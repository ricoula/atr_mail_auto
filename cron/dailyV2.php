<?php
include("../API/fonctions.php");
$ui_stats = json_decode(getStatsUi());
// var_dump($ui_stats);
foreach($ui_stats as $ui_stat){
    // echo $ui_stat->libelle;
    // echo $ui_stat->statistique."\n";
}
$listeStatsUiDomaine = json_decode(getStatsDomaine());
$listDom = array("Client", "FO & CU", "Immo", "Dissi", "Coordi");
foreach($listeStatsUiDomaine as $statsUiDomaine)
{
    $statsUiDomaine->statistique = 0;
    foreach($listeUI as $ui)
    {
        if($ui->libelle == $statsUiDomaine->libelle)
        {
            $statsUiDomaine->statistique = $ui->statistique;
        }
        
    }
    ?>
    <div class="listeTableUi">
        <span class="tableStatTitle"><h4 class="<?php if($statsUiDomaine->statistique < 80){ echo "red"; }else{ echo "green"; } ?>"><?php echo json_decode(getUiNameByUiTag($statsUiDomaine->libelle)) ?><span class="glyphicon glyphicon-triangle-right stat_icon <?php if($statsUiDomaine->statistique < 80){ echo "red"; }else{ echo "green"; } ?>"></span><?php echo $statsUiDomaine->statistique ?>%</h4></span>
        <li class="tableStatDomaine"><span class="tbl_domaine dom-<?php echo $statsUiDomaine->libelle; ?>">Client</span><span class="<?php foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Client"){ if($dom->statistiques < 80){ echo "red"; }else{ echo "green"; } } } ?> pull-right"><?php $contient = false; foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Client"){ echo $dom->statistiques."%"; $contient = true; } } if(!$contient){ echo "---"; } ?></span></li>
        
        <li class="tableStatDomaine"><span class="tbl_domaine dom-<?php echo $statsUiDomaine->libelle; ?>">Fo & Cu</span><span class="<?php foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "FO & CU"){ if($dom->statistiques < 80){ echo "red"; }else{ echo "green"; } } } ?> pull-right"><?php $contient = false; foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "FO & CU"){ echo $dom->statistiques."%"; $contient = true; } } if(!$contient){ echo "---"; } ?></span></li>
        
        <li class="tableStatDomaine"><span class="tbl_domaine dom-<?php echo $statsUiDomaine->libelle; ?>">Immo</span><span class="<?php foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Immo"){ if($dom->statistiques < 80){ echo "red"; }else{ echo "green"; } } } ?> pull-right"><?php $contient = false; foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Immo"){ echo $dom->statistiques."%"; $contient = true; } } if(!$contient){ echo "---"; } ?></span></li>
        
        <li class="tableStatDomaine"><span class="tbl_domaine dom-<?php echo $statsUiDomaine->libelle; ?>">Dissi</span><span class="<?php foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Dissi"){ if($dom->statistiques < 80){ echo "red"; }else{ echo "green"; } } } ?> pull-right"><?php $contient = false; foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Dissi"){ echo $dom->statistiques."%"; $contient = true; } } if(!$contient){ echo "---"; } ?></span></li>
        
        <li class="tableStatDomaine"><span class="tbl_domaine dom-<?php echo $statsUiDomaine->libelle; ?>">Coordi</span><span class="<?php foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Coordi"){ if($dom->statistiques < 80){ echo "red"; }else{ echo "green"; } } } ?> pull-right"><?php $contient = false; foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Coordi"){ echo $dom->statistiques."%"; $contient = true; } } if(!$contient){ echo "---"; } ?></span></li>
        <div id="graph-<?php echo $statsUiDomaine->libelle; ?>" class="graphStat"></div>
    
    </div>
    <div id="left-scroll"><span class="glyphicon glyphicon-chevron-left"><span></div>
    <div id="right-scroll"><span class="glyphicon glyphicon-chevron-right"><span></div>
    <?php
}
?>
?>