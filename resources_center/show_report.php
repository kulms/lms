<?
//require("../include/global_login.php");
session_start();
$session_id = session_id();		

require ("../include/global_login.php");

require_once ("./classes/User.php");
require_once ("./classes/UserStorage.php");
require_once( "./includes/main_functions.php" );

	
$user = UserStorage::lookupById($person["login"]);

session_register( 'user' ); 		

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


//echo "Faculty : ".$fac."<br>";
//echo "Department : ".$dept."<br>";
//echo "Major : ".$major."<br>";
if($fac == ""){
	$fac =-1;
}
if($dept == ""){
	$dept =-1;
}
if($major == ""){
	$major ="no";
}
if (($fac == -1) and ($dept == -1) and ($major == "no")){
	$chk = 0;	
} elseif (($fac != -1) and ($dept == -1) and ($major == "no")){
		$chk = 1;		
	} elseif (($fac != -1) and ($dept != -1) and ($major == "no")){
			$chk = 2;			
		} elseif (($fac != -1) and ($dept != -1) and ($major != "no")){
				$chk = 3;				
			}
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
<script language="javascript">
<!--
function newWindowsResize(url)
 {
   var options = "width=" + screen.width + ",height=" + screen.height + ",";
   options += "resizable=yes,scrollbars=yes,status=yes,menubar=no,toolbar=no,location=no,directories=no,";
   options += "left=0,top=0";
 
   newWin = window.open(url, "wName", options);
   newWin.focus();
 }
//-->

</script>
<!--<link rel="STYLESHEET" type="text/css" href="../main.css">
<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">

</head>
<body bgcolor="#ffffff">
<div align="center">
  <table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
	    height="53" class="bg1">
    <tr> 
      <td class="menu" align="center"> <b>E-Courseware Center</b> </td>
    </tr>
  </table>
  <br>
  <table border="0" cellpadding="0" cellspacing="0" width="60%">
    <tr> 
      <td class="res" width="464"><img src="../images/resources.gif" width=20 height=16
alt="" border="0" align="top"> E-Courseware Center</td>
      <!--<td class="res" width="1"><a href="edit.php?modules=144&id=0&folder=true">-->
	  <td class="res" width="1"><a href="edit.php?id=0&folder=true"> 
        <? if (($person["category"] == 2) || ($person["category"] == 0)) { ?>
        	<!--<img src="../../images/tool.gif" width=18 height=16 alt="" border="0" align="top"></a> -->
        <? } ?>
      </td>
    </tr>
	<!--
    <tr>
      <td class="res" colspan="2"><img src="../images/l_down.gif"
