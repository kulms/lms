<?  	
		session_start();
		$session_id = session_id();		

		require ("../include/global_login.php");
        include ("../include/control_win.js");
		require("../include/online.php");
		online_courses($session_id,$person["id"],$courses,time(),1); 

		if($userid=="" || $userid==none)
		  {                        
				$users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
				$users_info=mysql_query("SELECT * from users_info WHERE id=".$person["id"]);
		   }else{         
				$users=mysql_query("SELECT * from users WHERE id=$userid");
				$users_info=mysql_query("SELECT * from users_info WHERE id=$userid");
		   }    
?>
<html><head><title>:-: Users :-:</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<script language="JavaScript">
function BrowserInfo()
{          
		  this.screenWidth = screen.availWidth;
          this.screenHeight = screen.availHeight;
              // toolbar_height=toolbar.height;
             //  toolbar_width=toolbar.width;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<div align="center">
<table width="640" cellpadding="10" cellspacing="0" bgcolor="#ffffff">
        
    <tr> 
      <td align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" class="bluenav"> 
              <?
if( $groups=="" || $groups==none )
{
        $Getlist=mysql_query("SELECT DISTINCT u.id,u.login,u.firstname,u.surname,u.email,u.homepage,uf.skill_interest,uf.address,u.picture, u.lastlogin,
                                                                                                  uf.picture_width, uf.picture_height,uf.mobile_phone,uf.telephone,uf.p_address,uf.p_telephone,uf.p_mobile_phone
                                                                                                 FROM wp,users u , users_info uf
                                                                                                 WHERE wp.users=u.id AND wp.courses=".$courses." AND wp.cases=0 AND wp.modules=0 AND wp.groups=0
                                                                                                 AND u.active=1 AND u.category=3 AND uf.id=u.id  ORDER BY u.login, wp.admin desc, u.category ");

        $course=mysql_query("SELECT * from courses where id=".$courses);

        // debug here
        if($person["id"] == @mysql_result($course,0,"users"))
                $course_admin = true;
        else
                $course_admin = false;
?>
              <font size="5"> <strong> 
              <?   echo @mysql_result($course,0,"name");
                         if (@mysql_result($course,0,"section") != "")
                           {    ?>
              (หมู่ <? echo @mysql_result($course,0,"section"); ?>)</strong></font> 
              <?  }   ?>
              <?   
}else{
                $Getlist=mysql_query("SELECT DISTINCT u.id,u.login,u.email,u.firstname,u.surname,u.homepage,uf.skill_interest, uf.address,u.picture, u.lastlogin,
                                                                                                          uf.mobile_phone,uf.telephone, uf.picture_width, uf.picture_height,uf.p_address,uf.p_telephone,uf.p_mobile_phone
                                                                                                         FROM  wp,users u, users_info uf
                                                                                                         WHERE wp.users=u.id AND wp.groups=".$groups." AND wp.cases=0 AND wp.modules=0 AND wp.courses=0
                                                                                                         AND u.active=1 AND u.category=3 AND u.id=uf.id ORDER BY u.login, wp.admin desc, u.category,u.login");
        $group=mysql_query("SELECT * from groups where id=".$groups);
?>
              <?  }  ?>
            </td>
          </tr>
        </table> 
        <br>
        <table border=0 cellpadding="2" cellspacing="0" width="100%" >
          <tr> 
            <td width="77" align="center"   class="mini"  style="border-bottom: solid #2D649B 2px;border-top: solid #2D649B 2px;"><b>Login</b></td>
            <td width="103" align="center"  class="mini" style="border-bottom: solid #2D649B 2px;border-top: solid #2D649B 2px;"><b>Name</b></td>
            <td width="308" align="center"  class="mini" style="border-bottom: solid #2D649B 2px;border-top: solid #2D649B 2px;"><b>Raw 
              Score </b></td>           
            <td width="74" align="center"  class="mini"  style="border-bottom: solid #2D649B 2px;border-top: solid #2D649B 2px;"><b>Total 
              Score</b></td>
          </tr>
          <?  
		$color = 0;
		$bgcolor = "#d4e2ed";
		while($row=mysql_fetch_array($Getlist))
		{      
			$userlogin=$row["login"];
			$firstname=$row["firstname"];
			$surname=$row["surname"];	
			$homepage=$row["homepage"];
			$userid=$row["id"];    
		?>
		<? if ($color==0) {?>
          <tr> 
            <td  style="border-bottom: dotted #2D649B 1px;" align="center" class="mini"><span><? echo $userlogin; ?></span></td>
            <td style="border-bottom: dotted #2D649B 1px;" class="mini"> <span > 
              <?          
			  // debug here
				if($person["admin"]==1 || $course_admin)
				{          
			   ?>
              <!--<a href="../personal/menu.php?userid=<? echo $userid; ?>"><? echo $firstname." ".$surname; ?></a> -->
			  <? echo $firstname." ".$surname; ?>
              <? 
			  }else
			  {         
			  		echo  "&nbsp;".$firstname." ".$surname; 
			   }                                        
			  ?>
			  </span> 
			</td>
			<?
				$n=0;
				$number=1;
				$score=mysql_query("SELECT (home_score1+home_score2+home_score3) as home, (final_score1+final_score2+final_score3) as final, eval_by 
															FROM evaluate WHERE eval_owner=$userid");
				if ( mysql_num_rows($score) != 0) 
				{										
					while($row_score=mysql_fetch_array($score))
						{
							$evalby_id=$row_score["eval_by"];
							//echo $evalby_id."<br>";
							$evalby=mysql_query("SELECT * from users WHERE id=$evalby_id");
							//echo mysql_num_rows($evalby)."<br>";
								if (mysql_result($evalby,0,"category")==3) {														
									$eachscore[$n]=array($row_score["home"]);	
									$calscore_home[$n]=array($row_score["home"]);							
									$eachscore_[$n]=array($row_score["final"]);
									$calscore_final[$n]=array($row_score["final"]);
									$n++;
								} else {
									$t_home_score = $row_score["home"];
									$t_final_score = $row_score["final"];
								}
						}
					
					if (count($calscore_home)!=0) {
						rsort($calscore_home);
						$num_h = count($calscore_home);					
						$d_h = $num_h-2;  // ตัวหารของ homework
						$sum_h = 0;
						 for($i=1; $i<=$d_h; ++$i)
						{
							$sum_h+=$calscore_home[$i][0];
						}
						$avg_h = $sum_h/$d_h;
					}	
					if (count($calscore_final)!=0) {
						rsort($calscore_final);
						$num_f = count($calscore_final);
						$d_f = $num_f-2;  // ตัวหารของ final
						$sum_f = 0;
						 for($i=1; $i<=$d_f; ++$i)
						{
							$sum_f+=$calscore_final[$i][0];
						}
						
						$avg_f = $sum_f/$d_f;
					}
					
					$nume=count($eachscore);					
					$nume_=count($eachscore_);									
					
					if (($nume == 14) && ($nume_==14)) {
						$special_score = 10;
					}				
		?>
            <td style="border-bottom: dotted #2D649B 1px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="20%"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                      <tr> 
                        <td width="100%" class="mini"><strong>Homework</strong></td>
                      </tr>
                      <tr> 
                        <td class="mini"><strong>Final</strong></td>
                      </tr>
                    </table></td>
                  <td width="77%"><table width="14" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <?
				  for($idx=0; $idx<$nume; ++$idx)
				 {
						$home_s=$eachscore[$idx][0];						
						//$final_s=$eachscore[$idx][1];
				?>
                        <td>&nbsp;</td>
                        <td  align="center" width="100%" class="mini"><? echo $home_s;?></td>
                        <?
				  }		
				  ?>
                      </tr>
                      <tr> 
                        <?
				  for($idx=0; $idx<$nume_; ++$idx)
				 {
						//$home_s=$eachscore[$idx][0];
						$final_s=$eachscore_[$idx][0];
				?>
                        <td>&nbsp;</td>
                        <td  align="center" width="100%" class="mini"><? echo $final_s;?></td>
                        <?
				  }		
				  ?>
                      </tr>
                    </table></td>
                  <td width="77%"><table width="14" border="0" cellpadding="0" cellspacing="0" bgcolor="#999999">
                      <tr> 
                       
                        <td>&nbsp;</td>
                        <td  align="center" width="100%" class="mini" ><b><? if($t_home_score!=0) {echo $t_home_score;} else { echo "0";}?></b></td>
                 
                      </tr>
                      <tr> 
                        
                        <td>&nbsp;</td>
                        <td  align="center" width="100%" class="mini"><b><? if($t_final_score!=0) {echo $t_final_score;} else { echo "0";}?></b></td>
                     
                      </tr>
                    </table> </td>
                </tr>
              </table> 
              
            </td>
			   <td class="small" valign="middle" style="border-bottom: dotted #2D649B 1px;" align="center"><font color="#FF0000" size="4"><strong><? echo $avg_h+$avg_f+($t_home_score/2)+($t_final_score/2)+$special_score;?>
              </strong></font></td>
			  <? 
			  unset($eachscore);
			  unset($eachscore_);
			  unset($calscore_home);
			  unset($calscore_final);
			  $t_home_score=0;
			  $t_final_score=0;			  
			  	} else {?>
			  
			   <td style="border-bottom: dotted #2D649B 1px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
                <tr>
                  <td width="18%" class="mini"><strong>Homework</strong></td>				
                  <td width="5%" align="center"><? //echo "- -";?></td>				  
                </tr>
                <tr>
                  <td class="mini"><strong>Final</strong></td>                  
                  <td width="5%" align="center"><? //echo "- -";?></td>				  
                </tr>
              </table></td>
			   <td class="small" valign="middle" style="border-bottom: dotted #2D649B 1px;" align="center"><font color="#FF0000" size="4"><strong>- 
              -</strong></font></td>
			  <? }?>         
			     
           
          </tr>		  
          <? 
		  $color = 1;
		  } else {
		  ?>
		  <tr bgcolor="<? echo $bgcolor;?>"> 
            <td  style="border-bottom: dotted #2D649B 1px;" align="center" class="mini"><span ><? echo $userlogin; ?></span></td>
            <td  style="border-bottom: dotted #2D649B 1px;" class="mini"> <span > 
              <?          
			  // debug here
				if($person["admin"]==1 || $course_admin)
				{          
			   ?>
              <!--<a href="../personal/menu.php?userid=<? echo $userid; ?>"><? echo $firstname." ".$surname; ?></a>-->
			  <? echo $firstname." ".$surname; ?> 
              <? 
			  }else
			  {         
			  		echo  "&nbsp;".$firstname." ".$surname; 
			   }                                        
			  ?>
			  </span> 
			</td>
			<?
				$n=0;
				$number=1;
				$score=mysql_query("SELECT (home_score1+home_score2+home_score3) as home, (final_score1+final_score2+final_score3) as final, eval_by
															FROM evaluate WHERE eval_owner=$userid");
				if ( mysql_num_rows($score) != 0) 
				{
					while($row_score=mysql_fetch_array($score))
						{
							$evalby_id=$row_score["eval_by"];
							//echo $evalby_id."<br>";
							$evalby=mysql_query("SELECT * from users WHERE id=$evalby_id");
							//echo mysql_num_rows($evalby)."<br>";
								if (mysql_result($evalby,0,"category")==3) {														
									$eachscore[$n]=array($row_score["home"]);	
									$calscore_home[$n]=array($row_score["home"]);							
									$eachscore_[$n]=array($row_score["final"]);
									$calscore_final[$n]=array($row_score["final"]);
									$n++;
								} else {
									$t_home_score = $row_score["home"];
									$t_final_score = $row_score["final"];
								}
						}
					
					if (count($calscore_home)!=0) {
						rsort($calscore_home);
						$num_h = count($calscore_home);					
						$d_h = $num_h-2;  // ตัวหารของ homework
						$sum_h = 0;
						 for($i=1; $i<=$d_h; ++$i)
						{
							$sum_h+=$calscore_home[$i][0];
						}
						$avg_h = $sum_h/$d_h;
					}
					if (count($calscore_final)!=0) {						
						rsort($calscore_final);
						$num_f = count($calscore_final);
						$d_f = $num_f-2;  // ตัวหารของ final
						$sum_f = 0;
						 for($i=1; $i<=$d_f; ++$i)
						{
							$sum_f+=$calscore_final[$i][0];
						}
						
						$avg_f = $sum_f/$d_f;
					}
					
					$nume=count($eachscore);
				
					$nume_=count($eachscore_);				

					
					if (($nume == 14) && ($nume_==14)) {
						$special_score = 10;
					}
		?>
            <td style="border-bottom: dotted #2D649B 1px;"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="20%"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                      <tr> 
                        <td width="100%" class="mini"><strong>Homework</strong></td>
                      </tr>
                      <tr> 
                        <td class="mini"><strong>Final</strong></td>
                      </tr>
                    </table></td>
                  <td width="77%"><table width="14" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <?
				  for($idx=0; $idx<$nume; ++$idx)
				 {
						$home_s=$eachscore[$idx][0];						
						//$final_s=$eachscore[$idx][1];
				?>
                        <td>&nbsp;</td>
                        <td  align="center" width="100%" class="mini"><? echo $home_s;?></td>
                        <?
				  }		
				  ?>
                      </tr>
                      <tr> 
                        <?
				  for($idx=0; $idx<$nume_; ++$idx)
				 {
						//$home_s=$eachscore[$idx][0];
						$final_s=$eachscore_[$idx][0];
				?>
                        <td>&nbsp;</td>
                        <td  align="center" width="100%" class="mini"><? echo $final_s;?></td>
                        <?
				  }		
				  ?>
                      </tr>
                    </table></td>
                  <td width="77%"><table width="14" border="0" cellpadding="0" cellspacing="0" bgcolor="#999999">
                      <tr> 
                        <td>&nbsp;</td>
                        <td  align="center" width="100%" class="mini" ><b>
                          <? if($t_home_score!=0) {echo $t_home_score;} else { echo "0";}?>
                          </b></td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td  align="center" width="100%" class="mini"><b>
                          <? if($t_final_score!=0) {echo $t_final_score;} else { echo "0";}?>
                          </b></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
			  <td class="small" valign="middle" style="border-bottom: dotted #2D649B 1px;" align="center"><font color="#FF0000" size="4"><strong><? echo $avg_h+$avg_f+($t_home_score/2)+($t_final_score/2)+$special_score;?>
              </strong></font></td>
			  <? 
			  unset($eachscore);
			  unset($eachscore_);
			  unset($calscore_home);
			  unset($calscore_final);
			   $t_home_score=0;
			  $t_final_score=0;
			  } else {
			  ?>
			  
			   <td style="border-bottom: dotted #2D649B 1px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
                <tr>
                  <td width="18%" class="mini"><strong>Homework</strong></td>				
                  <td width="5%" align="center"><? //echo "0";?></td>				  
                </tr>
                <tr>
                  <td class="mini"><strong>Final</strong></td>                  
                  <td width="5%" align="center"><? //echo "0";?></td>				  
                </tr>
              </table></td>
			  <td class="small" valign="middle" style="border-bottom: dotted #2D649B 1px;" align="center"><font color="#FF0000" size="4"><strong>- 
              - </strong></font></td>
			  <? }?>                 
            
          </tr>
		  <?
		  $color = 0;
		  }
		  
		  } 
		  // end while  Getlist
		  ?>
        </table>

       <table cellpadding="0" cellspacing="0" width="100%" border="0" >
          <tr>
            <td width="12%" style="border-bottom: solid #2D649B 2px;border-top: solid #2D649B 2px;" class="mini"><b>Total</b></td>
            <td width="88%" style="border-bottom: solid #2D649B 2px;border-top: solid #2D649B 2px;" class="mini"><? echo mysql_num_rows($Getlist); ?> คน</td>
          </tr>
        </table>
	</td>
  </tr>
</table>
</div>
</body>
</html>