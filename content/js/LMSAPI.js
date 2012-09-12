	/*
		Answers LMS API adapter
		
		This code is open source under the GPL license.
		http://www.gnu.org/copyleft/gpl.html
		
		Results International 2002
	*/
	
	
	
	// ====================================================
	// API Class Constructor
	//
	function APIClass() {
		
		// Execution State
		this.LMSInitialize = LMSInitialize;
		this.LMSFinish = LMSFinish;
		
		// Data Transfer
		this.LMSGetValue = LMSGetValue;
		this.LMSSetValue = LMSSetValue;
		this.LMSCommit = LMSCommit;
		
		// State Management
		this.LMSGetLastError = LMSGetLastError;
		this.LMSGetErrorString = LMSGetErrorString;
		this.LMSGetDiagnostic = LMSGetDiagnostic;
		
		// Private
		this.APIError = APIError;
		
	}
	
	
	// ====================================================
	// Execution State
	//
	function LMSInitialize(arg) {
		if ( arg!="" ) {
			this.APIError("201");
			return "false";
		}
		this.APIError("0");
		APIInitialized = true;
		ans_function("init");
		
		if ( this.LMSGetValue("cmi.core.lesson_status") == "not_started" ) {
			this.LMSSetValue("cmi.core.lesson_status","started");
		}
		
		return "true";
	}
	
	function LMSFinish(arg) {
		if ( APIInitialized ) {
			if ( arg!="" ) {
				this.APIError("201");
				return "false";
			}
			this.APIError("0");
			this.LMSCommit("");
			setTimeout("ans_function('LMSFinish')",1000);
			return "true";
		} else {
			this.APIError("301");
			return "false";
		}
	}
	
	
	// ====================================================
	// Data Transfer
	//
	function LMSGetValue(ele) {
		if ( APIInitialized ) {
			var i = array_indexOf(elements,ele);
			if ( i!=-1 ) {
				this.APIError("0");
				return values[i];
			} else {
				APIError("401");
				return "false";
			}
		} else {
			this.APIError("301");
			return "false";
		}
	}
	
	function LMSSetValue(ele,val) {
		if ( APIInitialized ) {
			var i = array_indexOf(elements,ele);
			if ( i != -1 ) {
				values[i] = val;
				this.APIError("0");
				return "true";
			} else {
				this.APIError("401");
				return "false";
			}
		} else {
			this.APIError("301");
			return "false";
		}
	}
	
	function LMSCommit(arg) {
		if ( APIInitialized ) {
			if ( arg!="" ) {
				this.APIError("201");
				return "false";
			} else {
				this.APIError("0");
				for ( var i=0; i<elements.length; i++ ) {
					//document.comms.SetVariable("elements"+i,elements[i]);
					//document.comms.SetVariable("values"+i,values[i]);
				}
				ans_function("commit");
				return "true";
			}
		} else {
			this.APIError("301");
			return "false";
		}
	}
	
	
	// ====================================================
	// State Management
	//
	function LMSGetLastError() {
		if ( APIInitialized ) {
			return APILastError;
		} else {
			this.APIError("301");
			return "false";
		}
	}
	
	function LMSGetErrorString(num) {
		if ( APIInitialized ) {
			return errCodes[num];
		} else {
			this.APIError("301");
			return "false";
		}
	}
	
	function LMSGetDiagnostic(num) {
		if ( APIInitialized ) {
			if ( num=="" ) num = APILastError;
			return errDiagn[num];
		} else {
			this.APIError("301");
			return "false";
		}
	}
	
	
	// ====================================================
	// Private
	//
	function APIError(num) {
		APILastError = num;
	}
	
	
	
	// ====================================================
	// Error codes and Error diagnostics
	//
	var errCodes = new Array();
	errCodes["0"]   = "No Error";
	errCodes["101"] = "General Exception";
	errCodes["102"] = "Server is busy";
	errCodes["201"] = "Invalid Argument Error";
	errCodes["202"] = "Element cannot have children";
	errCodes["203"] = "Element not an array.  Cannot have count";
	errCodes["301"] = "Not initialized";
	errCodes["401"] = "Not implemented error";
	errCodes["402"] = "Invalid set value, element is a keyword";
	errCodes["403"] = "Element is read only";
	errCodes["404"] = "Element is write only";
	errCodes["405"] = "Incorrect Data Type";
	
	var errDiagn = new Array();
	errDiagn["0"]   = "No Error";
	errDiagn["101"] = "Possible Server error.  Contact System Administrator";
	errDiagn["102"] = "Server is busy and cannot handle the request.  Please try again";
	errDiagn["201"] = "The course made an incorrect function call.  Contact course vendor or system administrator";
	errDiagn["202"] = "The course made an incorrect data request. Contact course vendor or system administrator";
	errDiagn["203"] = "The course made an incorrect data request. Contact course vendor or system administrator";
	errDiagn["301"] = "The system has not been initialized correctly.  Please contact your system administrator";
	errDiagn["401"] = "The course made a request for data not supported by Answers.";
	errDiagn["402"] = "The course made a bad data saving request.  Contact course vendor or system adminsitrator";
	errDiagn["403"] = "The course tried to write to a read only value.  Contact course vendor";
	errDiagn["404"] = "The course tried to read a value that can only be written to.  Contact course vendor";
	errDiagn["405"] = "The course gave an incorrect Data type.  Contact course vendor";
	
	
	
	// ====================================================
	// CMI Elements and Values
	//
	var elements = new Array();
	elements[0]  = "cmi.core._children";
	elements[1]  = "cmi.core.student_id";
	elements[2]  = "cmi.core.student_name";
	elements[3]  = "cmi.core.lesson_location";
	elements[4]  = "cmi.core.credit";
	elements[5]  = "cmi.core.lesson_status";
	elements[6]  = "cmi.core.entry";
	elements[7]  = "cmi.core.score._children";
	elements[8]  = "cmi.core.score.raw";
	elements[9]  = "cmi.core.total_time";
	elements[10] = "cmi.core.exit";
	elements[11] = "cmi.core.session_time";
	elements[12] = "cmi.suspend_data";
	elements[13] = "cmi.launch_data";
	elements[14] = "cmi.comments";
	
	var values = new Array();
	values[0]  = "student_id,student_name,lesson_location,credit,lesson_status,entry,score,total_time,exit,session_time";
	values[1]  = "<?=$userID;?>";
	values[2]  = "<?=$row_usr["username"];?>";
	values[3]  = "<?=$row_enr["lesson_location"];?>";
	values[4]  = "<?=$row_crs["credit"];?>";
	values[5]  = "<?=$row_enr["lesson_status"];?>";
	values[6]  = "<?=$row_enr["entry"];?>";
	values[7]  = "raw";
	values[8]  = "<?=$row_enr["score"];?>";
	values[9]  = "<?=$row_enr["total_time"];?>";
	values[10] = "";
	values[11] = "00:00:00";
	values[12] = "<?=$row_enr["suspend_data"];?>";
	values[13] = "<?=$row_crs["launch_data"];?>";
	values[14] = "<?=$row_enr["comments"];?>";
	
	
	
	// ====================================================
	// CMI Equivalents (masks) in Database 
	//  2d array with table name and field name for each cmi element
	//  nun = not in db (eg: cmi.core._children)
	//  enr = in enrollments table   -   only one really used at the moment
	//  crs = in courses table
	//  usr = in user table
	//
	var elemasks = new Array();
	elemasks[0]  = ["nun", ""];
	elemasks[1]  = ["usr", "userID"];
	elemasks[2]  = ["usr", "username"];
	elemasks[3]  = ["enr", "lesson_location"];
	elemasks[4]  = ["crs", "credit"];
	elemasks[5]  = ["enr", "lesson_status"];
	elemasks[6]  = ["enr", "entry"];
	elemasks[7]  = ["nun", ""];
	elemasks[8]  = ["enr", "score_raw"];
	elemasks[9]  = ["enr", "total_time"];
	elemasks[10] = ["enr", "exit_data"];
	elemasks[11] = ["enr", "session_times"];
	elemasks[12] = ["enr", "suspend_data"];
	elemasks[13] = ["crs", "launch_data"];
	elemasks[14] = ["enr", "comments"];
	
	var tblmasks = new Array();
	tblmasks["enr"] = "<?=$dbprfx?>enrollments";
	tblmasks["usr"] = "<?=$dbprfx?>users";
	tblmasks["crs"] = "<?=$dbprfx?>courses";
	
	
	
	
	// ====================================================
	// Assistant functions
	//
	function ans_function(func) {
		/*
			create full GET-style url with all elements and values
			and send this to the applet
			
			
		*/
		var str = "action="+func+"&tablename=<?=$dbprfx?>enrollments&enrollID=<?=$enrollID?>";
		for ( var i=0; i<elemasks.length; i++ ) {
			if ( elemasks[i][0] == "enr" ) {
				str += "&db_" + elemasks[i][1] + "=" + escape( values[i] );
			}
		}
		
		var response = document.comms.doSomething(str);
		var tmp = new String(response);
		//alert(tmp);
	}
	
	function array_indexOf(arr,val) {
		for ( var i=0; i<arr.length; i++ ) {
			if ( arr[i] == val ) {
				return i;
			}
		}
		return -1;
	}
	
	
	
	// ====================================================
	// Final Setup
	//
	
	
	APIInitialized = false;
	APILastError = "301";
	API = new APIClass();

	