<?php $lang = App::getLocale(); ?>
<form onsubmit="createLoad()"role="form" action="{{asset($path)}}" method="post">
  @if(isset($service))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('service.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('service.name')}}" name="name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($service) ? $service->name : Input::get('name')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>

     <div class="form-group row @include('errors.field-class', ['field' => 'transport'])">
      <label class="col-lg-3 control-label">{{trans('service.transport')}}</label>
      <div class="col-lg-9">
        @if(!isset($readonly) || $readonly == false)
        <select style="width:100%;" class="form-control" id="ics_transport_type_transport" name="transport" required="true"
          <option value="0">{{trans('service.selectOption')}}</option>
          @foreach($transports as $key => $value)
            <option {{(isset($transport_type)) && ($transport_type->transport == $value->id) ? 'selected' : Input::get('transport') == $value->id ? 'selected' : '' }} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{($lang == 'es') ? ucwords($value->spanish) : ucwords($value->english)}}</option>
          @endforeach
        </select>
        @else
        <input class="form-control" placeholder="" name="" type="text" required="true" value="{{isset($transport_type) ? $transport_type->transport : Input::get('transport')}}" @include('form.readonly')>
        @endif
        @include('errors.field', ['field' => 'transport'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])">
      <label class="col-lg-3 control-label">{{trans('service.description')}}</label>
      <div class="col-lg-9">
        <textarea class="form-control" placeholder="{{trans('service.description')}}" name="description" maxlength="255" min="5" required="true" rows="4" @include('form.readonly')>{{isset($service) ? $service->direction : Input::get('direction')}}</textarea>
        @include('errors.field', ['field' => 'description'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'value'])">
      <label class="col-lg-3 control-label">{{trans('service.value')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('service.value')}}" name="value" type="text" maxlength="25" min="5" required="true" value="{{isset($service) ? $service->value : Input::get('direction')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'valor'])
      </div>
    </div>
    <!-- -->
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons" id="divButton">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($service)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
