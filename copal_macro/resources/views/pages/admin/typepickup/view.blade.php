<div class="panel panel-default" id="pnlft">
<form class="form" action="" method="post" id="formSerial">
  @if(isset($typepickup))
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
  @endif
  <fieldset class="form">

  <div class="tab-content">
    <div id="ics_tab_menu0" class="tab-pane fade in active" >
      <div class="panel-body">
          <!-- -->
          <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
            <label class="col-lg-3 control-label">{{trans('typepickup.name')}}</label>
            <div class="col-lg-9">
              <input class="form-control" placeholder="{{trans('typepickup.name')}}" name="name" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($typepickup) ? $typepickup->name : clear(Input::get('name'))}}" @include('form.readonly')>
              @include('errors.field', ['field' => 'name'])
            </div>
          </div>

          <!---->
          <div class="form-group row @include('errors.field-class', ['field' => 'description'])">
            <label class="col-lg-3 control-label">{{trans('typepickup.description')}}</label>
            <div class="col-lg-9">
              <input class="form-control" placeholder="{{trans('typepickup.description')}}" name="description" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($typepickup) ? $typepickup->description : clear(Input::get('description'))}}" @include('form.readonly')>
              @include('errors.field', ['field' => 'description'])
            </div>
          </div>
        
      </div>
    </div>
  </div>
  </fieldset>
</form>
