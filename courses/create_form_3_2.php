<?	require("../include/global_login.php");?>
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
 
	    if($courses==0){				
			mysql_query("INSERT INTO courses (name,users) values('unreg',".$person["id"].")");
			$courses=mysql_insert_id();				
			mysql_query("INSERT INTO wp (courses,users,admin) values($courses,".$person["id"].",'1');");
			// Jitti  for Stampintg time when the course  was created for the first time 
			mysql_query("INSERT INTO courses_history (courses,open_time,users) values ($courses,".time().",".$person["id"].");");			
        }
        if($active=="true"){
            $active=1;
        }else{
            $active=0;
        }
        mysql_query("UPDATE courses set name=\"$name\",fullname=\"$fullname\",fullname_eng=\"$fullname_eng\",info=\"$info\",applyopen=$applyopen,active=$active,section=\"$section\" 
					 WHERE id=$courses;");
		if($active==1){
			mysql_query("insert into courses_history (courses,active_time,users) values($courses,".time().",".$person["id"].");");
		}else { 
			mysql_query("insert into courses_history(courses,inactive_time,users) values ($courses,".time().",".$person["id"].");");
		}

		// Auto add member
		if($add_member=="yes"){
		
			$array = explode(",", $section);
			for($i=0; $i < count($array); $i++)
			{
				$gsql=mysql_query("SELECT STD_ID FROM ku_classlist WHERE CS_CODE='$name' and  LC_SECTION='$array[$i]' ORDER BY STD_ID asc;");
				while($row3=mysql_fetch_array($gsql))
				{
					$gsql2=mysql_query("SELECT distinct  * FROM ku_student	where STD_ID =".$row3["STD_ID"].";");
						if(mysql_num_rows($gsql2)==1)
						{
							$row4=mysql_fetch_array($gsql2);
							$major= substr($row4["MAJOR_ID"], 0,1);
							if($major=="X"){$std_title="g";}else{$std_title="b";}
							$s=substr($row4["STD_ID"],0,7);
							$login=$std_title.$s;
							$email=$login."@ku.ac.th";
							$check_ex=mysql_query("SELECT id FROM users WHERE login like '$login';");
							if(mysql_num_rows($check_ex)==0){
								if(
									mysql_query("INSERT INTO users (active,login,title,firstname,surname,password,category,email) values (1,'$login','".$row4["STD_TITLE"]."','".$row4["STD_NAME"]."','".$row4["STD_SURNAME"]."','asd323',3,'$email');"))
									{
										$got_id=mysql_insert_id();
										mysql_query("INSERT INTO users_info(id) values ($got_id);");
										//echo $got_id;
										// Must be check Exist in course but not be member user 
										mysql_query("INSERT INTO wp (courses,users) values($courses,$got_id);");
										//mysql_query("INSERT INTO wp (courses,users) values ('$courses','$got_id');");
										//echo ("INSERT INTO users (active,login,title,firstname,surname,password,category,email) values (1,'$login','".$row4["STD_TITLE"]."','".$row4["STD_NAME"]."','".$row4["STD_SURNAME"]."','asd323',3,'$email');");																	
									}
							} else {
								$row_user = mysql_fetch_array($check_ex);
								mysql_query("INSERT INTO wp (courses,users) values($courses,".$row_user["id"].");");
							}														
						}								
				}
			}
						   		
		}
		
		?>
        <body bgcolor="#ffffff" onLoad="update();">
        <p>&nbsp;</p>
        <div align="center" class="h3">OK, created <b><?echo $name?></b>.</div>
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