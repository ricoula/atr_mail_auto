<?php

	function getAll($limit){
		include("connexionBdd.php");
		include("global.php");
		$poi_list = null;
		$i = 0;
		$req = $bdd->prepare($global. " LIMIT ? OFFSET 0");
		$req->execute(array($limit));
			while($data = $req->fetch()){
				$poi_list[$i]['id'] = $data['id'];
				$poi_list[$i]['partner'] = $data['partner'];
				$poi_list[$i]['atr_ui'] = $data['atr_ui'];
				$poi_list[$i]['ft_numero_oeie'] = $data['ft_numero_oeie'];
				if($data['ft_oeie_dre'] != null)
				{
					$poi_list[$i]['ft_oeie_dre'] = date("d/m/Y", strtotime($data['ft_oeie_dre']));
				}
				else{
					$poi_list[$i]['ft_oeie_dre'] = null;
				}
				$poi_list[$i]['domaine'] = $data['domaine'];
				$poi_list[$i]['sous_domaine'] = $data['sous_domaine'];
				$poi_list[$i]['ft_pg'] = $data['ft_pg'];
				$poi_list[$i]['ft_sous_justification_oeie'] = $data['ft_sous_justification_oeie'];
				$poi_list[$i]['ft_libelle_commune'] = $data['ft_libelle_commune'];
				$poi_list[$i]['ft_libelle_de_voie'] = $data['ft_libelle_de_voie'];
				$poi_list[$i]['name_related'] = $data['name_related'];
				$poi_list[$i]['work_email'] = $data['work_email'];
				$poi_list[$i]['mobile_phone'] = $data['mobile_phone'];
				$poi_list[$i]['ft_commentaire_creation_oeie'] = $data['ft_commentaire_creation_oeie'];
				$i++;
			}
			return json_encode($poi_list);
	}

	function getUi()
	{
		include("connexionBdd.php");
		include("global.php");
		$uis = null;
		$i = 0;
		$req = $bdd->query("SELECT DISTINCT atr_ui FROM (".$global.") ui");
		while($data = $req->fetch())
		{
			$uis[$i] = $data["atr_ui"];
			$i++;
		}
		return json_encode($uis);
	}
	
	function getStats($ui)
	{
		include("connexionBddRelance.php");
		//$uis = null;
		// $global = null;
		// $client = null;
		// $immo = null;
		// $focu = null;
		// $dissi = null;
		// $coordi = null;
		$stats = null;
		$i = 0;
		//$req = $bdd->query("SELECT * FROM save_data WHERE ui = '".$ui."' ORDER BY ui,date");
		$req = $bdd->query("SELECT * FROM save_data WHERE date >= now() + interval '-10 day' and ui = '".$ui."' ORDER BY ui,date");
		// SELECT * FROM save_data WHERE date >= now() + interval '-10 day' and ui = '".$ui."' ORDER BY ui,date
		while($data = $req->fetch())
		{
			$stats[$i]["date"] = $data["date"];
			$stats[$i]["ui"] = $data["ui"];
			$stats[$i]["globale"] = $data["globale"];
			$stats[$i]["client"] = $data["client"];
			$stats[$i]["immo"] = $data["immo"];
			$stats[$i]["focu"] = $data["focu"];
			$stats[$i]["dissi"] = $data["dissi"];
			$stats[$i]["coordi"] = $data["coordi"];
			$i++;
		}
		
		
		$listeStatsUi = json_decode(getStatsDomaine());
		$thisUi = null;
		foreach($listeStatsUi as $statsUi)
		{
			if($statsUi->libelle == $ui)
			{
				$stats[$i]["date"] = date("Y-m-d");
				$stats[$i]["ui"] = $ui;
				$stats[$i]["globale"] = $statsUi->statistiques;
				$stats[$i]["client"] = 0;
				$stats[$i]["immo"] = 0;
				$stats[$i]["focu"] = 0;
				$stats[$i]["dissi"] = 0;
				$stats[$i]["coordi"] = 0;
				foreach($statsUi->listeDomaines as $domaine)
				{
					switch($domaine->libelle)
					{
						case "Client": $stats[$i]["client"] = $domaine->statistiques;
						break;
						case "Coordi": $stats[$i]["coordi"] = $domaine->statistiques;
						break;
						case "Dissi": $stats[$i]["dissi"] = $domaine->statistiques;
						break;
						case "FO & CU": $stats[$i]["focu"] = $domaine->statistiques;
						break;
						case "Immo": $stats[$i]["immo"] = $domaine->statistiques;
						break;
					}
				}
			}
			
		}
		
		/*$derniereUi = json_decode(getStatsUiByLibelle($ui));
		
		$stats[$i]["date"] = date("Y-m-d");
		$stats[$i]["ui"] = $ui;
		$stats[$i]["globale"] = $derniereUi->statistique;
		$stats[$i]["client"] = 0;
		$stats[$i]["immo"] = 0;
		$stats[$i]["focu"] = 0;
		$stats[$i]["dissi"] = 0;
		$stats[$i]["coordi"] = 0;
		foreach($derniereUi->listeDomaines as $domaine)
		{
			switch($domaine->libelle)
			{
				case "Client": $stats[$i]["client"] = $domaine->statistiques;
				break;
				case "Coordi": $stats[$i]["coordi"] = $domaine->statistiques;
				break;
				case "Dissi": $stats[$i]["dissi"] = $domaine->statistiques;
				break;
				case "FO & CU": $stats[$i]["focu"] = $domaine->statistiques;
				break;
				case "Immo": $stats[$i]["immo"] = $domaine->statistiques;
				break;
				
			}
		}*/
		
		return json_encode($stats);
	}
	
	function getDomainesByUi($listeUI) //$listeUi au format implode avec des virgules entre (chaque ui doit être entouré de '')
	{
		include("connexionBdd.php");
		include("global.php");
		$domaines = null;
		$i = 0;
		$req = $bdd->query("SELECT DISTINCT domaine FROM (".$global.") tout WHERE atr_ui IN (".$listeUI.") AND domaine IS NOT NULL");
		while($data = $req->fetch())
		{
			$domaines[$i] = $data["domaine"];
			$i++;
		}
		return json_encode($domaines);
	}
	
	function getDomaines()
	{
		include("connexionBdd.php");
		include("global.php");
		$domaines = null;
		$i = 0;
		$req = $bdd->query("SELECT DISTINCT domaine FROM (".$global.") tout WHERE domaine IS NOT NULL");
		while($data = $req->fetch())
		{
			$domaines[$i] = $data["domaine"];
			$i++;
		}
		return json_encode($domaines);
	}
	
	function getSousDomaines()
	{
		include("connexionBdd.php");
		include("global.php");
		$sousDomaines = null;
		$i = 0;
		$req = $bdd->query("SELECT DISTINCT sous_domaine FROM (".$global.") tout WHERE sous_domaine IS NOT NULL");
		while($data = $req->fetch())
		{
			$sousDomaines[$i] = $data["sous_domaine"];
			$i++;
		}
		return json_encode($sousDomaines);
    }
    function getUiNameByUiTag($ui){
        $uiName = $ui;
        if($ui == 'JR4')
        {
            $uiName = 'ALP';
        }
        if($ui == 'QFY')
        {
            $uiName = 'LYO';
        }
        if($ui == 'GYL')
        {
            $uiName = 'RD';
        }
        if($ui == 'LT7')
        {
            $uiName = 'PCA';
        }
        if($ui == 'FC4')
        {
            $uiName = 'BFC';
        }
        if($ui == 'HD4')
        {
            $uiName = 'ALS';
        }
        if($ui == 'TF7')
        {
            $uiName = 'MPY';
        }
        if($ui == 'NGF')
        {
            $uiName = 'AUV';
        }
        return json_encode($uiName);
    }
	function getPg()
	{
		include("connexionBdd.php");
		include("global.php");
		$pg = null;
		$i = 0;
		$req = $bdd->query("SELECT DISTINCT ft_pg FROM (".$global.") tout WHERE ft_pg IS NOT NULL");
		while($data = $req->fetch())
		{
			$pg[$i] = $data["ft_pg"];
			$i++;
		}
		return json_encode($pg);
	}
	
	function getSousJustifs()
	{
		include("connexionBdd.php");
		include("global.php");
		$sousJustifs = null;
		$i = 0;
		$req = $bdd->query("SELECT DISTINCT ft_sous_justification_oeie FROM (".$global.") tout WHERE ft_sous_justification_oeie IS NOT NULL");
		while($data = $req->fetch())
		{
			if(strlen($data["ft_sous_justification_oeie"]) < 3)
			{
				$sousJustifs[$i] = $data["ft_sous_justification_oeie"];
				$i++;
			}
		}
		return json_encode($sousJustifs);
	}
	
	function getSousJustifsByPgBySousDomaineByDomaineByUi($ui, $domaines, $sousDomaines, $pg)
	{
		include("connexionBdd.php");
		include("global.php");
		$sousJustifs = null;
		$i = 0;
		$req = $bdd->prepare("SELECT DISTINCT ft_sous_justification_oeie FROM (".$global.") tout WHERE ft_sous_justification_oeie IS NOT NULL AND atr_ui = ? AND domaine IN(?) AND sous_domaine IN(?) AND ft_pg IN(?)");
		$req->execute(array($ui, $domaines, $sousDomaines, $pg));
		while($data = $req->fetch())
		{
			if(strlen($data["ft_sous_justification_oeie"]) < 3)
			{
				$sousJustifs[$i] = $data["ft_sous_justification_oeie"];
				$i++;
			}
		}
		return json_encode($sousJustifs);
	}
	
	function getUiByDomaine($domaine)
	{
		include("connexionBdd.php");
		include("global.php");
		$ui = null;
		$i = 0;
		$req = $bdd->prepare("SELECT DISTINCT atr_ui FROM (".$global.") test WHERE domaine = ?");
		$req->execute(array($domaine));
		while($data = $req->fetch())
		{
			$ui[$i] = $data["atr_ui"];
			$i++;
		}
		return json_encode($ui);
	}
	
	function getDomainesAndUiBySousDomaine($sousDomaine)
	{
		include("connexionBdd.php");
		include("global.php");
		$tab = array();
		$i = 0;
		$req = $bdd->prepare("SELECT DISTINCT atr_ui FROM (".$global.") test WHERE sous_domaine = ?");
		$req->execute(array($sousDomaine));
		while($data = $req->fetch())
		{
			$tab["ui"][$i] = $data["atr_ui"];
			$i++;
		}
		
		$i = 0;
		$req = $bdd->prepare("SELECT DISTINCT domaine FROM (".$global.") test WHERE sous_domaine = ?");
		$req->execute(array($sousDomaine));
		while($data = $req->fetch())
		{
			$tab["domaine"][$i] = $data["domaine"];
			$i++;
		}
		
		return json_encode($tab);
	}
	
	function getSousDomainesAndDomainesAndUiBySousJustif($sousJustif)
	{
		include("connexionBdd.php");
		include("global.php");
		$tab = array();
		$i = 0;
		$req = $bdd->prepare("SELECT DISTINCT atr_ui FROM (".$global.") test WHERE ft_sous_justification_oeie = ?");
		$req->execute(array($sousJustif));
		while($data = $req->fetch())
		{
			$tab["ui"][$i] = $data["atr_ui"];
			$i++;
		}
		
		$i = 0;
		$req = $bdd->prepare("SELECT DISTINCT domaine FROM (".$global.") test WHERE ft_sous_justification_oeie = ?");
		$req->execute(array($sousJustif));
		while($data = $req->fetch())
		{
			$tab["domaine"][$i] = $data["domaine"];
			$i++;
		}
		
		$i = 0;
		$req = $bdd->prepare("SELECT DISTINCT sous_domaine FROM (".$global.") test WHERE ft_sous_justification_oeie = ?");
		$req->execute(array($sousJustif));
		while($data = $req->fetch())
		{
			$tab["sous_domaine"][$i] = $data["sous_domaine"];
			$i++;
		}
		
		return json_encode($tab);
	}
	
	function getArbo()
	{
		include("connexionBdd.php");
		include("global.php");
		$arbo = null;
		$i = 0;
		$req = $bdd->query("select atr_ui,domaine,sous_domaine,ft_sous_justification_oeie from(".$global.")atre
		group by atr_ui,domaine,sous_domaine,ft_sous_justification_oeie
		order by atr_ui,domaine,sous_domaine,ft_sous_justification_oeie");
		while($data = $req->fetch())
		{
			if(strlen($data["ft_sous_justification_oeie"]) < 3)
			{
				$data["atr_ui"] = str_replace(" ", "_", $data["atr_ui"]);
				$data["domaine"] = str_replace(" ", "_", $data["domaine"]);
				$data["sous_domaine"] = str_replace(" ", "_", $data["sous_domaine"]);
				$data["ft_sous_justification_oeie"] = str_replace(" ", "_", $data["ft_sous_justification_oeie"]);
				$data["atr_ui"] = str_replace("&", "_", $data["atr_ui"]);
				$data["domaine"] = str_replace("&", "_", $data["domaine"]);
				$data["sous_domaine"] = str_replace("&", "_", $data["sous_domaine"]);
				$data["ft_sous_justification_oeie"] = str_replace("&", "_", $data["ft_sous_justification_oeie"]);
				$arbo[$i]["sous_justification"] = $data["ft_sous_justification_oeie"];
				$arbo[$i]["sous_domaine"] = $data["sous_domaine"];
				$arbo[$i]["domaine"] = $data["domaine"];
				$arbo[$i]["ui"] = $data["atr_ui"];
				$i++;
			}
		}
		return json_encode($arbo);
	}
	
	function getAllParams($listeUi, $listeDomaines, $listeSousDomaines, $listeSousJustifs, $limit)
	{
		include("connexionBdd.php");
		include("global.php");
		$poi_list = null;
		$i = 0;
		if($listeUi == null)
		{
			$listeDomaines = null;
		}
		
		if($listeDomaines == null)
		{
			$listeSousDomaines = null;
		}
		
		if($listeSousDomaines == null)
		{
			$listeSousJustifs = null;
		}
		
		$where = 'WHERE atr_ui IN('.$listeUi.')';
		if($listeDomaines != null)
		{
			$where = $where.' AND domaine IN('.$listeDomaines.')';
		}
		if($listeSousDomaines != null)
		{
			$where = $where.' AND sous_domaine IN('.$listeSousDomaines.')';
		}
		if($listeSousJustifs != null)
		{
			$where = $where.' AND ft_sous_justification_oeie IN('.$listeSousJustifs.')';
		}
		if($limit != null)
		{
			$req = $bdd->prepare("SELECT * FROM (".$global.") test ".$where." LIMIT ? OFFSET 0");
			$req->execute(array($limit));
		}
		else{
			$req = $bdd->query("SELECT * FROM (".$global.") test ".$where);
		}
		while($data = $req->fetch())
		{
			$poi_list[$i]['id'] = $data['id'];
			$poi_list[$i]['atr_ui'] = $data['atr_ui'];
			$poi_list[$i]['partner'] = $data['partner'];
			$poi_list[$i]['ft_numero_oeie'] = $data['ft_numero_oeie'];
			
			if($data['ft_oeie_dre'] != null)
			{
				$poi_list[$i]['ft_oeie_dre'] = date("d/m/Y", strtotime($data['ft_oeie_dre']));
			}
			else{
					$poi_list[$i]['ft_oeie_dre'] = null;
				}
			
			
			$poi_list[$i]['domaine'] = $data['domaine'];
			$poi_list[$i]['sous_domaine'] = $data['sous_domaine'];
			$poi_list[$i]['ft_pg'] = $data['ft_pg'];
			$poi_list[$i]['ft_sous_justification_oeie'] = $data['ft_sous_justification_oeie'];
			$poi_list[$i]['ft_libelle_commune'] = $data['ft_libelle_commune'];
			$poi_list[$i]['ft_libelle_de_voie'] = $data['ft_libelle_de_voie'];
			$poi_list[$i]['name_related'] = $data['name_related'];
			$poi_list[$i]['work_email'] = $data['work_email'];
			$poi_list[$i]['mobile_phone'] = $data['mobile_phone'];
			$poi_list[$i]['ft_commentaire_creation_oeie'] = $data['ft_commentaire_creation_oeie'];
			$i++;
		}
		return json_encode($poi_list);
	}
	
	function envoyerMails($liste)
	{
		include("connexionBddRelance.php");
		
		try{
			$reponse = false;
			if($liste != null)
			{
				$liste = json_decode($liste);
				$listePoi = array();
				$contenuHtml = "";
				if($liste != null)
				{
					foreach($liste as $caff)
					{
						if($caff->listePois != null)
						{
							foreach($caff->listePois as $poi)
							{
							array_push($listePoi, $poi->id);
							}
						}
					}
				}
				foreach($listePoi as $poi)
				{
					$idPoi = null;
					
					$req = $bdd->prepare("SELECT id FROM relance WHERE poi = ?");
					$req->execute(array($poi));
					if(!$data = $req->fetch())
					{
						$req2 = $bdd->prepare("INSERT INTO relance(poi) VALUES(?) RETURNING id");
						$req2->execute(array($poi));
						if($data2 = $req2->fetch())
						{
							$idPoi = $data2["id"];
						}
					}
					else{
						$idPoi = $data["id"];
					}
					if($idPoi != null)
					{
						$req = $bdd->prepare("UPDATE relance SET nb_relances = nb_relances + 1, date_derniere_relance = NOW() WHERE id = ?");
						$reponse = $req->execute(array($idPoi));
					}
				}
				
				
				
				if($reponse)
				{
					
					$headers = "";
					//$headers .= "From: " . strip_tags($_POST['req-email']) . "\r\n";
					//$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
					//$headers .= "CC: susan@example.com\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=utf-8\r\n";
					$headers .= "From: \"Centre De Services\"<root@ambitiontelecom.com>";
					
					if($liste != null)
					{
						foreach($liste as $caff)
						{
							$contenuHtml = "";
							//$contenuHtml = $contenuHtml."<!DOCTYPE html><html><head><meta charset='utf-8' /><style>table{ border: 3px solid black; border-collapse: collapse; } th, td{ border: 1px solid black; }</style></head><body><table><thead><tr><th>UI</th><th>POI</th><th>DRE</th><th>Domaine</th><th>Sous-Domaine</th><th>Pg</th><th>Sous-Justif</th><th>Commune</th><th>Voie</th><th>Commentaire</th></tr></thead><tbody>";
							$contenuHtml = $contenuHtml."<!DOCTYPE html><html><head><meta charset='utf-8' /><style>.datagrid table { border-collapse: collapse; text-align: left; width: 100%; } .datagrid {font: normal 12px/150% Arial, Helvetica, sans-serif; background: #fff; overflow: hidden; border: 1px solid #006699; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; }.datagrid table td, .datagrid table th { padding: 3px 10px; }.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #006699), color-stop(1, #00557F) );background:-moz-linear-gradient( center top, #006699 5%, #00557F 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699', endColorstr='#00557F');background-color:#006699; color:#ffffff; font-size: 15px; font-weight: bold; border-left: 1px solid #0070A8; } .datagrid table thead th:first-child { border: none; }.datagrid table tbody td { color: #00557F; border-left: 1px solid #E1EEF4;font-size: 12px;border-bottom: 1px solid #E1EEF4;font-weight: normal; }.datagrid table tbody .alt td { background: #E1EEf4; color: #00557F; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }.datagrid table tfoot td div { border-top: 1px solid #006699;background: #E1EEf4;} .datagrid table tfoot td { padding: 0; font-size: 12px } .datagrid table tfoot td div{ padding: 2px; }.datagrid table tfoot td ul { margin: 0; padding:0; list-style: none; text-align: right; }.datagrid table tfoot  li { display: inline; }.datagrid table tfoot li a { text-decoration: none; display: inline-block;  padding: 2px 8px; margin: 1px;color: #FFFFFF;border: 1px solid #006699;-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #006699), color-stop(1, #00557F) );background:-moz-linear-gradient( center top, #006699 5%, #00557F 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699', endColorstr='#00557F');background-color:#006699; }.datagrid table tfoot ul.active, .datagrid table tfoot ul a:hover { text-decoration: none;border-color: #00557F; color: #FFFFFF; background: none; background-color:#006699;}div.dhtmlx_window_active, div.dhx_modal_cover_dv { position: fixed !important; }</style></head><body>Bonjour,<br/><br/>Ci-dessous la liste des POI à actualiser via un commentaire GDP,<br/><br/><div class='datagrid'><table><thead><tr><th>UI</th><th>POI</th><th>DRE</th><th>Domaine</th><th>Sous-Domaine</th><th>Pg</th><th>Sous-Justif</th><th>Commune</th><th>Voie</th><th>Commentaire</th></tr></thead><tbody>";
							
							if($caff->listePois != null)
							{
								foreach($caff->listePois as $poi)
								{
									$contenuHtml = $contenuHtml."<tr><td>".$poi->atr_ui ."</td><td>".$poi->ft_numero_oeie ."</td><td>".$poi->ft_oeie_dre ."</td><td>".$poi->domaine ."</td><td>".$poi->sous_domaine ."</td><td>".$poi->ft_pg ."</td><td>".$poi->ft_sous_justification_oeie ."</td><td>".$poi->ft_libelle_commune ."</td><td>".$poi->ft_libelle_de_voie ."</td><td>".$poi->ft_commentaire_creation_oeie ."</td></tr>";
								}
							}
							$contenuHtml = $contenuHtml."</tbody></table></div><br/>Merci d’avance<br/><br/>Le CDS</body></html><br/><br/>";
							$email = $caff->email;
							//$email = "marc.lapouge@ambitiontelecom.com";
							$objet = "MaJ COMLAB";
							//$objet = "Mail de test NE PAS EN TENIR COMPTE";
							$envoiMail = mail("cds-relance@ambitiontelecom.com,".$email, $objet, $contenuHtml, $headers);
						}
					}
				}
				
			}
		}
		catch(Exception $e){
			$reponse = false;
		}
		return json_encode($reponse);
	}
	
	function getListePoiRelances($toutesPoi)
	{
		include("connexionBddRelance.php");
		
		$listePoi = null;
		$i = 0;
		$req = $bdd->query("SELECT * FROM relance WHERE poi IN(".$toutesPoi.")");
		while($data = $req->fetch())
		{
			$listePoi[$i]["id"] = $data["id"];
			$listePoi[$i]["poi"] = $data["poi"];
			$listePoi[$i]["nb_relances"] = $data["nb_relances"];
			$listePoi[$i]["alerte"] = $data["alerte"];
			if($data["date_derniere_relance"] != null)
				{
					$listePoi[$i]["date_derniere_relance"] = date("d/m/Y", strtotime($data["date_derniere_relance"]));
				}
				else{
					$listePoi[$i]["date_derniere_relance"] = null;
				}
				
				if($data["date_expiration"] != null)
				{
					$listePoi[$i]["date_expiration"] = date("d/m/Y", strtotime($data["date_expiration"]));
				}
				else{
					$listePoi[$i]["date_expiration"] = null;
				}
			$i++;
		}
		return json_encode($listePoi);
	}
	
	function modifierDate($date) //retourne JJ-MM-AAAA
	{
		$jour = substr($date, 8, 2);
		$mois = substr($date, 5, 2);
		$annee = substr($date, 0, 4);
		$date = $jour."/".$mois."/".$annee;
		return json_encode($date);
	}
	
	function validerPoi($idPoi)
	{
		include("connexionBddRelance.php");
		
		$poi = null;
		
		$req = $bdd->prepare("SELECT date_expiration FROM relance WHERE poi = ?");
		$req->execute(array($idPoi));
		if(!$data = $req->fetch())
		{
			$req2 = $bdd->prepare("INSERT INTO relance(poi, date_expiration) VALUES(?, NOW())");
			$req2->execute(array($idPoi));
		}
		else{
			if($data["date_expiration"] == null)
			{
				$req2 = $bdd->prepare("UPDATE relance SET date_expiration = NOW() WHERE poi = ?");
				$req2->execute(array($idPoi));
			}
		}
		
		$req = $bdd->prepare("UPDATE relance SET date_expiration = date_expiration + integer '15', nb_relances = 0 WHERE poi = ?");
		$reponse = $req->execute(array($idPoi));
		if($reponse)
		{
			$req2 = $bdd->prepare("SELECT * FROM relance WHERE poi = ?");
			$req2->execute(array($idPoi));
			if($data2 = $req2->fetch())
			{
				$poi["id"] = $data2["id"];
				$poi["poi"] = $data2["poi"];
				$poi["nb_relances"] = $data2["nb_relances"];
				if($data2["date_derniere_relance"] != null)
				{
					$poi["date_derniere_relance"] = date("d/m/Y", strtotime($data2["date_derniere_relance"]));
				}
				else{
					$poi["date_derniere_relance"] = null;
				}
				
				if($data2["date_expiration"] != null)
				{
					$poi["date_expiration"] = date("d/m/Y", strtotime($data2["date_expiration"]));
				}
				else{
					$poi["date_expiration"] = null;
				}
			}
		}
		return json_encode($poi);
	}
	
	function getPoiRelanceById($idPoi)
	{
		include("connexionBddRelance.php");
		
		$poi = null;
		
		$req = $bdd->prepare("SELECT * FROM relance WHERE poi = ?");
		$req->execute(array($idPoi));
		if($data = $req->fetch())
		{
			$poi["id"] = $data["id"];
			$poi["poi"] = $data["poi"];
			$poi["nb_relances"] = $data["nb_relances"];
			if($data["date_derniere_relance"] != null)
			{
				$poi["date_derniere_relance"] = date("d/m/Y", strtotime($data["date_derniere_relance"]));
			}
			else{
				$poi["date_derniere_relance"] = null;
			}
			
			if($data["date_expiration"] != null)
			{
				$poi["date_expiration"] = date("d/m/Y", strtotime($data["date_expiration"]));
			}
			else{
				$poi["date_expiration"] = null;
			}
		}
		return json_encode($poi);
	}
	
	function getStatsUi()
	{
		include("connexionBdd.php");
		$bddErp = $bdd;
		$bdd = null;
		unset($bdd);
		include("connexionBddRelance.php");
		$maBdd = $bdd;
		include("global.php");
		
		$listePoiBleues = array();
		$req = $maBdd->query("select poi from relance where date_expiration >= NOW()");
		while($data = $req->fetch())
		{
			array_push($listePoiBleues, $data["poi"]);
		}
		
		$listePoiBleues = implode(", ", $listePoiBleues);
		
		$listeUi = array();
		if($listePoiBleues != null && $listePoiBleues != "")
		{
			$req = $bddErp->query("select atr_ui,count(dre_ko) as dre_ko,count(dre_ok) as dre_ok from(select atr_ui,ft_oeie_dre,case when (ft_oeie_dre IS NULL OR ft_oeie_dre <= NOW()) and id not in (".$listePoiBleues.") then 1 end as dre_ko,case when ft_oeie_dre > NOW() or id in (".$listePoiBleues.") then 1 end as dre_ok from (".$global.")dre)dre2 group by atr_ui");
			while($data = $req->fetch())
			{
				$ui = (object) array();
				$ui->libelle = $data["atr_ui"];
				$ui->statistique = round((1-($data["dre_ko"]/($data["dre_ko"] + $data["dre_ok"])))*100, 1);
				array_push($listeUi, $ui);
			}
		}
		else{
			$req = $bddErp->query("select atr_ui,count(dre_ko) as dre_ko,count(dre_ok) as dre_ok from(select atr_ui,ft_oeie_dre,case when (ft_oeie_dre IS NULL OR ft_oeie_dre <= NOW()) then 1 end as dre_ko,case when ft_oeie_dre > NOW() then 1 end as dre_ok from (".$global.")dre)dre2 group by atr_ui");
			while($data = $req->fetch())
			{
				$ui = (object) array();
				$ui->libelle = $data["atr_ui"];
				$ui->statistique = round((1-($data["dre_ko"]/($data["dre_ko"] + $data["dre_ok"])))*100, 1);
				array_push($listeUi, $ui);
			}
		}
		
		return json_encode($listeUi);
	}
	
	/*function getStatsUi()
	{
		include("connexionBdd.php");
		$bddErp = $bdd;
		$bdd = null;
		unset($bdd);
		include("connexionBddRelance.php");
		$maBdd = $bdd;
		include("global.php");
		
		$listeUI = array();
		$i = 0;
		$req = $bddErp->query("SELECT DISTINCT atr_ui FROM (".$global.") atr ");
		while($data = $req->fetch())
		{
			$ui = (object) array();
			$ui->libelle = $data["atr_ui"];
			array_push($listeUI, $ui);
		}
		
		foreach($listeUI as $ui)
		{
			$listePoi = array();
			
			$req = $bddErp->prepare("SELECT id, ft_oeie_dre FROM (".$global.") atr WHERE atr_ui = ?");
			$req->execute(array($ui->libelle));
			while($data = $req->fetch())
			{
				$poi = (object) array();
				
				$poi->id = $data["id"];
				$poi->dre = strtotime($data["ft_oeie_dre"]);

				$req2 = $maBdd->prepare("SELECT nb_relances, date_expiration FROM relance WHERE poi = ?");
				$req2->execute(array($poi->id));
				if($data2 = $req2->fetch())
				{
					$poi->nbRelances = $data2["nb_relances"];
					$poi->dateExpiration = strtotime($data2["date_expiration"]);
				}
				else{
					$poi->nbRelances = 0;
					$poi->dateExpiration = 0;
				}
				
				array_push($listePoi, $poi);
			}
			
			$ui->listePoi = $listePoi;
		}
		
		$dateAjd = time();
		foreach($listeUI as $ui)
		{
			$nbEnCours = 0;
			$nbAttOrange = 0;
			$nbAttAtr = 0;
			$nbRetard = 0;
			foreach($ui->listePoi as $poi)
			{
				if($poi->dre > $dateAjd)
				{
					$poi->categorie = "en_cours";
					$nbEnCours++;
				}
				elseif($poi->dateExpiration > $dateAjd)
				{
					$poi->categorie = "att_orange";
					$nbAttOrange++;
				}
				elseif($poi->nbRelances > 0)
				{
					$poi->categorie = "att_atr";
					$nbAttAtr++;
				}
				else{
					$poi->categorie = "retard";
					$nbRetard++;
				}
			}
			$ui->statistique = round((1-(($nbRetard + $nbAttAtr) / sizeof($ui->listePoi))) * 100, 1);
		}
		
		return json_encode($listeUI);
	}*/
	
	function getStatsDomaine()
	{
		include("connexionBdd.php");
		$bddErp = $bdd;
		$bdd = null;
		unset($bdd);
		include("connexionBddRelance.php");
		$maBdd = $bdd;
		$bdd = null;
		unset($bdd);
		include("global.php");		
		
		$listeStatsUi = json_decode(getStatsUi());
		
		$listePoiBleues = array();
		$req = $maBdd->query("select poi from relance where date_expiration >= NOW()");
		while($data = $req->fetch())
		{
			array_push($listePoiBleues, $data["poi"]);
		}
	
		$listePoiBleues = implode(", ", $listePoiBleues);
		
		$listeUi = array();
		if($listePoiBleues != null && $listePoiBleues != "")
		{
			$req = $bddErp->query("select atr_ui,domaine,case when sum(dre_ko) is null then 0 else sum(dre_ko) end as dre_ko,case when sum(dre_ok) is null then 0 else sum(dre_ok) end as dre_ok from(select atr_ui,domaine,ft_oeie_dre,case when (ft_oeie_dre is null or ft_oeie_dre <= NOW()) and id not in (".$listePoiBleues.") then 1 end as dre_ko,case when ft_oeie_dre > NOW() or id in (".$listePoiBleues.") then 1 end as dre_ok from (".$global.")dre)dre2 where domaine is not null group by atr_ui,domaine order by atr_ui,domaine");
		}
		else{
			$req = $bddErp->query("select atr_ui,domaine,case when sum(dre_ko) is null then 0 else sum(dre_ko) end as dre_ko,case when sum(dre_ok) is null then 0 else sum(dre_ok) end as dre_ok from(select atr_ui,domaine,ft_oeie_dre,case when (ft_oeie_dre is null or ft_oeie_dre <= NOW()) then 1 end as dre_ko,case when ft_oeie_dre > NOW() then 1 end as dre_ok from (".$global.")dre)dre2 where domaine is not null group by atr_ui,domaine order by atr_ui,domaine");
		}
		while($data = $req->fetch())
		{
			$uiExistante = false;
			foreach($listeUi as $ui)
			{
				if($ui->libelle == $data["atr_ui"])
				{
					$uiExistante = true;
				}
			}
			if(!$uiExistante)
			{
				$ui = (object) array();
				$ui->libelle = $data["atr_ui"];
				$ui->listeDomaines = array();
				$ui->statistiques = null;
				
				foreach($listeStatsUi as $statUi)
				{
					if($statUi->libelle == $ui->libelle)
					{
						$ui->statistiques = $statUi->statistique;
					}
				}
				
				$domaine = (object) array();
				$domaine->libelle = $data["domaine"];
				$domaine->statistiques = round((1-($data["dre_ko"]/($data["dre_ko"] + $data["dre_ok"])))*100, 1);
				array_push($ui->listeDomaines, $domaine);
				
				array_push($listeUi, $ui);
			}
			else{
				foreach($listeUi as $ui)
				{
					if($ui->libelle == $data["atr_ui"])
					{
						$domaine = (object) array();
						$domaine->libelle = $data["domaine"];
						$domaine->statistiques = round((1-($data["dre_ko"]/($data["dre_ko"] + $data["dre_ok"])))*100, 1);
						array_push($ui->listeDomaines, $domaine);
					}
				}
			}
		}
		
		return json_encode($listeUi);
	}
	
	/*function getStatsDomaine()
	{
		include("connexionBdd.php");
		$bddErp = $bdd;
		$bdd = null;
		unset($bdd);
		include("connexionBddRelance.php");
		$maBdd = $bdd;
		$bdd = null;
		unset($bdd);
		include("global.php");
		
		$listeDomaines = array();
		$req = $bddErp->query("SELECT DISTINCT domaine FROM (".$global.") atr WHERE domaine IS NOT NULL");
		while($data = $req->fetch())
		{
			$domaine = (object) array();
			$domaine->libelle = $data["domaine"];
			
			array_push($listeDomaines, $domaine);
		}
		
		foreach($listeDomaines as $domaine)
		{
			$listeUI = array();
			$req = $bddErp->prepare("SELECT DISTINCT atr_ui FROM (".$global.") atr WHERE domaine = ?");
			$req->execute(array($domaine->libelle));
			while($data = $req->fetch())
			{
				$ui = (object) array();
				$ui->libelle = $data["atr_ui"];
				
				array_push($listeUI, $ui);
			}
			$domaine->listeUi = $listeUI;
		}
		
		foreach($listeDomaines as $domaine)
		{
			foreach($domaine->listeUi as $ui)
			{
				$listePoi = array();
				
				$req = $bddErp->prepare("SELECT id, ft_oeie_dre FROM (".$global.") atr WHERE atr_ui = ? AND domaine = ?");
				$req->execute(array($ui->libelle, $domaine->libelle));
				while($data = $req->fetch())
				{
					$poi = (object) array();
					$poi->id = $data["id"];
					$poi->dre = strtotime($data["ft_oeie_dre"]);
					
					$req2 = $maBdd->prepare("SELECT nb_relances, date_expiration FROM relance WHERE poi = ?");
					$req2->execute(array($poi->id));
					if($data2 = $req2->fetch())
					{
						$poi->nbRelances = $data2["nb_relances"];
						$poi->dateExpiration = $data2["date_expiration"];
					}
					else{
						$poi->nbRelances = 0;
						$poi->dateExpiration = 0;
					}
					
					array_push($listePoi, $poi);
				}
				
				$ui->listePoi = $listePoi;
			}
		}
		
		$dateAjd = time();
		foreach($listeDomaines as $domaine)
		{
			foreach($domaine->listeUi as $ui)
			{
				$nbEnCours = 0;
				$nbAttAtr = 0;
				$nbAttOrange = 0;
				$nbRetard = 0;
				foreach($ui->listePoi as $poi)
				{
					if($poi->dre > $dateAjd)
					{
						$poi->categorie = "en_cours";
						$nbEnCours++;
					}
					elseif($poi->dateExpiration > $dateAjd)
					{
						$poi->categorie = "att_orange";
						$nbAttOrange++;
					}
					elseif($poi->nbRelances > 0)
					{
						$poi->categorie = "att_atr";
						$nbAttAtr++;
					}
					else{
						$poi->categorie = "retard";
						$nbRetard++;
					}
				}
				
				$ui->statistique = round((1-(($nbRetard + $nbAttAtr) / sizeof($ui->listePoi))) * 100, 1);
			}
		}
		
		return json_encode($listeDomaines);
	}*/
	
	function ajouterAlerte($poi)
	{
		include("connexionBddRelance.php");
		
		$reponse = false;
		
		try{
			$req = $bdd->prepare("SELECT id FROM relance WHERE poi = ?");
			$req->execute(array($poi));
			if(!$data = $req->fetch())
			{
				$req2 = $bdd->prepare("INSERT INTO relance(poi) VALUES(?)");
				$req2->execute(array($poi));
			}
			
			$req = $bdd->prepare("UPDATE relance SET alerte = TRUE WHERE poi = ?");
			$reponse = $req->execute(array($poi));
		}
		catch(Exception $e){
			$reponse = false;
		}
		return json_encode($reponse);
	}
	
	function removeAlerte($poi)
	{
		include("connexionBddRelance.php");
		
		$reponse = false;
		
		try{
			$req = $bdd->prepare("UPDATE relance SET alerte = FALSE WHERE poi = ?");
			$reponse = $req->execute(array($poi));
		}
		catch(Exception $e){
			$reponse = false;
		}
		return json_encode($reponse);
	}
	
	function getAlertesUi($listeUi)
	{
		include("connexionBdd.php");
		$bddErp = $bdd;
		$bdd = null;
		unset($bdd);
		include("connexionBddRelance.php");
		$maBdd = $bdd;
		$bdd = null;
		unset($bdd);
		include("global.php");
		
		$poi_list = null;
		$i = 0;
		
		$listePoiAlerteRelance = array();
		$req = $maBdd->query("SELECT poi FROM relance WHERE alerte = TRUE");
		while($data = $req->fetch())
		{
			array_push($listePoiAlerteRelance, $data["poi"]);
		}
		$listePoiAlerteRelance = implode(", ", $listePoiAlerteRelance);
		
		$req = $bddErp->query("SELECT * FROM (".$global.") poi WHERE atr_ui IN(".$listeUi.") AND id IN(".$listePoiAlerteRelance.")");
		while($data = $req->fetch())
		{
			$poi_list[$i]['id'] = $data['id'];
			$poi_list[$i]['atr_ui'] = $data['atr_ui'];
			$poi_list[$i]['ft_numero_oeie'] = $data['ft_numero_oeie'];
			
			if($data['ft_oeie_dre'] != null)
			{
				$poi_list[$i]['ft_oeie_dre'] = date("d/m/Y", strtotime($data['ft_oeie_dre']));
			}
			else{
					$poi_list[$i]['ft_oeie_dre'] = null;
				}
			
			
			$poi_list[$i]['domaine'] = $data['domaine'];
			$poi_list[$i]['sous_domaine'] = $data['sous_domaine'];
			$poi_list[$i]['ft_pg'] = $data['ft_pg'];
			$poi_list[$i]['ft_sous_justification_oeie'] = $data['ft_sous_justification_oeie'];
			$poi_list[$i]['ft_libelle_commune'] = $data['ft_libelle_commune'];
			$poi_list[$i]['ft_libelle_de_voie'] = $data['ft_libelle_de_voie'];
			$poi_list[$i]['name_related'] = $data['name_related'];
			$poi_list[$i]['work_email'] = $data['work_email'];
			$poi_list[$i]['mobile_phone'] = $data['mobile_phone'];
			$poi_list[$i]['ft_commentaire_creation_oeie'] = $data['ft_commentaire_creation_oeie'];
			$i++;
		}
		return json_encode($poi_list);
	}

	function getInfosCaff()
	{
		include("connexionBdd.php");
		
		$listeCaff = array();
		
		$req = $bdd->query("select id, t3.ag_coeff_traitement, t3.name_related, t3.mobile_phone, t3.work_email, t3.site, t3.agence,case when t3.reactive is null then 0 else t3.reactive end,
		case when t3.non_reactive is null then 0 else t3.non_reactive end from
		(
		select t2.ag_coeff_traitement, t2.id, t2.name_related, t2.mobile_phone, t2.work_email, t2.site, t2.name as agence, sum(t2.reactive) as reactive, sum(t2.non_reactive) as non_reactive from (
		 
		select t1.ag_coeff_traitement, t1.id, t1.name_related,t1.mobile_phone,t1.work_email,t1.site,t1.name, case when account_analytic_account.name in ('Client', 'FO & CU') then count (ag_poi.id)
		end as reactive , case when account_analytic_account.name not in ('Client', 'FO & CU') then count (ag_poi.id) end as non_reactive
		from ag_poi
		left join account_analytic_account on ag_poi.atr_domaine_id = account_analytic_account.id  
		full join
		(select hr_employee.ag_coeff_traitement, hr_employee.id, hr_employee.name_related,hr_employee.mobile_phone,hr_employee.work_email,ag_site.name as site,ag_agence.name from res_users
		full join hr_employee on res_users.ag_employee_id = hr_employee.id
		full join ag_site on hr_employee.ag_site_id = ag_site.id
		full join ag_agence on hr_employee.ag_agence_id = ag_agence.id
		full join hr_job on hr_employee.job_id = hr_job.id
		where res_users.active = true and hr_job.name in ('CAFF FT','CAFF MIXTE')) t1 on ag_poi.atr_caff_traitant_id = t1.id and ft_etat in ('1','5') and ag_poi.ft_numero_oeie not like '%MBB%'
		group by t1.id, t1.name_related,t1.mobile_phone,t1.work_email,t1.site,t1.name, account_analytic_account.name, t1.ag_coeff_traitement) t2
		group by t2.id, t2.name_related, t2.mobile_phone, t2.work_email, t2.site, t2.name, t2.ag_coeff_traitement ) t3
		where name_related is not null ORDER BY name_related");
		while($data = $req->fetch())
		{
			$caff = (object) array();
			$caff->id = $data["id"];
			$caff->ag_coeff_traitement = $data["ag_coeff_traitement"];
			$caff->name_related = $data["name_related"];
			$caff->mobile_phone = $data["mobile_phone"];
			$caff->work_email = $data["work_email"];
			$caff->site = $data["site"];
			$caff->agence = $data["agence"];
			$caff->reactive = $data["reactive"];
			$caff->non_reactive = $data["non_reactive"];
			
			array_push($listeCaff, $caff);
		}
		
		return json_encode($listeCaff);
	}
?>
