<?php 
/**
 *	AdvisorCourse Class
 */
require ("../include/global_login.php");
/*
$dbname = "maxlearn";
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbtype = "mysql";

$dsn = "$dbtype://$dbuser:$dbpass@$dbhost/$dbname";

$email_host="nontri.ku.ac.th";
$path ="course";
$realpath="E:/Workshop/course";

$serverhost = $_SERVER["HTTP_HOST"];
*/
 
require_once("DB.php");
//require_once("../../classes/maxlearn_includes.php");
 
class Advisor_Course {

	var $advisor_course_id;
	
	//AdvisorCourse owner name
	var $advisor_course_name;

	// AdvisorCourse co1
	var $advisor_course_applyopen;
	
	// AdvisorCourse co1
	var $advisor_course_info;
	
	// AdvisorCourse co2
	var $advisor_course_users;
	
	// AdvisorCourse co3
	var $advisor_course_fullname;
	
	// AdvisorCourse co4
	var $advisor_course_fullname_eng;
	
	// AdvisorCourse co5
	var $advisor_course_section;
	
	// reseach name thai
	var $advisor_course_year;
	
	// AdvisorCourse name eng
	var $advisor_course_semester;
	
	// AdvisorCourse year
	var $advisor_course_quota;
	
	// AdvisorCourse encourage
	var $advisor_course_campus_id;
	
	// AdvisorCourse start date
	var $advisor_course_fac_id;
	
	// AdvisorCourse status
	var $advisor_course_dept_id;
	
	// AdvisorCourse budget
	var $advisor_course_keyword;
	
	// AdvisorCourse reward1
	var $advisor_course_advisor;
	
	
	
	function Advisor_Course($id, $name, $applyopen, $info, $users, $fullname, $fullname_eng, 
					  $section, $year, $semester, $quota, 
					  $campus_id, $fac_id, $dept_id, $keyword, $advisor
					  ) 
	{
		$this->advisor_course_id = $id;
		$this->advisor_course_name = $name;
		$this->advisor_course_applyopen = $applyopen;
		$this->advisor_course_info = $info;
		$this->advisor_course_users = $users;
		$this->advisor_course_fullname = $fullname;
		$this->advisor_course_fullname_eng = $fullname_eng;
		$this->advisor_course_section = $section;
		$this->advisor_course_year = $year;
		$this->advisor_course_semester = $semester;
		$this->advisor_course_quota = $quota;
		$this->advisor_course_campus_id = $campus_id;
		$this->advisor_course_fac_id = $fac_id;
		$this->advisor_course_dept_id = $dept_id;
		$this->advisor_course_keyword = $keyword;
		$this->advisor_course_advisor = $advisor;
	}
		
	function getAdvisorCourseId() {
		return $this->advisor_course_id;
	}		
	
	function getAdvisorCourseName() {
		return $this->advisor_course_name;
	}
	
	function getAdvisorCourseApplyOpen() {
		return $this->advisor_course_applyopen;
	}
	
	function getAdvisorCourseInfo() {
		return $this->advisor_course_info;
	}
	
	function getAdvisorCourseUsers() {
		return $this->advisor_course_users;
	}
	
	function getAdvisorCourseFullName() {
		return $this->advisor_course_fullname;
	}
	
	function getAdvisorCourseFullNameEng() {
		return $this->advisor_course_fullname_eng;
	}
	
	function getAdvisorCourseSection() {
		return $this->advisor_course_section;
	}
	
	function getAdvisorCourseYear() {
		return $this->advisor_course_year;
	}
	
	function getAdvisorCourseSemester() {
		return $this->advisor_course_semester;
	}
	
	function getAdvisorCourseQuota() {
		return $this->advisor_course_quota;
	}
	
	function getAdvisorCourseCampusId() {
		return $this->advisor_course_campus_id;
	}
	
	function getAdvisorCourseFacId() {
		return $this->advisor_course_fac_id;
	}
	
	function getAdvisorCourseDeptId() {
		return $this->advisor_course_dept_id;
	}
	
	function getAdvisorCourseKeyword() {
		return $this->advisor_course_keyword;
	}
	
	function getAdvisorCourseAdvisor() {
		return $this->advisor_course_advisor;
	}
	
	function checkCreate($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
				
		$sql = "SELECT advisor
				FROM courses WHERE users = ".$id." AND advisor =1;";		
		
		$result = $db->query($sql);
		
		if ($result->numRows() == 1)	
 		{			
			return true;
		} else {		
			return false;
		}
	}
		
	function create($AdvisorCourse) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
					  
	   $sql = "INSERT INTO courses
			   (name, active, applyopen, info, users, fullname, fullname_eng,
			    section, year, semester, quota, 
				campus_id, fac_id, dept_id, keyword, advisor
			   )
			   VALUES
			   ('Advisor', 1, -1, '', ".$AdvisorCourse->getAdvisorCourseUsers().", '', '',
				'',0,0,100,
				'','','','',1);";
			   				
		//echo $sql."<br>";			
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   
	   return true;	   			
	}
		
	
	function SelectAdvisorCourse($uid) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM courses WHERE users=".$uid." AND advisor = 1;";

		//echo $sql."<br>";
		
		$result = $db->query($sql);
	
		$rs_AdvisorCourse = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$advisor_course = Advisor_Course::createAdvisorCourseObject($rs_AdvisorCourse);

		return $advisor_course;
	
	}
				
	function createAdvisorCourseObject($row) {			
		$id = $row["id"];		
		$name = $row["name"];
		$applyopen   = $row["applyopen"];
		$info   = $row["info"];
		$users   = $row["users"];
		$fullname   = $row["fullname"];
		$fullname_eng   = $row["fullname_eng"];
		$section    = $row["section"];
		$year   = $row["year"];
		$semester       = $row["semester"];
		$quota  = $row["quota"];
		$campus_id = $row["campus_id"];
		$fac_id     = $row["fac_id"];
		$dept_id     = $row["dept_id"];
		$keyword    = $row["keyword"];
		$advisor    = $row["advisor"];
		
		
		$advisor_course = new Advisor_Course($id, $name, -1, '', $user, '', '', 
					  '', 0, 0, 100, 
					  '', '', '', '', 1
					  );
					  				
		return $advisor_course;
	}
			
}

?>