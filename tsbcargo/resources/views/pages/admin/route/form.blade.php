<form class="form" action="{{asset($path)}}" onsubmit="createLoad()" method="post">
  @if(isset($route))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!--nombre-->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-2 control-label">{{trans('route.name')}}</label>
      <div class="col-lg-10">
        <input class="form-control" placeholder="{{trans('route.name')}}" name="name" type="text" required="true" value="{{isset($route) ? $route->name : Input::get('name')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!--Precio-->
    <div class="form-group row @include('errors.field-class', ['field' => 'price'])">
      <label class="col-lg-2 control-label">{{trans('route.price')}}($)</label>
      <div class="col-lg-10">
        <input class="form-control" placeholder="{{trans('route.price')}}" name="price" type="number" required="true" value="{{isset($route) ? $route->price : Input::get('price')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'price'])
      </div>
    </div>
    <!--tipo-->
    <div class="form-group row @include('errors.field-class', ['field' => 'transport'])">
      <label class="col-lg-2 control-label">{{trans('route.type')}}</label>
      <div class="col-lg-10">
        @if(!isset($readonly) || $readonly == false)
        <select style="width:100%;" class="form-control" id="ics_route_transport" name="transport" required="true" value="{{isset($route) ? $route->transport : Input::get('transport')}}" @include('form.readonly') >
          <option value="0">{{trans('route.selectOption')}}</option>
          @foreach ($transport as $key => $value)
            <option {{(isset($route) && $route->transport == $value->id) ? 'selected' : '' }} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{ucwords($value->toOption()['text'])}}</option>
          @endforeach
        </select>
        @else
        <input class="form-control" placeholder="" name="" type="text" required="true" value="{{isset($route) ? $route->transport : Input::get('transport')}}" @include('form.readonly')>
        @endif
        @include('errors.field', ['field' => 'type'])
      </div>
    </div>
    <!--Origen-->
    <div class="form-group row">
      <div class=" @include('errors.field-class', ['field' => 'origin_country'])">
        <label for="origin_country" class="col-lg-2 control-label">{{trans('route.originCountry')}}</label>
          <div class="col-lg-4">
            @if(!isset($readonly) || $readonly == false)
            <select style="width:100%;" class="form-control" id="ics_route_origin_country" name="origin_country" required="true" value="{{isset($route) ? $route->origin_country : Input::get('origin_country')}}" @include('form.readonly') >
                <option value="0">{{trans('route.selectOption')}}</option>
              @foreach ($country as $key => $value)
                <option {{(isset($route) && $route->origin_country == $value->id) ? 'selected' : '' }} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{ucwords($value->toOption()['text'])}}</option>
              @endforeach
            </select>
            @else
            <input class="form-control" placeholder="" name="" type="text" required="true" value="{{isset($route) ? $route->origin_country : Input::get('origin_country')}}" @include('form.readonly')>
            @endif
            @include('errors.field', ['field' => 'origin_country'])
          </div>
      </div>
      <div class=" @include('errors.field-class', ['field' => 'origin_city'])">
        <label class="col-lg-2 control-label">{{trans('route.originCity')}} <span id="ics_load_route_origin"></span></label>
        <div class="col-lg-4">
          @if(!isset($readonly) || $readonly == false)
          <select style="width:100%;" class="form-control" id="ics_route_origin_city" name="origin_city" required="true" value="{{isset($route) ? $route->origin_city : Input::get('origin_city')}}" @include('form.readonly') >
              <option value="0">{{trans('route.selectOption')}}</option>
          </select>
          @else
          <input class="form-control" placeholder="" name="" type="text" required="true" value="{{isset($route) ? $route->origin_city : Input::get('origin_city')}}" @include('form.readonly')>
          @endif
          @include('errors.field', ['field' => 'origin_city'])
        </div>
      </div>
    </div>
    <!--destino-->
    <div class="form-group row">
      <div class=" @include('errors.field-class', ['field' => 'destiny_country'])">
        <label for="destiny_country" class="col-lg-2 control-label">{{trans('route.destinyCountry')}}</label>
          <div class="col-lg-4">
            @if(!isset($readonly) || $readonly == false)
            <select style="width:100%;" class="form-control" id="ics_route_destiny_country" name="destiny_country" required="true" value="{{isset($route) ? $route->destiny_country : Input::get('origin_country')}}" @include('form.readonly') >
                <option value="0">{{trans('route.selectOption')}}</option>
                @foreach ($country as $key => $value)
                  <option {{(isset($route) && $route->destiny_country == $value->id) ? 'selected' : '' }} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{ucwords($value->toOption()['text'])}}</option>
                @endforeach
            </select>
            @else
            <input class="form-control" placeholder="" name="" type="text" required="true" value="{{isset($route) ? $route->destiny_country : Input::get('destiny_country')}}" @include('form.readonly')>
            @endif
            @include('errors.field', ['field' => 'origin_country'])
          </div>
      </div>
      <div class=" @include('errors.field-class', ['field' => 'destiny_city'])">
        <label class="col-lg-2 control-label">{{trans('route.destinyCity')}} <span id="ics_load_route_destiny"></span></label>
        <div class="col-lg-4">
          @if(!isset($readonly) || $readonly == false)
          <select style="width:100%;" class="form-control" id="ics_route_destiny_city" name="destiny_city" required="true" value="{{isset($route) ? $route->destiny_city : Input::get('destiny_city')}}" @include('form.readonly') >
              <option value="0">{{trans('route.selectOption')}}</option>
          </select>
          @else
          <input class="form-control" placeholder="" name="" type="text" required="true" value="{{isset($route) ? $route->destiny_city : Input::get('destiny_city')}}" @include('form.readonly')>
          @endif
          @include('errors.field', ['field' => 'destiny_city'])
        </div>
      </div>
    </div>
    <!--description-->
    <div class="form-group row @include('errors.field-class', ['field' => 'description'])">
      <label class="col-lg-2 control-label">{{trans('route.description')}}</label>
      <div class="col-lg-10">
        <textarea class="form-control" placeholder="{{trans('route.description')}}" name="description" required="true"  @include('form.readonly')>{{isset($route) ? ucfirst($route->description) : Input::get('description')}}</textarea>
        @include('errors.field', ['field' => 'description'])
      </div>
    </div>
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons" id="divButton">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($office)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
