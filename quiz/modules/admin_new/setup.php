<? 
require("../include/global_login.php");
include('classes/config.inc.php');
require("header.php");
//echo $quiz->getModules();

$result=$quiz->CheckScore($quiz);                       //check score for grading
$num_score=$result->numRows();

if($id !="")
	$modules=$id;
//$quiz=new Quiz('',$modules,'');
//Update Setup
if($setup==1){
	//set color
	if($bgcolor == "")
		$color=$OtherBgcolor;
	else
		$color=$bgcolor;
	
	//set Limit
	 if($qlimit=="")
		 $qlimit=0;
	
	//set grade
	 if($grade=="")
		 $grade=0;

	 //set  View
	 if($endview==0)
		 $view=0;

	 //set  Time
	 if($time==1)
			$total=$sel_hour+$sel_minute;
	else
			$total=0;
	
	if($grade==1)
		 $multiple=0;

	//set  end_date
	if($end_date=="")
           $in_date=0;
    else{
            $date_parts = explode("/",$end_date);
               if($date_parts[2]<1990)
				   $years=1900+$date_parts[2];
                else
                    $years=$date_parts[2];
			$in_date=mktime(0,0,0,$date_parts[1],$date_parts[0],$years);
	}	
	
	//set  quiztype
	if ($quiztype==1) { 
         $endview=0;
          $view=0;
           $randomized=0;
               //  $oneOrMany=1; //$multiple=0;
    }

	 $sql = "UPDATE q_module_prefs SET multiple=$multiple, end_date=$in_date, bgcolor='".$color."',validation='".$validation."',oneOrMany=".$oneOrMany.", randomize=".$randomized.", info='".$text_info."',view=".$view.",quiztype=".$quiztype.",qlimit=".$qlimit.",endview=".$endview." ,matching ='".$matching ."',timeLimited =".$time.",timeLimit=".$total.",grading=".$grade." WHERE module_id =".$quiz->getModules().";";
	mysql_query($sql);
	//header("Status: 302 Moved Temporarily");
	//header("Location:  ?a=addQuestion&m=admin&question_type='mltc'&modules=".$quiz->getModules());
	//exit;
}else{
	$QName=mysql_query("SELECT name FROM modules  WHERE id=".$quiz->getModules()."");
	$Qname= mysql_result($QName,0,"name");
	$GetAll = mysql_query("SELECT * FROM q_module_prefs WHERE module_id=".$quiz->getModules()."");
                if(mysql_num_rows($GetAll)!=0)
                 {      $row=mysql_fetch_array($GetAll);
                                $multiple = $row["multiple"];
                                $color = $row["bgcolor"];
                                $validation = $row["validation"];
                                $oneOrMany = $row["oneOrMany"];
                                $end_date = $row["end_date"];
                                $u_id = $row["pref_id"];
                                $randomized = $row["randomize"];
                                $info = $row["info"];
                                $view=$row["view"];
                                $endview=$row["endview"];
                                $quiztype=$row["quiztype"];   		//0=Quiz ; 1=Survey
                                $qlimit=$row["qLIMIT"];
								 $matching=$row["matching"];
								$timeLimited=$row['timeLimited'];
								$timeLimit=$row['timeLimit'];
								$grading=$row['grading'];
								if($qlimit==0){     $qlimit="";    }
                                $exists=1;
                } 
	//if($exists!=1){
	//	$checked="checked";
	//}else{
	//	 if($endview ==2 || $endview=="")
		//		$checked="checked";
	//	else if($endview==1)
	//			$checked="checked";
	//	else if($endview==0)
	//			$checked="checked";
	//}

if($color !='white' && $color !='antiquewhite' && $color !='mintcream'&& $color !='#ccccff' && $color !='coral' && $color !='tan' && $color !='royalblue' && $color !='gainsboro' )
		$Color=$color;
}
$min=($timeLimit / 60 );
$min=explode(".",$min);

$sic=($timeLimit % 60 );

//select quiz use in grade
$sql_quiz=mysql_query("SELECT g_modules_id  FROM g_score_type WHERE g_modules_id = ".$quiz->getModules()." ");
$num_quiz=mysql_num_rows($sql_quiz);
//====================Template=========================
$template= new Template(C_SKIN);	
$template->set_filenames(array('body' =>  'main_menu.html',
																'main'=>'main_edit_quiz.html'
																));
