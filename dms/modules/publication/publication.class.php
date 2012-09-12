<?php 
/**
 *	@package dms
 *	@subpackage modules
*/

/**
 *	publication Class
 */
require_once("DB.php");
//require_once("../../classes/maxlearn_includes.php");
 
class Publication {
	// publication id
	var $publication_id;
	
	// publication owner id
	var $publication_owner_id;
	
	// publication owner name
	var $publication_owner_name;
	
	// publication name thai
	var $publication_name_th;
	
	// publication name eng
	var $publication_name_eng;
	
	// publication type
	var $publication_type;
	
	// publication category
	var $publication_category;
	
	
	function Publication($id, $owner_id, $owner_name, $name_th, $name_eng, $type, $category) 
	{
		$this->publication_id = $id;
		$this->publication_owner_id = $owner_id;
		$this->publication_owner_name = $owner_name;
		$this->publication_name_th = $name_th;
		$this->publication_name_eng = $name_eng;
		$this->publication_type = $type;
		$this->publication_category = $category;
	}
	
	//function publication(){
	//}
	
	function getPublicationId() {
		return $this->publication_id;
	}
	
	function getpublicationOwner() {
		return $this->publication_owner_id;
	}		
	
	function getpublicationOwnerName() {
		return $this->publication_owner_name;
	}
	
	function getPublicationNameTh() {
		return $this->publication_name_th;
	}
	
	function getPublicationNameEng() {
		return $this->publication_name_eng;
	}
	
	function getPublicationType() {
		return $this->publication_type;
	}
	
	function getPublicationCategory() {
		return $this->publication_category;
	}	
	/*	
	function create($publication) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
	
		$type = $publication->getPublicationType();
		if ($type == '') { $type = 0;}		
		$category = $publication->getPublicationCategory();
		if ($category == '') { $category = 0;}
						 		
					  
	   $sql = "INSERT INTO publication
			   (publication_owner_id, publication_name_th, publication_name_eng, publication_type
			   )
			   VALUES
			   (".$publication->getPublicationOwner().", 
			   '".$publication->getPublicationNameTh()."','".$publication->getPublicationNameEng()."',".$type.",
			   );";
			   				
		//echo $sql."<br>";			
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   
	   return true;	   			
	}
	*/
	
	/*
	function SelectAllPublication($uid) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM publication WHERE publication_owner_id=".$uid.";";
		
		$result = $db->query($sql);
	
		return $result;
	
	}
	*/
	/*
	function ShowTableAll($result,$user,$uistyle) {
		//echo $result->numRows();
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"std\">"; 
  		echo "<tr>";
   		echo "<td valign=\"top\"> <table width=\"50%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<tr align=\"left\" valign=\"middle\">"; 
        echo "<td width=\"1%\" height=\"2\" bgcolor=\"#9999CC\"><font size=\"2\"><img src=\"./images/publication.gif\" border=\"0\"></font></td>";
        echo "<td width=\"99%\" height=\"2\" background=\"style/".$uistyle."/images/titlegrad.jpg\"><font color=\"#FFFFFF\"><strong>publication</strong></font></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td height=\"2\" width=\"1%\"><font size=\"2\">&nbsp;</font></td>";
        echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">Total publication : ".$result->numRows()."</font></td>";
        echo "</tr>";
      	echo "</table>";
      	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Mtable\">";
        echo "<tr align=\"center\">"; 
        echo "<td width=\"500\" height=\"25\" bgcolor=\"#CAE1FF\" class=\"line\"><strong>".$user->_('publication Name (English)')."</strong></td>";
        echo " <td height=\"25\" width=\"10\" bgcolor=\"#E5F2FF\" class=\"line\"><strong><font size=\"2\">&nbsp;</font></strong></td>";
        echo "<td height=\"25\" width=\"103\" bgcolor=\"#E5F2FF\" class=\"line\"><strong>".$user->_('Type')."</strong></td>";
        echo "</tr>";
		while ($rs = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$publication_name_eng = $rs["publication_name_eng"];
			$publication_type = $rs["publication_type"];
			if ($publication_type == '') { $publication_type = "&nbsp;"; }
			echo "<tr>";
			echo "<td height=\"25\" bgcolor=\"#FFFFFF\" class=\"line\"><font size=\"2\">&nbsp;<font color=\"#0099CC\">&raquo;</font>&nbsp;";
			echo "<a href=\"./index.php?m=publication&a=view&publication_id=".$rs["publication_id"]."\">".$publication_name_eng."</a></font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">&nbsp;</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$publication_type."</font></td>";
			echo "</tr>";
		}
		echo "</table></td>";
		echo "</tr>";
		echo "<tr>";
    	echo "<td valign=\"top\">&nbsp;</td>";
   		echo "</tr>";
		echo "</table>";
	
	}
	*/
	/*
	function lookupPublication($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM publication WHERE publication_id = ".$id.";";
		
		$result = $db->query($sql);

		$rs_publication = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$publication = Publication::createPublicationObject($rs_publication);

		return $publication;
	
	}
	*/
	/*
	function createPublicationObject($row) {			
		$id = $row["publication_id"];
		$owner = $row["publication_owner_id"];
		$publication_name_th    = $row["publication_name_th"];
		$publication_name_eng   = $row["publication_name_eng"];
		$publication_type       = $row["publication_type"];
		
		$publication = new publication($id, $owner, $publication_name_th, $publication_name_eng, $publication_type);
		return $publication;
	}
	*/
	/*
	function update($publication) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$type = $publication->getPublicationType();
		if ($type == '') { $type = 0;}
		
		$sql = "UPDATE publication SET 
			   publication_owner_id    = ".$publication->getPublicationOwner().", 
			   publication_name_th     = '".$publication->getPublicationNameTh()."', 
			   publication_name_eng    = '".$publication->getPublicationNameEng()."', 
			   publication_type  	   = ".$type."
			   WHERE publication_id    = ".$publication->getPublicationId().";";
			   
	   //echo $sql."<br>"; 
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	*/
	
