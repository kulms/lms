<?require("../include/global_login.php");?>
<html>
<head>
	<title></title>
<script language="JavaScript">
<!-- hide
function check_and_send(m){
	if(confirm('Really overwrite ALL previous assignments?')){
		if(confirm("Are you really...REALLY sure?\n\n\nThis action can´t be undone.")){
			window.location="random.php?modules=" + m + "&continue=1&del=1";
		}
	}
}
// -->
</script>		
<LINK REL=STYLESHEET TYPE="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff">
<?if($continue==""){
	//check if already assigned reports to users
	$check=mysql_query("SELECT count(id) AS cnt FROM peer_corr WHERE modules=$modules;");
	if(mysql_num_rows($check)!=0){
		if(mysql_result($check,0,"cnt")>0){?>
			<div class="h3" align="center"><b>Warning!</b></div>
			<div class="main" align="center"><b>The users have already been assigned their reports to review. <br>If you still decide to continue, these assignments will be overwritten. If any of the users already reviewed any of their assigned reports, you should consider to leave things as they are.</b></div>
			<div align="center">
				<form action="random.php?modules=$modules" method="post" name="cont">
					<input type="button" value="Continue(=overwrite)" onClick="check_and_send(<?echo $modules?>)">
				</form>
			</div>
<?		}else{	//OK, no previous records
			$continue=1;
		}
	}else{
		$continue=1;
	}
}//end if $continue!=""
if($continue==1){
	if($del==1){
		mysql_query("DELETE FROM peer_corr WHERE modules=$modules");
	}
	$get_peer=mysql_query("SELECT users FROM peer WHERE modules=$modules;");
	if(mysql_num_rows($get_peer)!=0){
		$peer_temp_array=array();
		while($row=mysql_fetch_array($get_peer)){
			$peer_temp_array[]=$row["users"];
		}
		$peer_array=array();			

		do{	//randomize into new array
			srand((double)microtime()*1000000);
			$NewNumber=rand(0,sizeof($peer_temp_array)-1);
			if($peer_temp_array[$NewNumber]!="-"){
				$peer_array[]=$peer_temp_array[$NewNumber];
				$peer_temp_array[$NewNumber]="-";
			}
		}while(sizeof($peer_array)<sizeof($peer_temp_array));
		//echo sizeof($peer_temp_array);
		
		$get_prefs=mysql_query("SELECT reports_to_review FROM peer_prefs WHERE modules=$modules;");
		$reports_to_review=mysql_result($get_prefs,0,"reports_to_review");
		$check_postings=mysql_query("SELECT count(id) as postings FROM peer WHERE modules=$modules;");
		if(mysql_result($check_postings,0,"postings")>($reports_to_review)){
			for($counter=0;$counter<sizeof($peer_array);$counter++){
				for($a=1;$a<=$reports_to_review;$a++){
					$corr=$counter+$a;
					if($corr>=sizeof($peer_array)){
						$corr=$corr-sizeof($peer_array);
					}
					mysql_query("INSERT INTO peer_corr(users,corr,modules) VALUES(".$peer_array[$counter].",".$peer_array[$corr].",$modules);");
				}
			}?>
			<table>
				<tr>
					<td width="15%">&nbsp;</td>
					<td><div align="center" class="h5"><b>OK, assigned <?echo $reports_to_review?> reports to each student to review.</b></div>
						<div align="center" class="main"></div>
					</td>
					<td width="15%">&nbsp;</td>
				</tr>
			</table>
		<?}else{?>
		<p>&nbsp;</p>
		<table>
			<tr>
				<td width="15%">&nbsp;</td>
				<td><div align="center" class="h5"><b>You can't assign <?echo $reports_to_review?> reports for every student when there are only <?echo mysql_result($check_postings,0,"postings")?> students that have posted...</b></div>
					<div align="center" class="main">If you change the number of reports to review in the setup to be less then <?echo mysql_result($check_postings,0,"postings")?> you can try again. If you don't do this you have to wait for more postings. Be sure to set the closing date for postings to a future date in case you decide to wait...</div>
				</td>
				<td width="15%">&nbsp;</td>
			</tr>
		</table>
		<?}
	}//end if $get_peer
}
?>
</body>
</html>
