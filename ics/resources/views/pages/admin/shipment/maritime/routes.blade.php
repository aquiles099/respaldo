<script type="text/javascript">
$(document).ready(function(){
  $('select').select2({
       width: '100%'
  }).on('select2:select', function(e){
    if ($(e.currentTarget).attr('id') == 'portMaritime_shipment') {
      if($(e.currentTarget).find('option:selected').attr('value')=='new'){
        detailstransport(1,'true');
      }
    }
    if ($(e.currentTarget).attr('id') == 'downloadPortMaritime_shipment') {
      if($(e.currentTarget).find('option:selected').attr('value')=='new'){
        detailstransport(1,'true');
      }
    }
});

});
/**
* Enviar datos del puerto que se desea crear
*/
var icsAddPort = function (transport) {
  var root = window.location.origin;
  if (root == 'http://localhost') {
    root += "/ics-app-version-2.0/public";
  }
  var path  = root + "/admin/transport/"+ transport + "/edit";
  var data =  $('#formSerial').serialize();

  $.ajax({
    url: path,
    type: 'POST',
    dataType: 'json',
    data: data,
    beforeSend: function () {

    },
    success: function (json) {
      json.message == 'true' ? icsLoadBackPort (alert = true, transport) : evalJson (json.alert)
    },
    error:function (e){
      bootbox.alert('Ha ocurrido un error');
    }
  });
}
/**
* Se carga el formulario para crear un nuevo puerto asociado a un tipo de transporte
*/
var icsLoadPortForm = function (transport) {
  var root = window.location.origin;
  if (root == 'http://localhost') {
    root += "/ics-app-version-2.0/public";
  }
  var path  = root + "/admin/transport/" + transport + "/edit";
  $('#tltgnif').html('Nuevo');

  $('#load').load(path, function () {
      $('#bckic').show();
      $('[data-toggle="tooltip"]').tooltip();
  });
}
var detailstransport = function (id, open) {
  var root = window.location.origin;
  if (root == 'http://localhost') {
    root += "/ics-app-version-2.0/public";
  }
  var path  = root + "/admin/transport/" + id + "/read";
  if (open == 'true') {
    var sw    = 0;
    var alert = false;
    bootbox.dialog({
    title: "<a href='javascript:icsLoadBackPort(false,"+id+")' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><span id='tltgnif'>Información</span>",
    message: "<div id='load'></div>",
    size:"large",
    backdrop: true,
    onEscape: function() { },
    }).on('shown.bs.modal', function () {
      $('#load').show();
    })
    .on('hide.bs.modal', function (e) {
      $('#load').hide().appendTo('body');
      reloadPortSelect();
    })
    .modal('show');
      $('#load').load(path, function() {
          $('#dtble2').dataTable();
          $('[data-toggle="tooltip"]').tooltip();
      })
  }
  else {
     $('#load').load(path, function() {});
  }
}
var icsLoadBackPort = function (alert, transport) {
  var root = window.location.origin;
  if (root == 'http://localhost') {
    root += "/ics-app-version-2.0/public";
  }
  var path  = root + "/admin/transport/"  + transport + "/read";
  $('#tltgnif').html('Informacion');

  $('#load').load(path, function () {
      $('#bckic').hide();
      $('[data-toggle="tooltip"]').tooltip();
      $('#dtble2').dataTable();
      showAlertInLoadBack(alert);
  });
}

var reloadPortSelect = function(){
  var root = window.location.origin;
  if (root == 'http://localhost') {
    root += "/ics-app-version-2.0/public";
  }
  var path  = root + "/admin/transport/get";
  var data =  $('#formSerial').serialize();
  $.ajax({
    url: path,
    type: 'GET',
    dataType: 'json',
    data: data,
    beforeSend: function () {
      $('#portMaritime_shipment').html('');
        $('#portMaritime_shipment').append("<option  value='new'>Espere...</option>");
    },
    success: function (json) {
      if (json.message == 'true') {
        $('#portMaritime_shipment').html('');
        $('#portMaritime_shipment').append("<option  value='0'>Seleccione una Opcion</option>");
        $('#portMaritime_shipment').append("<option  value='new'>Agregar puerto</option>");

        $('#downloadPortMaritime_shipment').html('');
        $('#downloadPortMaritime_shipment').append("<option  value='0'>Seleccione una Opcion</option>");
        $('#downloadPortMaritime_shipment').append("<option  value='new'>Agregar puerto</option>");

        $.each(json.ports, function(key, element) {
          $('#portMaritime_shipment').append("<option  value='" + element.id + "'>" +" "+ element.name+" </option>");
          $('#downloadPortMaritime_shipment').append("<option  value='" + element.id + "'>" +" "+ element.name+" </option>");
        });
      }
    },
    error:function (e){
      bootbox.alert('Ha ocurrido un error');
    }
  });
}

