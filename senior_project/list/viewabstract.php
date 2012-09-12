<html>
<head>
<title>Student List</title>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-874">
</head>

<body bgcolor="#FFFFFF">
<font face="MS San Sarif">

<?
  $file = file("../upload/$abstract");
  for ($i=0;$i<count($file);$i++)
  {  print ("$file[$i]<br>");  }
?>

</font>
</body>
</html>