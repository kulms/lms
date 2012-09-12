<?php
/* $Id: thai.inc.php,v 1.146 2002/06/19 00:18:17 lem9 Exp $ */


/**
 * Translated on 2002/04/29 by: Arthit Suriyawongkul & Warit Wanasathian
 * Revised on 2002/06/18 by: Arthit Suriyawongkul
 */

// note: Thai has 2 standard encodings (tis-620, iso-8859-11)
// tis-620 is the only Thai encoding that registered with IANA,
// it used in MIME text/* media type.
$charset = 'tis-620';
$text_dir = 'ltr';
$left_font_family = 'sans-serif';
$right_font_family = 'sans-serif';
$number_thousands_separator = ',';
$number_decimal_separator = '.';
$byteUnits = array('ไบต์', 'กิโลไบต์', 'เมกกะไบต์', 'กิกะไบต์');

$day_of_week = array('อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์');
$month = array('ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.');
// See http://www.php.net/manual/en/function.strftime.php to define the
// variable below
$datefmt = '%e %B %Y  %R น.';
//------------------    For Common Feather -----------------------------------

$strAdd="เพิ่ม";
$strBack="ย้อนกลับ";
$strEdit="แก้ไข";
$strDelete="ลบ";
$strDeletePic="ลบภาพประกอบ";
$strNext="ถัดไป";
$strPrevious="ก่อนหน้า";
$strBack="ย้อนกลับ";
$strSubmit="ยืนยัน";
$strCreate="สร้าง";
$strReset="ตั้งค่าใหม่";
$strCancel="ยกเลิก";
$strUpdate="ปรับปรุง";
$strShow="แสดง";
$strSave="บันทึก";
$strSearch="ค้นหา";
$strView="ดู";
$strResult="ผลการทำงาน";
$strLink="เชื่อมโยง";
$strSend="ส่ง";
$strClose="ปิด";
$strActive = "ใช้งาน";
$strDisable = "ปิดการใช้งาน";
$strClick = "คลิ้ก";
$strSet = "ตั้งค่า";
$strYes = "ใช่";
$strNo = "ไม่";
$strRemove = "นำออก";
$strAction = "กระบวนการ";
$strPage = "หน้าที่";

//-----------------------------------------------------------------------------------------

//-------------------------  For Each Modules ------------------------------------

//-------------------------  Top Frame ---------------------------------------------
$strTop_MenuStart = "หน้าแรก";
$strTop_MenuPersonal = "ข้อมูลบุคคล";
$strTop_MenuCourses = "ข้อมูลรายวิชา";
$strTop_MenuSystem = "ข้อมูลระบบ";
$strTop_LabUser = "ผู้ใช้ขณะนี้ : ";
$strTop_LabLogout = "ออกจากระบบ";

//-------------------------  Start Page ---------------------------------------------
$strStart_MenuECourse = "ศุนย์รวมแหล่งความรู้กลาง";
$strStart_MenuStat = "สถิติการใช้งานรายวิชา";
$strStart_Header = "หน้าแรก";
$strStart_LabManual = "คู่มือการใช้งาน";
$strStart_LabForum = "กระดานอภิปราย";
$strStart_LabHomework = "ระบบส่งการบ้าน";
$strStart_LabQuiz = "แบบทดสอบและแบบสำรวจ";
$strStart_LabResources = "แหล่งข้อมูล";
$strStart_LabSyllabus = "แผนการเรียน";
$strStart_LabWebboard = "กระดานข่าว";
$strStart_LabAll = "คู่มือทั้งหมด";
$strStart_LabMaxWebboard = "กระดานข่าว M@xLearn";
$strStart_LabRecommend = "Webboard สำหรับการรายงานข้อผิดพลาด และแนะนำข้อการใช้งานระบบสนับสนุนการเรียนการสอนผ่านเว็บ";

//-------------------------  Personal ---------------------------------------------
$strPersonal_MenuCalendar = "ปฎิทินส่วนบุคคล";
$strPersonal_BtnEditPersonal = $strEdit." ข้อมูลส่วนบุคคล";
$strPersonal_Header = "ข้อมูลส่วนบุคคล";
$strPersonal_LabUserHeader = "ข้อมูลส่วนบุคคล";
$strPersonal_LabTitleTh = "คำนำหน้าชื่อ (ไทย)";
$strPersonal_LabTitleEng = "คำนำหน้าชื่อ (อังกฤษ)";
$strPersonal_LabNameTh = "ชื่อ (ไทย)";
$strPersonal_LabNameEng = "ชื่อ (อังกฤษ)";
$strPersonal_LabSurNameTh = "นามสกุล (ไทย)";
$strPersonal_LabSurNameEng = "นามสกุล (อังกฤษ)";
$strPersonal_LabNameSurNameTh = "ชื่อ-นามสกุล (ไทย)";
$strPersonal_LabNameSurNameEng = "ชื่อ-นามสกุล (อังกฤษ)";
$strPersonal_LabTeacherCode = "รหัสอาจารย์";
$strPersonal_LabUserName = "รหัสผู้ใช้";
$strPersonal_LabChangePassword = "เปลี่ยนรหัสผ่าน";
$strPersonal_LabPassword = "รหัสผ่าน";
$strPersonal_LabFac = "คณะ";
$strPersonal_LabDep = "ภาควิชา";
$strPersonal_LabEmail = "อีเมลล์";
$strPersonal_LabOtherEmail = "อีเมลล์อื่น ๆ";
$strPersonal_LabHomepage = "โฮมเพจ";
$strPersonal_LabPicture = "รูปภาพ";
$strPersonal_LabIcq = "ไอซีคิว";
$strPersonal_LabSkill = "ความถนัด / ความสนใจ ";
$strPersonal_LabOfficeHeader = "สถานที่ติดต่อที่ทำงาน";
$strPersonal_LabOfficeOutHeader = "สถานที่ติดต่อนอกที่ทำงาน";
$strPersonal_LabHomeHeader = "สถานที่ติดต่อที่พัก";
$strPersonal_LabBuilding = "ตึก";
$strPersonal_LabRoom = "ห้อง";
$strPersonal_LabIntPhone = "เบอร์ภายใน";
$strPersonal_LabAddress = "ที่อยู่";
$strPersonal_LabTelephone = "เบอร์ติดต่อ";
$strPersonal_LabMobile = "มือถือ";
$strPersonal_LabLanguage = "ภาษา";
$strPersonal_LabPostalAddress = "ที่อยู่";
$strPersonal_LabIDCode = "รหัสประจำตัว";
$strPersonal_LabIDCodeError = "กรอกรหัสประจำตัว เป็นตัวเลขเท่านั้น";
$strPersonal_LabLastLogin = "ใช้งานครั้งสุดท้าย";
$strPersonal_LabNeverLogin = "ยังไม่เคยเข้าสู่ระบบ";

//-------------------------------  Calendar  -------------------------------------------
  //$strCaledarAbc="อะไรก็ว่าไป";
$strCalendar_LabShare="ปฏิทินร่วม";
$strCalendar_LabThisMonth="ปฏิทินเดือนนี้";
$strCalendar_LabSelectYear="เลือกปี";
$strCalendar_LabSelectMonth="เลือกเดือน";
$strCalendar_LabSelectUser="เลือกผู้ใช้";
$strCalendar_LabViewFrom="เลือกปฏิทินจาก";
$strCalendar_LabViewFromAll="ทั้งหมด";
$strCalendar_LabViewFromPersonal="ส่วนบุคคล";
$strCalendar_LabMonthAsList="ดูรายการเป็นเดือน";
$strCalendar_LabApp="รายการนัดหมาย";
$strCalendar_LabAddNewApp="เพิ่มรายการนัดหมายใหม่";
$strCalendar_LabShowDetailApp="แสดงรายละเอียดรายการนัดหมาย";
 $strCalendar_LabAddNewAppTo="เพิ่มรายการนัดหมายใหม่ไปยัง"; 
 $strCalendar_LabPerCal="ปฏิทินส่วนบุคคล";
 $strCalendar_LabStart="เวลาเริ่มต้น";
