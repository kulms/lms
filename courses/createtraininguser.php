<?   //require("../include/global.php");
	// require("../../online_training/global_login.php");
	$db1=mysql_connect('server1','user1','pwd1');
	$result = mysql_query("SELECT * WHERE 1=1",$db1)
?>
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<title>Create Training User in M@xlearn</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body>
<!-- 
<form name="add" method="post">
&ordf;&times;&egrave;&Iacute; : <input type="text" name="username">
&uml;&Oacute;&sup1;&Ccedil;&sup1; : <input type="text" name="amount">
<input type="submit" name="submit" value="submit">
</form><br>
Forreset Password
<form name="reset" method="post">
&Atilde;&Euml;&Ntilde;&Ecirc;&sup1;&Oacute;&Euml;&sup1;&eacute;&Ograve; (&agrave;&ordf;&egrave;&sup1; tuxml) <input type="text" name="namelike"><br>
<input type="submit" name="resetpasswd" value="resetpasswd">
</form>
<br>
- - - - - - - - - - - Change Login - - - - - - - - - 
<br>
<form name="update" method="post">
  First_userID :
  <input name="first_u_id" type="text">
  ; Last_userID : 
  <input name="last_u_id" type="text">
  <br>
  Prefix-Login : 
  <input name="prefix_login" type="text" id="prefix_login"><br>
  <input type="submit" name="LoginSubmit" value="U p d a t e">
</form>
<br>
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
<br> ####### DB 'courses' ########
<form name="courses_frm" method="post">
		  <input name="add_course" type="submit" id="add_course" value="Add Course"><br>
		  <input type="submit" name="add_wp" value="Add wp"><br>
		  <input type="submit" name="add_maxlearn_wp_id" value="add_maxlearn_wp_id"><br>
		  <input type="submit" name="login_passwd" value="MD5_passwd_with_login"><br>
		  <input type="submit" name="add_courses" value="COURSES"><br>
		  <input type="submit" name="add_courses" value="COURSES"><br>
		  <input type="submit" name="report_trainee_info" value="report_trainee_info"><br>
</form>
<br> ####### DB 'online_training' ########
<form name="updateUTfrm" method="post">
  <input name="updateUT" type="submit" id="updateUT" value="Update Users by Users_Training">
</form>
<br>
<form name="addWPTfrm" method="post">
  <input name="add_WPT" type="submit" id="add_wpt" value="Add wp training">
</form>
----------------------------------------------<br><br> 
-->
</body>
</html>
<?   // #######   UPDATE  Login   ########
//		if($LoginSubmit)
//		{
//		       $sel_training=mysql_query("SELECT *  FROM users WHERE id!=1 AND id!=12;");
//			   while($row_t=mysql_fetch_array($sel_training)){
//						mysql_query("UPDATE users set category='4'  where  id='".$row_t["id"]."';");
//						echo("UPDATE users set category='4'  where  id='".$row_t["id"]."';"); 
						
		        //$sel_users=mysql_query("SELECT *  FROM users WHERE id>=$first_u_id AND id<=$last_u_id");
				//$sel_users=mysql_query("SELECT *  FROM users WHERE id>='3449' AND id<='3518';");    		   			
				//$sel_uTraining=mysql_query("SELECT * FROM users_training  WHERE id!=1 AND id!=12;");
   /*			   while($row=mysql_fetch_array($sel_users)){
								mysql_query("UPDATE users set category='5'  where  id='".$row["id"]."';");
								echo("UPDATE users set category='4'  where  id='".$row["id"]."';");                        */
					//$sel_uTraining=mysql_query("SELECT * FROM users_training  WHERE id!=1 OR id!=12;");
					// mysql_query("UPDATE users set login='tumcn".$row["login"]."'  where  id='".$row["id"]."';");
					// echo("UPDATE users set login='tumcn".$row["login"]."'  where  id='".$row["id"]."';");
							//	$passwd=$row["password"];
							//	$password=MD5("$passwd");
							//	mysql_query("UPDATE users set password='$password'  where  id='".$row["id"]."';");
							//	echo("UPDATE users set password='$password'  where  id='".$row["id"]."';");
//				}
//		}
	  // #######   SUBMIT  ########
