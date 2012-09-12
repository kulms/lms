<?require("../include/global_login.php");
$type=mysql_query("SELECT * FROM news_type WHERE active=1;");
?>
<html>
<head>
        <title>Add NEWS</title>
        <script language="javascript">
        <!--
        function name_check(){
                if(document.fileform.name.value=="") {
                        alert("You can't have an empty name");
                        return false;
                    }else{
                        return true;
                }
        }
        function delete_check(){
                if(confirm("Do you really want to delete "+document.renameform.homeworkname.value+" and all it's content?")){
                        if(confirm("Are you really...REALLY sure?\nThis action can't be undone.")){
                                return true;
                        }else{
                                return false;
                        }
                }else{
                        return false;
                }
        }
        //-->
        </script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff">
<div align="center" class="info"><br>
<? if($id!="0"){ // edit news
        $rs=mysql_query("SELECT * FROM news WHERE id=$id;");
        $r=mysql_fetch_array($rs);
        if($r["users"]==$person["id"] || $person["id"]==564){
        ?>

  <table border="0" cellpadding="2" cellspacing="0" width="75%">
    <tr>
      <td colspan=2 class="info" align="center" bgcolor="#CCFFCC">แก้ไขข่าว/ประกาศ</td>
    </tr>
    <? if ($r["text"]==1) { ?>
    <tr> <form action="rename.php" method="post" name="form" onSubmit="return name_check();">
      <input type="hidden" name="id" value="<?echo $id?>">
      <td class="res">ที่</td>
      <td class="res">
        <input type="text" name="news_id" size="18" value="<?echo $r["news_id"] ?>">
      </td>
    </tr>
    <tr>
      <td class="res">รับที่ :</td>
      <td class="res">
        <input type="text" name="news_in" size="10" value="<?echo $r["news_in"] ?>">
      </td>
    </tr>
    <tr>
      <td class="res">เรื่อง :</td>
      <td class="res">
        <input type="text" name="name" size="50" value="<?echo $r["name"] ?>">
      </td>
    </tr>
    <tr>
      <td class="res">ข้อความ:</td>
      <td class="res">
        <textarea rows="10" cols="50" name="bodytext" wrap="virtual" class="small"><?echo $r["body"] ?></textarea>
      </td>
    </tr>
    <tr>
    <tr>
      <td class="res" align="left" valign="top">ประเภทของผู้รับ</td>
      <td class="res">
        <input type="checkbox" name="forstd" value="1" <?if ($r["forstd"]==1){ echo "checked";}?>>
        นิสิต
        <input type="checkbox" name="forlect" value="1" <?if ($r["forlect"]==1){ echo "checked";}?>>
        อาจารย์
        <input type="checkbox" name="forstaff" value="1" <?if ($r["forstaff"]==1){ echo "checked";}?>>
        เจ้าหน้าที่
        <input type="checkbox" name="forge" value="1" <?if ($r["forge"]==1){ echo "checked";}?>>
        บุคคลทั่วไป </td>
    </tr>
    <tr>
      <td class="res" align="left" valign="top">นำข่าวนี้ประกาศไว้หน้าแรก</td>
      <td class="res">
        <input type="radio" name="firstpage" value="0" <?if ($r["firstpage"]==0){ echo "checked";}?>>
        ไม่ใช่
        <input type="radio" name="firstpage" value="1" <?if ($r["firstpage"]==1){ echo "checked";}?>>
        ใช่ </td>
    </tr>
    <tr>
      <td></td>
      <td class="res">
        <input type="submit" value="Update">
        <input type="button" value="Cancel" onClick="{location='index.php?id=<?echo $modules?>';}">
      </td>
    </tr></form>
    <? }
                     if($r["text"]==0 && strlen($r["url"])>0){
                         ?>
    <tr> <form action="rename.php" method="post" name="form" onSubmit="return name_check();">
      <input type="hidden" name="id" value="<?echo $id?>">
      <td class="res">ที่</td>
      <td class="res">
        <input type="text" name="news_id" size="18" value="<?echo $r["news_id"] ?>">
      </td>
    </tr>
    <tr>
      <td class="res">รับที่ :</td>
      <td class="res">
        <input type="text" name="news_in" size="10" value="<?echo $r["news_in"] ?>">
      </td>
    </tr>
    <tr>
      <td class="res">เรื่อง :</td>
      <td class="res">
        <input type="text" name="name" size="50" value="<?echo $row["name"] ?>">
      </td>
    </tr>
    <tr>
      <td class="res">ข้อความ:</td>
      <td class="res">
        <textarea ROWS="3" COLS="49" name="name" wrap="virtual" class="small"><?echo $r["bodytext"] ?></textarea>
      </td>
    </tr>
    <tr>
      <td class="res" align="left" valign="top">ประเภทของผู้รับ</td>
      <td class="res">
        <input type="checkbox" name="forstd" value="1" <?if ($r["forstd"]==1){ echo "checked";}?>>
        นิสิต
        <input type="checkbox" name="forlect" value="1" <?if ($r["forlect"]==1){ echo "checked";}?>>
        อาจารย์
        <input type="checkbox" name="forstaff" value="1" <?if ($r["forstaff"]==1){ echo "checked";}?>>
        เจ้าหน้าที่
        <input type="checkbox" name="forge" value="1" <?if ($r["forge"]==1){ echo "checked";}?>>
        บุคคลทั่วไป </td>
    </tr>
    <tr>
      <td class="res" align="left" valign="top">นำข่าวนี้ประกาศไว้หน้าแรก</td>
      <td class="res">
        <input type="radio" name="firstpage" value="0" <?if ($r["firstpage"]==0){ echo "checked";}?>>
        ไม่ใช่
        <input type="radio" name="firstpage" value="1" <?if ($r["firstpage"]==1){ echo "checked";}?>>
        ใช่ <br>
        <input type="submit" value="Save !!"></form>
        </td>
    </tr>
    <tr>
      <td colspan=2 class="info" align="center" bgcolor="#CCFFCC">แก้ไขเฉพาะ URL</td>
    </tr>
    <tr> <form action="url.php" method="post">
      <input type="hidden" name="modules" value="<?echo $modules?>">
      <input type="hidden" name="id" value="<?echo $id?>">
      <td class="res">URL:</td>
      <td class="res">
        <input type="text" name="url" size="49" value="<?echo $r["url"]?>">
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="res">
        <input type="submit" value="Update New URL">
        <input type="button" value="Cancel" onClick="{location='menu.php';}">
      </td></form>
    </tr>
    <?
                 }
                if($r["text"]==0 && strlen($r["url"])==0){
                        ?>
    <tr> <form action="rename.php" method="post" name="form" onSubmit="return name_check();">
      <input type="hidden" name="id" value="<?echo $id?>">
      <td class="res">ที่</td>
      <td class="res">
        <input type="text" name="news_id" size="18" value="<?echo $r["news_id"] ?>">
      </td>
    </tr>
    <tr>
      <td class="res">รับที่ :</td>
      <td class="res">
        <input type="text" name="news_in" size="10" value="<?echo $r["news_in"] ?>">
      </td>
    </tr>
    <tr>
      <td class="res">เรื่อง:</td>
      <td class="res">
        <textarea ROWS="3" COLS="49" name="name" wrap="virtual" class="small"><?echo $r["name"] ?></textarea>
      </td>
    </tr>
    <tr>
      <td class="res" align="left" valign="top">ประเภทของผู้รับ</td>
      <td class="res">
        <input type="checkbox" name="forstd" value="1" <?if ($r["forstd"]==1){ echo "checked";}?>>
        นิสิต
        <input type="checkbox" name="forlect" value="1" <?if ($r["forlect"]==1){ echo "checked";}?>>
        อาจารย์
        <input type="checkbox" name="forstaff" value="1" <?if ($r["forstaff"]==1){ echo "checked";}?>>
        เจ้าหน้าที่
        <input type="checkbox" name="forge" value="1" <?if ($r["forge"]==1){ echo "checked";}?>>
        บุคคลทั่วไป </td>
    </tr>
    <tr>
      <td class="res" align="left" valign="top">นำข่าวนี้ประกาศไว้หน้าแรก</td>
      <td class="res">
        <input type="radio" name="firstpage" value="0" <?if ($r["firstpage"]==0){ echo "checked";}?>>
        ไม่ใช่
        <input type="radio" name="firstpage" value="1" <?if ($r["firstpage"]==1){ echo "checked";}?>>
        ใช่ <br>
        <input type="submit" value="Save!!!">
      </td></form>
    </tr>
    <tr>
      <td colspan=2 class="info" align="center" bgcolor="#CCFFCC">แก้ไขเฉพาะรูปภาพ</td>
    </tr>
    <tr> <form action="file.php" method="post" enctype="multipart/form-data" name="form">
      <input type="hidden" name="id" value="<?echo $id?>">
      <input type="hidden" name="news_id" value="<?echo
$r["news_id"] ?>">
      <td class="res">File (2MB max):</td>
      <td class="info"> Old file:
        <?echo $r["file"]?>
        <br>
        <input type="file" size="49" name="file">
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="res">
        <input type="submit" value="Update New File">
        <input type="button" value="Cancel" onClick="{location='menu.php';}">
      </td></form>
    </tr>
    <?                }
                                         if($r["users"]==$person["id"] || $person["id"]==564 || $cadmin==1){
                        ?>
    <tr>
      <table width="75%" border="0">
        <form action="file.php" method="post" enctype="multipart/form-data" name="form">
          <input type="hidden" name="id" value="<?echo $id ?>">
          <input type="hidden" name="newpage" value="add">
          <tr>
            <td colspan=2 class="info" align="center" bgcolor="#CCFFCC">เพิ่มข่าวหน้าถัดไป</td>
          </tr>
          <tr>
            <td class="info">หน้าที่:</td>
            <td class="info">
              <input type="text" name="page" size="2">
          </tr>
          <tr>
            <td class="info">File :
            <td class="info">
              <input type="file" size="49" name="file">
          </tr>
          <tr>
            <td></td>
            <td class="info">
              <input type="submit" value="Add New Page">
              <input type="reset" value="Clear">
            </td>
          </tr>
        </form>
      </table>
    </tr>
    <tr>
      <td colspan="2" align="center" class="info"> <br>
        <hr width="50%">
        <form>
          ลบข่าวนี้ทั้งหมดทุกหน้า--->
          <input type="button" value="Delete!" onClick="if(confirm('Realy delete?')){location='delete.php?modules=<?echo $modules?>&id=<?echo $r["id"]?>';}">
        </form>
      </td>
    </tr>
    <?}
}?>
  </table>
<? }else{ //add news news
?>
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center" background="../images/headerbg.gif" height="53">
  <tr><td class="menu" align="center">
        <b>เพิ่มหัวข้อข่าว ประจำวันที่ <?echo date("d-m-Y",time()) ?> </b>

</td></tr>
</table>
<hr width="50%">


<table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolorlight="#FF99FF" bordercolordark="#FFFFFF">
    <tr>
      <td align="center" colspan="2" bgcolor="#6666FF"><class="main"><font color="#339999"><b>
        <font color="#FFFFFF">เพื่มข่าวด้วยภาพที่ได้จากการ scan หรือมี file แนบ</font> </b></font></td>
    </tr>
    <tr> <form action="file.php" method="post" enctype="multipart/form-data" name="fileform" >
      <input type="hidden" name="id" value="0">
      <td class="res">หมวดของข่าว :</td>
      <td class="info"><b><?echo $news_type_name;?></b></td>
      <input type="hidden" name="news_type" value="<?echo $news_type;?>">
      </tr>
      <tr>
      <td class="res">หมู่ของข่าว :</td>
      <td class="info"><b><?echo $news_group_name;?></b></td>
      <input type="hidden" name="news_group" value="<?echo $news_group;?>">
      </td>
      <tr>
      <td class="res">ที่ :</td>
      <td class="res">
        <input type="text" name="news_id" size="18">
      </td>
    </tr>
    <tr>
      <td class="res">รับที่:</td>
      <td class="res">
        <input type="text" name="news_in" size="10">
      </td>
    </tr>
    <tr>
      <td class="res">เรื่อง:</td>
      <td class="res">
        <input type="text" name="name" size="40">
      </td>
    </tr>
    <tr>
      <td class="res">File (2MB max):</td>
      <td class="res">
        <input type="file" size="40" name="file">
      </td>
    </tr>
    <tr>
      <td class="res">ประเภทการตอบรับ</td>
      <td class="info">
        <input type="radio" name="res" value="0" checked>
        ไม่ต้องตอบรับ
        <input type="radio" name="res" value="2">
        ตอบรับแบบมีข้อความหรือเสนอชื่อ
    </tr>
    <tr>
      <td class="res" align="left" valign="top">ประเภทของผู้รับ</td>
      <td class="res">
        <input type="checkbox" name="forstd" value="1">
        นิสิต
        <input type="checkbox" name="forlect" value="1">
        อาจารย์
        <input type="checkbox" name="forstaff" value="1">
        เจ้าหน้าที่
        <input type="checkbox" name="forge" value="1">
        บุคคลทั่วไป </td>
    </tr>
    <tr>
      <td class="res" align="left" valign="top">นำข่าวนี้ประกาศไว้หน้าแรก</td>
      <td class="res">
        <input type="radio" name="firstpage" value="0" checked>
        ไม่ใช่
        <input type="radio" name="firstpage" value="1">
        ใช่ / อายุของข่าวที่จะประกาศไว้หน้าแรก
        <input type="text" name="expire" size="4" maxlength="2" value="15">
        วัน </td>
    </tr>
    <tr>
      <td class="res" align="left" valign="top">ตอบรับภายในวันที่</td>
      <td class="res">
        <input type="Text" name="end_date" value="<? if ($row["end_date"]!=0){
         echo date("d/m/Y",$row["end_date"]); }?>">
        ( วัน/เดือน/ปี เช่น: 02/10/2000 ) </td>
    </tr>
    <tr>
      <td align="center" class="res" colspan="2">
        <input type="submit" value="Add + File">
        <input type="reset" value="Clear">
      </td></form>
    </tr>
