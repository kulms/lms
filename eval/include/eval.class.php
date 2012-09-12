<? 
require_once("DB.php");
session_start();
class Evaluate{

	var $person_id = NULL;
	var $module_id = NULL;
	var $course = NULL;
	
		function Evaluate($module_id,$course,$person_id){
			$this->person_id = $person_id;
			$this->module_id = $module_id;
			$this->course = $course;
				
		}
		function getModule(){
			return $this->module_id;
		}
		function getCourse(){
			return $this->course;
		}
		function getPersonID(){
			return $this->person_id ;
		}
		//------------------------Student-------------------------------
		
function GetModuleOwner($evaluate){
	global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			$module_id =$evaluate->getModule();
					$sql = "SELECT  users
							FROM modules 
							WHERE id= '$module_id' ";
					$rs = mysql_query($sql);
					$arr=mysql_fetch_array($rs);
					return $arr[users];
}


function GetDetailPerson($evaluate,$users)
	{
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			
			$module_id =$evaluate->getModule();
					$sql = "SELECT  id,firstname,surname,email,category,admin 
							FROM users 
							WHERE id= '$users' ";
					$rs = mysql_query($sql);
							
					 while($arr=mysql_fetch_array($rs)){
							$id = $arr[id];
							$firstname= $arr[firstname];
							$surname= $arr[surname];
							$email= $arr[email];
							$category= $arr[category];
							$admin= $arr[admin];
									
					}
				return array($id,$firstname,$surname,$email,$category,$admin);
		}

function GetstdNotEval($evaluate,$users){
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			
			$module_id =$evaluate->getModule();
					$sql = "SELECT ans_id
					FROM eval_usrd_answers   
					WHERE modules_id='$module_id'
					AND users_id='$users';";
			$rs = mysql_query($sql);
			
			$num = mysql_num_rows($rs);
			if($num >0){
					return true;
			}else{
					return false;
			}

}
function GetstdOfCourse($evaluate)
	{
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			
			$module_id =$evaluate->getModule();
			
			$sqlm = "SELECT users FROM modules WHERE id='$module_id'";
			$rsm = mysql_query($sqlm);
			$tea = mysql_fetch_array($rsm);
			$owner = $tea[users];
					$sql = "SELECT DISTINCT users
							FROM wp 
							WHERE courses = ".$evaluate->getCourse()."  
							AND users<>'$owner'"
							;//AND admin=0 
					$rs = mysql_query($sql);
							
						 while($arr=mysql_fetch_array($rs)){
									$users[] = $arr[users];
							}
					return array($users);
		}
							
		function AlreadyEval($evaluate,$m_id){
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			$person = $evaluate->getPersonID();
			$sql = "SELECT ans_id
					FROM eval_usrd_answers   
					WHERE modules_id='$m_id'
					AND users_id='$person';";
			$rs = mysql_query($sql);
			
			$num = mysql_num_rows($rs);
			if($num >0){
					return true;
			}else{
					return false;
			}
		
		}
		
		function AnswerOfPerson($evaluate,$q_id,$std){
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			$m_id = $evaluate->getModule();
			$person = $evaluate->getPersonID();
			if($std==1){
					$com = "AND std_q='1'";
							
			}else{
					$com = "AND std_q='0'";
			}
			$sql = "SELECT scores,txt_answer
					FROM eval_usrd_answers 
					WHERE modules_id='$m_id'
					AND users_id='$person'
					AND q_id = '$q_id' ".$com;
			$rs = mysql_query($sql);
			
				$arr=mysql_fetch_array($rs);
						$score = $arr[scores];
						$txt_answer =$arr[txt_answer];
			
			return array($score,$txt_answer);
		
		}
		
	function GetSurveyAnswer($evaluate,$user,$qid){
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			$m_id = $evaluate->getModule();
			
			if($qid) $cmd ="AND q_id='$qid'";
			  else $cmd = "ORDER BY q_id ASC ";
			
			$sql = "SELECT q_id,scores
					FROM eval_usrd_answers 
					WHERE modules_id='$m_id'
					AND users_id='$user' ".$cmd ; 
					        //echo $sql;
			$rs = mysql_query($sql);  
			
			while($arr=mysql_fetch_array($rs)){
						$q_id[] = $arr[q_id];
						$score[] = $arr[scores];
			}
		return array($q_id,$score);
	}
	
	function GetSurveyStudent($evaluate){
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			$m_id = $evaluate->getModule();
			$sql = "SELECT DISTINCT users_id
					FROM eval_usrd_answers 
					WHERE modules_id='$m_id'";
			$rs = mysql_query($sql);  
			while($arr=mysql_fetch_array($rs)){
						$users_id[] = $arr[users_id];
			}
		return array($users_id);
   }
   
