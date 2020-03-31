$(document).ready(function() {
  $('#dtble').DataTable({
    "order": [
      [ 0, "desc" ]
    ]
  });
});
/**
* Ver informacion de usuarios
*/
var showClient = function (id) {
  var path = window.location.origin + AUX_PATH +`/admin/user/`+ id +`/view`;
  bootbox.dialog({
    title: "<span>Detalles</span>",
    message: $('#load').load(path, function ()
    {

    }),
    size: "large"
  })
  .on('shown.bs.modal', function ()
  {
    $('#load').show();
  })
  .on('hide.bs.modal', function (e)
  {
    $('#load').hide().appendTo('body');
  })
  .modal('show');
}
/**
* Ver informacion de paquetes
*/
var detailspackage = function (id) {
  var path = `${window.location.origin}`+ AUX_PATH + `/admin/package/showpackage/`+id;
  bootbox.dialog ({
    title: "<span id='tltgnif'>Información</span>",
    message: $('#load').load(path, function ()
    {
      $('#packevnt').hide();
      $('#packinvo').hide();
    }),
    size: "large"
  })
  .on('shown.bs.modal', function ()
  {
    $('#load').show();
  })
  .on('hide.bs.modal', function (e)
  {
    $('#load').hide().appendTo('body');
  })
  .modal('show');
}
/**
* Ver informacion de compañia
*/
var detailscompany = function (id) {
  var path = `${window.location.origin}`+ AUX_PATH + `/admin/company/`+ id +`/read`;
  bootbox.dialog({
    title: "<span id='tltgnif'>Información</span>",
    message: $('#load').load(path, function ()
    {
      $('#hdprovs').hide();
    }),
    size: "large"
  })
  .on('shown.bs.modal', function ()
  {
    $('#load').show();
  })
  .on('hide.bs.modal', function (e)
  {
    $('#load').hide().appendTo('body');
  })
  .modal('show');
}
/**
* ver informacion de servicios
*/
var detailsservice = function (id) {
    var path = `${window.location.origin}`+ AUX_PATH + `/admin/service/`+ id +`/read`;
    bootbox.dialog ({
      title: "<span id='tltgnif'>Información</span>",
      message: $('#load').load(path, function ()
      {

      }),
      size: "large"
    })
    .on('shown.bs.modal', function ()
    {
      $('#load').show();
    })
    .on('hide.bs.modal', function (e)
    {
      $('#load').hide().appendTo('body');
    })
    .modal('show');
}
/**
* ver informacion de categorias
*/
var detailscategory = function (id) {
  var path = `${window.location.origin}`+ AUX_PATH + `/admin/category/`+ id +`/read`;
  bootbox.dialog({
    title: "<span id='tltgnif'>Información</span>",
    message: $('#load').load(path, function ()
    {

    }),
    size: "large"
  })
  .on('shown.bs.modal', function ()
  {
    $('#load').show();
  })
  .on('hide.bs.modal', function (e)
  {
    $('#load').hide().appendTo('body');
  })
  .modal('show');
}
/**
* ver informacion de promociones
*/
var detailspromotions = function (id) {
  var path = `${window.location.origin}`+ AUX_PATH + `/admin/promotions/`+ id +`/view`;
  bootbox.dialog({
    title: "<span id='tltgnif'>Información</span>",
    message: $('#load').load(path, function ()
    {

    }),
    size: "large"
  })
  .on('shown.bs.modal', function ()
  {
    $('#load').show();
  })
  .on('hide.bs.modal', function (e)
  {
    $('#load').hide().appendTo('body');
  })
  .modal('show');
}
/**
* ver informacion de promociones
*/
var detailstax = function (id) {
   var path = `${window.location.origin}`+ AUX_PATH + `/admin/tax/`+ id +`/view`;
   bootbox.dialog ({
     title: "<span id='tltgnif'>Información</span>",
     message: $('#load').load(path, function ()
     {

     }),
     size: "large"
   })
   .on('shown.bs.modal', function ()
   {
     $('#load').show();
   })
   .on('hide.bs.modal', function (e)
   {
     $('#load').hide().appendTo('body');
   })
   .modal('show');
}
