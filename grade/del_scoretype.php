<?
 
 /*
  mysql_query("delete from g_score_type where g_score_type_id = $id");
  mysql_query("delete from g_std_raw_score where g_score_type_id = $id");
 
  
  echo "<script language='javascript'>location.href='?id=$gid';</script>";
*/

//Update (29/03/05)
switch ($del){
	case 'modules':
			//echo "del module";
			mysql_query("UPDATE g_score_type SET g_modules_id=0,g_modules_type=0");
			echo "<script language='javascript'>location.href='?a=edit_scoretype&id=$id&gid=$gid&courses=$courses';</script>";
	break;

	case 'score':
		//echo "del score";
		mysql_query("delete from g_score_type where g_score_type_id = $id");
		mysql_query("delete from g_std_raw_score where g_score_type_id = $id");
		echo "<script language='javascript'>location.href='?id=$gid&courses=$courses';</script>";
	break;

}
//----
  ?>