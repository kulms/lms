<?

$forum=new Forum('',$person["id"],$module,$courses,'');

?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../themes/<?echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">

<script language="javascript">
<!--
function newWindow(url,w,h,r,s)
 {
   var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
  var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
		
   var options = "width="+w+",height="+h+",";
   options += "resizable="+r+",scrollbars="+s+",status=yes,menubar=no,toolbar=no,location=no,directories=no,";
   options += "left="+LeftPosition+",top="+TopPosition;
 
   newWin = window.open(url, "wName", options);
   newWin.focus();
 }
//-->

</script>



</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<table width="100%" cellpadding="2" cellspacing="1" class="tdborder1">
  <tr class="boxcolor">
    <td colspan="2" class="Bcolor"><?echo $strForum_Laboption?></td>
    
  </tr>
  
  <tr>
    <td></td>
    <td align="right"><a href="#" onClick="newWindow('index.php?a=prefs&modules=<?echo $module;?>&courses=<?echo $courses;?>',400,230,'no','no')"><? echo $strForum_Labpreference?></a> | <a href="#" onClick="window.parent.location.href='index.php';"><? echo $strForum_Labexit;?></a></td>
   
  </tr>
 

<? $forum->select_useronline($strForum_Labuserlist);?>

</table>
<br><a href="javascript:window.location.reload();">Refresh User List</a>

<!--<a href="exit.php?module=<?echo $module?>&courses=<?echo $courses;?>">Exit Chat</a>!-->

</body>
</html>
