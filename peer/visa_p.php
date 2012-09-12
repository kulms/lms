<% 
set dConn = Server.CreateObject("ADODB.Connection")
  dConn.Open application("db")

id = Request("id")
req_pm = Request("pm")
if req_pm <> "" Then

	Select Case req_pm

		Case "1" 
			pm = Session("pm1")
			words = Session("words1")
			email = Session("email1")
			fnamn = Session("fnamn1")
			enamn = session("hnamn1")
			titel = Session("titel1")
			hnamn = Session("hnamn1")
			id = Session("ID1")
		
		Case "2"
			pm = Session("pm2")
			words = Session("words2")
			email = Session("email2")
			fnamn = Session("fnamn2")
			enamn = session("hnamn2")
			titel = Session("titel2")
			hnamn = Session("hnamn2")
			id = Session("ID2")
		
		Case Else 
			Response.redirect "main.asp"
	End Select
else
	if id <> "" Then
		 On Error Resume Next
		  Set oConn = Server.CreateObject("ADODB.Connection")
		  oConn.Open application("db")
		
		  SQLStmt = "SELECT * FROM peer WHERE id = " & id & ";"  
		
		  Set oRS = oConn.Execute(SQLStmt) 
		
		 If oConn.Errors.Count > 0 Then   'errors or warnings occurred.
		   	
			Response.Write "<P>Ooops..!</P>"
			Response.Write "<B>Database Error: " + Err.Description + "</B>"
				
		  Else
		   Do Until oRS.EOF
				pm = oRS("pm")
				words = oRS("words")
				set names = oConn.execute("SELECT firstname,surname,email FROM users WHERE id = " & oRS("users") & ";")
				hnamn = names("firstname")
				fnamn = names("surname")
				title = oRS("title")
				'id = oRS("id")
				
				CRLF = chr(13) & chr(10)
				brake = "<br>" & CRLF
				pm = replace(pm,CRLF,brake)
			oRS.MoveNext
			Loop
		  End If
		  oRs.Close
		  Set oRS = Nothing
				
			End If

end if	

If words = 0 Then
	str = pm
	start=1
	ant=0
	CRLF = chr(13) & chr(10)
	str = Replace(str,CRLF," ")
	if len(str)>0 then ant=1
	do while instr(start,str," ")>0
		start=instr(start,str," ")+1
		ant=ant+1
	loop
	words = ant
End If
		'plocka fram studentens fnamn o enamn ur dkurs-db
	set get_name = dConn.execute("SELECT firstname,surname,email FROM users WHERE id = " & oRS("users") & ";")
%>
<html>
<head>
</head>
<body bgcolor="white" topmargin="0">
<table cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td bgcolor="#DDE7F9"  class="info"><b>Author</b></td>
	<td bgcolor="#DDE7F9" class="info"><b>Title</b></td>
	<td bgcolor="#DDE7F9" class="info"><b>Word count</b></td>
</tr>
<tr>
	<td class="main"><%= namnet("fnamn") %> <% if get_name("surname") <> "" then %>&nbsp;<%= get_name("surname") %><% End If %></td>
	<td class="main"><b><i><%= title %></i></b></td>
	<td class="main" class="main"><%= words %> words</td>
</tr>
<tr>
	<td colspan="3" class="main"><p>&nbsp;<br></p><%= pm %></td>
</tr>

</table>
<a href="Javascript:history.go(-1)"><font class="main">Back</font></a>
</body>
</html>
