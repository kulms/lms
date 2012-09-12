<?php //require("../include/global_login.php"); ?>
<font face="MS Sans Serif" size="1">เอา email ไปวางไว้ใน text box แล้วระบุว่าคั้นด้วยอะไร <br>เช่น
ojini@ku.ac.th;su@ad.com  ก้อ เอาสองอันนี้ไปใส่ใน text box<br> แล้ว ระบุ delimiter เป็น ; กด submit  จะเก็บลงฐานข้อมูล
mysql ทันที ( delimiter เป็น spacebar ก็ได้)</font><br>
<body bgcolor="#FFFFFF">
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><form name="form1" action="manualadd.php" method="post" >
        <p align="center"> <font size="1" face="MS Sans Serif, Microsoft Sans Serif">
          <textarea name="emailtext" rows="10" cols="50"></textarea>
          </font></p>
        <p align="center"><font size="1" face="MS Sans Serif, Microsoft Sans Serif">delimiter
          <input type="text" name="delimiter" size="4" maxlength="2">
          </font></p>      <p align="center"> <font size="1" face="MS Sans Serif, Microsoft Sans Serif">
<input type="hidden" name="insert" value="insert">
          <input type="submit" name="submit" value="submit">
          <input type="reset" name="Submit2" value="Reset">
          </font></p>
</form></td>
  </tr>
</table>
<? if ($insert=="insert"){
//echo $emailtext;
$arr=split("\n",$emailtext);
while (list ($i) = each ($arr))
   {
//echo $i.".".$arr[$i];
//if ($arr[$i]!="")
  //   {
    // echo "number:".$arr[$i]."<br>";
      $arr[$i]=substr($arr[$i],0,7);
      echo $arr[$i];
      $arr[$i]="b".$arr[$i];
      //echo $arr[$i]."<br>";
      $email=$arr[$i]."@csc.ku.ac.th";
      echo " ".$email."--->";
         //echo " ---lowercase-->".$arr[$i]."<br>";
     $ck=mysql_query("SELECT login FROM users WHERE login like '".$arr[$i]."';");
     if (mysql_num_rows($ck)>0)
     {echo "Update...";
     if(mysql_query("update users set email='$email',password='".$arr[$i]."',deptcode=25,category=3 where login='".$arr[$i]."';"))
        {echo "yes!<br>";}else{echo "failed<br>";}
     }else{echo "Insert...";
           if(mysql_query("insert into users (active,login,password,email,deptcode,category) values (1,
           '".$arr[$i]."','".$arr[$i]."','$email',25,3);")){echo "Yes<br>";}else{echo "Failed<br>";}

           }

    //  }
  }

}
/*
if(mysql_num_rows($check1)!=0){echo "  --->Skipped ...user Duplicate<br>";
$i++;
                            }
elseif (mysql_num_rows($check1)==0 && $arr[$i] !=""){
//mysql_query("INSERT INTO users (active,login,email,category,campus) VALUES (1,'".$arr[$i]."');");
echo "   --->Inserted<font color=red>...Yes</font><br>";
$i++;
                 }else{echo " <font color=green>--->Spacebar....Skipped</font><br>"; $i++;}
    }

             }
*/
?>