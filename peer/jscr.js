function delete_peer(m){
	if(confirm("Do you really want to delete this Peer module and all it´s content?")){
		if(confirm("Are you really...REALLY sure?\nALL data associated with this module will be permanently lost...\n\nThis action can´t be undone.")){
			window.location="../courses/delete.php?del=module&module=" + m;
		}
	}
}

function results(m){
	window.location="res.php?modules=" + m;	
}

function rand_peer(m,i){
	if(i==0){
		if(confirm("Do you really want to randomize the students?\nIf the students already have been assigned their reports to review you will be presented an option to redo the randomization...")){
			window.location="random.php?modules=" + m;
		}
	}else{
		alert("Your Peer module is still open for posting. Please change the last date for postings and try again later or wait with the randomization until later.");
	}
}

function isblank(s){
    for(var i = 0; i < s.length; i++) {
		var c = s.charAt(i);
		if ((c != ' ') && (c != '\n') && (c != '\t')) return false;
    }
	return true;
}

function verify(f){
	var msg;
	var empty_fields = "";
	var errors = "";
	var aMonth = new Array(31,28,31,30,31,30,31,31,30,31,30,31);

	str = document.setup.post_end.value;
	if(!str== ""){
		aDate = str.split("/");
		reg=new RegExp("/","gi");
		if(str.search(reg)!=-1){
	    	str2=str.substr((str.search(reg)+1));
	    	if(str2.search(reg)==-1){
				errors+="\n-Please use / between day/month/year.";
			}
		}else{		
			errors+="\n-Please use / between day/month/year.";
		}		
		if (aDate.length < 3){
			errors += "\n-Wrong date format - should be dd/mm/yyyy";
		}else{
			monthnum = aDate[1] - 1;
			if ((aDate[0] < 1) || (aDate[0] > aMonth[monthnum]) || (isNaN(aDate[0]))){
				errors += "\n-You can't have " + aDate[0] + " as a date in month nr " + aDate[1];
			}
			if((aDate[1] < 1) || (aDate[1] > 12)){
				errors += "\nMonth nr " + aDate[1] + " doesn't exist.";
			}
			if(isNaN(aDate[2])){
				errors += "\n" + aDate[2] + " is not a valid year.";
			}
		}
	}

	r_end = document.setup.review_end.value;
	if(!r_end== ""){
		aDate = r_end.split("/");
		reg=new RegExp("/","gi");
		if(r_end.search(reg)!=-1){
	    	r_end2=r_end.substr((r_end.search(reg)+1));
	    	if(r_end2.search(reg)==-1){
				errors+="\n-Please use / between day/month/year.";
			}
		}else{		
			errors+="\n-Please use / between day/month/year.";
		}		
		if (aDate.length < 3){
			errors += "\n-Wrong date format - should be dd/mm/yyyy";
		}else{
			monthnum = aDate[1] - 1;
			if ((aDate[0] < 1) || (aDate[0] > aMonth[monthnum]) || (isNaN(aDate[0]))){
				errors += "\n-You can't have " + aDate[0] + " as a date in month nr " + aDate[1];
			}
			if((aDate[1] < 1) || (aDate[1] > 12)){
				errors += "\nMonth nr " + aDate[1] + " doesn't exist.";
			}
			if(isNaN(aDate[2])){
				errors += "\n" + aDate[2] + " is not a valid year.";
			}
		}
	}
			//Kollar så att inte ngt fält är tomt
	    for(var i=0;i<f.length;i++) {
			var e = f.elements[i];
			if (((e.type == "text") || (e.type == "textarea")|| (e.type == "password")) && !e.optional) {
				// first check if the field is empty
				if((e.value == null) || (e.value == "") || isblank(e.value)) {
					empty_fields += "\n          " + e.name;
					continue;
				}
			}
		}
	
	if (!empty_fields && !errors) return true;
	msg  = "______________________________________________________\n\n";
	msg += "Your Form was not processed since it contained som errors. \n";
	msg += "              Please correct the errors and try again.\n";
	msg += "______________________________________________________\n\n";
	if (empty_fields) {
		msg += "- The following fields are empty:";
		msg += empty_fields + "\n";
		if (errors) msg += "\n";
	}
	msg += errors;
	alert(msg);
	return false;
}
