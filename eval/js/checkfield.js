<!--/// - - - ต้อง count ตัว input ที่ type=radio/checked  นำหน้าด้วย qs,qu, (ต้อง trim ก่อน)txts, txtu - - - ///

function Checkuser(formobj){

	// Enter name of mandatory fields
	var fieldRequired = Array();
	// Enter field description to appear in the dialog box
	var fieldDescription = Array();

	// dialog message
	var alertMsg = "กรุณากรอกแบบประเมินให้สมบูรณ์ โดยเฉพาะช่องต่อไปนี้ :\n";
	
	var l_Msg = alertMsg.length;
	
	for (var i = 0; i < fieldRequired.length; i++){
		var obj = formobj.elements[fieldRequired[i]];

		if (obj){
			switch(obj.type){
			case "select-one":
				if (obj.selectedIndex == -1 || obj.options[obj.selectedIndex].text == ""){
					alertMsg += " - " + fieldDescription[i] + "\n";
				}
				break;
			case "select-multiple":
				if (obj.selectedIndex == -1){
					alertMsg += " - " + fieldDescription[i] + "\n";
				}
				break;
			case "text":
			case "textarea":
				if (obj.value == "" || obj.value == null){
					alertMsg += " - " + fieldDescription[i] + "\n";
				}
				break;
			default:
			}
			if (obj.type == undefined){
				var blnchecked = false;
				for (var j = 0; j < obj.length; j++){
					if (obj[j].checked){
						blnchecked = true;
					}
				}
				if (!blnchecked){
					alertMsg += " - " + fieldDescription[i] + "\n";
				}
			}
		}
	}

	if (alertMsg.length == l_Msg){
		return true;
	}else{
		alert(alertMsg);
		return false;
	}
	return false;
}
// -->