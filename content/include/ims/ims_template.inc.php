<?php
/****************************************************************/
/* ATutor														*/
/****************************************************************/
/* Copyright (c) 2002-2003 by Greg Gay & Joel Kronenberg        */
/* Adaptive Technology Resource Centre / University of Toronto  */
/* http://atutor.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/
if (!defined('AT_INCLUDE_PATH')) { exit; }

function print_organizations($parent_id,
							 &$_menu, 
							 $depth, 
							 $path='',
							 $children,
							 &$string) {
	
	global $html_template, $zipfile, $resources, $ims_template_xml, $parser, $my_files,$config;
	static $paths, $zipped_files;

	$space  = '    ';
	$prefix = '                    ';

	if ($depth == 0) {
		$string .= '<ul>';
	}

	$top_level = $_menu[$parent_id];
	
	if (!is_array($paths)) {
		$paths = array();
	}
	if (!is_array($zipped_files)) {
		$zipped_files = array();
	}

	$content_path = 'resources/';

	if ( is_array($top_level) ) {
		$counter = 1;
		$num_items = count($top_level);
		foreach ($top_level as $garbage => $content) {

			$link = '';
			if (is_array($temp_path)) {
				$this = current($temp_path);
			}
//			if ($content['content_path']) {
//				$content['content_path'] .= '/';
//			}

			$link = $prevfix.'<item identifier="MANIFEST01_ITEM'.$content['LessonID'].'" identifierref="MANIFEST01_RESOURCE'.$content['LessonID'].'" parameters="">'."\n";

			$html_link = '<a href="'.$content_path.$content['LessonFile'].'" target="body">'.$content['LessonTitle'].'</a>';

			/* save the content as HTML files */
			/* @See: include/lib/format_content.inc.php */
			$content['text']=file_get_contents('courses/'.$content['CourseID'].'/'.$content['LessonFile']);

			$content['text'] =  str_replace('{PAGE}','<!--BREAK-->',$content['text']);
		
	//- - PDF format.. {PDF}file.pdf{/PDF}

			$pdfObjBegin="<OBJECT id='Acrobat Control for ActiveX' height=550 width=100% border=1 classid=CLSID:CA8A9780-280D-11CF-A24D-444553540000><PARAM NAME='_Version' VALUE='327680'><PARAM NAME='_ExtentX' VALUE='18812'><PARAM NAME='_ExtentY' VALUE='14552'><PARAM NAME='_StockProps' VALUE='0'><PARAM NAME='SRC' VALUE=\"";
			$pdfObjEnd="></OBJECT>";
			$content['text'] = preg_replace("/{pdf}(.*?){\/pdf}/si", "$pdfObjBegin\\1\"$pdfObjEnd", $content['text']) ;
			$content['text'] = preg_replace("/{PDF}(.*?){\/PDF}/si", "$pdfObjBegin\\1\"$pdfObjEnd", $content['text']) ;

//- - Flash {SWF}file.swff{/SWF}
			$swfObjBegin1="<OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0'  id='Lesson'> <PARAM NAME=movie VALUE=\"";
			$swfObjBegin2="> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#FFFFFF> <EMBED src=\"";
			$swfObjEnd=" quality=high bgcolor=#FFFFFF  NAME='Lesson' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/go/getflashplayer'></EMBED>";
			$content['text'] = preg_replace("/{swf}(.*?){\/swf}/si", "$swfObjBegin1\\1\"$swfObjBegin2\\1\"$swfObjEnd",  $content['text']) ;
			$content['text'] = preg_replace("/{SWF}(.*?){\/SWF}/si", "$swfObjBegin1\\1\"$swfObjBegin2\\1\"$swfObjEnd",  $content['text']);

// - - WMV - live
			$wmvObjBegin="<object id=MediaPlayer type=application/x-oleobject height=252 width=320 classid=CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6><param name=\"URL\" value=\"";
			$wmvObjEnd='><param name="AutoStart" value="true"><param name="ShowControls" value="false"><param name="ShowStatusBar" value="true"><param name="AutoSize" value="ture"><param name="uiMode" value="mini"></object>';
			$content['text'] = preg_replace("/{wml}(.*?){\/wml}/si", "$wmvObjBegin\\1\"$wmvObjEnd", $content['text']) ;
			$content['text'] = preg_replace("/{WML}(.*?){\/WML}/si", "$wmvObjBegin\\1\"$wmvObjEnd", $content['text']) ;
