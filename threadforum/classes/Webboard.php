<? 
require_once("../config/maxlearn_includes.php");
class Webboard{
		function getModuleClass( $path=null, $name=null ) {
		if ($name) {			
			return "$path/threadforum/$name.class.php";			
		}
	}
}
?>