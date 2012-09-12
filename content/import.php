<?
error_reporting(E_ALL ^ E_NOTICE);  // Get rid of undefined variable messages

define(AT_INCLUDE_PATH,'include/');
include("config.inc.php");
include("global.inc.php");
include (AT_INCLUDE_PATH."variables.inc.php"); 
include(AT_INCLUDE_PATH.'mysql.inc.php');					  /* database functions */
require(AT_INCLUDE_PATH.'lib/filemanager.inc.php'); /* for clr_dir() and preImportCallBack and dirsize() */
require(AT_INCLUDE_PATH.'classes/pclzip.lib.php');	  /* zip class */ 

/* get variables from import form */
if (empty($cid)) return;

if (empty($lid)) {
	// import course
	$lid=0;
	$order_offset=0;
	$parent_lid=0;
	
	// delete existing course
	$sql = "SELECT LessonID FROM $config[tablelesson] WHERE CourseID='$cid'";
	$result=db_query($sql);
	$rows = mysql_num_rows($result);
	if ($rows > 0 ) {
		$sql = "DELETE FROM $config[tablelesson]  WHERE CourseID='$cid'";	
		db_query($sql);
	}
}
else {
	// import lesson
	$parent_lid = db_getvar($config['tablelesson'],"LessonID='$lid'","LessonParentID");
	$order_offset = db_getvar($config['tablelesson'],"LessonID='$lid'","Ordering") - 1;

	// delete lesson 
	deleteLesson($cid,$lid);
}

/* check if ../content/import/ exists */
$import_path =$config['importcoursedir'].'/';
$content_path = $config['courseurl'].'/';

/* to avoid timing out on large files */
set_time_limit(0);

$package_base_path = '';

/* called at the start of en element */
/* builds the $path array which is the path from the root to the current element */
$item_tag = false;
function startElement($parser, $name, $attrs) {
	global $items, $path, $package_base_path;
	global $item_tag,$get_title,$get_description,$get_item_description,$get_item_duration;

	if (($name == 'item')) {
		if ($attrs['identifierref'] != '') {
			$path[] = $attrs['identifierref'];
		}
		else {
			$path[] = $attrs['identifier'];
		}
		$item_tag = true;
	}
	else if (($name == 'resource') && is_array($items[$attrs['identifier']]))  {
		$items[$attrs['identifier']]['href'] = $attrs['href'];

		$temp_path = pathinfo($attrs['href']);
		$temp_path = explode('/', $temp_path['dirname']);
		
		if ($package_base_path == '') {
			$package_base_path = $temp_path;
		}
		else {
			$package_base_path = array_intersect($package_base_path, $temp_path);
		}
		
		$items[$attrs['identifier']]['new_path'] = implode('/', $temp_path);
	}

	// get metadata
	if (($name == 'imsmd:title' || $name == 'title' ) && !$item_tag) {
		$get_title = true;
	}
	else if (($name == 'imsmd:description' || $name == 'description') && !$item_tag) {
		$get_description = true;
	}
	else if (($name == 'imsmd:description' || $name == 'description') && $item_tag) {
		$get_item_description = true;
	}
	else if (($name == 'imsmd:duration' || $name == 'duration') && $item_tag) {
		$get_item_duration = true;
	}
}

/* called when an element ends */
/* removed the current element from the $path */
function endElement($parser, $name) {
	global $path;
	global $item_tag,$get_title,$get_description,$get_item_description,$get_item_duration;

	if ($name == 'item') {
		array_pop($path);
		$item_tag = false;
	}
	else if ($name == 'imsmd:title' || $name == 'title') {
		$get_title=false;
	}
	else if (($name == 'imsmd:description' || $name == 'description') && !$item_tag) {
		$get_description=false;
	}
	else if (($name == 'imsmd:description' || $name == 'description') && $item_tag) {
		$get_item_description=false;
	}
	else if (($name == 'imsmd:duration' || $name == 'duration') && $item_tag) {
		$get_item_duration=false;
	}
}

