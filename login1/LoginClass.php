<?php
class CheckLogin{
	
	protected $ilogin, $ipassword, $user_id, $authen, $session_number;  
	//set as class variables to ilogin, ipassword because they are the same variable names in authen function from CPC stafe, hence less work 


// Set Username and password

	function setLogin($login)
	{
		$this->ilogin=$login;  
	}
	
	function setPassword($password)
	{
		$this->ipassword=$password;
	}
	
	function getAuthenResult()
	{
		return $this->authen;
	}
	
//Authen LDAP, this part was taken from CPC staff

	function ldap_authen($server,$base_dn,$useraccount,$password)
	{
		$ldapserver = ldap_connect($server);
        $bind = ldap_bind($ldapserver);
        $this->authen = "pass";
		if(!$bind)
		{
			$this->authen = "false";
		}
		$filter = "uid=" . $useraccount;
    	$inforequired = array("employeeType","department","thainame","mail","givenName",
                        "sn","uid","entrydn","gender","jobdescription","position","faculty","campus");
    	$result = ldap_search($ldapserver,$base_dn,$filter,$inforequired);
    	$info = ldap_get_entries($ldapserver,$result);
		if(!$result)
		{
			$this->authen = "false";
		}
		if($info["count"] == 0)
		{
			$this->authen = "false";
		}
		if($info["count"] > 1)
		{
			$this->authen = "false";
		}
		
		if (isset($info[0]["dn"])){
			$user_dn = $info[0]["dn"];
			$bind = @ldap_bind($ldapserver,$user_dn,$password);
    			if(!$bind)
				{
					$this->authen = "false";
				}
		}
		ldap_close($ldapserver);
	}

	
	function checkAuthen()
	{
	
		$authenou[0]="ou=bkn,dc=ku,dc=ac,dc=th";
		$authenou[1]="ou=kps,dc=ku,dc=ac,dc=th";
		$authenou[2]="ou=src,dc=ku,dc=ac,dc=th";
		$authenou[3]="ou=csc,dc=ku,dc=ac,dc=th";
		$authenzone[0]="ldap2.ku.ac.th";
		$authenzone[1]="ldap3.ku.ac.th";
//		$authenzone[2]="ldap3.ku.ac.th";
		$authenzone[2]="ldap.src.ku.ac.th";
		$i=0;
		$j=0;
		while($i<count($authenzone))
		{
			while($j<count($authenou))
			{
				$this->ilogin = str_replace("*","",$this->ilogin);
					if(trim($this->ipassword)=="")
					{
						$this->ipassword="ksjdfkljs";
					}
           			$authen = $this->ldap_authen($authenzone[$i],$authenou[$j],$this->ilogin,$this->ipassword);
						if($this->authen=="pass")	
						{
							$i=count($authenzone);
							$j=count($authenou);
						}else
						{
							$j+=1;
						}
     		}
     			$i+=1;
		}
	}
//Do something before user begin to use
	
	function everytimeLogin(){
		// Set session id
		require ("../config/config.inc.php");	
			session_start();
			$session_id = session_id();
			$this->session_number = session_id();
			$_SESSION["person_id"]=$this->user_id;
			$_SESSION["slogin"]=$this->ilogin;
			
			$_SESSION['dbname']	= DB_NAME;
			$_SESSION['dbhost']		= DB_HOST;
			$_SESSION['dbuser']		= DB_USER;
			$_SESSION['dbpass']		= DB_PASSWORD;
			$_SESSION['dbtype']		= DB_TYPE;
			$_SESSION['dsn']		= DB_DSN;
			$_SESSION['path']		= PATH;
			$_SESSION['realpath']	= REALPATH;
			
		
		// Update time and session_id
		require_once("../include/global.php");
		$sql=("UPDATE users set lastlogin=".time().",session_id='$this->session_number',password=MD5('$this->ipassword') WHERE id='$this->user_id';");
		//echo $sql;
		mysql_query($sql);
	}
//Add a new user login if it does not exist in database
	
	function addNewUser()
	{
		require_once("../include/global.php");
		$sql=mysql_query("SELECT id FROM users WHERE login='$this->ilogin';");
			if(mysql_num_rows($sql)==0)
			{
				$cutcode=substr($this->ilogin,0,1);
					switch($cutcode){
						case "g":
							$category=3;
							break;
						case "st":
							$category=3;
							break;
						case "b":
							$category=3;
							break;
						case "o":
							$category=4;
							break;
						case "l":
							$category=4;
							break;
						case "p":
							$category=2;
							break;	
						case "f":
							$category=2;
							break;
						case "s":
							$subcut = substr($this->ilogin,1,1);
							switch($subcut){
								case "0":
									$category=3;
									break;
								case "1":
									$category=3;
									break;
								case "2":
									$category=3;
									break;
								case "3":
									$category=3;
									break;
								case "4":
									$category=3;
									break;
								case "5":
									$category=3;
									break;
								case "6":
									$category=3;
									break;
								case "7":
									$category=3;
									break;
								case "8":
									$category=3;
									break;
								case "9":
									$category=3;
									break;									
								default :
									$category=3;
									break;	
							}	
						default :
							$category=2;
							break;	
						}
			$email=$this->ilogin."@ku.ac.th";
			mysql_query("insert into users (active,login,category,email) values (1,'$this->ilogin','$category','$email');");
			$this->user_id=mysql_insert_id();
		}        
	}
	
	function checkFirstTimeLogin()
	{
		require("../include/global.php");
		$sql=mysql_query("SELECT id FROM users WHERE login='$this->ilogin';");
			//Found no record
			if(mysql_num_rows($sql)==0)
			{
				return true;
			//Found 1 user
			}else if(mysql_num_rows($sql)==1)
			{
				$result=mysql_fetch_array($sql);
				$this->user_id=$result["id"];
				return false;
			}else 
			//Found more than 1 user
			{
				$_SESSION["userMessage"]="Found more than one '$this->ilogin' in the database! Please contact admin at fengjini@ku.ac.th";
				header("Location: ../index.php");
			}
	}
	function checkLocalUser()
	{
		require("../include/global.php");
		$sql=mysql_query("SELECT * FROM users WHERE login='$this->ilogin' and password=MD5('$this->ipassword') and active=1;");
			//Found 1 user
			if(mysql_num_rows($sql)==1)
			{
				$result=mysql_fetch_array($sql);
				$this->user_id=$result["id"];
				return true;
			//Found >1 , <1 user
			}else
			{	
				$_SESSION["userMessage"]="Found more than one '$this->ilogin' in the database! Please contact admin at fengjini@ku.ac.th";
				return false;
			}
	}
	function checkBypassUser()
	{
		require("../include/global.php");
		$sql=mysql_query("SELECT * FROM users WHERE login='$this->ilogin' and password='$this->ipassword' and active=1;");
			//Found 1 user
			if(mysql_num_rows($sql)==1)
			{
				$result=mysql_fetch_array($sql);
				$this->user_id=$result["id"];
				return true;
			//Found >1 , <1 user
			}else
			{	
				$_SESSION["userMessage"]="Found more than one '$this->ilogin' in the database! Please contact admin at fengjini@ku.ac.th";
				return false;
			}
	}
}
?>
