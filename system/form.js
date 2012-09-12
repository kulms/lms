function CheckNum(val){
	input = val.value;
				if (isNaN(input)) 
				{
					alert("The score must be numeric or must be greater than 0");
					val.value="";
					val.focus()
					return false;
				}

}

function CheckEmptyAlt(val){
	var checkError = "";
	var msg;
	var total=0;

	for(var i=1;i<6;i++)
    {
		if(document.all["alt"+i].value !=""){
			if(document.all["res"+i].value==""){
			checkError +="\n                      --Empty res"+i+"!!!--";
			document.all["res"+i].focus();
			}
		}else{
			total++;
		}
	}

	for(var ii=1;ii<6;ii++)
    {
		if(document.all["res"+ii].value !=""){
			if(document.all["alt"+ii].value==""){
			checkError +="\n                      --Empty alt"+ii+"!!!--";
			document.all["alt"+ii].focus();
			}
		}
	}
	
//check empty
if(total ==5)
	checkError +="\n                      --Empty Alternatives !!!--"; 

 if (!checkError) return true;
	 msg  = "______________________________________________________\n\n";
    msg += "The form wasn't processed since it contained some errors. \n";
    msg += "         Please correct the following errors and try again.\n";
    msg += "______________________________________________________\n\n";
    msg += checkError;
    alert(msg);
return false;
}