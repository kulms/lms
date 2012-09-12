<?	require("../include/global_login.php");
require("../include/function.inc.php");
?>
<html>
<head>
        <title>Create course</title>
        <script language="javascript">
function startup(){
        document.course.elements["courseadmins[]"].options[0]=null;
        document.course.elements["users[]"].options[0]=null;
}
function addadmin(){
        for(a=document.course.elements["users[]"].options.length-1;a>-1;a--){
                if(document.course.elements["users[]"].options[a].selected){
                        document.course.elements["courseadmins[]"].options[document.course.elements["courseadmins[]"].options.length]=new Option(document.course.elements["users[]"].options[a].text,document.course.elements["users[]"].options[a].value);
                        document.course.elements["users[]"].options[a]=null;
                }
        }
}
function removeadmin(){
        for(a=document.course.elements["courseadmins[]"].options.length-1;a>-1;a--){
                if(document.course.elements["courseadmins[]"].options[a].selected){
                        document.course.elements["users[]"].options[document.course.elements["users[]"].options.length]=new Option(document.course.elements["courseadmins[]"].options[a].text,document.course.elements["courseadmins[]"].options[a].value);
                        document.course.elements["courseadmins[]"].options[a]=null;
                }
        }
}
function mark_all(){
        for(a=document.course.elements["courseadmins[]"].options.length-1;a>-1;a--){
                document.course.elements["courseadmins[]"].options[a].selected=true;
        }
}

</script>

<link rel="STYLESHEET" type="text/css" href="../main.css">

<script language="javascript">
		function update(){
				top.ws_menu.location.reload();
		}
</script>

</head>
   <? 
   	$check=mysql_query("SELECT * FROM users WHERE category=2 and id=".$person["id"].";");
	if(mysql_num_rows($check)==1){
	    if($courses==0){				
			mysql_query("INSERT INTO courses (name,users) values('".$name."',".$person["id"].")");
			$courses=mysql_insert_id();				
			mysql_query("INSERT INTO wp (courses,users,admin) values($courses,".$person["id"].",'1');");
			// Jitti  for Stampintg time when the course  was created for the first time 
			mysql_query("INSERT INTO courses_history (courses,open_time,users) values ($courses,".time().",".$person["id"].");");	
					//***********insert modules_history***************
		$action="Create courses";
		Imodules_h2(0,$action,$person["id"],0,0,$courses,$courses);
        }
        if($active=="true"){
            $active=1;
        }else{
            $active=0;
        }

        mysql_query("UPDATE courses set name=\"$name\",fullname=\"$fullname\",fullname_eng=\"$fullname_eng\",info=\"$info\",applyopen=$applyopen,active=$active,section=\"$section\",year=$year,semester=$semester,section_type = $stype 
					 WHERE id=$courses;");
					//***********insert modules_history***************
		$action="Update courses";
		Imodules_h2(0,$action,$person["id"],0,0,$courses,$courses);

		if($active==1){
			mysql_query("insert into courses_history (courses,active_time,users) values($courses,".time().",".$person["id"].");");
		}else { 
			mysql_query("insert into courses_history(courses,inactive_time,users) values ($courses,".time().",".$person["id"].");");
		}
		
		/*								
        //Save administrators
        mysql_query("UPDATE wp set admin=0 WHERE courses=$courses AND NOT users=0;");
		
        if(is_array($courseadmins)){
                while(list($key,$val)=each($courseadmins)){												
                        $check=mysql_query("SELECT * from wp WHERE users=$val AND courses=$courses;");
                        if(mysql_num_rows($check)!=0){
                                mysql_query("UPDATE wp set admin=1 WHERE users=$val AND courses=$courses;");
                        }else{
                                mysql_query("INSERT INTO wp (users,courses,admin) values($val,$courses,1);");
                        }						
                }
        }
		*/
        //add module_type-access
        mysql_query("DELETE from wp_access WHERE courses=$courses AND users=0;");
        /*if(is_array($modules_type)){
                while(list($key,$var)=each($modules_type)){						
                        mysql_query("INSERT INTO wp_access(courses,modules_type) VALUES ($courses,".$var.")");
                }
        }
		*/
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