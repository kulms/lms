<?require("../include/global_login.php");
$sql=mysql_query("SELECT * FROM news WHERE id=$id;");
$row=mysql_fetch_array($sql);
$reply=mysql_query("SELECT * FROM users WHERE id=".$row["users"].";");
$from=mysql_fetch_array($reply);
?>
<html>
<head>
        <title>Reply Form</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body>
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
background="../images/headerbg.gif" height="53">
  <tr><td class="menu" align="center">
        <b>แบบฟอร์มตอบรับ</b>
</td></tr>
</table>
<hr width="50%">
<table border="1" cellspacing="1" cellpadding="1" align="center" bordercolor="#333333" >
<? if ($row["response"]==2) {
$replysql=mysql_query("SELECT * FROM news_res WHERE news=$id and users=".$person["id"].";");
$check=mysql_num_rows($replysql);
if ($check!=0){
$reply=mysql_fetch_array($replysql); }
?>
       <tr><td class="info">เรื่อง :</td>
           <td class="info"><?echo $row["name"] ?></td>
       </tr>
       <tr>
           <td class="info">จาก :</td>
           <td class="info"><?echo $person["firstname"]." ".$person["surname"]; ?></td>
       </tr>
       <tr>
           <td class="info">ถึง :</td>
           <td class="info"><?echo $from["firstname"]." ".$from["surname"]; ?></td>
       </tr>
       <tr>
           <form action="reply.php" method="post">
           <input type="hidden" name="id" value="<?echo $row["id"]?>">
           <input type="hidden" name="to_users" value="<?echo $reply["to_users"]?>">
           <td class="res">ข้อความตอบรับ :</td>
           <td class="res"><textarea ROWS="3" COLS="40" name="text" wrap="virtualy" class="small"><?if ($check!=0){ echo $reply["text"]; }?></textarea>
       </td></tr>
       <tr><td></td><td class="res"><input type="submit" value="submit"><input type="reset" name="Reset" value="Reset"></td></form></tr>
      <?if ($check!=0){?>
       <tr><form action="deletereply.php" method="post">
        <input type="hidden" name="reply_id" value="<?echo $reply["id"]?>">
        <td class="info">ยกเลิกการตอบรับ</td>
       <td class="res"><input type="submit" value="delete"></td>
        </form>
        </tr>
       <? } ?>
<? } ?>
</table>
</body>
</html>
<?mysql_close();?>