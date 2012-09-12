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
* school functions
* list school and show add form 
*/
function school() {
	global $config, $lang, $usersess;
	global $action, $schoolid;
	
	if (!$usersess->get_var("admin")) {
		echo '<BR>'.$lang['notauthorize'];
		return;
	}
	
	?>
    <script language="javaScript">
		function formSubmit(val) {
			if(checkFields()) {
				document.forms.School.action.value = val;
				return true;
			}
			else {
				return false;
			}
		}
		
    	function checkFields() {
			var code = document.forms.School.schoolcode.value;
			var name = document.forms.School.schoolname.value;
		
			if (code  == "" ) {
				alert("<?=$lang['alertcode']?>");
				document.forms.School.schoolcode.focus();
				return false;
			}
			if (code.length  != <?=$config['prefix_course_code_limit']?> ) {
				alert("<?=$lang['alertcode']?> =  <?=$config['prefix_course_code_limit']?>");
				document.forms.School.schoolcode.focus();
				return false;
			}
			if (name  == "" ) {
				alert("<?=$lang['alertschoolname']?>");
				document.forms.School.schoolname.focus();
				return false;
			}
			return true;
		}
	</script>	


<?
	echo '<DIV ALIGN="LEFT"><IMG SRC="theme/'.$config['theme'].'/title/'.$config['language'].'/course_school.jpg" BORDER=0></DIV><BR>';

	if (!empty($schoolid)) {
		echo "<FORM NAME=\"School\" METHOD=POST ACTION=\"index.php\" enctype=\"multipart/form-data\" Onsubmit=\" return formSubmit('updateschool')\">";

		$sql = "SELECT * FROM $config[tableschool]  WHERE School_code='$schoolid'";
		$result=db_select($sql);
		list($schoolid,$schoolcode,$schoolname,$schooldesc,$schoolimage,$schoolweight) = mysql_fetch_row($result);
		echo "<INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"updateschool\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"schoolid\" VALUE=\"$schoolid\">";
	}
	else {
		echo "<FORM NAME=\"School\" METHOD=POST ACTION=\"index.php\" enctype=\"multipart/form-data\" Onsubmit=\"return formSubmit('addschool')\">";

		$sql = "SELECT max(School_weight) FROM $config[tableschool]";
		$result=db_select($sql);
		list($schoolweight) = mysql_fetch_row($result);
		$schoolweight++;
		echo "<INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"addschool\">";
	}
	echo "<INPUT TYPE=\"hidden\" NAME=\"MAX_FILE_SIZE\" VALUE=$config[uploadfilesize]>";

	echo "<TABLE WIDTH=98% CELLSPACING=0 CELLPADDING=0>";
	echo "<TR valign=middle HEIGHT=18><TD class=head> <B>&nbsp;$lang[addschool]</B></TD></TR>";
	echo "<TR><TD>";
	echo "<TABLE WIDTH=100% CELLSPACING=0 CELLPADDING=3 class=form>";
	echo "<TR><TD ALIGN=RIGHT>$lang[schoolno]:</TD><TD><INPUT TYPE=\"text\" NAME=\"schoolweight\" size=1 VALUE=\"$schoolweight\"></TD></TR>";
	echo "<TR><TD ALIGN=RIGHT>$lang[schoolcode]:</TD><TD><INPUT TYPE=\"text\" NAME=\"schoolcode\" size=5 VALUE=\"$schoolcode\">  </TD></TR>";
	echo "<TR><TD ALIGN=RIGHT>$lang[schoolname]:</TD><TD><INPUT TYPE=\"text\" NAME=\"schoolname\" size=40 style='width:90%' VALUE=\"$schoolname\"></TD></TR>";
	echo "<TR><TD ALIGN=RIGHT VALIGN=TOP>$lang[schooldesc]:</TD><TD><textarea name=\"schooldesc\" rows=\"3\" cols=\"30\" style='width:90%'>$schooldesc</textarea></TD></TR>";
	if (!empty($schoolimage)) {
		echo "<TR><TD ALIGN=RIGHT></TD><TD><img src=\"$config[uploadimagesdir]/$schoolimage\" border=0></TD></TR>";
	}
	echo "<TR><TD ALIGN=RIGHT>$lang[schoolimage]:</TD><TD><INPUT TYPE=\"file\" NAME=\"filename\"> $lang[schoolimagenote]</TD></TR>";
	if (!empty($schoolid)) {
		echo "<TR><TD></TD><TD><INPUT TYPE=\"submit\" value=\"$lang[button_editschool]\"> <INPUT TYPE=\"button\" value=\"$lang[button_cancel]\" onclick=\"javascript:window.open('index.php?action=school','_self')\"></A></TD></TR>";
	}
	else {
		echo "<TR><TD></TD><TD><INPUT TYPE=\"submit\" class=\"button\" value=\"$lang[button_addschool]\"><BR><BR></TD></TR>";
	}
	echo "</TABLE>";
	echo "</TD></TR></TABLE>";
	echo "</FORM><BR>";
	

	// Browse all schools ====>>>>>>

	$sql = "SELECT * FROM $config[tableschool]  ORDER BY School_weight";
	$result=db_select($sql);

	echo "<TABLE WIDTH=98% CELLSPACING=3 CELLPADDING=0>";

	for ($i=0; list($schoolid,$schoolcode,$schoolname,$schooldesc,$schoolimage) = mysql_fetch_row($result); $i++) {
		$schoolcode=stripslashes($schoolcode);
		$schoolname=htmlspecialchars($schoolname);
		echo "<TR>";
		echo "<TD width=\"3%\"  valign=\"middle\" align=\"center\">";
		if (!empty($schoolimage) && file_exists($config['uploadimagesdir'].'/'.$schoolimage)) {
			echo "<IMG SRC=\"$config[uploadimagesdir]/$schoolimage\"  BORDER=0>";
		}
		else {
			echo '-';
		}
		echo "</TD>";
		echo "<TD valign=\"top\"><b>($schoolcode) $schoolname </b><br>$schooldesc</TD>";
		echo "<TD valign=\"top\" align=\"center\" width=20%>";
		echo "<INPUT TYPE=\"button\" class=button value=\"$lang[button_edit]\" onclick=\"window.open('index.php?action=school&schoolid=$schoolid','_self')\"> ";

		$ncourse =  db_getvar($config['tablecourse'],"School='$schoolid'","COUNT(*)");
		if ($ncourse == 0) {
			echo "<INPUT TYPE=\"button\" class=button value=\"$lang[button_delete]\"  onclick=\"if(confirm('Delete school $schoolname?\\nWARNING: you will lose all data in course $schoolname ')) window.open('index.php?action=deleteschool&schoolid=$schoolid','_self')\">";
		}
		echo "</TD></TR>";
	}

	echo "</TABLE><BR>";

}