$strCalendar_LabLength="ใช้เวลา";
$strCalendar_LabTitle="หัวข้อ";
$strCalendar_LabDesc="รายละเอียด";
$strCalendar_LabAppDel="รายการนัดหมายถูกลบแล้ว";
$strCalendar_LabDate="วันที่";
$strCalendar_LabTime="เวลา";
$strCalendar_LabCourse="รายวิชา";
$strCalendar_LabNewDate="วันที่ใหม่";
$strCalendar_LabMonthView="มุมมองเดือน";
$strCalendar_LabThisWeek="สัปดาห์นี้";
$strCalendar_LabWeek="สัปดาห์";

  
//-------------------------------  Course Member -------------------------------------------
//-------------------------------  Courses  -------------------------------------------
$strCourses_Header = "ส่วนการใช้งานรายวิชา";
$strCourses_MenuMainCourses = "รายวิชา";
$strCourses_MenuActiveCourses = "รายวิชาที่ใช้งาน";
$strCourses_MenuCreateCourses = "สร้างรายวิชา";
$strCourses_MenuDelCourses = "ลบรายวิชา";
$strCourses_MenuInActiveCourses = "รายวิชาที่ไม่ใช้งาน";

$strCourses_LabStdListApply = "รายชื่อผู้ใช้ [สมัครเข้าเรียน]";
$strCourses_LabStdListWithdraw = "รายชื่อผู้ใช้ [ถอนรายวิชา]";
$strCourses_LabCourseId = "รหัสวิชา";
$strCourses_LabCourseName = "ชื่อรายวิชา";
$strCourses_LabStdNo = "ลำดับที่";
$strCourses_LabStdName = "ชื่อ-นามสกุล";
$strCourses_LabStdEmail = "อีเมลล์";
$strCourses_LabStdApply = "สมัครวิชา";
$strCourses_LabStdGrant = "อนุญาต";
$strCourses_LabStdWithdraw = "ถอนรายวิชา";
$strCourses_LabStdRefuse = "ปฎิเสธ";

//----------- Course News-------------------

$strCourses_LabCourseNews = "ข่าวประกาศรายวิชา";
$strCourses_LabCourseSection = "หมู่";
$strCourses_LabCourseSemester = "ภาคเรียน";
$strCourses_LabCourseYear = "ปีการศึกษา";
$strCourses_LabCourseNewsDetail = "เนื้อหาข่าว";
$strCourses_NewsNo = "ลำดับ";
$strCourses_NewsPicture = "ภาพ";
$strCourses_NewsSubject = "หัวข้อข่าว";
$strCourses_NewsLimit = "ระยะเวลาประกาศ";
$strCourses_NewsHeaderadd = "เพิ่มข่าวรายวิชา";
$strCourses_NewsHeaderedit = "แก้ไขข่าวรายวิชา";
$strCourses_NewsHeaderview = "ดูข่าวรายวิชา";
$strCourses_NewsHeaderinfo = "ส่วนหัวข้อข่าว";
$strCourses_NewsFile= "รูปภาพ";
$strCourses_NewsThumbpic= "ภาพประกอบ";
$strCourses_NewsPreview= "แสดงภาพ";
$strCourses_NewsPictype= "ไฟล์ ชนิด .gif, .jpg , .jpeg ";
$strCourses_NewsEnter = "กด Shift+Enter เพื่อขึ้นบรรทัดใหม่";
$strCourses_NewsMsg	="***หากไม่กำหนดวันสิ้นสุดการประกาศข่าวนั้นจะมีอายุ 7 วัน ***";

$strCourses_NewsContent = "เนื้อหาข่าว";
$strCourses_NewsExpire = "ระยะเวลาแสดง";
$strCourses_NewsLastupdate = "แก้ไขล่าสุดเมื่อ";
$strCourses_NewsExpiredate= "วันสิ้นสุดประกาศ";
$strCourses_NewsDisplay= "รูปแบบประกาศ";
$strCourses_NewsDisplayFirstpage= "ประกาศสู่หน้าแรกของระบบด้วย ";
$strCourses_NewsDisplayCourses= "ประกาศเฉพาะในรายวิชานี้";
$strCourses_NewsTitle = "รายละเอียดข่าว";
$strCourses_NewsDelpic = "ลบรูปภาพ";
$strCourses_NewsTotal = "จำนวนข่าว: ";
$strCourses_NewsNotfound = "ไม่พบข่าวรายวิชา";

//-----------------------------------------------

$strCourses_DetailCreateCourses = "<p> <b>สำหรับอาจารย์ที่พร้อมจะสร้างรายวิชาแบบเต็มรูปแบบเพื่อให้บริการกับนิสิต ประโยชน์ที่ได้</b></p>
																		<ul>
																		  <li><b>แผนการเรียน</b> แบบกรอกข้อมูลลงแบบฟอร์มที่กำหนด ทำให้สะดวกแก่การค้นหา และนำไปใช้ประโยชน์ได้</li>
																		  <li><b>ตารางสอน </b>ในรูปแบบปฏิทินการเรียนสอนอัตโนมัตินักเรียนที่ลงทะเบียนเห็นตารางเรียนนี้ทุกคน</li>
																		  <li>เครื่องมือเก็บเอกสารประกอบการสอนสร้างให้ตามตารางสอนอัตโนมัติ</li>
																		  <li>นิสิตที่เรียนลงทะเบียนกับทางมหาวิทยาลัยเข้าเป็นสมาชิกวิชา เพื่อมีกิจกรรมการสอนบนเว็บได้ทันที</li>
																		  <li>มีเครื่องมืออื่น ๆ เช่น <b>Webboard Chatroom แบบสร้าง ข้อสอบ Online และอีกมากมาย </b>
																		  </li>
																		</ul>";

$strCourses_DetailApplyCourses = "<p><b><u>ขั้นตอน</u></b></p>
																		<ol>
																		  <li>ค้นหาวิชาที่จะลงเรียน</li>
																		  <li>กดที่ปุ่ม <b>apply </b>
																			<ol type=\"a\">
																			  <li>วิชาที่ระบุว่า <b>open</b> จะเข้าได้ทันที</li>
																			  <li>วิชาที่ระบุว่า <b>Approve</b> เมื่อสมัครแล้วจะต้องรอการอนุญาตจากอาจารย์ประจำวิชา</li>
																			</ol>
																		  </li>
																		</ol>";

$strCourses_DetailWithdrawCourses = "<p><u><b>ขั้นตอน</b></u></p>
																				<ol>
																				  <li>กดที่ปุ่ม <b>Withdraw</b>
																					<ol type=\"a\">
																					  <li>วิชาที่ระบุว่า <b>open</b> จะถอนออกได้ทันที</li>
																					  <li>วิชาที่ระบุว่า <b>Approve</b> เมื่อร้องขอการถอนแล้วจะต้องรอการอนุญาตจากอาจารย์ประจำวิชา 
																					  </li>
																					</ol>
																				  </li>
																				</ol>";
																				
$strCourses_LabCourseApply = "สมัครเรียนรายวิชา";
$strCourses_LabCourseApplyList = "รายการรายวิชา";

$strCourses_LabSearchCourse = "ค้นหารายชื่อวิชา";
$strCourses_LabSelectByCourse = "เลือกโดยใช้ข้อมูลรายวิชา";
$strCourses_LabSelectByInstructor = "เลือกโดยใช้ข้อมูลผู้สอน";
$strCourses_LabInsName = "ชื่อผู้สอน";
$strCourses_LabInsSurname = "นามสกุลผู้สอน";
$strCourses_LabInsFac = "คณะ";
$strCourses_LabShowAll= "แสดงรายวิชาทั้งหมด";
$strCourses_LabStatus= "สถานะ";
$strCourses_LabProcess= "ทำรายการ";
$strCourses_LabClose= "ปิด";
$strCourses_LabApplied= "สมัครไปแล้ว";
$strCourses_LabApply= "สมัคร";
$strCourses_LabOpen= "เปิด";
$strCourses_LabApprove= "ตรวจสอบ";
$strCourses_LabWithdraw= "ถอน";
$strCourses_LabWait= "รอ";
$strCourses_LabTotalCourse = "รายวิชาทั้งหมด";
$strCourses_LabNotFound = "ไม่พบรายวิชาตามเงื่อนไขที่ระบุ";

$strCourses_BtnShowCourseId = $strShow."ตามรหัสวิชา";
$strCourses_BtnShowCourseName = $strShow."ตามชื่อวิชา";
$strCourses_BtnShowName = $strShow."ตามชื่อผู้สอน";
$strCourses_BtnShowSurName = $strShow."ตามนามสกุลผู้สอน";
$strCourses_BtnShowFac = $strShow."ตามคณะ";
$strCourses_BtnShowAll = $strShow."ทั้งหมด";

$strCourses_LabCourseWithdraw = "ถอนรายวิชา";
$strCourses_LabCourseWaitWithdraw = "รายวิชาที่กำลังรอผลการถอนจากผู้สอน";

