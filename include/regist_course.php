<?php  
$slogin2=substr_replace($slogin,'',0,1); //echo "slogin2=".$slogin2.",  slogin=".$slogin;
$register=mysql_query("SELECT * FROM wp_ku WHERE STD_ID LIKE '%$slogin2%'");
while($rows=mysql_fetch_array($register))
{		
		$CS_CODE=$rows["CS_CODE"];
		$check_c=mysql_query("SELECT * FROM courses WHERE name='$CS_CODE'");
		//echo "SELECT * FROM courses WHERE name='$CS_CODE'<br>";
		if(mysql_num_rows($check_c)!=0)
		{	
			$c_id=@mysql_result($check_c,0,"id");  //echo "c_id=".$c_id;
			$users=mysql_query("SELECT * from users WHERE login='".$slogin."';");
			//echo "SELECT * from users WHERE login=".$slogin.";";
			$u_id=@mysql_result($users,0,"id");	    
			//echo "u_id".$u_id;
			$check_wp=mysql_query("SELECT * FROM wp WHERE users=".$u_id." AND courses=".$c_id.";");
			//echo  "SELECT * FROM wp WHERE users=".$u_id." AND courses=".$c_id.";";
			if( (mysql_num_rows($check_wp)==0) && ($c_id!="" || $c_id!=none ) && ($u_id!="" || $u_id!=none) )
			{	mysql_query("INSERT INTO wp(courses,users) VALUES($c_id,$u_id)");
				//echo  "sql_test=".$sql_test."<br>INSERT INTO wp(courses,users) VALUES($c_id,$u_id)";
				//exit;
			}
		}
} ?>