<?php  
require("../include/global_login.php");
require("syllabus.inc.php");
require("days_calc.php");

$s_prefs = mysql_query("SELECT * FROM syllabus_prefs WHERE courses = $courses");
$row_prefs = mysql_fetch_array($s_prefs);
$pref_id = $row_prefs["id"]; 
$weeks = $row_prefs["weeks"];
$start_date = $row_prefs["start_date"];
$start_hour = $row_prefs["start_hour"];
//echo $start_hour;
$start_min = $row_prefs["start_min"];
$end_hour = $row_prefs["end_hour"];
$end_min = $row_prefs["end_min"];
$length = $row_prefs["length"];
$calendar= $row_prefs["calendar"];
$resources= $row_prefs["resources"];

$s_fac = mysql_query("SELECT f.FAC_NAME, d.NAME_THAI FROM users u,ku_faculty f,ku_department  d WHERE u.id=".$person["id"]." AND u.fac_id = f.id AND u.dept_id = d.id");
$row_fac = mysql_fetch_array($s_fac);
$f_name = $row_fac["FAC_NAME"]; 
$f_dept = $row_fac["NAME_THAI"];
//echo $f_name."    ".$f_dept;
//echo $person["firstname"]."  ".$person["surname"]."<br>";

$qcourses = mysql_query("SELECT * FROM courses WHERE id = $courses");
$row_qcourses = mysql_fetch_array($qcourses);
$qname = $row_qcourses["name"];

	function gen_date($string)	
	{		
		$stringArray = explode("-", $string);		
		$date = mktime(0,0,0,$stringArray[1],$stringArray[2]+7,$stringArray[0]); 		
		$convertedDate = date("Y-m-d", $date);
		return $convertedDate;
	}
	function gen_date_int($string)
	{
		$stringArray = explode("-", $string);		
		$date = mktime(0,0,0,$stringArray[1],$stringArray[2],$stringArray[0]); 		
		return $date;
	}

	function insert_syllabus_userdef($topic,$details,$cid)
	{
		if (trim($topic)!="")
		   {
				mysql_query("INSERT INTO syllabus_userdef VALUES('',".$cid.",\"".trim($topic)."\",\"".trim($details)."\");");
		   }			
	
	}	
	
	function insert_syllabus_activity($courses,$date,$time,$start_hour,$start_min,$l,$topic,$select)
	{
		if (trim($courses)!="")
		   {
				mysql_query("INSERT INTO syllabus_activity (courses,date,time,start_hour,start_min,length,topic,method) VALUES($courses,'".$date."','".$time."',$start_hour,$start_min,$l,'".$topic."',$select);");
		   }				
	}
	
	function update_syllabus_activity($courses,$date,$time,$start_hour,$start_min,$l,$topic,$select,$id)
	{
		if (trim($courses)!="")
		   {
				mysql_query("UPDATE syllabus_activity  SET date = $date, time = '".$time."', start_hour=$start_hour, start_min=$start_min, length=$l, topic='".$topic."', method=$select  WHERE id = $id;");				
		   }				
	}
	
	 if($submit_filling)
	 {
	
			$checksql=mysql_query("SELECT * FROM syllabus where courses=".$courses.";");
			if(mysql_num_rows($checksql)==0)
				{
						mysql_query("INSERT INTO syllabus (courses) 
													 VALUES ($courses);");
				 }
				 else 
				 { 
				    //mysql_query("UPDATE syllabus SET grading='$grading' where courses=$courses;");
				 }
			mysql_query("DELETE FROM syllabus_userdef where courses = $courses");
			
			insert_syllabus_userdef($topic1,$description1,$courses);
			insert_syllabus_userdef($topic2,$description2,$courses);
			insert_syllabus_userdef($topic3,$description3,$courses);
			insert_syllabus_userdef($topic4,$description4,$courses);
			insert_syllabus_userdef($topic5,$description5,$courses);
			insert_syllabus_userdef($topic6,$description6,$courses);
			insert_syllabus_userdef($topic7,$description7,$courses);
			insert_syllabus_userdef($topic8,$description8,$courses);
			insert_syllabus_userdef($topic9,$description9,$courses);
			insert_syllabus_userdef($topic10,$description10,$courses);
			insert_syllabus_userdef($topic11,$description11,$courses);
			insert_syllabus_userdef($topic12,'',$courses);			
			insert_syllabus_userdef($topic13,$description13,$courses);
			
			if ($calendar==1) {			
				$act = mysql_query("select * from syllabus_activity  where courses = $courses order by id"); 
				$row_a=mysql_fetch_array($act);				
				mysql_query("DELETE FROM calendar WHERE courses = $courses AND users=".$person["id"]." AND syllabus_pref_id=$pref_id AND gen=1;");
				for($i=0; $i<$weeks; $i++)			
				{							
					$new_date = gen_date_int($date[$i]);
					//echo $courses." ".$new_date." ".$time[$i]." ".$topic[$i]." ".$select[$i]." ".$row_a["id"]+$i."<br>";
					if ($s_hr[$i] == ""){
						$s_hr[$i] = 0;
					}				
					if ($s_mnt[$i] == ""){
						$s_mnt[$i] = 0;
					}				
					if ($l[$i] == ""){
						$l[$i] = 0;
					}				
					//echo "sss";
					update_syllabus_activity($courses,$new_date, $time[$i], $s_hr[$i], $s_mnt[$i], $l[$i], $topic[$i],$select[$i],$row_a["id"]+$i);								
					$sql = "INSERT INTO calendar (users,title,appointment,time,length,courses,savetime,gen,syllabus_pref_id) VALUES (".$person["id"].",'".$qname."','".$topic[$i]."',".mktime(0+$s_hr[$i],0+$s_mnt[$i],0,date("m",$new_date),date("d",$new_date),date("Y",$new_date)).",".$l[$i].",".$courses.",".time().",1,$pref_id);";				
					mysql_query($sql);
					$id = mysql_insert_id();
					$getdb = mysql_query("SELECT * FROM calendar WHERE id =$id;");
					$row_c=mysql_fetch_array($getdb);
					$apptime = $row_c["time"];
					$length_ = $l[$i];
					if($length_ > 8){
							$s_total = "All day";
					}else{
							$s_total= date("H:i",mktime(date("H",$apptime),date("i",$apptime)+$length_*60,0,date("m",$apptime),date("d",$apptime),date("Y",$apptime)));
					}
					$new_time = date("H:i",$apptime)." - ".$s_total;										
					if ($s_hr[$i] == ""){
						$s_hr[$i] = 0;
					}				
					if ($s_mnt[$i] == ""){
						$s_mnt[$i] = 0;
					}				
					if ($l[$i] == ""){
						$l[$i] = 0;
					}	
					//echo "sss";			
					update_syllabus_activity($courses,$new_date, $new_time, $s_hr[$i], $s_mnt[$i], $l[$i], $topic[$i],$select[$i],$row_a["id"]+$i);										
				}		
			}	else {				
				$act = mysql_query("select * from syllabus_activity  where courses = $courses order by id");
				$row_a=mysql_fetch_array($act);
				for($i=0; $i<$weeks; $i++)			
				{
					//echo $courses." ".$new_date." ".$time[$i]." ".$topic[$i]." ".$select[$i]." ".$row_a["id"]+$i."<br>";																
					$new_date = gen_date_int($date[$i]);		
					//echo $courses." ".$new_date." ".$time[$i]." ".$row_a["id"]+$i."<br>";																			
					update_syllabus_activity($courses,$new_date, $time[$i], 0, 0, 0, $topic[$i],$select[$i],$row_a["id"]+$i);								
				}
			}					
			$mod = @mysql_query("SELECT * FROM modules WHERE syllabus_pref_id = $pref_id;");
			if ((@mysql_num_rows($mod) == 0) AND ($resources == 1))
			{
				$sql = "INSERT INTO modules (modules_type,name,active,courses,users,created,syllabus_pref_id) VALUES (3,'Document',1,$courses,".$person["id"].",".time().",$pref_id);";
				mysql_query($sql);				
				$mod_num=mysql_insert_id();				
				mysql_query("INSERT INTO wp (courses,modules,users) values($courses,".$mod_num.",".$person["id"].");");
				for($i=0; $i<$weeks; $i++)			
				{				
					$name_re = "LECTURE";
					if ($i < 9) {
						$name_re .= "0";	
						$name_re .= $i+1;
					} else {
						$name_re .= $i+1;
					}
					$sql = "INSERT INTO resources (name,folder,courses,modules,users,time) values('$name_re',1,$courses,$mod_num,".$person["id"].",".time().");";				
					mysql_query($sql);				
				}		
			}
									
			print("<script language=javascript> top.ws_menu.location.reload(); </script>");							
			
	 }
	   else if($submit_file)
              {
			
					  } // end if else
			
	   else if($save_all)
				     {							 												
						$checksql=mysql_query("SELECT * FROM syllabus where courses=".$courses.";");
						if(mysql_num_rows($checksql)==0)
							{
									mysql_query("INSERT INTO syllabus (courses) 
																 VALUES ($courses);");
							 }
							 else 
							 { 
								
							 }
						mysql_query("DELETE FROM syllabus_userdef where courses = $courses");
						
						insert_syllabus_userdef($topic1,$description1,$courses);
						insert_syllabus_userdef($topic2,$description2,$courses);
						insert_syllabus_userdef($topic3,$description3,$courses);
						insert_syllabus_userdef($topic4,$description4,$courses);
						insert_syllabus_userdef($topic5,$description5,$courses);
						insert_syllabus_userdef($topic6,$description6,$courses);
						insert_syllabus_userdef($topic7,$description7,$courses);
						insert_syllabus_userdef($topic8,$description8,$courses);
						insert_syllabus_userdef($topic9,$description9,$courses);
						insert_syllabus_userdef($topic10,$description10,$courses);
						insert_syllabus_userdef($topic11,$description11,$courses);
						insert_syllabus_userdef($topic12,$description12,$courses);	   						
					  } // end if else
					  

		$userdef = mysql_query("select su.* from syllabus_userdef su where courses = $courses order by id"); 
		$activity = mysql_query("select * from syllabus_activity  where courses = $courses order by date"); 
		$sel=mysql_query("SELECT * FROM syllabus WHERE courses=$courses;");
		$row=mysql_fetch_array($sel);
		//$pat=":";
		//$arr=split($pat,$row["grading"]);
		$udefine=false;

?>
<html>
<title>Add / Edit Syllabus</title>

<head>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">

<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>

<body bgcolor="#FFFFFF">
<!--
<table width="60%" border="0" align="center" cellpadding="2" cellspacing="1">
  <tr> 
    <td bgcolor="#0080C0"><div align="center"><font color="#FFFFFF"> <b>:-:<a name="top"></a> 
        You can add your syllabus by 3 ways</b> <b> :-:</b></font></div></td>
  </tr>
  <tr>
    <td><font color="#0066FF">1.Filling the syllabus section 
      :</font></td>
  </tr>
  <tr> 
    <td><font color="#0066FF">2. Upload your syllabus file<b> *.doc or *.pdf </b>(prefer 
      .pdf) <br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;in the uploadfile section.(2 Mb max)</font></td>
  </tr>
  <tr> 
    <td><font color="#0066FF">3. Both typing in form and uploadfile.</font></td>
  </tr>
  <tr> 
    <td><hr></td>
  </tr>
</table>
-->

<form method="post" action="" enctype="multipart/form-data" name="syllabus">

  <tr> 
    <div align="center"><b><font color="#0000FF" class="h3">.:: Filling Syllabus 
      Section ::.</font></b> </div>	
  </tr><br>
  <table width="60%" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr> 
      <td width="46%" height="38" > <b>Course Description<a name="typing"></a> 
        and How the Course is Conducted :</b> </td>
    </tr>
    <?		
		$cnt = 0;
		while($rowuser=mysql_fetch_array($userdef))
		{	
		$cnt++;
			if ($cnt !=12) {
			?>
    <tr class="boxcolor"> 
      <td  class="Bcolor" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"> 
        <b>Topic <? echo $cnt; ?> : </b></td>
    </tr>
    <tr class="tdbackground"> 
      <td tyle="border-left: dotted #000000 1px; border-right: dotted #000000 1px;"> 
        <input name="topic<? echo $cnt; ?>" type="text" id="topic<? echo $cnt; ?>" value="<? echo $rowuser["topic_name"]; ?>" size="100"  class="tdbackground1" > 
      </td>
    </tr>
    <tr class="boxcolor"> 
      <td  class="Bcolor"style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">Description 
        <? echo $cnt; ?> : </td>
    </tr>
    <tr  class="tdbackground"> 
      <? switch ($cnt) {
					case 1: ?>
      <td style="border-bottom: dotted #000000 1px;border-left: dotted #000000 1px; border-right: dotted #000000 1px;">
	  <textarea name="description<? echo $cnt; ?>" cols="100" rows="5" wrap="VIRTUAL" id="description<? echo $cnt; ?>" class="pn-text">
	  <? if ($rowuser["details"] != "") {echo $rowuser["details"];} else {if ($f_name != "") {echo $f_name;} else {echo $rowuser["details"];} }?></textarea>
	  </td>
      <?
						break;
					case 2: ?>
      <td style="border-bottom: dotted #000000 1px;border-left: dotted #000000 1px; border-right: dotted #000000 1px;">
	  <textarea name="description<? echo $cnt; ?>" cols="100" rows="5" wrap="VIRTUAL" id="description<? echo $cnt; ?>" class="pn-text">
	  <? 
	  		if ($rowuser["details"] != "") {		
				echo $rowuser["details"];
			} else {
				  if ($f_dept != "") { 
						echo $f_dept; 
				  } else {
						echo $rowuser["details"];
				  }
			} 
	  ?>
	  </textarea>
	  </td>
      <?
						break;
					case 3: ?>
      <td style="border-bottom: dotted #000000 1px;border-left: dotted #000000 1px; border-right: dotted #000000 1px;">
	  <textarea name="description<? echo $cnt; ?>" cols="100" rows="5" wrap="VIRTUAL" id="description<? echo $cnt; ?>" class="pn-text"><? echo $qname; ?></textarea>
	  </td>
      <?
						break;
					case 13: ?>
      <td style="border-bottom: dotted #000000 1px;border-left: dotted #000000 1px; border-right: dotted #000000 1px;">
	  <textarea name="description<? echo $cnt; ?>" cols="100" rows="5" wrap="VIRTUAL" id="description<? echo $cnt; ?>" class="pn-text">	  
	  <? 
	  		if ($rowuser["details"] != "") {		
				echo $rowuser["details"];
			} else {
	  			echo $person["firstname"]."  ".$person["surname"]; 
			}	
	  ?>
	  </textarea>
	  </td>
      <?
						break;	
					default: ?>
      <td style="border-bottom: dotted #000000 1px;border-left: dotted #000000 1px; border-right: dotted #000000 1px;"><textarea name="description<? echo $cnt; ?>" cols="100" rows="5" wrap="VIRTUAL" id="description<? echo $cnt; ?>" class="pn-text"><? echo $rowuser["details"]; ?></textarea></td>
      <?
				} 
			?>
    </tr>
    <?		
			} else { ?>
    <tr class="boxcolor"> 
      <td  class="Bcolor" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">Topic 
        <? echo $cnt; ?> : </td>
    </tr>
    <tr class="tdbackground"> 
      <td   style="border-left: dotted #000000 1px; border-right: dotted #000000 1px;"> 
        <input name="topic<? echo $cnt; ?>" type="text" id="topic<? echo $cnt; ?>" value="<? echo $t[$cnt]; ?>"size="100"  class="tdbackground1"> 
      </td>
    </tr>
    <tr class="boxcolor"> 
      <td class="Bcolor" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"><b>Description 
        <? echo $cnt; ?> : </b></td>
    </tr>
    <tr class="tdbackground"> 
      <td  style="border-bottom: dotted #000000 1px;border-left: dotted #000000 1px; border-right: dotted #000000 1px;"> 
        <table border="0" width="100%" >
          <tr> 
            <td width="6%" align="center" ><strong>ครั้งที่</strong></td>
            <td width="20%" align="center"  ><strong>Date</strong></td>
            <td width="28%" align="center" ><strong>Time</strong></td>
            <td width="32%" align="center" ><strong>Topic</strong></td>
            <td width="14%" align="center"  ><strong>การสอน</strong></td>
          </tr>
          <?
		$activity = mysql_query("SELECT * FROM syllabus_activity WHERE courses=$courses ORDER BY date;");
		$prefs_ = mysql_query("SELECT * FROM syllabus_prefs WHERE courses=$courses;");
		$row_p = mysql_fetch_array($prefs_);
		$i = 0;
		while ($row_activity = mysql_fetch_array($activity))
		{ ?>
          <tr valign="top"> 
            <td align="center" class="blue"><b><? echo $i+1;?></b></td>
            <?
				/*
				if ($i==0) {
					$date_add = date("Y-m-d",$start_date);					
				} else {
					$date_add = gen_date($date_add);					
				}
				*/				
			?>
            <td> 
              <input name="date[ ]" type="text" value="<? echo date("Y-m-d",$row_activity["date"]);?>" ></td>
            <td> 
			  <?
			  if ($calendar != 1) {
			  ?>
              <input name="time[ ]" type="text" value="<? echo $row_activity["time"];?>">              
			  <?
			  }
			  ?>
			  <?
			  if ($calendar == 1) {
			  ?>
              <table width="100%" border="0">
                <tr> 
                  <td>Start Time:</td>
                  <td><select  class="pn-text" name="s_hr[ ]">
                      <option value="00" <? if ($row_activity["start_hour"] != ''){if($row_activity["start_hour"] == '00'){echo "selected";}}else {if ($start_hour == '00'){ echo "selected";}}?>>00</option>
                      <option value="01" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '01'){echo "selected";}}else {if ($start_hour == '01'){ echo "selected";}}?>>01</option>
                      <option value="02" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '02'){echo "selected";}}else {if ($start_hour == '02'){ echo "selected";}}?>>02</option>
                      <option value="03" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '03'){echo "selected";}}else {if ($start_hour == '03'){ echo "selected";}}?>>03</option>
                      <option value="04" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '04'){echo "selected";}}else {if ($start_hour == '04'){ echo "selected";}}?>>04</option>
                      <option value="05" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '05'){echo "selected";}}else {if ($start_hour == '05'){ echo "selected";}}?>>05</option>
                      <option value="06" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '06'){echo "selected";}}else {if ($start_hour == '06'){ echo "selected";}}?>>06</option>
                      <option value="07" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '07'){echo "selected";}}else {if ($start_hour == '07'){ echo "selected";}}?>>07</option>
                      <option value="08" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '08'){echo "selected";}}else {if ($start_hour == '08'){ echo "selected";}}?>>08</option>
                      <option value="09" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '09'){echo "selected";}}else {if ($start_hour == '09'){ echo "selected";}}?>>09</option>
                      <option value="10" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '10'){echo "selected";}}else {if ($start_hour == '10'){ echo "selected";}}?>>10</option>
                      <option value="11" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '11'){echo "selected";}}else {if ($start_hour == '11'){ echo "selected";}}?>>11</option>
                      <option value="12" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '12'){echo "selected";}}else {if ($start_hour == '12'){ echo "selected";}}?>>12</option>
                      <option value="13" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '13'){echo "selected";}}else {if ($start_hour == '13'){ echo "selected";}}?>>13</option>
                      <option value="14" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '14'){echo "selected";}}else {if ($start_hour == '14'){ echo "selected";}}?>>14</option>
                      <option value="15" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '15'){echo "selected";}}else {if ($start_hour == '15'){ echo "selected";}}?>>15</option>
                      <option value="16" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '16'){echo "selected";}}else {if ($start_hour == '16'){ echo "selected";}}?>>16</option>
                      <option value="17" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '17'){echo "selected";}}else {if ($start_hour == '17'){ echo "selected";}}?>>17</option>
                      <option value="18" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '18'){echo "selected";}}else {if ($start_hour == '18'){ echo "selected";}}?>>18</option>
                      <option value="19" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '19'){echo "selected";}}else {if ($start_hour == '19'){ echo "selected";}}?>>19</option>
                      <option value="20" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '20'){echo "selected";}}else {if ($start_hour == '20'){ echo "selected";}}?>>20</option>
                      <option value="21" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '21'){echo "selected";}}else {if ($start_hour == '21'){ echo "selected";}}?>>21</option>
                      <option value="22" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '22'){echo "selected";}}else {if ($start_hour == '22'){ echo "selected";}}?>>22</option>
                      <option value="23" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '23'){echo "selected";}}else {if ($start_hour == '23'){ echo "selected";}}?>>23</option>
                    </select></td>
                  <td><select name="s_mnt[ ]" class="pn-text">
                      <option value="00" <? if($row_activity["start_min"] == '00') {echo "selected";} else { if ($start_min == '00') { echo "selected";}}?>>00</option>
                      <option value="10" <? if($row_activity["start_min"] == '10') {echo "selected";} else { if ($start_min == '10') { echo "selected";}}?>>10</option>
                      <option value="20" <? if($row_activity["start_min"] == '20') {echo "selected";} else { if ($start_min == '20') { echo "selected";}}?>>20</option>
                      <option value="30" <? if($row_activity["start_min"] == '30') {echo "selected";} else { if ($start_min == '30') { echo "selected";}}?>>30</option>
                      <option value="40" <? if($row_activity["start_min"] == '40') {echo "selected";} else { if ($start_min == '40') { echo "selected";}}?>>40</option>
                      <option value="50" <? if($row_activity["start_min"] == '50') {echo "selected";} else { if ($start_min == '50') { echo "selected";}}?>>50</option>
                    </select></td>
                </tr>
                <tr> 
                  <td>Length</td>
                  <td colspan="2"><select name="l[ ]" class="pn-text">
                      <option value="0.25" class="small" <? if($row_activity["length"] == 0.00) {echo "selected";} else { if ($length == 0.00) { echo "selected";}}?>>15min</option>
                      <option value="0.50" class="small" <? if($row_activity["length"] == 0.50) {echo "selected";} else { if ($length == 0.50) { echo "selected";}}?>>30min</option>
                      <option value="0.75" class="small" <? if($row_activity["length"] == 0.75) {echo "selected";} else { if ($length == 0.75) { echo "selected";}}?>>45min</option>
                      <option value="1.00" class="small" <? if($row_activity["length"] == 1.00) {echo "selected";} else { if ($length == 1.00) { echo "selected";}}?>>1hr</option>
                      <option value="1.25" class="small" <? if($row_activity["length"] == 1.25) {echo "selected";} else { if ($length == 1.25) { echo "selected";}}?>>1hr 
                      15min</option>
                      <option value="1.50" class="small" <? if($row_activity["length"] == 1.50) {echo "selected";} else { if ($length == 1.50) { echo "selected";}}?>>1hr 
                      30min</option>
                      <option value="1.75" class="small" <? if($row_activity["length"] == 1.75) {echo "selected";} else { if ($length == 1.75) { echo "selected";}}?>>1hr 
                      45min</option>
                      <option value="2.00" class="small" <? if($row_activity["length"] == 2.00) {echo "selected";} else { if ($length == 2.00) { echo "selected";}}?>>2hr</option>
                      <option value="2.25" class="small" <? if($row_activity["length"] == 2.25) {echo "selected";} else { if ($length == 2.25) { echo "selected";}}?>>2hr 
                      15min</option>
                      <option value="2.50" class="small" <? if($row_activity["length"] == 2.50) {echo "selected";} else { if ($length == 2.50) { echo "selected";}}?>>2hr 
                      30min</option>
                      <option value="2.75" class="small" <? if($row_activity["length"] == 2.75) {echo "selected";} else { if ($length == 2.75) { echo "selected";}}?>>2hr 
                      45min</option>
                      <option value="3.00" class="small" <? if($row_activity["length"] == 3.00) {echo "selected";} else { if ($length == 3.00) { echo "selected";}}?>>3hr</option>
                      <option value="3.25" class="small" <? if($row_activity["length"] == 3.25) {echo "selected";} else { if ($length == 3.25) { echo "selected";}}?>>3hr 
                      15min</option>
                      <option value="3.50" class="small" <? if($row_activity["length"] == 3.50) {echo "selected";} else { if ($length == 3.50) { echo "selected";}}?>>3hr 
                      30min</option>
                      <option value="3.75" class="small" <? if($row_activity["length"] == 3.75) {echo "selected";} else { if ($length == 3.75) { echo "selected";}}?>>3hr 
                      45min</option>
                      <option value="4.00" class="small" <? if($row_activity["length"] == 4.00) {echo "selected";} else { if ($length == 4.00) { echo "selected";}}?>>4hr</option>
                      <option value="4.25" class="small" <? if($row_activity["length"] == 4.25) {echo "selected";} else { if ($length == 4.25) { echo "selected";}}?>>4hr 
                      15min</option>
                      <option value="4.50" class="small" <? if($row_activity["length"] == 4.50) {echo "selected";} else { if ($length == 4.50) { echo "selected";}}?>>4 
                      hr 30min</option>
                      <option value="4.75" class="small" <? if($row_activity["length"] == 4.75) {echo "selected";} else { if ($length == 4.75) { echo "selected";}}?>>4hr 
                      45min</option>
                      <option value="5.00" class="small" <? if($row_activity["length"] == 5.00) {echo "selected";} else { if ($length == 5.00) { echo "selected";}}?>>5hr</option>
                      <option value="5.25" class="small" <? if($row_activity["length"] == 5.25) {echo "selected";} else { if ($length == 5.25) { echo "selected";}}?>>5hr 
                      15min</option>
                      <option value="5.50" class="small" <? if($row_activity["length"] == 5.50) {echo "selected";} else { if ($length == 5.50) { echo "selected";}}?>>5hr 
                      30min</option>
                      <option value="5.75" class="small" <? if($row_activity["length"] == 5.75) {echo "selected";} else { if ($length == 5.75) { echo "selected";}}?>>5hr 
                      45min</option>
                      <option value="6.00" class="small" <? if($row_activity["length"] == 6.00) {echo "selected";} else { if ($length == 6.00) { echo "selected";}}?>>6hr</option>
                      <option value="6.25" class="small" <? if($row_activity["length"] == 6.25) {echo "selected";} else { if ($length == 6.25) { echo "selected";}}?>>6hr 
                      15min</option>
                      <option value="6.50" class="small" <? if($row_activity["length"] == 6.50) {echo "selected";} else { if ($length == 6.50) { echo "selected";}}?>>6hr 
                      30min</option>
                      <option value="6.75" class="small" <? if($row_activity["length"] == 6.75) {echo "selected";} else { if ($length == 6.75) { echo "selected";}}?>>6hr 
                      45min</option>
                      <option value="7.00" class="small" <? if($row_activity["length"] == 7.00) {echo "selected";} else { if ($length == 7.00) { echo "selected";}}?>>7hr</option>
                      <option value="7.25" class="small" <? if($row_activity["length"] == 7.25) {echo "selected";} else { if ($length == 7.25) { echo "selected";}}?>>7hr 
                      15min</option>
                      <option value="7.50" class="small" <? if($row_activity["length"] == 7.50) {echo "selected";} else { if ($length == 7.50) { echo "selected";}}?>>7hr 
                      30min</option>
                      <option value="7.75" class="small" <? if($row_activity["length"] == 7.75) {echo "selected";} else { if ($length == 7.75) { echo "selected";}}?>>7hr 
                      45min</option>
                      <option value="8.00" class="small" <? if($row_activity["length"] == 8.00) {echo "selected";} else { if ($length == 8.00) { echo "selected";}}?>>8hr</option>
                      <option value="9.00" class="small" <? if($row_activity["length"] == 9.00) {echo "selected";} else { if ($length == 9.00) { echo "selected";}}?>>All 
                      day</option>
                    </select></td>
                </tr>
                <tr> 
                  <td colspan="3"><font color="#FF0000" face="MS Sans Serif, Tahoma, sans-serif">ระบุ 
                    Start Time, Length</font></td>
                </tr>
              </table> 
			  <?
			  }
			  ?>
			  </td>
            <td> 
              <input name="topic[ ]" type="text" size="50" value="<? echo $row_activity["topic"];?>" ></td>
            <td> 
              <select name="select[ ]" class="pn-text">
                <option value="0" <? if ($row_activity["method"] == 0) { echo "selected";}?>>---</option>
                <option value="1" <? if ($row_activity["method"] == 1) { echo "";}?>selected>บรรยาย</option>
                <option value="2" <? if ($row_activity["method"] == 2) { echo "selected";}?>>ปฎิบัติ</option>
                <option value="3" <? if ($row_activity["method"] == 3) { echo "selected";}?>>บรรยาย/ปฏิบัติ</option>
                <option value="4" <? if ($row_activity["method"] == 4) { echo "selected";}?>>สอบ</option>
              </select> </td>
          </tr>
          <? 
		  $i++;
			}
			?>
        </table></td>
    </tr>
    <?
			}
		}
		while($cnt<$max_item)
		{	
		$cnt++;
		if ($cnt !=12) {
			?>
    <tr class="boxcolor"> 
      <td  class="Bcolor" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"><b>Topic 
        <? echo $cnt; ?> : </b></td>
    </tr>
    <tr class="tdbackground"> 
      <td style="border-left: dotted #000000 1px; border-right: dotted #000000 1px;"><input name="topic<? echo $cnt; ?>" type="text" id="topic<? echo $cnt; ?>" value="<? echo $t[$cnt]; ?>" size="100"  class="tdbackground1"></td>
    </tr>
    <tr class="boxcolor"> 
      <td class="Bcolor" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"><b>Description 
        <? echo $cnt; ?> : </b></td>
    </tr>
    <tr class="tdbackground"> 
      <? switch ($cnt) {
					case 1: ?>
      <td style="border-bottom: dotted #000000 1px;border-left: dotted #000000 1px; border-right: dotted #000000 1px;">
	  <textarea name="description<? echo $cnt; ?>" cols="100" rows="5" wrap="VIRTUAL" id="description<? echo $cnt; ?>" class="pn-text">
	  <? if ($rowuser["details"] != "") {echo $rowuser["details"];} else {if ($f_name != "") {echo $f_name;} else {echo $rowuser["details"];} }?></textarea>
	  </td>
      <?
						break;
					case 2: ?>
       <td style="border-bottom: dotted #000000 1px;border-left: dotted #000000 1px; border-right: dotted #000000 1px;">
	  <textarea name="description<? echo $cnt; ?>" cols="100" rows="5" wrap="VIRTUAL" id="description<? echo $cnt; ?>" class="pn-text">
	  <? 
	  		if ($rowuser["details"] != "") {		
				echo $rowuser["details"];
			} else {
				  if ($f_dept != "") { 
						echo $f_dept; 
				  } else {
						echo $rowuser["details"];
				  }
			} 
	  ?>
	  </textarea>
	  </td>
      <?
						break;
					case 3: ?>
      <td bgcolor="#d4e2ed" style="border-bottom: dotted #000000 1px;border-left: dotted #000000 1px; border-right: dotted #000000 1px;"><textarea name="description<? echo $cnt; ?>" cols="100" rows="5" wrap="VIRTUAL" id="description<? echo $cnt; ?>" class="pn-text"><? echo $qname; ?></textarea></td>
      <?
						break;
					case 13: ?>
      <td bgcolor="#d4e2ed" style="border-bottom: dotted #000000 1px;border-left: dotted #000000 1px; border-right: dotted #000000 1px;">
	  <textarea name="description<? echo $cnt; ?>" cols="100" rows="5" wrap="VIRTUAL" id="description<? echo $cnt; ?>" class="pn-text">
	  <? if ($rowuser["details"] != "") {	echo $rowuser["details"];} else {echo $person["firstname"]."  ".$person["surname"]; }?>
	  </textarea>
	  </td>
      <?
						break;	
					default: ?>
      <td style="border-bottom: dotted #000000 1px;border-left: dotted #000000 1px; border-right: dotted #000000 1px;"><textarea name="description<? echo $cnt; ?>" cols="100" rows="5" wrap="VIRTUAL" id="description<? echo $cnt; ?>" class="pn-text"><? echo $rowuser["details"]; ?></textarea></td>
      <?
				} 
			?>
    </tr>
    <?
			} else { ?>
    <tr class="boxcolor"> 
      <td  class="Bcolor" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"><b>Topic 
        <? echo $cnt; ?> : </b></td>
    </tr>
    <tr class="tdbackground"> 
      <td  style="border-left: dotted #000000 1px; border-right: dotted #000000 1px;"> 
        <input name="topic<? echo $cnt; ?>" type="text" id="topic<? echo $cnt; ?>"value="<? echo $t[$cnt]; ?>" size="100"  class="tdbackground1"> 
      </td>
    </tr>
    <tr class="boxcolor"> 
      <td  class="Bcolor" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"><b>Description 
        <? echo $cnt; ?> : </b></td>
    </tr>
    <tr class="tdbackground"> 
      <td  style="border-bottom: dotted #000000 1px;border-left: dotted #000000 1px; border-right: dotted #000000 1px;"> 
        <table border="0" width="100%">
          <tr> 
            <td width="6%" align="center"><strong>ครั้งที่</strong></td>
            <td width="20%" align="center" ><strong>Date</strong></td>
            <td width="28%" align="center"><strong>Time</strong></td>
            <td width="32%" align="center"><strong>Topic</strong></td>
            <td width="14%" align="center"><strong>การสอน</strong></td>
          </tr>
          <?
		$activity = mysql_query("SELECT * FROM syllabus_activity WHERE courses=$courses ORDER BY date;");
		$prefs_ = mysql_query("SELECT * FROM syllabus_prefs WHERE courses=$courses;");
		$row_p = mysql_fetch_array($prefs_);
		$i = 0;
		while ($row_activity = mysql_fetch_array($activity))
		{ 
			//echo $row_activity["start_hour"];
		?>
          <tr valign="top"> 
            <td align="center" class="blue"><b><? echo $i+1;?></b></td>
            <?
				/*
				if ($i==0) {
					$date_add = date("Y-m-d",$start_date);					
				} else {
					$date_add = gen_date($date_add);					
				}
				*/				
			?>
            <td> 
              <input name="date[ ]" type="text" value="<? echo date("Y-m-d",$row_activity["date"]);?>"></td>
            <td> 
			  <?
			  if ($calendar != 1) {
			  ?>
              <input name="time[ ]" type="text" value="<? echo $row_activity["time"];?>">
			  <?
			  }
			  ?>
              <?
			  if ($calendar == 1) {
			  ?>
              <table width="100%" border="0">
                <tr> 
                  <td>Start Time:</td>
                  <td><select  class="pn-text" name="s_hr[ ]">
                      <option value="00" <? if ($row_activity["start_hour"] != ''){if($row_activity["start_hour"] == '00'){echo "selected";}}else {if ($start_hour == '00'){ echo "selected";}}?>>00</option>
                      <option value="01" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '01'){echo "selected";}}else {if ($start_hour == '01'){ echo "selected";}}?>>01</option>
                      <option value="02" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '02'){echo "selected";}}else {if ($start_hour == '02'){ echo "selected";}}?>>02</option>
                      <option value="03" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '03'){echo "selected";}}else {if ($start_hour == '03'){ echo "selected";}}?>>03</option>
                      <option value="04" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '04'){echo "selected";}}else {if ($start_hour == '04'){ echo "selected";}}?>>04</option>
                      <option value="05" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '05'){echo "selected";}}else {if ($start_hour == '05'){ echo "selected";}}?>>05</option>
                      <option value="06" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '06'){echo "selected";}}else {if ($start_hour == '06'){ echo "selected";}}?>>06</option>
                      <option value="07" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '07'){echo "selected";}}else {if ($start_hour == '07'){ echo "selected";}}?>>07</option>
                      <option value="08" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '08'){echo "selected";}}else {if ($start_hour == '08'){ echo "selected";}}?>>08</option>
                      <option value="09" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '09'){echo "selected";}}else {if ($start_hour == '09'){ echo "selected";}}?>>09</option>
                      <option value="10" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '10'){echo "selected";}}else {if ($start_hour == '10'){ echo "selected";}}?>>10</option>
                      <option value="11" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '11'){echo "selected";}}else {if ($start_hour == '11'){ echo "selected";}}?>>11</option>
                      <option value="12" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '12'){echo "selected";}}else {if ($start_hour == '12'){ echo "selected";}}?>>12</option>
                      <option value="13" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '13'){echo "selected";}}else {if ($start_hour == '13'){ echo "selected";}}?>>13</option>
                      <option value="14" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '14'){echo "selected";}}else {if ($start_hour == '14'){ echo "selected";}}?>>14</option>
                      <option value="15" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '15'){echo "selected";}}else {if ($start_hour == '15'){ echo "selected";}}?>>15</option>
                      <option value="16" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '16'){echo "selected";}}else {if ($start_hour == '16'){ echo "selected";}}?>>16</option>
                      <option value="17" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '17'){echo "selected";}}else {if ($start_hour == '17'){ echo "selected";}}?>>17</option>
                      <option value="18" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '18'){echo "selected";}}else {if ($start_hour == '18'){ echo "selected";}}?>>18</option>
                      <option value="19" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '19'){echo "selected";}}else {if ($start_hour == '19'){ echo "selected";}}?>>19</option>
                      <option value="20" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '20'){echo "selected";}}else {if ($start_hour == '20'){ echo "selected";}}?>>20</option>
                      <option value="21" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '21'){echo "selected";}}else {if ($start_hour == '21'){ echo "selected";}}?>>21</option>
                      <option value="22" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '22'){echo "selected";}}else {if ($start_hour == '22'){ echo "selected";}}?>>22</option>
                      <option value="23" <? if (($row_activity["start_hour"] != '') && ($row_activity["start_hour"] != 0)){if($row_activity["start_hour"] == '23'){echo "selected";}}else {if ($start_hour == '23'){ echo "selected";}}?>>23</option>
                    </select></td>
                  <td><select name="s_mnt[ ]" class="pn-text">
                      <option value="00" <? if($row_activity["start_min"] == '00') {echo "selected";} else { if ($start_min == '00') { echo "selected";}}?>>00</option>
                      <option value="10" <? if($row_activity["start_min"] == '10') {echo "selected";} else { if ($start_min == '10') { echo "selected";}}?>>10</option>
                      <option value="20" <? if($row_activity["start_min"] == '20') {echo "selected";} else { if ($start_min == '20') { echo "selected";}}?>>20</option>
                      <option value="30" <? if($row_activity["start_min"] == '30') {echo "selected";} else { if ($start_min == '30') { echo "selected";}}?>>30</option>
                      <option value="40" <? if($row_activity["start_min"] == '40') {echo "selected";} else { if ($start_min == '40') { echo "selected";}}?>>40</option>
                      <option value="50" <? if($row_activity["start_min"] == '50') {echo "selected";} else { if ($start_min == '50') { echo "selected";}}?>>50</option>
                    </select></td>
                </tr>
                <tr> 
                  <td>Length</td>
                  <td colspan="2"><select name="l[ ]" class="pn-text">
                      <option value="0.25" class="small" <? if($row_activity["length"] == 0.00) {echo "selected";} else { if ($length == 0.00) { echo "selected";}}?>>15min</option>
                      <option value="0.50" class="small" <? if($row_activity["length"] == 0.50) {echo "selected";} else { if ($length == 0.50) { echo "selected";}}?>>30min</option>
                      <option value="0.75" class="small" <? if($row_activity["length"] == 0.75) {echo "selected";} else { if ($length == 0.75) { echo "selected";}}?>>45min</option>
                      <option value="1.00" class="small" <? if($row_activity["length"] == 1.00) {echo "selected";} else { if ($length == 1.00) { echo "selected";}}?>>1hr</option>
                      <option value="1.25" class="small" <? if($row_activity["length"] == 1.25) {echo "selected";} else { if ($length == 1.25) { echo "selected";}}?>>1hr 
                      15min</option>
                      <option value="1.50" class="small" <? if($row_activity["length"] == 1.50) {echo "selected";} else { if ($length == 1.50) { echo "selected";}}?>>1hr 
                      30min</option>
                      <option value="1.75" class="small" <? if($row_activity["length"] == 1.75) {echo "selected";} else { if ($length == 1.75) { echo "selected";}}?>>1hr 
                      45min</option>
                      <option value="2.00" class="small" <? if($row_activity["length"] == 2.00) {echo "selected";} else { if ($length == 2.00) { echo "selected";}}?>>2hr</option>
                      <option value="2.25" class="small" <? if($row_activity["length"] == 2.25) {echo "selected";} else { if ($length == 2.25) { echo "selected";}}?>>2hr 
                      15min</option>
                      <option value="2.50" class="small" <? if($row_activity["length"] == 2.50) {echo "selected";} else { if ($length == 2.50) { echo "selected";}}?>>2hr 
                      30min</option>
                      <option value="2.75" class="small" <? if($row_activity["length"] == 2.75) {echo "selected";} else { if ($length == 2.75) { echo "selected";}}?>>2hr 
                      45min</option>
                      <option value="3.00" class="small" <? if($row_activity["length"] == 3.00) {echo "selected";} else { if ($length == 3.00) { echo "selected";}}?>>3hr</option>
                      <option value="3.25" class="small" <? if($row_activity["length"] == 3.25) {echo "selected";} else { if ($length == 3.25) { echo "selected";}}?>>3hr 
                      15min</option>
                      <option value="3.50" class="small" <? if($row_activity["length"] == 3.50) {echo "selected";} else { if ($length == 3.50) { echo "selected";}}?>>3hr 
                      30min</option>
                      <option value="3.75" class="small" <? if($row_activity["length"] == 3.75) {echo "selected";} else { if ($length == 3.75) { echo "selected";}}?>>3hr 
                      45min</option>
                      <option value="4.00" class="small" <? if($row_activity["length"] == 4.00) {echo "selected";} else { if ($length == 4.00) { echo "selected";}}?>>4hr</option>
                      <option value="4.25" class="small" <? if($row_activity["length"] == 4.25) {echo "selected";} else { if ($length == 4.25) { echo "selected";}}?>>4hr 
                      15min</option>
                      <option value="4.50" class="small" <? if($row_activity["length"] == 4.50) {echo "selected";} else { if ($length == 4.50) { echo "selected";}}?>>4 
                      hr 30min</option>
                      <option value="4.75" class="small" <? if($row_activity["length"] == 4.75) {echo "selected";} else { if ($length == 4.75) { echo "selected";}}?>>4hr 
                      45min</option>
                      <option value="5.00" class="small" <? if($row_activity["length"] == 5.00) {echo "selected";} else { if ($length == 5.00) { echo "selected";}}?>>5hr</option>
                      <option value="5.25" class="small" <? if($row_activity["length"] == 5.25) {echo "selected";} else { if ($length == 5.25) { echo "selected";}}?>>5hr 
                      15min</option>
                      <option value="5.50" class="small" <? if($row_activity["length"] == 5.50) {echo "selected";} else { if ($length == 5.50) { echo "selected";}}?>>5hr 
                      30min</option>
                      <option value="5.75" class="small" <? if($row_activity["length"] == 5.75) {echo "selected";} else { if ($length == 5.75) { echo "selected";}}?>>5hr 
                      45min</option>
                      <option value="6.00" class="small" <? if($row_activity["length"] == 6.00) {echo "selected";} else { if ($length == 6.00) { echo "selected";}}?>>6hr</option>
                      <option value="6.25" class="small" <? if($row_activity["length"] == 6.25) {echo "selected";} else { if ($length == 6.25) { echo "selected";}}?>>6hr 
                      15min</option>
                      <option value="6.50" class="small" <? if($row_activity["length"] == 6.50) {echo "selected";} else { if ($length == 6.50) { echo "selected";}}?>>6hr 
                      30min</option>
                      <option value="6.75" class="small" <? if($row_activity["length"] == 6.75) {echo "selected";} else { if ($length == 6.75) { echo "selected";}}?>>6hr 
                      45min</option>
                      <option value="7.00" class="small" <? if($row_activity["length"] == 7.00) {echo "selected";} else { if ($length == 7.00) { echo "selected";}}?>>7hr</option>
                      <option value="7.25" class="small" <? if($row_activity["length"] == 7.25) {echo "selected";} else { if ($length == 7.25) { echo "selected";}}?>>7hr 
                      15min</option>
                      <option value="7.50" class="small" <? if($row_activity["length"] == 7.50) {echo "selected";} else { if ($length == 7.50) { echo "selected";}}?>>7hr 
                      30min</option>
                      <option value="7.75" class="small" <? if($row_activity["length"] == 7.75) {echo "selected";} else { if ($length == 7.75) { echo "selected";}}?>>7hr 
                      45min</option>
                      <option value="8.00" class="small" <? if($row_activity["length"] == 8.00) {echo "selected";} else { if ($length == 8.00) { echo "selected";}}?>>8hr</option>
                      <option value="9.00" class="small" <? if($row_activity["length"] == 9.00) {echo "selected";} else { if ($length == 9.00) { echo "selected";}}?>>All 
                      day</option>
                    </select></td>
                </tr>
                <tr> 
                  <td colspan="3"><font color="#FF0000" face="MS Sans Serif, Tahoma, sans-serif">ระบุ 
                    Start Time, Length</font></td>
                </tr>
              </table>
			  <?
			  }
			  ?>
			   </td>
            <td> 
              <input name="topic[ ]" type="text" size="50" value="<? echo $row_activity["topic"];?>"></td>
            <td> 
              <select name="select[ ]" class="pn-text">
                <option value="0" <? if ($row_activity["method"] == 0) { echo "selected";}?>>---</option>
                <option value="1" <? if ($row_activity["method"] == 1) { echo "";}?>selected>บรรยาย</option>
                <option value="2" <? if ($row_activity["method"] == 2) { echo "selected";}?>>ปฎิบัติ</option>
                <option value="3" <? if ($row_activity["method"] == 3) { echo "selected";}?>>บรรยาย/ปฏิบัติ</option>
                <option value="4" <? if ($row_activity["method"] == 4) { echo "selected";}?>>สอบ</option>
              </select> </td>
          </tr>
          <? 
		  $i++;
			}
			?>
        </table></td>
    </tr>
    <?
			}
		}
	?>
    <!--
    <tr bgcolor="#CCFFFF"> 
      <td bgcolor="#C4C4FF" class="res"><b>Grading Policy</b></td>
    </tr>
    <tr> 
      <td height="60" class="small"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td bgcolor="#339900" class="small"> <div align="center">A</div></td>
            <td bgcolor="#66CC00" class="small"> <div align="center">B+</div></td>
            <td bgcolor="#CCFF33" class="small"> <div align="center">B</div></td>
            <td bgcolor="#FFFF66" class="small"> <div align="center">C+</div></td>
            <td bgcolor="#FFCC66" class="small"> <div align="center">C</div></td>
            <td bgcolor="#FF9999" class="small"> <div align="center">D+</div></td>
            <td bgcolor="#FF6666" class="small"> <div align="center">D</div></td>
            <td bgcolor="#CC0033" class="small"> <div align="center">F</div></td>
          </tr>
          <tr> 
            <td bgcolor="#339900"><div align="center"> 
                <input type="text" name="a" size="7" maxlength="30" value="<? echo $arr[0]; ?>">
              </div></td>
            <td bgcolor="#66CC00"><div align="center"> 
                <input type="text" name="bp" size="7" maxlength="30" value="<?  echo $arr[1]; ?>">
              </div></td>
            <td bgcolor="#CCFF33"><div align="center">
                <input type="text" name="b" size="7" maxlength="30" value="<?  echo $arr[2]; ?>">
              </div></td>
            <td bgcolor="#FFFF66"><div align="center"> 
                <input type="text" name="cp" size="7" maxlength="30" value="<?  echo $arr[3]; ?>">
              </div></td>
            <td bgcolor="#FFCC66"><div align="center"> 
                <input type="text" name="c" size="7" maxlength="30" value="<?  echo $arr[4]; ?>">
              </div></td>
            <td bgcolor="#FF9999"><div align="center"> 
                <input type="text" name="dp" size="7" maxlength="30" value="<?  echo $arr[5]; ?>">
              </div></td>
            <td bgcolor="#FF6666"><div align="center"> 
                <input type="text" name="d" size="7" maxlength="30" value="<?  echo $arr[6]; ?>">
              </div></td>
            <td bgcolor="#CC0033"> <div align="center"> 
                <input type="text" name="f" size="7" maxlength="30" value="<?  echo $arr[7]; ?>">
              </div></td>
          </tr>
        </table></td>
    </tr>
	-->
    <tr  class="boxcolor"> 
      <td > <div> 
          <input type="reset" name="Submit4" value="Reset" class="button">
          <input name="submit_filling" type="submit" id="submit_filling" value="Save" class="button">
          <input type="hidden" name="courses" value="<? echo $courses; ?>">
          <input type="hidden" name="weeks" value="<? echo $weeks; ?>">
        </div></td>
    </tr>
  </table>
  </div>
  <!--<div align="center"><b><font color="#008080" class="meny"> .:: Uploadfile section ::.</font></b></div> -->
  <!--		 
  <table width="530" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#A4A4FF">
		<!--
		<tr> 
			  <td bgcolor="#C4C4FF"  class="res"><b>Syllabus file: </b></td>
		</tr>
    <tr> 
		  
      <td height="46" bgcolor="#A4A4FF" class="res"> 
		  <input name="uploadedFile" type="file" id="uploadedFile" value="">
        <b><font color="#69012E">***File type .doc/.pdf   (2 
        Mb max)  ***</font></b> <br>        
		<?php   
				if(($row["syllabus_upload"]!="")&&($row["syllabus_upload"]!=none))
				{	echo " Current File : "; ?>
					<a href="<? echo 	"../files/syllabus/$courses/".$row["newuploadfilename"];?>" target="<? echo "_blank"; ?>">
		<? 		echo $row["syllabus_upload"]; ?></a>
					
		<?		echo "  [ "; ?> 
						 <a href="<? echo "deletesyllabus.php?courses=$courses";?>">
					 <? echo "Delete syllabus file</a> ] ";
				}
	 	?>
	 </td>
    </tr>
	-
    <tr>
      <td bgcolor="#A4A4FF">


			<table width="200">
			  <tr>
				<td class="res"><label>
				  <input type="radio" name="file_target" value="0" <? if($row["new_window"]==0) echo "Checked"; else echo "Unchecked";?>>
				  Show file in same window</label></td>
			  </tr>
			  <tr>
				<td class="res"><label> 
              <input name="file_target" type="radio" value="1" <? if($row["new_window"]==1) echo "Checked"; else echo "Unchecked";?>>
              Show file in new window</label></td>
			  </tr>
			</table> 

        
      </td>
    </tr>
	-->
  <tr> 
      <td bgcolor="#C4C4FF"><!--<input type="reset" name="Submit3" value="Reset">-->
        <!--<input type="submit" name="submit_file" value="Save">--></td>
		<!--
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>

    <tr> 
		  <td align="center" class="meny">
				 <b><font color="#008080"> .::Section save both filling and uploadfile::. </font> </b>
		 &nbsp;</td>
    </tr>
    <tr> 
      <td height="28" bgcolor="#A4A4FF" align="center"> 
        <input type="submit" name="save_all" value="Save All"> 
    </tr>
  </table>
  -->
</form>	
	
  <table width="90%" border="0" align="center">
    <tr>
      <td><div align="right"><a href="#top">top</a></div></td>
    </tr>
  </table>    <br>

</body>
</html>