<?require("../include/global_login.php");
require("calfunc.php");
$d=mktime(0,0,0,date("m"),date("d"),date("Y"));
$expire=fixday($d,+$expire);
if ($news_id=="") {$news_id=0;}
 $oldbody=$bodytext;
$bodytext = eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])","<a href=\"\\1://\\2\\3\" target=\"\\2\\3\">\\1://\\2\\3</a>",$bodytext);
$bodytext = eregi_replace("([[:alnum:]]+)@([^[:space:]]*)([[:alnum:]])","<a href=mailto:\\1@\\2\\3>\\1@\\2\\3</a>",$bodytext);

mysql_query("INSERT INTO news (name,text,news_type,news_group,news_id,users,response,time,forstd,forlect,forstaff,forge,firstpage,expire,body,bodytext)
values('$name',1,'$news_type','$news_group','$news_id',".$person["id"].",$res,".time().",'$forstd','$forlect','$forstaff','$forge','$firstpage','$expire','$oldbody','$bodytext');");
//mysql_query("INSERT INTO news (name,text,news_type,news_id,users,response,time,forstd,forlect,forstaff,forge,firstpage)
//values('$name',1,$news_type,$news_id,".$person["id"].",$res,".time().",'$forstd','$forlect','$forstaff','$forge','$firstpage');");
?>
<html>
<head>
        <title>update</title>
<script language="javascript">
        function update(){
                top.ws_menu.location.reload();
        }
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body onLoad="update()" bgcolor="#ffffff">
<div align="center" class="main">News Added...</div>
</body>
</html>