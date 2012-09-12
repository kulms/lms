<?require("../include/global_login.php");
if($id!=""){
	$modules=$id;
}
if($post_end==""){
	if($person["admin"]==1){
		$oRS = mysql_query("SELECT m.name FROM modules m WHERE m.id=$modules");
	}else{
		$oRS = mysql_query("SELECT m.name FROM modules m WHERE m.users = ".$person["id"]." AND m.id=$modules");
	}
	$get_prefs=mysql_query("SELECT * FROM peer_prefs WHERE modules=$modules;");	
	if(mysql_num_rows($oRS)!=0){
		$row=mysql_fetch_array($oRS);
		$peername = $row["name"];
		if(mysql_num_rows($get_prefs)!=0){
			$prefs_row=mysql_fetch_array($get_prefs);
			$update = "Update!";
			$p_e=$prefs_row["post_end"];
			if($p_e>time()){
				$stop=1;
			}else{
				$stop=0;
			}
			$post_end = date("d/m/Y",$prefs_row["post_end"]);
			$review_end = date("d/m/Y",$prefs_row["review_end"]);
			$first_instructions = $prefs_row["first_instructions"];
			$instructions = $prefs_row["instructions"];
			$reports_to_review = $prefs_row["reports_to_review"];
			$prefsID = $prefs_row["id"];
		}
		$check_results=mysql_query("SELECT id FROM peer_comments WHERE modules=$modules;");
		if(mysql_num_rows($check_results)!=0){
			$results=1;
		}else{
			$results=0;
		}
?><html>
	<script type="text/javascript" src="jscr.js" language="JavaScript"></script>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
		<body bgcolor="#ffffff">
		<div align="center">
			<form action="random.php" method="get">
				<input type="button" value="Randomize students" onClick="JavaScript:rand_peer(<?echo $modules?>,<?echo $stop?>);">
<?if($results==1){?><input type="button" value="Show results" onClick="JavaScript:results(<?echo $modules?>);"><?}?>
			</form>
		</div>
		<form action="setup.php?modules=<?echo $modules?>" method="post" name="setup" onSubmit="return verify(this);">
			<table cellpadding="2" cellspacing="2" align="center">
				<tr>
					<td colspan="2" align="center" class="h1"><?echo $row["name"] ?> setup<br>&nbsp;</td>
				</tr>
				<tr>
					<td valign="TOP" bgcolor="#E6E6E6" class="main"><b>Instructions to be displayed when the students post their report: </b></td>
					<td><textarea cols="50" rows="15" wrap="virtual" name="first_instructions"><? if($first_instructions!=""){ ?><?echo $first_instructions ?><?}?></textarea></td>
				</tr>
				<tr bgcolor="#E6E6E6">
					<td class="main" valign="top"><b>Instructions to be displayed when the students review each other:</b></td>
					<td><textarea cols="50" rows="15" wrap="virtual" name="instructions"><? if($instructions!=""){ ?><?echo $instructions ?><?}?></textarea></td>
				</tr>
				<tr bgcolor="#E6E6E6">
					<td class="main"><b>Number of reports to be reviewed by each student:</b></td>
					<td><input type="text" size="2" name="reports_to_review"<? if($reports_to_review!=""){ ?> value="<?echo $reports_to_review ?>"<?}?>></td>
				</tr>
				<tr bgcolor="#E6E6E6">
					<td class="main"><b>The last day for posting of <font color="Red">reports</font>.</b><br>
					(This is the date when the matching should be conducted)</td>
					<td><input type="text" name="post_end"<? if($post_end!=""){?> value="<?echo $post_end ?>"<?}?>> &nbsp;(Format:dd/mm/yyyy)</td>
				</tr>
				<tr bgcolor="#E6E6E6">
					<td class="main"><b>The last day for posting of <font color="Red">reviews</font>.</b><br>
					(The students can't submit any more comments on each others work from this date, but they can still read everything)</td>
					<td><input type="text" name="review_end"<? if($review_end!=""){ ?> value="<?echo $review_end ?>"<?}?>> &nbsp;(Format:dd/mm/yyyy)</td>
				</tr>
				<tr bgcolor="#E6E6E6">
					<td>&nbsp;</td>
					<td><input type="submit" value="Save preferences">
						<input type="reset">
						<? if($update!=""){?>
						<input type="hidden" name="upd" value="True">
						<input type="hidden" name="prefsID" value="<?echo $prefsID ?>">
						<?}?>
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>
<?	}else{
		$get_creator=mysql_query("SELECT u.firstname,u.surname FROM users u, modules m WHERE m.id=$modules AND u.id=m.users;");
		$creator=mysql_result($get_creator,0,"firstname")."&nbsp;".mysql_result($get_creator,0,"surname");?>
		<html>
		<head>
		<LINK REL=STYLESHEET TYPE="text/css" href="../main.css">
		<title></title>
		</head>
		<body bgcolor="#ffffff">
			<p>&nbsp;</p>
			<div class="h5" align="center">Sorry, you can't edit this Peer module. It can only be edited by it's creator (<i><?echo $creator ?></i>)</div>
		</body>
		</html><?
	}
}else{  // $post_end==""
		$instructions = str_replace("'","&#039;",$instructions);
		$first_instructions = str_replace("'","&#039;",$first_instructions);
		if($post_end==""){
			$in_date_pe=0;
		}else{
			$date_parts = explode("/",$post_end);
			if($date_parts[2]<1990){
				$years=1900+$date_parts[2];
			}else{
				$years=$date_parts[2];
			}
			$in_date_pe=mktime(0,0,0,$date_parts[1],$date_parts[0],$years);
		}

		if($review_end==""){
			$in_date_re=0;
		}else{
			$date_parts = explode("/",$review_end);
			if($date_parts[2]<1990){
				$years=1900+$date_parts[2];
			}else{
				$years=$date_parts[2];
			}
			$in_date_re=mktime(0,0,0,$date_parts[1],$date_parts[0],$years);
		}
		
		if($upd!=""){//fix date from string to int!!!!
			mysql_query("UPDATE peer_prefs SET instructions ='".$instructions."', first_instructions = '".$first_instructions."', post_end = $in_date_pe, review_end = $in_date_re, reports_to_review = $reports_to_review WHERE id =$prefsID;");
		}else{
			$check=mysql_query("SELECT id FROM peer_prefs WHERE modules=$modules;");
			if(mysql_num_rows($check)!=0){
				mysql_query("UPDATE peer_prefs SET instructions ='".$instructions."', first_instructions = '".$first_instructions."', post_end = $in_date_pe, review_end = $in_date_re, reports_to_review = $reports_to_review WHERE id =".mysql_result($check,0,"id").";");
			}else{
				mysql_query("INSERT INTO peer_prefs(modules,instructions,first_instructions,post_end,review_end,reports_to_review) VALUES($modules,'".$instructions."','".$first_instructions."',$in_date_pe,$in_date_re,$reports_to_review);");
			}
		}
		?>
		<html>
		<body bgcolor="#ffffff" class="main">
				<div align="center" class="h3"><b>Your preferences have been saved</b></div>
		</body>
		</html>
<?
}?>