	function del($publication) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "DELETE FROM dms_publication WHERE publication_id = ".$publication->getPublicationId().";";
		
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
			   (".$users.", ".$id.",'publication', 'insert', ".time().");";
		
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
	   		   (".$owner.", ".$id.",'publication', 'del', ".time().");";

		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	
	function log_update($publication) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "INSERT INTO dms_log
	   		   (log_users, log_doc_id, log_doc_type, log_action, log_time)
	   		   VALUES
	   		   (".$publication->getPublicationOwner().", ".$publication->getPublicationId().",'publication', 'update', ".time().");";

		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
		
}

/**
 *	Journal Class extends Publication Class
 */

class Journal extends Publication {		
	// journal press
	var $journal_press;
	
	// journal volume
	var $journal_volume;
	
	// journal number
	var $journal_number;
	
	// journal page from
	var $journal_page_from;
	
	// journal page to
	var $journal_page_to;
	
	// journal year
	var $journal_year;
	
	// journal issn
	var $journal_issn;
	
	function Journal($id, $owner_id, $owner_name, $name_th, $name_eng, $type, $category, $press, $volume, $number, $page_from, $page_to, $year, $issn) 
	{
		Publication::Publication($id, $owner_id, $owner_name, $name_th, $name_eng, $type, $category); 		
		$this->journal_press = $press;
		$this->journal_volume = $volume;
		$this->journal_number = $number;
		$this->journal_page_from = $page_from;
		$this->journal_page_to = $page_to;
		$this->journal_year = $year;
		$this->journal_issn = $issn;
	}
	
	function getJournalPress() {
		return $this->journal_press;
	}
	
	function getJournalVolume() {
		return $this->journal_volume;
	}
	
	function getJournalNumber() {
		return $this->journal_number;
	}
	
	function getJournalPageFrom() {
		return $this->journal_page_from;
	}
	
	function getJournalPageTo() {
		return $this->journal_page_to;
	}
	
	function getJournalYear() {
		return $this->journal_year;
	}
	
	function getJournalISSN() {
		return $this->journal_issn;
	}
	
	
	function create($journal) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
	
