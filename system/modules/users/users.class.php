<?php 
/**
 *	@package system
 *	@subpackage modules
*/

/**
 *	Users Class
 */
require_once("DB.php");
 
class Users {
	// int users id
	var $users_id = NULL;		
	// int users active
	var $users_active = NULL;
	// varchar users login
  	var $users_login = NULL;
	// varchar users password
	var $users_password = NULL;
	// varchar users firstname
	var $users_firstname = NULL;
	// varchar users surname
	var $users_surname = NULL;
	// varchar users email
	var $users_email = NULL;
	// varchar users homepage
	var $users_homepage = NULL;
	// int users category
	var $users_category = NULL;
	// varchar users title
	var $users_title = NULL;
	// varchar users email2
	var $users_email2 = NULL;
	// varchar users id number
	var $users_id_number = NULL;
	// int users admin
	var $users_admin = NULL;		
		
	
	function Users($id, $active, $login, $password, $firstname, $surname, $email, $homepage,
				   $category, $title, $email2, $id_number, $admin
				  ) 
	{
		$this->users_id 	   = $id;
		$this->users_active    = $active;
		$this->users_login     = $login;
		$this->users_password  = $password;
		$this->users_firstname = $firstname;
		$this->users_surname   = $surname;
		$this->users_email 	   = $email;
		$this->users_homepage  = $homepage;
		$this->users_category  = $category;
		$this->users_title     = $title;
		$this->users_email2    = $email2;
		$this->users_id_number = $id_number;
		$this->users_admin 	   = $admin;
	}
	
	function getUsersId() {
		return $this->users_id;
	}
	
	function getUsersActive() {
		return $this->users_active;
	}
	
	function getUsersLogin() {
		return $this->users_login;
	}
	
	function getUsersPassword() {
		return $this->users_password;
	}
	
	function getUsersFirstName() {
		return $this->users_firstname;
	}
	
	function getUsersSurName() {
		return $this->users_surname;
	}
	
	function getUsersEmail() {
		return $this->users_email;
	}
	
	function getUsersHomepage() {
		return $this->users_homepage;
	}
	
	function getUsersCategory() {
		return $this->users_category;
	}
	
	function getUsersTitle() {
		return $this->users_title;
	}
	
	function getUsersEmail2() {
		return $this->users_email2;
	}

	function getUsersIdNumber() {
		return $this->users_id_number;
	}
	
	function getUsersAdmin() {
		return $this->users_admin;
	}		
	
	function create($users) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$active = $users->getUsersActive();
		if ($active == '') { $active = 0;}
		$category = $users->getUsersCategory();
		if ($category == '') { $category = 0;}
		$id_number = $users->getUsersIdNumber();
		if ($id_number == '') { $id_number = 0;}
		$admin = $users->getUsersAdmin();
		if ($admin == '') { $admin = 0;}		
						 		
					  
	   $sql = "INSERT INTO users
			   (active, login, password, 
			    firstname, surname, email, 
				homepage, category, title, email2, 
				id_number, admin
			   )
			   VALUES
			   (".$active.", '".$users->getUsersLogin()."','".md5($users->getUsersPassword())."', 
			   '".$users->getUsersFirstName()."', '".$users->getUsersSurname()."', '".$users->getUsersEmail()."', 
			   '".$users->getUsersHomepage()."','".$users->getUsersCategory()."','".$users->getUsersTitle()."','".$users->getUsersEmail2()."',
			    ".$id_number.",".$admin."
			   );";
			   				
		//echo $sql."<br>";				
	
			
		$result = $db->query($sql);	   
		
		$id = mysql_insert_id();
		$sql_info = "INSERT INTO users_info (id) VALUES (".$id.");";
		$result_info = $db->query($sql_info);	   
		
		if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
		}
		return true;	   					
		//} else {
		//	echo "user ซ้ำ";			
		//	return false;
		//}
		//return true;										   	   	   
	}
	
	function SelectAllUsers($active, $order, $page) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$maxRow = $page*10;
		$minRow = $maxRow - 9;
		
		$numRow = " LIMIT ".$minRow.", ".$maxRow;
		
		if ($order == "") {
			$sql = "SELECT * FROM users WHERE active=".$active." ORDER BY login";
			//$sql = "SELECT * FROM users WHERE active=".$active." ORDER BY login ".$numRow.";";
		} else {
			$sql = "SELECT * FROM users WHERE active=".$active." ORDER BY ".$order."";
			//$sql = "SELECT * FROM users WHERE active=".$active." ORDER BY ".$order." ".$numRow.";";
		}
		//echo $sql;