$strCourses_LabMenuInstructor = "เมนูสำหรับผู้สอน";
$strCourses_LabCourseSyllabus = "แผนการสอน";
$strCourses_LabCourseCalendar = "ปฏิทินรายวิชา";
$strCourses_LabCoursePreference = "รายละเอียดรายวิชา";
$strCourses_LabCourseMember = "สมาชิกรายวิชา";
$strCourses_LabCourseActivity = "กิจกรรมรายวิชา";
$strCourses_LabCourseResource = "เนื้อที่รายวิชา";
$strCourses_LabCourseAnnouncement = "ข่าวประกาศรายวิชา";
$strCourses_LabCourseTools = "เครื่องมือรายวิชา";

$strCourses_LabShowAllInfo = $strShow."ข้อมูลทั้งหมด";
$strCourses_LabMailToAll = "ส่งอีเมลล์ให้ทุกคน";
$strCourses_LabEditGroup = $strEdit."สมาชิกในกลุ่ม";
$strCourses_LabEditCourseMembers = $strEdit.$strCourses_LabCourseMember ;

$strCourses_LabSearch = $strSearch."ตาม";
$strCourses_LabSearchText = $strSearch." คำว่า";

$strCourses_LabOtherCourseMember = $strCourses_LabCourseMember."อื่น ๆ";
//-------------------------------  Group -------------------------------------------
//-------------------------------  Homework -------------------------------------------
$strHome_LabInfo = "การบ้าน";
$strHome_LabDetail = "รายละเอียด";
$strHome_LabDes = "คำชี้แจง";
$strHome_LabDate = "วันสิ้นสุดการส่ง";
$strHome_LabNo = "ข้อ";
$strHome_LabQuestion = "คำถาม";
$strHome_LabAttach = "เอกสารแนบ / เชื่อมโยง";
$strHome_LabAction = "กระทำ";
$strHome_LabScore = "คะแนน";
$strHome_LabNoScore = "ยังไม่มี".$strHome_LabScore;
$strHome_LabAnswer = "คำตอบ";
$strHome_LabSolution = "วิธีทำ";
$strHome_LabHomeClose = "ปิดรับการส่งการบ้าน";
$strHome_LabResultForAll = "ผลการส่งการบ้านใน";
$strHome_LabPartType = "ชนิดของคำตอบ";
$strHome_LabNoSender = "จำนวนผู้ส่งขณะนี้";
$strHome_LabGraph = "แผนภูมิ";
$strHome_LabIndex = "หน้าหลัก";
$strHome_BtnNewQuestion = "เพิ่มคำถามใหม่";

$strHome_LabShowAll = $strShow.$strHome_LabQuestion;
$strHome_LabShowAllText = $strShow."ข้อความ";
$strHome_LabZip = "บีบอัดคำตอบ";
$strHome_LabDateTime = "วัน - เวลา";
$strHome_LabText = "ข้อความ";
$strHome_LabUrl = "เว็บไซด์";
$strHome_LabFile = "เอกสาร";

$strHome_LabMaxScores = "คะแนนเต็ม";
$strHome_LabEditQues="แก้ไข คำถาม";
$strHome_LabAssignment="คำถาม";
$strHome_LabQuestionType="ชนิดของคำถาม";

//-------------------------------  Quiz and Survey  -------------------------------------------
$strQuiz_LabText="ยินดีต้อนรับสู่ การจัดการแบบทดสอบออนไลน์";
$strQuiz_LabOther = "อื่นๆ";
$strQuiz_LabMQ="การจัดการ แบบทดสอบ";
$strQuiz_LabCategory = "หมวดคำถาม";
$strQuiz_LabQuizNo = "ลำดับที่";
$strQuiz_LabQuestion = "คำถาม";
$strQuiz_LabType = "ชนิดคำถาม";
$strQuiz_LabFile = "ข้อมูลแนบ";
$strQuiz_LabFileOld = "ข้อมูลแนบเก่า";
$strQuiz_LabScore = "คะแนน";
$strQuiz_LabMaxScore = "คะแนนเต็ม";
$strQuiz_LabAlternate = "ตัวเลือก";
$strQuiz_LabCorrectAns = "เลือกข้อที่ถูก";
$strQuiz_LabSolution = "วิธีทำ";
$strQuiz_LabComment = "หมายเหตุ";
$strQuiz_LabAnswer = "คำตอบ";
$strQuiz_LabDesc = "คำอธิบาย";
$strQuiz_LabActive = "ใช้งาน";
$strQuiz_LabInActive = "ไม่ใช้งาน";
$strQuiz_LabCorrectAnswer = "เฉลย";
$strQuiz_LabAnswerTrue = "ถูกต้อง";
$strQuiz_LabAnswerFalse = "ไม่ถูกต้อง";
$strQuiz_LabUse = "ใช้ได้";
$strQuiz_LabUseSelect="นำคำถามไปใช้งาน";
$strQuiz_LabAverage="ค่าเฉลี่ย";
$strQuiz_LabTopScore="คะแนนสูงสุด";

$strQuiz_LabTotalQuestion = "จำนวนคำถาม";
$strQuiz_LabTotalAnswer = "จำนวนคำตอบ";
$strQuiz_LabTotalScore= "คะแนน ทั้งหมด";
$strQuiz_LabFor= "ของ ";
$strQuiz_LabNoError= "ไม่มีข้อผิด";
$strQuiz_LabAnswerCorrect= "คำถามที่คุณทำผิด ใน ";
$strQuiz_LabAnswerCorrectAll= "คำถามทั้งหมด ใน ";

$strQuiz_MenuEditPreference = "กำหนดรูปแบบข้อสอบ";
$strQuiz_MenuAddQuestion = "สร้างข้อสอบ";
$strQuiz_MenuAddMultipleChoice = "ข้อสอบตัวเลือก";
$strQuiz_MenuAddMatching = "ข้อสอบจับคู่";
$strQuiz_MenuAddFilling = "ข้อสอบเติมคำ";
$strQuiz_MenuAddTrueFalse = "ข้อสอบถูกผิด";
$strQuiz_MenuSetActive = "กำหนดการใช้งาน";
$strQuiz_MenuViewAdd = "แสดงข้อมูลข้อสอบ";
$strQuiz_MenuSearchQuestion = "ค้นหาข้อมูลข้อสอบ";
$strQuiz_MenuDeleteQuiz = "ลบข้อสอบ";
$strQuiz_MenuResult = "รายงานการประเมิน";
$strQuiz_MenuResultByUser = "ตามผู้สอบ";
$strQuiz_MenuResultByQuestion = "ตามคำถาม";

$strQuiz_LabAddCategorySuccess = "ได้ทำการเพิ่มหมวดคำถามเรียบร้อยแล้ว";
$strQuiz_LabAddQuestionSuccess = "ได้ทำการเพิ่มคำถามเรียบร้อยแล้ว!";
$strQuiz_LabSolutionDisplay = "วิธีทำจะแสดง กรณีที่ตอบผิด";
$strQuiz_LabForSearch = "ใช้สำหรับค้นหาจากหน้าค้นหา";
$strQuiz_LabRecieveScore = "คะแนนสำหรับคำตอบที่ถูกต้อง";
$strQuiz_LabScoreByQuiz = "คะแนนแต่ละคำถาม";
$strQuiz_LabNumericOnly = "ตัวเลขเท่านั้น";
$strQuiz_LabOutofTime = "หมดเวลาทำข้อสอบ";
$strQuiz_LabNoNumQuiz = "ไม่ระบุ จำนวนข้อสอบ";
$strQuiz_LabNumQuizEqual = "จำนวนข้อสอบ ยังไม่ครบจำนวน";
$strQuiz_LabNoNumMcit= "ข้อสอบชุดนี้ มีการใช้ข้อสอบแบบจับคู่ แต่เนื่องจากผู้สอนยังไม่ได้ทำการสร้างข้อสอบ จึงควรแจ้งผู้สอน";    //(29/03/05)
$strQuiz_LabDonotCopy= "เนื่องจากข้อสอบ ข้อนี้ได้มีผู้เรียน ได้ทำการทดสอบอยู่ จึงไม่สามารถทำการ ปรับปรุงได้";    //(29/03/05)
$strQuiz_LabDonotCopy1= "เนื่องจากข้อสอบ ข้อนี้ได้มีข้อสอบชุดอื่นทำการเรียกใช้อยู่ จึงไม่สามารถทำการ ปรับปรุงได้";    //(29/03/05)
$strQuiz_LabNoRecord = "ไม่มีข้อมูลการทำข้อสอบ ณ ขณะนี้";
$strQuiz_LabResultAll = "ผลการทำข้อสอบของผู้สอบทั้งหมดใน ";
$strQuiz_LabResultSurveyAll = "ผลการทำแบบทดสอบของผู้สอบทั้งหมดใน ";
$strQuiz_LabUniPart = "จำนวนผู้เข้าสอบ";
$strQuiz_LabNrRun = "จำนวนครั้งที่ทำข้อสอบ";
$strQuiz_LabNrSend="จำนวนครั้งที่มีการส่งคำตอบ";
$strQuiz_LabPart = "ผู้สอบ";
$strQuiz_LabOccasion = "วัน-เวลา";
$strQuiz_LabPercent = "ร้อยละ";
$strQuiz_LabQuestionUpdate = "คำถามถูกแก้ไข";
$strQuiz_LabSorry = "ขออภัย ...";
$strQuiz_LabCanNotDel = "ไม่สามารถลบคำถามนี้ได้เนื่องมีการใช้งานกับข้อสอบชุดอื่นอยู่...";
$strQuiz_LabQuestionDel = "คำถามถูกลบ...";
$strQuiz_LabQuestionSend= "ส่งคำตอบ...";
$strQuiz_LabQuestionRemove = "คำถามถูกนำออก...";
$strQuiz_LabTimer = "เวลาในการทำข้อสอบ";
$strQuiz_LabSearch = "พิมพ์ % เพื่อค้นหาคำถามทั้งหมด";
$strQuiz_LabSearchIn = "ค้นหาใน";
$strQuiz_LabSubmitAll = "ส่งคำตอบทั้งหมด";
$strQuiz_LabSubmitAns = "ส่งคำตอบข้อนี้";
$strQuiz_LabDoStart = "เริ่มทำ ";
$strQuiz_LabDoContinue = "ทำต่อ ";
$strQuiz_LabSeveralComment = "คุณไม่สามารถทำข้อสอบได้อีกครั้ง<br>";
$strQuiz_LabAgainComment = "<p>คุณต้องการทำข้อสอบอีกครั้งหรือไม่<br>";


