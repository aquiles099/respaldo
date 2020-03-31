@include('sections.translate')

<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    <form role="form" action="" method="post" id="formSerial">
      @if(isset($service))
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
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
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'description'])">
          <label class="col-lg-3 control-label">{{trans('service.description')}}</label>
          <div class="col-lg-9">
            <textarea class="form-control" placeholder="{{trans('service.description')}}" name="description" maxlength="255" min="5" required="true" rows="4" @include('form.readonly')>{{isset($service) ? $service->description : Input::get('description')}}</textarea>
            @include('errors.field', ['field' => 'description'])
          </div>
        </div>
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'value'])">
          <label class="col-lg-3 control-label">{{trans('service.value')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('service.value')}}" name="value" type="text" maxlength="25" min="5" required="true" value="{{isset($service) ? $service->value : Input::get('value')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'value'])
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</div>
