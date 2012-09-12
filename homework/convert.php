<?require("../include/global_login.php");
$grpname=mysql_query("SELECT name FROM modules WHERE id=$id;");
$seekfile=mysql_query("SELECT * FROM homework WHERE modules=$id AND users=".$person["id"]." AND sendtype=3 ORDER BY id;");
$num=1;
while($row=mysql_fetch_array($seekfile))
    {
      $getans=mysql_query("SELECT * FROM homework_ans WHERE refid = ".$row["id"]." AND modules=".$row["modules"].";");
while($ans=mysql_fetch_array($getans)){
      $userinfo=mysql_query("SELECT * FROM users WHERE id=".$ans["users"].";");

      $gname=mysql_result($userinfo,0,"firstname");
      $gsurname=mysql_result($userinfo,0,"surname");
      $glogin=mysql_result($userinfo,0,"login");
      $gemail=mysql_result($userinfo,0,"email");
      $ggroup=mysql_result($grpname,0,"name");
      $olddir=$row["id"];
      $oldfile=$ans["file"];

       echo $olddir;
       echo "<br>";
       echo $oldfile;
       echo "<br>";

      $name="<name>".$gname." ".$gsurname. "</name>";
      $login="<id>".$glogin."</id>";
      $email="<email>".$gemail."</email>" ;
      $group="<group>".$ggroup."</group>";

      $filename=$glogin."-".$ggroup."-".$num.".pas";
      echo ($filename);
      if( $file=fopen("/home/jtn/backup/homework/pas/$filename","w"))
      {
      fputs($file,"$name\n $login\n $email\n $group\n");
      fclose($file);
      $last=fopen("/home/jtn/backup/homework/pas/$filename","a");
      $pas=fopen("/home/jtn/backup/homework/ansfiles/$olddir/$oldfile","r");
      while (fgets($buff,1024,"/home/jtn/backup/homework/pas/$filename") != NULL){
      fprintf("/home/jtn/backup/homework/ansfiles/$olddir/$oldfile","%s",$buff);
            }
          echo $pas;
   //   fwrite($last,$pas);
      fclose($last);
      fclose($pas);

      }
      $num++;
     }
}
 ?>
