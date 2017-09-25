<?php
function getAll(){
    include("connexionBdd.php");
    $poi_list = null;
    $i = 0;
    $req = $bdd->query("select atr.atr_sous_domaine_id,atr.id,atr.atr_ui,atr.ft_numero_oeie,atr.ft_oeie_dre,atr.name as domaine,account_analytic_account.name as sous_domaine,atr.ft_pg,atr.ft_sous_justification_oeie,atr.ft_libelle_commune,atr.ft_libelle_de_voie,atr.name_related,atr.work_email,atr.mobile_phone,atr.ft_commentaire_creation_oeie from(
        select ag_poi.atr_sous_domaine_id,ag_poi.id,ag_poi.atr_ui,ag_poi.ft_oeie_dre,ag_poi.ft_numero_oeie,account_analytic_account.name,ag_poi.ft_pg,ag_poi.ft_sous_justification_oeie,ag_poi.ft_libelle_commune,ag_poi.ft_libelle_de_voie,hr_employee.name_related,hr_employee.work_email,hr_employee.mobile_phone,ag_poi.ft_commentaire_creation_oeie from ag_poi
        left join account_analytic_account on ag_poi.atr_domaine_id = account_analytic_account.id
        left join hr_employee on ag_poi.atr_caff_traitant_id = hr_employee.id
        where ft_etat = '1' and name_related is not null and work_email is not null)atr
        left join account_analytic_account on atr.atr_sous_domaine_id = account_analytic_account.id
        order by ft_oeie_dre");
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
?>

