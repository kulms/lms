<?php
// $Id: editor.php,v 1.4 2003/09/26 08:51:51 rcastley Exp $
/**
* Editor handler
* @package Mambo Open Source
* @Copyright (C) 2000 - 2003 Miro International Pty Ltd
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.4 $
**/

defined( '_VALID_EEL' ) or die( 'Direct Access to this location is not allowed.' );

$Config_editor = strtolower( @$config['editor'] );

if (file_exists( "editor/editor.$Config_editor.php" )) {
	require_once( "editor/editor.$Config_editor.php" );
}
else {
	require_once( "editor/editor.htmlarea2.php" );
}

if ($subaction == "save") {
	if (file_exists($filename)) {
		/*
		$root = $_SERVER['PHP_SELF']; 
		$root = str_replace("/index.php","",$root);
		$htmlareatext = str_replace($root,"",$htmlareatext);
		$htmlareatext = str_replace('/'.$htmldir.'/',"",$htmlareatext);
		*/
		$htmlareatext = stripslashes($htmlareatext);
		$root = $_SERVER['PHP_SELF']; 
		$root = str_replace("/t_index.php","",$root);  //nuankae

		$handler=new MyHandler();
		$parser =& new XML_HTMLSax();
		$parser->set_object($handler);
		$parser->set_element_handler('openHandler','closeHandler');
		$parser->parse($htmlareatext);

		$files=array();
		$my_files = @array_unique($my_files);
		$icons=array('html_small.gif','gif_small.gif','doc_small.gif','gz_small.gif','jpg_small.gif','mov_small.gif','pdf_small.gif','png_small.gif','ppt_small.gif','rar_small.gif','txt_small.gif','zip_small.gif','def_small.gif','xls_small.gif');
		if (!empty($my_files[0])) {
			foreach ($my_files as $file) {
				/* filter out full urls */
				$url_parts = @parse_url($file);
				if (isset($url_parts['scheme'])) {
					continue;
				}

				foreach ($icons as $icon) {
					if (eregi($icon,$url_parts['path'])) {
						$htmlareatext = str_replace('/editor/htmlarea3_xtd/popups/InsertFile/images/ext/'.$icon,'editor/htmlarea3_xtd/popups/InsertFile/images/ext/'.$icon,$htmlareatext);
						continue;
					}
				}

				$htmlareatext = str_replace($root,"",$htmlareatext);
				$htmlareatext = str_replace('/'.$htmldir.'/',"",$htmlareatext);
			}
		}
		
		$my_files =  array();
		$path = '';

		$fp=fopen($filename,"w");
		fwrite($fp,$htmlareatext);
		fclose($fp);
?>
		<SCRIPT LANGUAGE="JavaScript">
		<!--
			if (window.opener != null) { 
				//top.ws_menu.location.reload();
				
				self.close();
				opener.window.location.reload(); 
			}
		//-->
		</SCRIPT>
<?
	}
}


/**
* show content and editor
*/
function showEditorContent($action,$filename,$htmldir,$imgdir) {
	global $config,$lang,$usersess;
	global $subaction;

//$config['uploadurl'].'/'.
	$htmlareatext = showContent($filename,$htmldir);  //showContent  in lesson.inc.php
	
	if ($subaction == "editor") {
		if ($action=='editcontent') {

?>
			<html>
			<head>
			<title>Edit Content</title>
			<body TOPMARGIN="0" LEFTMARGIN="0" MARGINHEIGHT="0" MARGINWIDTH="0" bgcolor="#DDDDDD">
			<FORM action="t_index.php" method="POST" name="textForm">
			<INPUT TYPE="hidden" name="action" VALUE="<?=$action?>">
			<INPUT TYPE="hidden" name="subaction" VALUE="save">
			<INPUT TYPE="hidden" name="filename" VALUE="<?=$filename?>">
			<INPUT TYPE="hidden" name="htmldir" VALUE="<?=$htmldir?>">
			<TABLE width="100%" cellpadding="0" cellspacing="1" bgcolor="#EEEEEE">
			<TR>
				<TD>
				<?
					editorArea( 'editor1',  $htmlareatext , 'htmlareatext', '100%', '465', '60', '5' ) ;
				?>
			</TR>
			<TR>
			<TD ALIGN="CENTER" BGCOLOR="#DDDDDD">
					<INPUT TYPE="submit" VALUE="Save"> <INPUT TYPE="button" VALUE="Close" Onclick="window.close()">
			</TD>
			</TR>
			</TABLE>
			</FORM>
<?
		

		}
		else {
?>
			<FORM action="t_index.php" method="POST" name="textForm">
			<INPUT TYPE="hidden" name="action" VALUE="<?=$action?>">
			<INPUT TYPE="hidden" name="subaction" VALUE="save">
			<INPUT TYPE="hidden" name="filename" VALUE="<?=$filename?>">
			<INPUT TYPE="hidden" name="htmldir" VALUE="<?=$htmldir?>">
			<TABLE width="100%" cellpadding="0" cellspacing="1" bgcolor="#EEEEEE">
			<TR>
				<TD>
				<?
					editorArea( 'editor1',  $htmlareatext , 'htmlareatext', '615', '300', '60', '5' ) ;
				?>
			</TR>
			<TR>
			<TD ALIGN="CENTER" BGCOLOR="#DDDDDD">
					<INPUT TYPE="submit" VALUE="Save"> <INPUT TYPE="button" VALUE="Cancel" Onclick="javascript:window.open('t_index.php?action=<?=$action?>','_self')">
			</TD>
			</TR>
			</TABLE>
			</FORM>
<?
		}
	}
	else {
		if ($usersess->get_var("admin")) {
			echo "<DIV ALIGN=RIGHT><A class=f  HREF=\"t_index.php?action=$action&subaction=editor&filename=$filename&dir=$htmldir&imgdir=$imgdir\"><img src=images/editdoc.gif border=0><BR>Edit?</A>&nbsp;</DIV>";
		}
		
		echo '<TABLE WIDTH="615" BORDER="0" CELLSPACING=0 CELLPADDING=0>';

		if (file_exists('theme/'.$config['theme'].'/title/'.$config['language'].'/'.$action.'.jpg')) {
			echo '<TR><TD align="left" valign="top">';
			echo '<img src="theme/'.$config['theme'].'/title/'.$config['language'].'/'.$action.'.jpg" border="0"></td></tr><tr height="1"><td valign="middle" align="center" background="images/line2.gif"></TD></TR>';
		}

		echo '<TR><TD>';
		echo $htmlareatext;
		echo '</TD></TR></TABLE>';
	}

}
?>