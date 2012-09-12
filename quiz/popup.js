function __dlg_onclose() {
	if (!document.all) {
		opener.Dialog._return(null);
	} else {
		opener.Dialog._return(null);
	}
};

function __dlg_init() {
	if (!document.all) {
		// init dialogArguments, as IE gets it
		window.dialogArguments = opener.Dialog._arguments;
		
		window.resizeTo(window.document.documentElement.offsetWidth, window.document.documentElement.offsetHeight);
		window.sizeToContent();
		window.sizeToContent();	// for reasons beyond understanding,
					// only if we call it twice we get the
					// correct size.
		window.addEventListener("unload", __dlg_onclose, true);
		// center on parent
		var px1 = opener.screenX;
		var px2 = opener.screenX + opener.outerWidth;
		var py1 = opener.screenY;
		var py2 = opener.screenY + opener.outerHeight;
		var x = (px2 - px1 - window.outerWidth) / 2;
		var y = (py2 - py1 - window.outerHeight) / 2;
		window.moveTo(x, y);
		//var body = document.body;
		//window.innerHeight = body.offsetHeight;
		//window.innerWidth = body.offsetWidth;

	} else {
		
		var parentWidth = 0, parentHeight = 0;
		var myWidth = window.document.all.tags("body")[0].scrollWidth+10;
		var myHeight = window.document.all.tags("body")[0].scrollHeight+10;

		window.resizeTo( myHeight, myWidth );

		if( opener.document.documentElement &&
			( opener.document.documentElement.clientWidth || opener.document.documentElement.clientHeight ) ) {
			//IE 6+ in 'standards compliant mode'
			parentWidth = opener.document.documentElement.clientWidth;
			parentHeight = opener.document.documentElement.clientHeight;
		} else if( opener.document.body && ( opener.document.body.clientWidth || opener.document.body.clientHeight ) ) {
			//IE 4 compatible
			parentWidth = opener.document.body.clientWidth;
			parentHeight = opener.document.body.clientHeight;
		}
		
	 		
		var px1 = opener.screenLeft;
		var px2 = opener.screenLeft + parentWidth;
		var py1 = opener.screenTop;
		var py2 = opener.screenTop + parentHeight;
		var x = (px2 - px1 - myHeight) / 2;
		var y = (py2 - py1 - myWidth) / 2;
		window.moveTo(x, y);
		
		window.onunload = __dlg_onclose;
	}
};

// closes the dialog and passes the return info upper.
function __dlg_close(val) {
	if (document.all) {	// IE
		window.returnValue = val;
		opener.Dialog._return(val);
	} else {
		opener.Dialog._return(val);
	}
	window.close();
};
