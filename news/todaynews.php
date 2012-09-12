<?require("../include/global_login.php");
require("calfunc.php");
$category=$person["category"];
//$check=mysql_query("SELECT users FROM news_admin WHERE users=".$person["id"].";");
$check=mysql_query("SELECT id FROM users WHERE id=".$person["id"].";");
switch($category){
        case 2:
                $usertype="forlect";
                break;
        case 3:
                $usertype="forstd";
                break;
        case 4:
               $usertype="forstaff";
                break;
        case 5:
               $usertype="forge";
                break;
        }//end switch
if($onlyday=='yes'){$a='+1';}else{$a='+7';}

if ($category!=1){
$today=mysql_query("SELECT DISTINCT n.news_type,nt.name,nt.id FROM news n, news_type nt WHERE n.users=".$person["id"]." OR n.$usertype=1 AND nt.id=n.news_type ORDER BY nt.id");
//$today=mysql_query("SELECT DISTINCT n.news_type,nt.name,nt.id FROM news n, news_type nt WHERE n.users=".$person["id"]." ORDER BY nt.id");
}else{
$today=mysql_query("SELECT DISTINCT n.news_type,nt.name,nt.id FROM news n, news_type nt WHERE nt.id=n.news_type ORDER BY nt.id");
}
//if($d==""){$d=time();
if($search==''){
    if ($category!=1){
                   $sql = "SELECT * FROM news WHERE news.users=".$person["id"]." OR $usertype=1 AND time < ".fixday($d,$a)." AND time > $d ORDER BY time desc;";
                     }
       else{
                   //    $sql = "SELECT * FROM news WHERE time < ".mktime(24,0,0,date("m",$d),date("d",$d),date("Y",$d))." AND time > ".mktime(0,0,0,date("m",$d),date("d",$d),date("Y",$d))." ORDER BY time desc;";
                       $sql = "SELECT * FROM news WHERE time < ".fixday($d,$a)." AND time > $d ORDER BY time desc;";
          }
}
if($search=="by_id"){
                     $sql="SELECT * FROM news WHERE news_id like '%$news_id%';";
                     }
if($search=="by_name"){
                       $sql="SELECT * FROM news WHERE name like '%$news_name%';";
                       }
if($search=="by_news_in"){
                       $sql="SELECT * FROM news WHERE news_in like '%$news_in%';";
                       }
                       $show = mysql_query($sql);

