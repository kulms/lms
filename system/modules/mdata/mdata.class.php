<?php 
/**
 *	@package system
 *	@subpackage modules
*/

/**
 *	Courses Class
 */
require_once("DB.php");
 
class Courses {
	// int courses id
	var $courses_id = NULL;		
	// int courses active
	var $courses_active = NULL;
	// varchar courses name
  	var $courses_name = NULL;
	// varchar courses fullname
	var $courses_fullname = NULL;
	// varchar courses fullname eng
	var $courses_fullname_eng = NULL;
	// varchar courses section
	var $courses_section = NULL;
	// int courses year
	var $courses_year = NULL;
	// varchar courses semester
	var $courses_semester = NULL;
	// int courses users
	var $courses_users = NULL;
	// varchar courses firstname
	var $courses_firstname = NULL;
	// varchar courses surname
	var $courses_surname = NULL;		
	
	function Courses($id, $active, $name, $fullname, $fullname_eng, 
					 $section, $year, $semester, 
					 $users, $firstname, $surname
				    ) 
	{
		$this->courses_id 	   		= $id;
		$this->courses_active    	= $active;
		$this->courses_name     	= $name;
		$this->courses_fullname  	= $fullname;
		$this->courses_fullname_eng = $fullname_eng;
		$this->courses_section   	= $section;
		$this->courses_year 	   	= $year;
		$this->courses_semester  	= $semester;
		$this->courses_users  		= $users;
		$this->courses_firstname 	= $firstname;
		$this->courses_surname   	= $surname;
	}
	
	function getCoursesId() {
		return $this->courses_id;
	}
	
	function getCoursesActive() {
		return $this->courses_active;
	}
	
	function getCoursesName() {
		return $this->courses_name;
	}
	
	function getCoursesFullName() {
		return $this->courses_fullname;
	}
	
	function getCoursesFullNameEng() {
		return $this->courses_fullname_eng;
	}
	
	function getCoursesSection() {
		return $this->courses_section;
	}
	
	function getCoursesYear() {
		return $this->courses_year;
	}
	
	function getCoursesSemester() {
		return $this->courses_semester;
	}
	
	function getCoursesUsers() {
		return $this->courses_users;
	}
	
	function getCoursesFirstname() {
		return $this->courses_firstname;
	}
	
	function getCoursesSurname() {
		return $this->courses_surname;
	}
	
	
	function create($courses) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$year = $courses->getCoursesYear();
		if ($year == '') { $year = 0;}
		$semester = $courses->getCoursesSemester();
		if ($semester == '') { $semester = 0;}
		
	   $sql = "INSERT INTO courses
			   (
			    active, name, fullname, fullname_eng,  
			    section, year, semester, users
			   )
			   VALUES
			   (".$courses->getCoursesActive().", '".$courses->getCoursesName()."','".$courses->getCoursesFullname()."', 
			   '".$courses->getCoursesFullNameEng()."', '".$courses->getCoursesSection()."', ".$courses->getCoursesYear().", 
			    ".$courses->getCoursesSemester().",".$courses->getCoursesUsers()."
			   );";
			   				
