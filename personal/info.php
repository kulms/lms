<?php

	require("../include/global_login.php"); 
	include ("../include/control_win.js");  
	//require ("../include/global_var.inc.php"); 
		
	if($userid=="" || $userid==none)
 	{				
		$users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
		$users_info=mysql_query("SELECT * from users_info WHERE id=".$person["id"]);
   	}else{ 	
		$users=mysql_query("SELECT * from users WHERE id=$userid"); 
		$users_info=mysql_query("SELECT * from users_info WHERE id=$userid"); 
	}
	
 ?>
<html><head><title>M@xLearn : User Information</title>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<head>
<!--<link rel="STYLESHEET" type="text/css" href="../style.css">
<link rel="STYLESHEET" type="text/css" href="images/main.css">
<link rel="STYLESHEET" type="text/css" href="images/faq.css">!-->
<script language="JavaScript">
<!--
function BrowserInfo()
{	  this.screenWidth = screen.availWidth;
	  this.screenHeight = screen.availHeight;
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body   topmargin="0" >
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
	    height="53" class="bg1">
	  <tr>
			<td class="menu" align="center">
			<b><?php echo $strPersonal_Header;?></b>
			</td>
	</tr>
</table>

<?php if(@mysql_result($users,0,"id") == $person["id"]){?>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><a href="prefs.php" ><img src="../images/_edit-16.png" width="16" height="16" border="0"> 
      <?php echo $strPersonal_BtnEditPersonal?></a></td>
  </tr>
</table>
<?php } ?>
<br>
<table width="100%" border="0" cellpadding="1" cellspacing="1" class="tdborder2" >
  <tr>
    <td align="center" valign="top"><div align="center">
        <table border="0"  width="100%" align=center cellpadding="2" cellspacing="1" class="tdLine">
          <?php if(  (@mysql_result($users,0,"firstname")!="" && @mysql_result($users,0,"firstname")!=none)  || ( @mysql_result($users,0,"surname")!="" &&  @mysql_result($users,0,"surname")!=none)   )
	      {       ?>
          <tr  class="boxcolor"> 
            <th colspan="2" align="left" class="Bcolor"><img src="../images/icon_user.gif" > 
              <?php echo $strPersonal_LabUserHeader;?></th>
          </tr>
          <tr> 
            <td width="24%" > <div align="right"><?php echo $strPersonal_LabNameSurNameTh;?> : </div></td>
            <td width="76%"  class="hilite" bgcolor="#FFFFFF"><?php echo (@mysql_result($users,0,"title").@mysql_result($users,0,"firstname")." ".@mysql_result($users,0,"surname")); ?></td>
          </tr>
          <?php  	}   	if(  (@mysql_result($users_info,0,"firstname_eng")!="" && @mysql_result($users_info,0,"firstname_eng")!=none)  || ( @mysql_result($users_info,0,"surname_eng")!="" &&  @mysql_result($users_info,0,"surname_eng")!=none)   )
				          {  	  		?>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabNameSurNameEng;?> :</div></td>
            <td class="hilite" bgcolor="#FFFFFF"><?php echo (@mysql_result($users_info,0,"title_eng").@mysql_result($users_info,0,"firstname_eng")." ".@mysql_result($users_info,0,"surname_eng")); ?></td>
          </tr>
          <?php 	 } 			?>
          <tr> 
            <td><div align="right"><?php echo $strPersonal_LabUserName;?> : </div></td>
            <td class="hilite" bgcolor="#FFFFFF"><?php echo @mysql_result($users,0,"login"); ?></td>
          </tr>
          <?php if (  (@mysql_result($users,0,"category")==2) && (@mysql_result($users,0,"ucode")!="" && @mysql_result($users,0,"ucode")!=none) ) 
		{			 ?>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabTeacherCode;?> : </div></td>
            <td  class="hilite" bgcolor="#FFFFFF"><?php echo  @mysql_result($users,0,"ucode"); ?></td>
          </tr>
          <?php	 } 		 if(@mysql_result($users_info,0,"campus")!="" && @mysql_result($users_info,0,"campus")!=none && @mysql_result($users_info,0,"campus")!=-1 )
		  				{	$campus_result=@mysql_result($users_info,0,"campus");
							$campus_z=@mysql_query("SELECT NAME_THAI  FROM ku_campus  kc WHERE  kc.id= $campus_result;");
   ?>
          <tr> 
            <td><div align="right">วิทยาเขต :</div></td>
            <td  class="hilite" bgcolor="#FFFFFF"><?php echo  @mysql_result($campus_z,0,"NAME_THAI"); ?></td>
          </tr>
          <?php					 }
				// start here
		if(@mysql_result($users,0,"fac_id")!="" && @mysql_result($users,0,"fac_id")!=none && @mysql_result($users,0,"fac_id")>0 )
			{				$facID=@mysql_result($users,0,"fac_id");
							$facz=@mysql_query("SELECT FAC_NAME  FROM ku_faculty  kc WHERE  kc.id= $facID;");
 ?>
          <tr> 
            <td><div align="right"><?php echo $strPersonal_LabFac;?> :</div></td>
            <td class="hilite" bgcolor="#FFFFFF"><?php echo  @mysql_result($facz,0,"FAC_NAME"); ?></td>
          </tr>
          <?php		 }
					if(@mysql_result($users,0,"dept_id")!="" && @mysql_result($users,0,"dept_id")!=none && @mysql_result($users,0,"dept_id")>0 )
		  				{
							$deptID=@mysql_result($users,0,"dept_id");
							$deptz=@mysql_query("SELECT NAME_THAI  FROM ku_department  kc WHERE  kc.id= $deptID;");
 ?>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabDep;?> :</div></td>
            <td class="hilite" bgcolor="#FFFFFF"><?php echo  @mysql_result($deptz,0,"NAME_THAI"); ?></td>
          </tr>
          <?php		    		 }			
					if(@mysql_result($users,0,"major_id")!="" && @mysql_result($users,0,"major_id")!=none && @mysql_result($users,0,"major_id")>0 )
		  				{
							$majID=@mysql_result($users,0,"major_id");
							$majz=@mysql_query("SELECT NAME_THAI  FROM ku_major  kc WHERE  kc.id= $majID;");
 ?>
          <tr> 
            <td><div align="right">สาขาวิชาเอก :</div></td>
            <td class="hilite" bgcolor="#FFFFFF"><?php echo  @mysql_result($majz,0,"NAME_THAI"); ?></td>
          </tr>
          <?php                    }
		// end here
		 if ( (@mysql_result($users,0,"category")!=5) && ((@mysql_result($users,0,"email")!=""  &&  @mysql_result($users,0,"email")!=none) || (@mysql_result($users,0,"email2")!=none && @mysql_result($users,0,"email2")!="" ))   )
    	 {        
		     if  ( (@mysql_result($users,0,"email")!=none) && (@mysql_result($users,0,"email")!="" )  )
			  {        ?>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabEmail;?> : </div></td>
            <td class="hilite" bgcolor="#FFFFFF"><?php echo @mysql_result($users,0,"email"); ?></td>
          </tr>
          <?php  }
			if(  (@mysql_result($users,0,"email2")!=none) && (@mysql_result($users,0,"email2")!="") )
			  {       ?>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabOtherEmail;?> : </div></td>
            <td class="hilite" bgcolor="#FFFFFF"><?php echo @mysql_result($users,0,"email2"); ?></td>
          </tr>
          <?php  }
           }else{     if(@mysql_result($users,0,"email2")!="" && @mysql_result($users,0,"email2")!=none)
		   						{      ?>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabOtherEmail;?> : </div></td>
            <td class="hilite" bgcolor="#FFFFFF"><?php echo @mysql_result($users,0,"email2"); ?></td>
          </tr>
          <?php					}
  					 }
    if(	@mysql_result($users_info,0,"homepage")!=""  && @mysql_result($users_info,0,"homepage")!=none )
		{   	?>
          <tr> 
            <td > <div align="right"><?php echo $strPersonal_LabHomepage;?> : </div></td>
            <td class="hilite" bgcolor="#FFFFFF"> <?php echo @mysql_result($users_info,0,"homepage"); ?></td>
          </tr>
          <?php    } 
	if(@mysql_result($users_info,0,"icq")!="" && @mysql_result($users_info,0,"icq")!=none )
		{ 		 ?>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabIcq;?> : </div></td>
            <td class="hilite" bgcolor="#FFFFFF"><?php echo @mysql_result($users_info,0,"icq"); ?></td>
          </tr>
          <?php  } 
	if(@mysql_result($users_info,0,"skill_interest")!=""  &&  @mysql_result($users_info,0,"skill_interest")!=none )
		{			 ?>
          <tr > 
            <td ><div align="right"><?php echo $strPersonal_LabSkill;?> :</div></td>
            <td  class="hilite" bgcolor="#FFFFFF"><?php echo @mysql_result($users_info,0,"skill_interest"); ?></td>
          </tr>
          <?php  }   if( (@mysql_result($users,0,"category")==1) || (@mysql_result($users,0,"category")==2) || (@mysql_result($users,0,"category")==4)  )
			  {    if( (@mysql_result($users_info,0,"building")!="" && @mysql_result($users_info,0,"building")!=none) || (@mysql_result($users_info,0,"room")!="" && @mysql_result($users_info,0,"room")!=none ) || (@mysql_result($users_info,0,"internal_phone")!="" && @mysql_result($users_info,0,"internal_phone")!=none )  ) {  ?>
          <tr class="boxcolor"> 
            <th colspan="2" align="left" class="Bcolor"><b><img src="../images/html.gif" > 
              <?php echo $strPersonal_LabOfficeHeader;?></b></th>
          </tr>
          <?php	if(@mysql_result($users_info,0,"building")!="" && @mysql_result($users_info,0,"building")!=none )
			{    ?>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabBuilding;?> :</div></td>
            <td class="hilite" bgcolor="#FFFFFF"><?php echo @mysql_result($users_info,0,"building");?></td>
          </tr>
          <?php 		}   
	  		if(@mysql_result($users_info,0,"room")!="" && @mysql_result($users_info,0,"room")!=none )
			{    ?>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabRoom;?> :</div></td>
            <td   class="hilite" bgcolor="#FFFFFF"><?php echo @mysql_result($users_info,0,"room"); ?></td>
          </tr>
          <?php 		}   
	  		if(@mysql_result($users_info,0,"internal_phone")!="" && @mysql_result($users_info,0,"internal_phone")!=none )
			{     ?>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabIntPhone;?> :</div></td>
            <td  class="hilite" bgcolor="#FFFFFF"><?php echo @mysql_result($users_info,0,"internal_phone"); ?></td>
          </tr>
          <?php 		}   
	}  	}
		
  if (@mysql_result($users,0,"category")==5) 
	  {   
		if(@mysql_result($users_info,0,"office_address")!="" && @mysql_result($users_info,0,"office_address")!=none )
		  {     ?>
          <tr  class="boxcolor"> 
            <th colspan="2" align="left" class="Bcolor"><b><img src="../images/html.gif" > <?php echo $strPersonal_LabOfficeOutHeader;?></b></th>
          </tr>
          <tr> 
            <td><div align="right"><?php echo $strPersonal_LabAddress;?> :</div></td>
            <td   class="hilite" bgcolor="#FFFFFF"><?php echo @mysql_result($users_info,0,"office_address"); ?></td>
          </tr>
          <?php   	}   
	  		if(@mysql_result($users_info,0,"office_tel")!="" && @mysql_result($users_info,0,"office_tel")!=none )
			{     ?>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabTelephone;?> :</div></td>
            <td  class="hilite" bgcolor="#FFFFFF"><?php echo @mysql_result($users_info,0,"office_tel"); ?></td>
          </tr>
          <?php 		}   
	   }

  			if(@mysql_result($users_info,0,"p_address")==1)
  			{ 
				if(@mysql_result($users_info,0,"p_address")!="" && @mysql_result($users_info,0,"p_address")!=none )
				{    ?>
          <tr class="boxcolor" > 
            <th colspan="2"  align="left" class="Bcolor"><b><img src="../images/html.gif" > <?php echo $strPersonal_LabHomeHeader;?></b></th>
          </tr>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabAddress;?> : </div></td>
            <td  class="hilite" bgcolor="#FFFFFF"><?php echo @mysql_result($users_info,0,"address"); ?></td>
          </tr>
          <?php    		}   
  		 } 
		   if(@mysql_result($users_info,0,"p_telephone")==1)
		  {   
				if(@mysql_result($users_info,0,"telephone")!="" && @mysql_result($users_info,0,"telephone")!=none )
				{    ?>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabTelephone;?> : </div></td>
            <td class="hilite"  bgcolor="#FFFFFF"> <?php echo @mysql_result($users_info,0,"telephone"); ?></td>
          </tr>
          <?php 	}   
  		 } 
  			 if(@mysql_result($users_info,0,"p_mobile_phone")==1)
			 {   
				if(@mysql_result($users_info,0,"mobile_phone")!="" && @mysql_result($users_info,0,"mobile_phone")!=none )
				 {    ?>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabMobile;?> :</div></td>
            <td  class="hilite" bgcolor="#FFFFFF"><?php echo  @mysql_result($users_info,0,"mobile_phone");?></td>
          </tr>
          <?php    		}   
 			} 				?>
			
          <tr class="boxcolor"> 
            <th colspan="2"  align="left" class="Bcolor"><b><img src="../images/html.gif" > ภาษา 
              </b></th>
          </tr>
          <tr> 
            <td ><div align="right"><?php echo $strPersonal_LabLanguage;?> : </div></td>
            <td   class="hilite" bgcolor="#FFFFFF">
			<?php 
			switch(@mysql_result($users,0,"language"))
			{	
			case 0:
				echo "อังกฤษ";
				break;
			case 1:
				echo "ไทย";
				break;
			}			
		?>
			</td>
          </tr>
          <tr> 
            <td > <div align="right"><?php echo $strPersonal_LabLastLogin;?> : </div></td>
            <td   class="hilite" bgcolor="#FFFFFF"> <?php echo date("d-m-Y H:i",@mysql_result($users,0,"lastlogin"));  ?></td>
          </tr>
        </table>
      </div></td>
    <td align="center" valign="top" class="hilite"><table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr class="boxcolor">
          <th  class="Bcolor"><?php echo $strPersonal_LabPicture;?></th>
        </tr>
        <tr>
          <td align="center"> 
            <?php  if(strlen(@mysql_result($users,0,"picture"))>3  && ($picture!=none || $picture!="")  )	  
	   {   $height=none;
			$width=none;
			$id= @mysql_result($users,0,"id"); 									
			$picture=@mysql_result($users,0,"picture");
			$picture_width=@mysql_result($users_info,0,"picture_width");//+50;
			$picture_height=@mysql_result($users_info,0,"picture_height");//+75; 
		// if($picture_width>$win_maxwidth)
			if($picture_width<($screenWidth-50))
			 {			  $width=($screenWidth-50);
		     } else { $width=$picture_width;  
						}  
		// if($picture_height>$win_maxheight)
		 if($picture_height<($screenHeight-75))
			 {           $height=($screenHeight-75);    $scroll="yes"; 
			 }else{  $height=$picture_height;    $scroll="no";    }				
?>
            <!--<img src="../files/preference/<?php echo $id."/".$picture; ?>" alt="" style="cursor:hand"  onMouseOver=";window.status='Click to view picture!';return true" onMouseOut="window.status='';return true" title="Click to view picture" onClick="MM_openBrWindow('showpicture.php?id=<?php echo $person["id"]; ?>','showpicture','status=yes,scrollbars=yes,resizable=yes,width=<?php echo $width; ?>,height=<?php echo $height; ?>')" > -->
            <img src="http://<?php echo $_SERVER["HTTP_HOST"];?>/preference/<?php echo $id."/".$picture; ?>" alt="" style="cursor:hand"  onMouseOver=";window.status='Click to view picture!';return true" onMouseOut="window.status='';return true" title="Click to view picture" onClick="MM_openBrWindow('showpicture.php?id=<?php echo $person["id"]; ?>','showpicture','status=yes,scrollbars=yes,resizable=yes,width=<?php echo $width; ?>,height=<?php echo $height; ?>')"  width="101" height="102">
            <?php
	  }   else {
	  ?>
	  	<img src="../images/no_picture.gif">
	  <?php
	  }
	  ?>
          </td>
        </tr>
      </table> 
      
    </td>	  	
  </tr>
</table>
<?php //  \\} ?>
</html>
<?php mysql_close(); ?>
<?php /* \\  	while($row=mysql_fetch_array($users))
		{   $email=$row["email"];
			if($email_list!="")
				$email_list.=",";

        $login=$row["login"];
        $firstname=$row["firstname"];
        $surname=$row["surname"];
        $email_list.=$email;
        $homepage=$row["homepage"];
        $address=$row["address"];
        $telephone=$row["telephone"];
		$mobile_phone=$row["mobile_phone"];
        $skill_interest=$row["skill_interest"];
        $title=$row["title"];
        $ucode=$row["ucode"];
        $email2=$row["email2"];
		$icq=$row["icq"];
		$building=$row["building"];
		$room=$row["room"];
		$internal_phone=$row["internal_phone"];
		$office_address=$row["office_address"];
		$office_tel=$row["office_tel"];
		$p_address=$row["p_address"];
		$p_telephone=$row["p_telephone"];
		$p_mobile_phone=$row["p_mobile_phone"];
		$postal=$row["postal"];
		$picture_width=$row["picture_width"]+50;
		$picture_height=$row["picture_height"]+75;  \\*/   ?>