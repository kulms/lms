<!--
	//------------------------------------------------------------
	// JavaScript av Per Åsberg.
	//
	// Hjälp för formuläret och kontroll av inmatning.
	//-----------------------------------------------------------
		
		//Öppnar rätt hjälpavsnitt i ett nytt litet fönster
	function openHelp(s){
		link = "help.asp?vad=" + s
		window.open(link, "displayWindow", "ScreenX=570,ScreenY=70,width=200,height=350,status=no,toolbar=no,menubar=no");
	}
		//Sätter focus till första (Titel) fältet
	function setfocus() {
		document.reg.Title.focus();
		return;
	}
		// En funktion som returnerar sant om en sträng innehåller
		// endast "tomma" tecken (dvs om det är tomt).
		// Anropas från verify() nedan
	function isblank(s)
	{
	    for(var i = 0; i < s.length; i++) {
			var c = s.charAt(i);
			if ((c != ' ') && (c != '\n') && (c != '\t')) return false;
	    }
		return true;
	}
		
		//Går igenom alla element för att kontrollera att de inte är tomma
	function verify(f)
	{
		var msg;
		var empty_fields = "";
		var errors = "";
	
				//Kollar så att inte ngt fält är tomt
	    for(var i = 0; i < f.length; i++) {
			var e = f.elements[i];
			if (((e.type == "text") || (e.type == "textarea")|| (e.type == "password")) && !e.optional) {
				// first check if the field is empty
				if ((e.value == null) || (e.value == "") || isblank(e.value)) {
					empty_fields += "\n          " + e.name;
					continue;
				}
			}
		}
			
		// Om det uppstod ngt fel så ska meddelande om det skrivas ut, och
		// returnera false för att förhindra att formuläret skickas iväg. 
		// Annars returnera true.
		if (!empty_fields && !errors) return true;
			msg  = "______________________________________________________\n\n"
			msg += "Your Form was not processed since it contained som errors. \n";
			msg += "              Please correct the errors and try again.\n";
			msg += "______________________________________________________\n\n"
			if (empty_fields) {
				msg += "- The following fields are empty:" 
				+ empty_fields + "\n";
				if (errors) msg += "\n";
			}
			msg += errors;
			alert(msg);
			return false;
		}
	
	//-->