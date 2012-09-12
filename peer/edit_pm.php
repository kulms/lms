<? require ("../include/global_login.php");	
if($id!=""){
	$modules=$id;
}
if($update!=1){
	if($memo_id!=""){
		$peer_sql = "SELECT p.memo,p.title,m.name FROM peer p, modules m WHERE p.id =$memo_id AND m.id=$modules;";
	}else{
		$peer_sql = "SELECT p.memo,p.title,m.name FROM peer p, modules m WHERE p.users =".$person["id"]." AND m.id=$modules;";
	}

	$peer=mysql_query($peer_sql);
	if(mysql_num_rows($peer)!=0){
		$memo = mysql_result($peer,0,"memo");
		$p_name = mysql_result($peer,0,"name");
		$title = mysql_result($peer,0,"title");
?>
		<html>
		<head>
		<title></title>
			<script language="JavaScript"><!--
	//------------------------------------------------------------
	// JavaScript av Per Åsberg.
	//
	// Hjälp för formuläret och kontroll av inmatning.
	//-----------------------------------------------------------
		
	function setfocus() {
		document.reg.memo.focus();
		return;
	}
	function isblank(s)
	{
	    for(var i = 0; i < s.length; i++) {
			var c = s.charAt(i);
			if((c != ' ') && (c != '\n') && (c != '\t')) return false;
	    }
		return true;
	}
		
	function verify(f)
	{
		var msg;
		var empty_fields = "";
		var errors = "";
	
	    for(var i = 0; i < f.length; i++) {
			var e = f.elements[i];
			if(((e.type == "text") || (e.type == "textarea")|| (e.type == "password")) && !e.optional) {
				// first check if(the field is empty
				if((e.value == null) || (e.value == "") || isblank(e.value)) {
					empty_fields += "\n          " + e.name;
					continue;
				}
			}
		}
			
		if(empty_fields=="" && errors=="") return true;
			msg  = "______________________________________________________\n\n";
			msg += "Your Form was not processed since it contained som errors. \n";
			msg += "              Please correct the errors and try again.\n";
			msg += "______________________________________________________\n\n"
			if(empty_fields!="") {
				msg += "- The following fields are empty:" 
				msg += empty_fields + "\n";
				if(errors) msg += "\n";
			}
			msg += errors;
			alert(msg);
			return false;
		}
	//--></script>
		<link rel="STYLESHEET" type="text/css" href="../main.css">
		</head>
		<body onLoad="setfocus()" bgcolor="#ffffff">
		<table align="center">
		<tr>
			<td><div align="center" class="h3"><b><?echo $p_name ?></b></div>
			</td>
		</tr>
		<tr>
			<td><p>&nbsp;<br></p><div align="center" class="main"><b>You have already submitted a report.<br>
				You may edit below.</b><br>
				<a href="showall.php?modules=<?echo $modules ?>">Postings this far...</a>
				</div>
			</td>
		</tr>
		<form action="edit_pm.php" name="reg" method="POST">
		<tr>
			<td><input type="text" value="<?echo $title?>" size="26"></td>
		</tr>		
		<tr>
			<td><textarea name="memo" cols="70" rows="50" wrap="PHYSICAL"><?echo $memo ?></textarea></td>
		</tr>
		<tr><input type="Hidden" name="modules" value="<?echo $modules ?>">
		<input type="Hidden" name="m_id" value="<?echo $memo_id ?>">
		<input type="Hidden" name="update" value="1">
			<td colspan="2"><input type="Submit" value=" S u b m i t " style="font-family:Arial;font-size:10pt;font-weight:bold" name="s2"></td>
		</tr>
		</form>
		</table>  
		</body>
		</html>
<?
	}
}else{
	  //update report
	$str = $memo;

	$memo = str_replace("'","&#039;",$memo);
	$word=count(explode(" ",$memo));
	$oRS =mysql_query("UPDATE peer SET memo ='".$memo."',words=$word WHERE id=$m_id;");
	$ending = mysql_query("SELECT post_end FROM peer_prefs WHERE modules =$modules;");
	$post_end=mysql_result($ending,0,"post_end");
	$end_d=mktime(0,0,0,date("m",$post_end),date("d",$post_end),date("Y",$post_end));
	$now_d=mktime(0,0,0,date("m",time()),date("d",time()),date("Y",time()));
	$diffdate=(($end_d-$now_d)/86400)+1;
	?>
	<html>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	<body bgcolor="#ffffff">
	<p>&nbsp;<br></p>
			<div align="center" class="main"><b>Your report has been updated!</b><p>
			<? if($diffdate<2){?>This is the last day for posting, so if you need to make any changes to your work, you only have time until midnight.<?}else{ ?>There are still <?echo $diffdate ?> days left (including today) before the posting closes and you may edit it as much as you like during that time.<?}?>
	<br><a href="showall.php?modules=<?echo $modules ?>">Postings this far...</a></div>
	</body>
	</html>
	<?
}		  
?>
