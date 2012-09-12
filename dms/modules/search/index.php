<?php  
@include_once( $user->getModuleClass( $realpath, 'book') );
@include_once( $user->getModuleClass( $realpath, 'research') );
@include_once( $user->getModuleClass( $realpath, 'publication') );
@include_once( $user->getModuleClass( $realpath, 'search') );

$book = new Book('', $user->getUserId(), $user->getFirstName()." ".$user->getLastName(),'', '', '', '', 
				 '', '', '', '', '', '',
				 '', '', '', '', ''
				 );
$research = new Research('', $user->getUserId(), $user->getFirstName()." ".$user->getLastName(), '', '', '', '', '', 
						'', '', '', '', '', '', '',
						'', '', '', '', '', '',
						'', '', '', '', ''
						);						
$obj = new Journal('', $user->getUserId(), $user->getFirstName()." ".$user->getLastName(),'', '', '', '',
									'', '', '', '', '', '', ''
					);						
				 			
$search = new Search();	
?>
<script language='javascript' src='<? echo "./modules/search";?>/popcalendar.js'></script>
<script language='javascript' src='<? echo "./modules/search";?>/AutoSelect.js'></script>
<script language="javascript">
	 //generate array for filling in select box
	var obj1 = new Array();	// fac
	var obj2 = new Array();	// dept
	var a;	
	<?php	
		$res_Fac = mysql_query("select k.*,c.NAME_ENG as CNAME_THAI from ku_faculty k, ku_campus c where k.CAMPUS_ID = c.CAMPUS_ID order by FAC_NAME,k.id");
		$res_Dept = mysql_query("select d.* from ku_faculty f, ku_department d, ku_campus c where d.FAC_ID = f.id AND f.CAMPUS_ID = c.CAMPUS_ID order by d.NAME_THAI;");		
		$res_Dept2 = mysql_query("select distinct d.* from ku_faculty f, ku_department d, ku_campus c where d.FAC_ID = f.id AND f.CAMPUS_ID = c.CAMPUS_ID order by d.NAME_THAI");		   

		while($row=mysql_fetch_array($res_Fac))
		{
			echo("obj1[obj1.length]=new OBJ1st('".$row["FAC_NAME"]." (".$row["CNAME_THAI"].")','".$row["id"]."'); \n");
		}				
		while($row1=mysql_fetch_array($res_Dept))
		{			
			echo("obj2[obj2.length]=new OBJ2nd('".$row1["FAC_ID"]."','".$row1["NAME_THAI"]." (".$row1["DEPT_ID"]." ) ','".$row1["id"]."'); \n");			
		}		
		$i=mysql_num_rows($res_Dept2);
		echo("a=$i;");
	?>
	//document.write(a);
		function selectChange(control, controlToPopulate)
		  {  
			// Empty the second drop down box of any choices
			for (var q=controlToPopulate.options.length;q>=0;q--) 
			{		
				controlToPopulate.options.remove(1);
			}
			if (control.name == "fac")
			 {    // Empty the third drop down box of any choices					
			 }
		  }