$strQuiz_LabAddQuestionMutipleChoice = "สร้างข้อสอบแบบตัวเลือก";
$strQuiz_LabAddQuestionTrueFalse = "สร้างข้อสอบแบบถูกผิด";
$strQuiz_LabAddQuestionMatching = "สร้างข้อสอบแบบจับคู่";
$strQuiz_LabAddQuestionFilling = "สร้างข้อสอบแบบเติมคำ";

$strQuiz_LabQuizWrong="คำตอบของคุณ ผิด";
$strQuiz_LabQuizCorrect="คำตอบของคุณ ถูก";
$strQuiz_LabAnsCorrect="คำตอบที่ถูกต้อง";

$strQuiz_LabName = "ชื่อ";
$strQuiz_LabMaxName = "สูงสุด 15 ตัวอักษร";
$strQuiz_LabQuizOrSurvey = "แบบทดสอบ หรือ  แบบประเมิน";
$strQuiz_LabQuiz = "แบบทดสอบ";
$strQuiz_LabSurvey = "แบบประเมิน";
$strQuiz_LabLastDate = "วันสุดท้ายในการทำข้อสอบ";
$strQuiz_LabValidate = "ข้อความเตือนก่อนส่งคำตอบ";
$strQuiz_LabMultipleSelect = "ช่องคำตอบปรนัย";
$strQuiz_LabDependOn = "ขึ้นอยู่กับจำนวนคำตอบ";
$strQuiz_LabMultiChoose = "เลือกตอบได้หลายข้อ";
$strQuiz_LabRandom = "สุ่มคำถาม";
$strQuiz_LabViewAns = "ดูคำตอบ";
$strQuiz_LabViewOnebyOne = "ดูคำตอบข้อต่อข้อ";
$strQuiz_LabViewAllQuiz = "ทำหมดทั้งชุดก่อน";
$strQuiz_LabViewAnsNo = "ไม่อนุญาตให้ดูคำตอบ";
$strQuiz_LabViewSol = "ดูวิธีทำ";
$strQuiz_LabTimesQuiz = "จำนวนครั้งในการทำข้อสอบ";
$strQuiz_LabSeveral = "ไม่จำกัด ";
$strQuiz_LabOnce = "ครั้งเดียว";
$strQuiz_LabSelectMatching = "เลือกใช้ข้อสอบแบบจับคู่";
$strQuiz_LabSelectTimer = "ต้องการจับเวลาในการทดสอบ";
$strQuiz_LabHour = "ชั่วโมง";
$strQuiz_LabMinute = "นาที";
$strQuiz_LabSelectColor = "สีที่ต้องการแสดง";
$strQuiz_LabWhite = "ขาว";
$strQuiz_LabAntiqueWhite = "ชมพูอ่อน";
$strQuiz_LabMintCream = "ขาวครีม";
$strQuiz_LabLearnLoopBlue = "ม่วงอ่อน";
$strQuiz_LabCoral = "ส้ม";
$strQuiz_LabTan = "น้ำตาล";
$strQuiz_LabRoyalBlue = "น้ำเงิน";
$strQuiz_LabGainsboro = "ฟ้า";
$strQuiz_LabOtherColor = "สีอื่นๆ";
$strQuiz_LabStartPage = "คำชี้แจง";
$strQuiz_LabRequireField = "ระบุเขตข้อมูลที่ต้องการ";
$strQuiz_LabExplanationCopy = "This question is also included in the following modules";
$strQuiz_LabCoursesName="Courses Name";
$strQuiz_LabModules="Module Name";
$strQuiz_LabCreated="Created by";
$strQuiz_LabResultSearch="ผลจากการค้นหาของคำว่า";
$strQuiz_LabTotal="ทั้งหมด";
$strQuiz_LabNewSearch="ค้นหาใหม่";
$strQuiz_LabTaken="คุณได้ทำข้อสอบทั้งหมดในชุดคำถามนี้แล้ว";
$strQuiz_LabStart = "
<table width=\"98%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" class=\"tdborder\">
                <tr class=Tmenu> 
                  <td bgcolor=\"#FFFFFF\"><p><strong>การกำหนดรูปแบบข้อสอบ</strong><br>
                      <br>
                      กำหนดประเภทข้อสอบว่าเป็นข้อสอบหรือแบบประเมิน รวมถึงข้อกำหนดต่าง 
                      ๆ </p>
                    <ul>
                      <li>สีพื้นของ ข้อสอบหรือแบบประเมิน </li>
                      <li>การแสดงข้อความยืนยันหลังจากที่นิสิตเลือกคำตอบ ในแต่ละข้อ 
                      </li>
                      <li>การกำหนดว่าเป็นการสอบแบบสุ่มหรือชุด </li>
                      <li>การแสดงเฉลยคำตอบ </li>
                      <li>การกำหนดการดูคำตอบ</li>
                      <li>การกำหนดการใช้ข้อสอบแบบจับคู่</li>
                      <li>การกำหนดการเวลาในการทดสอบ</li>
                    </ul></td>
                </tr>
                <tr  class=Tmenu> 
                  <td><p><strong>การสร้างชุดข้อมูลข้อสอบหรือแบบประเมินและคำตอบ<br>
                      </strong><br>
                      เลือกรูปแบบหรือประเภทข้อสอบที่ต้องการสร้าง ซึ่งมีด้วยกันทั้งหมด 
                      4 รูปแบบคือ</p>
                    <ul>
                      <li> เลือก Multiple Choice กรณีต้องการสร้างข้อสอบแบบตัวเลือก</li>
                      <li>เลือก True/False กรณีต้องการสร้างข้อสอบแบบถูกผิด</li>
                      <li>เลือก Matching Item กรณีต้องการสร้างข้อสอบแบบจับคู่</li>
                      <li>เลือก Fill-in-Blank กรณีต้องการสร้างข้อสอบแบบเติมคำ<br>
                      </li>
                    </ul></td>
                </tr>
                <tr  class=Tmenu> 
                  <td bgcolor=\"#FFFFFF\"> <p><strong>การค้นหาข้อมูลข้อสอบหรือแบบประเมิน</strong><br>
                      <br>
                      โดยพิมพ์คำสำคัญที่ต้องการค้นหา ซึ่งถ้าพบระบบจะแสดง Listข้อมูลที่พบทั้งหมดขึ้นมาให้ 
                      โดยสามารถที่จะทำการ Remove ข้อสอบแต่ละข้อออกจากชุดได้<br>
                    </p></td>
                </tr>
                <tr  class=Tmenu> 
                  <td><p><strong>การแสดงข้อมูลข้อสอบและการดูรูปแบบข้อสอบ</strong><br>
                      <br>
                      ระบบจะทำการแสดงข้อมูลข้อสอบทั้งหมดที่อยู่ในชุดข้อสอบนั้นขึ้นมาให้ 
                      ซึ่งสามารถที่ จะทำการแก้ไข ข้อมูลข้อสอบแต่ละข้อได้ โดยการคลิกที่หมายเลยข้อหรือรายละเอียดโจทย์<br>
                  </td>
                </tr>
                <tr  class=Tmenu> 
                  <td bgcolor=\"#FFFFFF\"><strong>การออกรายงานการประเมิน</strong><br> 
                    <br> <strong>การแสดงรายงานประเมินผลตามผู้สอบ</strong><br> 
                    <br>
                    เป็นหน้าจอแสดงการประเมินผลของนิสิต โดยจะแสดงจำนวนนิสิตที่ทำการสอบทั้งหมด 
                    รวมถึงคำนวณและแสดงคะแนนสูงสุดที่มี, คะแนนเฉลี่ยของนิสิตทุกคน 
                    และเปอร์เซนต์คะแนนที่ได้ โดยที่สามารถดูคำตอบของนิสิตได้ด้วย<br> 
                    <br> <strong>การแสดงรายงานประเมินผลตามคำถาม</strong><br> <br>
                    เป็นหน้าจอแสดงการประเมินผลการตอบคำถามของผู้สอบในแต่ละข้อ โดยจะแสดง 
                    คำถามและคำตอบทั้งหมด รวมถึงจำนวนการเลือกตอบของผู้สอบในแต่ละข้อคำตอบ<br> 
                  </td>
                </tr>
              </table>";

