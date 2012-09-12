<script language="javascript">

</script>
<html>
<head>
	<meta name="Version" content="<?php //echo @$AppUI->getConfig( 'version' );?>" />
	<meta http-equiv="Content-Type" content="text/html;charset=tis-620" />
	<title><?php echo @$user->_('M@xLearn');?></title>
	<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />
</head>

<body>
<table cellspacing="0" cellpadding="4" border="0" width="95%" class="std" align="center">
  <tr>
    <td align="center"><b><?php echo $user->_($strSystem_LabImpError);?></b></td>
  </tr>
</table>
<table width="95%"  border="0" cellspacing="0" cellpadding="0" align="center">
		  <tr>
		    <td colspan="3">&nbsp;</td>
  </tr>
<? $file=file("$realpath/system/modules/users/data_noinsert/$file_n","r");
for($i=0;$i<count($file);$i++){
$data=explode(",", $file[$i]);
		 //--------check data
			for($ii=0;$ii<count($data);$ii++){   
				if($data[$ii]==""){							
					$skip=1;			
					$num++;
					$ii=count($data);						
				}else													
					$skip=0;
			}
		
		if($skip==1){ ?>
		  <tr>
			<td width="36%">&nbsp;</td>
		    <td width="16%"><b><? if($data[0] =="") echo $data[2]; else echo $data[0];?></b></td>
		    <td width="48%"><b><?php echo $user->_($strSystem_LabImpEmpty);?></b></td>
		  </tr>
	<? }else { ?>
		  <tr>
			<td width="36%">&nbsp;</td>
		    <td width="16%"><b><? echo $data[0]?></b></td>
		    <td width="48%"><b><?php echo $user->_($strSystem_LabImpAlre);?></b></td>
		  </tr>
	<? }?>  <? }?>
		  <tr>
		    <td colspan="3">&nbsp;</td>
  </tr>
		  <tr>
		    <td colspan="3" align="center"><a href="#" onClick="javascript:window.close();">[ Close ]</a></td>
  		</tr>
	

</table>
</body>
</html>
