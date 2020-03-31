<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    <form role="form" action="" method="post"  id="formSerial" >
      @if(isset($tax))
          <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
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
        <div class="form-group row @include('errors.field-class', ['field' => 'value'])">
          <label class="col-lg-3 control-label">{{trans('tax.value')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('tax.value')}}" name="value" type="text" maxlength="255" min="1" required="true" value="{{isset($tax) ? $tax->value : Input::get('value')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'value'])
          </div>
        </div>
        <!-- -->
        @if(!isset($readonly) || $readonly == false)
        <div class="form-group row @include('errors.field-class', ['field' => 'type'])">
          <label class="col-lg-3 control-label">{{trans('tax.type')}}</label>
          <div class="col-lg-9">
            <select class="form-control" placeholder="{{trans('tax.type')}}" name="type" type="text" required="true" value="{{isset($tax) ? $tax->type : Input::get('type')}}" @include('form.readonly')>
                  <option {{isset($tax) && ($tax->type == 0) ? 'selected' :  ''}} value="0">Porcentaje</option>
                  <option {{isset($tax) && ($tax->type == 1) ? 'selected' :  ''}} value="1" >Fijo</option>
            </select>
            @include('errors.field', ['field' => 'type'])
          </div>
        </div>
        @else
        <div class="form-group row @include('errors.field-class', ['field' => 'type'])">
          <label class="col-lg-3 control-label">{{trans('tax.type')}}</label>
          <div class="col-lg-9">
            <input class="form-control"  name="value" type="text" value="{{(isset($tax) && $tax->type == 0) ? trans('tax.percentage') : trans('tax.fix')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'value'])
          </div>
        </div>
        @endif
        <!-- -->
        @if(!isset($readonly) || $readonly == false)
        <div class="form-group row @include('errors.field-class', ['field' => 'country'])">
          <label class="col-lg-3 control-label">{{trans('tax.country')}}</label>
          <div class="col-lg-9">
             <select class="form-control" placeholder="{{trans('tax.country')}}" name="country" required="true" value="{{isset($tax) ? $tax->country : Input::get('country')}}" @include('form.readonly')>
                @foreach ($country as $countrys)
                  <option {{isset($tax) && ($tax->country == $countrys->id) ? 'selected' :  ''}} value="{{$countrys->id}}">{{$countrys->name}}</option>
                @endforeach
              </select>
            @include('errors.field', ['field' => 'value'])
          </div>
        </div>
        @else
        <div class="form-group row @include('errors.field-class', ['field' => 'country'])">
          <label class="col-lg-3 control-label">{{trans('tax.country')}}</label>
          <div class="col-lg-9">
            <input class="form-control"  name="value" type="text" value="{{isset($tax) ? $tax->getCountry->name : ''}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'value'])
          </div>
        </div>
        @endif
        <!-- -->
        @if(!isset($readonly) || $readonly == false)
        <div class="form-group row @include('errors.field-class', ['field' => 'state'])">
          <label class="col-lg-3 control-label">{{trans('tax.state')}}</label>
          <div class="col-lg-9">
            <select class="form-control" name="state"  required="true" value="" @include('form.readonly')>
                  <option {{isset($tax) && ($tax->state == 1) ? 'selected' :  ''}} value = "1">Activo</option>
                  <option {{isset($tax) && ($tax->state == 0) ? 'selected' :  ''}} value = "0">Inactivo</option>
            </select>
              @include('errors.field', ['field' => 'value'])
          </div>
        </div>
        @else
        <div class="form-group row @include('errors.field-class', ['field' => 'state'])">
          <label class="col-lg-3 control-label">{{trans('tax.state')}}</label>
          <div class="col-lg-9">
            <input class="form-control"  name="value" type="text" value="{{(isset($tax) && $tax->state == 1)  ? trans('tax.active') : trans('tax.inactive') }}" @include('form.readonly')>
            @include('errors.field', ['field' => 'value'])
          </div>
        </div>
        @endif
      </fieldset>
    </form>
  </div>
</div>
