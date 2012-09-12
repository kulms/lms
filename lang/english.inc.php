<?php
/* $Id: english.inc.php,v 1.172 2002/06/22 23:41:04 swix Exp $ */

//$charset = 'iso-8859-1';
$charset = 'tis-620';
$text_dir = 'ltr'; // ('ltr' for left to right, 'rtl' for right to left)
$left_font_family = 'verdana, arial, helvetica, geneva, sans-serif';
$right_font_family = 'arial, helvetica, geneva, sans-serif';
$number_thousands_separator = ',';
$number_decimal_separator = '.';
$byteUnits = array('Bytes', 'KB', 'MB', 'GB');

$day_of_week = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
$month = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
// See http://www.php.net/manual/en/function.strftime.php to define the
// variable below
$datefmt = '%B %d, %Y at %I:%M %p';

//------------------    For Common Feather -----------------------------------
//  Please order by Alphabet

$strAdd="Add";
$strBack="Back";
$strEdit="Edit";
$strDelete="Delete";
$strDeletePic="Delete Picture";
$strNext="Next";
$strPrevious="Previous";
$strBack="Back";
$strSubmit="Submit";
$strCreate="Create";
$strReset="Reset";
$strCancel="Cancel";
$strUpdate="Update";
$strShow="Show";
$strSave="Save";
$strSearch="Search";
$strView="View";
$strResult="Result";
$strLink="Link";
$strSend="Send";
$strClose="Close";
$strActive = "Active";
$strDisable = "Disable";
$strClick = "Click";
$strSet = "Set";
$strYes = "Yes";
$strNo = "No";
$strRemove = "Remove";
$strAction = "Action";
$strPage = "Page";


//-----------------------------------------------------------------------------------------

//-------------------------  For Each Modules ------------------------------------

//-------------------------  Top Frame ---------------------------------------------
$strTop_MenuStart = "Start";
$strTop_MenuPersonal = "Personal";
$strTop_MenuCourses = "Courses";
$strTop_MenuSystem = "System";
$strTop_LabUser = "Login by : ";
$strTop_LabLogout = "Logout";

//-------------------------  Start Page ---------------------------------------------
$strStart_MenuECourse = "E-Courseware Center";
$strStart_MenuStat = "Course Statistics";
$strStart_Header = "Start Page";
$strStart_LabManual = "M@xLearn Manaul";
$strStart_LabForum = "Forum";
$strStart_LabHomework = "Homework";
$strStart_LabQuiz = "Quiz & Survey";
$strStart_LabResources = "Resources";
$strStart_LabSyllabus = "Syllabus";
$strStart_LabWebboard = "Webboard";
$strStart_LabAll = "M@xLearn (All Tools)";
$strStart_LabMaxWebboard = "M@xLearn Webboard";
$strStart_LabRecommend = "Webboard for inform error and recommend Learning Management System";

//-------------------------  Personal ---------------------------------------------
$strPersonal_MenuCalendar = "Personal Calendar";
$strPersonal_BtnEditPersonal = $strEdit." User Information";
$strPersonal_Header = "Personal Information Area";
$strPersonal_LabUserHeader = "User Information";
$strPersonal_LabTitleTh = "Title (th)";
$strPersonal_LabTitleEng = "Title (eng)";
$strPersonal_LabNameTh = "Name (th)";
$strPersonal_LabNameEng = "Name (eng)";
$strPersonal_LabSurNameTh = "SurName (th)";
$strPersonal_LabSurNameEng = "SurName (eng)";
$strPersonal_LabNameSurNameTh = "Name-Surname (th)";
$strPersonal_LabNameSurNameEng = "Name-Surname (eng)";
$strPersonal_LabTeacherCode = "University officer code";
$strPersonal_LabUserName = "UserName";
$strPersonal_LabChangePassword = "Change Password";
$strPersonal_LabPassword = "Password";
$strPersonal_LabFac = "Faculty";
$strPersonal_LabDep = "Department";
$strPersonal_LabEmail = "Email";
$strPersonal_LabOtherEmail = "Other Email";
$strPersonal_LabHomepage = "HomePage";
$strPersonal_LabPicture = "Picture";
$strPersonal_LabIcq = "Icq";
$strPersonal_LabSkill = "Skill / Interest";
$strPersonal_LabOfficeHeader = "Office Information";
$strPersonal_LabOfficeOutHeader = "Office Outside Information";
$strPersonal_LabHomeHeader = "Home Information";
$strPersonal_LabBuilding = "Building";
$strPersonal_LabRoom = "Room";
$strPersonal_LabIntPhone = "Internal Telephone";
$strPersonal_LabAddress = "Address";
$strPersonal_LabTelephone = "Telephone";
$strPersonal_LabMobile = "Mobile";
$strPersonal_LabLanguage = "Language";
$strPersonal_LabPostalAddress = "Postal Address";
$strPersonal_LabIDCode = "Id Number";
$strPersonal_LabIDCodeError = "Id Number must be numeric";
$strPersonal_LabLastLogin = "Last Login";
$strPersonal_LabNeverLogin = "Never logged in";


//-------------------------------  Calendar  -------------------------------------------
  //$strCaledarAbc=" This is the word";
$strCalendar_LabShare="Share Calendar";
$strCalendar_LabThisMonth="This Month";
$strCalendar_LabSelectYear="Select Year";
$strCalendar_LabSelectMonth="Select Month";
$strCalendar_LabSelectUser="Select User";
$strCalendar_LabViewFrom="View Calendar From";
$strCalendar_LabViewFromAll="View All";
$strCalendar_LabViewFromPersonal="View Personal";
$strCalendar_LabMonthAsList="Month as List";
$strCalendar_LabApp="Appointment.";
$strCalendar_LabAddNewApp="Add new Appointment.";
$strCalendar_LabShowDetailApp="Show detail of this appointment.";
$strCalendar_LabAddNewAppTo="Add new Appointment to ";
$strCalendar_LabPerCal="Personal Calendar";
$strCalendar_LabStart="Start Time";
$strCalendar_LabLength="Length";
$strCalendar_LabTitle="Title";
$strCalendar_LabDesc="Description";
$strCalendar_LabAppDel="Appointment deleted successfully.";
$strCalendar_LabDate="Date";
$strCalendar_LabTime="Time";
$strCalendar_LabCourse="Course";
$strCalendar_LabNewDate="New Date";
$strCalendar_LabMonthView="Month View";
$strCalendar_LabThisWeek="This Week";
$strCalendar_LabWeek="Week";
//-------------------------------  Course Member -------------------------------------------
//-------------------------------  Courses  -------------------------------------------
$strCourses_Header = "Course Area";
$strCourses_MenuMainCourses = "Courses";
$strCourses_MenuActiveCourses = "Active Courses";
$strCourses_MenuCreateCourses = "Create Course";
$strCourses_MenuDelCourses = "Delete Course";
$strCourses_MenuInActiveCourses = "Inactive Courses";

