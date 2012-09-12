<?php 
/**
 *	@package dms
 *	@subpackage modules
*/

/**
 *	Thesis Class
 */
require_once("DB.php");
//require_once("../../classes/maxlearn_includes.php");
 
class Thesis {
	// thesis id
	var $thesis_id;
	
	// thesis owner id
	var $thesis_owner_id;
	
	// thesis owner name
	var $thesis_owner_name;

	// thesis advisor id
	var $thesis_advisor_id;

	// thesis co1
	var $thesis_co1_id;
	
	// thesis co2
	var $thesis_co2_id;
	
	// thesis co3
	var $thesis_co3_id;
	
	// thesis co4
	var $thesis_co4_id;
	
	// thesis co5
	var $thesis_co5_id;
	
	// thesis name thai
	var $thesis_name_th;
	
	// thesis name eng
	var $thesis_name_eng;
	
	// thesis year
	var $thesis_year;
	
	// thesis encourage
	var $thesis_encourage;
	
	// thesis type
	var $thesis_type;
	
	// thesis budget
	var $thesis_budget;
	
	// thesis reward1
	var $thesis_reward1;
	
	// thesis reward2
	var $thesis_reward2;
	
	// thesis no
	var $thesis_no;

	// thesis isbn
	var $thesis_isbn;
	
	// thesis abstract
	var $thesis_abstract;
	
	// thesis picture
	var $thesis_picture;
	
	// thesis full
	var $thesis_full;
	
	// thesis keyword1
	var $thesis_keyword1;
	
	// thesis keyword2
	var $thesis_keyword2;
	
	// thesis keyword3
	var $thesis_keyword3;
	
	// thesis keyword4
	var $thesis_keyword4;
	
	// thesis keyword5
	var $thesis_keyword5;
	
	function Thesis($id, $owner_id, $owner_name, $advisor_id, $co1_id, $co2_id, $co3_id, $co4_id, $co5_id,
					  $name_th, $name_eng, $year, $encourage, $type ,$budget, $reward1, $reward2, $no,
					  $isbn, $abstract, $picture, $full, $keyword1, $keyword2, $keyword3, $keyword4, $keyword5
					  ) 
	{
		$this->thesis_id = $id;
		$this->thesis_owner_id = $owner_id;
		$this->thesis_owner_name = $owner_name;
		$this->thesis_advisor_id = $advisor_id;
		$this->thesis_co1_id = $co1_id;
		$this->thesis_co2_id = $co2_id;
		$this->thesis_co3_id = $co3_id;
		$this->thesis_co4_id = $co4_id;
		$this->thesis_co5_id = $co5_id;
		$this->thesis_name_th = $name_th;
		$this->thesis_name_eng = $name_eng;
		$this->thesis_year = $year;
		$this->thesis_encourage = $encourage;
		$this->thesis_type = $type;
		$this->thesis_budget = $budget;
		$this->thesis_reward1 = $reward1;
		$this->thesis_reward2 = $reward2;
		$this->thesis_no = $no;
		$this->thesis_isbn = $isbn;
		$this->thesis_abstract = $abstract;
		$this->thesis_picture = $picture;
		$this->thesis_full = $full;
		$this->thesis_keyword1 = $keyword1;
		$this->thesis_keyword2 = $keyword2;
		$this->thesis_keyword3 = $keyword3;
		$this->thesis_keyword4 = $keyword4;
		$this->thesis_keyword5 = $keyword5;
	}
	
	//function Thesis(){
	//}
	
	function getThesisId() {
		return $this->thesis_id;
	}
	
	function getThesisOwner() {
		return $this->thesis_owner_id;
	}
	
	function getThesisOwnerName() {
		return $this->thesis_owner_name;
	}
	
	function getThesisAdvisor() {
		return $this->thesis_advisor_id;
	}

	function getThesisCo1() {
		return $this->thesis_co1_id;
	}
	
	function getThesisCo2() {
		return $this->thesis_co2_id;
	}
	
	function getThesisCo3() {
		return $this->thesis_co3_id;
	}
	
	function getThesisCo4() {
		return $this->thesis_co4_id;
	}
	
	function getThesisCo5() {
		return $this->thesis_co5_id;
	}
	
	function getThesisNameTh() {
		return $this->thesis_name_th;
	}
	
