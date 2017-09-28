<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mail</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>

        <?php
        include("API/fonctions.php");
        $listePoi = json_decode(getAll());
        $toutesPoi = array();
        if($listePoi != null)
        {
            foreach($listePoi as $poi)
            {
                array_push($toutesPoi, "'".$poi->id."'");
            }
        }
        $toutesPoi = implode(",", $toutesPoi);
        $listePoiRelance = json_decode(getListePoiRelances($toutesPoi));
        ?>
        
            <form class="intro-header">
            <h1 class="titre">Unité d'intervention</h1>
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
                            <button id="<?php echo $uiRplc ?>" name="<?php echo $uiRplc ?>" type="button" class="btn btn-xs" data-color="primary"><?php echo json_decode(getUiNameByUiTag($ui)); ?></button>
                            <input id="ui-<?php echo $uiRplc ?>" type="checkbox" class="hidden checkboxFiltre checkboxUi" />
                            </span>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
                <h1 class="titre">Domaine</h1>
                <div class="form-group row divRadios" id="divDomaines">
                    <?php
                    $listeDomaines = json_decode(getDomaines());
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
                            <button type="button" class="btn btn-xs" data-color="primary" name="<?php echo $domaineRplc ?>" id="<?php echo $domaineRplc ?>"><?php echo $domaine ?></button>
                            <input id="domaine-<?php echo $domaineRplc ?>" type="checkbox" class="hidden checkboxFiltre checkboxDomaine" />
                             </span>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <h1 class="titre">Sous domaine</h1>
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
                            <button type="button" class="btn btn-xs" data-color="primary" name="<?php echo $sousDomaineRplc ?>" id="<?php echo $sousDomaineRplc ?>"><?php echo $sousDomaine ?></button>
                            <input id="sousDomaine-<?php echo $sousDomaineRplc ?>" type="checkbox" class="hidden checkboxFiltre checkboxSousDomaine" checked />
                             </span>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <h1 class="titre">Sous justification</h1>
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
            </form>
            <div class="filtre_sec">
                <div>
                <span class="button-checkbox">
                    <button type="button" class="btn" data-color="danger">Retard</button>
                    <input type="checkbox" class="hidden" checked />
                </span>
                <span class="button-checkbox">
                    <button type="button" class="btn" data-color="warning">Attente ATR</button>
                    <input type="checkbox" class="hidden" checked />
                </span>
                <span class="button-checkbox">
                    <button type="button" class="btn" data-color="info">Attente Orange</button>
                    <input type="checkbox" class="hidden" checked />
                </span>
                <span class="button-checkbox">
                    <button type="button" class="btn" data-color="success">En cours</button>
                    <input type="checkbox" class="hidden" checked />
                </span>
                </div>

                <div class="mailsearch">
                    <select name="nb_lignre" id="nb_ligne" class="form-control" data-toggle="tooltip" title="Nombre de ligne à afficher">
                        <option value="100">100</option>
                        <option value="200">200</option>
                        <option value="500">500</option>
                        <option value="illimité">illimité</option>
                    </select>
                    <input type="search" placeholder="Recherche POI" class="form-control searchbar" data-toggle="tooltip" title="En cours de développement">
                    <button class="btn btn-primary"><span class="glyphicon glyphicon-envelope"></span> Push mail</button>
                </div>
            </div>

            <div id='tableau'>
                <table id="tablePoi" class="tablesorter table table-striped table-bordered table-hover table-condensed table-responsive">
                        <thead>
                            <tr>
                                <td id="checkboxToutSelectionner"><input type="checkbox" name="toutSelectionner" id="toutSelectionner" /></td>
                                <th>UI</th>
                                <th>POI</th>
                                <th>DRE</th>
                                <th>Domaine</th>
                                <th>Sous-Domaine</th>
                                <th>PG</th>
                                <th>Sous-Justif</th>
                                <th>Commune</th>
                                <th>Voie</th>
                                <th>CAFF</th>
                                <!-- <th>Email</th> -->
                                <th>Mobile</th>
                                <th>Commentaire</th>
                                <th>Nb relances</th>
                                <th>Dernière relance</th>
                                <th>Expiration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if($listePoi != null)
                            {
                                foreach($listePoi as $poi)
                                {
                                    ?>
                                    <tr id="poi-<?php echo $poi->id ?>" class="eltTr ui-<?php echo $poi->atr_ui ?> domaine-<?php echo $poi->domaine ?> sousDomaine-<?php echo $poi->sous_domaine ?> sousJustif-<?php echo $poi->ft_sous_justification_oeie ?>">
                                        <td><input type="checkbox" name="<?php echo $poi->ft_numero_oeie ?>" id="<?php echo $poi->ft_numero_oeie ?>" class="checkPoi" /></td>
                                        <td><?php echo $poi->atr_ui ?></td>
                                        <td><?php echo $poi->ft_numero_oeie ?></td>
                                        <td><?php echo $poi->ft_oeie_dre ?></td>
                                        <td><?php echo $poi->domaine ?></td>
                                        <td><?php echo $poi->sous_domaine ?></td>
                                        <td><?php echo $poi->ft_pg ?></td>
                                        <td><?php echo $poi->ft_sous_justification_oeie ?></td>
                                        <td><?php echo $poi->ft_libelle_commune ?></td>
                                        <td><?php echo $poi->ft_libelle_de_voie ?></td>
                                        <td><?php echo $poi->name_related ?></td>
                                        <!-- <td><?php /*echo $poi->work_email*/ ?></td> -->
                                        <td><?php echo $poi->mobile_phone ?></td>
                                        <td><?php echo $poi->ft_commentaire_creation_oeie ?></td>
                                            <?php 
                                            if($listePoiRelance != null)
                                            {
                                                $contient = false;
                                                foreach($listePoiRelance as $poiRelance)
                                                {
                                                    if(!$contient)
                                                    {
                                                        if($poi->id == $poiRelance->poi)
                                                        {
                                                            $contient = true;
                                                            ?>
                                                            <td><?php echo $poiRelance->nb_relances ?></td>
                                                            <td><?php echo $poiRelance->date_derniere_relance ?></td>
                                                            <td>
                                                                <?php
                                                                $dateAjd = new DateTime("now");
                                                                $dateExpiration = date($poiRelance->date_expiration);
                                                                if($dateExpiration < $dateAjd)
                                                                {
                                                                    ?>
                                                                    <button id="validerPoi-<?php echo $poi->id ?>" class="btn btn-success validerPoi">Valider</button>
                                                                    <?php
                                                                }
                                                                else{
                                                                    echo $poiRelance->date_expiration;
                                                                }
                                                                ?>
                                                            </td>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                if(!$contient)
                                                {
                                                    ?>
                                                    <td>0</td>
                                                    <td></td>
                                                    <td><button id="validerPoi-<?php echo $poi->id ?>" class="btn btn-success validerPoi">Valider</button></td>
                                                    <?php
                                                }
                                            }
                                            else{
                                                ?>
                                                <td>0</td>
                                                <td></td>
                                                <td><button id="validerPoi-<?php echo $poi->id ?>" class="btn btn-success validerPoi">Valider</button></td>
                                                <?php
                                            }
                                            ?>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                </table>
            </div>
        
        
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="tablesort/jquery.tablesorter.min.js"></script>
        <script src="js/index.js"></script>
        <script src="js/checkbox.js"></script>
    </body>
</html>