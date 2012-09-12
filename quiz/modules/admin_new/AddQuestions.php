<? 
require("../include/global_login.php");
 include("../include/function.inc.php");

if($question_type=='mltc'){
	$question = str_replace("'","&#039;",$question);
	$Comment = str_replace("'","&#039;",$Comment);
	$Lead = str_replace("'","&#039;",$Lead);
	$Solution = str_replace("'","&#039;",$Solution);
	$categories = str_replace("'","&#039;",$categories);
	if($score==""){
		$score=0;
	}
	if($picture!="" && $picture!="none"){
      if (!isset ($_FILES['picture'])) {
           echo "Can not get source file.";
           exit;
      }
	  $picture_name = ($_FILES["picture"]['name']);
      $picture_name = str_replace("'","&#039;",$picture_name);
	  }

//Courses_id
$courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$modules.";");
$courses=mysql_result($courseid,0,"courses");

//Insert question
	//***********insert modules_history***************
	$action="Add question";
	Imodules_h($quiz->getModules(),$action,$person["id"],$courses);

    $d1=date('Y-m-d h:i:s');
    $SqlIns = "INSERT INTO q_questions(question,score,solution,comment,created_by,categories,question_type,lead,created_date,real_attached_file,active) VALUES('".stripslashes($question)."',$score,'".$Solution."','".$Comment."','".$person["id"]."','".$categories."','".$question_type."','".$Lead."','".$d1."','".$picture_name."',1);";
	mysql_query($SqlIns);
		//Get question ID
	$question_id=mysql_insert_id();
		//Insert question ID into q_modules_questions
	$check=mysql_query("SELECT module_id AS id FROM q_modules_questions WHERE module_id=$modules AND question_id=$question_id;");
	if(mysql_num_rows($check)==0){
		$sql = "INSERT INTO q_modules_questions(module_id,question_id) VALUES($modules,$question_id);";
		mysql_query($sql);
	}
	
//Rename file and copy to dir files/
/*
    if($picture!="" && $picture!="none"){
      if (!isset ($_FILES['picture'])) {
           echo "Can not get source file.";
           exit;
      }
	  //$picture_name = ($_FILES["picture"]['name']);
    //  $picture_name = str_replace("'","&#039;",$picture_name);
      $pos = strpos($_FILES['picture']['name'], '.');
      $file_type = substr($_FILES['picture']['name'],$pos);
      $new_name = "q".$question_id."_q".$file_type;
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
    }
	*/
     //Insert answer into q_answers
    $choice="a";
    $new_alternative_name="";
    $alt_pic_name="";
	for($a=1;$a<7;$a++){
		if ((${"Alternative".$a}!="")){
			$alt = stripslashes(${"Alternative".$a});
			$alt = str_replace("'","&#039;",$alt);
			/*
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
            }*/

			if(${"true_".$a}==1){
				$truevalue=1;
                $correct_answer=$correct_answer.$choice;
			}else{
				$truevalue=0;
			}
			//$sql2 = "INSERT INTO q_answers(answer_des,correct,question_id,active,choice,answer_file,real_file) VALUES('".$alt."',$truevalue,$question_id,1,'".$choice."','".$new_alternative_name."','".$alt_pic_name."');";
			$sql2 = "INSERT INTO q_answers(answer_des,correct,question_id,active,choice) VALUES('".$alt."',$truevalue,$question_id,1,'".$choice."');";
			mysql_query($sql2);
            $ascii_choice = ord($choice);
            $ascii_choice++;
            $choice = chr($ascii_choice);
            $new_alternative_name="";
            $alt_pic_name="";
		}//end if
	}//end for

    $sql3 = "UPDATE q_questions SET correct_answer='".$correct_answer."' WHERE question_id=$question_id;";
	mysql_query($sql3);


}else if($question_type=='tnf'){
	$question = str_replace("'","&#039;",$question);
	$Comment = str_replace("'","&#039;",$Comment);
	$Solution = str_replace("'","&#039;",$Solution);
	$categories = str_replace("'","&#039;",$categories);
	if($score==""){
		$score=0;
	}
    $d1=date('Y-m-d h:i:s');
    $SqlIns = "INSERT INTO q_questions(question,score,solution,comment,created_by,categories,question_type,created_date,real_attached_file,correct_answer,active) VALUES('".$question."',$score,'".$Solution."','".$Comment."','".$person["id"]."','".$categories."','".$question_type."','".$d1."','".$picture_name."','".$answer."',1);";
	mysql_query($SqlIns);
		//Get question ID
	$question_id=mysql_insert_id();
			//Courses_id
	$courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$modules.";");
	$courses=mysql_result($courseid,0,"courses");
		//Insert question
	//***********insert modules_history***************
	$action="Add question";
	Imodules_h($quiz->getModules(),$action,$person["id"],$courses);

        //Rename file and copy to dir files/
  /*  if($picture!="" && $picture!="none"){
      if (!isset ($_FILES['picture'])) {
           echo "Can not get source file.";
           exit;
      }
      $pos = strpos($_FILES['picture']['name'], '.');
      $file_type = substr($_FILES['picture']['name'],$pos);
      $new_name = "q".$question_id."_q".$file_type;
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
    }
	*/
		//Insert question ID into q_modules_questions
	$check=mysql_query("SELECT module_id AS id FROM q_modules_questions WHERE module_id=$modules AND question_id=$question_id;");
	if(mysql_num_rows($check)==0){
		$sql = "INSERT INTO q_modules_questions(module_id,question_id) VALUES($modules,$question_id);";
		mysql_query($sql);
	}
