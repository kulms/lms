<?
$report = new Report('');
$time = $report ->SelectTimeDB();
if($time !=0){
		$report ->RefreshDB($time);
}else{
		$report ->RefreshDB(0);
}
require "header.php"; 
?>