<?
@include_once( $user->getModuleClass( $realpath, 'research') );
@include_once( $user->getModuleClass( $realpath, 'book') );
$research = new Research('', $user->getUserId(), '', '', '', '', '', 
						'', '', '', '', '', '', 
						'', '', '', '', '', 
						'', '', '', '', ''
						);
$book = new Book('', $user->getUserId(), '', '', '', '', 
				 '', '', '', '', '', 
				 '', '', '', '', ''
				 );						

?>
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"><h1><? echo $user->_('Research List');?></h1></td>    
  </tr>
</table>
<?
		$row = $research->SelectAllResearch();
		$research->ShowTableAll($row,$user,$uistyle);
?>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" height="30" class="std">
  <tr> 
    <td valign="top"> <table width="50%" border="0" cellspacing="0" cellpadding="0">
        <tr align="left" valign="middle"> 
          <td width="1%" height="2" bgcolor="#9999CC"><img src="./images/public.gif"  border="0"></td>
          <td width="99%" height="2" background="style/<?php echo $uistyle;?>/images/titlegrad.jpg"><font color="#FFFFFF"><strong>Publication</strong></font></td>
        </tr>
        <tr> 
          <td height="2" width="1%">&nbsp;</td>
          <td height="20" width="99%" align="left"><font color="#990000" size="2">Total 
            Publication : 3</font></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="Mtable">
        <tr align="center"> 
          <td height="25" bgcolor="#C2F8E3" width="87" class="line"><font size="2">ID</font></td>
          <td width="396" height="25" bgcolor="#CAE1FF" class="line"><font size="2">ชื่องานตีพิมพ์</font></td>
          <td height="25" width="10" bgcolor="#E5F2FF" class="line"><font size="2">&nbsp;</font></td>
          <td height="25" width="80" bgcolor="#E5F2FF" class="line"><font size="2">ประเภท</font></td>
          <td height="25" width="120" bgcolor="#E5F2FF" class="line"><font size="2">ISSN</font></td>
          <td height="25" width="83" bgcolor="#E5F2FF" class="line"><font size="2">ปี 
            (พ.ศ.) </font></td>
          <td width="68" bgcolor="#E5F2FF" class="line"><font size="2">Volumn</font></td>
          <td width="35" bgcolor="#E5F2FF" class="line"><font size="2">No.</font></td>
          <td height="25" width="75" bgcolor="#E5F2FF" class="line"><font size="2">หน้าที่</font></td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#E2FCF1" align="center" class="line"><font size="2">P-0001</font></td>
          <td height="25" bgcolor="#E5F2FF" class="line"><font size="2">&nbsp;<font color="#0099CC">&raquo;</font>&nbsp; 
            <a href="./add_journal.php">Publication 1</a> </font></td>
          <td height="25" align="center" class="line"><font size="2">&nbsp;</font></td>
          <td height="25" align="center" class="line"><font size="2">Journal</font></td>
          <td height="25" align="center" class="line"><font size="2">111</font></td>
          <td height="25" align="center" class="line"><font size="2">2543</font></td>
          <td align="center" class="line"><font size="2">12</font></td>
          <td align="center" class="line"><font size="2">1</font></td>
          <td height="25" align="center" class="line"><font size="2">112-123</font></td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#E2FCF1" align="center" class="line"><font size="2">P-0002</font></td>
          <td height="25" bgcolor="#E5F2FF" class="line"><font size="2">&nbsp;<font color="#0099CC">&raquo;</font>&nbsp; 
            <a href="./add_proceeding.php">Publication 2</a></font></td>
          <td height="25" align="center" class="line"><font size="2">&nbsp;</font></td>
          <td height="25" align="center" class="line"><font size="2">Proceeding</font></td>
          <td height="25" align="center" class="line"><font size="2">222</font></td>
          <td height="25" align="center" class="line"><font size="2">2544</font></td>
          <td align="center" class="line"><font size="2">13</font></td>
          <td align="center" class="line"><font size="2">14</font></td>
          <td height="25" align="center" class="line"><font size="2">23-30</font></td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#E2FCF1" align="center" class="line"><font size="2">P-0003</font></td>
          <td height="25" bgcolor="#E5F2FF" class="line"><font size="2">&nbsp;<font color="#0099CC">&raquo;</font>&nbsp; 
            <a href="./add_proceeding.php">Publication 3 </a></font></td>
          <td height="25" align="center" class="line"><font size="2">&nbsp;</font></td>
          <td height="25" align="center" class="line"><font size="2">Presentation</font></td>
          <td height="25" align="center" class="line"><font size="2">333</font></td>
          <td height="25" align="center" class="line"><font size="2">2545</font></td>
          <td align="center" class="line"><font size="2">14</font></td>
          <td align="center" class="line"><font size="2">6</font></td>
          <td height="25" align="center" class="line"><font size="2">17-25</font></td>
        </tr>
      </table></td>
  </tr>
   <tr>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"><h1><? echo $user->_('Book List');?></h1></td>    
  </tr>
