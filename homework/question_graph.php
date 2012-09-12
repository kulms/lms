<?
	header("Content-Type: image/png");
	require("panachart.php");	
	require("../include/global_login.php");
	session_start();
	$session_id = session_id();
	//require ("../include/global_login.php");
	require("../include/online.php");
	require_once ("./classes/User.php");
	require_once ("./classes/UserStorage.php");
	require_once( "./includes/main_functions.php" );		
	$user = UserStorage::lookupById($person["login"]);	
	session_register( 'user' ); 
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
	
	$next=mysql_query("SELECT id,modules FROM homework WHERE modules=$modules ORDER BY id;");
	$hw_id=@mysql_result($next,$num,"id");
	
	
	$p=mysql_query("SELECT * FROM homework WHERE id=$hw_id ORDER BY id;");
	$points = @mysql_result($p,0,"points");		
	$name = @mysql_result($p,0,"name");
	
	$gen = 0;
	for($i=1;$i<=$points;$i++)
	{
		$vLabels[ ] = $i; 
	
		$hwans=mysql_query("SELECT count(ha.marks) as cnt_ans FROM homework_ans ha, users u 
													  WHERE ha.refid=$hw_id AND ha.modules=$modules AND ha.users = u.id 
													  AND ha.marks = $i;");  		
		if (mysql_num_rows($hwans) != 0) {
			$row = mysql_fetch_array($hwans);
			$vCht5[ ] = $row["cnt_ans"];
			$gen = 1;		
		} else {
			//echo "zz";
			$vCht5[ ] = 0;			
		}		
	}
	$display=mysql_query("SELECT marks FROM homework_ans WHERE refid=$hw_id AND marks !='' ");
	$num_dis=mysql_num_rows($display);
if($num_dis == 1) {
		$title = "Graph Bar Plot : X = scores,Y = nr of stds";		
		$ochart = new chart(650,250,5,'#eeeeee');
		$ochart->setTitle($title,"#000000",3);
		$ochart->setPlotArea(SOLID,"#aaaaaa", '#ffffff');
		$ochart->setFormat(1,',','.');
		$ochart->addSeries($vCht5,'bar','Series1', SOLID,'#444444', '#99CCCC');
		$ochart->setXAxis('#000000', SOLID, 2, "");
		$ochart->setYAxis('#000000', SOLID, 2, "");
		$ochart->setLabels($vLabels, '#000000', 2, HORIZONTAL);
		$ochart->setGrid("#cccccc", SOLID, "", DOTTED);
		$ochart->plot("");    
	}	else {
		echo "No data to Generate Graph !!!";
	}						

?>

