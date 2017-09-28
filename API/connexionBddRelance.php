<?php
	try{
		$bdd = new PDO('pgsql:host=localhost;dbname=mail_auto', 'postgres', 'postgres');
	}
	catch (Exception $e){
		die('Erreur : '.$e->getMessage());
	}
?>
