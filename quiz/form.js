<!--
function cont(m,cnt,occ,view,l){
	linkstring="index.php?modules=" + m + "&lead=0&lasterror=1&Cnt=" + cnt + "&occ=" +  occ + "&view=" + view  + "&last=" + l;
	window.location=linkstring;
}

	//Check for empty values and display validation alert
function verify(question_type,f,validation)
{
    var msg;
	var checkError = "";
	var nr = 0; cnt = 0;		//Number of alternatives in question
	var answer=false;	//If user didn't select any alternative
	
	for(i=0;i<f.length;i++){
		if((f.elements[i].type=="checkbox") || (f.elements[i].type=="radio")){
			nr++;
			if(f.elements[i].checked){
				answer = true;  //User selected at least one alternative
			}
		}
	}

if(question_type=="fib") {
	 if (f.elements["answer"].value == "") {
		checkError += "\n-You didn't fill in blank on the answer"
	  }else if ((isNaN(document.form.answer.value))||(document.form.answer.value<=0)) {
		checkError += "\n\n-The answer must be numeric or must be greater than 0!"
		document.form.answer.focus();
	} 
}
	
	if(question_type=="mcit") {
	//    q_cnt = f.mcit_q_cnt.value;
//		answer=true;
	//	if (q_cnt >= 1 && f.q_id1.value=="") { answer = false; }
//		if (q_cnt >= 2 && f.q_id2.value=="") { answer = false; }
//		if (q_cnt >= 3 && f.q_id3.value=="") { answer = false; }
//		if (q_cnt >= 4 && f.q_id4.value=="") { answer = false; }
//		if (q_cnt >= 5 && f.q_id5.value=="") { answer = false; }
//		if (q_cnt >= 6 && f.q_id6.value=="") { answer = false; }
//		if (q_cnt >= 7 && f.q_id7.value=="") { answer = false; }
//		if (q_cnt >= 8 && f.q_id8.value=="") { answer = false; }
//		if (q_cnt >= 9 && f.q_id9.value=="") { answer = false; }
//		if (q_cnt >= 10 && f.q_id10.value=="") { answer = false; }
	}

		
	if (!answer) {
		if ((question_type=="mltc") || (question_type=="tnf")) {
			checkError += "\n-You didn't select any alternative on the answer";
		} 
	}

    // If user didn't submit any question or corect answer 
	// a message should be displayed to the user
    if (!checkError) {
		if (!validation == "")
			return confirm(validation);
		else
			return true;
	}
    msg  = "______________________________________________________\n\n"
    msg += "The form wasn't processed since it contained some errors. \n";
    msg += "         Please correct the following errors and try again.\n";
    msg += "______________________________________________________\n\n"
    
    msg += checkError;
    alert(msg);
    return false;
}

function check(a,b){
 var msg;
 if(a !=b){
	msg  = "______________________________________________________\n\n"
    msg += "The form wasn't processed since it contained some errors. \n";
    msg += "         Please correct the following errors and try again.\n";
    msg += "______________________________________________________\n\n"

	msg += "                 You haven't finished the questions \n\n"
	alert(msg); 
	return false;
 }
}

function checkgrade(x){
			var x;
			var msg;
	        var checkError = "";
			var r = document.forms[0].elements['grade'];
			var multiple = document.forms[0].elements['multiple'];
			var quiztype = document.forms[0].elements['quiztype'];
			//var i = 0
			if(x==1){
				//alert(document.setup.num_score.value);
				var num = document.setup.num_score.value;
				if(num >1){
					checkError += "\n -This  score must equal \n";
					r[1].checked=true;
				}

				if(multiple[0].checked ==true){
					checkError += "\n -จำนวนครั้งในการทำข้อสอบควรเป็น ครั้งเดียว\n";
					r[1].checked=true;
				}

				if(quiztype[1].checked ==true){
					checkError += "\n -ชุดข้อสอบ ไม่ควรเป็นแบบประเมิน\n";
					r[1].checked=true;
				}

				if(checkError ==""){
					for (var i = 0; i < multiple.length; i++){
						multiple[i].checked=true;
						multiple[i].disabled=true;
					}
				}

			}else{
				for (var i = 0; i < multiple.length; i++){
					multiple[0].checked=true;
					multiple[i].disabled=false;
				}
			}
			

			

			if (!checkError)return true;
			{
				msg  = "______________________________________________________\n\n";
				msg += "Your Form was not processed since it contained som errors. \n";
				msg += "              Please correct the errors and try again.\n";
				msg += "______________________________________________________\n\n";
				msg += checkError;
				alert(msg); 
				return false;
			}
		}


extArray = new Array(".gif", ".jpg");
function LimitAttach(form, file) {
	allowSubmit = false;
	if (!file) return;
	while (file.indexOf("\\") != -1)
	file = file.slice(file.indexOf("\\") + 1);
	ext = file.slice(file.indexOf(".")).toLowerCase();
	for (var i = 0; i < extArray.length; i++) {
		if (extArray[i] == ext) { 
			allowSubmit = true; 
			break;
		}
	}


	if (allowSubmit) return true;
	else{
	alert("Please only upload files that end in types:  " 
	+ (extArray.join("  ")) + "\nPlease select a new "
	+ "file to upload and submit again.");
	return false;
	}
}
//-->
