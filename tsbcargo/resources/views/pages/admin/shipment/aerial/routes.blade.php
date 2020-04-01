<!---->
<script type="text/javascript">
$(document).ready(function(){
  $('select').select2({
       width: '100%'
  }).on('select2:select', function(e){
    if ($(e.currentTarget).attr('id') == 'from_country_shipment') {
      var option = $(e.currentTarget).find('option:selected').attr('item');
      option = JSON.parse(option);
      item = option.id;
      var url = window.location.origin +'/admin/l/shipments/iata'+'/' + item ;
      $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        beforeSend: function ()
        {
          var loading = (messages.language == 'es') ? 'Cargando...' : 'Loading...';
          $('#fromAerial_shipment').html('');
          $('#fromAerial_shipment').append("<option value=''>"+loading+"</option> ");
        },
        success: function (json)
        {
          if(json.message == true){
            setIataFrom(json.airports);
          }
        },
        error: function (e)
        {
          log(e);
        }
      });
    }
    if ($(e.currentTarget).attr('id') == 'to_country_shipment') {
      var option = $(e.currentTarget).find('option:selected').attr('item');
      option = JSON.parse(option);
      item = option.id;
      var url = window.location.origin +'/admin/l/shipments/iata'+'/' + item ;
      $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        beforeSend: function ()
        {
          var loading = (messages.language == 'es') ? 'Cargando...' : 'Loading...';
          $('#toAerial_shipment').html('');
          $('#toAerial_shipment').append("<option value=''>"+loading+"</option> ");
        },
        success: function (json)
        {
          if(json.message == true){
            setIataTo(json.airports);
          }
        },
        error: function (e)
        {
          log(e);
        }
      });
    }

  });
});

function setIataFrom(code){
  var choose = (messages.language == 'es') ? 'Seleccione' : 'Choose';
  $('#fromAerial_shipment').html('');
  $('#fromAerial_shipment').append("<option value=''>"+choose+"</option> ");

  for (var i = 0; i < code.length; i++) {
    if (code[i].name != null) {
        $('#fromAerial_shipment').append("<option value='"+code[i].id+"' item='"+code[i]+"'>"+code[i].name+"</option> ");
    }
  }
}
function setIataTo(code){
  var choose = (messages.language == 'es') ? 'Seleccione' : 'Choose';
  $('#toAerial_shipment').html('');
  $('#toAerial_shipment').append("<option value=''>"+choose+"</option> ");

  for (var i = 0; i < code.length; i++) {
    if (code[i].name != null) {
        $('#toAerial_shipment').append("<option value='"+code[i].id+"' item='"+code[i]+"'>"+code[i].name+"</option> ");
    }
  }
}
</script>
@include('sections.translate')

