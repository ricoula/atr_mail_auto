<?php
	try{
		$bdd = new PDO('pgsql:host=192.168.30.240;dbname=ambigroup_prod8', 'admambigroup', '13jkgaUM8Um');
	}
	catch (Exception $e){
		die('Erreur : '.$e->getMessage());
	}
?>
