@include('sections.translate')
<form role="form" action="" method="post">
  @if(isset($tax))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('tax.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('tax.name')}}" name="name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($tax) ? $tax->name : Input::get('name')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'type'])">
      <label class="col-lg-3 control-label">{{trans('tax.type')}}</label>
      <div class="col-lg-9">
      <select class="form-control" placeholder="{{trans('tax.type')}}" name="type" type="text" required="true" value="{{isset($tax) ? $tax->type : Input::get('type')}}" @include('form.readonly')>
            <option value=0>Porcentaje (%)</option>
            <option value=1>Fijo ($)</option>
      </select>
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'value'])">
      <label class="col-lg-3 control-label">{{trans('tax.value')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('tax.value')}}" name="value" type="text" maxlength="255" min="1" required="true" value="{{isset($tax) ? $tax->value : Input::get('value')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'value'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'country'])">
      <label class="col-lg-3 control-label">{{trans('tax.country')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('tax.country')}}" name="country" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($tax) ? $tax->getCountry->name : Input::get('country')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'state'])">
      <label class="col-lg-3 control-label">{{trans('tax.state')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('tax.name')}}" name="name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($tax) ? ($tax->state == 1) ? trans('tax.active') : trans('tax.inactive') : Input::get('state')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!-- -->
  </fieldset>
</form>