//***	$result = $db->query($sql);
		
//****		return $result;
		return $sql;
	
	}
	
/*	function SelectUsersPerPage($active, $order, $page) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
				
		$maxRow = $page*10;
		if($page == 1){
			$minRow = $maxRow - 10;
		}else{
			$minRow = $maxRow - 9;
		}
		
		$numRow = " LIMIT ".$minRow.", "."10";
		

		$where .= " AND (id >= $minRow ";
		$where .= " AND id <= $maxRow) ";
		
		
		
		if ($order == "") {
			//$sql = "SELECT * FROM users WHERE active=".$active." ORDER BY login;"; --1
//			$sql = "SELECT * FROM users WHERE active=".$active.$where." ORDER BY $order;";
			$sql = "SELECT * FROM users WHERE active=".$active." ORDER BY $order;";
			//$sql = "SELECT * FROM users WHERE active=".$active." ORDER BY $order".$numRow.";";
		} else {
			//$sql = "SELECT * FROM users WHERE active=".$active." ORDER BY ".$order.";"; --1
//			$sql = "SELECT * FROM users WHERE active=".$active.$where." ORDER BY $order;";
			$sql = "SELECT * FROM users WHERE active=".$active." ORDER BY $order;";
			//$sql = "SELECT * FROM users WHERE active=".$active." ORDER BY $order".$numRow.";";
		}
		//echo $sql;
		$result = $db->query($sql);
	
		return $result;
	
	}	*/

	function SelectUsersPerPage($sql,$page) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		$pagesize=50;
		$maxRow = $page*$pagesize;
		if (isset($page)){
						$start = $pagesize * ($page -1);
			}else{
						$page =1;
						$start=0;
			}		
		$numRow = " LIMIT ".$start.", ".$pagesize;
		$sql=$sql.$numRow;
		//echo $sql;
		$result = $db->query($sql);
		return $result;
	
	}	
	
	function ShowTableAll($result,$user,$uistyle,$tab,$page,$stub) {
		//echo $result->numRows();				
		echo "<table cellpadding=\"2\" cellspacing=\"1\" border=\"0\" width=\"100%\" class=\"tdbackground\" >";
		echo "<tr class=\"boxcolor\">";
		echo "<td width=\"60\" align=\"right\" bgcolor=\"#FFFFFF\">";
		echo "&nbsp; sort by:&nbsp;";
		echo "</td>";
		echo "<th width=\"150\">";
		echo "<a class=\"a13\" href=\"?m=users&a=list&orderby=login&tab=$tab&page=$page&stub=$stub\" >UserName</a>";
		echo "</th>";
		echo "<th>";
		echo "<a class=\"a13\" href=\"?m=users&a=list&orderby=firstname&tab=$tab&page=$page&stub=$stub\" class=\"hdr\">Name-Surname</a>";
		echo "</th>";
		echo "<th>";
		echo "<a class=\"a13\" href=\"?m=users&a=list&orderby=lastlogin&tab=$tab&page=$page&stub=$stub\" class=\"hdr\">Last Login</a>";
		echo "</th>";
		echo "</tr>";
		while ($rs = @$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$users_id = $rs["id"];
			$users_login = $rs["login"];
			$users_firstname = $rs["firstname"];
			$users_surname = $rs["surname"];
			$users_email = $rs["email"];
			$users_lastlogin = $rs["lastlogin"];
			$users_admin = $rs["admin"];
			echo "<tr bgcolor=\"#FFFFFF\">";
			echo "<td align=\"right\" nowrap=\"nowrap\">";
			echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			echo "<tr>";
			echo "<td>";
			
			//echo "<a href=\"./index.php?m=users&a=addedit&users_id=".$users_id."\" title=\"edit\">";
			//echo "<div style=\"height:16px; width:16px; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='./images/icon/_edit-16.png', sizingMethod='scale');\" ></div>";
			//echo "</a>";
			echo "</td>";
			echo "<td>";
			//echo "<a href=\"javascript:delMe(".$users_id.", '".$users_firstname." ".$users_surname."')\" title=\"delete\">";
			//echo "<div style=\"height:16px; width:16px; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='./images/icon/_delete-16.png', sizingMethod='scale');\" ></div>";
			//echo "</a>";
			echo "</td>";
			echo "</tr>";
			echo "</table>";
			echo "</td>";
			echo "<td>";
			if($users_admin == 1){
				echo "<img src=\"./images/obj/person_adm.gif\" border=\"0\">";
			} else {
				echo "<img src=\"./images/obj/person_user.gif\" border=\"0\">";
			}
			echo "<a href=\"./index.php?m=users&a=view&users_id=".$users_id."\">".$users_login."</a>";
			echo "</td>";
			echo "<td class=\"hilite\">";
			echo "<a href=\"mailto:".$users_email."\"><img src=\"./images/obj/email.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"email\"></a>";
			echo " ".$users_firstname." ".$users_surname;
			echo "</td>";
			echo "<td class=\"hilite\">";
			if($users_lastlogin==0)
				{
					echo "Never logged in";
				}else{
					echo date("d-m-Y H:i",$users_lastlogin);
				}            
			echo "</td>";    
			echo "</tr>";
		}
		echo "</table>";									
	}
	
	function ShowSeqTable($sql,$order,$page,$stub,$tab){
	/*	$NRow = $result->numRows();																	 
		$rt = $NRow%10;
		if($rt!=0) {
			$totalpage = floor($NRow/10)+1;
		}
		else {
			$totalpage = floor($NRow/10);
		}
		$goto = ($page-1)*10;
		if ($page != 1) {
		$s = $page*5;
		} else {
		$s=0;
		}*/
			global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		$result = $db->query($sql);
		$num = $result->numRows();	
		$pagesize=50;
		$totalpage =(int)($num/$pagesize);
		$page_amnt_per_page_range = 10;   //กำหนดจำนวนหมายเลขหน้าที่จะแสดงต่อหน้า
		if (empty($start)) { //ลองตรวจดูว่าค่าแถวเริ่มต้นที่จะแสดงไม่ได้กำหนดหรือเปล่า ถ้าไม่ได้กำหนด จะกำหนดให้เป็น 0 
		  $start = 0; 
		} 

		if (($num % $pagesize) != 0)
				{
						$totalpage += 1;
				}

			if (isset($page)){
						$start = $pagesize * ($page -1);
			}else{
						$page =1;
						$start=0;
			}	
		 if($num !=0){
		  // table แสดงเลขหน้า
		echo "<table width=100% border=0 bordercolor=black cellspacing=0 cellpadding=2 >\n";
		echo "<tr><td align=left>\n";
		echo "\t<font size=2 >\n";

		// สร้าง link เพื่อไปหน้าก่อน-หน้าถัดไป
		if($page>1 && $page<=$totalpage) {
				$prevpage = $page-1;
				echo "\t<a href='./index.php?m=users&a=list&page=$prevpage&orderby=$order&stub=$stub&tab=$tab' ><img src=\"../images/back.gif\" border=\"0\" align=\"top\"></a>\n";
		}

		echo "\t [$page/$totalpage] \n";

		if($page!=$totalpage) {
				$nextpage = $page+1;
				echo "\t<a href='./index.php?m=users&a=list&page=$nextpage&orderby=$order&stub=$stub&tab=$tab'><img src=\"../images/next_.gif\" border=\"0\" align=\"top\"></a>\n";
		}

		echo "\t</font>\n";
		echo "</td></tr>\n";
		echo "<tr><td>\n";

/*
		// วนลูปแสดงเลขหน้าทั้งหมด
		for($i=1 ; $i<$page ; $i++) {
				echo "\t<a href='./index.php?m=users&a=list&page=$i&orderby=$order&stub=$stub&tab=$tab'>$i</a> \n";
		}
		echo "\t<font size=2 color=red><b>$page</b></font> \n";
		for($i=$page+1 ; $i<=$totalpage ; $i++) {
				echo "\t<a href='./index.php?m=users&a=list&page=$i&orderby=$order&stub=$stub&tab=$tab' class=a11>$i</a> \n";
		}
 */
 if ($totalpage>1) { //ตรวจดูว่าถ้าจำนวนหน้าทั้งหมดมีเกิน 1 หน้า ต้องแสดงบรรทัดที่จะให้เลือกหน้า 
  $begin_page_range = (intval(($page - 1)/$page_amnt_per_page_range) * $page_amnt_per_page_range) +1;
  $previous_page_range = $begin_page_range - 2; //หาว่าช่วงหน้าก่อนหน้าปัจจุบันคือหน้าอะไร 
  $next_page_range = $begin_page_range + $page_amnt_per_page_range - 1; //หาว่าช่วงหน้าถัดจากหน้าปัจจุบันคืออะไร 
  if ($previous_page_range >0) { //ถ้าช่วงหน้าก่อนหน้าติดลบหรือเป็นศูนย์แสดงว่าไม่สามารถแสดงช่วงหน้าก่อนหน้าได้ 
    $new_startrow = ($begin_page_range - 2) * $pagesize; 
	$prev_page=$begin_page_range-$page_amnt_per_page_range;
  //  $left_page_show = "<A HREF=$PHP_SELF?start=$new_startrow>&lt;&lt;</A> " ; 
	$left_page_show ="<a href='./index.php?m=users&a=list&page=$prev_page&orderby=$order&stub=$stub&tab=$tab'> &lt;&lt;</a>";
  } else { 
    $left_page_show = "  "; 
  } 
  if ($next_page_range >= $totalpage) { //ถ้าช่วงหน้าถัดไป มากกว่าจำนวนหน้าทั้งหมด แสดงว่าไม่สามารถแสดงหน้าถัดไปได้ 
    $right_page_show = " "; 
  } else { 
	$new_startrow = ($begin_page_range + $page_amnt_per_page_range - 1)*$pagesize; 
	$next_page=$begin_page_range+$page_amnt_per_page_range;
  //  $right_page_show = " <A HREF=$PHP_SELF?start=$new_startrow>&gt;&gt;</A>"; 
 $right_page_show ="<a href='./index.php?m=users&a=list&page=$next_page&orderby=$order&stub=$stub&tab=$tab' > &gt;&gt;</a>";
  } 
  $middle_page_show = ""; 
  
  for ($i=$begin_page_range;($i<=$totalpage) AND ($i<$begin_page_range+$page_amnt_per_page_range);$i++) { //วนลูปแสดงหน้าทั้งหมด 
    if ($i == $page) { //ถ้าหน้าที่พิมพ์เป็นหน้าเดียวกับหน้าปัจจุบัน แสดงให้ไม่สามารถคลิ๊กได้ 
      $middle_page_show .= " <font size=2 color=red><b>$i</b></font> "; 
    } else { 
      $new_startrow = (($i-1)*$pagesize); 
     // $middle_page_show .= " <A HREF=$PHP_SELF?start=$new_startrow>$i</A> "; 
	 $middle_page_show .=" <a href='./index.php?m=users&a=list&page=$i&orderby=$order&stub=$stub&tab=$tab'>$i</a>";
    } 
  } 
  $page_show = $left_page_show . $middle_page_show . $right_page_show; 
} else { 
  $page_show = ""; 
} 
		echo $page_show; 
		echo "</td></tr>\n";
		echo "</table>\n";
		 }



	}
	
	
	function lookupUsers($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM users WHERE id = ".$id.";";
		
		$result = $db->query($sql);

		$rs_users = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$users = Users::createUsersObject($rs_users);

		return $users;
	
	}		
	
	function lookupUsersName($name) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM users WHERE login = '".$name."';";
		
		$result = $db->query($sql);
		
		//echo $sql;
		//$rs_users = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		//$users = Users::createUsersObject($rs_users);

		//return $users;
		
		if($result->numRows()==0){
			return true;
		} else {
			return false;
		}
	
	}
	
	function createUsersObject($row) {			
		$users_id 		 = $row["id"];
		$users_active 	 = $row["active"];
		$users_login 	 = $row["login"];
		$users_password  = $row["password"];
		$users_firstname = $row["firstname"];
		$users_surname   = $row["surname"];
		$users_email   	 = $row["email"];
		$users_homepage  = $row["homepage"];
		$users_category  = $row["category"];
		$users_title   	 = $row["title"];
		$users_email2    = $row["email2"];
		/*
		$users_fac_id  	 = $row["fac_id"];
		$users_dept_id 	 = $row["dept_id"];
		$users_major_id  = $row["major_id"];
		*/
		$users_id_number = $row["id_number"];
		$users_admin 	 = $row["admin"];
				
		$users = new Users($users_id, $users_active, $users_login, $users_password, 
						   $users_firstname, $users_surname, $users_email, $users_homepage, 
						   $users_category, $users_title, $users_email2, 
						   $users_id_number, $users_admin
						  );
		return $users;
	}
	
	function update($users) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$u = $users->lookupUsers($users->getUsersId());
		if(strcmp($u->getUsersPassword(), $users->getUsersPassword()) == 0)
		{
			$passwd = $users->getUsersPassword();
		} else {
			$passwd = md5($users->getUsersPassword());
		}
		
		$active = $users->getUsersActive();
		if ($active == '') { $active = 0;}
		$category = $users->getUsersCategory();
		if ($category == '') { $category = 0;}				
		$id_number = $users->getUsersIdNumber();
		if ($id_number == '') { $id_number = 0;}
		$admin = $users->getUsersAdmin();
		if ($admin == '') { $admin = 0;}
		
		$sql = "UPDATE users SET 
			   active    = ".$active.", 	
			   login     = '".$users->getUsersLogin()."', 
			   password  = '".$passwd."',
			   firstname = '".$users->getUsersFirstName()."', 
			   surname   = '".$users->getUsersSurname()."', 
			   email     = '".$users->getUsersEmail()."', 
			   homepage  = '".$users->getUsersHomepage()."', 
			   category  = ".$category.", 
			   title     = '".$users->getUsersTitle()."', 
			   email2    = '".$users->getUsersEmail2()."', 
			   id_number = ".$id_number.", 
			   admin     = ".$admin."	
			   WHERE id  = ".$users->getUsersId().";";
			   
				
	   $result = $db->query($sql);
	   
	  if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }
	   return true;
			
	}
		
	function del($users) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "DELETE FROM users WHERE id = ".$users->getUsersId().";";
		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	
	function checkPassword($id, $password) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM users WHERE id = ".$id.";";
		
		$result = $db->query($sql);
		
		$rs_users = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$users = Users::createUsersObject($rs_users);
			
		if (strcmp($users->getUsersPassword(), md5($password)) == 0) {			
			return true;
		} else {		
			return false;
		}
	}
	
	function SearchUsers($strSearch,$page) 
	{
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		if ($strSearch != '') {
			if (strlen($strSearch) > 1) 
			{
				$where = "WHERE id <> 0 ";
				//if ($strSearch != '') $where .= " AND (login LIKE '%".$strSearch."%'";
				if ($strSearch != '')    $where .= " AND firstname LIKE '%".$strSearch."%'";
				//if ($strSearch != '')    $where .= " AND firstname LIKE '%".$strSearch."%'";
				//if ($strSearch != '')   $where .= " OR surname LIKE '%".$strSearch."%')";			
			} else {
				$where = "WHERE id <> 0 ";
				//if ($strSearch != '') $where .= " AND (login LIKE '%".$strSearch."%'";
				if ($strSearch != '')    $where .= " AND SUBSTRING(firstname, 1, 1) LIKE '%".$strSearch."%'";
				//if ($strSearch != '')    $where .= " AND firstname LIKE '%".$strSearch."%'";
				//if ($strSearch != '')   $where .= " OR surname LIKE '%".$strSearch."%')";			
			}
		}
		
		$maxRow = $page*20;
		$minRow = $maxRow - 19;
		
		$numRow = " LIMIT ".$minRow.", ".$maxRow;
		
		$sql = "SELECT * FROM users ".$where." ORDER BY login ";
		
		//$sql = "SELECT * FROM users ".$where." ORDER BY login ".$numRow.";";
		
		//echo $sql;		
	//**	$result = $db->query($sql);	
	//**	return $result;		
		return $sql;
	}
	
	function SearchUsersPerPage($strSearch,$page) 
	{
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$maxRow = $page*20;
		if($page == 1){
			$minRow = $maxRow - 20;
		}else{
			$minRow = $maxRow - 19;
		}
		
		$numRow = " LIMIT ".$minRow.", ".$maxRow;
		
		if ($strSearch != '') 
		{
			$where = "WHERE id <> 0 ";
			//if ($strSearch != '') $where .= " AND (login LIKE '%".$strSearch."%'";
			if ($strSearch != '')    $where .= " AND SUBSTRING(firstname, 1, 1) LIKE '%".$strSearch."%'";
			//if ($strSearch != '')    $where .= " AND firstname LIKE '%".$strSearch."%'";
			//if ($strSearch != '')   $where .= " OR surname LIKE '%".$strSearch."%')";			
		} else {
			$where = "WHERE id <> 0 ";
			$where .= " AND (id >= $minRow ";
			$where .= " AND id <= $maxRow) ";
		}
										
		//$sql = "SELECT * FROM users ".$where." ORDER BY login ;";
		
		$sql = "SELECT * FROM users ".$where." ORDER BY id ;";
		
		//echo $sql;		
		$result = $db->query($sql);	
		return $result;		
	}