//-------------------------------  Resource -------------------------------------------
$strResource_LabFileName = "ชื่อแฟ้มข้อมูล: ";
$strResource_LabFileSize = "ขนาดแฟ้มข้อมูล: ";
$strResource_LabUrlName = "ชื่อลิงค์: ";
$strResource_LabFolderName = "ชื่อกล่อง: ";
$strResource_LabFileUpload = "แฟ้มข้อมูลนำเข้า: ";
$strResource_LabShowType = "แสดงชนิด: ";
$strResource_LabMove = "ย้ายไปยังกล่อง: ";
$strResource_LabDelete = "ลบ: ";
$strResource_LabDiskUsage = "เนื้อที่ใช้งาน: ";
$strResource_LabUrl = "ลิงค์: ";
$strResource_LabGetFilePer = "นำเข้าข้อมูลจากข้อมูลบุคคล: ";
$strResource_LabGetFileCenter = "นำเข้าข้อมูลจาก Resources Center";

$strResource_BtnAddFolder = $strAdd." กล่อง"; 
$strResource_BtnAddUrl = $strAdd." ลิงค์";
$strResource_BtnUploadFile = $strAdd."แฟ้มข้อมูลนำเข้า";
$strResource_BtnEditFolder = $strEdit." ชื่อกล่อง";
$strResource_BtnEditFile = $strEdit." ชื่อแฟ้มข้อมูล";
$strResource_BtnEditUrl = $strEdit." ชื่อลิงค์";
$strResource_BtnEditZip = $strEdit." ชื่อแฟ้มบีบอัดข้อมูล";
$strResource_BtnFile = "แฟ้มข้อมูล";
$strResource_BtnMove = "ย้าย";
$strResource_BtnDelete = "ลบ";
$strResource_BtnGetFiles = "นำเข้า";

$strResource_LabMang="การจัดการเนื้อหา ในวิชา";
$strResource_LabResourceName="ชื่อเนื้อหา";
$strResource_LabFileDetail="รายละเอียดของแฟ้มข้อมูล";
$strResource_LabEachResour="รวมเนื้อหา : ";
$strResource_LabAllResour="รวมเนื้อหาทั้งหมด : ";
$strResource_LabStorage="เก็บรายละเอียดพื้นที่ ";
$strResource_LabUsedSpace="พื้นที่ ที่ใช้แล้ว : ";
$strResource_LabFreeSpace="พื้นที่ ที่เหลือ : ";
$strResource_LabQuota="ส่วนที่กำหนด : ";
//-------------------------------  Research  -------------------------------------------
//-------------------------------  Score Card  -------------------------------------------
//------------------------------- Syllabus-------------------------------------------
$strSyllabus_Header = "แผนการสอน";

$strSyllabus_LabSelectType = "เลือกชนิดการใช้งานแผนการสอน";
$strSyllabus_LabBasic = "แผนการเรียนพื้นฐาน";
$strSyllabus_LabAdvance = "แผนการเรียนขั้นสูง";
$strSyllabus_LabEditFile = $strEdit."แผนการสอน";
$strSyllabus_LabDelFile = $strDelete."แผนการสอน";
$strSyllabus_LabEditAdvance = $strEdit."แผนการสอน";
$strSyllabus_LabFileName = "ชื่อแฟ้มข้อมูล";
$strSyllabus_LabFileType = "ชนิดแฟ้มข้อมูล";
$strSyllabus_LabFileSize = "ขนาดแฟ้มข้อมูล";
$strSyllabus_LabNo = "ครั้งที่";
$strSyllabus_LabDate = "วันที่สอน";
$strSyllabus_LabTime = "เวลาที่สอน";
$strSyllabus_LabTopic = "หัวข้อที่สอน";
$strSyllabus_LabWay = "วิธีการสอน";

//------------------------------- System-------------------------------------------
$strSystem_Header = "การจัดการระบบ M@xLearn";
$strSystem_LeftMenu = "ระบบการทำงาน";

$strSystem_LabUser = "การจัดการผู้ใช้";
$strSystem_LabSystem = "การจัดการระบบ";
$strSystem_LabMaster = "การจัดการข้อมูลเบื้องต้น";
$strSystem_LabCourses = "การจัดการรายวิชา";
$strSystem_LabReport = "การจัดการรายงาน";         //****** 

$strSystem_MenuHome = "หน้าหลัก";
$strSystem_MenuUser = "ผู้ใช้";
$strSystem_MenuSystem = "ระบบ";
$strSystem_MenuMaster = "ข้อมูลเบื้องต้น";
$strSystem_MenuCourses = "รายวิชา";
$strSystem_MenuReport = "รายงาน";                                  //****** 

$strSystem_LabNewUser = "เพิ่มผู้ใช้ใหม่";
$strSystem_LabActiveUser = "ผู้ใช้ที่ใช้งาน";
$strSystem_LabInactiveUser = "ผู้ใช้ไม่ใช้งาน";
$strSystem_LabSortBy = "เรียงตาม";
$strSystem_LabUserType = "ชนิดผู้ใช้";
$strSystem_LabUserStatus = "สถานะ";
$strSystem_LabUserAdmin = "เป็นผู้ดูแล";
$strSystem_LabAdminPer = "สิทธิผู้ดูแล";
$strSystem_LabUserPer = "สิทธิผู้ใช้";
$strSystem_LabAddEditPer = "เพิ่ม / แก้ไขสิทธิ";
$strSystem_LabLevel = "ระดับ";
$strSystem_LabGrant = "การใช้งาน";
$strSystem_LabRequired = "ช่องที่ต้องใส่ข้อมูล";
$strSystem_LabCurrentPass = "รหัสผ่านปัจจุบัน";
$strSystem_LabNewPass = "รหัสผ่านใหม่";
$strSystem_LabRepeatPass = "ยืนยันรหัสผ่านใหม่";
$strSystem_LabImpUser = "นำเข้าผู้ใช้ใหม่";                                  //****
$strSystem_LabImpFile="ไฟส์ข้อมูลสมาชิก";								 //****
$strSystem_LabImpChar="ตัวอักษรขั้นข้อมูล";								 //****
$strSystem_LabImpEx="ตัวอย่างไฟล์";											//****
$strSystem_LabImpAdd="เพิ่มสมาชิกจากแฟ้มข้อมูล";					 //****
$strSystem_LabImpError="รายชื่อสมาชิกที่ไม่สามารถ นำเข้าระบบได้";			//****
$strSystem_LabImpEmpty="ข้อมูลของ ผู้ใช้ ไม่ครบ";                                                           //****
$strSystem_LabImpAlre="ชื่อผู้ใช้ ได้มีแล้วในระบบ ";               //****
$strSystem_LabChangePWUpdate="รหัสผ่านถูกแก้ไข...";
$strSystem_LabChangePWWrong="รหัสผ่านไม่ถูกต้อง";
$strSystem_LabChangePWValidNew="รหัสผ่านต้องไม่น้อยกว่า 3 ตัวอักษร";
$strSystem_LabChangePWNoMatch="รหัสผ่านใหม่ไม่ตรงกัน";
$strSystem_LabChangePWValidOld="รหัสผ่านเก่าว่าง";
$strSystem_LabChangePWValidNewEmpty="รหัสผ่านใหม่ว่าง";

