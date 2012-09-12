<? require("../include/global_login.php");

$newfile_name=strtolower($file_name);
$newfile_name=str_replace(".php",".htm",$newfile_name);
$newfile_name=str_replace(".cgi",".htm",$newfile_name);
$newfile_name=str_replace(".pl",".htm",$newfile_name);
$newfile_name=str_replace(".phtml",".htm",$newfile_name);
$newfile_name=str_replace(".shtml",".htm",$newfile_name);
$newfile_name=str_replace("'","&#039;",$newfile_name);

if($id==0){
        mysql_query("INSERT INTO news (name,news_types,file,users,time)
values('".str_replace("'","&#039;",$name)."',$news_types,'$newfile_name',".$person["id"].",".time().");");
        $id=mysql_insert_id();
}else{
        mysql_query("UPDATE news set name='".str_replace("'","&#039;",$name)."', news_type=$news_type, time=".time().", file='$newfile_name' WHERE id=$id;");
}
/*
exec("rm -R -f $realpath/homework/files/$id");
$allpath=$realpath."/homework/files/".$id;
mkdir($allpath,0777);
chmod($allpath,0777);
copy($file,$allpath."/".$newfile_name);
mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");
header("Status: 302 Moved Temporarily");
header("Location: index.php?id=$modules");
*/
?>