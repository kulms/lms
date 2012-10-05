<? require("../include/global_login.php");
mysql_query("DELETE FROM forum_ori WHERE id=".$id." AND modules=".$module.";");
?>
<html>
<script LANGUAGE="JavaScript">
<!--
function confirm(){
//        alert('OK, updated your contribution.');
//        window.opener.parent.head_2.location.reload();
        self.close();
}
// -->
</script>

<body onLoad="confirm()">
<? mysql_close();?>
