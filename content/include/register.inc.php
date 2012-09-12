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
/*  Registeration and User preference Form 
*/
function register($section,$vars) {
	global $config,$lang,$usersess;

	// Get arguments from argument array
    extract($vars);

?>
    
    <script language="javaScript">
		
		function formSubmit(val) {
			if(checkFields()) {
				document.forms.Userprofile.action.value = val;
				return true;
			}
			else {
				return false;
			}
		}
		
		function clearFields() {
			document.forms.Userprofile.reset();
		}

    	function checkFields() {
			var nickname = document.forms.Userprofile.nick.value;
			var userId = document.forms.Userprofile.id.value;
			var password1 = document.forms.Userprofile.password.value;
			var password2 = document.forms.Userprofile.confirmpassword.value;
			var userFirstName = document.forms.Userprofile.firstname.value;
			var userLastName = document.forms.Userprofile.lastname.value;
			var emailAddress = document.forms.Userprofile.email.value;
			var phone = document.forms.Userprofile.phone.value;
		
			if (nickname  == "" ) {
				alert("<?=$lang['alertnickname']?>");
				document.forms.Userprofile.nick.focus();
				return false;
			}			
			if (isComposedOfChars("_ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",nickname)){
				alert("<?=$lang['nickname']?> <?=$lang['alertnotalpha']?>");
				document.forms.Userprofile.nick.focus();
				return false;
			}
			if (nickname.length  < <?=$config['nick_lower']?>) {
				alert("<?=$lang['alertnicknamel']?>");
				document.forms.Userprofile.nick.focus();
				return false;
			}
			if (nickname.length  >= <?=$config['nick_upper']?>) {
				alert("<?=$lang['alertnicknamem']?>");
				document.forms.Userprofile.nick.focus();
				return false;
			}

			if (password1  == "") {
				alert("<?=$lang['alertpassword']?>");
				document.forms.Userprofile.password.focus();
				return false;
			}
			if (isComposedOfChars("_ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",password1)){
				alert("<?=$lang['password']?> <?=$lang['alertnotalpha']?>");
				document.forms.Userprofile.password.focus();
				return false;
			}
			if (password1.length  < <?=$config['pass_lower']?>) {
				alert("<?=$lang['alertpassword6']?>");
				document.forms.Userprofile.password.focus();
				return false;
			} 
			else if (password1.length  >= <?=$config['pass_upper']?>) {
				alert("<?=$lang['alertpassword32']?>");
				document.forms.Userprofile.password.focus();
				return false;
			}

			if (password2  == "") {
				alert("<?=$lang['alertpassword2']?>");
				document.forms.Userprofile.confirmpassword.focus();
				return false;
			}
			if (password2 != password1) {
				alert("<?=$lang['alertpassword0']?>");
				document.forms.Userprofile.confirmpassword.focus();
				return false;
			}

			if (userId  == "") {
				alert("<?=$lang['alertid']?>");
				document.forms.Userprofile.id.focus();
				return false;
			}
			if (userId.length  != <?=$config['id_length']?>) {
					alert("<?=$lang['alertid6']?>");
					document.forms.Userprofile.id.focus();
					return false;
			}
			if (isComposedOfChars("0123456789",userId)){
				alert("<?=$lang['id']?> <?=$lang['alertnotnum']?>");
				document.forms.Userprofile.id.focus();
				return false;
			}

			if (userFirstName  == "") {
				alert("<?=$lang['alertfirstname']?>");
				document.forms.Userprofile.firstname.focus();
				return false;
			}

			if (userLastName  == "") {
				alert("<?=$lang['alertlastname']?>");
				document.forms.Userprofile.lastname.focus();
				return false;
			}

			if (emailAddress  == "" && phone == "") {
				alert("<?=$lang['alertemail']?>");
				document.forms.Userprofile.email.focus();
				return false;
			}

			if (emailAddress != "" && (emailAddress.indexOf(" ") > -1 || emailAddress.indexOf("@") == -1 || emailAddress.indexOf(",") > -1 )) {
				alert("<?=$lang['alertemailformat']?>");
				document.forms.Userprofile.email.focus();
				return false;
			}


			if (isComposedOfChars("0123456789-",phone)){
				alert("<?=$lang['phone']?> <?=$lang['alertnotnum']?>");
				document.forms.Userprofile.phone.focus();
				return false;
			}

		return true; 
	}

	function isComposedOfChars(testSet, input) {
		for (var j=0; j<input.length; j++) {
			if (testSet.indexOf(input.charAt(j), 0) == -1) {
				return true;
			}
		}
		return false;
	}

	</script>

			<TABLE WIDTH="615"  BORDER="0" CELLSPACING="0" CELLPADDING="0">
			<TR HEIGHT="45">
			<TD VALIGN="MIDDLE" ALIGN="LEFT">
<?
				if ($section == "preferences") {
					echo '<IMG SRC="theme/'.$config['theme'].'/title/'.$config['language'].'/profile.jpg"  BORDER="0" ALT="">';
				}
				else {
					echo '<IMG SRC="theme/'.$config['theme'].'/title/'.$config['language'].'/register.jpg" WIDTH="111" HEIGHT="41" BORDER="0" ALT="">';
				}
?>	
			</TD>
			</TR>
			<TR HEIGHT="1">
			<TD  BACKGROUND="images/line2.gif" VALIGN="MIDDLE" ALIGN="CENTER">
			</TD>
			</TR>
			</TABLE>

			<TABLE WIDTH="600" BORDER="0" CELLSPACING="0" CELLPADDING="6">
			<TR >
			<TD  VALIGN="TOP" ALIGN="LEFT">
			<?								
				if ($section == "preferences") {
					echo '<DD>'.$lang['userpreferences'].'<P>';

					$sql = "SELECT * FROM ".$config['tableuser']." WHERE Nickname='".$usersess->get_var('nickname')."'";
					$result = db_getarray($sql);

					$id=$result['ID'];
					$nick= $result['Nickname'];
					$firstname=$result['Firstname'];
					$lastname=$result['Lastname'];
					$password=$result['Password'];
					$confirmpassword=$result['Password'];
					$email=$result['Email'];
					$phone=$result['Phone'];
					$ann=$result['News'];
					$show_result=$result['Shows'];
				}
				else if ($section == "register") {
					echo '<DD>'.$lang['registration'].'<P>';
				}

				echo '<DD>'.$lang['yourprofile'].'<P>';
			?>
			</TD>
			</TR>							
			</TABLE>
			
			<TABLE WIDTH="615"   BORDER="0" CELLSPACING="0" CELLPADDING="2">
			<TR HEIGHT="22">
			<TD VALIGN="MIDDLE" ALIGN="LEFT" class="head2">
			<IMG SRC="images/bul.gif" WIDTH="10" HEIGHT="10" BORDER="0" ALT=""> <B><?=$lang['reghead1']?></B> 
			</TD>
			</TR>		
			</TABLE>
			<P>
			
			<TABLE WIDTH="600"   BORDER="0" CELLSPACING="0" CELLPADDING="2">
				
				
				<!-- Register Form -->
				 <FORM name="Userprofile" method="post" action="index.php" onSubmit="return formSubmit('regsave');">
				 <INPUT TYPE="hidden" NAME="action">
				
				<TR><TD WIDTH="20">&nbsp;</TD><TD WIDTH="185"><?=$lang['nickname']?>:</TD>
					<TD>
					<? if ($usersess->get_var("nickname")) {?>
						<INPUT TYPE="hidden" NAME="nick" value="<?=$nick?>"><B><?=$nick?></B>
					<? } else { ?>		
						<INPUT TYPE="text" NAME="nick" value="<?=$nick?>">
						<?=$lang['nicknamelimit']?>&nbsp;<BR><? if ($dupnickname) echo $lang['dupnickname'];?>
					<? } ?>
					</TD>
				</TR>

				<TR><TD>&nbsp;</TD><TD><?=$lang['password']?>:</TD>
					<TD><INPUT TYPE="password" NAME="password" value="<?=$password?>"><?=$lang['passwordlimit']?></TD></TR>

				<TR><TD>&nbsp;</TD><TD><?=$lang['confirmpassword']?>:</TD>
					<TD><INPUT TYPE="password" NAME="confirmpassword" value="<?=$confirmpassword?>"> *</TD></TR>


				<TR valign="top"><TD>&nbsp;</TD><TD><?=$lang['id']?>:</TD>
					<TD>
					<? if ($usersess->get_var("nickname")) { ?>
						<INPUT TYPE="hidden" NAME="id" value="<?=$id?>"><?=$id?>
					<? } else { ?>	
						<INPUT TYPE="text" NAME="id" value="<?=$id?>"> * &nbsp;<BR><? if ($dupid) echo $lang['dupid'];?> 
					<? } ?>
					</TD>
				</TR>
				</TABLE>
				
				<P>
				<TABLE WIDTH="615"   BORDER="0" CELLSPACING="0" CELLPADDING="2">
				<TR HEIGHT="22">
				<TD VALIGN="MIDDLE" ALIGN="LEFT" class="head2">
				<IMG SRC="images/bul.gif" WIDTH="10" HEIGHT="10" BORDER="0" ALT=""> <B><?=$lang['reghead2']?></B> 
				</TD>
				</TR>		
				</TABLE>
				<P>

				<TABLE  WIDTH="600" BORDER="0" CELLSPACING="0" CELLPADDING="2">
				<TR ><TD WIDTH="20"><INPUT TYPE="checkbox" NAME="show[firstname]" value=1 <? if ($show_result & 1) echo "checked"?>></TD>
					<TD WIDTH="185"><?=$lang['firstname']?>:</TD><TD><INPUT TYPE="text" NAME="firstname" value="<?=$firstname?>"> * </TD></TR>

				<TR><TD><INPUT TYPE="checkbox" NAME="show[lastname]" value=2 <? if ($show_result & 2) echo "checked"?>></TD>
					<TD><?=$lang['lastname']?>:</TD><TD><INPUT TYPE="text" NAME="lastname" value="<?=$lastname?>"> *</TD></TR>

				<TR><TD><INPUT TYPE="checkbox" NAME="show[email]" value=4 <? if ($show_result & 4) echo "checked"?>></TD>
					<TD><?=$lang['email']?>:</TD><TD><INPUT TYPE="text" NAME="email" value="<?=$email?>"> *&nbsp;<? if ($dupemail) echo $lang['dupemail'];?></TD></TR>

				<TR><TD><INPUT TYPE="checkbox" NAME="show[phone]" value=8 <? if ($show_result & 8) echo "checked"?>></TD>
					<TD><?=$lang['phone']?>:</TD><TD><INPUT TYPE="text" NAME="phone" value="<?=$phone?>"></TD></TR>

				<TR HEIGHT=20><TD>&nbsp;</TD>
					<TD COLSPAN="2"><B><?=$lang['universitynews']?></B></TD></TR>

				<TR><TD><INPUT TYPE="checkbox" NAME="ann" value=1 <? if ($ann) echo "checked"?>></TD>
					<TD COLSPAN="2"><?=$lang['universitynewstext']?></TD></TR>

				</TABLE>

<P>
 <input type="hidden" name="section" value="<?=$section?>">
 <input type="hidden" name="show_result" value="<?=$show_result?>">

<CENTER>
<? if ($action == 'preferences') {?>
	<INPUT TYPE="submit" name="submit" class="button" value="<?=$lang['button_preference']?>">
<? } else { ?>
	<INPUT TYPE="submit" name="submit" class="button" value="<?=$lang['button_register']?>">
<? } ?>
</CENTER>
</FORM>	
<BR>
<?
}


