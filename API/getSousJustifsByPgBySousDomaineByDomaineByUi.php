<?php
	require_once("fonctions.php");
	echo getSousJustifsByPgBySousDomaineByDomaineByUi($_POST["ui"], $_POST["domaines"], $_POST["sous_domaines"], $_POST["pg"]);
?>