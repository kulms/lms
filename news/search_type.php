<?require("calfunc.php");?>
<html>
<head>
<title>Search Type</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>

<body bgcolor="#FFFFFF">


<table width="50%" border="1" cellspacing="0" cellpadding="0" align="center" class="info" bgcolor="#0033CC" bordercolor="#0033CC">
  <tr>

    <td>

    <table width="100%" border="0" align="center" class="info" bgcolor="#DFFFEF">
      <form name="form1" method="post" action="todaynews.php">
          <tr>
            <td colspan="2">
              <div align="center">ค้นหาตามชื่อเรื่องที่มีคำว่า</div>
            </td>
          </tr>
          <tr>
            <td>
              <div align="right">keyword</div>
            </td>
            <td>
              <input type="text" name="news_name" size="40">
            </td>
          </tr>
          <tr>
            <td>
              <input type="hidden" name="search" value="by_name">
            </td>
            <td>
              <input type="submit" name="Submit2" value="Submit">
            </td>
          </tr>
        </form>
      </table>

    <table width="100%" border="0" align="center" class="info" bgcolor="#FFF2D7">
      <form name="form1" method="post" action="todaynews.php">
          <tr>
            <td colspan="2">
              <div align="center">ค้นหาตามเลขที่หนังสือ</div>
            </td>
          </tr>
          <tr>
            <td width="15%">
              <div align="right">ที่</div>
            </td>
            <td width="85%">
              <input type="text" name="news_id" size="40">
            </td>
          </tr>
          <tr>
            <td width="15%">
              <input type="hidden" name="search" value="by_id">
            </td>
            <td width="85%">
              <input type="submit" name="Submit" value="Submit">
            </td>
          </tr>
</form>
        </table>

    <table width="100%" border="0" align="center" class="info" bgcolor="#FFDFEA">
      <form name="form1" method="post" action="todaynews.php">
          <tr>
            <td colspan="2">
              <div align="center">ค้นหาตามเลขรับที่หนังสือ</div>
            </td>
          </tr>
          <tr>
            <td width="15%">

            <div align="right">รับที่</div>
            </td>
            <td width="85%">
              <input type="text" name="news_in" size="40">
            </td>
          </tr>
          <tr>
            <td width="15%">
              <input type="hidden" name="search" value="by_news_in">
            </td>
            <td width="85%">
              <input type="submit" name="Submit3" value="Submit">
            </td>
          </tr>
        </form>
      </table>
    </td>
    </tr>
<tr>
    <td>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#E3F1C7" class="info">
      <tr>
          <td>
          <div align="center">ค้นหาตามวันที่</div>
        </td>
        </tr>
        <tr>
          <td><?if($courses==""){$courses=-1;}


//*************  C a l e n d a r  ************
//
//                        index.php
//********************************************
//********************************************
//                                 SETUP:                                                '
//********************************************
        //size of grid
$width = 15;
$height = 15;

        //colours:
$border = "#000000";
$weekend = "#f5e6c0";
$head = "#9999cc";
$weekdays = "#CACFF4";
$today = "pink";
$out_of_month = "#dfdfdf";
//********************************************
//********************************************

$username=$person["firstname"]."&nbsp;".$person["surname"];

if($dt!=""){ //if incoming parameter - set startdate=1:st day of month
        $startdate =mktime(0,0,0,date("m",$dt),        1,        date("Y",$dt)); //ger startdatum f๖r mๅnaden
}else{
         $startdate =mktime(0,0,0,date("m")  ,1,date("Y")); // f๖rsta denna mๅnad
}
$wd_fday=(int)strftime("%w",$startdate);//get daynumber for first in month
if($wd_fday==0){
        $wd_fday=7;
}
        //$startcell = date (UNIX-time) for first day in week where month starts
$startcell=fixday($startdate,-$wd_fday+1);

?>
        <script type="text/javascript" language="JavaScript" src="cal.js"></script>