//- -  WMV
			$wmvObjBegin="<object id=MediaPlayer type=application/x-oleobject height=252 width=320 classid=CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6><param name=\"URL\" value=\"".$config['courseurl'].'/'.$courseid.'/';
			$wmvObjEnd='><param name="AutoStart" value="true"><param name="ShowControls" value="false"><param name="ShowStatusBar" value="true"><param name="AutoSize" value="ture"><param name="uiMode" value="mini"></object>';
			$content['text'] = preg_replace("/{wmv}(.*?){\/wmv}/si", "$wmvObjBegin\\1\"$wmvObjEnd", $content['text']) ;
			$content['text'] = preg_replace("/{WMV}(.*?){\/WMV}/si", "$wmvObjBegin\\1\"$wmvObjEnd", $content['text']) ;

//			$content['text'] = str_replace('CONTENT_DIR/', '', $content['text']);
//			$content['text'] = format_content($content['text'], $content['formatting'], false);

			/* add HTML header and footers to the files */
			$content['text'] = str_replace(	array('{TITLE}',	'{CONTENT}', '{KEYWORDS}'),
									array($content['LessonTitle'],	$content['text'], $content['keywords']),
									$html_template);		

			$zipfile->add_file($content['text'], $content_path.$content['LessonFile'], time());
			$content['LessonTitle'] = $content['LessonTitle'];

			/* add the resource dependancies */
			$my_files = array();
			$content_files = "\n";
			$parser->parse($content['text']);

			$files=array();

			foreach ($my_files as $file) {
				/* filter out full urls */
				$url_parts = @parse_url($file);
				if (isset($url_parts['scheme'])) {
					continue;
				}

				/* file should be relative to content. let's double check */
				if ((substr($file, 0, 1) == '/') && ( strpos($file, '..') !== false) ) {
					continue;
				}

//				$file_path =  $config['courseurl'].'/' . $parent_id. '/' . $file;
					$file_path = $config['courseurl'].'/' .$content['CourseID'] . '/' . $file;
		

				/* check if this file exists in the content dir, if not don't include it */
				if (file_exists($file_path) && 	!in_array($file_path, $zipped_files)) {
					$zipped_files[] = $file_path;

					$dir = dirname($file).'/';
					
					if (!in_array($dir, $paths)) {
						$zipfile->priv_add_dir($content_path.$dir, time());
						$paths[] = $dir;
					}

					$file_info = stat( $file_path );
//					$zipfile->add_file(file_get_contents($file_path), 'resources/' . $content['content_path'] . $file, $file_info['mtime']);
					$zipfile->add_file(file_get_contents($file_path), $content_path.$file, $file_info['mtime']);
				}		
				
				if (file_exists($file_path) && 	!in_array($file_path, $files)) {
					$files[] = $file_path;
					$content_files .= str_replace('{FILE}',  $file, $ims_template_xml['file']);
				}	
			
			}

			/******************************/
			$resources .= str_replace(	array('{LESSON_ID}', '{LESSON_FILE}', '{FILES}'),
										array($content['LessonID'], $content['LessonFile'], $content_files),
										$ims_template_xml['resource']);

			for ($i=0; $i<$depth; $i++) {
				$link .= $space;
			}

			$lessontitle = str_replace("\r\n",':::',$content['LessonTitle']);
			$title = $prefix.$space.'<title>'.$lessontitle.'</title>';

			$abstract = str_replace("\r\n",':::',$content['Abstract']);
			$metadata = '<metadata>
          <imsmd:lom xmlns:imsmd="http://www.imsglobal.org/xsd/imsmd_v1p2">
            <imsmd:general>
               <imsmd:description>
                <imsmd:langstring>'.$abstract.'</imsmd:langstring>
              </imsmd:description>
            </imsmd:general>
            <imsmd:technical>
              <imsmd:duration>
                <imsmd:datetime>P'.$content['Length'].'D</imsmd:datetime>
              </imsmd:duration>
            </imsmd:technical>
          </imsmd:lom>
        </metadata>';


		if ( is_array($_menu[$content['LessonID']]) ) {
				/* has children */

				$html_link = '<li>'.$html_link.'<ul>';
				for ($i=0; $i<$depth; $i++) {
					if ($children[$i] == 1) {
						echo $space;
						//$html_link = $space.$html_link;
					} else {
						echo $space;
						//$html_link = $space.$html_link;
					}
				}

			} else {
				/* doesn't have children */
				$html_link = '<li>'.$html_link.'</li>';
				if ($counter == $num_items) {
					for ($i=0; $i<$depth; $i++) {
						if ($children[$i] == 1) {
							echo $space;
							//$html_link = $space.$html_link;
						} else {
							echo $space;
							//$html_link = $space.$html_link;
						}
					}
				} else {
					for ($i=0; $i<$depth; $i++) {
						echo $space;
						//$html_link = $space.$html_link;
					}
				}
				$title = $space.$title;
			}

			echo $prefix.$link;
			echo $title;
			echo "\n";
			echo $metadata;
			echo "\n";

			$string .= $html_link."\n";

			$depth ++;
			print_organizations($content['LessonID'],
								$_menu, 
								$depth, 
								$path.$counter.'.', 
								$children,
								$string);
			$depth--;

			$counter++;
			for ($i=0; $i<$depth; $i++) {
				echo $space;
			}
			echo $prefix.'</item>';
			echo "\n";
		}
		$string .= '</ul>';
		if ($depth > 0) {
			$string .= '</li>';
		}

	}
}