width=20 height=16 alt="" border="0" align="top"> For Windows XP or Internet Explorer 
        6.0 or Higher, must be install JVM, download JVM (<a href="http://course.eng.ku.ac.th/installer/jvm/msjavx86.exe">click 
        here</a>)</td>
    </tr>
	-->		
	<? // Create Tree Resource ================================= ?>
    <? 
		function rs($id,$space,$faculty,$department,$major,$check){
				
				 if (($faculty != -1) and ($department != -1) and ($major != "no")){
				 	 //echo "1"."<br>";
					 $rs=mysql_query("SELECT r.*,u.firstname,u.surname,u.category 
									  FROM resources_center r,users u 
									  WHERE r.refid=$id AND r.users=u.id AND 
									  (r.faculty=$faculty AND 
									  ((r.department=$department) OR (r.department=0)) AND ((r.major=$major) OR (r.major=0))) 
									  ORDER BY r.name;");
				 } elseif (($faculty != -1) and ($department != -1)){
				 			//echo "2"."<br>";
							//echo "id = ".$id."<br>";
							$rs=mysql_query("SELECT r.*,u.firstname,u.surname,u.category  
										  	 FROM resources_center r,users u 
										  	 WHERE r.refid=$id AND r.users=u.id AND 
										  	 (r.faculty = $faculty AND ((r.department=$department) OR (r.department=0)))  											  
										  	 ORDER BY r.name;");
				 		} elseif ($faculty != -1) {
								//echo "3"."<br>";
								$rs=mysql_query("SELECT r.*,u.firstname,u.surname,u.category  
									  			 FROM resources_center r,users u 
									  			 WHERE r.refid=$id AND r.users=u.id AND r.faculty=$faculty
									  			 ORDER BY r.name;");
							   } else {
							   			//echo "4"."<br>";
										$rs=mysql_query("SELECT r.*,u.firstname,u.surname,u.category  
														 FROM resources_center r,users u 
														 WHERE r.refid=$id AND r.users=u.id 
														 ORDER BY r.name;");			
							   		  }
				 //echo mysql_num_rows($rs);
                 while($row=@mysql_fetch_array($rs)){
                        ?>
                        <tr>
                                <td class="res" nowrap><?
                                        echo $space;
                                        if($row["folder"]==1){
                                                ?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><img src="../images/folder.gif" width=20 height=15 alt="" border="0" align="top"><?
                                                echo $row["name"];
                                        }else{
                                                if(strlen($row["url"])!=0){
                                                        ?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><?
                                                        ?><img src="../images/link.gif" width=20 height=16 alt="" border="0" align="top"><?
                                                        ?>
														
														<a href="#" onClick="newWindowsResize('report_detail.php?id=<? echo $row["id"]?>&index_name=<? echo $row["url"];?>')">
                          									<? echo $row["name"]?> </a>
														<?
                                                }else{
                                                        ?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><?
                                                        ?><img src="../images/file.gif" width=20 height=16 alt="" border="0" align="top">
														<?
														if($row["index_name"]!= "" && $row["index_name"] != "null") {
															?>
															 <!--<a href="#" onClick="newWindowsResize('main.php?id=<? echo $row["id"]?>&index_name=<? echo $row["index_name"]."&action=content&user=".$person["login"]?>;?>')">-->
															 <!--<a href="#" onClick="newWindowsResize('../files/resources_center_files/<? echo $row["id"]."/".$row["index_name"]."?action=content&user=".$person["login"]?>')">-->
															 <a href="#" onClick="newWindowsResize('report_detail.php?id=<? echo $row["id"]?>&index_name=<? echo $row["index_name"];?>')">
                          									<? echo $row["name"]?> </a>
															<!--<a href="../files/resources_center_files/<? echo $row["id"]."/".$row["index_name"]?>" target="_blank"><? echo $row["name"]?></a>-->
															<?
														} else {
															?>
															<!--<a href="../files/resources_center_files/<? echo $row["id"]."/".$row["file"]?>"><? echo $row["name"]?></a>-->
															<a href="#" onClick="newWindowsResize('report_detail.php?id=<? echo $row["id"]?>&index_name=<? echo $row["file"];?>')"><? echo $row["name"]?></a>
															<?
														}
                                                }
                                        }
                                ?>
                                &nbsp;&nbsp;</td>
								<? 
                                      if($row["folder"]==0){?>
                                          <td class="res">
										  	 <? if($row["category"] != 3){?>
											 <!--
                                             <a href="edit.php?id=<? echo $row["id"]?>&fac=<? echo $row["faculty"]?>&dept=<? echo $row["department"]?>&major=<? echo $row["major"]?>&chk=<? echo $check?>">
                                             <img src="../images/tool.gif" width=18 height=16 alt="<? echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"])?>" border="0" align="top"></a>-->
											 <? }?>
											 <!--<img src="../../images/tool.gif" alt="<? //echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"])?>" width=18 height=16 border="0" align="top" 
											 style="cursor:pointer;cursor:hand"   											 
											 onClick="MM_openBrWindow('edit.php?id=<? //echo $row["id"]?>&fac=<? //echo $row["faculty"]?>&dept=<? //echo $row["department"]?>&major=<? //echo $row["major"]?>','edit','status=yes,scrollbars=yes,width=400,height=250')">-->											 
                                   		  </td>
                                   <? } else {
								   			if (($row["is_major"]==1) OR (($row["is_fac"]==0) AND ($row["is_dept"]==0) AND ($row["is_major"]==0))) {
								   ?>
												<td class="res">
													<? if($row["category"] != 3){?>	
													<!--
													<a href="edit.php?id=<? echo $row["id"]?>&folder=true&fac=<? echo $row["faculty"]?>&dept=<? echo $row["department"]?>&major=<? echo $row["major"]?>&chk=<? echo $check?>">
													<img src="../images/tool.gif" width=18 height=16 alt="<? echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"])?>" border="0" align="top"></a>-->
													<? }?>
													<!--<img src="../../images/tool.gif" alt="<? //echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"])?>" width=18 height=16 border="0" align="top" 
											 		style="cursor:pointer;cursor:hand"   											 
											 		onClick="MM_openBrWindow('edit.php?id=<? //echo $row["id"]?>&amp;folder=true&amp;fac=<? //echo $row["faculty"]?>&amp;dept=<? //echo $row["department"]?>&amp;major=<? //echo $row["major"]?>','edit','status=yes,scrollbars=yes,width=500,height=400')">-->											 
													<? //echo $rcheck; ?>
												</td>
									<?	}
                                	 }
								  ?>
                        </tr>
                        <?
                        if($row["folder"]==1){ ?>
							<!--<img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top">-->
                               <? rs($row["id"],$space.'<img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top">',$faculty,$department,$major,$check); ?>
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
  <table width="40%">
    <tr>
      <td>
          <div align="center">
            <input name="Back" type="button" id="Back" value="Back" onClick="location.href('index.php')" class="button">            
            </font></div>
          </td>
    </tr>
  </table> 
  
</div></body>
</html>
