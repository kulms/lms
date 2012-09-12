<?php require("../include/global_login.php"); 
				mysql_query("DELETE  FROM news_courses WHERE id=$id AND courses=$courses;");
				header("Location: activity.php?courses=$courses"); 		  
?>
<head>
<title>DELETE NEWS</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script language="javascript">alert( Completely  Delete )</script>
</head>
<body bgcolor="#ffffff">
</body>
</html>