$strCourses_LabStdListApply = "Student Lists [Apply Courses]";
$strCourses_LabStdListWithdraw = "Studennt Lists [Withdraw Courses] ";
$strCourses_LabCourseId = "Course Id";
$strCourses_LabCourseName = "Course Name";
$strCourses_LabStdNo = "No";
$strCourses_LabStdName = "Full Name";
$strCourses_LabStdEmail = "Email";
$strCourses_LabStdApply = "Applied Course";
$strCourses_LabStdGrant = "Grant";
$strCourses_LabStdWithdraw = "Withdraw Course";
$strCourses_LabStdRefuse = "Refuse";

//----------- Course News-------------------
$strCourses_LabCourseNews = "Course Announcement";
$strCourses_LabCourseSection = "Section";
$strCourses_LabCourseSemester = "Semester";
$strCourses_LabCourseYear = "Year";
$strCourses_LabCourseNewsDetail = "Announcement Detail";
$strCourses_NewsNo = "No.";
$strCourses_NewsPicture = "Picture";
$strCourses_NewsSubject = "Subject";
$strCourses_NewsLimit = "Date limit";
$strCourses_NewsHeaderadd = "Add News";
$strCourses_NewsHeaderedit = "Edit News";
$strCourses_NewsHeaderview = "View News";
$strCourses_NewsHeaderinfo = "Header Information";
$strCourses_NewsFile= "Files";
$strCourses_NewsThumbpic= "Thumbnail Picture";
$strCourses_NewsPreview= "Preview";
$strCourses_NewsPictype= "file type .gif, .jpg , .jpeg ";
$strCourses_NewsEnter = "Press Shift+Enter to make a new row.";
$strCourses_NewsMsg        ="***If you don't filling expired date, your message will be deleted in 7 days***";

$strCourses_NewsContent = "Content";
$strCourses_NewsExpire = "Expiration";
$strCourses_NewsLastupdate = "Last Update";
$strCourses_NewsExpiredate= "Expire Date";
$strCourses_NewsDisplay= "Display";
$strCourses_NewsDisplayFirstpage= "Announce to Firstpage";
$strCourses_NewsDisplayCourses= "Announce to this Course only";
$strCourses_NewsTitle = "Title";
$strCourses_NewsDelpic = "Delete Picture";
$strCourses_NewsTotal = "Total News: ";
$strCourses_NewsNotfound = "Not Found News";


//------------------------------------------


$strCourses_DetailCreateCourses = "<p><b>Benefit for Instructor who create course online to support your students.</b></p>
                                                                                                                                                        <ul>
                                                                                                                                                          <li><b>Course Syllabus</b>, have the form to put your course information and easy to use and search for everyone.</li>
                                                                                                                                                          <li><b>Course Schedule</b> , Automatic generate calendar when you use it with Course Syllabus.</li>
                                                                                                                                                          <li>Have the tools for collect your Content each your course.</li>
                                                                                                                                                          <li>Students can easily join your course and have the activity that instructor assigned.</li>
                                                                                                                                                          <li>Have many Tools that you can usable such as <b>Webboard Chatroom Online quiz and Online Homework.</b>
                                                                                                                                                          </li>
                                                                                                                                                        </ul>";

$strCourses_DetailApplyCourses = "<p><b><u>Step</u></b></p>
                                                                                                                                                <ol>
                                                                                                                                                  <li>Searching Course that you require.</li>
                                                                                                                                                  <li>Click button <b>Apply</b>
                                                                                                                                                        <ol type=\"a\">
                                                                                                                                                          <li>Course specify <b>\"Open\" </b>immediately join.</li>
                                                                                                                                                          <li>Course specify <b>\"Approve\" </b>wait for permit from instructor.</li>
                                                                                                                                                        </ol>
                                                                                                                                                  </li>
                                                                                                                                                </ol>";

$strCourses_DetailWithdrawCourses = "<p><u><b>Step</b></u></p>
                                                                                                                                                                <ol>
                                                                                                                                                                  <li>Click button <b>Withdraw</b>
                                                                                                                                                                        <ol type=\"a\">
                                                                                                                                                                          <li>Course specify <b>\"Open\" </b>immediately withdraw.</li>
                                                                                                                                                                          <li>Course specify <b>\"Approve\" </b>wait for permit from instructor.
                                                                                                                                                                          </li>
                                                                                                                                                                        </ol>
                                                                                                                                                                  </li>
                                                                                                                                                                </ol>";

$strCourses_LabCourseApply = "Apply Courses";
$strCourses_LabCourseApplyList = "Apply Course Lists";


$strCourses_LabSearchCourse = "Search Course";
$strCourses_LabSelectByCourse = "Select by Course Detail.";
$strCourses_LabSelectByInstructor = "Select by Instructor Detail.";
$strCourses_LabInsName = "Lecturer's firstname";
$strCourses_LabInsSurname = "Lecturer's surname";
$strCourses_LabInsFac = "Faculty";
$strCourses_LabShowAll= "Show All";
$strCourses_LabStatus= "Status";
$strCourses_LabProcess= "Process";
$strCourses_LabClose= "Close";
$strCourses_LabApplied= "Applied";
$strCourses_LabApply= "Apply";
$strCourses_LabOpen= "Open";
$strCourses_LabApprove= "Approve";
$strCourses_LabWithdraw= "Withdraw";
$strCourses_LabWait= "Wait";
$strCourses_LabTotalCourse = "Total Courses";
$strCourses_LabNotFound = "Course'd not found.";