$ims_template_xml['header'] = '<?xml version="1.0" encoding="tis-620"  standalone="no" ?>
	<manifest identifier="CONTENT-MANIFEST" version="1.3"
    xmlns="http://www.imsglobal.org/xsd/imscp_v1p1"
    xmlns:adlcp="http://www.adlnet.org/xsd/adlcp_v1p3"
    xmlns:imsss="http://www.imsglobal.org/xsd/imsss"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.imsglobal.org/xsd/imscp_v1p1 imscp_v1p1.xsd
                        http://www.adlnet.org/xsd/adlcp_v1p3 adlcp_v1p3.xsd
                        http://www.imsglobal.org/xsd/imsss imsss_v1p0.xsd"  >
   <metadata>
      <schema>ADL SCORM</schema>
      <schemaversion>1.3</schemaversion>
	  <imsmd:lom xmlns:imsmd="http://www.imsglobal.org/xsd/imsmd_v1p2">
		  <imsmd:educational>
			<imsmd:learningresourcetype>
			  <imsmd:source>
				<imsmd:langstring xml:lang="x-none">Learning Nuke</imsmd:langstring>
			  </imsmd:source>
			  <imsmd:value>
				<imsmd:langstring xml:lang="x-none">Content Module</imsmd:langstring>
			  </imsmd:value>
			</imsmd:learningresourcetype>
		  </imsmd:educational>
		  <imsmd:lifecycle>
		  </imsmd:lifecycle>
		  <imsmd:general>
			<imsmd:title>
			  <imsmd:langstring>{COURSE_TITLE}</imsmd:langstring>
			</imsmd:title>
			<imsmd:description>
				<imsmd:langstring>{COURSE_DESCRIPTION}</imsmd:langstring>
			</imsmd:description>
		  </imsmd:general>
		  <imsmd:rights>
		  </imsmd:rights>
		</imsmd:lom>
   </metadata>    
';

$ims_template_xml['resource'] = '		<resource identifier="MANIFEST01_RESOURCE{LESSON_ID}" type="webcontent" href="resources/{LESSON_FILE}"  adlcp:scormType="asset">
			<metadata/>
			{FILES}
		</resource>'."\n";

$ims_template_xml['file'] = '			<file href="resources/{FILE}"/>'."\n";

$ims_template_xml['final'] = '
	<organizations default="MANIFEST01_ORG1">
		<organization identifier="MANIFEST01_ORG1" structure="hierarchical">
			<title>{COURSE_TITLE}</title>
{ORGANIZATIONS}
		</organization>
	</organizations>
	<resources>
{RESOURCES}
	</resources>
</manifest>';

$html_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=tis-620" />
	<style type="text/css">
	body { font-family: Verdana, Arial, Helvetica, sans-serif;}
	</style>
	<title>{TITLE}</title>
	<meta name="Generator" content="ATutor'.VERSION.'">
	<meta name="Keywords" content="{KEYWORDS}">
</head>
<body>{CONTENT}</body>
</html>';



//output this as header.html
$html_mainheader = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=tis-620" />
	<link rel="stylesheet" type="text/css" href="ims.css"/>
	<title></title>
</head>
<body class="headerbody"><h3>{COURSE_TITLE}</h3></body></html>';


$html_toc = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=tis-620" />
	<link rel="stylesheet" type="text/css" href="ims.css" />
	<title></title>
</head>
<body>{TOC}</body></html>';

$html_frame = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
	<title>{COURSE_TITLE}</title>
</head>
<frameset rows="50,*,50">
<frame src="header.html" name="header" title="header" scrolling="no">
	<frameset cols="25%, *" frameborder="1" framespacing="3">
		<frame frameborder="2" marginwidth="0" marginheight="0" src="toc.html" name="frame" title="TOC">
		<frame frameborder="2" src="resources/{FIRST_ID}" name="body" title="{COURSE_TITLE}">
	</frameset>
<frame src="footer.html" name="footer" title="footer" scrolling="no">
	<noframes>
      <p><br />
	  </p>
  </noframes>
</frameset>
</html>';

?>