//Import Users
function import($Login,$Pass,$FName,$Cat){
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
	$password=md5($Pass);					//Insert users
	$sql="INSERT INTO users (login,password,firstname,category,active) 
	VALUES ('".$Login."','".$password."','".$FName."','".$Cat."',1) ";
	$result = $db->query($sql);	   
		
	$id = mysql_insert_id();
	$sql_info = "INSERT INTO users_info (id) VALUES (".$id.");";
	$result_info = $db->query($sql_info);	   
		
	if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	}
		return true;	
}
	
	/*
	function db_loadList( $sql, $maxrows=NULL ) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		if (!($result = $db->query($sql))) {
			return false;
		}
		$list = array();
		$cnt = 0;
								
		while ($hash = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$list[] = $hash;
			if( $maxrows && $maxrows == $cnt++ ) {
				break;
			}
		}
		//db_free_result( $cur );
		$result->free();
		return $list;
	}
	*/
	
	/*
	
	function log_insert($id, $users) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "INSERT INTO dms_log
			   (log_users, log_doc_id, log_doc_type, log_action, log_time)
			   VALUES
			   (".$users.", ".$id.",'research', 'insert', ".time().");";
		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	
	function log_del($id,$owner) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "INSERT INTO dms_log
	   		   (log_users, log_doc_id, log_doc_type, log_action, log_time)
	   		   VALUES
	   		   (".$owner.", ".$id.",'research', 'del', ".time().");";

		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	
	function log_update($research) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "INSERT INTO dms_log
	   		   (log_users, log_doc_id, log_doc_type, log_action, log_time)
	   		   VALUES
	   		   (".$research->getResearchOwner().", ".$research->getResearchId().",'research', 'update', ".time().");";

		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	*/	
}

