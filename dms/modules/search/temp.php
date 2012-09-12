 <form name="SearchResearchFrm" action="./index.php?m=search&t=6" method="post">
              <table width="100%" border="0" cellspacing="0" cellpadding="4">
              <tr> 
                <td colspan="2" class="hilite">
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
			</form><br>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="50%"></td>
<td width="50%"></td>
</tr>
</table>
<table cellspacing="0" cellpadding="4" border="0" width="100%" class="std">
<form name="SearchResearchFrm" action="./index.php?m=search" method="post">
<input type="hidden" name="dosql" value="do_search" />
<input type="hidden" name="search_type" value="project" />
<tr>
<td colspan="2" valign="top" class="hilite">
<input class="button" type="submit" name="btnFuseAction" value="search" />
<input class="button" type="button" name="cancel" value="cancel" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = './index.php?m=search';}" />
</td>
</tr>
<tr>
<td width="50%" valign="top">
<table cellspacing="0" cellpadding="2" border="0">
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
<td>
<input type="text" name="project_owner_name" value="" size="25" maxlength="50" class="text" />			  
</td> 
</tr>                       
</table>
</td>
<td width="50%" valign="top">
<table cellspacing="0" cellpadding="2" border="0" width="100%">
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
</table>
</td>
</tr>
<tr>
<td>
</td>
<td align="left">
</td>
</tr>
</form>
</table>