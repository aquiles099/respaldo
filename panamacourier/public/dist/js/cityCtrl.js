"use strict";function loadButton(e){var t="es"==messages.language?"Espere...":"Wait...";$(e).attr("disabled","true"),$(e).html('<i class="fa fa-circle-o-notch fa-spin"></i> '+t)}$(document).ready(function(){var url=window.location.origin+window.location.pathname;console.log(url),$("#dtble").dataTable(),$("select").select2({width:"100%"}).on("select2:select",function(e){var elemento=eval("("+$(e.currentTarget).find("option:selected").attr("item")+")");icsLoadSelect(elemento.id)})});var createLoad=function(){var e="es"==messages.language?"Espere...":"Wait...";$("#divButton").attr("disabled","true"),$("#divButton").html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> "+e+"</button>")},icsLoadSelect=function(e){var t=window.location.origin+window.location.pathname+"/"+e+"/state";$.ajax({url:t,type:"GET",dataType:"json",data:e,beforeSend:function(){},success:function(e){Object.keys(e).length>0?icsSetDataLoadSelect(e.message):console.log("no hay elementos")},error:function(){log("no se ha cargado"+t)},complete:function(){}})},icsSetDataLoadSelect=function(e){$("#ics_city_state").empty(),$.each(e,function(t,o){$("#ics_city_state").append(new Option(e[t].name,e[t].id,!0,!0))})},icsCityDelete=function(element,from){try{var city=getItem(element)||getItemFromParent(element),url=window.location.origin+window.location.pathname+"/"+city.id;void 0!=city&&bootbox.confirm(eval(msg(messages.delete)),function(e){e&&doForm(url,"delete",void 0,void 0===from||from)})}catch(e){log(e)}};