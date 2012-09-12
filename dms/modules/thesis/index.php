<?php  
$thesis = new Thesis('', $user->getUserId(), $user->getFirstName()." ".$user->getLastName(), '', '', '', '', '', '', 
						'', '', '', '', '', '','', 
						'', '', '', '', '', '',
						'', '', '', '', ''
						);
?>
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"></td>
    <td width="50%" align="right"><form name="form1" method="post" action="?m=thesis&a=addedit">
        <input type="submit" name="Submit" value="<?php echo $user->_('new thesis / independant study');?>" class="button">
      </form></td>
  </tr>
</table>
<?		
		$row = $thesis->SelectAllThesis($user->getUserId());
		$thesis->ShowTableAll($row,$user,$uistyle,$theme);
?>