//Insert tb q_answers
$ans_des1="TRUE";    $ans_choice1="a";
$ans_des2="FALSE";   $ans_choice2="b";
for($a=1;$a<3;$a++){
$ans= ${"ans_des".$a};
$choice=${"ans_choice".$a};
		if(${"ans_choice".$a}==$answer)
			$correct=1;
		else
			$correct=0;
$sql2="INSERT INTO q_answers (answer_des,choice,question_id,active,correct) VALUES ('".$ans."','".$choice."',$question_id,1,$correct)";
//echo $sql2;
mysql_query($sql2);
}
/*
    if ($new_name != "") {
        $sql3 = "UPDATE q_questions SET attached_file='".$new_name."' WHERE question_id=$question_id;";
	   mysql_query($sql3);
    }*/

}else if($question_type=='fib'){
	$question = str_replace("'","&#039;",$question);
	$Comment = str_replace("'","&#039;",$Comment);
    $Lead = str_replace("'","&#039;",$Lead);
	$Solution = str_replace("'","&#039;",$Solution);
	$categories = str_replace("'","&#039;",$categories);
	if($score==""){
		$score=0;
	}
		//Insert question
    $d1=date('Y-m-d h:i:s');
  //--------29/10/47
  //Courses_id
$courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$modules.";");
$courses=mysql_result($courseid,0,"courses");
  //Insert into tb q_questions
  //***********insert modules_history***************
  $action="Add question";
  Imodules_h($quiz->getModules(),$action,$person["id"],$courses);

  $SqlIns = "INSERT INTO q_questions(question,score,solution,comment,created_by,categories,question_type,created_date,real_attached_file,active) VALUES('".$question."',$score,'".$Solution."','".$Comment."','".$person["id"]."','".$categories."','".$question_type."','".$d1."','".$picture_name."',1);";
  //
	mysql_query($SqlIns);

	//Get question ID
$question_id=mysql_insert_id();

