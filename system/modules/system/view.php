<?php 
$users = Users::lookupUsers($users_id);
?>
<script language="javascript">
function delIt() {
	if (confirm( "<?php echo $user->_('doDelete').' '.$user->_('Users').'?';?>" )) {
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
<script language="javascript">
function popChgPwd() {
	window.open( './index.php?m=users&a=chpwd&users_id=<? echo $users_id;?>', 'chpwd', 'top=250,left=280,width=350, height=220, scollbars=false' );
}
</script>

<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td width="50%">
	<table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
		<?
		//if($research->getResearchOwner() == $user->getUserId() || ($user->checkAdmin($user->getUserId()))){
		?>
          <td width="30%"><img src="./images/icon/_edit-16.png" border="0"> <a href="?m=users&a=addedit&users_id=<? echo $users->getUsersId();?>"><? echo $user->_('edit this user');?></a>         
          </td>
  	    <?
	    //}
	    ?>
          <td width="30%"> 
        <?
		//if($research->getResearchOwner() == $user->getUserId() || ($user->checkAdmin($user->getUserId()))){
		?>
            <a href="javascript:delIt()"> <img src="./images/icon/_trash_full-16.png" border="0"> 
            </a> <a href="javascript:delIt()"><? echo $user->_('delete users');?></a> 
        <?
		//}
	    ?>
          </td>
		   <td width="40%">         
            <a href="#" onclick="popChgPwd();return false"> <img src="./images/obj/lock.gif" border="0"> 
            </a> <a href="#" onclick="popChgPwd();return false"><? echo $user->_('change password');?></a>         
          </td>
        </tr>
      </table>
      </td>
    <td width="50%" align="right"> 
	<?
		//if($user->getCategory() == 2){
	?>
      <form name="form1" method="post" action="?m=users&a=addedit">
        <input type="submit" name="Submit" value="<?php echo $user->_('new user');?>" class="button">
      </form>
	<?
	//}
	?>  
	</td>
  </tr>
</table>

<table border="0" cellpadding="4" cellspacing="0" width="100%" class="std">
<tr>
<td>

</td>


<td>
<form name="frmDelete" action="./index.php?m=users" method="post">
	<input type="hidden" name="dosql" value="do_users_aed" />
	<input type="hidden" name="del" value="1" />
	<input type="hidden" name="users_id" value="<?php echo $users_id;?>" />
</form>
</td>
</tr>
<tr>
	<td width="50%" valign="top">		
		<table cellspacing="1" cellpadding="2" border="0" width="100%">
        <tr> 
          <td align="right" nowrap><?php echo $user->_('User Login');?>:</td>
          <td class="hilite" width="100%"> <?php echo $users->getUsersLogin();?> 
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('User Type');?>:</td>
          <td class="hilite"> 
            <?php 
				switch ($users->getUsersCategory()) {							
					case 1:
						echo "admin";
						break;
					case 2:
						echo "instructor";
						break;
					case 3:
						echo "student";
						break;
					default:
						echo "guest";
				}
		  ?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('User Real Name');?>:</td>
          <td class="hilite"><a href = "#" onClick="NewWindow('../personal/info.php?userid=<? echo $users->getUsersId()?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $users->getUsersTitle().$users->getUsersFirstName()." ".$users->getUsersSurName();?></a></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('User Status');?>:</td>
          <td class="hilite">
		  <font color="#FF0000">
		  <?php if($users->getUsersActive()==1) { echo "active";} else { echo "inactive";}?>
		  </font>             
          </td>
        </tr>
		<tr> 
          <td align="right" nowrap><?php echo $user->_('User Email');?>:</td>
          <td class="hilite">
            <?php echo $users->getUsersEmail();?> 
          </td>
        </tr>
      </table>
	</td>
	<td width="50%" rowspan="9" valign="top">		
		<table cellspacing="1" cellpadding="2" border="0" width="100%">
		
        <tr> 
          <td align="right" nowrap><?php echo $user->_('User Homepage');?>:</td>
          <td class="hilite"><?php echo $users->getUsersHomepage();?> </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('User Faculty');?>:</td>
          <td class="hilite" width="100%"><?php echo $users->getUsersFacId();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('User Department');?>:</td>
          <td class="hilite" width="100%"><?php echo $users->getUsersDeptId();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('User Major');?>:</td>
          <td class="hilite" width="100%"> 
            <?php echo $users->getUsersMajorId();?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('User Id Number');?>:</td>
          <td class="hilite" width="100%"><?php echo $users->getUsersIdNumber();?></td>
        </tr>        
      </table>    
    </td>
</table>
