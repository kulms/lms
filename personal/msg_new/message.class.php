<? 
require_once("DB.php");

class Message{
	var $action = NULL;
	var $person_id=NULL;
	
	
		function Message($action,$person_id){
			$this->person_id = $person_id;
				if(isset($action)){
						$this->action = $action;
									
				}else{
						$this->action=0;
				}
		}
		function getAction(){
			return $this->action;
		}
		function getPersonID(){
			return $this->person_id ;
		}
		

function GetDetailPerson($message,$users)
	{
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			
					$sql = "SELECT  id,firstname,surname,email,category,admin 
							FROM users 
							WHERE id= '$users' ";
					$rs = mysql_query($sql);
							
					 while($arr=mysql_fetch_array($rs)){
							$id = $arr[id];
							$firstname= $arr[firstname];
							$surname= $arr[surname];
							$email= $arr[email];
							$category= $arr[category];
							$admin= $arr[admin];
									
					}
				return array($id,$firstname,$surname,$email,$category,$admin);
		}

	function SelectBox($message)
	{
		global $dsn;
		$person = $message->getPersonID();
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
					 
					 if($message->getAction()==4){ //especially new msg that not open
						$condition   =	"WHERE msg.msg_to_uid='$person'
										AND  msg.msg_from_uid= users.id 
										AND (msg.msg_type ='1'
										OR  msg.msg_type ='5')
										ORDER BY msg.msg_date DESC ";
					 }else if($message->getAction()==1){ //SENTBOX
						$condition   =	"WHERE msg.msg_from_uid='$person'
										AND  msg.msg_to_uid=users.id 
										AND msg.msg_type='0'
										ORDER BY msg.msg_date DESC ";
					}else if($message->getAction()==2){  //OUTBOX
						$condition   =	"WHERE msg.msg_from_uid='$person'
										AND  msg.msg_to_uid= users.id 
										AND (msg.msg_type ='1'
										OR  msg.msg_type ='5')
										ORDER BY msg.msg_date DESC ";
					}else if($message->getAction()==3){  //SAVEBOX
						$condition   =	"WHERE msg.msg_to_uid='$person'
										 AND msg.msg_from_uid= users.id 
										 AND msg.msg_type ='3'
										 ORDER BY msg.msg_date DESC ";
					}else{ //INBOX
					//*********Update Type when open Inbox  1-->5
					
							$sql = "SELECT msg_id
									FROM msg
									WHERE msg_to_uid='$person' 
									AND msg_type ='1' ";
							$rs = mysql_query($sql);
							 while($arr=mysql_fetch_array($rs)){
								$message->updateType('5',$arr[msg_id]);
							}
							$condition ="WHERE msg.msg_to_uid='$person'
										AND  msg.msg_from_uid= users.id 
										AND (msg.msg_type ='2'
										OR  msg.msg_type ='5')
										ORDER BY msg.msg_date DESC ";
					}
					return $condition;
		} // closeFunction

		function ListMsg($message,$cmd,$page){
				global $dsn;
				$db = DB::connect($dsn);
					if( DB::isError($db) ) {
					   die ($db->getMessage());
					}
		//page
		//echo "PAGE++++".$page."********";
		$pagesize=20;
		$maxRow = $page*$pagesize;
		if (isset($page)){
						$start = $pagesize*($page-1);
			}else{
						$page =1;
						$start=0;
			}		
			$numRow = "  LIMIT ".$start.", ".$pagesize;
			$sql="SELECT  * FROM  msg,users ".$cmd.$numRow;  
			$result = $db->query($sql);
			
		return $result;
	}
	
	function ShowPage($message,$cmd,$page)
	{
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		//page			
		$sql="SELECT  * FROM  msg,users ".$cmd;
		//echo $sql;
			$result = $db->query($sql);
			$num = $result->numRows();	
		$pagesize=20;
		$totalpage =(int)($num/$pagesize);
		if (($num % $pagesize) != 0)
				{
					$totalpage += 1;
				}

			if (isset($page)){
						$start = $pagesize*($page-1);
			}else{
						$page =1;
						$start=0;
			}	

	return array($page,$totalpage);
	}
	