		$type = $journal->getPublicationType();
		if ($type == '') { $type = 0;}		
		$category = $journal->getPublicationCategory();
		if ($category == '') { $category = 0;}
		$volume = $journal->getJournalVolume();
		if ($volume == '') { $volume = 0;}
		$number = $journal->getJournalNumber();
		if ($number == '') { $number = 0;}
		$page_from = $journal->getJournalPageFrom();
		if ($page_from == '') { $page_from = 0;}
		$page_to = $journal->getJournalPageTo();
		if ($page_to == '') { $page_to = 0;}
		$year = $journal->getJournalYear();
		if ($year == '') { $year = 0;}
		$issn = $journal->getJournalISSN();
		if ($issn == '') { $issn = 0;}
					  
	   $sql = "INSERT INTO dms_publication
			   (publication_owner_id, publication_owner_name, publication_name_th, publication_name_eng, publication_type, publication_category,
			    publication_press, publication_volume, publication_number, publication_page_from, publication_page_to, 
				publication_year, publication_issn
			   )
			   VALUES
			   (".$journal->getPublicationOwner().", '".$journal->getPublicationOwnerName()."',
			   '".$journal->getPublicationNameTh()."','".$journal->getPublicationNameEng()."',".$type.", ".$category.",
			    '".$journal->getJournalPress()."', ".$volume.", ".$number.", ".$page_from.", ".$page_to.",
			    ".$year.", ".$issn."
			   );";
			   				
