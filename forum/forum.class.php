<?

require_once("DB.php");


class Forum {
   
   var $forum_id = NULL;                         
   var  $forum_users = NULL;                    
   var $forum_modules = NULL;              
   var $forum_course = NULL;					
   var  $forum_info = NULL;		
	
	//class constructor
	
	function Forum($id,$users,$modules,$course,$info)
	{
		$this->forum_id = $id;
		$this->forum_users = $users;
	    $this->forum_modules= $modules;
	    $this->forum_course= $course;
	    $this->forum_info = $info;
	
	
	}


       function select_modulename() {
		
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
		$names="SELECT u.firstname,u.surname, m.name, m.info FROM users u, modules m WHERE u.id=".$this->forum_users." AND m.id=".$this->forum_modules."";
	
	     $result = $db->query($names);
	
	       if ($result->numRows() ==0) {
    
				 return false;
		   
		   }else {
		  
		  while ($rs = @$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$record[]  = $rs;
			
			
			    	}
		
		     return $record;
		 
		   }
	
	}		

         	  
		 function select_useronline($strForum_Labuserlist) {
		  
		 global $dsn;
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		  
		  $result = $db->query("select distinct u.id as uid,u.firstname,u.surname,u.category,u.login,fo.status,fo.users from users u,forum_online fo where u.id = fo.users and fo.modules = ".$this->forum_modules." and fo.status=1  order by u.login");

		  $num = $result->numRows();	
		  
		  echo  "<tr class=\"boxcolor\">";
          echo "<td colspan=\"2\" class=\"Bcolor\">".$strForum_Labuserlist ." (". $num .") </td>";
          echo "</tr>";
		  
		  while ($rs = @$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			
			 echo "<tr>";
			 
			 if ($rs["category"]==2) {
				
				echo "<td align=\"center\"><a  href=\"#\" onclick =\"newWindow('../personal/info.php?userid=".$rs["uid"]."',650,500,'yes','yes');\"><img src = \"images/teacher.gif\" border = 0 alt=\"instructor\"></a></td>";
			 
			 }else if ($rs["category"]==3) {
                  
				  echo "<td align=\"center\"><a  href=\"#\" onclick =\"newWindow('../personal/info.php?userid=".$rs["uid"]."',650,500,'yes','yes');\"><img src = \"images/student.gif\" border = 0 alt=\"student\"></a></td>";

			   }else {
                   
				   echo "<td align=\"center\"><img src = \"images/admin.gif\" border = 0 alt=\"admin\"></td>";

			   }
			
			 echo "<td><span title=\"".$rs["firstname"]."&nbsp;".$rs["surname"]."\" >". $rs["login"] ;if($rs["users"] == $this->forum_users) echo " (you)";  
			 echo "</span></td></tr>";
				
			
			    }
		 
		  
		 }
		  
