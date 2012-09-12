<?require("../include/global_login.php");
/*
 * **********************************************
 * **        PHP - WebBoard : Show Image       **
 * **********************************************
 * *                                            *
 * * Developed By : Sansak Chairattanatrai      *
 * * E-mail :  sansak@engineer.com              *
 * * UIN : 5590582                              *
 * * License : SamChai Public Soft Group(tm).   *
 * *                                            *
 * **********************************************
 */

        require("config.inc.php");

        // ติดต่อ database เพื่ออ่านข้อมูล
        $sql = "select image from webboard_$table where No='$No'";
        $result = mysql_db_query($dbname,$sql);
        $row = mysql_fetch_row($result);

        // กำหนด Header เป็น GIF
        header("Content-type: image/gif");

        // แสดงภาพ
        echo $row[0];

?>