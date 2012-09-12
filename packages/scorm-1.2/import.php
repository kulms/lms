<?php
//require ("../../include/global_login.php");
@set_time_limit(0);
//$_SESSION['done'] = 1;

require('../filemanager.inc.php'); 
require('../classes/pclzip.lib.php');


function chmodPackageDir ($path) {

	if (!is_dir($path)) return;
	else chmod ($path, 0755);

	$h = opendir($path);
	while ($f = readdir($h)) {
		if ($f == '.' || $f == '..') continue;
		$fpath = $path.'/'.$f;
		if (!is_dir($fpath)) {
   			chmod ($fpath, 0644);
		} else {
			chmodPackageDir ($fpath);
		}
	}
	closedir ($h);
}

$package_base_path = '';

$idx      = '';		// the current item's index, 1, 1.1, 1.2, 2, 2.1 ...
$idxs     = array();	// array containing the idx for all items
$orgid    = 0;		// index of current organization 1...
$depth    = 0;		// depth in organization tree
$itemid   = array();	
$files    = array();
$orgitems = array();
$idxs     = array();
$text;
$res;
$ress     = array();
$files    = array();
$finfo;
$totalsize = 0;

if (!isset($_POST['submit'])) {

	header('Location: ../index.php?courses=$p_courses');
	exit;
}

$ext = pathinfo($_FILES['file']['name']);
$ext = $ext['extension'];

if ($_FILES['file']['error'] == 1) {
	echo "File error";
	exit;
}

if (!$_FILES['file']['name'] || (!is_uploaded_file($_FILES['file']['tmp_name']))\|| ($ext != 'zip')) {
		echo "File name error";
		exit;
	}

	if ($_FILES['file']['size'] == 0) {
		echo "File size error";
		exit;
	}
	
			
	$package_path = '../files/sco/';
	//echo $package_path;
	
	if (!is_dir($package_path)) {
		if (!@mkdir($package_path, 0755)) {
			echo "PACKAGE_DIR_FAILED";
			exit;
		}
		chmod ($package_path, 0755);
	}

	$package_path .= $p_courses.'/';
	if (!is_dir($package_path)) {
		if (!@mkdir($package_path, 0755)) {
			echo "PACKAGE_DIR_COURSE_FAILED";
			exit;
		}
		chmod ($package_path, 0755);
	}

	$package_path .= 'tmp/';
	clr_dir($package_path);
	if (!is_dir($package_path)) {
		if (!@mkdir($package_path, 0755)) {
			echo "PACKAGE_DIR_TMP_FAILED";
			exit;
		}
		chmod ($package_path, 0755);
	}

	$archive = new PclZip($_FILES['file']['tmp_name']);
	if ($archive->extract (PCLZIP_OPT_PATH, $package_path) == 0) {
		clr_dir($package_path);
		exit;
	}
	chmodPackageDir ($package_path);
	

//echo $package_path;
parseManifest($package_path);
//echo "eeeee";
doValidation();
//echo "<br>here";
doImport($p_courses);


$orgs = array();
for ($i=1; $orgitems[$i]; $i++) {
	array_push ($orgs, $orgitems[$i]['title']);
}
$oc = sizeOf($orgs);
if ($oc == 1)  {
} else {
	$l = '';
	for ($i=0; $i<$oc; $i++) {
		$l .= '<li>' . $orgs[$i] . '</li>';
	}
}

header('Location: ./index.php?courses='.$course_id.'');
exit;


function parseManifest($import_path) {
	//global $msg;

	//$ims_manifest_xml = @file_get_contents($import_path.'imsmanifest.xml');
	/*
	if ($ims_manifest_xml === false) {
		echo "manifest error";
		clr_dir($import_path);
		exit;
	}
	*/

	$xml_parser = xml_parser_create();

	xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false);
	xml_set_element_handler($xml_parser, 'startElement', 'endElement');
	xml_set_character_data_handler($xml_parser, 'characterData');
	$fp  = fopen($import_path."imsmanifest.xml", "r");
	while($data = fread($fp, 8192))
	!xml_parse($xml_parser, $data, feof($fp));
	/*
	if (!xml_parse($xml_parser, $ims_manifest_xml, true)) {
		die(sprintf("XML error: %s at line %d",xml_error_string(xml_get_error_code($xml_parser)),xml_get_current_line_number($xml_parser)));
	}
	*/
	xml_parser_free($xml_parser);
}

function scormType ($i) {
	global $idxs, $orgitems, $res;
	$r = $res[$orgitems[$idxs[$i]]['identifierref']]['adlcp:scormtype'];
	if ($r) return $r;
	$o = explode ('.', $idxs[$i]);
	if (sizeOf($o) > 1) return 'cluster';
	return 'organization';  
}  