/**
* Permissions class
*/
class Permission {
	//int system admin id
	var $sys_admin_id = NULL; 
	//int system admin user id
  	var $sys_admin_users = NULL;
	//int system permission course
  	var $sys_padmin_courses = NULL;
	//int system permission dms
  	var $sys_padmin_dms = NULL;
	//int system permission system
  	var $sys_padmin_system = NULL;
	//int system permission master data
  	var $sys_padmin_mdata = NULL;
	//int system permission users
  	var $sys_padmin_users = NULL;
	//int system permission report
  	var $sys_padmin_report = NULL;
	//int system permission super user
  	var $sys_padmin_super = NULL;	
	
	function Permission($admin_id, $users_id, $courses, $dms, $system, $mdata, $users, $report, $super) { 
		$this->sys_admin_id = $admin_id;
		$this->sys_admin_users = $users_id;
		$this->sys_padmin_courses = $courses;
		$this->sys_padmin_dms = $dms;
		$this->sys_padmin_system = $system;
		$this->sys_padmin_mdata = $mdata;
		$this->sys_padmin_users = $users;
		$this->sys_padmin_report = $report;
		$this->sys_padmin_super = $super;
	}
	
	function getSysAdminId() {
		return $this->sys_admin_id;
	}
	
	function getSysAdminUsers() {
		return $this->sys_admin_users;
	}
	