	function  updateType($nType,$msg_id){
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
			   die ($db->getMessage());
		}
		$sql = "UPDATE msg
				SET msg_type='$nType'
				WHERE msg_id='$msg_id' ";
		$rs = $db->query($sql);
	}
	
	function GetNameUID($uid){
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
			   die ($db->getMessage());
		}
			$sql = "SELECT id,login   
					FROM users
					WHERE id ='$uid' ";
			$rs = mysql_query($sql);
			$arr= mysql_fetch_array($rs);
			return $arr[login];
	}
	
	function FormatDate($oldDate){
		$ndate = date("d/m/Y H:i",$oldDate);
		return $ndate;
	}
	
	
	function getActionName($message,$strPersonal_msg_Sentbox,$strPersonal_msg_Outbox,$strPersonal_msg_Savebox,$strPersonal_msg_inbox){
	
		if($message->getAction() ==1){
			$header = $strPersonal_msg_Sentbox;
		}else if($message->getAction() ==2){
			$header =$strPersonal_msg_Outbox;
		}else if($message->getAction() ==3){
			$header = $strPersonal_msg_Savebox;
		}else{
			$header = $strPersonal_msg_inbox;
		}
		return $header;
	
	}
	
	function GetDetailMsg($msg_id){
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
			   die ($db->getMessage());
		}
		$sql = "SELECT *
				FROM msg
				WHERE msg_id = '$msg_id'";  
		$rs = mysql_query($sql);
		$arr= mysql_fetch_array($rs);
			//echo $arr['msg_id'];
			$msg_id=$arr['msg_id'];
			$msg_type=$arr['msg_type']; 
			$msg_priority=$arr['msg_priority'];
			$msg_subject=$arr['msg_subject'];
			$msg_message=$arr['msg_message'];
			$msg_from_uid=$arr['msg_from_uid'];
			$msg_to_uid=$arr['msg_to_uid'];
			$msg_date=$arr['msg_date'];
			$msg_enable=$arr['msg_enable'];
			
		return array($msg_id,$msg_type,$msg_priority,$msg_subject,$msg_message,$msg_from_uid,$msg_to_uid,$msg_date,$msg_enable);

	}
	
	function createNewMsg($message,$msg_id){
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
			 die ($db->getMessage());
		}
		@list($msg_id,$msg_type,$msg_priority,$msg_subject,$msg_message,$msg_from_uid,$msg_to_uid,$msg_date,$msg_enable)= $message->GetDetailMsg($msg_id);

		if($message->getAction()==0){
				if($msg_type != 2){                                  
						$sql= "INSERT INTO msg(msg_type,msg_priority,msg_subject,msg_message,msg_from_uid,msg_to_uid,msg_date,msg_enable)
								VALUES('2','$msg_priority','$msg_subject','$msg_message','$msg_from_uid','$msg_to_uid',".time()." ,'$msg_enable')";
						$rs = $db->query($sql);
						 $new_id =mysql_insert_id();
						 $message->updateType('0',$msg_id);  // when read Type==0
				}else{
					$new_id= $msg_id;
				}
		}else{ $new_id = $msg_id; }
		
		return $new_id;
		
	}
	
function getListUser($fname,$lname,$userCat,$cosid){
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
			 die ($db->getMessage());
		}
		$cmd ="";  

			if($fname !="") $cmd .= " and firstname LIKE '%$fname%' ";
			if($lname !="") $cmd .= " and surname  LIKE '%$lname%' ";
					
				if($cosid !='' and $cosid !=0){  // student of course
						$sql = "SELECT  u.id,u.login,u.firstname,u.surname
								FROM users u,wp w
								WHERE u.id = w.users 
								and w.courses = '$cosid' 
								and w.admin='0' 
								 ".$cmd."
								ORDER BY firstname ASC ";
				}else if($userCat ==0){
						$sql = "SELECT  id,login,firstname,surname
								FROM users
								WHERE 1 
								 ".$cmd."
								ORDER BY firstname ASC ";
				}else{
						$sql = "SELECT  id,login,firstname,surname
								FROM users
								WHERE category='$userCat' 
								 ".$cmd."
								ORDER BY firstname ASC ";
								
			   }
			$rs = mysql_query($sql);  //echo $sql;
			 while($arr= mysql_fetch_array($rs)){
			 	$id[] = $arr[id];
				$login[] = $arr[login];
				$firstname[] = $arr[firstname];
				$surname[] = $arr[surname];
			 }

		return array($id,$login,$firstname,$surname);
	}
	
	
	
	
	

	 
