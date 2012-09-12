
  function OBJ1st( name, value) 
  {	
	this.name = name
	this.value = value	
  }
  
  function OBJ2nd(parentid, name, value) 
  {	
	this.parentid = parentid
	this.name = name
	this.value = value	
  }

  function OBJ3rd(grandpa,parentid, name, value) 
  {	
	this.grandpa = grandpa
	this.parentid = parentid
	this.name = name
	this.value = value	
  }  
  
  function Add1stSelect(sel_1st)
  {
  	var newEl 
	for (i=0;i<obj1.length;i++ )
	{
			newEl = document.createElement("OPTION")	
			newEl.text = obj1[i].name
			newEl.value = obj1[i].value  
			sel_1st.options.add(newEl)

	}
  }
  
  function manage_2nd(sel_2nd,parent_id)
  {	
	// clear all	
	var newEl 
	var j = sel_2nd.options.length
	//var k = sel_3rd.options.length
	var i,start=0,end=0

	for(i=1;i<j;i++)		  
	  sel_2nd.options.remove(1)
	
	for(i=0;i<obj2.length-1;i++)
	{
		if(obj2[i].parentid==parent_id)
		{
		 if(start==0)
		  start=i
		 else
		  end=i
		}		 
	}
	
	if(start!=0)		
	{
		if(end==0)
		 end=start		
		for(i=start;i<=end;i++)		  
		{
			newEl = document.createElement("OPTION")	
			newEl.text = obj2[i].name
			newEl.value = obj2[i].value  
			sel_2nd.options.add(newEl)
		}
	}
  }
  
  function manage_3rd(sel_3rd,parent_id,grandpa_id)
  {	
	// clear all	
	var newEl 
	var j = sel_3rd.options.length
	var i,start=0,end=0

	for(i=1;i<j;i++)		  
	  sel_3rd.options.remove(1)	 
	
	for(i=0;i<obj3.length-1;i++)
	{
		if((obj3[i].parentid==parent_id) && (obj3[i].grandpa==grandpa_id))
		{
		 if(start==0)
		  start=i
		 else
		  end=i
		}		 
	}
	
	if(start!=0)		
	{
		if(end==0)
		 end=start		
		for(i=start;i<=end;i++)		  
		{
			newEl = document.createElement("OPTION")	
			newEl.text = obj3[i].name
			newEl.value = obj3[i].value  
			sel_3rd.options.add(newEl)
		}
	}
  }  
  
  