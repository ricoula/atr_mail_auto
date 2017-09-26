<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mail</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        
        <style>
            #divSousJustifs{
                display: none;
            }
            .divRadios{
                text-align: center;
                display: flex;
                justify-content: space-around;
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
                            <div class="col-lg-1">
                                <label for="<?php echo $ui ?>"><input type="checkbox" class="form-control" name="<?php echo $ui ?>" id="<?php echo $ui ?>" /> <?php echo $ui ?></label>
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
                            <span class="col-lg-1">
                                <label for="<?php echo $domaine ?>"><input type="checkbox" class="form-control" name="<?php echo $domaine ?>" id="<?php echo $domaine ?>" /> <?php echo $domaine ?></label>
                            </span>
                            <?php
                        }
                    }
                    ?>
                </div>
                <hr/>
                <div class="form-group row divRadios" id="divSousDomaines">
                    <?php
                    
                    ?>
                </div>
                <hr/>
                <div class="form-group row divRadios" id="divPg">
                </div>
                <hr/>
                <div class="form-group row divRadios" id="divSousJustifs">
                </div>
            </form>
        </div>
        
        
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
        <script src="js/index.js"></script>
    </body>
</html>