<?php 
/**
 *	@package dms
 *	@subpackage modules
*/

/**
 *	Research Class
 */
require_once("DB.php");
//require_once("../../classes/maxlearn_includes.php");
 
class Research {
	// research id
	var $research_id;
	
	// research owner id
	var $research_owner_id;
	
	//research owner name
	var $research_owner_name;

	// research co1
	var $research_co1_id;
	
	// research co2
	var $research_co2_id;
	
	// research co3
	var $research_co3_id;
	
	// research co4
	var $research_co4_id;
	
	// research co5
	var $research_co5_id;
	
	// reseach name thai
	var $research_name_th;
	
	// research name eng
	var $research_name_eng;
	
	// research year
	var $research_year;
	
	// research encourage
	var $research_encourage;
	
	// research start date
	var $research_start_date;
	
	// research status
	var $research_status;
	
	// research budget
	var $research_budget;
	
	// research reward1
	var $research_reward1;
	
	// research reward2
	var $research_reward2;
	
	// research isbn
	var $research_isbn;
	
	// research abstract
	var $research_abstract;
	
	// research picture
	var $research_picture;

	// research full
	var $research_full;
	
	// research keyword1
	var $research_keyword1;
	
	// research keyword2
	var $research_keyword2;
	
	// research keyword3
	var $research_keyword3;
	
	// research keyword4
	var $research_keyword4;
	
	// research keyword5
	var $research_keyword5;
	
	function Research($id, $owner_id, $owner_name, $co1_id, $co2_id, $co3_id, $co4_id, $co5_id,
					  $name_th, $name_eng, $year, $encourage, $start_date, $status, $budget,
					  $reward1, $reward2, $isbn, $abstract, $picture, $full,
					  $keyword1, $keyword2, $keyword3, $keyword4, $keyword5
					  ) 
	{
		$this->research_id = $id;
		$this->research_owner_id = $owner_id;
		$this->research_owner_name = $owner_name;
		$this->research_co1_id = $co1_id;
		$this->research_co2_id = $co2_id;
		$this->research_co3_id = $co3_id;
		$this->research_co4_id = $co4_id;
		$this->research_co5_id = $co5_id;
		$this->research_name_th = $name_th;
		$this->research_name_eng = $name_eng;
		$this->research_year = $year;
		$this->research_encourage = $encourage;
		$this->research_start_date = $start_date;
		$this->research_status = $status;
		$this->research_budget = $budget;
		$this->research_reward1 = $reward1;
		$this->research_reward2 = $reward2;
		$this->research_isbn = $isbn;
		$this->research_abstract = $abstract;
		$this->research_picture = $picture;
		$this->research_full = $full;
		$this->research_keyword1 = $keyword1;
		$this->research_keyword2 = $keyword2;
		$this->research_keyword3 = $keyword3;
		$this->research_keyword4 = $keyword4;
		$this->research_keyword5 = $keyword5;
	}
	
	//function Research(){
	//}
	
	function getResearchId() {
		return $this->research_id;
	}
	
	function getResearchOwner() {
		return $this->research_owner_id;
	}
	
	function getResearchOwnerName() {
		return $this->research_owner_name;
	}
	
	function getResearchCo1() {
		return $this->research_co1_id;
	}
	
	function getResearchCo2() {
		return $this->research_co2_id;
	}
	
	function getResearchCo3() {
		return $this->research_co3_id;
	}
	
	function getResearchCo4() {
		return $this->research_co4_id;
	}
	
	function getResearchCo5() {
		return $this->research_co5_id;
	}
	
	function getResearchNameTh() {
		return $this->research_name_th;
	}
	
	function getResearchNameEng() {
		return $this->research_name_eng;
	}
	
	function getResearchYear() {
		return $this->research_year;
	}
	
	function getResearchEncourage() {
		return $this->research_encourage;
	}
	
	function getResearchStartDate() {
		return $this->research_start_date;
	}
	