function getCourseOfUser($user){
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
			 die ($db->getMessage());
		}
						$sql = "SELECT  id,name,fullname
								FROM courses 
								WHERE users='$user'
								ORDER BY name";
								
			
			$rs = mysql_query($sql);  //echo $sql;
			 while($arr= mysql_fetch_array($rs)){
			 	$id[] = $arr[id];
				$name[] = $arr[name];
				$fullname[] = $arr[fullname];
				
			 }

		return array($id,$name,$fullname);
	}

	 
	  

/*	function getListUser($keyWord,$userCat){
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
			 die ($db->getMessage());
		}

			if(!empty($keyWord)){    // search by  user Group  & keyword 
					if($userCat=='0'){   //all USER
						$sql = "SELECT  id,login,firstname,surname
								FROM users
								WHERE login LIKE '$keyWord%'
								ORDER BY 'login' ASC ";
					}else{
						$sql = "SELECT  id,login,firstname,surname
								FROM users
								WHERE category='$userCat' 
								AND login LIKE '$keyWord%'
								ORDER BY 'login' ASC ";
						}
			}else{  // search by  user Group 
					if($userCat =='0'){   //  all USER
						$sql = "SELECT  id,login,firstname,surname
								FROM users
								ORDER BY 'login' ASC ";
								
					 }else{
						$sql = "SELECT  id,login,firstname,surname
								FROM users
								WHERE category='$userCat' 
								ORDER BY 'login' ASC  ";
					}
			 }  
			$rs = mysql_query($sql);
			 while($arr= mysql_fetch_array($rs)){
			 	$id[] = $arr[id];
				$login[] = $arr[login];
				$firstname[] = $arr[firstname];
				$surname[] = $arr[surname];
			 }

		return array($id,$login,$firstname,$surname);
	}
	
	*/
	
	function getUIDbyLogin($login){
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
			 die ($db->getMessage());
		}

		$sql = "SELECT  id,login 
				FROM users
				WHERE login='$login'";
		$rs = mysql_query($sql);
		$arr=mysql_fetch_array($rs);
		return $arr[id];
	}
	
	function sentMsg($mPri,$mSbj,$mMsg,$from_id,$to_id){
			$MSG_TYPE=1;
			$ENABLE = 1;
			$DEFAULT_PRI=1;
			global $dsn;
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
				 die ($db->getMessage());
			}
				
				if(empty($mPri)){
					$mPri=$DEFAULT_PRI;
				}
				$sql = "INSERT INTO msg(msg_type,msg_priority,msg_subject,msg_message,msg_from_uid,msg_to_uid,msg_date,msg_enable)
						VALUES('$MSG_TYPE','$mPri','$mSbj','$mMsg','$from_id','$to_id',".time().",'$ENABLE')";
				$rs= mysql_query($sql); 
				//echo $sql;  
				 	if(!empty($rs)){
							 session_unregister("mSbj");
							 session_unregister("mPri");
							session_unregister("mMsg");
							
					}  
	}
	
	
	
	
}//End Class

class Template{
	var $classname = "Template";
	var $_tpldata = array();
	var $files = array();
	var $root = "";
	var $compiled_code = array();
	var $uncompiled_code = array();

	function Template($root = ".")
	{
		$this->set_rootdir($root);
	}

	function destroy()
	{
		$this->_tpldata = array();
	}

