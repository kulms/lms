<?  	
		session_start();
		$session_id = session_id();		

		require ("../include/global_login.php");
        // require ("../include/global_var.inc.php");
        include ("../include/control_win.js");
		require("../include/online.php");
		online_courses($session_id,$person["id"],$courses,time(),1); 
		require_once ("./classes/User.php");
		require_once ("./classes/UserStorage.php");
		require_once( "./includes/main_functions.php" );
		require_once( "./modules/advisor/advisor.class.php");
			
		$user = UserStorage::lookupById($person["login"]);
		
		session_register( 'user' ); 
		
		//online_courses($session_id,$person["id"],$courses,time(),1);
		
		switch ($user->getCategory()) {
			case 0:
				$uistyle = "admin";
				break;
			case 1:
				$uistyle = "admin";
				break;
			case 2:
				$uistyle = "teacher";
				break;
			case 3:
				$uistyle = "student";
				break;
			default:
				$uistyle = "guest";
			}



                if($userid=="" || $userid==none)
                  {                        $users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
                                    $users_info=mysql_query("SELECT * from users_info WHERE id=".$person["id"]);
                   }else{         $users=mysql_query("SELECT * from users WHERE id=$userid");
                                                   $users_info=mysql_query("SELECT * from users_info WHERE id=$userid");
                                      }    
