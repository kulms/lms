<%
On Error Resume Next
  Set oConn = Server.CreateObject("ADODB.Connection")
  oConn.Open application("db")  
%>
<html>
<head>
	<title></title>
</head>

<body>

<table width="100%" cellspacing="1" cellpadding="2">

<%
granskare = request("granskare")
	set Namn = oConn.execute("SELECT * FROM deltagare WHERE ID = " & granskare & ";")  
  SQLStmt = "SELECT * FROM pm WHERE granskare = " & granskare & ";"  
  Set oRS = oConn.Execute(SQLStmt) 

 If oConn.Errors.Count > 0 Then   'errors or warnings occurred.
   	
	Response.Write "<P>FEL!</P>"
	Response.Write "<B>Database Error: " + Err.Description + "</B>"
		
  Else
  %>
<tr bgcolor="#A0B7EB">
	<td colspan="4" align="center"><b><font face="Arial">Kommentarer av <a href="mailto:<%= Namn("email") %>"><%= Namn("hnamn") %></a></font></b></td>
</tr>
<tr bgcolor="#A0B7EB">
	<td width="20%" valign="top"><b><font face="Arial">Författare</font></b></td>
	<td width="15%" valign="top"><b><font face="Arial">Titel</font></b></td>
	<td valign="top"><b><font face="Arial">Kommentar</font></b></td>
	<td valign="top" align="center"><b><font face="Arial">Antal ord <font size="-2">(kommentar)</font></font></b></td>
</tr>
<%
   	Do Until oRS.EOF
	flag = false
	granskad_stud = oRS("granskad_stud")
  	SQL2 = "SELECT * FROM deltagare WHERE ID = " & granskad_stud & ";"
  	Set vem = oConn.Execute(SQL2)

	
		kommentar = oRS("kommentar")
'************************************************
		'TA fram längden på PM:et
'************************************************
		str = kommentar
		start=1
		ant=0
		CRLF = chr(13) & chr(10)
		str = Replace(str,CRLF," ")
		if len(str)>0 then ant=1
		do while instr(start,str," ")>0
			start=instr(start,str," ")+1
			ant=ant+1
		loop
'*************************************************
		
		
		CRLF = chr(13) & chr(10) 
		kommentar = replace(kommentar,CRLF,"<br>")
		rad = rad + 1
		block = block + 1
		if block = 5 then
			spacer = "<tr><td colspan='4'><hr noshade></td></tr>"
			block = 0
		else
			spacer = ""
		end if
		if rad = 1 then
			bgcol = "#DDE7F9"
		else
			bgcol = "#b2b2d2"
			rad = 0
		end if
%>

<tr bgcolor="<%= bgcol %>">
	<td valign="top"><font face="Arial"><%= vem("hnamn") %></font></td>
	<td valign="top"><a href="visa.asp?ID=<%= vem("ID") %>"><font face="Arial" size="-1"><i><%= vem("titel") %></i></font></a></td>
	<td valign="top"><font face="Arial" size="-1"><%= kommentar %></font></td>
	<td valign="top" align="center"><font face="Arial" size="-1"><%= ant %></font></td>
</tr>
<%= spacer %>
<%

  vem.close
set vem = Nothing

	oRS.MoveNext
	Loop

  End If
  

  oRs.Close
  Set oRS = Nothing
%>
</table>
<div align="center"><b><a href="Javascript:history.go(-1)"><font face="Arial">Tillbaka</font></a></b></div>
</body>
</html>