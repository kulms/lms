<?
        $rs=mysql_query("SELECT * from homework WHERE modules=$modules;");
        while($r=mysql_fetch_array($rs)){
                exec("rm -R -f $realpath/homework/files/".$r["id"]);
        }
        mysql_query("DELETE FROM homework WHERE modules=$modules;");
?>