<?php 	
	 if($sendmail==1)
	 {    
	        $mailto=$_POST["mailto"];               // echo "mailto=".$mailto."<br>";
			$subject=$_POST["subject"];         // echo "subject=".$subject."<br>";
			$message=$_POST["message"]; // echo "message=".$message."<br>";
			$from=$_POST["from"];                // echo "from=".$from."<br>"; 	exit();
			// $ref_url=$_POST["ref_url"];	    // $courses=$_POST["courses"]; $qset=$_POST["qset"]; 
			// $mailto="numoo321@hotmail.com";

		$mailto=trim($mailto);
	    $mailto=str_replace(" ",",",$mailto);

         // print("mailto='".$mailto."'<br> subject='".$subject."'<br> message='".$message."'<br> from='".$from."'<br>");	//exit();

		  if(mail($mailto,$subject,$message,$from))
		  {
			  		 // echo "<b>Send mail successfully.</b> ";
					 echo "<script language=\"javascript\"> alert(\"Send mail successfully.\");</script>";
		  }else{
					 // echo "<b>Send mail failed! </b>";  
 					 echo "<script language=\"javascript\"> alert(\"Send mail failed! \");</script>";
				   }
		 echo "<script language='javascript'>window.location='./trackstd.php?courses=$courses&qset=$qset';</script>";
	  }
/*
	    if($ref_url==null)
		{
			$ref_url="./trackstd.php?courses=$courses&qset=$qset";
	    }

		if( mail("g4565353@ku.ac.th","TestSubject","TestMessage","FROM : Cute_NuMoo"))
		{
					echo "Send mail successfully. ";
		 }else{
			    	echo "Send mail failed! ";  
			  }
	   echo "<meta http-equiv=\"refresh\" content=\"2;url=$ref_url\">";
*/
?>