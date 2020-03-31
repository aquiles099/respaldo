<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    <form class="form" action="" method="post" id="formSerial">
      @if(isset($city))
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
      @endif
      <fieldset class="form">
        <!--nombre-->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('city.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('city.name')}}" name="name" type="text" required="true" value="{{isset($city) ? $city->name : Input::get('name')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>
        <!--country-->
        <div class="form-group row @include('errors.field-class', ['field' => 'country'])">
          <label class="col-lg-3 control-label">{{trans('city.country')}}</label>
          <div class="col-lg-9">
            @if(!isset($readonly) || $readonly == false)
            <select class="form-control" id="ics_city_country" name="country" required="true" value="{{isset($city) ? $city->country : Input::get('country')}}" @include('form.readonly') >
              <option value="0">{{trans('city.selectOption')}}</option>
              @foreach($country as $key => $value)
                <option {{(isset($city)) && ($city->country == $value->id) ? 'selected' : '' }} item="{{$value->toInnerJson()}}" value="{{ucwords($value->id)}}">{{ucwords($value->name)}}</option>
              @endforeach
            </select>
            @else
            <input class="form-control" placeholder="" name="" type="text" required="true" value="{{isset($city) ? $city->getCountry->name : Input::get('country')}}" @include('form.readonly')>
            @endif
            @include('errors.field', ['field' => 'country'])
          </div>
        </div>
        <!--descripcion-->
        <div class="form-group row @include('errors.field-class', ['field' => 'description'])">
          <label class="col-lg-3 control-label">{{trans('city.description')}}</label>
          <div class="col-lg-9">
            <textarea class="form-control" placeholder="{{trans('city.description')}}" name="description" type="text" required="true" value="" @include('form.readonly')>{{isset($city) ? $city->description : Input::get('description')}}</textarea>
            @include('errors.field', ['field' => 'description'])
          </div>
        </div>
      </fieldset>
    </form>

  </div>
</div>
