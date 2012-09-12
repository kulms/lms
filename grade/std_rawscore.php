<?
require("classes/grade.class.php");
$grade=New Grade();

if (isset($Save)) {

if($modules_id ==0){
	$chkscr=true;
			for ($i=0; $i<sizeof($userid); $i++) {
				  if (!empty($score[$i]) ||$score[$i]==0 ) {
							if($group_id !=0) {
								$check =mysql_query("select sum(g_std_raw_score) as total_score  from g_std_raw_score 							st,g_score_type t where st.g_grade_id =".$gid." 
								and st.g_score_type_id = t.g_score_type_id and g_score_type_g_id = ".$group_id."
								and g_std_users = ".$userid[$i]. " and t.g_score_type_id <> ".$id."");
                            
					$total = @mysql_result($check,0,"total_score");
								if (($total+$score[$i]) > $max_score) {
								      $chkscr=false;
									 echo "<script language='javascript'>alert('Max score group is ' +$max_score);</script>";
									 echo "<script language='javascript'>location.href='?a=std_rawscore&gid=$gid&id=$id';</script>";
									  }
								}
				if($chkscr) {
						 if ($raw_id[$i] == "") {
				$sql = "INSERT INTO g_std_raw_score(g_grade_id,g_score_type_id,g_std_users,g_std_raw_score,g_comment,g_users,g_lastupdate) 
				 VALUES (".$gid.",".$id.",".$userid[$i].",".$score[$i].",'".$comment[$i]."',".$person["id"].",".time().")";
						 } else {
                            $sql = "UPDATE g_std_raw_score SET g_std_raw_score = ".$score[$i].",
										  g_comment = '".$comment[$i]."',
										  g_lastupdate=  ".time()."
										  WHERE g_std_raw_score_id = ".$raw_id[$i]."";
						 }

				mysql_query($sql);
					  
				  } // end check
			
			}//end if
	          
		} //end loop
}else{    //end if g_modules_id==0
	for ($i=0; $i<sizeof($userid); $i++) {
		 if ($raw_id[$i] == "") {
			 $sql="INSERT INTO g_std_raw_score(g_grade_id,g_score_type_id,g_std_users,g_std_raw_score,g_comment,g_users,g_lastupdate) 
			VALUES (".$gid.",".$id.",".$userid[$i].",".$h_score[$i].",'".$comment[$i]."',".$person["id"].",".time().") ";
		 }else{
			 $sql = "UPDATE g_std_raw_score SET g_std_raw_score = ".$h_score[$i].",
						 g_comment = '".$comment[$i]."',
						g_lastupdate=  ".time()."
					   WHERE g_std_raw_score_id = ".$raw_id[$i]."";
		 }
		mysql_query($sql);
	}
}
		echo "<script language='javascript'>location.href='?a=std_score&gid=$gid';</script>";
		
   }//end submit
 

	
	//Update 31/03/05

	$result = @mysql_query("SELECT *
														FROM  g_score_type 
														WHERE  g_grade_id = ".$gid." and  g_score_type_id = ".$id."");
	
	$max_score = @mysql_result($result,0,"g_max_score");
    $group_id = @mysql_result($result,0,"g_score_type_g_id");
	$g_modules_id=mysql_result($result,0,"g_modules_id");    //0=no modules
	$g_modules_type=mysql_result($result,0,"g_modules_type");    //7=hw,5=quiz

	// end update
?>

<html>
<title>
</title>
<head>

<link href="../themes/<? echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<SCRIPT LANGUAGE='javascript' src='validate.js'></SCRIPT>

<script LANGUAGE="javascript">

function check(theForm)
{
     var max;
	
	max=<?echo $max_score?>;
	
	for (i=0;i<theForm.g_score.length;i++)
	{
		//alert("GG");
		//alert(g_score[i]);
		if (!validNum(theForm.g_score[i],"score",true))
			{
				return false;			
			}
		
	 if (theForm.g_score[i].value >max ) {
	
			alert("Max score is: "+max);
			theForm.g_score[i].focus();
			return false;		
	 
			}
	
	
	}

	if (!validNum(theForm.g_score,"score",true))
			{
				return false;			
			}
	
	 if (theForm.g_score.value >max ) {
	
			alert("Max score is: "+max);
			theForm.g_score.focus();
			return false;		
	 
			}
	
	
	return true;

}

</script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>
			<?
	echo "<h1>#".@mysql_result($result,0,"g_score_type_name")."</h1>";
	?>
	
			</td>
		  </tr>
		</table>
	</td>
  </tr>  
</table>

<? 
	if($g_modules_id==0)
		$java="onsubmit=\"return check(this);\" ";
	else
		$java="";
?>
<form name="insert_score" method="post" action="?a=std_rawscore" <? echo $java?> >
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tdborder1">
  <tr> 
    <td colspan="7" align="left">
	<input type="hidden" value="<? echo $id;?>" name = "id">
	<input type="hidden" value="<? echo $gid;?>" name = "gid">
	<input type="hidden" value="<? echo $group_id;?>" name = "group_id">
    <input type="hidden" value="<? echo $max_score;?>" name = "max_score">
	<input type="hidden" value="<? echo $g_modules_id;?>" name = "modules_id">

	<input type="submit" name="Save" value="<?=$strSave;?>" class="button">
	<input  type="button"  value="<?=$strCancel;?>" class="button" onClick="location.href='?a=std_score&gid=<? echo $gid;?>'"> &nbsp; &nbsp;<b>(<? echo $strGrade_LabMaxScore." : ".  $max_score;?>)	</b>   
	</td>
  </tr>
  <tr  class="boxcolor" align="center"> 
    <td width="6%" class="main_white" ><?=$strGrade_LabNo;?>	</td>
    <td width="16%"  class="main_white"><?=$strGrade_LabID;?>	</td>
    <td width="35%"  class="main_white"><?=$strGrade_LabNameLastname;?>	</td>
    
  <td width="12%"   class="main_white"><?=$strGrade_LabScore;?>	</td>
  <td width="31%"   class="main_white"><?=$strGrade_LabComment;?></td>
  </tr>
<?
		if($g_modules_id ==0){      //No Use Modules
			   $Getlist=mysql_query("SELECT DISTINCT u.id AS 				
			 uid,u.login,u.firstname,u.surname,raw.g_std_raw_score_id,
			raw.g_std_raw_score_id AS rc,raw.g_std_raw_score,raw.g_score_type_id,raw.g_comment
			FROM wp inner join users u on wp.users=u.id 
			inner join g_grade g on wp.courses=g.g_courses 
			left join g_std_raw_score raw on (raw.g_std_users=u.id and raw.g_score_type_id = ".$id.")
			where g.g_grade_id =".$gid." AND wp.cases=0 AND wp.modules=0 AND wp.groups=0 
			AND u.active=1  and wp.admin = 0 ORDER BY u.login");
			 $num_row=mysql_num_rows($Getlist);
			 while($row=mysql_fetch_array($Getlist)){
				$login[]=$row["login"];
				$name[]=$row["firstname"]."\t".$row["surname"];
				$uid[]=$row["uid"];
				$raw_id[]=$row["rc"];
				if($row["g_std_raw_score"] == "")
					$score[]="0";
				else
					$score[]=$row["g_std_raw_score"];
				$comment[]=$row["g_comment"];
			 }
		}else{   //Use Modules
				//check use group 	
		$sql="SELECT group_id FROM modules WHERE id=".$g_modules_id." ";
			$result=mysql_query($sql);
			$g_id=mysql_result($result,0,'group_id');
				if($g_id ==0){
					$sql="SELECT DISTINCT u.id AS 				
							 uid,u.login,u.firstname,u.surname,raw.g_std_raw_score_id,
							raw.g_std_raw_score_id AS rc,raw.g_std_raw_score,raw.g_score_type_id,raw.g_comment
							FROM wp inner join users u on wp.users=u.id 
							inner join g_grade g on wp.courses=g.g_courses 
							left join g_std_raw_score raw on (raw.g_std_users=u.id and raw.g_score_type_id = ".$id.")
							where g.g_grade_id =".$gid." AND wp.cases=0 AND wp.modules=0 AND wp.groups=0 
							AND u.active=1  and wp.admin = 0 ORDER BY u.login";
					 $Getlist=mysql_query($sql);
					$num_row=mysql_num_rows($Getlist);
					$maxscore=$grade->GetMaxscore($g_modules_id,$g_modules_type);
					 while($row=mysql_fetch_array($Getlist)){
							$login[]=$row["login"];
							$name[]=$row["firstname"]."\t".$row["surname"];
							$uid[]=$row["uid"];
							$raw_id[]=$row["rc"];
							if($row["rc"] != ""){
								$comment[]=$row["g_comment"];
								$score[]=$row["g_std_raw_score"];
							}else{
								$maxscore_user=$grade->GetScoreUser($row["uid"],$g_modules_id,$g_modules_type);
								if($maxscore_user=='-1'){
									$score[]=0;
									$comment[]="user นี้ยังไม่ทำการ ทดสอบ";
								}
								else{
									$score[]=$grade->ShowScore($maxscore,$max_score,$maxscore_user);
									$comment[]="";
								}
							}
					}
					$disabled="disabled";
				}else{
					$sql="SELECT DISTINCT  u.id AS uid,u.login,u.firstname,u.surname
					FROM  wp,users u, users_info uf
					WHERE wp.users=u.id AND wp.groups=".$g_id." AND wp.cases=0 AND wp.modules=0 AND wp.courses=0 AND u.active=1 AND u.id=uf.id AND wp.admin = 0  ORDER BY u.login, wp.admin desc, u.category,u.login";
					//echo $sql;
					 $Getlist=mysql_query($sql);
					 $num_row=mysql_num_rows($Getlist);
					 $maxscore=$grade->GetMaxscore($g_modules_id,$g_modules_type);
					 while($row=mysql_fetch_array($Getlist)){
							$login[]=$row["login"];
							$name[]=$row["firstname"]."\t".$row["surname"];
							$uid[]=$row["uid"];
							$sql=mysql_query("SELECT g_std_raw_score,g_comment,g_std_raw_score_id AS rc FROM g_std_raw_score WHERE g_std_users=".$row["uid"]." AND g_score_type_id = ".$id." ");
							if(mysql_num_rows($sql) !=""){
								$comment[]=mysql_result($sql,0,'g_comment');
								$score[]=mysql_result($sql,0,'g_std_raw_score');
								$raw_id[]=mysql_result($sql,0,'rc');
							}else{
								$maxscore_user=$grade->GetScoreUser($row["uid"],$g_modules_id,$g_modules_type);
									if($maxscore_user=='-1'){
										$score[]=0;
										$comment[]="user นี้ยังไม่ทำการ ทดสอบ";
									}
									else{
										$score[]=$grade->ShowScore($maxscore,$max_score,$maxscore_user);
										$comment[]="";
									}
							}							
					 }
					 $disabled="disabled";
				}
		}
  
  $i=1;
 

 
// while ($row = @mysql_fetch_array($Getlist)) { 
	for($ii=0;$ii<$num_row;$ii++){
	?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center"><? echo $ii+1;?></td>
    <td >
		<? //echo $row["login"];
			echo $login[$ii];
		?>
		
	</td>
   <td >
		<? 
			//echo $row["firstname"]."\t".$row["surname"];
			echo $name[$ii];
		?>
	</td>
   
   
    <td align="center">
		<input type="hidden"  name="userid[]" value="<? echo $uid[$ii];?>">
		<input type="hidden"  name="raw_id[]" value="<? echo $raw_id[$ii];?>"> 
		<input type="text" class="text" size="5" maxlength="6" name="score[]" id="g_score" value="<? echo $score[$ii]?>" <? echo $disabled?>>
		<input type="hidden"  name="h_score[]" value="<? echo $score[$ii]?>"> 
	</td>
	
   
    <td align="center">
	<input type="text" class="text" size="30" maxlength="100" name="comment[]" value="<? echo $comment[$ii];//echo $row["g_comment"]?>" >
	
	</td>
  </tr>
<?
//$i++;
}
?>
</table>
</form>
<div align="right"></div>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 
</table>


</body>
</html>