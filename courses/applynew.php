<?   require("../include/global_login.php");  ?>
<html>
<head>
<title>Apply to course</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<?   include("../include/page_update.js");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<body bgcolor="#ffffff">
<?  /*     if($cpname!=$row["campus.NAME_THAI"]){
			    $cpname=$row["campus.NAME_THAI"];
			   echo $cpname;   	      */ 
?>
<!--
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="headfac" align="center">&nbsp;<? // echo $cpname; ?></td>
  </tr>
</table> -->
<? // } ?>
<table width="90%" border="1" cellspacing="0" cellpadding="5"  align="center" bordercolor="#CCCCCC">
  <tr> 
    <td colspan="6"> <div align="center"><font color="#993300" face="MS Sans Serif, Microsoft Sans Serif" size="1"> 
        <b>Available Courses </b></font></div></td>
  </tr>
  <tr> 
    <td><div align="center" class="res">Course ID</font></div></td>
    <td><div align="center" width="5%" class="res">Section (หมู่)</font></div></td>
    <td><div align="center" class="res">Course Name</font></div></td>
    <td><div align="center" class="res">Course Admin</font></div></td>
    <td><div align="center" width="6%" class="res">Apply Status</font></div></td>
    <td><div align="center" width="5%">&nbsp;</div></td>
  </tr>
<?  	//  $getcourse=mysql_query("SELECT c.* , fac.FAC_NAME,  campus.NAME_THAI  FROM courses as c, ku_faculty as fac, users as u , ku_campus as campus WHERE c.active=1 AND c.users=u.id  AND u.fac_id=fac.id  AND fac.CAMPUS_ID=campus.CAMPUS_ID ORDER BY  campus.NAME_THAI desc, fac.FAC_NAME, c.name;");
		$getcourse=mysql_query("SELECT c.* ,u.fac_id  FROM courses as c, users as u WHERE c.active=1 AND c.users=u.id ORDER BY u.fac_id desc, c.name;");		
       //  [from=applyfac.php]  $getcourse=mysql_query("SELECT c.id, c.name, c.fullname, c.users, c.active, u.fac_id , u.firstname, u.surname , u.email , u.id FROM courses  as c, users as u, ku_faculty as fac  WHERE fac.id=u.fac_id AND u.category=2 AND u.id=c.users AND c.active=1 AND ORDER BY fac.id, c.name; ");
		$cpname=""; $fcname="";
		
 while($row=mysql_fetch_array($getcourse))
  {
  		$ufac=mysql_query("SELECT kfac.FAC_NAME FROM ku_faculty as kfac WHERE kfac.id=".$row["fac_id"].";");
		$ucampus=mysql_query("SELECT kcampus.NAME_THAI FROM ku_campus as kcampus,ku_faculty as kfac  WHERE kcampus.CAMPUS_ID=kfac.CAMPUS_ID;");
	
		if(  ($fcname!=$ufac ) ||  ($cpname!=$ucampus)  ){
					
					if($cpname!=$ucampus)
					{    
							?><tr><td colspan="6"><b>วิทยาเขต</b><?
									echo $ucampus."<br>";
									$cpname=$ucampus;
					 }

					if( $fcname!=$ufac )
					{            
							?><tr><td colspan="6"><b>คณะ<?
									echo $ufac."<br>";
									$cpname=$ufac;
					}
					echo "</b></td></tr>";
		 }
        $open=$row["applyopen"];

        switch($open)
		{
			case 1:
					$td="Open";
					break;
			case 0:
					$td="<font color=\"#0000cc\"> Approve </font>";
					break;
			case -1:
					$td="<font color=\"#660000\"> Close </font>";
					break;
			default:
					$td="Open";
					break;
        }    //end switch
 ?>
  <tr> 
    <td class="info" align="center"><? if(  ($row["name"]!="") ||  ($row["name"]!=null) ){ echo $row["name"];  }else{  echo "&nbsp;";  } ?></td>
    <td class="info" align="center" width="5%"> 
      <? if ($row["section"] == "") 
		{
				$row["section"] = "&nbsp;";
		}
		echo $row["section"]; ?>
    </td>
    <td class="info" align="center"> <? echo $row["fullname"]."<br>".$row["fullname_eng"]; ?></td>
    <? $result=mysql_query("SELECT firstname,surname,email FROM users WHERE id=".$row["users"].";"); ?>
    <td class="info" align="center"><a href="mailto:<? echo @mysql_result($result,0,"email"); ?>"> 
      <? 
		if(   (@mysql_result($result,0,"firstname")!=""  || @mysql_result($result,0,"firstname")!=null) && (@mysql_result($result,0,"surname")!=""  || @mysql_result($result,0,"surname")!=null) ){
					echo @mysql_result($result,0,"firstname")."&nbsp;&nbsp;".@mysql_result($result,0,"surname");
		}else if(@mysql_result($result,0,"firstname")!=""  || @mysql_result($result,0,"firstname")!=null){
      	echo @mysql_result($result,0,"firstname");
	   }else if(@mysql_result($result,0,"surname")!=""  || @mysql_result($result,0,"surname")!=null){   
	   						echo "&nbsp;&nbsp;".@mysql_result($result,0,"surname");
	   					}else{   	echo "-"; }  ?>
      </a> </td>
    <td class="info" align="center" width="6%"><? echo $td; ?></td>
    <td class="info" align="center" width="5%"> 
      <?
	   if ($open == '-1')
		 {  
			?>
      <font color="red">close </font> 
      <?
		 } 
	    $membered=mysql_query("SELECT courses,users FROM wp WHERE courses=".$row["id"]." AND users=".$person["id"].";");
		if (mysql_num_rows($membered)>=1 && $open!='-1') 
		{ 
		   ?>
      <font color="cccccc">applied</font> 
      <?
		}
		if(mysql_num_rows($membered)==0 && $open!='-1') 
		 {  
			?>
      <a href="application.php?courses=<? echo $row["id"]; ?>">apply</a> 
      <?
		 } ?>
    </td>
    <? } // end while loop
  ?>
    <tr> 
    <td colspan="6" class="res"><b>Total Courses =<? echo @mysql_num_rows($getcourse);  ?></b></td>
  </tr>
</table>
</body>
</html>