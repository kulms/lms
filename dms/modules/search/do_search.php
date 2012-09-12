<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<?php 
@include_once( $user->getModuleClass( $realpath, 'search') );

if ($search_type == 'book'){	
	$search = new Search();			 
	$row = $search->SearchBook($book_owner_name,$book_name_th,$book_name_eng,$book_year,$book_isbn,$book_keyword,$fac,$dept);
	$str = $book_owner_name." ".$book_name_th." ".$book_name_eng." ".$book_year." ".$book_isbn." ".$book_keyword;
	$search->ShowBookAll($row,$user,$uistyle,$str,$theme);			 			 
}

if ($search_type == 'research'){	
	$search = new Search();			 
	$row = $search->SearchResearch($research_owner_name,$research_name_th,$research_name_eng,$research_year,$research_isbn,$research_keyword,$research_status,$fac,$dept);
	if ($research_status == 1) {
		$status_str = "ยังไม่เสร็จ";
	} else {
		if ($research_status == 2) {
			$status_str = "เสร็จแล้ว";
		}
	}
	$str = $research_owner_name." ".$research_name_th." ".$research_name_eng." ".$research_year." ".$research_isbn." ".$research_keyword." ".$status_str;
	$search->ShowResearchAll($row,$user,$uistyle,$str,$theme);	 			 			 
}

if ($search_type == 'project'){	
	$search = new Search();			 
	$row = $search->SearchProject($project_owner_name,$project_name_th,$project_name_eng,$project_year,$project_isbn,$project_keyword,$fac,$dept);
	$str = $project_owner_name." ".$project_name_th." ".$project_name_eng." ".$project_year." ".$project_isbn." ".$project_keyword;
	$search->ShowProjectAll($row,$user,$uistyle,$str,$theme);	 			 			 
}

if ($search_type == 'thesis'){	
	$search = new Search();			 
	$row = $search->SearchThesis($thesis_owner_name,$thesis_name_th,$thesis_name_eng,$thesis_year,$thesis_isbn,$thesis_keyword,$thesis_type,$fac,$dept);
	if ($thesis_type == 1) {
		$type_str = "Thesis";
	} else {
		if ($thesis_type == 2) {
			$type_str = "Independant Study";
		}
	}
	$str = $thesis_owner_name." ".$thesis_name_th." ".$thesis_name_eng." ".$thesis_year." ".$thesis_isbn." ".$thesis_keyword." ".$type_str;
	$search->ShowThesisAll($row,$user,$uistyle,$str,$theme);	 			 			 
}

