<?php  require("../include/global_login.php");

	function insert_syllabus_userdef($topic,$details,$cid)
	{
		if (trim($topic)!="")
		   {
				mysql_query("INSERT INTO syllabus_userdef VALUES('',".$cid.",\"".trim($topic)."\",\"".trim($details)."\");");
		   }			
	
	}	

	 if($submit_filling)
	 {
	 		$a=trim($a);
			$bp=trim($bp);
			$b=trim($b);
			$cp=trim($cp);
			$c=trim($c);
			$dp=trim($dp);
			$d=trim($d);
			$f=trim($f);
			
			$grading="$a:$bp:$b:$cp:$c:$dp:$d:$f";
			$checksql=mysql_query("SELECT * FROM syllabus where courses=".$courses.";");
			if(mysql_num_rows($checksql)==0)
				{
						mysql_query("INSERT INTO syllabus (courses,grading) 
													 VALUES ($courses,'$grading');");
				 }
				 else 
				 { 
				    mysql_query("UPDATE syllabus SET grading='$grading' where courses=$courses;");
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
		//	print( "<script language=javascript> alert(\"Completely Update.\"); <!/script>");
			print( "<script language=javascript> document.location='index.php?courses=$courses'; </script>");		 		
		
	 }
	   else if($submit_file)
              {
				$path="../files/syllabus/$courses";
				if(!(@opendir($path)))
					mkdir ("$path", 0777);
								  
				   $res=mysql_query("SELECT syllabus_upload FROM syllabus where courses=$courses;");				   
				   $checkfile=mysql_fetch_array($res);
					 if(trim($uploadedFile)=="" ||  $uploadedFile == none)
					 {
							if(mysql_num_rows($res)>=1)
								{	
										mysql_query("UPDATE syllabus SET new_window=$file_target  WHERE courses=$courses;"); 								
										//print( "<script language=javascript> alert(\"Completely Update.\"); <!/script>");
										print( "<script language=javascript> document.location='index.php?courses=$courses'; </script>");
								}
							else
							{	// no syllabus info in database
								mysql_query("INSERT INTO syllabus(id, courses, new_window) VALUES('', $courses, $file_target);"); 
							//	print( "<script language=javascript> alert(\"Completely Update.\"); <!/script>");
								print( "<script language=javascript> document.location='index.php?courses=$courses'; </script>");								
							}
					 }
					 else
						{ // User input uploadedFile
							 if(strtolower($uploadedFile_type)=="application/pdf" || strtolower($uploadedFile_type)=="application/msword")
							 {
							 	// rename uploadedFile
								$sql="select now()+0 as current";
								$result=mysql_query($sql);
								$row1=mysql_fetch_array($result);

								$typeFile=$uploadedFile_name;		//return filename as Sample.gif
								$pos = strrpos($typeFile, ".");
								$rest = substr($typeFile, $pos+1);
								
								$new_uploadedFile=$row1["current"].".".$rest;
								
								if(mysql_num_rows($res)==0)
								{   
									if(move_uploaded_file($HTTP_POST_FILES['uploadedFile']['tmp_name'], "$path/$new_uploadedFile"))
										{
											mysql_query("INSERT INTO  syllabus (syllabus_upload, newuploadfilename ,new_window) VALUES('$uploadedFile_name', '$new_uploadedFile',$file_target);");										 
											//print( "<script language=javascript> alert(\"Completely Update.\"); <!/script>");
											print( "<script language=javascript> document.location='index.php?courses=$courses'; </script>");
										}
									else
										print( "<script language=javascript> alert(\"Can not upload syllabus file. Try again.\"); </script>");
								}			   			
								else
								{	if($checkfile["newuploadfilename"]!="" && $checkfile["newuploadfilename"]!=none)
									{	
										if(file_exists($path."/".$checkfile["newuploadfilename"]))
										{	print($path."/".$checkfile["newuploadfilename"]);
											unlink($path."/".$checkfile["newuploadfilename"]);
										 }
									}
											if(move_uploaded_file($HTTP_POST_FILES['uploadedFile']['tmp_name'], "$path/$new_uploadedFile"))
											{
												//mysql_query("UPDATE syllabus SET syllabus_upload=\"$path/$uploadedFile_name\"  WHERE courses=$courses;"); 
												mysql_query("UPDATE syllabus SET syllabus_upload=\"$uploadedFile_name\", new_window=\"$file_target\", 
															newuploadfilename=\"$new_uploadedFile\" WHERE courses=$courses;"); 
											} // end if copy
									
								} // end else
								//print( "<script language=javascript> alert(\"Completely Update.\"); <!/script>");
								print( "<script language=javascript> document.location='index.php?courses=$courses'; </script>");
							} // check type file
							else
								{ 
									print( "<script language=javascript> alert(\"Wrong type of  syllabus.\"); </script>");	  
								}
							}  //end if upload..
					  } // end if else
			
	   else if($save_all)
				     {							 
						 // syllabus form
						$a=trim($a);
						$bp=trim($bp);
						$b=trim($b);
						$cp=trim($cp);
						$c=trim($c);
						$dp=trim($dp);
						$d=trim($d);
						$f=trim($f);

						$grading="$a:$bp:$b:$cp:$c:$dp:$d:$f";
						$checksql=mysql_query("SELECT * FROM syllabus where courses=".$courses.";");
						if(mysql_num_rows($checksql)==0)
							{
									mysql_query("INSERT INTO syllabus (courses,grading) 
																 VALUES ($courses,'$grading');");
							 }
							 else 
							 { 
								mysql_query("UPDATE syllabus SET grading='$grading' where courses=$courses;");
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
		
						// submit_file					
							$path="../files/syllabus/$courses";							
							if(!(@opendir($path)))
								mkdir ("$path", 0777);
								  
						   $checkfile=mysql_query("SELECT syllabus_upload FROM syllabus where courses=$courses;");				   
							 if(trim($uploadedFile)=="" ||  $uploadedFile == none)
								 { // no syllabus file attach .... do only update details
										if(mysql_num_rows($checkfile)>=1)
										{												
											mysql_query("UPDATE syllabus SET new_window=$file_target  WHERE courses=$courses;"); 
										//	print( "<script language=javascript> alert(\"Completely Update.\"); <!/script>");			
											print( "<script language=javascript> document.location='index.php?courses=$courses'; </script>");											
										}											
								 }
							 else
								{ // User input uploadedFile
							 if(strtolower($uploadedFile_type)=="application/pdf" || strtolower($uploadedFile_type)=="application/msword")
							 {
							 	// rename uploadedFile								
								$sql="select now()+0 as current";
								$result=mysql_query($sql);
								$row1=mysql_fetch_array($result);

								$typeFile=$uploadedFile_name;		//return filename as Sample.gif
								$pos = strrpos($typeFile, ".");
								$rest = substr($typeFile, $pos+1);
								
								$new_uploadedFile=$row1["current"].".".$rest;
								
								if(mysql_num_rows($checkfile)==0)
								{   
									if(move_uploaded_file($HTTP_POST_FILES['uploadedFile']['tmp_name'], "$path/$new_uploadedFile"))
										{
											mysql_query("INSERT INTO  syllabus (syllabus_upload, newuploadfilename ,new_window) VALUES('$uploadedFile_name', '$new_uploadedFile',$file_target);");										 
											//print( "<script language=javascript> alert(\"Completely Update.\"); <!/script>");
											print( "<script language=javascript> document.location='index.php?courses=$courses'; </script>");
										}
									else
										print( "<script language=javascript> alert(\"Can not upload syllabus file. Try again.\"); </script>");
								}			   			
								else
								{	if(file_exists ($checkfile["syllabus_upload"]))
									{	
										unlink($checkfile["syllabus_upload"]);
									 }
										if(move_uploaded_file($HTTP_POST_FILES['uploadedFile']['tmp_name'], "$path/$new_uploadedFile"))
										{
											//mysql_query("UPDATE syllabus SET syllabus_upload=\"$path/$uploadedFile_name\"  WHERE courses=$courses;"); 
											mysql_query("UPDATE syllabus SET syllabus_upload=\"$uploadedFile_name\", new_window=\"$file_target\", 
														newuploadfilename=\"$new_uploadedFile\" WHERE courses=$courses;"); 
										} // end if copy
								} // end else
								//print( "<script language=javascript> alert(\"Completely Update.\"); <!/script>");
								print( "<script language=javascript> document.location='index.php?courses=$courses'; </script>");
							} // check type file
							else
								{ 
									print( "<script language=javascript> alert(\"Wrong type of  syllabus.\"); </script>");	  
								}
							}  //end if upload..
					  } // end if else

		$userdef = mysql_query("select su.* from syllabus_userdef su where courses = $courses order by id"); 
		$sel=mysql_query("SELECT * FROM syllabus WHERE courses=$courses;");
		$row=mysql_fetch_array($sel);
		$pat=":";
		$arr=split($pat,$row["grading"]);
		$udefine=false;

?>
<html>
<title>Add / Edit Syllabus</title>
<head>

<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>

<body bgcolor="#FFFFFF">
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
    <td><!--<p>--><font color="#0066FF">2. Upload your syllabus file 
        <!-- <b> *.doc or *.pdf </b>-->
     ( prefer  *.pdf )<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  in the uploadfile section.(2 Mb max)</font><!--</p>-->
      </td>
  </tr>
  <tr> 
    <td><font color="#0066FF">3. Both typing in form and uploadfile.</font></td>
  </tr>
  <tr> 
    <td><hr></td>
  </tr>
</table>

<form method="post" action="" enctype="multipart/form-data">

  <tr> 
    <div align="center"><b><font color="#008080" class="meny">.:: Filling syllabus 
      section ::.</font></b> 
    </div>	
  </tr><br>
  <table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" bordercolor="#A4A4FF" bgcolor="#A4A4FF">
    <tr> 
      <td width="46%" height="38"  class="res"> <b>Course Description<a name="typing"></a> 
        and How the Course is Conducted :</b> </td>
    </tr>
    <?
		$max_item = 12;
		$cnt = 0;
		while($rowuser=mysql_fetch_array($userdef))
		{	$cnt++;
	?>
    <tr> 
      <td  bgcolor="#C4C4FF" class="res"><b>Topic <? echo $cnt; ?> : </b></td>
    </tr>
    <tr> 
      <td><input name="topic<? echo $cnt; ?>" type="text" id="topic<? echo $cnt; ?>" value="<? echo $rowuser["topic_name"]; ?>"></td>
    </tr>
    <tr> 
      <td bgcolor="#C4C4FF" class="res"><b>Description <? echo $cnt; ?> : </b></td>
    </tr>
    <tr> 
      <td><textarea name="description<? echo $cnt; ?>" cols="100" rows="5" wrap="VIRTUAL" id="description<? echo $cnt; ?>"><? echo $rowuser["details"]; ?></textarea></td>
    </tr>
    <?		
		}
		while($cnt<$max_item)
		{	$cnt++;
	?>
    <tr> 
      <td bgcolor="#C4C4FF" class="res"><b>Topic <? echo $cnt; ?> : </b></td>
    </tr>
    <tr> 
      <td><input name="topic<? echo $cnt; ?>" type="text" id="topic<? echo $cnt; ?>"></td>
    </tr>
    <tr> 
      <td bgcolor="#C4C4FF"  class="res"><b>Description <? echo $cnt; ?> : </b></td>
    </tr>
    <tr> 
      <td><textarea name="description<? echo $cnt; ?>" cols="100" rows="5" wrap="VIRTUAL" id="description<? echo $cnt; ?>"><? echo $rowuser["details"]; ?></textarea></td>
    </tr>
    <?
		}
	?>
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
    <tr bgcolor="#CCFFFF"> 
      <td bgcolor="#C4C4FF"> <div> 
          <input type="reset" name="Submit4" value="Reset">
          <input name="submit_filling" type="submit" id="submit_filling" value="Save">
          <input type="hidden" name="courses" value="<? echo $courses; ?>">
        </div></td>
    </tr>
  </table>
    </div>

  <br><br><div align="center"><b><font color="#008080" class="meny"> .:: Uploadfile section ::.</font></b></div>  
		 
  <table width="530" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#A4A4FF">
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
    <tr> 
      <td bgcolor="#C4C4FF"><!--<input type="reset" name="Submit3" value="Reset">-->
        <!--<input type="submit" name="submit_file" value="Save">--></td>
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
</form>	
	
  <table width="90%" border="0" align="center">
    <tr>
      <td><div align="right"><a href="#top">top</a></div></td>
    </tr>
  </table>    <br>

</body>
</html>