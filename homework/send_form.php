<? 
	session_start();  
	require("../include/global_login.php");
	require_once ("./classes/User.php");
	require_once ("./classes/UserStorage.php");
	require_once( "./includes/main_functions.php" );
		
	$user = UserStorage::lookupById($person["login"]);
	
	session_register( 'user' ); 
	
	switch ($user->getCategory()) {
		case 0:
			$uistyle = "admin";
			break;
		case 1:
			$uistyle = "admin";
			break;
		case 2:
			$uistyle = "teacher";
			break;
		case 3:
			$uistyle = "student";
			break;
		default:
			$uistyle = "guest";
		}
	
	require "./style/$uistyle/header.php";
	require "./style/$uistyle/footer.php";	

	
?>
<? 

$showassg=mysql_query("SELECT * FROM homework WHERE id=$id;");
$showpref=mysql_query("SELECT * FROM homework_prefs WHERE modules=$modules;");
$checkans=mysql_query("SELECT * FROM homework_ans WHERE refid=$id AND modules=$modules AND users=".$person["id"].";");

?>
<html>
<head>
        <title>Send Homework</title>
<html>
<head>
        <title>Edit resources</title>
        <script language="javascript">
        <!--
        /*function upload_check(){
                if(document.uploadform.file.value==""){
                        alert("Empty File Name!!");
                        return false;
                }else{
                        return true;
                }
        }*/
		<!-- Begin

		//var mikExp = /[$\@#%\^\&\*\(\)\[\]\+\{\}\'\~\=\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\|]/;
		var mikExp = /[$\@#%\^\&\*\(\)\[\]\+\{\}\'\~\=ù]/;
		
		function checkFields(val) {
		
			missinginfo = "";
			if (uploadform.file.value == "") {
				missinginfo += "\n     -  File Upload";
			}
			
			if (missinginfo != "") {
				missinginfo ="_____________________________\n" +
				"You failed to correctly fill in your:\n" +
				missinginfo + "\n_____________________________" +
				"\nPlease re-enter and submit again!";
				alert(missinginfo);
				return false;
			}
			else {
				//return true;
				if(uploadform.file.value.search(mikExp) == -1) {
					//alert("Correct Input");
					return true;
				}
				else {
					alert("Sorry, but the following characters\n\r\n\r@ $ % ^ & * # ( ) [ ]  { + } ` ~ =  | \n\r\n\rFilename ѡ\n\r\n\rare not allowed!\n");
					return false;
				}
			}
		}
		
		//  End -->
        function delete_check(){
                if(confirm("Do you really want to delete "+document.renameform.resourcesname.value+" and all its content?")){
                        if(confirm("Are you really...REALLY sure?\nThis action can't be undone.")){
                                return true;
                        }else{
                                return false;
                        }
                }else{
                        return false;
                }
        }
        //-->
        </script>

<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />-->
</head>
<body bgcolor="#ffffff">
<div class="info">
<h1><? echo $user->_('Homework Send Answer');?></h1>

<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tdborder2" >	
	<tr>
		<td width="100%" valign="top">		
			<table cellspacing="1" cellpadding="2" border="0" width="100%">
          <tr class="boxcolor"> 
            <th align="right" nowrap   class="Bcolor"><?php echo $user->_($strHome_LabQuestion);?>:</th>
            <td class="hilite" width="100%" bgcolor="#FFFFFF"> <? echo nl2br(mysql_result($showassg,0,"name"));?> 
            </td>
          </tr>
          <tr class="boxcolor">
            <th align="right" nowrap   class="Bcolor"><?php echo $user->_($strHome_LabMaxScores);?>:</th>
            <td class="hilite" bgcolor="#FFFFFF"><? echo nl2br(mysql_result($showassg,0,"points"));?></td>
          </tr>
        </table>
		</td>	 
  </table>
  <br>
  <table border="0" cellpadding="2" cellspacing="0" width="100%" class="tdborder2">
    <? if(mysql_result($showassg,0,"sendtype") == 1){ ?>
    <form action="send.php" method="post">
      <tr> 
        <td colspan="2"  class="hilite"><input name="submit3" type="submit" class="button" value="<? echo $user->_($strSubmit);?>"> 
          <input name="button4" type="button" class="button" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location='index.php?id=<?echo $modules?>';}" value="<? echo $user->_($strCancel);?>"> 
          <?
		    if(mysql_num_rows($checkans) ==1){
            ?>
          <input name="button3" type="button" class="button" onClick="if(confirm('Realy delete?')){location='delete_ans.php?modules=<?echo $modules?>&id=<?echo $id ?>&file=<? if (mysql_num_rows($checkans) == 1){ echo mysql_result($checkans,0,"file"); } ?>';}" value="<? echo $user->_($strDelete);?>"> 
          <?
			}
			?>
        </td>
      <tr> 
        <input type="hidden" name="modules" value="<?echo $modules?>">
        <input type="hidden" name="id" value="<?echo $id?>">
        <td ><? echo $user->_($strHome_LabAnswer);?>:</td>
        <td ><textarea ROWS="10" COLS="112" name="name" wrap="virtual"><? if(mysql_num_rows($checkans) == 1){ echo mysql_result($checkans,0,"name"); } ?></textarea> 
        </td>
      <tr> 
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr></tr>
    </form>
    <? }
           if(mysql_result($showassg,0,"sendtype") == 2){ ?>
    <form action="send.php" method="post">
      <tr> 
        <td colspan="2"  class="hilite"><input name="submit2" type="submit" class="button" value="send"> 
          <input name="button2" type="button" class="button" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location='index.php?id=<?echo $modules?>';}" value="cancel"> 
          <?
		    if(mysql_num_rows($checkans) ==1){
            ?>
          <input name="button3" type="button" class="button" onClick="if(confirm('Realy delete?')){location='delete_ans.php?modules=<?echo $modules?>&id=<?echo $id ?>&file=<? if (mysql_num_rows($checkans) == 1){ echo mysql_result($checkans,0,"file"); } ?>';}" value="delete"> 
          <?
			}
			?>
        </td>
      </tr>
      <tr> 
        <input type="hidden" name="modules" value="<?echo $modules; ?>">
        <input type="hidden" name="id" value="<?echo $id; ?>">
        <td >Send URL:</td>
        <td ><input type="text" name="url" size="70" value="http://<? if (mysql_num_rows($checkans) == 1){ echo str_replace("http://","",mysql_result($checkans,0,"url")); } ?>" class="text">	
        </td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </form>
    <?
                     }
               if(mysql_result($showassg,0,"sendtype") == 3){ ?>
    <form action="send.php" method="post" enctype="multipart/form-data" onSubmit="return checkFields(this.file);" name="uploadform">
      <tr> 
        <td colspan="2" class="hilite" ><input name="submit" type="submit" class="button"  value="send"> 
          <input name="button" type="button" class="button" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location='index.php?id=<?echo $modules?>';}" value="cancel"> 
          <?
		    if(mysql_num_rows($checkans) ==1){
            ?>
          <input type="button" value="delete" onClick="if(confirm('Realy delete?')){location='delete_ans.php?modules=<?echo $modules?>&id=<?echo $id ?>&file=<? if (mysql_num_rows($checkans) == 1){ echo mysql_result($checkans,0,"file"); } ?>';}" class="button"> 
          <?
			}
			?>
        </td>
      <tr>
        <td >Answer:</td>
        <td ><textarea ROWS="10" COLS="112" name="name" wrap="virtual" class="pn-text"><? echo @mysql_result($checkans,0,"name");?></textarea> 
        </td>
	  </tr>	
      <tr> 
        <input type="hidden" name="modules" value="<? echo $modules?>">
        <input type="hidden" name="id" value="<? echo $id?>">
        <input type="hidden" name="oldfile" value="<? if (mysql_num_rows($checkans) == 1){ echo mysql_result($checkans,0,"file"); } ?>">
        <td >Send file <br> </td>
        <td > <input type="file" name="file" size="40" class="text"> </td>
      <tr> 
        <td >Old file: </td>
        <td class="hilite" bgcolor="#FFFFFF"> 
          <? if (mysql_num_rows($checkans) == 1){ echo mysql_result($checkans,0,"file"); }?>
        </td>
      </tr>
      <tr> 
        <td >&nbsp;</td>
        <td ><table width="100%" border="0" cellpadding="1" cellspacing="1"  class="tdborder4" >
            <tr> 
              <th width="17%" ><span class="Bcolor">Conditions:</span></th>
              <td width="83%" bgcolor="#FFFFFF" class="red"><strong>- not 
                over 
                <? 
								$fsize = mysql_result($showassg,0,"filesize");
								switch ($fsize) {
								case 1:
									$fsize_name = "100 KB";
									break;
								case 2:
									$fsize_name = "500 KB";
									break;
								case 3:
									$fsize_name = "1 MB";
									break;
								case 4:
									$fsize_name = "1.5 MB";
									break;
								case 5:
									$fsize_name = "2 MB";
									break;
								case 6:
									$fsize_name = "10 MB";
									break;	
								}
								echo $fsize_name;
								?>
                maximum</strong></td>
            </tr>
            <tr> 
              <td rowspan="2" >&nbsp;</td>
              <td class="red" bgcolor="#FFFFFF"><strong>- only upload file 
                in type ( 
                <? 
								$ftype = mysql_result($showassg,0,"filetype");
								switch ($ftype) {
								case 1:
									$ftype_name = "gif";
									break;
								case 2:
									$ftype_name = "jpg";
									break;
								case 3:
									$ftype_name = "jpeg";
									break;
								case 4:
									$ftype_name = "png";
									break;
								case 5:
									$ftype_name = "gif & jpg & jpeg & png";
									break;
								case 6:
									$ftype_name = "doc";
									break;
								case 7:
									$ftype_name = "pdf";
									break;
								case 8:
									$ftype_name = "doc & pdf";
									break;							
								case 9:
									$ftype_name = "Any type";
									break;								
								}
								echo $ftype_name;
								?>
                )</strong></td>
            </tr>
            <tr> 
              <td class="red" bgcolor="#FFFFFF"><b>- English File Name 
                only!!!</b></td>
            </tr>
          </table></td>
      </tr>
    </form>
    <?                }
                                        
                        ?>
  </table>