if ($search_type == 'publication'){	
	$search = new Search();
				 
	$row = $search->SearchPublication($type,$owner_name,$name_th,$name_eng,$category,$year,$issn,$fac,$dept);
	$str = "";
	switch ($type) {    
    case 1:
        $str .= "Journal";
        break;
    case 2:
        $str .= "Proceeding";
        break;
	case 3:
        $str .= "Presentation";
		break;	
	}
	
	switch ($category) {    
    case 1:
        $category = "International";
        break;
    case 2:
        $category = "National";
        break;
	case 3:
        $category = "Other";
		break;	
	}
	
	
	$str .= " ".$owner_name." ".$name_th." ".$name_eng." ".$category." ".$year." ".$issn;
	
	if ($type == 1) {
	$search->ShowJournalAll($row,$user,$uistyle,$str,$theme);			 			 
	}
	else
	{
	$search->ShowProceedPresentAll($row,$user,$uistyle,$str,$theme);			 			 
	}
}
if ($search_type == 'all'){	
	$search = new Search();
	
	$str = "";
	$row = $search->SearchResearch($owner_name,$name_th,$name_eng,$year,'',$keyword,'',$fac,$dept);	
	$str = $owner_name." ".$name_th." ".$name_eng." ".$year." ".$keyword." ";
	if(@$row->numRows() != 0){
		$search->ShowResearchAll($row,$user,$uistyle,$str,$theme);	 
		echo "<br>";	
	}
	if (strlen($keyword)==0) {
		$str = "";
		$row = $search->SearchPublication(1,$owner_name,$name_th,$name_eng,1,$year,'',$fac,$dept);
		$str .= " ".$owner_name." ".$name_th." ".$name_eng." "."International"." ".$year;
		if(@$row->numRows() != 0){
			$search->ShowJournalAll($row,$user,$uistyle,$str,$theme);
			echo "<br>";			 			 			
		}
		
		$str = "";
		$row = $search->SearchPublication(1,$owner_name,$name_th,$name_eng,2,$year,'',$fac,$dept);
		$str .= " ".$owner_name." ".$name_th." ".$name_eng." "."National"." ".$year;
		if(@$row->numRows() != 0){
			$search->ShowJournalAll($row,$user,$uistyle,$str,$theme);			 			 			
			echo "<br>";
		}
	
		$str = "";
		$row = $search->SearchPublication(1,$owner_name,$name_th,$name_eng,3,$year,'',$fac,$dept);
		$str .= " ".$owner_name." ".$name_th." ".$name_eng." "."Other"." ".$year;
		if(@$row->numRows() != 0){
			$search->ShowJournalAll($row,$user,$uistyle,$str,$theme);			 			 			
			echo "<br>";
		}
		
		$str = "";
		$row = $search->SearchPublication(2,$owner_name,$name_th,$name_eng,1,$year,'',$fac,$dept);
		$str .= " ".$owner_name." ".$name_th." ".$name_eng." "."International"." ".$year;
		if(@$row->numRows() != 0){
			$search->ShowProceedPresentAll($row,$user,$uistyle,$str,$theme);			 			 
			echo "<br>";
		}
		
		$str = "";
		$row = $search->SearchPublication(2,$owner_name,$name_th,$name_eng,2,$year,'',$fac,$dept);
		$str .= " ".$owner_name." ".$name_th." ".$name_eng." "."National"." ".$year;
		if(@$row->numRows() != 0){
			$search->ShowProceedPresentAll($row,$user,$uistyle,$str,$theme);
			echo "<br>";
		}
		
		$str = "";
		$row = $search->SearchPublication(2,$owner_name,$name_th,$name_eng,3,$year,'',$fac,$dept);
		$str .= " ".$owner_name." ".$name_th." ".$name_eng." "."Other"." ".$year;
		if(@$row->numRows() != 0){
			$search->ShowProceedPresentAll($row,$user,$uistyle,$str,$theme);
			echo "<br>";
		}
		
		$str = "";
		$row = $search->SearchPublication(3,$owner_name,$name_th,$name_eng,1,$year,'',$fac,$dept);
		$str .= " ".$owner_name." ".$name_th." ".$name_eng." "."International"." ".$year;
		if(@$row->numRows() != 0){
			$search->ShowProceedPresentAll($row,$user,$uistyle,$str,$theme);			 			 
			echo "<br>";
		}
		
		$str = "";
		$row = $search->SearchPublication(3,$owner_name,$name_th,$name_eng,2,$year,'',$fac,$dept);
		$str .= " ".$owner_name." ".$name_th." ".$name_eng." "."National"." ".$year;
		if(@$row->numRows() != 0){
			$search->ShowProceedPresentAll($row,$user,$uistyle,$str,$theme);
			echo "<br>";
		}
		
		$str = "";
		$row = $search->SearchPublication(3,$owner_name,$name_th,$name_eng,3,$year,'',$fac,$dept);
		$str .= " ".$owner_name." ".$name_th." ".$name_eng." "."Other"." ".$year;
		if(@$row->numRows() != 0){
			$search->ShowProceedPresentAll($row,$user,$uistyle,$str,$theme);
			echo "<br>";
		}
	}
	$str = ""; 
	$row = $search->SearchBook($owner_name,$name_th,$name_eng,$year,'',$keyword,$fac,$dept);
	$str = $owner_name." ".$name_th." ".$name_eng." ".$year." ".$keyword;
	if(@$row->numRows() != 0){
		$search->ShowBookAll($row,$user,$uistyle,$str,$theme);
		echo "<br>";
	}
	
	$row = $search->SearchThesis($owner_name,$name_th,$name_eng,$year,'',$keyword,1,$fac,$dept);	
	$type_str = "Thesis";
	$str = $owner_name." ".$name_th." ".$name_eng." ".$year." ".$keyword." ".$type_str;
	if(@$row->numRows() != 0){
		$search->ShowThesisAll($row,$user,$uistyle,$str,$theme);
		echo "<br>";
	}
	
	$row = $search->SearchThesis($owner_name,$name_th,$name_eng,$year,'',$keyword,2,$fac,$dept);	
	$type_str = "Independant Study";
	$str = $owner_name." ".$name_th." ".$name_eng." ".$year." ".$keyword." ".$type_str;
	if(@$row->numRows() != 0){
		$search->ShowThesisAll($row,$user,$uistyle,$str,$theme);
		echo "<br>";
	}
	
	$row = $search->SearchProject($owner_name,$name_th,$name_eng,$year,'',$keyword,$fac,$dept);
	$str = $owner_name." ".$name_th." ".$name_eng." ".$year." ".$keyword;
	if(@$row->numRows() != 0){
		$search->ShowProjectAll($row,$user,$uistyle,$str,$theme);	 
	}			 			 
}

?>
