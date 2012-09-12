<? 
require_once("../config/maxlearn_includes.php");
class Quiz{
		function getModuleClass( $path=null, $name=null ) {
		if ($name) {			
			return "$path/quiz/classes/$name.class.php";			
		}
	}
}
?>