</script>

<!--Maritimo-->
<fieldset class="form">
  <!--Servicio-->
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb">{{trans('shipment.serviceInfo')}}</div>
    </div>
  </div>
  <!---->
  <div class="row">
    <!--tipo de servicio-->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'typeServiceMaritime_shipment'])">
        <label for="typeServiceMaritime_shipment">{{trans('shipment.serviceType')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="typeServiceMaritime_shipment" name="typeServiceMaritime_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($typeService as $key => $value)
            <option {{(isset($shipment_route) && $shipment_route['service_type'] == $value['id']) ? 'selected' : ''}} item="{{json_encode($value)}}" value="{{$value['id']}}">{{$value['text']}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'typeServiceMaritime_shipment'])
      </div>
    </div>
    <!--tipo de transporte-->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'typeTransportMaritime_shipment'])">
        <label for="typeTransportMaritime_shipment">{{trans('shipment.transportType')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="typeTransportMaritime_shipment" name="typeTransportMaritime_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($typeTransport as $key => $value)
            <option {{(isset($shipment_route) && $shipment_route->transport_type == $value->id) ? 'selected' : ''}} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->toOption()['text']}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'typeTransportMaritime_shipment'])
      </div>
    </div>
    <!--route-->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'typeRouteMaritime_shipment'])">
        <label for="typeRouteMaritime_shipment">{{trans('shipment.route')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="typeRouteMaritime_shipment" name="typeRouteMaritime_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
            @foreach($route as $key => $value)
              <option {{(isset($shipment_route) && $shipment_route->route == $value->id) ? 'selected' : ''}} item ="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->name}}</option>
            @endforeach
          </select>
        @include('errors.field', ['field' => 'typeRouteMaritime_shipment'])
      </div>
    </div>
  </div>
</fieldset>
<!---->
<fieldset class="form">
  <!--Servicio-->
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb">{{trans('shipment.originInfo')}}</div>
    </div>
  </div>
  <!---->
  <div class="row">
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'originPointMaritime_shipment'])">
        <label for="originPointMaritime_shipment">{{trans('shipment.originPoint')}}</label>
        <input class ="form-control" type="text" id="originPointMaritime_shipment" name="originPointMaritime_shipment" placeholder="{{trans('shipment.originPoint')}}" value="{{isset($shipment_route) ? $shipment_route->origin_point : ''}}">
        @include('errors.field', ['field' => 'originPointMaritime_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'preTransportMaritime_shipment'])">
        <label for="preTransportMaritime_shipment">{{trans('shipment.preTransport')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="preTransportMaritime_shipment" name="preTransportMaritime_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($transporters as $key => $value)
            <option {{isset($shipment_detail) ? ($shipment_detail==$value->id) ? 'selected' : '' : ''}} item="{{$value->toJson()}}"value ="{{$value->id}}">{{$value->code}} {{$value->name}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'preTransportMaritime_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'preTransportPlaceMaritime_shipment'])">
        <label for="preTransportPlaceMaritime_shipment">{{trans('shipment.pretransportPlace')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="preTransportPlaceMaritime_shipment" name="preTransportPlaceMaritime_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($transporters as $key => $value)
            <option item="{{$value->toJson()}}"value ="{{$value->id}}">{{$value->code}} {{$value->name}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'preTransportPlaceMaritime_shipment'])
      </div>
    </div>
  </div>
</fieldset>
<!---->
<fieldset class="form">
  <!---->
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb">{{trans('shipment.exportInfo')}}</div>
    </div>
  </div>
  <!---->
  <div class="row">
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'dockMaritime_shipment'])">
        <label for="dockMaritime_shipment">{{trans('shipment.dockOrTerminal')}}</label>
        <input class ="form-control" type="text" id="dockMaritime_shipment" name="dockMaritime_shipment" placeholder="{{trans('shipment.dockOrTerminal')}}" value="{{isset($shipment_route) ? $shipment_route->dock_terminal : ''}}">
        @include('errors.field', ['field' => 'dockMaritime_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'portMaritime_shipment'])">
        <label for="portMaritime_shipment">{{trans('shipment.port')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="portMaritime_shipment" name="portMaritime_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          <option value="new">Agregar Puerto</option>
          @foreach($ports as $key => $value)
            <option {{(isset($shipment_route) && $shipment_route->port == $value->id) ? 'selected' : ''}} item="{{$value}}" value="{{$value->id}}">{{$value->toOption()['text']}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'portMaritime_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'carrierExportMaritime_shipment'])">
        <label for="carrierExportMaritime_shipment">{{trans('shipment.carrrierExport')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="carrierExportMaritime_shipment" name="carrierExportMaritime_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($transporters as $key => $value)
            <option {{(isset($shipment_route) && $shipment_route->export_transporter == $value->id) ? 'selected' : ''}} item="{{$value->toJson()}}"value ="{{$value->id}}">{{$value->code}} {{$value->name}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'carrierExportMaritime_shipment'])
      </div>
    </div>
  </div>
  <!---->
  <div class="row">
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'travelIdentifierMaritime_shipment'])">
        <label for="travelIdentifierMaritime_shipment">{{trans('shipment.traverIdentifier')}}</label>
        <input class ="form-control" type="text" id="travelIdentifierMaritime_shipment" name="travelIdentifierMaritime_shipment" placeholder="{{trans('shipment.traverIdentifier')}}" value="{{isset($shipment_route) ? $shipment_route->travel_identifier : ''}}">
        @include('errors.field', ['field' => 'travelIdentifierMaritime_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'vesselMaritime_shipment'])">
        <label for="vesselMaritime_shipment">{{trans('shipment.vessel')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="vesselMaritime_shipment" name="vesselMaritime_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
           @foreach($vessel as $key => $value)
            <option {{(isset($shipment_route) && $shipment_route->vessel == $value->id) ? 'selected' : ''}} item ="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->code}} {{$value->name}}</option>
           @endforeach
        </select>
        @include('errors.field', ['field' => 'vesselMaritime_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'vesselFlagMaritime_shipment'])">
        <label for="vesselFlagMaritime_shipment">{{trans('shipment.vesselFlag')}}</label>
        <input class ="form-control" type="text" id="vesselFlagMaritime_shipment" name="vesselFlagMaritime_shipment" placeholder="{{trans('shipment.vesselFlag')}}" value="{{isset($shipment_route) ? $shipment_route->vessel_flag : ''}}">
        @include('errors.field', ['field' => 'vesselFlagMaritime_shipment'])
      </div>
    </div>
  </div>
</fieldset>
<!---->
<fieldset class="form">
  <!---->
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb">{{trans('shipment.arrivedInfo')}}</div>
    </div>
  </div>
  <!---->
  <div class="row">
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'downloadPortMaritime_shipment'])">
        <label for="downloadPortMaritime_shipment">{{trans('shipment.downloadPort')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="downloadPortMaritime_shipment" name="downloadPortMaritime_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          <option value="new">Agregar Puerto</option>
          @foreach($ports as $key => $value)
            <option {{(isset($shipment_route) && $shipment_route->download_port == $value->id) ? 'selected' : ''}} item="{{$value}}" value="{{$value->id}}">{{$value->toOption()['text']}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'downloadPortMaritime_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'carrierDeliverMaritime_shipment'])">
        <label for="carrierDeliverMaritime_shipment">{{trans('shipment.carrierDeliver')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="carrierDeliverMaritime_shipment" name="carrierDeliverMaritime_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($transporters as $key => $value)
            <option {{(isset($shipment_route) && $shipment_route->deliver_transporter == $value->id) ? 'selected' : ''}} item="{{$value->toJson()}}"value ="{{$value->id}}">{{$value->code}} {{$value->name}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'carrierDeliverMaritime_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'placeDeliverMaritime_shipment'])">
        <label for="placeDeliverMaritime_shipment">{{trans('shipment.placeDeliver')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="placeDeliverMaritime_shipment" name="placeDeliverMaritime_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($cities as $key => $value)
            <option {{(isset($shipment_route) && $shipment_route->deliver_city_place == $value->id) ? 'selected' : ''}} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->toOption()['text']}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'placeDeliverMaritime_shipment'])
      </div>
    </div>
  </div>
</fieldset>
