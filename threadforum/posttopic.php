<? 
require("../include/global_login.php");
$webboard=new Webboard($topicid,$refid,'','','','',$person["id"],$id,$courses);
?>
<script language='JavaScript1.2' src='./javascript/ubbc.js' type='text/javascript'></script>
<script language='JavaScript1.2' type='text/javascript'>
extArray = new Array(".gif", ".jpg");
function showimage()
{
	document.images.icons.src='./images/icons/'+document.posttopic.icon.options[document.posttopic.icon.selectedIndex].value+'.gif';
}

function CheckTopic(form, file){
    if(document.posttopic.txt_sub.value==""){
       alert("You can't have subject");
           return false;
  	}else{
		if(document.posttopic.filename.value != ""){
			allowSubmit = false;
		  while (file.indexOf("\\") != -1)
			file = file.slice(file.indexOf("\\") + 1);
			ext = file.slice(file.indexOf(".")).toLowerCase();
			for (var i = 0; i < extArray.length; i++) {
				if (extArray[i] == ext) { 
					allowSubmit = true; 
					break;
				}
			}
			if (allowSubmit) return true;
			else{
				alert("Please only upload files that end in types:  " 
				+ (extArray.join("  ")) + "\nPlease select a new "
				+ "file to upload and submit again.");
				return false;
			}
		}else{
			return true;
		}
  	}
}

function CheckReply(form, file){
	if(document.posttopic.message.value =="" && document.posttopic.filename.value ==""){
		alert("You can't have message");
		return false;
	}/*else{
		if(document.posttopic.filename.value != ""){
        allowSubmit = false;
		  while (file.indexOf("\\") != -1)
			file = file.slice(file.indexOf("\\") + 1);
			ext = file.slice(file.indexOf(".")).toLowerCase();
			for (var i = 0; i < extArray.length; i++) {
				if (extArray[i] == ext) { 
					allowSubmit = true; 
					break;
				}
			}
			if (allowSubmit) return true;
			else{
				alert("Please only upload files that end in types:  " 
				+ (extArray.join("  ")) + "\nPlease select a new "
				+ "file to upload and submit again.");
				return false;
			}
		}else{
			return true;
		}
  	}*/else
		return true;
}

function LimitAttach(form, file) {
	allowSubmit = false;
	if (!file) return;
	while (file.indexOf("\\") != -1)
	file = file.slice(file.indexOf("\\") + 1);
	ext = file.slice(file.indexOf(".")).toLowerCase();
	for (var i = 0; i < extArray.length; i++) {
		if (extArray[i] == ext) { 
			allowSubmit = true; 
			break;
		}
	}
	if (allowSubmit) return true;
	else{
	alert("Please only upload files that end in types:  " 
	+ (extArray.join("  ")) + "\nPlease select a new "
	+ "file to upload and submit again.");
	return false;
	}
}

</script>
<? 
	//sql
	if($edit==1){
		@$sql=mysql_query("SELECT * FROM threadforum WHERE id=$topicid");
		@$rs=mysql_fetch_array($sql);
			$subject=$rs['subject'];
			$icon=$rs['icon'];
			$message=str_replace("<br />","",$rs['contrib']);
			$image=$rs['img'];
	}else{
		$subject="";
		$icon="";
		$message="";
		$image="";
	}
?>
<table width="70%"  border="0" align="center" cellpadding="0" cellspacing="1" class="tdborder1">
  <tr  class="boxcolor">
    <td height="15"><a name=new>
</a>&nbsp;</td>
  </tr>
 
 <tr>
    <td >
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" >
	<form name="posttopic" method="post" enctype="multipart/form-data" action="index.php?a=do_topic_aed" >
	<input type="hidden" name="id" value="<? echo $webboard->getWModules()?>">
	<input type="hidden" name="courses" value="<? echo $webboard->getWCourses()?>">
	<input type="hidden" name="refid" value="<?  echo $webboard->getWRefid() ?>">
	<input type="hidden" name="topicid" value="<? echo $webboard->getWId() ?>">
	<input type="hidden" name="edit" value="<? echo $edit ?>">
	<input type="hidden" name="topic" value="<? echo $topic ?>">
	<input type="hidden" name="reply" value="<? echo $reply ?>">
