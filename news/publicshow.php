<?require("../include/global.php");
/*
$checkread=mysql_query("SELECT * FROM news_read WHERE users=".$person["id"]." AND news=$id;");;
if (mysql_num_rows($checkread)==0){
mysql_query("INSERT INTO news_read (news,users,time) VALUES ($id,".$person["id"].",".time().");");
}
*/
//$sql = "SELECT * FROM news WHERE time < ".mktime(24,0,0,date("m",$d),date("d",$d),date("Y",$d))." AND time > ".mktime(0,0,0,date("m",$d),date("d",$d),date("Y",$d))." ORDER BY time desc;";
$file=mysql_query("SELECT * FROM news WHERE id=$id;");
//$file=mysql_query($sql);
$name=mysql_result($file,0,"name");
$filename=mysql_result($file,0,"file");
$text=mysql_result($file,0,"text");
$url=mysql_result($file,0,"url");
$news_id=mysql_result($file,0,"news_id");
$news_in=mysql_result($file,0,"news_in");
$body=mysql_result($file,0,"bodytext");
$end_date=mysql_result($file,0,"end_date");
$res=mysql_result($file,0,"response");
$users=mysql_result($file,0,"users");
$nextpage=mysql_query("SELECT * FROM news_page WHERE from_news=$id;");
$check=mysql_num_rows($nextpage);
$next=mysql_fetch_array($nextpage);
$username=mysql_query("SELECT firstname FROM users WHERE id=".$users.";");
?>
<html>
<head>
        <title>Intranet News @ Faculty of Engineering, KU</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body>
<table border="0" cellspacing="4" cellpadding="1" align="center" bordercolor="#333333" >

<?/*
if (($filename!="") && ($text==0)){?>
 <tr><td class="news" width="14%"><? if ($end_date != 0) {?>ตอบรับภายใน : </td>
     <td class="news" width="70%"><?echo date("d-m-Y",$end_date);} ?></td>
     <td class="news" align="center"><?if ($res==2 && $users!=$person["id"]){?><a href="reply_form.php?id=<?echo $id ?>"><font color="cc0099">ตอบรับ</font></a><? } ?>
<?if ($res==2 && $users==$person["id"]) {?> <a href="showreply.php?id=<?echo $id ?>">ผลการตอบรับ</a><? }
</td>
      </tr>
*/
$filetype=substr($filename,-3); ?>
<tr><td colspan="3" align="center"><?
 if($filetype=="jpg" || $filetype=="gif"){
?>
<img src="../files/news/<?echo $id;?>/<?
if ($pages=="" || $pages==1){echo $filename;}
else{
$get=mysql_query("SELECT file FROM news_page WHERE from_news=$id AND page=$pages;");
echo mysql_result($get,0,"file"); }?>"></td>
 </tr>
<tr><td class="news" colspan="2" width="80%">ทั้งหมด <?if ($check==0){echo "1";}else{echo $check+1;} ?> หน้า
     ไปหน้าที่
<? if ($check==0){$p=1;}
   if ($check!=0){$p=$check+1;}
$a=1;
while($p >= $a){?>
<a href="show.php?id=<?echo $id?>&pages=<?echo $a ?>">
<?echo "$a"?></a>
<?echo "  " ?>
  <?
$a++;
} }elseif($filetype!=""){ echo "<a href=\"../files/news/$id/".$filename."\">"?><font
face="MS Sans Serif" size="2"><?echo "$name" ?></a>
<? } ?>
<span align="right"></span>
</td>
<td class="news" align="right" width="25%"> ผู้ออกข่าว : <font color="red"><? echo mysql_result($username,0,"firstname"); ?>
</font></td>
      </tr>
<? //}
if ($text==1){  ?>
 <?if ($news_id!=""){?>
<tr><td class="res" width="10%"><b>ที่  : </b></td>
     <td class="news" width="80%"><?echo $news_id ?></td>
      <td class="news"></td>
      </tr>
      <? } ?>
<tr><td class="res" width="10%" valign="top"><b> เรื่อง : </b></td>
     <td class="main" width="80%"><?echo nl2br($name) ?></td>
     <td class="news" align="center">&nbsp;</td>
      </tr>
<tr><td class="res" width="10%" valign="top"><b> ข้อความ : </b></td>
     <td class="main" width="80%"><?echo nl2br($body) ?></td>
     <td class="news" align="center">&nbsp;</td>
      </tr>
<?if($end_date != 0){?>
<tr><td class="news" width="10%">ตอบรับภายใน : </td>
     <td class="news" width="80%"><? if ($end_date != 0) {echo date("d-m-Y",$end_date);} ?></td>
     <td class="news" align="center"><?if ($res==2 && $users!=$person["id"]){?><a href="reply_form.php?id=<?echo $id ?>"><font color="cc0099">ตอบรับ</font></a><? } ?>
<?if ($res==2 && $users==$person["id"]) {?> <a href="showreply.php?id=<?echo $id ?>">ผลการตอบรับ</a><? } }?>
</td>
      </tr>
<tr><td class="news" width="10%">ผู้ออกข่าว : </td>
     <td class="news" width="80%"><? echo mysql_result($username,0,"firstname"); ?></td>
     <td class="news"></td>
      </tr>

<?
}
if (($filename=="") && ($text==0)){ ?>
<tr><td class="news" width="10%" >เรื่อง : </td>
     <td class="news"><?echo $name ?></td>
      </tr>
<tr><td class="news">URL :</td>
     <td><a href="<?echo $url ?>" target="_blank"><?echo $url ?></a></td>
 </tr>
<tr><td class="news">ผู้ออกข่าว :</td>
<td class="news"><? echo mysql_result($username,0,"firstname"); ?>
</td>
</tr>
<?
} ?>
</table>
<INPUT TYPE="BUTTON" NAME="Close" VALUE="ปิดข่าวนี้" onclick="window.close()">
</body>
</html>