		   function get_prefs() {
             
			  global $dsn;
			  $db = DB::connect($dsn);
				if( DB::isError($db) ) {
				   die ($db->getMessage());
				}
				   
		   
		   
		   
		   $prefs=$db->query("SELECT fp.id,fp.orders,fp.show_online,fp.time_delay,fp.begin_date,fp.end_date,fp.refresh from forum_prefs fp WHERE fp.users=".$this->forum_users." AND fp.modules=".$this->forum_modules.";");

           if ($prefs->numRows() ==0) {
    
				 return false;
		   
		   }else {
			
			while ($rs = @$prefs->fetchRow(DB_FETCHMODE_ASSOC)) {
					
					$record[]  = $rs;
			
			
					 }
		
		
				return $record;
            
			}

	 }
		  
		  
		       function Insert_forum_prefs($sort,$showonline,$timedelay,$begindate,$enddate,$refresh) {
				
				  global $dsn;
				  $db = DB::connect($dsn);
					if( DB::isError($db) ) {
					   die ($db->getMessage());
					}
				   
		            $db->query("INSERT INTO forum_prefs(users,modules,orders,show_online,time_delay,begin_date,end_date,refresh) VALUES(".$this->forum_users.",".$this->forum_modules.",$sort,$showonline,$timedelay,'$begindate','$enddate',$refresh);");

		   

			   }
		   
		   
		   function Update_forum_prefs($sort,$showonline,$timedelay,$begindate,$enddate,$refresh) {
				
				  global $dsn;
				  $db = DB::connect($dsn);
					if( DB::isError($db) ) {
					   die ($db->getMessage());
					}
				   
		            $db->query("UPDATE forum_prefs SET orders=".$sort." ,
		                       show_online = ".$showonline.",
		                       time_delay = ".$timedelay.",
						       begin_date = '.$begindate.',
							   end_date = '.$enddate.',
							   refresh = ".$refresh." 
							   WHERE id=$this->forum_id;");
		   

			   }




		   function show_forum($showonline,$sort,$begindate,$enddate) {

                global $dsn;
				$db = DB::connect($dsn);
				if( DB::isError($db) ) {
				   die ($db->getMessage());
				}
			  
			  
			  
			   if($begindate!="0000-00-00" && $begindate!="") {
			  
					$date_parts = explode("-",$begindate);
					$begindate = mktime(0,0,0,$date_parts[1],$date_parts[2],$date_parts[0]);
			   
			   }else {
				
				 $begindate= "-1";
				
				}
			
			
			  
			
			  if($enddate!="0000-00-00" && $enddate!="") {
					 
					 $date_parts = explode("-",$enddate);
					 $enddate = mktime(0,0,0,$date_parts[1],$date_parts[2]+1,$date_parts[0]);
			 
			  }else{
                
					$enddate= "-1";
 
			  }
			  
			 
			  
			  $sql = "select u.id,u.login,f.time,f.info,f.info_type from users u,forum f   WHERE f.modules=".$this->forum_modules."  AND u.id=f.users";

           
			  if($showonline==1) {$sql.= ""; }else {$sql.= " and f.info_type = 0"; }
			  
			  if($begindate!="-1" && $enddate!="-1") { 
				  
				  $sql.= " and f.time between '$begindate' and  '$enddate'";
				  
				  }

			  if($begindate!="-1" && $enddate == "-1") {

					 $sql.= " and f.time >='$begindate'";
				 
				 }
              
			  if($begindate=="-1" && $enddate != "-1") {

					 $sql.= " and f.time <= '$enddate'";
				 
				 }
			  
			    
			  
			  
			  if($sort==1) {$sql.=" ORDER BY f.id DESC";}else{$sql.=" ORDER BY f.id";}
 

               $result = $db->query($sql);


		    while ($rs = @$result->fetchRow(DB_FETCHMODE_ASSOC)) {

					if ($rs["info_type"]==0) {

					// User Message
					
					echo "<tr><td width=\"6%\">";
					echo  $rs["login"]. ": </td>";
					echo "<td width=\"94%\" align=\"left\">".stripslashes($rs["info"]);
					echo "\t\t<font color=\"#99999\">[ ".date("d-m-Y  H:i",$rs["time"])." ]</font></td>";
					   
					 echo " </tr>";
					  


						 }else {
                      
					// System Message
					
					echo "<tr><td width=\"6%\">";
					echo  "<b>system: </b></td>";
					echo "<td width=\"94%\" align=\"left\"><b>".$rs["login"]."\t\t".$rs["info"]."</b>";
					echo "\t\t<font color=\"#99999\">[ ".date("d-m-Y  H:i",$rs["time"])." ]</font></td>";
					echo " </tr>";
					  
							}


                     }
		  
		  
		  
		  
		  }
		  
		  
		  
		  
		  
		  function Insert_forum($forum) {
		  
		  	global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		
       
	      
	
		$data = $forum->Filter($this->forum_info);
		
	
		 $db->query("INSERT INTO forum (users,modules,info,time) VALUES(".$this->forum_users.",".$this->forum_modules.",'".$data."',".time().");");
		
		
		
		
		 $db->query("UPDATE modules set updated=".time().", updated_users=".$this->forum_users." WHERE id=".$this->forum_modules.";");

      

 

   }



         function Filter($msg) {

          
		   $msg = addslashes(htmlspecialchars($msg));
		   
		   $msg=str_replace("'","&#039;",str_replace("\n","<br>",$msg));
		
		//*** Check insert link and email
		
		  $msg = eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])","<a href=\"\\1://\\2\\3\" target=\"\\2\\3\">\\1://\\2\\3</a>",$msg);
	                   
		  $msg = eregi_replace("([[:alnum:]]+)@([^[:space:]]*)([[:alnum:]])","<a href=mailto:\\1@\\2\\3>\\1@\\2\\3</a>",$msg); 

	//*****
	
	$txt = array(":D", ":)",":(", ":s)", ":shock:", ":?", "8)", ":lol:", ":x", ":P", ":oops:", ":cry:", ":evil:", ":twisted:", ":roll:", ":wink:", ":!:", ":?:", ":idea:", ":arrow:", ":|", ":mrgreen:");
	$pic = array("icon_biggrin.gif","icon_smile.gif","icon_sad.gif","icon_surprised.gif","icon_eek.gif","icon_confused.gif","icon_cool.gif","icon_lol.gif","icon_mad.gif","icon_razz.gif","icon_redface.gif","icon_cry.gif","icon_evil.gif","icon_twisted.gif","icon_rolleyes.gif","icon_wink.gif","icon_exclaim.gif","icon_question.gif","icon_idea.gif","icon_arrow.gif","icon_neutral.gif","icon_mrgreen.gif");
		
		
		for ($i=0 ; $i<sizeof($txt) ; $i++) {
		$msg = str_replace($txt[$i],"<img src=\"images/smiles/$pic[$i]\" border=\"0\">",$msg);
	               }
		

          return $msg;
		 
		 }




}//End Class Forum

?>