$strCourses_BtnShowCourseId = $strShow." by Course Id";
$strCourses_BtnShowCourseName = $strShow." by Course Name";
$strCourses_BtnShowName = $strShow." by Firstname";
$strCourses_BtnShowSurName = $strShow." by Surname";
$strCourses_BtnShowFac = $strShow." by Faculty";
$strCourses_BtnShowAll = $strShow." All";



$strCourses_LabCourseWithdraw = "Withdraw Courses";
$strCourses_LabCourseWaitWithdraw = "Waiting for withdraw Courses";


$strCourses_LabMenuInstructor = "Instructor Memu";
$strCourses_LabCourseSyllabus = "Course Syllabus";
$strCourses_LabCourseCalendar = "Course Calendar";
$strCourses_LabCoursePreference = "Course Preference";
$strCourses_LabCourseMember = "Course Member";
$strCourses_LabCourseActivity = "Course Activity";
$strCourses_LabCourseResource = "Course Resource";
$strCourses_LabCourseAnnouncement = "Course Announcement";
$strCourses_LabCourseTools = "Course Tools";

$strCourses_LabShowAllInfo = $strShow." full info";
$strCourses_LabMailToAll = "Mail to all";
$strCourses_LabEditGroup = $strEdit." Group Members";
$strCourses_LabEditCourseMembers = $strEdit.$strCourses_LabCourseMember;

$strCourses_LabSearch = $strSearch." by";
$strCourses_LabSearchText = $strSearch." Text";

$strCourses_LabOtherCourseMember = "Other ".$strCourses_LabCourseMember;



//-------------------------------  Group -------------------------------------------
//-------------------------------  Homework -------------------------------------------
$strHome_LabInfo = "Homework Information";
$strHome_LabDetail = "Homework Detail";
$strHome_LabDes = "Homework Description";
$strHome_LabDate = "Homework Due Date";
$strHome_LabNo = "No";
$strHome_LabQuestion = "Question";
$strHome_LabAttach = "Attachment / Link";
$strHome_LabAction = "Action";
$strHome_LabScore = "Score";
$strHome_LabNoScore = "No ".$strHome_LabScore;
$strHome_LabAnswer = "Answer";
$strHome_LabSolution = "Solution";
$strHome_LabHomeClose = "THIS HOMEWORK IS CLOSED.";
$strHome_LabResultForAll = "Results for all participating users in ";
$strHome_LabPartType = "Participation Type";
$strHome_LabNoSender = "No. of sender now";
$strHome_LabGraph = "Graph";
$strHome_LabIndex = "Homework Index";
$strHome_BtnNewQuestion = "New Question";

$strHome_LabShowAll = $strShow.$strHome_LabQuestion;
$strHome_LabShowAllText = $strShow." Text";
$strHome_LabZip = "Zip Answer";
$strHome_LabDateTime = "Date-Time";
$strHome_LabText = "Text";
$strHome_LabUrl = "URL";
$strHome_LabFile = "File";

$strHome_LabMaxScores = "Max Scores";
$strHome_LabEditQues="Edit Question";
$strHome_LabAssignment="Assignment";
$strHome_LabQuestionType="Question Type";

//-------------------------------  Quiz and Survey  -------------------------------------------
$strQuiz_LabText="Welcome to Online Quiz  Management System";
$strQuiz_LabOther = "Other";
$strQuiz_LabCategory = "Category";
$strQuiz_LabQuizNo = "Question No.";
$strQuiz_LabQuiz = "Question";
$strQuiz_LabType = "Type";
$strQuiz_LabFile = "File Attach";
$strQuiz_LabFileOld = "File Attach Old";
$strQuiz_LabScore = "Score";
$strQuiz_LabMaxScore = "MaxScore";
$strQuiz_LabAlternate = "Alternatives";
$strQuiz_LabCorrectAns = "Check if true";
$strQuiz_LabSolution = "Solution";
$strQuiz_LabComment = "Comment";
$strQuiz_LabAnswer = "Answer";
$strQuiz_LabDesc = "Description";
$strQuiz_LabActive = "Active";
$strQuiz_LabInActive = "Inactive";
$strQuiz_LabCorrectAnswer = "Correct Answer";
$strQuiz_LabAnswerTrue = "True";
$strQuiz_LabAnswerFalse = "False";
$strQuiz_LabUse = "Use";
$strQuiz_LabUseSelect="Use selected questions";
$strQuiz_LabAverage="Average";
$strQuiz_LabTopScore="Top score";

$strQuiz_LabTotalQuestion = "Total of question";
$strQuiz_LabTotalAnswer = "Total of Answer";
$strQuiz_LabTotalScore= "Total score ";
$strQuiz_LabFor= "For ";
$strQuiz_LabNoError= "No error";
$strQuiz_LabAnswerCorrect= "The questions you missed in ";
$strQuiz_LabAnswerCorrectAll= "The questions  in  Quiz ";

$strQuiz_MenuEditPreference = "Edit preferences";
$strQuiz_MenuAddQuestion = "Add new questions";
$strQuiz_MenuAddMultipleChoice = "Multiple Choice";
$strQuiz_MenuAddMatching = "Matching Item";
$strQuiz_MenuAddFilling = "Fill-in-Blank";
$strQuiz_MenuAddTrueFalse = "True/alse";
$strQuiz_MenuSetActive = "Set active/inactive";
$strQuiz_MenuViewAdd = "View added questions";
$strQuiz_MenuSearchQuestion = "Search questions";
$strQuiz_MenuDeleteQuiz = "Delete quiz";
$strQuiz_MenuResult = "Results";
$strQuiz_MenuResultByUser = "Results by user";
$strQuiz_MenuResultByQuestion = "Results question";

