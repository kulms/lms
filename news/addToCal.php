<?require("../include/global_login.php");

if($insert!=1){
 ?>
	<html>
	<head>
		<link rel="STYLESHEET" type="text/css" href="../main.css">
		<title>Add appointment</title>
		<script type="text/javascript" language="JavaScript">
			<!-- 		
			function closeIt() {
	  			self.window.close();
			}
			function setfocus(courses){
				self.window.focus();
				for(a=0;a<document.addit.courses.options.length;a++){
					if(document.addit.courses.options[a].value==courses){
						document.addit.courses.options[a].selected=true;
					}
				}
			}
						// -->		
		</script>
	</head>
	<body bgcolor="#ffffff" onLoad="setfocus(<?echo $courses?>)">
		<form name="addit" action="add.php" method="post">
		<div align="center">
			<input type="button" onClick="closeIt();" value="C l o s e" style="font-family:Arial;font-size:8pt">
		</div>
		<table cellpadding="0" cellspacing="0" bgcolor="#CACFF4">
			<tr>
				<td>
		<table cellpadding="1" cellspacing="1">
		<tr bgcolor="#CACFF4">
				<td colspan="2" class="main" align="center">Add appointment to <b><?echo date("Y-m-d",$dt) ?></b></td>
		</tr>

		<?	//Get courses where user is admin
		if($person["admin"]==1){
			$checkAdmin = mysql_query("SELECT distinct c.id,c.name FROM courses c, wp WHERE c.active=1 AND wp.courses=c.id;");
		}else{
			$checkAdmin = mysql_query("SELECT distinct c.id,c.name FROM courses c, wp WHERE wp.users = ".$person["id"]." AND wp.admin=1 AND NOT wp.courses=0 AND wp.courses=c.id AND c.active=1;");
		}
		if(mysql_num_rows($checkAdmin)!=0){ ?>
		<tr>
			<td bgcolor="#CACFF4" class="small">Add to</td>
			<td><select class"small" name="courses">
				<option value="0">Personal Calendar</option>
				<? 	
				while($course_row=mysql_fetch_array($checkAdmin)){
				?>
					<option value="<?echo $course_row["id"] ?>"><?echo $course_row["name"] ?></option> 
				<?}
	 ?>			
			</select></td>
		</tr>
	<?}else{?>
	<tr bgcolor="#CACFF4">
		<td colspan="2" align="center" class="small"><b>Personal calendar</b></td>
	</tr>
	<?}?>
	<tr bgcolor="#CACFF4">
		<td class="small">StartTime:</td>
		<td><select class="small" name="hr">
				<option value="00">00</option>
			   	<option value="01">01</option>
			   	<option value="02">02</option>
			   	<option value="03">03</option>
			   	<option value="04">04</option>
			   	<option value="05">05</option>
			   	<option value="06">06</option>
			   	<option value="07">07</option>
			   	<option value="08" selected>08</option>
			   	<option value="09">09</option>
			   	<option value="10">10</option>
			   	<option value="11">11</option>
			   	<option value="12">12</option>
			   	<option value="13">13</option>
			   	<option value="14">14</option>
			   	<option value="15">15</option>
			   	<option value="16">16</option>
			   	<option value="17">17</option>
			   	<option value="18">18</option>
			   	<option value="19">19</option>
			   	<option value="20">20</option>
			   	<option value="21">21</option>
			   	<option value="22">22</option>
			   	<option value="23">23</option>
			</select>

			<select name="mnt">
				<option value="00">00</option>
			   	<option value="10">10</option>
			   	<option value="20">20</option>
			   	<option value="30">30</option>
			   	<option value="40">40</option>
			   	<option value="50">50</option>
			</select>
		</td>
	</tr>
	<tr bgcolor="#CACFF4">
		<td class="small">Length:</td>
		<td>
			<select name="length" class="small">
				<option value="0.50" class="small">30min</option>
				<option value="1.00" class="small">1hr</option>
				<option value="1.50" class="small">1hr 30min</option>
				<option value="2.00" class="small">2hr</option>
				<option value="2.50" class="small">2hr 30min</option>
				<option value="3.00" class="small">3hr</option>
				<option value="3.50" class="small">3hr 30min</option>
				<option value="4.00" class="small">4hr</option>
				<option value="4.50" class="small">4 hr 30min</option>
				<option value="5.00" class="small">5hr</option>
				<option value="5.50" class="small">5hr 30min</option>
				<option value="6.00" class="small">6hr</option>
				<option value="6.50" class="small">6hr 30min</option>
				<option value="7.00" class="small">7hr</option>
				<option value="7.50" class="small">7hr 30min</option>
				<option value="8.00" class="small">8hr</option>
				<option value="9.00" class="small">All day</option>
			</select>
		</td>
	</tr>
	<tr bgcolor="#CACFF4">
		<td class="small">Title:</td>
		<td><input type="Text" name="title" size="30" maxlength="8"></td>
	</tr>
	<tr bgcolor="#CACFF4">
		<td valign="top" class="small">Text:</td>
		<td><textarea name="appointment" cols="30" rows="5" wrap="PHYSICAL"></textarea></td>
	</tr>

	<input type="Hidden" name="dt" value="<?echo $dt ?>">
	<input type="Hidden" name="insert" value="1">

	</table>
	</td>
			</tr>
		</table>
	<table align="center">
		<tr>
			<td colspan="2"><input type="Submit" value="   S a v e   " name="subm"><input type="Reset" value="  C l e a r  "></td>
		</tr>
	</table>
	</form>
	</body>
	</html>
<?}// End If 
?>
