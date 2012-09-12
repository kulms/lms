	<!-- 
//------------------------------------------------------------
// Check for empty or incorrect values
//-----------------------------------------------------------

function verify(f){
    var msg="";
	var checkError="";

	if ((f.email.value == "") || (f.email.value.indexOf('@', 0) == -1)){
		checkError += "\n\n-Your e-mail address is not valid!";
	}
	if(f.login.value==""){
		checkError += "\n\n-You must supply a login!";
	}
	if(f.firstname.value==""){
		checkError += "\n\n-You must supply a firstname!";
	}
	if(f.surname.value==""){
		checkError += "\n\n-You must supply a surname!";
	}

//alert(checkerror);
    // Display a message with encountered errors
    if (!checkError) return true;
    msg  = "______________________________________________________\n\n"
    msg += "The form wasn't processed since it contained some errors. \n";
    msg += "         Please correct the following errors and try again.\n";
    msg += "______________________________________________________"
    
    msg += checkError;
    alert(msg);
    return false;
}
	function checkmail(fm){
		if ((fm.email.value == "") || (fm.email.value.indexOf('@', 0) == -1)){
			alert("\n\n-Your e-mail address is not valid!");
			return false;
		}
		else{
			return true;
		}
	}

	//-->
