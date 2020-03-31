<form role="form" action="{{asset($path)}}" onsubmit="createLoad()" method="post">
  @if(isset($addcharge))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('addcharge.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('addcharge.name')}}" name="name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($addcharge) ? $addcharge->name : Input::get('name')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])">
      <label class="col-lg-3 control-label">{{trans('addcharge.description')}}</label>
      <div class="col-lg-9">
        <textarea class="form-control" placeholder="{{trans('addcharge.description')}}" name="description" maxlength="255" min="5" required="true" rows="4" @include('form.readonly')>{{isset($addcharge) ? $addcharge->direction : Input::get('direction')}}</textarea>
        @include('errors.field', ['field' => 'description'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'phone'])">
      <label class="col-lg-3 control-label">{{trans('addcharge.value')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('addcharge.value')}}" name="value" type="text" maxlength="25" min="5" required="true" value="{{isset($addcharge) ? $addcharge->phone : Input::get('direction')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'value'])
      </div>
    </div>

    <!-- -->

    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons" id="divButton">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($addcharge)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
