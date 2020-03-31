<!--departure date and hour-->
<div class="form-group row @include('errors.field-class', ['field' => 'since_departure_maritime'])" id="type" >
  <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.departureDate')}}</label>
  <div class="col-lg-4 @include('errors.field-class', ['field' => 'since_departure_maritime'])">
    <div class="input-group">
      <input type="text" class="form-control" id="since_departure_maritime" name="since_departure_maritime" value="{{isset($shipment) ? $shipment->departure_date_mar : date('Y-m-d')}}" required="true" placeholder ="{{trans('shipment.since')}}" @include('form.readonly')>
      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    </div>
    @include('errors.field', ['field' => 'since_departure_maritime'])
  </div>
  <div class="col-lg-4 @include('errors.field-class', ['field' => 'hour_departure_maritime'])">
    <div class="input-group">
      <input type="text" class="form-control" id="hour_departure_maritime" name="hour_departure_maritime" value="{{isset($shipment) ? $shipment->departure_hour_mar : date('H:i')}}" required="true" placeholder ="{{trans('shipment.hour')}}" @include('form.readonly')>
      <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
    </div>
     @include('errors.field', ['field' => 'hour_departure_maritime'])
  </div>
</div>
<!--arrived date and hour-->
<div class="form-group row @include('errors.field-class', ['field' => 'since_arrived_maritime'])" id="type" >
  <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.arrivedDate')}}</label>
  <div class="col-lg-4 @include('errors.field-class', ['field' => 'since_arrived_maritime'])">
    <div class="input-group">
      <input type="text" class="form-control" id="since_arrived_maritime" name="since_arrived_maritime" value="{{isset($shipment) ? $shipment->arrived_date_mar : date('Y-m-d')}}" required="true" placeholder ="{{trans('shipment.since')}}" @include('form.readonly')>
      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    </div>
    @include('errors.field', ['field' => 'since_arrived_maritime'])
  </div>
  <div class="col-lg-4 @include('errors.field-class', ['field' => 'hour_arrived_maritime'])">
    <div class="input-group">
      <input type="text" class="form-control" id="hour_arrived_maritime" name="hour_arrived_maritime" value="{{isset($shipment) ? $shipment->arrived_hour_mar : date('H:i')}}" required="true" placeholder ="{{trans('shipment.hour')}}" @include('form.readonly')>
      <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
    </div>
     @include('errors.field', ['field' => 'hour_arrived_maritime'])
  </div>
</div>
