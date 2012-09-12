<?	
session_start();

require("../../include/global_login.php");
require("../../include/online.php");
require("../../include/function.inc.php");
require("message.class.php");
include('classes/config.inc.php');

$message =new Message('',$person['id']);    
/*
if($_POST[mSbj] != ""){
		 $_SESSION[mSbj]= $_POST[mSbj];
		session_register("mSbj");
}
if($_POST[mPri] !="") {
		$_SESSION[mPri] =$_POST[mPri];
		session_register("mPri");
}
if($_POST[mMsg] !="") {
		$_SESSION[mMsg] =$_POST[mMsg];
		session_register("mMsg");
}  */

 if($update){
				//echo count($courseusers);
				session_unregister("sendperson");
				session_unregister("allperson");
		$sendperson =array();
		for($i=0;$i<count($courseusers);$i++){
		
				$sendperson[] =  $courseusers[$i];
								//echo "==============".$_SESSION["sendperson"]= $courseusers[$i];
				}   
				
				session_register("sendperson");
				$allperson = count($courseusers);
				session_register("allperson");
				
echo "<script >window.opener.location.reload(); window.close(); </script>";
			
} 
				  ?>
<html>
<head>
<title>Send Message To ::....</title>

<script language="JavaScript" type="text/javascript">
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
				{    var v= document.course.elements["courseusers[]"].options[a].value;
							if(v !=0){                 // alert(v);
								document.course.elements["courseusers[]"].options[a].selected=true;
								}
				}
	}
	
	function sendform()
	{		
			mark_all();
		document.course.submit();
	}
	


	function Closeform()
	{
			window.opener.location.reload();
			window.close();
	}
</script>
<link rel="STYLESHEET" type="text/css" href="../../themes/<?php echo $theme;?>/style/main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<body> 

		<table border="0" width="100%" align="center" cellpadding="3" cellspacing="5"  class="tdborder2">
		<form action="selectName.php" method="post" name="course" >
		<input type="hidden" name="to_id" value="<? echo $to_id; ?>">
		
		<tr>
				<td colspan="3"  align="center"><h1>Send Message To</h1></td>
		</tr>
		<tr>
				<td colspan="3" class="main" align="center">&nbsp;</td>
		</tr>
		
		<tr>
		  <td colspan="3" align="center" valign="top" class="hilite">				
				<table width="90%" border="0" cellpadding="3" class="tdborder1"  cellspacing="1">
          <tr bgcolor="#FFFFFF">
            <td align="right" valign="middle" class="hilite"><b>Search By : </b></td>
            <td align="left" valign="bottom" class="hilite"> 
         	    <select name="userCat" size="1" onChange="course.submit();"  class="text">
                <option value="0">=== All user ===</option>
                <option value="1"  <?=($userCat==1)?"selected":""?>>Admin</option>
                <option value="2" <?=($userCat==2)?"selected":""?>>Teacher</option>
                <option value="3" <?=($userCat==3)?"selected":""?>>Student</option>
              </select>
		    </td>
          </tr>
		  <?   // echo $userCat;

		  if($userCat ==3 && $person[category]==2){  //  select  Course
				@list($cid,$cname,$cfullname) = $message->getCourseOfUser($person[id]);
		  ?>
		  
          <tr>
            <td colspan="2" align="right" >
			<table width="100%" border="0" cellpadding="3" class="tdborder2"  cellspacing="0">
          <tr class="boxcolor">
		  <td width="39%" align="right" class="bcolor">
			<b>Student Of Course : </b></td>
			
            <td width="61%" align="left">
			  <select name="cos"  class="text" >
                <option value="0">===Select Course ===</option>
		<? 
		 $sel ="";
		 for($x=0;$x<count($cid);$x++){
					if($cos==$cid[$x]) $sel = "selected";
				     echo "<option value=\"$cid[$x]\" $sel>$cname[$x] : $cfullname[$x]</option>";
					 } 
			 ?>
		    </select></td>
          </tr></table>	</td>
            </tr>
		  <? } ?>
		  
          <tr bgcolor="#FFFFFF"> 
            <td width="39%" align="right" valign="middle" class="main"><b>Firstname :</b></td>
            <td width="61%" align="left" valign="bottom"><input name="fname" type="text"  size="30" class="text" value="<?=$fname?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td align="right" ><b>Lastname : </b></td>
            <td align="left" valign="top"><input name="lname" type="text"  size="30" class="text"  value="<?=$lname?>"></td>
          </tr>
          <tr align="center" > 
            <td colspan="2"><input name="search" type="submit" id="search" value="Search..." class="button"></td>
            </tr>
        </table>				</td>
		</tr>
		<tr>
				<td height="49" colspan="3" align="center" valign="bottom" class="red">* Please select name in the box on your right into the box on your left </td>
		</tr>								
		<tr>
  	      <td colspan="3" class="main" align="center">
	      <table border="0" cellpadding="2" cellspacing="0">
			<tr>						
            <td align="center" class="hilite" valign="top"> <div align="center"><b>Send Message To</b><br>
                <select multiple name="courseusers[]" size="15">
                  <option value="0">---------------------------- </option>
               <?
				
							
				  if($to_id !="" && $to_id !=0){
				    @list(,$to_firstname,$to_surname) =  $message->GetDetailPerson($message,$to_id);
				  		echo "<option value=$to_id>$to_firstname  $to_surname</option>";
				  }
				
		  if($allperson >0){
				for($a=0;$a<$allperson;$a++){
						@list($aid,$firstname,$surname,$email,$category,$admin) =$message->GetDetailPerson($message,$sendperson[$a]);
						echo "<option  value=$aid> $firstname $surname";
						//echo  "+++++".$sendperson[$i];
					}
		}
				  ?> 
                </select></div></td>
			<td align="center" class="small" valign="top">
				<br><br>
				<input type="button" value=" << " onClick="addadmin()"  class="button">
				<br><br>
				<input type="button" value=" >> " onClick="removeadmin()" class="button">
			</td>						
            <td align="center" class="hilite" valign="top"><b>Other users</b><br>			
			<select multiple name="users[]" size="15" >
              <option value="0">----------------------------</option>
              <?	
			    if($search){
				//echo "======".$cos;
				
				@list($id,$login,$firstname,$surname) =  $message->getListUser($fname,$lname,$userCat,$cos);
							
							for($i=0;$i<count($id);$i++){
							       echo "<option value=$id[$i]>".$firstname[$i]." ".$surname[$i]."</option>";
								//echo $id[$i],$login[$i],$firstname[$i],$surname[$i];  echo "<br>";
							}
			  }
				  
				      ?>
                        </select> </td>
			 <? // print($testsql);  ?>
			    </tr>
				</table>
				</td>
		</tr>
		<tr>	<td colspan="3" align="center"  valign="top">
						<input type="submit" value=" OK " name="update" onClick="sendform()" class="button"> &nbsp;
						<input type="button" value=" Close " onClick="Closeform()" class="button">
				</td>
		</tr>
</form>
</table>
</body>
</html>
