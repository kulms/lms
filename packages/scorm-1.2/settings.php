<?php
require ("../../include/global_login.php");
/*
 * tools/packages/scorm-1.2/settings.php
 *
 * This file is part of ATutor, see http://www.atutor.ca
 * 
 * Copyright (C) 2005  Matthai Kurian 
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

//define('AT_INCLUDE_PATH', '../../../include/');
//require(AT_INCLUDE_PATH.'vitals.inc.php');

/*
if (authenticate(AT_PRIV_CONTENT, AT_PRIV_RETURN)) {
       $_pages['tools/packages/scorm-1.2/settings.php']['parent'] =
               'tools/packages/index.php';
       $_pages['tools/packages/scorm-1.2/settings.php']['children'] = array ();
}
*/

$org_id = $_GET['org_id'];
if (isset($_POST[org_id])) {
	$org_id = $_POST[org_id];
	$sql = "UPDATE	p_scorm_1_2_org
		SET	lesson_mode = '$_POST[lesson_mode]',
			credit      = '$_POST[credit]'
		WHERE	org_id = $org_id
		";
	$result = mysql_query($sql);
	if ($result) {
		//$msg->addFeedback('SCORM_SETTINGS_SAVED');
		print("<script language=javascript> alert('SCORM_SETTINGS_SAVED'); </script>");
	} else {		
		//$msg->addError('SCORM_SETTINGS_SAVE_ERROR');
		print("<script language=javascript> alert('SCORM_SETTINGS_SAVE_ERROR'); </script>");
	}
}

$sql = "SELECT	org_id, title, credit, lesson_mode
	FROM	p_scorm_1_2_org 
	WHERE	org_id = $org_id
	";

$result = mysql_query($sql);

if (mysql_num_rows($result) == 0) {
	//require(AT_INCLUDE_PATH.'header.inc.php');
	//$msg->printInfos (NO_PACKAGES);
	//require (AT_INCLUDE_PATH.'footer.inc.php');
	echo "No packages.";
	exit;
} else {
	$row = mysql_fetch_assoc($result);
	$_pages['packages/scorm-1.2/settings.php']['children'] = array();
	$_pages['packages/scorm-1.2/settings.php']['title']
		= $row['title'];
	$cr = $row['credit'];
	$lm = $row['lesson_mode'];
}


//require(AT_INCLUDE_PATH.'header.inc.php');
require('header.php');

?><br> 
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="5%" >&nbsp;</td>
    <td width="3%" ><img src="../../images/tool-old.gif" width="18" height="16"></td>
    <td width="92%" ><strong><u>Packages Setting</u></strong></td>
  </tr>
</table>
<div class="input-form">
<form name="form1" method="post"
      action="settings.php"
      enctype="multipart/form-data">
    <table width="90%" border="0" align="center" cellspacing="0" cellpadding="3" class="tdborder2">
      <tr> 
        <td colspan="2" class="hilite"> <input type="submit" name="submit" 
	     onClick="setClickSource('submit');"
	     value="<?php echo "save"; ?>"  class="button"/> <input type="hidden" name="org_id" value="<?php echo $org_id; ?>"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td width="18%"><strong>Title</strong></td>
        <td width="82%"><strong><? echo $_pages['packages/scorm-1.2/settings.php']['title'];?></strong></td>
      </tr>
      <tr> 
        <td><?php echo "scorm_credit_mode";?></td>
        <td><select name="credit" class="text">
            <option value="credit" 
      	<?php if ($cr == 'credit') echo 'selected'; ?>>credit</option>
            <option value="no-credit"
      	<?php if ($cr != 'credit') echo 'selected'; ?>>no-credit</option>
          </select></td>
      </tr>
      <tr> 
        <td><?php echo "scorm_lesson_mode";?></td>
        <td><select name="lesson_mode" class="text">
            <option value="browse" <?php if ($lm == 'browse') echo 'selected'; ?>>browse</option>
            <option value="normal" <?php if ($lm != 'browse') echo 'selected'; ?>>normal</option>
          </select></td>
      </tr>
    </table>    

</form>
</div>


<script language="javascript" type="text/javascript">

var but_src;

function setClickSource(name) {
	but_src = name;
}

</script>

<?php //require (AT_INCLUDE_PATH.'footer.inc.php'); ?>
