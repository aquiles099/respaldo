@include('sections.translate')

<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    @if(isset($country))
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    @endif
    <form role="form" action="" method="" id ="formSerial">
      <fieldset class="form">
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('country.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('country.name')}}" name="name" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($country) ? $country->name : clear(Input::get('name'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</div>
