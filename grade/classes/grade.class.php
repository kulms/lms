<? 
require_once("DB.php");

class Grade {
//Nok create (28/03/05)
	function GetModulesType($modules_type){
		global $dsn;
				$db = DB::connect($dsn);
					if( DB::isError($db) ) {
					   die ($db->getMessage());
					}
		$sql="SELECT name  FROM modules_type  WHERE id=".$modules_type." ";
		$result = $db->getRow($sql);
		return $result; 
	}

	function GetGroup($group_id){
		global $dsn;
				$db = DB::connect($dsn);
					if( DB::isError($db) ) {
					   die ($db->getMessage());
					}
		$sql="SELECT name  FROM groups  WHERE id=".$group_id." ";
		$result = $db->getRow($sql);
		return $result; 
	}
	// end (28/03/05)

//31/06/05
	function GetMaxscore($modules_id,$modules_type){
		global $dsn;
				$db = DB::connect($dsn);
					if( DB::isError($db) ) {
					   die ($db->getMessage());
					}
		$maxscore="";
		switch ($modules_type){
			case '7':
				$sql="SELECT sum(points) as maxscore FROM homework WHERE modules=".$modules_id."";
				$query=mysql_query($sql);
				$totalscore=mysql_result($query,0,'maxscore');
				return $totalscore;
			break;
			case '5':
				$sql="SELECT qLIMIT,matching FROM q_module_prefs  WHERE module_id=".$modules_id."";
				$query=mysql_query($sql);
					$qlimit=mysql_result($query,0,'qLIMIT');
					$matching=mysql_result($query,0,'matching');

					//check num question
					$sql_num="SELECT * FROM q_modules_questions WHERE module_id=".$modules_id." ";
					$query_num=mysql_query($sql_num);
					$num_rows=mysql_num_rows($query_num);

					//check mcit
					$sql_mcit="SELECT q.question_id,q.score FROM q_modules_questions  mq,q_questions q WHERE q.question_id=mq.question_id AND mq.module_id=".$modules_id." AND q.question_type='mcit' ";  //select score mcit
					$query_mcit=mysql_query($sql_mcit);
					$num_mcit=mysql_num_rows($query_mcit);

					//check all not mcit
					$sql_n_mcit="SELECT q.question_id,q.score FROM q_modules_questions  mq,q_questions q WHERE q.question_id=mq.question_id AND mq.module_id=".$modules_id." AND q.question_type !='mcit'";
					$query_n_mcit=mysql_query($sql_n_mcit);
					$num_n_mcit=mysql_num_rows($query_n_mcit);
					
					if($num_rows == 0){
						$totalscore=0;
						//exit;
					}else{
						if($matching ==0){
							if($num_n_mcit <($qlimit-1)){
								$totalscore=0;
							//	exit;
							}else{
								$score_no_mcit=mysql_result($query_n_mcit,0,'score');
								$totalscore=$score_no_mcit*($qlimit);
							}
						}else{
							if($num_n_mcit <($qlimit-1)){
								$totalscore=0;
							//	exit;
							}else{
								if($num_mcit ==0){
									$totalscore=0;
								//	exit;
								}else{
									$score_mcit=mysql_result($query_mcit,0,'score');
									$qid_mcit=mysql_result($query_mcit,0,'question_id');
									$sql_num_mcit=mysql_query("SELECT mcit_id FROM q_question_mcit WHERE question_id=".$qid_mcit." ");
									$num_mcit_q=mysql_num_rows($sql_num_mcit);
									$Tscore_mcit=$score_mcit*$num_mcit_q;
								}

								$score_no_mcit=mysql_result($query_n_mcit,0,'score');
								$Tscore_no_mcit=$score_no_mcit*($qlimit-1);

								$totalscore=$Tscore_mcit+$Tscore_no_mcit;
							}
						}
					}
					return $totalscore;
			break;
		}
		
	}

	function GetScoreUser($userid,$modules_id,$modules_type){
		global $dsn;
				$db = DB::connect($dsn);
					if( DB::isError($db) ) {
					   die ($db->getMessage());
					}
		switch($modules_type){
			case '7':
				$sql="SELECT sum(marks) FROM homework_ans WHERE modules=".$modules_id." AND users=".$userid." ";
				$query=mysql_query($sql);
				if(mysql_num_rows($query) !=0)
					$score=mysql_result($query,0,'sum(marks)');
				else
					$score=-1;
				return $score;
			break;
			case '5':
				$sql="SELECT user_sum_score FROM q_occasions  WHERE module_id=".$modules_id." AND user_id=".$userid." ";
				$query=mysql_query($sql);
				if(mysql_num_rows($query) !=0)
					$score=mysql_result($query,0,'user_sum_score');
				else
					$score=-1;
				return	$score;
			break;
		}
		
	}

	function ShowScore($maxscore,$g_maxscore,$score_user){
		if($maxscore !=0)
			$score=($score_user*$g_maxscore)/$maxscore;
		else
			$score=0;
		return $score;
	}

//end 31/03/05

//Create by Bank
function check_score($id){

$total = mysql_query("select  g_score_type_g_id ,g_max_score,
sum(if(g_score_type_g_id=0,g_max_score,0)) as a
 from g_score_type where g_grade_id = ".$id." group by g_score_type_g_id ");

$gd_score = 0;

while ($rs = mysql_fetch_array($total)) { 


 if($rs[0] ==0) {
   
 
  $gd_score = $gd_score + $rs[2];
	}else{
       
	   $gd_score = $gd_score+$rs[1];

		}

	}

return $gd_score;

}





}
?>