$strQuiz_LabAddCategorySuccess = "New category has been successfully added.";
$strQuiz_LabAddQuestionSuccess = "Your question has been successfully added.";
$strQuiz_LabSolutionDisplay = "This solution will only be displayed to those that didn't submit the right answer.";
$strQuiz_LabForSearch = "For searchable from the search page.";
$strQuiz_LabRecieveScore = "The score for correct answer.";
$strQuiz_LabScoreByQuiz = "คะแนนแต่ละคำถาม";
$strQuiz_LabNumericOnly = "Numeric Only";
$strQuiz_LabOutofTime = "Your Questions Out Of Time...";
$strQuiz_LabNoNumQuiz = "ไม่ระบุ จำนวนข้อสอบ";
$strQuiz_LabNumQuizEqual = "จำนวนข้อสอบ ยังไม่ครบจำนวน";
$strQuiz_LabNoNumMcit= "ข้อสอบชุดนี้ มีการใช้ข้อสอบแบบจับคู่ แต่เนื่องจากผู้สอนยังไม่ได้ทำการสร้างข้อสอบ จึงควรแจ้งผู้สอน";    //(29/03/05)
$strQuiz_LabDonotCopy= "เนื่องจากข้อสอบ ข้อนี้ได้มีผู้เรียน ได้ทำการทดสอบอยู่ จึงไม่สามารถทำการ ปรับปรุงได้";    //(29/03/05)
$strQuiz_LabDonotCopy1= "เนื่องจากข้อสอบ ข้อนี้ได้มีข้อสอบชุดอื่นทำการเรียกใช้อยู่ จึงไม่สามารถทำการ ปรับปรุงได้";    //(29/03/05)
$strQuiz_LabNoRecord = "No records for this quiz yet !!!";
$strQuiz_LabResultAll = "Results for all participating users in ";
$strQuiz_LabResultSurveyAll = "Results for all Survey users in  ";
$strQuiz_LabUniPart = "Uniqe Participants";
$strQuiz_LabNrRun = "Nr of runs";
$strQuiz_LabPart = "Participants";
$strQuiz_LabNrSend="Nr of send";
$strQuiz_LabOccasion = "Occasion";
$strQuiz_LabPercent = "Percent";
$strQuiz_LabQuestionUpdate = "Your question is updated...";
$strQuiz_LabSorry = "Sorry ...";
$strQuiz_LabCanNotDel = "Couldn't delete this question since it's included in another quiz...";
$strQuiz_LabQuestionDel = "The question has been deleted...";
$strQuiz_LabQuestionRemove = "The question has been removed from your quiz...";
$strQuiz_LabQuestionSend= "Your answer update...";
$strQuiz_LabTimer = "Time";
$strQuiz_LabSearch = "Input % to Search All";
$strQuiz_LabSearchIn = "Search from";
$strQuiz_LabSubmitAll = "Submit All";
$strQuiz_LabSubmitAns = "Submit Answer";
$strQuiz_LabDoStart = "Start ";
$strQuiz_LabDoContinue = "Continue ";
$strQuiz_LabSeveralComment = "You're not allowed to run it several times<br>";
$strQuiz_LabAgainComment = "<p>Do you want to do it all over again?<br>";


$strQuiz_LabAddQuestionMutipleChoice = "New questions (Multiple Choice)";
$strQuiz_LabAddQuestionTrueFalse = "New questions (True-False)";
$strQuiz_LabAddQuestionMatching = "New questions (Macthing Item)";
$strQuiz_LabAddQuestionFilling = "New questions (Fill in blank)";

$strQuiz_LabQuizWrong="Your answer is wrong";
$strQuiz_LabQuizCorrect="Your answer is correct";
$strQuiz_LabAnsCorrect="Answer Correct";

$strQuiz_LabName = "Quiz Name";
$strQuiz_LabMaxName = "Maximum 15 characters";
$strQuiz_LabQuizOrSurvey = "Quiz or Survey";
$strQuiz_LabQuiz = "Quiz";
$strQuiz_LabSurvey = "Survey";
$strQuiz_LabLastDate = "Last Date";
$strQuiz_LabValidate = "Alert Message";
$strQuiz_LabMultipleSelect = "Multiple Choice Format";
$strQuiz_LabDependOn = "Depend on answer";
$strQuiz_LabMultiChoose = "Multi choosing answer";
$strQuiz_LabRandom = "Randomize questions";
$strQuiz_LabViewAns = "View Answer";
$strQuiz_LabViewOnebyOne = "One by one";
$strQuiz_LabViewAllQuiz = "All Quiz";
$strQuiz_LabViewAnsNo = "Not View answer";
$strQuiz_LabViewSol = "View Solution";
$strQuiz_LabTimesQuiz = "Times to do Quiz";
$strQuiz_LabSeveral = "Several times";
$strQuiz_LabOnce = "Once";
$strQuiz_LabSelectMatching = "Select Matching Item";
$strQuiz_LabSelectTimer = "Select Timer";
$strQuiz_LabHour = "Hour";
$strQuiz_LabMinute = "Minute";
$strQuiz_LabSelectColor = "Select <b>Background colour</b> for your questions.";
$strQuiz_LabWhite = "White";
$strQuiz_LabAntiqueWhite = "Antique White";
$strQuiz_LabMintCream = "Mint Cream";
$strQuiz_LabLearnLoopBlue = "LearnLoop Blue";
$strQuiz_LabCoral = "Coral";
$strQuiz_LabTan = "Tan";
$strQuiz_LabRoyalBlue = "Royal Blue";
$strQuiz_LabGainsboro = "Gainsboro";
$strQuiz_LabOtherColor = "Other Color";
$strQuiz_LabStartPage = "Start Page";
$strQuiz_LabRequireField = "Require Fields";
$strQuiz_LabExplanationCopy = "This question is also included in the following modules";
$strQuiz_LabCoursesName="Courses Name";
$strQuiz_LabModules="Module Name";
$strQuiz_LabCreated="Created by";
$strQuiz_LabResultSearch="Result for";
$strQuiz_LabTotal="Total";
$strQuiz_LabNewSearch="New search";
$strQuiz_LabTaken="You've already taken all the questions in this quiz ";
$strQuiz_LabStart = "
                        <table width=\"98%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" class=\"bordertable\">
            </table>";
//-------------------------------  Resource -------------------------------------------
$strResource_LabFileName = "File Name: ";
$strResource_LabFileSize = "File Size:  ";
$strResource_LabUrlName = "URL Name: ";
$strResource_LabFolderName = "Folder Name: ";
$strResource_LabFileUpload = "File Upload: ";
$strResource_LabShowType = "Show Type: ";
$strResource_LabMove = "Move to Folder: ";
$strResource_LabDelete = "Delete: ";
$strResource_LabDiskUsage = "Disk Usage: ";
$strResource_LabUrl = "URL: ";
$strResource_LabGetFilePer = "Get Files From Personal: ";
$strResource_LabGetFileCenter = "Get Files From Resources Center";

