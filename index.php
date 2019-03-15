<?php
session_start();
$_SESSION["oppilasID"]=1;
require "./yhteys.php";//tietokantayhteys käyttöön 
require "./tkfunktiot.php";
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
			<div class="col"><p class="grey"><b>Mieliala (1 - 5)</b></p> </div>
		</div>
		<?php
			

			$sql="SELECT peli.genre, paivakirja.maara, paivakirja.pvm, paivakirja.uni, liikunta.laji, paivakirja.mieliala, ruokailu.ateria FROM paivakirja
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

			if (!empty($_POST["genre"]) && !empty($_POST["maara"]) && !empty($_POST["Uni"]) && !empty($_POST["liikunta"]) && !empty($_POST["ruokailu"]) && !empty($_POST["Mieliala"]) && !empty($_POST["pvm"])) { 
				$peliid = $_POST['genre']; 
				$pmaara = $_POST['maara']; 
				$Uni = $_POST['Uni']; 
				$liikunt = $_POST['liikunta']; 
				$ruokailu = $_POST['ruokailu']; 
				$mieliala = $_POST['Mieliala']; 
				$pvm = $_POST['pvm']; 

				$tieto = "INSERT INTO paivakirja (PeliID,maara,Uni,LiikuntaID,RuokailuID,Mieliala,pvm) VALUES ('$peliid','$pmaara','$Uni','$liikunt','$ruokailu','$mieliala','$pvm')"; 
			echo $tieto;
				$kysely=$yhteys->query($tieto); 
				//$kysely->execute(array($peliid,$pmaara,$Uni,$liikunt,$ruokailu,$mieliala,$pvm)); 
				if($kysely!=FALSE) echo "Tiedot lisätty"; 
				else echo "Lisäys ei onnistunut, yritä myöhemmin uudelleen"; 
			}
		?>


			<button onclick="document.getElementById('id01').style.display='block'" class="col text-center link">Lisää merkintä</button>
			<div id="id01" class="modal">
			  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
			  <form class="modal-content" action="./index.php" method="post">
				<div class="container">
				  <h1>Lisää merkintä</h1>
				  <hr>
				  <?php echo tulosta_peligenre($peliId,$yhteys); ?><br>
				  <input type="text" placeholder="pelauksen määrä(H)" name="maara" value="<?php if(isset($_POST["maara"]))?>"required>
				  <input type="text" placeholder="unen määrä(H)" name="Uni" value="<?php if(isset($_POST["Uni"]))?>" required><br>
				  <?php echo tulosta_lajivalintalista($lajiId,$yhteys); ?><br>
				  <?php echo tulosta_ruokalista($ruokaId,$yhteys); ?><br>
				  <label><b> Mieliala</b>
					<input type="radio" name="Mieliala" value="1"> 1
					<input type="radio" name="Mieliala" value="2"> 2
					<input type="radio" name="Mieliala" value="3" checked> 3
					<input type="radio" name="Mieliala" value="4"> 4
					<input type="radio" name="Mieliala" value="5"> 5
				  </label><br>
					<input type="date" name="pvm" value="<?php if(isset($_POST["pvm"]))?>"><br> 
				  <div class="clearfix">
					<button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Lopeta</button>
					<button type="submit" class="signupbtn">Tallenna</button>
				  </div>
				</div>
			  </form>
			</div>


			<script>
			// Get the modal
			var modal = document.getElementById('id01');

			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
			  if (event.target == modal) {
				modal.style.display = "none";
			  }
			}
			</script>

    </div>
</body>