<?
	require("include/global_login.php");
	require("calendar/calfunc.php");

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="themes/<?php echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 00px;
}
-->
</style></head>

<body>
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" >
        <!--  Calendar-->
        <tr>
          <td width="19%" valign="top" class="news"><div align="center"><a href="personal/menu.php?calendar=1" target="ws_menu"><img src="images/cal_logo2.gif" width="48" height="47" border="0"></a><br>
                  <a href="personal/menu.php?calendar=1" target="ws_menu"><?php echo $strPersonal_MenuCalendar; ?></a><br>
          </div></td>
          <td width="3%">&nbsp;</td>
          <td width="78%" valign="top" class="news">
            <div align="left">
              <? //  Calendar
			echo  "$Calendar_appointment <br>".date("d-m-Y")."<br><br>";
if($courses=="")$courses=-1;

$username=$person["firstname"]."&nbsp;".$person["surname"];

if($dt!=""){ //if incoming parameter - set startdate=1:st day of month
		$startdate =mktime(0,0,0,date("m",$dt),	1,	date("Y",$dt)); //startdate for month
}else{
		$startdate =mktime(0,0,0,date("m")  ,1,date("Y")); // 1:st of current month
}

$wd_fday=(int)strftime("%w",$startdate);//get daynumber for first in month

if($wd_fday==0){
	$wd_fday=7;
}
	//$startcell = date (UNIX-time) for first day in week where month starts

$startcell=fixday($startdate,-$wd_fday+1);
//get courses for user
/*
if($person["admin"]==1){
		$getcourses=mysql_query("SELECT distinct c.id,c.name FROM courses c, wp WHERE c.active=1 AND wp.courses=c.id ORDER BY c.name;");
}else{
		$getcourses=mysql_query("SELECT distinct c.id,c.name FROM courses c, wp WHERE wp.courses=c.id AND NOT wp.courses=0 AND wp.users=".$person["id"]." AND c.active=1 ORDER BY c.name;");
}

//get shared calendars
*/
//$shared=mysql_query("SELECT c.users,u.firstname,u.surname FROM calendar_share c, users u WHERE c.shared_user=".$person["id"]." AND u.id=c.users;");?>
              <? $daycount = 0; //count the days to get the rows/week right

	$i=0;

	$stop=0;

	if($courses==-1){
/*
		if($person["admin"]==1){

			$moncourses=mysql_query("SELECT DISTINCT c.title,c.time,c.id,c.length,c.appointment FROM wp,calendar c, courses cc WHERE c.time>".$startcell." AND c.time<".(fixday($startcell,42))." AND NOT c.courses=0 AND c.courses=cc.id AND cc.active=1 ORDER BY c.time asc;");

		}else{
*/
			$moncourses=mysql_query("SELECT DISTINCT c.title,c.time,c.id,c.length,c.appointment  FROM wp,calendar c, courses cc WHERE c.time>".$startcell." AND c.time<".(fixday($startcell,42))." AND c.courses=wp.courses AND wp.users=".$person["id"]." AND c.courses=cc.id AND cc.active=1 AND NOT wp.courses=0 ORDER BY c.time asc;");

		//}

		$monpersonal=mysql_query("SELECT DISTINCT c.title,c.time,c.id,c.length,c.appointment  FROM calendar c WHERE c.time>".$startcell." AND c.time<".(fixday($startcell,42))." AND c.users=".$person["id"]." AND c.courses=0 ORDER BY c.time asc;");

		$row=mysql_fetch_array($moncourses);

		$row2=mysql_fetch_array($monpersonal);

	/*}else{

		if($courses==0){
			//personal calendar
			$monpersonal=mysql_query("SELECT DISTINCT c.title,c.time,c.id,c.length,c.appointment FROM calendar c WHERE c.time>".$startcell." AND c.time<".(fixday($startcell,42))." AND c.users=".$person["id"]." AND c.courses=0 ORDER BY c.time asc;");

			$row2=mysql_fetch_array($monpersonal);
		}else{

			//distinct course

			$moncourses=mysql_query("SELECT DISTINCT c.title,c.time,c.id,c.length,c.appointment FROM wp,calendar c WHERE c.time>".$startcell." AND c.time<".(fixday($startcell,42))." AND c.courses=wp.courses AND wp.users=".$person["id"]." AND wp.courses=$courses ORDER BY c.time asc;");

			$row=mysql_fetch_array($moncourses);

		}
*/
	}

	$nextmonth=fixmonth($startdate,1);

	do{

		$t=fixday($startcell,$i);

		$d=date("d",$t);

		$m=date("m",$t);

		$y=date("Y",$t);


		//**************************************** d a y - c e l l *****************************************

	if($courses=="-1"){
			//personal  
			while($row2["time"]<fixday($t,1) && $row2){
			$length = $row2["length"];			
					if($length > 8){
								$s_total = "All day";
					}else{
								$s_total= date("H:i",mktime(date("H",$row2["time"]),date("i",$row2["time"])+$length*60,0,date("m",$row2["time"]),date("d",$row2["time"]),date("Y",$row2["time"])));
					}
					if(date("d-m-Y",$t)==date("d-m-Y",time())){ //  Show Appointment of Today
							if($row2["id"] !=""){
									$app =1; 
									echo " <table  width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
									echo "<tr>";
									echo " <td   width=\"30%\" class=\"fblue\" align=\"left\"><img src=\"images/clock.gif\"  align=\"absmiddle\" border=\"0\">".date("H:i",$row2["time"])." - ".$s_total."</td>";
									echo  "<td  width=\"70%\" align=\"left\">";
									 if($row2["title"] !=""){   echo  htmlspecialchars($row2["title"]);   } 
					 	 			if($row2[appointment] !=""){  echo " : ".$row2[appointment]; }
									echo "</td>";
									echo "</tr>";
									echo " </table>"; 
									//echo "<br>";
								}
						}
						//****************************************************************
			 $row2=mysql_fetch_array($monpersonal);

			} // CLOSE WHILE
			
			
			while($row["time"]<fixday($t,1) && $row){
			$length = $row["length"];			
			
							if($length > 8){
								$s_total = "All day";
							}else{
								$s_total= date("H:i",mktime(date("H",$row["time"]),date("i",$row["time"])+$length*60,0,date("m",$row["time"]),date("d",$row["time"]),date("Y",$row["time"])));
							}

		//Show courses  Today*******************************************************************************
			if(date("d-m-Y",$t)==date("d-m-Y",time())){   //if(date("d-m-Y",$t)=="17-02-2005"){   
								if($row["title"] !=""){
											$app =1;
											echo " <table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
											echo "<tr>";
											echo " <td width=\"30%\" class=\"fblue\"><img src=\"images/clock.gif\" align=\"absmiddle\" border=\"0\">".date("H:i",$row["time"])." - ".$s_total."</td>";
											echo "<td width=\"70%\"><img src=\"images/courses.gif\" align=\"absmiddle\" border=\"0\" >".htmlspecialchars($row["title"])."</td>";   
											echo " </tr>";
											echo " </table>";
								}
				 }
			 $row=mysql_fetch_array($moncourses);

			}
		}
	//**************************************** e n d  d a y - c e l l *****************************************

		$daycount++;

		if($daycount==7){
			$week = strftime("%W",$t);
			$w2=fixday($t,-6);
			 $daycount=0;
		}
	$i++;

		if(($daycount==0) && ($t>$nextmonth)){
			$stop=1;
		}
	}while($stop!=1);
	
	if($app !=1){
			echo $Calendar_Noappointment;
	}

	?>
          </div></td>
        </tr>
    </table>
</body>
</html>
