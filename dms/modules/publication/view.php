<?php 
//$research = Research::lookupResearch($research_id);
//echo $research->getResearchISBN();
	switch ($p) {
		case 1:
			//echo "Add Journal";
			$obj = Journal::lookupJournal($publication_id); 
			break;
		case 2:
			//echo "Add Proceeding";
			$obj = Proceeding::lookupProceeding($publication_id);
			break;
		case 3:
			//echo "Add Presentation";
			$obj = Presentation::lookupPresentation($publication_id);
			break;
	}
?>
<script language="javascript">
function delIt() {
	if (confirm( "<?php echo $user->_('doDelete').' '.$user->_('Publication').'?';?>" )) {
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
    <table width="62%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
		<?
		if($obj->getPublicationOwner() == $user->getUserId() || ($user->checkAdmin($user->getUserId()))){
		?>
          <td width="45%"><img src="./images/icon/_edit-16.png" border="0"> <a href="?m=publication&a=addedit&p=<? echo $obj->getPublicationType();?>&publication_id=<? echo $obj->getPublicationId();?>"><? echo $user->_('edit this publication');?></a>
          </td>
		  <?
		  }
		  ?>
          <td width="55%"> 
            <?
		if($obj->getPublicationOwner() == $user->getUserId() || ($user->checkAdmin($user->getUserId()))){
		?>
            <a href="javascript:delIt()"> <img src="./images/icon/_trash_full-16.png" border="0"> 
            </a> <a href="javascript:delIt()"><? echo $user->_('delete publication');?></a> 
            <?
		}
		?>
          </td>
        </tr>
      </table>
	</td>
    <td width="50%" align="right"> 
	<?
		if($user->getCategory() == 2){
	?>
      <form name="form1" method="post" action="?m=publication&a=addedit">
        <input type="submit" name="Submit" value="<?php echo $user->_('new publication');?>" class="button">
      </form>
	 <?
		}
	 ?> 
	  </td>
  </tr>
</table>
<?
switch ($p) {
	case 1:
		//echo "Edit Journal";
		?>
<table border="0" cellpadding="4" cellspacing="0" width="100%" class="tdborder1">
		<tr>
		<td>
		</td>
		<td>
		<form name="frmDelete" action="./index.php?m=publication" method="post">
			<input type="hidden" name="dosql" value="do_publication_aed" />
			<input type="hidden" name="del" value="1" />
			<input type="hidden" name="p" value="<? echo $obj->getPublicationType();?>" />	
			<input type="hidden" name="publication_id" value="<?php echo $publication_id;?>" />
		</form>
		</td>
		</tr>
		<tr>
			<td width="50%" valign="top">		
				<table cellspacing="1" cellpadding="2" border="0" width="100%">
				<tr> 
				  <td align="right" nowrap><?php echo $user->_('Journal Name Thai');?>:</td>
				  <td class="hilite" width="100%"> <?php echo $obj->getPublicationNameTh();?> 
				  </td>
				</tr>
				<tr> 
				  <td align="right" nowrap><?php echo $user->_('Journal Name English');?>:</td>
				  <td class="hilite"><?php echo $obj->getPublicationNameEng();?></td>
				</tr>
				<tr> 
				  <td align="right" nowrap><?php echo $user->_('Journal Owner');?>:</td>
				  <td class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $obj->getPublicationOwner();?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $obj->getPublicationOwnerName();?></a></td>
				</tr>
				<tr> 
				  <td align="right" nowrap="nowrap"><?php echo $user->_('Journal Category');?></td>
				  <td width="100%" class="hilite"> 
				  <?
				  switch ($obj->getPublicationCategory()) {
						case 1:
							echo "International";
							break;
						case 2:
							echo "National";
							break;
						case 3:
							echo "Other";
							break;
					}
				  ?>	
				  </td>
				</tr>
				<tr> 
				  <td align="right" nowrap><?php echo $user->_('Journal Press');?>:</td>
				  <td class="hilite"><?php echo $obj->getJournalPress();?></td>
				</tr>
				<tr> 
				  <td align="right" nowrap><?php echo $user->_('Journal Volume');?>:</td>
				  <td class="hilite"><?php echo $obj->getJournalVolume();?></td>
				</tr>
			  </table>
			</td>
			<td width="50%" rowspan="9" valign="top">		
				<table cellspacing="1" cellpadding="2" border="0" width="100%">
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Journal Number');?></td>
          <td class="hilite"><?php echo $obj->getJournalNumber();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Page From');?></td>
          <td width="100%" class="hilite"><?php echo $obj->getJournalPageFrom();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Page To');?></td>
          <td class="hilite"><?php echo $obj->getJournalPageTo();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Journal Year');?></td>
          <td class="hilite"><?php echo $obj->getJournalYear();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Journal ISSN');?></td>
          <td class="hilite"><?php echo $obj->getJournalISSN();?></td>
        </tr>
      </table>
			  <br />
			</td>
		</table>		
		<?
		break;
	case 2:
		//echo "Edit Proceeding";
		?>
		<table border="0" cellpadding="4" cellspacing="0" width="100%" class="tdborder1">
		<tr>
		<td>
		</td>
		<td>
		<form name="frmDelete" action="./index.php?m=publication" method="post">
			<input type="hidden" name="dosql" value="do_publication_aed" />
			<input type="hidden" name="del" value="1" />
			<input type="hidden" name="p" value="<? echo $obj->getPublicationType();?>" />	
			<input type="hidden" name="publication_id" value="<?php echo $publication_id;?>" />
		</form>
		</td>
		</tr>
		<tr>
			<td width="50%" valign="top">		
				<table cellspacing="1" cellpadding="2" border="0" width="100%">
				<tr> 
				  <td align="right" nowrap><?php echo $user->_('Proceeding Name Thai');?>:</td>
				  <td class="hilite" width="100%"> <?php echo $obj->getPublicationNameTh();?> 
				  </td>
				</tr>
				<tr> 
				  <td align="right" nowrap><?php echo $user->_('Proceeding Name English');?>:</td>
				  <td class="hilite"><?php echo $obj->getPublicationNameEng();?></td>
				</tr>
				<tr> 
				  <td align="right" nowrap><?php echo $user->_('Proceeding Owner');?>:</td>
				  <td class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $obj->getPublicationOwner();?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $obj->getPublicationOwnerName();?></a></td>
				</tr>
				<tr> 
				  <td align="right" nowrap="nowrap"><?php echo $user->_('Proceeding Category');?></td>
				  <td width="100%" class="hilite"> 
				  <?
				  switch ($obj->getPublicationCategory()) {
						case 1:
							echo "International";
							break;
						case 2:
							echo "National";
							break;
						case 3:
							echo "Other";
							break;
					}
				  ?>	
				  </td>
				</tr>
				<tr> 
				  <td align="right" nowrap><?php echo $user->_('Proceeding Date From');?>:</td>
				  <td class="hilite"><?php echo $obj->getProceedingDateFrom();?></td>
				</tr>
				<tr> 
				  <td align="right" nowrap><?php echo $user->_('Proceeding Date To');?>:</td>
				  <td class="hilite"><?php echo $obj->getProceedingDateTo();?></td>
				</tr>
			  </table>
			</td>
			<td width="50%" rowspan="9" valign="top">		
				<table cellspacing="1" cellpadding="2" border="0" width="100%">
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Proceeding Topic');?></td>
          <td width="100%" class="hilite"><?php echo $obj->getProceedingTopic();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Proceeding City');?></td>
          <td class="hilite"><?php echo $obj->getProceedingCity();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Proceeding Country');?></td>
          <td class="hilite"><?php echo $obj->getProceedingCountry();?></td>
        </tr>
      </table>
			  <br />
			</td>
		</table>
		
<?		
		break;
	case 3:
		//echo "Edit Presentation";
		?>
<table border="0" cellpadding="4" cellspacing="0" width="100%" class="tdborder1">
  <tr> 
    <td> </td>
    <td> <form name="frmDelete" action="./index.php?m=publication" method="post">
        <input type="hidden" name="dosql" value="do_publication_aed" />
        <input type="hidden" name="del" value="1" />
        <input type="hidden" name="p" value="<? echo $obj->getPublicationType();?>" />
        <input type="hidden" name="publication_id" value="<?php echo $publication_id;?>" />
      </form></td>
  </tr>
  <tr> 
    <td width="50%" valign="top"> <table cellspacing="1" cellpadding="2" border="0" width="100%">
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Presentation Name Thai');?>:</td>
          <td class="hilite" width="100%"> <?php echo $obj->getPublicationNameTh();?> 
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Presentation Name English');?>:</td>
          <td class="hilite"><?php echo $obj->getPublicationNameEng();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Presentation Owner');?>:</td>
          <td class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $obj->getPublicationOwner();?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $obj->getPublicationOwnerName();?></a></td>
        </tr>
        <tr> 
          <td align="right" nowrap="nowrap"><?php echo $user->_('Presentation Category');?></td>
          <td width="100%" class="hilite"> 
            <?
				  switch ($obj->getPublicationCategory()) {
						case 1:
							echo "International";
							break;
						case 2:
							echo "National";
							break;
						case 3:
							echo "Other";
							break;
					}
				  ?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Presentation Date From');?>:</td>
          <td class="hilite"><?php echo $obj->getPresentationDateFrom();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Presentation Date To');?>:</td>
          <td class="hilite"><?php echo $obj->getPresentationDateTo();?></td>
        </tr>
      </table></td>
    <td width="50%" rowspan="9" valign="top"> <table cellspacing="1" cellpadding="2" border="0" width="100%">
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Presentation Topic');?></td>
          <td width="100%" class="hilite"><?php echo $obj->getPresentationTopic();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Presentation City');?></td>
          <td class="hilite"><?php echo $obj->getPresentationCity();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Presentation Country');?></td>
          <td class="hilite"><?php echo $obj->getPresentationCountry();?></td>
        </tr>
      </table>
      <br /> </td>
</table>
<?
		break;
}
?>
