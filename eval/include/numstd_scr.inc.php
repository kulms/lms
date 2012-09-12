<?
function Get_Value_from_array2($srch_value,$srch_value2,&$srch_array,$srch_col_name,$srch_col_name2,$ret_col_name)
{
	$i=0;
	while($i < count($srch_array))
	{
		if(($srch_array[$i][$srch_col_name] == $srch_value) && ($srch_array[$i][$srch_col_name2] == $srch_value2))
		{
			return	 $srch_array[$i][$ret_col_name];
			//return true;
		}
		$i++;
	}	
	return (0);
}

/*
$sqlCmd="select *  from Sexualintercourse_DimY order by lv1,lv2,lv3,lv4";
$db->db_query($sqlCmd);
$init_YDim = array();

while ($row = $db->db_fetch_array())
{
	array_push($init_YDim,$row);
}
*/
?>