<?
require("../include/global_login.php");

$users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
?>
<html>
<head>
<script type="text/javascript" language="JavaScript" src="../createlogin/AutoSelect.js"></script>
<script language="JavaScript">
	function BrowserInfo()
	{	  this.screenWidth = screen.availWidth;
		  this.screenHeight = screen.availHeight;
	}
</script>
<script language="javascript">
	 //generate array for filling in select box
				var obj1 = new Array();	// fac
				var obj2 = new Array();	// dept
				var obj3 = new Array(); // major
<?      
		$res_Fac = mysql_query("select k.*,c.NAME_THAI as CNAME_THAI from ku_faculty k, ku_campus c where k.CAMPUS_ID = c.CAMPUS_ID order by FAC_NAME,k.id");

		$res_Dept = mysql_query("select d.*,f.id as fid from ku_faculty f, ku_department d where f.id = d.FAC_ID   order by f.FAC_NAME,f.id,d.NAME_THAI");

    	$res_Major = mysql_query("SELECT DISTINCT d.FAC_ID as fid,m.* FROM ku_faculty f, ku_department d, ku_major m where f.id = d.FAC_ID and f.id = m.FAC_ID and m.DEPT_ID = d.id ORDER BY f.FAC_NAME,f.id,d.NAME_THAI,m.NAME_THAI ");

		while($row=mysql_fetch_array($res_Fac))
		{
			echo("obj1[obj1.length]=new OBJ1st('".$row["FAC_NAME"]." (".$row["CNAME_THAI"].")','".$row["id"]."'); \n");
		}		
		while($row1=mysql_fetch_array($res_Dept))
		{
			echo("obj2[obj2.length]=new OBJ2nd('".$row1["fid"]."','".$row1["NAME_THAI"]." (".$row1["DEPT_ID"]." ) ','".$row1["id"]."'); \n");
		}	
			
		while($row2=mysql_fetch_array($res_Major))
		{
			echo("obj3[obj3.length]=new OBJ3rd('".$row2["fid"]."','".$row2["DEPT_ID"]."','".$row2["NAME_THAI"]." (".$row2["MAJOR_ID"].")','".$row2["id"]."'); \n");
		} 					
	?>
	  function selectChange(control, controlToPopulate)
      {
                        // Empty the second drop down box of any choices
                        for (var q=controlToPopulate.options.length;q>=0;q--)
                        {
                                controlToPopulate.options.remove(1);
                        }

                        if (control.name == "fac")
                         {       // Empty the third drop down box of any choices
                                 for (var q=user.major.options.length;q>=0;q--)
                                           user.major.options.remove(1);
                         }
    }
</script>
<title>Resources</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=tis-620"></head>
<body bgcolor="#ffffff">
<div align="center"><br>
  <table border="0" cellpadding="0" cellspacing="0" width="60%">
    <tr> 
      <td class="res" width="464"><img src="../images/resources.gif" width=20 height=16
alt="" border="0" align="top"> E-Courseware Center</td>
      <!--<td class="res" width="1"><a href="edit.php?modules=144&id=0&folder=true">-->
	  <td class="res" width="1"><a href="edit.php?id=0&folder=true"> </a> </td>
    </tr>
    <tr>
      <td class="res" colspan="2">&nbsp; </td>
    </tr>
  </table>
  <table width="80%">
    <tr>
      <td>

	  <form action="show_res.php" method="post" name="user">

          <table align="center" width="579">
			  <?
					if($person["category"]==2){
			  ?>            
		    <?	 }	 ?>
            <tr> 
              <td width="88" align="right" class="res"><b>คณะ :</b></td>
              <td width="479" class="main"> <select name="fac" onclick="manage_2nd(document.forms('user').dept,
		document.forms('user').fac.value);"  onChange="selectChange(this, user.dept);" style="font-size:10px">
                  <option value="-1"> -------------------------------- เลือกคณะ 
                  --------------------------------------- </option>
                  <script language = "javascript">Add1stSelect(document.forms('user').fac);</script>
                </select>
                <? 
				if (@mysql_result($users,0,"id")!=none && @mysql_result($users,0,"id")!="") 
				{			$fac = @mysql_result($users,0,"id");
					if($fac)
					{
						$tmpFact =" <script language= \"javascript\">
						  function selFac()
							{
								document.forms('user').fac.value=\"".$fac."\";
								manage_2nd(document.forms('user').dept,\"".$fac."\");
							}
							</script>";
					}
				}   ?>
              </td>
            </tr>
            <?	if($tmpFact !="")					
				echo $tmpFact;
			else
				echo ("<script language= \"javascript\">
						  function selFac()
							{
							}
							</script>");
?>
            <tr> 
              <td class="res" align="right"><b> ภาควิชา :</b></td>
              <td class="main"><font color="#CCCC00"> 
                <select name="dept"  onclick="manage_3rd(document.forms('user').major,
			document.forms('user').dept.value,
			document.forms('user').fac.value);" onChange="selectChange(this, user.major);" style="font-size:10px">
                  <option value="-1"> -------------------------------- เลือกภาควิชา 
                  ----------------------------------- </option>
                </select>
                <?
				if(@mysql_result($users,0,"dept_id")!=none && @mysql_result($users,0,"dept_id")!="")
				{	$dept = @mysql_result($users,0,"dept_id");
					if($dept)
					{
						$tmpDept =" <script language= \"javascript\">
						  function selDept()
							{
								document.forms('user').dept.value=\"".$dept."\";
										manage_3rd(document.forms('user').major,\"".$dept."\",\"".$fac."\");
							}
							</script>";
					}
				}   ?>
                </font></td>
            </tr>
            <?	 if($tmpDept!="")
				echo($tmpDept);
	     else
				echo ("<script language= \"javascript\">
					  function selDept()
						{
						}
						</script>");
	?>
            <tr> 
              <td class="res" align="right"><b>สาขาวิชา :</b></td>
              <td class="main"> <select name="major" style="font-size:10px">
                  <option value="no"> ------------------------------- เลือกสาขาวิชา 
                  ----------------------------------- </option>
                </select> 
                <?  
				if(@mysql_result($users,0,"major_id")!=none && @mysql_result($users,0,"major_id")!="")
				{	$major = @mysql_result($users,0,"major_id");
					if($major)
					{
						$tmpMajor =" <script language= \"javascript\">
						  function selMajor()
							{
								document.forms('user').major.value=\"".$major."\";							
							}
							</script>";
					}
				} 	 ?>
              </td>
            </tr>
            <tr>
              <td>&nbsp; </td>
              <td class="info">&nbsp; &nbsp; &nbsp; <font color="red"><b>***</b></font> 
                <b>หากไม่เลือกจะแสดงทั้งหมด</b><font color="red"> <b>***</b></font></td>
            </tr>
            <tr>
			              
              <td  align="center" >&nbsp; </td>

              <td  > 
			  <input type="submit" name="subm" value="Submit"> 
                 </td>
            </tr>
          </table>
		  <input name="user" type="hidden" value="<? echo $user;?>">
  	  <input name="modules" type="hidden" value="<? echo $modules;?>">
	  <input name="res_id" type="hidden" value="<? echo $res_id;?>">
	  <input name="isedit" type="hidden" value="<? echo $isedit;?>">
      <input name="folders" type="hidden" value="<? echo $folders;?>">
	  <input name="courses" type="hidden" value="<? echo $courses;?>">
      </form>
	  </td>
    </tr>
  </table>
</div>
</body>
</html>