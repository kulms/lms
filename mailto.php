<?require("include/global_login.php");

?>
<html>
<head>
        <title>Mailtoall</title>
<link rel="STYLESHEET" type="text/css" href="main.css">
</head>

<body bgcolor="#FFFFFF">
<form method="post" action="mailto.php?send=1">
  <table width="75%" border="0" cellspacing="0" cellpadding="5" align="center">
    <tr>
      <td class="info">
        <div align="right">From</div>
      </td>
      <td class="info">
        <input type="text" name="from" size="25">(Your E-Mail address)
      </td>
    </tr>
    <tr>
      <td class="info">
        <div align="right">To</div>
      </td>
      <td class="info">
        <input type="text" name="to" value="All Staff" size="25">หากต้องการส่งทั้งคณะ ไม่ต้องเปลี่ยนแปลงข้อความในช่องนี้ แต่หากต้องการส่งเฉพาะเจาะจงให้เปลี่ยน All Staff เป็น email ของผู้รับ
      </td>
    </tr>
<tr>
      <td class="info">
        <div align="right">Subject</div>
      </td>
      <td class="info">
        <input type="text" name="subject" size="45">
      </td>
    </tr>
<tr>
      <td class="info">
        <div align="right">Messages</div>
      </td>
      <td class="info">
        <textarea name="message" rows="6" cols="45" class="small" wrap="PHYSICAL"></textarea>
      </td>
    </tr>
    <tr>
      <td class="info">&nbsp;</td>
      <td class="info">
        <input type="submit" name="Submit" value="Send Now!!">
        <input type="reset" name="Submit2" value="Clear">
      </td>
    </tr>
  </table>
</form>
</body>
</html>
<? if ($send==1 && $to=="All Staff"){
  $query=mysql_query("SELECT login FROM faculty ORDER BY name;");
   while($row=mysql_fetch_array($query)){
   $receiver="".$row["login"]."@nontri.ku.ac.th";
   mail("$receiver","$subject","$message","FROM:$from\r\nReply-to:$from");
}
}
 if ($send==1 && $to != "All Staff"){
   mail("$to","$subject","$message","FROM:$from\r\nReply-to:$from");
}
?>
