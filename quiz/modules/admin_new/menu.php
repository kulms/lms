<table width="128" border="0" cellspacing="0">
        <tr>
          <td height="17" align="right"><a href="Javascript:editQuiz(<? echo $modules; ?>)" ><?php echo $strQuiz_MenuEditPreference;?></a></td>
        </tr>
        <tr>
           <td height="17" align="right" ><a href="#"  onclick="return toggleMenu('menu1')"><?php echo $strQuiz_MenuAddQuestion;?></a>
		  <span class="menu" id="menu1" style="display:none ">
            <table width=76% cellspacing="0">
            <tr><td td class="nav" align="left"><a href="Javascript:addquestions(<? echo $modules;?>)">- <?php echo $strQuiz_MenuAddMultipleChoice;?></a></td></tr>
            <tr><td td class="nav" align="left"><a href="Javascript:addquestionstnf(<? echo $modules;?>)">- <?php echo $strQuiz_MenuAddTrueFalse;?></a></td></tr>
            <tr><td td class="nav" align="left"><a href="Javascript:addquestionsmcit(<? echo $modules;?>)">- <?php echo $strQuiz_MenuAddMatching;?></a></td></tr>
            <tr><td td class="nav" align="left"><a href="Javascript:addquestionsfib(<? echo $modules;?>)">- <?php echo $strQuiz_MenuAddFilling;?></a></td></tr>
            </table>
			</span></td>
        </tr>
        <tr>
          <td height="17" align="right"><a href="Javascript:skipit(<? echo $modules;?>)"> <?php echo $strQuiz_MenuSetActive;?> </a></td>
        </tr>
        <tr>
          <td align="right"  height="17"><a href="Javascript:viewQuestions(<? echo $modules;?>)"><?php echo $strQuiz_MenuViewAdd;?> </a></td>
        </tr>
        <tr>
          <td height="17" align="right"><a href="Javascript:search_quiz(<? echo $modules;?>)"><?php echo $strQuiz_MenuSearchQuestion;?></a></td>
        </tr>
        <tr>
          <td align="right" height="17"><a href="Javascript:check_delete(<? echo $modules;?>)"><?php echo $strQuiz_MenuDeleteQuiz;?></a></td>
        </tr>
        <tr>
<td height="17" align="right" ><a href="#"  onclick="return toggleMenu('menu2')"><?php echo $strQuiz_MenuResult;?></a>
		  <span class="menu" id="menu2" style="display:none ">
            <table width=76% cellspacing="0">
			<tr><td class="nav" align="left"><a href="Javascript:viewUserResult(<? echo $modules;?>)">- <?php echo $strQuiz_MenuResultByUser;?></a></td></tr>
            <tr><td class="nav" align="left"><a href="Javascript:viewall(<? echo $modules;?>)">- <?php echo $strQuiz_MenuResultByQuestion;?></a></td></tr>
            </table>
			</span></td>        </tr>
      </table>