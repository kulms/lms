<?php 
$research = Research::lookupResearch($research_id);
//echo $research->getResearchISBN();
?>
<script language="javascript">
function delIt() {
	if (confirm( "<?php echo $user->_('doDelete').' '.$user->_('Research').'?';?>" )) {
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
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr valign="top"> 
    <td width="50%">
	<table width="50%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
		<?
		if($research->getResearchOwner() == $user->getUserId() || ($user->checkAdmin($user->getUserId()))){
		?>
          <td width="50%"><img src="./images/icon/_edit-16.png" border="0"> <a href="?m=research&a=addedit&research_id=<? echo $research->getResearchId();?>"><? echo $user->_('edit this research');?></a>         
          </td>
		  <?
		  }
		  ?>
          <td width="50%"> 
            <?
		if($research->getResearchOwner() == $user->getUserId() || ($user->checkAdmin($user->getUserId()))){
		?>
            <a href="javascript:delIt()"> <img src="./images/icon/_trash_full-16.png" border="0"> 
            </a> <a href="javascript:delIt()"><? echo $user->_('delete research');?></a> 
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
      <form name="form1" method="post" action="?m=research&a=addedit">
        <input type="submit" name="Submit" value="<?php echo $user->_('new research');?>" class="button">
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
<form name="frmDelete" action="./index.php?m=research" method="post">
	<input type="hidden" name="dosql" value="do_research_aed" />
	<input type="hidden" name="del" value="1" />
	<input type="hidden" name="research_id" value="<?php echo $research_id;?>" />
</form>
</td>
</tr>
<tr>
	<td width="50%" valign="top">		
		<table cellspacing="1" cellpadding="2" border="0" width="100%">
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Research Name Thai');?>:</td>
          <td class="hilite" width="100%"> <?php echo $research->getResearchNameTh();?> 
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Research Name English');?>:</td>
          <td class="hilite"><?php echo $research->getResearchNameEng();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Research Owner');?>:</td>
          <td class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $research->getResearchOwner()?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $research->getResearchOwnerName();?></a></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Research Year');?>:</td>
          <td class="hilite">
            <?php if ($research->getResearchYear()==0) { echo "-";} else {echo $research->getResearchYear();}?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Research Supporting Fund');?>:</td>
          <td class="hilite"><?php echo $research->getResearchEncourage();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Research Start Date');?>:</td>
          <td class="hilite">
            <?php if(strlen($research->getResearchStartDate())==0) { echo "-";} else {echo $research->getResearchStartDate();}?>
          </td>
        </tr>
        <tr>
          <td align="right" nowrap><?php echo $user->_('Research Status');?>:</td>
          <td class="hilite">
		  <?php if ($research->getResearchStatus() == 1) { echo "ยังไม่เสร็จ";} else { echo "เสร็จแล้ว";} ?>
		  </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Research Budget');?>:</td>
          <td class="hilite">(THB)
            <?php if ($research->getResearchBudget() == 0) { echo "-";} else { echo " ".$research->getResearchBudget();} ?>
          </td>
        </tr>
        <tr> 
          <td colspan="2"><hr noshade="noshade" size="1"></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('CoWorker1');?>:</td>
          <td class="hilite"><?php echo $research->getResearchCo1();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('CoWorker2');?>:</td>
          <td class="hilite"><?php echo $research->getResearchCo2();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('CoWorker3');?>:</td>
          <td class="hilite"><?php echo $research->getResearchCo3();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('CoWorker4');?>:</td>
          <td class="hilite"><?php echo $research->getResearchCo4();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('CoWorker5');?>:</td>
          <td class="hilite"><?php echo $research->getResearchCo5();?></td>
        </tr>
      </table>
	</td>
	<td width="50%" rowspan="9" valign="top">		
		<table cellspacing="1" cellpadding="2" border="0" width="100%">
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Research Reward1');?>:</td>
          <td class="hilite" width="100%"><?php echo $research->getResearchReward1();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Research Reward2');?>:</td>
          <td class="hilite" width="100%"><?php echo $research->getResearchReward2();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Research ISBN');?>:</td>
          <td class="hilite" width="100%"><?php if ($research->getResearchISBN()==0) { echo "-";} else {echo $research->getResearchISBN();}?></td>
        </tr>
        <tr> 
          <td colspan="2"><hr noshade="noshade" size="1"></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword1');?>:</td>
          <td class="hilite"><?php echo $research->getResearchKeyword1();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword2');?>:</td>
          <td class="hilite"><?php echo $research->getResearchKeyword2();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword3');?>:</td>
          <td class="hilite"><?php echo $research->getResearchKeyword3();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword4');?>:</td>
          <td class="hilite"><?php echo $research->getResearchKeyword4();?></td>
        </tr>
        <tr>
          <td align="right" nowrap><?php echo $user->_('Keyword5');?>:</td>
          <td class="hilite"><?php echo $research->getResearchKeyword5();?></td>
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
          <td width="45%" align="left" class="hilite"><?php echo @$research->getResearchAbstract();?></td>
          <td width="34%"> 
		 		<?
				$allpath="../files/dms/research/".$research->getResearchId();
				if (@$research->getResearchAbstract() != "") {
				?>
				<a href="<? echo $allpath."/".@$research->getResearchAbstract();?>"><?php echo $user->_( 'download' );?></a> 
				<?
				}
				?>
          </td>
        </tr>
        <tr valign="top"> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
          <td align="left" class="hilite"> 
                <?php 
					$typeFile=@$research->getResearchAbstract();		
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
			if (@$research->getResearchAbstract() != "") {
			$doc_filesize = filesize($allpath."/".@$research->getResearchAbstract());
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
          <td align="left" class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $research->getResearchOwner()?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $research->getResearchOwnerName();?></a></td>
		</tr>       
      </table></td>
    </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="50%"><h2><? echo $user->_('Picture');?></h2></td>
    <td width="50%" align="right"></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="tdborder1">
  <tr> 
    <td width="100%" valign="top" align="center"> <table cellspacing="1" cellpadding="2" width="60%">
        <tr> 
          <td width="21%" align="right" nowrap="nowrap"><?php echo $user->_( 'File Name' );?>:</td>
          <td width="45%" align="left" class="hilite"><?php echo @$research->getResearchPicture();?></td>
          <td width="34%"> 
            <?
				$allpath="../files/dms/picture/".$research->getResearchId();
				if (@$research->getResearchPicture() != "") {
				?>
            <a href="<? echo $allpath."/".@$research->getResearchPicture();?>"><?php echo $user->_( 'download' );?></a> 
            <?
				}
				?>
          </td>
        </tr>
        <tr valign="top"> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
          <td align="left" class="hilite"> 
            <?php //echo $obj->file_type;
					$typeFile=@$research->getResearchPicture();		
					$pos = strrpos($typeFile, ".");
					$rest = substr($typeFile, $pos+1);
					//echo $rest;
					if ($rest == "gif") echo "image/gif";
					if ($rest == "jpg") echo "image/jpg";
					if ($rest == "jpeg") echo "image/jpeg";
					if ($rest == "png") echo "image/png";
					if ($rest == "bmp") echo "image/bmp";
			?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Size' );?>:</td>
          <td align="left" class="hilite"> 
            <?php //echo $obj->file_size;
			if (@$research->getResearchPicture() != "") {
			$doc_filesize = filesize($allpath."/".@$research->getResearchPicture());
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
          <td align="left" class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $research->getResearchOwner()?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $research->getResearchOwnerName();?></a></td>
        </tr>
        <tr>
          <td align="right" nowrap="nowrap">&nbsp;</td>
          <td align="left" class="hilite">
		   <?php			
			if (@$research->getResearchPicture() != "") {				
				$mysock = getimagesize($allpath."/".@$research->getResearchPicture());								
			?>
			<a href="javascript:NewWindow('<? echo $allpath."/".@$research->getResearchPicture();?>','myname','screen.availWidth','screen.availHeight','yes')">			
			<img src="<? echo $allpath."/".@$research->getResearchPicture()?>" <?php echo imageResize($mysock[0], $mysock[1], 350); ?> alt="Click to enlarge." border="0">
			</a>
			<?php	
			}
			?>
		  </td>
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
          <td width="45%" align="left" class="hilite"><?php echo @$research->getResearchFull();?></td>
          <td width="34%"> 
		 		<?
				$allpath="../files/dms/full_research/".$research->getResearchId();
				if (@$research->getResearchFull() != "") {
				?>
				<a href="<? echo $allpath."/".@$research->getResearchFull();?>"><?php echo $user->_( 'download' );?></a> 
				<?
				}
				?>
          </td>
        </tr>
        <tr valign="top"> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
          <td align="left" class="hilite"> 
                <?php 
					$typeFile=@$research->getResearchFull();		
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
			if (@$research->getResearchFull() != "") {
			$doc_filesize = filesize($allpath."/".@$research->getResearchFull());
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
          <td align="left" class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $research->getResearchOwner()?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $research->getResearchOwnerName();?></a></td>
		</tr>       
      </table></td>
    </tr>
</table>
