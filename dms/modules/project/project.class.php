<?php 
/**
 *	@package dms
 *	@subpackage modules
*/

/**
 *	Project Class
 */
require_once("DB.php");
//require_once("../../classes/maxlearn_includes.php");
 
class Project {
	// project id
	var $project_id;
	
	// project owner id
	var $project_owner_id;
	
	// project owner name
	var $project_owner_name;

	// project advisor id
	var $project_advisor_id;

	// project co1
	var $project_co1_id;
	
	// project co2
	var $project_co2_id;
	
	// project co3
	var $project_co3_id;
	
	// project co4
	var $project_co4_id;
	
	// project co5
	var $project_co5_id;
	
	// project name thai
	var $project_name_th;
	
	// project name eng
	var $project_name_eng;
	
	// project year
	var $project_year;
	
	// project encourage
	var $project_encourage;
	
	// project budget
	var $project_budget;
	
	// project reward1
	var $project_reward1;
	
	// project reward2
	var $project_reward2;
	
	// project no
	var $project_no;

	// project isbn
	var $project_isbn;
	
	// project abstract
	var $project_abstract;
	
	// project picture
	var $project_picture;
	
	// project full
	var $project_full;
	
	// project keyword1
	var $project_keyword1;
	
	// project keyword2
	var $project_keyword2;
	
	// project keyword3
	var $project_keyword3;
	
	// project keyword4
	var $project_keyword4;
	
	// project keyword5
	var $project_keyword5;
	
	function Project($id, $owner_id, $owner_name, $advisor_id, $co1_id, $co2_id, $co3_id, $co4_id, $co5_id,
					  $name_th, $name_eng, $year, $encourage, $budget, $reward1, $reward2, $no,
					  $isbn, $abstract, $picture, $full, $keyword1, $keyword2, $keyword3, $keyword4, $keyword5
					  ) 
	{
		$this->project_id = $id;
		$this->project_owner_id = $owner_id;
		$this->project_owner_name = $owner_name;
		$this->project_advisor_id = $advisor_id;
		$this->project_co1_id = $co1_id;
		$this->project_co2_id = $co2_id;
		$this->project_co3_id = $co3_id;
		$this->project_co4_id = $co4_id;
		$this->project_co5_id = $co5_id;
		$this->project_name_th = $name_th;
		$this->project_name_eng = $name_eng;
		$this->project_year = $year;
		$this->project_encourage = $encourage;
		$this->project_budget = $budget;
		$this->project_reward1 = $reward1;
		$this->project_reward2 = $reward2;
		$this->project_no = $no;
		$this->project_isbn = $isbn;
		$this->project_abstract = $abstract;
		$this->project_picture = $picture;
		$this->project_full = $full;
		$this->project_keyword1 = $keyword1;
		$this->project_keyword2 = $keyword2;
		$this->project_keyword3 = $keyword3;
		$this->project_keyword4 = $keyword4;
		$this->project_keyword5 = $keyword5;
	}
	
	//function Project(){
	//}
	
	function getProjectId() {
		return $this->project_id;
	}
	
	function getProjectOwner() {
		return $this->project_owner_id;
	}
	
	function getProjectOwnerName() {
		return $this->project_owner_name;
	}
	
	function getProjectAdvisor() {
		return $this->project_advisor_id;
	}

	function getProjectCo1() {
		return $this->project_co1_id;
	}
	
	function getProjectCo2() {
		return $this->project_co2_id;
	}
	
	function getProjectCo3() {
		return $this->project_co3_id;
	}
	
	function getProjectCo4() {
		return $this->project_co4_id;
	}
	
	function getProjectCo5() {
		return $this->project_co5_id;
	}
	
	function getProjectNameTh() {
		return $this->project_name_th;
	}
	
	function getProjectNameEng() {
		return $this->project_name_eng;
	}
	
	function getProjectYear() {
		return $this->project_year;
	}
	
	function getProjectEncourage() {
		return $this->project_encourage;
	}
	
	function getProjectBudget() {
		return $this->project_budget;
	}
	
	function getProjectReward1() {
		return $this->project_reward1;
	}
	
	function getProjectReward2() {
		return $this->project_reward2;
	}
	
	function getProjectNo() {
		return $this->project_no;
	}
	
	function getProjectISBN() {
		return $this->project_isbn;
	}
	
	function getProjectAbstract() {
		return $this->project_abstract;
	}
	
	function getProjectPicture() {
		return $this->project_picture;
	}
	
	function getProjectFull() {
		return $this->project_full;
	}
	
	function getProjectKeyword1() {
		return $this->project_keyword1;
	}
	
	function getProjectKeyword2() {
		return $this->project_keyword2;
	}
	
	function getProjectKeyword3() {
		return $this->project_keyword3;
	}
	
	function getProjectKeyword4() {
		return $this->project_keyword4;
	}
	
	function getProjectKeyword5() {
		return $this->project_keyword5;
	}
	
	
	function create($project) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
				
