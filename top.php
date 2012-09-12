<?php require ("include/global_login.php");

if ($person["language"]==1) $menulang="thai";else $menulang = "eng";

?>
<HTML>
<HEAD>
<script type="text/javascript" language="JavaScript1.1">
<!--
function xppr(im){var i=new Image();i.src='themes/<?echo $theme;?>/images/topmenu/<?echo $menulang;?>/bt'+im;return i;}function xpe(id){x=id.substring(0,id.length-1);document['xpwb'+x].src=eval('xpwb'+id+'.src');if(id.indexOf('e')!=-1)document['xpwb'+x+'e'].src=eval('xpwb'+id+'e.src');}
xpwb0n=xppr('0_0.gif');xpwb0o=xppr('0_1.gif');xpwb0c=xppr('0_2.gif');xpwb1n=xppr('1_0.gif');xpwb1o=xppr('1_1.gif');xpwb1c=xppr('1_2.gif');xpwb2n=xppr('2_0.gif');xpwb2o=xppr('2_1.gif');xpwb2c=xppr('2_2.gif');xpwb3n=xppr('3_0.gif');xpwb3o=xppr('3_1.gif');xpwb3c=xppr('3_2.gif');
 //--></script>
<META content="text/html; charset=windows-874" http-equiv=Content-Type>
<link href="themes/<? echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
margin-left:0px;
}
-->
</style>
</HEAD>
<table id="Table_01"  width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td  rowspan="2" background="images/hearder_03.gif"><img src="../images/hearder_01.gif" width="127" height="107" alt="Kasetsart University"></td>
		<td><img src="images/hearder_02.gif" width="341" height="51" alt="">
         </td><td  rowspan="2" width="100%" background="images/hearder_03.gif"></td>
		<td rowspan="2">
			<img src="images/hearder_04.gif" width="266" height="107" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/hearder_05.gif" width="341" height="56" alt=""></td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" class="tdBotred">
  <tr>
    <td width="53%">
	<table width=0 cellpadding=0 cellspacing=0 border=0><tr><td>
<a href="courses/menu_courses.php" target="ws_menu" onMouseOver='xpe("0o");'onMouseOut='xpe("0n");'onMouseDown='xpe("0c");'><img src="themes/<? echo $theme;?>/images/topmenu/<?=$menulang;?>/bt0_0.gif" name=xpwb0  border=0 alt ="หน้าแรก" ></a></td><td >
<a href="personal/menu.php" target="ws_menu" onMouseOver='xpe("1o");'onMouseOut='xpe("1n");'onMouseDown='xpe("1c");'><img src="themes/<? echo $theme;?>/images/topmenu/<?=$menulang;?>/bt1_0.gif" name=xpwb1 border=0 alt ="ข้อมูลบุคคล"></a></td><td>
<a href="courses/menu_in_courses.php" target="ws_menu" onMouseOver='xpe("2o");'onMouseOut='xpe("2n");'onMouseDown='xpe("2c");'><img src="themes/<? echo $theme;?>/images/topmenu/<?=$menulang;?>/bt2_0.gif" name=xpwb2  border=0 alt ="ข้อมูลรายวิชา"></a></td>
<?php
				if($person["admin"]==1){
				?>
<td>
<a href="system/menu_system.php" target="ws_menu" onMouseOver='xpe("3o");'onMouseOut='xpe("3n");'onMouseDown='xpe("3c");'><img src="themes/<? echo $theme;?>/images/topmenu/<?=$menulang;?>/bt3_0.gif" name=xpwb3  border=0 alt ="ข้อมูลระบบ"></a>
</td>
<?php
				}
				?>
</tr></table>
	 </td>
	<td width="47%" align="right"><?php echo $strTop_LabUser;?> <?php echo $person["firstname"]?> <?php echo $person["surname"] ?><font face="MS Sans Serif" color="#CC0033"> 
      <strong>I</strong> </font> <a href="../<?php echo $_SESSION['path'];?>/include/logout.php" target="_top" class="a12"><?php echo $strTop_LabLogout;?></a></td>
  </tr>
  
</table>
</HTML>
