<?

$forum=new Forum('',$person["id"],$module,$courses,$info);


if(strlen($info)!=0){
		
		//*********insert modules_history************
		$action="New Forum";
		Imodules_h($module,$action,$person["id"],$courses);
          
       $forum->Insert_forum($forum);

   


}

print("<script language=javascript> top.ws_main.main.location.href='index.php?a=content&module=$module'; </script>");

//header ("location: index.php?a=compose&module=".$module);



?>

<meta http-equiv="refresh" content="0;url=javascript:location.href='index.php?a=compose&module=<? echo $module;?>';">