/* called when there is character data within elements */
/* constructs the $items array using the last entry in $path as the parent element */
function characterData($parser, $data){
	global $path, $items, $order;
	global $course_name,$course_description;
	global  $item_tag,$get_title,$get_description,$get_item_description,$get_item_duration;

	$str_trimmed_data = trim($data);
			
	if (!empty($str_trimmed_data)) {
	
		if ($get_title && empty($course_name)) {
			$course_name=$str_trimmed_data;
			return;
		}

		if ($get_description && empty($course_description)) {
			$course_description.=$str_trimmed_data;
			return;
		}

		$size = count($path);
		if ($size > 0) {
			$current_item_id = $path[$size-1];
			if ($size > 1) {
				$parent_item_id = $path[$size-2];
			} 
			else {
				$parent_item_id = 0;
			}
			if (is_array($items[$current_item_id])) {
				/* this item already exists, append the title		*/
				/* this fixes {\n, \t, `, &} characters in elements */
				if (empty($items[$current_item_id]['description']) && $get_item_description) 
					$items[$current_item_id]['description'] = $data;
				else if (empty($items[$current_item_id]['duration']) && $get_item_duration) 
					$items[$current_item_id]['duration'] = $data;

			} else {
					$order[$parent_item_id] ++;
					$items[$current_item_id] = array('title'	=> $data,
												'parent_content_id' => $parent_item_id,
												'ordering'			=> $order[$parent_item_id]-1);
			}
		}
	}
}

$ext = pathinfo($_FILES['file']['name'] );
$ext = strtolower($ext['extension']);

if (  !$_FILES['file']['name'] || !is_uploaded_file($_FILES['file']['tmp_name']) || ($ext != 'zip') ||  ($_FILES['file']['size'] == 0) ) {
	echo 'File: "'.$_FILES['file']['name'].'" upload problem.';
	echo '<UL>Please change <B>php.ini</B><LI>upload_max_filesize = 50M<LI>memory_limit = 50M<LI>post_max_size = 50M</UL>';

	exit;
}
	
if (!is_dir($import_path)) {
	if (!@mkdir($import_path, 0700)) {
		echo 'Cannot make import directory.';
		exit;
	}
}

$import_path .= $cid.'/';

if (!is_dir($import_path)) {
	if (!@mkdir($import_path, 0700)) {
		echo 'Cannot make import for a course directory.';
		exit;
	}
}


/* extract the entire archive into ../../content/import/$course using the call back function to filter out php files */
$archive = new PclZip($_FILES['file']['tmp_name']);
if ($archive->extract(	PCLZIP_OPT_PATH,	$import_path,
						PCLZIP_CB_PRE_EXTRACT,	'preImportCallBack') == 0) {
	echo 'Cannot extract to $import_path';
	clr_dir($import_path);
	exit;
}

unlink($_FILES['file']['tmp_name']);

/* XML*/
$items = array(); /* all the content pages */
$order = array(); /* keeps track of the ordering for each content page */
$path  = array();  /* the hierarchy path taken in the menu to get to the current item in the manifest */



$ims_manifest_xml = @file_get_contents($import_path.'imsmanifest.xml');

$xml_parser = xml_parser_create();

xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false); /* conform to W3C specs */
xml_set_element_handler($xml_parser, 'startElement', 'endElement');
xml_set_character_data_handler($xml_parser, 'characterData');

if (!xml_parse($xml_parser, $ims_manifest_xml, true)) {
	die(sprintf("XML error: %s at line %d",
				xml_error_string(xml_get_error_code($xml_parser)),
				xml_get_current_line_number($xml_parser)));
}

xml_parser_free($xml_parser);
	
/* generate a unique new package base path based on the package file name and date as needed. */
/* the package name will be the dir where the content for this package will be put, as a result */
/* the 'content_path' field in the content table will be set to this path. */

$package_base_path = implode('/', $package_base_path);

//$order_offset=0;

// update course name
$course_name = str_replace('_',' ',$course_name);
$course_name = addslashes($course_name);
$course_description = addslashes($course_description);
$course_description = str_replace(':::',"\r\n",$course_description);