   function GetPreference($a_id,$a_score){
   
   	$sum_vis =0; $sum_tac=0;$sum_aud=0;$sum_grp =0;$sum_kin=0;$sum_ind =0;
	
   		for($z=0;$z<count($a_id);$z++){
				if($a_id[$z]){
									if($a_id[$z]=='6' || $a_id[$z]=='10' || $a_id[$z]=='12' || $a_id[$z]=='24' || $a_id[$z]=='29'){   //  visual
												$sum_vis =  $sum_vis + $a_score[$z];
												
										}else if($a_id[$z]=='11' || $a_id[$z]=='14' || $a_id[$z]=='16' || $a_id[$z]=='22' || $a_id[$z]=='25'){  // Tactile
												$sum_tac =  $sum_tac + $a_score[$z];
										}else if($a_id[$z]=='1' || $a_id[$z]=='7' || $a_id[$z]=='9' || $a_id[$z]=='17' || $a_id[$z]=='20'){  //Auditory
												$sum_aud=  $sum_aud + $a_score[$z];
										}else if($a_id[$z]=='3' || $a_id[$z]=='4' || $a_id[$z]=='5' || $a_id[$z]=='21' || $a_id[$z]=='23'){   // Group
												$sum_grp =  $sum_grp+ $a_score[$z];
										}else if($a_id[$z]=='2' || $a_id[$z]=='8' || $a_id[$z]=='15' || $a_id[$z]=='19' || $a_id[$z]=='26'){ // Kinesthetic
												$sum_kin =  $sum_kin + $a_score[$z];
										}else if($a_id[$z]=='13' || $a_id[$z]=='18' || $a_id[$z]=='27' || $a_id[$z]=='28' || $a_id[$z]=='30'){  // Individual
												$sum_ind =  $sum_ind + $a_score[$z];
										}
						}
				} // for
//echo $sum_vis;
$sum_vis = $sum_vis*2;
 $sum_tac= $sum_tac*2;
 $sum_aud= $sum_aud*2;
 $sum_grp =$sum_grp*2;
 $sum_kin=$sum_kin*2;
 $sum_ind =$sum_ind*2;

 // =======  Visual================
 if($sum_vis>=38 && $sum_vis<51){
		 $major = "Visual";
 }else if($sum_vis>=25 && $sum_vis<38){
 		$minor = "Visual";
 }
 
    // =======  Tactile================
 if($sum_tac>=38 && $sum_tac<51){
		 $major = "Tactile";
 }else if($sum_tac>=25 && $sum_tac<38){
 		$minor = "Tactile";
 }

  // =======  Auditory================
 if($sum_aud>=38 && $sum_aud<51){
		 $major = "Auditory";
 }else if($sum_aud>=25 && $sum_aud<38){
 		$minor = "Auditory";
 }
  // =======  Group ================
 if($sum_grp>=38 && $sum_grp<51){
		 $major = "Group";
 }else if($sum_grp>=25 && $sum_grp<38){
 		$minor = "Group";
 }
  // =======  Kinesthetic================
 if($sum_kin>=38 && $sum_kin<51){
		 $major = "Kinesthetic";
 }else if($sum_kin>=25 && $sum_kin<38){
 		$minor = "Kinesthetic";
 }
  // =======  Individual================
 if($sum_ind>=38 && $sum_ind<51){
		 $major = "Individual";
 }else if($sum_ind>=25 && $sum_ind<38){
 		$minor = "Individual";
 }
  // =======================================
  
  if(!$major)  $major="None";
    if(!$minor)  $minor="None";
	
	return array($major,$minor);
   
} //close
   
   
function getModuleEval($evaluate,$do){
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			$person = $evaluate->getPersonID();
			$today =  date("Y-m-d H:i:s");
			
			if($do==1){
					$table =",eval_usrd_answers  a ";
					$cmd ="AND a.modules_id=s.modules_id 
							AND a.users_id='$person'
							AND a.ans_id !='' ";
			}else{ // NOT do EVALUATE
					$table ="";
					$cmd = "AND s.end_date >='$today' ";
			}
			$sql = "SELECT m.name,s.*
					FROM modules m,eval_q_set s ".$table." 
					WHERE m.courses = ".$evaluate->getCourse()."   
					AND m.modules_type ='8' 
					AND s.modules_id = m.id
					".$cmd."
					AND m.active='1' 
					GROUP BY s.modules_id 
					ORDER BY m.created ASC";
			$rs = mysql_query($sql);
			//echo $sql."<br>";
			
			while($arr=mysql_fetch_array($rs)){
				if($do==1){
						$modules_id[] = $arr[modules_id];
						$m_name[] =$arr[name];
						$eval_type[] =$arr[eval_type];
						$info[] =$arr[info];
						$courses_id[] = $arr[courses_id];
						$semester[] =$arr[semester];
						$year[] =$arr[year];
						$start_date[] =$arr[start_date];
						$end_date[] =$arr[end_date];
						$show_std[] =$arr[show_std];
					}else{
						$no = $evaluate->AlreadyEval($evaluate,$arr[modules_id]);
						if($no == false){
							$modules_id[] = $arr[modules_id];
							$m_name[] =$arr[name];
							$eval_type[] =$arr[eval_type];
							$info[] =$arr[info];
							$courses_id[] = $arr[courses_id];
							$semester[] =$arr[semester];
							$year[] =$arr[year];
							$start_date[] =$arr[start_date];
							$end_date[] =$arr[end_date];
							$show_std[] =$arr[show_std];
						}
					}
			}
			return array($modules_id,$m_name,$eval_type,$info,$courses_id,$semester,$year,$start_date,$end_date,$show_std);
		}
		
		
		
function GetSTDStandardQuestion($evaluate)
	{
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			
			$module_id =$evaluate->getModule();
					$sql = "SELECT eq.q_id,eq.alt_id,eq.question,g.g_id
							FROM eval_usrd_questions eq,eval_usrd_group g,modules m 
							WHERE m.id ='$module_id' 
							AND m.users = g.users_id 
							AND g.modules_id = '$module_id' 
							AND g.g_name = eq.q_id 
							AND eq.users_id ='-1' 
							AND eq.std_q = '1'  
							AND eq.active = '1' 
							ORDER BY g.g_order ASC ";
					$rs = mysql_query($sql);
							
							 while($arr=mysql_fetch_array($rs)){
							  	$q_id[] = $arr[q_id];
								$alt_id[] = $arr[alt_id];
								$question[] = $arr[question];
								$g_id[] = $arr[g_id];
							}
					    return array($q_id,$alt_id,$question,$g_id);
					
		} // closeFunction
		
