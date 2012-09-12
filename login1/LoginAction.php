<?php
require("LoginClass.php");
//To protect POST from other servers (IPs), security coding is needed to add here i.e.Captcha
// if ....

//check $_REQUEST from login form
	if(isset($_POST["ilogin"])){
		
		//set username, password
			$obj= new CheckLogin;
			$obj->setLogin($_POST["ilogin"]);
			$obj->setPassword($_POST["ipassword"]);
		
		/*There are 2 steps to allow users to login
		 Step 1. Check Authen via LDAP
		 	if "fail" go to Step 2
		 Step 2. Check users via local database
		 */
		 
		 //Step 1. Check via LDAP
		 
			$obj->checkAuthen();
			$result=$obj->getAuthenResult();
			//pass
				if($result=="pass"){ 
					//Do some activities before taking to index page
						//Check if it is a first-time-login user
								if($obj->checkFirstTimeLogin())
								{
								//True, add the new login to database
									$obj->addNewUser();
								}
								//Then do some routine activities for every user, i.e. update last login, add session_id database

										$obj->everytimeLogin();
										//Take the user to index page
										header("Location: ../index.php");
		
				}else
				{
					
					//False, if LDAP Failed check user in local database
					//Found a user in the database 1 record
					if ($obj->checkLocalUser()){
						
						//Then do some routine activities for every user, i.e. update last login, add session_id database
							$obj->everytimeLogin();
										
						//Take the user to index page 
							header("Location: ../index.php");
										
					}else if($obj->checkBypassUser()){
							//Then do some routine activities for every user, i.e. update last login, add session_id database
							$obj->everytimeLogin();
										
							//Take the user to index page 
							header("Location: ../index.php");
					}else
					//No user found
					{
						header("Location: ../index.php");
					}
				} 
				
	}

?>