<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mail</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <style>
            #divSousJustifs{
                display: none;
            }
            .divRadios{
                text-align: center;
                /*display: flex;
                justify-content: space-around;*/
            }
        </style>
    </head>
    <body>
    
        <?php
        include("API/fonctions.php");
        ?>
        <div class="container">
            <form class="jumbotron">
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
                            <div id="divUi-<?php echo $uiRplc ?>" class="col-lg-1">
                            <span class="button-checkbox">
                            <button id="<?php echo $uiRplc ?>" name="<?php echo $uiRplc ?>" type="button" class="btn btn-xs" data-color="primary"><?php echo json_decode(getUiNameByUiTag($ui)); ?></button>
                            <input id="ui-<?php echo $uiRplc ?>" type="checkbox" class="hidden checkboxUi" checked />
                            </span>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
                <hr/>
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
                            
                            <div id="divDomaine-<?php echo $domaineRplc ?>" class="col-lg-1 divFiltre">
                            <span class="button-checkbox">
                            <button type="button" class="btn btn-xs" data-color="primary" name="<?php echo $domaineRplc ?>" id="<?php echo $domaineRplc ?>"><?php echo $domaine ?></button>
                            <input id="domaine-<?php echo $domaineRplc ?>" type="checkbox" class="hidden" checked />
                             </span>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <hr/>
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
                            
                            <div id="divSousDomaine-<?php echo $sousDomaineRplc ?>" class="col-lg-1 divFiltre">
                            <span class="button-checkbox">
                            <button type="button" class="btn btn-xs" data-color="primary" name="<?php echo $sousDomaineRplc ?>" id="<?php echo $sousDomaineRplc ?>"><?php echo $sousDomaine ?></button>
                            <input id="sousDomaine-<?php echo $sousDomaineRplc ?>" type="checkbox" class="hidden" checked />
                             </span>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>

                <hr/>
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
                            <div id="divSousJustif-<?php echo $sousJustifRplc ?>" class="col-lg-1 divFiltre">
                            <span class="button-checkbox">
                            <button type="button" class="btn btn-xs" data-color="primary" name="<?php echo $sousJustifRplc ?>" id="<?php echo $sousJustifRplc ?>"><?php echo $sousJustif ?></button>
                            <input id="sousJustification-<?php echo $sousJustifRplc ?>" type="checkbox" class="hidden filtre" checked />
                             </span>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </form>
            </div>
            <br/>
            <br/>
            <table id="tablePoi" class="tablesorter table table-striped table-bordered table-hover table-condensed table-responsive">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="toutSelectionner" id="toutSelectionner" /></th>
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
                        $listePoi = json_decode(getAll());
                        if($listePoi != null)
                        {
                            foreach($listePoi as $poi)
                            {
                                ?>
                                <tr class="ui-<?php echo $poi->atr_ui ?> domaine-<?php echo $poi->domaine ?> sousDomaine-<?php echo $poi->sous_domaine ?> sousJustif-<?php echo $poi->ft_sous_justification_oeie ?>">
                                    <td><input type="checkbox" name="<?php echo $poi->ft_numero_oeie ?>" id="<?php echo $poi->ft_numero_oeie ?>" /></td>
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
                                    <td>Test</td>
                                    <td>Test</td>
                                    <td>Test</td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
            </table>
        
        
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="tablesort/jquery.tablesorter.min.js"></script>
        <script src="js/index.js"></script>
        <script>
        $(function () {
    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
});
        </script>
    </body>
</html>