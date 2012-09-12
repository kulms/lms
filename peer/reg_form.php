<html>
	<head>
	<title>Submit report</title>
	<script language="JavaScript1.1" src="form.js"></script>
	<? 
	if($id!=""){
		$modules=$id;
	}
	$instruct = mysql_query("SELECT first_instructions FROM peer_prefs WHERE modules =$modules;");
	if(mysql_num_rows($instruct)!=0){
		$instructions = mysql_result($instruct,0,"first_instructions");
	}//end if
	
	?>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	</head>
	<body bgcolor="#ffffff" topmargin="0" leftmargin="0" onLoad="setfocus()">
	<FORM method="POST" action="insert.php" name="reg" onSubmit="return verify(this);" onReset="return confirm('Do you really want to erase everything in the form?')">
	<table width="100%" border="0" cellspacing="2" cellpadding="2">
		<tr>
			<td width="22%">&nbsp;</td>
			<td width="34%" class="h3"><br><?echo mysql_result($dates,0,"name") ?><br>&nbsp;</td>
		</tr>
		<? if($instructions!=""){ ?>
		<tr>
			<td>&nbsp;</td>
			<td class="main"><?echo $instructions ?><p>&nbsp;</p></td>
		</tr><?}?>
		<tr>
			<td>&nbsp;</td>
			<td class="main"><a href="showall.php?modules=<?echo $modules ?>">Postings this far...</a></td>
		</tr>
		<tr>
			<td width="22%"><p align="right" class="main"><b>Title:</b></p></td>
			<td width="44%"><input type="Text" name="Title" size="26"></td>
			<td width="34%"></td>
		</tr>
		<tr>
			<td width="22%" valign="TOP" class="main"><p align="right"><b>Report:</b></p></td>
			<td width="44%" class="main"><textarea cols="60" name="memo" rows="50" wrap="PHYSICAL">Paste your report here...<?echo "\n"?>It should be unformatted, i.e pure text</textarea></td>
			<td width="34%"></td>
		</tr>
		<tr>
			<td width="22%" class="main"></td>
			<td width="44%" class="main">
				<input type="hidden" name="modules" value="<?echo $modules ?>">
				<input type="submit" value="Submit" name="B1">
				<input type="reset" value="Clear" name="B2">
	</form>
			</td>
			<td width="34%"></td>
		</tr>
	</table>