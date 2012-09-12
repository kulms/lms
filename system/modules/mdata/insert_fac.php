<?php		 
	//require("../include/global_login.php");				
	  session_start();
if($save_fac)
	{
		if(  ($fac_thai=="" || $fac_thai==none)  ||  ($fac_eng=="" || $fac_eng==none) )
			{
				print("<script language='javascript'> alert('Please complete detail !'); </script>");
				
			}else {
							$result=mysql_query("SELECT * FROM ku_faculty  kf WHERE (kf.FAC_NAME='$fac_thai' OR kf.NAME_ENG='$fac_eng') and kf.CAMPUS_ID = '$campus_id' ;");
							if($row=mysql_fetch_array($result))
								{
									print("<script language='javascript'> alert('There is same Faculty in database ready ! '); </script>");	
								 } // end while
							else
								{
									$fac_thai=trim($fac_thai);
									$fac_eng=trim($fac_eng);
									// debug here
									$url=trim($url);
									$pid=$person["id"];
								//	echo  $fac_thai." ".$fac_eng." ".$url." ".$time." ".$pid,"<br>"; exit();
									mysql_query("INSERT INTO ku_faculty(id,FAC_NAME,NAME_ENG,CAMPUS_ID,URL ,edit_by,post_datetime) 
												 VALUES ('','$fac_thai', '$fac_eng','$campus_id','$url','$pid',now());");
									$new_id = mysql_insert_id();			 
									$sql = "INSERT INTO resources_center (name, refid, folder, is_fac, faculty, time, users) 
											VALUES ('$fac_thai', 0, 1, 1, $new_id, ".time().", ".$user->getUserId().");";											
									//echo $sql;
									mysql_query($sql);
											
									/*print("<script language='javascript'>document.location='./index.php?m=mdata&a=insert_fac';</script>"); 	*/
								} //end else
						} //end else
		} // if save
	  $icname="";					
      $fac_query=mysql_query("SELECT kf.*,kc.NAME_THAI as CNAME_THAI FROM ku_faculty kf, ku_campus kc WHERE kc.CAMPUS_ID = kf.CAMPUS_ID ORDER BY kf.CAMPUS_ID,kf.FAC_NAME,kf.id;");		
?>
<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->

<a name="top"></a>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%">	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="8%"><img src="./modules/mdata/images/my_sub_master.png" border="0"></td>
			<td width="92%"><h1><?php echo $user->_($strSystem_LabAcademic);?></h1></td>
		  </tr>
		</table>
	</td>
	<td align="right" width="25%" valign="bottom">
		
	</td>	
  </tr>  
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tdborder1"> 
  <tr bgcolor="#FFFFFF"> 
    <td height="35" colspan="5" align="right">
	  <input type="button" name="Submit2" value="<?php echo $user->_($strSystem_BtnNewCam);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_cam#Faculty'">
	<input type="button" name="Submit" value="<?php echo $user->_($strSystem_BtnNewFac);?>" class="button" onClick="location='./index.php?m=mdata&a=insert_fac#Faculty'">	</td>
  </tr>
  <tr> 
    <td colspan="5" align="center"> <b><font color="#FF0000">***</font> 
      </b><?php echo $user->_($strSystem_LabClickDept);?><b><font color="#FF0000">***</font></b></td>
  </tr>
  
<?php 
	if($icname!=@mysql_result($fac_query,0,"CNAME_THAI"))
		{   
			$icname=@mysql_result($fac_query,0,"CNAME_THAI") ;   
?>
			  <tr> 
				<td colspan="5"><h1><?php echo @mysql_result($fac_query,0,"CNAME_THAI");  ?></h1></td>
			  </tr>
			  <tr align="center" class="Boxcolor"> 
				<td width="3%" class="main_white"><?php echo $user->_($strSystem_LabNo);?></td>
				<td width="25%" class="main_white"><?php echo $user->_($strSystem_LabFacNameTh);?>				  </td>
				<td width="25%" class="main_white"><?php echo $user->_($strSystem_LabFacNameEng);?></td>
				<td width="20%" class="main_white"><?php echo $user->_($strSystem_LabFacUrl);?></td>
				<td width="3%"></td>
			  </tr>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center"><?php echo "1"; ?></td>
				<td ><a href="./index.php?m=mdata&a=insert_dept&id=<? echo  @mysql_result($fac_query,0,"id"); ?>" title="View more detail!"> 
				  <?php
					if(  ( @mysql_result($fac_query,0,"FAC_NAME")!="")  &&  (@mysql_result($fac_query,0,"FAC_NAME")!=none) && (@mysql_result($fac_query,0,"id")!=72 )   )
					{ 
						echo "".@mysql_result($fac_query,0,"FAC_NAME"); 
					}else {  
						echo @mysql_result($fac_query,0,"FAC_NAME"); 
					} 
				  ?>
				  </a>
			    </td>
				<td>
				  <?php
				   if(  (@mysql_result($fac_query,0,"NAME_ENG")!="")  &&  (@mysql_result($fac_query,0,"NAME_ENG")!=none) && (@mysql_result($fac_query,0,"id")!=72 )  )
				   { 
						echo "".@mysql_result($fac_query,0,"NAME_ENG"); 
				   } else {  
						echo @mysql_result($fac_query,0,"NAME_ENG"); 
				   } 
				   ?>
				</td>
				<td> 
				  <?php  
				  if(@mysql_result($fac_query,0,"URL")!=""  &&  @mysql_result($fac_query,0,"URL")!=none )
				  { 
						echo "<a href='http://".@mysql_result($fac_query,0,"URL")."'>http://".@mysql_result($fac_query,0,"URL")."</a>"; 
				  } else {  
					echo ""; 
				  } 
				  ?>
				</td>
				<td align="center"><a href="./index.php?m=mdata&a=edit_fac&id=<?php echo @mysql_result($fac_query,0,"id"); ?>" target="_self"><img src="./images/icon/_edit-16.png" border="0" alt="<?php echo $user->_($strEdit);?>"></a></td>
			  </tr>   
<?php 	
		} 	  
		$num=2;
			   while( $row=mysql_fetch_array($fac_query))
				 {     $name_thai=$row["FAC_NAME"];
						$name_eng=$row["NAME_ENG"];
						$cname = $row["CNAME_THAI"];
						$url=$row["URL"];
						//$url=str_replace("http://",$url);
						$url=trim($url);
						$id=$row["id"];
						
		 if($icname!=$cname )
				{	  
?>
				  <tr> 
					<td colspan="5"><h1><?php echo $cname; ?></h1></td>
				  </tr>
				  <tr align="center" class="boxcolor"> 
					
    <td width="3%" class="main_white"><?php echo $user->_($strSystem_LabNo);?>
    <td width="25%" class="main_white"><?php echo $user->_($strSystem_LabFacNameTh);?>
    <td width="25%" class="main_white"><?php echo $user->_($strSystem_LabFacNameEng);?>
    <td width="20%" class="main_white"><?php echo $user->_($strSystem_LabFacUrl);?>
<td width="3%"></td>
				  </tr>
<?php 			
				$icname=$cname;	   
				} 	  
?>
  <tr bgcolor="#FFFFFF"> 
    <td  align="center"><? echo $num++; ?></td>
    <td><a href="./index.php?m=mdata&a=insert_dept&id=<?php echo $id; ?>" title="View more detail!"> 
      <?php
      if(($name_thai!="") && ($name_thai!=none) && ($id!=72 ))
	  { 
	  	echo "".$name_thai; 
	  } else {  
	  	echo $name_thai; 
	  } 
	  ?>
      </a>
    </td>
    <td>
      <?php
       if(($name_eng!="") && ($name_eng!=none) && ($id!=72 ))
	   { 
	   	echo "".$name_eng; 
	   } else {  
	   	echo $name_eng; 
	   } 
	   ?>
    </td>
    <td> 
      <?php  
	  	if($url!=""  &&  $url!=none ){ 
			echo "<a href='http://".$url."'>http://".$url."</a>"; 
		} else {  
			echo ""; 
		} 
	  ?>
    <td align="center"><a href="./index.php?m=mdata&a=edit_fac&id=<?php echo $id; ?>" target="_self"><img src="./images/icon/_edit-16.png" border="0" alt="<?php echo $user->_($strEdit);?>"></a></td>
  </tr>
<?php 		
} 		
?>
</table>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right"><a href="#top">Go to top</a></td>
  </tr>
</table>

<form name="insert_fac" method="post" action="./index.php?m=mdata&a=insert_fac">

  <table width="600" border="0" align="center" cellpadding="2" cellspacing="0" class="tdborder2">
    <tr class="Boxcolor"> 
      <th colspan="2" class="Bcolor"><a name="Faculty"></a><?php echo $user->_($strSystem_BtnNewFac);?></th>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2" class="hilite"> <input name="save_fac" type="submit" id="save_fac" value="<?php echo $user->_($strSave);?>" class="button"> 
        <input name="resetfac" type="reset" id="resetfac2" value="<?php echo $user->_($strReset);?>" class="button"></td>
    </tr>
    <tr> 
      <td width="190" align="right" class="hilite"><?php echo $user->_($strSystem_LabCampus);?>:</td>
      <td width="404"> 
        <?php 
			  $resCmp = mysql_query("select * from ku_campus order by id");
			  if($rowCmp = mysql_fetch_array($resCmp))
			  {				
		?>
        		<select name="campus_id" style="font-size:10px">
          		<option value="<?php echo $rowCmp["CAMPUS_ID"]; ?>" selected><? echo $rowCmp["NAME_THAI"]; ?></option>
        <?php
					while($rowCmp = mysql_fetch_array($resCmp))
					{			
		?>
          			<option value="<? echo $rowCmp["CAMPUS_ID"]; ?>"><? echo $rowCmp["NAME_THAI"]; ?></option>
        <?php   
					}		
		?>
        		</select> 
        <?php   
			  }            
		?>
      </td>
    </tr>
    <tr> 
      <td align="right" class="hilite"><?php echo $user->_($strSystem_LabFacNameTh);?>:</td>
      <td><input name="fac_thai" type="text" id="fac_thai" size="55" maxlength="200" class="text"></td>
    </tr>
    <tr> 
      <td align="right" class="hilite"><?php echo $user->_($strSystem_LabFacNameEng);?>:</td>
      <td><input name="fac_eng" type="text" id="fac_eng" size="55" maxlength="200" class="text"></td>
    </tr>
    <tr> 
      <td align="right" class="hilite"><?php echo $user->_($strSystem_LabFacUrl);?>: <b>http://</b></td>
      <td><input name="url" type="text" id="url" size="55" maxlength="100" class="text"> 
      </td>
    </tr>
  </table>
</form>