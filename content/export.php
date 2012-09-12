<?
error_reporting(E_ALL ^ E_NOTICE);  // Get rid of undefined variable messages

define(AT_INCLUDE_PATH,'include/');
include("config.inc.php");
include("global.inc.php");
include (AT_INCLUDE_PATH."variables.inc.php"); 
include(AT_INCLUDE_PATH.'mysql.inc.php');
require(AT_INCLUDE_PATH.'classes/zipfile.class.php');														/* for zipfile */
require(AT_INCLUDE_PATH.'classes/XML/XML_HTMLSax/XML_HTMLSax.php');	/* for XML_HTMLSax */
require(AT_INCLUDE_PATH.'ims/ims_template.inc.php');														/* for ims templates + print_organizations() */


/* get course information */
$sql="SELECT Code, School, CourseName, Creator, Description, Prerequisite, Objective, Manday, Reference, Enable, CreateOn, CourseType"
			." FROM $config[tablecourse] "
			." WHERE CID='$cid' ";
$result = db_select($sql);

list($code,$school,$course_title,$creator,$course_description,$prerequisite,$objective,$manday,$reference,$enable,$createon,$coursetype) = mysql_fetch_row($result);

$ims_course_title = str_replace(' ', '_', $course_title);
$full_course_title = $course_title;
$ims_course_description= htmlspecialchars($course_description);
$ims_course_description = str_replace("\r\n",':::', $ims_course_description);

/* generate the imsmanifest.xml header attributes */
/* 1 */
$imsmanifest_xml = str_replace(array('{COURSE_TITLE}','{COURSE_DESCRIPTION}'), array($ims_course_title,$ims_course_description), $ims_template_xml['header']);

$zipfile = new zipfile();  // export file

// html handler class
class MyHandler {
    function MyHandler(){}
    function openHandler(& $parser,$name,$attrs) {
		global $my_files;

		$elements = array(	'img'		=> 'src',
							'a'			=> 'href',
							'object'	=> 'data',
							'applet'	=> 'classid',
							'link'		=> 'href',
							'script'	=> 'src',
							'form'		=> 'action',
							'input'		=> 'src',
							'iframe'	=> 'src',
							'embed'	=> 'src',
							'param'		=> 'value');

		if (isset($elements[strtolower($name)])) { // set name to lower
				if ($attrs[$elements[strtolower($name)]] != '') { //lowercase attribute
					$my_files[] = $attrs[$elements[strtolower($name)]];
				}
				else if ($attrs[strtoupper($elements[strtolower($name)])] != ''){	//uppercase attribute
					$my_files[] = $attrs[strtoupper($elements[strtolower($name)])];
				}
		}
    }

    function closeHandler(& $parser,$name) { }
}

/* get all the content */
$content = array();
$paths	 = array();
$top_content_parent_id = 0;

$handler=new MyHandler();
$parser =& new XML_HTMLSax();
$parser->set_object($handler);
$parser->set_element_handler('openHandler','closeHandler');

// collect all informations to $content array
$sql="SELECT * FROM $config[tablelesson] WHERE CourseID='$cid' ORDER BY LessonParentID,Ordering";
$result = db_select($sql);

while ($row = mysql_fetch_assoc($result)) {
	$content[$row['LessonParentID']][] = $row;
	if ($lid == $row['LessonID']) {
		$top_content = $row;
		$top_content_parent_id = $row['LessonParentID'];
	}
}

// if export lesson
if ($lid) {
	
	/* filter out the top level sections that we don't want */
	$top_level = $content[$top_content_parent_id];

	foreach($top_level as $page) {
		if ($page['LessonID'] == $lid) {
			$content[$top_content_parent_id] = array($page);
		} else {
			/* this is a page we don't want, so might as well remove it's children too */
			unset($content[$page['LessonID']]);
		}
	}
	
	$ims_course_title .= '-'.str_replace(' ', '_', $content[$top_content_parent_id][0]['LessonTitle']);
	$full_course_title .= ': '.$content[$top_content_parent_id][0]['LessonTitle'];
}

/* get the first content page to default the body frame to */
$first = $content[$top_content_parent_id][0];

ob_start();

print_organizations($top_content_parent_id, $content, 0, '', array(), $toc_html);

$organizations_str = ob_get_contents();

ob_clean();

$toc_html = str_replace('{TOC}', $toc_html, $html_toc);

$frame = str_replace(	array('{COURSE_TITLE}',		'{FIRST_ID}'),
						array($ims_course_title, $first['LessonFile']),
						$html_frame);

