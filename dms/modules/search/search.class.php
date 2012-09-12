<?php 
/**
 *	@package dms
 *	@subpackage modules
*/

/**
 *	Search Class
 */
require_once("DB.php");
//require_once("../../classes/maxlearn_includes.php");
 
class Search {
	
	function Search(){
	}
	
	function SearchResearch($owner_name, $name_th, $name_eng, $year, $isbn, $keyword, $status, $fac, $dept) 
	{
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		if ($owner_name != '' || $name_th != '' || $name_eng != '' || $year != '' || $isbn != ''
			|| $keyword != '' || $status != 0 || $fac > 0 || $dept > 0) 
		{
			$where = "WHERE d.research_id <> 0";
			if ($owner_name != '') $where .= " AND d.research_owner_name LIKE '%".$owner_name."%'";
			if ($name_th != '')    $where .= " AND d.research_name_th LIKE '%".$name_th."%'";
			if ($name_eng != '')   $where .= " AND d.research_name_eng LIKE '%".$name_eng."%'";
			if ($year != '') 	   $where .= " AND d.research_year = ".$year;
			if ($isbn != '') 	   $where .= " AND d.research_isbn = ".$isbn;
			if ($status != 0) 	   $where .= " AND d.research_status = ".$status;
			if ($keyword != '')    $where .= " AND (d.research_keyword1 LIKE '%".$keyword."%' OR d.research_keyword2 LIKE '%".$keyword."%' 
											   OR d.research_keyword3 LIKE '%".$keyword."%' OR d.research_keyword4 LIKE '%".$keyword."%' 
											   OR d.research_keyword5 LIKE '%".$keyword."%')";
			if ($fac > 0) 	   $where .= " AND u.fac_id = ".$fac;
			if ($dept > 0) 	   $where .= " AND u.dept_id = ".$dept;								   
			
		}
		if (($fac > 0) || ($dept > 0)){
			$sql = "SELECT distinct d.* FROM dms_research d, users u ".$where." AND u.id = d.research_owner_id;";
		} else {
			$sql = "SELECT distinct d.* FROM dms_research d ".$where.";";
		}
		//echo $sql;		
		$result = $db->query($sql);	
		return $result;		
	}
	
	function ShowResearchAll($result,$user,$uistyle,$str,$theme) {
		//echo $result->numRows();
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"std\">"; 
  		echo "<tr>";
   		echo "<td valign=\"top\"> <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<tr align=\"left\" valign=\"middle\">"; 
        echo "<td width=\"1%\" height=\"2\" bgcolor=\"#9999CC\" background=\"../themes/$theme/images/titlegrad.jpg\"><font size=\"2\"><img src=\"./images/BlueBook.gif\" border=\"0\"></font></td>";
        echo "<td width=\"99%\" height=\"2\" background=\"../themes/$theme/images/titlegrad.jpg\"><font color=\"#FFFFFF\"><strong>Research</strong></font></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td height=\"2\" width=\"1%\"><font size=\"2\">&nbsp;</font></td>";
		if (@$result->numRows() != 0) {
        echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">ค้นหาด้วยคำว่า : [".$str."] พบ : ".@$result->numRows()." รายการ</font></td>";
		}
		else 
		{
		echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">Data Not Found</font></td>";
		}
        echo "</tr>";
      	echo "</table>";
      	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Mtable\">";      
		$count = 0;
		while ($rs = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$count++;
			$str = $count.". ";
			$research_owner_name = $rs["research_owner_name"];
			$str .= $research_owner_name;
			if ($rs["research_co1_id"] != "") {
				$research_co1_id = $rs["research_co1_id"];
				$str .= ", ".$research_co1_id;
			}
			if ($rs["research_co2_id"] != "") {
				$research_co2_id = $rs["research_co2_id"];
				$str .= ", ".$research_co2_id;
			}
			if ($rs["research_co3_id"] != "") {
				$research_co3_id = $rs["research_co3_id"];
				$str .= ", ".$research_co3_id;
			}
			if ($rs["research_co4_id"] != "") {
				$research_co4_id = $rs["research_co4_id"];
				$str .= ", ".$research_co4_id;
			}
			if ($rs["research_co5_id"] != "") {
				$research_co5_id = $rs["research_co5_id"];
				$str .= ", ".$research_co5_id;
			}
			
			$strname = "";						
			$research_name_th = $rs["research_name_th"];
			$strname .= " ".$research_name_th." ";
			$research_name_eng = $rs["research_name_eng"];
			$strname .= " ".$research_name_eng." ";
				
			$str_detail = " ";
			if ($rs["research_year"] != '') { 
				$research_year = $rs["research_year"];
				$str_detail .= " ปีที่วิจัย ".$research_year;
			}
						
			if (strlen($rs["research_isbn"]) != 0) { 
				$research_isbn = $rs["research_isbn"];
				$str_detail .= " ISBN:".$research_isbn;
			}						
						
			echo "<tr>";
			echo "<td height=\"25\" bgcolor=\"#FFFFFF\" class=\"line\"><b><font size=\"2\">&nbsp;<font color=\"#0099CC\">&raquo;</font>&nbsp;";
			if ($uistyle != "guest") {
				echo $str."</font></b><font size=\"2\"><i>"."<a href=\"./index.php?m=research&a=view&research_id=".$rs["research_id"]."\">".$strname."</a></i></font>&nbsp;&nbsp;".$str_detail;
			} else {
				echo $str."</font></b><font size=\"2\"><i>"."".$strname."</i></font>&nbsp;&nbsp;".$str_detail;
			}
			if ($rs["research_abstract"] != "") {
				$allpath="../files/dms/research/".$rs["research_id"]."/";
				echo " [ "."<a href=\"".$allpath.$rs["research_abstract"]."\">".$rs["research_abstract"]."</a>"." ]"; 				
			} else {
				echo " [ <font color=\"red\">no file</font> ]";
			}			
			echo "</td>";			
			echo "</tr>";
		}
		echo "</table></td>";
		echo "</tr>";
		echo "</table>";
	
	}		
	
	function SearchBook($owner_name, $name_th, $name_eng, $year, $isbn, $keyword, $fac, $dept) 
	{
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		if ($owner_name != '' || $name_th != '' || $name_eng != '' || $year != '' || $isbn != ''
			|| $keyword != '' || $fac > 0 || $dept > 0) 
		{
			$where = "WHERE d.book_id <> 0";
			if ($owner_name != '') $where .= " AND d.book_owner_name LIKE '%".$owner_name."%'";
			if ($name_th != '')    $where .= " AND d.book_name_th LIKE '%".$name_th."%'";
			if ($name_eng != '')   $where .= " AND d.book_name_eng LIKE '%".$name_eng."%'";
			if ($year != '') 	   $where .= " AND d.book_year = ".$year;
			if ($isbn != '') 	   $where .= " AND d.book_isbn = ".$isbn;
			if ($keyword != '')    $where .= " AND (d.book_keyword1 LIKE '%".$keyword."%' OR d.book_keyword2 LIKE '%".$keyword."%' 
											   OR d.book_keyword3 LIKE '%".$keyword."%' OR d.book_keyword4 LIKE '%".$keyword."%'
											   OR d.book_keyword5 LIKE '%".$keyword."%')";
			if ($fac > 0) 	   $where .= " AND u.fac_id = ".$fac;
			if ($dept > 0) 	   $where .= " AND u.dept_id = ".$dept;								   
								   
			
		}
		//$sql = "SELECT distinct d.* FROM dms_book d, users u ".$where.";";
		if (($fac > 0) || ($dept > 0)){
			$sql = "SELECT distinct d.* FROM dms_book d, users u ".$where." AND u.id = d.book_owner_id;";
		} else {
			$sql = "SELECT distinct d.* FROM dms_book d ".$where.";";
		}
		//echo $sql;		
		$result = $db->query($sql);	
		return $result;		
	}					
	
	function ShowBookAll($result,$user,$uistyle,$str,$theme) {
		//echo @$result->numRows();
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"std\">"; 
  		echo "<tr>";
   		echo "<td valign=\"top\"> <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<tr align=\"left\" valign=\"middle\">"; 
        echo "<td width=\"1%\" height=\"2\" bgcolor=\"#9999CC\" background=\"../themes/$theme/images/titlegrad.jpg\"><font size=\"2\"><img src=\"./images/Books.gif\" border=\"0\"></font></td>";
        echo "<td width=\"99%\" height=\"2\" background=\"../themes/$theme/images/titlegrad.jpg\"><font color=\"#FFFFFF\"><strong>Book</strong></font></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td height=\"2\" width=\"1%\"><font size=\"2\">&nbsp;</font></td>";				
		if (@$result->numRows() != 0) {
        	echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">ค้นหาด้วยคำว่า : [".$str."] พบ : ".@$result->numRows()." รายการ</font></td>";
		} else {
			echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">Data not found !!!!</font></td>";		
		}
        echo "</tr>";
      	echo "</table>";		
      	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Mtable\">";        
		$count = 0;
		while ($rs = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$count++;
			$str = $count.". ";
			$book_owner_name = $rs["book_owner_name"];
			$str .= $book_owner_name;
			
			$strname = "";						
			$book_name_th = $rs["book_name_th"];
			$strname .= " ".$book_name_th." ";
			$book_name_eng = $rs["book_name_eng"];
			$strname .= " ".$book_name_eng." ";			
			/*			
			$book_type = $rs["book_type"];
			switch ($book_type) {
				case 1:
					$book_type = "Text Book";
					break;
				case 2:
					$book_type = "Hand Book";
					break;
				case 3:
					$book_type = "Other Book";
					break;
			}
			*/			
			$str_detail = " ";			
			if ($rs["book_volume"] != '') { 
				$book_volume = $rs["book_volume"];
				$str_detail .= " ฉบับที่ ".$book_volume;
			}			
			if (strlen($rs["book_isbn"]) != 0) { 
				$book_isbn = $rs["book_isbn"];
				$str_detail .= " ISBN:".$book_isbn;
			}			
			if ($rs["book_year"] != '') { 
				$book_year = $rs["book_year"];
				$str_detail .= " ปีที่ ".$book_year;
			}
			
			echo "<tr>";
			echo "<td height=\"25\" bgcolor=\"#FFFFFF\" class=\"line\"><b><font size=\"2\">&nbsp;<font color=\"#0099CC\">&raquo;</font>&nbsp;";
			if ($uistyle != "guest") {
				echo $str."</font></b><font size=\"2\"><i>"."<a href=\"./index.php?m=book&a=view&book_id=".$rs["book_id"]."\">".$strname."</a></i></font>&nbsp;&nbsp;".$str_detail;
			} else {
				echo $str."</font></b><font size=\"2\"><i>"."".$strname."</i></font>&nbsp;&nbsp;".$str_detail;
			}
			if ($rs["book_abstract"] != "") {
				$allpath="../files/dms/book/".$rs["book_id"]."/";
				echo " [ "."<a href=\"".$allpath.$rs["book_abstract"]."\">".$rs["book_abstract"]."</a>"." ]"; 				
			} else {
				echo " [ <font color=\"red\">no file</font> ]";
			}			
			echo "</td>";			
			echo "</tr>";																					
		}
		echo "</table></td>";
		echo "</tr>";
		echo "</table>";
	
	}
	
	function SearchPublication($type,$owner_name,$name_th,$name_eng,$category,$year,$issn,$fac,$dept) 
	{
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		if ($type != '' || $owner_name != '' || $name_th != '' || $name_eng != '' || $category != '' || $year != ''
			|| $issn != '' || $fac > 0 || $dept > 0) 
		{
			$where = "WHERE d.publication_id <> 0";
			if ($owner_name != '') $where .= " AND d.publication_owner_name LIKE '%".$owner_name."%'";
			if ($name_th != '')    $where .= " AND d.publication_name_th LIKE '%".$name_th."%'";
			if ($name_eng != '')   $where .= " AND d.publication_name_eng LIKE '%".$name_eng."%'";
			if ($category != '')   $where .= " AND d.publication_category = ".$category;
			if ($year != '') 	   $where .= " AND d.publication_year = ".$year;
			if ($issn != '') 	   $where .= " AND d.publication_isbn = ".$issn;
			if ($fac > 0) 	   $where .= " AND u.fac_id = ".$fac;
			if ($dept > 0) 	   $where .= " AND u.dept_id = ".$dept;
		}
		
		switch ($type) {
    		case 1:
        		//$sql = "SELECT distinct d.* FROM dms_publication d, users u ".$where." AND d.publication_type = 1;";
				if (($fac > 0) || ($dept > 0)){
					$sql = "SELECT distinct d.* FROM dms_publication d, users u ".$where." AND d.publication_type = 1 AND u.id = d.publication_owner_id;";
				} else {
					$sql = "SELECT distinct d.* FROM dms_publication d ".$where." AND d.publication_type = 1;";
				}
        		break;
    		case 2:
				if (($fac > 0) || ($dept > 0)){
					$sql = "SELECT distinct d.* FROM dms_publication d, users u ".$where." AND d.publication_type = 2 AND u.id = d.publication_owner_id;";
				} else {
					$sql = "SELECT distinct d.* FROM dms_publication d ".$where." AND d.publication_type = 2;";
				}
        		break;
    		case 3:
				if (($fac > 0) || ($dept > 0)){
					$sql = "SELECT distinct d.* FROM dms_publication d, users u ".$where." AND d.publication_type = 3 AND u.id = d.publication_owner_id;";
				} else {
					$sql = "SELECT distinct d.* FROM dms_publication d ".$where." AND d.publication_type = 3;";
				}
        		break;
			default:
				$sql = "SELECT distinct d.* FROM dms_publication d, users u ".$where.";";
        		break;
		}

		//$sql = "SELECT * FROM book ".$where.";";
		//echo $sql;		
		$result = $db->query($sql);	
		return $result;		
	}
	
	function ShowJournalAll($result,$user,$uistyle,$str,$theme) {
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
        echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">ค้นหาด้วยคำว่า : [".$str."] พบ : ".@$result->numRows()." รายการ</font></td>";
        echo "</tr>";
      	echo "</table>";
      	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Mtable\">";
        
		$count = 0;
		while ($rs = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$count++;
			$str = $count.". ";
			$publication_owner_name = $rs["publication_owner_name"];
			$str .= $publication_owner_name;
			
			$strname = "";
			$publication_name_th = $rs["publication_name_th"];
			$strname .= $publication_name_th;
			$publication_name_eng = $rs["publication_name_eng"];
			$strname .= $publication_name_eng;
			
			$str_detail = "";
			if ($rs["publication_topic"] != "") {
				$publication_topic = $rs["publication_topic"];
				$str_detail .= ", ".$publication_topic;
			}
			if ($rs["publication_page_from"] != "") {
				$publication_page_from = $rs["publication_page_from"];
				$str_detail .= " หน้าที่ ".$publication_page_from;
			}
			if ($rs["publication_page_to"] != "") {
				$publication_page_to = $rs["publication_page_to"];
				$str_detail .= " - ".$publication_page_to;
			}			
			if ($rs["publication_city"] != "") {
				$publication_city = $rs["publication_city"];
				$str_detail .= " ".$publication_city;
			}
			if ($rs["publication_country"] != "") {
				$publication_country = $rs["publication_country"];
				$str_detail .= " ".$publication_country;
			}
			
			if ($rs["publication_volume"] != "") {
				$publication_volume = $rs["publication_volume"];
				$str_detail .= " ปีที่ ".$publication_volume;
			}
			if ($rs["publication_number"] != "") {
				$publication_number = $rs["publication_number"];
				$str_detail .= " ฉบับที่ ".$publication_number;
			}
			if ($rs["publication_issn"] != "") {
				$publication_issn = $rs["publication_issn"];
				$str_detail .= " ISSN: ".$publication_issn;
			}
			if ($rs["publication_year"] != "") {
				$publication_year = $rs["publication_year"];
				$str_detail .= " ".$publication_year;
			}
			
			echo "<tr>";
			echo "<td height=\"25\" bgcolor=\"#FFFFFF\" class=\"line\"><b><font size=\"2\">&nbsp;<font color=\"#0099CC\">&raquo;</font>&nbsp;";
			if ($uistyle != "guest") {
				echo $str."</font></b><font size=\"2\"><i>"."<a href=\"./index.php?m=publication&a=view&p=1&publication_id=".$rs["publication_id"]."\">".$strname."</a></i></font>&nbsp;&nbsp;".$str_detail."</td>";			
			} else {
				echo $str."</font></b><font size=\"2\"><i>"."".$strname."</i></font>&nbsp;&nbsp;".$str_detail."</td>";			
			}
			echo "</tr>";
			
		}
		echo "</table></td>";
		echo "</tr>";
		echo "</table>";	
	}
	
	function ShowProceedPresentAll($result,$user,$uistyle,$str,$theme) {
		//echo $result->numRows();
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"std\">"; 
  		echo "<tr>";
   		echo "<td valign=\"top\"> <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<tr align=\"left\" valign=\"middle\">"; 
        echo "<td width=\"1%\" height=\"2\" bgcolor=\"#9999CC\" background=\"../themes/$theme/images/titlegrad.jpg\"><font size=\"2\"><img src=\"./images/Newspaper.gif\" border=\"0\"></font></td>";
        echo "<td width=\"99%\" height=\"2\" background=\"../themes/$theme/images/titlegrad.jpg\"><font color=\"#FFFFFF\"><strong>Proceeding/Presentation</strong></font></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td height=\"2\" width=\"1%\"><font size=\"2\">&nbsp;</font></td>";
        echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">ค้นหาด้วยคำว่า : [".$str."] พบ : ".@$result->numRows()." รายการ</font></td>";
        echo "</tr>";
      	echo "</table>";
      	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Mtable\">";
        
		$count = 0;
		while ($rs = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$count++;
			$str = $count.". ";
			$publication_owner_name = $rs["publication_owner_name"];
			$str .= $publication_owner_name;
			
			$strname = "";
			$publication_name_th = $rs["publication_name_th"];
			$strname .= $publication_name_th;
			$publication_name_eng = $rs["publication_name_eng"];
			$strname .= $publication_name_eng;
			
			$str_detail = "";
			if ($rs["publication_topic"] != "") {
				$publication_topic = $rs["publication_topic"];
				$str_detail .= ", ".$publication_topic;
			}
			if ($rs["publication_date_from"] != "") {
				$publication_date_from = $rs["publication_date_from"];
				$str_detail .= " ระหว่างวันที่ ".$publication_date_from;
			}
			if ($rs["publication_date_to"] != "") {
				$publication_date_to = $rs["publication_date_to"];
				$str_detail .= " - ".$publication_date_to;
			}			
			if ($rs["publication_city"] != "") {
				$publication_city = $rs["publication_city"];
				$str_detail .= " ".$publication_city;
			}
			if ($rs["publication_country"] != "") {
				$publication_country = $rs["publication_country"];
				$str_detail .= " ".$publication_country;
			}
			
			if ($rs["publication_volume"] != "") {
				$publication_volume = $rs["publication_volume"];
				$str_detail .= " ปีที่ ".$publication_volume;
			}
			if ($rs["publication_number"] != "") {
				$publication_number = $rs["publication_number"];
				$str_detail .= " ฉบับที่ ".$publication_number;
			}
			if ($rs["publication_issn"] != "") {
				$publication_issn = $rs["publication_issn"];
				$str_detail .= " ISSN: ".$publication_issn;
			}
			if ($rs["publication_year"] != "") {
				$publication_year = $rs["publication_year"];
				$str_detail .= " ".$publication_year;
			}
			
			echo "<tr>";
			echo "<td height=\"25\" bgcolor=\"#FFFFFF\" class=\"line\"><b><font size=\"2\">&nbsp;<font color=\"#0099CC\">&raquo;</font>&nbsp;";
			if ($uistyle != "guest") {
				echo $str."</font></b><font size=\"2\"><i>"."<a href=\"./index.php?m=publication&a=view&p=1&publication_id=".$rs["publication_id"]."\">".$strname."</a></i></font>&nbsp;&nbsp;".$str_detail."</td>";			
			} else {
				echo $str."</font></b><font size=\"2\"><i>"."".$strname."</i></font>&nbsp;&nbsp;".$str_detail."</td>";
			}	
			echo "</tr>";						
			
		}
		echo "</table></td>";
		echo "</tr>";
		echo "</table>";	
	}
	
	function SearchProject($owner_name, $name_th, $name_eng, $year, $isbn, $keyword,$fac,$dept)
	{
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		if ($owner_name != '' || $name_th != '' || $name_eng != '' || $year != '' || $isbn != ''
			|| $keyword != '' || $fac > 0 || $dept > 0) 
		{
			$where = "WHERE d.project_id <> 0";
			if ($owner_name != '') $where .= " AND d.project_owner_name LIKE '%".$owner_name."%'";
			if ($name_th != '')    $where .= " AND d.project_name_th LIKE '%".$name_th."%'";
			if ($name_eng != '')   $where .= " AND d.project_name_eng LIKE '%".$name_eng."%'";
			if ($year != '') 	   $where .= " AND d.project_year = ".$year;
			if ($isbn != '') 	   $where .= " AND d.project_isbn = ".$isbn;
			if ($keyword != '')    $where .= " AND (d.project_keyword1 LIKE '%".$keyword."%' OR d.project_keyword2 LIKE '%".$keyword."%' 
											   OR d.project_keyword3 LIKE '%".$keyword."%' OR d.project_keyword4 LIKE '%".$keyword."%'
											   OR d.project_keyword5 LIKE '%".$keyword."%')";
			if ($fac > 0) 	   $where .= " AND u.fac_id = ".$fac;
			if ($dept > 0) 	   $where .= " AND u.dept_id = ".$dept;
		}
		if (($fac > 0) || ($dept > 0)){
			$sql = "SELECT distinct d.* FROM dms_project d, users u ".$where." AND u.id = d.project_owner_id;";
		} else {
			$sql = "SELECT distinct d.* FROM dms_project d ".$where.";";
		}
		//echo $sql;		
		$result = $db->query($sql);	
		return $result;		
	}
	
	function ShowProjectAll($result,$user,$uistyle,$str,$theme) {
		//echo $result->numRows();
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"std\">"; 
  		echo "<tr>";
   		echo "<td valign=\"top\"> <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<tr align=\"left\" valign=\"middle\">"; 
        echo "<td width=\"1%\" height=\"2\" bgcolor=\"#9999CC\" background=\"../themes/$theme/images/titlegrad.jpg\"><font size=\"2\"><img src=\"./images/BlueBook.gif\" border=\"0\"></font></td>";
        echo "<td width=\"99%\" height=\"2\" background=\"../themes/$theme/images/titlegrad.jpg\"><font color=\"#FFFFFF\"><strong>Project</strong></font></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td height=\"2\" width=\"1%\"><font size=\"2\">&nbsp;</font></td>";
		if (@$result->numRows() != 0) {
        echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">ค้นหาด้วยคำว่า : [".$str."] พบ : ".@$result->numRows()." รายการ</font></td>";
		}
		else 
		{
		echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">Data Not Found</font></td>";
		}
        echo "</tr>";
      	echo "</table>";
      	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Mtable\">";      
		$count = 0;
		while ($rs = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$count++;
			$str = $count.". ";
			$project_owner_name = $rs["project_owner_name"];
			$str .= $project_owner_name;
			if ($rs["project_co1_id"] != "") {
				$project_co1_id = $rs["project_co1_id"];
				$str .= ", ".$project_co1_id;
			}
			if ($rs["project_co2_id"] != "") {
				$project_co2_id = $rs["project_co2_id"];
				$str .= ", ".$project_co2_id;
			}
			if ($rs["project_co3_id"] != "") {
				$project_co3_id = $rs["project_co3_id"];
				$str .= ", ".$project_co3_id;
			}
			if ($rs["project_co4_id"] != "") {
				$project_co4_id = $rs["project_co4_id"];
				$str .= ", ".$project_co4_id;
			}
			if ($rs["project_co5_id"] != "") {
				$project_co5_id = $rs["project_co5_id"];
				$str .= ", ".$project_co5_id;
			}
			
			$strname = "";						
			$project_name_th = $rs["project_name_th"];
			$strname .= " ".$project_name_th." ";
			$project_name_eng = $rs["project_name_eng"];
			$strname .= " ".$project_name_eng." ";
				
			$str_detail = " ";
			if ($rs["project_year"] != '') { 
				$project_year = $rs["project_year"];
				$str_detail .= " ปีที่จัดทำ ".$project_year;
			}
						
			if (strlen($rs["project_isbn"]) != 0) { 
				$project_isbn = $rs["project_isbn"];
				$str_detail .= " ISBN:".$project_isbn;
			}						
						
			echo "<tr>";
			echo "<td height=\"25\" bgcolor=\"#FFFFFF\" class=\"line\"><b><font size=\"2\">&nbsp;<font color=\"#0099CC\">&raquo;</font>&nbsp;";
			if ($uistyle != "guest") {
				echo $str."</font></b><font size=\"2\"><i>"."<a href=\"./index.php?m=project&a=view&project_id=".$rs["project_id"]."\">".$strname."</a></i></font>&nbsp;&nbsp;".$str_detail;
			} else {
				echo $str."</font></b><font size=\"2\"><i>"."".$strname."</i></font>&nbsp;&nbsp;".$str_detail;
			}
			if ($rs["project_abstract"] != "") {
				$allpath="../files/dms/project/".$rs["project_id"]."/";
				echo " [ "."<a href=\"".$allpath.$rs["project_abstract"]."\">".$rs["project_abstract"]."</a>"." ]"; 				
			} else {
				echo " [ <font color=\"red\">no file</font> ]";
			}			
			echo "</td>";			
			echo "</tr>";
		}
		echo "</table></td>";
		echo "</tr>";
		echo "</table>";
	
	}		

	function SearchThesis($owner_name, $name_th, $name_eng, $year, $isbn, $keyword, $type, $fac, $dept)
	{
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		if ($owner_name != '' || $name_th != '' || $name_eng != '' || $year != '' || $isbn != ''
			|| $keyword != '' || $type != 0 || $fac > 0 || $dept > 0) 
		{
			$where = "WHERE d.thesis_id <> 0";
			if ($owner_name != '') $where .= " AND d.thesis_owner_name LIKE '%".$owner_name."%'";
			if ($name_th != '')    $where .= " AND d.thesis_name_th LIKE '%".$name_th."%'";
			if ($name_eng != '')   $where .= " AND d.thesis_name_eng LIKE '%".$name_eng."%'";
			if ($year != '') 	   $where .= " AND d.thesis_year = ".$year;
			if ($isbn != '') 	   $where .= " AND d.thesis_isbn = ".$isbn;
			if ($type != 0) 	   $where .= " AND d.thesis_type = ".$type;
			if ($keyword != '')    $where .= " AND (d.thesis_keyword1 LIKE '%".$keyword."%' OR d.thesis_keyword2 LIKE '%".$keyword."%' 
											   OR d.thesis_keyword3 LIKE '%".$keyword."%' OR d.thesis_keyword4 LIKE '%".$keyword."%'
											   OR d.thesis_keyword5 LIKE '%".$keyword."%')";
			if ($fac > 0) 	   $where .= " AND u.fac_id = ".$fac;
			if ($dept > 0) 	   $where .= " AND u.dept_id = ".$dept;
		}
		//$sql = "SELECT distinct d.* FROM dms_thesis d, users u ".$where.";";
		if (($fac > 0) || ($dept > 0)){
			$sql = "SELECT distinct d.* FROM dms_thesis d, users u ".$where." AND u.id = d.thesis_owner_id;";
		} else {
			$sql = "SELECT distinct d.* FROM dms_thesis d ".$where.";";
		}

		//echo $sql;		
		$result = $db->query($sql);	
		return $result;		
	}
	
	function ShowThesisAll($result,$user,$uistyle,$str,$theme) {
		//echo $result->numRows();
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"std\">"; 
  		echo "<tr>";
   		echo "<td valign=\"top\"> <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<tr align=\"left\" valign=\"middle\">"; 
        echo "<td width=\"1%\" height=\"2\" bgcolor=\"#9999CC\" background=\"../themes/$theme/images/titlegrad.jpg\"><font size=\"2\"><img src=\"./images/BlueBook.gif\" border=\"0\"></font></td>";
        echo "<td width=\"99%\" height=\"2\" background=\"../themes/$theme/images/titlegrad.jpg\"><font color=\"#FFFFFF\"><strong>Thesis / Independant Study</strong></font></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td height=\"2\" width=\"1%\"><font size=\"2\">&nbsp;</font></td>";
		if (@$result->numRows() != 0) {
        echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">ค้นหาด้วยคำว่า : [".$str."] พบ : ".@$result->numRows()." รายการ</font></td>";
		}
		else 
		{
		echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">Data Not Found</font></td>";
		}
        echo "</tr>";
      	echo "</table>";
      	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Mtable\">";      
		$count = 0;
		while ($rs = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$count++;
			$str = $count.". ";
			$thesis_owner_name = $rs["thesis_owner_name"];
			$str .= $thesis_owner_name;
			if ($rs["thesis_co1_id"] != "") {
				$thesis_co1_id = $rs["thesis_co1_id"];
				$str .= ", ".$thesis_co1_id;
			}
			if ($rs["thesis_co2_id"] != "") {
				$thesis_co2_id = $rs["thesis_co2_id"];
				$str .= ", ".$thesis_co2_id;
			}
			if ($rs["thesis_co3_id"] != "") {
				$thesis_co3_id = $rs["thesis_co3_id"];
				$str .= ", ".$thesis_co3_id;
			}
			if ($rs["thesis_co4_id"] != "") {
				$thesis_co4_id = $rs["thesis_co4_id"];
				$str .= ", ".$thesis_co4_id;
			}
			if ($rs["thesis_co5_id"] != "") {
				$thesis_co5_id = $rs["thesis_co5_id"];
				$str .= ", ".$thesis_co5_id;
			}
			
			$strname = "";						
			$pthesis_name_th = $rs["thesis_name_th"];
			$strname .= " ".$thesis_name_th." ";
			$thesis_name_eng = $rs["thesis_name_eng"];
			$strname .= " ".$thesis_name_eng." ";
				
			$str_detail = " ";
			if ($rs["thesis_year"] != '') { 
				$thesis_year = $rs["thesis_year"];
				$str_detail .= " ปีที่จัดทำ ".$thesis_year;
			}
						
			if (strlen($rs["thesis_isbn"]) != 0) { 
				$thesis_isbn = $rs["thesis_isbn"];
				$str_detail .= " ISBN:".$thesis_isbn;
			}						
						
			echo "<tr>";
			echo "<td height=\"25\" bgcolor=\"#FFFFFF\" class=\"line\"><b><font size=\"2\">&nbsp;<font color=\"#0099CC\">&raquo;</font>&nbsp;";
			if ($uistyle != "guest") {
				echo $str."</font></b><font size=\"2\"><i>"."<a href=\"./index.php?m=thesis&a=view&thesis_id=".$rs["thesis_id"]."\">".$strname."</a></i></font>&nbsp;&nbsp;".$str_detail;
			} else {
				echo $str."</font></b><font size=\"2\"><i>"."".$strname."</i></font>&nbsp;&nbsp;".$str_detail;
			}
			if ($rs["thesis_abstract"] != "") {
				$allpath="../files/dms/thesis/".$rs["thesis_id"]."/";
				echo " [ "."<a href=\"".$allpath.$rs["thesis_abstract"]."\">".$rs["thesis_abstract"]."</a>"." ]"; 				
			} else {
				echo " [ <font color=\"red\">no file</font> ]";
			}			
			echo "</td>";			
			echo "</tr>";
		}
		echo "</table></td>";
		echo "</tr>";
		echo "</table>";
	
	}		

}
?>