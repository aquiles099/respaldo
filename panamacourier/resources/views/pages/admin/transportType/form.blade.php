<form onsubmit="createLoad()"class="form" action="{{asset($path)}}" method="post">
  @if(isset($transport_type))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!--nombre-->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('transportType.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('transportType.name')}}" name="name" type="text" required="true" value="{{isset($transport_type) ? $transport_type->name : Input::get('name')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!--tipo-->
    <div class="form-group row @include('errors.field-class', ['field' => 'transport'])">
      <label class="col-lg-3 control-label">{{trans('transportType.type')}}</label>
      <div class="col-lg-9">
        @if(!isset($readonly) || $readonly == false)
        <select class="form-control" id="ics_transport_type_transport" name="transport" required="true" value="{{isset($transport_type) ? $transport_type->transport : Input::get('transport')}}" @include('form.readonly') >
          <option value="0">{{trans('messages.optionSelect')}}</option>
          @foreach($transports as $key => $value)
            <option {{(isset($transport_type)) && ($transport_type->transport == $value->id) ? 'selected' : Input::get('transport') == $value->id ? 'selected' : '' }} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{ucwords($value->spanish)}}</option>
          @endforeach
        </select>
        @else
        <input class="form-control" placeholder="" name="" type="text" required="true" value="{{isset($transport_type) ? $transport_type->transport : Input::get('transport')}}" @include('form.readonly')>
        @endif
        @include('errors.field', ['field' => 'transport'])
      </div>
    </div>
    <!--descripcion-->
    <div class="form-group row @include('errors.field-class', ['field' => 'description'])">
      <label class="col-lg-3 control-label">{{trans('transportType.description')}}</label>
      <div class="col-lg-9">
        <textarea class="form-control" placeholder="{{trans('transportType.description')}}" name="description" type="text" required="true" value="" @include('form.readonly')>{{isset($transport_type) ? $transport_type->description : Input::get('description')}}</textarea>
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