<? 
if($topic==1){ ?>
  <tr>
    <td width="21%" height="24" align="right" class="main"><b><? echo $strWebboard_LabSubject ?> :</b>&nbsp; </td>
    <td colspan="2"><input type="text" name="txt_sub" maxlength="200" size="50" value="<? echo $subject ?>" class="text"><span class="style1">*</span></td>
  </tr>
  <? 	if (empty($icon)) $icon='xx';
	$iconlist[$icon] = "selected";
	$iconshow = "<img src='./images/icons/$icon.gif' name='icons' border=0 hspace=15>";
	?>
  <tr>
    <td height="24" align="right" class="main"><b> <? echo $strWebboard_LabIcon ?> :</b>&nbsp;</td>
    <td colspan="2">
<select name='icon' onChange='showimage()'>
  <option value='xx'<? if($icon == 'xx') { echo "selected";}?>>มาตรฐาน
  <option value='thumbup' <? if($icon == 'thumbup') { echo "selected";}?>>รูปยกหัวแม่มือ
  <option value='thumbdown' <? if($icon == 'thumbdown') { echo "selected";}?>>รูปยกหัวแม่มือลง
  <option value='exclamation' <? if($icon == 'exclamation') { echo "selected";}?>>ป้ายเตือน
  <option value='question' <? if($icon == 'question') { echo "selected";}?>>เครื่องหมายคำถาม
  <option value='lamp' <? if($icon == 'lamp') { echo "selected";}?>>รูปดวงไฟ
  <option value='smiley' <? if($icon == 'smiley') { echo "selected";}?>>ยิ้ม
  <option value='angry' <? if($icon == 'angry') { echo "selected";}?>>โกรธ
  <option value='cheesy' <? if($icon == 'cheesy') { echo "selected";}?>>ดีใจมาก
  <option value='laugh' <? if($icon == 'laugh') { echo "selected";}?>>หัวเราะ
  <option value='sad' <? if($icon == 'sad') { echo "selected";}?>>เศร้า
  <option value='wink' <? if($icon == 'wink') { echo "selected";}?>>ยิ้มแบบขยิบตา
</select>	
<? echo $iconshow ?>
	</td>
  </tr>
  <? }?>
  <tr>
    <td height="24" align="right" valign="top" class="main"><b><? echo $strWebboard_LabMessage  ?> :</b>&nbsp;</td>
    <td colspan="2"><textarea name='message' rows=10 cols=30 style='width:95%' onSelect='javascript:storeCaret(this);' onClick='javascript:storeCaret(this);' onKeyUp='javascript:storeCaret(this);' onChange='javascript:storeCaret(this);' wrap="virtual" class="pn-text"><? echo $message?></textarea>	</td>
  </tr>
  <tr>
    <td height="24" align="right" class="main"><b><? echo $strWebboard_LabSmilies?> :</b>&nbsp;</td>
    <td colspan="2">