		$year = $project->getProjectYear();
		if ($year == '') { $year = 0;}
		//$start_date = $research->getResearchStartDate();
		//if ($start_date == '') { $start_date = 0;}
		$budget = $project->getProjectBudget();		
		if ($budget == '') { $budget = 0;}
		$no = $project->getProjectNo();
		if ($no== '') { $no = 0;}
		$isbn = $project->getProjectISBN();
		if ($isbn == '') { $isbn = 0;}
						 		
					  
	   $sql = "INSERT INTO dms_project
			   (project_owner_id , project_owner_name, project_advisor_id, project_co1_id, project_co2_id, project_co3_id, project_co4_id, project_co5_id,
			    project_name_th, project_name_eng, project_year, project_encourage, project_budget,
				project_reward1, project_reward2, project_no, project_isbn, project_abstract, project_picture, project_full,
				project_keyword1, project_keyword2, project_keyword3, project_keyword4, project_keyword5 
			   )
			   VALUES
			   (".$project->getProjectOwner().",'".$project->getProjectOwnerName()."','".$project->getProjectAdvisor()."','".$project->getProjectCo1()."', '".$project->getProjectCo2()."', '".$project->getProjectCo3()."', '".$project->getProjectCo4()."', '".$project->getProjectCo5()."',
				'".$project->getProjectNameTh()."','".$project->getProjectNameEng()."',".$year.",'".$project->getProjectEncourage()."',".$budget.",
				'".$project->getProjectReward1()."','".$project->getProjectReward2()."',".$no.",".$isbn.",'".$project->getProjectAbstract()."','".$project->getProjectPicture()."','".$project->getProjectFull()."',
				'".$project->getProjectKeyword1()."','".$project->getProjectKeyword2()."','".$project->getProjectKeyword3()."','".$project->getProjectKeyword4()."','".$project->getProjectKeyword5()."'
			   );";
			   				
