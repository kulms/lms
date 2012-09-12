<?  	
		session_start();
		$session_id = session_id();		

		require ("../include/global_login.php");
        include ("../include/control_win.js");
		require("../include/online.php");
		online_courses($session_id,$person["id"],$courses,time(),1); 

		if($userid=="" || $userid==none)
		  {                        
				$users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
				$users_info=mysql_query("SELECT * from users_info WHERE id=".$person["id"]);
		   }else{         
				$users=mysql_query("SELECT * from users WHERE id=$userid");
				$users_info=mysql_query("SELECT * from users_info WHERE id=$userid");
		   }    
?>
<html><head><title>:-: Users :-:</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<script language="JavaScript">
<!--
function BrowserInfo()
{          
		  this.screenWidth = screen.availWidth;
          this.screenHeight = screen.availHeight;
              // toolbar_height=toolbar.height;
             //  toolbar_width=toolbar.width;
}

function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<div align="center">
<table width="600" cellpadding="10" cellspacing="0" bgcolor="#ffffff">
        <tr>
              
      <td align="center"><br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" class="bluenav"> 
              <?
if( $groups=="" || $groups==none )
{
        $Getlist=mysql_query("SELECT DISTINCT u.id,u.login,u.firstname,u.surname,u.email,u.homepage,uf.skill_interest,uf.address,u.picture, u.lastlogin,
                                                                                                  uf.picture_width, uf.picture_height,uf.mobile_phone,uf.telephone,uf.p_address,uf.p_telephone,uf.p_mobile_phone
                                                                                                 FROM wp,users u , users_info uf
                                                                                                 WHERE wp.users=u.id AND wp.courses=".$courses." AND wp.cases=0 AND wp.modules=0 AND wp.groups=0
                                                                                                 AND u.active=1 AND u.category=3 AND uf.id=u.id  ORDER BY u.login, wp.admin desc, u.category ");

        $course=mysql_query("SELECT * from courses where id=".$courses);

        // debug here
        if($person["id"] == @mysql_result($course,0,"users"))
                $course_admin = true;
        else
                $course_admin = false;
?>
              <font size="5"> <strong> 
              <?   echo @mysql_result($course,0,"name");
                         if (@mysql_result($course,0,"section") != "")
                           {    ?>
              (หมู่ <? echo @mysql_result($course,0,"section"); ?>)</strong></font> 
              <?  }   ?>
              <?   
}else{
                $Getlist=mysql_query("SELECT DISTINCT u.id,u.login,u.email,u.firstname,u.surname,u.homepage,uf.skill_interest, uf.address,u.picture, u.lastlogin,
                                                                                                          uf.mobile_phone,uf.telephone, uf.picture_width, uf.picture_height,uf.p_address,uf.p_telephone,uf.p_mobile_phone
                                                                                                         FROM  wp,users u, users_info uf
                                                                                                         WHERE wp.users=u.id AND wp.groups=".$groups." AND wp.cases=0 AND wp.modules=0 AND wp.courses=0
                                                                                                         AND u.active=1 AND u.category=3 AND u.id=uf.id ORDER BY u.login, wp.admin desc, u.category,u.login");
        $group=mysql_query("SELECT * from groups where id=".$groups);
?>
              <?  }  ?>
            </td>
          </tr>
        </table> 
        <br>
        <table border=0 cellpadding="2" cellspacing="0" width="100%" >
          <tr> 
            <td width="77" align="center"   class="mini"  style="border-bottom: solid #2D649B 2px;border-top: solid #2D649B 2px;"><b>Login</b></td>
            <td width="131" align="center"  class="mini" style="border-bottom: solid #2D649B 2px;border-top: solid #2D649B 2px;"><b>Name</b></td>
            <td width="280" align="center"  class="mini" style="border-bottom: solid #2D649B 2px;border-top: solid #2D649B 2px;"><b>Homepage</b></td>           
            <td width="74" align="center"  class="mini"  style="border-bottom: solid #2D649B 2px;border-top: solid #2D649B 2px;"><b>Score</b></td>
          </tr>
          <?  
		$email_list="";
		$color = 0;
		$bgcolor = "#d4e2ed";
		while($row=mysql_fetch_array($Getlist))
		{      
			$email=$row["email"];
	
			if($email_list!="")
			   $email_list.=",";
	
			$email_list.=$email;
			$userlogin=$row["login"];
			$firstname=$row["firstname"];
			$surname=$row["surname"];
	
			$homepage=$row["homepage"];
			$address=$row["address"];
			$p_address=$row["p_address"];
			$telephone=$row["telephone"];
			$p_telephone=$row["p_telephone"];
			$mobile_phone=$row["mobile_phone"];
			$p_mobile_phone=$row["p_mobile_phone"];
			$skill_interest=$row["skill_interest"];
			$lastlogin=$row["lastlogin"];
			$picture=$row["picture"];
			$picture_width=$row["picture_width"];
			$picture_height=$row["picture_height"];
			$userid=$row["id"];    
		?>
		<? if ($color==0) {?>
          <tr> 
            <td  style="border-bottom: dotted #2D649B 1px;" align="center" class="mini"><span><? echo $userlogin; ?></span></td>
            <td style="border-bottom: dotted #2D649B 1px;" class="mini"> <span > 
              <?          
			  // debug here
				if($person["admin"]==1 || $course_admin)
				{          
			   ?>
              <!--<a href="../personal/menu.php?userid=<? echo $userid; ?>"><? echo $firstname." ".$surname; ?></a> -->
			  <? echo $firstname." ".$surname; ?>
              <? 
			  }else
			  {         
			  		echo  "&nbsp;".$firstname." ".$surname; 
			   }                                        
			  ?>
			  </span> 
			</td>
            <td style="border-bottom: dotted #2D649B 1px;" class="mini"> <span > 
              <?  //echo  $homepage;
               $homepage=str_replace("http://","",$homepage);  // echo  $homepage;
                if($homepage!="" || $homepage!=none)
                {        
			   ?>
              <a href="http://<? echo $homepage; ?>" target="new_" class="a3"> 
               <?  
			  	 }  
			    ?>
              <img src="../images/home-blues.gif" width=11 height=16
               alt="" border="0" > <? echo "http://".$homepage;  ?></a> 
              </span></td>            
            <td class="small" valign="top" style="border-bottom: dotted #2D649B 1px;" align="center"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr align="center">
				  <?
				  		$eval_m = "SELECT * FROM evaluate_match WHERE eval_by =".$person["id"]." AND status=1;"; 
						$eval_r= mysql_query($eval_m);
						while ($row_m=mysql_fetch_array($eval_r)) {
				  ?>
				  <? if (($row_m["eval_owner"]==$userid) || ($person["category"]==2)) {?>
                  <td class="mini"><a href="score_form.php?belong=<? echo $userid;?>&courses=<? echo $courses;?>" onClick="MM_popupMsg('คุณสามารถให้คะแนนได้เพียง 1 ครั้งเท่านั้น')"><img src="../images/vt_2.gif" width="16" height="16" border="0"><br>
                    score </a></td>
				  <? }
				  }
				  ?>
				  <? if (($person["category"]==2)) {?>
                  <td class="mini"><a href="score_form.php?belong=<? echo $userid;?>&courses=<? echo $courses;?>" ><img src="../images/vt_2.gif" width="16" height="16" border="0"><br>
                    score </a></td>
				  <? } ?>
				  <? if (($person["id"]==$userid) || ($person["category"]==2)) {?>
                  <td class="mini"><a href="score_view.php?belong=<? echo $userid;?>"><img src="../images/vt_1.gif" width="16" height="16" border="0"><br>
                    result </a></td>
				  <? }?>
                </tr>
              </table> </td>
          </tr>		  
          <? 
		  $color = 1;
		  } else {
		  ?>
		  <tr bgcolor="<? echo $bgcolor;?>"> 
            <td  style="border-bottom: dotted #2D649B 1px;" align="center" class="mini"><span ><? echo $userlogin; ?></span></td>
            <td  style="border-bottom: dotted #2D649B 1px;" class="mini"> <span > 
              <?          
			  // debug here
				if($person["admin"]==1 || $course_admin)
				{          
			   ?>
              <!--<a href="../personal/menu.php?userid=<? echo $userid; ?>"><? echo $firstname." ".$surname; ?></a>-->
			  <? echo $firstname." ".$surname; ?> 
              <? 
			  }else
			  {         
			  		echo  "&nbsp;".$firstname." ".$surname; 
			   }                                        
			  ?>
			  </span> 
			</td>
            <td  style="border-bottom: dotted #2D649B 1px;" class="mini"> <span> 
              <?  //echo  $homepage;
               $homepage=str_replace("http://","",$homepage);  // echo  $homepage;
                if($homepage!="" || $homepage!=none)
                {        
			   ?>
              <a href="http://<? echo $homepage; ?>" target="new_" class="a3"> 
               <?  
			  	 }  
			    ?>
              <img src="../images/home-blues.gif" width=11 height=16
               alt="" border="0" > <? echo "http://".$homepage;  ?></a> 
              </span></td>            
            <td class="small" valign="top" style="border-bottom: dotted #2D649B 1px;" align="center"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr align="center"> 
				 <?
				  		$eval_m = "SELECT * FROM evaluate_match WHERE eval_by =".$person["id"]." AND status=1;"; 
						$eval_r= mysql_query($eval_m);
						while ($row_m=mysql_fetch_array($eval_r)) {
				  ?>
				  <? if (($row_m["eval_owner"]==$userid) || ($person["category"]==2)) {?>
                  <td class="mini"><a href="score_form.php?belong=<? echo $userid;?>&courses=<? echo $courses;?>" onClick="MM_popupMsg('คุณสามารถให้คะแนนได้เพียง 1 ครั้งเท่านั้น')"><img src="../images/vt_2.gif" width="16" height="16" border="0"><br>
                    score </a></td>
				  <? }
				  }
				  ?>
				  <? if (($person["category"]==2)) {?>
                  <td class="mini"><a href="score_form.php?belong=<? echo $userid;?>&courses=<? echo $courses;?>" ><img src="../images/vt_2.gif" width="16" height="16" border="0"><br>
                    score </a></td>
				  <? } ?>
                  <? if (($person["id"]==$userid) || ($person["category"]==2)) {?>
                  <td class="mini"><a href="score_view.php?belong=<? echo $userid;?>"><img src="../images/vt_1.gif" width="16" height="16" border="0"><br>
                    result </a></td>
				  <? }?>
                </tr>
              </table> </td>
          </tr>
		  <?
		  $color = 0;
		  }
		  
		  } 
		  // end while  Getlist
		  ?>
        </table>

       <table cellpadding="0" cellspacing="0" width="100%" border="0" >
          <tr>
            <td width="12%" style="border-bottom: solid #2D649B 2px;border-top: solid #2D649B 2px;" class="bblack"><b>Total</b></td>
            <td width="88%" style="border-bottom: solid #2D649B 2px;border-top: solid #2D649B 2px;" class="bblack"><? echo mysql_num_rows($Getlist); ?> คน</td>
          </tr>
        </table>
	</td>
  </tr>
</table>
<? if ($person["category"]==2) {?>
  <br>
  <table width="600" border="0" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
    <tr align="center"> 
      <td width="100%" bgcolor="#739FC4" ><strong><a href="score_result.php?courses=<? echo $courses;?>" class="mini">Show 
        Result</a></strong></td>
    </tr>
  </table>
  <? }?>
  <br>
<br>
</div>
</body>
</html>