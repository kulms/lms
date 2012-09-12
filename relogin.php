<?
	Header("WWW-Authenticate: Basic realm=\"Course\"");
	Header("HTTP/1.0 401 Unauthorized");
	echo "<center><h1>Invalid User or Password...\n</h1><br>";
	echo "<a href=\"index.html\">Back to Course on Web Home</a></center>";
?>