		//echo $sql."<br>";			
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   
	   return true;	   			
	}
	
	function SelectAllProject($uid) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM dms_project WHERE project_owner_id=".$uid." ORDER BY project_name_eng;";
		
		$result = $db->query($sql);
	
		return $result;
	
	}
	
	function ShowTableAll($result,$user,$uistyle,$theme) {
		//echo $result->numRows();
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"std\">"; 
  		echo "<tr>";
   		echo "<td valign=\"top\"> <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<tr align=\"left\" valign=\"middle\">"; 
        echo "<td width=\"1%\" height=\"2\" bgcolor=\"#9999CC\" background=\"../themes/$theme/images/titlegrad.jpg\"><font size=\"2\"><img src=\"./images/project.gif\" border=\"0\"></font></td>";
        echo "<td width=\"99%\" height=\"2\" background=\"../themes/$theme/images/titlegrad.jpg\"><font color=\"#FFFFFF\"><strong>Project</strong></font></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td height=\"2\" width=\"1%\"><font size=\"2\">&nbsp;</font></td>";
        echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">Total Project : ".$result->numRows()."</font></td>";
        echo "</tr>";
      	echo "</table>";
      	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"tdborder1\">";
        echo "<tr align=\"center\" class=\"boxcolor\">"; 
        echo "<td width=\"500\" height=\"25\" class=\"BColor\"><strong>".$user->_('Project Name (English)')."</strong></td>";
        echo " <td height=\"25\" width=\"10\" class=\"BColor\"><strong><font size=\"2\">&nbsp;</font></strong></td>";
        echo "<td height=\"25\" width=\"180\" class=\"BColor\"><strong><font size=\"2\">".$user->_('Advisor')."</font></strong></td>";
		echo "<td height=\"25\" width=\"102\" class=\"BColor\"><strong>".$user->_('No')."</strong></td>";
		echo "<td height=\"25\" width=\"103\" class=\"BColor\"><strong>".$user->_('Year')."</strong></td>";
        echo "<td height=\"25\" width=\"144\" class=\"BColor\"><strong>".$user->_('Budget (THB)')."</strong></td>";
        echo "</tr>";
		while ($rs = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$project_name_eng = $rs["project_name_eng"];
			$project_advisor_id = $rs["project_advisor_id"];
			$project_no = $rs["project_no"];
			if (strlen($project_no) == 0) { $project_no = "&nbsp;"; }
			$project_year = $rs["project_year"];
			if ($project_year == '') { $project_year = "&nbsp;"; }
			$project_encourage = $rs["project_encourage"];
			if (strlen($project_encourage) == 0) { $project_encourage = "&nbsp;"; }
			$project_budget = $rs["project_budget"];
			if (strlen($project_budget) == 0) { $project_budget = "&nbsp;"; }
			echo "<tr>";
			echo "<td height=\"25\" bgcolor=\"#FFFFFF\" class=\"line\"><font size=\"2\">&nbsp;<font color=\"#0099CC\">&raquo;</font>&nbsp;";
			echo "<a href=\"./index.php?m=project&a=view&project_id=".$rs["project_id"]."\">".$project_name_eng."</a></font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">&nbsp;</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$project_advisor_id."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$project_no."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$project_year."</font></td>";
			//echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$project_encourage."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$project_budget."</font></td>";
			echo "</tr>";
		}
		echo "</table></td>";
		echo "</tr>";
		echo "<tr>";
    	echo "<td valign=\"top\">&nbsp;</td>";
   		echo "</tr>";
		echo "</table>";
	
	}
	
	function lookupProject($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM dms_project WHERE project_id = ".$id.";";
		
		$result = $db->query($sql);

		$rs_project = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$project = Project::createProjectObject($rs_project);

		return $project;
	
	}
	
	function createProjectObject($row) {			
		$id = $row["project_id"];
		$owner = $row["project_owner_id"];
		$owner_name = $row["project_owner_name"];
		$project_advisor_name = $row["project_advisor_id"];
		$project_co1_name     = $row["project_co1_id"];
		$project_co2_name     = $row["project_co2_id"];
		$project_co3_name     = $row["project_co3_id"];
		$project_co4_name     = $row["project_co4_id"];
		$project_co5_name     = $row["project_co5_id"];
		$project_name_th      = $row["project_name_th"];
		$project_name_eng     = $row["project_name_eng"];
		$project_year         = $row["project_year"];
		$project_encourage    = $row["project_encourage"];
		$project_budget       = $row["project_budget"];
		$project_reward1      = $row["project_reward1"];
		$project_reward2      = $row["project_reward2"];
		$project_no			  = $row["project_no"];
		$project_isbn         = $row["project_isbn"];
		$project_abstract     = $row["project_abstract"];
		$project_picture      = $row["project_picture"];
		$project_full      	  = $row["project_full"];
		$project_keyword1     = $row["project_keyword1"];
		$project_keyword2     = $row["project_keyword2"];
		$project_keyword3     = $row["project_keyword3"];
		$project_keyword4     = $row["project_keyword4"];
		$project_keyword5     = $row["project_keyword5"];
		
		$project = new Project($id, $owner, $owner_name, $project_advisor_name, $project_co1_name, $project_co2_name, $project_co3_name, $project_co4_name, $project_co5_name, 
						$project_name_th, $project_name_eng, $project_year, $project_encourage,  $project_budget, $project_reward1, $project_reward2, $project_no,
						$project_isbn, $project_abstract, $project_picture, $project_full, $project_keyword1, $project_keyword2, $project_keyword3, $project_keyword4, $project_keyword5
						);
		return $project;
	}
	
	function update($project) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$year = $project->getProjectYear();
		if ($year == '') { $year = 0;}
		$budget = $project->getProjectBudget();		
		if ($budget == '') { $budget = 0;}
		$no = $project->getProjectNo();		
		if ($no == '') { $no = 0;}
		$isbn = $project->getProjectISBN();
		if ($isbn == '') { $isbn = 0;}
		
		$sql = "UPDATE dms_project SET 
			   project_owner_id    = ".$project->getProjectOwner().",
			   project_owner_name  = '".$project->getProjectOwnerName()."', 
			   project_advisor_id  = '".$project->getProjectAdvisor()."',
			   project_co1_id      = '".$project->getProjectCo1()."', 
			   project_co2_id      = '".$project->getProjectCo2()."', 
			   project_co3_id      = '".$project->getProjectCo3()."', 
			   project_co4_id      = '".$project->getProjectCo4()."', 
			   project_co5_id      = '".$project->getProjectCo5()."', 
			   project_name_th     = '".$project->getProjectNameTh()."', 
			   project_name_eng    = '".$project->getProjectNameEng()."', 
			   project_year  	   = ".$year.", 
			   project_encourage   = '".$project->getProjectEncourage()."', 
			   project_budget  	   = ".$budget.", 
			   project_reward1     = '".$project->getProjectReward1()."', 
			   project_reward2     = '".$project->getProjectReward2()."',
			   project_no          = ".$no.",
			   project_isbn   	   = ".$isbn.",  
			   project_abstract    = '".$project->getProjectAbstract()."', 
			   project_picture     = '".$project->getProjectPicture()."',
			   project_full        = '".$project->getProjectFull()."',
			   project_keyword1    = '".$project->getProjectKeyword1()."',
			   project_keyword2    = '".$project->getProjectKeyword2()."',
			   project_keyword3    = '".$project->getProjectKeyword3()."',
			   project_keyword4    = '".$project->getProjectKeyword4()."',
			   project_keyword5    = '".$project->getProjectKeyword5()."' 
			   WHERE project_id    = ".$project->getProjectId().";";
			   
	   //echo $sql."<br>"; 
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	
	
	function del($project) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "DELETE FROM dms_project WHERE project_id = ".$project->getProjectId().";";
	
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}

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
			   (".$users.", ".$id.",'project', 'insert', ".time().");";
		
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
	   		   (".$owner.", ".$id.",'project', 'del', ".time().");";

		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	
	function log_update($project) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "INSERT INTO dms_log
	   		   (log_users, log_doc_id, log_doc_type, log_action, log_time)
	   		   VALUES
	   		   (".$project->getProjectOwner().", ".$project->getProjectId().",'project', 'update', ".time().");";

		
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