<?php 
error_reporting(0);

$ThemeStyle = ThemeStyle::lookupTheme();
	
	//echo $ThemeStyle->getThemeName();


?>


<script language="JavaScript">



function validateForm(theForm) {
	
if (theForm.theme_color[0].selected == true) {
			alert("Please select theme");
			theForm.theme_color.focus();
			return false;
		}	

}

function newWindow(url,w,h,r,s)
 {
   var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
  var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
		
   var options = "width="+w+",height="+h+",";
   options += "resizable="+r+",scrollbars="+s+",status=yes,menubar=no,toolbar=no,location=no,directories=no,";
   options += "left="+LeftPosition+",top="+TopPosition;
 
   newWin = window.open(url, "wName", options);
   newWin.focus();
 
 }






</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30%">	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="28%" ><img src="./modules/system/images/gnome-hint.png" border="0"></td>
			<td width="72%"  ><h1><?php echo $user->_($strSystem_LabDisplay);?></h1></td>
		  </tr>
	  </table>
	</td>
	<td align="right" width="25%" valign="bottom">
	</td>
	<td align="left" nowrap width="45%">

	</td>
  </tr>  
</table>
<br>
<form name="editTheme" action="./index.php?m=system" method="post"  enctype="multipart/form-data" onSubmit="return validateForm(this)">
<input type="hidden" name="dosql" value="do_themes_aed" />
<table width="300" border="0" align="center" cellpadding="2" cellspacing="1" class="tdborder2">
  <tr align="center" class="boxcolor">
    <td  class="Bcolor"><?php echo $user->_($strSystem_LabDisplaySetup);?></td>
  </tr>
  <tr><td>
  <table width="45%" align="center" cellspacing="1" >
    <tr><td  align="left">Color: 
  <select name="theme_color">
                <option value="">-Select theme-</option>
                <option value="red" <?php if($ThemeStyle->getThemeName() == "red") { echo "selected";}?>><?php echo $user->_($strSystem_LabDisplayColorRed);?></option>
                <option value="blue" <?php if($ThemeStyle->getThemeName() == "blue") { echo "selected";}?>><?php echo $user->_($strSystem_LabDisplayColorBlue);?></option>
                <option value="green" <?php if($ThemeStyle->getThemeName() == "green") { echo "selected";}?>><?php echo $user->_($strSystem_LabDisplayColorGreen);?></option>
              </select> 
  
  </td>
 

 </tr>
 <tr><td nowrap>Logo: <input type="file" name="image" class="button" size="25">
 <? if($ThemeStyle->getThemelogo()!=""){?>
 <br>
 <a href="#" onClick="newWindow('index.php?m=system&a=showlogo&img=<?=$ThemeStyle->getThemelogo();?>&theme=<?=$ThemeStyle->getThemeName();?>',400,200,'yes','yes')">
 <?=$ThemeStyle->getThemelogo();?></a>
 <? } ?>
  </td></tr>
  
  </table>
  
  
  
  </td></tr>
  <tr >
    <td bgcolor="#FFFFFF" ><input type="submit"  name="save_theme" value="<?php echo $user->_($strSave);?>" class="button">
	<input type="button"  name="reset_theme" value="<?php echo $user->_($strCancel);?>" class="button" onClick="javascript:history.back();"></td>
  </tr>
</table>

</form>

