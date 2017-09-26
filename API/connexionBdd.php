<?php
	try{
<<<<<<< HEAD
		$bdd = new PDO('pgsql:host=192.168.30.240;dbname=ambigroup_dev', 'admambigroup', '13jkgaUM8Um');
=======
		$bdd = new PDO('pgsql:host=192.168.30.240;dbname=ambigroup_dev','admambigroup','13jkgaUM8Um');
>>>>>>> 96ee55dfac2a0e4bbf0af3a9f97128a2e29358b0
	}
	catch (Exception $e){
		die('Erreur : '.$e->getMessage());
	}
?>
