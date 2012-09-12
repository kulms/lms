<?php 
/**
 *	@package dms
 *	@subpackage modules
*/

/**
 *	Book Class
 */
require_once("DB.php");
//require_once("../../classes/maxlearn_includes.php");
 
class Book {
	// book id
	var $book_id;
	
	// book owner id
	var $book_owner_id;
	
	// book owner name
	var $book_owner_name;
	
	// book name thai
	var $book_name_th;
	
	// book name eng
	var $book_name_eng;
	
	// book type
	var $book_type;
	
	// book volume
	var $book_volume;
	
	// book press
	var $book_press;
	
	// book press country
	var $book_press_country;
	
	// book year
	var $book_year;
	
	// book abstract
	var $book_abstract;
	
	// book picture
	var $book_picture;

	// book isbn
	var $book_isbn;
		
	// book keyword1
	var $book_keyword1;
	
	// book keyword2
	var $book_keyword2;
	
	// book keyword3
	var $book_keyword3;
	
	// book keyword4
	var $book_keyword4;
	
	// book keyword5
	var $book_keyword5;
	
	function Book($id, $owner_id, $owner_name, $name_th, $name_eng, $type, $volume, 
				  $press, $press_country, $year, $abstract, $picture, $isbn, 
			      $keyword1, $keyword2, $keyword3, $keyword4, $keyword5
			      ) 
	{
		$this->book_id 		 	  = $id;
		$this->book_owner_id 	  = $owner_id;
		$this->book_owner_name 	  = $owner_name;
		$this->book_name_th  	  = $name_th;
		$this->book_name_eng 	  = $name_eng;
		$this->book_type 	 	  = $type;
		$this->book_volume 	 	  = $volume;
		$this->book_press 	 	  = $press;
		$this->book_press_country = $press_country;
		$this->book_year 		  = $year;
		$this->book_abstract 	  = $abstract;
		$this->book_picture 	  = $picture;
		$this->book_isbn 	      = $isbn;
		$this->book_keyword1 	  = $keyword1;
		$this->book_keyword2 	  = $keyword2;
		$this->book_keyword3 	  = $keyword3;
		$this->book_keyword4 	  = $keyword4;
		$this->book_keyword5      = $keyword5;
	}
	
	//function book(){
	//}
	
	function getBookId() {
		return $this->book_id;
	}
	
	function getBookOwner() {
		return $this->book_owner_id;
	}
	
	function getBookOwnerName() {
		return $this->book_owner_name;
	}
		
	function getBookNameTh() {
		return $this->book_name_th;
	}
	
	function getBookNameEng() {
		return $this->book_name_eng;
	}

	function getBookType() {
		return $this->book_type;
	}
	
	function getBookVolume() {
		return $this->book_volume;
	}
	
	function getBookPress() {
		return $this->book_press;
	}

	function getBookPressCountry() {
		return $this->book_press_country;
	}
	
	function getBookYear() {
		return $this->book_year;
	}		
	
	function getBookAbstract() {
		return $this->book_abstract;
	}
	
	function getBookPicture() {
		return $this->book_picture;
	}

	function getBookISBN() {
		return $this->book_isbn;
	}
		
	function getBookKeyword1() {
		return $this->book_keyword1;
	}
	
	function getBookKeyword2() {
		return $this->book_keyword2;
	}
	
	function getBookKeyword3() {
		return $this->book_keyword3;
	}
	
	function getBookKeyword4() {
		return $this->book_keyword4;
	}
	
	function getBookKeyword5() {
		return $this->book_keyword5;
	}
	
	function create($book) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$type = $book->getBookType();
		if ($type == '') { $type = 0;}
		$volume = $book->getBookVolume();
		if ($volume == '') { $volume = 0;}
		$year = $book->getBookYear();
		if ($year == '') { $year = 0;}
		$isbn = $book->getBookISBN();
		if ($isbn == '') { $isbn = 0;}						 		
		
					  
	    $sql = "INSERT INTO dms_book
			   (book_owner_id, book_owner_name ,book_name_th, book_name_eng, book_type, book_volume, 
				book_press, book_press_country, book_year, book_abstract, book_picture, book_isbn, 
				book_keyword1, book_keyword2, book_keyword3, book_keyword4, book_keyword5 
			   )
			   VALUES
			   (".$book->getBookOwner().",'".$book->getBookOwnerName()."','".$book->getBookNameTh()."','".$book->getBookNameEng()."',".$type.",".$volume.",
				'".$book->getBookPress()."', '".$book->getBookPressCountry()."',".$year.",'".$book->getBookAbstract()."','".$book->getBookPicture()."',".$isbn.",
				'".$book->getBookKeyword1()."','".$book->getBookKeyword2()."','".$book->getBookKeyword3()."','".$book->getBookKeyword4()."','".$book->getBookKeyword5()."'
			   );";
			   
