<?
header("Content-type: text/css");

$win=eregi("Win",$HTTP_USER_AGENT);
$mac=eregi("Mac",$HTTP_USER_AGENT);
$ie=eregi("MSIE",$HTTP_USER_AGENT);

if($win){
	if($ie){
		require("main_pc_ie.css");
	}else{
		require("main_pc_ns.css");
	}
}else{
	if($mac){
		if($ie){
			require("main_mac_ie.css");
		}else{
			require("main_mac_ns.css");
		}
	}else{
		require("main_other.css");
	}
}
?>