<? 
require("../include/global_login.php");
$filepath = "/data/httpd_course/files/";

//begin function
function delete_files($target, $exceptions, $output=true)
	{
	   $sourcedir = opendir($target);
	   while(false !== ($filename = readdir($sourcedir)))
	   {
		   if(!in_array($filename, $exceptions))
		   {
			//   if($output)
			  // { echo "Processing: ".$target."/".$filename."<br>"; }
			   if(is_dir($target."/".$filename))
			   {
				   // recurse subdirectory; call of function recursive
				   delete_files($target."/".$filename, $exceptions);
			   }
			   else if(is_file($target."/".$filename))
			   {
				   // unlink file
				   unlink($target."/".$filename);
			   }
		   }
	   }
	   closedir($sourcedir);
	   rmdir($target);
	}

$arr_id[]=$id;
function Find_id($num) {
    global $arr_id;
	$sql = mysql_query("SELECT id FROM resources WHERE refid=$num ORDER BY id;");
	while ($sql_row=mysql_fetch_array($sql)) {
		$arr_id[]=$sql_row["id"];
		$sql2=mysql_query("SELECT id FROM resources WHERE refid=".$sql_row["id"]." ORDER BY id;");
		if (mysql_num_rows($sql2)!=0) {			
			Find_id($sql_row["id"]);
		}
	}
}

//end function 


if($test != "unzip"){
Find_id($id);
while (list($key,$value) = each($arr_id)) { 
	$arr_id_row = intval($value);
	mysql_query("DELETE FROM resources WHERE id=$arr_id_row AND modules=$modules;");
	//$sourcedir = opendir($forder= $realpath."/files/resources_files/".$person["id"]."/");
	$sourcedir = opendir($forder= $filepath."/resources_files/".$person["id"]."/");
	$exceptions = array(".", "..");
	 while(false !== ($filename = readdir($sourcedir)))
	 {
		if($filename==intval($value)){
			//$forder= $realpath."/files/resources_files/".$person["id"]."/".$arr_id_row;
			$forder= $filepath."/resources_files/".$person["id"]."/".$arr_id_row;
			delete_files($forder, $exceptions, true);
		}
	 }

}
}else{
	//$forder= $realpath."/files/resources_files/".$person["id"]."/".$id;
	$forder= $filepath."/resources_files/".$person["id"]."/".$id;
	$exceptions = array(".", "..");
	delete_files($forder, $exceptions, true);
}
header("Status: 302 Moved Temporarily");
header("Location: index.php?id=$modules&courses=$courses");


?>