	function getThesisNameEng() {
		return $this->thesis_name_eng;
	}
	
	function getThesisYear() {
		return $this->thesis_year;
	}
	
	function getThesisEncourage() {
		return $this->thesis_encourage;
	}
	
	function getThesisType() {
		return $this->thesis_type;
	}
	
	function getThesisBudget() {
		return $this->thesis_budget;
	}
	
	function getThesisReward1() {
		return $this->thesis_reward1;
	}
	
	function getThesisReward2() {
		return $this->thesis_reward2;
	}
	
	function getThesisNo() {
		return $this->thesis_no;
	}
	
	function getThesisISBN() {
		return $this->thesis_isbn;
	}
	
	function getThesisAbstract() {
		return $this->thesis_abstract;
	}
	
	function getThesisPicture() {
		return $this->thesis_picture;
	}
	
	function getThesisFull() {
		return $this->thesis_full;
	}
	
	function getThesisKeyword1() {
		return $this->thesis_keyword1;
	}
	
	function getThesisKeyword2() {
		return $this->thesis_keyword2;
	}
	
	function getThesisKeyword3() {
		return $this->thesis_keyword3;
	}
	
	function getThesisKeyword4() {
		return $this->thesis_keyword4;
	}
	
	function getThesisKeyword5() {
		return $this->thesis_keyword5;
	}
	
	
	function create($thesis) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
				
		$year = $thesis->getThesisYear();
		if ($year == '') { $year = 0;}
		$type = $thesis->getThesisType();
		if ($type == '') { $type = 0;}
		$budget = $thesis->getThesisBudget();		
		if ($budget == '') { $budget = 0;}
		$no = $thesis->getThesisNo();
		if ($no== '') { $no = 0;}
		$isbn = $thesis->getThesisISBN();
		if ($isbn == '') { $isbn = 0;}
						 		
					  
	   $sql = "INSERT INTO dms_thesis
			   (thesis_owner_id , thesis_owner_name, thesis_advisor_id, thesis_co1_id, thesis_co2_id, thesis_co3_id, thesis_co4_id, thesis_co5_id,
			    thesis_name_th, thesis_name_eng, thesis_year, thesis_encourage, thesis_type, thesis_budget,
				thesis_reward1, thesis_reward2, thesis_no, thesis_isbn, thesis_abstract, thesis_picture, thesis_full,
				thesis_keyword1, thesis_keyword2, thesis_keyword3, thesis_keyword4, thesis_keyword5 
			   )
			   VALUES
			   (".$thesis->getThesisOwner().", '".$thesis->getThesisOwnerName()."','".$thesis->getThesisAdvisor()."','".$thesis->getThesisCo1()."', '".$thesis->getThesisCo2()."', '".$thesis->getThesisCo3()."', '".$thesis->getThesisCo4()."', '".$thesis->getThesisCo5()."',
				'".$thesis->getThesisNameTh()."','".$thesis->getThesisNameEng()."',".$year.",'".$thesis->getThesisEncourage()."',".$type.",".$budget.",
				'".$thesis->getThesisReward1()."','".$thesis->getThesisReward2()."',".$no.",".$isbn.",'".$thesis->getThesisAbstract()."','".$thesis->getThesisPicture()."','".$thesis->getThesisFull()."',
				'".$thesis->getThesisKeyword1()."','".$thesis->getThesisKeyword2()."','".$thesis->getThesisKeyword3()."','".$thesis->getThesisKeyword4()."','".$thesis->getThesisKeyword5()."'
			   );";
			   				
