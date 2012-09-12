<?require("calfunc.php"); ?>
<form action="dayconvert.php" method="post">
<input type="text" name="day">
<input type="submit" name="submit" value="submit">
</form>

<?
if($submit=="submit"){
$d=mktime(0,0,0,date("m"),date("d"),date("Y"));
$nextday=fixday($d,+$day);
echo $nextday;
}
?>