<? 
session_start();
$session_id = session_id();
require("../include/global_login.php");
require("../include/online.php");
online($session_id,time(),$session_id,$person["category"],$person["id"]);
online_courses($session_id,0,0,time(),0);
require("calfunc.php");
//$check=mysql_query("SELECT users FROM news_admin WHERE users=".$person["id"].";");
$check=mysql_query("SELECT id FROM users WHERE id=".$person["id"]." and (category=1 or category=2);");
$todaydate=mktime(0,0,0,date("m"),date("d"),date("Y"));
if($d==""){
$d=mktime(0,0,0,date("m"),date("d"),date("Y"));
 }
$category=$person["category"];
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
if ($category!=1){
$today=mysql_query("SELECT DISTINCT n.news_type,nt.name,nt.id FROM news n, news_type nt WHERE n.$usertype=1 AND nt.id=n.news_type AND time < ".mktime(24,0,0,date("m",$d),date("d",$d),date("Y",$d))." AND time > ".mktime(0,0,0,date("m",$d),date("d",$d),date("Y",$d))." ORDER BY nt.id");
}else{
$today=mysql_query("SELECT DISTINCT n.news_type,nt.name,nt.id FROM news n, news_type nt WHERE nt.id=n.news_type AND time < ".mktime(24,0,0,date("m",$d),date("d",$d),date("Y",$d))." AND time > ".mktime(0,0,0,date("m",$d),date("d",$d),date("Y",$d))." ORDER BY nt.id");
}
$member=mysql_query("SELECT * FROM faculty WHERE login = '".$person["login"]."';");

$n=1;
$lastday=mktime(0,0,0,date("m",$d), $n--,date("Y",$d));
$nextday=mktime(0,0,0,date("m",$d), $n++,date("Y",$d));

$startdate =mktime(0,0,0,date("m",$d),1,date("Y",$d));
$wd_fday=(int)strftime("%w",$todaydate);//get daynumber for first in month
if($wd_fday==0){
$wd_fday=7; }
$thisweek=fixday($todaydate,-$wd_fday+1);
$lastweek=fixday($thisweek,-7);



?>

<html>
<head>
        <title>Internal New @ Faculty of Engineering, KU</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<?if($person["category"]==6){ ?>
<body bgcolor="#CC0033" topmargin="0" leftmargin="0"
text="#FFFF00" link="#FFFF00" vlink="#FFFF00" alink="#FFFF00"
onLoad="top.ws_main.location.href='temp.php';">
<? } if($person["category"]==1 || 2 || 3 || 4 || 5) { ?>
<body bgcolor="#CC0033" topmargin="0" leftmargin="0"
text="#FFFF00" link="#FFFF00" vlink="#FFFF00" alink="#FFFF00"
onLoad="top.ws_main.location.href='todaynews.php?d=<?echo $d?>';">
<br>
<table border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
                <td class="yellow" nowrap>วันที่ <?echo date("d-m-Y",$todaydate)?></a></td>

                 <? if (mysql_num_rows($check)==1) {?>
                <td class="menu" nowrap><a href="select_news_type.php" target="ws_main">
                <img src="../images/tool.gif" width=18 height=16 alt="Add" border="0" align="top"></a></td>
                 <? } ?>
        </tr>

       <tr>
                <td class="menu" nowrap colspan="2"><img src="../images/l_down.gif" width=20 height=16 alt="" border="0"></td>
        </tr>
        <tr>
                <td class="menu" nowrap colspan="2"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><a href="todaynews.php?d=<?echo $thisweek?>" target="ws_main" class="a11"> ข่าวสัปดาห์นี้</a></td>
        </tr>

                </tr>

               <tr>
                <td class="menu" nowrap colspan="2"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><a href="todaynews.php?d=<?echo $lastweek?>" target="ws_main" class="a11"> ข่าวสัปดาห์ก่อน</a></td>
        </tr>
        <tr>
                <td class="menu" nowrap colspan="2"><img src="../images/l_down.gif" width=20 height=16 alt="" border="0"></td>
        </tr>
       <tr>
                <td class="menu" nowrap colspan="2"><img src="../images/l_down.gif" width=20 height=16 alt="" border="0"></td>
        </tr>
        <tr>
                <td class="menu" nowrap colspan="2"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><a href="search_type.php" target="ws_main" class="a11"> ระบบค้นหา</a></td>
        </tr>
<? if($person["login"]=="newsmaster" || $person["login"]=="moo"){?>
               <tr>
                <td class="menu" nowrap colspan="2"><img src="../images/l_down.gif" width=20 height=16 alt="" border="0"></td>
        </tr>
       <tr>
                <td class="menu" nowrap colspan="2"><img src="../images/l_down.gif" width=20 height=16 alt="" border="0"></td>
        </tr>
        <tr>
                <td class="menu" nowrap colspan="2"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><a href="newsadmin.php?showtype=yes" target="ws_main" class="a11"> เพิ่มหมวดหมู่ข่าว</a></td>
        </tr>
        <tr>
                <td class="menu" nowrap colspan="2"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><a href="search_type.php" target="ws_main" class="a11"> ค้นหา</a></td>
        </tr>
<?}?>
        <?/*
        <tr><td class="menu" nowrap colspan="2"><img src="../images/l_down.gif" width=20 height=16 alt="" border="0"></td>
        </tr><tr><td class="menu" nowrap colspan="2"><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><!a href="../calendar/index.php" target="ws_main"><img src="../images/calendar.gif" width=20 height=16" border="0" align="top">ปฏิทินกิจกรรม</a></td>
        </tr>
        */?>
        </table><br><br>
<div class="small" align="center">
</div>
<? } ?>
</body>
</html>
<?mysql_close();?>