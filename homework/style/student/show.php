<?
@include_once( $user->getModuleClass( $realpath, 'project') );
@include_once( $user->getModuleClass( $realpath, 'thesis') );

$project = new Project('', $user->getUserId(), '', '', '', '', '', '', 
						'', '', '', '', '', '', 
						'', '', '', '', '', 
						'', '', '', '', ''
						);
						
$thesis  = new Thesis('', $user->getUserId(), '', '', '', '', '', 
						'', '', '', '', '', '', 
						'', '', '', '', '','', 
						'', '', '', '', ''
						);						
					
?>
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"><h1><? echo $user->_('Project List');?></h1></td>    
  </tr>
</table>
<?
		$row = $project->SelectAllProject($user->getUserId());
		$project->ShowTableAll($row,$user,$uistyle);
?>
<br>

<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"><h1><? echo $user->_('Thesis List');?></h1></td>    
  </tr>
</table>
<?
		$row = $thesis->SelectAllThesis($user->getUserId());
		$thesis->ShowTableAll($row,$user,$uistyle);
?>
<br>

