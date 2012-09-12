<?
	require("../include/global_login.php");
	require("../include/getsize.php");
	include('htmltool/config.php');
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
	$m1='';
	$a = 'index';
//	$r = '';
	
	$m = $_GET['m'];
	$m1 = $_GET['m1'];
	$u = $_GET['u'];
	$a = $_GET['a'];
//	$r = $_GET['r'];
	
	if ($a == '')
	{
		$a = 'index';
	}
	
	@include_once( $user->getModuleClass( $realpath, $m ) );
	$user->getModuleClass( $realpath, $m )."<BR>";
	
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
	
	
	//echo $m."<br>".$a.$r;
	if($a != view_error && $a !=print_report && $a !=chpwd )	{
		if($courses =="")
			require "./style/$uistyle/header.php";
		else
			require "./style/$uistyle/header_c.php";
	}

	if ($m != '') {
		if($m1 == 'eval'){
			require "./modules/$m/" . ($u ? "$u/" : "") . "$m1/$a.php";
		}else{
			require "./modules/$m/" . ($u ? "$u/" : "") . "$a.php";
		}
			
	} else {
		require "./style/$uistyle/show.php";
	}	
	require "./style/$uistyle/footer.php";	
	
?>