	function getSysPAdminCourses() {
		return $this->sys_padmin_courses;
	}
	
	function getSysPAdminDms() {
		return $this->sys_padmin_dms;
	}
	
	function getSysPAdminSystem() {
		return $this->sys_padmin_system;
	}
	
	function getSysPAdminMData() {
		return $this->sys_padmin_mdata;
	}
	
	function getSysPAdminUsers() {
		return $this->sys_padmin_users;
	}
	
	function getSysPAdminReport() {
	return $this->sys_padmin_report;
	}

	function getSysPAdminSuper() {
		return $this->sys_padmin_super;
	}
	
	function checkAdmin($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM users WHERE id = ".$id.";";
		
		$result = $db->query($sql);
		
		$rs_users = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		//$users = Users::createUsersObject($rs_users);
			
		if ($rs_users["admin"] == 1) {			
			return true;
		} else {		
			return false;
		}
	}
	
	function SelectAdminPerm($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
				
		$sql = "SELECT * FROM sys_admin_per WHERE sys_admin_users=".$id.";";

		//echo $sql;
		$result = $db->query($sql);
	
		return $result;	
	}
	
	function ShowTableAdminPerm($result,$tab) {
		//echo $result->numRows();								
		while ($rs = @$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$sys_admin_id = $rs["sys_admin_id"];
			$sys_admin_users = $rs["sys_admin_users"];
			$sys_padmin_courses = $rs["sys_padmin_courses"];
			$sys_padmin_dms = $rs["sys_padmin_dms"];
			$sys_padmin_system = $rs["sys_padmin_system"];
			$sys_padmin_mdata = $rs["sys_padmin_mdata"];
			$sys_padmin_users = $rs["sys_padmin_users"];
			$sys_padmin_report = $rs["sys_padmin_report"];
			$sys_padmin_super = $rs["sys_padmin_super"];
			
			if($sys_padmin_super==1){
				echo "<tr bgcolor=\"#FFFFFF\">";
				echo "<td width=\"10\">";
				echo "<a href=# onClick=\"editPerm($sys_admin_id,1,$sys_padmin_super)\">";						
				echo "<img src=\"./images/icon/_edit-16.png\" border=\"0\" alt=\"edit\">";
				echo "</a>";
				echo "</td>";
				echo "<td style=\"background-color:#ffc235\">";
				echo "Super Administrator";
				echo "</td>";
				echo "<td>";
				echo "active";
				echo "</td>";
				echo "<td width=\"10\">";
				echo "<a href=# onClick=\"delPerm($sys_admin_id,1)\">";
				echo "<img src=\"./images/icon/_cancel-16.png\" border=\"0\" alt=\"delete\">";
				echo "</a>";
				echo "</td>";
				echo "</tr>";
			}
			
			if($sys_padmin_courses==1){			
				echo "<tr bgcolor=\"#FFFFFF\">";
				echo "<td width=\"10\">";
				echo "<a href=# onClick=\"editPerm($sys_admin_id,2,$sys_padmin_courses)\">";						
				echo "<img src=\"./images/icon/_edit-16.png\" border=\"0\" alt=\"edit\">";
				echo "</a>";
				echo "</td>";
				echo "<td style=\"background-color:#ffff99\">";
				echo "Course Administrator";
				echo "</td>";
				echo "<td>";
				echo "active";
				echo "</td>";
				echo "<td width=\"10\">";
				echo "<a href=# onClick=\"delPerm($sys_admin_id,2)\">";
				echo "<img src=\"./images/icon/_cancel-16.png\" border=\"0\" alt=\"delete\">";
				echo "</a>";
				echo "</td>";
				echo "</tr>";
			}
			
			if($sys_padmin_dms==1){
				echo "<tr bgcolor=\"#FFFFFF\">";
				echo "<td width=\"10\">";
				echo "<a href=# onClick=\"editPerm($sys_admin_id,3,$sys_padmin_dms)\">";						
				echo "<img src=\"./images/icon/_edit-16.png\" border=\"0\" alt=\"edit\">";
				echo "</a>";
				echo "</td>";
				echo "<td style=\"background-color:#ffff99\">";
				echo "DMS Administrator";
				echo "</td>";
				echo "<td>";
				echo "active";
				echo "</td>";
				echo "<td width=\"10\">";
				echo "<a href=# onClick=\"delPerm($sys_admin_id,3)\">";
				echo "<img src=\"./images/icon/_cancel-16.png\" border=\"0\" alt=\"delete\">";
				echo "</a>";
				echo "</td>";
				echo "</tr>";
			}
			
			if($sys_padmin_mdata==1){
				echo "<tr bgcolor=\"#FFFFFF\">";
				echo "<td width=\"10\">";
				echo "<a href=# onClick=\"editPerm($sys_admin_id,4,$sys_padmin_mdata)\">";						
				echo "<img src=\"./images/icon/_edit-16.png\" border=\"0\" alt=\"edit\">";
				echo "</a>";
				echo "</td>";
				echo "<td style=\"background-color:#ffff99\">";
				echo "Master Data Administrator";
				echo "</td>";
				echo "<td>";
				echo "active";
				echo "</td>";
				echo "<td width=\"10\">";
				echo "<a href=# onClick=\"delPerm($sys_admin_id,4)\">";
				echo "<img src=\"./images/icon/_cancel-16.png\" border=\"0\" alt=\"delete\">";
				echo "</a>";
				echo "</td>";
				echo "</tr>";
			}
			
			if($sys_padmin_system==1){
				echo "<tr bgcolor=\"#FFFFFF\">";
				echo "<td width=\"10\">";
				echo "<a href=# onClick=\"editPerm($sys_admin_id,5,$sys_padmin_system)\">";						
				echo "<img src=\"./images/icon/_edit-16.png\" border=\"0\" alt=\"edit\">";
				echo "</a>";
				echo "</td>";
				echo "<td style=\"background-color:#ffff99\">";
				echo "System Administrator";
				echo "</td>";
				echo "<td>";
				echo "active";
				echo "</td>";
				echo "<td width=\"10\">";
				echo "<a href=# onClick=\"delPerm($sys_admin_id,5)\">";
				echo "<img src=\"./images/icon/_cancel-16.png\" border=\"0\" alt=\"delete\">";
				echo "</a>";
				echo "</td>";
				echo "</tr>";
			}
			
			if($sys_padmin_users==1){
				echo "<tr bgcolor=\"#FFFFFF\">";
				echo "<td width=\"10\">";
				echo "<a href=# onClick=\"editPerm($sys_admin_id,6,$sys_padmin_users)\">";						
				echo "<img src=\"./images/icon/_edit-16.png\" border=\"0\" alt=\"edit\">";
				echo "</a>";
				echo "</td>";
				echo "<td style=\"background-color:#ffff99\">";
				echo "Users Administrator";
				echo "</td>";
				echo "<td>";
				echo "active";
				echo "</td>";
				echo "<td width=\"10\">";
				echo "<a href=# onClick=\"delPerm($sys_admin_id,6)\">";
				echo "<img src=\"./images/icon/_cancel-16.png\" border=\"0\" alt=\"delete\">";
				echo "</a>";
				echo "</td>";
				echo "</tr>";
			}
			if($sys_padmin_report==1){
				echo "<tr bgcolor=\"#FFFFFF\">";
				echo "<td width=\"10\">";
				echo "<a href=# onClick=\"editPerm($sys_admin_id,7,$sys_padmin_report)\">";						
				echo "<img src=\"./images/icon/_edit-16.png\" border=\"0\" alt=\"edit\">";
				echo "</a>";
				echo "</td>";
				echo "<td style=\"background-color:#ffff99\">";
				echo "Report Administrator";
				echo "</td>";
				echo "<td>";
				echo "active";
				echo "</td>";
				echo "<td width=\"10\">";
				echo "<a href=# onClick=\"delPerm($sys_admin_id,7)\">";
				echo "<img src=\"./images/icon/_cancel-16.png\" border=\"0\" alt=\"delete\">";
				echo "</a>";
				echo "</td>";
				echo "</tr>";
			}	
			
		}									
	}
	
