<?php 
$book = Book::lookupBook($book_id);
//echo $research->getResearchISBN();
?>
<script language="javascript">
function delIt() {
	if (confirm( "<?php echo $user->_('doDelete').' '.$user->_('Book').'?';?>" )) {
		document.frmDelete.submit();
	}
}
</script>
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td width="50%"> 
      <h1><? echo $user->_('View Book');?></h1></td>    
  </tr>
</table>
<table border="0" cellpadding="4" cellspacing="0" width="100%">
<tr>
	<td nowrap="nowrap">
		<a href="?m=book"><? echo $user->_('book list');?></a> <strong>:</strong> <a href="?m=book&a=addedit&book_id=<? echo $book->getBookId();?>"><? echo $user->_('edit this book');?></a>
	</td>
	<td align="right" nowrap="nowrap">
	<table cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td>
				<a href="javascript:delIt()">
				<img src="./images/icon/_trash_full-16.png" border="0">
				</a>
			</td>
			<td>&nbsp;<a href="javascript:delIt()"><? echo $user->_('delete book');?></a>
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>
<table border="0" cellpadding="4" cellspacing="0" width="100%" class="std">
<tr>
<td>

</td>


<td>
</td>
</tr>
<tr>
	<td width="50%" valign="top">		
		<table cellspacing="1" cellpadding="2" border="0" width="100%">
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Book Name Thai');?>:</td>
          <td class="hilite" width="100%"> <?php echo $book->getBookNameTh();?> 
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Book Name English');?>:</td>
          <td class="hilite"><?php echo $book->getBookNameEng();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Book Owner');?>:</td>
          <td class="hilite"><?php echo $user->getFirstName()." ".$user->getLastName();?></td>
        </tr>
        <tr> 
          <td colspan="2" align="right" nowrap><hr noshade="noshade" size="1"></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Book Type');?>:</td>
          <td class="hilite"> 
            <?php 			
			switch ($book->getBookType()) {
				case 1:
					echo "Text Book";
					break;
				case 2:
					echo "Hand Book";
					break;
				case 3:
					echo "Other Book";
					break;
			}
			?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Book Volume');?>:</td>
          <td class="hilite"><?php echo $book->getBookVolume();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Book Press');?>:</td>
          <td class="hilite"> 
            <?php echo $book->getBookPress();?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Book Press Country');?>:</td>
          <td class="hilite"> 
            <?php echo $book->getBookPressCountry();?>
          </td>
        </tr>        
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Book Year');?>:</td>
          <td class="hilite">
		  <?php if ($book->getBookYear() == 0) { echo "-";} else { echo " ".$book->getBookYear();} ?>
		  </td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Book ISBN');?>:</td>
          <td class="hilite">
		  <?php if ($book->getBookISBN() == 0) { echo "-";} else { echo " ".$book->getBookISBN();} ?>
		  </td>
        </tr>        
      </table>
	</td>
	<td width="50%" rowspan="9" valign="top">		
		<table cellspacing="1" cellpadding="2" border="0" width="100%">
        <tr> 
          <td align="right" nowrap>&nbsp;</td>
          <td  width="100%">&nbsp;</td>
        </tr>
        <tr> 
          <td align="right" nowrap>&nbsp;</td>
          <td  width="100%">&nbsp;</td>
        </tr>
        <tr> 
          <td align="right" nowrap>&nbsp;</td>
          <td  width="100%">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="2"><hr noshade="noshade" size="1"></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword1');?>:</td>
          <td class="hilite"><?php echo $book->getBookKeyword1();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword2');?>:</td>
          <td class="hilite"><?php echo $book->getBookKeyword2();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword3');?>:</td>
          <td class="hilite"><?php echo $book->getBookKeyword3();?></td>
        </tr>
        <tr> 
          <td align="right" nowrap><?php echo $user->_('Keyword4');?>:</td>
          <td class="hilite"><?php echo $book->getBookKeyword4();?></td>
        </tr>
        <tr>
          <td align="right" nowrap><?php echo $user->_('Keyword5');?>:</td>
          <td class="hilite"><?php echo $book->getBookKeyword5();?></td>
        </tr>
      </table>
      <br />
    </td>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="50%"><h1><? echo $user->_('Abstract File');?></h1></td>
    <td width="50%" align="right"></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="std">
  
    <tr> 
      <td width="100%" valign="top" align="center"> <table cellspacing="1" cellpadding="2" width="60%">
        <tr> 
          <td width="21%" align="right" nowrap="nowrap"><?php echo $user->_( 'File Name' );?>:</td>
          <td width="45%" align="left" class="hilite"><?php echo @$book->getBookAbstract();?></td>
          <td width="34%"> 
		 		<?
				$allpath="../files/dms/book/".$book->getBookId();
				?>
				<a href="<? echo $allpath."/".@$book->getBookAbstract();?>"><?php echo $user->_( 'download' );?></a> 
          </td>
        </tr>
        <tr valign="top"> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
          <td align="left" class="hilite"> 
            <?php //echo $obj->file_type;?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Size' );?>:</td>
          <td align="left" class="hilite"> 
            <?php //echo $obj->file_size;?>
          </td>
        </tr>
        <tr> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Uploaded By' );?>:</td>
          <td align="left" class="hilite"><?php echo @$user->getFirstName()." ".@$user->getLastName();?></td>
        </tr>       
      </table></td>
    </tr>
</table>
