<?php 
$thesis = Thesis::lookupThesis($thesis_id);
//echo $thesis->getThesisISBN();
?>
<script language="javascript">
function delIt() {
	if (confirm( "<?php echo $user->_('doDelete').' '.$user->_('Thesis').'?';?>" )) {
		document.frmDelete.submit();
	}
}
</script>
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings =
	'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(mypage,myname,settings)
}
</script>
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td width="50%"> 
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
		<?
		if($thesis->getThesisOwner() == $user->getUserId() || ($user->checkAdmin($user->getUserId()))){
		?>
          <td width="50%"><img src="./images/icon/_edit-16.png" border="0"> <a href="?m=thesis&a=addedit&thesis_id=<? echo $thesis->getThesisId();?>"><? echo $user->_('edit this thesis / independant study');?></a>         
          </td>
		  <?
		  }
		  ?>
          <td width="50%"> 
            <?
		if($thesis->getThesisOwner() == $user->getUserId() || ($user->checkAdmin($user->getUserId()))){
		?>
            <a href="javascript:delIt()"> <img src="./images/icon/_trash_full-16.png" border="0"> 
            </a> <a href="javascript:delIt()"><? echo $user->_('delete thesis / independant study');?></a> 
            <?
		}
	?>
          </td>
        </tr>
      </table>
    </td>
    <td width="50%" align="right"> 
	<?
		if($user->getCategory() == 3){
	?>
      <form name="form1" method="post" action="?m=thesis&a=addedit">
        <input type="submit" name="Submit" value="<?php echo $user->_('new thesis / independant study');?>" class="button">
      </form>
	 <?
	 }
	 ?> 
	  </td>
  </tr>
</table>
<table border="0" cellpadding="4" cellspacing="0" width="100%" class="tdborder1">
<tr>
<td>

</td>


<td>
<form name="frmDelete" action="./index.php?m=thesis" method="post">
	<input type="hidden" name="dosql" value="do_thesis_aed" />
	<input type="hidden" name="del" value="1" />
	<input type="hidden" name="thesis_id" value="<?php echo $thesis_id;?>" />
</form>
</td>
</tr>
<tr>
	<td width="50%" valign="top">		
		<table cellspacing="1" cellpadding="2" border="0" width="100%">
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Name Thai');?>:</td>
          <td class="hilite" width="100%"> 
            <?php echo $thesis->getThesisNameTh();?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Name English');?>:</td>
          <td class="hilite"><?php echo $thesis->getThesisNameEng();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Owner');?>:</td>
          <td class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $thesis->getThesisOwner()?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $thesis->getThesisOwnerName();?></a></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Advisor');?>:</td>
          <td class="hilite"><?php echo $thesis->getThesisAdvisor();?></td>
        </tr>
		<tr> 
          <td align="right" nowrap><?php echo $user->_('Year');?>:</td>
          <td class="hilite"><?php if ($thesis->getThesisYear()==0) { echo "-";} else {echo $thesis->getThesisYear();}?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Encourage');?>:</td>
          <td class="hilite"><?php echo $thesis->getThesisEncourage();?></td>
        </tr>
		<tr>
          <td align="right" nowrap><?php echo $user->_('Type');?>:</td>
          <td class="hilite">
		  <?php if ($thesis->getThesisType() == 1) { echo "Thesis";} else { echo "Independant Study";} ?>
		  </td>
        </tr>
        <tr> 
          <td colspan="2"><hr noshade="noshade" size="1"></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('CoWorker1');?>:</td>
          <td class="hilite"><?php echo $thesis->getThesisCo1();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('CoWorker2');?>:</td>
          <td class="hilite"><?php echo $thesis->getThesisCo2();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('CoWorker3');?>:</td>
          <td class="hilite"><?php echo $thesis->getThesisCo3();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('CoWorker4');?>:</td>
          <td class="hilite"><?php echo $thesis->getThesisCo4();?></td>
        </tr>
        <tr>
          <td align="right" nowrap><?php echo $user->_('CoWorker5');?>:</td>
          <td class="hilite"><?php echo $thesis->getThesisCo5();?></td>
        </tr>
      </table>
	</td>
	<td width="50%" rowspan="9" valign="top">		
		<table cellspacing="1" cellpadding="2" border="0" width="100%">
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Budget');?>:</td>
          <td class="hilite">(THB)<?php if ($thesis->getThesisBudget() == 0) { echo "-";} else { echo " ".$thesis->getThesisBudget();} ?></td>
        </tr>
		<tr> 
          <td align="right" nowrap><?php echo $user->_('Reward1');?>:</td>
          <td class="hilite" width="100%"><?php echo $thesis->getThesisReward1();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Reward2');?>:</td>
          <td class="hilite" width="100%"><?php echo $thesis->getThesisReward2();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('No.');?>:</td>
          <td class="hilite" width="100%"><?php if ($thesis->getThesisNo()==0) { echo "-";} else {echo $thesis->getThesisNo();}?></td>
        </tr>
		<tr> 
          <td align="right" nowrap><?php echo $user->_('ISBN (for Thesis)');?>:</td>
          <td class="hilite" width="100%"><?php if ($thesis->getThesisISBN()==0) { echo "-";} else {echo $thesis->getThesisISBN();}?></td>
        </tr>
        <tr> 
          <td colspan="2"><hr noshade="noshade" size="1"></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword1');?>:</td>
          <td class="hilite"><?php echo $thesis->getThesisKeyword1();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword2');?>:</td>
          <td class="hilite"><?php echo $thesis->getThesisKeyword2();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword3');?>:</td>
          <td class="hilite"><?php echo $thesis->getThesisKeyword3();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword4');?>:</td>
          <td class="hilite"><?php echo $thesis->getThesisKeyword4();?></td>
        </tr>
        <tr>
          <td align="right" nowrap><?php echo $user->_('Keyword5');?>:</td>
          <td class="hilite"><?php echo $thesis->getThesisKeyword5();?></td>
        </tr>
      </table>
      <br />
    </td>
