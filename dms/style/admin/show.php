<?
@include_once( $user->getModuleClass( $realpath, 'research') );
@include_once( $user->getModuleClass( $realpath, 'book') );
@include_once( $user->getModuleClass( $realpath, 'publication') );
$research = new Research('', $user->getUserId(), $user->getFirstName()." ".$user->getLastName(),'', '', '', '', '', 
						'', '', '', '', '', '', 
						'', '', '', '', '', 
						'', '', '', '', ''
						);
$book = new Book('', $user->getUserId(), $user->getFirstName()." ".$user->getLastName(),'', '', '', '', 
				 '', '', '', '', '', '',
				 '', '', '', '', ''
				 );				 
$journal = new Journal('', $user->getUserId(), $user->getFirstName()." ".$user->getLastName(), '', '', '', '',
					   '', '', '', '', '', '', ''
					   );
$proceeding = new Proceeding('', $user->getUserId(), $user->getFirstName()." ".$user->getLastName(), '', '', '', '',
							 '', '', '', '', ''
							 );
$presentation = new Presentation('', $user->getUserId(), $user->getFirstName()." ".$user->getLastName(), '', '', '', '',
								 '', '', '', '', ''
								 );				 						
?>
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"><h1><? echo $user->_('Research List');?></h1></td>    
  </tr>
</table>
<?
		$row = $research->SelectAllResearch($user->getUserId());
		$research->ShowTableAll($row,$user,$uistyle);
?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"><h1><? echo $user->_('Publication List');?></h1></td>    
  </tr>
</table>
<?		
		$row_journal = $journal->SelectAllJournal($user->getUserId());
		$journal->ShowTableJournalAll($row_journal,$user,$uistyle);
		
		$row_proceeding = $proceeding->SelectAllProceeding($user->getUserId());
		$proceeding->ShowTableProceedingAll($row_proceeding,$user,$uistyle);
		
		$row_presentation = $presentation->SelectAllPresentation($user->getUserId());
		$presentation->ShowTablePresentationAll($row_presentation,$user,$uistyle);
?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"><h1><? echo $user->_('Book List');?></h1></td>    
  </tr>
</table>
<?		
		$row = $book->SelectAllBook($user->getUserId());
		$book->ShowTableAll($row,$user,$uistyle);
?>
<br>
