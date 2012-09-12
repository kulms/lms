<?
/*
#===========================================================================
#= Script : EGAT e-Learning
#= Author : S.Kongdej
#= Web Designer: somboonph@egat.or.th
#= Email  : skongdej@hotmail.com
#= Support: http://www.learningnuke.com
#===========================================================================
#= Copyright (c) 2004 Electricity Generating Authority of Thailand,Jongdee Group
#= You are free to use and modify this script as long as this header
#=
#= This program is free software; you can redistribute it and/or modify
#= it under the terms of the GNU General Public License as published by
#= the Free Software Foundation; either version 2 of the License, or
#= (at your option) any later version.
#=
#= This program is distributed in the hope that it will be useful,
#= but WITHOUT ANY WARRANTY; without even the implied warranty of
#= MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#= GNU General Public License for more details.
#=
#= You should have received a copy of the GNU General Public License
#= along with this program; if not, write to the Free Software
#= Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#===========================================================================
*/
/**
*  แฟ้มข้อมูลสุดบันทึก
*/
function folder() {
	global $config,$lang;
		

	echo '<TABLE WIDTH=98% cellspacing=0 cellpadding=0>';
	echo '<TR><TD>';
		
	folderMenu();

	echo $lang['folderdesc'];
?>
<BR>&nbsp;
<script language="JavaScript" src="js/tree.js"></script>
<script language="JavaScript">
		var TREE_ITEMS = [['My Folder', 'index.php?action=folder',
<?
	print_menu_tree(0,0);	
?>
		]];
</script>
<script language="JavaScript" src="js/tree_tpl.js"></script>
<script language="JavaScript">
	new tree (TREE_ITEMS, tree_tpl);
</script>

<?

	echo '</TD></TR></TABLE>';
}


/**
* เมนูบันทึกข้อความ
*/
function folderMenu() {
	global $config, $lang;
	global $action;

	echo '<table width=98% cellspacing=0 cellpadding=0>';
	echo '<tr><td>';
	echo '<img src="theme/'.$config['theme'].'/title/'.$config['language'].'/folder.jpg" border="0"></td></tr>';
	$select = array();
	if (empty($action)) {
		$select['folder']='class=select';
	}
	else {
		$select[$action] = 'class=select';
	}
	echo "<tr valign=top><td>";
	echo "<A HREF='index.php?action=folder' ".$select['folder']."><img src=js/icons/base.gif border=0><B>$lang[menu_note]</B></A>&nbsp;&nbsp; ";
	echo "<A HREF='index.php?action=noteadd' ".$select['noteadd']."><img src='".$config['foldericons'][2]."' border=0><B>$lang[menu_note_add]</B></A>&nbsp;&nbsp; ";
	echo "<A HREF='index.php?action=foldernew' ".$select['foldernew']."><img src=js/icons/folder.gif border=0><B>$lang[menu_folder_add]</B></A>&nbsp;&nbsp; ";
	echo "<A HREF='index.php?action=folderedit' ".$select['folderedit']."><img src=js/icons/folders.gif border=0><B>$lang[menu_folder_org]</B></A>";
	echo "</td></tr>";
	echo "<tr height=1><td background='images/line2.gif'></table>";
}


// function: display complete menu tree
// returns: HTML list
function print_menu_tree($id = 0,$edit) 
{
	global $config;

	$result = get_children($id);	
	for ($x=0; $x<sizeof($result); $x++)
	{
		if ($edit && $result[$x]["subject"] != "My Folder") {
			$renfolder ="<A HREF=index.php?action=foldernew&folderid=".$result[$x]["id"]."><img src=images/edit.gif border=0></A> ";
			$renfolder.="<A HREF=javascript:if(confirm(&quot;Are%20you%20sure?&quot;))window.open(&quot;index.php?action=folderdelete&folderid=".$result[$x]["id"]."&quot;,&quot;_self&quot;);><img src=images/delete.gif border=0></A>";
		}
		else {
			$renfolder="";
		}

		if ($result[$x]["type"] == 0)  {
			if (get_children($result[$x]["id"]) <= 0 ) {
				echo "['" . $result[$x]["subject"]." $renfolder ',null";
			}
			else {
				echo "['" . $result[$x]["subject"]." $renfolder  ',null, ";
			}
		}
		else {
			echo "['" . $result[$x]["subject"]." <img src=".$config['foldericons'][$result[$x]["type"]]." border=0>','index.php?action=postview&folderid=".$result[$x]["id"]."'";
		}


		print_menu_tree($result[$x]["id"],$edit);	

		echo "],";
	}
}



