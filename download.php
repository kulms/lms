<?php
session_start();
require("include/global_login.php");

$path_out = "/data/httpd_course/files/";		//config path for local server
//$path_out = "/home/course/files/";	//config path for ku server

// get Parameters 
//$course = id course that user'd been member.
//$req = id user that login system //This should get from $_SESSION
$regId=$_SESSION["person_id"];
//echo $regId."<br>";
//echo $userid."<br>";
//echo $id."<br>";
//Example
//http://localhost/lms/download.php?m=resources&uid=2&id=1&filename=download_form.jpg&courses=1

//$Getlist=mysql_query("SELECT DISTINCT u.id FROM wp, users u WHERE wp.users=u.id AND wp.courses=".$courses." AND wp.users=".$req." AND wp.users NOT IN (SELECT users FROM drop_courses WHERE courses =".$courses." AND status = 0)");

$Getlist=mysql_query("SELECT DISTINCT u.id FROM wp, users u WHERE wp.users=u.id AND wp.courses=".$courses." AND wp.users=".$regId." AND wp.users NOT IN (SELECT users FROM drop_courses WHERE courses =".$courses." AND status = 0)");

if(@mysql_num_rows($Getlist)!=0){

	switch ($m) {
		case "resources":
			//http://localhost/lms/download.php?m=resources&uid=2&id=1&filename=download_form.jpg
			//https://158.108.219.215/lms/download.php?m=resources&uid=66828&id=166543&filename=epsonipro.jpg&courses=11034&req=66828
			$user_id = $userid."/";
			$id = $id."/";
			$modules_type = "resources_files/";		
			$file = $filename;
			$path = $path_out.$modules_type.$user_id.$id.$file;		
			break;
		//In case of homework, required these parameters: 1.file owner id, 2. admin id,  3. request user id, 4. homework id, 5. filename?
		//Logic to allow downloading , 
		//if the user is the course "admin" -> yes,
		//OR
		//if the user is the file "owner" -> yes
		case "hw":
			//http://localhost/lms/download.php?m=hw&id=1&filename=test.doc
			//http://158.108.219.215/lms/download.php?m=hw&id=29981&filename=computer130.jpg
			//tested
			$id = $id."/";	
			$modules_type = "homework/files/";		
			$file = $filename;
			$path = $path_out.$modules_type.$id.$file;
			break;
		case "hwans":
			//http://localhost/lms/download.php?m=hwans&id=1&filename=std01_php.doc
			//have not yet tested
			$id = $id."/";	
			$modules_type = "homework/ansfiles/";
			$file = $filename;
			$path = $path_out.$modules_type.$id.$file;
			break;
		case "hwsol":
			// have not yet tested http://localhost/lms/download.php?m=hwans&id=1&filename=sol.doc
			$id = $id."/";	
			$modules_type = "homework/solutions/";
			$file = $filename;
			$path = $path_out.$modules_type.$id.$file;
			break;
		case "hwzip":
			//http://localhost/test/lms/download_outside.php?m=hwans&id=1&filename=2_1.zip
			//tested
			//$id = $id."/";	
			$modules_type = "homework/zipfiles/";
			$file = $filename;
			$path = $path_out.$modules_type.$file;
			break;
		case "newschtml":
			$id = $id."/";
			$modules_type = "news_courses/".$id."htmlfiles/";
			$file = $filename;
			$path = $path_out.$modules_type.$file;
			break;
		case "newsclib":
			$id = $id."/";
			$modules_type = "news_courses/".$id."library/";
			$file = $filename;
			$path = $path_out.$modules_type.$file;
			break;
		case "newscthum":
			$id = $id."/";
			$modules_type = "news_courses/".$id."thumbnail/";
			$file = $filename;
			$path = $path_out.$modules_type.$file;
			break;
		case "preforiginal":
			$user_id = $user_id."/";
			$modules_type = "preference/";
			$original = "original/";
			$file = $filename;
			$path = $path_out.$modules_type.$user_id.$original.$file;
			break;
		case "prefconvert":
			$user_id = $user_id."/";
			$modules_type = "preference/";
			$file = $filename;
			$path = $path_out.$modules_type.$user_id.$file;
			break;
		case "syllabus":
			//http://localhost/lms/download.php?m=syllabus&id=1&filename=syllabus.doc
			$id = $id."/";
			$modules_type = "syllabus/";
			$file = $filename;
			$path = $path_out.$modules_type.$id.$file;
			break;
		case "quiz":
			break;
	}
	/*
	$mm_type="application/octet-stream";         
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Type: " . $mm_type);
	header("Content-Length: " .(string)(filesize($path)) );
	header('Content-Disposition: attachment; filename="'.basename($path).'"');
	header("Content-Transfer-Encoding: binary\n");
	readfile($path); // outputs the content of the file
	*/
	/*
	function Download($path, $speed = null)
	{
		if (is_file($path) === true)
		{
			$file = @fopen($path, 'rb');
			$speed = (isset($speed) === true) ? round($speed * 1024) : 524288;

			if (is_resource($file) === true)
			{
				set_time_limit(0);
				ignore_user_abort(false);

				while (ob_get_level() > 0)
				{
					ob_end_clean();
				}

				header('Expires: 0');
				header('Pragma: public');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Content-Type: application/octet-stream');
				header('Content-Length: ' . sprintf('%u', filesize($path)));
				header('Content-Disposition: attachment; filename="' . basename($path) . '"');
				header('Content-Transfer-Encoding: binary');

				while (feof($file) !== true)
				{
					echo fread($file, $speed);

					while (ob_get_level() > 0)
					{
						ob_end_flush();
					}

					flush();
					sleep(1);
				}

				fclose($file);
			}

			exit();
		}

		return false;
	}
	Download($path);
	*/
	
	if (file_exists($path))
	{
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($path));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($path));
		ob_clean();
		flush();
		readfile($path);
		exit();
	}else
	{
		echo "File does not exists";
	}
	
	//echo $path;
	//exit();
}
?>