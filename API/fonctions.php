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
            $uiName = 'Alpes';
        }
        if($ui == 'QFY')
        {
            $uiName = 'Lyon';
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
            $uiName = 'Alsace Lorraine';
        }
        if($ui == 'TF7')
        {
            $uiName = 'Midi Pyrennees';
        }
        if($ui == 'NGF')
        {
            $uiName = 'Auvergne';
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
							$envoiMail = mail("cyril.ricou@ambitiontelecom.com", $email, $contenuHtml, $headers);
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
	}
	
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
	}
?>
