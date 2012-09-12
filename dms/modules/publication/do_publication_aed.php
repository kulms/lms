<?php 

if ($publication_id == ''){
	switch ($p) {
				case 1:
					$journal = new Journal('', $user->getUserId(), $user->getTitle().$user->getFirstName()." ".$user->getLastName(), $journal_name_th, $journal_name_eng, $p, $journal_category,
									$journal_press, $journal_volume, $journal_number, $journal_page_from, $journal_page_to, $journal_year, $journal_issn
									);
					$journal->create($journal);
					$id = mysql_insert_id();	
					$journal->log_insert($id, $user->getUserId());
					break;
				case 2:
					$proceeding = new Proceeding('', $user->getUserId(), $user->getTitle().$user->getFirstName()." ".$user->getLastName(), $proceeding_name_th, $proceeding_name_eng, $p, $proceeding_category,
										$proceeding_topic, $proceeding_city, $proceeding_country, $proceeding_date_from, $proceeding_date_to
									);
					$proceeding->create($proceeding);
					$id = mysql_insert_id();	
					$proceeding->log_insert($id, $user->getUserId());
					break;
				case 3:
					$presentation = new Presentation('', $user->getUserId(), $user->getTitle().$user->getFirstName()." ".$user->getLastName(), $presentation_name_th, $presentation_name_eng, $p, $presentation_category,
										$presentation_topic, $presentation_city, $presentation_country, $presentation_date_from, $presentation_date_to
									);
					$presentation->create($presentation);
					$id = mysql_insert_id();	
					$presentation->log_insert($id, $user->getUserId());
					break;
	}
} else {
	/*
	$research = new Research($research_id, $user->getUserId(), $research_co1_name, $research_co2_name, $research_co3_name, $research_co4_name, $research_co5_name, 
						$research_name_th, $research_name_eng, $research_year, $research_encourage, $research_start_date, $research_budget, 
						$research_reward1, $research_reward2, $research_isbn, $research_abstract, $research_picture, 
						$research_keyword1, $research_keyword2, $research_keyword3, $research_keyword4, $research_keyword5
						);
	*/
	//echo $research->getResearchId()."<br>";
	switch ($p) {
				case 1:
					$obj = new Journal($publication_id, $journal_owner_id, $journal_owner_name, $journal_name_th, $journal_name_eng, $p, $journal_category,
									$journal_press, $journal_volume, $journal_number, $journal_page_from, $journal_page_to, $journal_year, $journal_issn
									);
					//$journal->create($journal);
					break;
				case 2:
					$obj = new Proceeding($publication_id, $proceeding_owner_id, $proceeding_owner_name, $proceeding_name_th, $proceeding_name_eng, $p, $proceeding_category,
										$proceeding_topic, $proceeding_city, $proceeding_country, $proceeding_date_from, $proceeding_date_to
									);
					//$proceeding->create($proceeding);
					break;
				case 3:
					$obj = new Presentation($publication_id, $presentation_owner_id, $presentation_owner_name, $presentation_name_th, $presentation_name_eng, $p, $presentation_category,
										$presentation_topic, $presentation_city, $presentation_country, $presentation_date_from, $presentation_date_to
									);
					//$presentation->create($presentation);
					break;
	}
	if ($del == 1) {
		//echo "del record";
		$id = $obj->getPublicationId();
		$owner = $user->getUserId();
		
		$obj->del($obj);
		$obj->log_del($id,$owner);
	} else {
		$obj->update($obj);
		$obj->log_update($obj);
		//echo "edit record";	
		   }
}	


?>