if (empty($lid)) {
	$sql = "UPDATE $config[tablecourse] SET CourseName='$course_name',  Description='$course_description' WHERE CID='$cid'";
	db_query($sql);
}

/* get the top level content ordering offset */
//$sql	= "SELECT MAX(Ordering) AS ordering FROM $config[tablelesson] WHERE CourseID=$cid AND LessonParentID=$parent_lid";
//echo $sql;
//exit;
//$result=db_query($sql);
//$row	= mysql_fetch_assoc($result);
//$order_offset = intval($row['ordering']); /* it's nice to have a real number to deal with */

$new_paths=array();

foreach ($items as $item_id => $content_info) {
		$content_parent_id = $parent_lid;
		if ($content_info['parent_content_id'] !== 0) {
			$content_parent_id = $items[$content_info['parent_content_id']]['real_content_id'];
		}

		$my_offset = 0;
		if ($content_parent_id == $parent_lid) {
			$my_offset = $order_offset;
		}
		
		/* replace the old path greatest common denomiator with the new package path. */
		/* we don't use str_replace, b/c there's no knowing what the paths may be	  */
		/* we only want to replace the first part of the path.						  */

		if (!in_array($content_info['new_path'],$new_paths)) {
			$new_paths[] = $content_info['new_path'];
		}

		$filesco = str_replace('resources/','',$content_info['href']);
		$description = str_replace(':::',"\r\n",$content_info['description']);
		$description = addslashes($description);
		$title = addslashes($content_info['title']);

		list($_,$d) = explode('P',$content_info['duration']);
		list($duration,$_) = explode('D',$d);

		$ordering = $content_info['ordering'] + $my_offset +1;

		$nextid = db_getvar($config['tablelesson'],"1","MAX(LessonID)+1");
		
		$sql = "INSERT INTO $config[tablelesson] VALUES ('$nextid','$cid','$title','$description','$filesco','$duration','$quiz_title','$content_parent_id','$ordering')";	
//		echo $sql;
//		exit;
		db_query($sql);

		/* get the content id and update $items */
		$items[$item_id]['real_content_id'] = $nextid;

		// insert quiz
		$item_idtemp=str_replace('MANIFEST01_RESOURCE','',$item_id);
		$quiz_data = @file_get_contents($import_path.'quiz'.$item_idtemp.'.txt');	
		list($quiz_title,$quiz_data) = explode('@@@',$quiz_data);
		
		// delete quiz table
		$nlid = db_getvar($config['tablelesson'],"LessonID is not null","max(LessonID)");
		$sql = "DELETE FROM $config[tablequiz] WHERE LessonID='$nlid' ";
		db_query($sql);

		$question = explode('==',$quiz_data);
		
		for ($i=0; $i<count($question); $i++) {
			list($questions,$answer,$ch_a,$desc_a,$ch_b,$desc_b,$ch_c,$desc_c,$ch_d,$desc_d,$ch_e,$desc_e,$ch_f,$desc_f,$type) = explode('::',$question[$i]);
			$questions = addslashes($questions);
			$ch_a = addslashes($ch_a);
			$desc_a = addslashes($desc_a);
			$ch_b = addslashes($ch_b);
			$desc_b = addslashes($desc_b);
			$ch_c = addslashes($ch_c);
			$desc_c = addslashes($desc_c);
			$ch_d = addslashes($ch_d);
			$desc_d = addslashes($desc_d);
			$ch_e = addslashes($ch_e);
			$desc_e = addslashes($desc_e);
			$ch_f = addslashes($ch_f);
			$desc_f = addslashes($desc_f);
			if (!empty($questions)) {
				$sql = "INSERT INTO $config[tablequiz] (QuizID, LessonID, Question, Answer, ChoiceA, DescA, ChoiceB, DescB, ChoiceC, DescC, ChoiceD, DescD, ChoiceE, DescE, ChoiceF, DescF, Type) VALUES (NULL, '$nlid', '$questions', '$answer', '$ch_a', '$desc_a', '$ch_b', '$desc_b', '$ch_c', '$desc_c', '$ch_d', '$desc_d', '$ch_e', '$desc_e', '$ch_f', '$desc_f', '$type')";
			}
			db_query($sql);
		}
}

