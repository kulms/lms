
	 function enableall()
	 {		
					for(i=0; i<document.forms[0].elements.length; i++)
					{		 // check all checkboxes
							if(document.forms[0].elements[i].type=="checkbox")
							{
										document.forms[0].elements[i].checked = document.forms[0].checkALL.checked;
							}								
					}
					
	 }

	 
	 function validsubmit()
	 {
					for(i=0; i<document.forms[0].elements.length; i++)
					{
							if(document.forms[0].elements[i].type=="checkbox")
							{ 
									if(document.forms[0].elements[i].checked )
									{				
										if(document.forms[0].elements[i].name !='checkALL')
									    document.forms[0].mailto.value=document.forms[0].mailto.value+" "+document.forms[0].elements[i].value;
									}								
							}
					}
					
					if(document.forms[0].mailto.value==""){
							alert("กรุณาเลือกรายชื่อผู้เรียนที่ต้องการส่งเมลแจ้งเตือน");
					}else{
									//alert(document.forms[0].mailto.value);
										window.mailFrm.submit();
								}
	 }