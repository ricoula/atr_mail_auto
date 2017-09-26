<?php

	function getAll(){
		include("connexionBdd.php");
		include("global.php");
		$poi_list = null;
		$i = 0;
		$req = $bdd->query($global);
			while($data = $req->fetch()){
				$poi_list[$i]['id'] = $data['id'];
				$poi_list[$i]['atr_ui'] = $data['atr_ui'];
				$poi_list[$i]['ft_numero_oeie'] = $data['ft_numero_oeie'];
				$poi_list[$i]['ft_oeie_dre'] = $data['ft_oeie_dre'];
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
		$req = $bdd->query();
		while($data = $req->fetch("SELECT DISTINCT sous_domaine FROM (".$global.") tout WHERE atr_ui IN (".$listeUI.") AND domaine IS NOT NULL"))
		{
			$sousDomaines[$i] = ;
			$i++;
		}
	}
?>
