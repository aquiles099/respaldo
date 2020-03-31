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
        <select class ="form-control" type="text" id="typeServiceMaritime_shipment" name="typeServiceMaritime_shipment">
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
        <select class ="form-control" type="text" id="typeTransportMaritime_shipment" name="typeTransportMaritime_shipment">
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
        <select class ="form-control" type="text" id="typeRouteMaritime_shipment" name="typeRouteMaritime_shipment">
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
        <select class ="form-control" type="text" id="preTransportMaritime_shipment" name="preTransportMaritime_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($transporters as $key => $value)
            <option item="{{$value->toJson()}}"value ="{{$value->id}}">{{$value->code}} {{$value->name}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'preTransportMaritime_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'preTransportPlaceMaritime_shipment'])">
        <label for="preTransportPlaceMaritime_shipment">{{trans('shipment.pretransportPlace')}}</label>
        <select class ="form-control" type="text" id="preTransportPlaceMaritime_shipment" name="preTransportPlaceMaritime_shipment">
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
        <select class ="form-control" type="text" id="portMaritime_shipment" name="portMaritime_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
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
        <select class ="form-control" type="text" id="carrierExportMaritime_shipment" name="carrierExportMaritime_shipment">
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
        <select class ="form-control" type="text" id="vesselMaritime_shipment" name="vesselMaritime_shipment">
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
        <select class ="form-control" type="text" id="downloadPortMaritime_shipment" name="downloadPortMaritime_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
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
        <select class ="form-control" type="text" id="carrierDeliverMaritime_shipment" name="carrierDeliverMaritime_shipment">
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
        <select class ="form-control" type="text" id="placeDeliverMaritime_shipment" name="placeDeliverMaritime_shipment">
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