</script>
<script language="javascript"> 
function displayCB() { 
	switch (document.all.dropdown.selectedIndex) { 
	case 0:
		  document.all.area.innerHTML = "";	
		  break;
	case 2: 		  
		  document.all.area.innerHTML = "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
										"<tr>"+
										"<td width=\"50%\"></td>"+
										"<td width=\"50%\"></td>"+
										"</tr>"+
										"</table>"+
										"<table cellspacing=\"0\" cellpadding=\"4\" border=\"0\" width=\"100%\" class=\"std\">"+
										"<form name=\"SearchResearchFrm\" action=\"./index.php?m=search\" method=\"post\">"+
										"<input type=\"hidden\" name=\"dosql\" value=\"do_search\" />"+
										"<input type=\"hidden\" name=\"search_type\" value=\"research\" />"+
										"<tr>"+
      									"<td colspan=\"2\" valign=\"top\" class=\"hilite\">"+
										"<input class=\"button\" type=\"submit\" name=\"btnFuseAction\" value=\"search\" /> "+										
										"<input class=\"button\" type=\"button\" name=\"cancel\" value=\"cancel\" onClick=\"javascript:if(confirm(\'Are you sure you want to cancel.\')){location.href = \'./index.php?m=search\';}\" /> "+
										"</td>"+
					    				"</tr>"+
										"<tr>"+
										"<td width=\"50%\" valign=\"top\">"+
										"<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\">"+
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Research Name Thai</td>"+
										"<td width=\"100%\"><input type=\"text\" name=\"research_name_th\" value=\"\" size=\"40\" maxlength=\"80\" class=\"text\" />"+ 
										"</td>"+
										"</tr>"+
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Research Name English</td>"+
										"<td width=\"100%\"> <input type=\"text\" name=\"research_name_eng\" value=\"\" size=\"40\" maxlength=\"80\" class=\"text\" />"+ 
										"</td>"+
									  	"</tr>"+
									  	"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Research Owner</td>"+
										"<td>"+ 
										"<input type=\"text\" name=\"research_owner_name\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\"/>"+			  
										"</td>"+
										"<tr>"+ 
									    "<td align=\"right\" nowrap=\"nowrap\">Research Status</td>"+
  									    "<td width=\"100%\" nowrap=\"nowrap\"> <input type=\"radio\" name=\"research_status\" value=\"1\">"+
									    "ยังไม่เสร็จ"+ 
									    "<input type=\"radio\" name=\"research_status\" value=\"2\">"+
									    "เสร็จแล้ว"+ 									    
									    "</tr>"+                            
										"</table>"+
										"</td>"+
										"<td width=\"50%\" valign=\"top\">"+
										"<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" width=\"100%\">"+ 										  
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Research ISBN</td>"+
										"<td nowrap=\"nowrap\"><input type=\"text\" name=\"research_isbn\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\" /></td>"+
										"</tr>"+
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Research Year</td>"+
										"<td width=\"100%\" nowrap=\"nowrap\"><input type=\"text\" name=\"research_year\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\" />"+ 
										"</td>"+
										"</tr>"+          
										"<tr>"+          
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Keyword</td>"+
										"<td colspan=\"3\"><textarea name=\"research_keyword\" cols=\"40\" rows=\"5\" wrap=\"virtual\" class=\"textarea\" /></textarea> "+   
										"</td>"+
										"</tr>"+          
										"</table>"+
										"</td>"+										
										"</tr>"+
										"<tr>"+
										"<td>"+										
										"</td>"+
										"<td align=\"left\">"+										
										"</td>"+
										"</tr>"+										
										"</form>"+
										"</table>";
										
		break; 
	case 3: 
		//document.all.area.innerHTML = "<input type=\"checkbox\" name=\"cb4\" value=\"doc\">doc<br><input type=\"checkbox\" name=\"cb5\" value=\"pdf\">pdf"; 
		document.all.area.innerHTML = "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
									  "<tr>"+
									  "<td width=\"50%\"></td>"+
									  "</tr>"+
									  "</table>"+
									  "<table cellspacing=\"0\" cellpadding=\"4\" border=\"0\" width=\"100%\" class=\"std\">"+
									  "<form name=\"editFrm\" action=\"./index.php?m=search\" method=\"post\">"+
									  "<input type=\"hidden\" name=\"dosql\" value=\"do_search\" />"+
									  "<input type=\"hidden\" name=\"search_type\" value=\"publication\" />"+
									  "<tr>"+
      								  "<td colspan=\"2\" valign=\"top\" class=\"hilite\">"+
									  "<input class=\"button\" type=\"submit\" name=\"btnFuseAction\" value=\"search\" /> "+										
									  "<input class=\"button\" type=\"button\" name=\"cancel\" value=\"cancel\" onClick=\"javascript:if(confirm(\'Are you sure you want to cancel.\')){location.href = \'./index.php?m=search\';}\" /> "+
									  "</td>"+
					    			  "</tr>"+									  																			  
									  "<tr>"+
									  "<td width=\"50%\" valign=\"top\">"+
									  "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\">"+
									  "<tr>"+ 
									  "<td align=\"right\" nowrap=\"nowrap\">Publication Type</td>"+
									  "<td width=\"100%\" align=\"left\">"+									  																		  									  
									  "<select name=\"type\" style=\"font-size:10px\">"+
            						  "<option value=\"0\">- Select Item -</option>"+
									  "<option value=\"1\">Journal</option>"+
									  "<option value=\"2\">Proceeding</option>"+
									  "<option value=\"3\">Presentation</option>"+			
								      "</select>"+ 
									  "</td>"+ 
									  "</tr>"+
									  "<tr>"+ 
									  "<td align=\"right\" nowrap=\"nowrap\">Publication Name Thai</td>"+
									  "<td width=\"100%\"><input type=\"text\" name=\"name_th\" value=\"\" size=\"40\" maxlength=\"80\" class=\"text\" />"+
									  "</td>"+
									  "</tr>"+
									  "<tr>"+ 
									  "<td align=\"right\" nowrap=\"nowrap\">Publication Name English</td>"+
									  "<td width=\"100%\"> <input type=\"text\" name=\"name_eng\" value=\"\" size=\"40\" maxlength=\"80\" class=\"text\" />"+ 
									  "</td>"+
									  "</tr>"+		  			
									  "<tr>"+ 
									  "<td align=\"right\" nowrap=\"nowrap\">Publication Owner</td>"+				
									  "<td>"+ 
									  "<input type=\"text\" name=\"owner_name\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\" />"+
									  "</td>"+
									  "</tr>"+						  
								      "</table>"+
									  "</td>"+
									  "<td width=\"50%\" valign=\"top\">"+
									  "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" width=\"100%\">"+
									  "<tr>"+ 
									  "<td align=\"right\" nowrap=\"nowrap\">Publication Category</td>"+
  									  "<td width=\"100%\" nowrap=\"nowrap\"> <input type=\"radio\" name=\"category\" value=\"1\">"+
									  "International"+ 
									  "<input type=\"radio\" name=\"category\" value=\"2\">"+
									  "National"+ 
									  "<input type=\"radio\" name=\"category\" value=\"3\">"+
									  "Other </td>"+
									  "</tr>"+
									  "<tr>"+ 
									  "<td align=\"right\" nowrap=\"nowrap\">Publication Year</td>"+
									  "<td nowrap=\"nowrap\"><input type=\"text\" name=\"year\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\" /></td>"+
								  	  "</tr>"+
								      "<tr>"+ 
									  "<td align=\"right\" nowrap=\"nowrap\">ISSN (for journal)</td>"+
									  "<td nowrap=\"nowrap\"><input type=\"text\" name=\"issn\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\" /></td>"+
								  	  "</tr>"+
								  	  "</table>"+
									  "</td>"+
									  "</tr>"+
									  "<tr>"+
									  "<td>"+									  
									  "</td>"+
									  "<td align=\"left\">"+									  
									  "</td>"+
								      "</tr>"+
								      "</form>"+
							          "</table>";
		break; 
	case 4: 
		//document.all.area.innerHTML = "<input type=\"checkbox\" name=\"cb4\" value=\"doc\">doc<br><input type=\"checkbox\" name=\"cb5\" value=\"pdf\">pdf"; 
		document.all.area.innerHTML = "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
										"<tr>"+
										"<td width=\"50%\"></td>"+
										"<td width=\"50%\"></td>"+
										"</tr>"+
										"</table>"+
										"<table cellspacing=\"0\" cellpadding=\"4\" border=\"0\" width=\"100%\" class=\"std\">"+
										"<form name=\"SearchResearchFrm\" action=\"./index.php?m=search\" method=\"post\">"+
										"<input type=\"hidden\" name=\"dosql\" value=\"do_search\" />"+
										"<input type=\"hidden\" name=\"search_type\" value=\"book\" />"+
									    "<tr>"+
      									"<td colspan=\"2\" valign=\"top\" class=\"hilite\">"+
										"<input class=\"button\" type=\"submit\" name=\"btnFuseAction\" value=\"search\" /> "+										
										"<input class=\"button\" type=\"button\" name=\"cancel\" value=\"cancel\" onClick=\"javascript:if(confirm(\'Are you sure you want to cancel.\')){location.href = \'./index.php?m=search\';}\" /> "+
										"</td>"+
					    				"</tr>"+										
										"<tr>"+
										"<td width=\"50%\" valign=\"top\">"+
										"<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\">"+
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Book Name Thai</td>"+
										"<td width=\"100%\"><input type=\"text\" name=\"book_name_th\" value=\"\" size=\"40\" maxlength=\"80\" class=\"text\" />"+ 
										"</td>"+
										"</tr>"+
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Book Name English</td>"+
										"<td width=\"100%\"> <input type=\"text\" name=\"book_name_eng\" value=\"\" size=\"40\" maxlength=\"80\" class=\"text\" />"+ 
										"</td>"+
									  	"</tr>"+
									  	"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Book Owner</td>"+
										"<td>"+ 
										"<input type=\"text\" name=\"book_owner_name\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\"/>"+			  
										"</td>"+                         
										"</table>"+
										"</td>"+
										"<td width=\"50%\" valign=\"top\">"+
										"<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" width=\"100%\">"+       
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Book ISBN</td>"+
										"<td nowrap=\"nowrap\"><input type=\"text\" name=\"book_isbn\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\" /></td>"+
										"</tr>"+
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Book Year</td>"+
										"<td width=\"100%\" nowrap=\"nowrap\"><input type=\"text\" name=\"book_year\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\" />"+ 
										"</td>"+
										"</tr>"+          
										"<tr>"+          
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Keyword</td>"+
										"<td colspan=\"3\"><textarea name=\"book_keyword\" cols=\"40\" rows=\"5\" wrap=\"virtual\" class=\"textarea\" /></textarea> "+ 
										"</td>"+
										"</tr>"+          
										"</table>"+
										"</td>"+										
										"</tr>"+
										"<tr>"+
										"<td>"+										
										"</td>"+
										"<td align=\"left\">"+										
										"</td>"+
										"</tr>"+
										"</form>"+
										"</table>";
		break;
	case 5: 		  
		  document.all.area.innerHTML = "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
										"<tr>"+
										"<td width=\"50%\"></td>"+
										"<td width=\"50%\"></td>"+
										"</tr>"+
										"</table>"+
										"<table cellspacing=\"0\" cellpadding=\"4\" border=\"0\" width=\"100%\" class=\"std\">"+
										"<form name=\"SearchResearchFrm\" action=\"./index.php?m=search\" method=\"post\">"+
										"<input type=\"hidden\" name=\"dosql\" value=\"do_search\" />"+
										"<input type=\"hidden\" name=\"search_type\" value=\"thesis\" />"+
										"<tr>"+
      									"<td colspan=\"2\" valign=\"top\" class=\"hilite\">"+
										"<input class=\"button\" type=\"submit\" name=\"btnFuseAction\" value=\"search\" /> "+										
										"<input class=\"button\" type=\"button\" name=\"cancel\" value=\"cancel\" onClick=\"javascript:if(confirm(\'Are you sure you want to cancel.\')){location.href = \'./index.php?m=search\';}\" /> "+
										"</td>"+
					    				"</tr>"+										
										"<tr>"+
										"<td width=\"50%\" valign=\"top\">"+
										"<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\">"+
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Name Thai</td>"+
										"<td width=\"100%\"><input type=\"text\" name=\"thesis_name_th\" value=\"\" size=\"40\" maxlength=\"80\" class=\"text\" />"+ 
										"</td>"+
										"</tr>"+
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Name English</td>"+
										"<td width=\"100%\"> <input type=\"text\" name=\"thesis_name_eng\" value=\"\" size=\"40\" maxlength=\"80\" class=\"text\" />"+ 
										"</td>"+
									  	"</tr>"+
									  	"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Owner</td>"+
										"<td>"+ 
										"<input type=\"text\" name=\"thesis_owner_name\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\"/>"+			  
										"</td>"+ 
										"<tr>"+ 
									    "<td align=\"right\" nowrap=\"nowrap\">Type</td>"+
  									    "<td width=\"100%\" nowrap=\"nowrap\"> <input type=\"radio\" name=\"thesis_type\" value=\"1\">"+
									    "Thesis"+ 
									    "<input type=\"radio\" name=\"thesis_type\" value=\"2\">"+
									    "Independant Study"+ 									    
									    "</tr>"+                          
										"</table>"+
										"</td>"+
										"<td width=\"50%\" valign=\"top\">"+
										"<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" width=\"100%\">"+      
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">ISBN</td>"+
										"<td nowrap=\"nowrap\"><input type=\"text\" name=\"thesis_isbn\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\" /></td>"+
										"</tr>"+
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Year</td>"+
										"<td width=\"100%\" nowrap=\"nowrap\"><input type=\"text\" name=\"thesis_year\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\" />"+ 
										"</td>"+										
										"</tr>"+										            										      
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Keyword</td>"+
										"<td colspan=\"3\"> <textarea name=\"thesis_keyword\" cols=\"40\" rows=\"5\" wrap=\"virtual\" class=\"textarea\" /></textarea> "+ 
										"</td>"+
										"</tr>"+
										"</table>"+
										"</td>"+										
										"</tr>"+
										"<tr>"+
										"<td>"+
										"</td>"+
										"<td align=\"left\">"+										
										"</td>"+
										"</tr>"+
										"</form>"+
										"</table>";
										
		break;
	case 6:
		  document.all.area.innerHTML = "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
										"<tr>"+
										"<td width=\"50%\"></td>"+
										"<td width=\"50%\"></td>"+
										"</tr>"+
										"</table>"+
										"<table cellspacing=\"0\" cellpadding=\"4\" border=\"0\" width=\"100%\" class=\"std\">"+
										"<form name=\"SearchResearchFrm\" action=\"./index.php?m=search\" method=\"post\">"+
										"<input type=\"hidden\" name=\"dosql\" value=\"do_search\" />"+
										"<input type=\"hidden\" name=\"search_type\" value=\"project\" />"+
										"<tr>"+
      									"<td colspan=\"2\" valign=\"top\" class=\"hilite\">"+
										"<input class=\"button\" type=\"submit\" name=\"btnFuseAction\" value=\"search\" /> "+										
										"<input class=\"button\" type=\"button\" name=\"cancel\" value=\"cancel\" onClick=\"javascript:if(confirm(\'Are you sure you want to cancel.\')){location.href = \'./index.php?m=search\';}\" /> "+
										"</td>"+
					    				"</tr>"+
										"<tr>"+
										"<td width=\"50%\" valign=\"top\">"+
										"<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\">"+
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Project Name Thai</td>"+
										"<td width=\"100%\"><input type=\"text\" name=\"project_name_th\" value=\"\" size=\"40\" maxlength=\"80\" class=\"text\" />"+ 
										"</td>"+
										"</tr>"+
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Project Name English</td>"+
										"<td width=\"100%\"> <input type=\"text\" name=\"project_name_eng\" value=\"\" size=\"40\" maxlength=\"80\" class=\"text\" />"+ 
										"</td>"+
									  	"</tr>"+
									  	"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Project Owner</td>"+
										"<td>"+ 
										"<input type=\"text\" name=\"project_owner_name\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\"/>"+			  
										"</td>"+                         
										"</table>"+
										"</td>"+
										"<td width=\"50%\" valign=\"top\">"+
										"<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" width=\"100%\">"+      
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Project ISBN</td>"+
										"<td nowrap=\"nowrap\"><input type=\"text\" name=\"project_isbn\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\" /></td>"+
										"</tr>"+
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Project Year</td>"+
										"<td width=\"100%\" nowrap=\"nowrap\"><input type=\"text\" name=\"project_year\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\" />"+ 
										"</td>"+
										"</tr>"+          
										"<tr>"+          
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Keyword</td>"+
										"<td colspan=\"3\"> <textarea name=\"project_keyword\" cols=\"40\" rows=\"5\" wrap=\"virtual\" class=\"textarea\" /></textarea> "+ 
										"</td>"+
										"</tr>"+          
										"</table>"+
										"</td>"+
										"</tr>"+
										"<tr>"+
										"<td>"+
										"</td>"+
										"<td align=\"left\">"+										
										"</td>"+
										"</tr>"+
										"</form>"+
										"</table>";
										
		break; 	
	case 1: 		  
		  document.all.area.innerHTML = "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
										"<tr>"+
										"<td width=\"50%\"></td>"+
										"<td width=\"50%\"></td>"+
										"</tr>"+
										"</table>"+
										"<table cellspacing=\"0\" cellpadding=\"4\" border=\"0\" width=\"100%\" class=\"std\">"+
										"<form name=\"SearchResearchFrm\" action=\"./index.php?m=search\" method=\"post\">"+
										"<input type=\"hidden\" name=\"dosql\" value=\"do_search\" />"+
										"<input type=\"hidden\" name=\"search_type\" value=\"all\" />"+
										"<tr>"+
      									"<td colspan=\"2\" valign=\"top\" class=\"hilite\">"+
										"<input class=\"button\" type=\"submit\" name=\"btnFuseAction\" value=\"search\" /> "+										
										"<input class=\"button\" type=\"button\" name=\"cancel\" value=\"cancel\" onClick=\"javascript:if(confirm(\'Are you sure you want to cancel.\')){location.href = \'./index.php?m=search\';}\" /> "+
										"</td>"+
					    				"</tr>"+										
										"<tr>"+
										"<td width=\"50%\" valign=\"top\">"+
										"<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\">"+
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Search All Name Thai</td>"+
										"<td width=\"100%\"><input type=\"text\" name=\"name_th\" value=\"\" size=\"40\" maxlength=\"80\" class=\"text\" />"+ 
										"</td>"+
										"</tr>"+
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Name English</td>"+
										"<td width=\"100%\"> <input type=\"text\" name=\"name_eng\" value=\"\" size=\"40\" maxlength=\"80\" class=\"text\" />"+ 
										"</td>"+
									  	"</tr>"+
									  	"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Owner</td>"+
										"<td>"+ 
										"<input type=\"text\" name=\"owner_name\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\"/>"+			  
										"</td>"+ 
										"</tr>"+                    
										"</table>"+
										"</td>"+
										"<td width=\"50%\" valign=\"top\">"+
										"<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" width=\"100%\">"+      										
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Year</td>"+
										"<td width=\"100%\" nowrap=\"nowrap\"><input type=\"text\" name=\"year\" value=\"\" size=\"25\" maxlength=\"50\" class=\"text\" />"+ 
										"</td>"+										
										"</tr>"+										            										      
										"<tr>"+ 
										"<td align=\"right\" nowrap=\"nowrap\">Keyword</td>"+
										"<td colspan=\"3\"> <textarea name=\"keyword\" cols=\"40\" rows=\"5\" wrap=\"virtual\" class=\"textarea\" /></textarea> "+ 
										"</td>"+
										"</tr>"+
										"</table>"+
										"</td>"+										
										"</tr>"+
										"<tr>"+
										"<td>"+
										"</td>"+
										"<td align=\"left\">"+										
										"</td>"+
										"</tr>"+
										"</form>"+
										"</table>";
										
		break;
		}
} 
</script> 
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />
<!--
<table width="100%" border="0" cellpadding="2" cellspacing="3" class="std">
  <tr valign="middle"> 
    <td width="21%"> 
     <img src="./images/zoom.gif"><b> 
        <? //echo $user->_('Select Search Type');?> :</b></td>
    <td width="79%"> 
      <select name="dropdown" onchange="displayCB();" style="font-size:10px">
            <option value="0">-Select Search Type-</option>			
			<option value="1">-Search All</option>
            <option value="2">&nbsp;&nbsp;&nbsp;&#8226;Research</option>
            <option value="3">&nbsp;&nbsp;&nbsp;&#8226;Publication</option>
			<option value="4">&nbsp;&nbsp;&nbsp;&#8226;Book</option>
			<option value="5">&nbsp;&nbsp;&nbsp;&#8226;Thesis/IS</option>
			<option value="6">&nbsp;&nbsp;&nbsp;&#8226;Project</option>			
          </select> 		                  
	</td>
  </tr>
