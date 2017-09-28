<?php
    if(isset($_POST["liste_poi"]) && $_POST["liste_poi"] != 'null')
    {
        ?>
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
                    $listePoi = json_decode($_POST["liste_poi"]);
                    if($listePoi != null)
                    {
                        foreach($listePoi as $poi)
                        {
                            ?>
                            <tr class="eltTr ui-<?php echo $poi->atr_ui ?> domaine-<?php echo $poi->domaine ?> sousDomaine-<?php echo $poi->sous_domaine ?> sousJustif-<?php echo $poi->ft_sous_justification_oeie ?>">
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
        <!--<script src="js/index.js"></script>-->
        <script>
            $(function(){
                $(".checkPoi").change(function(){
        if($(".checkPoi").length == $(".checkPoi:checked").length)
            {
                $("#toutSelectionner").prop("checked", true);
            }
        else{
            $("#toutSelectionner").prop("checked", false);
        }
    });
    
    $("#toutSelectionner").change(function(){
        if($(this).prop("checked"))
            {
                $(".checkPoi").prop("checked", true);
            }
        else{
            $(".checkPoi").prop("checked", false);
        }
    });

    $("#tablePoi").tablesorter();
                
                if(!$("#toutSelectionner").prop("checked"))
                    {
                        $("#toutSelectionner").click();
                    }
            });
        </script>
        <?php
    }
?>