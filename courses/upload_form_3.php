<?php
	require("../include/global_login.php");
	?>
<html>
<head>
        <title>Create course</title>
        <script language="javascript">

</script>

<link rel="STYLESHEET" type="text/css" href="../main.css">

<script language="javascript">
		function update(){
				top.ws_menu.location.reload();
		}
</script>

</head>
   <?php 
   

   $check=mysql_query("SELECT * FROM users WHERE category=2 and id=".$person["id"].";");
	if(mysql_num_rows($check)==1){

	  	        mysql_query("INSERT INTO  courses (name,active,applyopen,users,fullname,fullname_eng,section,fac_id,dept_id,keyword) VALUES
					('$name','0','-1',".$person["id"].",'$fullname','$fullname_eng','$section','$fac','$dept','$keyword');");
                $courses=mysql_insert_id();				
                mysql_query("INSERT INTO wp (courses,users,admin) values($courses,".$person["id"].",'1');");
				
	$allpath=$realpath."/files/syllabus/".$courses;
	$newfile_name=strtolower($file_name);
	$newfile_name=strtr($newfile_name,"дец? ","aaoq_");
	$newfile_name=str_replace(".php",".html",$newfile_name);
	$newfile_name=str_replace(".cgi",".html",$newfile_name);
	$newfile_name=str_replace(".pl",".html",$newfile_name);
	$newfile_name=str_replace(".phtml",".html",$newfile_name);
	$newfile_name=str_replace(".shtml",".html",$newfile_name);
	$newfile_name=str_replace("'","&#039;",$newfile_name);
	$newfile_name=str_replace(" ","_",$newfile_name);
	

			mkdir($allpath,0777);
			chmod($allpath,0777);
			copy($file,$allpath."/".$newfile_name)
                                                        
		?>
        <body bgcolor="#ffffff" onLoad="update();">
        <p>&nbsp;</p>
        <div align="center" class="h3">OK,  <b><?echo $name?>'s syllabus was  uploaded successfully.</b>.</div>
        <? 
}else{
        //User don't have access to this script!
        ?>
        <body bgcolor="#ffffff">
        <p>&nbsp;</p>
        <div align="center" class="h3">You don't have access to this script!!</div>
<?
	}
?>
</body>
</html>