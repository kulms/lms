<?
function GetNameUID($uid){
	$sql = "SELECT id,login   
			FROM users
			WHERE id ='$uid' ";
	$rs = mysql_query($sql);
	$arr= mysql_fetch_array($rs);
	return $arr[login];
}
	
function FormatDate($oldDate){
	$ndate = date("d/m/Y H:s",$oldDate);
	return $ndate;
}

function GetDetailMsg($msg_id,$uid){

if($msg_id ==""){
$sql = "SELECT msg_id,msg_type,msg_priority,msg_subject,msg_message,msg_from_uid,msg_to_uid,msg_date,msg_enable
			FROM msg
			WHERE  msg_to_uid='$uid' ";
}else{
$sql = "SELECT msg_id,msg_type,msg_priority,msg_subject,msg_message,msg_from_uid,msg_to_uid,msg_date,msg_enable
			FROM msg
			WHERE msg_id = '$msg_id'  
			 ";//AND msg_to_uid='$uid'
}
	$rs = mysql_query($sql);
   $num=mysql_num_rows($rs);
	 while($arr= mysql_fetch_array($rs))
		{
			//echo $arr['msg_id'];
			$msg_id=$arr['msg_id'];
			$msg_type=$arr['msg_type']; 
			$msg_priority=$arr['msg_priority'];
			$msg_subject=$arr['msg_subject'];
			$msg_message=$arr['msg_message'];
			$msg_from_uid=$arr['msg_from_uid'];
			$msg_to_uid=$arr['msg_to_uid'];
			$msg_date=$arr['msg_date'];
			$msg_enable=$arr['msg_enable'];
		}
return array($msg_id,$msg_type,$msg_priority,$msg_subject,$msg_message,$msg_from_uid,$msg_to_uid,$msg_date,$msg_enable);
}



function  updateType($nType,$msg_id){
$sql ="UPDATE msg
			SET msg_type='$nType'
			WHERE msg_id='$msg_id' ";
$rs = mysql_query($sql);

}
?>
