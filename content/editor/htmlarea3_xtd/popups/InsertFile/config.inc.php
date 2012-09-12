<?
$raw = phpversion();
list($v_Upper,$v_Major,$v_Minor) = explode(".",$raw);

if (($v_Upper == 4 && $v_Major < 1) || $v_Upper < 4) {
	$_FILES = $HTTP_POST_FILES;
	$_ENV = $HTTP_ENV_VARS;
	$_GET = $HTTP_GET_VARS;
	$_POST = $HTTP_POST_VARS;
	$_COOKIE = $HTTP_COOKIE_VARS;
	$_SERVER = $HTTP_SERVER_VARS;
	$_SESSION = $HTTP_SESSION_VARS;
	$_FILES = $HTTP_POST_FILES;
}

if (!ini_get('register_globals')) {
	while(list($key,$value)=each($_FILES)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_ENV)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_GET)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_POST)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_COOKIE)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_SERVER)) $GLOBALS[$key]=$value;
	while(list($key,$value)=@each($_SESSION)) $GLOBALS[$key]=$value;
	foreach($_FILES as $key => $value){
		$GLOBALS[$key]=$_FILES[$key]['tmp_name'];
		foreach($value as $ext => $value2){
			$key2 = $key."_".$ext;
			$GLOBALS[$key2]=$value2;
		}
	}
}

require_once("../../../../config.inc.php");

$MY_DOCUMENT_ROOT 		= $config['homepath'].'/'.$datadir;	// if you are using Docman change this to '/dmdocuments';
$MY_BASE_URL 			= $config['homeurl'].'/'.$datadir;	// if you are using Docman change this to '/dmdocuments';

$MY_ALLOW_EXTENSIONS	= array('html', 'doc', 'xls', 'txt', 'gif', 'pdf', 'gz', 'tar', 'zip', 'rar', 'bzip', 'sql', 'swf', 'mov', 'jpeg', 'jpg', 'png','asf'); //add file types here, e. g. 'gif', 'jpeg', 'jpg', 'png', 'pdf'
$MY_DENY_EXTENSIONS		= array('php', 'php3', 'php4', 'phtml', 'shtml', 'cgi', 'pl'); //add file types here
$MY_LIST_EXTENSIONS		= array('html', 'doc', 'xls', 'txt', 'pdf', 'gz', 'tar', 'zip', 'rar', 'sql', 'swf', 'mov', 'gif', 'jpeg', 'jpg', 'png');	//add file types here
$MY_ALLOW_DELETE_FILE 	= true;	// set to false if file deleting should be disabled
$MY_ALLOW_UPLOAD_FILE 	= true;	// set to false if file uploads should be disabled
$MY_ALLOW_DELETE_FOLDER = true;	// set to false if directory deleting should be disabled
$MY_ALLOW_CREATE_FOLDER = true;	// set to false if directory creation should be disabled
$MY_MAX_FILE_SIZE 		= 2*1024*1024;
$MY_LANG 				= 'en';	// change this to 'de'; for german language
$MY_DATETIME_FORMAT		= "d.m.Y H:i";	// set your date and time format

// DO NOT EDIT BELOW
$MY_NAME = 'insertfiledialog';
$lang_file = 'lang/lang-'.$MY_LANG.'.php';
if (is_file('lang/lang-'.$MY_LANG.'.php')) {
	require($lang_file);
} else {
	require('lang/lang-en.php');
}
$MY_PATH = '/';
$MY_UP_PATH = '/';