		function GetStdGroupQuestion($evaluate)
	{
		global $dsn;
		
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		
		$module_id =$evaluate->getModule();
		
				$sql = "SELECT g.g_id,g.g_name,g.g_order
							FROM eval_usrd_group g,modules m 
							WHERE m.id ='$module_id' 
							AND m.users = g.users_id 
							AND g.modules_id = '$module_id' 
							ORDER BY g_order ASC ";
				$rs = mysql_query($sql);
				 while($arr=mysql_fetch_array($rs)){
					 @list($q_id,$alt_id,$question) = $evaluate->GetStudentQuestion($evaluate,$arr[g_id],false);
							 if(count($q_id)>0){
								 $g_id[] = $arr[g_id];
								 $g_name[] = $arr[g_name];
								 $g_order[] = $arr[g_order];
							 }
						
					 }
		 return array($g_id,$g_name,$g_order);
	}
	
		
function GetStudentQuestion($evaluate,$g_id,$cat_id)
	{
		global $dsn;
		
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		//$person = $evaluate->getPersonID(); 
		$module_id =$evaluate->getModule();
				if($cat_id == false){
							$sql = "SELECT *
									FROM eval_usrd_questions eq
									WHERE eq.g_id = '$g_id'
									AND eq.std_q ='0'
									AND eq.active = '1'
									ORDER BY eq.q_id ASC ";
				}else{
							$sql = "SELECT *
									FROM eval_usrd_questions eq
									WHERE eq.g_id = '$g_id'
									AND eq.cat_id = '$cat_id'
									AND eq.std_q ='0'
									AND eq.active = '1'
									ORDER BY eq.q_id ASC ";
				} 
							$rs = mysql_query($sql);
							 while($arr=mysql_fetch_array($rs)){
							  	$q_id[] = $arr[q_id];
								$alt_id[] = $arr[alt_id];
								$question[] = $arr[question];
							}
							
		return array($q_id,$alt_id,$question);
	}
	
	function InsertAnswer($evaluate,$q_id,$scores,$txt_answer,$std){ // q_id  Or g_id for standard Q
		
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			$person = $evaluate->getPersonID(); 
			$modules_id = $evaluate->getModule(); 
			
			$sql ="INSERT INTO eval_usrd_answers (ans_id,q_id,users_id,modules_id,scores,txt_answer,std_q) 
					VALUES ('', '$q_id','$person' ,'$modules_id','$scores','$txt_answer','$std')";

			$rs = mysql_query($sql);
			if(isset($rs)){
						return true;
			
			}
		}
	
		//------------------------Student-------------------------------
		
		function computeScore($evaluate,$std){
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			$module_id =$evaluate->getModule();
			
				$sql ="SELECT scores  
						FROM eval_usrd_answers 
						WHERE modules_id='$module_id' 
						AND scores <> '0' 
						AND std_q='$std'";
				$rs = mysql_query($sql);
				 while($arr=mysql_fetch_array($rs)){
						 $score[]=$arr[scores];
						
					}
							
			return array($score);
		
		}
		function getNumUser($evaluate,$std){
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			$module_id =$evaluate->getModule();
			
				$sql ="SELECT COUNT(DISTINCT users_id) as num 
						FROM eval_usrd_answers 
						WHERE modules_id='$module_id' 
						AND scores <> '0' 
						AND std_q='$std'";
				$rs = mysql_query($sql);
				$arr=mysql_fetch_array($rs);
			return $arr[num];
		}


		function DeleteAny($g_id,$q_id){
		
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
				if($g_id !=""){
						$sql ="DELETE FROM eval_usrd_group
								WHERE g_id = '$g_id'";
						$sql2 ="DELETE FROM eval_usrd_questions
								WHERE g_id = '$g_id'";
					$rs = mysql_query($sql);
					$rs2 = mysql_query($sql2);
					
				}else if($q_id !=""){
						$sql ="DELETE FROM eval_usrd_questions
								WHERE q_id = '$q_id'";
					$rs = mysql_query($sql);
				}

		}
		
		function DeleteAnswer($evaluate,$q_id){
		
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
				$module_id =$evaluate->getModule();
						$sql ="DELETE FROM eval_usrd_answers
								WHERE q_id = '$q_id' 
								AND modules_id='$module_id' ";
						
					$rs = mysql_query($sql);
	}
					
		
		function getCourseName($c_id){
		
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			$sql ="SELECT * 
					FROM courses
					WHERE id = '$c_id' ";
					
			$rs = mysql_query($sql);
			$arr=mysql_fetch_array($rs);
			return $arr[name];
			
		}
		
		function AddGroupQ($evaluate,$g_name,$module_id){
		
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			$person = $evaluate->getPersonID();
			$sql ="SELECT MAX(g_order) as maxo
					FROM eval_usrd_group
					WHERE modules_id='$module_id'
					AND users_id='$person'";
					
			$rs = mysql_query($sql);
			$arr=mysql_fetch_array($rs);
			if($arr[maxo]!=""){
					$order = $arr[maxo]+1;
			}else{
					$order = 1;
			}
				$sql ="INSERT INTO eval_usrd_group(g_id,g_name,modules_id,users_id,g_order) 
						VALUES ('','$g_name','$module_id','$person','$order')";
						
				$rs = mysql_query($sql); 
				$g_id =mysql_insert_id();
		return $g_id;

		}
		function Insert_Alt($evaluate,$alt1,$alt2,$alt3,$alt4,$alt5,$res1,$res2,$res3,$res4,$res5){
		
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			$person = $evaluate->getPersonID(); 
			$sql ="INSERT INTO eval_usrd_alternatives (alt_id,users_id,alt1,alt2,alt3,alt4,alt5,res1,res2,res3,res4,res5,std_alt) 
					VALUES ('', '$person','$alt1' ,'$alt2','$alt3','$alt4','$alt5','$res1','$res2','$res3', '$res4' ,'$res5','0')";

			$rs = mysql_query($sql);
			
		
		}

