<?	
		session_start();
		require("../include/global_login.php"); 
		require_once ("./classes/User.php");
		require_once ("./classes/UserStorage.php");
		require_once( "./includes/main_functions.php" );
			
		$user = UserStorage::lookupById($person["login"]);
		
		session_register( 'user' ); 
		
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
<title>Add Permission</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
</head>

<body>
<?
		$admins=mysql_query("SELECT u.id,u.firstname,u.surname,u.login 
								 						FROM  users u,wp,courses c 
								 						WHERE c.id=".$courses." AND c.id=wp.courses AND wp.users=u.id AND (wp.admin=1) AND 
									   					u.active=1 AND wp.courses=".$courses." AND wp.modules=0 AND wp.folders=0 AND 
									   					wp.groups=0 AND wp.cases=0 
								 						ORDER BY c.users desc");
		$num=1;
		?>
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>			
    		<td align="center"><h1>List Administrator</h1><br>
      <table width="80%" border="0" cellspacing="1" cellpadding="2" class="tdborder2">
        <tr class="boxcolor">
          <th class="Bcolor">No.</th>
          <th class="Bcolor">Administrator Name</th>
          <th class="Bcolor">Action</th>
        </tr>
		<?												
		while($co_admin=mysql_fetch_array($admins))												
		{
		?>
        <tr bgcolor="#FFFFFF">
          <td align="center" class="hilite"><? echo $num;?></td>
          <td class="hilite"><? echo $co_admin["firstname"]."_".$co_admin["surname"]."_(".$co_admin["login"].")"."<br>"; ?></td>
          <td align="center" class="hilite"><a href="add_permission.php?courses=<? echo $courses;?>&admins=<? echo $co_admin["id"];?>">Edit Permission</a></td>
        </tr>
		<?
		$num++;
		}
		?>
      </table>
      </td>
		  </tr>
		</table>

		<?
			//echo $co_admin["firstname"]."_".$co_admin["surname"]."_(".$co_admin["login"].")"."<br>"; 
			/*	
			 $modules=mysql_query("SELECT Distinct m.id,m.users,m.active,m.name,m.updated,m.updated_users,m.created , mt.id AS mt_type 
																FROM modules m,wp,modules_type mt 
																WHERE (wp.courses=$courses AND wp.modules=m.id AND m.modules_type=mt.id AND wp.folders=0 
																AND wp.cases=0 AND wp.groups=0 AND m.active=1 AND wp.admin=1 AND wp.users=".$co_admin["id"].") order by m.name;");
			while($row=mysql_fetch_array($modules)){
				switch ($row["mt_type"]) {
				case 1:
					echo "Type : Forum - ";
					break;
				case 2:
					echo "Type : Peer Review - ";
					break;
				case 3:
					echo "Type : Resources - ";
					break;
				case 4:
					echo "Type : Webboard - ";
					break;
				case 5:
					echo "Type : Quiz - ";
					break;
				case 6:
					echo "Type : Web Mail - ";
					break;
				case 7:
					echo "Type : E Homework - ";
					break;	
				}
				echo "Module : ".$row["name"]."<br>";	
			}
			echo "<br><br>";
			*/																
?>									 
</body>
</html>
