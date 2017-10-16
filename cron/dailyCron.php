<?php

	try{
		$bdd = new PDO('pgsql:host=192.168.30.218;dbname=mail_auto', 'CYRRIC', 'cyril');
	}
	catch (Exception $e){
		die('Erreur : '.$e->getMessage());
	}
	try{
		$bddErp = new PDO('pgsql:host=192.168.30.240;dbname=ambigroup_dev', 'admambigroup', '13jkgaUM8Um');
	}
	catch (Exception $e){
		die('Erreur : '.$e->getMessage());
	}

	function getStatsDomaine()
	{
		$global = "select atr.atr_sous_domaine_id,atr.id,atr.atr_ui,atr.ft_numero_oeie,atr.ft_oeie_dre,atr.name as domaine,account_analytic_account.name as sous_domaine,atr.ft_pg, CASE WHEN LENGTH(ft_sous_justification_oeie) = 2 THEN ft_sous_justification_oeie ELSE 'Pas de SJ' END AS ft_sous_justification_oeie, atr.ft_libelle_commune,atr.ft_libelle_de_voie,atr.name_related,atr.work_email,atr.mobile_phone,atr.ft_commentaire_creation_oeie from(
			select ag_poi.atr_sous_domaine_id,ag_poi.id,ag_poi.atr_ui,ag_poi.ft_oeie_dre,ag_poi.ft_numero_oeie,account_analytic_account.name,ag_poi.ft_pg,ag_poi.ft_sous_justification_oeie,ag_poi.ft_libelle_commune,ag_poi.ft_libelle_de_voie,hr_employee.name_related,hr_employee.work_email,hr_employee.mobile_phone,ag_poi.ft_commentaire_creation_oeie from ag_poi
			left join account_analytic_account on ag_poi.atr_domaine_id = account_analytic_account.id
			left join hr_employee on ag_poi.atr_caff_traitant_id = hr_employee.id
			where ft_etat = '1' and name_related is not null and work_email is not null and ag_poi.ft_numero_oeie not like '%MBB%')atr
			left join account_analytic_account on atr.atr_sous_domaine_id = account_analytic_account.id
			order by ft_oeie_dre";
			
		$listeStatsUi = json_decode(getStatsUi());
		
		$listePoiBleues = array();
		$req = $bdd->query("select poi from relance where date_expiration >= NOW()");
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
	$listeStatsUi = json_decode(getStatsDomaine());
	foreach($listeStatsUi as $statsUi)
	{
		$client = 0;
		$focu = 0;
		$immo = 0;
		$dissi = 0;
		$coordi = 0;
		foreach($statsUi->listeDomaines as $statsDom)
		{
			if($statsDom->libelle == "Client")
			{
				$client = $statsDom->statistiques;
			}
			if($statsDom->libelle == "FO & CU")
			{
				$focu = $statsDom->statistiques;
			}
			if($statsDom->libelle == "Immo")
			{
				$immo = $statsDom->statistiques;
			}
			if($statsDom->libelle == "Dissi")
			{
				$dissi = $statsDom->statistiques;
			}
			if($statsDom->libelle == "Coordi")
			{
				$coordi = $statsDom->statistiques;
			}
			
		}
		//echo $statsUi->libelle.' - '.$statsUi->statistiques.' - '.$client.' - '.$focu.' - '.$immo.' - '.$dissi.' - '.$coordi.'<br/>';
		$req = $bdd->prepare("INSERT INTO save_data(date, ui, globale, client, focu, immo, dissi, coordi) VALUES(NOW(), ?, ?, ?, ?, ?, ?, ?)");
		$req->execute(array($statsUi->libelle, $statsUi->statistiques, $client, $focu, $immo, $dissi, $coordi));
	}
?>