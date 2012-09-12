

function newWindow(url,w,h,r,s)
 {
   var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
  var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
		
   var options = "width="+w+",height="+h+",";
   options += "resizable="+r+",scrollbars="+s+",status=yes,menubar=no,toolbar=no,location=no,directories=no,";
   options += "left="+LeftPosition+",top="+TopPosition;
 
   newWin = window.open(url, "wName", options);
   newWin.focus();
 }

function iconfirm(in_url,msg)
		{
				if( confirm(msg) )
					{   
						document.location =in_url; 
					 }
		}


function validateEmail(str) {
  var supported = 0;
  if (window.RegExp) {
    var tempStr = "a";
    var tempReg = new RegExp(tempStr);
    if (tempReg.test(tempStr)) supported = 1;
  }
  if (!supported) return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);
  var r1 = new RegExp("(@.*@)|(\\.\\.)|(@\\.)|(^\\.)");
  var r2 = new RegExp("^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,3}|[0-9]{1,3})(\\]?)$");
  return (!r1.test(str) && r2.test(str));
}


function validRequired(formField,fieldLabel)
{
	var result = true;
	
	if (formField.value == "")
	{
		alert('Please enter a value for the "' + fieldLabel +'" field.');
		formField.focus();
		result = false;
	}
	
	return result;
}

function validSelect(formField,fieldLabel) {
	var strError;				
 	if(formField.selectedIndex == null) 
	{ 
	  alert("BUG: dontselect command for non-select Item"); 
	  return false; 
	} 
	if(formField.selectedIndex==0) 
	{ 
		strError = fieldLabel+" : Please Select one option ";
		formField.focus();
		alert(strError);
		return false;
	}
	return true;	
}		 

function allDigits(str)
{

	return inValidCharSet(str,"0123456789.");
}

function inValidCharSet(str,charset)
{

var result = true;

	
	
	for (var i=0;i<str.length;i++)
		
		
		if (charset.indexOf(str.substr(i,1))<0)
		{
			
			result = false;
			break;
		}
	
	return result;
}

function validNum(formField,fieldLabel,required)
{
	var result = true;

	if (required && !validRequired(formField,fieldLabel))
		result = false;
  
 	if (result)
 	{
 		if (!allDigits(formField.value))
 		{
 			alert('Please enter a number for the "' + fieldLabel +'" field.');
			formField.focus();		
			result = false;
		}
	} 
	
	return result;
}


function validInt(formField,fieldLabel,required)
{
	var result = true;

	if (required && !validRequired(formField,fieldLabel))
		result = false;
  
 	if (result)
 	{
 		var num = parseInt(formField.value,10);
 		if (isNaN(num))
 		{
 			alert('Please enter a number for the "' + fieldLabel +'" field.');
			formField.focus();		
			result = false;
		}
	} 
	
	return result;
}




function validateForm(theForm)
{
	
	
	if (!validRequired(theForm.g_score_name,"score name"))
		return false;
	
	
	
	if (!validNum(theForm.g_score,"score",true))
		return false;			
	
	
	
	return true;
}