$html_mainheader = str_replace('{COURSE_TITLE}', $full_course_title, $html_mainheader);
						

/* append the Organizations and Resources to the imsmanifest */
/* 2 */
$imsmanifest_xml .= str_replace(	array('{COURSE_TITLE}','{ORGANIZATIONS}',	'{RESOURCES}'),
									array($ims_course_title, $organizations_str, $resources),
									$ims_template_xml['final']);


/* export quiz */
/*3*/
$lessonids = array();
$quiztitles = array();
$sql = "SELECT LessonID,QuizTitle FROM $config[tablelesson] WHERE CourseID='$cid'";
$result = db_select($sql);
//echo $sql.'<P>';
if (empty($lid)) {
	while(list($lessonid,$quiztitle) = mysql_fetch_row($result)) {
		$lessonids[] = $lessonid;
		$quiztitles[] = $quiztitle;
	}
}
else {
	list($lessonid,$quiztitle) = mysql_fetch_row($result);
	$lessonids[] = $lid;
	$quiztitles[] = $quiztitle;
}

for ($i=0; $i<count($lessonids); $i++) {
	$sql="SELECT left(Question,3)+0 l, Question, Answer, ChoiceA, DescA, ChoiceB, DescB, ChoiceC, DescC, ChoiceD, DescD, ChoiceE, DescE, ChoiceF, DescF, Type FROM $config[tablequiz] WHERE LessonID='".$lessonids[$i]."' ORDER BY l";
	$result = db_select($sql);
	$quizs = array();
	while(list($_,$question,$answer,$ch_a,$desc_a,$ch_b,$desc_b,$ch_c,$desc_c,$ch_d,$desc_d,$ch_e,$desc_e,$ch_f,$desc_f,$type) = mysql_fetch_row($result)) {
		$quizs[] = "$question::$answer::$ch_a::$desc_a::$ch_b::$desc_b::$ch_c::$desc_c::$ch_d::$desc_d::$ch_e::$desc_e::$ch_f::$desc_f::$type";
	}
	
	$quiz = join('==',$quizs);
	
	$quiz=$quiztitles[$i].'@@@'.$quiz;

	$zipfile->add_file($quiz, 'quiz'.$lessonids[$i].'.txt');
}

/* zip the entire ims export directory and send to the user */
$zipfile->add_file($frame, 'index.html');
$zipfile->add_file($toc_html, 'toc.html');
$zipfile->add_file($imsmanifest_xml, 'imsmanifest.xml');
$zipfile->add_file($html_mainheader, 'header.html');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/ims.css'), 'ims.css');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/footer.html'), 'footer.html');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/logo.jpg'), 'logo.jpg');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/adlcp_v1p3.xsd'), 'adlcp_v1p3.xsd');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/adlnav_v1p3.xsd'), 'adlnav_v1p3.xsd');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/adlseq_v1p3.xsd'), 'adlseq_v1p3.xsd');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/imscp_v1p1.xsd'), 'imscp_v1p1.xsd');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/imsss_v1p0.xsd'), 'imsss_v1p0.xsd');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/imsss_v1p0auxresource.xsd'), 'imsss_v1p0auxresource.xsd');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/imsss_v1p0control.xsd'), 'imsss_v1p0control.xsd');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/imsss_v1p0delivery.xsd'), 'imsss_v1p0delivery.xsd');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/imsss_v1p0limit.xsd'), 'imsss_v1p0limit.xsd');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/imsss_v1p0objective.xsd'), 'imsss_v1p0objective.xsd');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/imsss_v1p0random.xsd'), 'imsss_v1p0random.xsd');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/imsss_v1p0rollup.xsd'), 'imsss_v1p0rollup.xsd');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/imsss_v1p0seqrule.xsd'), 'imsss_v1p0seqrule.xsd');
$zipfile->add_file(file_get_contents(AT_INCLUDE_PATH.'ims/imsss_v1p0util.xsd'), 'imsss_v1p0util.xsd');


/* create the archive */
header('Content-Type: application/octet-stream');
header('Content-transfer-encoding: binary'); 
if (!empty($lid)) {
	header('Content-Disposition: attachment; filename="lesson_'.escapeshellcmd($code).'_'.$lid.'.zip"');
}
else {
	header('Content-Disposition: attachment; filename="course_'.escapeshellcmd($code).'.zip"');
}
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');

echo $zipfile->file();

exit;
?>