/**
* add school
*/
function addSchool() {
	global $lang, $config,$usersess;
	global $schoolcode,$schoolname,$schooldesc,$filename,$schoolweight;
	
	if ($usersess->get_var("admin")) {
		
		// upload images to server
		$IMG_ACCEPT =  array("image/gif","image/pjpeg","image/jpg","image/x-png","image/jpeg"); //acceptable types
		list($logofilename,$type) = explode('.',$_FILES['filename']['name']);
		if (!empty($logofilename)) {
			
			$accept_type = 0;
			foreach ($IMG_ACCEPT as $type) {
					if ($_FILES['filename']['type'] == $type){
							$accept_type = 1;
							break;
					}
			}

			if ($accept_type){
					if (!@copy($_FILES['filename']['tmp_name'], $config['uploadimagesdir']. "/" . $_FILES['filename']['name'])){
							$errors =  "Cannot upload " . $_FILES['filename']['name'];
					}
					unlink($_FILES['filename']['tmp_name']);
			}else{
					$errors = "Wrong file type";
			}
		
		}
	
		$schoolcode = addslashes($schoolcode);
		$schoolname = addslashes($schoolname);
		$schooldesc = addslashes($schooldesc);
		$file_name = $_FILES['filename']['name'];

		$sql = "INSERT INTO $config[tableschool] (School_code, School_codename, School_name,School_desc,School_image,School_weight) ";
		$sql .= " VALUES ('','$schoolcode','$schoolname','$schooldesc','$file_name','$schoolweight')";

		$ret = db_query($sql);
	}
	else {
		echo $lang['notauthorize'];
	}

	school();
}


/**
*  delete school
*/
function deleteSchool() {
	global $lang, $config,$usersess;
	global $schoolid;
	
	if ($usersess->get_var("admin")) {

		// delete image
		$image =  db_getvar($config['tableschool'],"School_code='$schoolid'","School_image");
		if (!empty($image) && file_exists($config['uploadimagesdir'].'/'.$image)) {
			unlink($config['uploadimagesdir'].'/'.$image);
		}
		
		$sql = "DELETE FROM $config[tableschool] WHERE School_code='$schoolid'";
		$ret = db_query($sql);
	}
	else {
		echo $lang['notauthorize'];
	}

	$schoolid='';
	school();
}


/**
* update school
*/
function updateSchool() {
	global $lang, $config,$usersess;
	global $schoolid,$schoolcode,$schoolname,$schooldesc,$filename,$schoolweight;
	
	if ($usersess->get_var("admin")) {
		
		$sql = "UPDATE $config[tableschool] SET School_codename='$schoolcode', School_name='$schoolname',School_desc='$schooldesc',School_weight='$schoolweight'";

		// upload images to server
		if (!empty($_FILES['filename']['name'])) {
			$IMG_ACCEPT =  array("image/gif","image/pjpeg","image/jpg","image/x-png","image/jpeg"); //acceptable types
			list($logofilename,$type) = explode('.',$_FILES['filename']['name']);
			if (!empty($logofilename)) {
				
				$accept_type = 0;
				foreach ($IMG_ACCEPT as $type) {
						if ($_FILES['filename']['type'] == $type){
								$accept_type = 1;
								break;
						}
				}

				if ($accept_type){
						if (!@copy($_FILES['filename']['tmp_name'], $config['uploadimagesdir']. "/" . $_FILES['filename']['name'])){
								$errors =  "Cannot upload " . $_FILES['filename']['name'];
						}
						unlink($_FILES['filename']['tmp_name']);
				}else{
						$errors = "Wrong file type";
				}

				// delete image
				//$image =  db_getvar($config['tableschool'],"School_code='$schoolid'","School_image");
				//if (!empty($image) && file_exists($config['uploadimagesdir'].'/'.$image)) {
				//	unlink($config['uploadimagesdir'].'/'.$image);
				//}
			}
			$file_name = $_FILES['filename']['name'];
			$sql .= ",School_image='$file_name'";
		}
		
		$schoolcode = addslashes($schoolcode);
		$schoolname = addslashes($schoolname);
		$schooldesc = addslashes($schooldesc);

		$sql .= " WHERE School_code='$schoolid'";
		$ret = db_query($sql);
	}
	else {
		echo $lang['notauthorize'];
	}
 
	$schoolid=$schoolcode=$schoolname=$schooldesc=$filename=$schoolweight='';
	school();
}
?>