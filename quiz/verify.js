<!--


function view_q(q,m,cnt){
	links = "?a=view&m=admin&qid=" + q + "&modules=" + m+"&cnt="+cnt;
	window.open(links, "qWindow", "ScreenX=200,ScreenY=70,width=650,height=580,status=no,toolbar=no,menubar=no,scrollbars=yes");
}

function view_ans(o,m)
{
	links = "?a=view_ans&m=admin&occ="+o+"&modules="+m;
	window.open(links, "qWindow", "ScreenX=200,ScreenY=70,width=650,height=580,status=no,toolbar=no,menubar=no,scrollbars=yes");
}
function navigation(m){
//alert(document.nav.ctrlpanel.value);
	switch(document.nav.ctrlpanel.selectedIndex){
	case 1:
		window.location="setup.php?id=" + m;
		break;
	case 2:
		window.location="Addquestions.php?modules=" +m;
		break;
	case 3:
		window.location="edit.php?modules=" +m
		break;
	case 4:
		window.location="viewQuestions.php?modules=" + m;
		break;
	case 5:
		window.location="search.php?modules=" +m;
		break;
	case 6:
		if(confirm("Do you really want to delete this quiz and all itดs content?")){
			if(confirm("Are you really...REALLY sure?\nALL data associated with this quiz will be permanently lost...\n\nThis action can't be undone.")){
				window.location="../courses/delete.php?del=module&module=" + m;
			}
		}
		break;
	case 7:
		window.location="AllStat.php?modules=" + m;
		break;
	case 8:
		window.location="useranswers.php?modules=" +m
		break;
	}
}

//------------------------------------------------------------

// Check for empty or incorrect values

//-----------------------------------------------------------
extArray = new Array(".gif", ".jpg");
function verify(f,qt){
    var msg;
	var checkError = "";
	var count = 0;
	var nr = 0;

	for(i=0;i<f.length;i++){
		if(f.elements[i].type=="checkbox"){
			nr++;
		}
	}

	if (document.form.question.value==""){
		checkError += "\n-You didn't submit any question...";
	}
	
//	if (qt==0)  {
		check = false;
		for(a=1;a<nr+1;a++){
			if(f.elements["true_"+a].checked)
			check = true;
		}
		if (!check){
			checkError += "\n\n-You have to select at least ONE correct answer!";
		}
		
		if (f.score.value == ""){
			checkError += "\n\n-Please type in the score."
		   document.form.score.focus();
		}
		else {
			if ((isNaN(f.score.value))||(f.score.value<=0))
				checkError += "\n\n-The score must be numeric or must be greater than 0!"
		}
		
		if(eval(f.maxscore.value) !=0){
			if(f.score.value  != eval(f.maxscore.value))
				checkError += "\n\n-This  score must equal with the previeus  score which have been added  your score = "+f.maxscore.value
			   document.form.score.focus();
		}

	if(f.picture.value != ""){
		var skip =0;
		var ext=f.picture.value.slice(f.picture.value.indexOf(".")).toLowerCase();
		for (var i = 0; i < extArray.length; i++) {
			if (extArray[i] != ext) 
				skip++;
		}
		if(skip == extArray.length ){
			checkError += "\n\n-Please only upload files that end in types:  " 
				+ (extArray.join("  ")) + "\nPlease select a new "
				+ "file to upload and submit again";
				f.picture.focus();
		}
	}

	for(a=1;a<nr+1;a++){
		if(document.all["alternative_pic"+a+""].value !=""){
			var skip=0;
			var ext=document.all["alternative_pic"+a+""].value.slice(document.all["alternative_pic"+a+""].value.indexOf(".")).toLowerCase();
			for (var i = 0; i < extArray.length; i++) {
				if (extArray[i] != ext) 
					skip++;
			}
			if(skip==extArray.length){
				checkError += "\n\n-Please only upload files that end in types:  " 
					+ (extArray.join("  ")) + "\nPlease select a new "
					+ "file to upload and submit again answer "+a; 
					document.all["alternative_pic"+a+""].focus();
			}
		}
	}
	
	//check edit score
	if(f.qnr.value !=""){
		if(f.num_rows.value !=0){
			if(eval(f.h_score.value) != f.score.value){
				checkError += "\n\n-แบบทดสอบนี้ ไม่สามารถทำการแก้ไขคะแนนได้ เนื่องจากได้มีแบบทดสอบอื่นได้ทำการใช้ แบบทดสอบข้อนี้อยู่"
				document.form.score.focus();
			}
		}
	}

    // Display a message with encountered errors
    if (!checkError) return true;
    msg  = "______________________________________________________\n\n"
    msg += "The form wasn't processed since it contained some errors. \n";
    msg += "         Please correct the following errors and try again.\n";
    msg += "______________________________________________________\n\n"
    
    msg += checkError;
    alert(msg);
    return false;
}

