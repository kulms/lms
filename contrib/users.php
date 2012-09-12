<?  
		session_start();
		$session_id = session_id();		

		require ("../include/global_login.php");
        include ("../include/control_win.js");
		require("../include/online.php");
		online_courses($session_id,$person["id"],$courses,time(),1); 

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
                                                                                                 FROM wp,users u , users_info uf
                                                                                                 WHERE wp.users=u.id AND wp.courses=".$courses." AND wp.cases=0 AND wp.modules=0 AND wp.groups=0
                                                                                                 AND u.active=1 AND uf.id=u.id  ORDER BY u.login, wp.admin desc, u.category ");

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
                                                                                                                                                echo $email2; }?>" target="_self"><img src="../images/mail.jpg" width="15" height="11"></a></div></td>

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

<br>

<a href="users.php?courses=<? echo $courses; ?>&groups=<? echo $groups; ?>&show=all" class="main">Show full info</a><br>
<a href="mailto:<? echo $email_list; ?>" class="main">Mail to all</a><br>

<?
$check=mysql_query("SELECT * FROM wp WHERE users=".$person["id"]." AND courses=$courses AND admin=1;");
if($groups!="")
{
        $check2=mysql_query("SELECT users FROM groups where id=$groups;");
        if( (mysql_result($check2,0,"users")==$person["id"] ) ||  ($person["admin"]==1)  || (mysql_num_rows($check)!=0) )
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