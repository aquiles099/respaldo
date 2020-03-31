/**
 *
 */

 $(document).ready( function() {
  //  if (messages.language == 'en') {
  //    $('#dtble').DataTable( {
  //      "language": {
  //        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json"
  //      }
  //    } );
  //    $('#dataTableSearch').attr('placeholder','Search...');
  //    $('#dtble_next').html('Next');
  //    $('#dtble_previous').html('Previous');
  //    $('.dataTables_empty').html('No data to show...');
  //  }else {
  //    $('#dtble').DataTable({
  //      "order": [
  //        [ 0, "desc" ]
  //      ]
  //    });
  //  }
  /**
   *
   */
    $('#ics_vessel_country').select2().on('select2:select', function(e) {
      var elemento = eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')');
      icsLoadSelect(elemento.id);
  });
  $('#payments_term_coin').select2();
  $('#payments_term_coin').select2();
   /**
   *
   */
    $('#ics_vessel_country2').select2().on('select2:select', function(e) {
      var elemento = eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')');
      icsLoadSelect2(elemento.id);
  });
   /**
   *
   */
   initDropzone();
   /**
   *
   */
 });

 var createLoad = function ()
 {
   var wait = (messages.language == 'es') ? 'Espere...':'Wait...';
   $('#divButton').attr('disabled','true');
   $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> "+wait+"</button>");
 }
 function loadButton(element) {
   var wait = (messages.language == 'es') ? 'Espere...':'Wait...';

  $(element).attr('disabled','true');
  $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> '+wait);
 }
/**
 *
 */
var icsLoadSelect = function (country) {
  var url = window.location.origin + AUX_PATH + '/admin/vessels/new/' + country + '/city';
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    data: country,
    beforeSend: function () {
      $('#ics_load_vessel_city').html("<i class='fa fa-spin fa-spinner'></i>");
    },
    success: function (json) {
      if (Object.keys(json).length > 0) {
         icsSetDataLoadSelect(json.message);
      }else {
        console.log('no hay elementos');
      }
    },
    error: function ()
    {
      log('no se ha cargado' + url);
    },
    complete: function() {
    $('#ics_load_vessel_city').html("");
    }
  });
}
/**
*
*/
var icsSetDataLoadSelect = function (json) {
  /**
  *
  */
  $('#ics_vessel_city').empty();
  /**
  *
  */
  $.each(json, function(i, item){
    $('#ics_vessel_city').append(new Option((json[i].name), (json[i].id), true, true));
  });
}

var icsLoadSelect2 = function (country) {
  var url = window.location.origin + AUX_PATH + '/admin/vessels/new/' + country + '/city';
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    data: country,
    beforeSend: function () {
      $('#ics_load_vessel_city2').html("<i class='fa fa-spin fa-spinner'></i>");
    },
    success: function (json) {
      if (Object.keys(json).length > 0) {
         icsSetDataLoadSelect2(json.message);
      }else {
        console.log('no hay elementos');
      }
    },
    error: function ()
    {
      log('no se ha cargado' + url);
    },
    complete: function() {
    $('#ics_load_vessel_city2').html("");
    }
  });
}
/**
*
*/
var icsSetDataLoadSelect2 = function (json) {
  /**
  *
  */
  $('#ics_vessel_city2').empty();
  /**
  *
  */
  $.each(json, function(i, item){
    $('#ics_vessel_city2').append(new Option((json[i].name), (json[i].id), true, true));
  });
}

function searchOffice() {
  try {
    var search = $('#search').val().trim();
    if(search !== undefined && search !== '') {
      window.location = `${window.location.origin}${window.location.pathname}?search=${search}`;
    }
  } catch(e) {

  }
}
/**
 *
 */
function supplierDelete(element, from) {
  try {
    var supplier = getItem(element) || getItemFromParent(element);
    if(supplier != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/suppliers/${supplier.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
/**
*
*/
var initDropzone = function(){
  Dropzone.options.myDropzone = {
    // Prevents Dropzone from uploading dropped files immediately
    autoProcessQueue: false,
    uploadMultiple:true,
    maxFilesize:10,
    maxFiles:2,
    init: function() {
      var submitButton = document.querySelector("#submit-all")
          myDropzone = this;

      submitButton.addEventListener("click", function(e) {
        e.preventDefault();
        e.stopPropagation();
        myDropzone.processQueue();
      });
      /**
      *
      */
      this.on("addedfile", function() {
        // Show submit button here and/or inform user to click it.
      });
      /**
      *
      */
      this.on("complete", function(file) {
            myDropzone.removeFile(file);
        });
      /**
      *
      */
      this.on("success",
          myDropzone.processQueue.bind(myDropzone)
      );
    }
  };
}

var countimg=0;
function preview_image()
{
 var res=countimg+1;
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {
   var del = (messages.language == 'es') ? 'Eliminar':'Delete';
   $('#image_preview').append("<div class='preview' id='prev"+res+"'><div class='divimg'><img class='thumbnailp' src='"+URL.createObjectURL(event.target.files[i])+"'></div><a class='removeimg' onclick=remove_preview('prev"+res+"')>"+del+"</a>");
 }
}

function remove_preview(id){
  $('#'+id).remove();
}
