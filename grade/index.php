<?
	require("../include/global_login.php");
	//require("../include/getsize.php");
	require_once ("./classes/User.php");
	require_once ("./classes/UserStorage.php");
	require_once( "./includes/main_functions.php" );
	
	
	$user = UserStorage::lookupById($person["login"]);
	session_start();
	session_register( 'user' ); 
	//$_SESSION['user'] = new User();
	//$user =& $_SESSION['user'];
	if($courses != '' || $courses != 0){
		if($courses!=$g_courses){
		session_unregister('g_courses'); 
		}
	}
	
	if(!$g_courses){
		$g_courses = $courses;
		session_register('g_courses'); 
	}
	//echo $g_courses;
	
	// clear out main url parameters
	$m = '';
	$u = '';
	$a = 'index';
//	$r = '';
	
	$m = $_GET['m'];
	$u = $_GET['u'];
	$a = $_GET['a'];
//	$r = $_GET['r'];
	
	if ($a == '')
	{
		switch ($user->getCategory()) {
	
		case 0:
			$a = 'main';
			break;
		case 1:
			$a = 'main';
			break;
		case 2:
			$a = 'main';
			break;
		case 3:
			$a = 'select_level';
			break;
		default:
			$a = 'select_level';
		}
		
	}
	
	//@include_once( $user->getModuleClass( $realpath, $m ) );
	//$user->getModuleClass( $realpath, $m )."<BR>";
	
	switch ($user->getCategory()) {
	
    case 0:
        $uistyle = "admin";
        break;
    case 1:
        $uistyle = "admin";
        break;
    case 2:
        $uistyle = "teacher";
        break;
	case 3:
        $uistyle = "student";
		break;
	default:
        $uistyle = "guest";
	}
	
	//echo $_REQUEST["dosql"];
	if (isset( $_REQUEST["dosql"]) ) {
		if ($_REQUEST["dosql"] == "do_search" ) {			
			//require "./style/$uistyle/header.php";					
			//require ("./modules/$m/" . $_REQUEST["dosql"] . ".php");
			//require "./style/$uistyle/footer.php";
			exit;		
		}
		else
		{
			require ("./" . $_REQUEST["dosql"] . ".php");
		}
	}
	
	
	//echo $m."<br>".$a.$r;
	if($a != sel_module && $a !=create_group && $a !=show_group && $a !=prefs)	{
		
			require "./style/$uistyle/header.php";		
	}

	if ($a != 'index') {		
		require "./" . ($u ? "$u/" : "") . "$a.php";				
	} else {
		//require "./style/$uistyle/show.php";
	}	
	require "./style/$uistyle/footer.php";	
	
?>