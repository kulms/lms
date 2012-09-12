<?	require("../include/global_login.php"); 

	    $check=mysql_query("SELECT * FROM wp WHERE users=".$person["id"]." AND courses=".$courses." AND admin=1;");
if($person["admin"]==1 || (mysql_num_rows($check)!=0 && $courses!=0))
{
  if($update!="true")
  {     if($courses==0)
		{          $course["id"]=0;
                   $course["name"]="";
                   $course["active"]=1;
                   $course["applyopen"]=1;
                   $course["info"]="";
                   $course["users"]=$person["id"];
        }else{ $check=mysql_query("SELECT * FROM courses WHERE id=$courses;");
                   $course=mysql_fetch_array($check);
       		     }   ?>
<html>
<head>
<title>Course On Web  - Courses</title>
<script language="javascript">
	function startup()
	{
			document.course.elements["courseusers[]"].options[0]=null;
			document.course.elements["users[]"].options[0]=null;
	}
	function addadmin()
	{		for(a=document.course.elements["users[]"].options.length-1;a>-1;a--)
			{		if(document.course.elements["users[]"].options[a].selected)
					{						document.course.elements["courseusers[]"].options[document.course.elements["courseusers[]"].options.length]=new Option(document.course.elements["users[]"].options[a].text,document.course.elements["users[]"].options[a].value);
							document.course.elements["users[]"].options[a]=null;
					}
			}
			mark_all();
	}
	function removeadmin()
	{		for(a=document.course.elements["courseusers[]"].options.length-1;a>-1;a--)
			{		if(document.course.elements["courseusers[]"].options[a].selected)
					{							document.course.elements["users[]"].options[document.course.elements["users[]"].options.length]=new Option(document.course.elements["courseusers[]"].options[a].text,document.course.elements["courseusers[]"].options[a].value);
							document.course.elements["courseusers[]"].options[a]=null;
					}
			}
			mark_all();
	}
	function mark_all()
	{
			for(a=0;a<document.course.elements["courseusers[]"].options.length;a++)
			{
					document.course.elements["courseusers[]"].options[a].selected=true;
			}
	}
	function sendform()
	{		mark_all();
			if(confirm('Make sure that all the administrators are selected (highlighted) in the administratorslist.\nOK to send?'))
			{
					document.course.update.value = "true";	
					document.course.submit();
			}
	}
	function Closeform()
	{
			window.opener.location.reload();
			window.close();
	}
</script>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
</head>
<body bgcolor="#ffffff" <? if($search_coAdmin) echo "onLoad=\"startup()\"";?>> 
		<table border="0" align="center" cellpadding="5" cellspacing="5"  class="tdborder2">
		<form action="add_admin_course.php" method="post" name="course">
		<input type="hidden" name="courses" value="<? echo $courses; ?>">
		<input type="hidden" name="update" value="false">
		<tr>
				<td colspan="3"  align="center"><h1>Edit Course Administrators</h1></td>
		</tr>
		<tr>
				<td colspan="3" class="main" align="center">&nbsp;</td>
		</tr>
		<tr>				
      <td colspan="3" class="main" align="center"> 
<?   $check=mysql_query("SELECT * FROM users WHERE id=".$course["users"].";");
?>  Course created by : <b><? echo @mysql_result($check,0,"firstname")." ".@mysql_result($check,0,"surname"); ?></b></td>
		</tr>
		<tr>
				<td colspan="3" align="center" valign="top" class="hilite">				
				<table border="0">
          <tr>
            <td align="right" valign="middle" class="hilite"><b>Search By </b></td>
            <td align="left" valign="bottom" class="hilite"> 
              <select name="searchCond">
                <option value="all">----- All -----</option>
                <option value="login">Login</option>
                <option value="firstname">Firstname</option>
                <option value="surname">Surname</option>
              </select></td>
          </tr>
          <tr> 
            <td width="45%" align="right" valign="middle" class="main"><b>Search Co-Admin.</b></td>
            <td width="55%" align="left" valign="bottom"><input name="coAdmin" type="text" id="coAdmin"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td align="left" valign="top"><input name="search_coAdmin" type="submit" id="search_coAdmin" value="S e a r c h" class="button"></td>
          </tr>
        </table></td>
		</tr>
		<tr>
				<td colspan="3" class="main" align="center">&nbsp;</td>
		</tr>								
		<tr>
  	      <td colspan="3" class="main" align="center">
	      <table border="0" cellpadding="2" cellspacing="0">
			<tr>						
            <td align="center" class="hilite" valign="top"> <div align="center"><b>Administrators</b><br>
                <select multiple name="courseusers[]" size="15">
                  <option value="0">---------------------------- 
                  <?   $admins=mysql_query("SELECT u.id,u.firstname,u.surname,u.login 
						 FROM  users u,wp,courses c 
						 WHERE c.id=".$course["id"]." AND c.id=wp.courses AND wp.users=u.id AND wp.admin=1 AND 
							   u.active=1 AND wp.courses=".$course["id"]." AND wp.modules=0 AND wp.folders=0 AND 
							   wp.groups=0 AND wp.cases=0 
						 ORDER BY u.firstname ASC, u.surname ASC");				
					$AdminID = "";
					while($row=mysql_fetch_array($admins))
					{  ?><option value="<? echo $row["id"]; ?>"><?
						  echo $row["firstname"]."_".$row["surname"]."_(".$row["login"].")"; 
						  $AdminID.= " id != ".$row["id"]." AND ";
					}  ?> 
                </select></div></td>
			<td align="center" class="small" valign="top">
				<br><br>
				<input type="button" value=" << " onClick="addadmin()"  class="button">
				<br><br>
				<input type="button" value=" >> " onClick="removeadmin()" class="button">
			</td>						
            <td align="center" class="hilite" valign="top"><b>Other users</b><br>
              <select multiple name="users[]" size="15">
                <option value="0">---------------------------- 
<?	   if(mysql_num_rows($admins)!=0)
			{		
					mysql_data_seek($admins,0);
			}		
		            $mypos=0;
			if($search_coAdmin)
			{ 		$coAdmin = trim($coAdmin);
					$sql = "SELECT id,login,firstname,surname FROM users WHERE active=1 ";
				  if($AdminID!="")
						$sql = $sql." AND ".substr($AdminID,0,strlen($AdminID)-4);				
 				  if($searchCond!="all")
					{	        $users=mysql_query($sql." AND ".$searchCond." LIKE '%$coAdmin%' ORDER BY firstname ASC,surname ASC;");
				    }else{	$users=mysql_query($sql." AND  ( login LIKE '%$coAdmin%' OR firstname LIKE '%$coAdmin%' OR surname LIKE '%$coAdmin%' ) ORDER BY firstname ASC,surname ASC;");
						     }
					while($row=mysql_fetch_array($users))
					{		$show=1;
							if($mypos<mysql_num_rows($admins))
							{	
								if(@mysql_result($admins,$mypos,"id")==$row["id"])
									{
											$show=0;
											$mypos++;
									}
							}
							if($show==1)
							{   ?><option value="<? echo $row["id"]; ?>"><? if($row["firstname"]!="" || $row["firstname"]!=none || $row["surname"]!="" || $row["surname"]!=none || $row["login"]!="" || $row["login"]!=none ){ echo $row["firstname"]."_".$row["surname"]."_(".$row["login"].")"; }else{ echo "Search not Found!"; }
							}
					} 
			} ?></select> </td>
			 <? // print($testsql);  ?>
			    </tr>
				</table>
				</td>
		</tr>
		<tr>	<td colspan="3" align="center"  valign="top">
						<input type="button" value="  U p d a t e  " onClick="sendform()" class="button"> &nbsp;
						<input type="button" value="  C l o s e  " onClick="Closeform()" class="button">
				</td>
		</tr>
</form>
</table>
</body>
</html>
<?
 }else{  // UPDATE is true
		   mysql_query("UPDATE wp SET admin=0 WHERE courses=$courses AND not users=0 AND users!= ".$person["id"]);	
        if(is_array($courseusers))
		{	
			while(list($key,$val)=each($courseusers))
				{	
						$check=mysql_query("SELECT * FROM wp WHERE users=$val AND courses=$courses;");
                        if(mysql_num_rows($check)!=0)
						{           mysql_query("UPDATE wp SET admin=1 WHERE users=$val AND courses=$courses;");
                        }else{ 
							        mysql_query("INSERT INTO wp(users,courses,admin) VALUES($val,$courses,1);");
                                 }
                }
        }
		 if(is_array($users))
		{	   while(list($key,$val)=each($users))
				{	 $check=mysql_query("SELECT * FROM wp WHERE users=$val AND courses=$courses;");
                      if(mysql_num_rows($check)!=0)
					  {           mysql_query("UPDATE wp SET temp=0 WHERE users=$val AND courses=$courses;");
                      }else{
								  mysql_query("INSERT INTO wp(users,courses,temp) VALUES($val,$courses,0);");
                              }
                }
        }
		echo("<script language='javascript'>window.opener.location.reload(); window.close();</script>");
 }
}else{	//User don't have access to this script
    ?><html>
        <head>
        <title></title>
        <link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
        </head>
        <body bgcolor="#ffffff">
        <p>&nbsp;</p>
        <div align="center" class="h3">Sorry, you are not permitted to create or edit a course!</div>
        </body>
        </html>
<?     }      ?>