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
                    <div><h4 class="<?php if($ui->statistique < 80){ echo "red"; }else{ echo "green"; } ?>"><?php echo json_decode(getUiNameByUiTag($ui->libelle)) ?><span class="glyphicon glyphicon-triangle-right stat_icon <?php if($ui->statistique < 80){ echo "red"; }else{ echo "green"; } ?>"></span><?php echo  $ui->statistique ?>%</h4></div>
                        <?php
                    }
                    ?>
                </div>
                <div id="allTableStat">
                    <?php
                    $listeStatsUiDomaine = json_decode(getStatsDomaine());
                    $listDom = array("Client", "FO & CU", "Immo", "Dissi", "Coordi");
                    foreach($listeStatsUiDomaine as $statsTable)
                    {
                        ?>
                        <div class="listeTableUi">
                            <span class="tableStatTitle"><h4 class="<?php if($listeUI[0]->statistique < 80){ echo "red"; }else{ echo "green"; } ?>"><?php echo json_decode(getUiNameByUiTag($listeUI[0]->libelle)) ?><span class="glyphicon glyphicon-triangle-right stat_icon <?php if($listeUI[0]->statistique < 80){ echo "red"; }else{ echo "green"; } ?>"></span><?php echo  $listeUI[0]->statistique ?>%</h4></span>
                            <li class="tableStatDomaine"><span class="tbl_domaine">Client</span><span class="green pull-right">83.2%</span></li>
                            <li class="tableStatDomaine"><span class="tbl_domaine">Fo & Cu</span><span class="red pull-right">60.8%</span></li>
                            <li class="tableStatDomaine"><span class="tbl_domaine">Immo</span><span class="green pull-right">81.0%</span></li>
                            <li class="tableStatDomaine"><span class="tbl_domaine">Dissi</span><span class="red pull-right">76.2%</span></li>
                            <li class="tableStatDomaine"><span class="tbl_domaine">Coordi</span><span class="red pull-right">33.5%</span></li>
                            <div class="graphStat"></div>
                        </div>
                        <?php
                    }
                    ?>
     

                </div>
                <!-- <div id="listeTableauxUi" style="display:none" class="container-fluid">
                    <?php
                    foreach($listeUI as $ui)
                    {
                        ?>
                        <div class="col-lg-4">
                            <h4 id="listeUi-<?php echo $ui->libelle ?>" class="<?php if($ui->statistique < 80){ echo "red"; }else{ echo "green"; } ?>"><?php echo json_decode(getUiNameByUiTag($ui->libelle)) ?><span class="glyphicon glyphicon-triangle-right stat_icon <?php if($ui->statistique < 80){ echo "red"; }else{ echo "green"; } ?>"></span><?php echo  $ui->statistique ?>%</h4>
                            <div class="list-group tableauUi" id="liste-<?php echo $ui->libelle ?>">
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div> -->
                <!--<div><h4 class="green">Alpes<span class="glyphicon glyphicon-triangle-right green stat_icon"></span>89.2%<h1></div>
                <div><h4 class="red">Midi Py<span class="glyphicon glyphicon-triangle-right red stat_icon"></span>69.1%<h1></div>
                <div><h4 class="red">Lyon<span class="glyphicon glyphicon-triangle-right red stat_icon"></span>76.8%<h1></div>-->
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