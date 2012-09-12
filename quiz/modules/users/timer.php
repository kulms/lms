<? 
 require ("../include/global_login.php");
?>
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="images/main.css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body>
<? if($time == 1) {
if ($id!=""){
	$modules = $id;
}
$sql=mysql_query("SELECT timeLimit  FROM q_module_prefs WHERE module_id ='".$modules."' ");
$timeLimit1=mysql_result($sql,0,'timeLimit');
$sec=$timeLimit1*60;

$sql=mysql_query("SELECT occasion_id  FROM q_occasions  WHERE module_id ='".$modules."' AND finished =0 ");
$occ=mysql_result($sql,0,'occasion_id');
?>
<form action="?a=main&m=users&occ=<? echo $occ ?>&id=<? echo $modules?>&time=0&submit=submit"  method="post"  target="_parent" name="aform"> 
<input type="hidden" name="quizId" value="1" >
<input id='timeleft' name="timeleft" type="hidden" value="<? echo $sec?>" ><br>
<?php //if ($this->_tpl_vars['quiz_info']['timeLimited'] == 'y'): ?>
เวลาในการทำแบบทดสอบ:&nbsp;
<input id='minleft' name="minleft" type="text" size="3" value=0  disabled class="text"  align="left">:<input size="3" id='secleft' name="secleft" type="text" value=0  disabled class="text" align="right" >
<script language='Javascript' type='text/javascript'>
<?php echo '
var itid;
function settimeleft() {
  document.getElementById(\'timeleft\').value -= 1;
  if(document.getElementById(\'timeleft\').value<1) {
    window.clearInterval(itid); 
    document.aform.submit();
  }
  document.getElementById(\'minleft\').value = Math.floor(document.getElementById(\'timeleft\').value/60);
  document.getElementById(\'secleft\').value = document.getElementById(\'timeleft\').value%60; 
}
itid = window.setInterval(\'settimeleft();\',1000); 
settimeleft(itid);
'; ?>
</script>
</form> 
<? }?>
</body>
</html>