		//echo $sql."<br>";			
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   
	   return true;	   			
	}
	
	function SelectAllJournal($uid) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM dms_publication WHERE publication_owner_id=".$uid." AND publication_type = 1 ORDER BY publication_name_eng;";
		
		$result = $db->query($sql);
	
		return $result;
	
	}
	
	function ShowTableJournalAll($result,$user,$uistyle,$theme) {
		//echo $result->numRows();
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"std\">"; 
  		echo "<tr>";
   		echo "<td valign=\"top\"> <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<tr align=\"left\" valign=\"middle\">"; 
		echo "<td width=\"1%\" height=\"2\" bgcolor=\"#9999CC\" background=\"../themes/$theme/images/titlegrad.jpg\"><font size=\"2\"><img src=\"./images/Newspaper.gif\" border=\"0\"></font></td>";
        echo "<td width=\"99%\" height=\"2\" background=\"../themes/$theme/images/titlegrad.jpg\"><font color=\"#FFFFFF\"><strong>Journal</strong></font></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td height=\"2\" width=\"1%\"><font size=\"2\">&nbsp;</font></td>";
        echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">Total Journal : ".$result->numRows()."</font></td>";
        echo "</tr>";
      	echo "</table>";
      	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"tdborder1\">";
        echo "<tr align=\"center\" class=\"boxcolor\">"; 
        echo "<td width=\"500\" height=\"25\" class=\"BColor\"><strong>".$user->_('Journal Name (English)')."</strong></td>";
        echo " <td height=\"25\" width=\"10\" class=\"BColor\"><strong><font size=\"2\">&nbsp;</font></strong></td>";		
        echo "<td height=\"25\" width=\"240\" class=\"BColor\"><strong>".$user->_('Press')."</strong></td>";
		echo "<td height=\"25\" width=\"83\"  class=\"BColor\"><strong>".$user->_('Year')."</strong></td>";
		echo "<td height=\"25\" width=\"68\"  class=\"BColor\"><strong>".$user->_('Volume')."</strong></td>";
		echo "<td height=\"25\" width=\"35\"  class=\"BColor\"><strong>".$user->_('No.')."</strong></td>";
		echo "<td height=\"25\" width=\"75\"  class=\"BColor\"><strong>".$user->_('Page')."</strong></td>";
        echo "</tr>";
		while ($rs = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$publication_name_eng = $rs["publication_name_eng"];
			$publication_type = $rs["publication_type"];
			if ($publication_type == '') { $publication_type = "&nbsp;"; }
			$publication_press = $rs["publication_press"];
			if ($publication_press == '') { $publication_press = "&nbsp;"; }			
			$publication_year = $rs["publication_year"];
			if ($publication_year == '') { $publication_year = "&nbsp;"; }
			$publication_volume = $rs["publication_volume"];
			if ($publication_volume == '') { $publication_volume = "&nbsp;"; }
			$publication_no = $rs["publication_number"];
			if ($publication_no == '') { $publication_no = "&nbsp;"; }
			$publication_page_from = $rs["publication_page_from"];
			if ($publication_page_from == '') { $publication_page_from = "&nbsp;"; }
			$publication_page_to = $rs["publication_page_to"];
			if ($publication_page_to == '') { $publication_page_to = "&nbsp;"; }
			
			echo "<tr>";
			echo "<td height=\"25\" bgcolor=\"#FFFFFF\" class=\"line\"><font size=\"2\">&nbsp;<font color=\"#0099CC\">&raquo;</font>&nbsp;";
			echo "<a href=\"./index.php?m=publication&a=view&p=1&publication_id=".$rs["publication_id"]."\">".$publication_name_eng."</a></font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">&nbsp;</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$publication_press."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$publication_year."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$publication_volume."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$publication_no."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$publication_page_from."-".$publication_page_to."</font></td>";
			echo "</tr>";
			
		}
		echo "</table></td>";
		echo "</tr>";
		echo "<tr>";
    	echo "<td valign=\"top\">&nbsp;</td>";
   		echo "</tr>";
		echo "</table>";	
	}
	
	function lookupJournal($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM dms_publication WHERE publication_id = ".$id.";";
		
		$result = $db->query($sql);

		$rs_journal = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$journal = Journal::createJournalObject($rs_journal);

		return $journal;
	
	}

	function createJournalObject($row) {		
	//Journal($id, $owner_id, $name_th, $name_eng, $type, $category, $volume, $number, $page_from, $page_to, $year, $issn)	
		$id = $row["publication_id"];
		$owner = $row["publication_owner_id"];
		$owner_name = $row["publication_owner_name"];
		$publication_name_th    = $row["publication_name_th"];
		$publication_name_eng   = $row["publication_name_eng"];
		$publication_type       = $row["publication_type"];
		$publication_category   = $row["publication_category"];
		$publication_press      = $row["publication_press"];
		$publication_volume     = $row["publication_volume"];
		$publication_number     = $row["publication_number"];
		$publication_page_from  = $row["publication_page_from"];
		$publication_page_to    = $row["publication_page_to"];		
		$publication_year   = $row["publication_year"];		
		$publication_issn    = $row["publication_issn"];		
		
		$journal = new journal($id, $owner, $owner_name, $publication_name_th, $publication_name_eng, $publication_type, $publication_category, 
							   $publication_press, $publication_volume, $publication_number, $publication_page_from, $publication_page_to, $publication_year, $publication_issn);
		return $journal;
	}
	
	function update($journal) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$type = $journal->getPublicationType();
		if ($type == '') { $type = 0;}
		$category = $journal->getPublicationCategory();
		if ($category == '') { $category = 0;}
		$volume = $journal->getJournalVolume();
		if ($volume == '') { $volume = 0;}
		$number = $journal->getJournalNumber();
		if ($number == '') { $number = 0;}
		$page_from = $journal->getJournalPageFrom();
		if ($page_from == '') { $page_from = 0;}
		$page_to = $journal->getJournalPageTo();
		if ($page_to == '') { $page_to = 0;}
		$year = $journal->getJournalYear();
		if ($year == '') { $year = 0;}
		$issn = $journal->getJournalISSN();
		if ($issn == '') { $issn = 0;}
		
		$sql = "UPDATE dms_publication SET 
			   publication_owner_id    = ".$journal->getPublicationOwner().", 
			   publication_owner_name  = '".$journal->getPublicationOwnerName()."',
			   publication_name_th     = '".$journal->getPublicationNameTh()."', 
			   publication_name_eng    = '".$journal->getPublicationNameEng()."', 
			   publication_type  	   = ".$type.",
			   publication_category    = ".$category.",
			   publication_press       = '".$journal->getJournalPress()."', 
			   publication_volume      = ".$volume.",
			   publication_number      = ".$number.",
			   publication_page_from   = ".$page_from.",
			   publication_page_to     = ".$page_to.",
			   publication_year        = ".$year.",
			   publication_issn        = ".$issn."
			   WHERE publication_id    = ".$journal->getPublicationId().";";
			   
	  // echo $sql."<br>"; 
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}

			
}

