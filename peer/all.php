<?require("../include/global_login.php");?>
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="white" topmargin="0" leftmargin="0">
<table width="100%" cellspacing="1" cellpadding="5">
<tr bgcolor="#808080">
	<td width="20%" class="main"><b>Author</b></td>
	<td  class="main"><b>Title</b></td>
	<td align="right" width="20%" class="main"><b>Word count</b></td>
	<td align="center" width="15%" class="main"><b>Nr of comments</b></td>
	<td align="center" width="5%" class="main"><b>You?</b></td>
</tr>
<? 
function in_array($arr,$item){
	$in=0;
	for($a=0;$a<sizeof($arr);$a++){
		if($arr[$a]==$item){
			$in=1;
			break;
		}
	}
	return $in;
}

$SQLStmt = "SELECT * FROM peer WHERE memo <>'' AND modules = $modules;";  
$oRS = mysql_query($SQLStmt);
$check_for_postings=mysql_query("SELECT author FROM peer_comments WHERE reviewer=".$person["id"]." AND modules=$modules;");
$reviewed_arr=array();
if(mysql_num_rows($check_for_postings)!=0){
	while($rev_row=mysql_fetch_array($check_for_postings)){
		$reviewed_arr[]=$rev_row["author"];
	}
}
if(mysql_num_rows($oRS)!=0){
	$rownum=0;
	$block=0;
	while($row=mysql_fetch_array($oRS)){
		$cnt_word = $row["words"];
		$rownum++;
		$block++;
		if($block==5){
			$spacer="<tr><td colspan='4'><hr noshade></td></tr>";
			$block=0;
		}else{
			$spacer="";
		}//end if
		if($rownum==1){
			$bgcol="#C0C0C0";
		}else{
			$bgcol="#D3D3D3";
			$rownum=0;
		}//end if
		$id = $row["users"];
		$rs = mysql_query("SELECT count(id) AS cnt FROM peer_comments WHERE author = $id AND modules=$modules;");
		$name = mysql_query("SELECT * FROM users WHERE id =$id;");
		$user_row=mysql_fetch_array($name);
		$cnt_comm = mysql_result($rs,0,"cnt");
?>
<tr bgcolor="<?echo $bgcol ?>">
	<td class="main"><b><a href="mailto:<?echo $user_row["email"] ?>"><?echo $user_row["firstname"] ?>&nbsp;<? if($user_row["surname"]!=""){?>&nbsp;<?echo $user_row["surname"] ?><?}?></a></b></td>
	<td class="main"><i><a href="show.php?id=<?echo $id ?>&modules=<?echo $modules ?>"><?echo $row["title"] ?></a></b></td>
	<td class="main" align="right"><?echo $cnt_word ?> words</td>
	<td class="main" align="center"><? if($cnt_comm!=0){?><a href="show_comments.php?id=<?echo $id ?>&modules=<?echo $modules ?>"><?echo $cnt_comm ?></a><?}else{?> - <?}?></td>
	<td align="center" class="main"><?if(in_array($reviewed_arr,$id)==1){?>Yes<?}else{?>&nbsp;<?}?></td>
</tr>
<?echo $spacer ?>
<?
	}//end while
}//End If
?>
</table>
</body>
</html>
