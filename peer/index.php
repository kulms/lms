<? require ("../include/global_login.php");
//******************************************************
// This is default.asp which redirects the users to
// either reg.asp (register/submit) 
// or frame.php(the review part)
//******************************************************
function fixday($s,$i){
	return $n = mktime(0,0,0,date("m",$s)  ,date("d",$s)+$i,date("Y",$s));
}

$sql = "SELECT m.name,p.* FROM modules m,peer_prefs p WHERE m.id = $id AND p.modules =$id;";
if($id!=""){
	$modules=$id;
}

	//insert into login_modules
mysql_query("INSERT INTO login_modules(modules,users,time) VALUES($modules,".$person["id"].",".time().");");

$dates = mysql_query($sql);
$post_end=mysql_result($dates,0,"post_end");
$last_date=fixday($post_end,1);
//echo $last_date;
//******************************************************
//	Check that no-one is trying to submit article
//	after last valid date
//******************************************************
if(time()<= $last_date){ 
	$check = mysql_query("SELECT id FROM peer WHERE users =".$person["id"]." AND modules =$id;");
	if(mysql_num_rows($check)!=0){
		header("Status: 302 Moved Temporarily");
		header("Location: edit_pm.php?modules=".$modules."&memo_id=".mysql_result($check,0,"id"));			
		exit;
	}//End if
	include "reg_form.php";
}else{ //time() <= $post_end
	$check_corr=mysql_query("SELECT id FROM peer_corr WHERE modules=$id;");
	if(mysql_num_rows($check_corr)==0){
		$creator=mysql_query("SELECT u.firstname,u.surname,u.email,m.name,pp.mailed FROM users u, modules m,peer_prefs pp WHERE m.id=$modules AND u.id=m.users AND pp.modules=$modules;");
		$creatorname=mysql_result($creator,0,"firstname")."&nbsp;".mysql_result($creator,0,"surname");
		$email=mysql_result($creator,0,"email");
		$m_name=mysql_result($creator,0,"name");
		if(mysql_result($creator,0,"mailed")==0){
			$mailbody="A user (".$person["firstname"]." ".$person["surname"].") has tried to access your Peer module(".$m_name.") but discovered that you haven't randomized it yet. \nBefore you do so, the users can't do their reviews. \n\nIf you would like to give the users more time to post/edit their work you have to change the time limit in the setup page.\n\n-----------------------------------\nThis is an auto generated mail.\nLearnLoop";
			mail($email,"Reminder to randomize your Peer module(".$m_name.")",$mailbody,"From:LearnLoop@$SERVER_NAME");
			mysql_query("UPDATE peer_prefs SET mailed=1 WHERE modules=$modules;");			
		}?>
		<html>
		<head>
			<link rel="STYLESHEET" type="text/css" href="../main.css">
		</head>
		<body bgcolor="#ffffff">
		<p>&nbsp;</p>
		<p class="main" align="center">This Peer module is waiting for the owner(<i><?echo $creatorname?></i>) to match the participants work together.</p>
		<p class="main" align="center">He/she has nevertheless been informed about this so plase check back again later.</p>
		</body>
		</html>	
	<?}else{
		// i.e time's up
		header("Status: 302 Moved Temporarily");
		header("Location: frame.php?modules=".$modules);
		exit;
	}
}//End if('now <= dates("post_end")
?>
