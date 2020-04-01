<form onsubmit="createLoad()"role="form" action="{{asset($path)}}" method="post">
  @if(isset($office))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('office.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('office.name')}}" name="name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($office) ? $office->name : Input::get('name')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])">
      <label class="col-lg-3 control-label">{{trans('office.direction')}}</label>
      <div class="col-lg-9">
        <textarea class="form-control" placeholder="{{trans('office.direction')}}" name="direction" maxlength="255" min="5" required="true" rows="4" @include('form.readonly')>{{isset($office) ? $office->direction : Input::get('direction')}}</textarea>
        @include('errors.field', ['field' => 'direction'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'phone'])">
      <label class="col-lg-3 control-label">{{trans('office.phone')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('office.phone')}}" name="phone" type="text" maxlength="25" min="5" required="true" value="{{isset($office) ? $office->phone : Input::get('direction')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'phone'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'country'])">
      <label class="col-lg-3 control-label">{{trans('office.country')}}</label>
      <div class="col-lg-9">
      <select style="width:100%;" class="form-control" placeholder="{{trans('office.country')}}" name="country" required="true" value="{{isset($office) ? $office->country : Input::get('country')}}" @include('form.readonly')>
        @foreach ($countries as $country)
          <option value="{{$country->id}}">{{ucwords($country->name)}}</option>
        @endforeach
      </select>
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
