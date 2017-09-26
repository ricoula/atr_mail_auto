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
                            <span class="button-checkbox">
                            <button id="<?php echo $ui ?>" name="<?php echo $ui ?>" type="button" class="btn btn-xs" data-color="primary"><?php echo json_decode(getUiNameByUiTag($ui)); ?></button>
                            <input type="checkbox" class="hidden" checked />
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
                            ?>
                            
                            <div class="col-lg-1">
                            <span class="button-checkbox">
                            <button type="button" class="btn btn-xs" data-color="primary" name="<?php echo $domaine ?>" id="<?php echo $domaine ?>"><?php echo $domaine ?></button>
                            <input type="checkbox" class="hidden" checked />
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
                            ?>
                            
                            <div class="col-lg-1">
                            <span class="button-checkbox">
                            <button type="button" class="btn btn-xs" data-color="primary" name="<?php echo $sousDomaine ?>" id="<?php echo $sousDomaine ?>"><?php echo $sousDomaine ?></button>
                            <input type="checkbox" class="hidden" checked />
                             </span>
                            </div>
                            <?php
                        }
                    }
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
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
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