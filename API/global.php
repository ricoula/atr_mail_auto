<?php
	$global = "select atr.atr_sous_domaine_id,atr.id,atr.atr_ui,atr.partner,atr.ft_numero_oeie,atr.ft_oeie_dre,atr.name as domaine,account_analytic_account.name as sous_domaine,atr.ft_pg, CASE WHEN LENGTH(ft_sous_justification_oeie) = 2 THEN ft_sous_justification_oeie ELSE 'Pas de SJ' END AS ft_sous_justification_oeie, atr.ft_libelle_commune,atr.ft_libelle_de_voie,atr.name_related,atr.work_email,atr.mobile_phone,atr.ft_commentaire_creation_oeie from(
                select ag_poi.atr_sous_domaine_id,ag_poi.id,ag_poi.atr_ui,res_partner.name as partner,ag_poi.ft_oeie_dre,ag_poi.ft_numero_oeie,account_analytic_account.name,ag_poi.ft_pg,ag_poi.ft_sous_justification_oeie,ag_poi.ft_libelle_commune,ag_poi.ft_libelle_de_voie,hr_employee.name_related,hr_employee.work_email,hr_employee.mobile_phone,ag_poi.ft_commentaire_creation_oeie from ag_poi
                left join account_analytic_account on ag_poi.atr_domaine_id = account_analytic_account.id
                left join hr_employee on ag_poi.atr_caff_traitant_id = hr_employee.id
                left join res_partner on ag_poi.res_partner_id = res_partner.id
                where ft_etat = '1' and name_related is not null and work_email is not null and ag_poi.ft_numero_oeie not like '%MBB%')atr
                left join account_analytic_account on atr.atr_sous_domaine_id = account_analytic_account.id
                order by ft_oeie_dre";
?>