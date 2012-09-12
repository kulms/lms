<? 
require_once("DB.php");

class Webboard {
   var $w_id = NULL;                         //id
   var $w_refid = NULL;                    //Refid
	var $w_subject = NULL;               //Subject
	var $w_icon = NULL;					//Icons
	var $w_contrib = NULL;				//Comtrib
	var $w_img = NULL;						//Img
	var $w_user = NULL;					//UserID
	var $w_modules = NULL;			//Modules  
	var $w_courses = NULL;			   //Courses 
	//var $vars= array_merge($GLOBALS['HTTP_GET_VARS'],$GLOBALS['HTTP_POST_VARS']);	

	function Webboard($id,$refid,$subject,$icon,$contrib,$img,$user,$modules,$courses) 
		{
			$this->w_id 	   = $id;
			$this->w_refid =$refid;
			$this->w_subject    = $subject;
			$this->w_icon     = $icon;
			$this->w_contrib  = $contrib;
			$this->w_img = $img;
			$this->w_user   = $user;
			$this->w_modules = $modules;
			$this->w_courses  = $courses;
		}
	function getWId(){
			return $this->w_id;
		}
	function getWRefid() {
			return $this->w_refid;
		}		
	function getWSubject() {
			return $this->w_subject;
		}
	function getWIcon() {
			return $this->w_icon;
		}
	function getWContrib() {
			return $this->w_contrib;
		}
	function getWImg() {
			return $this->w_img;
		}
	function getWUser() {
			return $this->w_user;
		}
	function getWModules() {
			return $this->w_modules;
		}
	function getWCourses() {
			return $this->w_courses;
		}
	
	function SelectReportAll($webboard,$topic,$search)
	{
		if($topic==1){
			if($search !="")
				$search=" AND subject LIKE '%$search%' ";
			else
				$search="";
			$sql="SELECT id  FROM threadforum WHERE refid = 0 AND deleted !=1 ".$search." ";
		}else
			$sql="SELECT id  FROM threadforum WHERE refid=".$webboard->getWId()." AND deleted !=1 ";
		return $sql;
	}
	
	//threadprefs and forum_prefs
	function SelectPrefs($webboard){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}

