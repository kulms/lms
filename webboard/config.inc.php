<?
/*
 * **********************************************
 * **    PHP - WebBoard : Configuration File   **
 * **********************************************
 * *                                            *
 * * Developed By : Sansak Chairattanatrai      *
 * * E-mail :  sansak@engineer.com              *
 * * UIN : 5590582                              *
 * * License : SamChai Public Soft Group(tm).   *
 * *                                            *
 * **********************************************
 */

//(1) ตั้งค่าต่างๆ ของ MySQL Server
//        $host = "course.eng.ku.ac.th";
//        $user = "alumni";
//        $passwd = "inmula";
//        $dbname = "alumni";

//(2) Admin Password
        $admin = "jtn";
        $admin_pwd = "";

//(3) ตั้งค่าความต่างของเวลา Server กับ ประเทศไทย
        $p_hour = 0;
        $p_min = 0;

//(4) ตั้งค่าจำนวนคำถามต่อหน้า
        $list_page = 20;

//(5) ตั้งค่าให้แสดงหมายเลข IP Address
        // ALL - แสดงหมดทุกหลัก , BAN - แสดง 3 หลักแรก , NONE - ไม่แสดง IP Address
        $showIP = "BAN";

//(6) เลือกระบบส่งอีเมล์
        // 1 - ส่งเมล์จาก Script ของเว็บบอร์ด , 2 - ส่งเมล์จาก MS Outlook Express
        $s_mail = "1";

//(7) กำหนดขนาดของภาพที่อนุญาตให้ upload ได้ (หน่วยเป็น byte)
        $Image_size = 1024000;        // 10240 = 10 kbytes

//(8) กำหนดรูปแบบของตัวแสดงสถานะ ICQ (1-17)
        $ICQ_Image_Type = 5;

//(9) แสดงลำดับของคำตอบ
        // ASC - เรียงลำดับข้อมูลจากน้อยไปมาก , DESC - เรียงลำดับข้อมูลจากมากไปน้อย
        $order = "ASC";
?>