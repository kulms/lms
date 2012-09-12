
<?

//error_reporting(0);


require("../include/global.php");
require("modules/system/include/function.php");

?>
<html>
<title>
News System
</title>
<head>

<link href="../themes/<? echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body background="../themes/<?php echo $theme;?>/images/bg_lines.gif">
  <?

$news=mysql_query("SELECT u.firstname,u.surname,ns.subject,ns.title,ns.id,ns.picture,ns.htmlfile, ns.expired_date,ns.post_date,ns.news_area,ns.users FROM news_system ns,users u  
WHERE   ns.id=$id and ns.users=u.id;");
								
$row=mysql_fetch_array($news);
						

$filename = "../files/news_system/".$row["users"]."/htmlfiles/".$row["htmlfile"];
$fd = fopen ($filename, "r");
$contents = fread ($fd, filesize ($filename));
fclose ($fd);
?>
<table width="600"  border="0" cellpadding="0" cellspacing="2"  >
                            <tr> 
                              <td align="left" valign="top"> 
                              
                                <table width="100%" border="0" cellspacing="0" cellpadding="2" class="tdborder3">
                                  <tr align="center" class="boxcolor1"> 
                                    <td height="20"  class="main_white"><strong> 
                                      <?=$row["subject"]?>
                                     </strong></td>
                                  </tr>
                               
								  <tr> 
                                    <td height="800" valign="top" bgcolor="#FFFFFF"> 
                                      <? 
									 
									  if (strlen($row["picture"])>0) {
										echo "<div align=\"center\"> <img src=\"../files/news_system/".$row["users"]."/thumbnail/".$row["picture"]."\" border=\"0\"></div><br>"; 
								
										}
									  echo "<span class=\"news\"><b>".nl2br($row["title"])."</b></span><br>";
									  
									  echo $contents;
									  
									  ?>
                                
									</td>
                                
								  </tr>
                                  <tr><td class="hilite" align="right" bgcolor="#FFFFFF">
								  <span class="Bred">ผู้ประกาศ: </span><b><?echo $row["firstname"]."\t\t".$row["surname"];?></b>&nbsp;&nbsp;
								 <span class="Bred"> วันที่: </span><b><?=ShowDateLong($row["post_date"]);?></b></td></tr>
								</table>
                                
                              </td>
                            </tr>
</table>


<div align="center"><input type="button" onClick="window.close();" value="Close" style="font-family :Verdana; font-size: 10px; color: #000000; font-weight: bold; height:18px; text-align: center; cursor: hand; width:80px;  border-width: 1px"></div>
</body>
</html>