/**
 *	Proceeding Class extends Publication Class
 */

class Proceeding extends Publication {
	// proceeding topic
	var $proceeding_topic;
	
	// proceeding city
	var $proceeding_city;
	
	// proceeding country
	var $proceeding_country;
	
	// proceeding date from
	var $proceeding_date_from;
	
	// proceeding date to
	var $proceeding_date_to;
	
	function Proceeding($id, $owner_id, $owner_name, $name_th, $name_eng, $type, $category, $topic, $city, $country, $date_from, $date_to)
	{
		Publication::Publication($id, $owner_id, $owner_name, $name_th, $name_eng, $type, $category); 		
		$this->proceeding_topic = $topic;
		$this->proceeding_city = $city;
		$this->proceeding_country = $country;
		$this->proceeding_date_from = $date_from;
		$this->proceeding_date_to = $date_to;
	}
	
	function getProceedingTopic() {
		return $this->proceeding_topic;
	}
	
	function getProceedingCity() {
		return $this->proceeding_city;
	}
	
	function getProceedingCountry() {
		return $this->proceeding_country;
	}
	
	function getProceedingDateFrom() {
		return $this->proceeding_date_from;
	}
	
	function getProceedingDateTo() {
		return $this->proceeding_date_to;
	}
	
	function create($proceeding) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
	
		$type = $proceeding->getPublicationType();
		if ($type == '') { $type = 0;}		
		$category = $proceeding->getPublicationCategory();
		if ($category == '') { $category = 0;}
					  
	   $sql = "INSERT INTO dms_publication
			   (publication_owner_id, publication_owner_name, publication_name_th, publication_name_eng, publication_type, publication_category,
			    publication_topic, publication_city, publication_country, 
				publication_date_from, publication_date_to
			   )
			   VALUES
			   (".$proceeding->getPublicationOwner().", '".$proceeding->getPublicationOwnerName()."',
			   '".$proceeding->getPublicationNameTh()."','".$proceeding->getPublicationNameEng()."',".$type.", ".$category.",
			    '".$proceeding->getProceedingTopic()."', '".$proceeding->getProceedingCity()."', '".$proceeding->getProceedingCountry()."',
			    '".$proceeding->getProceedingDateFrom()."', '".$proceeding->getProceedingDateTo()."'
			   );";
			   				