$strSystem_LabModule = "ส่วนการทำงานระบบ";
$strSystem_LabViewModule = $strView." ส่วนการทำงาน";
$strSystem_LabBackup = "สำรองระบบ";
$strSystem_LabBackupDb = "สำรองฐานข้อมูล";
$strSystem_LabDisplay = "การแสดงผล";
$strSystem_LabDisplaySetup = "ตั้งค่าการแสดงผล";
$strSystem_LabDisplayColorRed = "สีแดง";
$strSystem_LabDisplayColorBlue = "สีน้ำเงิน";
$strSystem_LabDisplayColorGreen ="สีเขียว";
$strSystem_LabFirstpage = "หน้าแรก";
$strSystem_LabControlFirstpage = "ควบคุมหน้าแรก";



$strSystem_LabSubModule = "ส่วนการทำงาน";
$strSystem_LabModuleStatus = "สถานะ";
$strSystem_LabModuleUrl = "ตำแหน่งเชื่อมโยง";
$strSystem_LabModuleUrlAdmin = "ตำแหน่งเชื่อมโยงผู้ดูแล";
$strSystem_LabModuleUrlSetup = "ตำแหน่งเชื่อมโยงการติดตั้ง";
$strSystem_LabModuleInfo = "รายละเอียด";
$strSystem_LabModulePicture = "รูปภาพ";

$strSystem_LabAcademicData = "ข้อมูลสถาบัน";
$strSystem_LabAcademic = "การจัดการโครงสร้างสถาบัน";

$strSystem_LabEvaluationData = "ข้อมูลแบบประเมิน";
$strSystem_LabEvaluation = "การจัดการข้อมูลแบบประเมิน";

$strSystem_LabCampus = "สถาบัน";
$strSystem_LabFaculty = "คณะ";
$strSystem_LabDept = "ภาควิชา";
$strSystem_LabMajor = "สาขาวิชา";

$strSystem_LabNo = "ลำดับ";
$strSystem_LabCamId = "รหัสสถาบัน";
$strSystem_LabCamNameTh = "ชื่อสถาบัน (ไทย)";
$strSystem_LabCamNameEng = "ชื่อสถาบัน (อังกฤษ)";
$strSystem_LabCamUrl = "เว็บไซด์";

$strSystem_LabFacNameTh = "ชื่อคณะ (ไทย)";
$strSystem_LabFacNameEng = "ชื่อคณะ (อังกฤษ)";
$strSystem_LabFacUrl = "เว็บไซด์";

$strSystem_LabDeptNameTh = "ชื่อภาควิชา (ไทย)";
$strSystem_LabDeptNameEng = "ชื่อภาควิชา (อังกฤษ)";
$strSystem_LabDeptUrl = "เว็บไซด์";

$strSystem_LabMajorNameTh = "ชื่อสาขาวิชา (ไทย)";
$strSystem_LabMajorNameEng = "ชื่อสาขาวิชา (อังกฤษ)";
$strSystem_LabMajorUrl = "เว็บไซด์";

$strSystem_LabClickDept = $strClick.$strSystem_LabFacNameTh." เพื่อดู ".$strSystem_LabDept;
$strSystem_LabClickMajor = $strClick.$strSystem_LabDeptNameTh."  เพื่อดู ".$strSystem_LabMajor;

$strSystem_BtnNewCam = "เพิ่มสถาบัน";
$strSystem_BtnNewFac = "เพิ่มคณะ";
$strSystem_BtnNewDept = "เพิ่มภาควิชา";
$strSystem_BtnNewMajor = "เพิ่มสาขาวิชา";

$strSystem_LabActiveCourses = "รายวิชาที่ใช้งาน";
$strSystem_LabInactiveCourses = "รายวิชาไม่ใช้งาน";

//-------------- System news-------------------------

$strSystem_LabNews = "จัดการข่าว";
$strSystem_LabNewsAnnounce = "ประกาศข่าว";
$strSystem_LabNewsAdd = "เพิ่มข่าวของระบบ";
$strSystem_LabNewsView = "ดูข่าวของระบบ";
$strSystem_LabNewsEdit = "แก้ไขข่าวของระบบ";
$strSystem_LabNewsViewperson = "ประกาศเฉพาะ";
$strSystem_LabNewsAnnounceSystem = "ประกาศเฉพาะภายในระบบ";
$strSystem_LabNewsSelectUser= "--เลือกผู้ใช้--";
$strSystem_LabNewsUserAdmin= "ผู้ดูแลระบบ";
$strSystem_LabNewsUserTeacher= "อาจารย์";
$strSystem_LabNewsUserStudent = "นักเรียน";
$strSystem_LabNewsUserShowall = "แสดงทั้งหมด";
$strSystem_LabHeadNews = "ข่าวสารจากระบบ";
$strSystem_LabNewsNotFound="ไม่พบข่าวของระบบ";


//-------------------------Import/Export Data-------------------------------------
$strImport_LabImport="นำเข้า";
$strImport_LabExport="นำออก";
$strImport_LabData="ข้อมูล";
$strImport_LabNo="ลำดับที่";
$strImport_LabType="ชนิด";
$strImport_LabSelectImport= "ไฟส์ข้อมูลที่ต้องการ นำเข้า";
$strImport_LabTypeQuiz="แบบทดสอบ";
//********menu report********
$strSystem_RMenuHeader = "แสดงตาม";
$strSystem_RMenuAll = "ทั้งหมด";
$strSystem_RMenuCourse = "รายวิชา";
$strSystem_RMenuModules = "กิจกรรมรายวิชา";
$strSystem_RMenuLogin = "เข้าสู่ระบบ";
$strSystem_RMenuLogout= "ออกจากระบบ";

$strSystem_RHeader = "แสดง";
$strSystem_LabReportTime= "กำหนดช่วงเวลา";
$strSystem_LabReportTo= "ถึง";

$strSystem_ListReportTime= "วัน / เวลา";
$strSystem_ListReportName= "ชื่อผู้ใช้งานระบบ";
$strSystem_ListReportAction= "กิจกรรม";
$strSystem_ListReportModules= "Modules";
$strSystem_ListReportCourses= "รายวิชา";

$strSystem_CReportCreate= "สร้างรายวิชา";
$strSystem_CReportUpdate= "ปรับปรุงรายวิชา";
$strSystem_CReportDelete= "ลบรายวิชา";
$strSystem_CReportApply= "สมัครเรียนรายวิชา";
$strSystem_CReportDrop= "ถอนรายวิชา";

$strSystem_MReportFolder= "Folder";
$strSystem_MReportGroup= "Groups";
$strSystem_MReportForum= "Forum";
$strSystem_MReportWebboard= "Webboard";
$strSystem_MReportResources= "Resourcess";
$strSystem_MReportQuiz= "Quiz";
$strSystem_MReportHW= "E-Homework";

$strSystem_LabUserTypeAll = "ทั้งหมด";
$strSystem_LabUserTypeAdmin = "ผู้ดูแลระบบ";
$strSystem_LabUserTypeInstructor = "อาจารย์";
$strSystem_LabUserTypeStudent = "นักศึกษา";

$strSystem_LabUserPrint = "พิมพ์รายงาน";
$strSystem_LabUserPrintHeader= "ข้อมูลรายงาน";
//------------------------------- Activity -------------------------------------------
$strActivity_SelectModule = "เลือกส่วนการทำงาน";
$strActivity_LabModuleName = "ชื่อส่วนการทำงาน";
$strActivity_LabStat = "สถิติ";
$strActivity_LabByUser = "แยกตามผู้ใช้";
$strActivity_LabCurrentWeek = "สัปดาห์ปัจจุบัน ";
$strActivity_LabTotalLogin = "จำนวนการเข้าใช้งานทั้งหมด ";
$strActivity_LabNrPost = "จำนวนผู้ใช้ส่งข้อมูล ";
$strActivity_LabTotalPost = "จำนวนการส่งข้อมูลทั้งหมด";
$strActivity_LabWeek = "สัปดาห์";
$strActivity_LabLogin = "เข้าใช้งาน ";
$strActivity_LabPost = "ส่งข้อมูล ";


