
<?php

error_reporting(0);


$ThemeStyle = new ThemeStyle($theme_color);
					   
	//echo $ThemeStyle->getThemeName();
		
		
		$ThemeStyle->update($ThemeStyle);
		
     
?>

<script language = "javascript">
top.ws_top.location.reload();
//top.ws_menu.location.href="../system/menu_system.php";
top.ws_menu.location.reload();
</script>
