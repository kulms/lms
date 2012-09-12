//Update 30/03/05 Nok

function set(f){
	var module_id = document.form.m_id.value;
	switch (f)
	{
	case 'insert_gname':
		window.opener.document.insert_gname.ModuleName.value =document.all["qname_"+module_id+""].value;
	   window.opener.document.insert_gname.m_id.value =module_id;
		window.close();
	break;
	case 'edit_gname':
		window.opener.document.edit_gname.ModuleName.value =document.all["qname_"+module_id+""].value;
		 window.opener.document.edit_gname.m_id.value =module_id;
	    window.close();
	break;
	}
}

function Click(m_id){
	document.form.m_id.value=m_id;
}



//funciton set cookie
function SetCookie (name, value) {  
var argv = SetCookie.arguments;  
var argc = SetCookie.arguments.length;  
var expires = (argc > 2) ? argv[2] : null;  
document.cookie = name + "=" + escape (value) + 
((expires == null) ? "" : ("; expires=" + expires.toGMTString())) ;
}

function getCookieVal (offset) {  
var endstr = document.cookie.indexOf (";", offset);  
if (endstr == -1)    
endstr = document.cookie.length;  
return unescape(document.cookie.substring(offset, endstr));
}
function GetCookie (name) {  
var arg = name + "=";  
var alen = arg.length;  
var clen = document.cookie.length;  
var i = 0;  
while (i < clen) {    
var j = i + alen;    
if (document.cookie.substring(i, j) == arg)      
return getCookieVal (j);    
i = document.cookie.indexOf(" ", i) + 1;    
if (i == 0) break;   
}  
return null;
}

function DeleteCookie (name) {  
var exp = new Date();  
exp.setTime (exp.getTime() - 1);  
var cval = GetCookie (name);  
document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString();
}
// end funciton set cookie