		//echo $sql."<br>";			
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   	   
	   return true;	   			
	}
	
	function SelectAllCourses($active, $order, $page) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$maxRow = $page*20;
		$minRow = $maxRow - 19;
		
		$numRow = " LIMIT ".$minRow.", ".$maxRow;
		
		if ($order == "") {
			//$sql = "SELECT * FROM courses WHERE active=".$active." ORDER BY name;";
			$sql = "SELECT c.id, c.active, c.name, c.section, c.year, c.semester, c.fullname, c.fullname_eng, c.users, 
						   u.title,u.firstname,u.surname 
					FROM courses c, users u 
					WHERE c.active=".$active." AND c.users=u.id AND c.advisor=0 
					ORDER BY c.name;";
		} else {
			//$sql = "SELECT * FROM courses WHERE active=".$active." ORDER BY ".$order.";";
			$sql = "SELECT c.id, c.active, c.name, c.section, c.year, c.semester, c.fullname, c.fullname_eng, c.users, 
						   u.title,u.firstname,u.surname 
					FROM courses c, users u 
					WHERE c.active=".$active." AND c.users=u.id AND c.advisor=0 
					ORDER BY ".$order.";";
		}
		//echo $sql;
		$result = $db->query($sql);
	
		return $result;
	
	}
	
	function SelectCoursesPerPage($active, $order, $page) {
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
		
		$numRow = " LIMIT ".$minRow.", "."20";
		

		$where .= " AND (c.id >= $minRow ";
		$where .= " AND c.id <= $maxRow) ";
		
		
		
		if ($order == "") {
			//$sql = "SELECT * FROM courses WHERE active=".$active.$where." ORDER BY $order;";
			$sql = "SELECT c.id, c.active, c.name, c.section, c.year, c.semester, c.fullname, c.fullname_eng, c.users, 
						   u.title, u.firstname, u.surname 
					FROM courses c, users u 
					WHERE c.active=".$active." AND c.users=u.id AND c.advisor=0 
					ORDER BY c.name ".$numRow.";";
		} else {			
			//$sql = "SELECT * FROM courses WHERE active=".$active.$where." ORDER BY $order;";
			$sql = "SELECT c.id, c.active, c.name, c.section, c.year, c.semester, c.fullname, c.fullname_eng, c.users, 
						   u.title, u.firstname, u.surname 
					FROM courses c, users u 
					WHERE c.active=".$active." AND c.users=u.id AND c.advisor=0
					ORDER BY ".$order."".$numRow.";";
		}
		//echo $sql;
		$result = $db->query($sql);
	
		return $result;
	
	}	
	
	function ShowTableAll($result,$user,$uistyle,$tab,$page) {
		//echo $result->numRows();				
		echo "<table cellpadding=\"2\" cellspacing=\"1\" border=\"0\" width=\"100%\" class=\"tbl\">";
		echo "<tr>";
		echo "<td width=\"60\" align=\"right\">";
		echo "&nbsp; sort by:&nbsp;";
		echo "</td>";
		echo "<th width=\"10%\">";
		echo "<a href=\"?m=courses&a=index&orderby=name&tab=$tab&page=$page\" class=\"hdr\">Course Id</a>";
		echo "</th>";
		echo "<th width=\"5%\">";
		echo "<a href=\"?m=courses&a=index&orderby=section&tab=$tab&page=$page\" class=\"hdr\">Section</a>";
		echo "</th>";
		echo "<th width=\"5%\">";
		echo "<a href=\"?m=courses&a=index&orderby=year&tab=$tab&page=$page\" class=\"hdr\">Year</a>";
		echo "</th>";
		echo "<th width=\"5%\">";
		echo "<a href=\"?m=courses&a=index&orderby=semester&tab=$tab&page=$page\" class=\"hdr\">Semester</a>";
		echo "</th>";
		echo "<th width=\"45%\">";
		echo "<a href=\"?m=courses&a=index&orderby=fullname_eng&tab=$tab&page=$page\" class=\"hdr\">Course Name</a>";
		echo "</th>";
		echo "<th width=\"20%\">";
		echo "<a href=\"?m=courses&a=index&orderby=firstname&tab=$tab&page=$page\" class=\"hdr\">Lecturer</a>";
		echo "</th>";
		echo "</tr>";
		while ($rs = @$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$courses_id = $rs["id"];
			$courses_active = $rs["active"];
			$courses_name = $rs["name"];
			$courses_section = $rs["section"];
			$courses_year = $rs["year"];
			$courses_semester = $rs["semester"];
			$courses_fullname = $rs["fullname"];
			$courses_fullname_eng = $rs["fullname_eng"];
			$courses_title = $rs["title"];
			$courses_firstname = $rs["firstname"];
			$courses_surname = $rs["surname"];
			
			echo "<tr>";
			echo "<td align=\"right\" nowrap=\"nowrap\">";
			echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			echo "<tr>";
			echo "<td>";						
			echo "</td>";
			echo "<td>";			
			echo "</td>";
			echo "</tr>";
			echo "</table>";
			echo "</td>";
			
			echo "<td>";
			if($courses_active==1){
				echo "<img src=\"./images/obj/courses.gif\" border=\"0\">";			
			} else {
				echo "<img src=\"./images/obj/courses_in.gif\" border=\"0\">";			
			}
			//echo "<a href=\"./index.php?m=courses&a=view&courses_id=".$courses_id."\">".$courses_name."</a>";
			echo "<a href=\"../courses/menu.php?courses=".$courses_id."\" target=\"ws_menu\">".$courses_name."</a>";
			echo "</td>";
			
			echo "<td>";
			if(strlen($courses_section)==0){			
				echo "-";
			} else {
				echo $courses_section;
			}
				
			echo "</td>";
			
			echo "<td>";			
			echo $courses_year;
			echo "</td>";
			
			echo "<td>";			
			echo $courses_semester;
			echo "</td>";
			
			echo "<td valign=\"middle\">";			
			echo $courses_fullname." ".$courses_fullname_eng."";
			echo "</td>";
									
			echo "<td>";			
			echo $courses_title.$courses_firstname." ".$courses_surname;
			echo "</td>";
			
			echo "</tr>";
		}
		echo "</table>";									
	}
	
	function ShowSeqTable($result,$page){
		$NRow = $result->numRows();																	 
		$rt = $NRow%20;
		if($rt!=0) {
			$totalpage = floor($NRow/20)+1;
		}
		else {
			$totalpage = floor($NRow/20);
		}
		$goto = ($page-1)*20;
		if ($page != 1) {
		$s = $page*10;
		} else {
		$s=0;
		}
		  // table แสดงเลขหน้า
		echo "<table width=100% border=0 bordercolor=black cellspacing=0 cellpadding=2>\n";
		echo "<tr><td align=left>\n";
		echo "\t<font size=2 >\n";

		// สร้าง link เพื่อไปหน้าก่อน-หน้าถัดไป
		if($page>1 && $page<=$totalpage) {
				$prevpage = $page-1;
				echo "\t<a href='./index.php?m=courses&page=$prevpage' class=a11>[Prev]</a>\n";
		}

		echo "\t [$page/$totalpage] \n";

		if($page!=$totalpage) {
				$nextpage = $page+1;
				echo "\t<a href='./index.php?m=courses&page=$nextpage' class=a11>[Next]</a>\n";
		}

		echo "\t</font>\n";
		echo "</td></tr>\n";
		echo "<tr><td>\n";

		// วนลูปแสดงเลขหน้าทั้งหมด
		for($i=1 ; $i<$page ; $i++) {
				echo "\t<a href='./index.php?m=courses&page=$i'>$i</a> \n";
		}
		echo "\t<font size=2 color=red><b>$page</b></font> \n";
		for($i=$page+1 ; $i<=$totalpage ; $i++) {
				echo "\t<a href='./index.php?m=courses&page=$i' class=a11>$i</a> \n";
		}

		echo "</td></tr>\n";
		echo "</table>\n";
	}
		
	function lookupCourses($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT c.id, c.active, c.name, c.section, c.year, c.semester, c.fullname, c.fullname_eng, c.users, 
						   u.title, u.firstname, u.surname 
				FROM courses c, users u 
				WHERE c.id=".$id." AND c.users=u.id AND c.advisor=0;";

		
		$result = $db->query($sql);

		$rs_courses = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$courses = Courses::createCoursesObject($rs_courses);

		return $courses;
	
	}		
	
	function createCoursesObject($row) {					
		
		$courses_id 		   = $row["id"];
		$courses_active 	   = $row["active"];
		$courses_name	 	   = $row["name"];
		$courses_section 	   = $row["section"];
		$courses_year  		   = $row["year"];
		$courses_semester 	   = $row["semester"];
		$courses_fullname      = $row["fullname"];
		$courses_fullname_eng  = $row["fullname_eng"];
		$courses_users  	   = $row["users"];
		$courses_firstname     = $row["firstname"];
		$courses_surname  	   = $row["surname"];
		
		$courses = new Courses($courses_id, $courses_active, $courses_name, $courses_fullname, $courses_fullname_eng, 
						   	   $courses_section, $courses_year, $courses_semester, 
						   	   $courses_users, $courses_firstname, $courses_surname 
						  );
		return $courses;
	}
	
	function update($courses) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$year = $courses->getCoursesYear();
		if ($year == '') { $year = 0;}
		$semester = $courses->getCoursesSemester();
		if ($semester == '') { $semester = 0;}
		
		$sql = "UPDATE courses SET 
				   active    	= ".$courses->getCoursesActive().", 	
				   name     	= '".$courses->getCoursesName()."', 
				   fullname  	= '".$courses->getCoursesFullName()."',
				   fullname_eng = '".$courses->getCoursesFullNameEng()."', 
				   section   	= '".$courses->getCoursesSection()."', 
				   year     	= ".$courses->getCoursesYear().", 
				   semester  	= ".$courses->getCoursesSemester().", 
				   users  		= ".$courses->getCoursesUsers()."
				WHERE id  = ".$courses->getCoursesId().";";
			   
	   //echo $sql."<br>"; 
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }
	   return true;
			
	}
		
	function del($courses) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "DELETE FROM courses WHERE id = ".$courses->getCoursesId().";";
		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
		
	function SearchCourses($strSearch,$page) 
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
				$where = "WHERE c.id <> 0 ";
				//if ($strSearch != '') $where .= " AND (login LIKE '%".$strSearch."%'";
				if ($strSearch != '')    $where .= " AND (c.fullname LIKE '%".$strSearch."%'";
				if ($strSearch != '')    $where .= " OR c.fullname_eng LIKE '%".$strSearch."%')";
				//if ($strSearch != '')   $where .= " OR surname LIKE '%".$strSearch."%')";			
			} else {
				$where = "WHERE c.id <> 0 ";
				//if ($strSearch != '') $where .= " AND (login LIKE '%".$strSearch."%'";
				if ($strSearch != '')    $where .= " AND (SUBSTRING(c.fullname, 1, 1) LIKE '%".$strSearch."%'";
				if ($strSearch != '')    $where .= " OR SUBSTRING(c.fullname_eng, 1, 1) LIKE '%".$strSearch."%')";				
				//if ($strSearch != '')   $where .= " OR surname LIKE '%".$strSearch."%')";			
			}
		}
		
		$maxRow = $page*20;
		$minRow = $maxRow - 19;
		
		$numRow = " LIMIT ".$minRow.", ".$maxRow;
		
		//$sql = "SELECT * FROM courses ".$where." ORDER BY name ;";
		
		$sql = "SELECT c.id, c.active, c.name, c.section, c.year, c.semester, c.fullname, c.fullname_eng, c.users, 
					   u.title,u.firstname,u.surname 
				FROM courses c, users u 
				".$where." AND c.users=u.id AND c.advisor=0 				
				ORDER BY c.name;";
		
		//echo $sql;		
		$result = $db->query($sql);	
		return $result;		
	}
	
	function SearchCoursesPerPage($strSearch,$page) 
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
			$where = "WHERE c.id <> 0 ";
			//if ($strSearch != '') $where .= " AND (login LIKE '%".$strSearch."%'";
			if ($strSearch != '')    $where .= " AND (SUBSTRING(c.fullname, 1, 1) LIKE '%".$strSearch."%'";
			if ($strSearch != '')    $where .= " OR SUBSTRING(c.fullname_eng, 1, 1) LIKE '%".$strSearch."%')";
			//if ($strSearch != '')    $where .= " AND firstname LIKE '%".$strSearch."%'";
			//if ($strSearch != '')   $where .= " OR surname LIKE '%".$strSearch."%')";			
		} else {
			$where = "WHERE c.id <> 0 ";
			$where .= " AND (c.id >= $minRow ";
			$where .= " AND c.id <= $maxRow) ";
		}
														
		//$sql = "SELECT * FROM courses ".$where." ORDER BY id ;";
		
		$sql = "SELECT c.id, c.active, c.name, c.section, c.year, c.semester, c.fullname, c.fullname_eng, c.users, 
					   u.title,u.firstname,u.surname 
				FROM courses c, users u 
				".$where." AND c.users=u.id AND c.advisor=0 				
				ORDER BY c.name;";
		
		//echo $sql;		
		$result = $db->query($sql);	
		return $result;		
	}
		
}

?>