foreach ($new_paths as $source) {
	if ($source == '.') {
		$source = $import_path;
	}
	else {
		$source = $import_path.$source;
	}
	$dest = $content_path. $cid;
	copys($source,$dest);
	clr_dir($import_path);
	convertSpecialTags($dest);
}

if (empty($lid)) {
	header("Location:index.php?action=editlesson&courseid=$cid");
	exit;
}
else {
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		window.close();
	//-->
	</SCRIPT>
<?
}

function convertSpecialTags($dir) {
		$d = dir($dir);
		for($i=0;$entry=$d->read();$i++) {
			if (strpos($entry,".html")) {
				$html = @file_get_contents($dir.'/'.$entry);

		//- - Break Page
				$html =  str_replace('<!--BREAK-->','{PAGE}',$html);
			
		//- - PDF format.. {PDF}file.pdf{/PDF}
				$pdfObjBegin="<OBJECT id='Acrobat Control for ActiveX' height=550 width=100% border=1 classid=CLSID:CA8A9780-280D-11CF-A24D-444553540000><PARAM NAME='_Version' VALUE='327680'><PARAM NAME='_ExtentX' VALUE='18812'><PARAM NAME='_ExtentY' VALUE='14552'><PARAM NAME='_StockProps' VALUE='0'><PARAM NAME='SRC' VALUE=\"";
				$pdfObjEnd="\"></OBJECT>";
				$html =  str_replace($pdfObjBegin,'{PDF}',$html);
				$html =  str_replace($pdfObjEnd,'{/PDF}',$html);
/*
// - - WMV - live
				$wmvObjBegin="<object id=MediaPlayer type=application/x-oleobject height=252 width=320 classid=CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6><param name=\"URL\" value=\"";
				$wmvObjEnd='"><param name="AutoStart" value="true"><param name="ShowControls" value="false"><param name="ShowStatusBar" value="true"><param name="AutoSize" value="ture"><param name="uiMode" value="mini"></object>';
				$html =  str_replace($pdfObjBegin,'{WML}',$html);
				$html =  str_replace($pdfObjEnd,'{/WML}',$html);
//- -  WMV
				$wmvObjBegin="<object id=MediaPlayer type=application/x-oleobject height=252 width=320 classid=CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6><param name=\"URL\" value=\"".$config['courseurl'].'/'.$courseid.'/';
				$wmvObjEnd='"><param name="AutoStart" value="true"><param name="ShowControls" value="false"><param name="ShowStatusBar" value="true"><param name="AutoSize" value="ture"><param name="uiMode" value="mini"></object>';
				$html =  str_replace($pdfObjBegin,'{WMV}',$html);
				$html =  str_replace($pdfObjEnd,'{/WMV}',$html);


	//- - Flash {SWF}file.swff{/SWF}
				$swfObjBegin1="<OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0'  id='Lesson'> <PARAM NAME=movie VALUE=\"";
				$swfObjBegin2="> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#FFFFFF> <EMBED src=\"";
				$swfObjEnd=" quality=high bgcolor=#FFFFFF  NAME='Lesson' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/go/getflashplayer'></EMBED>";
				$html =  str_replace($swfObjBegin1,'{SWF}',$html);
				$html =  str_replace($swfObjBegin2,'',$html);
				$html =  str_replace($swfObjEnd,'{/SWF}',$html);
*/
				$fp=fopen($dir.'/'.$entry,"w");
				fwrite($fp,$html);
				fclose($fp);
			}
		}
}

function deleteLesson($cid,$lid) {
	global $config;

	$sql = "SELECT LessonID FROM $config[tablelesson] WHERE CourseID='$cid' AND LessonParentID='$lid'";
	$result=db_select($sql);

	while (list($child_lid) = mysql_fetch_row($result)) {
		deleteLesson($cid,$child_lid);
	}
	$sql = "DELETE FROM $config[tablelesson]  WHERE LessonID='$lid'";	
	db_query($sql);
}

?>