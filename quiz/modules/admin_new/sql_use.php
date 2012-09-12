<? 
require("../include/global_login.php");
$quiz=new Quiz($qid,$modules,$courses);


if(sizeof($use_question)!=0){
  //get all questions in this quiz
       $get_present=mysql_query("SELECT question_id as questions FROM q_modules_questions WHERE module_id=".$quiz->getModules()."");
        $present=array();
             if(mysql_num_rows($get_present)!=0){
                       while($row=mysql_fetch_array($get_present)) {
                              $present[]=$row["questions"];
                       }
               }
               for($a=1;$a<=$num;$a++){
                       $stop=0;
                       for($i=0;$i<sizeof($present);$i++){
                                if($present[$i]==$use_question[$a]){
                                        $stop=1;
                                }
                        }//Only add those questions not already in this quiz
						if($use_question[$a] != null){
							if($stop !=1){
								 mysql_query("INSERT into q_modules_questions(module_id,question_id,makecopy) VALUES(".$quiz->getModules().",".$use_question[$a].",1);");
							}
						}
                }
		
        header("Status: 302 Moved Temporarily");
        header("Location:  ?a=viewQuestion&m=admin&modules=".$quiz->getModules());
        exit;

}
?>