//function: get parent
// returns: node id
function get_parent($id)
{
	global $config,$usersess;

	$query = "SELECT Parent FROM $config[tablefolder] WHERE FolderID = '$id' and Nickname='$usersess[nickname]' ";	
	$result = db_query($query);
	$row = mysql_fetch_row($result);
	return $row[0];
}

// function: get next level of menu tree
// returns: array
function get_children($id)
{
	global $config,$usersess;

	$query = "SELECT FolderID, Subject, Type, Note, NoteTime FROM $config[tablefolder] WHERE Parent = '$id' and Nickname='".$usersess->get_var("nickname")."' ORDER BY Subject";	
	$result = db_query($query);
	$count = 0;
	while ($row = mysql_fetch_array($result))
	{
		$children[$count]["id"] = $row["FolderID"];	
		$children[$count]["subject"] = $row["Subject"];
		$children[$count]["type"] = $row["Type"];
		$children[$count]["note"] = $row["Note"];
		$children[$count]["notetime"] = $row["NoteTime"];
		$count++;
	}
	return $children;
}

// function: get folder
// returns: array
function get_folder()
{
	global $config,$usersess;

	$query = "SELECT FolderID, Subject FROM $config[tablefolder] WHERE Type = '0' and Nickname='".$usersess->get_var("nickname")."' ";	
	$result = db_query($query);
	$count = 0;
	while ($row = mysql_fetch_array($result))
	{
		$folder[$count]["id"] = $row["FolderID"];	
		$folder[$count]["subject"] = $row["Subject"];
		$count++;
	}
	return $folder;
}


/*- - - แสดงข้อมูล- - -*/
function postView() {
	global $config,$lang;
	global $folderid;

	folderMenu();

	?>
	<TABLE WIDTH=98% cellspacing=5 cellpadding=0>
	<TR>
	<TD ALIGN="LEFT">
	<?

	$sql = "SELECT Subject, Note, NoteTime, Parent FROM $config[tablefolder]";
	$sql .= " WHERE FolderID='$folderid'";
	$result=db_select($sql);
	list($subject,$message,$notetime,$parent) = mysql_fetch_row($result);

	$subject=stripslashes($subject);
	$subject=filter($subject,1);
	$message=stripslashes($message);
	$message=filter($message,1);
	
	$notedate=date($config['dateformat'],sql_to_unix_time($notetime));
	echo "<div align=left>$lang[noteviewdesc]</div><BR>";
	echo "<table width=100% cellpadding=3 cellspacing=1  border=0 bgcolor=#336666>";
	echo "<FORM NAME=Noteadd METHOD=POST ACTION='index.php'>";
	echo "<INPUT TYPE=hidden name=action value='noteadd'>";
	echo "<INPUT TYPE=hidden name=fid value=$folderid>";
	echo "<tr height=18><td class=head>&nbsp;<B>$subject</B></td></tr>";
	echo "<tr valign=top height=100><td bgcolor=#FFFFFF>$message</td></tr></td></tr>";
	echo "<tr><td align=right class=head>$lang[date]: $notedate</td></tr></table>";
	echo "<BR><CENTER><INPUT class=button TYPE=\"submit\" value=\"$lang[button_edit_note]\">&nbsp;<INPUT class=button TYPE=\"button\" value=\"$lang[button_delete]\" onclick=\"javascript:if(confirm('Are you sure?')) window.open('index.php?action=notedelete&fid=$folderid','_self')\"></CENTER>";
	echo "</FORM>";

	?>
	</TD>
	</TR>
	</TABLE>
	<?
}


