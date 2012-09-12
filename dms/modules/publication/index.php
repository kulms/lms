<?php  

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
    <td width="50%"></td>
    <td width="50%" align="right">
	  <form name="form1" method="post" action="?m=publication&a=addedit">
        <input type="submit" name="Submit" value="<?php echo $user->_('new publication');?>" class="button">
      </form>
	</td>
  </tr>
</table>
<?		
		//$row = $research->SelectAllResearch($user->getUserId());
		//$research->ShowTableAll($row,$user,$uistyle);
		$row_journal = $journal->SelectAllJournal($user->getUserId());
		$journal->ShowTableJournalAll($row_journal,$user,$uistyle,$theme);
		
		$row_proceeding = $proceeding->SelectAllProceeding($user->getUserId());
		$proceeding->ShowTableProceedingAll($row_proceeding,$user,$uistyle,$theme);
		
		$row_presentation = $presentation->SelectAllPresentation($user->getUserId());
		$presentation->ShowTablePresentationAll($row_presentation,$user,$uistyle,$theme);
		
?>