//----------------------------Webboard------------------------------
$strWebboard_LabSubject="หัวข้อคำถาม";
$strWebboard_LabIcon="ไอคอนข้อความ";
$strWebboard_LabMessage="ข้อความ";
$strWebboard_LabSmilies="ยิ้มกว้างๆ";
$strWebboard_LabPicture="ภาพประกอบ";
$strWebboard_LabTextSize="ขนาดไม่เกิน 50 KB";
$strWebboard_LabDeletePic="ลบภาพนี้";
$strWebboard_LabSearch="ค้นหากระทู้ ใน";
$strWebboard_LabHPre="Personal preferences for";
$strWebboard_LabHDatail="Show Subject & Detail:";
$strWebboard_LabSDatail="This option requires javascript";
$strWebboard_LabHThread="Show thread:";
$strWebboard_LabHDESC="Sort descending:";
$strWebboard_LabSDESC="Show the last subject first";
$strWebboard_LabHMail="Subscribe:";
$strWebboard_LabSMail="Receive a mail for every new contribution";
$strWebboard_LabHDate="Show the last:";
$strWebboard_LabDate="วัน";
$strWebboard_LabUpload="ภาพประกอบ ต้องเป็น : ";

//-----------------------------------------------  Msg + Evaluate [Kae]---------------------------
$strPersonal_MenuMsg = "กล่องข้อความ";
$strPersonal_msg_inbox = "ข้อความเข้า";
$strPersonal_msg_Sentbox =  "ข้อความส่งแล้ว";
$strPersonal_msg_Outbox = "ข้อความออก";
$strPersonal_msg_Savebox= "ข้อความบันทึกแล้ว";
$strPersonal_Pri_Priority= "ประเภทของการส่ง";
$strPersonal_Pri_High= "ด่วนที่สุด";
$strPersonal_Pri_Normal= "ด่วน";
$strPersonal_Pri_Low= "ปกติ";
$strPersonal_msg_Subject= "เรื่อง";
$strPersonal_msg_From= "จาก";
$strPersonal_msg_To= "ถึง";
$strPersonal_msg_Message= "ข้อความ";
$strPersonal_msg_New= "ข้อความใหม่";
$strPersonal_msg_Date= "วันที่";
$strPersonal_msg_Search= "ค้นหา...";
$strPersonal_msg_SentComplete ="ส่งข้อความเรียบร้อยแล้ว";
$strPersonal_msg_SentEditTo = "กรุณาใส่ข้อมูลในช่อง ' ถึง' ";
$strPersonal_msg_SentEditMsg ="กรุณาใส่ข้อมูลในช่อง ' ข้อความ' ";
$strPersonal_msg_Non = "ไม่ระบุ ";
$strPersonal_msg_PleaseSelect ="กรุณาเลือกกลุ่มผู้ใช้";
$strPersonal_msg_KeyWord = "คีย์เวิร์ดในการค้นหา";
$strPersonal_msg_All = "กลุ่มผู้ใช้ทั้งหมด";
$strPersonal_msg_Admin = "ผู้ดูแลระบบ";
$strPersonal_msg_Teacher = "อาจารย์";
$strPersonal_msg_Student = "นักศึกษา";
$strPersonal_msg_NotFound = "ไม่พบรายชื่อที่คุณต้องการ กรุณาค้นหาใหม่อีกครั้ง.";
$strPersonal_msg_NotHaveLoginName = "ไม่มีรายชื่อผู้ใช้  ";
$strPersonal_msg_SelectName =" เลือก ";
$strPersonal_msg_Answer =" ตอบกลับ ";
$strPersonal_msg_AlreadySave =" บันทึกข้อความเรียบร้อยแล้ว ";
$strPersonal_msg_AlreadyDel=" ลบข้อความเรียบร้อยแล้ว ";
$strPersonal_msg_ChooseMsg= " กรุณาเลือกข้อความที่ต้องการบันทึก หรือ ลบ ";
$strPersonal_msg_ErrorNoMsg= " ไม่มีข้อความใน กล่องข้อความ ของคุณ ";
$strPersonal_msg_ErrorNoMsg= " ไม่มีข้อความใน กล่องข้อความ ของคุณ ";
$Calendar_appointment  ="การนัดหมายของวันนี้";
$Calendar_Noappointment  ="ไม่มีการนัดหมาย ";
$INFO_HOMEWORK ="การบ้าน ";
$INFO_CAUSE_TITLE ="วิชา ";
$INFO_DEADLINE_TITLE ="กำหนดส่ง";
$INFO_NotHaveHomework =" ไม่มีการบ้าน ";
$INFO_Quiz =" แบบทดสอบ ";
$INFO_NotHaveQz =" ไม่มีแบบทดสอบ ";
$INFO_Webboard="กระดานข่าว ";
$INFO_NotHaveWeb="ไม่มีกระดานข่าว ";


$INFO_EVAL_title ="แบบประเมิน";
$EVAL_NEW_NAME ="ชื่อใหม่";
$EVAL_NOT = "ไม่มีแบบประเมิน";
$INFO_EVAL_dead="วันที่สิ้นสุด";
$Eval_Num="ข้อที่ ";
$Eval_Question="คำถาม";
$Eval_Action ="การกระทำ ";
$Eval_Score ="ระดับการประเมิน (คะแนน)";
$Eval_StdQues ="คำถามมาตราฐาน";
$Eval_TeaQues ="คำถามจากผู้สอน";
$Eval_AddstdQues ="เพิ่มคำถามมาตรฐาน";
$Eval_AddGroupQues= "เพิ่มหัวข้อ(หมวด)ของคำถาม";
$FullCharacters=" กรอกได้ 255 ตัวอักษร ";
$Eval_AddTeaQues ="เพิ่มคำถาม";
$chooseQues="เลือกคำถามจากคลัง ";
$AddChoice="เพิ่มคำถามแบบเลือกตอบ(Choice) จำนวน";
$AddFill="เพิ่มคำถามแบบเติมคำตอบ จำนวน";
$ChoiceQues="คำถามแบบเลือกตอบ";
$FillQues="คำถามแบบเติมคำตอบ";  //********not
$choice="ตัวเลือก";
$AddAlt="เพิ่มตัวเลือก";
$Eval_GroupName= "ชื่อหมวดคำถาม";
$Eval_NOTStdQues ="ไม่มีคำถามมาตราฐาน";
$Eval_NOTTeaQues ="ไม่มีคำถามจากผู้สอน";
$unitPerStd="หน่วย : คน";
$Eval_total="รวม";
$strEvalMaxScore="คะแนนเต็ม.";
$strEvalAverageScore="คะแนนเฉลี่ย";
$listSTD = "รายชื่อผู้ที่ยังไม่ประเมินการสอน";
$Eval_StdNum="ลำดับที่";
$Eval_SendMail="เลือกส่งเมลล์";
$Eval_SendAll="ส่งทั้งหมด";
$Std_NAME="ชื่อ - สกุล";
$Eval_descripe ="คำชี้แจง";
$Eval_year="ปีการศึกษา";
$Eval_semester ="ภาคการศึกษา";
$Eval_startDate ="เริ่มวันที่";
$Eval_endDate ="วันสิ้นสุด";
$EVALDESCRIPT = "รายละเอียดแบบประเมิน";
$EVALRESULT ="ผลการประเมิน";
$HOME_Link = "หน้าแรก";
$RES_Everage="ผลการประเมินแสดงคะแนนเฉลี่ย";
$RES_Person ="ผลการประเมินแสดงจำนวนผู้ตอบ";
$Check_no_Eval="ตรวจสอบรายชื่อผู้ที่ยังไม่ได้ประเมิน";
$CHOICE_1 = "ตัวเลือกที่ 1";
$CHOICE_2 = "ตัวเลือกที่ 2";
$CHOICE_3 = "ตัวเลือกที่ 3";
$CHOICE_4 = "ตัวเลือกที่ 4";
$CHOICE_5 = "ตัวเลือกที่ 5";
$CHOOSE_Q="เลือกคำถาม"; 
$EVE_standrd="คะแนนเฉลี่ยแบบประเมินมาตรฐาน ";
$EVE_user="คะแนนเฉลี่ยแบบประเมินจากผู้สอน ";
$FROM_Std = " จากผู้ประเมิน ";
$NUM_PER="คน";
$POINTS ="ระดับคะแนน";
$EXAMPLE ="ตัวอย่างการกรอกข้อมูล";
$EDIT_QC="ปรับปรุงคำถามแบบเลือกตอบ(Choice)";
$EDIT_QF = "ปรับปรุงคำถามแบบเติมคำตอบ";
$EDIT_GROUP="ปรับปรุงหัวข้อคำถาม [หมวด]";
$ALTERNATIVE="ตัวเลือกของคำถาม";
$NEW_GROUPNAME ="หัวข้อคำถามใหม่";
$NOTDO="แบบประเมินที่คุณยังไม่ได้ประเมิน";
$ALREADYDO="แบบประเมินที่คุณประเมินแล้ว";
$EVAL_STATUS="สถานะการประเมิน";
$MUST_DO="ทำแบบประเมิน";
$LOOK_EVAL = "ดูผลการประเมิน";
$COS_EVAL ="แบบประเมินการสอน รายวิชา ";
$NO_DATA="ยังไม่มีข้อข้อมูลในแบบประเมิน";
$Create_TITLE="ระบบประเมินการสอนของอาจารย์โดยนิสิต( Teaching  Evaluate System :TES )"; 
$SHOW_Finish ="แสดงผลประเมินให้ผู้เรียนเห็นเมื่อสิ้นสุดช่วงประเมิน";
$EVAL_SHOW_STD = "แสดงผลการประเมินให้ผู้เรียนเห็น";
$EVAL_SURVEY_RES = "ผลการประเมิน";
//-----------------------------------------------  Msg [Kae]---------------------------


