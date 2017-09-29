<?php
	require_once("fonctions.php");
	echo envoyerMails($_POST["liste"]) //$listePoi = JSON, $listeMails = implode avec ', ' entre chaque valeur;
	
	/*$tabPoi = array();
	array_push($tabPoi, 1);
	array_push($tabPoi, 2);
	$listePoi = json_encode($tabPoi);
	
	$tabMails = array();
	array_push($tabMails, 'florianspadaro@gmail.com');
	array_push($tabMails, 'spadaro.florian@outlook.fr');
	$listeMails = implode(", ", $tabMails);
	echo envoyerMails($listePoi, $listeMails);*/
?>