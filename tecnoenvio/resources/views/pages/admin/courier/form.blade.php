<form onsubmit="createLoad()" role="form" action="{{asset($path)}}" method="post">
  @if(isset($courier))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('courier.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('courier.name')}}" name="name" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($courier) ? $courier->name : clear(Input::get('name'))}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!--show only create or edit -->
    <div style="{{(!$readonly) ? '' : 'display:none'}}" class="form-group row @include('errors.field-class', ['field' => 'status'])">
      <label class="col-lg-3 control-label">{{trans('courier.status')}}</label>
      <div class="col-lg-9">
      <select class="form-control" placeholder="{{trans('courier.status')}}" name="status" required="true" value="{{isset($courier) ? $courier->status : Input::get('status')}}" @include('form.readonly')>
        <option value="0">{{trans('courier.disable')}}</option>
        <option value="1">{{trans('courier.enable')}}</option>
      </select>
      </div>
    </div>
      <!-- -->
    <div style="{{($readonly) ? '' : 'display:none'}}"class="form-group row ">
      <label class="col-lg-3 control-label">{{trans('courier.status')}}</label>
      <div class="col-lg-9">
        <input class="form-control"  type="text" value="{{isset($courier) ? ($courier->status == 1)? trans('courier.enable') : trans('courier.disable') : clear(Input::get('status'))}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($courier)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
