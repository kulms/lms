<?php require("../include/global_login.php");
$get_course=mysql_query("SELECT courses FROM wp WHERE modules=$id;");
$check_cadmin=mysql_query("SELECT id FROM wp WHERE courses=".mysql_result($get_course,0,"courses")." AND admin=1 AND users=".$person["id"].";");
if(mysql_num_rows($check_cadmin)!=0){
        $cadmin=1;
}else{
        $cadmin=0;
}
mysql_query("INSERT INTO login_modules(users,modules,time) VALUES(".$person["id"].",$id,".time().");");
$check=mysql_query("SELECT name,info,stdlock from modules WHERE id=$id;");
$rightcheck=mysql_query("SELECT id,users from modules WHERE users=".$person["id"]." AND id=$id;");
$userright=mysql_num_rows($rightcheck);
$checked=mysql_result($check,0,"stdlock");
?>
<html>
<head>
        <title>Resources</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<body bgcolor="#ffffff">
<div align="center">
<table border="0" cellpadding="0" cellspacing="0">
        <tr>
                <td class="res"><?php echo nl2br(mysql_result($check,0,"info"))?></td>
                <td class="res" width="15%"><br>&nbsp;</td>
        </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0">
        <tr>
                <td class="res"><img src="../images/resources.gif" width=20 height=16
alt="" border="0" align="top"><?php echo mysql_result($check,0,"name");?>&nbsp;&nbsp;</td>
			<?php if ($cadmin == 1) { ?>
                <td class="res"><a href="edit.php?modules=<?php echo $id ?>&id=0&folder=true">
				<img src="../images/tool.gif" width=18 height=16 alt="" border="0" align="top"></a>
				</td>
			<?php } ?>
        </tr>
        <tr>
                <td class="res nowrap" colspan="2"><img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top"></td>
        </tr>
        <?php
        function rs($modules,$id,$space){
 $rs=mysql_query("SELECT r.name,r.id,r.folder,r.url,r.refid,r.file,r.modules,r.time,u.firstname,u.firstname,u.surname from resources r,users u WHERE r.modules=$modules AND r.refid=$id AND r.users=u.id order by r.name;");
                 while($row=mysql_fetch_array($rs)){
                        ?>
                        <tr>
                                <td class="res" nowrap><?php
                                        echo $space;
                                        if($row["folder"]==1){
                                                ?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><img src="../images/folder.gif" width=20 height=15 alt="" border="0" align="top"><?php
                                                echo $row["name"];
                                        }else{
                                                if(strlen($row["url"])!=0){
                                                        ?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><?php
                                                        ?><img src="../images/link.gif" width=20 height=16 alt="" border="0" align="top"><?php
                                                        ?><a href="<?php echo $row["url"]?>" target="_blank"><?php echo $row["name"]?></a><?php
                                                }else{
                                                        ?><img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"><?php
                                                        ?><img src="../images/file.gif" width=20 height=16 alt="" border="0" align="top"><?php
                                                        ?><a href="files/<?php echo $row["id"]."/".$row["file"]?>"><?php echo $row["name"]?></a><?php
                                                }
                                        }
                                ?>
                                &nbsp;&nbsp;</td><?php if($cadmin==1 || $cadmin==0) {
                                                 if($row["folder"]==0){?>
                                                <td class="res">
                                                <a href="edit.php?modules=<?php echo $modules?>&id=<?php echo $row["id"]?>">
                                                 <img src="../images/tool.gif" width=18 height=16 alt="<?php echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"])?>" border="0" align="top"></a>
                                        </td>
                                        <?php }else{?>
                                        <td class="res">
                                                <a href="edit.php?modules=<?php echo $modules?>&id=<?php echo $row["id"]?>&folder=true">
                                                  <img src="../images/tool.gif" width=18 height=16 alt="<?php echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"])?>" border="0" align="top"></a>
                                                   <?php echo $rcheck; ?>
                                                  </td>
                                <?php }
                                  }?>
                        </tr>
                        <?php
                        if($row["folder"]==1){
                                rs($modules,$row["id"],$space.'<img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top">');
                        }
                }
        }
        rs($id,0,'');
        ?>
</table>
</div></body>
</html>
<?php
mysql_close();
?>