<fieldset class="form">
  <!--Servicio-->
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb">{{trans('shipment.serviceInfo')}}</div>
    </div>
  </div>
  <!---->
  <div class="row">
    <!---->
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'typeServiceAerial_shipment'])">
        <label for="typeServiceAerial_shipment">{{trans('shipment.serviceType')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="typeServiceAerial_shipment" name="typeServiceAerial_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($typeService as $key => $value)
            <option {{(isset($shipment_route) && $shipment_route['service_type'] == $value['id']) ? 'selected' : ''}} item="{{json_encode($value)}}" value="{{$value['id']}}">{{$value['text']}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'typeServiceAerial_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'typeTransportAerial_shipment'])">
        <label for="typeTransportAerial_shipment">{{trans('shipment.transportType')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="typeTransportAerial_shipment" name="typeTransportAerial_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($typeTransport as $key => $value)
            <option {{(isset($shipment_route) && $shipment_route->transport_type == $value->id) ? 'selected' : ''}} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{ucwords($value->name)}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'typeTransportAerial_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'typeRouteAerial_shipment'])">
        <label for="typeRouteAerial_shipment">{{trans('shipment.route')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="typeRouteAerial_shipment" name="typeRouteAerial_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($route as $key => $value)
            <option {{(isset($shipment_route) && $shipment_route->route == $value->id) ? 'selected' : ''}} item ="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->name}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'typeRouteAerial_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'numberTrackingAerial_shipment'])">
        <label for="numberTrackingAerial_shipment">{{trans('shipment.flyNumber')}}</label>
        <input class ="form-control" type="text" id="numberTrackingAerial_shipment" name="numberTrackingAerial_shipment" placeholder="{{trans('shipment.flyNumber')}}" value="{{isset($shipment_route) ? $shipment_route->fly_number : ''}}">
        @include('errors.field', ['field' => 'numberTrackingAerial_shipment'])
      </div>
    </div>
  </div>
</fieldset>
<!---->
<fieldset class="form">
  <!--Servicio-->
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb">{{trans('shipment.departureInfo')}}</div>
    </div>
  </div>
  <!---->
  <div class="row">
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'from_country_shipment'])">
        <label for="from_country_shipment">{{trans('shipment.country_ini')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="from_country_shipment" name="from_country_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($countrys as $key => $value)
            <option {{(isset($shipment->from_country) && $shipment->from_country == $value->id) ? 'selected' : ''}} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{ucwords($value->name)}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'from_country_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'fromAerial_shipment'])">
        <label for="fromAerial_shipment">{{trans('shipment.airport_ini')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="fromAerial_shipment" name="fromAerial_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @if(isset($from_airports))
            @foreach($from_airports as $key => $value)
              <option {{(isset($shipment->from_airport) && $shipment->from_airport == $value->id) ? 'selected' : ''}} item="{{$value}}" value="{{$value->id}}">{{ucwords($value->name)}}</option>
            @endforeach
          @endif
        </select>
        @include('errors.field', ['field' => 'fromAerial_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'departureDateAerial_shipment'])">
        <label for="departureDateAerial_shipment">{{trans('shipment.departureDate')}}</label>
        <div class="input-group">
          <input class ="form-control" type="text" id="departureDateAerial_shipment" name="departureDateAerial_shipment" placeholder="{{trans('shipment.departureDate')}}" value ="{{isset($shipment_route) ? $shipment_route->date_city_departure : Input::get('hourDepeartureAerial_shipment')}}">
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        </div>
        @include('errors.field', ['field' => 'departureDateAerial_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'hourDepeartureAerial_shipment'])">
        <label for="hourDepeartureAerial_shipment">{{trans('shipment.departureHour')}}</label>
          <div class="input-group">
            <input class ="form-control" type="text" id="hourDepeartureAerial_shipment" value ="{{isset($shipment_route) ? $shipment_route->hour_city_departure : Input::get('hourDepeartureAerial_shipment')}}" name="hourDepeartureAerial_shipment" placeholder="{{trans('shipment.departureHour')}}">
            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
          </div>
        @include('errors.field', ['field' => 'hourDepeartureAerial_shipment'])
      </div>
    </div>
  </div>
</fieldset>
<!---->
<fieldset class="form">
  <!--Servicio-->
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb">{{trans('shipment.arrivedInfo')}}</div>
    </div>
  </div>
  <!---->
  <div class="row">
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'to_country_shipment'])">
        <label for="to_country_shipment">{{trans('shipment.country_arrive')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="to_country_shipment" name="to_country_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($countrys as $key => $value)
            <option {{(isset($shipment) && $shipment->to_country == $value->id) ? 'selected' : ''}} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{ucwords($value->name)}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'to_country_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'toAerial_shipment'])">
        <label for="toAerial_shipment">{{trans('shipment.airport_arrive')}}</label>
        <select style="width:100%;" class ="form-control" type="text" id="toAerial_shipment" name="toAerial_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @if(isset($to_airports))
              @foreach($to_airports as $key => $value)
                <option {{(isset($shipment->to_airport) && $shipment->to_airport == $value->id) ? 'selected' : ''}} item="{{$value}}" value="{{$value->id}}">{{ucwords($value->name)}}</option>
              @endforeach
          @endif
        </select>
        @include('errors.field', ['field' => 'toAerial_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'arrivedDateAerial_shipment'])">
        <label for="arrivedDateAerial_shipment">{{trans('shipment.arrivedDate')}}</label>
          <div class="input-group">
            <input class ="form-control" type="text" id="arrivedDateAerial_shipment" name="arrivedDateAerial_shipment" value ="{{isset($shipment_route) ? $shipment_route->date_city_arrived : ''}}" placeholder="{{trans('shipment.arrivedDate')}}">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
          </div>
        @include('errors.field', ['field' => 'arrivedDateAerial_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'hourArrivedAerial_shipment'])">
        <label for="hourArrivedAerial_shipment">{{trans('shipment.arrivedHour')}}</label>
          <div class="input-group">
            <input class ="form-control" type="text" id="hourArrivedAerial_shipment" value ="{{isset($shipment_route) ? $shipment_route->hour_city_arrived : ''}}" name="hourArrivedAerial_shipment" placeholder="{{trans('shipment.arrivedHour')}}">
            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
          </div>
        @include('errors.field', ['field' => 'hourArrivedAerial_shipment'])
      </div>
    </div>
  </div>
</fieldset>
