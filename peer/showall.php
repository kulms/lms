<?require("../include/global_login.php");
$SQLStmt = "SELECT * FROM peer WHERE memo <> '' AND modules =$modules;"; 
$oRS =mysql_query($SQLStmt); 
if(mysql_num_rows($oRS)!=0){?>
<html>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
<body bgcolor="#ffffff">
<a href="javascript:history.go(-1);" class="main">Back</a>
	<div class="h3" align="center"><b>Postings this far...</b></div>
	<table width="100%" cellpadding="2" cellspacing="0" align="center">
	<tr bgcolor="#808080">
		<td class="main"><b>&nbsp;Name</b></td>
		<td class="main"><b>&nbsp;Title</b></td>
		<td align="right" class="main" width="15%"><b>Word count&nbsp;</b></td>
	</tr><?
	$rownum=0;
	$block=0;
	while($row=mysql_fetch_array($oRS)){
		$rownum++;
		$block++;
		$cnt++;
		if($block==5){
			$spacer = "<tr><td colspan='3'><hr noshade></td></tr>";
			$block=0;
		}else{
			$spacer="";
		}//end if
		if($rownum==1){
			$bgcol="#C0C0C0";
		}else{
			$bgcol="#D3D3D3";
			$rownum=0;
		}//end if
			$get_name =mysql_query("SELECT * FROM users WHERE id =".$row["users"].";");
			$name_row=mysql_fetch_array($get_name);
		?><tr bgcolor="<?echo $bgcol ?>">
			<td class="main"><?echo $name_row["firstname"] ?> <? if($name_row["surname"]!=""){ ?>&nbsp;<?echo $name_row["surname"] ?><? } ?></td>
			<td class="main"><a href="showall_stud.php?id=<?echo $row["id"] ?>"><?echo $row["title"] ?></a></td>
			<td class="main" align="right"><?echo $row["words"] ?></td>
		</tr>
		<?echo $spacer ?>
	<?}//end while
?></table>

<?}else{?>
	<html>
		<link rel="STYLESHEET" type="text/css" href="../main.css">
	<body bgcolor="#ffffff">
	<div class="h3" align="center"><b>No records for this Peer module yet...</b></div>
	<a href="javascript:history.go(-1);" class="main">Back</a>
<?}?>
</body>
</html>