$template->assign_vars(array('TEXT' =>$strQuiz_LabText ,
																'Q_ID'=>$quiz->getModules(),
																'DEL_'=>($num_quiz !=0)?"1":"0",
																'Q_NAME'=>$name,
																'VIEW'=>$strQuiz_MenuViewAdd ,
																'EDIT'=>$strQuiz_MenuEditPreference,
																'ADD'=>$strQuiz_MenuAddQuestion,
																'ADD1'=>$strQuiz_MenuAddMultipleChoice,
																'ADD2'=>$strQuiz_MenuAddTrueFalse,
																'ADD3'=>$strQuiz_MenuAddMatching,
																'ADD4'=>$strQuiz_MenuAddFilling,
																'SET'=>$strQuiz_MenuSetActive,
																'VIEWQ'=>$strQuiz_MenuViewAdd,
																'SEARCH'=>$strQuiz_MenuSearchQuestion,
																'DEL'=>$strQuiz_MenuDeleteQuiz,
																'RESULT'=>$strQuiz_MenuResult,
																'RESULT1'=>$strQuiz_MenuResultByUser,
																'RESULT2'=>$strQuiz_MenuResultByQuestion,
																//setup text
																'SUBMIT_B'=>$strSubmit,
																'RESET_B'=>$strReset,
																'QUIZ_NAME'=>$strQuiz_LabName,
																'MAX_NAME'=>$strQuiz_LabMaxName,
																'QUIZ_SURVEY'=>$strQuiz_LabQuizOrSurvey,
																'QUIZ'=>$strQuiz_LabQuiz,
																'SURVEY'=>$strQuiz_LabSurvey,
																'DATE'=>$strQuiz_LabLastDate,
																'VALIDATE'=>$strQuiz_LabValidate,
																'MULTIPLE'=>$strQuiz_LabMultipleSelect,
																'DEPEND'=>$strQuiz_LabDependOn,
																'CHOOSE'=>$strQuiz_LabMultiChoose,
																'RANDOM'=>$strQuiz_LabRandom,
																'VIEW_ANS'=>$strQuiz_LabViewAns,
																'VIEW_SOL'=>$strQuiz_LabViewSol,
																'OnebyOne'=>$strQuiz_LabViewOnebyOne,
																'ViewAllQuiz'=>$strQuiz_LabViewAllQuiz,
																'ViewAnsNo'=>$strQuiz_LabViewAnsNo,
																'TIME_QUIZ'=>$strQuiz_LabTimesQuiz,
																'TIME_SEVERAL'=>$strQuiz_LabSeveral,
																'TIME_ONCE'=>$strQuiz_LabOnce,
																'MATCHING'=>$strQuiz_LabSelectMatching,
																'SEL_TIMER'=>$strQuiz_LabSelectTimer,
																'TIMER'=>$strQuiz_LabTimer,
																'HOUR'=>$strQuiz_LabHour,
																'MINUTE'=>$strQuiz_LabMinute,
																'TOTAL'=>$strQuiz_LabTotalQuestion,
																'YES'=>$strYes,
																'NO'=>$strNo,
																'SEL_COLOR'=>$strQuiz_LabSelectColor,
																//color
																'White'=>$strQuiz_LabWhite,
																'AntiqueWhite'=>$strQuiz_LabAntiqueWhite,
																'MintCream'=>$strQuiz_LabMintCream,
																'LearnLoopBlue'=>$strQuiz_LabLearnLoopBlue,
																'Coral'=>$strQuiz_LabCoral,
																'Tan'=>$strQuiz_LabTan,
																'RoyalBlue'=>$strQuiz_LabRoyalBlue,
																'Gainsboro'=>$strQuiz_LabGainsboro,
																'OtherColor'=>$strQuiz_LabOtherColor,
																'StartPage'=>$strQuiz_LabStartPage,
																//detail
																'QuizName'=>$Qname,
																'QuizLimit'=>$qlimit,
																'TextInfo'=>$info,
																'IsSel_quiztype0'=>($quiztype==0 || $quiztype=="")?"checked":"",
																'IsSel_quiztype1'=>($quiztype==1)?"checked":"",
																'EndDate'=>($end_date !=0)?"".date("d/m/Y", $end_date)."":"",
																'Validate'=>$validation,
																'IsSel_oneOrMany0'=>($oneOrMany==0 || $oneOrMany=="")?"checked":"",
																'IsSel_oneOrMany1'=>($oneOrMany==1)?"checked":"",
																'IsSel_random0'=>($randomized==0 || $randomized=="")?"checked":"",
																'IsSel_random1'=>($randomized==1 )?"checked":"",
																'IsDisabled_endview'=>($quiztype==1)?"disabled":"",
																'IsSel_endview0'=>($endview==0)?"checked":"",
																'IsSel_endview1'=>($endview==1)?"checked":"",
																'IsSel_endview2'=>($endview==2  || $endview=="" )?"checked":"",
																'IsDisabled_view1'=>($endview==0)?"disabled":"",
																'IsDisabled_view0'=>($endview==0)?" disabled checked":"",
																'IsSel_view1'=>($view==1 || $view=="")?"checked":"",
																'IsSel_view0'=>($view==0)?"checked":"",
																'IsSel_grade1'=>($grading ==1 || $grading =="")?"checked":"",
																'IsSel_grade0'=>($grading ==0)?"checked":"",
																'IsSel_multiple1'=>($multiple==1 )?"checked":"",
																'IsSel_multiple0'=>($multiple==0 || $multiple=="")?"checked":"",
																'IsDisabled_multiple'=>($quiztype==1)?"disabled":"",
																'IsDisabled_multiple'=>($quiztype==1)?"disabled":"",
																'IsSel_matching1'=>($grading==1)?"disabled":"",
																'IsSel_matching0'=>($grading==1)?"checked disabled":"",
																'IsSelmatching1'=>($matching==1)?"checked":"",
																'IsSelmatching0'=>($matching==0)?"checked ":"",
																'IsSel_timeLimited1'=>($timeLimited==1 )?"checked":"",
																'IsSel_timeLimited0'=>($timeLimited==0 || $timeLimited=="")?"checked":"",
																'IsSel_white'=>($color=="white" ||  $color=="")?"checked":"",
																'IsSel_antiquewhite'=>($color=="antiquewhite" )?"checked":"",
																'IsSel_mintcream'=>($color=="mintcream" )?"checked":"",
																'IsSel_#ccccff'=>($color=="#ccccff" )?"checked":"",
																'IsSel_coral'=>($color=="coral" )?"checked":"",
																'IsSel_tan'=>($color=="tan")?"checked":"",
																'IsSel_royalblue'=>($color=="royalblue")?"checked":"",
																'IsSel_gainsboro'=>($color=="gainsboro")?"checked":"",
																'Color'=>$Color,
																'IsSel_h0'=>($min[0]==0)?"selected":"",
																'IsSel_h1'=>($min[0]==1)?"selected":"",
																'IsSel_h2'=>($min[0]==2)?"selected":"",
																'IsSel_h3'=>($min[0]==3)?"selected":"",
																'IsSel_s0'=>($sic==0)?"selected":"",
																'IsSel_s5'=>($sic==5)?"selected":"",
																'IsSel_s10'=>($sic==10)?"selected":"",
																'IsSel_s15'=>($sic==15)?"selected":"",
																'IsSel_s20'=>($sic==20)?"selected":"",
																'IsSel_s25'=>($sic==25)?"selected":"",
																'IsSel_s30'=>($sic==30)?"selected":"",
																'IsSel_s35'=>($sic==35)?"selected":"",
																'IsSel_s40'=>($sic==40)?"selected":"",
																'IsSel_s45'=>($sic==45)?"selected":"",
																'IsSel_s50'=>($sic==50)?"selected":"",
																'IsSel_s55'=>($sic==55)?"selected":"",
																'Score'=>$num_score,
																));
if($setup !=1){
$template->assign_var_from_handle('MAIN', 'main');

$template->pparse('body');
}else{
?>
<html>
<head>
	<title></title>
	<META HTTP-EQUIV="Refresh" CONTENT="1;URL=?a=addQuestion&m=admin&question_type=mltc&modules=<?echo $quiz->getModules() ?>">	
</head>
<p>&nbsp;</p>
<div align="center" class="Terror"><b>Your preference is updated...</b></div>
</html> 
<? }?>