		//echo $sql."<br>";			
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   
	   return true;	   			
	}
	
	function SelectAllProceeding($uid) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM dms_publication WHERE publication_owner_id=".$uid." AND publication_type = 2 ORDER BY publication_name_eng;";
		
		$result = $db->query($sql);
	
		return $result;
	
	}
	
	function ShowTableProceedingAll($result,$user,$uistyle,$theme) {
		//echo $result->numRows();
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"std\">"; 
  		echo "<tr>";
   		echo "<td valign=\"top\"> <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<tr align=\"left\" valign=\"middle\">"; 
        echo "<td width=\"1%\" height=\"2\" bgcolor=\"#9999CC\" background=\"../themes/$theme/images/titlegrad.jpg\"><font size=\"2\"><img src=\"./images/Newspaper.gif\" border=\"0\"></font></td>";
        echo "<td width=\"99%\" height=\"2\" background=\"../themes/$theme/images/titlegrad.jpg\"><font color=\"#FFFFFF\"><strong>Proceeding</strong></font></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td height=\"2\" width=\"1%\"><font size=\"2\">&nbsp;</font></td>";
        echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">Total Proceeding : ".$result->numRows()."</font></td>";
        echo "</tr>";
      	echo "</table>";
      	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"tdborder1\">";
        echo "<tr align=\"center\" class=\"boxcolor\">"; 
        echo "<td width=\"380\" height=\"25\"  class=\"BColor\"><strong>".$user->_('Proceeding Name (English)')."</strong></td>";
        echo " <td height=\"25\" width=\"10\"  class=\"BColor\"><strong><font size=\"2\">&nbsp;</font></strong></td>";		
        echo "<td height=\"25\" width=\"200\"  class=\"BColor\"><strong>".$user->_('Topic')."</strong></td>";
		echo "<td height=\"25\" width=\"83\"  class=\"BColor\"><strong>".$user->_('City')."</strong></td>";
		echo "<td height=\"25\" width=\"68\" class=\"BColor\"><strong>".$user->_('Country')."</strong></td>";
        echo "</tr>";
		while ($rs = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$publication_name_eng = $rs["publication_name_eng"];
			$publication_type = $rs["publication_type"];
			if ($publication_type == '') { $publication_type = "&nbsp;"; }
			$publication_topic = $rs["publication_topic"];
			if ($publication_topic == '') { $publication_topic = "&nbsp;"; }
			$publication_city = $rs["publication_city"];
			if ($publication_city == '') { $publication_city = "&nbsp;"; }
			$publication_country = $rs["publication_country"];
			if ($publication_country == '') { $publication_country = "&nbsp;"; }
			$publication_date_from = $rs["publication_date_from"];
			if ($publication_date_from == '') { $publication_date_from = "&nbsp;"; }
			$publication_date_to = $rs["publication_date_to"];
			if ($publication_date_to == '') { $publication_date_to = "&nbsp;"; }
			
			echo "<tr>";
			echo "<td height=\"25\" bgcolor=\"#FFFFFF\" class=\"line\"><font size=\"2\">&nbsp;<font color=\"#0099CC\">&raquo;</font>&nbsp;";
			echo "<a href=\"./index.php?m=publication&a=view&p=2&publication_id=".$rs["publication_id"]."\">".$publication_name_eng."</a></font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">&nbsp;</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$publication_topic."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$publication_city."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$publication_country."</font></td>";
			echo "</tr>";
			
		}
		echo "</table></td>";
		echo "</tr>";
		echo "<tr>";
    	echo "<td valign=\"top\">&nbsp;</td>";
   		echo "</tr>";
		echo "</table>";	
	}

	function lookupProceeding($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM dms_publication WHERE publication_id = ".$id.";";
		
		$result = $db->query($sql);

		$rs_proceeding = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$proceeding = Proceeding::createProceedingObject($rs_proceeding);

		return $proceeding;
	
	}

	function createProceedingObject($row) {		
	//Proceeding($id, $owner_id, $name_th, $name_eng, $type, $category, $topic, $city, $country, $date_from, $date_to)	
		$id = $row["publication_id"];
		$owner = $row["publication_owner_id"];
		$owner_name = $row["publication_owner_name"];
		$publication_name_th    = $row["publication_name_th"];
		$publication_name_eng   = $row["publication_name_eng"];
		$publication_type       = $row["publication_type"];
		$publication_category   = $row["publication_category"];
		$publication_topic     = $row["publication_topic"];
		$publication_city     = $row["publication_city"];
		$publication_country  = $row["publication_country"];
		$publication_date_from    = $row["publication_date_from"];
		$publication_date_to    = $row["publication_date_to"];
		
		$proceeding = new proceeding($id, $owner, $owner_name, $publication_name_th, $publication_name_eng, $publication_type, $publication_category, 
				      $publication_topic, $publication_city, $publication_country, $publication_date_from, $publication_date_to);
		return $proceeding;
	}
	
	function update($proceeding) {
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$type = $proceeding->getPublicationType();
		if ($type == '') { $type = 0;}
		$category = $proceeding->getPublicationCategory();
		if ($category == '') { $category = 0;}
		
		
		$sql = "UPDATE dms_publication SET 
			   publication_owner_id    = ".$proceeding->getPublicationOwner().", 
			   publication_owner_name  = '".$proceeding->getPublicationOwnerName()."',
			   publication_name_th     = '".$proceeding->getPublicationNameTh()."', 
			   publication_name_eng    = '".$proceeding->getPublicationNameEng()."', 
			   publication_category    = ".$category.",
			   publication_topic  	   = '".$proceeding->getProceedingTopic()."', 
			   publication_city        = '".$proceeding->getProceedingCity()."', 
			   publication_country     = '".$proceeding->getProceedingCountry()."', 
			   publication_date_from   = '".$proceeding->getProceedingDateFrom()."', 
			   publication_date_to     = '".$proceeding->getProceedingDateTo()."'
			   WHERE publication_id    = ".$proceeding->getPublicationId().";";
			   
	   //echo $sql."<br>"; 
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}

}

