<? //get Modules and resource id from edit.php?>
<? require("../include/global_login.php");

//mysql_query("INSERT INTO login_modules(users,modules,time) VALUES(".$person["id"].",$id,".time().");");
$check=mysql_query("SELECT name,info from modules WHERE id=$modules;");
//echo "module = ".$modules;
//echo "id = ".$id."<br>";
?>
<html>
<head>
        <title>Resources</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff">
<div align="center">

  <form name="form1" method="post" action="pub_course.php">
	  <input type="hidden" name="modules" value="<? echo $modules?>">
      <input type="hidden" name="id" value="<? echo $id?>">
<table border="0" cellpadding="0" cellspacing="0">
        <tr>
                <td class="menu"><? echo nl2br(mysql_result($check,0,"info"))?></td>
                <td class="menu" width="15%"><br>&nbsp;</td>
        </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0">
        <tr>
        	<td class="res"><img src="../images/resources.gif" width=20 height=16 alt="" border="0" align="top"><?echo mysql_result($check,0,"name");?>&nbsp;&nbsp;</td>
        </tr>
        <tr>                
        	<td class="res" colspan="2"><img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top"></td>
        </tr>
        <? 
        function rs($modules,$id,$space,$cat){
                $rs=mysql_query("SELECT r.name,r.id,r.folder,r.url,r.refid,r.file,r.modules,r.time,r.users,u.firstname,u.firstname,u.surname FROM resources r,users u WHERE r.modules=$modules AND r.refid=$id AND r.users=u.id order by r.name;");
				//$courses=mysql_query("SELECT c.* FROM courses c WHERE c.users=$cat order by c.id;");
                while($row=mysql_fetch_array($rs)){
					$courses=mysql_query("SELECT c.* FROM courses c WHERE c.users=$cat order by c.id;");			
                        ?>
          <tr>                                        				        				
          <td class="res" nowrap> 
          <?							
          echo $space;
          if($row["folder"]==1){ ?>
          <img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"> 
          <img src="../images/folder.gif" width=20 height=16 alt="" border="0" align="top"> 
          <? echo $row["name"]; ?> 
          <? $show=mysql_free_result($courses);
          }else{
          if(strlen($row["url"])!=0){?>
          <img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"> 
          <img src="../images/link.gif" width=20 height=16 alt="" border="0" align="top"> 
          <a href="<? echo $row["url"]?>"><?echo $row["name"]?></a> 
          <? $show=mysql_free_result($courses);
          }else{ ?>
          <img src="../images/l_out.gif" width=20 height=16 alt="" border="0" align="top"> 
          <img src="../images/file.gif" width=20 height=16 alt="" border="0" align="top"> 
          <a href="files/<? echo $row["id"]."/".$row["file"]?>"><? echo $row["name"]?></a> 
          <? $show=mysql_free_result($courses);
              }
          }?>
          &nbsp;&nbsp;</td>
		  					<? if($row["folder"]==0){?>							   									   
                               <td class="res">
                                   <a href="pub_edit.php?modules=<? echo $modules?>&id=<? echo $row["id"]?>"><img src="../images/tool_p.gif" width=14 height=14 alt="<?echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"])?>" border="0" align="top"></a>
                               </td>																												
                            <? } else {?>									
                               <td class="res">
                                   <a href="pub_edit.php?modules=<? echo $modules?>&id=<?echo $row["id"]?>"><img src="../images/tool_p.gif" width=14 height=14 alt="<?echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"])?>" border="0" align="top"></a>
                               </td>																		
							<? }?>								                          
                        </tr>
                        <?
                        if($row["folder"]==1){
                        	rs($modules,$row["id"],$space.'<img src="../images/l_down.gif" width=20 height=16 alt="" border="0" align="top">',$cat);
                        }
                }
        }
        rs($modules,0,'',$person["category"]);
        ?>
</table>
    <br>
  </form>

</div>
</body>
</html>
<?
mysql_close();
?>
