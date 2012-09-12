<? 
require("../include/global_login.php");
include('classes/config.inc.php');
require("classes/template.class.php");
require("classes/grade.class.php");

//$module_id=$HTTP_COOKIE_VARS['ModuleID'];
setcookie("ModuleID");
$grade=New Grade();
//select quiz
$sql="SELECT m.*,mq.qLIMIT,mq.matching  FROM modules m ,q_module_prefs mq WHERE mq.module_id =m.id AND m.courses=".$g_courses." AND m.modules_type=5 AND mq.grading=1 ";

$result=mysql_query($sql);
$num_quiz=mysql_num_rows($result);
$m_id=array();
while($rs=mysql_fetch_array($result)){
	$name[]=$rs['name'];
	$m_id[]=$rs['id'];
	$q_limit[]=$rs['qLIMIT'];
	$q_mcit[]=$rs['matching'];
	list($modules_type)=$grade->GetModulesType($rs['modules_type']);
	//score
	$maxscore[]=$grade->GetMaxscore($rs['id'],5);
	$m_type[]=$modules_type;
	if($rs['group_id'] !=0){
		list($group_name)=$grade->GetGroup($rs['group_id']);
		$g_name[]=$group_name;
	}else
		$g_name[]="-";
		
} //end while

//select hw
$sql_hw="SELECT m.* FROM modules m  WHERE  m.courses=".$g_courses." AND m.modules_type=7  ";
$result_hw=mysql_query($sql_hw);
$num_hw=mysql_num_rows($result_hw);
while($rs_hw=mysql_fetch_array($result_hw)){
	$name_hw[]=$rs_hw['name'];
	$m_id_hw[]=$rs_hw['id'];
	list($modules_type)=$grade->GetModulesType($rs_hw['modules_type']);
	$m_type_hw[]=$modules_type;
	if($rs_hw['group_id'] !=0){
		list($group_name)=$grade->GetGroup($rs_hw['group_id']);
		$g_name_hw[]=$group_name;
	}else
		$g_name_hw[]="-";
	//score
	$sql_score_hw="SELECT sum(points) as score  FROM homework WHERE modules=".$rs_hw['id']."";
	$result_score_hw=mysql_query($sql_score_hw);
	while($rs_score_hw=mysql_fetch_array($result_score_hw)){
		$score_hw[]=$rs_score_hw['score'];
	}
	//echo mysql_result($result_hw,0,'score');
} //end while

//select score_type_id

if($id !=""){
	$sql="SELECT * FROM g_score_type WHERE q_score_type_id = $id ";
	$module_id=$mid;
}else{
	$module_id=$module_id;
}

//====================Template=========================
$template= new Template(C_SKIN);	
$template->set_filenames(array('body' =>'sel_module.html',
																));
$template->assign_vars(array('Theme'=>$theme,
															'Form'=>$form,
															'H_Module'=>$strGrade_HeadListModule,
															'M_No'=>$strGrade_LabNo,
															'M_name'=>$strGrade_ModuleName,
															'M_Cate'=>$strGrade_LabType,
															'M_Group'=>$strGrade_LabGroup,
															'M_Totalscore'=>$strGrade_ModuleTotalscore, 
															'Btn_Submit'=>$strSubmit 
															//'Module_ID'=>$module_id,
												));

//list quiz
for($i=0;$i<$num_quiz;$i++){
	$template->assign_block_vars('list_quiz', array('NAME'=>$name[$i],
																								'M_ID'=>$m_id[$i],
																								'M_TYPE'=>$m_type[$i],
																								'GROUP'=>$g_name[$i],
																							   'IS_SELECT'=>($module_id==$m_id[$i])?"checked":"",
																								'SCORE'=>($maxscore[$i] == "")?"-":number_format($maxscore[$i],2,''.'',"."),
																));
}

//list_hw
for($ii=0;$ii<$num_hw;$ii++){
	$template->assign_block_vars('list_hw', array('NAME'=>$name_hw[$ii],
																								'M_ID'=>$m_id_hw[$ii],
																								'M_TYPE'=>$m_type_hw[$ii],
																								'GROUP'=>$g_name_hw[$ii],
																								'SCORE'=>($score_hw[$ii] == "")?"-":number_format($score_hw[$ii],2,''.'',"."),
																								'IS_SELECT'=>($module_id==$m_id_hw[$ii])?"checked":"",
																));
}
$template->pparse('body');
?>