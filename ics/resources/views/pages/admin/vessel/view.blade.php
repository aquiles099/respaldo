@include('sections.translate')
<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    <form class="form" action="" method="post" id="formSerial">
      @if(isset($vessel))
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
      @endif
      <fieldset class="form">
        <!--nombre-->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('route.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('vessel.name')}}" name="name" type="text" required="true" value="{{isset($vessel) ? $vessel->name : Input::get('name')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>
        <!--bandera-->
        <div class="form-group row @include('errors.field-class', ['field' => 'flag'])">
          <label class="col-lg-3 control-label">{{trans('vessel.flag')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('vessel.flag')}}" name="flag" type="text" required="true" value="{{isset($vessel) ? $vessel->flag : Input::get('flag')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'flag'])
          </div>
        </div>
        <!--country-->
        <div class="form-group row @include('errors.field-class', ['field' => 'country'])">
          <label class="col-lg-3 control-label">{{trans('vessel.country')}}</label>
          <div class="col-lg-9">
            @if(!isset($readonly) || $readonly == false)
            <select style="width:100%;" class="form-control" id="ics_vessel_country" name="country" required="true" value="{{isset($vessel) ? $vessel->getCountry->name : Input::get('country')}}" @include('form.readonly') >
              <option value="0">{{trans('route.selectOption')}}</option>
              @foreach($country as $key => $value)
                <option {{(isset($vessel)) && ($vessel->country == $value->id) ? 'selected' : '' }} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->name}}</option>
              @endforeach
            </select>
            @else
            <input class="form-control" placeholder="" name="" type="text" required="true" value="{{isset($vessel) ? $vessel->getCountry->name : Input::get('country')}}" @include('form.readonly')>
            @endif
            @include('errors.field', ['field' => 'country'])
          </div>
        </div>
        <!--city-->
        <div class="form-group row @include('errors.field-class', ['field' => 'city'])">
          <label class="col-lg-3 control-label">{{trans('vessel.city')}} <span id="ics_load_vessel_city"></span></label>
          <div class="col-lg-9">
            @if(!isset($readonly) || $readonly == false)
            <select style="width:100%;" class="form-control" id="ics_vessel_city" name="city" required="true" value="{{isset($vessel) ? $vessel->getCity->name : Input::get('city')}}" @include('form.readonly') >
              <option value="0">{{trans('route.selectOption')}}</option>
              @if(isset($view))
                @foreach($city as $key => $value)
                  <option {{(isset($vessel)) && ($vessel->city == $value->id) ? 'selected' : '' }} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
              @endif
            </select>
            @else
            <input class="form-control" placeholder="" name="" type="text" required="true" value="{{isset($vessel) ? $vessel->getCity->name : Input::get('city')}}" @include('form.readonly')>
            @endif
            @include('errors.field', ['field' => 'city'])
          </div>
        </div>
      </fieldset>
    </form>

  </div>
</div>
