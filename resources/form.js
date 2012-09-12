
var mikExp = /[$\@#%\^\&\*\(\)\[\]\+\{\}\'\~\=¡¢¤¦§¨©ª«¬­®¯°³±²´µ¶·¸º¼»¾¿ËÃ¹ÂÅÊÈÇÉÌÍÎÄÆ]/;
extZip = new Array(".zip");
function checkEmptyAdd(val,type){
	var msg;
   var checkError = "";
   if(type=="folder"){
		if(add_folder.name.value ==""){
			checkError += "\n -  You can't have an empty FolderName";
			add_folder.name.focus();
		}
	}else if(type=="url"){
		if(add_url.name.value ==""){
			checkError += "\n -  You can't have an empty url name";
			add_url.name.focus();
		}
	}
	
	if (!checkError)return true;
	{
		msg  = "______________________________________________________\n\n"
		msg += "The form wasn't processed since it contained some errors. \n";
		msg += "         Please correct the following errors and try again.\n";
		msg += "______________________________________________________\n\n"
		msg += checkError;
		alert(msg);
		return false;
	}
}

function checkEmptyEdit(){
   var msg;
   var checkError = "";
	if(document.rename.name.value==""){
		checkError += "\n -  You can't have an empty name";
	}

	/*if(index_name !=""){
		if(document.rename.index.value==""){
			checkError += "\n -  You can't have an index name";
		}
	}*/

	if (!checkError)return true;
	{
		msg  = "______________________________________________________\n\n"
		msg += "The form wasn't processed since it contained some errors. \n";
		msg += "         Please correct the following errors and try again.\n";
		msg += "______________________________________________________\n\n"
		msg += checkError;
		alert(msg);
		return false;
	}
}

function checkEmptyZip(){
	alert("ss");
	var m=document.rename.modules.value;
	var c=document.rename.courses.value;
	var id=document.rename.id.value;
	//alert(c);
	window.location="edit.php?modules="+m+"&courses="+c+"&id="+id+"&folder=true&action=edit";
}


function checkFieldsEdit(val){
	var msg;
    var checkError = "";
	
	if(form.file.value !=""){
			var skip =0;
			var ext=form.file.value.slice(form.file.value.indexOf(".")).toLowerCase();
			for (var i = 0; i < extZip.length; i++) {
				if (extZip[i] != ext) 
					skip++;
			}
			if(skip == extZip.length ){
				checkError += "\n\n-Please only upload files that end in types:  " 
					+ (extZip.join("  ")) + "\nPlease select a new "
					+ "file to upload and submit again";
					form.file.focus();
			}
			
			if(form.file.value.search(mikExp) != -1) {
				checkError += "Sorry, but the following characters\r\n\r@ $ % ^ & * # ( ) [ ]  { + } ` ~ =  | \r\n\rFilename ·ÕèÁÕÍÑ¡ÉÃÀÒÉÒä·Â\r\n\rare not allowed!\n";
				form.file.focus();
			}
		}
	if (!checkError)return true;
	{
		msg  = "______________________________________________________\n\n"
		msg += "The form wasn't processed since it contained some errors. \n";
		msg += "         Please correct the following errors and try again.\n";
		msg += "______________________________________________________\n\n"
		msg += checkError;
		alert(msg);
		return false;
	}
	
}
function checkFields(val,type) {
	var msg;
    var checkError = "";
	
	if(type=='zip'){
		if(form.index.value==""){
			checkError += "\n     -  You can't have an empty IndexName";
			form.index.focus();
		}
		
		if(form.name.value==""){
			checkError += "\n     -  You can't have an empty FileName";
			form.name.focus();
		}

		if(form.file.value==""){
			checkError += "\n     -  File Upload";
		}else{
			var skip =0;
			var ext=form.file.value.slice(form.file.value.indexOf(".")).toLowerCase();
			for (var i = 0; i < extZip.length; i++) {
				if (extZip[i] != ext) 
					skip++;
			}
			if(skip == extZip.length ){
				checkError += "\n\n-Please only upload files that end in types:  " 
					+ (extZip.join("  ")) + "\nPlease select a new "
					+ "file to upload and submit again";
					form.file.focus();
			}
		}
	}else{
		if(form.file_old.value==""){
			if (form.file.value == "") {
				checkError += "\n     -  File Upload";
			}else{
				if(form.file.value.search(mikExp) != -1) {
					checkError += "Sorry, but the following characters\r\n\r@ $ % ^ & * # ( ) [ ]  { + } ` ~ =  | \r\n\rFilename ·ÕèÁÕÍÑ¡ÉÃÀÒÉÒä·Â\r\n\rare not allowed!\n";
					form.file.focus();
				}
			}
		}
	}
	if (!checkError)return true;
	{
		msg  = "______________________________________________________\n\n"
		msg += "The form wasn't processed since it contained some errors. \n";
		msg += "         Please correct the following errors and try again.\n";
		msg += "______________________________________________________\n\n"
		msg += checkError;
		alert(msg);
		return false;
	}
}


function chk_lstFolder(val) { 
	msg = "";
	if (val.value == -1) {
		msg ="_____________________________\n\n" +
		"Please Select Folder from List ...\n" +
		"_____________________________" ;		
		alert(msg);
		return false;
	}
	else {
		return true;
	}
}