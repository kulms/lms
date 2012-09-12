<?php  
$project = new Project('', $user->getUserId(), $user->getFirstName()." ".$user->getLastName(),'', '', '', '', '', '', 
						'', '', '', '', '', '', 
						'', '', '', '', '', '',
						'', '', '', '', ''
						);
?>
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"></td>
    <td width="50%" align="right"><form name="form1" method="post" action="?m=project&a=addedit">
        <input type="submit" name="Submit" value="<?php echo $user->_('new project');?>" class="button">
      </form></td>
  </tr>
</table>
<?		
		$row = $project->SelectAllProject($user->getUserId());
		$project->ShowTableAll($row,$user,$uistyle,$theme);
?>