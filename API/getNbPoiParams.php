<?php
	require_once("fonctions.php");
	echo getNbPoiParams($_POST["liste_ui"], $_POST["liste_domaines"], $_POST["liste_sous_domaines"], $_POST["liste_sous_justifs"]);
	//echo getNbPoiParams("'QFY'", null, null, null);
?>