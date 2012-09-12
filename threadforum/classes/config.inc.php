<? 
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $dir_slash="\\";			//for windows
} else {
    $dir_slash="/";			//for linux
}
//------- Set  Working Directory ------- 

define('C_LOC_DIR',getcwd().$dir_slash);     $temp=substr(C_LOC_DIR,0,strrpos(C_LOC_DIR,$dir_slash));
define('C_ROOT_DIR',substr( $temp,0,strrpos( $temp,$dir_slash)+1));  

//------- Set  Template Directory ------- 
$loccfg = array();
$loccfg['skin'] = 'template';
define( 'C_SKIN' ,						C_LOC_DIR.'template');

//------- Set  Color ------- 
//define('COLOR1','#FFE1E1');
//define('COLOR2','#FFF2F2');
define('COLOR1',"tdbackground");
define('COLOR2',"tdbackground1");

?>