<?php
session_start();
$session_id = session_id();
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
        break;
    case 1:
        $uistyle = "admin";
        break;
    case 2:
        $uistyle = "teacher";
        break;
	case 3:
        $uistyle = "student";
		break;
	default:
        $uistyle = "guest";
	}

//require "./style/$uistyle/header.php";
//require "./style/$uistyle/footer.php";
 ?>
<html>
<head>
        <title>Course On Web - Courses</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">

<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
</head>
<script Language="JavaScript">
function validRequired(formField,fieldLabel)
{
	var result = true;
	
	if (formField.value == "")
	{
		alert('Please enter a value for the "' + fieldLabel +'" field.');
		formField.focus();
		result = false;
	}
	
	return result;
}

function allDigits(str)
{
	return inValidCharSet(str,"0123456789");
}

function inValidCharSet(str,charset)
{
	var result = true;

	// Note: doesn't use regular expressions to avoid early Mac browser bugs	
	for (var i=0;i<str.length;i++)
		if (charset.indexOf(str.substr(i,1))<0)
		{
			result = false;
			break;
		}
	
	return result;
}

function validNum(formField,fieldLabel,required)
{
	var result = true;

	if (required && !validRequired(formField,fieldLabel))
		result = false;
  
 	if (result)
 	{
 		if (!allDigits(formField.value))
 		{
 			alert('Please enter a number for the "' + fieldLabel +'" field.');
			formField.focus();		
			result = false;
		}
	} 
	
	return result;
}


function validInt(formField,fieldLabel,required)
{
	var result = true;

	if (required && !validRequired(formField,fieldLabel))
		result = false;
  
 	if (result)
 	{
 		var num = parseInt(formField.value,10);
 		if (isNaN(num))
 		{
 			alert('Please enter a number for the "' + fieldLabel +'" field.');
			formField.focus();		
			result = false;
		}
	} 
	
	return result;
}

function validateForm(theForm)
{
	// Customize these calls for your form

	// Start ------->										
			
	if (theForm.year.value.length == 2) {	
		if ((theForm.year.value != "")) {
			if (!validNum(theForm.year," Year",true))
				return false;
		}
	} else {
					alert("Year must input 2 digits.");
					return false;	
			}				

	if (theForm.semester.value.length == 1) {	
		if ((theForm.semester.value != "")) {
			if (!validNum(theForm.semester,"Semester",true))
				return false;
		}
	} else {
					alert("Semester must input 1 digits.");
					return false;	
			}
															
							
	// <--------- End
	
	return true;
}

</script>
<body>
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
background="../images/headerbg.gif" height="53">
  <tr>
    <td class="menu" align="center"> <b>Transfer Data</b><br>
      Step 1</td>
  </tr>
</table>


<?
$check=mysql_query("SELECT * FROM users WHERE category=1 and id=".$person["id"].";");
if(mysql_num_rows($check)==1){
         ?>
<form name="form1" method="post" action="transfer_2.php" onSubmit="return validateForm(this)">
  <table width="90%" border="0" align="center" cellpadding="2" cellspacing="1" class="std">
    <input type="hidden" name="courses" value="<? echo $courses; ?>">
    <tr> 
      <td colspan="2"  align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td width="28%" align="right" class="hilite"> Trasnfered by/ ผู้โอนข้อมูล 
        :</td>
      <td width="72%"  align="left" class="hilite"> <b><?php echo $person["title"].$person["firstname"]." ".$person["surname"]; ?></b> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="hilite">Year/ปีการศึกษา :</td>
      <td class="hilite">25 
        <input type="text" name="year" size="2" maxlength="2" class="text"></td>
    </tr>
    <tr> 
      <td align="right" class="hilite">Semester/ภาคการศึกษา :</td>
      <td class="hilite"><input type="text" name="semester" size="2" maxlength="2" class="text"> 
      </td>
    </tr>
    <tr> 
      <td class="main" align="right" valign="top">&nbsp;</td>
      <td class="main" align="right"><input type="submit" name="Submit" value="Next &gt;&gt;" class="button"></td>
    </tr>
  </table>
</form>
<?
}else{
        //User don't have access to this script
        ?>
        <p>&nbsp;</p>
        <div align="center" class="h3">Sorry, you are not permitted to Transfer Data !</div>
        <?
}
?>
</body>
</html>