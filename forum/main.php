<? 
require ("../include/global_login.php");

$forum=new Forum('',$person["id"],$id,$courses,'');

// update user status

// 3600 = 1 hour

mysql_query("UPDATE forum_online SET status = 0,end_time = ".time()." WHERE status = 1

							and start_time < ".(time() - 2 * 60 * 60));   


$result=$forum->select_modulename();

$forumname = $result[0]['name'];
$username = $result[0]['firstname']."\t".$result[0]['surname'];

  

?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">

<link href="../themes/<? echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">
</head>

<body>
<br><br>

<table width="50%" height="96"  border="0" align="center" cellpadding="3" cellspacing="0" class="tdborder2">
                <tr class="boxcolor">
                  <td class="Bcolor"><?echo $strForum_Labwelcome.$username.$strForum_Labto. $forumname;?></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" class="tdbackground1"><table width="100%"  border="0" cellpadding="0" cellspacing="0" >
                    <tr>
                      <td width="19%" valign="middle"  align="center"><a href="index.php?a=frame&module=<?echo $id;?>&courses=<?echo $courses;?>"><img src="images/chat.gif" width="48" height="49" border="0"></a><br>
                              
                      </a> </div></td>
                      <td width="2%">&nbsp;</td>
                      <td width="79%"><a href="index.php?a=frame&module=<?echo $id;?>&courses=<?echo $courses;?>">Enter the <?echo $forumname;?></a>

                        </td>
                    </tr>
                  
                  </table></td>
                </tr>
              </table>

</body>
</html>
