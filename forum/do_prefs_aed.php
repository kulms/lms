<?
$forum=new Forum($id,$person["id"],$modules,'','');

//if($sendmail=="on"){$sendmail=1;}else{$sendmail=0;}
	
	if($sort=="on"){$sort=1;}else{$sort=0;}
	if($showonline=="on"){$showonline=1;}else{$showonline=0;}
	if($refresh=="on"){$refresh=1;}else{$refresh=0;}
	if($timedelay==0 || $timedelay == ""){$timedelay=5;}
	

	
	if($id==0 || $id==""){
			
			
			
			$forum->Insert_forum_prefs($sort,$showonline,$timedelay,$begin_date,$end_date,$refresh);
			
			}else{
		
		    
     
			$forum->Update_forum_prefs($sort,$showonline,$timedelay,$begin_date,$end_date,$refresh);
		
		
		
	    }
/*
    echo "<script language='javascript'>alert('Update success');location.href='index.php?a=prefs&modules=$modules';</script>";	
*/
?> 
<meta http-equiv="refresh" content="0;url=javascript:window.opener.top.ws_main.main.location.reload();">
<?
	
?>
<title>Update successful !</title>
<style type="text/css">
<!--
a:visited {
	color: #6699FF;
}
a:hover {
	text-decoration: underline;
	color: #FF0000;
}
a:link {
	color: #6699FF;
}
-->
</style>
<div align="center"><font color="#0000FF" size="4"><strong>Update 
  preferrence forum successful</strong></font><br>
  <br>
  <a href="#" onClick="javascript:window.close();"><b> <font size="2" face="MS Sans Serif, Tahoma, sans-serif">Close 
  window</font></b></a></div>
