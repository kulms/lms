<?

$forum=new Forum('',$person["id"],$module,$courses,'');

$delay = 5;           

$result=$forum->get_prefs();

$names=$forum->select_modulename();

if (isset($names)) {

  $forumname = $names[0]['name'];
	$foruminfo = $names[0]['info'];
    }

$sort = $result[0]['orders'];
$showonline = $result[0]['show_online'];
$timedelay = $result[0]['time_delay'];
$begindate = $result[0]['begin_date'];
$enddate =  $result[0]['end_date'];
$refresh =  $result[0]['refresh'];



?>
<html>
<head>
<title>Forum</title>
<?
if($refresh==1){
?>
<meta http-equiv="refresh" content="<? if ($timedelay==0 || $timedelay ==""){ echo $delay;}else{echo $timedelay;}?>">
<?
} else {
?>
<meta http-equiv="refresh" content="180">
<?
}
?>
<link href="../themes/<?echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">

<script type="text/javascript">

function setscroll()
{


document.body.scrollTop = 500000




}


</script>

</head>

<body <?if ($sort==0) echo "onload =\"setscroll();\"";?> >



<table width="100%" cellpadding="2" cellspacing="1">
  <tr class="boxcolor">
    <td colspan="2" class="Bcolor"><? echo $strForum_Labmsg."\t\t( ".$forumname." )"."\t\t( ".$foruminfo." )";?></td>
    
  </tr>
  
<?
	
$forum->show_forum($showonline,$sort,$begindate,$enddate);

?>
</table>

</body>
</html>
