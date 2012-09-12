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
		if($book->getBookOwner() == $user->getUserId() || ($user->checkAdmin($user->getUserId()))){
		?>
          <td width="42%"><img src="./images/icon/_edit-16.png" border="0"> <a href="?m=book&a=addedit&book_id=<? echo $book->getBookId();?>"><? echo $user->_('edit this book');?></a>         
          </td>
		  <?
		  }
		  ?>
          <td width="58%"> 
            <?
			if($book->getBookOwner() == $user->getUserId() || ($user->checkAdmin($user->getUserId()))){
			?>
				<a href="javascript:delIt()"> <img src="./images/icon/_trash_full-16.png" border="0"> 
				</a> <a href="javascript:delIt()"><? echo $user->_('delete book');?></a>
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
      <form name="form1" method="post" action="?m=book&a=addedit">
        <input type="submit" name="Submit" value="<?php echo $user->_('new book');?>" class="button">
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
<form name="frmDelete" action="./index.php?m=book" method="post">
	<input type="hidden" name="dosql" value="do_book_aed" />
	<input type="hidden" name="del" value="1" />
	<input type="hidden" name="book_id" value="<?php echo $book_id;?>" />
</form>
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
          <td class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $book->getBookOwner()?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $book->getBookOwnerName();?></a></td>
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
    <td width="50%"><h2><? echo $user->_('Abstract File');?></h2></td>
    <td width="50%" align="right"></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="tdborder1">
  
    <tr> 
      <td width="100%" valign="top" align="center"> <table cellspacing="1" cellpadding="2" width="60%">
        <tr> 
          <td width="21%" align="right" nowrap="nowrap"><?php echo $user->_( 'File Name' );?>:</td>
          <td width="45%" align="left" class="hilite"><?php echo @$book->getBookAbstract();?></td>
          <td width="34%"> 
		 		
				<?
				$allpath="../files/dms/book/".$book->getBookId();
				if (@$book->getBookAbstract() != "") {
				?>
				<a href="<? echo $allpath."/".@$book->getBookAbstract();?>"><?php echo $user->_( 'download' );?></a> 
				<?
				}
				?>
			</td>
        </tr>
        <tr valign="top"> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
          <td align="left" class="hilite"> 
              <?php 
					$typeFile=@$book->getBookAbstract();		
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
			if (@$book->getBookAbstract() != "") {
			$doc_filesize = filesize($allpath."/".@$book->getBookAbstract());
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
          <td align="left" class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $book->getBookOwner()?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $book->getBookOwnerName();?></a></td>
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
          <td width="45%" align="left" class="hilite"><?php echo @$book->getBookPicture();?></td>
          <td width="34%"> 
            <?
				$allpath="../files/dms/picture_book/".$book->getBookId();
				if (@$book->getBookPicture() != "") {
				?>
            <a href="<? echo $allpath."/".@$book->getBookPicture();?>"><?php echo $user->_( 'download' );?></a> 
            <?
				}
				?>
          </td>
        </tr>
        <tr valign="top"> 
          <td align="right" nowrap="nowrap"><?php echo $user->_( 'Type' );?>:</td>
          <td align="left" class="hilite"> 
            <?php //echo $obj->file_type;
					$typeFile=@$book->getBookPicture();		
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
			if (@$book->getBookPicture() != "") {
			$doc_filesize = filesize($allpath."/".@$book->getBookPicture());
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
          <td align="left" class="hilite"><a onClick="NewWindow('../personal/info.php?userid=<? echo $book->getBookOwner()?>','name','650','500','no');return false" style="cursor:hand;color:#4545aa"><?php echo $book->getBookOwnerName();?></a></td>
        </tr>
        <tr>
          <td align="right" nowrap="nowrap">&nbsp;</td>
          <td align="left" class="hilite">		  
			 <?php			
			if (@$book->getBookPicture() != "") {				
				$mysock = getimagesize($allpath."/".@$book->getBookPicture());								
			?>
			<a href="javascript:NewWindow('<? echo $allpath."/".@$book->getBookPicture();?>','myname','screen.availWidth','screen.availHeight','yes')">			
			<img src="<? echo $allpath."/".@$book->getBookPicture()?>" <?php echo imageResize($mysock[0], $mysock[1], 350); ?> alt="Click to enlarge." border="0">
			</a>
			<?php	
			}
			?>			
		  </td>
        </tr>
      </table>
      </td>
  </tr>
</table>