	function InsertQuestion($evaluate,$person,$alt_id,$g_id,$question,$cat_id,$std_q,$survey,$active){
	
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			if($person != -1) $person = $evaluate->getPersonID(); 
			if($active=='')
				$active =1;  // Active Now
			else
				$active=$active;
			
			if($survey==1){
					$rs = mysql_query("SELECT max(q_order) as max FROM eval_usrd_questions");
					$arr=mysql_fetch_array($rs);
					$order=$arr['max']+1;
			}else{
					$order =0;
			}
			$sql ="INSERT INTO eval_usrd_questions(q_id,alt_id,users_id,g_id,question,cat_id,std_q,is_perceptual,q_order,active) 
					VALUES ('','$alt_id','$person','$g_id','$question','$cat_id','$std_q','$survey','$order','$active')";
			
			$rs = mysql_query($sql);
			//echo $sql;
				
	}
	
	function GetAltStd($evaluate,$alt_id){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			$person = $evaluate->getPersonID(); 
			$sql ="SELECT * 
					FROM eval_usrd_alternatives 
					WHERE (users_id = '-1' AND std_alt = '1')
					OR (users_id='$person' AND std_alt = '0')";
					
			$rs = mysql_query($sql);
			 while($arr=mysql_fetch_array($rs)){
			 if(mysql_num_rows($rs)>0){
				 if($arr[alt_id]==$alt_id){
						$x ="selected";
				}else
					$x = "";
			 	 $name_alt .="<option value=\"{$arr[alt_id]}\" $x>";
					for($i=1;$i<=5;$i++){
						if($arr["alt".$i] !=""){
							 $name_alt .= $arr["alt".$i]."[".$arr["res".$i]."]";
					  	}
						
					}
				 $name_alt .="</option>";   
				}        
				 
			}
		return $name_alt ;
	}

	function GetAltOfQ($evaluate,$alt_id){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			$person = $evaluate->getPersonID(); 
				$sql =	"SELECT *
						FROM eval_usrd_alternatives
						WHERE alt_id = '$alt_id' ";
					
			$rs = mysql_query($sql);
			$arr=mysql_fetch_array($rs);
				 $alt1 = $arr[alt1];
				 $alt2 = $arr[alt2];
				 $alt3 = $arr[alt3];
				 $alt4 = $arr[alt4];
				 $alt5 = $arr[alt5];
				 $res1 = $arr[res1];
				 $res2 = $arr[res2];
				 $res3 = $arr[res3];
				 $res4 = $arr[res4];
				 $res5 = $arr[res5];
				
		 return array($alt1,$alt2,$alt3,$alt4,$alt5,$res1,$res2,$res3,$res4,$res5);
			
		}
		
	function GetGroupQuestion($evaluate)
	{
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		 $person = $evaluate->GetModuleOwner($evaluate);  
		$module_id =$evaluate->getModule();
		
				$sql = "SELECT * 
						FROM eval_usrd_group
						WHERE modules_id = '$module_id'
						AND users_id='$person'
						ORDER BY g_order ASC ";
				$rs = mysql_query($sql);
				 while($arr=mysql_fetch_array($rs)){
				 @list($q_id,$alt_id,$question) = $evaluate->GetQuestion($evaluate,$arr[g_id],false);
						 if(count($q_id)>0){
								 $g_id[] = $arr[g_id];
								 $g_name[] = $arr[g_name];
						 }
						
					 }
		 return array($g_id,$g_name);
	}
	
	
	function CheckGroupRepeated($evaluate,$stdq_id)
		{
		global $dsn;
		
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		 $person = $evaluate->GetModuleOwner($evaluate); 
		$module_id =$evaluate->getModule();
		
				$sql = "SELECT g_id 
						FROM eval_usrd_group
						WHERE modules_id = '$module_id'
						AND g_name='$stdq_id'
						AND users_id='$person'";
				$rs = mysql_query($sql);
				$num =mysql_num_rows($rs);
		 return $num;
	}

	
	function updateQuestion($q_id,$alt_id,$newq,$cat_id,$survey,$active)
	{
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
				
				$sql = "UPDATE eval_usrd_questions 
						SET alt_id='$alt_id',
						question ='$newq',
						cat_id='$cat_id',
						is_perceptual='$survey',
						active='$active'
						WHERE q_id = '$q_id'";
				$rs = mysql_query($sql);
	}
	
									
function updateGroup($g_id,$g_name)
	{
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
				
				$sql = "UPDATE eval_usrd_group 
						SET g_name='$g_name' 
						WHERE g_id = '$g_id'";
						
				$rs = mysql_query($sql);
	}
	

function GetQuestionOfTeacher($evaluate,$cat)
	{
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			 $person = $evaluate->GetModuleOwner($evaluate); 
			
							$sql = "SELECT  q_id,alt_id,question,active
									FROM eval_usrd_questions
									WHERE users_id='$person'
									AND cat_id='$cat' 
									AND std_q = '0' 
									GROUP BY question
									ORDER BY alt_id ASC ";
									
							$rs = mysql_query($sql);
							//echo $sql ;
							 while($arr=mysql_fetch_array($rs)){
										$q_id[] = $arr[q_id];
										$alt_id[] = $arr[alt_id];
										$question[] = $arr[question];
										$active[] = $arr[active];
							}
		    return array($q_id,$alt_id,$question,$active);
						
	}					
						
