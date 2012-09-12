<html>
<head>
<title>test  alert</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>

<body>
<script language='javascript'> 
			if( confirm("Do you really want to delete Department and its details !") )
			 	{   	document.write('show page! ');   // echo "show";   
				 }else{    document.form[0].reset( );//document.write(' hide page  ');	 // echo "hide"; 
				 			}
</script>	
<!--  <script>
			var x=window.confirm("Are you sure you are ok?")
			if (x)
			window.alert("Good!")
			else
			window.alert("Too bad")
		</script>  
// ####    #####   seperate code  #####   ####
<SCRIPT language="JavaScript"> 
			function go_there() 
			{ 		var where_to= confirm("Do you really want to go to this page?");
					 if (where_to== true)
					 { 
					 		  window.location="http://confirmedpage.com/";
					   } else { 
									  window.location="http://www.changedmind.com/";
								  }
			} 
</SCRIPT>
<A HREF="javascript:go_there()">New Page</A>
*/			 --> 
</body>
</html>