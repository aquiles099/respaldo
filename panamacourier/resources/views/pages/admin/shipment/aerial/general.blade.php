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
<!---->
<div class="form-group row @include('errors.field-class', ['field' => 'carrier_aerial'])" id="type" >
  <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.carrier')}}</label>
  <div class="col-lg-8">
    <select type="text" class="form-control" id="carrier_aerial" name="carrier_aerial" required="true">
      <option style="width:100%;" value="0">{{trans('shipment.selectOption')}}</option>
      @foreach($transporters as $key => $value)
        <option {{(isset($shipment) && $shipment->transporter == $value->id) ? 'selected' : ''}} item="{{$value->toJson()}}"value ="{{$value->id}}">{{$value->code}} {{$value->name}}</option>
      @endforeach
    </select>
    @include('errors.field', ['field' => 'carrier_aerial'])
  </div>
</div>
<!---->
<div class="form-group row @include('errors.field-class', ['field' => 'aduana_aerial'])" id="type" >
  <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.forAduana')}}</label>
  <div class="col-lg-8">
    <input type="text" class="form-control" id="aduana_aerial" name="aduana_aerial" value="{{isset($shipment) ? $shipment->for_aduana  : ''}}" required="true" placeholder ="{{trans('shipment.forAduana')}}" @include('form.readonly')>
    @include('errors.field', ['field' => 'aduana_aerial'])
  </div>
</div>
