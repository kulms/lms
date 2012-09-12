<?require("../include/global_login.php");
require("calfunc.php");
$d=mktime(0,0,0,date("m"),date("d"),date("Y"));
$expire=fixday($d,+$expire);
function genfile(){
        srand((double)microtime()*1000000);
        $numchar=rand(4,6);
        $temp="";
        for($b=0;$b<$numchar;$b++){
                $chrnum=rand(48,109);
                if($chrnum>57){
                        $chrnum+=7;
                }
                if($chrnum>90){
                        $chrnum+=6;
                }
                $temp=$temp.chr($chrnum);
        }
        return $temp;
}
$randfile=genfile();

$newfile_name=strtolower($file_name);
$filetype=substr($newfile_name,-3);
$filed=$randfile.".".$filetype;

if($news_type=="0"){echo "<a href=\"javascript:history.go(-1)\">Failed: ท่านไม่ได้ระบุประเภทของข่าว</a>"; exit(); }
if($news_id==""){$news_id=0;}
if($id==0){
        mysql_query("INSERT INTO news (name,text,file,news_type,news_group,news_id,news_in,users,response,time,forstd,forlect,forstaff,forge,firstpage,expire)
values('$name',0,'$filed',$news_type,$news_group,'$news_id','$news_in',".$person["id"].",$res,".time().",'$forstd','$forlect','$forstaff','$forge','$firstpage','$expire');");
        $id=mysql_insert_id();
        exec("mkdir $realpath/files/news/$id");  
}
if($id!=0 && $newpage=="add"){
    mysql_query("INSERT INTO news_page (from_news,page,file)values($id,$page,'$filed');");
}
if($id!=0 && $newpage!="add") {
        mysql_query("UPDATE news set text=0, time=".time().", file='$filed', news_id='$news_id', news_in='$news_in' WHERE id=$id;");
}
//exec("rm -R -f $realpath/news/imgfiles/$filed");
$allpath=$realpath."/files/news/$id";
copy($file,$allpath."/".$filed);
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
<div align="center" class="main">News + Files Added...</div>
</body>
</html>
<?
/*
header("Status: 302 Moved Temporarily");
header("Location: menu.php?id=$id");
 */

  ?>