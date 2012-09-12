<?php   
session_start();
$session_id = session_id();
require("../include/global_login.php");
require ("../include/global_login.php");
require("../include/online.php");
require_once ("./classes/User.php");
require_once ("./classes/UserStorage.php");
require_once( "./includes/main_functions.php" );
	
$user = UserStorage::lookupById($person["login"]);

session_register( 'user' ); 

//online_courses($session_id,$person["id"],$courses,time(),1);

switch ($user->getCategory()) {
    case 0:
        $uistyle = "admin";
		$id = $modules;	
        break;
    case 1:
        $uistyle = "admin";
		$id = $modules;	
        break;
    case 2:
        $uistyle = "teacher";
		$id = $modules;	
        break;
	case 3:
        $uistyle = "student";
		$id = $modules;	
		break;
	default:
        $uistyle = "guest";
		$id = $modules;	
	}

	

require "./style/$uistyle/header.php";
require "./style/$uistyle/footer.php";	

//$info=mysql_query("SELECT id,users,name FROM modules WHERE users=".$person["id"]." AND id=$modules;");
$info=mysql_query("SELECT m.id, m.users, m.name FROM modules m, wp WHERE m.id=$modules and m.id=wp.modules AND wp.users=".$person["id"].";");
$hw_pref=mysql_query("SELECT * FROM homework_prefs WHERE modules=$modules;");
$end_date = @mysql_result($hw_pref,0,end_date);
//echo date("d-m-y",$end_date);

