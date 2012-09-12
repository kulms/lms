function checkdate(f){
    var msg;
	var checkError = "";

		if (f.beTime.value == ""){
			checkError += "\n\n-Please Select BeginTime."
		}
		if (f.endTime.value == ""){
			checkError += "\n\n-Please Select EndTime."
		}
    if (!checkError) return true;
    msg  = "______________________________________________________\n\n"
    msg += "The form wasn't processed since it contained some errors. \n";
    msg += "         Please correct the following errors and try again.\n";
    msg += "______________________________________________________\n\n"
    
    msg += checkError;
    alert(msg);
    return false;
}

function OrderBy(a,f,bt,et,p,o,c,ut){
	window.location="?m=report&a="+a+"&filter="+f+"&beTime="+bt+"&endTime="+et+"&page="+p+"&order="+o+"&courses="+c+"&user_type="+ut+" ";
}

function NewWin(a,f,bt,et,o,c,ut,ac){
	links ="?m=report&a="+a+"&filter="+f+"&beTime="+bt+"&endTime="+et+"&order="+o+"&courses="+c+"&user_type="+ut+"&action="+ac+" ";
	window.open(links,"qWindow","ScreenX=200,ScreenY=70,width=700,height=580,toolbar=1,location=0,directories=0,status=0,menubar=1,scrollbars=1,resizable=0");
}

function Print(){
	window.print();
}