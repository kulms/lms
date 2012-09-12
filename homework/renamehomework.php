<? require("../include/global_login.php");
 include("../include/function.inc.php");
 //Courses_id
$courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$modules.";");
$courses=mysql_result($courseid,0,"courses");


$getresources=mysql_query("SELECT * FROM modules WHERE id=$modules AND users=".$person["id"].";");
$checkdate=mysql_query("SELECT * FROM homework_prefs WHERE modules=$modules;");
if($active==""){
                $active = 0;
               }
if(mysql_num_rows($getresources)!=0){
        mysql_query("UPDATE modules set name='".str_replace("'","&#039;",$homeworkname)."', info='$info', active=$active WHERE id=$modules;");
}
//***********insert modules_history***************
	$action="Update";
	Imodules_h($modules,$action,$person["id"],$courses);
if($end_date==""){
                        $in_date=0;
                 }else{
				 		
                        $date_parts = explode("/",$end_date);
						//echo $date_parts[0]."0<BR>";
						//echo $date_parts[1]."1<BR>";
						//echo $date_parts[2]."2<BR>";
						//echo $date_parts[3]."3<BR>";
						 					
                        if($date_parts[2]<1990){
                                $years=1990+$date_parts[2];
                        }else{
                                $years=$date_parts[2];
                        }
                        //if($hr==""){
                        //$in_date=mktime(23,59,59,$date_parts[1],$date_parts[0],$years);
                        //}else{						
						//$in_date=mktime($date_parts[3],0,0,$date_parts[1],$date_parts[0],$years);
                        $in_date=mktime($hr,$mnt,59,$date_parts[1],$date_parts[0],$years);
						//echo $in_date;
                         //}
                }

                if(mysql_num_rows($checkdate)!=0){
                        $sql = "UPDATE homework_prefs SET modules=$modules, end_date=$in_date, hour=$hr,minute=$mnt WHERE modules=$modules;";
                }else{
                        $sql = "INSERT INTO homework_prefs(modules,end_date,hour,minute) VALUES($modules,$in_date,$hr,$mnt);";
                }
                //echo $sql;
                mysql_query($sql);
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
<div align="center" class="main">Homework updated...</div>
</body>
</html>
<?
mysql_close();
?>