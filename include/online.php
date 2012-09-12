<?php
require("global.php");
function online($user_session,$time,$session,$status,$user_id) {
    $past = time()-900;	
    $sql = "DELETE FROM session WHERE time < $past";
	mysql_query($sql);
	if ($status == 0){
		$sql = "SELECT time FROM session WHERE user_session='$user_session'";
		$result = mysql_query($sql);
		$ctime = time();
		if ($row = mysql_fetch_row($result)) {
			$sql = "UPDATE session SET user_session='$user_session', time='$ctime', session='$session', status='$status', user_id='$user_id' WHERE user_session='$user_session'";
			mysql_query($sql);
		} else {
			$sql = "INSERT INTO session (user_session, user_id, time, session, status) VALUES ('$user_session', '$user_id', '$ctime', '$session', '$status')";
			mysql_query($sql);
		}
	} else {
		$sql = "SELECT time FROM session WHERE user_session='$user_session'";
		$result = mysql_query($sql);
		$ctime = time();
		if ($row = @mysql_fetch_row($result)) {
			$sql = "UPDATE session SET user_session='$user_session', time='$ctime', session='$session', status='$status', user_id='$user_id' WHERE user_session='$user_session'";
			mysql_query($sql);
		} else {
			$sql = "INSERT INTO session (user_session, user_id, time, session, status) VALUES ('$user_session', '$user_id', '$ctime', '$session', '$status')";
			mysql_query($sql);
		}
	}	
}

function online_courses($user_session,$users,$courses,$time,$online) {

    $past = time()-900;	
    $sql = "DELETE FROM login_courses WHERE time < $past";
	mysql_query($sql);

	if ($online == 1){
		$sql = "SELECT time FROM login_courses WHERE user_session='$user_session'";
		$result = mysql_query($sql);
		$ctime = time();
		if ($row = @mysql_fetch_row($result)) {
			$sql = "UPDATE login_courses SET user_session='$user_session', users=$users, courses=$courses, time='$ctime' WHERE user_session='$user_session'";
			mysql_query($sql);
		} else {
			$sql = "INSERT INTO login_courses (user_session, users, courses, time) VALUES ('$user_session', $users, $courses, $ctime)";
			mysql_query($sql);
		}
	} else {
		$sql = "DELETE FROM login_courses WHERE user_session='$user_session'";
		mysql_query($sql);		
	}	
}

function Login($user_id,$user_session)
{
	$sql=mysql_query("SELECT id FROM action WHERE modules_type=99 AND action='Login' ");
	$action_id=mysql_result($sql,0,"id");
	mysql_query("INSERT INTO login(users,user_session,time,action_id) VALUES (".$user_id.",'".$user_session."',".time().",$action_id)");
}

function Logout($user_session)
{
	$sql=mysql_query("SELECT id FROM action WHERE modules_type=99 AND action='Logout' ");
	$action_id=mysql_result($sql,0,"id");

	$sql=mysql_query("SELECT users FROM login WHERE user_session='".$user_session."' AND action_id !=$action_id " );
	$num=mysql_num_rows($sql);
	$user_id = mysql_result($sql,0,"users");

	if($num != 0){
		mysql_query("INSERT INTO login(users,user_session,time,action_id) VALUES (".$user_id.",'".$user_session."',".time().",$action_id)");
	}
}

?>