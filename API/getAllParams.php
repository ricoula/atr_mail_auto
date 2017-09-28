<?php
	require_once("fonctions.php");
	
	if(!isset($_POST["liste_domaines"]) || $_POST["liste_domaines"] == "")
	{
		$_POST["liste_domaines"] = null;
	}
	if(!isset($_POST["liste_sous_domaines"]) || $_POST["liste_sous_domaines"] == "")
	{
		$_POST["liste_sous_domaines"] = null;
	}
	if(!isset($_POST["liste_sous_justifs"]) || $_POST["liste_sous_justifs"] == "")
	{
		$_POST["liste_sous_justifs"] = null;
	}
	if(!isset($_POST["limit"]) || $_POST["limit"] == "")
	{
		$_POST["limit"] = null;
	}
	
	echo getAllParams($_POST["liste_ui"], $_POST["liste_domaines"], $_POST["liste_sous_domaines"], $_POST["liste_sous_justifs"], $_POST["limit"]);
	//echo getAllParams("frq", "grzz", null, null);
?>