	function getResearchStatus() {
		return $this->research_status;
	}
	
	function getResearchBudget() {
		return $this->research_budget;
	}
	
	function getResearchReward1() {
		return $this->research_reward1;
	}
	
	function getResearchReward2() {
		return $this->research_reward2;
	}
	
	function getResearchISBN() {
		return $this->research_isbn;
	}
	
	function getResearchAbstract() {
		return $this->research_abstract;
	}
	
	function getResearchPicture() {
		return $this->research_picture;
	}
	
	function getResearchFull() {
		return $this->research_full;
	}
	
	function getResearchKeyword1() {
		return $this->research_keyword1;
	}
	
	function getResearchKeyword2() {
		return $this->research_keyword2;
	}
	
	function getResearchKeyword3() {
		return $this->research_keyword3;
	}
	
	function getResearchKeyword4() {
		return $this->research_keyword4;
	}
	
	function getResearchKeyword5() {
		return $this->research_keyword5;
	}
	
	function create($research) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		$year = $research->getResearchYear();
		if ($year == '') { $year = 0;}
		//$start_date = $research->getResearchStartDate();
		//if ($start_date == '') { $start_date = 0;}
		$budget = $research->getResearchBudget();		
		if ($budget == '') { $budget = 0;}
		$isbn = $research->getResearchISBN();
		if ($isbn == '') { $isbn = 0;}
						 		
					  
	   $sql = "INSERT INTO dms_research
			   (research_owner_id , research_owner_name, research_co1_id, research_co2_id, research_co3_id, research_co4_id, research_co5_id,
			    research_name_th, research_name_eng, research_year, research_encourage, research_start_date, research_status, research_budget,
				research_reward1, research_reward2, research_isbn, research_abstract, research_picture, research_full,
				research_keyword1, research_keyword2, research_keyword3, research_keyword4, research_keyword5 
			   )
			   VALUES
			   (".$research->getResearchOwner().", '".$research->getResearchOwnerName()."','".$research->getResearchCo1()."', '".$research->getResearchCo2()."', '".$research->getResearchCo3()."', '".$research->getResearchCo4()."', '".$research->getResearchCo5()."',
				'".$research->getResearchNameTh()."','".$research->getResearchNameEng()."',".$year.",'".$research->getResearchEncourage()."','".$research->getResearchStartDate()."',".$research->getResearchStatus().",".$budget.",
				'".$research->getResearchReward1()."','".$research->getResearchReward2()."',".$isbn.",'".$research->getResearchAbstract()."','".$research->getResearchPicture()."','".$research->getResearchFull()."',
				'".$research->getResearchKeyword1()."','".$research->getResearchKeyword2()."','".$research->getResearchKeyword3()."','".$research->getResearchKeyword4()."','".$research->getResearchKeyword5()."'
			   );";
			   				
