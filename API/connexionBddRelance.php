<?php
	try{
		$bdd = new PDO('pgsql:host=192.168.30.242;dbname=mail_auto', 'CYRRIC', 'cyril');
	}
	catch (Exception $e){
		die('Erreur : '.$e->getMessage());
	}
?>
