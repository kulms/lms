<?  session_start();

for($i=1;$i<=$allM;$i++){   // Standard question 
		$sgid =$_POST["m".$i];
		if($_POST["sqv".$sgid] !=""){
				$_SESSION["s_ques_gid$sgid"]= $sgid ;
				$_SESSION["s_ques_gvalue$sgid"]= $_POST["sqv".$sgid];
				session_register("s_ques_gid$sgid") ;
				session_register("s_ques_gvalue$sgid");
		}
		//echo $_SESSION["s_ques_gid$sgid"]."===".
				//$_SESSION["s_ques_gvalue$sgid"];
}

//echo $_POST[comment_id1],$_POST[comment_id2];
//echo $_POST[comment39],$_POST[comment46];

//echo $_POST[allNumC];
for($c=1;$c<$_POST[allNumC];$c++){   // Standard question 
		$com_id =$_POST["comment_id".$c];
		//echo $_POST["comment_id".$c];
		if($com_id !=""){
				$_SESSION["comment_id$com_id"]=$com_id;
				$_SESSION["comment$com_id"]= $_POST["comment".$com_id];
				session_register("comment_id$com_id") ;
				session_register("comment$com_id");
		//echo $_SESSION["comment_id$com_id"]."===".
				//$_SESSION["comment$com_id"];
		
		}
		
}
/*allNumC
if($_POST[comment_id] !=""){
				$_SESSION["comment_id$"] = $_POST[comment_id];
				$_SESSION[comment] = $_POST[comment];
				session_register("comment_id") ;
				session_register("comment");
		}
		*/
for($ii=1;$ii<=$allN;$ii++){   //  question  from teacher
		$qid =$_POST["n".$ii];
		if($_POST["qv".$qid] !=""){
				$_SESSION["ques_id$qid"]=$qid;
				$_SESSION["ques_value$qid"]= $_POST["qv".$qid];
				session_register("ques_id$qid") ;
				session_register("ques_value$qid");
		}
		//echo $_SESSION["ques_id$qid"]."--------".$_SESSION["ques_value$qid"] ;
		//echo "<br>";

}
		

if(isset($_POST[pback])){
		$gb = $_REQUEST[gg]-1;
		header("Location: std_eval.php?gg=$gb&m_id=$_REQUEST[m_id]#QT");
}
if(isset($_POST[pnext])){
		$gb = $_REQUEST[gg]+1;
		header("Location: std_eval.php?gg=$gb&m_id=$_REQUEST[m_id]#QT");
}
if(isset($_POST[submit])){
		header("Location: std_eval.php?esubmit=1&m_id=$_REQUEST[m_id]");
}

		
	?>