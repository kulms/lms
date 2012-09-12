<? 
//********function modules*************
function Caction($modules_id,$action)
{
		$sql=mysql_query("SELECT a.id FROM action a,modules m WHERE m.id=$modules_id AND m.modules_type=a.modules_type AND a.action='".$action."' ");
		$action_id=@mysql_result($sql,0,"id");
		return $action_id;
}

function Imodules_h($modules_id,$action,$user_id,$courses)
{
	$action_id=Caction($modules_id,$action);
	$sql=mysql_query("SELECT name  FROM modules  WHERE id=$modules_id");
	$Name=mysql_result($sql,0,"name");
	mysql_query("INSERT INTO modules_history (modules_id,time,user,action_id,name,courses) VALUES ($modules_id,".time().",$user_id,$action_id,'".$Name."',$courses)");
	//echo "INSERT INTO modules_history (modules_id,time,user,action_id,name,courses) VALUES ($modules_id,".time().",$user_id,$action_id,'".$Name."',$courses)";
}

//********function folder and group and couses*************
function Imodules_h2($modules_type,$action,$user_id,$group_id,$folder_id,$courses_id,$courses)
{
	if($group_id !=0){
		$sql=mysql_query("SELECT name  FROM groups  WHERE id=$group_id");
		$Name=mysql_result($sql,0,"name");
	}
	if($folder_id !=0){
		$sql=mysql_query("SELECT name  FROM folders  WHERE id=$folder_id");
		$Name=mysql_result($sql,0,"name");
	}
	if($courses_id !=0){
		$sql=mysql_query("SELECT name  FROM courses  WHERE id=$courses_id");
	//	if(mysql_num_rows($sql)!=0)
			$Name=mysql_result($sql,0,"name");
//		else{
//			$sql=mysql_query("SELECT name  FROM courses_deleted   WHERE id=$courses_id");
//			$Name=mysql_result($sql,0,"name");
//		}
	}
	$sql=mysql_query("SELECT id FROM action WHERE modules_type=$modules_type AND action='".$action."' ");
	$action_id=mysql_result($sql,0,"id");
	mysql_query("INSERT INTO modules_history (time,user,action_id,group_id,folder_id,courses_id,name,courses) VALUES (".time().",$user_id,$action_id,$group_id,$folder_id,$courses_id,'".$Name."',$courses)");
}

//**************function report******************

?>