/**
* ฟอร์มรับบันทึกข้อความ 
*/
function noteAdd() {
	global $config,$lang;
	global $fid;
	
	folderMenu();
	
	echo '<TABLE WIDTH=98% cellspacing=0 cellpadding=0>';
	echo '<TR><TD>';

	if ($fid) {
		$sql = "SELECT Subject, Note, NoteTime, Parent FROM $config[tablefolder]";
		$sql .= " WHERE FolderID='$fid'";
		$result=db_select($sql);
		list($subject,$message,$notetime,$parent) = mysql_fetch_row($result);
	}
	
	?>
	  <script language="javaScript">
		function formSubmit(val) {
			if(val == "Clear") document.forms.Noteadd.submit();
			else if(checkFields()) {
				document.forms.Noteadd.action.value = val;
				return true;
			}
			else {
				return false;
			}
		}
		
		function clearFields() {
			document.forms.Noteadd.reset();
		}
		
    	function checkFields() { 
			var subject = document.forms.Noteadd.subject.value;	
			if (subject  == "" ) {
				alert("<?=$lang['alertsubject']?>");
				document.forms.Noteadd.subject.focus();
				return false;
			} 
			return true
		}
		</script>
	<?
	echo $lang['noteadddesc'];
	echo "<BR>&nbsp;<table width=100% cellpadding=3 cellspacing=1  border=0 class=form>";
	echo "<FORM NAME=Noteadd METHOD=POST ACTION='index.php' Onsubmit=\"return formSubmit('noteaddsave')\">";
	echo "<INPUT TYPE=hidden name=action>";
	echo "<INPUT TYPE=hidden name=fid value=$fid>";
	echo "<tr><td colspan=2 class=head>&nbsp;<B>$lang[noteadd]</B></td></tr>";
	echo "<tr><td align=right width=100>$lang[subject]:</td><td><INPUT TYPE=\"text\" NAME=\"subject\" value=\"$subject\" style='width:80%'></td></tr>";
	echo "<tr valign=top><td align=right>$lang[message]:</td><td><TEXTAREA NAME=\"message\" ROWS=10 COLS=30 style='width:90%'>$message";
	echo "</TEXTAREA></td></tr>";
	echo "<tr><td align=right>$lang[select_folder]:</td><td><SELECT NAME=\"parent\">";
	$result = get_folder();	

	$select[$parent]='selected';
	for ($x=0; $x<sizeof($result); $x++) {
		echo "<OPTION VALUE=".$result[$x]["id"]." ".$select[$result[$x]["id"]].">".$result[$x]["subject"]."</OPTION>";
	}
	echo "</SELECT></td></tr>";
	echo "<tr valign=top><td></td><td>&nbsp;<BR>";
	echo "<INPUT class=button TYPE=\"submit\" VALUE=\"$lang[button_add_note]\">&nbsp;";
	echo "<INPUT class=button TYPE=\"button\" VALUE=\"$lang[button_cancel]\" onclick=\"javascript:window.open('index.php?action=folder','_self')\">";
	echo "<BR>&nbsp;</td></tr></table>";
	echo "</FORM>";
?>
</TD>
</TR>
</TABLE>
<?

}


/**
* เก็บข้อมูลลง database
*/
function noteAddSave() {
	global $config,$usersess;
	global $subject,$message,$parent,$fid;

	$subject=addslashes($subject);
	$message=addslashes($message);
	if ($fid) {
		$sql = "UPDATE $config[tablefolder] SET Subject='$subject', Note='$message', Parent='$parent' WHERE FolderID='$fid' ";
	}
	else {
		$sql = "INSERT INTO $config[tablefolder] (Nickname, Subject, Type, Note, Parent) ";
		$sql .= "VALUES ('".$usersess->get_var("nickname")."','$subject','2','$message','$parent')";
	}
	db_query($sql);
	folder();
}

/**
* ลบบันทึก
*/
function noteDelete() {
	global $config,$fid;

	// Delete Note
	$sql = "DELETE FROM $config[tablefolder] WHERE FolderID='$fid' ";
	db_query($sql);
	$fid='';
	folder();
}


