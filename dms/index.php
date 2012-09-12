<?
	require("../include/global_login.php");
	require("../include/getsize.php");
	require_once ("./classes/User.php");
	require_once ("./classes/UserStorage.php");
	require_once( "./includes/main_functions.php" );
	
	
	$user = UserStorage::lookupById($person["login"]);
	session_start();
	session_register( 'user' ); 
	//$_SESSION['user'] = new User();
	//$user =& $_SESSION['user'];
	
	// clear out main url parameters
	$m = '';
	$u = '';
	$a = 'index';
	
	$m = $_GET['m'];
	$u = $_GET['u'];
	$a = $_GET['a'];
	
	if ($a == '')
	{
		$a = 'index';
	}
	
	@include_once( $user->getModuleClass( $realpath, $m ) );
	//echo $user->getModuleClass( $realpath, $m )."<BR>";
	
	switch ($user->getCategory()) {
	/*
    case 0:
        $uistyle = "admin";
        break;
    case 1:
        $uistyle = "admin";
        break;
	*/	
    case 2:
        $uistyle = "teacher";
		//$themes = $_SESSION['theme'];
        break;
	case 3:
        $uistyle = "student";
		//$themes = $_SESSION['theme'];
		break;
	default:
        $uistyle = "guest";
		//$themes = $_SESSION['theme'];
	}
	
	//echo $_REQUEST["dosql"];
	if (isset( $_REQUEST["dosql"]) ) {
		if ($_REQUEST["dosql"] == "do_search" ) {			
			require "./style/$uistyle/header.php";					
			require ("./modules/$m/" . $_REQUEST["dosql"] . ".php");
			require "./style/$uistyle/footer.php";
			exit;		
		}
		else
		{
			require ("./modules/$m/" . $_REQUEST["dosql"] . ".php");
		}
	}
	
	
	//echo $m."<br>".$a;
			
	require "./style/$uistyle/header.php";
	
	if ($m != '') {
		require "./modules/$m/" . ($u ? "$u/" : "") . "$a.php";		

	} else {
		require "./style/$uistyle/show.php";
	}	
	require "./style/$uistyle/footer.php";	
	
?>