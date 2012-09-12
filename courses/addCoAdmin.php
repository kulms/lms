<?    require("../include/global_login.php");  ?>
<html>
<head>
<title>:-: Add Co-Admin :-:</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script language="javascript">
function startup()
{
        document.course.elements["courseadmins[]"].options[0]=null;
       <!-- document.course.elements["users[]"].options[0]=null;-->
}
<!-- function addadmin()
//{
       // for(a=document.course.elements["users[]"].options.length-1;a>-1;a--)
		//{
                //if(document.course.elements["users[]"].options[a].selected)
				//{
                       // document.course.elements["courseadmins[]"].options[document.course.elements["courseadmins[]"].options.length]=new Option(document.course.elements["users[]"].options[a].text,document.course.elements["users[]"].options[a].value);
                       // document.course.elements["users[]"].options[a]=null;
               // }
       // }
//}-->
<!--function removeadmin()
//{
        //for(a=document.course.elements["courseadmins[]"].options.length-1;a>-1;a--)
		//{
               // if(document.course.elements["courseadmins[]"].options[a].selected)
				//{
                       // document.course.elements["users[]"].options[document.course.elements["users[]"].options.length]=new Option(document.course.elements["courseadmins[]"].options[a].text,document.course.elements["courseadmins[]"].options[a].value);
                       // document.course.elements["courseadmins[]"].options[a]=null;
               // }
       // }
//} -->
function mark_all()
{
        for(a=document.course.elements["courseadmins[]"].options.length-1;a>-1;a--)
		{
                document.course.elements["courseadmins[]"].options[a].selected=true;
        }
}
</script> 
</head>

<body>

</body>
</html>
