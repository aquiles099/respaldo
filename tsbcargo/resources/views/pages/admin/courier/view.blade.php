<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    @if(isset($courier))
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    @endif
    <form role="form" action="" method="" id="formSerial">
      <fieldset class="form">
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('courier.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('courier.name')}}" name="name" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($courier) ? $courier->name : clear(Input::get('name'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>
        <!--show only create or edit (VS)-->
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
      </fieldset>
    </form>
  </div>
</div>