//-----------------------------------------------------------
function verifyTF(f,qt,qtype){
    var msg;
	var checkError = "";
	var count = 0;
	var nr = 0;
	for(i=0;i<f.length;i++){
		if(f.elements[i].type=="checkbox"){
			nr++;
		}
	}

if (document.form.question.value==""){
		checkError += "\n-You didn't submit any question...";
		document.form.question.focus();
	}

	//if (qt==0)  {
/*			check = false;
		for(a=1;a<nr+1;a++){
			if(f.elements["true_"+a].checked)
			check = true;
		}
*/
		if (f.score.value == ""){
				checkError += "\n\n-Please type in the score."
			document.form.score.focus();
		}else {
			if ((isNaN(f.score.value))||(f.score.value<=0))
				checkError += "\n\n-The score must be numeric or must be greater than 0!"
		}
			
	    if(f.elements["answer"].value == ""){
			checkError += "\n\n-You can't have an empty answer as correct answer."
			document.form.answer.focus();
		}else {
			if (qtype=='fib'){
				if ((isNaN(document.form.answer.value))||(document.form.answer.value<=0)){
					checkError += "\n\n-The answer must be numeric or must be greater than 0!"
					document.form.answer.focus();
			   }
			}
		}

		if(eval(f.maxscore.value) != 0){
			if(f.score.value  != eval(f.maxscore.value))
				checkError += "\n\n-This  score must equal with the previeus  score which have been added  your score = "+f.maxscore.value
			   document.form.score.focus();
		}

		if(f.picture.value != ""){
			var skip=0;
			var ext=f.picture.value.slice(f.picture.value.indexOf(".")).toLowerCase();
			for (var i = 0; i < extArray.length; i++) {
				if (extArray[i] != ext) 
					skip++;
			}
			if(skip==extArray.length){
					checkError += "\n\n-Please only upload files that end in types:  " 
					+ (extArray.join("  ")) + "\nPlease select a new "
					+ "file to upload and submit again"; 
					f.picture.focus();
			}
		}

	if(f.qnr.value !=""){
		if(f.num_rows.value !=0){
			if(eval(f.h_score.value) != f.score.value){
				checkError += "\n\n-แบบทดสอบนี้ ไม่สามารถทำการแก้ไขคะแนนได้ เนื่องจากได้มีแบบทดสอบอื่นได้ทำการใช้ แบบทดสอบข้อนี้อยู่"
				f.score.value=eval(f.h_score.value);
				document.form.score.focus();
			}
		}
	}
	//}
    // Display a message with encountered errors
    if (!checkError) return true;
    msg  = "______________________________________________________\n\n"
    msg += "The form wasn't processed since it contained some errors. \n";
    msg += "         Please correct the following errors and try again.\n";
    msg += "______________________________________________________\n\n"
    
    msg += checkError;
    alert(msg);
    return false;
}

