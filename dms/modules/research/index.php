<?php  
$research = new Research('', $user->getUserId(), $user->getFirstName()." ".$user->getLastName(), '', '', '', '', '', 
						'', '', '', '', '', '', '',
						'', '', '', '', '', '',
						'', '', '', '', ''
						);
?>
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%">&nbsp;</td>
    <td width="50%" align="right"><form name="form1" method="post" action="?m=research&a=addedit">
        <input type="submit" name="Submit" value="<?php echo $user->_('new research');?>" class="button">
      </form></td>
  </tr>
</table>
<?		
		$row = $research->SelectAllResearch($user->getUserId());
		$research->ShowTableAll($row,$user,$uistyle,$theme);
?>
