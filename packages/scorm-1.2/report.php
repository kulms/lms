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
/*
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
*/

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

$sql_item = "SELECT	item_id,org_id, title
	FROM	p_scorm_1_2_item
	WHERE	org_id = $org_id AND scormtype = 'sco'
	ORDER BY item_id
	";

$result_item = mysql_query($sql_item);
/*
if (mysql_num_rows($result_item) == 0) {
	//require(AT_INCLUDE_PATH.'header.inc.php');
	//$msg->printInfos (NO_PACKAGES);
	//require (AT_INCLUDE_PATH.'footer.inc.php');
	echo "No packages.";
	exit;
} else {
	$row_item = mysql_fetch_assoc($result_item);
	$item_id	= $row_item['item_id'];
	$title_item	= $row_item['title'];
}
*/

//require(AT_INCLUDE_PATH.'header.inc.php');
require('header.php');

?><br> 
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="5%" >&nbsp;</td>
    <td width="3%" ><img src="../../images/_class.gif" width="16" height="16"></td>
    <td width="92%" ><strong><u>Report Usage</u></strong></td>
  </tr>
</table>
<div class="input-form"><br>
  <table width="90%" border="0" align="center" cellspacing="0" cellpadding="3" class="tdborder2">
    <tr> 
      <td colspan="2" class="hilite"><strong><img src="../../images/_class.gif" width="16" height="16"> 
        Title</strong> : <strong><? echo $_pages['packages/scorm-1.2/settings.php']['title'];?></strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<?
	while($row_item = mysql_fetch_array($result_item)){
	?>
    <tr> 
      <td width="2%"><strong><img src="../../images/spacer.gif" width="20"><img src="../../images/cal_plus.gif" width="11" height="13"> 
        </strong></td>
      <td width="98%"><strong>Topic :</strong> <a href="report.php?org_id=<? echo $org_id;?>&item_id=<? echo $row_item['item_id'];?>"><? echo $row_item['title'];?></a></td>
    </tr>
	<?
	if($item_id == 0 || $item_id == ""){
		$sql_total_time = "select i.title,c.member_id,c.lvalue,c.rvalue, u.login, u.firstname, u.surname, u.title as title_name 
						   from p_scorm_1_2_item i, p_cmi c , users u
						   where i.org_id = $org_id and i.item_id = c.item_id and c.item_id = ".$row_item['item_id']."
						   and c.lvalue = 'cmi.core.total_time' and c.member_id = u.id;";
		$result_total_time = mysql_query($sql_total_time);
		while($r_tt=@mysql_fetch_array($result_total_time)){
			$a_tt[ ]  =  $r_tt["rvalue"];
		}
		/*
		foreach($a_tt as $a){
			echo $a."<br>";
		}
		*/
		//mysql_data_seek($result_total_time,0);					   
		$sql_lesson_status = "select i.title,c.member_id,c.lvalue,c.rvalue from p_scorm_1_2_item i, p_cmi c 
						   where i.org_id = $org_id and i.item_id = c.item_id and c.item_id = ".$row_item['item_id']."
						   and c.lvalue = 'cmi.core.lesson_status';";				   
		$result_lesson_status = mysql_query($sql_lesson_status);
		while($r_ls=@mysql_fetch_array($result_lesson_status)){
			$a_ls[ ]  =  $r_ls["rvalue"];
		}
		@mysql_data_seek($result_total_time,0);
	} else {
		$sql_total_time = "select i.title,c.member_id,c.lvalue,c.rvalue, u.login, u.firstname, u.surname, u.title as title_name 
						   from p_scorm_1_2_item i, p_cmi c , users u
						   where i.org_id = $org_id and i.item_id = c.item_id and c.item_id = ".$item_id."
						   and c.lvalue = 'cmi.core.total_time' and c.member_id = u.id;";
		$result_total_time = mysql_query($sql_total_time);
		while($r_tt=@mysql_fetch_array($result_total_time)){
			$a_tt[ ]  =  $r_tt["rvalue"];
		}
		/*
		foreach($a_tt as $a){
			echo $a."<br>";
		}
		*/
		//mysql_data_seek($result_total_time,0);					   
		$sql_lesson_status = "select i.title,c.member_id,c.lvalue,c.rvalue from p_scorm_1_2_item i, p_cmi c 
						   where i.org_id = $org_id and i.item_id = c.item_id and c.item_id = ".$item_id."
						   and c.lvalue = 'cmi.core.lesson_status';";				   
		$result_lesson_status = mysql_query($sql_lesson_status);
		while($r_ls=@mysql_fetch_array($result_lesson_status)){
			$a_ls[ ]  =  $r_ls["rvalue"];
		}
		
		$sql_inter_count = "select i.title,c.member_id,c.lvalue,c.rvalue from p_scorm_1_2_item i, p_cmi c 
						   where i.org_id = $org_id and i.item_id = c.item_id and c.item_id = ".$item_id."
						   and c.lvalue = 'cmi.interactions._count';";
		//echo 	$sql_inter_count."<br>";			   				   
		$result_inter_count = mysql_query($sql_inter_count);
		//echo @mysql_num_rows($result_inter_count)."<br>";
		if(@mysql_num_rows($result_inter_count) != 0){
			while($ric=@mysql_fetch_array($result_inter_count)){
			//echo $ric["member_id"]."<br>";				
				//$inter_count = @mysql_result($result_inter_count,0,"rvalue");
				$inter_count = $ric["rvalue"];
				//echo $inter_count;	
				$sum=0;		
				for($i=0;$i<$inter_count;$i++){
					$sql_inter_result = "select i.title,c.member_id,c.lvalue,c.rvalue from p_scorm_1_2_item i, p_cmi c 
							   where i.org_id = $org_id and i.item_id = c.item_id and c.item_id = ".$item_id."
							   and c.lvalue = 'cmi.interactions.".$i.".result' and c.member_id = ".$ric["member_id"].";";
					//echo $sql_inter_result."<br>";		   
					
					$r_inter_result = mysql_query($sql_inter_result);								
					while($row_inter_result=@mysql_fetch_array($r_inter_result)){
						if($row_inter_result["rvalue"] == "correct"){
						$sum++;
						//$a_sum[ ]  =  $sum;
						}
					}
					
					//$a_sum[ ]  =  $sum;
				}
				//echo $sum."<br>";
				$a_sum[ ]  =  $sum;
			}
		}
		
		@mysql_data_seek($result_total_time,0);
	}
	//echo count($a_sum);
	/*
	while (list($key, $val) = each($a_sum)) {
    echo "$key => $val\n"."<br>";
	}
	*/
	?>
	
    <tr> 
      <td colspan="2">
	  <? if($item_id == $row_item['item_id']){?>
	  	<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tdborder">
          <tr class="boxcolor"> 
            <td width="8%"><div align="center"><strong><font color="#FFFFFF">No.</font></strong></div></td>
            <td width="11%"><div align="center"><strong><font color="#FFFFFF">Login</font></strong></div></td>
            <td width="36%"><div align="center"><strong><font color="#FFFFFF">Firstname-Surname</font></strong></div></td>
            <td width="19%"><div align="center"><strong><font color="#FFFFFF">Total 
                time (hhhh:mm:ss)</font></strong></div></td>
            <td width="26%"><div align="center"><strong><font color="#FFFFFF">Lesson 
                status</font></strong></div></td>
          </tr>
		  <?
		  $i=0;
		  while($r_tt=@mysql_fetch_array($result_total_time)){
		  ?>
          <tr> 
            <td <? if(($i%2) == 0) echo "bgcolor=\"#FFFFFF\"";?>><div align="center"><? echo $i+1;?></div></td>
            <td <? if(($i%2) == 0) echo "bgcolor=\"#FFFFFF\"";?>><div align="center"><? echo $r_tt["login"];?></div></td>
            <td <? if(($i%2) == 0) echo "bgcolor=\"#FFFFFF\"";?>><? echo $r_tt["title_name"].$r_tt["firstname"]." ".$r_tt["surname"];?></td>
            <td <? if(($i%2) == 0) echo "bgcolor=\"#FFFFFF\"";?>><div align="center"><? echo $a_tt[$i];?></div></td>
            <td <? if(($i%2) == 0) echo "bgcolor=\"#FFFFFF\"";?>><div align="center"><? echo $a_ls[$i]; if($a_sum[$i] != "" || $a_sum[$i] == "0") echo "<br>Score: ".$a_sum[$i]."/".$inter_count;?></div></td>
          </tr>
		  <?
		  $i++;
		  }
		  unset($a_tt);
		  unset($a_ls);
		  unset($a_sum);
		  ?>
        </table>
		<? }?>
		</td>
    </tr>	
	<?
	}
	?>
    <tr> 
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>    


</div>

