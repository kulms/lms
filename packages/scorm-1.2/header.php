<link rel="STYLESHEET" type="text/css" href="../../themes/<?php echo $theme;?>/style/main.css">
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"  height="53" class="bg1">
  <tr>
    <td class="menu" align="center"><b><?php echo "Packages"; ?></b></td>
  </tr>
</table>
<br>
<?php
if($person["category"]==2){
?>
<table width="90%" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td> <table width="100%" cellpadding="2" cellspacing="0">
        <tr  class="boxcolor1"> 
          <td class="tdtop-color"><span class="Bcolor"><?php echo "Select action :";?></span></td>
          <td class="tdtop-color">&nbsp;</td>
          <td class="tdtop-color">&nbsp;</td>
          <td class="tdtop-color">&nbsp;</td>
          <td class="tdtop-color">&nbsp;</td>
        </tr>
        <tr> 
          <td width="20%"  class="tdbottom-color"><a href="../index.php?courses=<?php echo $p_courses;?>"><img src="../../images/disk_space.gif" width="16" height="16" border="0"> 
            <?php echo "Package Lists";?></a></td>
          <td width="20%"  class="tdbottom-color"><a href="../import.php?course_id=<?php echo $p_courses;?>"><img src="../../images/packages.gif" width="16" height="16" border="0"> 
            <?php echo "Import packages";?></a></td>
          <td width="20%"  class="tdbottom-color"><a href="../delete.php?course_id=<?php echo $p_courses;?>"><img src="../../images/_delete.gif" width="16" height="16" border="0"> 
            <?php echo "Delete packages";?></a></td>
          <td width="20%"  class="tdbottom-color"><a href="../settings.php?course_id=<?php echo $p_courses;?>"><img src="../../images/tool-old.gif" width="18" height="16" border="0"> 
            <?php echo "Setting packages";?></a></td>
          <td width="20%"  class="tdbottom-color"><a href="../report.php?course_id=<?php echo $p_courses;?>"><img src="../../images/_class.gif" width="16" height="16" border="0"> 
            <?php echo "Report usage";?></a></td>
        </tr>
      </table></td>
  </tr>
</table>
<?
}
?>