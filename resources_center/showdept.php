<?php	 
               require ("../include/global_login.php");
				 //include("../include/check_pass.js");  
				include ("../include/control_win.js");  
				// require ("../include/global_var.inc.php"); 
				
				
				//echo $facid;
		//$res_Fac = mysql_query("select k.*,c.NAME_THAI as CNAME_THAI from ku_faculty k, ku_campus c where k.CAMPUS_ID = c.CAMPUS_ID order by FAC_NAME,k.id");
		$res_Dept = @mysql_query("select d.*,f.id as fid,f.FAC_NAME  from ku_faculty f, ku_department d where f.id = '$facid'  AND d.FAC_ID = '$facid'  order by f.FAC_NAME,f.id,d.NAME_THAI");
//echo $facid;
				//$res_Dept = @mysql_query("select d.*,f.id as fid,f.FAC_NAME  from ku_faculty f, ku_department d order by f.FAC_NAME,f.id,d.NAME_THAI");

    	//$res_Major = mysql_query("SELECT DISTINCT d.FAC_ID as fid,m.* FROM ku_faculty f, ku_department d, ku_major m where f.id = d.FAC_ID and f.id = m.FAC_ID and m.DEPT_ID = d.id ORDER BY f.FAC_NAME,f.id,d.NAME_THAI,m.NAME_THAI ");
		//		$res_Major = mysql_query("select d.FAC_id as fid,m.* from  ku_department d, ku_major m  where  m.DEPT_ID = d.id and m.FAC_ID = d.FAC_ID order by d.NAME_THAI,m.NAME_THAI");
		
		?>


<html>
<head>
<title>:: Department List.. ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">

<SCRIPT LANGUAGE="JavaScript">
function sendValue(id,name){
			window.opener.document.user.dept.value = id;
			window.opener.document.user.deptname.value = name;
			window.opener.document.user.submit();
			window.close();
}
</script>

</head>
<body>



<table width="98%"  border="0" align="center" cellpadding="5" cellspacing="1"  class="tdborder1">
  <tr class="lmnbg">
    <td valign="top" class="bwhite"> 
      Department Of  
	   <? //$rs = mysql_query("select  FAC_NAME,NAME_ENG  from ku_faculty  where id='$facid'");
	   //echo mysql_result($rs,0,"NAME_ENG");
	  //echo " [".mysql_result($rs,0,"FAC_NAME")."]";    ?> &nbsp;::  
	  </td>
  </tr>
  <tr> 
    <td align="center">
	<table width="85%" border="0" cellspacing="1" cellpadding="3" class="tdborder1" align="center">
        <tr align="center" class="lmnbg"> 
          <td width=""  class="bwhite"></td>
          <td width="28%"  class="bwhite">Department Name[TH]</td>    
          <td width="28%"  class="bwhite">Department Name[EN]</td>
          <td width="28%"  class="bwhite">Faculty</td>
         
        </tr>
		<?
		$num=0;
		 while($row=mysql_fetch_array($res_Dept)){
					
					if($num%2==0)  $bg="class=tdbackground3" ;  else  $bg ="bgcolor=#FFFFFF";
					
		?>

        <tr align="center" <?=$bg?>> 
			  <td height="20">
			 <a href=""  onClick="sendValue('<?=$row[id]?>','<?=$row[NAME_THAI]?>');"><img src="images/select1.gif" border="0" alt="select">
             </a>			
			  </td> 
			  <td height="20"><?=$row[NAME_THAI] ?></td>
			  <td align="center"><?=$row[NAME_ENG] ?></td>
               <td height="20"><?=$row[FAC_NAME] ?></td> 
	    </tr>
		<? $num++;   
		 } // close while?>
		  
<?      if($num==0){  ?>
		      <tr align="center">
          			<td height="20" colspan="5">NOT FOUND</td>
	    </tr>
		<? }  ?>
      </table>
	
    </td>
  </tr>
</table>
 <br> <center><b><a href="" onClick="window.close();">Close</a></b></center>
</body>
</html>