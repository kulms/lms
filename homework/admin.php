<?	
session_start();
require ("../include/global_login.php");	
require_once ("./classes/User.php");
require_once ("./classes/UserStorage.php");
require_once( "./includes/main_functions.php" );
	
$user = UserStorage::lookupById($person["login"]);

session_register( 'user' ); 

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

require "./style/$uistyle/header.php";
require "./style/$uistyle/footer.php";	
?>
<html>
<head>
        <title>Homework admin</title>
        <link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
		<!--<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />!-->
		<script language='javascript' src='popcalendar.js'></script>
        <script language="javascript">
<!--  
        function rename_check()
		{
                if(document.renameform.homeworkname.value=="")
                {           alert("You can't have an empty name");
                            return false;
                }else{  return true;
                         }
        }
        function delete_check(){
                if(confirm("Do you really want to delete "+document.renameform.homeworkname.value+" and all it's content?")){
                        if(confirm("Are you really...REALLY sure?\nThis action can't be undone.")){
                                return true;
                        }else{
                                return false;
                        }
                }else{
                        return false;
                }
        }
        //-->
        </script>

</head>
<body>
<?
if($modules!=0){
        $id=$modules;
}

$check=mysql_query("SELECT * FROM homework_prefs WHERE modules=$id;");
if (mysql_num_rows($check)!=1)
{
mysql_query("INSERT INTO homework_prefs(modules) VALUES ($id);");
}
$check=mysql_query("SELECT * FROM homework_prefs WHERE modules=$id;");

