<? 
require_once("DB.php");

class Quiz {
		var $q_id = NULL;                         //Quizid
		var $modules = NULL;					//Courses 
		var $courses = NULL;			       //Modules  

		function Quiz($qid,$modules,$courses) 
		{
			$this->q_id 	   = $qid;
			$this->modules =$modules;
			$this->courses    = $courses;
		}

		function getQId(){
			return $this->q_id;
		}

		function getModules(){
			return $this->modules;
		}

		function getCourses(){
			return $this->courses;
		}

	   function getQuizInfo($quiz){
			global $dsn;
			$db = DB::connect($dsn);
				if( DB::isError($db) ) {
				   die ($db->getMessage());
				}
			$sql="SELECT qp.info,qp.end_date, m.name,m.users,m.active,qp.quiztype,qp.view,qp.endview,qp.timeLimited,qp.multiple,qp.grading   FROM q_module_prefs qp, modules m WHERE qp.module_id=".$quiz->getModules()." AND m.id=".$quiz->getModules()." ";
			$result = $db->getRow($sql);
			return $result; 
	}
	  
	function getCountRun($quiz){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
				 die ($db->getMessage());
			}
		$all_occ="SELECT occasion_id AS id from q_occasions WHERE module_id=".$quiz->getModules()." ORDER BY occasion_id ASC;";
		$result = $db->query($all_occ);
		$all_arr=array();
		$a=0;
			while($all_row=$result->fetchRow(DB_FETCHMODE_ASSOC)){
				$all_arr[$a]=$all_row["id"];
				$a++;
			}
		//echo sizeof($all_arr);
			if(sizeof($all_arr)!=0){
				$avg = "SELECT DISTINCT occasion_id FROM q_user_questions WHERE occasion_id IN (".implode($all_arr,",").");";
				$result = $db->query($avg);
				$cnt = $result->numRows();	
			}else{
				$cnt=0;
			}
		return $cnt;
	}

	function getCountUser($quiz){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
				 die ($db->getMessage());
			}
		$userCount ="SELECT DISTINCT user_id AS users FROM q_occasions WHERE module_id=".$quiz->getModules()."";
		$result = $db->query($userCount);
		return $result;
	}

	function getCountNum($quiz){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
				 die ($db->getMessage());
			}
		$sql="SELECT DISTINCT mq.question_id as questions FROM q_modules_questions mq, q_user_questions usa, q_occasions o WHERE usa.question_id=mq.question_id AND mq.module_id=".$quiz->getModules()." AND usa.occasion_id=o.occasion_id AND o.module_id=".$quiz->getModules()."";
		$result = $db->query($sql);
		return $result;
	}

	function ListQuizAll($quiz,$page,$pagesize){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
				 die ($db->getMessage());
			}
		//page
		//$pagesize=5;
		if (isset($page)){
						$start = $pagesize * ($page -1);
			}else{
						$page =1;
						$start=0;
			}		
		$numRow = " LIMIT ".$start.", ".$pagesize;
		$sql="SELECT DISTINCT mq.question_id as qid FROM q_modules_questions mq, q_user_questions usa, q_occasions o WHERE usa.question_id=mq.question_id AND mq.module_id=".$quiz->getModules()." AND usa.occasion_id=o.occasion_id AND o.module_id=".$quiz->getModules()." ".$numRow." ";
		$result = $db->query($sql);
		
		return $result;
	}

	function getQuizDetail($Qid){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
				 die ($db->getMessage());
			}
		 $quest=mysql_query("SELECT question, question_type, correct_answer,comment ,attached_file FROM q_questions WHERE question_id=".$Qid."");
		$result = $db->query($sql);
		return $result;		
	}

	//View
	function SelectQuizAll($quiz){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql = "SELECT question_id FROM q_modules_questions WHERE module_id =".$quiz->getModules()."";
		$result = $db->query($sql);
		$num=$result->numRows();
		return $num;	
	}
	
	function SelectQuiz($quiz,$page){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
				 die ($db->getMessage());
			}
		//page
		$pagesize=25;
		if (isset($page)){
						$start = $pagesize * ($page -1);
			}else{
						$page =1;
						$start=0;
			}	
		$numRow = " LIMIT ".$start.", ".$pagesize;
		$sql = "SELECT q.*,m.name,i.info QuizInfo,mq.makecopy FROM q_questions q, q_modules_questions mq, modules m,q_module_prefs i WHERE mq.module_id=".$quiz->getModules()." AND q.question_id=mq.question_id AND m.id=".$quiz->getModules()."  AND i.module_id =".$quiz->getModules()." ORDER BY q.question_id ".$numRow ."";
		$result = $db->query($sql);
		return $result;

	}

	
	function SearchAll($searchtype,$qry,$personID){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
				 die ($db->getMessage());
			}
		  if($searchtype=="any"){         //search for every word, any-search
        //******************************************
        //                split string into words
        //******************************************
                $qry=trim($qry);
                $string=explode(" ",$qry);
                $cnt=0;
                $result=array();
                for($a=0;$a<sizeof($string);$a++){
                       $sql="SELECT question_id as id FROM q_questions WHERE (categories like'%".$string[$a]."%'   OR question like'%".$string[$a]."%') AND created_by=".$personID." ORDER BY question_id";
                        $find=mysql_query($sql);
                        if(mysql_num_rows($find)!=0){
                                while($row=mysql_fetch_array($find)){
                                        $stop=0;
                                        for($i=0;$i<sizeof($result);$i++){
                                                if($result[$i]==$row["id"]){
                                                        $stop=1;
                                                }
                                        }//end for
                                        if($stop==0){
                                                $result[]=$row["id"];
                                        }
                                }//end while
                        }//end if
                }//end for
        }//end if=="any"
        else{        //search for ALL words i.e phrase
                $qry=trim($qry);
                $string=$qry;
                $cnt=0;
                 $sql="SELECT question_id as id FROM q_questions WHERE (categories like'%".$string."%'  OR question like'%".$string."%') AND created_by=".$person["id"]." ORDER BY question_id";
                $find=mysql_query($sql);
                if(mysql_num_rows($find)!=0){
                        while($row=mysql_fetch_array($find)){
                                $stop=0;
                                for($i=0;$i<sizeof($result);$i++){
                                        if($result[$i]==$row["id"]){
                                                $stop=1;
                                        }
                                }//end for
                                if($stop==0){
                                        $result[]=$row["id"];
                                }
                        }//end while
                }//end if
        }//end else=="any"
	return array(sizeof($result),$result);
	}

	function SearchPage(){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
				 die ($db->getMessage());
			}
		//page
		$pagesize=25;
		if (isset($page)){
						$start = $pagesize * ($page -1);
			}else{
						$page =1;
						$start=0;
			}	
		$numRow = " LIMIT ".$start.", ".$pagesize;
		$get_q=mysql_query("SELECT q.question,q.question_type,m.module_id FROM q_questions q ,q_modules_questions m WHERE q.question_id=".$result[$a]." AND q.question_id=m.question_id AND m.makecopy <> 1;");
	}

	function Page($quiz,$num,$page,$pagesize)
	{
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		//page
	//		$result = $db->query($sql);
		//	$num = $result->numRows();	
	//	$pagesize=5;
		$totalpage =(int)($num/$pagesize);
		if (($num % $pagesize) != 0)
				{
						$totalpage += 1;
				}

			if (isset($page)){
						$start = $pagesize * ($page -1);
			}else{
						$page =1;
						$start=0;
			}	
		return array($page,$totalpage);
	}

	function imageResize($width, $height, $target) { 
		if ($width > $height) { 
			$percentage = ($target / $width); 
		} else { 
			$percentage = ($target / $height); 
		} 
	$width = round($width * $percentage); 
	$height = round($height * $percentage); 
	return "width=\"$width\" height=\"$height\""; 
	} 

	//User
	function CheckOutTime($quiz){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$date=time();
		$sql="SELECT pref_id  FROM q_module_prefs WHERE module_id=".$quiz->getModules()." AND end_date < ".$date." AND end_date !=0 ";
		$result = $db->query($sql);
		$num=$result->numRows();
		return $num;	 //(0=no,1=yes)
	}

	function CheckOcc($quiz,$userid){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql="SELECT occasion_id FROM  q_occasions WHERE  module_id=".$quiz->getModules()." AND user_id=".$userid."  ";
		$result = $db->query($sql);
		$num=$result->numRows();
		return $num;	  //(0=no,1=yes)
	}

	function getOcc($quiz,$userid){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql="SELECT occasion_id FROM q_occasions  WHERE module_id=".$quiz->getModules()." AND user_id=".$userid." AND finished=0";
		$result = $db->getRow($sql);
		return $result; 
	}

	function CheckFinished($quiz,$userid){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql="SELECT occasion_id FROM q_occasions  WHERE module_id=".$quiz->getModules()." AND user_id=".$userid." AND finished=0";
		$result = $db->query($sql);
		$num=$result->numRows();
		return $num;	  //(0=no,1=yes)
	}

	function CheckQuizNum($quiz){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql="SELECT qLIMIT FROM q_module_prefs WHERE module_id=".$quiz->getModules()." ";
		$result = $db->getRow($sql);
		return $result; 
	}

	function CheckQuizNum_($quiz){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql="SELECT * FROM q_modules_questions WHERE module_id =".$quiz->getModules()." ";
		$result = $db->query($sql);
		$num=$result->numRows();
		return $num;	
	}
	
	//22/03/05 update
		function CheckScore($quiz)
	{
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql="SELECT DISTINCT q.score  FROM q_questions q, q_modules_questions mq, modules m,q_module_prefs i WHERE mq.module_id=".$quiz->getModules()." AND q.question_id=mq.question_id AND m.id=".$quiz->getModules()."  AND i.module_id =".$quiz->getModules()." AND q.question_type !='mcit' ";
		$result = $db->query($sql);
		return $result;	
	}

	function GetMcit($quiz){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql="SELECT q.* FROM q_questions q, q_modules_questions mq, modules m,q_module_prefs i WHERE mq.module_id=".$quiz->getModules()." AND q.question_id=mq.question_id AND m.id=".$quiz->getModules()."  AND i.module_id =".$quiz->getModules()." AND q.question_type='mcit' ";
		$result = $db->query($sql);
		return $result; 
	}
	//22/03/05

	function CheckUse($quiz){
	    global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql="SELECT o.* FROM q_modules_questions mq,q_occasions o,q_user_questions uq WHERE mq.question_id=uq.question_id AND mq.module_id=o.module_id  AND o.occasion_id=uq.occasion_id AND mq.module_id= ".$quiz->getModules()." AND mq.question_id= ".$quiz->getQId()."  ";
		$result = $db->query($sql);
		$num=$result->numRows();
		return $num;	
	}

	//29/03/05 update

	//

	//===============function user
	function getUserID($quiz,$desc){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql = "SELECT DISTINCT u.id FROM users u, q_occasions o WHERE u.id=o.user_id AND o.module_id=".$quiz->getModules()." ORDER BY u.firstname ".$desc." ";
		$result = $db->query($sql);
		return $result; 
	}



	function getUserIDByScore($quiz,$desc){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql="SELECT u.id FROM  users u, q_occasions o WHERE u.id=o.user_id AND o.module_id=".$quiz->getModules()." ORDER BY o.user_sum_score ".$desc." ";
		echo $sql;
		$result = $db->query($sql);
		return $result; 
	}

	function getOccID($quiz,$userid){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql="SELECT occasion_id FROM q_occasions  WHERE module_id=".$quiz->getModules()." AND user_id=".$userid." AND finished=1";
		$result = $db->query($sql);
		while($rs=$result->fetchRow(DB_FETCHMODE_ASSOC)){
			$occ_id[]=$rs['occasion_id'];
		}
		return array($occ_id); 
	}

	function getScore($quiz,$occid,$order){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql = "SELECT finished_datetime as times,total_score,user_sum_score as user_score, occasion_id FROM q_occasions  WHERE occasion_id IN(".$occid.") GROUP BY occasion_id ".$order."";
		//echo $sql;
		$result = $db->query($sql);
		while($rs=$result->fetchRow(DB_FETCHMODE_ASSOC)){
			$datetime[]=$rs['times'];
			$total_score[]=$rs['total_score'];
			$user_score[]=$rs['user_score'];
			$occ_id[]=$rs['occasion_id'];
			if($rs['total_score']=="" || $rs['total_score']==0){
					$percent[] = 0;
			}else{
					$percent[] = number_format(($rs['user_score']/$rs['total_score'])*100,2,".",".");
			}
			if($rs['user_score']==""){
					$user_score[] = 0;
			}
		}
		return array($datetime,$total_score,$user_score,$percent,$occ_id);
	}

	
}//end class

?>