	function lookupPermission($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM sys_admin_per WHERE sys_admin_users = ".$id.";";
		
		$result = $db->query($sql);

		$rs = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$permission = Permission::createPermissionObject($rs);

		return $permission;
	
	}		
	
	function createPermissionObject($row) {	
		$sys_admin_id = $row["sys_admin_id"];
		$sys_admin_users = $row["sys_admin_users"];
		$sys_padmin_courses = $row["sys_padmin_courses"];
		$sys_padmin_dms = $row["sys_padmin_dms"];
		$sys_padmin_system = $row["sys_padmin_system"];
		$sys_padmin_mdata = $row["sys_padmin_mdata"];
		$sys_padmin_users = $row["sys_padmin_users"];
		$sys_padmin_report = $row["sys_padmin_report"];
		$sys_padmin_super = $row["sys_padmin_super"];
						
		$permission = new Permission($sys_admin_id, $sys_admin_users, 
									 $sys_padmin_courses, $sys_padmin_dms, 
									 $sys_padmin_system, $sys_padmin_mdata, 
									 $sys_padmin_users,$sys_padmin_report, $sys_padmin_super);
		
		return $permission;
	}
	
	function create($permission) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
					  
	   $sql = "INSERT INTO sys_admin_per
			   (
			   	sys_admin_users, sys_padmin_courses, 
			    sys_padmin_dms, sys_padmin_system, 
				sys_padmin_mdata, sys_padmin_users, 
				sys_padmin_report, sys_padmin_super
			   )
			   VALUES
			   (".$permission->getSysAdminUsers().", ".$permission->getSysPAdminCourses().", 
			   ".$permission->getSysPAdminDms().", ".$permission->getSysPAdminSystem().", 
			   ".$permission->getSysPAdminMData().", ".$permission->getSysPAdminUsers().",
			   ".$permission->getSysPAdminReport().",".$permission->getSysPAdminSuper()."
			   );";
			   				
	//	echo $sql."<br>";			
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   	   
	   return true;	   				   
	}
	
	function update($permission) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}						
		
		$sql = "UPDATE sys_admin_per SET 
			   sys_admin_users    = ".$permission->getSysAdminUsers().", 
			   sys_padmin_courses = ".$permission->getSysPAdminCourses().", 
			   sys_padmin_dms	  = ".$permission->getSysPAdminDms().", 
			   sys_padmin_mdata   = ".$permission->getSysPAdminMData().", 
			   sys_padmin_users   = ".$permission->getSysPAdminUsers().", 
			   sys_padmin_system  = ".$permission->getSysPAdminSystem().", 
			   sys_padmin_super   = ".$permission->getSysPAdminSuper().",
				sys_padmin_report   = ".$permission->getSysPAdminReport()." 
			   WHERE sys_admin_id  = ".$permission->getSysAdminId().";";
			   
	   //echo $sql."<br>"; 
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }
	   return true;			
	}
		
	function del($users) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "DELETE FROM sys_admin_per WHERE sys_admin_id = ".$permission->getSysAdminId().";";
		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;			
	}

}

?>