$userright=mysql_num_rows($info);
if ($userright==1)
{   ?><html>
        <head>
        <title></title>
        <LINK REL=STYLESHEET TYPE="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
		<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />-->
<script LANGUAGE="JavaScript">
parent.aktiv=1;
var win = null;
function edit(id,hw_id,course_id)
	{	
			LeftPosition = (screen.width) ? (screen.width-550)/2 : 0;
			TopPosition = (screen.height) ? (screen.height-400)/2 : 0;
			settings =
			'height='+400+',width='+550+',top='+TopPosition+',left='+LeftPosition+',scrollbars=yes,resizable=yes';		
			window.open("showtext.php?id=" + id + "&hw_id="+hw_id+ "&courses="+course_id, "edit", settings);
	}
</script>
<script language="JavaScript">
		function mouseOverRow(gId, onOver){	
			if(document.getElementById){
				if(onOver==1)
					//eval("document.getElementById('trE" + gId + "')").bgColor="#FFF5E8";
					eval("document.getElementById('trE" + gId + "')").bgColor="#B3F2EF";
					//eval("document.getElementById('trE" + gId + "')").bgColor="#FFFFFF";					
				else
					eval("document.getElementById('trE" + gId + "')").bgColor="#FFFFFF";		
			}//end if
		}//end function
</script>
</head>
        <body bgcolor="#ffffff">
        <div align="center"></div>
<?
$next=mysql_query("SELECT id,modules FROM homework WHERE modules=$modules ORDER BY id;");
$count=mysql_query("SELECT count(id) as cnt FROM homework WHERE modules=$modules;");
$last=@mysql_result($count,0,"cnt");
$hw_id=@mysql_result($next,$num,"id");
$assginfo=mysql_query("SELECT * FROM homework WHERE id=$hw_id;");
/*
if($desc==1){
	if($sort == "date"){
		$descend = " time DESC";
	}			
	if($sort == "scores"){
		$descend = " marks DESC";
	}			
}else{
		$descend = " time";
}
*/
switch($sortby){
	case "1":
		$orderstring="ha.time ";
		$orderstr_name = "";
		break;
	case "2":
		$orderstring="ha.marks ";
		$orderstr_name = "";
		break;
	case "3":
		$orderstring="u.login ";
		$orderstr_name = "login ";
		break;
	case "4":
		$orderstring="u.firstname ";
		$orderstr_name = "firstname ";
		break;	
	default:
		$orderstring="ha.id ";
		$orderstr_name = "";
		break;
}//end switch

switch($sortorder){
	case "1":
		$order="ASC";
		if($orderstr_name == "") 
		{
			$order_name = "";
		} else {
			$order_name = "ASC";
		}	
		break;
	case "2":
		$order="DESC";
		if($orderstr_name == "") 
		{
			$order_name = "";
		} else {
			$order_name = "DESC";
		}	
		break;
	default:
		$order="ASC";
		if($orderstr_name == "") 
		{
			$order_name = "";
		} else {
			$order_name = "ASC";
		}	
		break;
}//ens switch
//echo "SELECT ha.*, u.login, u.firstname FROM homework_ans ha, users u WHERE ha.refid=$hw_id AND ha.modules=$modules AND ha.users = u.id ORDER BY ".$orderstring." $order;";
$hwans=mysql_query("SELECT ha.*, u.login, u.firstname FROM homework_ans ha, users u WHERE ha.refid=$hw_id AND ha.modules=$modules AND ha.users = u.id ORDER BY ".$orderstring." $order;");  
?>
<table border="0" cellpadding="2" cellspacing="0" width="100%" >
  <tr> 
    <td width="100%" valign="top"><h1><? echo $user->_($strResult.$strHome_LabQuestion);?></h1></td>
  
</table>
<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tdborder2">	
	<tr>
		<td width="100%" valign="top">		
			<table width="100%" border="0" cellpadding="2" cellspacing="1">
          <tr class="boxcolor"> 
            <th align="right" nowrap   class="Bcolor"><? echo $user->_($strHome_LabQuestion);?></th>
            <td width="100%" bgcolor="#FFFFFF" class="hilite"> <? echo  nl2br(@mysql_result($assginfo,0,"name")); ?> 
            </td>
          </tr>
        </table>
		</td>	 
</table>                
<br>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tdborder2">
  <tr>
    <td>
	<form>   
	 <table width="100%" border="0" cellspacing="0" cellpadding="4">
	  <tr  bgcolor="#FFFFFF">
    	<td class="hilite">		    
      		<input type="button" value="<? echo $user->_($strHome_LabShowAll);?>" onClick="{location='showall.php?id=<? echo $modules; ?>';}" class="button">
      		<input type="button" value="<? echo $user->_($strHome_LabShowAllText);?>" onClick="{location='showalltext.php?hw_id=<? echo $hw_id; ?>&modules=<? echo $modules; ?>';}" class="button">
      	<?
	  	if (@mysql_result($assginfo,0,"sendtype") == 3){
	  	?>
      		<input type="button" name="Submit" value="<? echo $user->_($strHome_LabZip);?>" class="button" onClick="{location='zip.php?hw_id=<? echo $hw_id; ?>&modules=<? echo $modules; ?>&courses=<?php echo $courses;?>';}">
      	<? }?>     	 	
		</td>
  	</tr>
	</table>
	</form>
	<table width="100%" border="0" cellspacing="0" cellpadding="4">
	  <tr>
		<td>
		<table width="100%" cellspacing="1" cellpadding="2" border="0" align="center"> 
					
	  	<tr class="boxcolor"> 
			<td align="center"  class="Bcolor"><b><? echo $user->_($strHome_LabNo);?></b></td>
							
			<td align="center"  class="Bcolor"><b><? echo $user->_($strPersonal_LabUserName);?></b>
			<? if($sortorder!= 1 && $sortby==3){?>
				<a href="showdetail.php?modules=<? echo $modules; ?>&num=<? echo $num; ?>&sortorder=1&sortby=3">
					<img src="../images/drop2.gif" width=12 height=10 alt="Sort descending" border="0">
				</a>
			<? } else {?>
				<a href="showdetail.php?modules=<? echo $modules; ?>&num=<? echo $num; ?>&sortorder=2&sortby=3">
					<img src="../images/drop_up.gif" width=12 height=10 alt="Sort ascending" border="0">
				</a>		
			<? } ?>
			</td>
							
			<td align="center"  class="Bcolor"><b><? echo $user->_($strCourses_LabStdName);?></b>
			<? if($sortorder!= 1 && $sortby==4){?>
				<a href="showdetail.php?modules=<? echo $modules; ?>&num=<? echo $num; ?>&sortorder=1&sortby=4">
					<img src="../images/drop2.gif" width=12 height=10 alt="Sort descending" border="0">
				</a>
			<? } else {?>
				<a href="showdetail.php?modules=<? echo $modules; ?>&num=<? echo $num; ?>&sortorder=2&sortby=4">
					<img src="../images/drop_up.gif" width=12 height=10 alt="Sort ascending" border="0">
				</a>		
			<? } ?>
			</td>
							
			<td align="center"  class="Bcolor"><b> 
		  	<?    
				$sendtype=@mysql_result($assginfo,0,"sendtype");
				 switch ($sendtype) 
				{	   case 1:
						   echo $strHome_LabText;
						   break;
					   case 2:
							echo $strHome_LabUrl;
						   break;
					   case 3:
						   echo $strHome_LabFile;
						   break;
					}      /*<!--  if (mysql_result($assginfo,0,"sendtype") == 1){  echo "Text";    }
			   if (mysql_result($assginfo,0,"sendtype") == 2){     echo "URL"; } 
			   if (mysql_result($assginfo,0,"sendtype") == 3){ echo "File"; }	-->*/   
			   ?>
		  	</b></td>
							
		<td align="center"  class="Bcolor"><b><? echo $user->_($strHome_LabDateTime);?></b>
		<? if($sortorder!= 1 && $sortby==1){?>
			<a href="showdetail.php?modules=<? echo $modules; ?>&num=<? echo $num; ?>&sortorder=1&sortby=1">
				<img src="../images/drop2.gif" width=12 height=10 alt="Sort descending" border="0">
			</a>
		<? } else {?>
			<a href="showdetail.php?modules=<? echo $modules; ?>&num=<? echo $num; ?>&sortorder=2&sortby=1">
				<img src="../images/drop_up.gif" width=12 height=10 alt="Sort ascending" border="0">
			</a>		
		<? } ?>
		
		  
		</td>
							
		<td align="center" class="Bcolor" ><b><? echo $user->_($strHome_LabScore);?> 
		  <?
							 if( (@mysql_result($assginfo,0,"points")!="") && (@mysql_result($assginfo,0,"points")!=none) )
							{	  echo "(Max.=".@mysql_result($assginfo,0,"points").")"; 
							}else{	echo" "; } ?>
		  </b>
		  
		  <? if($sortorder!= 1 && $sortby==2){?>
			<a href="showdetail.php?modules=<? echo $modules; ?>&num=<? echo $num; ?>&sortorder=1&sortby=2">
				<img src="../images/drop2.gif" width=12 height=10 alt="Sort descending" border="0">
			</a>
		  <? } else {?>
			<a href="showdetail.php?modules=<? echo $modules; ?>&num=<? echo $num; ?>&sortorder=2&sortby=2">
				<img src="../images/drop_up.gif" width=12 height=10 alt="Sort ascending" border="0">
			</a>		
		  <? } ?>
		
		  </td>
			  </tr>
	<?  	$number=1;
	if (mysql_num_rows($hwans) != 0)
	{   while($row=mysql_fetch_array($hwans))
		{  	
			//if($orderstr_name != "") {
				//echo "SELECT login,firstname,surname,email FROM users WHERE id=".$row["users"]." ORDER BY ".$orderstr_name." $order_name;";			
			//	$userinfo=mysql_query("SELECT login,firstname,surname,email FROM users WHERE id=".$row["users"]." ORDER BY ".$orderstr_name." $order_name;"); 
			//} else {
				$userinfo=mysql_query("SELECT login,firstname,surname,email FROM users WHERE id=".$row["users"].";"); 
			//}
	?>
			<tr id="trE<? echo $number;?>" onMouseOver="mouseOverRow('<? echo $number;?>', 1);" onMouseOut="mouseOverRow('<? echo $number;?>', 0);" bgcolor="#FFFFFF">
				<td  align="center"><? echo $number++; ?></td>
				<td  align="center"><a href="mailto:<? echo @mysql_result($userinfo,0,"email");  ?>"><? echo @mysql_result($userinfo,0,"login"); ?></a></td>
				<td ><a href="showusers.php?id=<? echo $modules;?>&users=<? echo $row["users"];?>"><? echo  @mysql_result($userinfo,0,"firstname")." ".@mysql_result($userinfo,0,"surname"); ?></a></td>
				<td  align="center">
				<? if ($row["name"] != ""){ ?><a href="JavaScript:edit(<? echo $row["id"].",$hw_id,$courses"; ?>)"><? echo $strHome_LabText;}//echo "Show text"; } ?></a>
				<? if ($row["url"] != ""){ ?><a href="<? echo $row["url"]; ?>" target="_blank"><? echo $strHome_LabUrl;}//echo $row["url"]; } ?></a>
				<? if ($row["file"] != ""){ ?><a href="../download.php?m=hwans&id=<?php echo $hw_id; ?>&filename=<?php echo $row["file"]?>&courses=<?php echo $courses; ?>" target="_blank"><? echo $strHome_LabFile;}//echo $row["file"]; } ?></a></td>
				<td align="center" class="red" >
				<? if($row["time"] > $end_date) {?>
					<? echo  date("d-m-Y H:i",$row["time"]); ?>
				<? } else {?>
					<? echo  date("d-m-Y H:i",$row["time"]); ?>
				<? }?>
				</td>
				<td align="center"><? 
					if( ($row["marks"]!="" && $row["marks"]!=none) || ($row["examiner"]!="" && $row["examiner"]!=none) )
					{	       //echo $row["marks"]." ( by: ".$ex.")";
						$ex=mysql_query("SELECT u.login FROM users as u WHERE u.id=".$row["examiner"].";");				
					?><a href="JavaScript:edit(<? echo $row["id"].",$hw_id,$courses"; ?>)"><? echo $row["marks"]." (by: ".@mysql_result($ex,0,"login").")"; ?></a>
					<?	}else{  ?>
					<a href="JavaScript:edit(<? echo $row["id"].",$hw_id,$courses"; ?>)">
					<? echo $user->_($strHome_LabNoScore); ?>
					</a>
					<?  } ?>
					
				</td>
		</tr>
	<?    } // end  while
	  }   // end   if                ?>
		    </table>
		</td>
	  </tr>
	</table><br>	

<table border=0 width="100%" cellspacing="0" cellpadding="2">
                 <tr>
    <td width="50%" class="hilite"> 
      <?
							if ($num > 0)
							{ ?>

					      <input name="back" type="button" id="back" class="button" value="< <? echo $user->_($strBack);?>" onClick="location = 'showdetail.php?num=<? echo $num-1;  ?>&modules=<? echo $modules; ?>';">

      <? 
							} ?>
    </td>
                         
    <td width="50%" align="right" class="hilite"> 
      <? 
							if ($num < $last-1) 
							{ ?>

							<input name="next" type="button" id="next" value="<? echo $user->_($strNext);?> >" class="button" onClick="location = 'showdetail.php?num=<? echo $num+1; ?>&modules=<? echo $modules; ?>';">

      <? 
							} ?>
    </td>
  </tr>
   </table>
	</td>
  </tr>
</table>
<?  } else { echo "Permission Deny!!!";  } ?>
        </body>
        </html>