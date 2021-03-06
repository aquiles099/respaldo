<!---->
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
        <select class ="form-control" type="text" id="typeServiceAerial_shipment" name="typeServiceAerial_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($typeTransport as $key => $value)
            <option item="{{json_encode($value)}}" value="{{$value['id']}}">{{$value['text']}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'typeServiceAerial_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'typeTransportAerial_shipment'])">
        <label for="typeTransportAerial_shipment">{{trans('shipment.transportType')}}</label>
        <select class ="form-control" type="text" id="typeTransportAerial_shipment" name="typeTransportAerial_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
        </select>
        @include('errors.field', ['field' => 'typeTransportAerial_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'typeRouteAerial_shipment'])">
        <label for="typeRouteAerial_shipment">{{trans('shipment.route')}}</label>
        <select class ="form-control" type="text" id="typeRouteAerial_shipment" name="typeRouteAerial_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($route as $key => $value)
            <option item ="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->name}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'typeRouteAerial_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-3">
      <div class="form-group @include('errors.field-class', ['field' => 'numberTrackingAerial_shipment'])">
        <label for="numberTrackingAerial_shipment">{{trans('shipment.flyNumber')}}</label>
        <input class ="form-control" type="text" id="numberTrackingAerial_shipment" name="numberTrackingAerial_shipment" placeholder="{{trans('shipment.flyNumber')}}">
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
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'fromAerial_shipment'])">
        <label for="fromAerial_shipment">{{trans('shipment.from')}}</label>
        <select class ="form-control" type="text" id="fromAerial_shipment" name="fromAerial_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
        </select>
        @include('errors.field', ['field' => 'fromAerial_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'departureDateAerial_shipment'])">
        <label for="departureDateAerial_shipment">{{trans('shipment.departureDate')}}</label>
        <div class="input-group">
          <input class ="form-control" type="text" id="departureDateAerial_shipment" name="departureDateAerial_shipment" placeholder="{{trans('shipment.departureDate')}}">
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        </div>
        @include('errors.field', ['field' => 'departureDateAerial_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'hourDepeartureAerial_shipment'])">
        <label for="hourDepeartureAerial_shipment">{{trans('shipment.departureHour')}}</label>
          <div class="input-group">
            <input class ="form-control" type="text" id="hourDepeartureAerial_shipment" name="hourDepeartureAerial_shipment" placeholder="{{trans('shipment.departureHour')}}">
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
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'toAerial_shipment'])">
        <label for="toAerial_shipment">{{trans('shipment.to')}}</label>
        <select class ="form-control" type="text" id="toAerial_shipment" name="toAerial_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
        </select>
        @include('errors.field', ['field' => 'toAerial_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'arrivedDateAerial_shipment'])">
        <label for="arrivedDateAerial_shipment">{{trans('shipment.arrivedDate')}}</label>
          <div class="input-group">
            <input class ="form-control" type="text" id="arrivedDateAerial_shipment" name="arrivedDateAerial_shipment" placeholder="{{trans('shipment.arrivedDate')}}">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
          </div>
        @include('errors.field', ['field' => 'arrivedDateAerial_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'hourArrivedAerial_shipment'])">
        <label for="hourArrivedAerial_shipment">{{trans('shipment.arrivedHour')}}</label>
          <div class="input-group">
            <input class ="form-control" type="text" id="hourArrivedAerial_shipment" name="hourArrivedAerial_shipment" placeholder="{{trans('shipment.arrivedHour')}}">
            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
          </div>
        @include('errors.field', ['field' => 'hourArrivedAerial_shipment'])
      </div>
    </div>
  </div>
</fieldset>