</table>
<?		
		$row = $book->SelectAllBook();
		$book->ShowTableAll($row,$user,$uistyle);
?>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" height="30" class="std">
  <tr> 
    <td valign="top"> <table width="50%" border="0" cellspacing="0" cellpadding="0">
        <tr align="left" valign="middle"> 
          <td width="1%" height="2" bgcolor="#9999CC"><img src="./images/book.gif" border="0"></td>
          <td width="99%" height="2" background="style/<?php echo $uistyle;?>/images/titlegrad.jpg"><font color="#FFFFFF"><strong>Book</strong></font></td>
        </tr>
        <tr> 
          <td height="2" width="1%">&nbsp;</td>
          <td height="20" width="99%" align="left"><font color="#990000" size="2">Total 
            Book : 5</font></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="Mtable">
        <tr align="center"> 
          <td width="384" height="25" bgcolor="#CAE1FF" class="line"><font size="2">ชื่อหนังสือ</font></td>
          <td height="25" width="10" bgcolor="#E5F2FF" class="line"><font size="2">&nbsp;</font></td>
          <td height="25" width="97" bgcolor="#E5F2FF" class="line"><font size="2">ประเภท</font></td>
          <td height="25" width="92" bgcolor="#E5F2FF" class="line"><font size="2">ISBN</font></td>
          <td height="25" width="84" bgcolor="#E5F2FF" class="line"><font size="2">ปีที่พิมพ์</font></td>
          <td width="84" bgcolor="#E5F2FF" class="line"><font size="2">ฉบับที่</font></td>
          <td height="25" width="132" bgcolor="#E5F2FF" class="line"><font size="2">สำนักพิมพ์</font></td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#FFFFFF" class="line"><font size="2">&nbsp;&raquo;&nbsp; 
            <a href="./add_book.php">Book 1</a></font></td>
          <td height="25" align="center" class="line"><font size="2">&nbsp;</font></td>
          <td height="25" align="center" class="line"><font size="2">Text book</font></td>
          <td height="25" align="center" class="line"><font size="2">1234567</font></td>
          <td height="25" align="center" class="line"><font size="2">2540</font></td>
          <td align="center" class="line"><font size="2">2</font></td>
          <td height="25" align="center" class="line"><font size="2">-</font></td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#FFFFFF" class="line"><font size="2">&nbsp;&raquo;&nbsp; 
            <a href="./add_book.php">Book 2</a></font></td>
          <td height="25" align="center" class="line"><font size="2">&nbsp;</font></td>
          <td height="25" align="center" class="line"><font size="2">Text book</font></td>
          <td height="25" align="center" class="line"><font size="2">123456</font></td>
          <td height="25" align="center" class="line"><font size="2">2541</font></td>
          <td align="center" class="line"><font size="2">3</font></td>
          <td height="25" align="center" class="line"><font size="2">-</font></td>
        </tr>
      </table></td>
  </tr>
   <tr>
    <td valign="top">&nbsp;</td>
  </tr>
</table>