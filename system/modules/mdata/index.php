<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />
<link rel="stylesheet" type="text/css" href="./themes/red/style/main.css" >!-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="45%">	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="11%"><img src="./modules/mdata/images/my_master.png" border="0"></td>
			<td width="89%"><h1><?php echo $user->_($strSystem_LabMaster);?></h1></td>
		  </tr>
		</table>
	</td>	
	<td align="left" nowrap width="45%">

	</td>
  </tr>  
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="7%">&nbsp;</td>
    <td width="93%">&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="./modules/mdata/images/my_sub_master.png" border="0"></td>
        </tr>
      </table></td>
    <td><h2><?php echo $user->_($strSystem_LabAcademicData);?></h2></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td><a href="?m=mdata&a=insert_fac"><?php echo $user->_($strSystem_LabAcademic);?></a></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="7%">&nbsp;</td>
    <td width="93%">&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td ><a href="?m=mdata&a=eval&m1=eval"><img src="./modules/mdata/images/eval.gif" border="0"></a></td>
        </tr>
      </table></td>
    <td><h2><?php echo $user->_($strSystem_LabEvaluationData);?></h2></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td><a href="?m=mdata&a=index&m1=eval"><?php echo $user->_($strSystem_LabEvaluation);?></a></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>