<?php
require ("../include/global_login.php");
/*
 * tools/packages/import.php
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

//define('AT_INCLUDE_PATH', '../../include/');
//require(AT_INCLUDE_PATH.'vitals.inc.php');

define ('PACKAGE_TYPES', 'scorm-1.2');

if (isset ($_POST['type'])) {
	require ($_POST['type'] . '/import.php');
}

require('header.php');

/*
if (!defined('AT_ENABLE_SCO') || !AT_ENABLE_SCO) {
	$msg->printErrors('SCO_DISABLED');
	require(AT_INCLUDE_PATH.'footer.inc.php');
	exit;
}
*/
?> 
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> 
    <td width="5%" >&nbsp;</td>
    <td width="3%" ><img src="../images/packages.gif"></td>
    <td width="92%" ><strong><u>Import Packages</u></strong></td>
  </tr>
</table>
<div class="input-form"> 
    <!--<form name="form1" method="post"
			  action="tools/packages/import.php" enctype="multipart/form-data"
			  onsubmit="openWindow('<?php echo $_base_href; ?>tools/prog.php');">-->
	<form name="form1" method="post" action="import.php" enctype="multipart/form-data">		  
<table width="90%" border="0" align="center" cellspacing="0" cellpadding="3" class="tdborder2">
  <tr> 
    <td class="hilite"><input type="submit" name="submit" onClick="setClickSource('submit');" value="<?php echo 'import'; ?>" class="button" /> 
      <input type="submit" name="cancel" onClick="setClickSource('cancel');" value="<?php echo 'cancel'; ?>" class="button" />
      <input type="hidden" name="course_id" value="<?php echo $course_id;?>"></td>
    <td class="hilite">&nbsp; </td>
  </tr>
  
      <tr> 
        <td width="21%" ><?php echo 'package_type';?></td>
        <td width="79%" > <div class="row"> 
            <label for="type"></label>
            <br />
            <select name="type" class="text">
              <?php
			$ptypes = explode (',', PACKAGE_TYPES);
			foreach ($ptypes as $type) {
				echo '<option value="' . $type . '">' . $type . '</option>';
			}
			?>
            </select>
          </div>
          <div class="row"> 
            <label for="to_file"></label>
            <br />
          </div>
          <!--
			<?php echo 'package_upload_url_info';?>
			<div class="row">
			<label for="to_url">
			<?php echo 'package_upload_url'; ?>
			</label><br />
			<input type="text" name="url" value="http://" size="40" id="to_url" />
			</div>
			-->
          <div class="row buttons"> </div></td>
      </tr>
      <tr>
        <td ><?php echo 'package_upload_file'; ?></td>
        <td ><input type="file" name="file" id="file2" class="text" /></td>
      </tr>
   
</table>
 </form>
  </div>

<script language="javascript" type="text/javascript">

var but_src;
function setClickSource(name) {
	but_src = name;
}

function openWindow(page) {
	if (but_src != "cancel") {
		newWindow = window.open(page, "progWin",
			"width=400,height=200,toolbar=no,location=no"
		);
		newWindow.focus();
	}
}
</script>

<?php 
//require (AT_INCLUDE_PATH.'footer.inc.php'); 
?>
