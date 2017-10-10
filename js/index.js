$(function(){
    $("#right-scroll").click(function(){
        var px = $("#allTableStat").css("margin-left")
        console.log(px);
        if($("#allTableStat").css("margin-left") == '0px'){
            
            $("#allTableStat").animate({marginLeft: "-=550px"},600);
        }
       
    });
    $("#left-scroll").click(function(){
        var px = $("#allTableStat").css("margin-left")
        console.log(px);
        if($("#allTableStat").css("margin-left") == '-550px'){
            $("#allTableStat").animate({marginLeft: "+=550px"},600);
        }
       
    });
    $.post("API/getUi.php", {}, function(data){
        var listeUi = JSON.parse(data);
        console.log("startf");
   
    // $.post("API/getStats.php",function(data){
    //     var stats = JSON.parse(data);
    // })    
    
    $(".btn_detail").click(function(e){
        console.log("click");
        if($(".btn_detail").hasClass("btn_detail_active")){
            console.log("if");
                $(this).removeClass("btn_detail_active");
                console.log("remove active");
                $(this).addClass("btn_detail_disable");
                console.log("add disable");
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
               console.log("ferme");
        }
        else
        {
            console.log("else");
            $(this).prop("disabled",true);
            $(this).removeClass("btn_detail_disable");
            console.log("remove disable");
            $(this).addClass("btn_detail_active");
            console.log("add active active");
            $(this).text("Fermer le détail ");
            console.log("ouvrir");
            if($("#statsUi").css("height")!='580px'){
                
                e.preventDefault();
                e.stopPropagation();
                $("#statsUi").stop().animate({height: "580px"}, 500, function(){
                    
                    $("#listeStatsUi h4").fadeOut();
                        console.log("CECI EST UN TEST");
                        $("#listeTableauxUi").show();
                        $("#right-scroll").show();
                        $("#left-scroll").show();
                        $(".listeTableUi").delay(500).show();
                        $(".listeTableUi").css({ borderTopColor: '#2c3e50', borderLeftColor: '#2c3e50', borderRightColor: '#2c3e50', borderBottomColor: '#2c3e50' });
                        $(".listeTableUi").stop().animate({ borderTopColor: '#f7f9f8', borderLeftColor: '#f7f9f8', borderRightColor: '#f7f9f8', borderBottomColor: '#f7f9f8' }, 2000);
                        console.log("te");
                        $(".tableStatTitle").fadeIn();
                            console.log("nbtablestat");
                            $(".tableStatDomaine").delay(500).fadeIn();
                                console.log("nbtabledom");
                                $(".graphStat").delay(500).fadeIn();
                                    
                                    
                                    listeUi.forEach(function(ui){
                                        console.log("graph")
                                        var lienGraph = "#graph-" + ui;
                                        $.post("API/getStats.php", {ui:ui}, function(data){
                                             var stats = JSON.parse(data);
                                            var ser_stat = [];
                                            var lab_stat = [];
                            
                                            
                                            for(var i = 0; i < stats.length;i++){
                                               ser_stat.push(stats[i].globale);
                                               date_stat = stats[i].date;
                                               console.log(date_stat);
                                               var jour = new Date(date_stat);
                                               jour = jour.getDate()+"/"+ (jour.getMonth() + 1);
                                               console.log(jour);
                                               lab_stat.push(jour);
                                            
                                            }
                                            console.log(lab_stat);
                                       
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
});