<?
@include_once( $user->getModuleClass( $realpath, 'project') );
@include_once( $user->getModuleClass( $realpath, 'thesis') );

$project = new Project('', $user->getUserId(), $user->getFirstName()." ".$user->getLastName(), '', '', '', '', '', '', 
						'', '', '', '', '', '', 
						'', '', '', '', '', '',
						'', '', '', '', ''
						);
						
$thesis  = new Thesis('', $user->getUserId(), $user->getFirstName()." ".$user->getLastName(), '', '', '', '', '', 
						'', '', '', '', '', '', '',
						'', '', '', '', '','', '',
						'', '', '', '', ''
						);						
					


$cutcode=substr(@$user->getLogin(),0,1);
switch($cutcode)
{
case "g":
	?>
		<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />		
		<?
				$row = $thesis->SelectAllThesis($user->getUserId());
				$thesis->ShowTableAll($row,$user,$uistyle,$theme);
		?>
		<br>
	<?
	break;
case "b":			
	?>
		<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
		<?
				$row = $project->SelectAllProject($user->getUserId());
				$project->ShowTableAll($row,$user,$uistyle,$theme);
		?>
		<br>
	<?
	break;
default:
?>
		<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="50%"><h1><? echo $user->_('Project List');?></h1></td>    
		  </tr>
		</table>
		<?
				$row = $project->SelectAllProject($user->getUserId());
				$project->ShowTableAll($row,$user,$uistyle,$theme);
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
				$thesis->ShowTableAll($row,$user,$uistyle,$theme);
		?>
		<br>
<?			
}
?>







