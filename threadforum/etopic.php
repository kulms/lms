<!--<link rel="STYLESHEET" type="text/css" href="../main.css">!-->
<table width="90%"  border="0" align="center">
  <tr>
    <td><a href=" javascript:history.back(1)"><img src="./images/back.gif" border="0">Back</a></td>
  </tr>
</table>
<? 
require("../include/global_login.php");
$webboard=new Webboard($topicid,$refid,'','','','',$person["id"],$id,$courses);
 require("posttopic.php");
?>

