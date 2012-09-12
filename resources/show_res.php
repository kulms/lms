<?
require("../include/global_login.php");
//echo "Faculty : ".$fac."<br>";
//echo "Department : ".$dept."<br>";
//echo "Major : ".$major."<br>";
if (($fac == -1) and ($dept == -1) and ($major == "no")){
	$chk = 0;	
} elseif (($fac != -1) and ($dept == -1) and ($major == "no")){
		$chk = 1;		
	} elseif (($fac != -1) and ($dept != -1) and ($major == "no")){
			$chk = 2;			
		} elseif (($fac != -1) and ($dept != -1) and ($major != "no")){
				$chk = 3;				
			}
//echo "modules : ".$modules."<br>";
//$get_course = mysql_query("SELECT * FROM modules WHERE id=$modules;");
//$courses = mysql_fetch_array($get_course);
//echo "courses : ".$courses["courses"]."<br>";
//echo "courses : ".$courses."<br>";				
?>
<html>
<head>
<title>Resources</title>
<script language="javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

//-->
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff">
<div align="center"> 
  <table width="486" border="0" cellpadding="0" cellspacing="0" >
    <tr> 
      <td width="180"><img src="../images/template01.gif" width="180" height="56"></td>
      <td width="13"><img src="../images/template02.gif" width="13" height="56"></td>
      <td colspan="2"><img src="../images/template03_1.gif" width="293" height="56"></td>
    </tr>
    <tr>
      <td colspan="2"><img src="../images/template04.gif" width="193" height="18"></td>
      <td width="415" bgcolor="#FFFFFF"><div align="center" class="Bred"></div></td>
      <td width="171">&nbsp;</td>
    </tr>
  </table>
  <form name="form1" method="post" action="res_cen_up.php">
    <table width="80%" bgcolor="#000000">
      <tr> 
        <td bgcolor="#CC0033"> 
          <div align="right"> 
            <input type="submit" name="Submit2" value="Submit">
            <input name="Back2" type="button" id="Back2" value="Back" onClick="history.back();">
          </div></td>
      </tr>
    </table>

    <br>
    <table border="0" cellpadding="0" cellspacing="0" width="80%">
    <tr> 
      <td class="res" width="464"><img src="../images/resources.gif" width=20 height=16
alt="" border="0" align="top"> E-Courseware Center</td>
      <!--<td class="res" width="1"><a href="edit.php?modules=144&id=0&folder=true">-->
	  <td class="res" width="1"><a href="edit.php?id=0&folder=true">         
      </td>
    </tr>
    <tr>
      <td class="res" colspan="2"><img src="../images/l_down.gif"