		$sql="SELECT tp.showcontrib,tp.sortdesc,tp.showdays,tp.showthread,fp.mail  FROM threadprefs tp,forum_prefs fp  WHERE tp.modules=".$webboard->getWModules()." AND tp.users=".$webboard->getWUser() ." AND fp.modules=tp.modules AND fp.users=tp.users ";
		$result = $db->getRow($sql);
		return $result;
	}
	
	function InsertPrefs($webboard){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
			
		$sql="INSERT INTO threadprefs (users,modules) VALUES (".$webboard->getWUser().",".$webboard->getWModules().") ";
		$result = $db->query($sql);

		$sql="INSERT INTO forum_prefs (users,modules) VALUES (".$webboard->getWUser().",".$webboard->getWModules().")  ";
		$result = $db->query($sql);
	}

	function UpdatePrefs($webboard,$showcontrib,$showthread,$showdays,$sortdesc,$mailstate){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		
		$sql="UPDATE threadprefs SET showcontrib=".$showcontrib.",showthread=".$showthread.", showdays=".$showdays.", sortdesc=".$sortdesc." WHERE users=".$webboard->getWUser()." and modules=".$webboard->getWModules()." ";
		$result = $db->query($sql);

		$sql="UPDATE forum_prefs SET mail=".$mailstate."  WHERE users=".$webboard->getWUser()." AND modules=".$webboard->getWModules()." ";
		$result = $db->query($sql);
	}

	function UpdateRead($webboard){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql="SELECT read_topic FROM threadforum WHERE id=".$webboard->getWId()." ";
		//echo $sql;
		$result = $db->query($sql);
		$rs = @$result->fetchRow(DB_FETCHMODE_ASSOC);
		$read=$rs['read_topic'];
		$i=$read+1;

		$sql="UPDATE threadforum SET read_topic=".$i." WHERE  id=".$webboard->getWId()." ";
		$result = $db->query($sql);
	}

	function ListTopic($webboard,$sql,$page,$search){
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}

		//page
		$pagesize=20;
		$maxRow = $page*$pagesize;
		if (isset($page)){
						$start = $pagesize * ($page -1);
			}else{
						$page =1;
						$start=0;
			}		
		$numRow = " LIMIT ".$start.", ".$pagesize;

			if(!settype($refid,"integer")){
				$refid=0;
			}
			$prefs=mysql_query("SELECT * from threadprefs WHERE modules=".$webboard->getWModules()." and users=".$webboard->getWUser().";"); //preferences for this forum
			if($row=mysql_fetch_array($prefs)){                        //if prefs
					$showthread=$row["showthread"];
					$sortdesc=$row["sortdesc"];
					$showdays=$row["showdays"];
			}else{
					$showthread=0;
					$sortdesc=0;
					$showdays=7;
			}

			settype($showdays,"integer");
			if($sortdesc==1){
					$sortdesc=" desc";
			}else{
					$sortdesc="";
			}
			if($showthread==1){
					$refid=0;
			}

			if($search =="")
				$search="";
			else
				$search=" AND tf.subject LIKE '%$search%' ";
		$sql="SELECT tf.*,u.firstname,u.login,u.surname,u.email FROM threadforum tf,users u WHERE tf.modules=".$webboard->getWModules()." and tf.users=u.id and tf.refid=".$webboard->getWRefid()." AND tf.last>".mktime(0,0,0,date("m")  ,date("d")-$showdays,date("Y"))." AND deleted !=1  ".$search." order by tf.id ".$sortdesc."  ".$numRow." ";
		$result = $db->query($sql);
		return $result;
		}

	function CountPost($id){
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		$sql="SELECT count(*) as refcount FROM threadforum WHERE refid=".$id." AND deleted !=1 ";
		$result = $db->query($sql);
		$rs=@$result->fetchRow(DB_FETCHMODE_ASSOC);
			if($result->numRows()==0)
				$replies=0;
			else
				$replies=$rs['refcount'];
		return $replies;
	}

	function InsertTopic($webboard,$reply){
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		if($reply !=1){
			$sql="INSERT INTO threadforum (refid,users,modules,subject,contrib,time,last,icon) VALUES 					(".$webboard->getWRefid().",".$webboard->getWUser().",".$webboard->getWModules().",'".$webboard->getWSubject()."','".$webboard->getWContrib()."',".time().",".time().",'".$webboard->getWIcon()."')";
		}else{
			$sql="INSERT INTO threadforum (refid,users,modules,contrib,time,last) VALUES 					(".$webboard->getWId().",".$webboard->getWUser().",".$webboard->getWModules().",'".$webboard->getWContrib()."',".time().",".time().")";
		}
		$result = $db->query($sql);
		$id = mysql_insert_id();

		if($webboard->getWRefid() !=0){
			$sql="UPDATE threadforum SET last=".time()."  WHERE id=".$webboard->getWRefid()."  ";
			$result = $db->query($sql);
		}
		//Upload Img
		
		 //Rename file and copy to dir files/
		if($webboard->getWImg() !="" && $webboard->getWImg()!="none"){
			  /*$pos = strpos($_FILES['filename']['name'], '.');
			  $file_type = substr($_FILES['filename']['name'],$pos);
			  $new_name = $id."_1".$file_type;
			  if($file_type=='.gif'){
				  if ($_FILES['filename']['error']) {
					  echo "<center><b>Error upload file.</b></center>";
					  exit;
				  }
				  if (!is_uploaded_file ($_FILES['filename']['tmp_name'])) {
					 echo "<center><b>File upload error.</b></center>";
					 exit;
				  }
				  if (!copy($_FILES['filename']['tmp_name'], "./images/upload/".$new_name)) {
					 echo "<center><b>failed to copy</b></center>";
					 exit;
				  }
			  }else{
				$webboard->Resize($webboard,$new_name);
			  }*/  //Version gd2
			  $pos = strpos($_FILES['filename']['name'], '.');
			  $file_type = substr($_FILES['filename']['name'],$pos);
			  $new_name = $id."_1".$file_type;
					  if ($_FILES['filename']['error']) {
						  echo "Error upload file.";
						  exit;
					  }
					  if (!is_uploaded_file ($_FILES['filename']['tmp_name'])) {
						 echo "File upload error.";
						 exit;
					  }
					  if (!copy($_FILES['filename']['tmp_name'], "./images/upload/".$new_name)) {
						 echo "failed to copy";
						 exit;
					  }
			  $sql="UPDATE threadforum SET img='".$new_name."' WHERE id=".$id." ";
			  $result = $db->query($sql);
		}
	}
	
	function UnlinkPic($webboard){
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		$sql="SELECT img FROM threadforum WHERE id=".$webboard->getWId()." ";
		 $result = $db->query($sql);
		 $rs = @$result->fetchRow(DB_FETCHMODE_ASSOC);

		$sql="UPDATE threadforum SET img='' WHERE id=".$webboard->getWId()." ";
		$result = $db->query($sql);
		 return $rs['img'];
	}

	function Resize($webboard,$new_name){
		$images = $webboard->getWImg();
		$height=200;
		$size=GetimageSize($images);
		$width=round($height*$size[0]/$size[1]);
		$images_orig = ImageCreateFromJPEG($images);
		$photoX = ImagesX($images_orig);
		$photoY = ImagesY($images_orig); 
		$images_fin = ImageCreateTrueColor($width, $height); 
		$a=ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY); 
		ImageJPEG($images_fin,"./images/upload/$new_name"); 
		ImageDestroy($images_orig);
		ImageDestroy($images_fin);
	}

	function imageResize($width, $height, $target) { 
	/*
	takes the larger size of the width and height and applies the  
	formula accordingly...this is so this script will work  
	dynamically with any size image 
	*/	
	if ($width > $height) { 
		$percentage = ($target / $width); 
	} else { 
		$percentage = ($target / $height); 
	} 

	//gets the new value and applies the percentage, then rounds the value 
	$width = round($width * $percentage); 
	$height = round($height * $percentage); 

	//returns the new sizes in html image tag format...this is so you 
	//can plug this function inside an image tag and just get the 
	return "width=\"$width\" height=\"$height\""; 
	} 

	function UpdateTopic($webboard)
	{
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		if($webboard->getWImg() !="" && $webboard->getWImg()!="none"){
				$sql="SELECT  img FROM threadforum WHERE id=".$webboard->getWId()." ";
				$result = $db->query($sql);
				$rs = @$result->fetchRow(DB_FETCHMODE_ASSOC);
				$pic=$rs['img'];
				if($pic==""){
					$ii=1;
				}else{
					$i=explode("_",$pic);
					$ii=$i[1]+1;
					unlink("./images/upload/$pic");
				}	

				/*  $pos = strpos($_FILES['filename']['name'], '.');
				  $file_type = substr($_FILES['filename']['name'],$pos);
				  $new_name = $webboard->getWId()."_".$ii.$file_type;
				 if($file_type=='.gif'){
					  if ($_FILES['filename']['error']) {
						  echo "<center><b>Error upload file.</b></center>";
						  exit;
					  }
					  if (!is_uploaded_file ($_FILES['filename']['tmp_name'])) {
						 echo "<center><b>File upload error.</b></center>";
						 exit;
					  }
					  if (!copy($_FILES['filename']['tmp_name'], "./images/upload/".$new_name)) {
						 echo "<center><b>failed to copy</b></center>";
						 exit;
					  }
			  }else{
				$webboard->Resize($webboard,$new_name);
			  }		*/  //Version gd2
			 $pos = strpos($_FILES['filename']['name'], '.');
			  $file_type = substr($_FILES['filename']['name'],$pos);
			  $new_name = $webboard->getWId()."_".$ii.$file_type;
					  if ($_FILES['filename']['error']) {
						  echo "Error upload file.";
						  exit;
					  }
					  if (!is_uploaded_file ($_FILES['filename']['tmp_name'])) {
						 echo "File upload error.";
						 exit;
					  }
					  if (!copy($_FILES['filename']['tmp_name'], "./images/upload/".$new_name)) {
						 echo "failed to copy";
						 exit;
					  }

		$sql="UPDATE threadforum SET img='".$new_name."' WHERE id=".$webboard->getWId()." ";
	   $result = $db->query($sql);
		}
		$sql="UPDATE threadforum SET subject ='".$webboard->getWSubject()."',contrib='".$webboard->getWContrib()."',last=".time().",icon='".$webboard->getWIcon()."' WHERE id=".$webboard->getWId()." ";
		$result = $db->query($sql);
	}
	
	function DeleteTopic($webboard,$reply){
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		if($reply==0){
			$sql="UPDATE threadforum SET deleted=1 WHERE id=".$webboard->getWId()." ";
		}else{
			$sql="UPDATE threadforum SET deleted=1 WHERE id=".$webboard->getWRefid()." ";
		}
		$result = $db->query($sql);
	}

	function ShowTopic($webboard)
	{
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}

		$sql="SELECT  tf.*,u.firstname,u.login,u.surname,u.email FROM threadforum tf,users u  WHERE tf.id=".$webboard->getWId()." AND tf.users=u.id ";
		$result = $db->getRow($sql);
		return $result;
	}
	
	function CheckAdmin($webboard)
	{
		global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$checkadmin="SELECT users FROM courses WHERE id=".$webboard->getWCourses().";";
		$result = $db->query($checkadmin);
		$rs = @$result->fetchRow(DB_FETCHMODE_ASSOC);
		$admin=$rs['users'];
		return $admin;
	}

	function ShowReply($webboard,$sql,$page)
	{
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}

		//page
		$pagesize=20;
		$maxRow = $page*$pagesize;
		if (isset($page)){
						$start = $pagesize * ($page -1);
			}else{
						$page =1;
						$start=0;
			}		
		$numRow = " LIMIT ".$start.", ".$pagesize;
		$sql="SELECT tf.*,u.firstname,u.login,u.surname,u.email FROM threadforum tf,users u WHERE tf.modules=".$webboard->getWModules()." and tf.users=u.id and tf.refid=".$webboard->getWId()." AND deleted !=1 order by tf.time DESC ".$numRow." ";
		$result= $db->query($sql);
		return $result;
	}

	function filter($data,$efcode)
	{
		$data = str_replace(">","&gt;",$data);
		$data = nl2br($data);
		
		if ($efcode) {
			$data = " ".$data;
			$data = preg_replace("#([\n ])([a-z]+?)://([^, \n\r]+)#i", "\\1<a href=\"\\2://\\3\" target=\"_blank\">\\2://\\3</a>", $data);
			$data = preg_replace("#([\n ])www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[^, \n\r]*)?)#i", "\\1<a href=\"http://www.\\2.\\3\\4\" target=\"_blank\">www.\\2.\\3\\4</a>", $data);
			$data = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([^, \n\r]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $data);

			/* Remove space */
			$data = substr($data, 1);
			$data = str_replace("\n","",$data);
			$data = str_replace("\r","",$data);
			
			$data = str_replace("::)","<IMG src='./images/icons/rolleyes.gif' border=0>",$data);
			$data = str_replace(":)","<IMG src='./images/icons/smiley.gif' border=0>",$data);
			$data = str_replace(";)","<IMG src='./images/icons/wink.gif' border=0>",$data);
			$data = str_replace(":D","<IMG src='./images/icons/cheesy.gif' border=0>",$data);
			$data = str_replace(";D","<IMG src='./images/icons/grin.gif' border=0>",$data);
			$data = str_replace("&gt;:(","<IMG src='./images/icons/angry.gif' border=0>",$data);
			$data = str_replace(":(","<IMG src='./images/icons/sad.gif' border=0>",$data);
			$data = str_replace(":o","<IMG src='./images/icons/shocked.gif'border=0>",$data);
			$data = str_replace("8)","<IMG src='./images/icons/cool.gif' border=0>",$data);
			$data = str_replace("???","<IMG src='./images/icons/huh.gif' border=0>",$data);
			$data = str_replace(":P","<IMG src='./images/icons/tongue.gif' border=0>",$data);
			$data = str_replace(":-[","<IMG src='./images/icons/embarassed.gif' border=0>",$data);
			$data = str_replace(":-X","<IMG src='./images/icons/lipsrsealed.gif' border=0>",$data);
			$data = str_replace(":-/","<IMG src='./images/icons/undecided.gif' border=0>",$data);
			$data = str_replace(":-*","<IMG src='./images/icons/kiss.gif' border=0>",$data);
			$data = str_replace(":*(","<IMG src='./images/icons/cry.gif' border=0>",$data);

	//		$data = preg_replace("/\[b\](.*?)\[\/b\]/si", "<B>\\1</B>", $data);
	//		$data = preg_replace("/\[i\](.*?)\[\/i\]/si", "<I>\\1</I>", $data);
	//		$data = preg_replace("/\[u\](.*?)\[\/u\]/si", "<U>\\1</U>", $data);
	//		$data = preg_replace("/\[url\](http:\/\/)?(.*?)\[\/url\]/si", "<A HREF=\"http://\\2\" TARGET=\"_blank\">\\2</A>", $data);
	//		$data = preg_replace("/\[url=(http:\/\/)?(.*?)\](.*?)\[\/url\]/si", "<A HREF=\"http://\\2\" TARGET=\"_blank\">\\3</A>", $data);
	//		$data = preg_replace("/\[email\](.*?)\[\/email\]/si", "<A HREF=\"mailto:\\1\">\\1</A>", $data);
//			$data = preg_replace("/\[img\](.*?)\[\/img\]/si", "<IMG SRC=\"\\1\">", $data);
	//		$data = preg_replace("/\[code\](.*?)\[\/code\]/si", "<p><blockquote><font face='ms sans serif'  size=1>code:</font><HR noshade size=1><pre>\\1<br></pre><HR noshade size=1></blockquote><p>", $data);	
		}

		// Bad word filter
		$repchar = '.';
		
		for($i=0;$i<sizeof($lang['badwords']);$i++){
			$rep = '';
			$ltrs = strlen($lang['badwords'][$i])-1;
			for ($n=0;$n<$ltrs;$n++){
				$rep .= $repchar;
			}
			$replacement = substr($lang['badwords'][$i],0,1).$rep;
			$data = eregi_replace($lang['badwords'][$i],$replacement,$data);
		}
		return $data;
	}

	
	function ShowSeqTable($webboard,$sql,$page,$topic)
	{
		global $dsn;
		$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		//page
			$result = $db->query($sql);
			$num = $result->numRows();	
		$pagesize=20;
		$totalpage =(int)($num/$pagesize);
		if (($num % $pagesize) != 0)
				{
						$totalpage += 1;
				}

			if (isset($page)){
						$start = $pagesize * ($page -1);
			}else{
						$page =1;
						$start=0;
			}	

			if($topic==1){
				$a="";
			}else{
				$a="a=show_topic&topicid=".$webboard->getWId()."&";
			}
	return array($a,$page,$totalpage);
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