<? echo "
<script language='JavaScript1.2' type='text/javascript'>
	<!--
	if((navigator.appName == 'Netscape' && navigator.appVersion.charAt(0) >= 4) || (navigator.appName == 'Microsoft Internet Explorer' && navigator.appVersion.charAt(0) >= 4) || (navigator.appName == 'Opera' && navigator.appVersion.charAt(0) >= 4)) {
		document.write(\"<a href=javascript:smiley()><img src='./images/icons/smiley.gif' align=bottom alt='ยิ้ม' border='0'></a> \");
		document.write(\"<a href=javascript:wink()><img src='./images/icons/wink.gif' align=bottom alt='ยิ้มแบบขยิบตา' border='0'></a> \");
		document.write(\"<a href=javascript:cheesy()><img src='./images/icons/cheesy.gif' align=bottom alt='ดีใจมาก' border='0'></a> \");
		document.write(\"<a href=javascript:grin()><img src='./images/icons/grin.gif' align=bottom alt='ยิ้มยิงฟัน' border='0'></a> \");
		document.write(\"<a href=javascript:angry()><img src='./images/icons/angry.gif' align=bottom alt='โกรธ' border='0'></a> \");
		document.write(\"<a href=javascript:sad()><img src='./images/icons/sad.gif' align=bottom alt='เศร้า' border='0'></a> \");
		document.write(\"<a href=javascript:shocked()><img src='./images/icons/shocked.gif' align=bottom alt='ช็อค' border='0'></a> \");
		document.write(\"<a href=javascript:cool()><img src='./images/icons/cool.gif' align=bottom alt='เจ๋ง' border='0'></a> \");
		document.write(\"<a href=javascript:huh()><img src='./images/icons/huh.gif' align=bottom alt='อืม' border='0'></a> \");
		document.write(\"<a href=javascript:rolleyes()><img src='./images/icons/rolleyes.gif' align=bottom alt='ขยิบตา' border='0'></a> \");
		document.write(\"<a href=javascript:tongue()><img src='./images/icons/tongue.gif' align=bottom alt='แลบลิ้น' border='0'></a> \");
		document.write(\"<a href=javascript:embarassed()><img src='./images/icons/embarassed.gif' align=bottom alt='อายหน้าแดง' border='0'></a> \");
		document.write(\"<a href=javascript:lipsrsealed()><img src='./images/icons/lipsrsealed.gif' align=bottom alt='ปิดปากไม่พูด' border='0'></a> \");
		document.write(\"<a href=javascript:undecided()><img src='./images/icons/undecided.gif' align=bottom alt='ลังเล' border='0'></a> \");
		document.write(\"<a href=javascript:kiss()><img src='./images/icons/kiss.gif' align=bottom alt='จูบ' border='0'></a> \");
		document.write(\"<a href=javascript:cry()><img src='./images/icons/cry.gif' align=bottom alt='ร้องไห้' border='0'></a> \");
	}
	else { document.write(\"<font size=1>บราวเซอร์ไม่คอมแพตเทเบิ้ลกับปุ่มนี้</font>\"); }
	//-->
	</script>
	<noscript>
	<font size=1>บราวเซอร์ไม่คอมแพตเทเบิ้ลกับปุ่มนี้</font>
	</noscript>
"?>
	</td>
  </tr>
  <tr>
    <td height="24" align="right" valign="top" class="main"><b><? echo $strWebboard_LabPicture?> :</b>&nbsp;</td>
    <td colspan="2" class="main"><? echo $strWebboard_LabUpload; ?>(
	<script>
		document.write(extArray.join("  "));
	</script>)
	<br><input type=file name='filename' value='' size='30' maxlength='50' class="text">      &nbsp;&nbsp;(<? echo $strWebboard_LabTextSize?>)<br>
        <?
		if ($image !='') {				
			echo "<img name=previewPict src='./images/upload/$image' width=62 height=58 >";
			echo '<INPUT TYPE="checkbox" NAME="delpic" value=1 > '.$strWebboard_LabDeletePic;
		}
		else {
			echo "<img name=previewPict src='./images/blank.gif' border=0>";
		}
	?>	</td></tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="41%">
	<? if($webboard->getWRefid()==0){ ?>
	<input type="submit" name="submit" value="<? echo $strSubmit;?>" onClick="return CheckTopic(this.form, this.form.filename.value);" class="button">
	<? }else{?>
	<input type="submit" name="submit" value="<? echo $strSubmit;?>" onClick="return CheckReply(this.form, this.form.filename.value);" class="button">
	<? } ?>&nbsp;&nbsp;<input type="reset" name="reset" value="<? echo $strReset ?>" class="button"></td>
    <td width="38%">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</form>
