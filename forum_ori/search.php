<?
require("../include/global_login.php");?>
<html>
<head>
<title></title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<script LANGUAGE="JavaScript">
<!--
parent.aktiv=0;
// - End of JavaScript - -->
</script>
</head>
<body bgcolor="#ffffff">
<? 
if((!$qry)||($qry=="")){ 
	$forum=mysql_query("SELECT name FROM modules WHERE id=".$module.";");
	$forumname=mysql_result($forum,0,"name");

?>
<table border="0" cellspacing="0" cellpadding="0" align="center" width="218">
  <form action="search.php" METHOD="POST" name="search">
    <tr> 
      <td class="main">Search in <b><?echo $forumname?></b>
        <select name="searchtype" style="font-size: 10; font-weight: bold; background-color: #cccccc;">
          <option value="any">Any word</option>
          <option value="phrase">Phrase</option>
        </select>
      </td>
    </tr>
    <tr> 
      <td height="76" align="right" valign="top"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td rowspan="3" width="6%" valign="top"><img src="../images/border_left.gif" width="14" height="78" vspace="0" hspace="0" align="top"></td>
            <td width="58%" height="8"><img src="../images/border_top.gif" width="100%" height="10" align="top"></td>
            <td rowspan="3" width="36%" valign="top"><img src="../images/border_right.gif" width="14" height="78" align="top"></td>
          </tr>
          <tr> 
            <td height="60" width="58%"><input type="text" name="qry" size="35">
			<input type="image" src="../images/search.gif"  align="right" width=25 height=25 alt="" border="0">
			</td>
          </tr>
          <tr> 
            <td width="58%" height="10" valign="bottom"><img src="../images/border_bottom.gif" width="100%" height="7" align="absbottom"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td colspan="2" class="main">&nbsp; </td>
    </tr>
    <tr> 
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="2"><a href="show.php?module=<?echo $module?>" class="main">Back 
        to discussion.</a></td>
    </tr>
    <input type="hidden" name="module" value="<?echo $module?>">
  </form>
</table>
<script language="javascript">
document.search.qry.select();
document.search.qry.focus();
</script>

<?
} //end if
else{
	?>
	<table border="1" cellspacing="0" cellpadding="1" align="center">
	<?
	//*********** function printrow($row,$s_string) ************************
	//
	//	Print result into tablerow. $s_string is not used - inteneded to
	//	make str_replace on found string to <b>string</b>. 
	//	Not used since php makes a distinction between foo and Foo.
	//	We leave this to someone else :)
	//*************************************************************************
	
	function printrow($row,$s_string){
		?>
		<tr>
			<td class="main" valign="top"><b><?echo
eregi_replace($s_string,"<b>".$s_string."</b>",$row["firstname"])."&nbsp;".eregi_replace($s_string,"<b>".$s_string."</b>",$row["surname"])
?></b><BR><?echo date("d-m-Y H:i:s",$row["time"])?></td>
			<td class="main" valign="top"><?echo eregi_replace($s_string,"<b>".$s_string."</b>",$row["info"])?></td>
		</tr><?
	}

	//*********** function search($in_string,$in_sql) ************************
	//
	//	Takes the phrase ($in_string),module nr ($module) and an integer 
	//	($in_sql) to select the correct sql statement, as parameters. 
	//	Sends the result to printrow().
	//*************************************************************************
	function search($in_string,$sel_sql,$mode,$module){
		$sql_fname="SELECT u.firstname,u.surname,f.* FROM users u,forum_ori f WHERE f.users=u.id AND f.modules=".$module." AND u.firstname LIKE '%";
		$sql_sname="SELECT u.firstname,u.surname,f.* FROM users u,forum_ori f WHERE f.users=u.id AND f.modules=".$module." AND u.surname LIKE '%";
		$sql_info="SELECT u.firstname,u.surname,f.* FROM users u,forum_ori f WHERE u.id=f.users AND f.modules=".$module." AND f.info LIKE '%";
		
		switch ($sel_sql){
	    case 1:
	        $in_sql=$sql_fname;
			break;
	    case 2:
	        $in_sql=$sql_sname;
			break;
	    case 3:
	        $in_sql=$sql_info;
			break;
		}//end switch
		
		switch ($mode){
		case 1:
			for($i=0;$i<sizeof($in_string);$i++){
				$query = mysql_query($in_sql.$in_string[$i]."%';");
				while($row = mysql_fetch_array($query)){
					$cnt++;
					printrow($row,$in_string[$i]);
				}//end while
			}//end for		
			break;
			
		case 2:
			$query = mysql_query($in_sql.$in_string."%';");
			while($row = mysql_fetch_array($query)){
				$cnt++;
				printrow($row,$string);
			}//end while	
			break;
		}//end switch
		return $cnt;
	}//end function

	if($searchtype=="any"){ 	//search for every word, any-search
	//******************************************
	//		split string into words	
	//******************************************
		$qry=trim($qry);
		$string=explode(" ",$qry);
		$cnt=0;

		$cnt += search($string,1,1,$module);	// Search for firstname 
		$cnt += search($string,2,1,$module);	// Search for surname	
		$cnt += search($string,3,1,$module);	// Search for text
	}//end if=="any"

	else{	//search for ALL words i.e phrase
		$qry=trim($qry);
		$string=$qry;
		$cnt=0;

		$cnt += search($string,1,2,$module);	// Search for firstname	
		$cnt += search($string,2,2,$module);	// Search for surname	
		$cnt += search($string,3,2,$module);	// Search for text
	}//end else=="any"

		//diplay message to user - not found or nr of found items
	if($cnt==0){?>
	<table>
		<tr>
			<td class="h4">Sorry, couldnt find <b><?echo $qry ?></b></td>
		</tr>
		<tr>
			<td class="main"><p><a href="search.php?module=<?echo $module?>">New search</a></></td>
		</tr>
		<tr>
			<td class="main"><a href="show.php?module=<?echo $module?>" class="main">Back to discussion.</a></td>
		</tr>
	<?
	}//end if
	else{?>
		<div class="main">Found <b><?echo $cnt?></b> hit<? if($cnt>1){?>s<?}?></div>
		<tr>
			<td class="main" colspan="2" align="center"><a href="show.php?module=<?echo $module?>" class="main">Back to discussion.</a></td>
		</tr>
	<?
	}//end else
	?>
	</table>	
	<?
}
mysql_close();
?>
	<table align="center">
	</table>
</body>
</html>
