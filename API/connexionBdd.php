<?php
	try{
<<<<<<< HEAD
		$bdd = new PDO('pgsql:host=192.168.30.240;dbname=ambigroup_dev', 'admambigroup', '13jkgaUM8Um');
=======
		$bdd = new PDO('pgsql:host=bi.ambition.local;dbname=ambigroup_dev','admambigroup','13jkgaUM8Um');
>>>>>>> 5ce975d3c7ca5512199351ec08b4e5bd1e4d09f9
	}
	catch (Exception $e){
		die('Erreur : '.$e->getMessage());
	}
<<<<<<< HEAD
?>
=======
?>
>>>>>>> 5ce975d3c7ca5512199351ec08b4e5bd1e4d09f9