</table>
    <?//  Add newsss by url
?>
<br><br>
  <table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolorlight="#CCCCFF" bordercolordark="#FFFFFF">
    <tr>
      <td align="center" colspan="2" bgcolor="#6666FF"><class="main"><font color="#FFFFFF"><b>เพิ่มข่าวโดยการพิมพ์ข้อความ
        </b></font><font color="#339999"><b> </b></font></td>
    </tr>
    <tr> <form action="text.php" method="post"  name="fileform" onSubmit="return name_check();">
      <input type= "hidden" name="id" value="0">
      <td class="res">หมวดของข่าว :</td>
      <td class="info"><b><?echo $news_type_name;?></b></td>
      <input type="hidden" name="news_type" value="<?echo $news_type;?>">
      </tr>
      <tr>
      <td class="res">หมู่ของข่าว :</td>
      <td class="info"><b><?echo $news_group_name;?></b></td>
      <input type="hidden" name="news_group" value="<?echo $news_group;?>">
      </td>
      <tr>
      <td class="res">ที่ :</td>
      <td class="res">
        <input type="text" name="news_id" size="15">
      </td>
    </tr>
    <tr>
      <td class="res">รับที่:</td>
      <td class="res">
        <input type="text" name="news_in" size="10">
      </td>
    </tr>
    <tr>
      <td class="res">เรื่อง :</td>
      <td class="res">
        <input type="text" name="name" size="50">
      </td>
    </tr>
    <tr>
      <td class="res">เนื้อความ:</td>
      <td class="res">
        <textarea ROWS="10" COLS="60" name="bodytext" wrap="virtualy" class="small"></textarea>
      </td>
    </tr>
    <tr>
      <td class="res">ประเภทการตอบรับ</td>
      <td class="info">
        <input type="radio" name="res" value="0" checked>
        ไม่ต้องตอบรับ
        <input type="radio" name="res" value="2">
        ตอบรับแบบมีข้อความหรือเสนอชื่อ
    </tr>
    <tr>
      <td class="res" align="left" valign="top">ประเภทของผู้รับข่าว</td>
      <td class="res">
        <input type="checkbox" name="forstd" value="1">
        นิสิต
        <input type="checkbox" name="forlect" value="1">
        อาจารย์
        <input type="checkbox" name="forstaff" value="1">
        เจ้าหน้าที่
        <input type="checkbox" name="forge" value="1">
        บุคคลทั่วไป </td>
    </tr>
    <tr>
      <td class="res" align="left" valign="top">นำข่าวนี้ประกาศไว้หน้าแรก</td>
      <td class="res">
        <input type="radio" name="firstpage" value="0" checked>
        ไม่ใช่
        <input type="radio" name="firstpage" value="1">
        ใช่ / อายุของข่าวที่จะประกาศไว้หน้าแรก
        <input type="text" name="expire" size="4" maxlength="2" value="15">
        วัน </td>
    </tr>
    <tr>
      <td align="center" class="res" colspan="2">
        <input type="submit" value="Add">
        <input type="reset" value="Clear">
      </td></form>
    </tr>
  </table>
<br><br>
  <? } ?>
</div>
</body>
</html>
