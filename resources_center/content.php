<?
session_start();
require("../include/global_login.php");
//$license = 5;
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
</head>
<body>

<?

//$sql_find = mysql_query("select * from resource_center_usage where  users = ".$person["id"]." and status = 1 and resource_center_id = ".$id."");

//$rs=mysql_num_rows($sql_find);

//$sql =  mysql_query("select resource_center_id from resource_center_usage where  users = ".$person["id"]." and status = 1");
          

//$row = mysql_num_rows($sql);


//if($row >= $license) {

//echo "Can't not open file";
//exit();

//}

//if ( $rs==0) {

//$sql_ins="INSERT INTO resource_center_usage(resource_center_id,users,start_time,status) 
//		VALUES (".$id.",".$person["id"].",".time().",1)";
 //        mysql_query($sql_ins);

//}

echo	"<iframe src=\"../files/resources_center_files/$id/$index_name\" width=1012 height=740 frameborder=0 marginheight=0 marginwidth=0 scrolling=yes></iframe>";

?>




</body>
</html>