	function set_rootdir($dir)
	{
		if (!is_dir($dir))
		{
			return false;
		}

		$this->root = $dir;
		return true;
	}
		
	function set_filenames($filename_array)
	{
		if (!is_array($filename_array))
		{
			return false;
		}

		reset($filename_array);
		while(list($handle, $filename) = each($filename_array))
		{
			$this->files[$handle] = $this->make_filename($filename);
		}

		return true;
	}

	function pparse($handle)
	{
		if (!$this->loadfile($handle))
		{
			die("Template->pparse(): Couldn't load template file for handle $handle");
		}

		// actually compile the template now.
		if (!isset($this->compiled_code[$handle]) || empty($this->compiled_code[$handle]))
		{
			// Actually compile the code now.
			$this->compiled_code[$handle] = $this->compile($this->uncompiled_code[$handle]);
		}

		// Run the compiled code.
		eval($this->compiled_code[$handle]);
		return true;
	}

	function assign_var_from_handle($varname, $handle)
	{
		if (!$this->loadfile($handle))
		{
			die("Template->assign_var_from_handle(): Couldn't load template file for handle $handle");
		}
		$_str = "";
		$code = $this->compile($this->uncompiled_code[$handle], true, '_str');

		eval($code);
		$this->assign_var($varname, $_str);

		return true;
	}

	function assign_block_vars($blockname, $vararray)
	{
		if (strstr($blockname, '.'))
		{
			$blocks = explode('.', $blockname);
			$blockcount = sizeof($blocks) - 1;
			$str = '$this->_tpldata';
			for ($i = 0; $i < $blockcount; $i++)
			{
				$str .= '[\'' . $blocks[$i] . '.\']';
				eval('$lastiteration = sizeof(' . $str . ') - 1;');
				$str .= '[' . $lastiteration . ']';
			}
			$str .= '[\'' . $blocks[$blockcount] . '.\'][] = $vararray;';
			eval($str);
		}
		else
		{
			$this->_tpldata[$blockname . '.'][] = $vararray;

		}
		return true;
	}

	function assign_vars($vararray)
	{
		reset ($vararray);
		while (list($key, $val) = each($vararray))
		{
			$this->_tpldata['.'][0][$key] = $val;
		}

		return true;
	}

	function assign_var($varname, $varval)
	{
		$this->_tpldata['.'][0][$varname] = $varval;

		return true;
	}

	function make_filename($filename)
	{
		// Check if it's an absolute or relative path.
		if (substr($filename, 0, 1) != '/')
		{
//       		$filename = phpbb_realpath($this->root . '/' . $filename);
       		$filename = $this->root . '/' . $filename;
		}

		if (!file_exists($filename))
		{
			die("Template->make_filename(): Error - file $filename does not exist");
		}

		return $filename;
	}

	function loadfile($handle)
	{
		// If the file for this handle is already loaded and compiled, do nothing.
		if (isset($this->uncompiled_code[$handle]) && !empty($this->uncompiled_code[$handle]))
		{
			return true;
		}

		// If we don't have a file assigned to this handle, die.
		if (!isset($this->files[$handle]))
		{
			die("Template->loadfile(): No file specified for handle $handle");
		}

		$filename = $this->files[$handle];

		$str = implode("", @file($filename));
		if (empty($str))
		{
			die("Template->loadfile(): File $filename for handle $handle is empty");
		}

		$this->uncompiled_code[$handle] = $str;

		return true;
	}

