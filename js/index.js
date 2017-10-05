$(function(){

    $("#statsUi").hover(function(){
        /*var divElt = document.createElement("div");
        divElt.id = "divTableaux";
        divElt.style.width = "30em";
        divElt.style.overflowX = "auto";
        divElt.style.whiteSpace = "nowrap";
        divElt.classList += "container-fluid";
        
        $.post("API/getStatsDomaine.php", {}, function(data){
            var listeDomaines = JSON.parse(data);
            listeDomaines.forEach(function(domaine){
                var itemList = document.createElement("a");
                itemList.href = "#";
                itemList.classList += "list-group-item";
                itemList.textContent = domaine.libelle;
                $(".tableauUi").each(function(i, elt){
                    
                    if(domaine.listeUi.indexOf(elt.attr("id").split("-")[1]) != -1)
                        {
                            elt.append(itemList);
                        }
                    else{
                        itemList.textContent = "-----------";
                        elt.append(itemList);
                    }
                });
            });
        });*/
        
        $(this).animate({height: "800px"}, 500, function(){
            $("#listeTableauxUi").show();
        });
    });


    $("#activerSousJustifs").click(function(){
        if($("#checkActiverSousJustifs").prop("checked") == true)
            {
                $("#divSousJustifs").children(".divFiltre").children(".button-checkbox").children(".checkboxSJ").each(function(){
                    if($(this).parent().parent().is(":visible"))
                        {
                            if($(this).prop("checked") == true)
                                {
                                    $(this).parent().children("button").click();
                                }
                        }
                });
                $("#activerSousJustifs").html("<span class='glyphicon glyphicon-unchecked'></span> Activer tout");
            }
        else{
            $("#divSousJustifs").children(".divFiltre").children(".button-checkbox").children(".checkboxSJ").each(function(){
                    if($(this).parent().parent().is(":visible"))
                        {
                            if($(this).prop("checked") == false)
                                {
                                    $(this).parent().children("button").click();
                                }
                        }
                });
            $("#activerSousJustifs").html("<span class='glyphicon glyphicon-check'></span> Désactiver tout");
        }
    });
    
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
    
    if(!$("#toutSelectionner").prop("checked"))
    {
        $("#toutSelectionner").click();
    }

    $("#tablePoi").tablesorter();

    $(".checkboxFiltre").prop("checked", true);

    $(".checkboxFiltre").change(function(){
        
        
        $("#imageLoad").show();
        $("#tableau").hide();
        var nbUiCoche = 0;
        $(".checkboxUi").each(function(){
            if($(this).prop("checked") == true)
            {
                nbUiCoche++;
            }
        });
        if(nbUiCoche == 1)
        {
            $("#divSousJustifs").slideDown();
        }
        else
        {
            $("#divSousJustifs").slideUp();
        }
        
     var getCheckedUi = [];
     var getCheckedDomaine = [];
     var getCheckedSousDomaine = [];
     var getCheckedSJ = [];

     $(".checkboxUi").each(function(){
        if($(this).prop("checked") == true && $(this).closest("div").is(":visible"))
        {
            getCheckedUi.push("." + $(this).attr("id"));
        }
    });
    $(".checkboxDomaine").each(function(){
        if($(this).prop("checked") == true && $(this).closest("div").is(":visible"))
        {
            getCheckedDomaine.push("." + $(this).attr("id"));
        }
    });
    $(".checkboxSousDomaine").each(function(){
        if($(this).prop("checked") == true && $(this).closest("div").is(":visible"))
        {
            getCheckedSousDomaine.push("." + $(this).attr("id"));
        }
    });
    $(".checkboxSJ").each(function(){
        if($(this).prop("checked") == true)
        {
            getCheckedSJ.push("." + $(this).attr("id"));
        }
    });
    var getCheckedDomaineJoined = getCheckedDomaine.join(",");
    var getCheckedUiJoined = getCheckedUi.join(",");
    var getCheckedSousDomaineJoined = getCheckedSousDomaine.join(",");
    var getCheckedSJJoined = getCheckedSJ.join(",");

    $("#divDomaines div").each(function(){
        if($(this).is(getCheckedUiJoined))
        {
            $(this).show();
        }
        else
        {
            $(this).hide();
        }
    });
    getCheckedUi = [];
    getCheckedDomaine = [];
    getCheckedSousDomaine = [];
    getCheckedSJ = [];
   $(".checkboxUi").each(function(){
      if($(this).prop("checked") == true && $(this).closest("div").is(":visible"))
      {
          getCheckedUi.push("." + $(this).attr("id"));
      }
  });
  $(".checkboxDomaine").each(function(){
      if($(this).prop("checked") == true && $(this).closest("div").is(":visible"))
      {
          getCheckedDomaine.push("." + $(this).attr("id"));
      }
  });
  $(".checkboxSousDomaine").each(function(){
      if($(this).prop("checked") == true && $(this).closest("div").is(":visible"))
      {
          getCheckedSousDomaine.push("." + $(this).attr("id"));
      }
  });
  $(".checkboxSJ").each(function(){
      if($(this).prop("checked") == true)
      {
          getCheckedSJ.push("." + $(this).attr("id"));
      }
  });
   getCheckedDomaineJoined = getCheckedDomaine.join(",");
   getCheckedUiJoined = getCheckedUi.join(",");
   getCheckedSousDomaineJoined = getCheckedSousDomaine.join(",");
   getCheckedSJJoined = getCheckedSJ.join(",");  
    $("#divSousDomaines div").each(function(){
        if($(this).is(getCheckedUiJoined) && $(this).is(getCheckedDomaineJoined))
        {
            $(this).show()
        }
        else
        {
            $(this).hide();
        }
    });
    getCheckedUi = [];
    getCheckedDomaine = [];
    getCheckedSousDomaine = [];
    getCheckedSJ = [];
   $(".checkboxUi").each(function(){
      if($(this).prop("checked") == true && $(this).closest("div").is(":visible"))
      {
          getCheckedUi.push("." + $(this).attr("id"));
      }
  });
  $(".checkboxDomaine").each(function(){
      if($(this).prop("checked") == true && $(this).closest("div").is(":visible"))
      {
          getCheckedDomaine.push("." + $(this).attr("id"));
      }
  });
  $(".checkboxSousDomaine").each(function(){
      if($(this).prop("checked") == true && $(this).closest("div").is(":visible"))
      {
          getCheckedSousDomaine.push("." + $(this).attr("id"));
      }
  });
  $(".checkboxSJ").each(function(){
      if($(this).prop("checked") == true)
      {
          getCheckedSJ.push("." + $(this).attr("id"));
      }
  });
   getCheckedDomaineJoined = getCheckedDomaine.join(",");
   getCheckedUiJoined = getCheckedUi.join(",");
   getCheckedSousDomaineJoined = getCheckedSousDomaine.join(",");
   getCheckedSJJoined = getCheckedSJ.join(",");  
    $("#divSousJustifs div").each(function(){
        if($(this).is(getCheckedUiJoined) && $(this).is(getCheckedDomaineJoined) && $(this).is(getCheckedSousDomaineJoined))
        {
                $(this).show(); 
        }
        else
        {
            $(this).hide();
        }
    }); 
 
     getCheckedUi = [];
     getCheckedDomaine = [];
     getCheckedSousDomaine = [];
     getCheckedSJ = [];
    $(".checkboxUi").each(function(){
       if($(this).prop("checked") == true && $(this).closest("div").is(":visible"))
       {
           getCheckedUi.push("." + $(this).attr("id"));
       }
   });
   $(".checkboxDomaine").each(function(){
       if($(this).prop("checked") == true && $(this).closest("div").is(":visible"))
       {
           getCheckedDomaine.push("." + $(this).attr("id"));
       }
   });
   $(".checkboxSousDomaine").each(function(){
       if($(this).prop("checked") == true && $(this).closest("div").is(":visible"))
       {
           getCheckedSousDomaine.push("." + $(this).attr("id"));
       }
   });
   $(".checkboxSJ").each(function(){
       if($(this).prop("checked") == true && $(this).closest("div").is(":visible"))
       {
           getCheckedSJ.push("." + $(this).attr("id"));
       }
   });
    getCheckedDomaineJoined = getCheckedDomaine.join(",");
    getCheckedUiJoined = getCheckedUi.join(",");
    getCheckedSousDomaineJoined = getCheckedSousDomaine.join(",");
    getCheckedSJJoined = getCheckedSJ.join(",");  

    
    getCheckedUi = [];
    getCheckedDomaine = [];
    getCheckedSousDomaine = [];
    getCheckedSJ = [];
        
    $("#divUi .checkboxFiltre:checked").each(function(){
        getCheckedUi.push("'" + $(this).parent().children("button").attr("id") + "'");
    });
    $("#divDomaines .checkboxFiltre:checked").each(function(){
        getCheckedDomaine.push("'" + $(this).parent().children("button").text().slice(1) + "'");
    });
    $("#divSousDomaines .checkboxFiltre:checked").each(function(){
        getCheckedSousDomaine.push("'" + $(this).parent().children("button").text().slice(1) + "'");
    });
    if($("#divSousJustifs").is(":visible"))
        {
            $("#divSousJustifs .checkboxFiltre:checked").each(function(){
                getCheckedSJ.push("'" + $(this).parent().children("button").text().slice(1) + "'");
            });
            getCheckedSJ.push("'Pas de SJ'");
        }
        
    getCheckedUiJoined = getCheckedUi.join(",");
    getCheckedDomaineJoined = getCheckedDomaine.join(",");
    getCheckedSousDomaineJoined = getCheckedSousDomaine.join(",");
    getCheckedSJJoined = getCheckedSJ.join(",");

    $.post("API/getAllParams.php", {liste_ui: getCheckedUiJoined, liste_domaines: getCheckedDomaineJoined, liste_sous_domaines: getCheckedSousDomaineJoined, liste_sous_justifs: getCheckedSJJoined, limit: null}, function(data){
        $("#tableau").load("tableau.php", {liste_poi: data}, function(){
            $("#imageLoad").hide();
            $("#tableau").show();
        });
    });
        
    if($("#divSousJustifs .divFiltre:visible").length > 0)
            {
                $("#divActiverToutSj").show();
            }
        else{
            $("#divActiverToutSj").hide();
        }
    
});
    
    $(".checkboxDomaine, .checkboxUi").each(function(){
        if($(this).is(":checked"))
            {
                $(this).click();
            }
        else{
            console.log("pas cocher");
        }
    });

    $.post("API/getArbo.php", {}, function(data){
        var arbo = JSON.parse(data);
        if(arbo != null)
        {
            arbo.forEach(function(elt){
                var divSousJustif = $("#divSousJustif-" + elt.sous_justification);
                var divSousDomaine = $("#divSousDomaine-" + elt.sous_domaine);
                var divDomaine = $("#divDomaine-" + elt.domaine);
                var divUi = $("#divUi-" + elt.ui);

                if(!divSousJustif.hasClass("sousDomaine-" + elt.sous_domaine))
                {
                    divSousJustif.addClass("sousDomaine-" + elt.sous_domaine);
                }
                if(!divSousJustif.hasClass("domaine-" + elt.domaine))
                {
                    divSousJustif.addClass("domaine-" + elt.domaine);
                }
                if(!divSousJustif.hasClass("ui-" + elt.ui))
                {
                    divSousJustif.addClass("ui-" + elt.ui);
                }


                if(!divSousDomaine.hasClass("domaine-" + elt.domaine))
                {
                    divSousDomaine.addClass("domaine-" + elt.domaine);
                }
                if(!divSousDomaine.hasClass("ui-" + elt.ui))
                {
                    divSousDomaine.addClass("ui-" + elt.ui);
                }

                if(!divDomaine.hasClass("ui-" + elt.ui))
                {
                    divDomaine.addClass("ui-" + elt.ui);
                }
            });
        }
    });
    
    $("#btnAlerte").click(function(){
        if($(this).hasClass("btn-default"))
            {
                var getCheckedUi = [];
                $(".checkboxUi").each(function(){
                  if($(this).prop("checked") == true && $(this).closest("div").is(":visible"))
                  {
                      getCheckedUi.push("'" + $(this).attr("id").split("-")[1] + "'");
                  }
                });
                getCheckedUi = getCheckedUi.join(", ");
                 console.log(getCheckedUi);                     
                $(this).removeClass().addClass("btn btn-primary");
                
                $.post("API/getAlertesUi.php", {liste_ui: getCheckedUi}, function(data){
                    $("#tableau").load("tableau.php", {liste_poi: data, alerte: true}, function(){
                        $("#imageLoad").hide();
                        $("#tableau").show();
                    });
                });
            }
        else{
            $("#checkboxAlerte").click();
            $(this).removeClass().addClass("btn btn-default");
        }
    });


        $('[data-toggle="tooltip"]').tooltip(); 
    
});