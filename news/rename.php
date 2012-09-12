<?require("../include/global_login.php");
if ($news_in=="") {$news_in=0;}
$oldbody=$bodytext;
$bodytext = eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])","<a href=\"\\1://\\2\\3\" target=\"\\2\\3\">\\1://\\2\\3</a>",$bodytext);
$bodytext = eregi_replace("([[:alnum:]]+)@([^[:space:]]*)([[:alnum:]])","<a href=mailto:\\1@\\2\\3>\\1@\\2\\3</a>",$bodytext);
if($news_in=="" || $news_in=='0'){$news_in="-------";}
mysql_query("UPDATE news set name='".str_replace("'","&#039;",$name)."', time=".time().", news_id='$news_id', news_in='$news_in',forstd='$forstd', forlect='$forlect', forstaff='$forstaff', forge='$forge', firstpage='$firstpage',body='$oldbody',bodytext='$bodytext' WHERE id=$id;");
?>

<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<script language="javascript">
</script>
</head>
<body onLoad="top.ws_menu.location.href='menu.php';">
<div align="center" class="main"> News  updated...</div>
</body>
</html>
<?
//header("Status: 302 Moved Temporarily");
//header("Location: menu.php?id=$id");
?>