/* if($submit)
	 {		$num=1;  
	         //$amount=mysql_query("SELECT  count(*)  FROM users WHERE  id=9 OR( id>12 AND id<82) or id>82 ;");// id!='1'  OR id!='3'  OR id!='82' OR id!='12'
	 		$sel_training=mysql_query("SELECT id,active,login,password FROM users WHERE id=9 OR  ( id>12 AND id<82) OR id>82;");
	 	while( $row_t=mysql_fetch_array($sel_training) ) {
			
				//	if($num <= $amount){
						//$num++; echo $num."<br>";
						$username="tumcn";
						$login="$username".$num;
						$password=MD5("$username".$num);
								//$res=mysql_query("UPDATE  users SET login='$login', password='$password' WHERE id=".$id."; ");
								echo "num=".$num."; amount=".$amount." : res=UPDATE  users SET login='$login', password='$password' WHERE id=".$row_t["id"].";<br>";
			//		}
					//$stmp=mysql_query("UPDATE  users SET active='1', login='$login', password='$password', category='5';");
				   // echo $stmp."<br>";
					$stmp=mysql_query("UPDATE  users SET login='$login', password='$password' WHERE  id=".$row_t["id"].";");
				   // echo $stmp."<br>";
					$num++;
			}
		} 		
	// }
	*/
/* if($submit)
	 {    $sel_users=mysql_query("SELECT id, login  FROM users  WHERE id>3453 AND id<3519;");
			while( $row_u=mysql_fetch_array($sel_users) ) {
						//$sel_training=mysql_query("SELECT id, maxlearn_user_id  FROM users_training WHERE id=".$row_u["id"].";");
						echo "UPDATE users_training SET  maxlearn_user_id=".$row_u["id"]." WHERE login='".$row_u["login"]."';<br>";
						mysql_query("UPDATE users_training SET  maxlearn_user_id=".$row_u["id"]." WHERE login='".$row_u["login"]."';");
				}
		} 			
*/
/*   LAST UPDATE - - - - -
	if($submit)
	{
			 $sel_training=mysql_query("SELECT *  FROM users_training;");
			while( $row_t=mysql_fetch_array($sel_training) ) {
						mysql_query("UPDATE users SET  firstname='".$row_t["firstname"]."', surname='".$row_t["surname"]."', title='".$row_t["title"]."', email2='".$row_t["email"]."'   WHERE login='".$row_t["login"]."';");
						echo "UPDATE users SET  firstname='".$row_t["firstname"]."', surname='".$row_t["surname"]."', title='".$row_t["title"]."', email2='".$row_t["email"]."'   WHERE login='".$row_t["login"]."';<br>";
						mysql_query("UPDATE users_info SET address='".$row_t["address"]."', telephone='".$row_t["telephone"]."' , mobile_phone='".$row_t["mobile_phone"]."', office_address='".$row_t["office_address"]."'  WHERE id=".$row_t["maxlearn_user_id"].";");
						echo "UPDATE users_info SET address='".$row_t["address"]."', telephone='".$row_t["telephone"]."' , mobile_phone='".$row_t["mobile_phone"]."', office_address='".$row_t["office_address"]."'  WHERE id=".$row_t["maxlearn_user_id"]."; <br>";
				}
	}
	// #######   RESET PASSWORD  ########
	if($resetpasswd)
	{	$sql=mysql_query("SELECT login from users where login like '".$namelike."%';");
		while($row=mysql_fetch_array($sql)){
			echo $row["password"],"<br>";
			mysql_query("UPDATE users set password='".$row["login"]."',firstname='',surname='',homepage='',picture='',
			info='',telephone='',title='',address='',email2='',email='' where
			login='".$row["login"]."';");
		}
	}
   */
