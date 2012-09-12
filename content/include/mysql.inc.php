<?
// Database conection
function db_connect() {
	global $config;
	if ($config['encoded']) {
		$dbuser=base64_decode($config['dbuser']);
		$dbpass=base64_decode($config['dbpass']);
	}
	else {
		$dbuser=$config['dbuser'];
		$dbpass=$config['dbpass'];
	}
	$dbpass=$config['dbpass'];
	$connection=mysql_connect($config['dbhost'],$dbuser,$dbpass) or die ("Cannot connect to database");
	return $connection;
}

// Disconnect database
function db_disconnect() {
	global $config;
	@mysql_close();
	return;
}

// Query
function db_query($query) {
	global $config;
	
	if ($config['encoded']) {
		$dbuser=base64_decode($config['dbuser']);
		$dbpass=base64_decode($config['dbpass']);
	}
	else {
		$dbuser=$config['dbuser'];
		$dbpass=$config['dbpass'];
	}
	$connection = mysql_connect($config['dbhost'],$dbuser,$dbpass) or die ("Cannot connect to database.");
	$db =  mysql_select_db($config['dbname'],$connection) or die ("Couldn't select database.");
//	$ret = mysql_query($query, $connection) or die ("Error in query: $query");
	$ret = mysql_query($query, $connection);

	return $ret;
}

// Query with one column condition
function db_getvar($table,$condition,$column)
{
	global $config;

	$result = db_query("SELECT $column FROM $table WHERE $condition LIMIT 0,1");
	if ($result)
	{
		$tvar="";
		while ($row = mysql_fetch_array($result))
			$tvar = $row[$column];
		return $tvar;	
	}
	else
		return FALSE;
}

// get Query array
function db_getarray($sql)
{
	global $config;
	$result = db_query($sql);
	$arr = mysql_fetch_array($result);
	return $arr;
}

// Database selection
function db_select($sql)
{
	global $config;
	$result = db_query($sql);
	return $result;
}

?>