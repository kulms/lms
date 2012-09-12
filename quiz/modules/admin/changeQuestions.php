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
    $new_alternative_name="";
    $alt_pic_name="";
	$question_id=$qnr;
		//Update alternatives
	//mysql_query("DELETE FROM answers WHERE questions=$qnr");
if($del != 0){
	if($q == 1){ //delete pic q_question
		$sql=mysql_query("SELECT attached_file FROM q_questions WHERE question_id=$qnr");
		$q_pic= mysql_result($sql,0,"attached_file");
		unlink("files/$q_pic");
		$sql_del=mysql_query("UPDATE q_questions SET attached_file='',real_attached_file='' WHERE question_id=$qnr ");	
	}else{		//delete pic q_answers
		$sql=mysql_query("SELECT answer_file FROM q_answers  WHERE answer_id =$ans_id");
		$a_pic= mysql_result($sql,0,"answer_file");
		if($a_pic != "")
			unlink("files/$a_pic");
				$sql_del=mysql_query("UPDATE q_answers  SET answer_file='',real_file='' WHERE answer_id =$ans_id ");		
	}
}else{
			if($q==1){
				$sql=mysql_query("SELECT answer_file FROM q_answers  WHERE answer_id =$ans_id");
				$a_pic= mysql_result($sql,0,"answer_file");
				if($a_pic != "")
					unlink("files/$a_pic");
				$sql_del=mysql_query("DELETE FROM q_answers  WHERE  answer_id= $ans_id ");
			}
			//Update question
			//Rename file and copy to dir files/
		if($picture!="" && $picture!="none"){
		  if (!isset ($_FILES['picture'])) {
			   echo "Can not get source file.";
			  exit;
		  }
		  $picture_name = ($_FILES["picture"]['name']);
		  $picture_name = str_replace("'","&#039;",$picture_name);
		  $pos = strpos($_FILES['picture']['name'], '.');
		  $file_type = substr($_FILES['picture']['name'],$pos);
		  $new_name = "q".$qnr."_q".$file_type;
		  if ($_FILES['picture']['error']) {
			  echo "Error upload file.";
			  exit;
		  }

		  if (!is_uploaded_file ($_FILES['picture']['tmp_name'])) {
			 echo "File upload error.";
			 exit;
		  }
		  if (!copy($_FILES['picture']['tmp_name'], "files/".$new_name)) {
			 echo "failed to copy";
			 exit;
		  }
	$sql2="UPDATE q_questions SET attached_file='".$new_name."',real_attached_file='".$picture_name."' WHERE question_id=$qnr;";
	mysql_query($sql2);
		}

		//Update Answer
	for($a=1;$a<=7;$a++){
       if ((${"Alternative".$a}!="")|| ((($_FILES["alternative_pic".$a]['name'])!="")) || (${"old_alternative_pic".$a}!="")){
            $alt = ${"Alternative".$a};
            $alt = str_replace("'","&#039;",$alt);
			//"$a".$_FILES["alternative_pic".$a]['name'];
            if (($_FILES["alternative_pic".$a]['name'])!="") {
                $alt_pic = ($_FILES["alternative_pic".$a]['name']);
               $alt_pic = str_replace("'","&#039;",$alt_pic);
               if (!isset ($_FILES["alternative_pic".$a])) {
                    echo "Can not get alternative source file.".$a;
                    exit;
               } else {
                    $alt_pic_name =  ($_FILES["alternative_pic".$a]['name']);
               }
              $pos = strpos($_FILES["alternative_pic".$a]['name'], '.');
              $file_type = substr($_FILES["alternative_pic".$a]['name'],$pos);
              $new_alternative_name = "q".$question_id."_".$choice.$file_type;
              if ($_FILES["alternative_pic".$a]['error']) {
                  echo "Error upload alternative file.".$a;
                  exit;
              }
              if (!is_uploaded_file ($_FILES["alternative_pic".$a]['tmp_name'])) {
                 echo "Alternative file upload error.".$a;
                 exit;
              }
              if (!copy($_FILES["alternative_pic".$a]['tmp_name'], "files/".$new_alternative_name)) {
                 echo "Failed to copy alternative".$a;
                 exit;
              }
            }
			if(${"true_".$a}==1){
				$truevalue=1;
                $correct_answer=$correct_answer.$choice;
			}else{
				$truevalue=0;
			}
			if(${"alt_id".$a}!=""){
               if ($alt_pic_name!="") {
                     $sql="UPDATE q_answers SET choice='".$choice."',answer_des='".$alt."', correct=$truevalue, question_id=$qnr,active=1,answer_file='".$new_alternative_name."',real_file='".$alt_pic_name."' WHERE answer_id=".${"alt_id".$a}.";";
               }else{
				     $sql="UPDATE q_answers SET choice='".$choice."',answer_des='".$alt."', correct=$truevalue, question_id=$qnr,active=1 WHERE answer_id=".${"alt_id".$a}.";";
               }
			}else{
               if ($alt_pic_name!="") {
				   $sql = "INSERT INTO q_answers(answer_des,correct,question_id,active,choice,answer_file,real_file) VALUES('".$alt."',$truevalue,$qnr,1,'".$choice."','".$new_alternative_name."','".$alt_pic_name."');";
               }else{
                   $sql = "INSERT INTO q_answers(answer_des,correct,question_id,active,choice) VALUES('".$alt."',$truevalue,$qnr,1,'".$choice."');";
               }
			}
			mysql_query($sql);
            $ascii_choice = ord($choice);
            $ascii_choice++;
            $choice = chr($ascii_choice);
            $new_alternative_name="";
            $alt_pic_name="";
		}//end if 
	}//end for
    $d1=date('Y-m-d h:i:s');
	if($score == "")
		$score=$h_score;
	$sql2="UPDATE q_questions SET correct_answer='".$correct_answer."', question='".$question."', score='".$score."',solution='".$Solution."',comment='".$Comment."',updated_by=".$person["id"].",updated_date='".$d1."',categories='".$categories."' WHERE question_id=$qnr;";
	mysql_query($sql2);
 }  
}//if ($question_type=="mltc")   // End question_type==Multiple Choice 
  elseif (($question_type=="tnf") or ($question_type=="fib")) {  //Begin question_type==True/False 
  if($del != ""){
		$sql=mysql_query("SELECT attached_file FROM q_questions  WHERE question_id=$qnr ");
		$q_pic= mysql_result($sql,0,"attached_file");
		unlink("files/$q_pic");
		$sql_del=mysql_query("UPDATE q_questions SET attached_file='',real_attached_file='' WHERE question_id=$qnr");
  }else{
            //Update question
            //Rename file and copy to dir files/
        if($picture!="" && $picture!="none"){
          if (!isset ($_FILES['picture'])) {
               echo "Can not get source file.";
               exit;
          }
          $pos = strpos($_FILES['picture']['name'], '.');
          $file_type = substr($_FILES['picture']['name'],$pos);
          $new_name = "q".$qnr."_q".$file_type;
          if ($_FILES['picture']['error']) {
              echo "Error upload file.";
              exit;
          }

          if (!is_uploaded_file ($_FILES['picture']['tmp_name'])) {
             echo "File upload error.";
             exit;
          }
          if (!copy($_FILES['picture']['tmp_name'], "files/".$new_name)) {
             echo "failed to copy";
             exit;
          }

          $sql2="UPDATE q_questions SET attached_file='".$new_name."',real_attached_file='".$picture_name."' WHERE question_id=$qnr;";
          mysql_query($sql2);
        }

        $d1=date('Y-m-d h:i:s');
		if($score == "")
			$score=$h_score;
        $sql2="UPDATE q_questions SET correct_answer='".$answer."', question='".$question."', score=$score,solution='".$Solution."',comment='".$Comment."',updated_by=".$person["id"].",updated_date='".$d1."',categories='".$categories."' WHERE question_id=$qnr;";
        mysql_query($sql2);
		
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
$sql3="UPDATE q_answers SET answer_des='".$ans."',choice='".$choice."',correct=$correct WHERER question_id=$qnr ";
mysql_query($sql3);	
	}
 }
  }  // elseif ($question_type=="tnf") //End question_type==True/False 
  else if ($question_type=="mcit") {
		if($del != "" ){
			if($q == 1) { //delete pic q_question_mcit 
				$q_id=$qnr;
				$sql=mysql_query("SELECT attached_file FROM q_question_mcit  WHERE mcit_id=$q_id ");
				$q_pic= mysql_result($sql,0,"attached_file");
				unlink("files/$q_pic");
				$sql_del=mysql_query("UPDATE q_question_mcit SET attached_file='',real_attached_file='' WHERE mcit_id=$q_id ");
			}else{ //delete pic q_answer_mcit 
				$a_id=$ans_id;
				$sql=mysql_query("SELECT attached_file FROM q_answer_mcit  WHERE mcit_ans_id=$a_id ");
				$a_pic= mysql_result($sql,0,"attached_file");
				unlink("files/$a_pic");
				$sql_del=mysql_query("UPDATE q_answer_mcit SET attached_file='',real_attached_file='' WHERE mcit_ans_id=$a_id ");	
			}
		}else{
			//Update question
			$d1=date('Y-m-d h:i:s');
			$q_quertion="Matching Item";
			$sql=mysql_query("UPDATE q_questions SET  score=$score, comment='".$comment."',updated_by=".$person["id"].",updated_date='".$d1."',categories='".$categories."',matching_grp_no='".$user_mcit."',active='".$active."' WHERE question_id=$qnr;");
			//Update  question (mcit)
			for ($a=1;$a<=$totquestion;$a++){
				$qpic = "";
				$new_name="";
				  //Rename file and copy to dir files/
				if ((${"question".$a}!="") or (($_FILES["qpicture".$a]['name'])!="")){
					 $qitem= ${"question".$a};
					 $qitem = str_replace("'","&#039;",$qitem);
					 $a_qitem= ${"question_a".$a};
					 $a_qitem = str_replace("'","&#039;",$a_qitem);
					 $q_id=${"hid_q".$a};
					  if (($_FILES["qpicture".$a]['name'])!="") {
						  $qpic = ($_FILES["qpicture".$a]['name']);
						  $qpic = str_replace("'","&#039;",$qpic);

						  if (!isset ($_FILES["qpicture".$a])) {
							   echo "Can not get question file.";
							   exit;
						  }
						  $pos = strpos($_FILES["qpicture".$a]['name'], '.');
						  $file_type = substr($_FILES["qpicture".$a]['name'],$pos);
						  $new_name = "q".$question_id."_".$a."q".$file_type;
						  if ($_FILES["qpicture".$a]['error']) {
							  echo "Error upload question file.";
							  exit;
						  }
						  if (!is_uploaded_file ($_FILES["qpicture".$a]['tmp_name'])) {
							 echo "Question File upload error.";
							 exit;
						  }
						  if (!copy($_FILES["qpicture".$a]['tmp_name'], "files/".$new_name)) {
							 echo "Failed to copy question file";
							 exit;
						  }			
						  $sql=mysql_query("UPDATE q_question_mcit SET attached_file='".$new_name."',real_attached_file='".$qpic."' WHERE  mcit_id=$q_id ");
					  }  // end if question's pic
				}   // end if
				$sql=mysql_query("UPDATE q_question_mcit SET mcit_des='".$qitem."',correct='".$a_qitem."' WHERE  mcit_id=$q_id" );
			 }  // end for

			 //Update answer
		for ($b=1;$b<=$totanswer;$b++){
				$aitem="";
				 $apic = "";
				 $new_name="";
				 //Rename file and copy to dir files/
				if ((${"answer".$b}!="") or (($_FILES["apicture".$b]['name'])!="")){
					 $aitem= ${"answer".$b};
					 $aitem = str_replace("'","&#039;",$aitem);
					 $ans_choice=${"ans_choice".$b};
					 $a_id=${"hid_a".$b};
					  if (($_FILES["apicture".$b]['name'])!="") {
						  $apic = ($_FILES["apicture".$b]['name']);
						  $apic = str_replace("'","&#039;",$apic);

						  if (!isset ($_FILES["apicture".$b])) {
							   echo "Can not get answer file.";
							   exit;
						  }
						  $pos = strpos($_FILES["apicture".$b]['name'], '.');
						  $file_type = substr($_FILES["apicture".$b]['name'],$pos);
						  $new_name = "q".$question_id."_".$b."a".$file_type;
						  if ($_FILES["apicture".$b]['error']) {
							  echo "Error upload question file.";
							  exit;
						  }
						  if (!is_uploaded_file ($_FILES["apicture".$b]['tmp_name'])) {
							 echo "Question File upload error.";
							 exit;
						  }
						  if (!copy($_FILES["apicture".$b]['tmp_name'], "files/".$new_name)) {
							 echo "Failed to copy question file";
							 exit;
						  }
						  $sql=mysql_query("UPDATE q_answer_mcit SET attached_file='".$new_name."', real_attached_file='".$apic."' WHERE mcit_ans_id=$a_id ");
					  }  // end if question's pic
				}   // end if
				$sql=mysql_query("UPDATE q_answer_mcit SET mcit_ans_choice='".$ans_choice."', mcit_ans_des='".$aitem."' WHERE mcit_ans_id=$a_id ");
		 }// end for
		}// end if
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