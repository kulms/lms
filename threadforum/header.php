<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<html>
<head>
</head>
<body>
<?
$webboard=new Webboard($topicid,$refid,'','','','','',$id,$courses);
$info=mysql_query("SELECT name,info FROM modules WHERE id=$id");
if($info_row=mysql_fetch_array($info)){
        $info=$info_row["info"];
        $forumname=$info_row["name"];
}
?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
<body bgcolor="#ffffff">
<br>
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
height="53" class="bg1">
  <tr><td class="menu" align="center"><b><?echo $forumname?></b>
    </td>
  </tr>
</table>
<div class="main" align="center"><b><?echo $info?></b></div>
<table width="95%"  border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
	<? 
	if($menu==1){?>
	<table border="0" cellpadding="1" cellspacing="0" align="right">
      <tr>
        <td><b><a href="?id=<? echo $id?>&courses=<? echo $courses;?>#new" class="main" style="font-size:10pt"><img src="../images/postit.gif" width=25 height=25 alt="New thread" border="0"></a></b> &nbsp; <a href="index.php?a=search&id=<? echo $id?>&courses=<? echo $courses;?>" class="main"><img src="../images/search.gif"  align="top" width=25 height=25 border="0" alt="Search"></a> &nbsp; <a href="index.php?a=preferences&id=<? echo $id?>&courses=<? echo $courses;?>" ><img src="../images/prefs.gif" align="absmiddle" width=20 height=16 alt="Edit your preferences for ''<?echo $forumname?>''" border="0"></a></td>
      </tr>
    </table>
	<? } else{?>
	<table border="0" cellpadding="1" cellspacing="0" align="right">
      <tr>
        <td height="35"><a href="?id=<? echo $id?>&courses=<? echo $courses;?>"><img src="images/main.gif" border="0"></a>&nbsp;<b><a href="index.php?id=<? echo $id?>&courses=<? echo $courses;?>#new" class="main" style="font-size:10pt"><img src="images/new_topic.gif" border="0"></a></b>&nbsp;<A HREF="?a=show_topic&topicid=<? echo $webboard->getWId() ?>&refid=<? echo $webboard->getWRefid()?>&id=<? echo $id?>&courses=<? echo $courses ?>&reply=1#new"><img src="images/reply2.gif" border="0"></a> </td>
      </tr>
    </table>
	<? }?>
	</td>
  </tr>
</table>
<hr class="hr_color" width="95%">
</center>
</body>
</html>
