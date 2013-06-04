/* LivIcons v1.2 | (c) 2013 DeeThemes | livicons.com */

$(document).ready(function(){
var restsize = 6200,
    totalsize = 0;

$(".icon input").each(function(){
  var iconsize = $(this).data().size;
  $(this).parent().append('<p class="bytessize">'+iconsize+' bytes</p>');
});

var countChecked = function() {
  var n = $(".icon input:checked").length;
  $(".checkedsummary").text(n + (n === 1 ? " icon is" : " icons are") + " checked.");
  if (n>0) {
    $(".sizesummary").text("The approximate resulting script size: " + Math.round((totalsize + restsize)/1024) + " kB" + " (~" + Math.round((totalsize + restsize)/1024/5+20) + " kB Gziped)");
  } else {
    $(".sizesummary").text("The approximate resulting script size: " + totalsize +" bytes");
  };
};

$(".checkbutton").click(function(){
  if ($(this).val() === "check all") {
    totalsize = 0;
    $(".icon input").prop("checked", true).each(function(){
    iconsize = $(this).data().size;
    totalsize += iconsize;
    }).parent().parent().css("background", "#dfdfdf");
    $(".checkbutton").val("uncheck all");
    countChecked();
  } else {
    $(".icon input").prop("checked", false).parent().parent().css("background", "#fafafa");
    $(".checkbutton").val("check all");
    totalsize = 0;
    countChecked();
  }
});

countChecked();

$(".icon input[type=checkbox]").on("click", countChecked);

$(".icon input").change(function(){
  var c = this.checked ? "#dfdfdf" : "#fafafa";
  var iconsize = $(this).data().size;
  totalsize = this.checked ? totalsize += iconsize : totalsize -= iconsize;
  $(this).parent().parent().css("background", c);
});

$("#defsize").inputCtl({minVal: 1});
$("#morphtime").inputCtl({minVal: 0, step: 10});
$("#hovertime").inputCtl({minVal: 0, step: 10});

$("#defcolor").minicolors({swatchPosition:"right",theme:"bootstrap",defaultValue:"#333333"});
$("#defhovercolor").minicolors({swatchPosition:"right",theme:"bootstrap",defaultValue:"#cccccc"});
$("#defactivecolor").minicolors({swatchPosition:"right",theme:"bootstrap",defaultValue:"#000000"});

$("#result").on("click", function() {
  $("#resultcode").text("");
  var namevalues = $(".icon input:checkbox:checked").map(function () {
  return this.value;
  }).get();

  if (namevalues.length>0) {
    var customdata = {};
    
    for (var i = 0; i < namevalues.length; i++) {
      var temp = namevalues[i];
      customdata[temp] = dataforcustomizer[temp];
    }

    customdata = JSON.stringify(customdata);
    
    var defnamevalue = namevalues[0],
        defsizevalue = $("#defsize").val(),
        defmorphdurationvalue = $("#morphtime").val(),
        defhoverdurationvalue = $("#hovertime").val(),
        defactiveiconclassvalue = $("#activeicon").val(),
        defactiveparentclassvalue = $("#activeparent").val(),
        defactivecolorvalue = $("#defactivecolor").val();

    if ($("input:radio[name=iconcolor]:checked").val()==="original") {
      var defcolorvalue = "original";
    } else{
      var defcolorvalue = $("#defcolor").val();
    };
    if ($("input:radio[name=hoverchange]:checked").val()=="no") {
      var defchangecoloronhovervalue = false;
      var defhovercolorvalue = $("#defcolor").val();
    } else{
      var defchangecoloronhovervalue = true;
      var defhovercolorvalue = $("#defhovercolor").val();
    };
    
    var defanimatedvalue = $("input:radio[name=defanimated]:checked").val(),
        defloopedvalue = $("input:radio[name=deflooped]:checked").val(),
        defeventtypevalue = $("input:radio[name=defeventtype]:checked").val(),
        defonparentvalue = $("input:radio[name=defonparent]:checked").val(),
        restcode = $("#restcode").text();

    $("#resultcode").text(
      ';jQuery(document).ready(function(){var dN="'+defnamevalue+'",dS='+defsizevalue+',dC="'+defcolorvalue+'",dHC="'+defhovercolorvalue+'",dCCOH='+defchangecoloronhovervalue+',dET="'+defeventtypevalue+'",dA='+defanimatedvalue+',dL='+defloopedvalue+',dOP='+defonparentvalue+',mD='+defmorphdurationvalue+',hD='+defhoverdurationvalue+',aC="'+defactiveiconclassvalue+'",aPC="'+defactiveparentclassvalue+'",dAC="'+defactivecolorvalue+'",lDI=JSON.stringify('+customdata+'),'+restcode);
    $("#errinfo").css("display", "none");
    $("#resultinfo").css("display", "block");
  } else {
    $("#errinfo").css("display", "block");
    $("#resultinfo").css("display", "none");
  };

});
});