//$lastday=mktime(-24,0,0,date("m",$d), date("d",$d) ,date("Y",$d));
//$nextday=mktime(24,0,0,date("m",$d), date("d",$d) ,date("Y",$d));
$lastday=fixday($d,-7);
$nextday=fixday($d,+7);
$weeknumber = strftime("%W",$d);
?>
<?// for today news
if ($search==''){
?>
<html>
<head>
        <title>Internal New @ Faculty of Engineering, KU</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#FFFFFF">
<table bgcolor="AntiqueWhite" width="90%" cellpadding="6" cellspacing="0" border="1" align="center">
                <tr><td COLSPAN="4"><table border=0 width="100%">
                        <tr><td class="res"><a href="todaynews.php?d=<?echo $lastday ?>"><img src="../images/hback.gif" border="0"> สัปดาห์ก่อนนี้</a></td>
                        <td colspan="3" class="info"  align="center">ข่าวสัปดาห์ที่ <?echo $weeknumber?> ( <?echo date("d-m-Y",$d) ?> ถึง วันที่ <?echo date("d-m-Y",fixday($d,+7)); ?> )</div></td>
                         <td class="res" align="right"><a href="todaynews.php?d=<?echo $nextday ?>">สัปดาห์ถัดไป <img src="../images/hnext.gif" border="0"></a></td>
                </td>
                </tr>
                <tr>
                        <td class="info" align="center" width="15%"><b>ที่</b></td>
                        <td class="info" align="center"><b>เรื่อง</b></td>
                        <td class="info" align="center" width="60"><b>วันที่</b></td>
                        <td class="info" align="center" width="40"><b>ตอบรับ</b></td>
                        <td class="info" align="center" width="80"><b>สถานะการอ่าน</td>
                </tr>
  <? while($row=mysql_fetch_array($show)) { ?>
     <tr bgcolor="silver"><td class="info" align="right"><?echo $row["news_id"] ?></td>
          <td class="info"><a href="show.php?id=<?echo $row["id"] ?>" target="_blank"><? echo $row["name"] ?></a></td>
          <td class="info"><? echo date("d-m-Y",$row["time"]); ?></a></td>
          <?
$sql=mysql_query("SELECT * FROM news_res WHERE news=".$row["id"]." and users=".$person["id"].";");
$sent=mysql_num_rows($sql);
?>
         <td class="info" align="center">
         <?if ($row["response"]!=0 && $sent==0 && $row["users"] != $person["id"]) {?><a href="reply_form.php?id=<?echo $row["id"] ?>"><font color="cc0099">ต้องตอบรับ <? if ($row["end_date"] != 0) {echo date("m-d-Y",$row["end_date"]); } ?> </font></a> <?}?>
<?         if ($row["response"]!=0 && $sent==1 && $row["users"] != $person["id"]) {?><a href="reply_form.php?id=<?echo $row["id"] ?>"><i>ตอบรับแล้ว </i></a>
         <? } if ($row["response"]!=0 && $row["users"] == $person["id"]) {?><a href="showreply.php?id=<?echo $row["id"] ?>">ผลการตอบรับ</a>
           <? } else{ echo "&nbsp;"; }?></td>
          <td class="info" align="center">
  <?if (mysql_num_rows($check)==1 && $row["users"] == $person["id"] || $person["id"] ==564){
?><a href="add_form.php?id=<?echo $row["id"] ?>" target="ws_main">แก้ใข/ลบข่าวนี้</a> <?}
  $read=mysql_query("SELECT * FROM news_read WHERE users=".$person["id"]." AND news=".$row["id"].";");
      if(mysql_num_rows($read)==1 && $row["users"] != $person["id"]){ ?><i>เปิดอ่านแล้ว</i>
      <? } elseif(mysql_num_rows($read)!=1 && $row["users"] != $person["id"]) { ?><font color="cc0099"> ยังไม่ได้อ่าน </font><? } ?>
           </td>
            </tr>
<?}?>
</table>
</body>
</html>
<? }else{
//for search
?>
<html>
<head>
        <title>Internal New @ Faculty of Engineering, KU</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#FFFFFF">
<table bgcolor="AntiqueWhite" width="90%" cellpadding="6" cellspacing="0" border="1" align="center">
                <tr><td COLSPAN="4"><table border=0 width="100%">
                        <tr><td class="res" colspan="5" align="center">
                        <b>ค้นหาพบ <font color="red"><?echo mysql_num_rows($show);?></font> ข่าวที่เกี่ยวข้อง</b></td></tr>
                <tr>
                        <td class="info" align="center" width="15%"><b>ที่</b></td>
                        <td class="info" align="center"><b>เรื่อง</b></td>
                        <td class="info" align="center" width="60"><b>วันที่</b></td>
                        <td class="info" align="center" width="40"><b>ตอบรับ</b></td>
                        <td class="info" align="center" width="80"><b>สถานะการอ่าน</td>
                </tr>
  <?

  while($row=mysql_fetch_array($show)) { ?>
     <tr bgcolor="silver"><td class="info" align="right"><?echo $row["news_id"] ?></td>
          <td class="info"><a href="show.php?id=<?echo $row["id"] ?>" target="_blank"><? echo $row["name"] ?></a></td>
          <td class="info"><? echo date("d-m-Y",$row["time"]); ?></a></td>
          <?
$sql=mysql_query("SELECT * FROM news_res WHERE news=".$row["id"]." and users=".$person["id"].";");
$sent=mysql_num_rows($sql);
?>
         <td class="info" align="center">
         <?if ($row["response"]!=0 && $sent==0 && $row["users"] != $person["id"]) {?><a href="reply_form.php?id=<?echo $row["id"] ?>"><font color="cc0099">ต้องตอบรับ <? if ($row["end_date"] != 0) {echo date("m-d-Y",$row["end_date"]); } ?> </font></a> <?}?>
<?         if ($row["response"]!=0 && $sent==1 && $row["users"] != $person["id"]) {?><a href="reply_form.php?id=<?echo $row["id"] ?>"><i>ตอบรับแล้ว </i></a>
         <? } if ($row["response"]!=0 && $row["users"] == $person["id"]) {?><a href="showreply.php?id=<?echo $row["id"] ?>">ผลการตอบรับ</a>
           <? } else{ echo "&nbsp;"; }?></td>
          <td class="info" align="center">
  <?if (mysql_num_rows($check)==1 && $row["users"] == $person["id"] || $person["id"] ==564){
?><a href="add_form.php?id=<?echo $row["id"] ?>" target="ws_main">แก้ใข/ลบข่าวนี้</a> <?}
  $read=mysql_query("SELECT * FROM news_read WHERE users=".$person["id"]." AND news=".$row["id"].";");
      if(mysql_num_rows($read)==1 && $row["users"] != $person["id"]){ ?><i>เปิดอ่านแล้ว</i>
      <? } elseif(mysql_num_rows($read)!=1 && $row["users"] != $person["id"]) { ?><font color="cc0099"> ยังไม่ได้อ่าน </font><? } ?>
           </td>
            </tr>
<?}?>
</table>
</body>
</html>

<?}
mysql_close();?>