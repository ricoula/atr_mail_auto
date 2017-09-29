    <?php
    if(isset($_POST["liste_poi"]) && $_POST["liste_poi"] != 'null')
    {
        include("API/fonctions.php");
        $listePoi = json_decode($_POST["liste_poi"]);
        $toutesPoi = array();
        if($listePoi != null)
        {
            foreach($listePoi as $poi)
            {
                array_push($toutesPoi, "'".$poi->id."'");
            }
        }
        $toutesPoi = implode(",", $toutesPoi);
        if($toutesPoi != null && $toutesPoi != "")
        {
            $listePoiRelance = json_decode(getListePoiRelances($toutesPoi));
        }
        else{
            $listePoiRelance = null;
        }
        
        ?>
        <div id="imageChargement" style="text-align: center">
            <img src="img/loading.gif" />
        </div>

        <div class="filtre_sec" style="display: none">
                <div id="btnFiltre">
                <span class="button-checkbox">
                    <button type="button" class="btn btn-danger" data-color="danger">Retard <span class="badge badge-secondary" id="badge-retard">0</span></button>
                    <input id="danger" type="checkbox" class="hidden" checked />
                </span>
                <span class="button-checkbox">
                    <button type="button" class="btn btn-warning" data-color="warning">Attente ATR <span class="badge badge-secondary" id="badge-att-atr">0</span></button>
                    <input id="warning" type="checkbox" class="hidden" checked />
                </span>
                <span class="button-checkbox">
                    <button type="button" class="btn btn-info" data-color="info">Attente Orange <span class="badge badge-secondary" id="badge-att-orange">0</span></button>
                    <input id="info" type="checkbox" class="hidden" checked />
                </span>
                <span class="button-checkbox">
                    <button type="button" class="btn btn-success" data-color="success">En cours <span class="badge badge-secondary" id="badge-en-cours">0</span></button>
                    <input id="success" type="checkbox" class="hidden" checked />
                </span>
                </div>

                <div class="mailsearch">
                    <!--<select name="nb_lignre" id="nb_ligne" class="form-control" data-toggle="tooltip" title="Nombre de ligne à afficher">
                        <option value="100">100</option>
                        <option value="200">200</option>
                        <option value="500">500</option>
                        <option value="illimite">illimité</option>
                    </select>-->
                    <input type="search" placeholder="Recherche POI" class="form-control searchbar" data-toggle="tooltip" title="En cours de développement">
                    <button id="pushMail" class="btn btn-primary" data-toggle="modal" data-target="#mailModal"><span class="glyphicon glyphicon-envelope"></span> Push mail <span class="badge badge-secondary" id="badge-push-mail">0</span></button>
                </div>
            </div>

        <table id="tablePoi" class="tablesorter table table-striped table-bordered table-hover table-condensed table-responsive" style="display: none">
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
                        <th id="th-mobile">Mobile</th>
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
                            <tr id="poi-<?php echo $poi->id ?>" class="eltTr ui-<?php echo $poi->atr_ui ?> domaine-<?php echo $poi->domaine ?> sousDomaine-<?php echo $poi->sous_domaine ?> sousJustif-<?php echo $poi->ft_sous_justification_oeie ?> 
                               <?php  
                                /*$dateAjd = strtotime("+7 day");
                            
                                $dateDre = strtotime($poi->ft_oeie_dre);
                            
                                if($dateAjd < $dateDre)
                                {
                                    echo "success";
                                }
                                else{
                                    $poiRelance = json_decode(getPoiRelanceById($poi->id));
                                    if($poiRelance != null)
                                    {
                                        $dateExpiration = strtotime($poiRelance->date_expiration);
                                        if($dateExpiration < $dateAjd)
                                        {
                                            echo "info";
                                        }
                                        else{
                                            if($poiRelance->nb_relances != null && $poiRelance->nb_relances > 0)
                                            {
                                                echo "warning";
                                            }
                                            else{
                                                echo "danger";
                                            }
                                        }
                                    }
                                    else{
                                        echo "danger";
                                    }
                                }*/
                               ?>
                               ">
                                <td><input type="checkbox" name="<?php echo $poi->ft_numero_oeie ?>" id="<?php echo $poi->ft_numero_oeie ?>" class="checkPoi" /></td>
                                <td><?php echo $poi->atr_ui ?></td>
                                <td><?php echo $poi->ft_numero_oeie ?></td>
                                <td class="colonneDre"><?php echo $poi->ft_oeie_dre ?></td>
                                <td><?php echo $poi->domaine ?></td>
                                <td><?php echo $poi->sous_domaine ?></td>
                                <td><?php echo $poi->ft_pg ?></td>
                                <td><?php echo $poi->ft_sous_justification_oeie ?></td>
                                <td><?php echo $poi->ft_libelle_commune ?></td>
                                <td><?php echo $poi->ft_libelle_de_voie ?></td>
                                <td class="colonneCaff"><?php echo $poi->name_related ?></td>
                                <td class="colonneEmail" style="display: none"><?php echo $poi->work_email ?></td>
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
                                                            <td class="colonneNbRelances"><?php echo $poiRelance->nb_relances ?></td>
                                                            <td class="colonneDateDernierEnvoi"><?php echo $poiRelance->date_derniere_relance ?></td>
                                                            <td class="colonneDateExpiration">
                                                                <?php
                                                                $dateAjd = new DateTime("now");
                                                                $dateAjd = $dateAjd->format('Y-m-d H:i:s');
                                                                $dateAjd = strtotime($dateAjd);
                                                                
                                                                $dateExpiration = explode("/", $poiRelance->date_expiration);
                                                                if(sizeof($dateExpiration) == 3)
                                                                {
                                                                    $dateExpiration = $dateExpiration[2]."-".$dateExpiration[1]."-".$dateExpiration[0];
                                                                    $dateExpiration = strtotime($dateExpiration);
                                                                }
                                                                else{
                                                                    $dateExpiration = 0;
                                                                }
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
                                                    <td class="colonneNbRelances">0</td>
                                                    <td class="colonneDateDernierEnvoi"></td>
                                                    <td class="colonneDateExpiration"><button id="validerPoi-<?php echo $poi->id ?>" class="btn btn-success validerPoi">Valider</button></td>
                                                    <?php
                                                }
                                            }
                                            else{
                                                ?>
                                                <td class="colonneNbRelances">0</td>
                                                <td class="colonneDateDernierEnvoi"></td>
                                                <td class="colonneDateExpiration"><button id="validerPoi-<?php echo $poi->id ?>" class="btn btn-success validerPoi">Valider</button></td>
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

        <div class="modal" id="mailModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h4 class="modal-title">Liste de diffusion</h4>
              </div>
              <div class="modal-body" id="diff-mail">
              <table class='table table-striped table-bordered table-hover table-condensed table-responsive'><thead><tr><th>Caff</th><th>Email</th><th>Relance</th></tr></thead><tbody id="bodymail"></tbody></table>
              </div>
              <div class="modal-footer">
                 
                <button class="btn btn-info" data-dismiss="modal">Fermer</button>
                <button class="btn btn-success">Push mail</button>
              </div>
            </div>
          </div>
        </div>

        <script>
            $(function(){
                
                $(".checkPoi").change(function(){
        if($(".checkPoi").length == $(".checkPoi:checked").length)
            {
                $("#toutSelectionner").prop("checked", true);
                $("#badge-push-mail").html($(".checkPoi:checked").length);
            }
        else{
            $("#toutSelectionner").prop("checked", false);
            $("#badge-push-mail").html($(".checkPoi:checked").length);
        }
    });
    
    $("#toutSelectionner").change(function(){
        if($(this).prop("checked"))
            {
                $(".checkPoi").prop("checked", true);
                $("#badge-push-mail").html($(".checkPoi:checked").length);
            }
        else{
            $(".checkPoi").prop("checked", false);
            $("#badge-push-mail").html($(".checkPoi:checked").length);
        }
    });

    $("#tablePoi").tablesorter();
                
    if(!$("#toutSelectionner").prop("checked"))
        {
            $("#toutSelectionner").click();
        }
                
                
    $(".validerPoi").click(function(){
            $(this).prop("disabled", true);
            var idPoi = $(this).attr("id").split("-")[1];
            $.post("API/validerPoi.php", {poi_id: idPoi}, function(data){
                $(this).prop("disabled", true);
                var poi = JSON.parse(data);
                $("#poi-" + idPoi).children(".colonneNbRelances").text(poi.nb_relances);
                $("#poi-" + idPoi).children(".colonneDateDernierEnvoi").text(poi.date_derniere_relance);
                $("#poi-" + idPoi).children(".colonneDateExpiration").text(poi.date_expiration);
                if(!$("#poi-" + idPoi).hasClass("success"))
                    {
                        
                        $("#poi-" + idPoi).removeClass("info").removeClass("warning").removeClass("danger").addClass("info");
                        $("#badge-retard").html($("tbody .danger").length);
                        $("#badge-att-atr").html($("tbody .warning").length);
                        $("#badge-att-orange").html($("tbody .info").length);
                        $("#badge-en-cours").html($("tbody .success").length);
                    }
            });
        });
            
            
        $("tbody tr").each(function(){
            var dateAjd = new Date();
            dateAjd = dateAjd.getTime();
            var dateDreTab = $(this).children(".colonneDre").text().split("/");
            var dateDre = 0;
            if(dateDreTab.length == 3)
                {
                    dateDre = new Date(dateDreTab[2], dateDreTab[1], dateDreTab[0]);
                    dateDre = dateDre.getTime() - (1000*60*60*24*7); //Pour enlever 7 jours
                }
            var dateExpirationTab = $(this).children(".colonneDateExpiration").text().split("/");
            var dateExpiration = 0;
            if(dateExpirationTab.length == 3)
                {
                    dateExpiration = new Date(dateExpirationTab[2], dateExpirationTab[1], dateExpirationTab[0]);
                    dateExpiration = dateExpiration.getTime();
                }
            var nbRelances = parseInt($(this).children(".colonneNbRelances").text());
            var dateDerniereRelanceTab = $(this).children(".colonneDateDernierEnvoi").text().split("/");
            var dateDerniereRelance = 0;
            if(dateDerniereRelanceTab.length == 3)
                {
                    dateDerniereRelance = new Date(dateDerniereRelanceTab[2], dateDerniereRelanceTab[1], dateDerniereRelanceTab[0]);
                    dateDerniereRelance = dateDerniereRelance.getTime();
                }
            if(dateDre > dateAjd)
                {
                    $(this).addClass("success");
                }
            else{
                if(dateExpiration > dateAjd)
                    {
                        $(this).addClass("info");
                    }
                else{
                    if(nbRelances > 0)
                        {
                            $(this).addClass("warning");
                        }
                    else{
                        $(this).addClass("danger");
                    }
                }
            }
            });
                
            $("#btnFiltre button").each(function(){
                $(this).click(function(){
                var elt = $(this);
                var valeur = $(this).parent().children("input").attr("id");
                if($("#" + valeur).prop("checked"))
                    {
                        $("#" + valeur).prop("checked", false);
                        elt.removeClass().addClass("btn btn-default");
                        $("tbody ." + valeur).hide();
                        $("tbody ." + valeur).children(".checkPoi").prop("checked", false);
                    }
                else{
                    $("#" + valeur).prop("checked", true);
                    elt.removeClass().addClass("btn btn-" + valeur);
                    $("tbody ." + valeur).show();
                    $("tbody ." + valeur).children(".checkPoi").prop("checked", true);
                }
            });
            });
                
            $("#pushMail").click(function(){
                listeCaffPoi = new Object();
                var listeCaffs = [];
                $(".checkPoi:checked").each(function(){
                    var ligne = $(this).closest("tr");
                    var idPoi = ligne.attr("id").split("-")[1];
                    var email = ligne.children(".colonneEmail").text();
                    var caff = ligne.children(".colonneCaff").text();
                    if(listeCaffs.indexOf(caff) == -1)
                        {
                            listeCaffs.push(caff);
                            listeCaffPoi[caff] = new Object();
                            listeCaffPoi[caff].email = email;
                            listeCaffPoi[caff].nom = caff;
                            listeCaffPoi[caff].listePois = [];
                        }
                    listeCaffPoi[caff].listePois.push(idPoi);
                });
              $("#bodymail").html("");
                for(var caff in listeCaffPoi)
                {
                    var nomCaff = listeCaffPoi[caff].nom;
                    var nbPoi = listeCaffPoi[caff].listePois.length;
                    var caffMail = listeCaffPoi[caff].email
                    $("#bodymail").append("<tr><td>" +nomCaff+ "</td><td>" + caffMail  + "</td><td>" + nbPoi + "</td></th>");
                }
              
              
           
            //         for (var i = 0; i < listeCaffPoi.length; i++) {
            //             console.log(listeCaffPoi[i].nom)
            //           }
                
            // console.log(listeCaffPoi.length);
            // for(var caff in listeCaffPoi)
            // {
            //     console.log(caff.nom);
            // }
            });
            
            $("#imageChargement").hide();
            $("table").show();
            $(".filtre_sec").show();
            $("#badge-retard").html($("tbody .danger").length);
            $("#badge-att-atr").html($("tbody .warning").length);
            $("#badge-att-orange").html($("tbody .info").length);
            $("#badge-en-cours").html($("tbody .success").length);
            $("#badge-push-mail").html($(".checkPoi:checked").length);
        });            
        </script>
        <?php
    }
?>