	function GetQuestion($evaluate,$g_id,$cat_id)
	{
		global $dsn;
		
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		 $person = $evaluate->GetModuleOwner($evaluate); 
		$module_id =$evaluate->getModule();
				if($cat_id == false){
							$sql = "SELECT *
									FROM eval_usrd_questions eq
									WHERE eq.users_id ='$person' 
									AND eq.g_id = '$g_id' 
									AND eq.active = '1' 
									ORDER BY eq.q_id ASC ";
				}else{
							$sql = "SELECT *
									FROM eval_usrd_questions eq
									WHERE eq.users_id ='$person' 
									AND eq.g_id = '$g_id'
									AND eq.cat_id = '$cat_id'
									AND eq.active = '1' 
									ORDER BY eq.q_id ASC ";
				} 
				//echo $sql."<br>";
							$rs = mysql_query($sql);
							 while($arr=mysql_fetch_array($rs)){
							  	$q_id[] = $arr[q_id];
								$alt_id[] = $arr[alt_id];
								$question[] = $arr[question];
							}
					return array($q_id,$alt_id,$question);
					
		} // closeFunction
		
function GetQuestionOne($evaluate,$q_id)
	{
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
				
							$sql = "SELECT *
									FROM eval_usrd_questions 
									WHERE q_id = '$q_id'";
							$rs = mysql_query($sql);
							
							 while($arr=mysql_fetch_array($rs)){
							  	$q_id = $arr[q_id];
								$alt_id = $arr[alt_id];
								$users_id= $arr[users_id];
								$g_id= $arr[g_id];
								$question = $arr[question];
								$cat_id= $arr[cat_id];
								$std_q= $arr[std_q];
								$is_percep =$arr[is_perceptual];
								$active= $arr[active];
							}
							
					return array($q_id,$alt_id,$users_id,$g_id,$question,$cat_id,$std_q,$is_percep,$active);
					
		} // closeFunction
		
	function GetStandardQuestion($evaluate,$show,$fill)
	{
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			 $person = $evaluate->GetModuleOwner($evaluate);  
			$module_id =$evaluate->getModule();
			if($fill==1){ 
				$cmd = " AND eq.alt_id = '0' "; 
			}else{
				$cmd ="";
			}
					if($show ==1){
							$sql = "SELECT *
									FROM eval_usrd_questions eq,eval_usrd_group g
									WHERE g.modules_id = '$module_id'
									AND g.g_name = eq.q_id
									AND g.users_id='$person' ".$cmd." 
									AND eq.users_id ='-1' 
									AND eq.std_q = '1' 
									AND eq.is_perceptual ='0' 
									AND eq.active = '1' 
									ORDER BY eq.q_id ASC ";
							$rs = mysql_query($sql);
							
							 while($arr=mysql_fetch_array($rs)){
							  	$q_id[] = $arr[q_id];
								$alt_id[] = $arr[alt_id];
								$question[] = $arr[question];
								$g_id[] = $arr[g_id];
							}
					    return array($q_id,$alt_id,$question,$g_id);
					
					}else{
							$sql = "SELECT *
									FROM eval_usrd_questions
									WHERE users_id ='-1' 
									AND std_q = '1' 
									AND active = '1'   
									AND is_perceptual ='0'
									ORDER BY q_id ASC ";
					
							$rs = mysql_query($sql);
							
							 while($arr=mysql_fetch_array($rs)){
							  	$q_id[] = $arr[q_id];
								$alt_id[] = $arr[alt_id];
								$question[] = $arr[question];
							}
					return array($q_id,$alt_id,$question);
					} 
		} // closeFunction

		function getCosDetail($evaluate){
				global $dsn;
				$db = DB::connect($dsn);
					if( DB::isError($db) ) {
					   die ($db->getMessage());
					}
					
					$sql = "SELECT m.name,e.*
							FROM eval_q_set e,modules m
							WHERE e.modules_id=".$evaluate->getModule()."
							AND m.id=e.modules_id";
							$rs = mysql_query($sql);
							$arr=mysql_fetch_array($rs);
							
			//$name,$modules_id,$info,$courses_id,$semester,$year,$start_date,$end_date,$show_std  
		return array($arr[name],$arr[modules_id],$arr[eval_type],$arr[info],$arr[courses_id],$arr[semester],$arr[year],$arr[start_date],$arr[end_date],$arr[show_std],$arr[show_rs]);
	}
	
	
	function sentMsg($mPri,$mSbj,$mMsg,$from_id,$to_id){
			$MSG_TYPE=1;
			$ENABLE = 1;
			$DEFAULT_PRI=1;
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
				 die ($db->getMessage());
			}
				