$strResource_BtnAddFolder = $strAdd." Folder";
$strResource_BtnAddUrl = $strAdd." URL";
$strResource_BtnUploadFile = "Upload File";
$strResource_BtnEditFolder = $strEdit." Folder Name";
$strResource_BtnEditFile = $strEdit." File Name";
$strResource_BtnEditUrl = $strEdit." URL Name";
$strResource_BtnEditZip = $strEdit." Zip File";
$strResource_BtnFile = "File";
$strResource_BtnMove = "Move";
$strResource_BtnDelete = "Delete";
$strResource_BtnGetFiles = "Get Files";

$strResource_LabMang="Manage Resource in Course";
$strResource_LabResourceName="Resource name";
$strResource_LabFileDetail="File detail";
$strResource_LabEachResour="Total each resource : ";
$strResource_LabAllResour="Total all resources : ";
$strResource_LabStorage="Storage Usage";
$strResource_LabUsedSpace="Used Space : ";
$strResource_LabFreeSpace="Free Space : ";
$strResource_LabQuota="Your Quota : ";

//-------------------------------  Research  -------------------------------------------
//-------------------------------  Score Card  -------------------------------------------
//------------------------------- Syllabus-------------------------------------------
$strSyllabus_Header = "Course Syllabus";

$strSyllabus_LabSelectType = "Select Type Syllabus";
$strSyllabus_LabBasic = "Basic Syllabus";
$strSyllabus_LabAdvance = "Advance Syllabus";
$strSyllabus_LabEditFile = $strEdit." Syllabus File";
$strSyllabus_LabDelFile = $strDelete." Syllabus File";
$strSyllabus_LabEditAdvance = $strEdit." Syllabus";
$strSyllabus_LabFileName = "File Name";
$strSyllabus_LabFileType = "File Type";
$strSyllabus_LabFileSize = "File Size";
$strSyllabus_LabNo = "Occ.";
$strSyllabus_LabDate = "Date";
$strSyllabus_LabTime = "Time";
$strSyllabus_LabTopic = "Topic";
$strSyllabus_LabWay = "Teaching Way";

//------------------------------- System-------------------------------------------
$strSystem_Header = "M@xLearn Management";
$strSystem_LeftMenu = "My System";

$strSystem_LabUser = "Users Management";
$strSystem_LabSystem = "System Administration";
$strSystem_LabMaster = "Master Data Administration";
$strSystem_LabCourses = "Courses Management";
$strSystem_LabReport = "Report Management";         //******

$strSystem_MenuHome = "Home";
$strSystem_MenuUser = "Users";
$strSystem_MenuSystem = "System";
$strSystem_MenuMaster = "Master";
$strSystem_MenuCourses = "Courses";
$strSystem_MenuReport = "Report";                                  //******

$strSystem_LabNewUser = "New User";
$strSystem_LabActiveUser = "Active Users";
$strSystem_LabInactiveUser = "In-Active User";
$strSystem_LabSortBy = "Sort by";
$strSystem_LabUserType = "User Type";
$strSystem_LabUserStatus = "User Status";
$strSystem_LabUserAdmin = "User Admin";
$strSystem_LabAdminPer = "Admin Permission";
$strSystem_LabUserPer = "User Permission";
$strSystem_LabAddEditPer = "Add or Edit Permissions";
$strSystem_LabLevel = "Level";
$strSystem_LabGrant = "Grant";
$strSystem_LabRequired = "Required field";
$strSystem_LabCurrentPass = "Current Password";
$strSystem_LabNewPass = "New Password";
$strSystem_LabRepeatPass = "Repeat New Password";
$strSystem_LabImpUser = "Import User";                         //****
$strSystem_LabImpFile="File name";                                                                 //****
$strSystem_LabImpChar="Delimeter";                                                                 //****
$strSystem_LabImpEx="Example file";                                                        //****
$strSystem_LabImpAdd="Add from file";                                                         //****
$strSystem_LabImpError="List user can't import";                        //****
$strSystem_LabImpEmpty="Data Repeat";               //****
$strSystem_LabImpAlre="Data Already";               //****
$strSystem_LabChangePWUpdate="You password update...";
$strSystem_LabChangePWWrong="You password wrong";
$strSystem_LabChangePWValidNew="New password must be at least 3 characters.";
$strSystem_LabChangePWNoMatch="New password entries did not match.";
$strSystem_LabChangePWValidOld="Old Password  to be empty";
$strSystem_LabChangePWValidNewEmpty="New Password  to be empty";

$strSystem_LabModule = "System Modules";
$strSystem_LabViewModule = $strView." Modules";
$strSystem_LabBackup = "System Backup";
$strSystem_LabBackupDb = "Backup Database";

$strSystem_LabDisplay = "Display";
$strSystem_LabDisplaySetup = "Display Setting";
$strSystem_LabDisplayColorRed = "Red";
$strSystem_LabDisplayColorBlue = "Blue";
$strSystem_LabDisplayColorGreen ="Green";
$strSystem_LabFirstpage = "First page";
$strSystem_LabControlFirstpage = "Control First page";




$strSystem_LabSubModule = "Modules";
$strSystem_LabModuleStatus = "Status";
$strSystem_LabModuleUrl = "Url";
$strSystem_LabModuleUrlAdmin = "Url Admin";
$strSystem_LabModuleUrlSetup = "Url Setup";
$strSystem_LabModuleInfo = "Info";
$strSystem_LabModulePicture = "Picture";

$strSystem_LabAcademicData = "Academic Data";
$strSystem_LabAcademic = "Academic Organization";

$strSystem_LabEvaluationData = "Evaluation Data";
$strSystem_LabEvaluation = "Evaluation Management";

$strSystem_LabCampus = "Campus";
$strSystem_LabFaculty = "Faculty";
$strSystem_LabDept = "Department";
$strSystem_LabMajor = "Major";

$strSystem_LabNo = "No.";
$strSystem_LabCamId = "Campus Id";
$strSystem_LabCamNameTh = "Campus Name (Thai)";
$strSystem_LabCamNameEng = "Campus Name (Eng)";
$strSystem_LabCamUrl = "Campus Website";

