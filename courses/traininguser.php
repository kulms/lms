<?   require("../include/global.php");   ?>
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<title>Training User</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>

<body>
<br>
- - - - - - - - - - - Change Login - - - - - - - - - 
<br>
<form name="update" method="post">
Login : 
  <input type="text" name="textfield">
  <input name="LoginSubmit" type="submit" id="LoginSubmit" value="U p d a t e">
</form>
<?
// #######   SUBMIT  ########
	 if($submit)
	 {	$num=1;
		while($num <= $amount){
			$login="$username$num";
			$password=MD5("$username$num");
			if($stmp=mysql_query("INSERT INTO users (active,login,password,category) values(1,'$login','$password',2);")){
				$idget=mysql_insert_id();
				mysql_query("INSERT INTO users_info(id) values ('$idget');");
				echo $login;
				echo "<br>";
			}
			$num++;
		}
	}

// #######   RESET PASSWORD  ########
	if($resetpasswd)
	{	$sql=mysql_query("SELECT login from users where login like '".$namelike."%';");
		while($row=mysql_fetch_array($sql)){
			echo $row["password"],"<br>";
			mysql_query("UPDATE users set password='".$row["login"]."',firstname='',surname='',homepage='',picture='',
			info='',telephone='',title='',address='',email2='',email='' where
			login='".$row["login"]."';");
		}
	}
	
// #######   UPDATE  ########
	if($update)
	{
	
	}
	
?>
</body>
</html>
<? 
<!-- 
/*
<table border=0 cellpadding="2" cellspacing="0">
  <tr>
    <td align="right" class="info">id :&nbsp;</td>
    <td align="left" class="main"><input name="t_id" type="text" id="t_id" value="<? echo @mysql_result($users,0,"id");  ?>"></td>
  </tr>
  <tr> 
    <td align="right" class="info"> User Name: </td>
    <td align="left" class="main">  
      <input name="username" type="text" id="username" value="<? echo @mysql_result($users,0,"login");  ?>"> </td>
  </tr> 
  <tr> 
    <td align="right" class="info"> Change Password: </td>
    <td align="left" class="main"> <a href="https://nontri.ku.ac.th/tools/passwd.html" target="_blank">https://nontri.ku.ac.th/tools/passwd.html</a></td>
  <tr> 
    <td align="right" class="info"> คำนำหน้าชื่อ : </td>
    <td align="left" class="main"><input name="title" type="text" value="<? echo @mysql_result($users,0,"title");?>" maxlength="32"> 
      <font color="#cc00cc"> (เช่น นาย นางสาว ดร. ผศ.ดร. ฯ)</font></tr>
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
  <? 	} // end if cat=2  	?>
  <tr> 
    <td align="right" class="info">คณะ : </td>
    <td align="left" class="main"> <select name="fac" onclick="manage_2nd(document.forms('user').dept,
		document.forms('user').fac.value);"  onChange="selectChange(this, user.dept);">
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
				}   ?>
    </td>
  </tr>
  <?	if($tmpFact !="")					
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
			document.forms('user').fac.value);" onChange="selectChange(this, user.major);">
        <option value="-1"> -------------------------------- เลือกภาควิชา ----------------------------------- 
        </option>
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
				}   ?>
    </td>
  </tr>
  <?	 if($tmpDept!="")
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
      <select name="major">
        <option value="no"> ------------------------------- เลือกสาขาวิชา ----------------------------------- 
        </option>
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
				}  ?>
    </td>
    <?	 if($tmpMajor!="")
					echo($tmpMajor);
			else
					echo ("<script language= \"javascript\">
						  function selMajor()
							{
							}
							</script>");
		?>
    <?		
		$res_Fac = mysql_query("select * from faculty order by id");
		$res_Dept = mysql_query("select d.* from faculty f, department d  where f.fac_id = d.fac_id order by f.fac_name,d.dept_name");
		$res_Major = mysql_query("select f.fac_id,m.* from  faculty f,department d, major m  where f.fac_id = d.fac_id and m.dept_id = d.dept_id order by f.fac_name,d.dept_name,m.major_name");
?>
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
  <?  if (mysql_result($users,0,"category")!=5)
	  			{ 		?>
  <tr> 
    <td align="right" class="info">Email: </td>
    <td align="left" class="main"><? echo @mysql_result($users,0,"email"); ?> 
      <input type="hidden" name="email" value="<? echo @mysql_result($users,0,"email"); ?>" maxlength="255"> 
    </td>
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
      <? //if (sizeof($pictname)>0) 
				if(($pictname[$i-1]!="")&&($pictname[$i-1]!=none))
				{	 $picture_height=@mysql_result($users_info,0,"picture_height");
					 $picture_width=@mysql_result($users_info,0,"picture_width");
							if($picture_width<($screenWidth-50))
							 {			  $width=($screenWidth-50);
							 } else { $width=$picture_width;  
										}  
						 if($picture_height<($screenHeight-75))
							 {           $height=($screenHeight-75);    $scroll="yes"; 
							 }else{  $height=$picture_height;    $scroll="no";   
							          }				
						?>
      <a href="javascript:MM_openBrWindow('showpicture.php?id=<? echo $person["id"]; ?>','showpicture','status=no,resizable=yes,scrollbars=<? echo $scroll ?>,width=<? echo $width; ?>,height=<? echo $height; ?>')"> 
      <?  echo $pictname[$i-1];   ?>
      </a> 
      <?         	echo "   [ "; ?>
      <a href="javascript:iconfirm('deletepicture.php?id=<? echo $person["id"]; ?>')"><? echo "Delete picture file"; ?></a> 
      <?  			echo" ] "; 
				  }  ?>
    </td>
  </tr>
  <tr> 
    <td align="right" class="info">icq :</td>
    <td align="left" class="main"><input name="icq" type="text" id="icq" value="<? echo @mysql_result($users_info,0,"icq");  ?>"> 
    </td>
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
    <td align="right" bgcolor="#F0FFF0" class="info">Internal telephone no. :</td>
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
      <textarea name="office_address" cols="50" rows="7" wrap="virtual" class="small" id="office_address"><?
 echo @mysql_result($users_info,0,"office_address");  ?></textarea> </td>
  </tr>
  <tr> 
    <td align="right" bgcolor="#FFF0FF" class="info">Office tel. No.:</td>
    <td align="left" bgcolor="#FFF0FF" class="main"><input name="office_tel" type="text" id="office_tel" value="<? echo @mysql_result($users_info,0,"office_tel");  ?>"> 
    </td>
  </tr>
  <?   } 	?>
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
      <input name="postal" type="radio" value="0" <? if(@mysql_result($users_info,0,"postal")=="0" )  echo "checked ";?>>
      Office </td>
  </tr>
  <?          } 	 	 ?>
</table>*/
-->
?>