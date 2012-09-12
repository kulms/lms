<?php
require ("../../include/global_login.php");
/*
 * tools/packages/scorm-1.2/write.php
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


header('Content-Type: text/plain; charset=utf-8');
$L = $_POST['iL'];
$R = $_POST['iR'];
$ic = sizeOf ($L);
for ($i=0; $i<$ic; $i++) {
	$sql = "INSERT INTO p_cmi
		VALUES (0,
			 $_POST[sco_id],
			 ".$person["id"].",
			'$L[$i]', '$R[$i]'
		)";
	$result = mysql_query($sql);
}

$L = $_POST['uL'];
$R = $_POST['uR'];
$uc = sizeOf ($L);

for ($i=0; $i<$uc; $i++) {
	$sql = "UPDATE	p_cmi
		SET 	rvalue    = '$R[$i]'
		WHERE	item_id   = $_POST[sco_id]
		AND	member_id =  ".$person["id"]."
		AND	lvalue    = '$L[$i]'
	";
	$result = mysql_query($sql);

}
echo 'ATutor: '.$ic.' inserted '.$uc.' updated.'."\n";

?>

