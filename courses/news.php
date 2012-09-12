<?php  require("../include/global_login.php"); 
				
				 // Update or Insert News				 
				if($Submit)
					{	
							if ($id=="" || $id == none)
							{ 
								if($expired_date)
									mysql_query("INSERT INTO news_courses(txt_news,courses, post_date, expired_date, news_area) VALUES (\"$txt_news\",$courses, now(),'$expired_date',$news_area);");
								else
									mysql_query("INSERT INTO news_courses(txt_news,courses, post_date, expired_date, news_area) VALUES (\"$txt_news\",$courses, now(),(DATE_ADD(now(), INTERVAL 7 DAY)) , $news_area);");
							}
							else
							{
								if($expired_date)
									mysql_query("UPDATE news_courses SET txt_news=\"$txt_news\", post_date=now(),expired_date='$expired_date', news_area=$news_area  WHERE id=$id ");
								else 								
									mysql_query("UPDATE news_courses SET txt_news=\"$txt_news\", post_date=now(),expired_date=(DATE_ADD(now(), INTERVAL 7 DAY)), news_area=$news_area  WHERE id=$id ");
							}
							
							header("Location: activity.php?courses=$courses"); 		  		  
					}
					
					$check=mysql_query("SELECT c.name,c.info,c.fullname,c.section from wp,courses c  
															  WHERE	wp.courses=$courses AND wp.users=".$person["id"]." AND c.id=wp.courses;");

					if(mysql_num_rows($check)==0){
						echo "YOU DO NOT HAVE ACCESS TO THIS COURSE!!!!!";
						exit();
					}else{  $course=mysql_fetch_array($check);	}
					
					if ($id != "" && $id != none)
					{
						$news=mysql_query("SELECT   nc.txt_news, nc.id , nc.expired_date, nc.news_area FROM news_courses nc, courses c  
															WHERE  c.id=nc.courses  AND  nc.courses=$courses AND nc.id=$id;");
								
						$row=mysql_fetch_array($news);
						$txt_news=$row["txt_news"];
						$expired_date=$row["expired_date"];
						$news_area=$row["news_area"];
					}
					
					
?>
<html>
<head>
<title>:: Add news course  ::</title>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="STYLESHEET" type="text/css" href="../themes/blue/style/style.css">!-->
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script language="javascript" src="news/cal.js"></script>
<script language="javascript" src="news/cal_conf.js"></script>
</head>

<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<!--   onLoad="javascript:alert('Warning - - ส่วนของการประกาศข่าวไว้หน้าแรกของระบบเป็นการเก็บข้อมูลลงฐานข้อมูลเท่านั้น ยังไม่ประกาศใช้จริง')"   -->
<!--
			<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
				background="../images/headerbg.gif" height="53">
				  <tr><td class="menu" align="center">
						<b><? echo $course["name"]?>  <? if ($course["section"] !="") {  ?>
						<font color="#ff33ff">[ </font>
						<font color="#99ff99"> หมู่ <? echo $course["section"] ?> </font><font color="#ff33ff">]</font><? }?>
						<br><? echo $course["fullname"]?></b>
				</td></tr>
			</table>
		
<hr width="50%" align="center">
-->
<form name="news_form" method="post">
	<input type="hidden" name="courses" value="<? echo $courses; ?>">
	<input type="hidden" name="id" value="<? echo $id;?>">
   <table width="482" border="0" cellspacing="0" cellpadding="0" align="center" height="53" class="bg1">
    <tr>
      <td class="menu" align="center"><b>Course Annoucement / ประกาศข่าวรายวิชา
        </b> </td>
    </tr>
  </table>
  <br>
  <table width="480" border="0" align="center"   class="tdborder2">
    <tr> 
      <td colspan="2" class="hilite"><b>Announcement Detail / เนื้อความประกาศ :</b></td>
    </tr>
    <tr> 
      <td colspan="2"> <div align="center"> 
          <textarea name="txt_news" cols="80" rows="10" class="pn-text"><?php echo (trim($txt_news)); ?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td colspan="2" class="res"> <div align="center">***If you don't filling 
          expired date, your message will be deleted in 7 days***<br>
          หากไม่กำหนดวันสิ้นสุดการประกาศข่าวนั้นจะมีอายุ 7 วัน</div></td>
    </tr>
    <tr  valign="baseline"> 
      <td width="224" valign="top" class="hilite">
<div align="right"><b>Expired date / วันสิ้นสุดการประกาศุข่าว:</b></div></td>
      <td width="266" class="hilite"><input type="text" name="expired_date" size="10" value="<? echo $expired_date; ?>" onFocus="this.blur(); showCal('Date1')" class="text"> 
        <a href="javascript:showCal('Date1')"><img src="news/date.gif" style="cursor:pointer;cursor:hand" title="Click to select date"  onMouseOver="window.status='Click to select date';return true" onmouseout="window.status='';return true"  width="19" height="17" border="0"></a> 
        <br>
        (Format : yyyy-mm-dd, ex. 2002-12-31)</td>
    </tr>
    <tr> 
      <td valign="top" class="hilite">
<div align="right"><b>Display / รูปแบบการประกาศ:</b></div></td>
      <td class="hilite"> <input name="news_area" type="radio" value="0" <? if($news_area==0 )  echo "checked "; ?> class="r-button">
        ประกาศเฉพาะในรายวิชานี้ <br>
        <input type="radio" name="news_area" value="1" <? if($news_area==1 )  echo "checked "; ?> class="r-button">
        ประกาศสู่หน้าแรกของระบบด้วย</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td class="main"><input name="Submit" type="submit" id="Submit" value="<? echo $strSubmit?>" class="button"> <input type="button"  value="<? echo $strBack;?>" onClick="history.back();" class="button"> 
        <span id="cal1" style="position:relative;">&nbsp;</span></td>
    </tr>
  </table>
   
</form>



</body>
</html>