				if(empty($mPri)){
					$mPri=$DEFAULT_PRI;
				}
				$sql = "INSERT INTO msg(msg_type,msg_priority,msg_subject,msg_message,msg_from_uid,msg_to_uid,msg_date,msg_enable)
						VALUES('$MSG_TYPE','$mPri','$mSbj','$mMsg','$from_id','$to_id',".time().",'$ENABLE')";
				$rs= mysql_query($sql); 
	
	}
	
		//===============nok create==============//

	function CheckDelete($qid){
		global $dsn;
				$db = DB::connect($dsn);
					if( DB::isError($db) ) {
					   die ($db->getMessage());
					}
		$sql="SELECT  g_id FROM eval_usrd_group WHERE g_name=".$qid." ";
		$result = $db->query($sql);
		$num=$result->numRows();
		 return $num;
	}

	function CheckDeleteAlt($altid){
		global $dsn;
				$db = DB::connect($dsn);
					if( DB::isError($db) ) {
					   die ($db->getMessage());
					}
		$sql="SELECT  alt_id  FROM eval_usrd_questions  WHERE alt_id=".$altid." ";
		$result = $db->query($sql);
		$num=$result->numRows();
		 return $num;
	}


	function GetAlternatives($evaluate,$std,$g_id){
		global $dsn;
				$db = DB::connect($dsn);
					if( DB::isError($db) ) {
					   die ($db->getMessage());
					}

		if($std==1){
			$sql = "SELECT ea.*
					FROM eval_usrd_questions eq,eval_usrd_group eg,eval_usrd_alternatives ea
					WHERE eg.modules_id=".$evaluate->getModule()."  AND eq.q_id=eg.g_name AND ea.alt_id=eq.alt_id AND eq.std_q =1 GROUP BY ea.alt_id ";
		}else{
			$sql = "SELECT ea.*
					FROM eval_usrd_questions eq,eval_usrd_group eg,eval_usrd_alternatives ea
					WHERE eg.modules_id=".$evaluate->getModule()."  AND eg.g_id=".$g_id." AND eg.g_id=eq.g_id AND ea.alt_id=eq.alt_id  AND eq.std_q !=1 GROUP BY ea.alt_id ";
		}
		//echo $sql;
		$result = $db->query($sql);
		return $result;
	}
	
	function GetStandardGroupAlt($evaluate,$alt_id,$std,$g_id){
		global $dsn;
				$db = DB::connect($dsn);
					if( DB::isError($db) ) {
					   die ($db->getMessage());
					}
 $person = $evaluate->GetModuleOwner($evaluate); 
		if($std==1){
			$sql = "SELECT eq.*,eg.*
					FROM eval_usrd_questions eq,eval_usrd_group eg
					WHERE eg.users_id=".$person." AND modules_id=".$evaluate->getModule()." AND eq.std_q=1 AND eq.q_id=eg.g_name AND eq.alt_id=".$alt_id." ORDER BY eg. g_order ASC ";
		}else{
			$sql = "SELECT eq.*,eg.*
					FROM eval_usrd_questions eq,eval_usrd_group eg
					WHERE eg.users_id=".$person." AND modules_id=".$evaluate->getModule()."  AND eg.g_id=".$g_id." AND eq.g_id=eg.g_id AND eq.alt_id=".$alt_id." ORDER BY eq.q_id ASC ";
//	echo $sql;
		}
		
		$result = $db->query($sql);
		return $result;
	}

	function GetStandardQuestionByUser($evaluate){
		global $dsn;
				$db = DB::connect($dsn);
					if( DB::isError($db) ) {
					   die ($db->getMessage());
					}
		 $owner = $evaluate->GetModuleOwner($evaluate);  
		$sql = "SELECT eq.*,eg.*
					FROM eval_usrd_questions eq,eval_usrd_group eg 
					WHERE eg.users_id='$owner'  AND modules_id=".$evaluate->getModule()." AND eq.std_q=1 AND eq.q_id=eg.g_name  ORDER BY eg. g_order ASC ";
		//echo $sql;
		$result = $db->query($sql);
		return $result;
		
	}

	
	function SelectAnswer($qid,$page,$pagesize,$std,$mid){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
				 die ($db->getMessage());
			}
			
		//page
		if (isset($page)){
						$start = $pagesize * ($page -1);
			}else{
						$page =1;
						$start=0;
			}	
		$numRow = " LIMIT ".$start.", ".$pagesize;
		$sql = "SELECT * FROM eval_usrd_answers  
				WHERE q_id=".$qid." 
				AND modules_id = '$mid'  
				AND std_q  = '$std' 
				".$numRow ."";
		
		$result = $db->query($sql);
		return $result;
	}
	
	function SumEval($evaluate,$scores,$id,$std){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		if($std==1)
			$std=" AND std_q=1";
		else
			$std=" AND std_q !=1";

		if($score == ""){
			$sql="SELECT scores FROM  eval_usrd_answers WHERE q_id  IN (".$id.") AND modules_id=".$evaluate->getModule()." AND scores=".$scores." ".$std." ";
		}
	//	echo $sql;
		$result = $db->query($sql);
		$num=$result->numRows();
		 return $num;
	}

	function GetAlternativesAdmin(){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		
		$sql="SELECT ea.* FROM eval_usrd_alternatives ea,eval_usrd_questions eq WHERE eq.users_id =-1 AND ea.alt_id=eq.alt_id  GROUP BY ea.alt_id ";
		$result = $db->query($sql);
		 return $result;
	}


	function Page($sql,$page,$pagesize)
	{
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		//page
			$result = $db->query($sql);
			$num = $result->numRows();	
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

//--------------------------------end nok------------------------------------
	
}//End Class

class Template{
	var $classname = "Template";
	var $_tpldata = array();
	var $files = array();
	var $root = "";
	var $compiled_code = array();
	var $uncompiled_code = array();

	function Template($root = ".")
	{
		$this->set_rootdir($root);
	}

	function destroy()
	{
		$this->_tpldata = array();
	}

	function set_rootdir($dir)
	{
		if (!is_dir($dir))
		{
			return false;
		}

		$this->root = $dir;
		return true;
	}
		
	function set_filenames($filename_array)
	{
		if (!is_array($filename_array))
		{
			return false;
		}

		reset($filename_array);
		while(list($handle, $filename) = each($filename_array))
		{
			$this->files[$handle] = $this->make_filename($filename);
		}

		return true;
	}

