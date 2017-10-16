<?php 
	// try{
	// 	$bdd = new PDO('pgsql:host=192.168.30.218;dbname=mail_auto', 'CYRRIC', 'cyril');
	// }
	// catch (Exception $e){
	// 	die('Erreur : '.$e->getMessage());
	// }
	// $req = $bdd->query("INSERT INTO save_data (date,ui,globale,client,focu,immo,dissi,coordi) VALUES ('2017-09-25','JR4',20,20,20,20,20,20)");

?>
<?php
// Destinataire
$to = "cyril.ricou@ambitiontelecom.com";
// Sujet
$subject = 'Test de planification de tâche Cron';
 
// Message
$message = '
<html>
  <head>
    <title>Test Cron</title>
  </head>
  <body>
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td align="center">
          <p>
            Ceci est un test qui prouve que Cron fonctionne correctement !
          </p>
          <p>
            Chouette, hein ?
          </p>
        </td>
      </tr>
    </table>
  </body>
</html>
';
 
// Pour envoyer un mail HTML, l en-tête Content-type doit être défini
$headers = "MIME-Version: 1.0" . "\n";
$headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
 
// En-têtes additionnels
$headers .= 'From: Mail de test <no-reply@monsitedetest.com>' . "\r\n";
 
// Envoie
$resultat = mail($to, $subject, $message, $headers);
?>