?>
<html><head><title>:-: Users :-:</title>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->
<script language="JavaScript">
function BrowserInfo()
{          this.screenWidth = screen.availWidth;
          this.screenHeight = screen.availHeight;
              // toolbar_height=toolbar.height;
             //  toolbar_width=toolbar.width;
}
</script>
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings =
	'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(mypage,myname,settings)
}
</script>
<script language="JavaScript">
function mouseOverRow(gId, onOver){	
	if(document.getElementById){
		if(onOver==1)
			//eval("document.getElementById('trE" + gId + "')").bgColor="#FFF5E8";
			eval("document.getElementById('trE" + gId + "')").bgColor="#B3F2EF";
			//eval("document.getElementById('trE" + gId + "')").bgColor="#FFFFFF";					
		else
			eval("document.getElementById('trE" + gId + "')").bgColor="#FFFFFF";		
	}//end if
}//end function
</script>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<?
if( $groups=="" || $groups==none )
{
        $Getlist=mysql_query("SELECT DISTINCT u.id,u.login,u.firstname,u.surname,u.email,u.homepage,uf.skill_interest,uf.address,u.picture, u.lastlogin,u.title,
                                                                                                  uf.picture_width, uf.picture_height,uf.mobile_phone,uf.telephone,uf.p_address,uf.p_telephone,uf.p_mobile_phone
                                                                                                 FROM wp,users u , users_info uf
                                                                                                 WHERE wp.users=u.id AND wp.courses=".$courses." AND wp.cases=0 AND wp.modules=0 AND wp.groups=0
                                                                                                 AND u.active=1 AND uf.id=u.id  AND wp.admin = 0 ORDER BY u.login, wp.admin desc, u.category ");

        $course=mysql_query("SELECT * from courses where id=".$courses);

        // debug here
        if($person["id"] == @mysql_result($course,0,"users"))
                $course_admin = true;
        else
                $course_admin = false;
?>                
				
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"  height="53" class="bg1">
<!--
<table width="643" border="0" cellspacing="0" cellpadding="0" 
	    height="25"  background="../themes/<? echo $theme;?>/images/head_bg.gif">
-->		
	  <tr>
			<td width="21"></td>
			<!--<td width="622"  class="headline" >-->
			<td class="menu" align="center">
		 <b><?php echo  $strCourses_LabCourseMember;?>
              <?php echo $strCourses_LabCourseId;?> 
              <?   echo @mysql_result($course,0,"name");
							 if (@mysql_result($course,0,"section") != "")
							   {    ?>
              (<?php echo $strCourses_LabCourseSection;?> <? echo @mysql_result($course,0,"section"); ?>) 
              <?  }   ?></b>			</td>
	</tr>
</table>


<?   }else{
				/*
                $Getlist=mysql_query("SELECT DISTINCT u.id,u.login,u.email,u.firstname,u.surname,u.homepage,uf.skill_interest, uf.address,u.picture, u.lastlogin,u.title,
                                                                                                          uf.mobile_phone,uf.telephone, uf.picture_width, uf.picture_height,uf.p_address,uf.p_telephone,uf.p_mobile_phone
                                                                                                         FROM  wp,users u, users_info uf
                                                                                                         WHERE wp.users=u.id AND wp.groups=".$groups." AND wp.cases=0 AND wp.modules=0 AND wp.courses=0
                                                                                                         AND u.active=1 AND u.id=uf.id ORDER BY u.login, wp.admin desc, u.category,u.login");
				*/																						 
				 $Getlist=mysql_query("SELECT DISTINCT u.id,u.login,u.email,u.firstname,u.surname,u.homepage,uf.skill_interest, uf.address,u.picture, u.lastlogin,
                                                                                                          uf.mobile_phone,uf.telephone, uf.picture_width, uf.picture_height,uf.p_address,uf.p_telephone,uf.p_mobile_phone
                                                                                                         FROM  wp,users u, users_info uf
                                                                                                         WHERE wp.users=u.id AND wp.groups=".$groups." AND wp.cases=0 AND wp.modules=0 AND wp.courses=0
                                                                                                         AND u.active=1 AND u.id=uf.id AND wp.admin = 0  ORDER BY u.login, wp.admin desc, u.category,u.login");																						 
        $group=mysql_query("SELECT * from groups where id=".$groups);
?>
		
<table width="643" border="0" cellspacing="0" cellpadding="0"
	    height="25"  background="../themes/<? echo $theme;?>/images/head_bg.gif">
	  <tr>
			<td width="21"></td>
			<td width="622"  class="headline" >
		 <b><? echo @mysql_result($group,0,"name"); ?></b>			</td>
	</tr>
</table>

<?  }  ?>
<br>
<div align="center">
<table cellpadding="1" cellspacing="0" bgcolor="#ffffff" width="90%">
        <tr><td align="center">
        <table  cellpadding="2" cellspacing="1"  width="100%" class="tdborder2">
          <tr class="boxcolor">
            <th align="center" valign="top"  class="Bcolor"><?php echo $strPersonal_LabUserName;?></th>
            <th align="center" valign="top" class="Bcolor"><?php echo $strCourses_LabStdName;?></th>
            <th  align="center" valign="top" class="Bcolor"><?php echo $strCourses_LabStdEmail;?></th>
            <th align="center" valign="top" class="Bcolor"><?php echo $strPersonal_LabHomepage;?></th>
            <? if($show=="all")
                                  {  ?><th align="center" valign="top" class="Bcolor"><?php echo $strPersonal_LabPicture;?></th><?          }         ?>
            <th align="center" valign="top" class="Bcolor"><?php echo $strPersonal_LabLastLogin;?></th>
          </tr>
		  <?  
		  $number = 0;
		  $email_list="";
while($row=mysql_fetch_array($Getlist))
{      $email=$row["email"];
		//echo $email;

        if($email_list!="")
                $email_list.=",";

        $email_list.=$email;
        $userlogin=$row["login"];
		$title=$row["title"];
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
				$number++;
				?>
          <tr id="trE<? echo $number;?>" onMouseOver="mouseOverRow('<? echo $number;?>', 1);" onMouseOut="mouseOverRow('<? echo $number;?>', 0);" bgcolor="#FFFFFF">
            <td valign="top"><span class="hilite"><img src="../images/user2.gif"  border="0"> 
              <? echo $userlogin; ?></span></td>
            <td valign="top" > <span class="hilite">
                                <?          // debug here
                                        if($person["admin"]==1 || $course_admin)
                                        {          ?>                           
								<a onClick="NewWindow('../personal/info.php?userid=<? echo $userid; ?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa">
								<? echo $title.$firstname." ".$surname; ?></a>
                                <? }else{         echo  "&nbsp;".$title.$firstname." ".$surname; }
                                        ?>
  <?  if ($show=="all")
                         {         if(  ($p_address==1)  &&  (strlen($address)>3) )
                            {    ?><br><br><b><? echo "Address: "; ?></b><?  echo  $address;  //nl2br($address);
                                 } else{  echo "  ";  }  } ?>

              <?   if($show=="all")
                                                  {  if ( ($telephone!="" ) && ($telephone!=none)  && ($p_telephone==1)  )
                                                         {  ?><br><? echo "<b>Tel. no. : </b>".nl2br($telephone);  }else{ echo " ";  }
                         }   ?>

              <? if(  $show=="all" )
                                                  {   if ( ( $mobile_phone!="") && ($mobile_phone!=none) && ($p_mobile_phone==1)  )
                                                     {  ?><br><? echo "<b>Mobile : </b>".nl2br($mobile_phone);  }else{ echo " "; }
                                                 }   ?>
              </span> </td>

                    <td valign="top" ><div align="center">
					<? if(strlen($email)!=0 || strlen($email2)!=0) { ?>
                        <a href="mailto:<? 
																								//if( ($email!="") && ($email!=none) )
																								if(strlen($email)!=0)
                                                                                                          {           
																										  		echo $email;
                                                                                                          }else{         if(strlen($email2)!=0)
                                                                                                                                                echo $email2; }?>" target="_self"><img src="../images/mail.jpg" width="15" height="11" border="0"></a>
					<? } else {
								echo "-";
						   }
					?>																															
					</div></td>

            <td valign="top"  align="center"> <span class="hilite">
			<?  //echo  $homepage;
				if(strlen($homepage)!=0) {			
	                $homepage=str_replace("http://","",$homepage);  // echo  $homepage;

                //if($homepage!="" || $homepage!=none)
					if(strlen($homepage)!=0)
					{        
					?><a href="http://<? echo $homepage; ?>" target="new_"><?  }  ?><img src="../images/home-blues.gif" width=11 height=16
									alt="" border="0" ><? echo $homepage;  if($homepage!="" || $homepage!=none){  ?></a><?   }
	
													if($show=="all")
													{  ?> <p><span class="info"><?
	
													if(($skill_interest!="")&&($skill_interest!=none))
																			echo "<b>skill / interest :</b>".nl2br($skill_interest);?></span></p>
				  <?          
				  }
			  }  else {
			  	echo "-";
			  }  
			  ?>
			  </span></td>
<? if($show=="all")
       {     ?>
            <td  valign="top">&nbsp;
              <?  if(strlen($picture)>3 && ($picture!=none && $picture!="") )
                            {  /*    if($picture_height!="" && $picture_height!=none)
                                                {          if($picture_height>$screenHeight )
                                                        {                         $height=$picture_height;
                                                                                 $scroll="yes";
                                                        }else{   $height=$screenHeight ;
                                                                                 $scroll="no";
                                                                    }
                                                }
                                                if($picture_width!="" && $picture_width!=none)
                                                {        if($picture_width>$screenWidth)
                                                        {                     $width=$picture_width;
                                                        }else{   $width=$screenWidth;
                                                                           }
                                                } */
                                                        if($picture_width<($screenWidth-50))
                                                         {                          $width=($screenWidth-50);
                                                         } else { $width=$picture_width;
                                                                                }
                                                 if($picture_height<($screenHeight-75))
                                                         {           $height=($screenHeight-75);    $scroll="yes";
                                                         }else{  $height=$picture_height;    $scroll="no";
                                                                  }                ?>
                         <!--<img src="../files/preference/<? echo $row["id"]."/".$picture; ?>" style="cursor:hand" onMouseOver="window.status='Click to view picture!';return true" onMouseOut="window.status='';return true" title="Click to view picture" onClick="MM_openBrWindow('../personal/showpicture.php?id=<? echo $row["id"]; ?>','showpicture','status=no,resizable=yes,scrollbars=<? echo $scroll; ?>,width=<? echo $width;  ?>,height=<? echo $height; ?>')">-->
<img src="../files/preference/<? echo $row["id"]."/".$picture; ?>" style="cursor:hand" onMouseOver="window.status='Click to view picture!';return true" onMouseOut="window.status='';return true" title="Click to view picture" onClick="MM_openBrWindow('../personal/showpicture.php?id=<? echo $row["id"]; ?>','showpicture','status=no,resizable=yes,scrollbars=<? echo $scroll; ?>,width=<? echo $width;  ?>,height=<? echo $height; ?>')">
<?                                 }    ?>
            </td>
<?   }  ?>
            <td  valign="top" align="center">
          <?   if($lastlogin==0)
                          {
                                                echo $strPersonal_LabNeverLogin;
                                 }else{
                                                        echo date("d-m-Y H:i",$lastlogin);
                                                }                ?>
            </td>
          </tr>
          <? } // end while  Getlist?>
        </table>

        <br>
        <table cellpadding="2" cellspacing="0" width="100%" border="0" class="tdborder1">
          <tr bgcolor="#FFFFFF">
            <td width="12%" class="hilite"><b>Total</b></td>
            <td width="88%" class="hilite"><? echo mysql_num_rows($Getlist); ?> คน</td>
          </tr>
        </table>
	</td>
  </tr>
</table>

<?   
	  $droped_member=mysql_query("SELECT u.id AS uid, u.* , uf.*, d.* FROM users as u, drop_courses as d, users_info as uf WHERE d.users=u.id AND d.courses=$courses AND u.id=uf.id ORDER BY u.firstname");

 if(mysql_num_rows($droped_member)!=0){
?>
<br>
<table width="90%" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td align="center" class="blue"><b><?php echo $strCourses_LabStdListWithdraw;?><br>
        </b><br>
	  
<table width="100%" border=0 cellpadding="2" cellspacing="1" class="tdborder1">
    <tr class="boxcolor"> 
            <th width="107" align="center" valign="top"  class="Bcolor"><?php echo $strPersonal_LabUserName;?></th>
            <th width="289" align="center" valign="top"  class="Bcolor"><?php echo $strCourses_LabStdName;?></th>
            <th width="60" align="center" valign="top"  class="Bcolor"><?php echo $strCourses_LabStdEmail;?></th>
            <th width="157" align="center" valign="top"   class="Bcolor"><?php echo $strPersonal_LabHomepage;?></th>
<? if($show=="all")
       {     ?>
            <th width="94" align="center" valign="top"  class="Bcolor"><?php echo $strPersonal_LabPicture;?></th>
<?   }     ?>
            <th width="147" align="center" valign="top"  class="Bcolor"><?php echo $strPersonal_LabLastLogin;?></th>
            <th width="147" align="center" valign="top"  class="Bcolor">ยกเลิกการถอน</th>
    </tr>
<? 	while($row2=@mysql_fetch_array($droped_member)){   ?>
    <tr bgcolor="#FFFFFF"> 
            <td valign="top" class="hilite" ><span class="hilite"><img src="../images/user2.gif"  border="0"></span><? echo $row2["login"]; ?>&nbsp;</td>
	  <td valign="top" class="hilite"><? 
					// debug here
			if($person["admin"]==1 || $course_admin)
			{      ?>	<a href="../personal/menu.php?userid=<? echo $row2["id"]; ?>"><? echo $row2["firstname"]." ".$row2["surname"]; ?></a><? 
			}else{         echo  $row2["firstname"]."  ".$row2["surname"]; 
					 } 
     if ($show=="all")
      {			if( ($row2["reason"]!=null) &&  ($row2["reason"]!="") ){ echo "<br><br><font color=\"blue\"><b>Reason : ".$row2["reason"]."</b></font>"; }		

				if(  ($row2["p_address"]==1)  &&  (strlen($row2["address"])>3) )
                 {    ?><br>
	    <br><b><? echo "Address: "; ?></b><?  echo  $row2["address"];
                 } else{  echo "&nbsp;";  }
	 
				 if ( ($row2["telephone"]!="" ) && ($row2["telephone"]!=none)  && ($row2["p_telephone"]==1)  ){ 
				  ?><br><? echo "<b>Tel. no. : </b>".nl2br($row2["telephone"]);  }else{ echo "&nbsp;";  }
    			
				if ( ( $row2["mobile_phone"]!="") && ($row2["mobile_phone"]!=none) && ($row2["p_mobile_phone"]==1)  ){  			?><br><? echo "<b>Mobile : </b>".nl2br($row2["mobile_phone"]);  }else{ echo "&nbsp;"; }
       }   ?>&nbsp;</td>
      <td valign="top" class="hilite"><a href="mailto:<? 
				if( ($row2["email"]!="") && ($row2["email"]!=none) )
				{           echo $row2["email"]; 
				}else{         if( ($row2["email2"]!="") && ($row2["email2"]!=none) )   	echo $row2["email2"]; 
				         }  ?>" target="_self"><img src="../images/mail.jpg" width="15" height="11" border="0"></a>&nbsp;</td>
      <td valign="top" class="hilite"><span class="small"><?  //echo  $homepage;
               $row2["homepage"]=str_replace("http://","",$row2["homepage"]);  // echo  $homepage;

                if($row2["homepage"]!="" || $row2["homepage"]!=none)
                {        ?><a href="http://<? echo $row2["homepage"]; ?>" target="_blank"><? 
				}        ?><img src="../images/home-blues.gif" width=11 height=16
                                alt="" border="0" ><? echo $row2["homepage"]; 
				if($row2["homepage"]!="" || $row2["homepage"]!=none){  ?></a><?   }
                if($show=="all")
				{	?>
        <p><span class="info"><?
                        if( ($row2["skill_interest"]!="")&&($row2["skill_interest"]!=none) ){ echo "<b>skill / interest :</b>".nl2br($row2["skill_interest"]); } ?></span></p><? 
				}    ?></span></td>
<? if($show=="all")
       {     ?>
      <td  valign="top" class="hilite"><img src="../files/preference/<? echo $row2["id"]."/".$row2["picture"]; ?>" style="cursor:hand" onMouseOver="window.status='Click to view picture!';return true" onMouseOut="window.status='';return true" title="Click to view picture" onClick="MM_openBrWindow('../personal/showpicture.php?id=<? echo $row2["id"]; ?>','showpicture','status=yes,scrollbars=yes,resizable=yes,width=<? echo $row2["width"];  ?>,height=<? echo $row2["height"]; ?>')">&nbsp;</td>
<?   }	?>
      <td align="center"  valign="top" class="hilite"><?
				    	echo date("d-m-Y H:i",$row2["time"]);   ?>&nbsp;</td>
      <td align="center"  valign="top" class="hilite"><a href="#" onClick="javascript:if(confirm('Do you want to re apply for this student?')) {location.href('cancel_drop.php?courses=<? echo $courses;?>&user_id=<? echo $row2["uid"]?>')}"><img src="../images/correct_sign.gif" border="0"></a></td>
    </tr>
<?	  } // END while(droped_member)
?></table>
<?

 if(mysql_num_rows($droped_member)!=0){  ?>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="hilite" align="center">
	  <tr>
			<td width="12%"><b>Total</b></td>
			<td width="88%"><? echo @mysql_num_rows($droped_member); ?> คน</td>
	  </tr>
</table>
<?  } // END  total drop
?>
 </tr>
 </table><br>
<? } // END if
?>

<a href="users.php?courses=<? echo $courses; ?>&groups=<? echo $groups; ?>&show=all" class="main"><?php echo $strCourses_LabShowAllInfo;?></a><br>
<a href="mailto:<? echo $email_list; ?>" class="main"><?php echo $strCourses_LabMailToAll;?></a><br>

<?
$check=mysql_query("SELECT * FROM wp WHERE users=".$person["id"]." AND courses=$courses AND admin=1;");
if($groups!="")
{
        $check2=mysql_query("SELECT users FROM groups where id=$groups;");
        if( (mysql_result($check2,0,"users")==$person["id"] ) ||  ($person["admin"]==1)  || (mysql_num_rows($check)!=0) )
		{   
		?>
                <a href="../groups/admin_users.php?courses=<? echo $courses; ?>&groups=<? echo $groups; ?>" class="main"><?php echo $strCourses_LabEditGroup;?></a>
		<?    
		}
}else{
				
        		if(  ($person["admin"]==1)  ||  ((mysql_num_rows($check)!=0) && ($courses!=0) && ($groups==""))  )
                {    
?>
					<br>
	<!-- Edit Web Services  and Edit Normal-->				

  <table cellpadding="1" cellspacing="2" width="90%" border="0" class="tdborder1">
    <tr> 
      <!--<td width="50%" class="hilite" align="center"><a href="admin_users_auto.php?courses=<? echo $courses; ?>" class="main">Edit Course members Automatic</a></td>-->
      <td width="50%" align="center" bgcolor="#FFFFFF" class="hilite"><a href="admin_users.php?courses=<? echo $courses; ?>" class="main"><?php echo $strCourses_LabEditCourseMembers;?></a></td>
    </tr>
  </table>
  
  <!-- Edit Normal -->
  <!--
  <table cellpadding="1" cellspacing="2" width="90%" border="0" class="std">
    <tr> 
      <td width="50%" class="hilite" align="center"><a href="admin_users.php?courses=<? echo $courses; ?>" class="main">Edit 
        Course members Manual</a></td>
    </tr>
  </table>
	-->				
<?    		
				}
}
mysql_close();
?>
</div>
</body>
</html>