<? 
/***************************************************************************
 *   script					: Location (city.php)
 *   copyright            : (C) 2004 Phenomena
 *   website				: www.pheno_datacenter.com
 *   create					: 1 July 2004
 *   update					: 1 July 2004
 ***************************************************************************/
include('include/LOC_config.inc.php');
include(C_ROOT_DIR.'mainmenu.php');
include('include/config_db.inc.php');
include('include/func_qlocation.inc.php');
include('include/func_location.inc.php');


//----------Query -----------------------------------------------------------------------//
list($CategoryID,$CategoryName,$keyword_id,$keyword_name)=Keyword_List($cat);
$num_key=count($keyword_id);

//list keyword
list($CatID,$CatName,$KeywordName)=Keyword_ListAll();

//-------------------------------------------------------------------------------------------//

//====================================================//
include C_ROOT_URL."location/loc_header.php?menu_id=".$menu_id;

$template= new Template(C_SKIN);
$template->set_filenames(array('body' =>T_LOC_KEYWORD));

$template->assign_vars(array('STYLESHEET' => C_STYLESHEET_ADMIN,
															'LOC_EXEC_LOC_KEYWORD'=>C_EXEC_LOC_KEYWORD,
															'LOC_LOC_CAT'=>C_LOC_CAT,
													//		'JP_LIST_JOBPROFILE'=>C_LIST_JOBPROFILE,
															'CATEGORY_NAME'=>$CategoryName,
															'CATEGORY_ID'=>$CategoryID,
															'COUNT'=>$num_key,
															'COUNT_KEY'=>count($CatName),
															));

for ($i=0;$i<$num_key;$i++)
		{
			$template->assign_block_vars('subcategory', array(
																			'ID' => $i+1,
																			'SUBCATEGORY_ID' => $keyword_id[$i],
																			'SUBCATEGORY_NAME' => $keyword_name[$i],
																			'CHK_ID' => $i
																		));
		}


//--list keyword all
for($i=0;$i<count($KeywordName);$i++)
{			
			$template->assign_block_vars('keyword', array(
																			'KEYWORD_NAME' => $KeywordName[$i],
																			'CAT_NAME'=>$CatName[$i],
																			'NUM'=>$i,
																		));
}


if($error!=null)
	$template->assign_vars(array( 'ERROR'=>$errorCode[$error],
																	));	

$template->pparse('body');

//====================================================//
?>