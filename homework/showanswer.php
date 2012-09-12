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


		$showtext=mysql_query("SELECT * FROM homework WHERE id=".$id.";");
		
// if(($update!="true") || ($update) ) 
//{  ?>
	<html>
    <head>
    <title>Show Answer</title>
   
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
	<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />-->
    </head>
    <body topmargin="0" leftmargin="0">
	<br><center>
    <table border=0 cellpadding="2" cellspacing="0" width="90%" class="tdborder2"><!--<tr><td class="main" align="center"></td></tr>-->
    <tr class="boxcolor">
      <td align="center" class="bcolor">:: Answer ::</td>
    </tr>
    <tr>
        
      <td  class="hilite"> 
        <? 
		if(@mysql_result($showtext,0,"answer_type")== 1 )
		{   
			echo nl2br(@mysql_result($showtext,0,"answer")); 
		}
		if(@mysql_result($showtext,0,"answer_type")== 2 )
		{ 
	?>
        <a href="<? echo @mysql_result($showtext,0,"answer"); ?>" target="_blank"><b><? echo @mysql_result($showtext,0,"answer");  ?></b></a> 
        <?  
		}
	?>
      </td>
      </tr>	
    </table><br>
<input type="button" value="Close" onClick="window.close()" class="button"></center>

    </body>
    </html>