//-----------------------------------------------------------
function verifyMCIT(f,qt,ft,num,num_a,total){
	//alert(num_a);
   var msg;
	var checkError = "";
	var count = 0;
	var nr = 0;
	var p=0;
	var ans_choice=new Array();
	var choice=new Array();
	if (ft=="data") {
		/*for(i=0;i<f.length;i++){
			if(f.elements[i].type=="checkbox"){
				nr++;
			}
		}*/

			//check answer
			for(var b=1;b< num_a+1;b++){
				ans_choice[b]=f.elements["ans_choice"+b].value;
				var str=f.elements["answer"+b].length;
				//alert(str);
				//if(f.elements["answer"+b].value == "" &&  ( f.elements["apicture"+b].value == "" &&  f.elements["old_pic_a"+b].value==""))
				//	checkError += "\n\n-You can't have an empty question as answer #"+ans_choice[b];

				 if(f.elements["answer"+b].value == ""){
					if( f.elements["old_pic_a"+b].value == ""){
						if( f.elements["apicture"+b].value == "")
							checkError += "\n\n-You can't have an empty question as answer #"+ans_choice[b];
					}
				}
				
			} //end for

		for(var bb=1;bb<num_a+1;bb++){
			if(document.all["apicture"+bb].value !=""){
				var skip=0;
				var ext=document.all["apicture"+bb].value.slice(document.all["apicture"+bb].value.indexOf(".")).toLowerCase();
				for (var i = 0; i < extArray.length; i++) {
					if (extArray[i] != ext) 
						skip++;
				}
				if(skip==extArray.length){
					checkError += "\n\n-Please only upload files that end in types:  " 
						+ (extArray.join("  ")) + "\nPlease select a new "
						+ "file to upload and submit again answer #"+ans_choice[bb]; 
						document.all["apicture"+bb].focus();
				}
			}
		}

			

			//check question
			for(var a=1;a<num+1;a++){
			choice[a]=document.all["question_a"+a].value;
			
			 if(f.elements["question"+a].value == ""){
						checkError += "\n\n-You can't have an empty question as question no."+a;
				}

				 if(f.elements["question"+a].value == ""){
					if( f.elements["qpicture"+a].value == ""){
						if( f.elements["old_pic_q"+a].value == "")
							checkError += "\n\n-You can't have an empty question as answer #"+ans_choice[a];
						else
							var p=1;
					}
				}
		for(var aa=1;aa<num+1;aa++){
				if(document.all["qpicture"+aa].value !=""){
					var skip=0;
					var ext=document.all["qpicture"+aa].value.slice(document.all["qpicture"+aa].value.indexOf(".")).toLowerCase();
					for (var i = 0; i < extArray.length; i++) {
						if (extArray[i] != ext) 
							skip++;
					}
					if(skip==extArray.length){
						checkError += "\n\n-Please only upload files that end in types:  " 
							+ (extArray.join("  ")) + "\nPlease select a new "
							+ "file to upload and submit again answer #"+aa; 
							document.all["qpicture"+aa].focus();
					}
				}
			}

				if(f.elements["question_a"+a].value == ""){
					checkError += "\n\n-You can't have an empty answer as correct answer question #."+a;
				}
			}

			for(var n=1;n<num+1;n++)
    		{
				var skip=0;	
				for(var nn=1;nn<num_a+1;nn++){
					if(choice[n] ==ans_choice[nn] || f.elements["question_a"+n].value == ""){
						skip++;
					}
				}
				if(skip==0){
					checkError += "\n\n-You can't have an empty alternative as correct answer question #."+i;
				}
			}	
		//}
	} else {     //  elseif (ft=="data")
		if (f.score_T.value == "")
			checkError += "\n\n-Please type in the score."
		else {
			if ((isNaN(f.score_T.value))||(f.score_T.value<=0))
				checkError += "\n\n-The score must be numeric or must be greater than 0!"
		}

		if (f.totquestion.value == "") 
			checkError += "\n\n-You can't have an empty No.of Question."
		else {
			if ((isNaN(f.totquestion.value))||(f.totquestion.value<=0))
				checkError += "\n\n-The No. of Question must be numeric or must be greater than 0!"
		}

		if (f.totanswer.value == "") 
			checkError += "\n\n-You can't have an empty No.of Answer."
		else {
			if ((isNaN(f.totanswer.value))||(f.totanswer.value<=0))
				checkError += "\n\n-The No. of Answer must be numeric or must be greater than 0!"
		}


		
	//	if (f.totquestion.value > 10)
	//		checkError += "\n\n-Please enter total No.of Question in range of 1 to 10."
	}	
		if(total != "")
		{
		if(f.totanswer.value != null){
			var total_q=f.totquestion.value;
			var total_s=f.score_T.value;
			var total_s=total_q*total_s;
		}else{
			var total_s=f.score_T.value;
			var total_s=num*total_s;
		}
			if(total_s != total ){
				checkError += "\n\n-This MatchingItem score must equal with the previeus MatchingItem score which have been added !\n";
				//checkError += "-This MatchingItem score ="+total;
			}
		}
    // Display a message with encountered errors
    if (!checkError) return true;
    msg  = "______________________________________________________\n\n"
    msg += "The form wasn't processed since it contained some errors. \n";
    msg += "         Please correct the following errors and try again.\n";
    msg += "______________________________________________________\n\n"
    
    msg += checkError;
    alert(msg);
    return false;
}
//-----------------------------------------------------------
	function remove_question(qnr,m){
		if(confirm("Are you sure that you want to remove this question from your quiz?\nIf you change your mind you can always locate it by using the search function.")){
				window.location="?a=remove&m=admin&qnr=" + qnr + "&modules=" + m;
		}
	}

	function editQuiz(m){
		window.location="?a=setup&m=admin&modules=" + m;
	}
	
	function editQuestion(qid,m){
		window.location="?a=editQuestion&m=admin&qid="+qid+"&modules=" + m;	
	}

	function DeleteQuestion(mk,qid,aid,m,qt,q,del){
		if(q==1){
			if(confirm("Are you sure that you wish to delete question in the form?")){
				window.location="?a=changeQuestions&m=admin&makecopy="+mk+"&qnr="+qid+"&ans_id="+aid+"&modules="+ m+"&question_type="+qt+"&q="+q+"&del="+del;	
			}
		}else{
			if(confirm("Are you sure that you wish to delete picture in the form?")){
				window.location="?a=changeQuestions&m=admin&makecopy="+mk+"&qnr="+qid+"&ans_id="+aid+"&modules="+ m+"&question_type="+qt+"&q="+q+"&del=1"+del;	
			}
		}
	}

	function viewQuestions(m){
		window.location="?a=viewQuestion&m=admin&modules=" + m;	
	}
	
	function skipit(m){
		window.location="?a=setactive&m=admin&modules=" +m;
	}
	function addquestions(m,qt){
		window.location="?a=addQuestion&m=admin&modules=" +m+"&question_type="+qt;
	}
	function addquestionstnf(m){
		window.location="Addquestionstnf.php?modules=" + m ;
	}
	function addquestionsmcit(m){
		window.location="Addquestionsmcit.php?modules=" +m;
	}
	function addquestionsfib(m){
		window.location="Addquestionsfib.php?modules=" + m ;
	}

	function viewUserResult(m){
		window.location="?a=useranswersByuser&m=admin&modules=" +m;
	}
	function viewall(m){
		window.location="?a=useranswers&m=admin&modules=" +m;
	}
	function search_quiz(m){
			window.location="?a=search&m=admin&modules=" + m;
	}
	function check_delete_question(qnr,m){
		if(confirm("Are you sure that you want to completely delete this question?")){
			if(confirm("Are you REALLY sure that you want to erase this question and its information ?\nThis action can' be undone...")){
				window.location="?a=delete_question1&m=admin&qnr="+ qnr +"&modules=" + m;			
			}		
		}
	}
	function check_delete(m){
		if(confirm("Do you really want to delete this quiz and all this conten?")){
			if(confirm("Are you really...REALLY sure?\nALL data associated with this quiz will be permanently lost...\n\nThis action can't be undone.")){
				//window.location="../courses/delete.php?del=module&module=" + m;
				window.location="?a=delete&m=admin&module=" + m;	
			}
		}
	}

	//update 20/04/05
	function import_quiz(m){
		window.location="?a=import&m=admin&modules=" + m;
	}
	//
//-->

