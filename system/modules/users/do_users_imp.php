<?php 
$users = new Users('', '', '', '', '',  
				   '', '', '', '', '', 
				   '', '', ''
				   );
if ($FileImp !="") {
	$name_file= $HTTP_POST_FILES['FileImp']['name'];
	$filename=explode(".",$name_file);
	$typename=$filename[1];
	//$file_name=$filename[0];
	
	$line=file($HTTP_POST_FILES['FileImp']['tmp_name']);
	$num=0;
	$x=0;
	$file_name=date("j-m-Y-H-i-s");
	$filename=$realpath."/system/modules/users/data_noinsert/".$file_name.".txt";
	
	for ($i=1;$i<count($line);$i++) {
		$data=explode("$Deli", $line[$i]);
			 //--------check data
			for($ii=0;$ii<count($data);$ii++){   
				if($data[$ii]==""){							
					$skip=1;			
					$num++;
					$ii=count($data);						
				}else													
					$skip=0;
			}
			 //--------check data
		if($skip==1){                  //     Data no insert
			$x++;
			$b_file="$data[0],$data[1],$data[2],$data[3]";
			fputs((fopen($filename,"a")),$b_file);
		}else{
			if($users->lookupUsersName($data[0])){
				$users->import($data[0],$data[1],$data[2],$data[3]);	
			}else{
				$x++;
				$b_file="$data[0],$data[1],$data[2],$data[3]";
				fputs((fopen($filename,"a")),$b_file);
			}
		}

	} //end for

	if($x != 0){
				echo "<script language=\"javascript\">";
				echo "window.location=\"./index.php?m=users&a=import&error=1\" ";
				echo "</script>";
	}else{
				echo "<script language=\"javascript\">";
				echo "alert(\"UserName added successful.\")";
				echo "</script>";	
	}

}
?>