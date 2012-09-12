<? 
session_start();
$session_id = session_id();
require ("../include/global_login.php");
require("../include/online.php");
require_once ("./classes/User.php");
require_once ("./classes/UserStorage.php");
require_once( "./includes/main_functions.php" );
	
$user = UserStorage::lookupById($person["login"]);

session_register( 'user' ); 

//online_courses($session_id,$person["id"],$courses,time(),1);

switch ($user->getCategory()) {
    case 0:
        $uistyle = "admin";
        break;
    case 1:
        $uistyle = "admin";
        break;
    case 2:
        $uistyle = "teacher";
        break;
	case 3:
        $uistyle = "student";
		break;
	default:
        $uistyle = "guest";
	}

?>
<html>
<head>
        <title>Course On Web - Courses</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<meta http-equiv="Content-Type" content="text/html; charset=tis-620"></head>
<body bgcolor="#ffffff">
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
background="../images/headerbg.gif" height="53">
  <tr>
    <td class="menu" align="center"> <b>Transfer Data</b><br>
      Step 2</td>
  </tr>
</table>

<?php

$check=mysql_query("SELECT * FROM users WHERE category=1 and id=".$person["id"].";");
if(mysql_num_rows($check)==1){

//  SOAP Request
//echo $course_id;
//echo $_POST['year'];
//echo $_POST['semester'];

  if($_POST['semester'] || $_POST['year'])
	{
		require_once('../nusoap/nusoap.php');
		//$client = new soapclient('https://portal.ku.ac.th/cpestj/nusoap-kaset-oracle-server.php');
		$client = new soapclient('http://localhost/nusoap/nusoap-vec-server.php');

				
		$params = array('semester' => $_POST['semester'] ,
										  'year' => $_POST['year'] 
             						     ); 	
			
		if($_POST['semester'])
		{
			$response = $client->call('getStudents', $params);
		}
		
		if($client->fault)
		{
			print "ERROR! ".$client->faultstring."\n";
		}
		else
		{
			if($response)
			{
				print "<br><table border='0' class='std' cellpadding=\"2\" cellspacing=\"1\" width=\"60%\" align=\"center\">\n";
				print "<tr>
								<th>STD _TITLE</th><th>STD NAME</th><th>STD SURNAME</th>
							</tr>\n";
				$i=0;			
				foreach($response[0] as $res_row)							
				{	
					/*				
					$sql = "INSERT INTO ku_courses (CS_CODE, COURSE_NAME,COURSE_YR, B_CRE_LEC, B_CRE_LAB) 
									VALUES ('".$res_row['cs_code']."', '".$res_row['course_name']."', ".$res_row['sm_yr'].", ".$res_row['b_cre_lec'].", ".$res_row['b_cre_lab'].");"; 
					*/
					$new_password=md5($res_row['std_id']);
					
					$check_ex=mysql_query("SELECT id FROM users WHERE login like '".$res_row['std_id']."';");
					
					if(mysql_num_rows($check_ex)==0){
					
						$sql = "INSERT INTO users (active,login,title,firstname,surname,password,category) 
							VALUES (1,'".$res_row['std_id']."','".$res_row['std_title']."','".$res_row['std_name']."','".$res_row['std_surname']."',
							'$new_password',3);";				
							
						//echo $sql;
						
						mysql_query($sql);
						$got_id=mysql_insert_id();
						mysql_query("INSERT INTO users_info (id) values ($got_id);");
					
					} 
					
					print "<tr>\n
									<td class=\"hilite\">".$res_row['std_title']."</td>\n
									<td class=\"hilite\">".$res_row['std_name']."</td>\n
									<td class=\"hilite\">".$res_row['std_surname']."</td>\n									
								</tr>\n	
							 ";						 
					$i++;		 
				}
				print "</table>\n<br>";
				//echo $i;
				
				//echo '<xmp>' . $client->request . '</xmp>';
				//echo '<xmp>' . $client->response . '</xmp>';
			}
			else
			{
				print "NO MATCHES found !\n";
			}
		}
	}
	// End SOAP	
}	
		
?>
		
		
  <form action="../courses/create_form_3.php" method="post" name="course">
  <input name="year" type="hidden" value="<? echo $year;?>">
	<input name="semester" type="hidden" value="<? echo $semester;?>">
  <table width="90%" border="0" align="center" cellpadding="2" cellspacing="1" class="std">
    <tr> 
      <td colspan="2"  align="center">&nbsp;</td>
    </tr>
	<!--
    <tr> 
      <td width="28%"  align="right" class="hilite">Trasnfered by/ ผู้โอนข้อมูล 
        :</td>
      <td width="72%" align="left"  class="hilite"><b><?php echo $person["title"].$person["firstname"]." ".$person["surname"]; ?></b> 
      </td>
    </tr>
	-->
    <tr> 
      <td><input name="Button" type="button" value="&lt;&lt; Back" onClick="history.back()" class="button"></td>
      <!--<td align="right"> <input type="submit" value="Next &gt;&gt;" class="button"> 
      </td>-->
    </tr>
  </table>

  </form>        

</body>
</html>