width=20 height=16 alt="" border="0" align="top"> ( For Windows XP or Internet 
        Explorer 6.0 or Higher, must be install JVM, download JVM <a href="../../installer/jvm/msjavx86.exe">click 
        here)</a></td>
    </tr>		
	<? // Create Tree Resource ================================= ?>
    <? 
		function rs($id,$space,$faculty,$department,$major,$check){
				
				 if (($faculty != -1) and ($department != -1) and ($major != "no")){
				 	 //echo "1"."<br>";
					 $rs=mysql_query("SELECT r.*,u.firstname,u.surname 
									  FROM resources_center r,users u 
									  WHERE r.refid=$id AND r.users=u.id AND 
									  (r.faculty=$faculty AND 
									  ((r.department=$department) OR (r.department=0)) AND ((r.major=$major) OR (r.major=0))) 
									  ORDER BY r.name;");
				 } elseif (($faculty != -1) and ($department != -1)){
				 			//echo "2"."<br>";
							//echo "id = ".$id."<br>";
							$rs=mysql_query("SELECT r.*,u.firstname,u.surname 
										  	 FROM resources_center r,users u 
										  	 WHERE r.refid=$id AND r.users=u.id AND 
										  	 (r.faculty = $faculty AND ((r.department=$department) OR (r.department=0)))  											  
										  	 ORDER BY r.name;");
				 		} elseif ($faculty != -1) {
								//echo "3"."<br>";
								$rs=mysql_query("SELECT r.*,u.firstname,u.surname 
									  			 FROM resources_center r,users u 
									  			 WHERE r.refid=$id AND r.users=u.id AND r.faculty=$faculty
									  			 ORDER BY r.name;");
							   } else {
							   			//echo "4"."<br>";
										$rs=mysql_query("SELECT r.*,u.firstname,u.surname 
														 FROM resources_center r,users u 
														 WHERE r.refid=$id AND r.users=u.id 
														 ORDER BY r.name;");			
							   		  }
				 //echo mysql_num_rows($rs);
                 while($row=mysql_fetch_array($rs)){
                        ?>
                        <tr>
                                <td class="res" nowrap><?
                                        echo $space;
                                        if($row["folder"]==1){
                                                ?><img src="../images/l_out.gif" width=20 height=20 alt="" border="0" align="top"><?
												if (($row["is_fac"]!=1) AND ($row["is_dept"]!=1) AND ($row["is_major"]!=1)) {
													?><input name="folder[ ]" type="checkbox" value="<? echo $row["id"]."/".$row["refid"];?>" class="r-button"><?
													?><img src="../images/folder.gif" width=20 height=15 alt="" border="0" align="top"><?
												} else {
													?><img src="../images/folder.gif" width=20 height=15 alt="" border="0" align="top"><?
												}
                                                echo $row["name"];
                                        }else{
                                                if(strlen($row["url"])!=0){
                                                        ?><img src="../images/l_out.gif" width=20 height=20 alt="" border="0" align="top"><?
														?><input name="url[ ]" type="checkbox" value="<? echo $row["id"]."/".$row["refid"];?>" class="r-button"><?
                                                        ?><img src="../images/link.gif" width=20 height=16 alt="" border="0" align="top"><?
                                                        ?><font color="#0000FF"><? echo $row["name"]?></font><?
                                                }else{
                                                        ?><img src="../images/l_out.gif" width=20 height=20 alt="" border="0" align="top"><?
														?><input name="file[ ]" type="checkbox" value="<? echo $row["id"]."/".$row["refid"];?>" class="r-button"><?
                                                        ?><img src="../images/file.gif" width=20 height=16 alt="" border="0" align="top"><?
                                                        ?><font color="#0000FF"><? echo $row["name"]?></font><?
                                                }
                                        }
                                ?>
                                &nbsp;&nbsp;</td>
								<? 
                                      if($row["folder"]==0){?>
                                          <td class="res">										  	                                              											 
											 											 
                                   		  </td>
                                   <? } else {
								   			if (($row["is_major"]==1) OR (($row["is_fac"]==0) AND ($row["is_dept"]==0) AND ($row["is_major"]==0))) {
								   ?>
												<td class="res">
													
												</td>
									<?	}
                                	 }
								  ?>
                        </tr>
                        <?
                        if($row["folder"]==1){ ?>
							<!--<img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top">-->
                               <? rs($row["id"],$space.'<img src="../images/l_down.gif" width=20 height=20 alt="" border="0" align="top">',$faculty,$department,$major,$check); ?>
                        <? }
                }
        }
        rs(0,'',$fac,$dept,$major,$chk);
        ?>
	
	<? //================================= ?>
  </table>
    <? if (($person["category"] == 2) or ($person["category"] == 1)) { ?>
    <!--  <table width="40%">
    <tr>
      <td><form name="form1" method="post" action="">
          <div align="center"><font color="#0000FF" size="2">Get File From Personal 
            :</font><font size="2"> 
            <input name="getFile" type="submit" id="getFile" onClick="MM_openBrWindow('get_resource.php?user=<? echo $person["id"];?>','getResource','status=yes,scrollbars=yes,width=350,height=400')" value="Get Files">            
            </font></div>
          </form></td>
    </tr>
  </table>  -->
    <? } ?>
    <br>
    <table width="80%" bgcolor="#000000">
    <tr>
        <td bgcolor="#CC0033"> 
          <div align="right"> 
            <input type="submit" name="Submit" value="Submit">
            <input name="Back" type="button" id="Back" value="Back" onClick="history.back();">
          </div></td>
    </tr>
  </table>
   <input name="user" type="hidden" value="<? echo $user;?>">
   <input name="modules" type="hidden" value="<? echo $modules;?>">   
   <input name="res_id" type="hidden" value="<? echo $res_id;?>">
   <input name="isedit" type="hidden" value="1"> 
   <input name="courses" type="hidden" value="<? echo $courses;?>">
  </form>
</div></body>
</html>
