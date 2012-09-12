<title>Add Category</title>
<LINK REL=STYLESHEET TYPE="text/css" href="./images/main.css">
<?
require ("../include/global_login.php");
?>

<div align="center">
  <h1>เพิ่มหมวดคำถาม</h1>
</div><br>

<?
if ($categories=="") {
?>
<form method="post" ENCTYPE="multipart/form-data" action="?a=addCategory&m=admin" name="form">
<table align="center" cellpadding="3" cellspacing="0">
        <tr bgcolor="#D3D3D3">
                <td class="main" colspan='2'> &nbsp; &nbsp;</td>
        </tr>
        <tr bgcolor="#D3D3D3">
                
  <td class="main"><b>หมวดคำถาม : </b></td>
                <td><input type="text" name="categories" size="25" maxlength="25" class="text"></td>
        </tr>
        <tr bgcolor="#D3D3D3">
                <td></td>
                <td><input type="submit" value="Add Category" class="button">
                    <form>
                         <input type="button" value=" Close " onClick="JavaScript:self.close()" class="button">
                    </form></td>
        </tr>

</table>
</form>
<?

} else {
    $InsSql = "INSERT INTO q_categories (category_desc) VALUES('".$categories."');";
    mysql_query($InsSql);
//    <script language="javascript"> form.categories.Requery  ;</script>   
?>
    <form method="post" ENCTYPE="multipart/form-data" action="?a=addCategory&m=admin" name="form">
    <table align="center" cellpadding="3" cellspacing="0">
            <tr>
                
  <td class="main" colspan='2'><b>ได้ทำการเพิ่มหมวดคำถามเรียบร้อยแล้ว</b>&nbsp;</td>
            </tr><tr bgcolor="#D3D3D3"><td class="main" colspan='2'>&nbsp;</td>
            </tr>
            <tr bgcolor="#D3D3D3">
                    
  <td class="main"><b> หมวดคำถาม: </b></td>
                    <td><input type="text" name="categories" size="25" maxlength="25"></td>
            </tr>
            <tr bgcolor="#D3D3D3">
                    <td></td>
                    <td><input type="submit" value="Add Category" class="button">
                        <form>
                             <input type="button" value=" Close " onClick="JavaScript:self.close()" class="button">
                        </form></td>
            </tr>

    </table>
    </form>
<?
}
?>