		//echo $sql."<br>";			
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   
	   return true;	   			
	}
	
	function SelectAllResearch($uid) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM dms_research WHERE research_owner_id=".$uid." ORDER BY research_name_eng;";
		
		$result = $db->query($sql);
	
		return $result;
	
	}
	
	function ShowTableAll($result,$user,$uistyle,$theme) {
		//echo $result->numRows();
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"std\">"; 
  		echo "<tr>";
   		echo "<td valign=\"top\"> <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<tr align=\"left\" valign=\"middle\">"; 
        //echo "<td width=\"1%\" height=\"2\" bgcolor=\"#9999CC\" background=\"style/".$uistyle."/images/titlegrad.jpg\"><font size=\"2\"><img src=\"./images/BlueBook.gif\" border=\"0\"></font></td>";
		echo "<td width=\"1%\" height=\"2\" bgcolor=\"#9999CC\" background=\"../themes/$theme/images/titlegrad.jpg\"><font size=\"2\"><img src=\"./images/BlueBook.gif\" border=\"0\"></font></td>";
        echo "<td width=\"99%\" height=\"2\" background=\"../themes/$theme/images/titlegrad.jpg\"><font color=\"#FFFFFF\"><strong>Research</strong></font></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td height=\"2\" width=\"1%\"><font size=\"2\">&nbsp;</font></td>";
        echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">Total Research : ".$result->numRows()."</font></td>";
        echo "</tr>";
      	echo "</table>";
      	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"tdborder1\">";
        echo "<tr align=\"center\" class=\"boxcolor\">"; 
        echo "<td width=\"500\" height=\"25\" class=\"BColor\"><strong>".$user->_('Research Name (English)')."</strong></td>";
        echo " <td height=\"25\" width=\"10\" class=\"BColor\"><strong><font size=\"2\">&nbsp;</font></strong></td>";
        echo "<td height=\"25\" width=\"120\" class=\"BColor\"><strong><font size=\"2\">".$user->_('ISBN')."</font></strong></td>";
        echo "<td height=\"25\" width=\"103\" class=\"BColor\"><strong>".$user->_('Year')."</strong></td>";
        echo "<td height=\"25\" width=\"144\" class=\"BColor\"><strong>".$user->_('Budget (THB)')."</strong></td>";
		/*
		echo "<td width=\"500\" height=\"25\" bgcolor=\"#CAE1FF\" class=\"line\"><strong>".$user->_('Research Name (English)')."</strong></td>";
        echo " <td height=\"25\" width=\"10\" bgcolor=\"#E5F2FF\" class=\"line\"><strong><font size=\"2\">&nbsp;</font></strong></td>";
        echo "<td height=\"25\" width=\"120\" bgcolor=\"#E5F2FF\" class=\"line\"><strong><font size=\"2\">".$user->_('ISBN')."</font></strong></td>";
        echo "<td height=\"25\" width=\"103\" bgcolor=\"#E5F2FF\" class=\"line\"><strong>".$user->_('Year')."</strong></td>";
        echo "<td height=\"25\" width=\"144\" bgcolor=\"#E5F2FF\" class=\"line\"><strong>".$user->_('Budget (THB)')."</strong></td>";
		*/
        echo "</tr>";
		while ($rs = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$research_name_eng = $rs["research_name_eng"];
			$research_isbn = $rs["research_isbn"];
			if (strlen($research_isbn) == 0) { $research_isbn = "&nbsp;"; }
			$research_year = $rs["research_year"];
			if ($research_year == '') { $research_year = "&nbsp;"; }
			$research_encourage = $rs["research_encourage"];
			if (strlen($research_encourage) == 0) { $research_encourage = "&nbsp;"; }
			$research_budget = $rs["research_budget"];
			if (strlen($research_budget) == 0) { $research_budget = "&nbsp;"; }
			echo "<tr>";
			echo "<td height=\"25\" bgcolor=\"#FFFFFF\" class=\"line\"><font size=\"2\">&nbsp;<font color=\"#0099CC\">&raquo;</font>&nbsp;";
			echo "<a href=\"./index.php?m=research&a=view&research_id=".$rs["research_id"]."\">".$research_name_eng."</a></font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">&nbsp;</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$research_isbn."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$research_year."</font></td>";
			//echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$research_encourage."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$research_budget."</font></td>";
			echo "</tr>";
		}
		echo "</table></td>";
		echo "</tr>";
		echo "<tr>";
    	echo "<td valign=\"top\">&nbsp;</td>";
   		echo "</tr>";
		echo "</table>";
	
	}
	
	function lookupResearch($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM dms_research WHERE research_id = ".$id.";";
		
		$result = $db->query($sql);

		$rs_research = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$research = Research::createResearchObject($rs_research);

		return $research;
	
	}
	
	function createResearchObject($row) {			
		$id = $row["research_id"];
		$owner = $row["research_owner_id"];
		$owner_name = $row["research_owner_name"];
		$research_co1_name   = $row["research_co1_id"];
		$research_co2_name   = $row["research_co2_id"];
		$research_co3_name   = $row["research_co3_id"];
		$research_co4_name   = $row["research_co4_id"];
		$research_co5_name   = $row["research_co5_id"];
		$research_name_th    = $row["research_name_th"];
		$research_name_eng   = $row["research_name_eng"];
		$research_year       = $row["research_year"];
		$research_encourage  = $row["research_encourage"];
		$research_start_date = $row["research_start_date"];
		$research_status     = $row["research_status"];
		$research_budget     = $row["research_budget"];
		$research_reward1    = $row["research_reward1"];
		$research_reward2    = $row["research_reward2"];
		$research_isbn       = $row["research_isbn"];
		$research_abstract   = $row["research_abstract"];
		$research_picture    = $row["research_picture"];
		$research_full    	 = $row["research_full"];
		$research_keyword1   = $row["research_keyword1"];
		$research_keyword2   = $row["research_keyword2"];
		$research_keyword3   = $row["research_keyword3"];
		$research_keyword4   = $row["research_keyword4"];
		$research_keyword5   = $row["research_keyword5"];
		
		$research = new Research($id, $owner, $owner_name, $research_co1_name, $research_co2_name, $research_co3_name, $research_co4_name, $research_co5_name, 
						$research_name_th, $research_name_eng, $research_year, $research_encourage, $research_start_date, $research_status, $research_budget, 
						$research_reward1, $research_reward2, $research_isbn, $research_abstract, $research_picture, $research_full, 
						$research_keyword1, $research_keyword2, $research_keyword3, $research_keyword4, $research_keyword5
						);
		return $research;
	}
	
	function update($research) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$year = $research->getResearchYear();
		if ($year == '') { $year = 0;}
		$budget = $research->getResearchBudget();		
		if ($budget == '') { $budget = 0;}
		$isbn = $research->getResearchISBN();
		if ($isbn == '') { $isbn = 0;}
		
		$sql = "UPDATE dms_research SET 
			   research_owner_id    = ".$research->getResearchOwner().", 
			   research_owner_name  = '".$research->getResearchOwnerName()."',
			   research_co1_id      = '".$research->getResearchCo1()."', 
			   research_co2_id      = '".$research->getResearchCo2()."', 
			   research_co3_id      = '".$research->getResearchCo3()."', 
			   research_co4_id      = '".$research->getResearchCo4()."', 
			   research_co5_id      = '".$research->getResearchCo5()."', 
			   research_name_th     = '".$research->getResearchNameTh()."', 
			   research_name_eng    = '".$research->getResearchNameEng()."', 
			   research_year  	    = ".$year.", 
			   research_encourage   = '".$research->getResearchEncourage()."', 
			   research_start_date  = '".$research->getResearchStartDate()."', 
			   research_status  	= ".$research->getResearchStatus().", 
			   research_budget  	= ".$budget.", 
			   research_reward1     = '".$research->getResearchReward1()."', 
			   research_reward2     = '".$research->getResearchReward2()."',
			   research_isbn   	    = ".$isbn.",  
			   research_abstract    = '".$research->getResearchAbstract()."', 
			   research_picture     = '".$research->getResearchPicture()."',
			   research_full        = '".$research->getResearchFull()."',
			   research_keyword1    = '".$research->getResearchKeyword1()."',
			   research_keyword2    = '".$research->getResearchKeyword2()."',
			   research_keyword3    = '".$research->getResearchKeyword3()."',
			   research_keyword4    = '".$research->getResearchKeyword4()."',
			   research_keyword5    = '".$research->getResearchKeyword5()."' 
			   WHERE research_id    = ".$research->getResearchId().";";
			   
	   //echo $sql."<br>"; 
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	
	
	function del($research) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "DELETE FROM dms_research WHERE research_id = ".$research->getResearchId().";";
		
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
		
}

?>