		//echo $sql."<br>";			
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   
	   return true;	   			
	}
	
	function SelectAllThesis($uid) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM dms_thesis WHERE thesis_owner_id=".$uid." ORDER BY thesis_name_eng;";
		
		$result = $db->query($sql);
	
		return $result;
	
	}
	
	function ShowTableAll($result,$user,$uistyle,$theme) {
		//echo $result->numRows();
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"std\">"; 
  		echo "<tr>";
   		echo "<td valign=\"top\"> <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<tr align=\"left\" valign=\"middle\">"; 
        echo "<td width=\"1%\" height=\"2\" bgcolor=\"#9999CC\" background=\"../themes/$theme/images/titlegrad.jpg\"><font size=\"2\"><img src=\"./images/thesis.gif\" border=\"0\"></font></td>";
        echo "<td width=\"99%\" height=\"2\" background=\"../themes/$theme/images/titlegrad.jpg\"><font color=\"#FFFFFF\"><strong>Thesis</strong></font></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td height=\"2\" width=\"1%\"><font size=\"2\">&nbsp;</font></td>";
        echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">Total Thesis : ".$result->numRows()."</font></td>";
        echo "</tr>";
      	echo "</table>";
      	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"tdborder1\">";
        echo "<tr align=\"center\" class=\"boxcolor\">"; 
        echo "<td width=\"500\" height=\"25\" class=\"BColor\"><strong>".$user->_('Thesis Name (English)')."</strong></td>";
        echo " <td height=\"25\" width=\"10\" class=\"BColor\"><strong><font size=\"2\">&nbsp;</font></strong></td>";
        echo "<td height=\"25\" width=\"144\" class=\"BColor\"><strong>".$user->_('Advisor')."</strong></td>";
		echo "<td height=\"25\" width=\"103\" class=\"BColor\"><strong>".$user->_('No')."</strong></td>";
		echo "<td height=\"25\" width=\"120\" class=\"BColor\"><strong><font size=\"2\">".$user->_('ISBN')."</font></strong></td>";
        echo "<td height=\"25\" width=\"103\" class=\"BColor\"><strong>".$user->_('Year')."</strong></td>";
        echo "</tr>";
		while ($rs = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$thesis_name_eng = $rs["thesis_name_eng"];
			$thesis_advisor_id = $rs["thesis_advisor_id"];
			$thesis_no = $rs["thesis_no"];
			if (strlen($thesis_no) == 0) { $thesis_no = "&nbsp;"; }
			$thesis_isbn = $rs["thesis_isbn"];
			if (strlen($thesis_isbn) == 0) { $thesis_isbn = "&nbsp;"; }
			$thesis_year = $rs["thesis_year"];
			if ($thesis_year == '') { $thesis_year = "&nbsp;"; }
			$thesis_encourage = $rs["thesis_encourage"];
			if (strlen($thesis_encourage) == 0) { $thesis_encourage = "&nbsp;"; }
			
			echo "<tr>";
			echo "<td height=\"25\" bgcolor=\"#FFFFFF\" class=\"line\"><font size=\"2\">&nbsp;<font color=\"#0099CC\">&raquo;</font>&nbsp;";
			echo "<a href=\"./index.php?m=thesis&a=view&thesis_id=".$rs["thesis_id"]."\">".$thesis_name_eng."</a></font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">&nbsp;</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$thesis_advisor_id."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$thesis_no."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$thesis_isbn."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$thesis_year."</font></td>";
			//echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$thesis_encourage."</font></td>";
			echo "</tr>";
		}
		echo "</table></td>";
		echo "</tr>";
		echo "<tr>";
    	echo "<td valign=\"top\">&nbsp;</td>";
   		echo "</tr>";
		echo "</table>";
	
	}
	
	function lookupThesis($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM dms_thesis WHERE thesis_id = ".$id.";";
		
		$result = $db->query($sql);

		$rs_thesis = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$thesis = Thesis::createThesisObject($rs_thesis);

		return $thesis;
	
	}
	
	function createThesisObject($row) {			
		$id = $row["thesis_id"];
		$owner = $row["thesis_owner_id"];
		$owner_name = $row["thesis_owner_name"];
		$thesis_advisor_name = $row["thesis_advisor_id"];
		$thesis_co1_name     = $row["thesis_co1_id"];
		$thesis_co2_name     = $row["thesis_co2_id"];
		$thesis_co3_name     = $row["thesis_co3_id"];
		$thesis_co4_name     = $row["thesis_co4_id"];
		$thesis_co5_name     = $row["thesis_co5_id"];
		$thesis_name_th      = $row["thesis_name_th"];
		$thesis_name_eng     = $row["thesis_name_eng"];
		$thesis_year         = $row["thesis_year"];
		$thesis_encourage    = $row["thesis_encourage"];
		$thesis_type         = $row["thesis_type"];
		$thesis_budget       = $row["thesis_budget"];
		$thesis_reward1      = $row["thesis_reward1"];
		$thesis_reward2      = $row["thesis_reward2"];
		$thesis_no			 = $row["thesis_no"];
		$thesis_isbn         = $row["thesis_isbn"];
		$thesis_abstract     = $row["thesis_abstract"];
		$thesis_picture      = $row["thesis_picture"];
		$thesis_full         = $row["thesis_full"];
		$thesis_keyword1     = $row["thesis_keyword1"];
		$thesis_keyword2     = $row["thesis_keyword2"];
		$thesis_keyword3     = $row["thesis_keyword3"];
		$thesis_keyword4     = $row["thesis_keyword4"];
		$thesis_keyword5     = $row["thesis_keyword5"];
		
		$thesis = new Thesis($id, $owner, $owner_name, $thesis_advisor_name, $thesis_co1_name, $thesis_co2_name, $thesis_co3_name, $thesis_co4_name, $thesis_co5_name, 
						$thesis_name_th, $thesis_name_eng, $thesis_year, $thesis_encourage, $thesis_type, $thesis_budget, $thesis_reward1, $thesis_reward2, $thesis_no,
						$thesis_isbn, $thesis_abstract, $thesis_picture, $thesis_full, $thesis_keyword1, $thesis_keyword2, $thesis_keyword3, $thesis_keyword4, $thesis_keyword5
						);
		return $thesis;
	}
	
	function update($thesis) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$year = $thesis->getThesisYear();
		if ($year == '') { $year = 0;}
		$type = $thesis->getThesisType();
		if ($type == '') { $type = 0;}
		$budget = $thesis->getThesisBudget();		
		if ($budget == '') { $budget = 0;}
		$no = $thesis->getThesisNo();		
		if ($no == '') { $no = 0;}
		$isbn = $thesis->getThesisISBN();
		if ($isbn == '') { $isbn = 0;}
		
		$sql = "UPDATE dms_thesis SET 
			   thesis_owner_id    = ".$thesis->getThesisOwner().", 
			   thesis_owner_name  = '".$thesis->getThesisOwnerName()."',
			   thesis_advisor_id  = '".$thesis->getThesisAdvisor()."',
			   thesis_co1_id      = '".$thesis->getThesisCo1()."', 
			   thesis_co2_id      = '".$thesis->getThesisCo2()."', 
			   thesis_co3_id      = '".$thesis->getThesisCo3()."', 
			   thesis_co4_id      = '".$thesis->getThesisCo4()."', 
			   thesis_co5_id      = '".$thesis->getThesisCo5()."', 
			   thesis_name_th     = '".$thesis->getThesisNameTh()."', 
			   thesis_name_eng    = '".$thesis->getThesisNameEng()."', 
			   thesis_year  	  = ".$year.", 
			   thesis_encourage   = '".$thesis->getThesisEncourage()."', 
			   thesis_type  	  = ".$thesis->getThesisType().", 
			   thesis_budget  	  = ".$budget.", 
			   thesis_reward1     = '".$thesis->getThesisReward1()."', 
			   thesis_reward2     = '".$thesis->getThesisReward2()."',
			   thesis_no          = ".$no.",
			   thesis_isbn   	  = ".$isbn.",  
			   thesis_abstract    = '".$thesis->getThesisAbstract()."', 
			   thesis_picture     = '".$thesis->getThesisPicture()."',
			   thesis_full        = '".$thesis->getThesisFull()."',
			   thesis_keyword1    = '".$thesis->getThesisKeyword1()."',
			   thesis_keyword2    = '".$thesis->getThesisKeyword2()."',
			   thesis_keyword3    = '".$thesis->getThesisKeyword3()."',
			   thesis_keyword4    = '".$thesis->getThesisKeyword4()."',
			   thesis_keyword5    = '".$thesis->getThesisKeyword5()."' 
			   WHERE thesis_id    = ".$thesis->getThesisId().";";
			   
	   //echo $sql."<br>"; 
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	
	
	function del($thesis) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "DELETE FROM dms_thesis WHERE thesis_id = ".$thesis->getThesisId().";";
		
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
			   (".$users.", ".$id.",'thesis', 'insert', ".time().");";
		
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
	   		   (".$owner.", ".$id.",'thesis', 'del', ".time().");";

		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	
	function log_update($thesis) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "INSERT INTO dms_log
	   		   (log_users, log_doc_id, log_doc_type, log_action, log_time)
	   		   VALUES
	   		   (".$thesis->getThesisOwner().", ".$thesis->getThesisId().",'thesis', 'update', ".time().");";

		
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