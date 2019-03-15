<!doctype html>
<html>
<head>
<title>Asennus</title>
<meta charset="utf-8">
</head>
<body>
<?php
require "./yhteys.php";

$sql="DROP TABLE IF EXISTS juttu";
$kysely = $yhteys->query($sql);
if($kysely!=FALSE) echo "Poistetaan vanhat juttu-taulut..<br>";


$sql="DROP TABLE IF EXISTS kayttaja";
$kysely = $yhteys->query($sql);
if($kysely) echo "Poistetaan vanhat kayttaja-taulut..<br>";

?>
</body>
</html>
