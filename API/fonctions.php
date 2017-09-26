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
			$arbo[$i]["sous_justification"] = $data["ft_sous_justification_oeie"];
			$arbo[$i]["sous_domaine"] = $data["sous_domaine"];
			$arbo[$i]["domaine"] = $data["domaine"];
			$arbo[$i]["ui"] = $data["atr_ui"];
			$i++;
		}
		return json_encode($arbo);
	}
?>
