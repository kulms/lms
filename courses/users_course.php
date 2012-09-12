<?  			
		session_start();
		$session_id = session_id();		
	
		require ("../include/global_login.php");        
		require("../include/online.php");
		include ("../include/control_win.js");
		online($session_id,time(),$session_id,$person["category"],$person["id"]);
		online_courses($session_id,0,0,time(),0);
		require_once ("./classes/User.php");
		require_once ("./classes/UserStorage.php");
		require_once( "./includes/main_functions.php" );
		require_once( "./modules/advisor/advisor.class.php");
												
		$user = UserStorage::lookupById($person["login"]);
		
		session_register( 'user' ); 
		
		$sql = mysql_query("SELECT * FROM wp WHERE courses = $courses;");
		if(mysql_num_rows($sql) > 1){
			//echo "do nothing !!!!";
		} else {
			//echo "call web services";
			$row_courses = mysql_fetch_array($sql);
				if ($row_courses["advisor"] == 1) {
				require_once('../nusoap/nusoap.php');
				$client = new soapclient('https://portal.ku.ac.th/cpestj/advisor-kaset-oracle-server.php');
									
				$params = array('login' => $person["login"]); 	
						
					if($courses != "" || $courses == 0)
					{
						$response = $client->call('getKuAdvisorStd', $params);
					}
					
					if($client->fault)
					{
						print "ERROR! ".$client->faultstring."\n";
					}
					else
					{
						if($response)
						{
							/*
							print "<table border='0' class='std' cellpadding=\"2\" cellspacing=\"1\" width=\"60%\" align=\"center\">\n";
							print "<tr>
											<th>รหัสนิสิต</th><th>คำนำหน้าชื่อ</th><th>ชื่อ</th><th>นามสกุล</th><th>รหัสสาขา</th>
										</tr>\n";
							*/
										
							$i=0;
							
							foreach($response[0] as $res_row)			
							{
								/*						
								print "<tr>\n
												<td class=\"hilite\">".$res_row['std_id']."</td>\n
												<td class=\"hilite\">".$res_row['std_title']."</td>\n
												<td class=\"hilite\">".$res_row['std_name']."</td>\n
												<td class=\"hilite\">".$res_row['std_surname']."</td>\n
												<td class=\"hilite\">".$res_row['major_id']."</td>\n																						
											</tr>\n	
										 ";							
								*/
									$major= substr($res_row['major_id'], 0,1);
									if($major=="X"){$std_title="g";}else{$std_title="b";}
									$s=substr($res_row['std_id'],0,7);
									$login=$std_title.$s;
									$email=$login."@ku.ac.th";
									$check_ex=mysql_query("SELECT id FROM users WHERE login like '$login';");
									if(mysql_num_rows($check_ex)==0){
										if(
											mysql_query("INSERT INTO users (active,login,title,firstname,surname,password,category,email) values (1,'$login','".$res_row['std_title']."','".$res_row['std_name']."','".$res_row['std_surname']."','asd323',3,'$email');"))
											{
												$got_id=mysql_insert_id();
												mysql_query("INSERT INTO users_info(id) values ($got_id);");
												
												mysql_query("INSERT INTO wp (courses,users) values($courses,$got_id);");
												
											}
									} else {
										$row_user = mysql_fetch_array($check_ex);
										mysql_query("INSERT INTO wp (courses,users) values($courses,".$row_user["id"].");");
									}														
																							 
								$i++;		 
								
							}
							//print "</table>\n<br>";					
							//echo '<xmp>' . $client->request . '</xmp>';
							//echo '<xmp>' . $client->response . '</xmp>';
						}
						else
						{
							print "NO MATCHES found !\n";
						}
					}
				}
		}
				
		

         // require ("../include/global_var.inc.php");

                if($userid=="" || $userid==none)
                  {                        $users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
                                    $users_info=mysql_query("SELECT * from users_info WHERE id=".$person["id"]);
                   }else{         $users=mysql_query("SELECT * from users WHERE id=$userid");
                                                   $users_info=mysql_query("SELECT * from users_info WHERE id=$userid");
                                      }    ?>
