<?
//$fichier="../files/syllabus/5/20021003160911.pdf";
$NomFichier = basename($fichier);

@set_time_limit(600);

echo("Content-Type: application/force-download; name=\"$NomFichier\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: $taille");
header("Content-Disposition: attachment; filename=\"$NomFichier\"");
header("Expires: 0");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
readfile("$fichier");
//readfile("../files/syllabus/5/20021003160911.pdf");
//readfile("$cheminrelatif/$chemin/$fichier");
exit();
?>