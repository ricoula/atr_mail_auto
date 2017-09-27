$(function(){

    $("#tablePoi").tablesorter();

    $("input:checkbox").prop("checked", true);

    $("input:checkbox").change(function(){
        var nbUiCoche = 0;
        $(".checkboxUi").each(function(){
            if($(this).prop("checked") == true)
            {
                nbUiCoche++;
            }
        });
        if(nbUiCoche == 1)
        {
            $("#divSousJustifs").show();
        }
        else
        {
            $("#divSousJustifs").hide();
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
    console.log(getCheckedUiJoined);
   console.log(getCheckedDomaineJoined);
   console.log(getCheckedSousDomaineJoined);
   console.log(getCheckedSJJoined);
 
    // $(".divFiltre").hide();

    // $("input:checkbox").each(function(){
    //     if($(this).prop("checked") == true)
    //     {
    //         $("." + $(this).attr("id")).show();
    //         console.log($(this).attr("id"));
    //     }
    // });
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
});