		/*
		$sql = "INSERT INTO book
			   (book_owner_id, book_name_th, book_name_eng, book_type, book_volume,
			   book_press, book_press_country
			   )
			   VALUES
			   (".$book->getBookOwner().", '".$book->getBookNameTh()."','".$book->getBookNameEng()."',".$type.",".$volume.",
			   '".$book->getBookPress()."', '".$book->getBookPressCountry()."'
			   );";				
		*/	   
		//echo $sql."<br>";			
				
	    $result = $db->query($sql);
	   
	    if( DB::isError($result) ) {
		   die ($result->getMessage());
		   return false;
	    }	   
	   
	    return true;	   			
	}
	
	function SelectAllBook($uid) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM dms_book WHERE book_owner_id = ".$uid." ORDER BY book_type, book_name_eng;;";
		
		$result = $db->query($sql);
	
		return $result;
	
	}
	
	function ShowTableAll($result,$user,$uistyle,$theme) {
		//echo $result->numRows();
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"std\">"; 
  		echo "<tr>";
   		echo "<td valign=\"top\"> <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        echo "<tr align=\"left\" valign=\"middle\">"; 
        echo "<td width=\"1%\" height=\"2\" bgcolor=\"#9999CC\" background=\"../themes/$theme/images/titlegrad.jpg\"><font size=\"2\"><img src=\"./images/Books.gif\" border=\"0\"></font></td>";
        echo "<td width=\"99%\" height=\"2\" background=\"../themes/$theme/images/titlegrad.jpg\"><font color=\"#FFFFFF\"><strong>Book</strong></font></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td height=\"2\" width=\"1%\"><font size=\"2\">&nbsp;</font></td>";
        echo "<td height=\"20\" width=\"99%\" align=\"left\"><font color=\"#990000\" size=\"2\">Total book : ".$result->numRows()."</font></td>";
        echo "</tr>";
      	echo "</table>";
      	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"tdborder1\">";
        echo "<tr align=\"center\" class=\"boxcolor\">"; 
        echo "<td width=\"384\" height=\"25\"  class=\"BColor\"><strong>".$user->_('Book Name (English)')."</strong></td>";
        echo "<td height=\"25\" width=\"10\" class=\"BColor\"><strong><font size=\"2\">&nbsp;</font></strong></td>";		
        echo "<td height=\"25\" width=\"97\" class=\"BColor\"><strong>".$user->_('Type')."</strong></td>";
        echo "<td height=\"25\" width=\"92\" class=\"BColor\"><strong>".$user->_('ISBN')."</strong></td>";
        echo "<td height=\"25\" width=\"84\" class=\"BColor\"><strong>".$user->_('Year')."</strong></td>";
		echo "<td height=\"25\" width=\"84\" class=\"BColor\"><strong>".$user->_('Volume')."</strong></td>";
		echo "<td height=\"25\" width=\"132\" class=\"BColor\"><strong>".$user->_('Press')."</strong></td>";
        echo "</tr>";
		while ($rs = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$book_name_eng = $rs["book_name_eng"];			
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

			$book_isbn = $rs["book_isbn"];
			if (strlen($book_isbn) == 0) { $book_isbn = "&nbsp;"; }
			$book_year = $rs["book_year"];
			if ($book_year == '') { $book_year = "&nbsp;"; }
			$book_volume = $rs["book_volume"];
			$book_press = $rs["book_press"];
			if ($book_press == '') { $book_press = "&nbsp;"; }
			
			echo "<tr>";
			echo "<td height=\"25\" bgcolor=\"#FFFFFF\" class=\"line\"><font size=\"2\">&nbsp;<font color=\"#0099CC\">&raquo;</font>&nbsp;";
			echo "<a href=\"./index.php?m=book&a=view&book_id=".$rs["book_id"]."\">".$book_name_eng."</a></font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">&nbsp;</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$book_type."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$book_isbn."</font></td>";			
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$book_year."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$book_volume."</font></td>";
			echo "<td height=\"25\" align=\"center\" class=\"line\"><font size=\"2\">".$book_press."</font></td>";
			echo "</tr>";
		}
		echo "</table></td>";
		echo "</tr>";
		echo "<tr>";
    	echo "<td valign=\"top\">&nbsp;</td>";
   		echo "</tr>";
		echo "</table>";
	
	}
	
	function lookupBook($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM dms_book WHERE book_id = ".$id.";";
		
		$result = $db->query($sql);

		$rs_book = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$book = Book::createBookObject($rs_book);

		return $book;
	
	}
	
	function createBookObject($row) {			
		$id = $row["book_id"];
		$owner = $row["book_owner_id"];
		$owner_name = $row["book_owner_name"];
		$book_name_th    = $row["book_name_th"];
		$book_name_eng   = $row["book_name_eng"];
		$book_type       = $row["book_type"];
		$book_volume       = $row["book_volume"];
		$book_press       = $row["book_press"];
		$book_press_country = $row["book_press_country"];
		$book_year       = $row["book_year"];		
		$book_abstract   = $row["book_abstract"];
		$book_picture   = $row["book_picture"];
		$book_isbn       = $row["book_isbn"];
		$book_keyword1   = $row["book_keyword1"];
		$book_keyword2   = $row["book_keyword2"];
		$book_keyword3   = $row["book_keyword3"];
		$book_keyword4   = $row["book_keyword4"];
		$book_keyword5   = $row["book_keyword5"];
		
		$book = new Book($id, $owner, $owner_name, $book_name_th, $book_name_eng, $book_type, $book_volume, 
						$book_press, $book_press_country, $book_year, $book_abstract, $book_picture, $book_isbn, 
						$book_keyword1, $book_keyword2, $book_keyword3, $book_keyword4, $book_keyword5
						);
		return $book;
	}
	
	function update($book) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$type = $book->getBookType();
		if ($type == '') { $type = 0;}
		$volume = $book->getBookVolume();
		if ($volume == '') { $volume = 0;}
		$year = $book->getBookYear();
		if ($year == '') { $year = 0;}		
		$isbn = $book->getBookISBN();
		if ($isbn == '') { $isbn = 0;}				
		
		$sql = "UPDATE dms_book SET 
			   book_owner_id    = ".$book->getBookOwner().", 
			   book_owner_name     = '".$book->getBookOwnerName()."', 
			   book_name_th     = '".$book->getBookNameTh()."', 
			   book_name_eng    = '".$book->getBookNameEng()."', 
			   book_type  	    = ".$type.", 
			   book_volume  	= ".$volume.", 
			   book_press   = '".$book->getBookPress()."', 
			   book_press_country  = '".$book->getBookPressCountry()."', 
			   book_year  	    = ".$year.", 			   
			   book_abstract    = '".$book->getBookAbstract()."', 
			   book_picture    = '".$book->getBookPicture()."', 
			   book_isbn   	    = ".$isbn.",  			   
			   book_keyword1    = '".$book->getBookKeyword1()."',
			   book_keyword2    = '".$book->getBookKeyword2()."',
			   book_keyword3    = '".$book->getBookKeyword3()."',
			   book_keyword4    = '".$book->getBookKeyword4()."',
			   book_keyword5    = '".$book->getBookKeyword5()."' 
			   WHERE book_id    = ".$book->getBookId().";";
			   
	   //echo $sql."<br>"; 
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	
	
	function del($book) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "DELETE FROM dms_book WHERE book_id = ".$book->getBookId().";";
		
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
			   (".$users.", ".$id.",'book', 'insert', ".time().");";
		
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
	   		   (".$owner.", ".$id.",'book', 'del', ".time().");";

		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	
	function log_update($book) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "INSERT INTO dms_log
	   		   (log_users, log_doc_id, log_doc_type, log_action, log_time)
	   		   VALUES
	   		   (".$book->getBookOwner().", ".$book->getBookId().",'book', 'update', ".time().");";

		
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