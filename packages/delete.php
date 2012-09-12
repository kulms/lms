<?php
require ("../include/global_login.php");
/*
 * tools/packages/delete.php
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
/*
if (!defined('AT_ENABLE_SCO') || !AT_ENABLE_SCO) {
	require(AT_INCLUDE_PATH.'header.inc.php');
	$msg->printErrors('SCO_DISABLED');
	require(AT_INCLUDE_PATH.'footer.inc.php');
	exit;
}
*/

require ('header.php');

define('AT_PACKAGE_TYPES', 'scorm-1.2');
$ptypes = explode (',', AT_PACKAGE_TYPES);
$plug = Array();
foreach ($ptypes as $type) {
	include ('./' . $type . '/lib.inc.php');
}

if (sizeOf ($_POST['goners']) > 0) {
	foreach ($ptypes as $type) {
		$plug[$type]->deletePackages ($_POST['goners'], $course_id);
	}
}

$sql = "SELECT	package_id,
		ptype
	FROM    p_packages
	WHERE   course_id = ".$course_id."
	ORDER	BY package_id
	";


$result = mysql_query($sql);

$num = 0;
while ($row = mysql_fetch_assoc($result)) {
	foreach ($plug[$row['ptype']]->getDeleteFormItems ($row['package_id'], $num) as $l) {
		$p .= '<li>' . $l . '</li>' . "\n";
		$num++;
	}
}

if ($num == 0) {
	//require(AT_INCLUDE_PATH.'header.inc.php');
	//$msg->addInfo (NO_PACKAGES);
	//$msg->printAll();
	//require (AT_INCLUDE_PATH.'footer.inc.php');
	exit;
} 
?>


<?php 
//require(AT_INCLUDE_PATH.'header.inc.php');?>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> 
    <td width="5%" >&nbsp;</td>
    <td width="3%" ><img src="../images/_delete.gif" width="16" height="16"></td>
    <td width="92%" ><strong><u>Delete Packages</u></strong></td>
  </tr>
</table>
<br>
<form method="post" action="delete.php">
  <table width="90%" border="0" align="center" cellspacing="0" cellpadding="3" class="tdborder2">
    <tr>
      <td class="hilite"><input type="submit" name="submit"  value="<?php echo 'delete'; ?>" class="button" /></td>
      <td class="hilite">&nbsp;</td>
    </tr>
    <tr> 
      <td width="3%">&nbsp;</td>
      <td width="97%"> <div class="input-form"> 
          <ol>
            <?php echo $p;?> 
          </ol>
          <div class="row buttons"> 
            <input type="hidden" name="course_id" value="<? echo $course_id;?>">
          </div>
        </div></td>
    </tr>
  </table>
</form>



<?php //require (AT_INCLUDE_PATH.'footer.inc.php'); ?>