<html><head><title>:-: Users :-:</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<script language="JavaScript">
function BrowserInfo()
{          this.screenWidth = screen.availWidth;
          this.screenHeight = screen.availHeight;
                  // toolbar_height=toolbar.height;
             //  toolbar_width=toolbar.width;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<div align="center">
<table cellpadding="10" cellspacing="0" bgcolor="#ffffff">
        <tr>
              <td align="center"><?
if( $groups=="" || $groups==none )
{
        $Getlist=mysql_query("SELECT DISTINCT u.id,u.login,u.firstname,u.surname,u.email,u.homepage,uf.skill_interest,uf.address,u.picture, u.lastlogin,
                                                                                                  uf.picture_width, uf.picture_height,uf.mobile_phone,uf.telephone,uf.p_address,uf.p_telephone,uf.p_mobile_phone
                                                                                                 FROM wp,users u , users_info uf  WHERE wp.users=u.id AND wp.courses=".$courses." AND wp.cases=0 AND 
																								 wp.modules=0 AND wp.groups=0 AND wp.folders=0 AND u.active=1 AND uf.id=u.id  ORDER BY u.login, wp.admin desc, u.category ");

        $course=mysql_query("SELECT * from courses where id=".$courses);

        // debug here
        if($person["id"] == @mysql_result($course,0,"users"))
                $course_admin = true;
        else
                $course_admin = false;
?>
                <h3 class="h3">
                <?   echo @mysql_result($course,0,"name");
                         if (@mysql_result($course,0,"section") != "")
                           {    ?>
                                        (หมู่ <? echo @mysql_result($course,0,"section"); ?>)
                <?  }   ?>
                </h3>
<?   }else{
                $Getlist=mysql_query("SELECT DISTINCT u.id,u.login,u.email,u.firstname,u.surname,u.homepage,uf.skill_interest, uf.address,u.picture, u.lastlogin,
                                                                                                          uf.mobile_phone,uf.telephone, uf.picture_width, uf.picture_height,uf.p_address,uf.p_telephone,uf.p_mobile_phone
                                                                                                         FROM  wp,users u, users_info uf
                                                                                                         WHERE wp.users=u.id AND wp.groups=".$groups." AND wp.cases=0 AND wp.modules=0 AND wp.courses=0
                                                                                                         AND u.active=1 AND u.id=uf.id ORDER BY u.login, wp.admin desc, u.category,u.login");
        $group=mysql_query("SELECT * from groups where id=".$groups);
?>
        <h3 class="h3">
        <? echo @mysql_result($group,0,"name"); ?>
        </h3>
<?  }    ?>
        <table border=1 cellpadding="2" cellspacing="0">
          <tr>
            <td width="31" align="center" valign="top" class="res"><b>Login</b></td>
            <td width="84" align="center" valign="top" class="res"><b>Name</b></td>
            <td width="34" align="center" valign="top" class="res"><b>Email</b></td>
            <td width="95" align="center" valign="top" class="res"><b>Homepage</b></td>
            <? if($show=="all")
                                  {  ?><td width="72" align="center" valign="top" class="res"><b>Picture</b></td><?          }         ?>
            <td width="45" align="center" valign="top" class="res"><b>Last login</b></td>
          </tr><?  $email_list="";
while($row=mysql_fetch_array($Getlist))
{      $email=$row["email"];

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
                $userid=$row["id"];    ?>
          <tr>
            <td valign="top"><span class="info"><? echo $userlogin; ?></span></td>
            <td valign="top"> <span class="info">
                                <?          // debug here
                                        if($person["admin"]==1 || $course_admin)
                                        {          ?>
                                <a href="../personal/menu.php?userid=<? echo $userid; ?>"><? echo $firstname." ".$surname; ?></a>
                                <? }else{         echo  "&nbsp;".$firstname." ".$surname; }
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

                    <td valign="top"><div align="center">
                        <a href="mailto:<? if( ($email!="") && ($email!=none) )
                                                                                                          {           echo $email;

                                                                                                          }else{         if( ($email2!="") && ($email2!=none) )
                                                                                                                                                echo $email2; }?>" target="_self"><img src="../images/mail.jpg" width="15" height="11" border="0"></a></div></td>

            <td valign="top"> <span class="small"><?  //echo  $homepage;
                                   $homepage=str_replace("http://","",$homepage);  // echo  $homepage;

                if($homepage!="" || $homepage!=none)
                {        ?><a href="http://<? echo $homepage; ?>" target="new_"><?  }  ?><img src="../images/home-blues.gif" width=11 height=16
                                alt="" border="0" ><? echo $homepage;  if($homepage!="" || $homepage!=none){  ?></a><?   }

                                                if($show=="all")
                                                {  ?> <p><span class="info"><?

                        if( ($skill_interest!="")&&($skill_interest!=none) )
                                                                        echo "<b>skill / interest :</b>".nl2br($skill_interest);                 ?></span></p>
              <?          }    ?></span></td>
<? if($show=="all")
       {     ?>
            <td class="small" valign="top">&nbsp;
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
            <td class="small" valign="top">
          <?   if($lastlogin==0)
                          {
                                                echo "Never logged in";
                                 }else{
                                                        echo date("d-m-Y H:i",$lastlogin);
                                                }                ?>
            </td>
          </tr>
          <? } // end while  Getlist?>
        </table>

                <table cellpadding="0" cellspacing="0" width="100%" border="0" class="res">
          <tr>
            <td width="12%"><b>Total</b></td>
            <td width="88%"><? echo mysql_num_rows($Getlist); ?> คน</td>
          </tr>
        </table></td>
                                </tr>
</table>
<?   
	  $droped_member=mysql_query("SELECT u.* , uf.* FROM users as u, drop_courses as d, users_info as uf WHERE d.users=u.id AND d.courses=$courses AND u.id=uf.id ORDER BY u.firstname");

 if(mysql_num_rows($droped_member)!=0){
?>
<br>
<table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center" class="blue"><b>รายชื่อผู้ถอนชื่อออกจากรายวิชา</b>&nbsp;

<table border=1 cellpadding="2" cellspacing="0" align="center">
    <tr> 
      <td width="31" align="center" valign="top" class="res"><b>Login</b></td>
      <td width="84" align="center" valign="top" class="res"><b>Name</b></td>
      <td width="34" align="center" valign="top" class="res"><b>Email</b></td>
      <td width="95" align="center" valign="top" class="res"><b>Homepage</b></td>
<? if($show=="all")
       {     ?>
      <td width="72" align="center" valign="top" class="res"><b>Picture</b></td>
<?   }     ?>
      <td width="45" align="center" valign="top" class="res"><b>Last login</b></td>
    </tr>
<?
	  while($row2=@mysql_fetch_array($droped_member)){
?>	
    <tr> 
      <td valign="top" class="info"><? echo $row2["login"]; ?>&nbsp;</td>
	  <td valign="top" class="info"><? 
					// debug here
			if($person["admin"]==1 || $course_admin)
			{      ?>	<a href="../personal/menu.php?userid=<? echo $row2["id"]; ?>"><? echo $row2["firstname"]." ".$row2["surname"]; ?></a><? 
			}else{         echo  $row2["firstname"]."  ".$row2["surname"]; 
					 } 
     if ($show=="all")
      {         if(  ($row2["p_address"]==1)  &&  (strlen($row2["address"])>3) )
                 {    ?><br><br><b><? echo "Address: "; ?></b><?  echo  $row2["address"];
                 } else{  echo "&nbsp;";  }
	  } 
     if($show=="all")
	  {			 if ( ($row2["telephone"]!="" ) && ($row2["telephone"]!=none)  && ($row2["p_telephone"]==1)  )
				 {  ?><br><? echo "<b>Tel. no. : </b>".nl2br($row2["telephone"]);  }else{ echo "&nbsp;";  }
                  }   
	 if(  $show=="all" )
     {			if ( ( $row2["mobile_phone"]!="") && ($row2["mobile_phone"]!=none) && ($row2["p_mobile_phone"]==1)  )
			     {  ?><br><? echo "<b>Mobile : </b>".nl2br($row2["mobile_phone"]);  }else{ echo "&nbsp;"; }
                  }   ?>&nbsp;</td>
      <td valign="top" class="info"><a href="mailto:<? 
				if( ($row2["email"]!="") && ($row2["email"]!=none) )
				{           echo $row2["email"]; 
				}else{         if( ($row2["email2"]!="") && ($row2["email2"]!=none) )   	echo $row2["email2"]; 
				         }  ?>" target="_self"><img src="../images/mail.jpg" width="15" height="11" border="0"></a>&nbsp;</td>
      <td valign="top" class="info"><span class="small"><?  //echo  $homepage;
               $row2["homepage"]=str_replace("http://","",$row2["homepage"]);  // echo  $homepage;

                if($row2["homepage"]!="" || $row2["homepage"]!=none)
                {        ?><a href="http://<? echo $row2["homepage"]; ?>" target="_blank"><? 
				}        ?><img src="../images/home-blues.gif" width=11 height=16
                                alt="" border="0" ><? echo $row2["homepage"]; 
				if($row2["homepage"]!="" || $row2["homepage"]!=none){  ?></a><?   }
                if($show=="all")
				{	?><p><span class="info"><?
                        if( ($row2["skill_interest"]!="")&&($row2["skill_interest"]!=none) ){ echo "<b>skill / interest :</b>".nl2br($row2["skill_interest"]); }         ?></span></p><? 
				}    ?></span></td>
<? if($show=="all")
       {     ?>
      <td class="small" valign="top" class="info"><img src="../files/preference/<? echo $row2["id"]."/".$row2["picture"]; ?>" style="cursor:hand" onMouseOver="window.status='Click to view picture!';return true" onMouseOut="window.status='';return true" title="Click to view picture" onClick="MM_openBrWindow('../personal/showpicture.php?id=<? echo $row2["id"]; ?>','showpicture','status=yes,scrollbars=yes,resizable=yes,width=<? echo $row2["width"];  ?>,height=<? echo $row2["height"]; ?>')" border="0">&nbsp;</td>
<?   }	?>
      <td class="small" valign="top" class="info"><?
				if($row2["lastlogin"]==0)
                {
								echo "Never logged in";
				 }else{     	echo date("d-m-Y H:i",$row2["lastlogin"]);
						 }     ?>&nbsp;</td>
    </tr>
<?		  } // END while(droped_member)
?></table><?

 if(mysql_num_rows($droped_member)!=0){   ?>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="res" align="center">
	  <tr>
			<td width="12%"><b>Total</b></td>
			<td width="88%"><? echo @mysql_num_rows($droped_member); ?> คน</td>
	  </tr>
</table>
<?  } // END  total drop
?></td></tr>
  </table><br>
<?
} // END if
?>
<a href="users.php?courses=<? echo $courses; ?>&groups=<? echo $groups; ?>&show=all" class="main">Show full info</a><br>
<a href="mailto:<? echo $email_list; ?>" class="main">Mail to all</a><br>

<?
$check=mysql_query("SELECT * FROM wp WHERE users=".$person["id"]." AND courses=$courses AND admin=1;");
if($groups!="")
{
        $check2=mysql_query("SELECT users FROM groups where id=$groups;");
        if( (@mysql_result($check2,0,"users")==$person["id"] ) ||  ($person["admin"]==1)  || (mysql_num_rows($check)!=0) )
                {   ?>
                <a href="../groups/admin_users.php?courses=<? echo $courses; ?>&groups=<? echo $groups; ?>" class="main">Edit group members</a>
<?    }

}else{

        if(  ($person["admin"]==1)  ||  ((mysql_num_rows($check)!=0) && ($courses!=0) && ($groups==""))  )
                  {    ?>
                <a href="admin_users.php?courses=<? echo $courses; ?>" class="main">Edit course members</a>
<?    }
}
mysql_close();
?>
</div>
</body>
</html>