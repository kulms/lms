<?	
/*
#===========================================================================
#= Script : EGAT e-Learning
#= Author : S.Kongdej
#= Web Designer: somboonph@egat.or.th
#= Email  : skongdej@hotmail.com
#= Support: http://www.learningnuke.com
#===========================================================================
#= Copyright (c) 2004 Electricity Generating Authority of Thailand,Jongdee Group
#= You are free to use and modify this script as long as this header
#=
#= This program is free software; you can redistribute it and/or modify
#= it under the terms of the GNU General Public License as published by
#= the Free Software Foundation; either version 2 of the License, or
#= (at your option) any later version.
#=
#= This program is distributed in the hope that it will be useful,
#= but WITHOUT ANY WARRANTY; without even the implied warranty of
#= MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#= GNU General Public License for more details.
#=
#= You should have received a copy of the GNU General Public License
#= along with this program; if not, write to the Free Software
#= Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#===========================================================================
*/

//== Initialise Constants ==

// config e-Mail
	$config['email_enabled']=TRUE;						// enable email to members
	$config['notifyinstructor']=TRUE;							//mail to instructor when student  post message
	$config['email_type']='1';										// '0'= mail using socket, '1' = mail using php mail function 
	$config['mailserver']="localhost";						// SMTP mail server (email.egat.or.th)

//config chat server: IRC server
	$config['chatserver']="localhost";						
	
// select language english or  thai or etc.. see lang directory
	$config['language']="thai";					

// select theme
	$config['theme']="default";								

// select editor
	$config['editor']="htmlarea3_xtd";

// show login page: login.php
	$config['showlogin']=TRUE;						

//==




/// *************** MACHINE SETTINGS ******************
// (don't touch any of this)
	define("_VALID_EEL",1);

// encode username and pasword
	$config['encoded'] = '0';											

	// Table and database 
	$config['table_prefix'] = 'el';
	$config['tableuser'] = $config['table_prefix'] . "_user";					
	$config['tablelog'] = $config['table_prefix'] . "_userlog";				
	$config['tableschool'] = $config['table_prefix'] . "_school";			
	$config['tablecourse'] = $config['table_prefix'] . "_course";			
	$config['tablelesson'] = $config['table_prefix'] . "_lesson";			
	$config['tableassignment'] = $config['table_prefix'] . "_assignment"; 
	$config['tablequiz'] = $config['table_prefix'] . "_quiz";
	$config['tablescheduling'] = $config['table_prefix'] . "_scheduling";
	$config['tableenroll']= $config['table_prefix'] . "_enroll";
	$config['tablescore']= $config['table_prefix'] . "_score";
	$config['tablefolder']=	$config['table_prefix'] . "_folder";
	$config['tablemessage'] = $config['table_prefix'] . "_message";
	$config['tableevent'] = $config['table_prefix'] . "_event";

	// Registration
	$config['nick_lower']=4;
	$config['nick_upper']=20;
	$config['pass_lower']=6;
	$config['pass_upper']=32;
	$config['id_length']=6;
	$config['admin_level'] = 10;
	$config['instructor_level']=5;
	$config['student_level']=1;

	// images and icons
	$config['admin_icon']="admin.gif";
	$config['instructor_icon']="instructor.gif";
	$config['user_icon']="user.gif";
	$config['msgicon']="icon1.gif";																			// default message icon 
	$config['foldericons']=array("images/foldericon.gif","images/i_mesg.gif","images/i_mesg.gif"); // folder icons
	$config['msgiconsdir']= "images/art/msgicons";										// Icons directory for webboard topic
	$config['smileysdir']= "images/art/smileys";												// Icons directory for webboard message
	$config['cerdir']="certificate";																			// Certificates root directory
	$config['instdir']="instructor";																				// Instructor certificate template  directory
	$config['font']=$config['homepath'].'/'.$config['cerdir'].'/font/cor.ttf';	// select TTF font for certification

	// break page 
	$config['breakpage']="{PAGE}";

	// Directories 
	$config['htmldir']="html/".$config['language'];																 
	$config['htmlimg']=$config['htmldir']."/images";											
	$config['whatupfile']=$config['htmldir']."/whatup.html";			//  what'up  file
	$config['aboutusfile']=$config['htmldir']."/aboutus.html";		//  aboutus file
	$config['helpdeskfile']=$config['htmldir']."/helpdesk.html";	//  helpdesk file
	$config['downloadfile']=$config['htmldir']."/download.html";	//  download file
	$config['contactusfile']=$config['htmldir']."/contactus.html";	//  contactus file
	$config['coursedir']=$config['homepath']."/courses";				// full path of courses directory
	$config['courseurl']="courses";														// relative directory of courses
	$config['importcoursedir']="courses/import";								// import content directory
	$config['uploadimagesdir']="uploadimages";							// upload dir

	// Parameters
	$config['htmleditor']=TRUE;														// use richedit html editor (IE 5.5+ only)
	$config['course_code_limit']=5;												// course code limit
	$config['prefix_course_code_limit']=2;									// prefix course code limit, not more than course_code_limit
	$config['dateformat']="d-m-Y H:i";											// date format, see php manual
	$config['dateformat2']="Y-m-d H:i";										// date format, see php manual
	$config['choice']=6;																		// maximum answer choice A-F
	$config['highscore']=60;																// percent score limit 
	$config['uploadfilesize']=50000000;										// limit upload filesize byte
	$config['enroll_show_date']=30;												// show enroll schedule at homepage
	$config['status_study']=0;															// study status (study,pass,drop)
	$config['status_pass']=1;
	$config['status_drop']=2;
	$config['display_per_page']="50";											// display per page	
	$config['eventlimit']="100";														// display per page for event logging
?>