<?php
	include("../API/fonctions.php");
	include("../API/connexionBddRelance.php");
	
	$listeStatsUi = json_decode(getStatsDomaine());
	foreach($listeStatsUi as $statsUi)
	{
		$client = 0;
		$focu = 0;
		$immo = 0;
		$dissi = 0;
		$coordi = 0;
		foreach($statsUi->listeDomaines as $statsDom)
		{
			if($statsDom->libelle == "Client")
			{
				$client = $statsDom->statistiques;
			}
			if($statsDom->libelle == "FO & CU")
			{
				$focu = $statsDom->statistiques;
			}
			if($statsDom->libelle == "Immo")
			{
				$immo = $statsDom->statistiques;
			}
			if($statsDom->libelle == "Dissi")
			{
				$dissi = $statsDom->statistiques;
			}
			if($statsDom->libelle == "Coordi")
			{
				$coordi = $statsDom->statistiques;
			}
			
		}
		//echo $statsUi->libelle.' - '.$statsUi->statistiques.' - '.$client.' - '.$focu.' - '.$immo.' - '.$dissi.' - '.$coordi.'<br/>';
		$req = $bdd->prepare("INSERT INTO save_data(date, ui, globale, client, focu, immo, dissi, coordi) VALUES(NOW(), ?, ?, ?, ?, ?, ?, ?)");
		$req->execute(array($statsUi->libelle, $statsUi->statistiques, $client, $focu, $immo, $dissi, $coordi));
	}
?>