<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mail</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="chosen/chosen.min.css" >
        <link rel="stylesheet" href="css/chart.css">
        <style>
            #imageLoad{
                text-align: center;
                display: none;
            }
            .titreGraphe{
                text-align: center;
                color: aliceblue;
            }
            .tableStatTitle h4{
                cursor: pointer;
            }
        </style>
    </head>
    <body>

        <?php
        include("API/fonctions.php");
        $listeDomaines = json_decode(getDomaines());
        /*$listePoi = json_decode(getAll(100));
        $toutesPoi = array();
        if($listePoi != null)
        {
            foreach($listePoi as $poi)
            {
                array_push($toutesPoi, "'".$poi->id."'");
            }
        }
        $toutesPoi = implode(",", $toutesPoi);
        $listePoiRelance = json_decode(getListePoiRelances($toutesPoi));*/
        ?>
            <div id="statsUi" class="statsUiov">
                <div id="listeStatsUi">
                    <?php
                    $listeUI = json_decode(getStatsUi());
                    foreach($listeUI as $ui)
                    {
                        ?>
                    <div><h4 class="<?php echo "stats-".$ui->libelle." "; if($ui->statistique < 80){ echo "red"; }else{ echo "green"; } ?>"><?php echo json_decode(getUiNameByUiTag($ui->libelle)) ?><span class="glyphicon glyphicon-triangle-right stat_icon <?php if($ui->statistique < 80){ echo "red"; }else{ echo "green"; } ?>"></span><label><?php echo  $ui->statistique ?>%</label></h4></div>
                        <?php
                    }
                    ?>
                    <button class="btn_detail btn_detail_disable pull-right">Plus de détail <span class="glyphicon glyphicon-menu-down"></span></button>
                </div>
                
                <div id="allTableStat">
                    <?php
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
                            <span class="tableStatTitle"><h4 id="titreTbale-<?php echo $statsUiDomaine->libelle ?>" class="<?php if($statsUiDomaine->statistique < 80){ echo "red"; }else{ echo "green"; } ?>"><?php echo json_decode(getUiNameByUiTag($statsUiDomaine->libelle)) ?><span class="glyphicon glyphicon-triangle-right stat_icon <?php if($statsUiDomaine->statistique < 80){ echo "red"; }else{ echo "green"; } ?>"></span><?php echo $statsUiDomaine->statistique ?>%</h4></span>
                            <li class="tableStatDomaine"><span id="<?php echo $statsUiDomaine->libelle.'-Client' ?>" class="libelleDomaine tbl_domaine dom-<?php echo $statsUiDomaine->libelle; ?>">Client</span><span class="<?php foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Client"){ if($dom->statistiques < 80){ echo "red"; }else{ echo "green"; } } } ?> pull-right"><?php $contient = false; foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Client"){ echo $dom->statistiques."%"; $contient = true; } } if(!$contient){ echo "---"; } ?></span></li>
                            
                            <li class="tableStatDomaine"><span id="<?php echo $statsUiDomaine->libelle.'-FOCU' ?>" class="libelleDomaine tbl_domaine dom-<?php echo $statsUiDomaine->libelle; ?>">Fo & Cu</span><span class="<?php foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "FO & CU"){ if($dom->statistiques < 80){ echo "red"; }else{ echo "green"; } } } ?> pull-right"><?php $contient = false; foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "FO & CU"){ echo $dom->statistiques."%"; $contient = true; } } if(!$contient){ echo "---"; } ?></span></li>
                            
                            <li class="tableStatDomaine"><span id="<?php echo $statsUiDomaine->libelle.'-Immo' ?>" class="libelleDomaine tbl_domaine dom-<?php echo $statsUiDomaine->libelle; ?>">Immo</span><span class="<?php foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Immo"){ if($dom->statistiques < 80){ echo "red"; }else{ echo "green"; } } } ?> pull-right"><?php $contient = false; foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Immo"){ echo $dom->statistiques."%"; $contient = true; } } if(!$contient){ echo "---"; } ?></span></li>
                            
                            <li class="tableStatDomaine"><span id="<?php echo $statsUiDomaine->libelle.'-Dissi' ?>" class="libelleDomaine tbl_domaine dom-<?php echo $statsUiDomaine->libelle; ?>">Dissi</span><span class="<?php foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Dissi"){ if($dom->statistiques < 80){ echo "red"; }else{ echo "green"; } } } ?> pull-right"><?php $contient = false; foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Dissi"){ echo $dom->statistiques."%"; $contient = true; } } if(!$contient){ echo "---"; } ?></span></li>
                            
                            <li class="tableStatDomaine"><span id="<?php echo $statsUiDomaine->libelle.'-Coordi' ?>" class="libelleDomaine tbl_domaine dom-<?php echo $statsUiDomaine->libelle; ?>">Coordi</span><span class="<?php foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Coordi"){ if($dom->statistiques < 80){ echo "red"; }else{ echo "green"; } } } ?> pull-right"><?php $contient = false; foreach($statsUiDomaine->listeDomaines as $dom){ if($dom->libelle == "Coordi"){ echo $dom->statistiques."%"; $contient = true; } } if(!$contient){ echo "---"; } ?></span></li>
                            <h5 id="titreGraphe-<?php echo $statsUiDomaine->libelle ?>" class="titreGraphe" >Global</h5>
                            <div id="graph-<?php echo $statsUiDomaine->libelle; ?>" class="graphStat"></div>
                        </div>
                        <div id="left-scroll"><span class="glyphicon glyphicon-chevron-left"><span></div>
                        <div id="right-scroll"><span class="glyphicon glyphicon-chevron-right"><span></div>
                        <?php
                    }
                    ?>

                </div>
            </div>
            <form class="intro-header">
            <h1 class="titre"><span class="label label-default">Unité d'intervention</span></h1>
                <div class="form-group row divRadios" id="divUi">
                
                    <?php
                    $listeUis = json_decode(getUi());
                    if($listeUis != null)
                    {
                        foreach($listeUis as $ui)
                        {
                            $uiRplc = str_replace(" ", "_", $ui);
                            $uiRplc = str_replace("&", "_", $uiRplc);
                        ?>
                            <div id="divUi-<?php echo $uiRplc ?>">
                            <span class="button-checkbox">
                            <button id="<?php echo $uiRplc ?>" name="<?php echo $uiRplc ?>" type="button" class="btn btn-sm" data-color="primary"><?php echo json_decode(getUiNameByUiTag($ui)); ?></button>
                            <input id="ui-<?php echo $uiRplc ?>" type="checkbox" class="hidden checkboxFiltre checkboxUi" />
                            </span>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
                <h1 class="titre"><span class="label label-default">Domaine</span></h1>
                <div class="form-group row divRadios" id="divDomaines">
                    <?php
                    if($listeDomaines != null)
                    {
                        foreach($listeDomaines as $domaine)
                        {
                            $domaineRplc = str_replace(" ", "_", $domaine);
                            $domaineRplc = str_replace("&", "_", $domaineRplc);
                            $listeUi = json_decode(getUiByDomaine($domaineRplc));
                            ?>
                            
                            <div id="divDomaine-<?php echo $domaineRplc ?>" class="divFiltre">
                            <span class="button-checkbox">
                            <button type="button" class="btn btn-sm" data-color="primary" name="<?php echo $domaineRplc ?>" id="<?php echo $domaineRplc ?>"><?php echo $domaine ?></button>
                            <input id="domaine-<?php echo $domaineRplc ?>" type="checkbox" class="hidden checkboxFiltre checkboxDomaine" />
                             </span>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <h1 class="titre"><span class="label label-default">Sous domaine</span></h1>
                <div class="form-group row divRadios" id="divSousDomaines">
                    <?php
                    $listeSousDomaines = json_decode(getSousDomaines());
                    if($listeSousDomaines != null)
                    {
                        foreach($listeSousDomaines as $sousDomaine)
                        {
                            $sousDomaineRplc = str_replace(" ", "_", $sousDomaine);
                            $sousDomaineRplc = str_replace("&", "_", $sousDomaineRplc);
                            ?>
                            
                            <div id="divSousDomaine-<?php echo $sousDomaineRplc ?>" class="divFiltre">
                            <span class="button-checkbox">
                            <button type="button" class="btn btn-sm" data-color="primary" name="<?php echo $sousDomaineRplc ?>" id="<?php echo $sousDomaineRplc ?>"><?php echo $sousDomaine ?></button>
                            <input id="sousDomaine-<?php echo $sousDomaineRplc ?>" type="checkbox" class="hidden checkboxFiltre checkboxSousDomaine" checked />
                             </span>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <h1 class="titre">
                    <span class="label label-default">Sous justification</span>
                    <div id="divActiverToutSj" style="display: none">
                        <span class="button-checkbox">
                        <button type="button" class="btn btn-sm" data-color="success" name="<?php echo $sousDomaineRplc ?>" id="activerSousJustifs">Désactiver tout</button>
                        <input id="checkActiverSousJustifs" type="checkbox" class="hidden" checked />
                         </span>
                    </div>
                </h1>
                
                <div class="form-group row divRadios" id="divSousJustifs">
                        <?php
                        $listeSousJustifs = json_decode(getSousJustifs());
                        if($listeSousJustifs != null)
                        {
                            foreach($listeSousJustifs as $sousJustif)
                            {
                                $sousJustifRplc = str_replace(" ", "_", $sousJustif);
                                $sousJustifRplc = str_replace("&", "_", $sousJustifRplc);
                                ?>
                                <div id="divSousJustif-<?php echo $sousJustifRplc ?>" class="divFiltre col-lg-1">
                                <span class="button-checkbox">
                                <button type="button" class="btn btn-xs" data-color="primary" name="<?php echo $sousJustifRplc ?>" id="<?php echo $sousJustifRplc ?>"><?php echo $sousJustif ?></button>
                                <input id="sousJustification-<?php echo $sousJustifRplc ?>" type="checkbox" class="checkboxFiltre hidden filtre checkboxSJ" checked />
                                 </span>
                                </div>
                                <?php
                            }
                        }
                        ?>
                </div>
                <!--<button id="btnValiderFiltres" class="btn btn-info">Valider filtres</button>-->
                <div style="text-align: center">
                        <button id="btnAlerte" type="button" class="btn btn-default" data-color="dark"><span class="glyphicon glyphicon-star"></span> Alertes </button>
                        <input type="checkbox" id="checkboxAlerte" class="checkboxFiltre" hidden/>
                </div>
            </form>
            
        
            <div id="imageLoad">
                <img src="img/loading.gif" />
            </div>
        
            
        
            <div id='tableau'>
            </div>
        
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="tablesort/jquery.tablesorter.min.js"></script>
        <script src="js/chart.js"></script>
        <script src="js/index.js"></script>
        <script src="js/checkbox.js"></script>
        <!--<script src="js/checkbox.js"></script>-->
    </body>
</html>