if($person["admin"]==1){
        $getresources=mysql_query("SELECT m.*,u.firstname,u.surname,u.email FROM modules m, users u WHERE m.id=$id AND u.id=m.users;");
}else{
        //$getresources=mysql_query("SELECT m.*,u.firstname,u.surname,u.email FROM modules m,users u WHERE m.id=$id AND m.users=".$person["id"]." AND u.id=".$person["id"].";");
		$getresources=mysql_query("SELECT m.*,u.firstname,u.surname,u.email FROM modules m,users u, wp WHERE m.id=$id and m.id=wp.modules AND wp.users=".$person["id"].";");
}
if((mysql_num_rows($getresources)!=0)||($person["admin"]==1)){
?>
<form action="renamehomework.php" method="post" onSubmit="return rename_check();" name="renameform">
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="50%"><h1><? echo "Edit homework";?> </h1></td>
    <td width="50%">&nbsp;</td>
  </tr>
</table>
        
  <table border="0" cellpadding="2" cellspacing="0" align="center" class="tdborder2" width="100%">
    <? if($person["admin"]==1){?>
    <tr> 
      <td colspan="2" class="main">Created by: <b><a href="mailto:<?echo mysql_result($getresources,0,"email")?>"><?echo mysql_result($getresources,0,"firstname")."&nbsp;".mysql_result($getresources,0,"surname")?></a></b></td>
    </tr>
    <? } ?>
    <tr> 
      <td colspan="2"  class="hilite"><input name="submit" type="submit" class="button" value="<?php echo $user->_('save');?>">
        <input class="button" type="button" name="cancel" value="<?php echo $user->_('cancel');?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = 'index.php?id=<? echo $id;?>&courses=<? echo $courses;?>';}" /></td>
    </tr>
    <tr> 
      <td  align="right"  class="hilite" > Name: </td>
      <td  align="left" > <input type="text" name="homeworkname" maxlength="10" size="15" value="<?echo mysql_result($getresources,0,"name")?>" class="text"> 
        <input type="hidden" name="modules" value="<?echo $id?>"> </td>
    </tr>
    <tr> 
      <td  align="right" valign="top" class="hilite"> Last date: </td>
      <td  align="left" > <input type="text" name="end_date" value="<? if (mysql_result($check,0,"end_date")!=0){
                                         echo date("d/m/Y", mysql_result($check,0,"end_date")); }?>" class="text" maxlength="15" size="15" onFocus="this.blur();"> 
        <script language='javascript'>
											<!--
											  if (!document.layers) {
												document.write("<input type=button onclick='popUpCalendar(this, renameform.end_date, \"dd/mm/yyyy\")' value=' Date ' style='font-size:11px'>")
											}
											//-->
										  </script> </td>
    </tr>
    <tr> 
      <td align="right" valign="top" class="hilite">Last Time:</td>
      <td class="main" align="left" valign="top"> <select class="small" name="hr">
          <option value="0" <? if (mysql_result($check,0,"hour")=="0"){ echo "selected";} ?>>00</option>
          <option value="1" <? if (mysql_result($check,0,"hour")=="1"){ echo "selected";} ?>>01</option>
          <option value="2" <? if (mysql_result($check,0,"hour")=="2"){ echo "selected";} ?>>02</option>
          <option value="3" <? if (mysql_result($check,0,"hour")=="3"){ echo "selected";} ?>>03</option>
          <option value="4" <? if (mysql_result($check,0,"hour")=="4"){ echo "selected";} ?>>04</option>
          <option value="5" <? if (mysql_result($check,0,"hour")=="5"){ echo "selected";} ?>>05</option>
          <option value="6" <? if (mysql_result($check,0,"hour")=="6"){ echo "selected";} ?>>06</option>
          <option value="7" <? if (mysql_result($check,0,"hour")=="7"){ echo "selected";} ?>>07</option>
          <option value="8" <? if (mysql_result($check,0,"hour")=="8"){ echo "selected";} ?>>08</option>
          <option value="9" <? if (mysql_result($check,0,"hour")=="9"){ echo "selected";} ?>>09</option>
          <option value="10" <? if (mysql_result($check,0,"hour")=="10"){ echo "selected";} ?>>10</option>
          <option value="11" <? if (mysql_result($check,0,"hour")=="11"){ echo "selected";} ?>>11</option>
          <option value="12" <? if (mysql_result($check,0,"hour")=="12"){ echo "selected";} ?>>12</option>
          <option value="13" <? if (mysql_result($check,0,"hour")=="13"){ echo "selected";} ?>>13</option>
          <option value="14" <? if (mysql_result($check,0,"hour")=="14"){ echo "selected";} ?>>14</option>
          <option value="15" <? if (mysql_result($check,0,"hour")=="15"){ echo "selected";} ?>>15</option>
          <option value="16" <? if (mysql_result($check,0,"hour")=="16"){ echo "selected";} ?>>16</option>
          <option value="17" <? if (mysql_result($check,0,"hour")=="17"){ echo "selected";} ?>>17</option>
          <option value="18" <? if (mysql_result($check,0,"hour")=="18"){ echo "selected";} ?>>18</option>
          <option value="19" <? if (mysql_result($check,0,"hour")=="19"){ echo "selected";} ?>>19</option>
          <option value="20" <? if (mysql_result($check,0,"hour")=="20"){ echo "selected";} ?>>20</option>
          <option value="21" <? if (mysql_result($check,0,"hour")=="21"){ echo "selected";} ?>>21</option>
          <option value="22" <? if (mysql_result($check,0,"hour")=="22"){ echo "selected";} ?>>22</option>
          <option value="23" <? if (mysql_result($check,0,"hour")=="23"){ echo "selected";} ?>>23</option>
        </select>
        : 
        <select name="mnt" class="small">
          <option value="0" <? if (mysql_result($check,0,"minute")=="0"){ echo "selected";} ?>>00</option>
          <option value="10" <? if (mysql_result($check,0,"minute")=="10"){ echo "selected";} ?>>10</option>
          <option value="20" <? if (mysql_result($check,0,"minute")=="20"){ echo "selected";} ?>>20</option>
          <option value="30" <? if (mysql_result($check,0,"minute")=="30"){ echo "selected";} ?>>30</option>
          <option value="40" <? if (mysql_result($check,0,"minute")=="40"){ echo "selected";} ?>>40</option>
          <option value="50" <? if (mysql_result($check,0,"minute")=="50"){ echo "selected";} ?>>50</option>
        </select> </td>
    </tr>
    <tr> 
      <td class="hilite" align="right" valign="top" > Info: </td>
      <td class="hilite" align="left" valign="top"> <textarea name="info" cols="115" rows="6" class="pn-text" wrap="PHYSICAL"><?echo mysql_result($getresources,0,"info")?></textarea> 
      </td>
    </tr>
    <tr> 
      <td align="right" valign="top" class="hilite">Active/Inactive:</td>
      <td valign="top" class="hilite"><input type="checkbox" name="active" value="1"
<? if (mysql_result($getresources,0,"active") == 1) {?> checked<? } ?>> <br>
        If status = checked : you make this homework active and visible to users 
        <br>
        If status = unchecked : you make this homework inactive and invisible 
        to users <br> </td>
    </tr>
    <tr> 
      <td class="main" align="left" valign="top">&nbsp;</td>
      <td class="main" align="left" valign="top">&nbsp;</td>
    </tr>
  </table>
</form>
<?

}else{
        $getuser=mysql_query("SELECT u.firstname,u.surname FROM users u, modules m WHERE m.users=u.id AND m.id=$id;");
        if(mysql_num_rows($getuser)!=0){
                $creator=mysql_result($getuser,0,"firstname")."&nbsp;".mysql_result($getuser,0,"surname");
?>
        <p>&nbsp;</p>
        <div class="h5" align="center">Sorry, you can't edit this homework. It can only be edited by it's creator
(<i><?echo $creator ?></i>)</div>
        <?}
}?>
</body>
</html>