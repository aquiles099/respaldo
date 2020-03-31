@include('sections.translate')
<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    <form role="form" action="" method="post" id="formSerial">
      @if(isset($access))
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
      @endif
      <fieldset class="form">
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('access.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('access.name')}}" name="name" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($access) ? $access->name : Input::get('name')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</div>