</table>
-->
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="tdborder1">
  <tr valign="middle"> 
    <td width="21%" class="news"> <img src="./images/zoom.gif"><b> <? echo $user->_('Select Search Type');?> 
      :</b></td>
    <td width="79%" class="news"> <table width="100%" border="0" cellspacing="1" cellpadding="2" >
        <tr>
          <td class="hilite"><a href="./index.php?m=search&t=1">Search All</a></td>
          <td class="hilite"><a href="./index.php?m=search&t=2">Search Research</a></td>
          <td class="hilite"><a href="./index.php?m=search&t=3">Search Publication</a></td>         
        </tr>
        <tr>
          <td class="hilite"><a href="./index.php?m=search&t=4">Search Book</a></td>
          <td class="hilite"><a href="./index.php?m=search&t=5">Search Thesis/IS</a></td>
          <td class="hilite"><a href="./index.php?m=search&t=6">Search Project</a></td>         
        </tr>
      </table></td>
  </tr>
</table>
<br>
<div id="area"> </div>
<?
switch($t){
	case 1: 
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tdborder1">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr >
          <td width="17%" class="news" bgcolor="#FFFFFF"><img src="./images/zoom.gif"><b> <? echo $user->_('Search All');?> 
            :</b></td>
          <td width="83%" >
		   <form name="SearchResearchFrm" action="./index.php?m=search&t=1" method="post">
              <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr> 
                <td colspan="2" class="news" bgcolor="#FFFFFF"><input type="hidden" name="dosql" value="do_search" />
                    <input type="hidden" name="search_type" value="all" /><input class="button" type="submit" name="btnFuseAction" value="search" />
                    <input class="button" type="button" name="cancel" value="cancel" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=search';}" /> 
                  </td>
              </tr>
              <tr> 
                <td width="50%" valign="top">
			<table cellspacing="0" cellpadding="2" border="0" width="100%">
			<tr>
			<td align="right" nowrap="nowrap">Search All Name Thai</td>
			<td width="100%"><input type="text" name="name_th" size="40" maxlength="80" class="text" />
			</td>
			</tr>
			<tr>
			<td align="right" nowrap="nowrap">Name English</td>
			<td width="100%"> <input type="text" name="name_eng"  size="40" maxlength="80" class="text" />
			</td>
			</tr>
			<tr>
			<td align="right" nowrap="nowrap">Owner</td>
			<td>
			<input type="text" name="owner_name" size="25" maxlength="50" class="text"/>
			</td>
			</tr>
			<tr> 
				<td align="right" nowrap="nowrap">Year</td>
				<td width="100%" nowrap="nowrap"><input type="text" name="year" size="25" maxlength="50" class="text" /> 
				</td>
			  </tr>
			   <tr> 
				<td align="right" nowrap="nowrap">Keyword</td>
				<td colspan="3"><textarea name="keyword" cols="40" rows="5" wrap="virtual" class="textarea" /></textarea></td>
			  </tr>
			</table>
				</td>                
              </tr>
              <tr> 
                  <td colspan="2"> <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr> 
                        <td width="16%" align="right" ><?php echo $strPersonal_LabFac;?> 
                          : </td>
                        <td width="84%" align="left" > <select name="fac" onclick="manage_2nd(document.forms('SearchResearchFrm').dept,document.forms('SearchResearchFrm').fac.value);"  onChange="selectChange(this, SearchResearchFrm.dept);" style="font-size:10px">
                            <option value="-1"> -------------------------------- 
                            เลือกคณะ --------------------------------------- </option>
                            <script language = "javascript">
					Add1stSelect(document.forms('SearchResearchFrm').fac);
			  </script>
                          </select> </td>
                      </tr>
                      <tr> 
                        <td align="right" ><?php echo $strPersonal_LabDep;?> 
                          : </td>
                        <td align="left" > <select name="dept" style="font-size:10px">
                            <option value="-1"> -------------------------------- 
                            เลือกภาควิชา ----------------------------------- </option>
                          </select> </td>
                      </tr>
                    </table></td>
              </tr>
            </table>
			</form>
			</td>
        </tr>
      </table></td>
  </tr>
</table>
<?
		break;	
	case 2:
?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tdborder1">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="17%" class="news" bgcolor="#FFFFFF"><img src="./images/zoom.gif"><b> <? echo $user->_('Search Research');?> 
            :</b></td>
          <td width="83%" >
		   <form name="SearchResearchFrm" action="./index.php?m=search&t=2" method="post">
              <table width="100%" border="0" cellspacing="0" cellpadding="4">
              <tr> 
                <td colspan="2" class="news" bgcolor="#FFFFFF">
				<input type="hidden" name="dosql" value="do_search" />
				<input type="hidden" name="search_type" value="research" />
 				<input class="button" type="submit" name="btnFuseAction" value="search" /> 
                    <input class="button" type="button" name="cancel" value="cancel" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=search';}" /> 
                  </td>
              </tr>
              <tr> 
                  <td width="50%" valign="top"><table cellspacing="0" cellpadding="2" border="0" width="100%">
                      <tr> 
                        <td align="right" nowrap="nowrap">Research Name Thai</td>
                        <td width="100%"><input type="text" name="research_name_th"  size="40" maxlength="80" class="text" /> 
                        </td>
                      </tr>
                      <tr> 
                        <td align="right" nowrap="nowrap">Research Name English</td>
                        <td width="100%"> <input type="text" name="research_name_eng" value="" size="40" maxlength="80" class="text" /> 
                        </td>
                      </tr>
                      <tr> 
                        <td align="right" nowrap="nowrap">Research Owner</td>
                        <td> <input type="text" name="research_owner_name2" value="" size="25" maxlength="50" class="text"/> 
                        </td>
                      <tr> 
                        <td align="right" nowrap="nowrap">Research Status</td>
                        <td width="100%" nowrap="nowrap"> <input type="radio" name="research_status" value="1"> 
                          ยังไม่เสร็จ <input type="radio" name="research_status" value="2"> 
                          เสร็จแล้ว </tr>
						<tr> 
                        <td align="right" nowrap="nowrap">Research ISBN</td>
                        <td nowrap="nowrap"><input type="text" name="research_isbn2" value="" size="25" maxlength="50" class="text" /></td>
                      </tr>
                      <tr> 
                        <td align="right" nowrap="nowrap">Research Year</td>
                        <td width="100%" nowrap="nowrap"><input type="text" name="research_year2" value="" size="25" maxlength="50" class="text" /> 
                        </td>
                      </tr>
                      <tr> 
                      <tr> 
                        <td align="right" nowrap="nowrap">Keyword</td>
                        <td colspan="3"><textarea name="textarea" cols="40" rows="5" wrap="virtual" class="textarea" /></textarea> 
                        </td>
                      </tr>
					  <tr> 
                        <td width="16%" align="right" ><?php echo $strPersonal_LabFac;?> 
                          : </td>
                        <td width="84%" align="left" > <select name="fac" onclick="manage_2nd(document.forms('SearchResearchFrm').dept,document.forms('SearchResearchFrm').fac.value);"  onChange="selectChange(this, SearchResearchFrm.dept);" style="font-size:10px">
                            <option value="-1"> -------------------------------- 
                            เลือกคณะ --------------------------------------- </option>
                            <script language = "javascript">
					Add1stSelect(document.forms('SearchResearchFrm').fac);
			  </script>
                          </select> </td>
                      </tr>
                      <tr> 
                        <td align="right" ><?php echo $strPersonal_LabDep;?> : 
                        </td>
                        <td align="left" > <select name="dept" style="font-size:10px">
                            <option value="-1"> -------------------------------- 
                            เลือกภาควิชา ----------------------------------- </option>
                          </select> </td>
                      </tr>	  
                    </table> 
                   </td>                 
              </tr>
              <tr> 
                <td colspan="2"></td>
              </tr>
            </table>
			</form>
			</td>
        </tr>
      </table></td>
  </tr>
</table>
<?
		break;
	case 3:
?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tdborder1">
		<tr valign="middle"> 
		  <td width="21%" class="news" bgcolor="#FFFFFF"> <img src="./images/zoom.gif"><b> <? echo $user->_('Search Publication');?> :</b></td>
		  <td width="79%"> 
		  <form name="SearchResearchFrm" action="./index.php?m=search&t=3" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr> 
            <td colspan="2" class="news" bgcolor="#FFFFFF"> 
			  <input type="hidden" name="dosql" value="do_search" />
			  <input type="hidden" name="search_type" value="publication" />
			  <input class="button" type="submit" name="btnFuseAction2" value="search" /> 
              <input class="button" type="button" name="cancel2" value="cancel" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=search';}" /> 
            </td>
          </tr>
          <tr> 
            <td width="50%" valign="top"><table cellspacing="0" cellpadding="2" border="0" width="100%">
                <tr>
					<td align="right" nowrap="nowrap">Publication Type</td>
					<td width="100%" align="left">
					<select name="type" style="font-size:10px">
					<option value="0">- Select Item -</option>
					<option value="1">Journal</option>
					<option value="2">Proceeding</option>
					<option value="3">Presentation</option>
					</select>
					</td>
					</tr>
					<tr>
					<td align="right" nowrap="nowrap">Publication Name Thai</td>
					<td width="100%"><input type="text" name="name_th" value="" size="40" maxlength="80" class="text" />
					</td>
					</tr>
					<tr>
					<td align="right" nowrap="nowrap">Publication Name English</td>
					<td width="100%"> <input type="text" name="name_eng" value="" size="40" maxlength="80" class="text" />
					</td>
					</tr>
					<tr>
					<td align="right" nowrap="nowrap">Publication Owner</td>
					<td>
					<input type="text" name="owner_name" value="" size="25" maxlength="50" class="text" />
					</td>
					</tr>
					<tr>
					<td align="right" nowrap="nowrap">Publication Category</td>
					<td width="100%" nowrap="nowrap"> <input type="radio" name="category" value="1">
					International
					<input type="radio" name="category" value="2">
					National
					<input type="radio" name="category" value="3">
					Other </td>
					</tr>
					<tr>
					<td align="right" nowrap="nowrap">Publication Year</td>
					<td nowrap="nowrap"><input type="text" name="year" value="" size="25" maxlength="50" class="text" /></td>
					</tr>
					<tr>
					<td align="right" nowrap="nowrap">ISSN (for journal)</td>
					<td nowrap="nowrap"><input type="text" name="issn" value="" size="25" maxlength="50" class="text" /></td>
					</tr>
                <tr> 
                  <td width="16%" align="right" ><?php echo $strPersonal_LabFac;?> 
                    : </td>
                  <td width="84%" align="left" > <select name="fac" onclick="manage_2nd(document.forms('SearchResearchFrm').dept,document.forms('SearchResearchFrm').fac.value);"  onChange="selectChange(this, SearchResearchFrm.dept);" style="font-size:10px">
                      <option value="-1"> -------------------------------- เลือกคณะ 
                      --------------------------------------- </option>
                      <script language = "javascript">
					Add1stSelect(document.forms('SearchResearchFrm').fac);
			  </script>
                    </select> </td>
                </tr>
                <tr> 
                  <td align="right" ><?php echo $strPersonal_LabDep;?> : </td>
                  <td align="left" > <select name="dept" style="font-size:10px">
                      <option value="-1"> -------------------------------- เลือกภาควิชา 
                      ----------------------------------- </option>
                    </select> </td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td colspan="2"></td>
          </tr>
        </table>
      </form>
		  </td>
		</tr>
	  </table>
<?	
		break;
	case 4:
?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tdborder1">
		<tr valign="middle"> 
		  <td width="21%" class="news" bgcolor="#FFFFFF"> <img src="./images/zoom.gif"><b> <? echo $user->_('Search Book');?> :</b></td>
		  <td width="79%"> 
		   <form name="SearchResearchFrm" action="./index.php?m=search&t=4" method="post">
              <table width="100%" border="0" cellspacing="0" cellpadding="4">
              <tr> 
                <td colspan="2" class="news" bgcolor="#FFFFFF">
				<input type="hidden" name="dosql" value="do_search" />
				<input type="hidden" name="search_type" value="book" />
 				<input class="button" type="submit" name="btnFuseAction" value="search" /> 
                    <input class="button" type="button" name="cancel" value="cancel" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=search';}" /> 
                  </td>
              </tr>
              <tr> 
                  <td width="50%" valign="top"><table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr>
            <td align="right" nowrap="nowrap">Book Name Thai</td>
            <td width="100%"><input type="text" name="book_name_th" value="" size="40" maxlength="80" class="text" /> 
            </td>
          </tr>
          <tr>
            <td align="right" nowrap="nowrap">Book Name English</td>
            <td width="100%"> <input type="text" name="book_name_eng" value="" size="40" maxlength="80" class="text" /> 
            </td>
          </tr>
          <tr>
            <td align="right" nowrap="nowrap">Book Owner</td>
            <td> <input type="text" name="book_owner_name" value="" size="25" maxlength="50" class="text"/> 
            </td>
          <tr>
			<td align="right" nowrap="nowrap">Book ISBN</td>
			<td nowrap="nowrap"><input type="text" name="book_isbn" value="" size="25" maxlength="50" class="text" /></td>
			</tr>
			<tr>
			<td align="right" nowrap="nowrap">Book Year</td>
			<td width="100%" nowrap="nowrap"><input type="text" name="book_year" value="" size="25" maxlength="50" class="text" />
			</td>
			</tr>          
			<tr>          
			<tr>
			<td align="right" nowrap="nowrap">Keyword</td>
			<td colspan="3"><textarea name="book_keyword" cols="40" rows="5" wrap="virtual" class="textarea" /></textarea>
			</td>
			</tr>                   
          <tr> 
            <td width="16%" align="right" ><?php echo $strPersonal_LabFac;?> : 
            </td>
            <td width="84%" align="left" > <select name="fac" onclick="manage_2nd(document.forms('SearchResearchFrm').dept,document.forms('SearchResearchFrm').fac.value);"  onChange="selectChange(this, SearchResearchFrm.dept);" style="font-size:10px">
                <option value="-1"> -------------------------------- เลือกคณะ 
                --------------------------------------- </option>
                <script language = "javascript">
					Add1stSelect(document.forms('SearchResearchFrm').fac);
			  </script>
              </select> </td>
          </tr>
          <tr> 
            <td align="right" ><?php echo $strPersonal_LabDep;?> : </td>
            <td align="left" > <select name="dept" style="font-size:10px">
                <option value="-1"> -------------------------------- เลือกภาควิชา 
                ----------------------------------- </option>
              </select> </td>
          </tr>
        </table> 
                   </td>                 
              </tr>
              <tr> 
                <td colspan="2"></td>
              </tr>
            </table>
			</form>
		  </td>
		</tr>
	  </table>
<?		
		break;
	case 5:
?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tdborder1">
		<tr valign="middle"> 
		  <td width="21%" class="news" bgcolor="#FFFFFF"> <img src="./images/zoom.gif"><b> <? echo $user->_('Search Thesis/IS');?> :</b></td>
		  <td width="79%"> 
		  <form name="SearchResearchFrm" action="./index.php?m=search&t=5" method="post">
              <table width="100%" border="0" cellspacing="0" cellpadding="4">
              <tr> 
                <td colspan="2" class="news" bgcolor="#FFFFFF">
				<input type="hidden" name="dosql" value="do_search" />
				<input type="hidden" name="search_type" value="thesis" />
 				<input class="button" type="submit" name="btnFuseAction" value="search" /> 
                    <input class="button" type="button" name="cancel" value="cancel" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=search';}" /> 
                  </td>
              </tr>
              <tr> 
                  <td width="50%" valign="top"><table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap="nowrap">Name Thai</td>
            <td width="100%"><input type="text" name="thesis_name_th" value="" size="40" maxlength="80" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap">Name English</td>
            <td width="100%"> <input type="text" name="thesis_name_eng" value="" size="40" maxlength="80" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap">Owner</td>
            <td> <input type="text" name="thesis_owner_name" value="" size="25" maxlength="50" class="text"/> 
            </td>
          <tr> 
            <td align="right" nowrap="nowrap">Type</td>
            <td width="100%" nowrap="nowrap"> <input type="radio" name="thesis_type" value="1">
              Thesis 
              <input type="radio" name="thesis_type" value="2">
              Independant Study </tr>
          <tr>
			<td align="right" nowrap="nowrap">ISBN</td>
			<td nowrap="nowrap"><input type="text" name="thesis_isbn" value="" size="25" maxlength="50" class="text" /></td>
			</tr>
			<tr>
			<td align="right" nowrap="nowrap">Year</td>
			<td width="100%" nowrap="nowrap"><input type="text" name="thesis_year" value="" size="25" maxlength="50" class="text" />
			</td>										
			</tr>										            										      
			<tr>
			<td align="right" nowrap="nowrap">Keyword</td>
			<td colspan="3"> <textarea name="thesis_keyword" cols="40" rows="5" wrap="virtual" class="textarea" /></textarea>
			</td>
			</tr>
          <tr> 
            <td width="16%" align="right" ><?php echo $strPersonal_LabFac;?> : 
            </td>
            <td width="100%" align="left" > <select name="fac" onclick="manage_2nd(document.forms('SearchResearchFrm').dept,document.forms('SearchResearchFrm').fac.value);"  onChange="selectChange(this, SearchResearchFrm.dept);" style="font-size:10px">
                <option value="-1"> -------------------------------- เลือกคณะ 
                --------------------------------------- </option>
                <script language = "javascript">
					Add1stSelect(document.forms('SearchResearchFrm').fac);
			  </script>
              </select> </td>
          </tr>
          <tr> 
            <td align="right" ><?php echo $strPersonal_LabDep;?> : </td>
            <td align="left" > <select name="dept" style="font-size:10px">
                <option value="-1"> -------------------------------- เลือกภาควิชา 
                ----------------------------------- </option>
              </select> </td>
          </tr>
        </table> 
                   </td>                 
              </tr>
              <tr> 
                <td colspan="2"></td>
              </tr>
            </table>
			</form>
		  </td>
		</tr>
	  </table>
<?		
		break;
	case 6:			
?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tdborder1">
		<tr valign="middle"> 
		  <td width="21%" class="news" bgcolor="#FFFFFF"> <img src="./images/zoom.gif"><b> <? echo $user->_('Search Project');?> :</b></td>
		  <td width="79%"> 
		   <form name="SearchResearchFrm" action="./index.php?m=search&t=6" method="post">
              <table width="100%" border="0" cellspacing="0" cellpadding="4">
              <tr> 
                <td colspan="2" class="news" bgcolor="#FFFFFF">
				<input type="hidden" name="dosql" value="do_search" />
				<input type="hidden" name="search_type" value="project" />
 				<input class="button" type="submit" name="btnFuseAction" value="search" /> 
                    <input class="button" type="button" name="cancel" value="cancel" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=search';}" /> 
                  </td>
              </tr>
              <tr> 
                  <td width="50%" valign="top"><table cellspacing="0" cellpadding="2" border="0" width="100%">
          <tr> 
            <td align="right" nowrap="nowrap">Project Name Thai</td>
            <td width="100%"><input type="text" name="project_name_th" value="" size="40" maxlength="80" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap">Project Name English</td>
            <td width="100%"> <input type="text" name="project_name_eng" value="" size="40" maxlength="80" class="text" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap="nowrap">Project Owner</td>
            <td> <input type="text" name="project_owner_name" value="" size="25" maxlength="50" class="text" />	
            </td>
          </tr>
          <tr>
			<td align="right" nowrap="nowrap">Project ISBN</td>
			<td nowrap="nowrap"><input type="text" name="project_isbn" value="" size="25" maxlength="50" class="text" /></td>
			</tr>
			<tr>
			<td align="right" nowrap="nowrap">Project Year</td>
			<td width="100%" nowrap="nowrap"><input type="text" name="project_year" value="" size="25" maxlength="50" class="text" />
			</td>
			</tr>
			<tr>
			<tr>
			<td align="right" nowrap="nowrap">Keyword</td>
			<td colspan="3"> <textarea name="project_keyword" cols="40" rows="5" wrap="virtual" class="textarea" /></textarea> 
			</td>
			</tr>
          <tr> 
            <td width="16%" align="right" ><?php echo $strPersonal_LabFac;?> : 
            </td>
            <td width="100%" align="left" > <select name="fac" onclick="manage_2nd(document.forms('SearchResearchFrm').dept,document.forms('SearchResearchFrm').fac.value);"  onChange="selectChange(this, SearchResearchFrm.dept);" style="font-size:10px">
                <option value="-1"> -------------------------------- เลือกคณะ 
                --------------------------------------- </option>
                <script language = "javascript">
					Add1stSelect(document.forms('SearchResearchFrm').fac);
			  </script>
              </select> </td>
          </tr>
          <tr> 
            <td align="right" ><?php echo $strPersonal_LabDep;?> : </td>
            <td align="left" > <select name="dept" style="font-size:10px">
                <option value="-1"> -------------------------------- เลือกภาควิชา 
                ----------------------------------- </option>
              </select> </td>
          </tr>
        </table> 
                   </td>                 
              </tr>
              <tr> 
                <td colspan="2"></td>
              </tr>
            </table>
			</form>
		  </td>
		</tr>
	  </table>
<?	
	break;	
}
?>