	function compile($code, $do_not_echo = false, $retvar = '')
	{
		// replace \ with \\ and then ' with \'.
		$code = str_replace('\\', '\\\\', $code);
		$code = str_replace('\'', '\\\'', $code);

		// change template varrefs into PHP varrefs

		// This one will handle varrefs WITH namespaces
		$varrefs = array();
		preg_match_all('#\{(([a-z0-9\-_]+?\.)+?)([a-z0-9\-_]+?)\}#is', $code, $varrefs);
		$varcount = sizeof($varrefs[1]);
		for ($i = 0; $i < $varcount; $i++)
		{
			$namespace = $varrefs[1][$i];
			$varname = $varrefs[3][$i];
			$new = $this->generate_block_varref($namespace, $varname);

			$code = str_replace($varrefs[0][$i], $new, $code);
		}

		// This will handle the remaining root-level varrefs
		$code = preg_replace('#\{([a-z0-9\-_]*?)\}#is', '\' . ( ( isset($this->_tpldata[\'.\'][0][\'\1\']) ) ? $this->_tpldata[\'.\'][0][\'\1\'] : \'\' ) . \'', $code);

		// Break it up into lines.
		$code_lines = explode("\n", $code);

		$block_nesting_level = 0;
		$block_names = array();
		$block_names[0] = ".";

		// Second: prepend echo ', append ' . "\n"; to each line.
		$line_count = sizeof($code_lines);
		for ($i = 0; $i < $line_count; $i++)
		{
			$code_lines[$i] = chop($code_lines[$i]);
			if (preg_match('#<!-- BEGIN (.*?) -->#', $code_lines[$i], $m))
			{
				$n[0] = $m[0];
				$n[1] = $m[1];

				// Added: dougk_ff7-Keeps templates from bombing if begin is on the same line as end.. I think. :)
				if ( preg_match('#<!-- END (.*?) -->#', $code_lines[$i], $n) )
				{
					$block_nesting_level++;
					$block_names[$block_nesting_level] = $m[1];
					if ($block_nesting_level < 2)
					{
						// Block is not nested.
						$code_lines[$i] = '$_' . $n[1] . '_count = ( isset($this->_tpldata[\'' . $n[1] . '.\']) ) ?  sizeof($this->_tpldata[\'' . $n[1] . '.\']) : 0;';
						$code_lines[$i] .= "\n" . 'for ($_' . $n[1] . '_i = 0; $_' . $n[1] . '_i < $_' . $n[1] . '_count; $_' . $n[1] . '_i++)';
						$code_lines[$i] .= "\n" . '{';
					}
					else
					{
						// This block is nested.

						// Generate a namespace string for this block.
						$namespace = implode('.', $block_names);
						// strip leading period from root level..
						$namespace = substr($namespace, 2);
						// Get a reference to the data array for this block that depends on the
						// current indices of all parent blocks.
						$varref = $this->generate_block_data_ref($namespace, false);
						// Create the for loop code to iterate over this block.
						$code_lines[$i] = '$_' . $n[1] . '_count = ( isset(' . $varref . ') ) ? sizeof(' . $varref . ') : 0;';
						$code_lines[$i] .= "\n" . 'for ($_' . $n[1] . '_i = 0; $_' . $n[1] . '_i < $_' . $n[1] . '_count; $_' . $n[1] . '_i++)';
						$code_lines[$i] .= "\n" . '{';
					}

					// We have the end of a block.
					unset($block_names[$block_nesting_level]);
					$block_nesting_level--;
					$code_lines[$i] .= '} // END ' . $n[1];
					$m[0] = $n[0];
					$m[1] = $n[1];
				}
				else
				{
					// We have the start of a block.
					$block_nesting_level++;
					$block_names[$block_nesting_level] = $m[1];
					if ($block_nesting_level < 2)
					{
						// Block is not nested.
						$code_lines[$i] = '$_' . $m[1] . '_count = ( isset($this->_tpldata[\'' . $m[1] . '.\']) ) ? sizeof($this->_tpldata[\'' . $m[1] . '.\']) : 0;';
						$code_lines[$i] .= "\n" . 'for ($_' . $m[1] . '_i = 0; $_' . $m[1] . '_i < $_' . $m[1] . '_count; $_' . $m[1] . '_i++)';
						$code_lines[$i] .= "\n" . '{';
					}
					else
					{
						// This block is nested.

						// Generate a namespace string for this block.
						$namespace = implode('.', $block_names);
						// strip leading period from root level..
						$namespace = substr($namespace, 2);
						// Get a reference to the data array for this block that depends on the
						// current indices of all parent blocks.
						$varref = $this->generate_block_data_ref($namespace, false);
						// Create the for loop code to iterate over this block.
						$code_lines[$i] = '$_' . $m[1] . '_count = ( isset(' . $varref . ') ) ? sizeof(' . $varref . ') : 0;';
						$code_lines[$i] .= "\n" . 'for ($_' . $m[1] . '_i = 0; $_' . $m[1] . '_i < $_' . $m[1] . '_count; $_' . $m[1] . '_i++)';
						$code_lines[$i] .= "\n" . '{';
					}
				}
			}
			else if (preg_match('#<!-- END (.*?) -->#', $code_lines[$i], $m))
			{
				// We have the end of a block.
				unset($block_names[$block_nesting_level]);
				$block_nesting_level--;
				$code_lines[$i] = '} // END ' . $m[1];
			}
			else
			{
				// We have an ordinary line of code.
				if (!$do_not_echo)
				{
					$code_lines[$i] = 'echo \'' . $code_lines[$i] . '\' . "\\n";';
				}
				else
				{
					$code_lines[$i] = '$' . $retvar . '.= \'' . $code_lines[$i] . '\' . "\\n";'; 
				}
			}
		}

		// Bring it back into a single string of lines of code.
		$code = implode("\n", $code_lines);
		return $code	;

	}