	function pparse($handle)
	{
		if (!$this->loadfile($handle))
		{
			die("Template->pparse(): Couldn't load template file for handle $handle");
		}

		// actually compile the template now.
		if (!isset($this->compiled_code[$handle]) || empty($this->compiled_code[$handle]))
		{
			// Actually compile the code now.
			$this->compiled_code[$handle] = $this->compile($this->uncompiled_code[$handle]);
		}

		// Run the compiled code.
		eval($this->compiled_code[$handle]);
		return true;
	}

	function assign_var_from_handle($varname, $handle)
	{
		if (!$this->loadfile($handle))
		{
			die("Template->assign_var_from_handle(): Couldn't load template file for handle $handle");
		}
		$_str = "";
		$code = $this->compile($this->uncompiled_code[$handle], true, '_str');

		eval($code);
		$this->assign_var($varname, $_str);

		return true;
	}

	function assign_block_vars($blockname, $vararray)
	{
		if (strstr($blockname, '.'))
		{
			$blocks = explode('.', $blockname);
			$blockcount = sizeof($blocks) - 1;
			$str = '$this->_tpldata';
			for ($i = 0; $i < $blockcount; $i++)
			{
				$str .= '[\'' . $blocks[$i] . '.\']';
				eval('$lastiteration = sizeof(' . $str . ') - 1;');
				$str .= '[' . $lastiteration . ']';
			}
			$str .= '[\'' . $blocks[$blockcount] . '.\'][] = $vararray;';
			eval($str);
		}
		else
		{
			$this->_tpldata[$blockname . '.'][] = $vararray;

		}
		return true;
	}

	function assign_vars($vararray)
	{
		reset ($vararray);
		while (list($key, $val) = each($vararray))
		{
			$this->_tpldata['.'][0][$key] = $val;
		}

		return true;
	}

	function assign_var($varname, $varval)
	{
		$this->_tpldata['.'][0][$varname] = $varval;

		return true;
	}

	function make_filename($filename)
	{
		// Check if it's an absolute or relative path.
		if (substr($filename, 0, 1) != '/')
		{
//       		$filename = phpbb_realpath($this->root . '/' . $filename);
       		$filename = $this->root . '/' . $filename;
		}

		if (!file_exists($filename))
		{
			die("Template->make_filename(): Error - file $filename does not exist");
		}

		return $filename;
	}

	function loadfile($handle)
	{
		// If the file for this handle is already loaded and compiled, do nothing.
		if (isset($this->uncompiled_code[$handle]) && !empty($this->uncompiled_code[$handle]))
		{
			return true;
		}

		// If we don't have a file assigned to this handle, die.
		if (!isset($this->files[$handle]))
		{
			die("Template->loadfile(): No file specified for handle $handle");
		}

		$filename = $this->files[$handle];

		$str = implode("", @file($filename));
		if (empty($str))
		{
			die("Template->loadfile(): File $filename for handle $handle is empty");
		}

		$this->uncompiled_code[$handle] = $str;

		return true;
	}

