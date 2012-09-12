<?php
// $Id: editor.htmlarea3_xtd.php, v 1.0 2004/04/19 16:23:28 bpfeifer Exp $
/**
* Advanced Handler for HTMLAarea3 Extended
* @package Mambo Open Source
* @Copyright © 2004 Bernhard Pfeifer aka novocaine
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.0 $
**/

defined( '_VALID_EEL' ) or die( 'Direct access to this location is not allowed!' );

function initEditor() {
	global $config;
	
	$mosConfig_live_site=$config['homeurl'];

?>
<script type="text/javascript"> 
<!--
	_editor_url = "<?php echo $mosConfig_live_site;?>/editor/htmlarea3_xtd/";
	_editor_lang = "en";
//-->
</script>
<script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/editor/htmlarea3_xtd/htmlarea_xtd.js"></script>
<script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/editor/htmlarea3_xtd/dialog.js"></script>
<script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/editor/htmlarea3_xtd/lang/en.js"></script>
<style type="text/css">@import url(<?php echo $mosConfig_live_site;?>/editor/htmlarea3_xtd/htmlarea.css)</style>
<script type="text/javascript"> 
<!--
	// load the plugin files
	HTMLArea.loadPlugin("TableOperations");
	HTMLArea.loadPlugin("EnterParagraphs");
	HTMLArea.loadPlugin("ContextMenu");
//	HTMLArea.loadPlugin("CSS");
	var editor = null;
//-->
</script>
<?php
}

function editorArea( $name, $content, $hiddenField, $width, $height, $col, $row ) {
	global $config,$imgdir,$dir;
?>
<textarea name="<?php echo $hiddenField; ?>" id="<?php echo $hiddenField; ?>" cols="<?php echo $col; ?>" rows="<?php echo $row; ?>" style="width:<?php echo $width; ?>; height:<?php echo $height; ?>"><?php echo $content; ?></textarea>
<script language="JavaScript1.2" defer="defer">
<!--

	//
	var imgdir='<?=$imgdir?>';
	var datadir='<?=$dir?>';

	// create the editor 
	var editor<?php echo $name ?> = new HTMLArea("<?php echo $hiddenField ?>"); 

	// retrieve the config object 
	var config<?php echo $name ?> = editor<?php echo $name ?>.config;

config<?php echo $name ?>.sizeIncludesToolbar = false;
//config<?php echo $name ?>.height = "300px";
//config<?php echo $name ?>.width = "610px";
config<?php echo $name ?>.registerButton({
  id        : "mosimage",
  tooltip   : "Insert {egatlogo} tag",
  image     : _editor_url + "images/ed_mos_image.gif",
  textMode  : false,
  action    : function(editor<?php echo $name ?>, id) {
				editor<?php echo $name ?>.focusEditor(); 
                editor<?php echo $name ?>.insertHTML('{EGATLOGO}');
              }
});

config<?php echo $name ?>.registerButton({
  id        : "mospagebreak",
  tooltip   : "Insert {pagebreak} tag",
  image     : _editor_url + "images/ed_mos_pagebreak.gif",
  textMode  : false,
  action    : function(editor<?php echo $name ?>, id) {
				editor<?php echo $name ?>.focusEditor(); 
                editor<?php echo $name ?>.insertHTML('{PAGE}');
              }
});

config<?php echo $name ?>.toolbar = [
[ "fontname", "space",
  "fontsize", "space",
  "formatblock", "space",
  "bold", "italic", "underline", "separator",
  "strikethrough", "subscript", "superscript", "separator",
  "createlink", "mosimage", "mospagebreak", "separator", "htmlmode", "separator", "showhelp" ],
		
[ "justifyleft", "justifycenter", "justifyright", "justifyfull", "separator",
  "insertorderedlist", "insertunorderedlist", "outdent", "indent", "separator",
  "forecolor", "hilitecolor", "space", "textindicator", "space", "removeformat", "space"

, "inserthorizontalrule", "insertcharacter", "insertimage", "insertfile", "separator",
  "inserttable", "toggleborders", "separator", "cut", "copy", "paste", "separator",
  "killword", "separator", "popupeditor" ],
];

	editor<?php echo $name ?>.registerPlugin(TableOperations);
	editor<?php echo $name ?>.registerPlugin(EnterParagraphs);
	editor<?php echo $name ?>.registerPlugin(ContextMenu);
//	editor<?php echo $name ?>.registerPlugin(CSS, { 
//		combos : [ { label: "CSS Styles:",
			// 6 standard Mambo CSS template classes contained
			// add your own CSS classes like this (but leave [None selected] for removal of classes)
			// "Class name to be shown in the drop down": "name of the class like typed in your CSS file",
			// Note: you mustn't put a comma to the last line!
//				options: { "[None selected]": "", 
//					"Small": "small", 
//					"Small Dark": "smalldark", 
//					"Contentheading": "contentheading", 
//					"Componentheading": "componentheading", 
 //					"Moscode": "moscode", 
 //					"Message": "message"
//				}
//			} ] 
//		}
//	);
<?php
	if ($name != "editor2") {
?>
	HTMLArea.agt = navigator.userAgent.toLowerCase();
	HTMLArea.is_gecko  = (navigator.product == "Gecko");
	if (HTMLArea.is_gecko) {
		setTimeout('editor<?php echo $name ?>.generate("<?php echo $hiddenField ?>")', 3000); // Mozilla needs a rest here, especially on Mac OS
	} else {
		editor<?php echo $name ?>.generate('<?php echo $hiddenField ?>');
	}
<?php
	} else if ($name == "editor2") {
?>
		editor<?php echo $name ?>.generate('<?php echo $hiddenField ?>');
<?php
	}
?>
	 
//-->
</script>
<?php
}

function getEditorContents( $editorArea, $hiddenField ) {
}