/**
* สร้างแฟ้มข้อมูลใหม่
*/
function folderNew() {
	global $config,$lang;
	global $folderid;

	folderMenu();

	?>
	<TABLE WIDTH=98% cellspacing=5 cellpadding=0>
	<TR>
	<TD ALIGN="LEFT">
	<?

	echo $lang['foldernewdesc'].'<BR>';

	if ($folderid) {
		$sql = "SELECT Subject, Parent FROM $config[tablefolder]";
		$sql .= " WHERE FolderID='$folderid'";
		$result=db_select($sql);
		list($subject,$parent) = mysql_fetch_row($result);
	}


	?>
	    <script language="javaScript">
		function formSubmit(val) {
			if(checkFields()) {
				document.forms.Foldernew.action.value = val;
				return true
			}
			else {
				return false;
			}
		}
		
    	function checkFields() { 
			var name = document.forms.Foldernew.name.value;
		
			if (name  == "" ) {
				alert("<?=$lang['alertfolder']?>");
				document.forms.Foldernew.name.focus();
				return false;
			} 
			else {
				return true
			}
		}
		</script>
	<?
	echo "<BR><table width=100% cellpadding=3 cellspacing=1  border=0 class=form>";
	echo "<FORM NAME=Foldernew METHOD=POST ACTION='index.php' Onsubmit=\"return formSubmit('foldernewsave') \">";
	echo "<INPUT TYPE=\"hidden\" name=action>";
	echo "<INPUT TYPE=\"hidden\" name=fid VALUE='$folderid'>";
	echo "<tr height=18><td colspan=2 class=head>&nbsp;<B>$lang[foldernew]</B></td></tr>";
	echo "<tr><td align=right width=20%>$lang[foldernewname]:</td><td><INPUT TYPE=\"text\" NAME=\"foldername\" VALUE=\"$subject\" style='width:150px'></td></tr>";
	echo "<tr><td align=right>$lang[folderparent]:</td><td><SELECT NAME=\"parent\">";

	$result = get_folder();
	if ($parent==0) {
		echo "<OPTION VALUE=0 selected><< My Folder >></OPTION>";
	}
	else  {
		echo "<OPTION VALUE=0><< My Folder >></OPTION>";
	}
	for ($x=0; $x<sizeof($result); $x++)
	{
		if ($result[$x]["id"] == $parent)
			$select="selected";
		else 
			$select="";
		echo "<OPTION VALUE=".$result[$x]["id"]." $select>".$result[$x]["subject"]."</OPTION>";
	}
	echo "</SELECT></td></tr>";
	
	echo "<tr><td></td><td>&nbsp;<BR>";
	if ($folderid) {
		echo "&nbsp;<INPUT class=button TYPE=\"submit\" VALUE=\"$lang[button_edit_folder]\">";
	}
	else {
		echo "&nbsp;<INPUT class=button TYPE=\"submit\" VALUE=\"$lang[button_add_folder]\"></A>";
}
	echo "</td></tr></table>";
	echo "</FORM>";

?>
	</TD>
	</TR>
	</TABLE>
<?
}

/*- - - เพิ่มแฟ้มข้อมูลลงใน database - - -*/
function folderNewSave($fdn,$p,$f,$show) {
	global $config,$usersess;
	global $foldername,$parent,$fid;

	if ($fdn != -1) {
		$foldername = $fdn;
	}
	if ($p != -1) {
		$parent = $p;
	}
	if ($f != -1) {
		$fid = $f;
	}

	if ($fid) {
		// Rename folder
		$sql = "UPDATE $config[tablefolder] SET Subject='$foldername', Parent='$parent' WHERE FolderID='$fid' ";
	}
	else {
		// Add folder
		$sql = "INSERT INTO $config[tablefolder] (Nickname, Subject, Type, Parent) ";
		$sql .= "VALUES ('".$usersess->get_var("nickname")."','$foldername','0','$parent')";
	}
	
	db_query($sql);

	if ($show) { 
		folder();
	}
}


/*- - - แก้ไขชื่อแฟ้ม - - -*/
function folderEdit() {
	global $config,$lang;
		
	folderMenu();

	?>
	<TABLE WIDTH=98% cellspacing=5 cellpadding=0>
	<TR>
	<TD ALIGN="LEFT">
	<?

	echo $lang['foldereditdesc'].'</div><BR>';

	?>
	<script language="javaScript">
		function formSubmit(val) {
			document.forms.Noteadd.action.value = val;
			document.forms.Noteadd.submit();
		}		
		</script>
	<?
	echo "<FORM NAME=Noteadd METHOD=POST ACTION='index.php'>";
	echo "<INPUT TYPE=\"hidden\" name=action>";

	?>
	<script language="JavaScript" src="js/tree.js"></script>
	<script language="JavaScript">
			var TREE_ITEMS = [['My Folder', 'index.php?action=folder',
	<?
		print_menu_tree(0,1);	
	?>
			]];
	</script>
	<script language="JavaScript" src="js/tree_tpl.js"></script>
	<script language="JavaScript">
		new tree (TREE_ITEMS, tree_tpl);
	</script>

	</TD>
	</TR>
	</TABLE>
	<?
}


/*- - - ลบแฟ้ม- - - -*/
function folderDelete() {
	global $config;
	global $folderid;

	$sql = "DELETE FROM $config[tablefolder] WHERE FolderID='$folderid'";
	db_query($sql);

	folderDeleteChild($folderid);
	$folderid='';
	folder();
}

/*- - - ลบลูกของแฟ้มข้อมูล- - - -*/
function folderDeleteChild ($folderid) {
	global $config;

	$result = get_children($folderid);	
	for ($x=0; $x<sizeof($result); $x++)
	{
		if ($result[$x]["subject"] != "My Folder") {
			$sql = "DELETE FROM $config[tablefolder] WHERE FolderID='".$result[$x]["id"]."' ";
			db_query($sql);
		}
		folderDeleteChild($result[$x]["id"]);	
	}
}

?>