	/**
	 * Generates a reference to the given variable inside the given (possibly nested)
	 * block namespace. This is a string of the form:
	 * ' . $this->_tpldata['parent'][$_parent_i]['$child1'][$_child1_i]['$child2'][$_child2_i]...['varname'] . '
	 * It's ready to be inserted into an "echo" line in one of the templates.
	 * NOTE: expects a trailing "." on the namespace.
	 */
	function generate_block_varref($namespace, $varname)
	{
		// Strip the trailing period.
		$namespace = substr($namespace, 0, strlen($namespace) - 1);

		// Get a reference to the data block for this namespace.
		$varref = $this->generate_block_data_ref($namespace, true);
		// Prepend the necessary code to stick this in an echo line.

		// Append the variable reference.
		$varref .= '[\'' . $varname . '\']';

		$varref = '\' . ( ( isset(' . $varref . ') ) ? ' . $varref . ' : \'\' ) . \'';

		return $varref;

	}


	/**
	 * Generates a reference to the array of data values for the given
	 * (possibly nested) block namespace. This is a string of the form:
	 * $this->_tpldata['parent'][$_parent_i]['$child1'][$_child1_i]['$child2'][$_child2_i]...['$childN']
	 *
	 * If $include_last_iterator is true, then [$_childN_i] will be appended to the form shown above.
	 * NOTE: does not expect a trailing "." on the blockname.
	 */
	function generate_block_data_ref($blockname, $include_last_iterator)
	{
		// Get an array of the blocks involved.
		$blocks = explode(".", $blockname);
		$blockcount = sizeof($blocks) - 1;
		$varref = '$this->_tpldata';
		// Build up the string with everything but the last child.
		for ($i = 0; $i < $blockcount; $i++)
		{
			$varref .= '[\'' . $blocks[$i] . '.\'][$_' . $blocks[$i] . '_i]';
		}
		// Add the block reference for the last child.
		$varref .= '[\'' . $blocks[$blockcount] . '.\']';
		// Add the iterator for the last child if requried.
		if ($include_last_iterator)
		{
			$varref .= '[$_' . $blocks[$blockcount] . '_i]';
		}

		return $varref;
	}

	function redirect($url)
	{
	$redirect_url=$server_protocol . $server_name . $server_port . $script_name . $url;
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="Cache-control" content="no-store" /><meta http-equiv="Pragma" content="no-cache" /><meta http-equiv="Expires" content="0" /><meta http-equiv="Pray" content="true" /><meta http-equiv="refresh" content="0; url=' . $server_protocol . $server_name . $server_port . $script_name . $url . '"><title>Redirect</title></head><body bgcolor="#ff9900"></body></html>';
		exit;
 	}

}
?>