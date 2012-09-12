<? require "include/global_login.php";
//***************************************************************************************
//	Get:
//		-total number of active users in each module
//		-total number of posting in each module
//		-the number of distinct posting users in a module
//		-The number of postings for each user
// 	"select * from login_modules where week(from_unixtime(time))=(week(now())-1);"--hämta allt fr förra veckan
//	"select from_unixtime(940585640);" --omvandlar till datumformat
//***************************************************************************************
?>
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="main.css">
</head>
<body>
<?
$get_course=mysql_query("SELECT wp.modules,m.name AS modulename, mt.tablename,c.name AS coursename 
						 FROM wp,modules m,courses c,modules_type mt 
						 WHERE wp.courses=$courses AND m.id=wp.modules AND c.id=$courses 
						 	   AND mt.id=m.modules_type 
						 ORDER BY m.name ASC;");
if(mysql_num_rows($get_course)!=0){?>
	<div class="h3" align="center">
  <table width="482" border="0" cellspacing="0" cellpadding="0" align="center" background="images/headerbg.gif" height="53">
    <tr>
      <td class="menu" align="center"><b><? echo $strCourses_LabCourseActivity;?><br>
        <?php echo $strCourses_LabCourseId;?> <? echo mysql_result($get_course,0,"coursename")?></b> </td>
    </tr>
  </table>
  
</div>
<? 	if($modules==""){
		mysql_data_seek($get_course,0);?>
		
<div class="main" align="center"><b><br>
  <?php echo $strActivity_SelectModule;?></b></div>
			<div align="center"> 
			<form method="get" action="visualization.php">
			<select name="modules">
				<option value="0">Show all</option>
			<? while($module_row=mysql_fetch_array($get_course)){?>
				<option value="<? echo $module_row["modules"]?>"><? echo $module_row["modulename"]?></option>
			<? }?>
			</select>
			<input type="hidden" name="courses" value="<? echo $courses?>">
			<input type="submit" value="<?php echo $strShow;?>">
			</form>
			</div>
<?	}else{
		if($modules==0){
		mysql_data_seek($get_course,0);?>
		
<div class="main" align="center"><b><br>
  <?php echo $strActivity_SelectModule;?></b></div>
		<div align="center">
		<form method="get" action="visualization.php">
		<select name="modules">
			<option value="0">Show all</option>
		<? while($module_row=mysql_fetch_array($get_course)){?>
			<option value="<?echo $module_row["modules"]?>"><?echo $module_row["modulename"]?></option>
		<? }?>
		</select>
		<input type="hidden" name="courses" value="<? echo $courses?>">
		<input type="submit" value="<?php echo $strShow;?>">
		</form></div>
			<table valign="top" align="center" border="0" cellpadding="7" cellspacing="1" width="100%" bgcolor="#D6D6D6">
				<tr bgcolor="#808080">
					
    <td class="main"><b><?php echo $strActivity_LabModuleName;?></b></td>
					
    <td class="main"><b><?php echo $strActivity_LabStat;?></b></td>
					
    <td class="main"><b><?php echo $strActivity_LabByUser;?></b>&nbsp; (<? echo $strActivity_LabCurrentWeek;?>: 
      <? echo strftime("%W : %d/%m/%Y ",time())?>)</td>
				</tr>
			<? mysql_data_seek($get_course,0);
				while($module_row=mysql_fetch_array($get_course)){?>
				<tr>
					<td valign="top" class="main"><b><? echo $module_row["modulename"]?></b></td>
				<?	$tablename=$module_row["tablename"];
					
					$get_activity=mysql_query("SELECT distinct lm.users,u.firstname,u.surname,u.login 
											   FROM login_modules lm, users u 
											   WHERE lm.modules=".$module_row["modules"]." AND u.id=lm.users 
											   ORDER BY u.firstname,u.surname ASC;");
					$usercount=mysql_num_rows($get_activity); //the number of active users in module
					$get_total_activity=mysql_query("SELECT count(id) AS logincnt FROM login_modules WHERE modules=".$module_row["modules"].";");
					$logincount=mysql_result($get_total_activity,0,"logincnt"); //the number of users that logged into module
					?>
					<td valign="top" class="main">
					<table>
						<tr>
							
          <td class="main"><b><? echo $strSystem_LabActiveUser;?></b>(<? echo $strActivity_LabLogin;?>):</td>
							<td class="main"><? echo $usercount?></td>
						</tr>
						<tr>
							
          <td class="main"><b><? echo $strActivity_LabTotalLogin;?>:</b></td>
							<td class="main"><? echo $logincount?></td>
						</tr>
			<?		if($tablename!="-"){
						$get_contrib_count=mysql_query("SELECT count(id) AS contribs FROM ".$tablename." WHERE modules=".$module_row["modules"].";");
						$contrib_count=mysql_result($get_contrib_count,0,"contribs"); //The total number of postings in a module
						$get_postings=mysql_query("SELECT distinct f.users,u.firstname,u.surname,u.login 
												FROM ".$tablename." f,users u 
												WHERE f.modules=".$module_row["modules"]." AND u.id=f.users 
												ORDER BY u.firstname,u.surname;");
						$count_posting_users=mysql_num_rows($get_postings); //the number of posting users in module
						?>
						<tr>
							
          <td class="main"><b><? echo $strActivity_LabNrPost;?></b>:</td>
							<td class="main"><b><? echo $count_posting_users?></b></td>
						</tr>
						<tr>
							
          <td class="main"><b><? echo $strActivity_LabTotalPost;?></b>:</td>
							<td class="main"><b><? echo $contrib_count?></b></td>
						</tr>
						</table>
						</td><?
						if(mysql_num_rows($get_postings)!=0){?>
							<td valign="top">
							<table cellpadding="2" valign="top" cellspacing="1" width="100%" bgcolor="#808080">
							<? while($posting_users_row=mysql_fetch_array($get_activity)){?>
								<? 
								$get_act=mysql_query("SELECT distinct week(from_unixtime(time),0) as weektime 
													  FROM login_modules 
													  WHERE modules=".$module_row["modules"]." 
													  AND users=".$posting_users_row["users"]." ORDER BY weektime;");
								$get_contrib_count=mysql_query("SELECT count(id) AS contribs 
																FROM ".$tablename." 
																WHERE modules=".$module_row["modules"]." 
																AND users=".$posting_users_row["users"].";");
								$get_login_count=mysql_query("SELECT count(id) AS logins 
															  FROM login_modules 
															  WHERE modules=".$module_row["modules"]." 
															  AND users=".$posting_users_row["users"].";");
								if(mysql_num_rows($get_login_count)!=0){
									$logins=mysql_result($get_login_count,0,"logins");
								}
	
								if(mysql_num_rows($get_contrib_count)!=0){
									$user_contrib_count=mysql_result($get_contrib_count,0,"contribs"); //The total number of posting for each user
									$username=$posting_users_row["firstname"]."&nbsp;".$posting_users_row["surname"];
									if($username=="&nbsp;"){
										$username=$posting_users_row["login"];
									}?>
								<tr>
									<td valign="top" class="main"><b><? echo $username?></b>
										<? if(mysql_num_rows($get_act)!=0){?>
											<table border="0" width="100%">
												<tr bgcolor="#C0C0C0">
													
                <td class="main" valign="top" align="right"><b><? echo $strActivity_LabWeek;?></b></td>
													
                <td class="main" valign="top" align="right"><b><? echo $strActivity_LabLogin?>(<? echo $logins?>)</b></td>
													
                <td class="main" valign="top" align="right"><b><? echo $strActivity_LabPost;?>(<? echo $user_contrib_count?>)</b></td>
												</tr>
											<? 
											$prev_week=0;
											while($act_row=mysql_fetch_array($get_act)){
												if($act_row["weektime"]!=$prev_week){?>
													<tr bgcolor="#D6D6D6">
														
                <td class="main" valign="top" align="right"><? echo $act_row["weektime"]?> 
                  <br>
                  <?
														$days = $act_row["weektime"]*7;
														echo date ("d/m/Y", mktime (0, 0, 0, 1, $days-3, date("Y")-1))." - ".date ("d/m/Y", mktime (0, 0, 0, 1, $days+3, date("Y")-1));
														?>
                </td>
													<? 
													$post_by_week=mysql_query("SELECT count(id) as contrib_by_week 
																			   FROM ".$tablename." 
																			   WHERE modules=".$module_row["modules"]." 
																			   		 AND users=".$posting_users_row["users"]." 
																			   		 AND week(from_unixtime(time),0)=".$act_row["weektime"].";");
													$login_by_week=mysql_query("SELECT count(id) as login_week 
																				FROM login_modules 
																				WHERE modules=".$module_row["modules"]." 
																					  AND users=".$posting_users_row["users"]." 
																					  AND week(from_unixtime(time),0)=".$act_row["weektime"].";");
													if(mysql_num_rows($login_by_week)!=0){?>
														<td class="main" valign="top" align="right"><? echo mysql_result($login_by_week,0,"login_week")?></td>
													<? }else{?>
														<td class="main" valign="top" align="right">0</td>
													<? }
													if(mysql_num_rows($post_by_week)!=0){?>
														<td class="main" valign="top" align="right"><? echo mysql_result($post_by_week,0,"contrib_by_week")?></td>
													<? }else{?>
														<td class="main" valign="top" align="right">0</td>
													<? }?>
													</tr>
											<?		$prev_week=$act_row["weektime"];
												}
											}?>
											</table>
										<? }?></td>
								 </tr><?
								}
							}?>
							</table>
							</td>
						<? }else{
						//*************
						?>
							<td valign="top">
							<table cellpadding="2" cellspacing="1" width="100%" bgcolor="#808080">
							<? while($posting_users_row=mysql_fetch_array($get_activity)){?>
								<? $get_act=mysql_query("SELECT distinct week(from_unixtime(time),0) as weektime 
														 FROM login_modules 
														 WHERE modules=".$module_row["modules"]." AND users=".$posting_users_row["users"]." 
														 ORDER BY weektime;");
								//$get_contrib_count=mysql_query("SELECT count(id) AS contribs FROM ".$tablename." WHERE modules=".$module_row["modules"]." AND users=".$posting_users_row["users"].";");
								$get_login_count=mysql_query("SELECT count(id) AS logins 
															  FROM login_modules 
															  WHERE modules=".$module_row["modules"]." AND users=".$posting_users_row["users"].";");
								if(mysql_num_rows($get_login_count)!=0){
									$logins=mysql_result($get_login_count,0,"logins");
								}
									$username=$posting_users_row["firstname"]."&nbsp;".$posting_users_row["surname"];
									if($username=="&nbsp;"){
										$username=$posting_users_row["login"];
									}?>
								<tr>
									<td valign="top" class="main"><b><? echo $username?></b>
										<? if(mysql_num_rows($get_act)!=0){?>
											<table border="0" width="100%">
												<tr bgcolor="#C0C0C0">
													
                <td class="main" valign="top" align="right"><b><? echo $strActivity_LabWeek;?></b></td>
													
                <td class="main" valign="top" align="right"><b><? echo $strActivity_LabLogin?>(<? echo $logins?>)</b></td>
													
                <td class="main" valign="top" align="right"><b><? echo $strActivity_LabPost;?>(0)</b></td>
												</tr>
											<?
											$prev_week=0;
											while($act_row=mysql_fetch_array($get_act)){
												if($act_row["weektime"]!=$prev_week){?>
													<tr bgcolor="#D6D6D6">
														
                <td class="main" valign="top" align="right"><? echo $act_row["weektime"]?> 
                  <br>
                  <?
														$days = $act_row["weektime"]*7;
														echo date ("d/m/Y", mktime (0, 0, 0, 1, $days-3, date("Y")-1))." - ".date ("d/m/Y", mktime (0, 0, 0, 1, $days+3, date("Y")-1));
														?>
                </td>
													<? 
													$post_by_week=mysql_query("SELECT count(id) as contrib_by_week 
																			   FROM ".$tablename." 
																			   WHERE modules=".$module_row["modules"]." 
																			   		 AND users=".$posting_users_row["users"]." 
																					 AND week(from_unixtime(time),0)=".$act_row["weektime"].";");
													$login_by_week=mysql_query("SELECT count(id) as login_week 
																				FROM login_modules 
																				WHERE modules=".$module_row["modules"]." 
																					  AND users=".$posting_users_row["users"]." 
																					  AND week(from_unixtime(time),0)=".$act_row["weektime"].";");
													if(mysql_num_rows($login_by_week)!=0){?>
														<td class="main" valign="top" align="right"><? echo mysql_result($login_by_week,0,"login_week")?></td>
													<? }else{?>
														<td class="main" valign="top" align="right">0</td>
													<? }
													if(mysql_num_rows($post_by_week)!=0){?>
														<td class="main" valign="top" align="right"><? echo mysql_result($post_by_week,0,"contrib_by_week")?></td>
													<? }else{?>
														<td class="main" valign="top" align="right">0</td>
													<? }?>
													</tr>
											<?		$prev_week=$act_row["weektime"];
												}
											}?>
											</table>
										<? }?></td>
								 </tr><?
								//}
							}?>
							</table>
							</td>						
						<?
						//**************
						}
					}else{?>
						<td valign="top" class="main">0</td><?
					}?>
				</tr>
				<? }?>
			</table>
		<? }else{
		mysql_data_seek($get_course,0);?>
		
<div class="main" align="center"><b><br>
  <?php echo $strActivity_SelectModule;?></b></div>
		<div align="center">
		<form method="get" action="visualization.php">
		<select name="modules">
			<option value="0">Show all</option>
		<? while($module_row=mysql_fetch_array($get_course)){?>
			<option value="<? echo $module_row["modules"]?>"><? echo $module_row["modulename"]?></option>
		<? }?>
		</select>
		<input type="hidden" name="courses" value="<? echo $courses?>">
		<input type="submit" value="<?php echo $strShow;?>">
		</form>
		</div>
			<table align="center" border="0" cellpadding="7" cellspacing="1" width="100%" bgcolor="#D6D6D6">
				<tr bgcolor="#808080">
					<td class="main"><b><?php echo $strActivity_LabModuleName;?></b></td>
					<td class="main"><b><?php echo $strActivity_LabStat;?></b></td>
					
    <td class="main"><b><?php echo $strActivity_LabByUser;?></b> &nbsp; (<? echo $strActivity_LabCurrentWeek;?>: <? echo strftime("%W : %d/%m/%Y ",time())?>)</td>
				</tr>
			<? $get_module=mysql_query("SELECT m.name,mt.tablename 
										FROM modules m, modules_type mt 
										WHERE m.id=$modules AND mt.id=m.modules_type;");
				$modulename=mysql_result($get_module,0,"name")?>
				<tr>
					<td valign="top" class="main"><b><? echo $modulename?></b></td>
				<?	$tablename=mysql_result($get_module,0,"tablename");
					$get_activity=mysql_query("SELECT distinct lm.users,u.firstname,u.surname,u.login 
											   FROM login_modules lm, users u 
											   WHERE lm.modules=$modules AND u.id=lm.users 
											   ORDER BY u.firstname,u.surname ASC;");
					$usercount=mysql_num_rows($get_activity); //the number of active users in module
					$get_total_activity=mysql_query("SELECT count(id) AS logincnt FROM login_modules WHERE modules=$modules;");
					$logincount=mysql_result($get_total_activity,0,"logincnt"); //the number of users that logged into module

					?>
					<td valign="top" class="main">
					<table>
						<tr>
							<td class="main"><b><? echo $strSystem_LabActiveUser;?></b>(<? echo $strActivity_LabLogin;?>):</td>
							<td class="main"><b><? echo $usercount?></b></td>
						</tr>
						<tr>
							<td class="main"><b><? echo $strActivity_LabTotalLogin;?>:</b></td>
							<td class="main"><b><? echo $logincount?></b></td>
						</tr>					
				<?	if($tablename!="-"){
						$get_contrib_count=mysql_query("SELECT count(id) AS contribs FROM ".$tablename." WHERE modules=$modules;");
						if(mysql_num_rows($get_contrib_count)!=0){
							$contrib_count=mysql_result($get_contrib_count,0,"contribs"); //The total number of postings in a module
						}
						$get_postings=mysql_query("SELECT distinct f.users,u.firstname,u.surname,u.login 
												   FROM ".$tablename." f,users u 
												   WHERE f.modules=$modules AND u.id=f.users 
												   ORDER BY u.firstname,u.surname;");
						$count_posting_users=mysql_num_rows($get_postings); //the number of posting users in module
						//mysql_data_seek($get_postings,0);
						?>
						<tr>
							<td class="main"><b><? echo $strActivity_LabNrPost;?></b>:</td>
							<td class="main"><b><? echo $count_posting_users?></b></td>
						</tr>
						<tr>
							<td class="main"><b><? echo $strActivity_LabTotalPost;?></b>:</td>
							<td class="main"><b><? echo $contrib_count?></b></td>
						</tr>
						</table>
						</td><?
						if(mysql_num_rows($get_postings)!=0){?>
							<td>
							<table cellpadding="2" cellspacing="1" width="100%" bgcolor="#808080">
							<? while($posting_users_row=mysql_fetch_array($get_activity)){?>
								<? $get_act=mysql_query("SELECT distinct week(from_unixtime(time),0) as weektime 
														 FROM login_modules 
														 WHERE modules=$modules 
														 	   AND users=".$posting_users_row["users"]." 
														 ORDER BY weektime;");
								$get_contrib_count=mysql_query("SELECT count(id) AS contribs 
																FROM ".$tablename." 
																WHERE modules=$modules 
																	  AND users=".$posting_users_row["users"].";");
								$get_login_count=mysql_query("SELECT count(id) AS logins 
															  FROM login_modules 
															  WHERE modules=$modules AND users=".$posting_users_row["users"]." ;");
								if(mysql_num_rows($get_login_count)!=0){
									$logins=mysql_result($get_login_count,0,"logins");
								}
								if(mysql_num_rows($get_contrib_count)!=0){
									$user_contrib_count=mysql_result($get_contrib_count,0,"contribs"); //The total number of posting for each user
									$username=$posting_users_row["firstname"]."&nbsp;".$posting_users_row["surname"];
									if($username=="&nbsp;"){
										$username=$posting_users_row["login"];
									}
								?><tr>
									<td valign="top" class="main"><b><? echo $username?></b>
										<? if(mysql_num_rows($get_act)!=0){?>
											<table border="0" width="100%">
												<tr bgcolor="#C0C0C0">
													<td class="main" valign="top" align="right"><b><? echo $strActivity_LabWeek;?></b></td>
													<td class="main" valign="top" align="right"><b><? echo $strActivity_LabLogin?>(<? echo $logins?>)</b></td>
													<td class="main" valign="top" align="right"><b><? echo $strActivity_LabPost;?>(<? echo $user_contrib_count?>)</b></td>
												</tr>
											<?
											$prev_week=0;
											while($act_row=mysql_fetch_array($get_act)){
												if($act_row["weektime"]!=$prev_week){?>
													<tr bgcolor="#D6D6D6">
														
                <td class="main" valign="top" align="right"><? echo $act_row["weektime"]?> 
                  <br>
                  <?
														$days = $act_row["weektime"]*7;
														echo date ("d/m/Y", mktime (0, 0, 0, 1, $days-3, date("Y")-1))." - ".date ("d/m/Y", mktime (0, 0, 0, 1, $days+3, date("Y")-1));
														?>
                </td>
													<? 
													$post_by_week=mysql_query("SELECT count(id) as contrib_by_week 
																			   FROM ".$tablename." 
																			   WHERE modules=$modules 
																					 AND users=".$posting_users_row["users"]." 
																					 AND week(from_unixtime(time),0)=".$act_row["weektime"].";");
													$login_by_week=mysql_query("SELECT count(id) as login_week 
																				FROM login_modules 
																				WHERE modules=$modules 
																				AND users=".$posting_users_row["users"]." 
																				AND week(from_unixtime(time),0)=".$act_row["weektime"].";");
													if(mysql_num_rows($login_by_week)!=0){?>
														<td class="main" valign="top" align="right"><? echo mysql_result($login_by_week,0,"login_week")?></td>
													<? }else{?>
														<td class="main" valign="top" align="right">0</td>
													<? }
													if(mysql_num_rows($post_by_week)!=0){?>
														<td class="main" valign="top" align="right"><? echo mysql_result($post_by_week,0,"contrib_by_week")?></td>
													<? }else{?>
														<td class="main" valign="top" align="right">0</td>
													<? }?>
													</tr>
											<?		$prev_week=$act_row["weektime"];
												}
											}?>
											</table>
										<? }?></td>
								 </tr><?
								}
							}?>
							</table>
							</td>
						<? }else{
						//*********************2
						?>
							<td valign="top">
							<table cellpadding="2" cellspacing="1" width="100%" bgcolor="#808080">
							<? while($posting_users_row=mysql_fetch_array($get_activity)){?>
								<? $get_act=mysql_query("SELECT distinct week(from_unixtime(time),0) as weektime 
														 FROM login_modules 
														 WHERE modules=$modules AND users=".$posting_users_row["users"]." 
														 ORDER BY weektime;");
								//$get_contrib_count=mysql_query("SELECT count(id) AS contribs FROM ".$tablename." WHERE modules=".$module_row["modules"]." AND users=".$posting_users_row["users"].";");
								$get_login_count=mysql_query("SELECT count(id) AS logins 
															  FROM login_modules 
															  WHERE modules=$modules AND users=".$posting_users_row["users"].";");
								if(mysql_num_rows($get_login_count)!=0){
									$logins=mysql_result($get_login_count,0,"logins");
								}
									$username=$posting_users_row["firstname"]."&nbsp;".$posting_users_row["surname"];
									if($username=="&nbsp;"){
										$username=$posting_users_row["login"];
									}?>
								<tr>
									<td valign="top" class="main"><b><? echo $username?></b>
										<? if(mysql_num_rows($get_act)!=0){?>
											<table border="0" width="100%">
												<tr bgcolor="#C0C0C0">
													
                <td class="main" valign="top" align="right"><b><? echo $strActivity_LabWeek;?></b></td>
                <td class="main" valign="top" align="right"><b><? echo $strActivity_LabLogin?>(<? echo $logins?>)</b></td>
                <td class="main" valign="top" align="right"><b><? echo $strActivity_LabPost;?>(0)</b></td>
												</tr>
											<?
											$prev_week=0;
											while($act_row=mysql_fetch_array($get_act)){
												if($act_row["weektime"]!=$prev_week){?>
													<tr bgcolor="#D6D6D6">
														
                <td class="main" valign="top" align="right"><? echo $act_row["weektime"]?><br>
                  <?
														$days = $act_row["weektime"]*7;
														echo date ("d/m/Y", mktime (0, 0, 0, 1, $days-3, date("Y")-1))." - ".date ("d/m/Y", mktime (0, 0, 0, 1, $days+3, date("Y")-1));
														?>
                </td>
													<? $post_by_week=mysql_query("SELECT count(id) as contrib_by_week 
																				  FROM ".$tablename." 
																				  WHERE modules=$modules 
																				  		AND users=".$posting_users_row["users"]." 
																						AND week(from_unixtime(time),0)=".$act_row["weektime"].";");
													$login_by_week=mysql_query("SELECT count(id) as login_week 
																				FROM login_modules 
																				WHERE modules=$modules 
																				AND users=".$posting_users_row["users"]." 
																				AND week(from_unixtime(time),0)=".$act_row["weektime"].";");
													if(mysql_num_rows($login_by_week)!=0){?>
														<td class="main" valign="top" align="right"><? echo mysql_result($login_by_week,0,"login_week")?></td>
													<? }else{?>
														<td class="main" valign="top" align="right">0</td>
													<? }
													if(mysql_num_rows($post_by_week)!=0){?>
														<td class="main" valign="top" align="right"><? echo mysql_result($post_by_week,0,"contrib_by_week")?></td>
													<? }else{?>
														<td class="main" valign="top" align="right">0</td>
													<?}?>
													</tr>
											<?		
													$prev_week=$act_row["weektime"];
												}
											}?>
											</table>
										<? }?></td>
								 </tr><?
								//}
							}?>
							</table>
							</td>						
						<?
						//*********************************2
						}
					}else{?>
						<td valign="top" class="main">0</td><?
					}?>
				</tr>
			</table>
		<? }
	}?>
<? }else{?>
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center" background="images/headerbg.gif" height="53">
    <tr>
      <td class="menu" align="center"><b><? echo $strCourses_LabCourseActivity;?> <br>
        <?php echo $strCourses_LabCourseId;?> <? echo mysql_result($get_course,0,"coursename")?></b> </td>
    </tr>
  </table>
<br>
<div class="h3" align="center"><b>No records for this course...</b></div>
<div class="main" align="center">(does it contain any modules?)</div>
<? }?></body>
</html>