/*
   //Rename file and copy to dir files/
    if($picture!="" && $picture!="none"){
      if (!isset ($_FILES['picture'])) {
           echo "Can not get source file.";
           exit;
      }
      $pos = strpos($_FILES['picture']['name'], '.');
      $file_type = substr($_FILES['picture']['name'],$pos);
      $new_name = "q".$question_id."_q".$file_type;
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
    }
	*/
		//Insert question ID into q_modules_questions
	$check=mysql_query("SELECT module_id AS id FROM q_modules_questions WHERE module_id=$modules AND question_id=$question_id;");
	if(mysql_num_rows($check)==0){
		$sql = "INSERT INTO q_modules_questions(module_id,question_id) VALUES($modules,$question_id);";
		mysql_query($sql);
	}
	/*
//Update file into tb q_questions
    if ($new_name != "") {
        $sql3 = "UPDATE q_questions SET attached_file='".$new_name."' WHERE question_id=$question_id;";
	    mysql_query($sql3);
    }
	*/

	//Insert into tb q_answers
	$sql="INSERT INTO q_answers (answer_des,question_id,active,correct) VALUES ('".$answer."',$question_id,1,1)";
	mysql_query($sql);
}else if($question_type=='mcit'){
	//echo "MCIT";
	$d1=date('Y-m-d h:i:s');
	$q_quertion="Matching Item";
	$SqlIns = "INSERT INTO q_questions(question,score,created_by,categories,question_type,created_date,comment,active) VALUES('".$q_quertion."',$score,'".$person["id"]."','".$categories."','".$question_type."','".$d1."','".$comment."','".$active."');";
   mysql_query($SqlIns);
       //Get question ID
    $question_id=mysql_insert_id();

	  //Insert question ID into q_modules_questions
   $check=mysql_query("SELECT module_id AS id FROM q_modules_questions WHERE module_id=".$quiz->getModules()." AND question_id=$question_id;");
    	if(mysql_num_rows($check)==0){
    		$sql = "INSERT INTO q_modules_questions(module_id,question_id) VALUES(".$quiz->getModules().",$question_id);";
    		mysql_query($sql);
    	} 
		//Courses_id
$courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$quiz->getModules().";");
$courses=mysql_result($courseid,0,"courses");
		//Insert question
	//***********insert modules_history***************
	$action="Add question";
	Imodules_h($quiz->getModules(),$action,$person["id"],$courses);

	//Insert  question (mcit)
    for ($a=1;$a<=$totquestion;$a++){
        $qpic = "";
		$new_name="";
          //Rename file and copy to dir files/
        if ((${"question".$a}!="") or (($_FILES["qpicture".$a]['name'])!="")){
             $qitem= ${"question".$a};
             $qitem = str_replace("'","&#039;",$qitem);
             $a_qitem= ${"question_a".$a};
             $a_qitem = str_replace("'","&#039;",$a_qitem);
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
              }  // end if question's pic
        }   // end if
		$sql=mysql_query("INSERT INTO q_question_mcit (question_id,mcit_des,correct,attached_file,real_attached_file) VALUES ($question_id,'".$qitem."','".$a_qitem."','".$new_name."','".$qpic."')");
     }  // end for

//Insert answer
 for ($b=1;$b<=$totanswer;$b++){
 		$aitem="";
         $apic = "";
		 $new_name="";
		 //Rename file and copy to dir files/
        if ((${"answer".$b}!="") or (($_FILES["apicture".$b]['name'])!="")){
             $aitem= ${"answer".$b};
             $aitem = str_replace("'","&#039;",$aitem);
			 $ans_choice=${"ans_choice".$b};
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
              }  // end if question's pic
        }   // end if
		$sql=mysql_query("INSERT INTO q_answer_mcit (question_id,mcit_ans_choice,mcit_ans_des,attached_file,real_attached_file) VALUES ($question_id,'".$ans_choice."','".$aitem."','".$new_name."','".$apic."')");
 }
}
header("Status: 302 Moved Temporarily");
header("Location:  ?a=addQuestion&m=admin&modules=".$modules."&result=1&question_type=".$question_type."");

?>