$strSystem_LabFacNameTh = "Faculty Name (Thai)";
$strSystem_LabFacNameEng = "Faculty Name (Eng)";
$strSystem_LabFacUrl = "Faculty Website";

$strSystem_LabDeptNameTh = "Department Name (Thai)";
$strSystem_LabDeptNameEng = "Department  Name (Eng)";
$strSystem_LabDeptUrl = "Department  Website";

$strSystem_LabMajorNameTh = "Major Name (Thai)";
$strSystem_LabMajorNameEng = "Major Name (Eng)";
$strSystem_LabMajorUrl = "Major Website";

$strSystem_LabClickDept = $strClick.$strSystem_LabFacNameTh." To see ".$strSystem_LabDept;
$strSystem_LabClickMajor = $strClick.$strSystem_LabDeptNameTh." To see ".$strSystem_LabMajor;

$strSystem_BtnNewCam = "new campus";
$strSystem_BtnNewFac = "new faculty";
$strSystem_BtnNewDept = "new department";
$strSystem_BtnNewMajor = "new major";

$strSystem_LabActiveCourses= "Active Courses";
$strSystem_LabInactiveCourses = "In-Active Courses";

//-------------------------Import/Export Data-------------------------------------
$strImport_LabImport="Import";
$strImport_LabExport="Export";
$strImport_LabData="Data";
$strImport_LabSelectImport= "File for import";
$strImport_LabTypeQuiz="Quiz";
//********menu report********
$strSystem_RMenuHeader = "User Events";
$strSystem_RMenuAll = "All";
$strSystem_RMenuCourse = "Courses";
$strSystem_RMenuModules = "Modeules";
$strSystem_RMenuLogin = "Login";
$strSystem_RMenuLogout= "Logout";

$strSystem_RHeader = "Display";
$strSystem_LabReportTime= "Time Limit";
$strSystem_LabReportTo= "To";

$strSystem_ListReportTime= "Date / Time";
$strSystem_ListReportName= "LoginName";
$strSystem_ListReportAction= "Action";
$strSystem_ListReportModules= "Modules";
$strSystem_ListReportCourses= "Courses";

$strSystem_CReportCreate= "Create Courses";
$strSystem_CReportUpdate= "Update Courses";
$strSystem_CReportDelete= "Delete Courses";
$strSystem_CReportApply= "Apply Courses";
$strSystem_CReportDrop= "Drop Courses";

$strSystem_MReportFolder= "Folder";
$strSystem_MReportGroup= "Groups";
$strSystem_MReportForum= "Forum";
$strSystem_MReportWebboard= "Webboard";
$strSystem_MReportResources= "Resourcess";
$strSystem_MReportQuiz= "Quiz";
$strSystem_MReportHW= "E-Homework";

$strSystem_LabUserTypeAll = "All";
$strSystem_LabUserTypeAdmin = "Admin";
$strSystem_LabUserTypeInstructor = "Instructor";
$strSystem_LabUserTypeStudent = "Student";

$strSystem_LabUserPrint = "Print Report";
$strSystem_LabUserPrintHeader= "Report Data";
//------------------------------- Activity -------------------------------------------
$strActivity_SelectModule = "Select a module";
$strActivity_LabModuleName = "Module Name";
$strActivity_LabStat = "Statistics";
$strActivity_LabByUser = "By Users";
$strActivity_LabCurrentWeek = "Current Week ";
$strActivity_LabTotalLogin = "Total nr of Logins ";
$strActivity_LabNrPost = "Nr of Posting users ";
$strActivity_LabTotalPost = "Total nr of postings ";
$strActivity_LabWeek = "Week";
$strActivity_LabLogin = "Logins ";
$strActivity_LabPost = "Postings ";

//----------------------------Webboard------------------------------
$strWebboard_LabSubject="Subject";
$strWebboard_LabIcon="Icon of Subject";
$strWebboard_LabMessage="Fill Message";
$strWebboard_LabSmilies="Smilies";
$strWebboard_LabPicture="Attach Picture";
$strWebboard_LabTextSize="Size not more than 50 KB";
$strWebboard_LabDeletePic="Delete Picture";
$strWebboard_LabSearch="Search topic in";
$strWebboard_LabHPre="Personal preferences for";
$strWebboard_LabHDatail="Show Subject & Detail:";
$strWebboard_LabSDatail="This option requires javascript";
$strWebboard_LabHThread="Show thread:";
$strWebboard_LabHDESC="Sort descending:";
$strWebboard_LabSDESC="Show the last subject first";
$strWebboard_LabHMail="Subscribe:";
$strWebboard_LabSMail="Receive a mail for every new contribution";
$strWebboard_LabHDate="Show the last:";
$strWebboard_LabDate="Days";
$strWebboard_LabUpload="Attach picture that end in : ";


//-----------------------------------------------  Msg + Evaluate [Kae]---------------------------
$strPersonal_MenuMsg = "Message Box";
$strPersonal_msg_inbox = "Inbox";
$strPersonal_msg_Sentbox =  "Sentbox";
$strPersonal_msg_Outbox = "Outbox";
$strPersonal_msg_Savebox= "Savebox";
$strPersonal_Pri_Priority= "Priority";
$strPersonal_Pri_High= "High";
$strPersonal_Pri_Normal= "Normal";
$strPersonal_Pri_Low= "Low";
$strPersonal_msg_Subject= "Subject";
$strPersonal_msg_From= "From";
$strPersonal_msg_To= "To";
$strPersonal_msg_Message= "Message";
$strPersonal_msg_New= "New Message";
$strPersonal_msg_Date= "Date";
$strPersonal_msg_Search= "Search...";
$strPersonal_msg_SentComplete ="Sent Complete!!!";
$strPersonal_msg_SentEditTo = "Please insert in box ' To' ";
$strPersonal_msg_SentEditMsg ="Please insert in box ' Message' ";
$strPersonal_msg_Non = "none ";
$strPersonal_msg_PleaseSelect ="Please select user group";
$strPersonal_msg_KeyWord = "key word";
$strPersonal_msg_All = "All user group";
$strPersonal_msg_Admin = "Admin ";
$strPersonal_msg_Teacher = "Teacher";
$strPersonal_msg_Student = "Student";
$strPersonal_msg_NotFound = "Sorry! Not Found this Name,Please Find again.";
$strPersonal_msg_SelectName =" Select ";
$strPersonal_msg_Answer =" Post Reply ";
$strPersonal_msg_AlreadySave =" Save Successful ";
$strPersonal_msg_AlreadyDel=" Delete Successful ";

