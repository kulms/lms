<?php 
/**
 *	@package system
 *	@subpackage modules
*/

/**
 *	System Class
 */
require_once("DB.php");
 
class System {
	// int system id
	var $system_id = NULL;		
	// int system active
	var $system_active = NULL;
	// varchar system name
  	var $system_name = NULL;
	// varchar system url
	var $system_url = NULL;
	// varchar system url admin
	var $system_url_admin = NULL;
	// varchar system url setup
	var $system_url_setup = NULL;
	// varchar system info
	var $system_info = NULL;
	// varchar system picture
	var $system_picture = NULL;
	
	function System($id, $active, $name, $url, $url_admin, $url_setup, $info, $picture) 
	{
		$this->system_id = $id;
		$this->system_active = $active;
		$this->system_name = $name;
		$this->system_url = $url;
		$this->system_url_admin = $url_admin;
		$this->system_url_setup = $url_setup;
		$this->system_info = $info;
		$this->system_picture = $picture;
	}
	
	function getSystemId() {
		return $this->system_id;
	}
	
	function getSystemActive() {
		return $this->system_active;
	}
	
	function getSystemName() {
		return $this->system_name;
	}
	
	function getSystemUrl() {
		return $this->system_url;
	}
	
	function getSystemUrlAdmin() {
		return $this->system_url_admin;
	}
	
	function getSystemUrlSetup() {
		return $this->system_url_setup;
	}
	
	function getSystemInfo() {
		return $this->system_info;
	}
	
	function getSystemPicture() {
		return $this->system_picture;
	}
		
	function create($system) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
								 							  
	    $sql = "INSERT INTO modules_type
		 	   (active, name, 
			    url, url_admin, url_setup, 
				info, picture
			   )
			   VALUES
			   (".$system->getSystemActive().", '".$system->getSystemName()."', 
			   '".$system->getSystemUrl()."', '".$system->getSystemUrlAdmin()."', '".$system->getSystemUrlSetup()."', 
			   '".$system->getSystemInfo()."', '".$system->getSystemPicture()."
			   );";
			   				
		//echo $sql."<br>";			
				
	    $result = $db->query($sql);
	   
	    if( DB::isError($result) ) {
		   die ($result->getMessage());
		   return false;
	    }	   
	   
	    return true;	   			
	}
	
	function SelectAllSystem() {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
				
		$sql = "SELECT * FROM modules_type;";
		
		//echo $sql;
		$result = $db->query($sql);
	
		return $result;	
	}			
	
	function lookupSystem($id) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM modules_type WHERE id = ".$id.";";
		
		$result = $db->query($sql);

		$rs_system = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		$system = System::createSystemObject($rs_system);

		return $system;	
	}		
	
	function createSystemObject($row) {			
		$system_id 		  = $row["id"];
		$system_active 	  = $row["active"];
		$system_name 	  = $row["name"];
		$system_url       = $row["url"];
		$system_url_admin = $row["url_admin"];
		$system_url_setup = $row["url_setup"];
		$system_info      = $row["info"];
		$system_picture   = $row["picture"];
				
		$system = new System($system_id, $system_active, $system_name, $system_url, 
						     $system_url_admin, $system_url_setup, $system_info, $system_picture
						    );
		return $system;
	}
	
	function update($system) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$active = $system->getSystemActive();
		if ($active == '') { $active = 0;}
		
		$sql = "UPDATE modules_type SET 
			   active    = ".$active.", 	
			   name      = '".$system->getSystemName()."', 
			   url  	 = '".$system->getSystemUrl()."',
			   url_admin = '".$system->getSystemUrlAdmin()."', 
			   url_setup = '".$system->getSystemUrlSetup()."', 
			   info      = '".$system->getSystemInfo()."', 
			   picture   = '".$system->getSystemPicture()."'
			   WHERE id  = ".$system->getSystemId().";";
			   
	   //echo $sql."<br>"; 
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;			
	}
		
	function del($system) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "DELETE FROM modules_type WHERE id = ".$system->getSystemId().";";
		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}			
	
	/*
	
	function log_insert($id, $system) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "INSERT INTO dms_log
			   (log_system, log_doc_id, log_doc_type, log_action, log_time)
			   VALUES
			   (".$system.", ".$id.",'research', 'insert', ".time().");";
		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	
	function log_del($id,$owner) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "INSERT INTO dms_log
	   		   (log_system, log_doc_id, log_doc_type, log_action, log_time)
	   		   VALUES
	   		   (".$owner.", ".$id.",'research', 'del', ".time().");";

		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	
	function log_update($research) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "INSERT INTO dms_log
	   		   (log_system, log_doc_id, log_doc_type, log_action, log_time)
	   		   VALUES
	   		   (".$research->getResearchOwner().", ".$research->getResearchId().",'research', 'update', ".time().");";

		
		//echo $sql."<br>";
				
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   }	   
	   return true;
			
	}
	*/	
}


/*******
  Theme Class

*/



class ThemeStyle {
	
	// varchar theme name
	var $theme_name = NULL;		
    var  $logo_img = NULL;
    var  $imgpath = NULL;

function ThemeStyle($name,$logoimg,$realpath) 
	{
		
		if ($name== "")  {
			
		$name= "red";

		 }
		
		$this->theme_name = $name;
		$this->logo_img = $logoimg;
	    $this->imgpath = $realpath;
	}


   function getThemeName() {
		
		
		return $this->theme_name;
	}

	 function getThemeLogo() {
		
		
		return $this->logo_img;
	}
	
	
	function update($ThemeStyle) {		
		// Get Connection
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
	

 
 if($ThemeStyle->getThemeLogo() !="" && $ThemeStyle->getThemeLogo() !="none")
		
		{
			
			if((strtolower($_FILES['image']['type'])== "image/png"  || strtolower($_FILES['image']['type'])=="image/x-png") || (strtolower($_FILES['image']['type'])=="image/pjpeg") || (strtolower($_FILES['image']['type'])=="image/jpeg") || 
			(strtolower($_FILES['image']['type'])=="image/gif"))
			  {

	$uploaddir= $this->imgpath."/themes/".$ThemeStyle->getThemeName()."/images/";
	
	
	$pos = strpos($_FILES['image']['name'], '.');	
	$file_type = substr($_FILES['image']['name'],$pos);
	$new_name = "header".$file_type;
	

		
		if(!copy($_FILES['image']['tmp_name'], $uploaddir.$new_name)) {
		   
	        echo "Unable create file";
			exit();
			}  
			  
			  
			  
			  }else{

                echo "wrong type image";
				exit();


			  }
	
	
		
		}
	
	
	
	
	
	$sql = "UPDATE maxlearn_config SET  default_theme  = '".$ThemeStyle->getThemeName()."'";
	
	if($ThemeStyle->getThemeLogo() !="" && $ThemeStyle->getThemeLogo() !="none") {
        
		$sql.= " ,site_logo = '".$new_name."'";
			
	  }
	   
	   $result = $db->query($sql);
	   
	   if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
	   
	   }	   
	   return true;			
	
	} // End Update


function lookupTheme() {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$sql = "SELECT * FROM maxlearn_config;";
		
		$result = $db->query($sql);

		 
		$rs_theme = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
		
		
		
		$ThemeStyle = ThemeStyle::createThemeObject($rs_theme);
	

		return $ThemeStyle;
	
	}		


	
function createThemeObject($row) {			
		
		$theme_name  = $row["default_theme"];
		$theme_logo    = $row["site_logo"];
				
		$ThemeStyle = new ThemeStyle($theme_name,$theme_logo);
		
		return $ThemeStyle;
	}




} // End Class
?>