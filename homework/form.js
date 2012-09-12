var mikExp = /[$\@#%\^\&\*\(\)\[\]\+\{\}\'\~\=°¢§¶ß®©™´¨≠ÆØ∞≥±≤¥µ∂∑∏∫ºªæøÀ√π¬≈ »«…ÃÕŒƒ∆]/;
function CheckEmpty(val,oldfile){
	//alert(val.q_type.value);
	//alert(oldfile);
	var msg;
	var checkError = "";


	//question
	switch(val.q_type.value) { 
		case ('0') :
				checkError +="\n                --Please select question type--  ";
				val.q_type.focus();
		break;
		case ('1') :
				if(val.name.value==""){
					checkError +="\n                      --Empty Assignment!!!--";
					val.name.focus();
				}
		break;
		case ('2') :
				if(val.url.value=="http://" || val.url.value=="" ){
					checkError +="\n                      --Empty URL Name!!!--";
					val.url.focus();
				}else if(val.name.value==""){
					checkError +="\n                      --Empty Assignment!!!--";
					val.name.focus();
				}
		break;
		case ('3') :
			if(oldfile == ""){
				if(val.file.value=="" ){
						checkError +="\n                      --Empty File Name!!!--";
						val.file.focus();
					}else if(val.name.value==""){
						checkError +="\n                      --Empty Assignment!!!--";
						val.name.focus();
					}else if(val.file.value.search(mikExp) != -1){
						checkError +="\nSorry, but the following characters\n\r\n\r@ $ % ^ & * # ( ) [ ]  { + } ` ~ =  | \n\r\n\rFilename ∑’Ë¡’Õ—°…√¿“…“‰∑¬\n\r\n\rare not allowed!\n";
					}
		}
		break;
	}

	//answer
	switch(val.sendtype.value) { 
		case ('0') :
				checkError +="\n                --Please select sending type--  ";
				val.sendtype.focus();
		break;
		case ('3') :
				if(val.dropdown.value==0){
					checkError +="\n                --Please select sending file type--  ";
					val.dropdown.focus();
				}else{
					if(val.filesize.value==0){
						checkError +="\n                --Please select sending filesize--  ";
						val.filesize.focus();
					}
				}
		break;
	}

	if(val.score.value==""){
		checkError +="\n                --Empty  Max scores!!--  ";
		val.score.focus();
	}

 if (!checkError) return true;
    msg  = "______________________________________________________\n\n";
    msg += "The form wasn't processed since it contained some errors. \n";
    msg += "         Please correct the following errors and try again.\n";
    msg += "______________________________________________________\n\n";
    msg += checkError;
    alert(msg);
    return false;
}

function CheckEmptyEdit(val){
		var checkError = "";
		var msg;
		//alert(val.q_type.value);
		//alert(val.sendtype2.value);

		switch(val.q_type.value) { 
		case ('2') :
			if(val.url.value=="http://" || val.url.value=="" ){
					checkError +="\n                      --Empty URL Name!!!--";
					val.url.focus();
				}else if(val.name.value==""){
					checkError +="\n                      --Empty Assignment!!!--";
					val.name.focus();
				}
		break;	
		}
	switch(val.sendtype2.value) { 
		case ('0') :
				checkError +="\n                --Please select sending type--  ";
				val.sendtype2.focus();
		break;
		case ('3') :
				if(val.dropdown.value==0){
					checkError +="\n                --Please select sending file type--  ";
					val.dropdown.focus();
				}else{
					if(val.filesize.value==0){
						checkError +="\n                --Please select sending filesize--  ";
						val.filesize.focus();
					}
				}
		break;
	}

	 if (!checkError) return true;
    msg  = "______________________________________________________\n\n";
    msg += "The form wasn't processed since it contained some errors. \n";
    msg += "         Please correct the following errors and try again.\n";
    msg += "______________________________________________________\n\n";
    msg += checkError;
    alert(msg);
    return false;
}

function CheckEmptyAns(val,file){
	var checkError = "";
	var msg;
	switch(val.ans_type.value){
		case('1') :
				 if(val.answer.value==""){
					checkError +="\n                      --Empty Answer!!!--";
					val.answer.focus();
				}
		break;
		case('2') :
				if(val.url.value=="http://" || val.url.value=="" ){
					checkError +="\n                      --Empty URL Name!!!--";
					val.url.focus();
				}
		break;
		case('3') :
			if(file ==""){
				if(val.answer.value=="" ){
						checkError +="\n                      --Empty File Name!!!--";
						val.answer.focus();
				}else if(val.answer.value.search(mikExp) != -1){
						checkError +="\nSorry, but the following characters\n\r\n\r@ $ % ^ & * # ( ) [ ]  { + } ` ~ =  | \n\r\n\rFilename ∑’Ë¡’Õ—°…√¿“…“‰∑¬\n\r\n\rare not allowed!\n";
				}
		}
		break;
	}
	 if (!checkError) return true;
    msg  = "______________________________________________________\n\n";
    msg += "The form wasn't processed since it contained some errors. \n";
    msg += "         Please correct the following errors and try again.\n";
    msg += "______________________________________________________\n\n";
    msg += checkError;
    alert(msg);
    return false;

}

function displayQuestion1(text,file) { 
	if(text==null)
		text="";
	switch (document.all.q_type.selectedIndex) { 
	case 0: 
		  document.all.area3.innerHTML = "";
		break; 
	case 1: 
		  document.all.area3.innerHTML = "<input type=\"hidden\" name=\"question_type\" value=\"text\">"+
		  								 "<input type=\"hidden\" name=\"text\" value=\"1\">";
		break; 
	case 2: 
		document.all.area3.innerHTML = "<input type=\"text\" name=\"url\" size=\"70\" value=\"http:\/\/"+text+"\" class=\"text\">"+
										"<input type=\"hidden\" name=\"question_type\" value=\"url\">";
		break; 
	case 3: 
		if(file ==""){
			document.all.area3.innerHTML = "<input type=\"file\" size=\"49\" name=\"file\" class=\"button\">"+
																		"<input type=\"hidden\" name=\"question_type\" value=\"file\">";
		}else{
			document.all.area3.innerHTML = "<input type=\"file\" size=\"49\" name=\"file\" class=\"button\">"+
																			"  <b>Old file:  "+file+"</b>"+
																		"<input type=\"hidden\" name=\"question_type\" value=\"file\">";
		}

		break; 	
		}		 
} 

function CheckNum(){
	input = document.form.score.value;
				if (isNaN(input)) 
				{
					alert("The score must be numeric or must be greater than 0");
					document.form.score.value="";
					document.form.score.focus()
					return false;
				}
}

