<?php
require ("../include/global_login.php");
include("../include/function.inc.php");

$question = str_replace("'","&#039;",$question);
$Comment = str_replace("'","&#039;",$Comment);
$Lead = str_replace("'","&#039;",$Lead);
$Solution = str_replace("'","&#039;",$Solution);
$categories = str_replace("'","&#039;",$categories);

$courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$modules.";");
$courses=mysql_result($courseid,0,"courses");

// $makecopy ==0 ข้อมูลของตัวเอง
	//***********insert modules_history***************
	$action="Edit question";
	Imodules_h($modules,$action,$person["id"],$courses);

   if ($question_type=="mltc") {  // Begin  question_type==Multiple Choice 
    $choice="a";
	$question_id=$qnr;

	//update answer
	for($a=1;$a<=7;$a++){
		$text_alt=stripslashes(${"Alternative".$a});
		$alt=str_replace("&nbsp;","",stripslashes(${"Alternative".$a}));
		if(${"true_".$a}==1){
			$truevalue=1;
            $correct_answer=$correct_answer.$choice;
		}else{
			$truevalue=0;
		}

		if(${"alt_id".$a}!=""){
			if($alt !="")
				mysql_query("UPDATE q_answers SET choice='".$choice."',answer_des='".$text_alt."', correct=$truevalue, question_id=$qnr,active=1 WHERE answer_id=".${"alt_id".$a});
			else
				mysql_query("DELETE FROM q_answers WHERE  answer_id=".${"alt_id".$a});
		}else{
			if($alt !=""){
				mysql_query("INSERT INTO q_answers(answer_des,correct,question_id,active,choice) VALUES('".$text_alt."',$truevalue,$qnr,1,'".$choice."') " );
			}
		}//if if
		$ascii_choice = ord($choice);
		$ascii_choice++;
		$choice = chr($ascii_choice);
	}//end for
		//update question
		$d1=date('Y-m-d h:i:s');
		if($score == "")
			$score=$h_score;
		$sql2="UPDATE q_questions SET correct_answer='".$correct_answer."', question='".stripslashes($question)."', score='".$score."',solution='".$Solution."',comment='".$Comment."',updated_by=".$person["id"].",updated_date='".$d1."',categories='".$categories."' WHERE question_id=$qnr;";
		mysql_query($sql2);
}//if ($question_type=="mltc")   // End question_type==Multiple Choice 
  elseif (($question_type=="tnf") or ($question_type=="fib")) {  //Begin question_type==True/False 
			$d1=date('Y-m-d h:i:s');
			if($score == "")
				$score=$h_score;
			$sql2="UPDATE q_questions SET correct_answer='".$answer."', question='".stripslashes($question)."', score=$score,solution='".$Solution."',comment='".$Comment."',updated_by=".$person["id"].",updated_date='".$d1."',categories='".$categories."' WHERE question_id=$qnr;";
			//echo $sql2;
			mysql_query($sql2);
			
			if($question_type=="tnf"){
				//Update tb q_answers
				$ans_des1="TRUE";    $ans_choice1="a";
				$ans_des2="FALSE";   $ans_choice2="b";
				for($a=1;$a<3;$a++){
					$ans= ${"ans_des".$a};
					$choice=${"ans_choice".$a};
							if(${"ans_choice".$a}==$answer)
								$correct=1;
							else
								$correct=0;
					$sql3="UPDATE q_answers SET answer_des='".$ans."',choice='".$choice."',correct=$correct WHERE question_id=$qnr ";
					mysql_query($sql3);	
				}
			}else{
				$sql3="UPDATE q_answers SET answer_des='".$answer."',correct=1 WHERE question_id=$qnr ";
				mysql_query($sql3);	
			}
  }  // elseif ($question_type=="tnf") //End question_type==True/False 
  else if ($question_type=="mcit") {
			//Update question
			$d1=date('Y-m-d h:i:s');
			$q_quertion="Matching Item";
			$sql=mysql_query("UPDATE q_questions SET  score=$score, comment='".$comment."',updated_by=".$person["id"].",updated_date='".$d1."',categories='".$categories."',matching_grp_no='".$user_mcit."',active='".$active."' WHERE question_id=$qnr;");
			//Update  question (mcit)
			for ($a=1;$a<=$totquestion;$a++){
					 $qitem= stripslashes(${"question".$a});
					// $qitem = str_replace("'","&#039;",$qitem);
					 $a_qitem= ${"question_a".$a};
					//$a_qitem = str_replace("'","&#039;",$a_qitem);
					 $q_id=${"hid_q".$a};
					$sql=mysql_query("UPDATE q_question_mcit SET mcit_des='".$qitem."',correct='".$a_qitem."' WHERE  mcit_id=$q_id" );
			}//end for

			 //Update answer
			for ($b=1;$b<=$totanswer;$b++){
					 $aitem= stripslashes(${"answer".$b});
					// $aitem = str_replace("'","&#039;",$aitem);
					 $ans_choice=${"ans_choice".$b};
					 $a_id=${"hid_a".$b};
					 $sql=mysql_query("UPDATE q_answer_mcit SET mcit_ans_choice='".$ans_choice."', mcit_ans_des='".$aitem."' WHERE mcit_ans_id=$a_id ");
			}
}  // elseif ($question_type=="mcit")
?>

<html>
<head>
	<title></title>
	<LINK REL=STYLESHEET TYPE="text/css" href="../main.css">
	<META HTTP-EQUIV="Refresh" CONTENT="1;URL=?a=viewQuestion&m=admin&modules=<?echo $quiz->getModules() ?>&result=1">	
</head>
<body bgcolor="#ffffff">
<p>&nbsp;</p>
<div align="center" class="h3">Your question is updated...</div>
</body>
</html>
