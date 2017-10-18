$(function(){
    
   

    $(".libelleDomaine").click(function(){
        var titre = $(this).text();
        $(this).closest("div").children(".titreGraphe").text(titre);
        
        var ui = $(this).attr("id").split("-")[0];
        var ceDomaine = $(this).attr("id").split("-")[1].toLowerCase();
        var lienGraph = "#graph-" + ui;
        $.post("API/getStats.php", {ui:ui}, function(data){
             var stats = JSON.parse(data);
            var ser_stat = [];
            var lab_stat = [];
            
            for(var i = 0; i < stats.length;i++){
                switch(ceDomaine)
                {
                    case "client":  ser_stat.push(stats[i].client);
                        break;
                    case "dissi":  ser_stat.push(stats[i].dissi);
                        break;
                    case "immo":  ser_stat.push(stats[i].immo);
                        break;
                    case "focu":  ser_stat.push(stats[i].focu);
                        break;
                    case "coordi":  ser_stat.push(stats[i].coordi);
                        break;
                }
               date_stat = stats[i].date;
               var jour = new Date(date_stat);
               jour = jour.getDate()+"/"+ (jour.getMonth() + 1);
               lab_stat.push(jour);

            }
            var chart = new Chartist.Line(lienGraph, {
                labels: lab_stat,
                series: [
                    ser_stat
                ]
              }, {
                low: 0,
                high:100,
                width:228,
                height:150,
                fullWidth:true,
                showPoint:false,
                showArea: true,
              });
              chart.on('draw', function(data) {
                if(data.type === 'line' || data.type === 'area') {
                  data.element.animate({
                    d: {
                      begin: 2000 * data.index,
                      dur: 3000,
                      from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                      to: data.path.clone().stringify(),
                      easing: Chartist.Svg.Easing.easeOutQuint
                    }
                  });
                }
              });
        });
    });
    
    $(".tableStatTitle h4").click(function(){
        $(this).closest("div").children(".titreGraphe").text("Global");
        
        var ui = $(this).attr("id").split("-")[1];
        var lienGraph = "#graph-" + ui;
        $.post("API/getStats.php", {ui:ui}, function(data){
             var stats = JSON.parse(data);
            var ser_stat = [];
            var lab_stat = [];

            for(var i = 0; i < stats.length;i++){
               ser_stat.push(stats[i].globale);
               date_stat = stats[i].date;
               var jour = new Date(date_stat);
               jour = jour.getDate()+"/"+ (jour.getMonth() + 1);
               lab_stat.push(jour);

            }
            
            
            var chart = new Chartist.Line(lienGraph, {
                labels: lab_stat,
                series: [
                    ser_stat
                ]
              }, {
                low: 0,
                high:100,
                width:228,
                height:150,
                fullWidth:true,
                showPoint:false,
                showArea: true,
              });
              chart.on('draw', function(data) {
                if(data.type === 'line' || data.type === 'area') {
                  data.element.animate({
                    d: {
                      begin: 2000 * data.index,
                      dur: 3000,
                      from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                      to: data.path.clone().stringify(),
                      easing: Chartist.Svg.Easing.easeOutQuint
                    }
                  });
                }
              });
        });
    });
    
    $("#right-scroll").click(function(){
        var px = $("#allTableStat").css("margin-left")
        if($("#allTableStat").css("margin-left") == '0px'){
            
            $("#allTableStat").animate({marginLeft: "-=550px"},600);
        }
       
    });
    $("#left-scroll").click(function(){
        var px = $("#allTableStat").css("margin-left")
        if($("#allTableStat").css("margin-left") == '-550px'){
            $("#allTableStat").animate({marginLeft: "+=550px"},600);
        }
       
    });
    $.post("API/getUi.php", {}, function(data){
        var listeUi = JSON.parse(data);
   
    // $.post("API/getStats.php",function(data){
    //     var stats = JSON.parse(data);
    // })    
    
    $(".btn_detail").click(function(e){
        
        
        if($(".btn_detail").hasClass("btn_detail_active")){
                $(this).removeClass("btn_detail_active");
                $(this).addClass("btn_detail_disable");
                $(this).text("Plus de détail ");
                //$(".listeTableUi").css({borderTopColor:"#2c3e00",borderRightColor:"#2c3e00",borderLeftColor:"#2c3e00",borderBottomColor:"#2c3e00"});
                $("#listeStatsUi h4").fadeIn();
                $(".graphStat").html("");
                $(".graphStat").css({display:"none"});
                $(".tableStatDomaine").css({display:"none"});
                $(".tableStatTitle").css({display:"none"});
                $(".listeTableUi").css({display:"none"});
                $("#right-scroll").css({display:"none"});
                $("#left-scroll").css({display:"none"});
               $("#statsUi").css({height:"45px"});
        }
        else
        {
            $(this).prop("disabled",true);
            $(this).removeClass("btn_detail_disable");
            $(this).addClass("btn_detail_active");
            $(this).text("Fermer le détail ");
            if($("#statsUi").css("height")!='580px'){
                
                e.preventDefault();
                e.stopPropagation();
                $("#statsUi").stop().animate({height: "580px"}, 500, function(){
                    
                    $("#listeStatsUi h4").fadeOut();
                        $("#listeTableauxUi").show();
                        $("#right-scroll").show();
                        $("#left-scroll").show();
                        $(".listeTableUi").delay(500).show();
                        $(".listeTableUi").css({ borderTopColor: '#2c3e50', borderLeftColor: '#2c3e50', borderRightColor: '#2c3e50', borderBottomColor: '#2c3e50' });
                        $(".listeTableUi").stop().animate({ borderTopColor: '#f7f9f8', borderLeftColor: '#f7f9f8', borderRightColor: '#f7f9f8', borderBottomColor: '#f7f9f8' }, 2000);
                        $(".tableStatTitle").fadeIn();
                            $(".tableStatDomaine").delay(500).fadeIn();
                                $(".graphStat").delay(500).fadeIn();
                                    
                                    listeUi.forEach(function(ui){
                                        var lienGraph = "#graph-" + ui;
                                        $.post("API/getStats.php", {ui:ui}, function(data){
                                             var stats = JSON.parse(data);
                                            var ser_stat = [];
                                            var lab_stat = [];
                            
                                            for(var i = 0; i < stats.length;i++){
                                               ser_stat.push(stats[i].globale);
                                               date_stat = stats[i].date;
                                               var jour = new Date(date_stat);
                                               jour = jour.getDate()+"/"+ (jour.getMonth() + 1);
                                               lab_stat.push(jour);
                                            
                                            }
                                            var chart = new Chartist.Line(lienGraph, {
                                                labels: lab_stat,
                                                series: [
                                                    ser_stat
                                                ]
                                              }, {
                                                low: 0,
                                                high:100,
                                                width:228,
                                                height:150,
                                                fullWidth:true,
                                                showPoint:false,
                                                showArea: true,
                                              });
                                              chart.on('draw', function(data) {
                                                if(data.type === 'line' || data.type === 'area') {
                                                  data.element.animate({
                                                    d: {
                                                      begin: 2000 * data.index,
                                                      dur: 3000,
                                                      from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                                                      to: data.path.clone().stringify(),
                                                      easing: Chartist.Svg.Easing.easeOutQuint
                                                    }
                                                  });
                                                }
                                              });
                                        });
                                        
                                       
                                        
                                    
                                    });
                                     
                                      $(".btn_detail").prop("disabled",false);
                               

                            
                        
                });
            }
        }
        
        
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

  //  $(".checkboxFiltre").prop("checked", true);

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
    $("#divSousJustifs div").each(function(i, elt){
        if($(this).is(getCheckedUiJoined) && $(this).is(getCheckedDomaineJoined) && $(this).is(getCheckedSousDomaineJoined))
        {
            var appartient = false;
            //$.post("API/getSousDomainesAndDomainesAndUiBySousJustif.php", {sous_justif: });
            var cetElt = $(this);
            elt.classList.forEach(function(uneClasse){
                var ceTableau = uneClasse.split("-");
                if(ceTableau.length == 3 && uneClasse != "col-lg-1")
                    {
                        if(getCheckedUi.indexOf(".ui-" + ceTableau[0]) != -1 && getCheckedDomaine.indexOf(".domaine-" + ceTableau[1]) != -1 && getCheckedSousDomaine.indexOf(".sousDomaine-" + ceTableau[2]) != -1)
                            {
                                appartient = true;
                                $(elt).show();
                            }
                    }
            });
            if(!appartient)
                {
                    $(this).hide();
                }
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
          //  $("#badge-alerte").text($(".alerte").length/2);
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
                if(!divSousJustif.hasClass(elt.ui + "-" + elt.domaine + "-" + elt.sous_domaine))
                {
                    divSousJustif.addClass(elt.ui + "-" + elt.domaine + "-" + elt.sous_domaine);
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
                $(this).removeClass().addClass("btn btn-primary");
                
                $.post("API/getAlertesUi.php", {liste_ui: getCheckedUi}, function(data){
                    $("#tableau").load("tableau.php", {liste_poi: data, alerte: true}, function(){
                        $("#imageLoad").hide();
                        $("#tableau").show();
                       // $("#badge-alerte").text($(".alerte").length/2);
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
});