<? require("../include/global_login.php");
require("../include/function.inc.php");
?>
<head>
        <title>DELETE COURSE</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
        <script language="javascript">
                function update(){
                        top.ws_menu.location.reload();
                }
        </script>
</head>
<? $check_ok=mysql_query("SELECT * FROM courses WHERE id=$delete AND users=".$person["id"].";");
 if(mysql_num_rows($check_ok)!=0){
		// Move a deleted record from coures to coures_deleted
		$dlc=mysql_query("select * from courses where id=$delete");
		$row=mysql_fetch_array($dlc);
//echo ("INSERT INTO courses_deleted ( id, name, active, applyopen, info , users , fullname , section , quota ) 
//VALUES ('".$row["id"]."','".$row["name"]."', '".$row["active"]."', '".$row["applyopen"]."', '".$row["info"]."', ".$row["users"].", '".$row["fullname"]."', '".$row["section"]."', ".$row["quota"].")");

		if(mysql_query("INSERT INTO courses_deleted ( id, name, active, applyopen, info , users , fullname , section , quota ) 
VALUES ('".$row["id"]."','".$row["name"]."', '".$row["active"]."', '".$row["applyopen"]."', '".$row["info"]."', ".$row["users"].", '".$row["fullname"]."', '".$row["section"]."', ".$row["quota"].");"))
{
        mysql_query("DELETE FROM courses WHERE id=$delete;");
        mysql_query("DELETE FROM wp WHERE courses=$delete;");
		mysql_query("INSERT INTO courses_history (courses,delete_time,users) values ($delete,".time().",".$person["id"].");");
		//***********insert modules_history***************
		$action="Delete courses";
		Imodules_h2(0,$action,$person["id"],0,0,$delete,$delete);

		// Delete Syllabus file
		$result=mysql_query("SELECT newuploadfilename from syllabus where courses = $delete");
		if($row=mysql_fetch_array($result))
		{		$path="../files/syllabus/$delete";
				if ($row["newuploadfilename"]!=none)
				{
					unlink($path."/".$row["newuploadfilename"]);
					@rmdir($path);
				}
		}
		mysql_query("DELETE FROM syllabus where courses = $delete");
		mysql_query("DELETE FROM wp_access WHERE courses=$delete;");
 }
        ?>
        <body bgcolor="#ffffff" onLoad="update();">
        <p>&nbsp;</p>
        <div align="center" class="h2">Deleted...</b></div>
        <?
                }
        ?>
        </body></html>