	function compile($code, $do_not_echo = false, $retvar = '')
	{
		// replace \ with \\ and then ' with \'.
		$code = str_replace('\\', '\\\\', $code);
		$code = str_replace('\'', '\\\'', $code);

		// change template varrefs into PHP varrefs

		// This one will handle varrefs WITH namespaces
		$varrefs = array();
		preg_match_all('#\{(([a-z0-9\-_]+?\.)+?)([a-z0-9\-_]+?)\}#is', $code, $varrefs);
		$varcount = sizeof($varrefs[1]);
		for ($i = 0; $i < $varcount; $i++)
		{
			$namespace = $varrefs[1][$i];
			$varname = $varrefs[3][$i];
			$new = $this->generate_block_varref($namespace, $varname);

			$code = str_replace($varrefs[0][$i], $new, $code);
		}

		// This will handle the remaining root-level varrefs
		$code = preg_replace('#\{([a-z0-9\-_]*?)\}#is', '\' . ( ( isset($this->_tpldata[\'.\'][0][\'\1\']) ) ? $this->_tpldata[\'.\'][0][\'\1\'] : \'\' ) . \'', $code);

		// Break it up into lines.
		$code_lines = explode("\n", $code);

		$block_nesting_level = 0;
		$block_names = array();
		$block_names[0] = ".";

		// Second: prepend echo ', append ' . "\n"; to each line.
		$line_count = sizeof($code_lines);
		for ($i = 0; $i < $line_count; $i++)
		{
			$code_lines[$i] = chop($code_lines[$i]);
			if (preg_match('#<!-- BEGIN (.*?) -->#', $code_lines[$i], $m))
			{
				$n[0] = $m[0];
				$n[1] = $m[1];

				// Added: dougk_ff7-Keeps templates from bombing if begin is on the same line as end.. I think. :)
				if ( preg_match('#<!-- END (.*?) -->#', $code_lines[$i], $n) )
				{
					$block_nesting_level++;
					$block_names[$block_nesting_level] = $m[1];
					if ($block_nesting_level < 2)
					{
						// Block is not nested.
						$code_lines[$i] = '$_' . $n[1] . '_count = ( isset($this->_tpldata[\'' . $n[1] . '.\']) ) ?  sizeof($this->_tpldata[\'' . $n[1] . '.\']) : 0;';
						$code_lines[$i] .= "\n" . 'for ($_' . $n[1] . '_i = 0; $_' . $n[1] . '_i < $_' . $n[1] . '_count; $_' . $n[1] . '_i++)';
						$code_lines[$i] .= "\n" . '{';
					}
					else
					{
						// This block is nested.

						// Generate a namespace string for this block.
						$namespace = implode('.', $block_names);
						// strip leading period from root level..
						$namespace = substr($namespace, 2);
						// Get a reference to the data array for this block that depends on the
						// current indices of all parent blocks.
						$varref = $this->generate_block_data_ref($namespace, false);
						// Create the for loop code to iterate over this block.
						$code_lines[$i] = '$_' . $n[1] . '_count = ( isset(' . $varref . ') ) ? sizeof(' . $varref . ') : 0;';
						$code_lines[$i] .= "\n" . 'for ($_' . $n[1] . '_i = 0; $_' . $n[1] . '_i < $_' . $n[1] . '_count; $_' . $n[1] . '_i++)';
						$code_lines[$i] .= "\n" . '{';
					}

					// We have the end of a block.
					unset($block_names[$block_nesting_level]);
					$block_nesting_level--;
					$code_lines[$i] .= '} // END ' . $n[1];
					$m[0] = $n[0];
					$m[1] = $n[1];
				}
				else
				{
					// We have the start of a block.
					$block_nesting_level++;
					$block_names[$block_nesting_level] = $m[1];
					if ($block_nesting_level < 2)
					{
						// Block is not nested.
						$code_lines[$i] = '$_' . $m[1] . '_count = ( isset($this->_tpldata[\'' . $m[1] . '.\']) ) ? sizeof($this->_tpldata[\'' . $m[1] . '.\']) : 0;';
						$code_lines[$i] .= "\n" . 'for ($_' . $m[1] . '_i = 0; $_' . $m[1] . '_i < $_' . $m[1] . '_count; $_' . $m[1] . '_i++)';
						$code_lines[$i] .= "\n" . '{';
					}
					else
					{
						// This block is nested.

						// Generate a namespace string for this block.
						$namespace = implode('.', $block_names);
						// strip leading period from root level..
						$namespace = substr($namespace, 2);
						// Get a reference to the data array for this block that depends on the
						// current indices of all parent blocks.
						$varref = $this->generate_block_data_ref($namespace, false);
						// Create the for loop code to iterate over this block.
						$code_lines[$i] = '$_' . $m[1] . '_count = ( isset(' . $varref . ') ) ? sizeof(' . $varref . ') : 0;';
						$code_lines[$i] .= "\n" . 'for ($_' . $m[1] . '_i = 0; $_' . $m[1] . '_i < $_' . $m[1] . '_count; $_' . $m[1] . '_i++)';
						$code_lines[$i] .= "\n" . '{';
					}
				}
			}
			else if (preg_match('#<!-- END (.*?) -->#', $code_lines[$i], $m))
			{
				// We have the end of a block.
				unset($block_names[$block_nesting_level]);
				$block_nesting_level--;
				$code_lines[$i] = '} // END ' . $m[1];
			}
			else
			{
				// We have an ordinary line of code.
				if (!$do_not_echo)
				{
					$code_lines[$i] = 'echo \'' . $code_lines[$i] . '\' . "\\n";';
				}
				else
				{
					$code_lines[$i] = '$' . $retvar . '.= \'' . $code_lines[$i] . '\' . "\\n";'; 
				}
			}
		}

		// Bring it back into a single string of lines of code.
		$code = implode("\n", $code_lines);
		return $code	;

	}


	/**
	 * Generates a reference to the given variable inside the given (possibly nested)
	 * block namespace. This is a string of the form:
	 * ' . $this->_tpldata['parent'][$_parent_i]['$child1'][$_child1_i]['$child2'][$_child2_i]...['varname'] . '
	 * It's ready to be inserted into an "echo" line in one of the templates.
	 * NOTE: expects a trailing "." on the namespace.
	 */
	function generate_block_varref($namespace, $varname)
	{
		// Strip the trailing period.
		$namespace = substr($namespace, 0, strlen($namespace) - 1);

		// Get a reference to the data block for this namespace.
		$varref = $this->generate_block_data_ref($namespace, true);
		// Prepend the necessary code to stick this in an echo line.

		// Append the variable reference.
		$varref .= '[\'' . $varname . '\']';

		$varref = '\' . ( ( isset(' . $varref . ') ) ? ' . $varref . ' : \'\' ) . \'';

		return $varref;

	}


	/**
	 * Generates a reference to the array of data values for the given
	 * (possibly nested) block namespace. This is a string of the form:
	 * $this->_tpldata['parent'][$_parent_i]['$child1'][$_child1_i]['$child2'][$_child2_i]...['$childN']
	 *
	 * If $include_last_iterator is true, then [$_childN_i] will be appended to the form shown above.
	 * NOTE: does not expect a trailing "." on the blockname.
	 */
	function generate_block_data_ref($blockname, $include_last_iterator)
	{
		// Get an array of the blocks involved.
		$blocks = explode(".", $blockname);
		$blockcount = sizeof($blocks) - 1;
		$varref = '$this->_tpldata';
		// Build up the string with everything but the last child.
		for ($i = 0; $i < $blockcount; $i++)
		{
			$varref .= '[\'' . $blocks[$i] . '.\'][$_' . $blocks[$i] . '_i]';
		}
		// Add the block reference for the last child.
		$varref .= '[\'' . $blocks[$blockcount] . '.\']';
		// Add the iterator for the last child if requried.
		if ($include_last_iterator)
		{
			$varref .= '[$_' . $blocks[$blockcount] . '_i]';
		}

		return $varref;
	}

	function redirect($url)
	{
	$redirect_url=$server_protocol . $server_name . $server_port . $script_name . $url;
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="Cache-control" content="no-store" /><meta http-equiv="Pragma" content="no-cache" /><meta http-equiv="Expires" content="0" /><meta http-equiv="Pray" content="true" /><meta http-equiv="refresh" content="0; url=' . $server_protocol . $server_name . $server_port . $script_name . $url . '"><title>Redirect</title></head><body bgcolor="#ff9900"></body></html>';
		exit;
 	}

}
?>