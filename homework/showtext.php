<?    
	require("../include/global_login.php");
	 include("../include/function.inc.php");
	session_start();
	$session_id = session_id();
	require ("../include/global_login.php");
	require("../include/online.php");
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
			$uistyle = "teacher";
			break;
		default:
			$uistyle = "teacher";
		}

	require "./style/$uistyle/Scoreheader.php";
	require "./style/$uistyle/footer.php";
			
	
	$showtext=mysql_query("SELECT * FROM homework_ans WHERE id=".$id.";");
	$userinfo=mysql_query("SELECT login,firstname,surname,email FROM users WHERE id=".@mysql_result($showtext,0,"users").";"); 
?>
	
    <link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">	
	<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />	!-->
    
	<table border="0" cellpadding="2" cellspacing="0" width="100%" >
  	<tr> 
    	<td width="100%" valign="top"><h1><?php echo "Answer for this Question";?></h1></td>
  	</tr>
	</table>
	<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tdborder2">	
	<tr>
		<td width="100%" valign="top">		
			<table cellspacing="1" cellpadding="2" border="0" width="100%"  class="tdbo">
          <tr class="boxcolor"> 
            <th align="right" nowrap class="Bcolor"  ><? echo $user->_($strHome_LabAnswer); ?>:</th>
            <td class="tdbackground1" width="100%" > 
				<? 				
	            if(@mysql_result($showtext,0,"name")!="" && @mysql_result($showtext,0,"name")!=none )
				{   
					echo nl2br(@mysql_result($showtext,0,"name")); 
				}
				if(@mysql_result($showtext,0,"url")!="" && @mysql_result($showtext,0,"url")!=none )
				{ 
				?>
				<a href="<? echo @mysql_result($showtext,0,"url"); ?>" target="_blank">
				<b><? echo @mysql_result($showtext,0,"url");  ?></b></a>
				<?  
				}
				if(@mysql_result($showtext,0,"file")!="" && @mysql_result($showtext,0,"file")!=none )
				{ 
				//echo $hw_id;
				?>
				<!--<a href="../files/homework/ansfiles/<? echo $hw_id; ?>/<? echo @mysql_result($showtext,0,"file"); ?>">-->
				<hr>
				<table width="100%" border="0" cellspacing="0" cellpadding="1" >
				  <tr>
					<td width="7%"><? echo $user->_($strHome_LabFile); ?> :</td>
					<td width="93%"  class="hilite" bgcolor="#FFFFFF">
					<?
						$pos = strrpos(@mysql_result($showtext,0,"file"), ".");
						$rest = substr(@mysql_result($showtext,0,"file"), $pos+1);
						//if($rest == "gif" || $rest == "jpg" || $rest == "jpeg" || $rest == "png"){	
					?>	
						<!--<img src="../files/homework/ansfiles/<? echo $hw_id; ?>/<? echo @mysql_result($showtext,0,"file");?>" border="0">
                        <a href="../download.php?m=hwans&id=<?php echo $hw_id; ?>&filename=<?php echo @mysql_result($showtext,0,"file");?>&courses=<?php echo $courses; ?>">-->
					<?
						//} else {
					?>
                    <a href="../download.php?m=hwans&id=<?php echo $hw_id; ?>&filename=<?php echo @mysql_result($showtext,0,"file");?>&courses=<?php echo $courses; ?>">
					<!--<a href="../files/homework/ansfiles/<? echo $hw_id; ?>/<? echo @mysql_result($showtext,0,"file"); ?>">-->
					<?
						echo @mysql_result($showtext,0,"file"); 
					?>
					</a>
					<?
						//}
					?>							
					</td>
				  </tr>
				</table>							
				<b>
				<? 
				//echo @mysql_result($showtext,0,"file"); 
				} 
				?>
				</b></a>			
            </td>
          </tr>
        </table>
		</td>	 
	</table> 
    
	<form name="getPoint" method="post" >     
	  <table border=0 cellpadding="3" cellspacing="1" class="tdborder2" width="100%">
		<tr bgcolor="#FFFFFF"> 
		  <td colspan="2" class="hilite"> <input type="submit" name="savePoints" value="<? echo $user->_($strSave); ?>" id="savePoints2" class="button"> 
			<input name="button" type="button" onClick="window.close()" value="<? echo $user->_($strClose); ?>" class="button"> 
		  </td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td >&nbsp;</td>
		</tr>
		<tr> 
		  <td width="12%" class="hilite"><div align="right"><? echo $user->_($strPersonal_LabUserName);?>:</div></td>
		  <td width="88%" class="hilite"><? echo @mysql_result($userinfo,0,"login");  ?></td>
		</tr>
		<tr> 
		  <td class="hilite"><div align="right"><? echo $user->_($strCourses_LabStdName);?>:</div></td>
		  <td class="hilite"><? echo @mysql_result($userinfo,0,"firstname")." ".@mysql_result($userinfo,0,"surname");  ?></td>
		</tr>
		<tr> 
		  <td class="hilite"><div align="right"><? echo $user->_($strPersonal_LabEmail);?>:</div></td>
		  <td class="hilite"><a href="mailto:<? echo @mysql_result($userinfo,0,"email"); ?>"> 
			<?  echo @mysql_result($userinfo,0,"email"); ?>
			</a></td>
		</tr>
		<tr> 
		  <td class="hilite" ><div align="right"><? echo $user->_($strHome_LabScore); ?> :</div></td>
		  <td class="hilite" > 
		  <?
		  	$scores=mysql_query("SELECT * FROM homework WHERE modules=".@mysql_result($showtext,0,"modules")." AND id=".@mysql_result($showtext,0,"refid").";");
		  ?>		  
		  <input type="text" name="point" value=<? if(@mysql_result($showtext,0,"marks")!=""){ echo @mysql_result($showtext,0,"marks");}else{ echo "0";}; ?> class="text" size="<? echo strlen(@mysql_result($scores,0,"points"));?>" maxlength="<? echo strlen(@mysql_result($scores,0,"points"));?>"> 
		  <?        		  	
			if( @mysql_result($scores,0,"points")!="" && @mysql_result($scores,0,"points")!=none )
			 {   
			 	echo " ( Max.=".@mysql_result($scores,0,"points").")"; 
			 }  
		  ?>
		  <input type="hidden" name="max" value="<?php echo @mysql_result($scores,0,"points");?>" />
		  </td>
		</tr>
		<tr> 
		  <td></tr>
		<br>
	  </table>
	</form>
<?
//}else{  
if($savePoints)
{   	 
		 if($point > $max) {
		 	print("<script language='javascript'>alert('Point must input number less than $max.');</script>");	
		 } else {
			 if($point=='0') $point='0.0'; 
			 if( $point!="" && $point!=none && $point!=@mysql_result($showtext,0,"points") )
				{ 
				   /*	
				   print("<script language='javascript'>alert('update homework_ans set marks=$point where id=$id'); opener.refresh; window.close; </script>");  
				   */
					 //Modules_id
					$modulesid=mysql_query("SELECT modules  FROM homework WHERE id =".$hw_id.";");
					$modules=mysql_result($modulesid,0,"modules");
				   //Courses_id
					$courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$modules.";");
					$courses=mysql_result($courseid,0,"courses");

				   	//***********insert modules_history***************
					$action="Check answer";
					Imodules_h(@mysql_result($showtext,0,"modules"),$action,$person["id"],$courses);
	
				   mysql_query("UPDATE homework_ans SET marks=$point, examiner=".$person["id"]." WHERE id=$id;");
				   print("<script language='javascript'> window.opener.location.reload(); window.close(); </script>");  
				}
		}	
}   
?>