/**
/*  Registeration and User preference Save 
*/
function regSave($vars) {
	global $lang,$config,$usersess;

	// Get arguments from argument array
	extract($vars);

	$show_result = $show['firstname'] + $show['lastname'] + $show['email'] + $show['phone'];

	// add new user
	if ($section == "register") {
		//check duplicate
		$dupnickname = db_getvar($config['tableuser'],"Nickname='$nick'","Nickname");
		$dupid = db_getvar($config['tableuser'],"ID='$id'","ID");
		$dupemail = db_getvar($config['tableuser'],"Email='$email'","Email");
		if (!empty($dupnickname) || !empty($dupid) || !empty($dupemail )) {
			$duplist=array('dupnickname'=>$dupnickname,'dupid'=>$dupid,'dupemail'=>$dupemail);
			$vars= array_merge($vars,$duplist);	
			register("register",$vars);
			exit;
		}

		//Add new user
			$regdate = date('Y-m-d H:i');
			$sql = "INSERT INTO $config[tableuser] (ID, Level, Nickname, Firstname, Lastname, Password, Email, Phone,  News, Shows, RegDate) ";
			$sql .= "VALUES ('$id','$config[student_level]','$nick','$firstname','$lastname','$password','$email','$phone','$ann','$show_result','$regdate')";
			db_query($sql);
			update_event($nick,"Register");
		
		// Add folder for user
			$sql = "INSERT INTO $config[tablefolder] (Nickname, Subject, Type, Parent) ";
			$sql .= "VALUES ('$nick','My Folder','0','0')";
			db_query($sql);
		
		// Mail confirm message to user
			if ($email) {
				$from=$config['adminmail'];
				$subject=$lang['registersubject'];
				$msg=$lang['registermail'];
				 mailsock($from,$email,'',$subject,$msg);
			}
		echo $lang['welcomecourse']."<P>";
	}

	// preferences
	else if ($section == "preferences") {
		// check duplicate
			$dupemail = db_getvar($config['tableuser'],"Email='$email'","Email");
			if (!empty($dupemail ) && $dupemail != $email) {
				$duplist=array('dupemail'=>$dupemail);
				$vars= array_merge($vars,$duplist);	
				register("preferences",$vars);
				return;
			}

		//Update user preferences
			$sql = "UPDATE $config[tableuser] SET Password='$password', Firstname='$firstname', Lastname='$lastname', Email='$email', Phone='$phone',  News='$ann', Shows='$show_result'";
			$sql .= " WHERE Nickname='".$usersess->get_var("nickname")."' ";
			db_query($sql);
			update_event($usersess->get_var("nickname"),"Modify user preferences");
			register("preferences",$vars);
			return;
	}

}
?>