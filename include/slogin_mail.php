<?
$db="maxlearn";
$path="course";
$realpath="/home/maxlearn/course";
$conn=mysql_pconnect('localhost','maxlearn','max');
mysql_select_db($db);

$check=mysql_query("SELECT * FROM users WHERE login='".$slogin."' AND STRCMP(password,'".$spassword."')=0 AND active=1;");
if(mysql_num_rows($check)==0){

header ("Location: ../login/login.html?fail=1");
        exit;
}else{
$person=mysql_fetch_array($check);
mysql_query("UPDATE users set lastlogin=".time()." WHERE id=".$person["id"].";");

//  connect to mail box
//include("../src/login.php");

require_once('../functions/strings.php');
require_once('../config/config.php');
require_once('../functions/i18n.php');
require_once('../functions/plugin.php');
require_once('../functions/constants.php');
require_once('../functions/prefs.php');
require_once('../functions/imap.php');

set_up_language($squirrelmail_language, TRUE);
if (!function_exists('sqm_baseuri')){
    require_once('../functions/display_messages.php');
}
$base_uri = sqm_baseuri();
$base_uri="/course/";
@session_destroy();

$cookie_params = session_get_cookie_params();
setcookie(session_name(), '', 0, $cookie_params['path'], 
          $cookie_params['domain']);
setcookie('username', '', 0, $base_uri);
//setcookie('key', '', 0, $base_uri);
session_start();

//header('Pragma: no-cache');
//do_hook('login_cookie');

//include("../src/redirect.php");

/*$login_username = $slogin;
$secretkey = $spassword;
*/
$login_username = "suthee";
$secretkey = "suthee";
//session_set_cookie_params (0, $base_uri);

session_unregister ('user_is_logged_in');
session_register ('base_uri');


if (! isset($squirrelmail_language) ||
    $squirrelmail_language == '' ) {
    $squirrelmail_language = $squirrelmail_default_language;
}
set_up_language($squirrelmail_language, true);
// Refresh the language cookie. 
setcookie('squirrelmail_language', $squirrelmail_language, time()+2592000, 
          $base_uri);

if (!isset($login_username)) {
    include_once( '../functions/display_messages.php' );
    logout_error( _("You must be logged in to access this page.") );    
    exit;
}

if (!session_is_registered('user_is_logged_in')) {
   // do_hook ('login_before');

    $onetimepad = OneTimePadCreate(strlen($secretkey));
    $key = OneTimePadEncrypt($secretkey, $onetimepad);
    session_register('onetimepad');

   //  Verify that username and password are correct. 
    if ($force_username_lowercase) {
        $login_username = strtolower($login_username);
    }

    $imapConnection = sqimap_login($login_username, $key, $imapServerAddress, $imapPort, 0);
    if (!$imapConnection) {
        $errTitle = _("There was an error contacting the mail server.");
        $errString = $errTitle . "<br>\n".
                     _("Contact your administrator for help.");
        include_once( '../functions/display_messages.php' );
        logout_error( _("You must be logged in to access this page.") );            
        exit;
    } else {
        $delimiter = sqimap_get_delimiter ($imapConnection);
    }
    session_register('delimiter');

    $username = $login_username;
    session_register ('username');
    setcookie('key', $key, 0, $base_uri);
	session_register ('key');
    sqimap_logout($imapConnection);

    //do_hook ('login_verified');

}

 //Set the login variables. 
$user_is_logged_in = true;
$just_logged_in = true;

 //And register with them with the session. 
session_register ('user_is_logged_in');
session_register ('just_logged_in');

session_register("slogin");
session_register("spassword");


Header("Location: ../index_mail.html");
}
?>