<table cellspacing="0" cellpadding="0" align="CENTER" bgcolor="<?echo $border?>" width="8%">
<tr>
        <td>
                <table border="0" width="100%" cellspacing="1" cellpadding="4" align="CENTER">
                        <tr>
                        <td align="center" colspan="8" bgcolor="<?echo $head?>" class="main">
                        <!-- Beginning of table for years and months -->
                        <table width="100%" cellspacing="5">
                         <tr>
                        <td colspan="8" align="center" bgcolor="<?echo $head?>" class="main">
                        <!-- Beginning of table containing current month and navigation arrows -->
                        <table border="0" width="100%">
                                <tr><td colspan=4 class="main" bgcolor="<?echo $head ?>" align="center"><a href="search_type.php?dt=<?echo fixmonth($startdate,-1) ?>"><font class="small"><img src="../images/back.gif" width=16 height=15 alt="Previous month" border="0"></font></a> &nbsp;
                                                <b><?echo date("M",$startdate) ?>&nbsp;<?echo date("y",$startdate) ?></b> &nbsp; <a href="search_type.php?dt=<?echo fixmonth($startdate,1) ?>&courses=<?echo $courses?>"><img src="../images/next.gif" width=16 height=15 alt="Next month" border="0"></a>
                                        </td>


                                </tr>
                        <!-- End of table containing current month and navigation arrows -->
                        </table>
                        </td>
                </tr>
                <tr bgcolor="<?echo $head ?>">
                        <td align="center" width="<?echo $width ?>" class="main"><b>จันทร์</b></td>
                        <td align="center" width="<?echo $width ?>" class="main"><b>อังคาร</b></td>
                        <td align="center" width="<?echo $width ?>" class="main"><b>พุธ</b></td>
                        <td align="center" width="<?echo $width ?>" class="main"><b>พฤหัส</b></td>
                        <td align="center" width="<?echo $width ?>" class="main"><b>ศุกร์</b></td>
                        <td align="center" width="<?echo $width ?>" class="main"><b><font color="Maroon">เสาร์</font></b></td>
                        <td align="center" width="<?echo $width ?>" class="main"><b><font color="Maroon">อาทิตย์</font></b></td>
                        <td align="center" width="<?echo $width ?>" class="main">สัปดาห์</td>
                </tr>
<?
        $daycount = 0; //count the days to get the rows/week right
        $i=0;
        $stop=0;
        $nextmonth=fixmonth($startdate,1);
        do{
                $t=fixday($startcell,$i);
                $d=date("d",$t);
                $m=date("m",$t);
                $y=date("Y",$t);
                if($daycount==0){
                        ?><tr><?
                }
                $bgcolor=$weekdays;
                if(date("d-m-Y",$t)==date("d-m-Y",time())){
                        $bgcolor=$today;
                }
                if($daycount>4){
                        $bgcolor=$weekend;
                }
                if((date("m",$t)<date("m",$startdate)) ||((date("m",$t)>date("m",$startdate)))){
                        $bgcolor=$out_of_month;
                }
                //**************************************** d a y - c e l l *****************************************
                ?>
                <td bgcolor="<?echo $bgcolor ?>" width="<?echo $width ?>" height="<?echo $height ?>" class="small" valign="top"><a href="todaynews.php?d=<?echo $t ?>&onlyday=yes" target="_blank"><?echo $d ?></a>
                <?
                if($courses=="-1"){
                        //personal
                        while($row2["time"]<fixday($t,1) && $row2){
                                ?>
                        <br><a href="Javascript:ShowIt(<?echo $row2["id"]?>)"><?echo date("H:i",$row2["time"])?>&nbsp;<?echo $row2["title"] ?></a>
                                <?
                                $row2=mysql_fetch_array($monpersonal);
                        }
                        //courses
                        while($row["time"]<fixday($t,1) && $row){
                                ?>
                                <br><a href="Javascript:ShowIt(<?echo $row["id"]?>)"><img src="../images/courses.gif" align="top" border="0"><font color="black"><?echo date("H:i",$row["time"])?>&nbsp;<?echo $row["title"]?></font></a>
                                <?
                                $row=mysql_fetch_array($moncourses);
                        }
                }else{
                        if($courses==0){
                        //personal calendar - only
                                while($row2["time"]<fixday($t,1) && $row2){
                                        ?>
                                <br><a href="Javascript:ShowIt(<?echo $row2["id"]?>)"><?echo date("H:i",$row2["time"])?>&nbsp;<?echo $row2["title"] ?></a>
                                        <?
                                        $row2=mysql_fetch_array($monpersonal);
                                }
                        }//courses, single course
                        else{
                                while($row["time"]<fixday($t,1) && $row){
                                        ?>
                                        <br><a href="Javascript:ShowIt(<?echo $row["id"]?>)"><img src="../images/courses.gif" align="top" border="0"><font color="black"><?echo date("H:i",$row["time"])?>&nbsp;<?echo $row["title"]?></font></a>
                                        <?
                                        $row=mysql_fetch_array($moncourses);
                                }
                        }
                }
                ?></td><?
                //**************************************** e n d  d a y - c e l l *****************************************
                $daycount++;
                if($daycount==7){
                        $week = strftime("%W",$t);
                        $w2=fixday($t,-6);
                ?>
                        <td class="small" width="10" bgcolor="<?echo $weekdays ?>"><a href="todaynews.php?d=<?echo $w2 ?>" target="_blank"><?echo $week ?></a></td>
                </tr>
                <?
                        $daycount=0;
                }
                $i++;
                if(($daycount==0) && ($t>$nextmonth)){
                        $stop=1;
                }
        }while($stop!=1);
 ?>
</table>
</td>
</tr>
</table></td>
        </tr>
      </table>
          <br>
        </td>
  </tr>
  </table>
</body>
</html>