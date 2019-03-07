<?php
require "./yhteys.php";//tietokantayhteys käyttöön 
$oppi="SELECT etunimi, sukunimi FROM oppilas WHERE etunimi = 'joku'";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="main.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>EDiary</title>
</head>
<body class="main">
    <div class="container-fluid">
        <div class="row text-center">
			<div class="col center mt-2"> 
				<p class="white"><b>Oppilas: <?php foreach($yhteys->query($oppi) as $oppilas) { 
					echo $oppilas["etunimi"]." ".$oppilas["sukunimi"]; } ?></b></p>
			</div>
        </div>
		<div class="row">
			<div class="col"><p class="grey"><b>Peli</b></p> </div>
			<div class="col"><p class="grey"><b>tunnit</b></p> </div>
			<div class="col"><p class="grey"><b>Pvm</b></p> </div>
			<div class="col"><p class="grey"><b>Unimäärä</b></p> </div>
			<div class="col"><p class="grey"><b>Liikunta</b></p> </div>
			<div class="col"><p class="grey"><b>Ruokailu</b></p> </div>
			<div class="col"><p class="grey"><b>Mieliala</b></p> </div>
		</div>
		<?php
			

			$sql="SELECT peli.genre, peli.maara, paivakirja.pvm, paivakirja.uni, liikunta.laji, paivakirja.mieliala, ruokailu.ateria FROM paivakirja
			INNER JOIN peli ON paivakirja.PeliID=peli.PeliID
			INNER JOIN ruokailu ON paivakirja.RuokailuID=ruokailu.RuokailuID
			INNER JOIN liikunta ON paivakirja.liikuntaID=liikunta.liikuntaID";
			//require "./yhteys.php"; 
			$kysely = $yhteys->query($sql); 
			$rivit = $kysely->rowCount();
			$vastaus = $kysely->fetchAll(PDO::FETCH_ASSOC); 

			if($rivit<=10) $raja=$rivit;//jos rivejä on vähemmän kuin 5, tulostetaan todellinen määrä 
			else $raja=10; 
			for($i=0;$i<$raja;$i++) { 
				$peli=$vastaus[$i]["genre"]; 
				$maara=$vastaus[$i]["maara"]; 
				$pvm=$vastaus[$i]["pvm"]; 
				$uni=$vastaus[$i]["uni"]; 
				$liikunta=$vastaus[$i]["laji"]; 
				$ruoka=$vastaus[$i]["ateria"]; 
				$mieli=$vastaus[$i]["mieliala"];
				
		?>
		<div class="row">
			<div class="col"><p class="white"><?php echo $peli; ?></p> </div>
			<div class="col"><p class="white"><?php echo $maara; ?>H</p> </div>
			<div class="col"><p class="white"><?php echo $pvm; ?></p> </div>
			<div class="col"><p class="white"><?php echo $uni; ?>H</p> </div>
			<div class="col"><p class="white"><?php echo $liikunta; ?></p> </div>
			<div class="col"><p class="white"><?php echo $ruoka; ?></p> </div>
			<div class="col"><p class="white"><?php echo $mieli; ?></p> </div>
		</div>
		<?php
			} 
		?>
    </div>
    
</body>
</html>