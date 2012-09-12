fdsfds<br>
<?
$subject=" gjfkdgöjkerajfkalfa ea fehuf wf jke-dfsjfk.sf@fdsjk.se fejaw fhewajlf hewajflheajflehawjfl ehwajflweahjfewlahfjewlahf jewalf hewjalfhewajkl fehajwlfhjewal hfewjalk fewa";
if(!eregi("([[:alnum:]]+)",$subject)){
	$subject="[no subject]";
}
echo $subject."<hr>";

$subject=" \n\r";
if(!eregi("([[:alnum:]])",$subject)){
	$subject="no subject";
}
echo $subject."<hr>";


?>
