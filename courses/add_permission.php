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
			if($action=="deny") {
				$sql = "DELETE FROM wp WHERE courses=$courses AND modules=$modules AND users=$admins AND admin=1 AND active=1;";
				//echo $sql;
				mysql_query($sql);
			}
			if($action=="allow") {
				$sql = "INSERT INTO wp (courses, modules, users, admin, active) VALUES ($courses, $modules, $admins, 1,1);";
				//echo $sql;
				mysql_query($sql);
			}
			

?>
<html>
<head>
<title>Add Permission</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<!--<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />!-->
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
</head>

<body>
<?
		$admin_sql=mysql_query("SELECT u.id,u.firstname,u.surname,u.login 
								 						FROM  users u,wp,courses c 
								 						WHERE c.id=".$courses." AND c.id=wp.courses AND wp.users=u.id AND (wp.admin=1) AND 
									   					u.active=1 AND wp.courses=".$courses." AND wp.modules=0 AND wp.folders=0 AND 
									   					wp.groups=0 AND wp.cases=0 and u.id = $admins
								 						ORDER BY c.users desc");
		$num=1;
		?>
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>			
    		<td align="center"><h1>Administrator Permission</h1>
      <table width="80%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><a href="add_admin_permission.php?courses=<? echo $courses;?>"><img src="../images/_edit-16.png" width="16" height="16" border="0"> 
            List Adminstrator</a></td>
        </tr>
      </table> 
      <br>
      <table width="80%" border="0" cellspacing="1" cellpadding="2" class="tdborder2">
        <tr class="boxcolor">
          <th class="bcolor">No.</th>
          <th class="Bcolor">Administrator Name</th>
        </tr>
		<?												
		while($co_admin=mysql_fetch_array($admin_sql))												
		{
		?>
        <tr bgcolor="#FFFFFF">
          <td align="center" class="hilite"><? echo $num;?></td>
          <td class="hilite"><? echo $co_admin["firstname"]."_".$co_admin["surname"]."_(".$co_admin["login"].")"."<br>"; ?></td>
        </tr>
		<?
		//$num++;
		}
		?>
      </table>
      <br>
      <table width="80%" border="0" cellspacing="1" cellpadding="2" class="tdborder2">
        <tr class="boxcolor"> 
          <th class="Bcolor">No.</th>
		  <th class="Bcolor">Module Type</th>
          <th class="Bcolor">Module Name</th>
          <th class="Bcolor">Status</th>
		  <th class="Bcolor">Action</th>
        </tr>
        <?														
		$modules=mysql_query("SELECT Distinct m.id,m.users,m.active,m.name,m.updated,m.updated_users,m.created , mt.id AS mt_type 
																FROM modules m,wp,modules_type mt 
																WHERE (wp.courses=$courses AND wp.modules=m.id AND m.modules_type=mt.id AND wp.folders=0 
																AND wp.cases=0 AND wp.groups=0 AND m.active=1 ) order by m.name;");
		$mod_num=1;
		
		echo mysql_num_rows($modules);
																
		while($row=mysql_fetch_array($modules))												
		{
		?>
        <tr bgcolor="#FFFFFF"> 
          <td align="center" class="hilite"><? echo $mod_num;?></td>
		  <td align="center" class="hilite">
		  <?
		  switch ($row["mt_type"]) {
				case 1:
					echo "Forum";
					break;
				case 2:
					echo "Peer Review";
					break;
				case 3:
					echo "Resources";
					break;
				case 4:
					echo "Webboard";
					break;
				case 5:
					echo "Quiz";
					break;
				case 6:
					echo "Web Mail";
					break;
				case 7:
					echo "E Homework";
					break;	
				}
			?>
		  </td>
          <td class="hilite"><? echo $row["name"]."<br>"; ?></td>
		  <?
		  $modules_can=mysql_query("SELECT Distinct m.id,m.users,m.active,m.name,m.updated,m.updated_users,m.created , mt.id AS mt_type 
																FROM modules m,wp,modules_type mt 
																WHERE (wp.courses=$courses AND wp.modules=m.id AND m.modules_type=mt.id AND wp.folders=0 
																AND wp.cases=0 AND wp.groups=0 AND m.active=1 AND wp.admin=1 AND wp.users=".$admins.") order by m.name;");
		$per =0;														
		 while($row_can=mysql_fetch_array($modules_can))	{
		 	
		 	if($row["id"] == $row_can["id"]) {
		  		$per = 1;
				}						
		}
		?>
		<? if ($per ==1 ) {?>
		  <td align="center" class="hilite"><img src="../images/correct_sign.gif"></td>		  
		  <td align="center" class="hilite"><a href="add_permission.php?courses=<? echo $courses;?>&modules=<? echo $row["id"];?>&admins=<? echo $admins;?>&action=<? echo "deny";?>">deny</a></td>
		  <? } else {?>
		  <td align="center" class="hilite"><img src="../images/stop_sign.gif"></td>		  
		  <td align="center" class="hilite"><a href="add_permission.php?courses=<? echo $courses;?>&modules=<? echo $row["id"];?>&admins=<? echo $admins;?>&action=<? echo "allow";?>">allow</a></td>
		  <? }?>
        </tr>
        <?
		$mod_num++;
		}
		?>
      </table> </td>
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
