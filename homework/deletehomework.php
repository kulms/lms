<?require("../include/global_login.php");
 include("../include/function.inc.php");
 include("classes/function.inc.php");
 //Courses_id
$courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$modules.";");
$courses=mysql_result($courseid,0,"courses");
 	//***********insert modules_history***************
	$action="Delete";
	Imodules_h($modules,$action,$person["id"],$courses);

if($person["admin"]==1){
        $getresources=mysql_query("SELECT * FROM modules WHERE id=$modules;");
        if(mysql_num_rows($getresources)!=0){
			$sql="SELECT id FROM homework WHERE modules=$modules ";
			$data_sql=mysql_query($sql);
			while($row=mysql_fetch_array($data_sql)){
				$allpath_sol=$realpath."/files/homework/solutions/".$row['id'];
				$allpath_file=$realpath."/files/homework/files/".$row['id'];
				$allpath_ansfile=$realpath."/files/homework/ansfiles/".$row['id'];

				$dir_sol=opendir($realpath."/files/homework/solutions");
				$dir_file=opendir($realpath."/files/homework/files");
				$dir_ansfile=opendir($realpath."/files/homework/ansfiles");
				$exceptions = array(".", "..");

				while(($data_file=readdir($dir_file)) != false){
					if($data_file==$row['id']){
						delete_files($allpath_file,$exceptions, true);
					}
				}

				while(($data_sol=readdir($dir_sol)) != false){
					if($data_sol==$row['id']){
						delete_files($allpath_sol,$exceptions, true);
					}
				}

				while(($data_ansfile=readdir($dir_ansfile)) != false){
					if($data_ansfile==$row['id']){
						delete_files($allpath_ansfile,$exceptions, true);
					}
				}
			}
               mysql_query("DELETE FROM homework WHERE modules=$modules;");
             mysql_query("DELETE FROM modules WHERE id=$modules;");
               mysql_query("DELETE FROM wp WHERE modules=$modules;");
              mysql_query("DELETE FROM login_modules WHERE modules=$forum;");
               mysql_query("DELETE FROM homework_ans WHERE modules=$modules;");
              mysql_query("DELETE FROM homework_prefs WHERE modules=$modules;");
        }
}else{
        $getresources=mysql_query("SELECT * FROM modules WHERE id=$modules AND users=".$person["id"].";");
        if(mysql_num_rows($getresources)!=0){
$sql="SELECT id FROM homework WHERE modules=$modules ";
			$data_sql=mysql_query($sql);
			while($row=mysql_fetch_array($data_sql)){
				$allpath_sol=$realpath."/files/homework/solutions/".$row['id'];
				$allpath_file=$realpath."/files/homework/files/".$row['id'];
				$allpath_ansfile=$realpath."/files/homework/ansfiles/".$row['id'];

				$dir_sol=opendir($realpath."/files/homework/solutions");
				$dir_file=opendir($realpath."/files/homework/files");
				$dir_ansfile=opendir($realpath."/files/homework/ansfiles");
				$exceptions = array(".", "..");

				while(($data_file=readdir($dir_file)) != false){
					if($data_file==$row['id']){
						delete_files($allpath_file,$exceptions, true);
					}
				}

				while(($data_sol=readdir($dir_sol)) != false){
					if($data_sol==$row['id']){
						delete_files($allpath_sol,$exceptions, true);
					}
				}

				while(($data_ansfile=readdir($dir_ansfile)) != false){
					if($data_ansfile==$row['id']){
						delete_files($allpath_ansfile,$exceptions, true);
					}
				}
			}
               mysql_query("DELETE FROM homework WHERE modules=$modules;");
               mysql_query("DELETE FROM modules WHERE id=$modules AND users=".$person["id"].";");
				mysql_query("DELETE FROM wp WHERE modules=$modules;");
               mysql_query("DELETE FROM login_modules WHERE modules=$forum;");
				mysql_query("DELETE FROM homework_ans WHERE modules=$modules;");
                mysql_query("DELETE FROM homework_prefs WHERE modules=$modules;");
                 }
}
?>
<html>
<head>
        <title>update</title>
<script language="javascript">
        function update(){
                top.ws_menu.location.reload();
        }
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body onLoad="update()" bgcolor="#ffffff">
<div align="center" class="main">Homework deleted...</div>
</body>
</html> 