/**
 *	Presentation Class extends Publication Class
 */

class Presentation extends Publication {
	// ppresentation topic
	var $presentation_topic;
	
	// presentation city
	var $presentation_city;
	
	// presentation country
	var $presentation_country;
	
	// presentation date from
	var $presentation_date_from;
	
	// presentation date to
	var $presentation_date_to;
	
	function Presentation($id, $owner_id, $owner_name, $name_th, $name_eng, $type, $category, $topic, $city, $country, $date_from, $date_to)
	{
		Publication::Publication($id, $owner_id, $owner_name, $name_th, $name_eng, $type, $category); 		
		$this->presentation_topic = $topic;
		$this->presentation_city = $city;
		$this->presentation_country = $country;
		$this->presentation_date_from = $date_from;
		$this->presentation_date_to = $date_to;
	}
	
	function getPresentationTopic() {
		return $this->presentation_topic;
	}
	
	function getPresentationCity() {
		return $this->presentation_city;
	}
	
	function getPresentationCountry() {
		return $this->presentation_country;
	}
	
	function getPresentationDateFrom() {
		return $this->presentation_date_from;
	}
	
	function getPresentationDateTo() {
		return $this->presentation_date_to;
	}
	
	function create($presentation) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
	
		$type = $presentation->getPublicationType();
		if ($type == '') { $type = 0;}		
		$category = $presentation->getPublicationCategory();
		if ($category == '') { $category = 0;}
					  
	   $sql = "INSERT INTO dms_publication
			   (publication_owner_id, publication_owner_name, publication_name_th, publication_name_eng, publication_type, publication_category,
			    publication_topic, publication_city, publication_country, 
				publication_date_from, publication_date_to
			   )
			   VALUES
			   (".$presentation->getPublicationOwner().", '".$presentation->getPublicationOwnerName()."',
			   '".$presentation->getPublicationNameTh()."','".$presentation->getPublicationNameEng()."',".$type.", ".$category.",
			    '".$presentation->getPresentationTopic()."', '".$presentation->getPresentationCity()."', '".$presentation->getPresentationCountry()."',
			    '".$presentation->getPresentationDateFrom()."', '".$presentation->getPresentationDateTo()."'
			   );";
			   				