//--------------------- Grade ------------------------------

$strGrade_HeaderGrade = "ระบบคำนวณผลการเรียน";
$strGrade_MenuGrade = "คำนวณผลการเรียน";
$strGrade_LabShowGrade = "แสดงผลการเรียน";
$strGrade_LabPreference  = "ตั้งค่า"; 
$strGrade_LabExport          = "ส่งออกเป็นไฟล์";
$strGrade_Labhelp          = "ช่วยเหลือ";
$strGrade_LabProgress      = "Grade Step";
$strGrade_LabSetRatio      = "กำหนดสัดส่วน";
$strGrade_LabInputScore  = "กำหนดคะแนน";
$strGrade_LabSetLevelType   = "กำหนดชนิดผลการเรียน";
$strGrade_LabSetScoreType   = "กำหนดระดับคะแนนผลการเรียน";
$strGrade_LabReport          = "รายงานผลการเรียน";
$strGrade_LabNo				   = "ลำดับ";
$strGrade_LabScoreName  = "ชื่อคะแนน";
$strGrade_LabGroup            =  "กลุ่ม";
$strGrade_LabGrade            = "ผลการเรียน";
$strGrade_LabScore				= "คะแนน";
$strGrade_LabComment      =  "ความคิดเห็น";
$strGrade_LabTotal              = "รวม";
$strGrade_LabAdd                = "เพิ่ม";
$strGrade_LabType				= "ประเภท";     
$strGrade_LabGroupName  = "ชื่อกลุ่ม";

$strGrade_LabSelectGroup =  "เลือกกลุ่ม";
$strGrade_LabMaxScore     = "คะแนนเต็ม";
$strGrade_LabCreateGroup = "สร้างกลุ่มใหม่"; 
$strGrade_LabShowGroup   = "แสดงกลุ่มทั้งหมด";
$strGrade_LabID					= "รหัส";
$strGrade_LabNameLastname = "ชื่อ-นามสกุล"; 
$strGrade_LabFrequency = "ความถี่";
$strGrade_LabHeadSelectType = "กำหนดชนิดผลการเรียน";
$strGrade_LabSelectType = "เลือกผลการเรียน";
$strGrade_LabCriteria = "ผลการเรียนตามเกณฑ์";
$strGrade_LabGroupGrading = "ผลการเรียนแบบกลุ่ม";
$strGrade_LabVarGrading = "ผลการเรียนแบบยืดหยุ่น";
$strGrade_LabTscore = "ผลการเรียนแบบ T-score";
$strGrade_LabLevel = "ขั้น";
$strGrade_LabSelectLevel  = "เลือกระดับขั้น";

$strGrade_LabStdscore = "คะแนนมาตรฐาน (Z)";
$strGrade_LabSelectStdscore = "- เลือกคะแนนมาตรฐาน -";
$strGrade_LabExcellent = " ดีเยี่ยม ";
$strGrade_LabVeryGood = " ดีมาก ";
$strGrade_LabGood = " ดี ";
$strGrade_LabFairlyGood = " ดีพอใช้ ";
$strGrade_LabFair = " พอใช้ ";
$strGrade_LabPoor = " แย่ ";
$strGrade_LabVeryPoor = " แย่มาก ";




$strGrade_LabGradeLevel = "ระดับผลการเรียน";
$strGrade_LabMinScore  = "คะแนนต่ำสุด";
$strGrade_LabMaxScore1  = "คะแนนสูงสุด";
$strGrade_LabCatetype   = "ประเภทผลการเรียน";
$strGrade_LabLeveltype  = "จำนวนระดับ";
$strGrade_LabActive         = "เปิดใช้งาน";
$strGrade_LabInActive     = "ปิดการใช้งาน";
$strGrade_LabAnalysis     = "ผลการวิเคราะห์";
$strGrade_LabStdDvt        = "ค่าเบี่ยงเบนมาตรฐาน";
$strGrade_LabMean          = "ค่าเฉลี่ย";
$strGrade_LabMedian      = "ค่ากลาง";
$strGrade_LabMaxValue  = "ค่าสูงสุด";
$strGrade_LabMinValue  = "ค่าต่ำสุด";
$strGrade_LabHeadSummary  = "สรุปผลการเรียน";
$strGrade_LabSummary  = "สรุปผล";

$strGrade_LabAmountSt = "จำนวนนักเรียน";
$strGrade_LabScoreLevel = "ช่วงคะแนน";
$strGrade_LabPercent = "ร้อยละ";
$strGrade_LabGraph    = "กราฟผลการเรียน";
$strGrade_LabGraphBar    = "กราฟแท่ง";
$strGrade_LabGraphCircle   = "กราฟวงกลม";
$strGrade_PrefRawscore   =  "แสดงคะแนนดิบ";
$strGrade_PrefviewAll   =  "แสดงผลการเรียนทุกคน";
$strGrade_Prefactive    = "เปิดให้นักเรียนเข้าดูได้";

$strGrade_SelectModule = "เลือก";
$strGrade_HeadListModule = "รายการส่วนการทำงานที่ใช้ตัดเกรด";
$strGrade_ModuleName = "ชื่อส่วนการทำงาน";
$strGrade_ModuleTotalscore = "คะแนนรวม";

$strGrade_BtnCalgrade =  "คำนวณผลการเรียน";
$strGrade_BtnNext        = "ถัดไป&gt;&gt;";
$strGrade_BtnBack        = "&lt;&lt;ย้อนกลับ";


//--------------------------------------------   Content [KAE]-----------------------------------------------------------------------------------------------------
$Content_Content =  "สารบัญ";
$Content_Lesson =  "บทเรียน ";
$Content_LessNum =  "บทที่";
$Content_LessName =  "ชื่อบทเรียน";
$Content_Abstract =  "เนื้อหาโดยสรุป";
$Content_Times =  "ระยะเวลา";
$Content_AddLess =  "เพิ่มบทเรียน";
$Content_UpdateLess =  "ปรับปรุงบทเรียน";
$Content_UpdateCon =  "ปรับปรุงบทเรียน";
$Content_NewContent =  "ตั้งชื่อใหม่";
$Content_TimeUnit =  "วัน";
$Content_NOTHAVE =  "ไม่มีบทเรียน";
$Content_LessNmEdit =  "แก้ไขชื่อบทเรียน ";
$Content_LessEdit =  "แก้ไขบทเรียน ";
$Content_LessShow =  "แสดงบทเรียน ";
$Content_HOME =  "กลับหน้าหลัก ";


//--------------------------------------------   Content [KAE]-----------------------------------------------------------------------------------------------------
//--------------------- Forum -------------------------

$strForum_Labwelcome="ยินดีต้อนรับ ";
$strForum_Labto=" เข้าสู่ ";
$strForum_Labmsg="ข้อความ";
$strForum_Labwrite_msg="เขียนข้อความ";
$strForum_Labsend=" ส่ง ";
$strForum_Laboption="ทางเลือก";
$strForum_Labpreference="ตั้งค่า";
$strForum_Labexit="ออกจากห้อง";
$strForum_Labuserlist="รายชื่อผู้ใช้ขณะนี้";
$strForum_Labshowemotion="แสดงอารมณ์";

//--------------------------------------------   Content [KAE]-----------------------------------------------------------------------------------------------------
$EVAL_Cat = "ประเภทของแบบประเมิน";
$EVAL_Perceptual = "แบบสำรวจการเรียนรู้ของนิสิต";
$EVAL_TEACHER="แบบประเมินการสอนของอาจารย์โดยนิสิต";
$EVAL_Amount= "จำนวน";
$EVAL_Persons= "คน";
$EVAL_Perceptual_title = "รูปแบบการเรียนรู้";
$EVAL_Student_All= "ผู้ลงทะเบียนเรียนทั้งหมด ";
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