/*
   if($add_course){
   		require("../include/global.php");
      //  $sel_ct=mysql_query("SELECT ct.name, ct.active, ct.applyopen, ct.info, ct.users,ct.fullname,ct.fullname_eng,ct.section, ct.quota FROM courses_training  as ct ORDER BY ct.id");
	//	while($ct=mysql_fetch_array($sel_ct)){
			 // mysql_query("INSERT  INTO courses (name, active,applyopen,info,users,fullname,fullname_eng,section,quota) SELECT ct.name, ct.active, ct.applyopen, ct.info, ct.users,ct.fullname,ct.fullname_eng,ct.section, ct.quota FROM courses_training  as ct ORDER BY ct.id;");
			echo "INSERT  INTO courses (name, active,applyopen,info,users,fullname,fullname_eng,section,quota) SELECT ct.name, ct.active, ct.applyopen, ct.info, ct.users,ct.fullname,ct.fullname_eng,ct.section, ct.quota FROM courses_training  as ct ORDER BY ct.id;";
	//	  }
    }
*/
/*
	if($updateUT){
			// require("../../online_training/global_login.php");
			 $sel_ut=mysql_query("SELECT * FROM users_training ORDER BY id;");
			 while($selUT=mysql_fetch_array($sel_ut)){
			      mysql_query("UPDATE users SET  maxlearn_user_id='".$selUT["maxlearn_user_id"]."' WHERE  login='".$selUT["login"]."';");
				 echo "UPDATE users SET  maxlearn_user_id='".$selUT["maxlearn_user_id"]."'  WHERE  login='".$selUT["login"]."' ;<br>";
			 }
	}	

	if($add_WPT){
			 require("../../online_training/global_login.php");
			  mysql_query("INSERT INTO wp_training(courses,users,admin , active , temp , pay_ready,  training,  maxlearn_wp_id) SELECT c.maxlearn_courses_id , u.maxlearn_user_id,  c.users, wp.active,  wp.temp,  wp.pay_ready,  wp.training,  wp.maxlearn_wp_id  FROM wp, courses as c, users as u WHERE  wp.users=u.id AND wp.courses=c.id");
			 echo "INSERT INTO wp_training(courses,users,admin , active , temp , pay_ready,  training,  maxlearn_wp_id) SELECT c.maxlearn_courses_id , u.maxlearn_user_id,  c.users, wp.active,  wp.temp,  wp.pay_ready,  wp.training,  wp.maxlearn_wp_id  FROM wp, courses as c, users as u WHERE  wp.users=u.id AND wp.courses=c.id";
	}	
	if($add_wp){
			require("../include/global.php");
			  mysql_query("INSERT INTO wp(courses,users,admin , active , temp) SELECT  wpt.courses, wpt.users, wpt.admin , wpt.active , wpt.temp  FROM wp_training as wpt  ORDER BY wpt.id");
			  echo "INSERT INTO wp(courses,users,admin , active , temp) SELECT  wpt.courses, wpt.users, wpt.admin , wpt.active , wpt.temp  FROM wp_training as wpt  ORDER BY wpt.id";
	}
	if($add_maxlearn_wp_id){
			require("../include/global.php");
			//$sel_wpt=mysql_query("SELECT * FROM wp_training as wpt ORDER BY id");
			$sel_wp=mysql_query("SELECT wp.* FROM `wp` , wp_training as wpt WHERE wp.courses IN (502,503,504,505,506,507,508,509,510,511);");
			while($updateWPT=mysql_fetch_array($sel_wp)){
					echo"UPDATE  wp_training SET  maxlearn_wp_id=".$updateWPT["id"]." WHERE ;";
			}
	}
	 if($login_passwd){
			require("../include/global.php");
			$sql_u=mysql_query("SELECT * FROM users as u WHERE  id>3448 AND id<3519 ORDER BY id;");
			while($array_u=mysql_fetch_array($sql_u))
			{ 			$login=$array_u["login"];
						$id=$array_u["id"];
						//mysql_query("UPDATE  users SET password='".MD5($login)."' WHERE id='".$id."';");
						//echo "UPDATE  users SET password='".MD5($login)."' WHERE id='".$id."';<br>"; 
				 $num_rand=rand(65,90);     $char_rand=chr(rand(65,90));
				 echo "num=".$num_rand."; char=".$char_rand."<br>";
			}
	 }
	 if($add_courses){
			require("../include/global.php");
			mysql_query("INSERT INTO wp(courses , users, admin) VALUES(502,3457,1);");
			mysql_query("INSERT INTO wp(courses , users, admin) VALUES(503,3457,1);");
			mysql_query("INSERT INTO wp(courses , users, admin) VALUES(504,3457,1);");
			mysql_query("INSERT INTO wp(courses , users, admin) VALUES(505,3457,1);");
			mysql_query("INSERT INTO wp(courses , users, admin) VALUES(506,3457,1);");
			mysql_query("INSERT INTO wp(courses , users, admin) VALUES(507,3457,1);");
			mysql_query("INSERT INTO wp(courses , users, admin) VALUES(508,3457,1);");
			mysql_query("INSERT INTO wp(courses , users, admin) VALUES(509,3457,1);");
			mysql_query("INSERT INTO wp(courses , users, admin) VALUES(510,3457,1);");
			mysql_query("INSERT INTO wp(courses , users, admin) VALUES(511,3457,1)"); 
	 }
	 if($report_trainee_info){
			require("../include/global.php");	 
	 	// ทำใบแจก login-password
			$sql_report=mysql_query("SELECT * FROM users as u  WHERE  id>3448 AND id<3519 ORDER BY id;");
			while($user_report=mysql_fetch_array($sql_report))
			{     	
					echo "ชื่อ-สกุล :".$user_report["title"].$user_report["firstname"]."  ".$user_report["surname"]."<br>username=".$user_report["login"]."<br>password:".$user_report["login"]."<br>website: http://course.ku.ac.th<br>(เลือกช่องผู้เข้าอบรมจากภายนอก)<br><br>";
			}
	 }
*/
?>