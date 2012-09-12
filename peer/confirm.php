<? require ("../include/global_login.php");	
$SQLStmt = "SELECT * FROM peer WHERE NOT memo ='' AND modules = $modules;";
$oRS = mysql_query($SQLStmt);
if(mysql_num_rows($oRS)!=0){
?>
	<table width="100%" cellpadding="2" cellspacing="0">
	<tr bgcolor="#869fe3">
		<td class="main"><b>&nbsp;Name</b></td>
		<td class="main"><b>&nbsp;Title</b></td>
		<td align="right" class="main"><b>Word count&nbsp;</b></td>
	</tr>
<?
	$row_cnt=0;
	$block=0;
	$cnt=0;
	while($row=mysql_fetch_array($oRS)){
		$row_cnt++;
		$block++;
		$cnt++;
		if($block==5){
			$spacer = "<tr><td colspan='3'><hr noshade></td></tr>";
			$block=0;
		}else{
			$spacer="";
		}//end if
		if($row_cnt==1){
			$bgcol="#DDE7F9";
		}else{
			$bgcol="#b2b2d2";
			$row_cnt=0;
		}//end if
			$get_name = mysql_query("SELECT firstname,surname,email FROM users WHERE id =".$row["users"].";");
			$user_row=mysql_fetch_array($get_name);
		?>
		<tr bgcolor="<?echo $bgcol ?>">
			<td class="main"><? echo $user_row["firstname"] ?> <? if($user_row["surname"]!=""){ ?>&nbsp;<? echo $user_row["surname"] ?><?}?></td>
			<td class="main"><a href="visa_p.php?id=<? echo $row["id"] ?>"><? echo $row["title"] ?></a></td>
			<td class="main" align="right"><? echo $row["words"] ?></td>
		</tr>
		<? echo $spacer ?>
	<?}//end while
?>
</table>
<?}//End If
?>
