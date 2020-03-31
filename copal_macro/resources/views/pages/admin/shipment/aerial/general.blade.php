<!---->
<div class="form-group row @include('errors.field-class', ['field' => 'carrier_aerial'])" id="type" >
  <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.carrier')}}</label>
  <div class="col-lg-8">
    <select type="text" class="form-control" id="carrier_aerial" name="carrier_aerial" required="true">
      <option value="0">{{trans('shipment.selectOption')}}</option>
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
