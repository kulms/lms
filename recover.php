<?require("include/global_login.php");
/*function password(){
        srand((double)microtime()*1000000);
        $numchar=rand(4,6);
        $temp="";
        for($b=0;$b<$numchar;$b++){
                $chrnum=rand(48,109);
                if($chrnum>57){
                        $chrnum+=7;
                }
                if($chrnum>90){
                        $chrnum+=6;
                }
                $temp=$temp.chr($chrnum);
        }
        return $temp;
}
$sql=mysql_query("SELECT * FROM users;");
$sign="@";
while($row=mysql_fetch_array($sql)) {
$passwd=password();
$test=$row["email"];
$spit=split($sign,$test);
$login="$spit[0]";
echo " $passwd";
echo "<br>";
mysql_query("UPDATE users set login='$login', password='$passwd' WHERE id=".$row["id"].";");
$emailhost="@nontri.ku.ac.th";
$email="$login$emailhost";
$mailbody = "Password of all users for login to Classroom Support@Faculty of Engineering have been reset!\n\nPlease use this news one as initial password. And you can change it later :\nUser
Name:".$login."\nPassword:".$passwd."\n\n Any problems please contact administrator";
                if(mail($email,"Password has been Reset!!",$mailbody,"From:admin@$SERVER_NAME")){
                        echo "OK! <BR>";
                }

}
*/
?>

<?mysql_close();?>