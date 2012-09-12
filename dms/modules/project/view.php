<?php 
$project = Project::lookupProject($project_id);
//echo $project->getProjectISBN();
?>
<script language="javascript">
function delIt() {
	if (confirm( "<?php echo $user->_('doDelete').' '.$user->_('Project').'?';?>" )) {
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
	<table width="50%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
		<?
		if($project->getProjectOwner() == $user->getUserId() || ($user->checkAdmin($user->getUserId()))){
		?>
          <td width="50%"><img src="./images/icon/_edit-16.png" border="0"> <a href="?m=project&a=addedit&project_id=<? echo $project->getProjectId();?>"><? echo $user->_('edit this project');?></a>
          </td>
		  <?
		  }
		  ?>
          <td width="50%"> 
            <?
		if($project->getProjectOwner() == $user->getUserId() || ($user->checkAdmin($user->getUserId()))){
		?>
            <a href="javascript:delIt()"> <img src="./images/icon/_trash_full-16.png" border="0"> 
            </a> <a href="javascript:delIt()"><? echo $user->_('delete project');?></a> 
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
      <form name="form1" method="post" action="?m=project&a=addedit">
        <input type="submit" name="Submit" value="<?php echo $user->_('new project');?>" class="button">
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
<form name="frmDelete" action="./index.php?m=project" method="post">
	<input type="hidden" name="dosql" value="do_project_aed" />
	<input type="hidden" name="del" value="1" />
	<input type="hidden" name="project_id" value="<?php echo $project_id;?>" />
</form>
</td>
</tr>
<tr>
	<td width="50%" valign="top">		
		<table cellspacing="1" cellpadding="2" border="0" width="100%">
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Project Name Thai');?>:</td>
          <td class="hilite" width="100%"> 
            <?php echo $project->getProjectNameTh();?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Project Name English');?>:</td>
          <td class="hilite"><?php echo $project->getProjectNameEng();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Project Owner');?>:</td>
          <td class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $project->getProjectOwner()?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $project->getProjectOwnerName();?></a></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Project Advisor');?>:</td>
          <td class="hilite"><?php echo $project->getProjectAdvisor();?></td>
        </tr>
		<tr> 
          <td align="right" nowrap><?php echo $user->_('Project Year');?>:</td>
          <td class="hilite"><?php if ($project->getProjectYear()==0) { echo "-";} else {echo $project->getProjectYear();}?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Project Encourage');?>:</td>
          <td class="hilite"><?php echo $project->getProjectEncourage();?></td>
        </tr>
        <tr> 
          <td colspan="2"><hr noshade="noshade" size="1"></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('CoWorker1');?>:</td>
          <td class="hilite"><?php echo $project->getProjectCo1();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('CoWorker2');?>:</td>
          <td class="hilite"><?php echo $project->getProjectCo2();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('CoWorker3');?>:</td>
          <td class="hilite"><?php echo $project->getProjectCo3();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('CoWorker4');?>:</td>
          <td class="hilite"><?php echo $project->getProjectCo4();?></td>
        </tr>
        <tr>
          <td align="right" nowrap><?php echo $user->_('CoWorker5');?>:</td>
          <td class="hilite"><?php echo $project->getProjectCo5();?></td>
        </tr>
      </table>
	</td>
	<td width="50%" rowspan="9" valign="top">		
		<table cellspacing="1" cellpadding="2" border="0" width="100%">
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Project Budget');?>:</td>
          <td class="hilite">(THB)<?php if ($project->getProjectBudget() == 0) { echo "-";} else { echo " ".$project->getProjectBudget();} ?></td>
        </tr>
		<tr> 
          <td align="right" nowrap><?php echo $user->_('Project Reward1');?>:</td>
          <td class="hilite" width="100%"><?php echo $project->getProjectReward1();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Project Reward2');?>:</td>
          <td class="hilite" width="100%"><?php echo $project->getProjectReward2();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Project No.');?>:</td>
          <td class="hilite" width="100%"><?php if ($project->getProjectNo()==0) { echo "-";} else {echo $project->getProjectNo();}?></td>
        </tr>
		<tr> 
        </tr>
        <tr> 
          <td colspan="2"><hr noshade="noshade" size="1"></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword1');?>:</td>
          <td class="hilite"><?php echo $project->getProjectKeyword1();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword2');?>:</td>
          <td class="hilite"><?php echo $project->getProjectKeyword2();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword3');?>:</td>
          <td class="hilite"><?php echo $project->getProjectKeyword3();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword4');?>:</td>
          <td class="hilite"><?php echo $project->getProjectKeyword4();?></td>
        </tr>
        <tr>
          <td align="right" nowrap><?php echo $user->_('Keyword5');?>:</td>
          <td class="hilite"><?php echo $project->getProjectKeyword5();?></td>
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
          <td width="45%" align="left" class="hilite"><?php echo @$project->getProjectAbstract();?></td>
          <td width="34%"> 
		  		<?
				$allpath="../files/dms/project/".$project->getProjectId();
				if (@$project->getProjectAbstract() != "") {
				?>
				<a href="<? echo $allpath."/".@$project->getProjectAbstract();?>"><?php echo $user->_( 'download' );?></a> 
				<?
				}
				?>		
			</td>
        </tr>
        <tr valign="top"> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
          <td align="left" class="hilite"> 
            <?php 
					$typeFile=@$project->getProjectAbstract();		
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
			if (@$project->getProjectAbstract() != "") {
			$doc_filesize = filesize($allpath."/".@$project->getProjectAbstract());
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
          <td align="left" class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $project->getProjectOwner()?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $project->getProjectOwnerName();?></a></td>
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
          <td width="45%" align="left" class="hilite"><?php echo @$project->getProjectFull();?></td>
          <td width="34%"> 
		  		<?
				$allpath="../files/dms/full_project/".$project->getProjectId();
				if (@$project->getProjectFull() != "") {
				?>
				<a href="<? echo $allpath."/".@$project->getProjectFull();?>"><?php echo $user->_( 'download' );?></a> 
				<?
				}
				?>		
			</td>
        </tr>
        <tr valign="top"> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
          <td align="left" class="hilite"> 
            <?php 
					$typeFile=@$project->getProjectFull();		
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
			if (@$project->getProjectFull() != "") {
			$doc_filesize = filesize($allpath."/".@$project->getProjectFull());
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
          <td align="left" class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $project->getProjectOwner()?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $project->getProjectOwnerName();?></a></td>
        </tr>       
      </table></td>
    </tr>
</table>