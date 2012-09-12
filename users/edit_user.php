<?php	 require ("../include/global_login.php");
				include ("../include/control_win.js");  				
  if($update!="true")
	  {
        $users=mysql_query("SELECT * from users WHERE id=".$id);
		$users_info=mysql_query("SELECT * FROM users_info  WHERE id=".$id);  		
        $pictname = explode("/",@mysql_result($users,0,"picture"));
        $i = sizeof($pictname);
?>	
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<script type="text/javascript" language="JavaScript" src="../createlogin/AutoSelect.js"></script>
<script language="JavaScript">
function BrowserInfo()
{	  this.screenWidth = screen.availWidth;
	  this.screenHeight = screen.availHeight;
}
</script>
<script language="javascript">
	 //generate array for filling in select box
	var obj1 = new Array();	// fac
	var obj2 = new Array();	// dept
	var obj3 = new Array();	 // major
	<?	
		$res_Fac = mysql_query("select k.*,c.NAME_THAI as CNAME_THAI from ku_faculty k, ku_campus c where k.CAMPUS_ID = c.CAMPUS_ID order by FAC_NAME,k.id");
		$res_Dept = mysql_query("select d.*,f.id as fid from ku_faculty f, ku_department d where f.id = d.FAC_ID   order by f.FAC_NAME,f.id,d.NAME_THAI");
		//$res_Major = mysql_query("select distinct d.FAC_id as fid,m.* from  ku_faculty f, ku_department d, ku_major m  where f.id = d.FAC_ID and f.id = m.FAC_ID and m.DEPT_ID = d.id and m.MAJOR_ID = '' order by f.FAC_NAME,f.id,d.NAME_THAI,m.NAME_THAI ");
    	$res_Major = mysql_query("SELECT DISTINCT d.FAC_ID as fid,m.* FROM ku_faculty f, ku_department d, ku_major m where f.id = d.FAC_ID and f.id = m.FAC_ID and m.DEPT_ID = d.id ORDER BY f.FAC_NAME,f.id,d.NAME_THAI,m.NAME_THAI ");
		//		$res_Major = mysql_query("select d.FAC_id as fid,m.* from  ku_department d, ku_major m  where  m.DEPT_ID = d.id and m.FAC_ID = d.FAC_ID order by d.NAME_THAI,m.NAME_THAI");
		while($row=mysql_fetch_array($res_Fac))
		{
			echo("obj1[obj1.length]=new OBJ1st('".$row["FAC_NAME"]." (".$row["CNAME_THAI"].")','".$row["id"]."'); \n");
		}		
		while($row1=mysql_fetch_array($res_Dept))
		{
			echo("obj2[obj2.length]=new OBJ2nd('".$row1["fid"]."','".$row1["NAME_THAI"]." (".$row1["DEPT_ID"]." ) ','".$row1["id"]."'); \n");
		}		
		while($row2=mysql_fetch_array($res_Major))
		{
			echo("obj3[obj3.length]=new OBJ3rd('".$row2["fid"]."','".$row2["DEPT_ID"]."','".$row2["NAME_THAI"]." (".$row2["MAJOR_ID"].")','".$row2["id"]."'); \n");
		} 				
	?>
	
		function selectChange(control, controlToPopulate)
		  {  
			// Empty the second drop down box of any choices
			for (var q=controlToPopulate.options.length;q>=0;q--) 
			{		
				controlToPopulate.options.remove(1);
			}
			if (control.name == "fac")
			 {    // Empty the third drop down box of any choices
					for (var q=user.major.options.length;q>=0;q--) 		
						user.major.options.remove(1);
			 }
		  }
</script>
<script language='javascript'> 
		function iconfirm(in_url)
		{
				if( confirm("Do you really want to delete this Department and its major ?") )
					{   
						document.location =in_url; 
					 }
		}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
  <div align="center">
        
  <h1 class="h1">Edit User</h1>
		
<form ENCTYPE="multipart/form-data" action="edit_user.php" method="post"   name="user" target="ws_main">
        
    <table border=0 cellpadding="2" cellspacing="0" class="tborder">
      <tr> 
        <td align="right" class="info"> User Name: </td>
        <td align="left" class="main"> 
          <? echo @mysql_result($users,0,"login");  ?>
           </td>
      </tr>
      <tr> 
        <td align="right" class="info">User Type:</td>
        <td align="left" class="main"> <select name="category" class="pn-text">
            <option value="-1"></option>
            <?
			$ut = mysql_query("SELECT id,nametype FROM users_type ORDER BY id;");
			while($row_ut=mysql_fetch_array($ut)){
			?>
            <option value="<? echo $row_ut["id"];?>" <? if (@mysql_result($users,0,"category")== $row_ut["id"]) echo "selected";?>><? echo $row_ut["nametype"];?></option>
            <? }?>
          </select> </td>
      </tr>
      <?php
	 //---- Old System 
	//if(@mysql_result($users,0,"category")==5){ 
	 ?>
      <tr> 
        <td align="right" class="info"> Password: </td>
        <td align="left" class="main"> <input name="password" type="password" value="<? echo @mysql_result($users,0,"password"); ?>" maxlength="255"> 
          <font color="#cc00cc">English ONLY! and case sensitive</font> </td>
      </tr>
      <tr> 
        <td align="right" class="info"> Confirm password: </td>
        <td align="left" class="main"> <input name="password2" type="password" value="<? echo @mysql_result($users,0,"password"); ?>" maxlength="255"> 
          <font color="#cc00cc">English ONLY! and case sensitive</font> </td>
      </tr>
      <?
     //}else{
?>
      <!--
      <tr> 
        <td align="right" class="info"> Change Password: </td>
        <td align="left" class="main"> <a href="https://nontri.ku.ac.th/tools/passwd.html" target="_blank">https://nontri.ku.ac.th/tools/passwd.html</a></td>
      </tr>
	  -->
      <?
        //        }
?>
      <tr> 
        <td align="right" class="info"> คำนำหน้าชื่อ : </td>
        <td align="left" class="main"><input name="title" type="text" value="<? echo @mysql_result($users,0,"title");?>" maxlength="32"> 
          <font color="#cc00cc"> (เช่น นาย นางสาว ดร. ผศ.ดร. ฯ)</font> </tr>
      <tr> 
        <td align="right" class="info"> ชื่อ : </td>
        <td align="left" class="main"><input name="firstname" type="text" value="<? echo @mysql_result($users,0,"firstname");?>" maxlength="255"> 
          <font color="#cc00cc"> (ไทย)</font> </td>
      </tr>
      <tr> 
        <td align="right" class="info"> นามสกุล : </td>
        <td align="left" class="main"><input name="surname" type="text" value="<? echo @mysql_result($users,0,"surname");?>" maxlength="255"> 
          <font color="#cc00cc"> (ไทย)</font> </td>
      </tr>
      <input type="hidden" name="check_uf" value="<? if(mysql_num_rows($users_info)==1) 
	  																										echo  "y";
																										else
																										     echo "n";  ?>">
      <tr> 
        <td align="right" class="info">Title :</td>
        <td align="left" class="main"><input name="title_eng" type="text" value="<? echo @mysql_result($users_info,0,"title_eng");?>" maxlength="32"> 
          <font color="#cc00cc"> (Eng)</font></td>
      </tr>
      <tr> 
        <td align="right" class="info"> Name : </td>
        <td align="left" class="main"><input name="firstname_eng" type="text" id="firstname_eng" value="<? echo @mysql_result($users_info,0,"firstname_eng");?>" maxlength="255"> 
          <font color="#cc00cc"> (Eng)</font> </td>
      </tr>
      <tr> 
        <td align="right" class="info">Surname : </td>
        <td align="left" class="main"><input name="surname_eng" type="text" id="surname_eng" value="<? echo @mysql_result($users_info,0,"surname_eng"); ?>" maxlength="255"> 
          <font color="#cc00cc"> (Eng)</font></td>
      </tr>
      <? if (@mysql_result($users,0,"category")==2)
	   			{ 		?>
      <tr> 
        <td align="right" class="info"> University officer code: </td>
        <td align="left" class="main"> <input name="ucode" type="text" value="<? echo @mysql_result($users,0,"ucode"); ?>" maxlength="8"> 
          <font color="#cc00cc"> (รหัสอาจารย์)</font> </td>
      </tr>
      <? 	} // end if cat=2  
	  //Start   category != 5
	if(@mysql_result($users,0,"category")!=5){
   	?>
      <tr> 
        <td align="right" class="info">คณะ : </td>
        <td align="left" class="main"> <select name="fac" onclick="manage_2nd(document.forms('user').dept,
		document.forms('user').fac.value);"  onChange="selectChange(this, user.dept);" class="pn-text">
            <option value="-1"> -------------------------------- เลือกคณะ --------------------------------------- 
            </option>
            <script language = "javascript">
				Add1stSelect(document.forms('user').fac);
		  </script>
          </select> 
          <? 
						  
				if (@mysql_result($users,0,"fac_id")!=none && @mysql_result($users,0,"fac_id")!="") 
				{	$fac = @mysql_result($users,0,"fac_id");
					if($fac)
					{
						$res1 = mysql_query("select FAC_NAME from ku_faculty where id = $fac");
						echo "<br> คณะปัจจุบัน : ".@mysql_result($res1,0,"FAC_NAME");
						$tmpFact =" <script language= \"javascript\">
						  function selFac()
							{
								document.forms('user').fac.value=\"".$fac."\";
								manage_2nd(document.forms('user').dept,\"".$fac."\");
							}
							</script>";
					}
				}
		?>
        </td>
      </tr>
      <? 	
	  		if($tmpFact !="")					
				echo $tmpFact;
			else
				echo ("<script language= \"javascript\">
						  function selFac()
							{
							}
							</script>");
					
		?>
      <tr> 
        <td align="right" class="info">ภาควิชา : </td>
        <td align="left" class="main"> 
          <!--  <select name="select3">
            <option>------------- เลือกภาควิชา -------------- </option>
          </select><br> -->
          <select name="dept" onclick="manage_3rd(document.forms('user').major,
			document.forms('user').dept.value,
			document.forms('user').fac.value);" onChange="selectChange(this, user.major);" class="pn-text">
            <option value="-1"> -------------------------------- เลือกภาควิชา 
            ----------------------------------- </option>
          </select> 
          <?
		  		
				if(@mysql_result($users,0,"dept_id")!=none && @mysql_result($users,0,"dept_id")!="")
				{	$dept = @mysql_result($users,0,"dept_id");
					if($dept)
					{
						$res1 = mysql_query("select NAME_THAI from ku_department where id = $dept");
						echo "<br> ภาควิชาปัจจุบัน : ". @mysql_result($res1,0,"NAME_THAI");
						$tmpDept =" <script language= \"javascript\">
						  function selDept()
							{
								document.forms('user').dept.value=\"".$dept."\";
								manage_3rd(document.forms('user').major,\"".$dept."\",\"".$fac."\");
							}
							</script>";
					}
				}   
				
		?>
        </td>
      </tr>
      <?
	  		 
	  		if($tmpDept!="")
					echo($tmpDept);
			else
					echo ("<script language= \"javascript\">
						  function selDept()
							{
							}
							</script>");
			
	?>
      <tr> 
        <td align="right" class="info">สาขาวิชา : </td>
        <td align="left" class="main"> 
          <!--<select name="select4">
            <option>------------- เลือกสาขาวิชา -------------</option>
          </select><br> -->
          <select name="major" class="pn-text">
            <option value="no"> ------------------------------- เลือกสาขาวิชา 
            ----------------------------------- </option>
          </select> 
          <? 
		  		
				if(@mysql_result($users,0,"major_id")!=none && @mysql_result($users,0,"major_id")!="")
				{	$major = @mysql_result($users,0,"major_id");
					if($major)
					{
						$res1 = mysql_query("select NAME_THAI from ku_major where id = $major");
						echo "<br> สาขาวิชาปัจจุบัน : ".@mysql_result($res1,0,"NAME_THAI");
						$tmpMajor =" <script language= \"javascript\">
						  function selMajor()
							{
								document.forms('user').major.value=\"".$major."\";							
							}
							</script>";
					}
				}  
				
		?>
        </td>
        <?		} // END category!='5'  -----
		  
			 if($tmpMajor!="")
					echo($tmpMajor);
			else
					echo ("<script language= \"javascript\">
						  function selMajor()
							{
							}
							</script>");
							
		?>
        <?		
		$res_Fac = mysql_query("select * from ku_faculty order by id");
		$res_Dept = mysql_query("select d.* from ku_faculty f, ku_department d  where f.fac_id = d.fac_id order by f.fac_name,d.dept_name");
		$res_Major = mysql_query("select f.fac_id,m.* from  faculty f, ku_department d, ku_major m  where f.fac_id = d.fac_id and m.dept_id = d.dept_id order by f.fac_name,d.dept_name,m.major_name");
?></td>
        <?
		
	 if(@mysql_result($users,0,"fac_id")!=none && @mysql_result($users,0,"fac_id")!="")
	 {
		print("<script language='javascript'>manage_2nd(document.forms('user').dept,".@mysql_result($users,0,"fac_id").");</script>	");
		if(@mysql_result($users,0,"dept_id")!=none && @mysql_result($users,0,"dept_id")!="")
		{
			print("<script language='javascript'>manage_2nd(document.forms('user').major,".@mysql_result($users,0,"dept_id").",".@mysql_result($users,0,"fac_id").");</script>	");
		}	
	 }
	
?>
      </tr>
      <?  
	  if (@mysql_result($users,0,"category")!=5)
	  			{ 		?>
      <tr> 
        <td align="right" class="info">Email: </td>
        <td align="left" class="main"> 
          <? //echo @mysql_result($users,0,"email"); ?>
          <input type="text" name="email" maxlength="255"> </td>
      </tr>
      <tr> 
        <td align="right" class="info">Email outside KU: </td>
        <td align="left" class="main"> 
          <? //echo @mysql_result($users,0,"email2"); ?>
          <input name="email2" type="text" value="<? echo @mysql_result($users,0,"email2"); ?>" size="45" maxlength="255"> 
        </td>
      </tr>
      <?     } else{  ?>
    
      <tr> 
        <td align="right" class="info">Email outside KU: </td>
        <td align="left" class="main"> 
          <? //echo @mysql_result($users,0,"email2"); ?>
          <input name="email2" type="text" value="<? echo @mysql_result($users,0,"email2"); ?>" size="45" maxlength="255"> 
        </td>
      </tr>

      <?     } //end else  ?>
      <tr> 
        <td align="right" class="info">Homepage: </td>
        <td align="left" class="main"><input name="homepage" type="text" value="<? echo @mysql_result($users,0,"homepage");?>" size="45"> 
        </td>
      </tr>
      <tr> 
        <td align="right" class="info">&nbsp;</td>
        <td align="left" class="main"><font color="#cc00cc"> Please insert picture 
          type in .jpg or .png ONLY</font></td>
      </tr>
      <tr> 
        <td align="right" class="info">Picture: </td>
        <td align="left" class="main"> <input name="piz" type="file" id="piz" size="45" maxlength="255"> 
          <br> 
          <? if (sizeof($pictname)>0) 
		
				if(($pictname[$i-1]!="")&&($pictname[$i-1]!=none))
				{	 $picture_height=@mysql_result($users_info,0,"picture_height");
					 $picture_width=@mysql_result($users_info,0,"picture_width");
				  	 /* if($picture_height!="" && $picture_height!=none)
						{ 	 if($picture_height>($screenHeight-75) )
							{			 $height=($screenHeight-75);
										 $scroll="yes";
							}else{   $height=$picture_height ;
										 $scroll="no";
								    }
						}
						if($picture_width!="" && $picture_width!=none)
						{	if($picture_width>($screenWidth-50))
							{		     $width=($screenWidth-50);								 
							}else{   $width=$picture_width;
								  	 }
						} */
			
							if($picture_width<($screenWidth-50))
							 {			  $width=($screenWidth-50);
							 } else { $width=$picture_width;  
										}  
						 if($picture_height<($screenHeight-75))
							 {           $height=($screenHeight-75);    $scroll="yes"; 
							 }else{  $height=$picture_height;    $scroll="no";   
							          }
												
						?>

        <a href="javascript:MM_openBrWindow('showpicture.php?id=<? echo $id; ?>','showpicture','status=no,resizable=yes,scrollbars=<? echo $scroll ?>,width=<? echo $width; ?>,height=<? echo $height; ?>')"> 
          <?  echo $pictname[$i-1];   ?>
          </a>
          <?         	echo "   [ "; ?>
          <a href="javascript:iconfirm('deletepicture.php?id=<? echo $id; ?>')"><? echo "Delete picture file"; ?></a> 
          <?  		echo" ] "; 
			}  ?>
        </td>
      </tr>
      <tr> 
        <td align="right" class="info">icq :</td>
        <td align="left" class="main"><input name="icq" type="text" id="icq" value="<? echo @mysql_result($users_info,0,"icq");  ?>"> 
        </td>
      </tr>
      <tr> 
        <td align="right" class="info">Active:</td>
        <td align="left" class="main"><input type="checkbox" name="active" <? if (@mysql_result($users,0,"active")== 1) echo "checked";?> value="1" class="r-button"></td>
      </tr>
      <tr> 
        <td align="right" class="info"> Skill / Interest : </td>
        <td align="left" class="main"> <textarea name="skill_interest" cols="50"  class="small" rows="7" wrap="VIRTUAL"  id="skill_interest"><? 
		echo @mysql_result($users_info,0,"skill_interest");?></textarea></td>
      </tr>
      <? if ((@mysql_result($users,0,"category")==2)|| (@mysql_result($users,0,"category")==4))
			{ 		?>
      <tr bgcolor="#DDFFDD"> 
        <td class="info"><div align="right"><b>Office in KU</b></div></td>
        <td class="info">&nbsp;</td>
      </tr>
      <tr> 
        <td align="right" bgcolor="#F0FFF0" class="info">Building :</td>
        <td align="left" bgcolor="#F0FFF0" class="main"> <input name="building" type="text" id="building" value="<? echo @mysql_result($users_info,0,"building"); ?>" size="45" maxlength="100"> 
        </td>
      </tr>
      <tr> 
        <td align="right" bgcolor="#F0FFF0" class="info">Room :</td>
        <td align="left" bgcolor="#F0FFF0" class="main"> <input name="room" type="text" id="room" value="<? echo @mysql_result($users_info,0,"room");  ?>" maxlength="100"> 
        </td>
      </tr>
      <tr> 
        <td align="right" bgcolor="#F0FFF0" class="info">Internal telephone no. 
          :</td>
        <td align="left" bgcolor="#F0FFF0" class="main"> <input name="internal_phone" type="text" id="internal_phone" value="<? echo @mysql_result($users_info,0,"internal_phone");  ?>" maxlength="40"> 
        </td>
      </tr>
      <? } 
			   if (@mysql_result($users_info,0,"category")==5)  
				{ 	 // old  (mysql_result($users,0,"category")!=3) 
	   ?>
      <tr bgcolor="#FFDFFF"> 
        <td class="info"><div align="right"><b><font color="#cc00cc">Office Outside 
            KU</font></b></div></td>
        <td class="info">&nbsp;</td>
      </tr>
      <tr> 
        <td align="right" bgcolor="#FFF0FF" class="info">Office Address:</td>
        <td align="left" bgcolor="#FFF0FF" class="main"> 
          <!--<textarea name="office_address" wrap="physical" class="small" cols="30" rows="5"> -->
          <textarea name="office_address" cols="50" rows="7" wrap="virtual" class="small" id="office_address">
		  <? echo @mysql_result($users_info,0,"office_address");  ?></textarea> 
        </td>
      </tr>
      <tr> 
        <td align="right" bgcolor="#FFF0FF" class="info">Office tel. No.:</td>
        <td align="left" bgcolor="#FFF0FF" class="main"><input name="office_tel" type="text" id="office_tel" value="<? echo @mysql_result($users_info,0,"office_tel");  ?>"> 
        </td>
      </tr>
      <?  } 	?>
      <tr bgcolor="#DDFFDD"> 
        <td class="info"><div align="right"><b>Home/ Phone</b></div></td>
        <td class="info">&nbsp;</td>
      </tr>
      <tr> 
        <td align="right" bgcolor="#F0FFF0" class="info"> Home Address: </td>
        <td align="left" bgcolor="#F0FFF0" class="main"> 
          <!--<textarea name="address" wrap="physical" class="small" cols="30" rows="5"> -->
          <textarea name="address" wrap="virtual" class="small" cols="50" rows="7"><? echo @mysql_result($users_info,0,"address");?></textarea> 
          <font color="#cc00cc">Public 
          <input name="p_address" type="radio" value="1" <? if(@mysql_result($users_info,0,"p_address")=="1" )  echo "checked ";?>>
          Yes</font><font color="#cc00cc"> 
          <input type="radio" name="p_address" value="0" <? if(@mysql_result($users_info,0,"p_address")=="0" )  echo "checked ";?>>
          No </font> </td>
      </tr>
      <tr> 
        <td align="right" bgcolor="#F0FFF0" class="info"> Home Tel. No.: </td>
        <td align="left" bgcolor="#F0FFF0" class="main"> <input name="telephone" type="text" value="<? echo @mysql_result($users_info,0,"telephone");?>" maxlength="128"> 
          <font color="#cc00cc">public -&gt; 
          <input name="p_telephone" type="radio" value="1" <? if(@mysql_result($users_info,0,"p_telephone")=="1" )  echo "checked ";?>>
          Yes</font> <font color="#cc00cc"> 
          <input type="radio" name="p_telephone" value="0" <? if(@mysql_result($users_info,0,"p_telephone")=="0" )  echo "checked ";?>>
          No </font> </td>
      <tr> 
        <td align="right" bgcolor="#F0FFF0" class="info">Mobile No.:</td>
        <td align="left" bgcolor="#F0FFF0" class="main"> <input name="mobile_phone" type="text" value="<? echo @mysql_result($users_info,0,"mobile_phone");?>" maxlength="40"> 
          <font color="#cc00cc">public -&gt; 
          <input name="p_mobile_phone" type="radio" value="1" <? if(@mysql_result($users_info,0,"p_mobile_phone")=="1" )  echo "checked ";?>>
          Yes</font> <font color="#cc00cc"> 
          <input name="p_mobile_phone" type="radio" value="0" <? if(@mysql_result($users_info,0,"p_mobile_phone")=="0" )  echo "checked ";?>>
          No </font> </td>
      </tr>
      <? if (@mysql_result($users_info,0,"category")==5)
				{ 	       ?>
      <tr> 
        <td align="right" bgcolor="#DDFFDD" class="info"><b>Postal Address :</b></td>
        <td align="left" bgcolor="#DDFFDD" class="info"> <input type="radio" name="postal" value="1"  <? if(@mysql_result($users_info,0,"postal")=="1" )  echo "checked ";?>>
          Home 
          <input name="postal" type="radio" value="0" <?  if(@mysql_result($users_info,0,"postal")=="0" )  echo "checked ";?>>
          Office </td>
      </tr>
      <?          } 	 	 ?>
    </table>
		
    <input type="hidden" name="pictname" value="<? if (sizeof($pictname)>0) echo $pictname[$i-1]; ?>">
    <input type="hidden" name="id" value="<? echo $id; ?>">
    <input type="hidden" name="update" value="true">
    <input type="submit" value="Update">

</form>
  </div>
</body>
</html>
<?
}else{  // update is true
		if($id !="" || $id !=none)
		  {
			$users=mysql_query("SELECT * from users WHERE id=$id");
			$users_info=mysql_query("SELECT * from users_info WHERE id=$id");
		   }
		//	 $users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
		 //	 $users_info=mysql_query("SELECT * from users_info WHERE id=".$person["id"]);
 
		if(@mysql_result($users,0,"password")!=$password  ){ 
	
			if($password==$password2){
							mysql_query("UPDATE users SET password='".MD5($password)."' WHERE id=$id;");
			}else{
								echo "<script language=javascript> alert('Warning - - กรุณาใส่ password ให้ตรงกับ confirm-password  [Please check your password is confirm-password ]'); </script>";
								echo "<script language=javascript> document.location='edit_user.php?id=$id'; </script>";
						}
			}
	    
	   
	 $workdir=$realpath."/files/preference/".$id."/";
	 $workdir2=$realpath."/files/preference/".$id."/"."original/";
	 
	switch($users["category"])
	{	case 1:
			$postal=0;
			break;
		case 2:
			$postal=0;
			break;
		case 3:
			$postal=1;
			break;
		case 4:
			$postal=0;
			break;
		}		
								 
	if($fac_id!="")
	{
		$resCampus = mysql_query("select CAMPUS_ID from ku_faculty where id = $fac_id");
		if($row=mysql_fetch_array($resCampus))
			$campus = $row["CAMPUS_ID"];
		else
			$campus = '';
	}
	else
		$campus = ''; 
	if ($active=="")
		{
			$active = 0;
		}		

	mysql_query("UPDATE users SET title='".trim($title)."', firstname='".trim($firstname)."',surname='".trim($surname)."',
								  ucode='".trim($ucode)."', email='".trim($email)."', email2='".trim($email2)."', homepage='".trim($homepage)."',
								  fac_id='".trim($fac)."',dept_id='".trim($dept)."',major_id='".trim($major)."',active=$active								  
								  WHERE id=$id;");			
							 
	if($check_uf=="y")
	{
		mysql_query("UPDATE users_info SET address = '".trim($address)."', campus='".trim($campus)."' , firstname_eng='".trim($firstname_eng)."', 
									address='".trim($address)."',skill_interest='".trim($skill_interest)."',telephone='".trim($telephone)."', internal_phone='".trim($internal_phone)."',
									room ='".trim($room)."',building = '".trim($building)."',mobile_phone = '".trim($mobile_phone)."',icq = '".trim($icq)."',office_tel='".trim($office_tel)."',
									office_address ='".trim($office_address)."',p_address='".trim($p_address)."',p_telephone='".trim($p_telephone)."',
									p_mobile_phone='".trim($p_mobile_phone)."',postal='".trim($postal)."',	surname_eng='".trim($surname_eng)."', title_eng='".trim($title_eng)."'  
									WHERE users_info.id=$id;");

	}else if($check_uf=="n")
			   { 
					mysql_query("INSERT INTO users_info(id,address,skill_interest,telephone,internal_phone,facimile,room,building,mobile_phone,icq,office_tel,office_address,p_address,p_telephone,p_mobile_phone,postal,picture_width,picture_height,campus,firstname_eng,surname_eng,title_eng) VALUES( ".$id.",'".trim($address)."','".trim($skill_interest)."','".trim($telephone)."', '".trim($internal_phone)."','','".trim($room)."','".trim($building)."','".trim($mobile_phone)."','".trim($icq)." ','".trim($office_tel)."','".trim($office_address)."','".trim($p_address)."','".trim($p_telephone)."','".trim($p_mobile_phone)."','".trim($postal)."','','','".trim($campus)."','".trim($firstname_eng)."', '".trim($surname_eng)."','".trim($title_eng)."' )"); 		
				}				
        if($piz!="" && $piz!="none")
		{  
			if((strtolower($piz_type)== "image/png"  || strtolower($piz_type)=="image/x-png") || (strtolower($piz_type)=="image/pjpeg") || (strtolower($piz_type)=="image/jpeg"))
			  {     // delete old files before copy new one			  	
				 if( (file_exists($workdir.$pictname) ) || ( file_exists($workdir2.$pictname) )  )
				 {
					 @unlink($workdir.$pictname);
				 	 @unlink($workdir2.$pictname);
				}
				
                if(!is_dir($workdir))
				{
						mkdir($workdir,0777);
                        chmod($workdir,0777);
                }
				if(!is_dir($workdir2))
				{
						mkdir($workdir2,0777);
                        chmod($workdir2,0777);
                }
				
				$sql="select now()+0 as current";
				$result=mysql_query($sql);
				$row=mysql_fetch_array($result);
				$current=$row["current"];
				
				$typeFile=$piz_name;		//return filename as Sample.gif
				$pos = strrpos($typeFile, ".");
				$tend = substr($typeFile, $pos+1);
				$f_dbname="$current.$tend";
				$dest=$workdir.$current.".".$tend;
				$dest2=$workdir2.$current.".".$tend;
                //$dest = $workdir.trim($piz_name);
                //$dest2= $workdir2.trim($piz_name);
                //$tend=substr($piz_name,-4);
                if(!($tend==".exe" || $tend==".php" || $tend=="php3" || $tend==".asp" || substr(trim($piz_name),-6)==".phtml"))
				{     
                        if((!copy($piz, $dest))||(!copy($piz, $dest2))) 
						{
                                echo "Unable to create $dest  or $dest2- check permissions<br>\n";
                                exit;
                        }else{  
								// ***** Built image in prefer size *****
								// only for jpeg files
								if ($piz_type == "image/jpeg"  || $piz_type == "image/pjpeg" )
							   {
									$src_img = ImageCreateFromJpeg($piz);   
									// Main code 						
									$img_size = GetImageSize($piz);		 
							 
			mysql_query("UPDATE users_info SET picture_width=".ceil($img_size[0]).", picture_height=".ceil($img_size[1])."
										WHERE id=$id");

									$orig_x = $img_size[0];  
									$orig_y = $img_size[1]; 
									
									if ($orig_x > 120)
									{
										$new_x = 120;   
										$new_y = $orig_y/($orig_x/$new_x);    
									}
									else
									{
										$new_x = $orig_x;   
										$new_y = $orig_y;
									}
		
									$dst_img = imagecreate($new_x,$new_y) or die ("Cannot Initialize new GD image stream");
									// $dst_img =ImageCreateTrueColor($new_x,$new_y);

									imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $new_x, $new_y, $orig_x, $orig_y);  
									//ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $new_x, $new_y, $orig_x, $orig_y);  				
									$image_quality=80;
									if ($piz_type == "image/jpeg"  || $piz_type == "image/pjpeg" )
										ImageJpeg($dst_img, $dest,$image_quality );  
									
									ImageDestroy($src_img);  
									ImageDestroy($dst_img); 
							   }
							   
								if ($piz_type == "image/png"  || $piz_type == "image/x-png" )
							   {	$src_img = ImageCreateFromPng($piz);   
									// Main code 						
									$img_size = GetImageSize($piz);		 
									
			mysql_query("UPDATE users_info  SET picture_width=".ceil($img_size[0]).", picture_height=".ceil($img_size[1])."
										WHERE id=$id;");
																		
									$orig_x = $img_size[0];  
									$orig_y = $img_size[1]; 
									
									if ($orig_x > 120)
									{
										$new_x = 120;   
										$new_y = $orig_y/($orig_x/$new_x);    
									}
									else
									{
										$new_x = $orig_x;   
										$new_y = $orig_y;
									}
		
									$dst_img = imagecreate($new_x,$new_y) or die ("Cannot Initialize new GD image stream");
									// $dst_img =ImageCreateTrueColor($new_x,$new_y);

									imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $new_x, $new_y, $orig_x, $orig_y);  
									//ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $new_x, $new_y, $orig_x, $orig_y);  				
									$image_quality=80;
									if ($piz_type == "image/png"  || $piz_type == "image/x-png" )
										ImagePng($dst_img, $dest,$image_quality );  
									
									ImageDestroy($src_img);  
									ImageDestroy($dst_img); 								
							   }		
								// here
	                               // mysql_query("UPDATE users SET picture='".$piz_name."' WHERE id=".$person["id"].";");
								   mysql_query("UPDATE users SET picture='".$f_dbname."' WHERE id=$id;");
								   
                        	 }
                }

			} // end if check file type 
			else 
				{
					print( "<script language=javascript> alert(\"Wrong type picture file, please try again in *.jpg or *.png .\"); </script>");
					print( "<script language=javascript> document.location='edit_user.php?id=$id'; </script>");
				}
        } // enf if input piz
			print( "<script language=javascript> document.location='index.php'; </script>");			
		
}
mysql_close();
?>