function doValidation () {
	//global $msg;
	global $orgitems;
	global $idxs;
	global $res;
	global $package_path;

	$ic = sizeOf ($idxs);

	$err  = 0;
	$warn = 0;

	for ($i=0; $i<$ic; $i++) {
		$title = addslashes($orgitems[$idxs[$i]]['title']);

		$href = $res[$orgitems[$idxs[$i]]['identifierref']]['href'];
		$styp = $res[$orgitems[$idxs[$i]]['identifierref']]['adlcp:scormtype'];
		$pre  = $orgitems[$idxs[$i]]['adlcp:prerequisites'];
		$max  = $orgitems[$idxs[$i]]['adlcp:maxtimeallowed'];
		$act  = $orgitems[$idxs[$i]]['adlcp:timelimitaction'];
		$lms  = $orgitems[$idxs[$i]]['adlcp:datafromlms'];
		$mas  = $orgitems[$idxs[$i]]['adlcp:masteryscore'];

		if ($idxs[$i].'.1' == $idxs[$i+1]) { // cluster
			if ($href != '' && ++$warn)

				echo 'SCORM_ITEM_CLUSTER_HAS_OBJECT';
		} else { 
			if ($styp == '' && ++$err)

				echo 'SCORM_ITEM_SCORMTYPE_MISSING';
			if ($href == '' && ++$err)

				echo 'SCORM_ITEM_HREF_MISSING';
		}

	}
	if ($err) {
		header('Location: ../index.php?courses=$p_courses');
		exit;
	}

}


function doImport ($courses) {
	global $db;
	//global $msg;
	global $orgitems;
	global $idxs;
	global $res;
	global $package_path;

	$now = date('Y-m-d H:i:s');
	$file = $_FILES['file']['name'];
	$sql = "INSERT INTO p_packages
	        VALUES (
			0,
			'$file',
			'$now',
			".$courses.",
			'scorm-1.2'
		)";
	//echo $sql;	

	$result = mysql_query($sql);
	if (!$result) {
		exit;
	} 

	$pkg = mysql_insert_id();
	rename ($package_path, dirname($package_path) . '/' . $pkg);

	$ic = sizeOf ($idxs);

	for ($i=0; $i<$ic; $i++) {
		$title = addslashes($orgitems[$idxs[$i]]['title']);
		$scormtype = scormType($i);

		switch ($scormtype) {
		case 'organization':
			$sql = "INSERT INTO p_scorm_1_2_org (
					package_id, title
				) VALUES ( $pkg, '$title')";
			//echo "<br>".$sql;

			$result = mysql_query($sql);
			if (!$result) {
				exit;
			}
			$orgid = mysql_insert_id();
			$sql = "INSERT INTO p_scorm_1_2_item
				VALUES (
					0,
					$orgid,
					'$idxs[$i]',
					'$title',
					'',
					'$scormtype',
					'', '', '', '', ''
				)";
			//echo "<br>".$sql;
			$result = mysql_query($sql);
			break;

		case 'sco':
			if (!$orgitems[$idxs[$i]]['adlcp:timelimitaction'])
				$orgitems[$idxs[$i]]['adlcp:timelimitaction'] =
			          	'continue, no message';
		case 'asset':
		case 'cluster':
			$href = $res[$orgitems[$idxs[$i]]['identifierref']]['href'];
			$pre  = $orgitems[$idxs[$i]]['adlcp:prerequisites'];
			$max  = $orgitems[$idxs[$i]]['adlcp:maxtimeallowed'];
			$act  = $orgitems[$idxs[$i]]['adlcp:timelimitaction'];
			$lms  = $orgitems[$idxs[$i]]['adlcp:datafromlms'];
			$mas  = $orgitems[$idxs[$i]]['adlcp:masteryscore'];
			$sql = "INSERT INTO p_scorm_1_2_item
				VALUES (
					0,
					$orgid,
					'$idxs[$i]',
					'$title',
					'$href',
					'$scormtype',
					'$pre',
					'$max', '$act', '$lms', '$mas'
				)";
			//echo "<br>".$sql;
			$result = mysql_query($sql);
			if (!$result) {
				exit;
			}
		}
	}
}


function startElement($parser, $name, $h) {

	global $orgid, $itemid,  $depth;
	global $orgitems, $idx, $idxs;
	global $res, $ress;
	global $files, $finfo, $totalsize;

	switch ($name) {
		case 'organization':
				$orgid++;
		case 'item':
				$itemid[$depth++]++;
				$idx = implode ('.', $itemid);
				array_push ($idxs, $idx);
				while (list($l, $r) = each($h)) {
					$orgitems[$idx][$l]=$r;
				}
				break;
		case 'title':
				break;

		case 'resource':
				array_push ($ress, $h['identifier']);
				while (list($l, $r) = each($h)) {
					$res[$h['identifier']][$l]=$r;
				}
				break;
		case 'dependency':
				break;
		case 'file':
				array_push ($files, $h['href']);
				$f='/home/httpd_course/html/lms/'
					.'import/'.$course_id
					.'/'.$h['href'];
				$finfo[$h['href']] = @stat($f);
				$totalsize +=  $finfo[$h['href']]['size'];
				break;
	}
}

function endElement($parser, $name) {
	global $orgid, $idx, $itemid, $depth, $text, $orgitems;

	switch ($name) {
		case 'organization':
				$depth=0;
				$itemid = array ($orgid);
				break;
		case 'item':	
				while ($itemid[$depth]) {
					array_pop($itemid);
				}
				$depth--;
				break;
		case 'title':
		case 'adlcp:datafromlms':
		case 'adlcp:maxtimeallowed':
		case 'adlcp:timelimitaction':
		case 'adlcp:prerequisites':
		case 'adlcp:masteryscore':
				$orgitems[$idx][$name] = trim($text);
				break;
		case 'resource':

	}
	$text = '';
}

function characterData($parser, $data){
	global $text;

	$text .= $data;
}

?>
