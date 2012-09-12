<?require("../include/global_login.php");
 include("../include/function.inc.php");
include("classes/function.inc.php");

 //Courses_id
	$courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$modules.";");
	$courses=mysql_result($courseid,0,"courses");
 	//***********insert modules_history***************
	$action="Delete question";
	Imodules_h($modules,$action,$person["id"],$courses);

mysql_query("DELETE FROM homework WHERE id=$id AND modules=$modules;");
mysql_query("DELETE FROM homework_ans WHERE refid=$id AND modules=$modules;");
//exec("rm -R -f $realpath/files/homework/files/$id");
//exec("rm -R -f $realpath/files/homework/ansfiles/$id");

$allpath_sol=$realpath."/files/homework/solutions/".$id;
$allpath_file=$realpath."/files/homework/files/".$id;
$allpath_ansfile=$realpath."/files/homework/ansfiles/".$id;
//delete forder in file
$exceptions = array(".", "..");
delete_files($allpath_file, $exceptions, true);

//delete forder in ansfile
delete_files($allpath_ansfile, $exceptions, true);

//delete forder in solutions
delete_files($allpath_sol, $exceptions, true);

header("Status: 302 Moved Temporarily");
header("Location: index.php?id=$modules");
?>