$strPersonal_msg_ChooseMsg= " Please Choose any message  to Save or Delete!!! ";
$strPersonal_msg_ErrorNoMsg= " There are no messages in your  messages box ";
$Calendar_appointment  =" Today's Appointment";
$Calendar_Noappointment  ="Not Have Appointment ";
$INFO_HOMEWORK ="Homework ";
$INFO_CAUSE_TITLE ="Subject ";
$INFO_DEADLINE_TITLE ="Deadline";
$INFO_NotHaveHomework =" Not Have Homework ";
$INFO_Quiz =" Quiz ";
$INFO_NotHaveQz =" Not Have Quiz ";
$INFO_Webboard="Webboard ";
$INFO_NotHaveWeb="Not Have Webboard ";

$INFO_EVAL_title ="Evaluate";
$EVAL_NEW_NAME ="New Name";
$EVAL_NOT = "Not Have Evaluate";
$INFO_EVAL_dead="Deadline";
$Eval_Num="No.";
$Eval_Question="Question ";
$Eval_Action ="Action ";
$Eval_Score ="Score Level";
$Eval_StdQues ="Standard Questions";
$Eval_TeaQues ="Lecturer Questions";
$Eval_AddstdQues ="Add Standard Questions";
$Eval_AddGroupQues= "New Group Questions";
$FullCharacters=" Limit 255 characters";
$Eval_AddTeaQues ="Add Questions";
$chooseQues="Choose Questions";
$AddChoice="Add Choice Questions";
$AddFill="Add Fill in Blank Questions";  //*****
$ChoiceQues="Choice Questions";
$FillQues="Fill  in Blank Questions";  //*******
$choice="Choice";
$AddAlt="Add Choice";
$Eval_GroupName= "Group Name";
$Eval_NOTStdQues ="Not  Found Standard Questions";
$Eval_NOTTeaQues ="Not  Found Teacher Questions";
$unitPerStd="Unit : Person";
$Eval_total="Total";
$strEvalMaxScore="Max Score";
$strEvalAverageScore="Average Score";
$listSTD = "List who have not evaluate";
$Eval_StdNum="No.";
$Eval_SendMail="Send mail";
$Eval_SendAll="Send All";
$Std_NAME="Name";
$Eval_descripe ="Description";
$Eval_year="Year";
$Eval_semester ="Semester";
$Eval_startDate ="Start Date";
$Eval_endDate ="End Date";
$EVALDESCRIPT = "Evaluate Description";
$EVALRESULT ="Evaluate Result ";
$HOME_Link = "Home";
$RES_Everage="Evaluate result display Point average";
$RES_Person ="Evaluate result display Answer summation";
$Check_no_Eval="Check list who have not evaluate";
$CHOICE_1 = "Choice 1";
$CHOICE_2 = "Choice 2";
$CHOICE_3 = "Choice 3";
$CHOICE_4 = "Choice 4";
$CHOICE_5 = "Choice 5";
$CHOOSE_Q="Choose Questions";
$EVE_standrd="Point average of standard evaluation ";
$EVE_user="Point average of lecturer evaluation ";
$FROM_Std = " from ";
$NUM_PER="person";
$POINTS ="points level";
$EXAMPLE ="Example";
$EDIT_QC="Update Choice Questions";
$EDIT_QF = "Update Fill in Blank Questions";
$EDIT_GROUP="Update Group Name";
$ALTERNATIVE="Alternative";
$NEW_GROUPNAME ="New Group Name ";
$NOTDO="Have Not  Evaluate";
$ALREADYDO="Already Evaluated";
$EVAL_STATUS="Status";
$MUST_DO="Just Do Now";
$LOOK_EVAL = "Look Evaluate Result";
$COS_EVAL ="EVALUATION OF COURSE ";
$NO_DATA="Evaluate Not Have Data";
$Create_TITLE="Teaching  Evaluate System : TES";
$SHOW_Finish ="Show Evaluate Result when Deadline";
$EVAL_SHOW_STD = "Show result for students";
$EVAL_SURVEY_RES = "Evaluate Result";
//-----------------------------------------------  Msg [Kae]---------------------------

//--------------------- Grade ------------------------------

$strGrade_HeaderGrade = "M@xGrade System";
$strGrade_MenuGrade = "Calulate Grade";
$strGrade_LabShowGrade = "Show Grade";
$strGrade_LabPreference  = "Preference";
$strGrade_Labhelp                                = "Help";
$strGrade_LabExport          = "Export Grade";
$strGrade_LabProgress      = "Grade Step";
$strGrade_LabSetRatio      = "Set Ratio";
$strGrade_LabInputScore  = "Input Scores";
$strGrade_LabSetLevelType   = "Set Level Type";
$strGrade_LabSetScoreType   = "Set Score level";
$strGrade_LabReport          = "Show grade report";
$strGrade_LabNo                                   = "No.";
$strGrade_LabScoreName  = "Name";
$strGrade_LabGroup            =  "Group";
$strGrade_LabGrade            = "Grade";
$strGrade_LabScore                                = "Score";
$strGrade_LabComment      =  "Comment";
$strGrade_LabTotal              = "Total";
$strGrade_LabAdd                = "ADD";
$strGrade_LabType                                = "Type";
$strGrade_LabGroupName  = "Group Name";

$strGrade_LabSelectGroup =  "Select group";
$strGrade_LabMaxScore     = "Max score";
$strGrade_LabCreateGroup = "new";
$strGrade_LabShowGroup   = "showgroup";
$strGrade_LabID                                        = "ID";
$strGrade_LabNameLastname = "Name-Lastname";
$strGrade_LabFrequency = "Frequency";
$strGrade_LabHeadSelectType = "Select Level type";
$strGrade_LabSelectType = "Select type";
$strGrade_LabCriteria = "criteria grading";
$strGrade_LabGroupGrading = "group grading";
$strGrade_LabVarGrading = "variable grading";
$strGrade_LabTscore = "T-score grading";
$strGrade_LabLevel = "level";
$strGrade_LabSelectLevel  = "Select Level";