		//echo $sql."<br>";			
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   
	   return true;	   			
	}
	
	function SelectAllPresentation($uid) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM dms_publication WHERE publication_owner_id=".$uid." AND publication_type = 3 ORDER BY publication_name_eng;";
		
		$result = $db->query($sql);
	
		return $result;
	
	}
	
	function ShowTablePresentationAll($result,$user,$uistyle,$theme) {
		//echo $result->numRows();
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"std\">"; 
  		echo "<tr>";
   		echo "<td valign=\"top\"> <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<tr align=\"left\" valign=\"middle\">"; 
        echo "<td width=\"1%\" height=\"2\" bgcolor=\"#9999CC\" background=\"../themes/$theme/images/titlegrad.jpg\"><font size=\"2\"><img src=\"./images/Newspaper.gif\" border=\"0\"></font></td>";
        echo "<td width=\"99%\" height=\"2\" background=\"../themes/$theme/images/titlegrad.jpg\"><font color=\"#FFFFFF\"><strong>Presentation</strong></font></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td height=\"2\" width=\"1%\"><font size=\"2\">&nbsp;</font></td>";
        echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">Total Presentation : ".$result->numRows()."</font></td>";
        echo "</tr>";
      	echo "</table>";
      	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"tdborder1\">";
        echo "<tr align=\"center\" class=\"boxcolor\">"; 
        echo "<td width=\"380\" height=\"25\"  class=\"BColor\"><strong>".$user->_('Presentation Name (English)')."</strong></td>";
        echo " <td height=\"25\" width=\"10\"  class=\"BColor\"><strong><font size=\"2\">&nbsp;</font></strong></td>";		
        echo "<td height=\"25\" width=\"150\"  class=\"BColor\" align=\"center\"><strong>".$user->_('Topic')."</strong></td>";
		echo "<td height=\"25\" width=\"83\" class=\"BColor\"><strong>".$user->_('City')."</strong></td>";
		echo "<td height=\"25\" width=\"68\" class=\"BColor\"><strong>".$user->_('Country')."</strong></td>";
        echo "</tr>";
		while ($rs = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$publication_name_eng = $rs["publication_name_eng"];
			$publication_type = $rs["publication_type"];
			if ($publication_type == '') { $publication_type = "&nbsp;"; }
			$publication_topic = $rs["publication_topic"];
			if ($publication_topic == '') { $publication_topic = "&nbsp;"; }
			$publication_city = $rs["publication_city"];
			if ($publication_city == '') { $publication_city = "&nbsp;"; }
			$publication_country = $rs["publication_country"];
			if ($publication_country == '') { $publication_country = "&nbsp;"; }
			$publication_date_from = $rs["publication_date_from"];
			if ($publication_date_from == '') { $publication_date_from = "&nbsp;"; }
			$publication_date_to = $rs["publication_date_to"];
			if ($publication_date_to == '') { $publication_date_to = "&nbsp;"; }
			
			echo "<tr>";
			echo "<td height=\"25\" bgcolor=\"#FFFFFF\" class=\"line\"><font size=\"2\">&nbsp;<font color=\"#0099CC\">&raquo;</font>&nbsp;";
			echo "<a href=\"./index.php?m=publication&a=view&p=3&publication_id=".$rs["publication_id"]."\">".$publication_name_eng."</a></font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">&nbsp;</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$publication_topic."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$publication_city."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$publication_country."</font></td>";
			echo "</tr>";
			
		}
		echo "</table></td>";
		echo "</tr>";
		echo "<tr>";
    	echo "<td valign=\"top\">&nbsp;</td>";
   		echo "</tr>";
		echo "</table>";	
	}

	function lookupPresentation($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM dms_publication WHERE publication_id = ".$id.";";
		
		$result = $db->query($sql);

		$rs_presentation = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$presentation = Presentation::createPresentationObject($rs_presentation);

		return $presentation;
	
	}

	function createPresentationObject($row) {		
	//Proceeding($id, $owner_id, $name_th, $name_eng, $type, $category, $topic, $city, $country, $date_from, $date_to)	
		$id = $row["publication_id"];
		$owner = $row["publication_owner_id"];
		$owner_name = $row["publication_owner_name"];
		$publication_name_th    = $row["publication_name_th"];
		$publication_name_eng   = $row["publication_name_eng"];
		$publication_type       = $row["publication_type"];
		$publication_category   = $row["publication_category"];
		$publication_topic     = $row["publication_topic"];
		$publication_city     = $row["publication_city"];
		$publication_country  = $row["publication_country"];
		$publication_date_from    = $row["publication_date_from"];
		$publication_date_to    = $row["publication_date_to"];
		
		$presentation = new presentation($id, $owner, $owner_name, $publication_name_th, $publication_name_eng, $publication_type, $publication_category, 
				      $publication_topic, $publication_city, $publication_country, $publication_date_from, $publication_date_to);
		return $presentation;
	}
	
	function update($presentation) {
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$type = $presentation->getPublicationType();
		if ($type == '') { $type = 0;}
		$category = $presentation->getPublicationCategory();
		if ($category == '') { $category = 0;}
		
		
		$sql = "UPDATE dms_publication SET 
			   publication_owner_id    = ".$presentation->getPublicationOwner().", 
			   publication_owner_name  = '".$presentation->getPublicationOwnerName()."',
			   publication_name_th     = '".$presentation->getPublicationNameTh()."', 
			   publication_name_eng    = '".$presentation->getPublicationNameEng()."', 
			   publication_category    = ".$category.",
			   publication_topic  	   = '".$presentation->getPresentationTopic()."', 
			   publication_city        = '".$presentation->getPresentationCity()."', 
			   publication_country     = '".$presentation->getPresentationCountry()."', 
			   publication_date_from   = '".$presentation->getPresentationDateFrom()."', 
			   publication_date_to     = '".$presentation->getPresentationDateTo()."'
			   WHERE publication_id    = ".$presentation->getPublicationId().";";
			   
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