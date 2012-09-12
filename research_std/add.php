<?require("../include/global_login.php");
if($Submit=="Add"){
mysql_query("insert into research_std(rs_title_thai,rs_title_eng,rs_keyword,users) values ('$rs_title_thai',
'$rs_title_eng','$rs_keyword','".$person["id"]."');");
$rs_id=mysql_insert_id();
$intfile=$rs_id."-1.pdf";
$objfile=$rs_id."-2.pdf";
$profile=$rs_id."-3.pdf";
$litfile=$rs_id."-4.pdf";
$desfile=$rs_id."-5.pdf";
$devfile=$rs_id."-6.pdf";
$tesfile=$rs_id."-7.pdf";
$resfile=$rs_id."-8.pdf";
$othfile=$rs_id."-9.pdf";
if($rs_intro!="none")
     {
      if(copy($rs_intro,"../files/project/".$intfile))
         {
            mysql_query("update research_std set rs_intro='$intfile' where id=$rs_id;");
            echo "uploading $intfile file Completed...<br>";
         }
     }

if($rs_objective!="none")
     {
      if(copy($rs_objective,"../files/project/".$objfile))
         {
            mysql_query("update research_std set rs_objective='$objfile' where id=$rs_id;");
            echo "uploading $objfile file Completed...<br>";
         }

     }
if($rs_problem!="none")
     {
      if(copy($rs_problem,"../files/project/".$profile))
         {
            mysql_query("update research_std set rs_problem='$profile' where id=$rs_id;");
            echo "uploading $profile file Completed...<br>";
         }

     }
if($rs_literature!="none")
     {
      if(copy($rs_literature,"../files/project/".$litfile))
         {
            mysql_query("update research_std set rs_literature='$litfile' where id=$rs_id;");
            echo "uploading $litfile file Completed...<br>";
         }

     }
if($rs_design!="none")
     {
      if(copy($rs_design,"../files/project/".$desfile))
         {
            mysql_query("update research_std set rs_design='$desfile' where id=$rs_id;");
            echo "uploading $desfile file Completed...<br>";
         }

     }
if($rs_development!="none")
     {
      if(copy($rs_development,"../files/project/".$devfile))
         {
            mysql_query("update research_std set rs_development='$devfile' where id=$rs_id;");
            echo "uploading $devfile file Completed...<br>";
         }

     }
if($rs_testing!="none")
     {
      if(copy($rs_testing,"../files/project/".$tesfile))
         {
            mysql_query("update research_std set rs_testing='$tesfile' where id=$rs_id;");
            echo "uploading $tesfile file Completed...<br>";
         }

     }
if($rs_result!="none")
     {
      if(copy($rs_result,"../files/project/".$resfile))
         {
            mysql_query("update research_std set rs_result='$resfile' where id=$rs_id;");
            echo "uploading $resfile file Completed...<br>";
         }

     }
if($rs_other1!="none")
     {
      if(copy($rs_other1,"../files/project/".$othfile))
         {
            mysql_query("update research_std set rs_other1='$othfile',rs_other1_text='$rs_other1_text' where id=$rs_id;");
            echo "uploading $othfile file Completed...<br>";
         }

     }

}
?>
