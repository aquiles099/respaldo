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
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'typeServiceGround_shipment'])">
        <label for="typeServiceGround_shipment">{{trans('shipment.serviceType')}}</label>
        <select class ="form-control" type="text" id="typeServiceGround_shipment" name="typeServiceGround_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($typeTransport as $key => $value)
            <option item="{{json_encode($value)}}" value="{{$value['id']}}">{{$value['text']}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'typeServiceGround_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'typeTransportGround_shipment'])">
        <label for="typeTransportGround_shipment">{{trans('shipment.transportType')}}</label>
        <select class ="form-control" type="text" id="typeTransportGround_shipment" name="typeTransportGround_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
        </select>
        @include('errors.field', ['field' => 'typeTransportGround_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'typeRouteGround_shipment'])">
        <label for="typeRouteGround_shipment">{{trans('shipment.route')}}</label>
        <select class ="form-control" type="text" id="typeRouteGround_shipment" name="typeRouteGround_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
          @foreach($route as $key => $value)
            <option item ="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->name}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'typeRouteGround_shipment'])
      </div>
    </div>
  </div>
</fieldset>
<!---->
<fieldset class="form">
  <!--Transporte-->
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb">{{trans('shipment.transportInfo')}}</div>
    </div>
  </div>
  <div class="row">
    <!--first row-->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'carrierGround_shipment'])">
        <label for="carrierGround_shipment">{{trans('shipment.carrier')}}</label>
        <select class ="form-control" type="text" id="carrierGround_shipment" name="carrierGround_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
        </select>
        @include('errors.field', ['field' => 'carrierGround_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'numberVehicleGround_shipment'])">
        <label for="numberVehicleGround_shipment">{{trans('shipment.numberOfVehicle')}}</label>
        <input class ="form-control" type="text" id="numberVehicleGround_shipment" name="numberVehicleGround_shipment" placeholder="{{trans('shipment.numberOfVehicle')}}">
        @include('errors.field', ['field' => 'numberVehicleGround_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'numberProGround_shipment'])">
        <label for="numberProGround_shipment">{{trans('shipment.numberPro')}}</label>
        <input class ="form-control" type="text" id="numberProGround_shipment" name="numberProGround_shipment" placeholder="{{trans('shipment.numberPro')}}">
        @include('errors.field', ['field' => 'numberProGround_shipment'])
      </div>
    </div>
  </div>
  <!--second row-->
  <div class="row">
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'numberTrackingGround_shipment'])">
        <label for="numberTrackingGround_shipment">{{trans('shipment.numberTracking')}}</label>
        <input class ="form-control" type="text" id="numberTrackingGround_shipment" name="numberTrackingGround_shipment" placeholder="{{trans('shipment.numberTracking')}}">
        @include('errors.field', ['field' => 'numberTrackingGround_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'driverVehicleGround_shipment'])">
        <label for="driverVehicleGround_shipment">{{trans('shipment.driverVehicle')}}</label>
        <input class ="form-control" type="text" id="driverVehicleGround_shipment" name="driverVehicleGround_shipment" placeholder="{{trans('shipment.driverVehicle')}}">
        @include('errors.field', ['field' => 'driverVehicleGround_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'driverLicenceGround_shipment'])">
        <label for="driverLicenceGround_shipment">{{trans('shipment.licenceNumber')}}</label>
        <input class ="form-control" type="text" id="driverLicenceGround_shipment" name="driverLicenceGround_shipment" placeholder="{{trans('shipment.licenceNumber')}}">
        @include('errors.field', ['field' => 'driverLicenceGround_shipment'])
      </div>
    </div>
  </div>
</fieldset>
<!---->
<fieldset>
  <!--destinos-->
  <div class="row">
    <div class="col-md-12">
      <div class="breadcrumb">{{trans('shipment.arrivedDepartureInfo')}}</div>
    </div>
  </div>
  <!---->
  <div class="row">
  <!---->
    <div class="col-md-4 form-group @include('errors.field-class', ['field' => 'fromGround_shipment'])">
      <label for="fromGround_shipment">{{trans('shipment.from')}}</label>
      <select class ="form-control" type="text" id="fromGround_shipment" name="fromGround_shipment">
        <option value="0">{{trans('shipment.selectOption')}}</option>
      </select>
      @include('errors.field', ['field' => 'fromGround_shipment'])
    </div>
  <!---->
    <div class="col-lg-4 @include('errors.field-class', ['field' => 'fromDateGround_shipment'])">
      <label for="fromDateGround_shipment" id="typeLabel" >{{trans('shipment.fromDate')}}</label>
      <div class="input-group">
        <input type="text" class="form-control" id="fromDateGround_shipment" name="fromDateGround_shipment" value="" required="true" placeholder ="{{trans('shipment.fromDate')}}" @include('form.readonly')>
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
      </div>
      @include('errors.field', ['field' => 'fromDateGround_shipment'])
    </div>
    <!---->
    <div class="col-lg-4 @include('errors.field-class', ['field' => 'fromHourGround_shipment'])">
        <label for="fromHourGround_shipment" id="typeLabel" >{{trans('shipment.hour')}}</label>
      <div class="input-group">
        <input type="text" class="form-control" id="fromHourGround_shipment" name="fromHourGround_shipment" value="" required="true" placeholder ="{{trans('shipment.hour')}}" @include('form.readonly')>
        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
      </div>
       @include('errors.field', ['field' => 'fromHourGround_shipment'])
    </div>
  </div>
  <!---->
  <div class="row">
    <!---->
    <div class="col-md-4">
      <div class="form-group @include('errors.field-class', ['field' => 'toGround_shipment'])">
        <label for="toGround_shipment">{{trans('shipment.to')}}</label>
        <select class ="form-control" type="text" id="toGround_shipment" name="toGround_shipment">
          <option value="0">{{trans('shipment.selectOption')}}</option>
        </select>
        @include('errors.field', ['field' => 'toGround_shipment'])
      </div>
    </div>
    <!---->
    <div class="col-lg-4 @include('errors.field-class', ['field' => 'toDateGround_shipment'])">
      <label for="toDateGround_shipment" id="typeLabel" >{{trans('shipment.toDate')}}</label>
      <div class="input-group">
        <input type="text" class="form-control" id="toDateGround_shipment" name="toDateGround_shipment" value="" required="true" placeholder ="{{trans('shipment.toDate')}}" @include('form.readonly')>
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
      </div>
      @include('errors.field', ['field' => 'toDateGround_shipment'])
    </div>
    <!---->
    <div class="col-lg-4 @include('errors.field-class', ['field' => 'toHourGround_shipment'])">
        <label for="toHourGround_shipment" id="typeLabel" >{{trans('shipment.hour')}}</label>
      <div class="input-group">
        <input type="text" class="form-control" id="toHourGround_shipment" name="toHourGround_shipment" value="" required="true" placeholder ="{{trans('shipment.hour')}}" @include('form.readonly')>
        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
      </div>
       @include('errors.field', ['field' => 'toHourGround_shipment'])
    </div>
  </div>
</fieldset>
