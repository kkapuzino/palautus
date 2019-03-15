<?php 
require "./yhteys.php";
function tulosta_lajivalintalista($valittu_laji_id,$yhteys)
{
	$palauta="<select name=\"liikunta\">";
	$sql="SELECT * FROM liikunta";
	$lause =$yhteys->query($sql);
	$vastaus=$lause->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($vastaus as $rivi){
	
		$palauta .="<option value=\"".$rivi["LiikuntaID"]."\">";
		if($valittu_laji_id==$rivi["LiikuntaID"]) $palauta .=" selected";
		$palauta .=$rivi["laji"]."</option>\n\r";
	}
	
	$palauta .="</select>";
	

	return $palauta;
}
$lajiId=NULL;

function tulosta_ruokalista($valittu_ruoka_id,$yhteys)
{
	$palauta="<select name=\"ruokailu\">";
	$sql="SELECT * FROM ruokailu";
	$lause =$yhteys->query($sql);
	$vastaus=$lause->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($vastaus as $rivi){
	
		$palauta .="<option value=\"".$rivi["RuokailuID"]."\">";
		if($valittu_ruoka_id==$rivi["RuokailuID"]) $palauta .=" selected";
		$palauta .=$rivi["ateria"]."</option>\n\r";
	}
	
	$palauta .="</select>";
	

	return $palauta;
}
$ruokaId=NULL;
function tulosta_peligenre($valittu_peli_id,$yhteys)
{
	$palauta="<select name=\"genre\">";
	$sql="SELECT * FROM peli";
	$lause =$yhteys->query($sql);
	$vastaus=$lause->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($vastaus as $rivi){
	
		$palauta .="<option value=\"".$rivi["PeliID"]."\">";
		if($valittu_peli_id==$rivi["PeliID"]) $palauta .=" selected";
		$palauta .=$rivi["genre"]."</option>\n\r";
	}
	
	$palauta .="</select>";
	

	return $palauta;
}
$peliId=NULL;
?>