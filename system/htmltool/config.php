<?

## File Path ###########################################################
 // A relative path with home page ----------
$System_Path_Upload      = "files";
 // A html full path ----------
$System_FullPath             = "http://localhost/vec";
//$System_FullPath_Upload      = "/vec/files/courses";


    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {

		$System_FullPath_Upload      = $realpath."/files/news_system";

	
	}else {
	
		$System_FullPath_Upload      = "/".$path."/files/news_system"; //for linux
	}


$System_RelativePath             = "../..";
$System_RelativePath_Upload      = "../files/news_system";



## Configuration Path ######################################
$myModule_FullPath_ThumbnailPicture = $System_FullPath_Upload."/".$person["id"]."/thumbnail"; 
$myModule_FullPath_HTMLFiles        = $System_FullPath_Upload."/".$person["id"]."/htmlfiles";  
$myModule_FullPath_ImageLibrary     = $System_FullPath_Upload."/".$person["id"]."/library";  
// A relative path with this files.
$myModule_Path_ThumbnailPicture = $System_RelativePath_Upload."/".$person["id"]."/thumbnail"; 
$myModule_Path_HTMLFiles        = $System_RelativePath_Upload."/".$person["id"]."/htmlfiles";  
$myModule_Path_ImageLibrary     = $System_RelativePath_Upload."/".$person["id"]."/library";  

?>