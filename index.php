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
                        ?>
                            <div class="col-lg-1 well">
                                <label for="ui-<?php echo $ui ?>"><input type="checkbox" class="form-control" name="ui-<?php echo $ui ?>" id="ui-<?php echo $ui ?>" /> <?php echo $ui ?></label>
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
                        
                            ?>
                            <div class="col-lg-1 well">
                                <label for="domaine-<?php echo $domaine ?>"><input type="checkbox" class="form-control" name="domaine-<?php echo $domaine ?>" id="domaine-<?php echo $domaine ?>" /> <?php echo $domaine ?></label>
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
                            ?>
                            <div class="col-lg-1 well">
                                <label for="sousDomaine-<?php echo $sousDomaine ?>"><input type="checkbox" class="form-control" name="sousDomaine-<?php echo $sousDomaine ?>" id="sousDomaine-<?php echo $sousDomaine ?>" /> <?php echo $sousDomaine ?></label>
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
                            ?>
                            <div class="col-lg-1 well">
                                <label for="sousJustif-<?php echo $sousJustif ?>"><input type="checkbox" class="form-control" name="sousJustif-<?php echo $sousJustif ?>" id="sousJustif-<?php echo $sousJustif ?>" /> <?php echo $sousJustif ?></label>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </form>
        </div>
        
        
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="js/index.js"></script>
    </body>
</html>