</div>
<?
if((time() > @mysql_result($showpref,0,"end_date"))){
	print( "<script language=javascript> alert(\"You can send this homework 1 time.\"); </script>");
}
?>
</body>
</html>
<? /*
<? if (mysql_result($showassg,0,"sendtype") == 0){ ?>
       <tr>
       <td class="info" align="center">This assignment doesn't assign participation type from your course admin. <br>
                       You can do it by choosing one in three ways below....<br><hr width=50% noshade>
        </td></tr>
                         <tr>
                         <form action="send.php" method="post">
                         <input type="hidden" name="modules" value="<?echo $modules?>">
                         <input type="hidden" name="id" value="<?echo $id?>">
                         <input type="hidden" name="sendtype" value="1">
                         <td class="res">1. Typing your answer in the textbox : <br>
                         <textarea ROWS="5" COLS="40" name="name" wrap="virtual" class="small"><?echo $r["name"] ?></textarea>
                         <br>
                         <input type="submit" value="Send text"><input type="reset" value="Clear">
                          <br><hr width=50% noshade></td>
                         </form>
                 </tr>
                         <tr>
                         <form action="send.php" method="post">
                         <input type="hidden" name="modules" value="<?echo $modules?>">
                         <input type="hidden" name="id" value="<?echo $id?>">
                         <input type="hidden" name="sendtype" value="2">
                         <td class="res">2. Send URL : <br>
                         <input type="text" name="url" size="40" value="http://<?echo $r["url"]?>">
                         <br>
                         <input type="submit" value="Send URL">
                          <br><hr width=50% noshade></td>
                         </form>
                         </tr>
                        <tr>
                                <form action="send.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="modules" value="<?echo $modules?>">
                                <input type="hidden" name="id" value="<?echo $id?>">
                                <input type="hidden" name="sendtype" value="3">
                                <td class="res">3. Send file : <br>
                                Old file:<i><?echo $r["file"]?></i><br>
                                <input type="file" size="40" name="file"><br>
                                <input type="submit" value="Send file">
                                </td>
                                </form>
                        </tr>
                        <?                }
                                         if($r["users"]==$person["id"] || $person["admin"]==1 || $cadmin==1){
                        ?>
                        <tr>
                                <td colspan="2" align="center">
                                        <form><input type="button" value="Delete!" onClick="if(confirm('Realy delete?')){location='delete.php?modules=<?echo $modules?>&id=<?echo $r["id"]?>';}"></form>
                               </td>
                        </tr>
<? } ?>
</table>
</div>
</body>
</html>
*/ ?>