</table>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="50%"><h2><? echo $user->_('Abstract File');?></h2></td>
    <td width="50%" align="right"></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="3" cellspacing="3" class="tdborder1">
    <tr> 
      <td width="100%" valign="top" align="center"> <table cellspacing="1" cellpadding="2" width="60%">
        <tr> 
          <td width="21%" align="right" nowrap="nowrap"><?php echo $user->_( 'File Name' );?>:</td>
          <td width="45%" align="left" class="hilite"><?php echo @$thesis->getThesisAbstract();?></td>
          <td width="34%"> 
		 		<?
				$allpath="../files/dms/thesis/".$thesis->getThesisId();
				if (@$thesis->getThesisAbstract() != "") {
				?>
				<a href="<? echo $allpath."/".@$thesis->getThesisAbstract();?>"><?php echo $user->_( 'download' );?></a> 
				<?
				}
				?>
          </td>
        </tr>
        <tr valign="top"> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
          <td align="left" class="hilite"> 
            <?php 
					$typeFile=@$thesis->getThesisAbstract();		
					$pos = strrpos($typeFile, ".");
					$rest = substr($typeFile, $pos+1);
					//echo $rest;
					if ($rest == "doc") echo "application/msword";
					if ($rest == "pdf") echo "application/pdf";
					
			?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Size' );?>:</td>
          <td align="left" class="hilite"> 
             <?php 
			if (@$thesis->getThesisAbstract() != "") {
			$doc_filesize = filesize($allpath."/".@$thesis->getThesisAbstract());
			if ($doc_filesize != 0) {
				echo GetSize ($doc_filesize);
				} 
			else echo "0 B";
			}
			?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Uploaded By' );?>:</td>
          <td class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $thesis->getThesisOwner()?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $thesis->getThesisOwnerName();?></a></td>
        </tr>       
      </table></td>
    </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="50%"><h2><? echo $user->_('Full File');?></h2></td>
    <td width="50%" align="right"></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="3" cellspacing="3" class="tdborder1">
    <tr> 
      <td width="100%" valign="top" align="center"> <table cellspacing="1" cellpadding="2" width="60%">
        <tr> 
          <td width="21%" align="right" nowrap="nowrap"><?php echo $user->_( 'File Name' );?>:</td>
          <td width="45%" align="left" class="hilite"><?php echo @$thesis->getThesisFull();?></td>
          <td width="34%"> 
		 		<?
				$allpath="../files/dms/full_thesis/".$thesis->getThesisId();
				if (@$thesis->getThesisFull() != "") {
				?>
				<a href="<? echo $allpath."/".@$thesis->getThesisFull();?>"><?php echo $user->_( 'download' );?></a> 
				<?
				}
				?>
          </td>
        </tr>
        <tr valign="top"> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
          <td align="left" class="hilite"> 
            <?php 
					$typeFile=@$thesis->getThesisFull();		
					$pos = strrpos($typeFile, ".");
					$rest = substr($typeFile, $pos+1);
					//echo $rest;
					if ($rest == "doc") echo "application/msword";
					if ($rest == "pdf") echo "application/pdf";
					
			?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Size' );?>:</td>
          <td align="left" class="hilite"> 
             <?php 
			if (@$thesis->getThesisFull() != "") {
			$doc_filesize = filesize($allpath."/".@$thesis->getThesisFull());
			if ($doc_filesize != 0) {
				echo GetSize ($doc_filesize);
				} 
			else echo "0 B";
			}
			?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Uploaded By' );?>:</td>
          <td class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $thesis->getThesisOwner()?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $thesis->getThesisOwnerName();?></a></td>
        </tr>       
      </table></td>
    </tr>
</table>