$strGrade_LabStdscore = "Standardized score (Z)";
$strGrade_LabSelectStdscore = "-Select Standardized score-";
$strGrade_LabExcellent = "Excellent";
$strGrade_LabVeryGood = "Very good";
$strGrade_LabGood = "Good";
$strGrade_LabFairlyGood = " Fairly good";
$strGrade_LabFair = " Fair";
$strGrade_LabPoor = "Poor";
$strGrade_LabVeryPoor = "Very poor";

$strGrade_LabGradeLevel = "Grade Level";
$strGrade_LabMinScore  = "Minimize Score";
$strGrade_LabMaxScore1  = "Maximize Score";
$strGrade_LabCatetype   = "Category Type";
$strGrade_LabLeveltype  = "Level Type";
$strGrade_LabActive         = "Active";
$strGrade_LabInActive     = "Inactive";
$strGrade_LabAnalysis     = "Analysis Values";
$strGrade_LabStdDvt        = "Standard deviation";
$strGrade_LabMean          = "Mean Values";
$strGrade_LabMedian      = "Median Values";
$strGrade_LabMaxValue  = "Maximum Value";
$strGrade_LabMinValue  = "Minimum Value";
$strGrade_LabHeadSummary  = "Grade Summary";
$strGrade_LabSummary  = "Summary";

$strGrade_LabAmountSt = "Student Total";
$strGrade_LabScoreLevel = "Score Level";
$strGrade_LabPercent = "Percent";
$strGrade_LabGraph    = "Grade Graph";
$strGrade_LabGraphBar    = "Bar Graph";
$strGrade_LabGraphCircle   = "Circle Graph";
$strGrade_PrefRawscore   =  "View raw score";
$strGrade_PrefviewAll   =  "View Grade Student All";
$strGrade_Prefactive    = "Active";

$strGrade_SelectModule = "Select";
$strGrade_HeadListModule = "List modules for use grading";
$strGrade_ModuleName = "Name";
$strGrade_ModuleTotalscore = "Totalscores";



$strGrade_BtnCalgrade =  "Calulate Grade";
$strGrade_BtnNext        = "Next&gt;&gt;";
$strGrade_BtnBack        = "&lt;&lt;Back";


//--------------------------------------------   Content [KAE]-----------------------------------------------------------------------------------------------------
$Content_Content =  "Content ";
$Content_Lesson =  "Lesson ";
$Content_LessNum =  "Lesson No.";
$Content_LessName =  "Lesson Name";
$Content_Abstract =  "Abstract";
$Content_Times =  "Times";
$Content_AddLess =  "Add Lesson";
$Content_UpdateLess =  "Update Lesson";
$Content_UpdateCon =  "Update Content";
$Content_NewContent =  "New Content";
$Content_TimeUnit =  "Times";
$Content_NOTHAVE =  "NOT FOUND CONTENT";
$Content_LessNmEdit =  "Edit Lesson Name ";
$Content_LessEdit =  "Edit Lesson ";
$Content_LessShow =  "Show Lesson ";
$Content_HOME =  "Home ";

//--------------------------------------------   Content [KAE]-----------------------------------------------------------------------------------------------------
//--------------------- Forum -------------------------

$strForum_Labwelcome="Welcome ";
$strForum_Labto=" to ";
$strForum_Labmsg="Message";
$strForum_Labwrite_msg="Compose Message";
$strForum_Labsend=" Send ";
$strForum_Laboption="Options";
$strForum_Labpreference="Edit Preference";
$strForum_Labexit="Exit Chat";
$strForum_Labuserlist="User List online";
$strForum_Labshowemotion="Emotion";

//--------------------------------------------   Content [KAE]-----------------------------------------------------------------------------------------------------
$EVAL_Cat = "Evaluate Category";
$EVAL_Perceptual = "Perceptual Learning Style Preference Survey";
$EVAL_TEACHER="Teaching  Evaluate System : TES";
$EVAL_Amount= "Amount";
$EVAL_Persons= "Persons";
$EVAL_Perceptual_title= " Learning Style Preference";
$EVAL_Student_All= "All Registered ";
$EVAL_Visual_DES =  "You learn well from seeing words in book, on the chalkboard, and in workbooks. You remember and understand information and instructions better if you read them. You don't need as much oral explanation as an auditory learner,and you can often learn alone with a book. You should take notes of lectures and oral directions if you want to remember the information.";
$EVAL_Tactile_DES = "You learn best when you have the opportunity to do \"hand-on\" experiences with materials. That is, working on experiments in a laboratory, handing and building models, and touching and working with materials provide you with the most successful learning situations. Writing notes or instructions can help you remember information, and physical involvement in class-related activities may help you understand new information.";
$EVAL_Auditory_DES = "You learn from hearing words spoken and from oral explanation. You may remember information by reading aloud or by moving your lips as you read,especially when you are learning new material. You benefit from hearing audiotapes, lectures, and class discussion. You benefit from making tapes to listen to,by teaching other students, and by conversing with your teacher.";
$EVAL_Group_DES = "You learn more easily when you study with at least one other student, and you will be more successful completing work well when you work with others.  You value group interaction and class work with other student, and you remember information better when you work with two or three classmates. The stimulation you receive from group work helps you learn and understand new information. ";
$EVAL_Kinesthetic_DES = "You learn beat by experience,by being involved physically in classroom experiences. You remember information well when you activity participate in activities,field trips, and role-playing in the classroom. A combination of stimuli for example, an audio tape combined with an activity-well help you understand new material.";
$EVAL_Individual_DES = "You learn best when you work alone. You think better when you study alone, and you remember information you learn by yourself. You understand materials best when you learn it alone, and you make better progress in learning when you work by yourself.";

$EVAL_Visual_NAME = "Visual  Major Learning Style Preference";
$EVAL_Tactile_NAME ="Tactile Major Learning Style Preference" ;
$EVAL_Auditory_NAME = "Auditory Major Learning Style Preference";
$EVAL_Group_NAME = "Group Major Learning Style Preference";
$EVAL_Kinesthetic_NAME  ="Kinesthetic Major Learning Style Preference";
$EVAL_Individual_NAME="Individual Major Learning Style Preference";

?>