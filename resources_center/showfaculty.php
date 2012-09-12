<?php	 
               require ("../include/global_login.php");
				 //include("../include/check_pass.js");  
				include ("../include/control_win.js");  
				// require ("../include/global_var.inc.php"); 
				
		//$res_Dept = mysql_query("select d.*,f.id as fid from ku_faculty f, ku_department d where f.id = d.FAC_ID   order by f.FAC_NAME,f.id,d.NAME_THAI");
    	//$res_Major = mysql_query("SELECT DISTINCT d.FAC_ID as fid,m.* FROM ku_faculty f, ku_department d, ku_major m where f.id = d.FAC_ID and f.id = m.FAC_ID and m.DEPT_ID = d.id ORDER BY f.FAC_NAME,f.id,d.NAME_THAI,m.NAME_THAI ");
		//		$res_Major = mysql_query("select d.FAC_id as fid,m.* from  ku_department d, ku_major m  where  m.DEPT_ID = d.id and m.FAC_ID = d.FAC_ID order by d.NAME_THAI,m.NAME_THAI");
		
		?>


<html>
<head>
<title>:: Faculty List.. ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">

<SCRIPT LANGUAGE="JavaScript">
function sendValue(id,name){

			window.opener.document.user.fac.value = id;
			window.opener.document.user.facname.value = name;
			//window.opener.document.user.dept.value = -1;
			//window.opener.document.form1.deptname.value = "";
			window.opener.document.user.submit();			
			window.close();
}
</script>

</head>
<body>

<form name="form" method="post" action="showfaculty.php">

  <table cellspacing="1" cellpadding="2" border="0" width="98%" class="tdborder1" align="center">
    <tr align="center" class="lmnbg">
      <td colspan="2" class="bwhite">
     Faculty</td>
    </tr>
    <tr>
  <td width="17%"><b> Search By Campus: </b></td>
      <td width="83%">
	   <select name="campus"  onChange="javascript:form.submit('this');">
	<option value="" >Select Campus</option>
		<option value="" >Select All</option>
	  <? $rs = @mysql_query("select  * from ku_campus  ORDER BY  NAME_THAI" );  
	 	  while($row=mysql_fetch_array($rs)){  ?>
				   <option value="<?=$row[CAMPUS_ID]?>" ><?=$row[NAME_THAI]." : ".$row[NAME_ENG]?></option>
				<?  }?>
				
                </select>

	  </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;      </td>
    </tr>
  </table>
</form>

<table width="98%"  border="0" align="center" cellpadding="5" cellspacing="1"  class="tdborder1">
  <tr class="lmnbg">
    <td valign="top" class="bwhite"> 
      Faculty Name :: </td>
  </tr>
  <?
  $rs3 = @mysql_query("select  * from ku_campus  where CAMPUS_ID='$campus'" );  
  @mysql_result($rs3,0,"NAME_ENG")   ;
  if(@mysql_num_rows($rs3)>0){
  ?>
    <tr>
    <td valign="top" class="bdarkblue"> 
     Campus Of  -> 
	  <?=@mysql_result($rs3,0,"NAME_THAI")." : ".@mysql_result($rs3,0,"NAME_ENG")  ?> </td>
  </tr>
  <? } ?>
  <tr> 
    <td align="center">
	<table width="90%" border="0" cellspacing="1" cellpadding="3" class="tdborder1" align="center">
        <tr align="center" class="lmnbg"> 
          <td width=""  class="bwhite"></td>
          <td width="28%"  class="bwhite">Faculty Name[TH]</td>     
          <td width="28%"  class="bwhite">Faculty Name[EN]</td>
          <td width="28%"  class="bwhite">Campus</td>
         
        </tr>
		<?  
if($campus !='')
			$res_Fac = mysql_query("select k.*,c.NAME_THAI as CNAME_THAI from ku_faculty k, ku_campus c where k.CAMPUS_ID = c.CAMPUS_ID and c.CAMPUS_ID = '$campus' order by FAC_NAME,k.id");
else
			$res_Fac = mysql_query("select k.*,c.NAME_THAI as CNAME_THAI from ku_faculty k, ku_campus c where k.CAMPUS_ID = c.CAMPUS_ID  order by FAC_NAME,k.id");

		$num=0;
		 while($row=mysql_fetch_array($res_Fac)){
					$fullname =  $row["FAC_NAME"]."[".$row["CNAME_THAI"]."]";
					if($num%2==0)  $bg="class=tdbackground3" ;  else  $bg ="bgcolor=#FFFFFF";
					
		?>

        <tr align="center" <?=$bg?>> 
			  <td height="20">
			 <a href=""  onClick="sendValue('<?=$row[id]?>','<?=$fullname?>');"><img src="images/select1.gif" border="0" alt="select">
             </a>			
			  </td> 
			  <td height="20"><?=$row[FAC_NAME] ?></td>
			  <td height="20"><?=$row[NAME_ENG] ?></td>
			  <td><?=$row[CNAME_THAI] ?></td>
             
	    </tr>
		<? $num++;   
		 } // close while?>
		  
<?      if($num==0){  ?>
		      <tr align="center">
          			<td height="20" colspan="5">NOT FOUND DATA</td>
     		   </tr>
		<? }  ?>
      </table>
	
    </td>
  </tr>
</table>
 <br> <center><b><a href="" onClick="window.close();">Close</a></b></center>
</body>
</html>
