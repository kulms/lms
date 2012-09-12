<?  session_start();
session_unregister("module_id");

//echo $url;
//echo "MID==".$m_id;

$_SESSION["module_id"]= $m_id;
session_register("module_id");

header("Location: $url");
?>