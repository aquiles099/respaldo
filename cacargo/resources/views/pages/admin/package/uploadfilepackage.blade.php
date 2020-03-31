<div class="panel panel-default">
  <div class="panel-body">
    <form role="form" action = "" id="upload_form" class = "form-horizontal"  novalidate enctype="multipart/form-data">

      <fieldset>
        <!---->
        <div class="form-group row @include('errors.field-class', ['field' => 'concept'])">
          <label for = "concept" class = "control-label col-md-2">{{trans('package.code')}}</label>
          <div class = "col-md-10">
            <input type = "text" class = "form-control" id = "tracking" name="tracking" placeholder = "" value="WR-{{isset($package) ? substr($package->code,6,8) : clear(Input::get('code'))}}" required="true" readonly="true">
          </div>
            @include('errors.field', ['field' => 'tracking'])
        </div>
        <!---->
        <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="type" >
          <label class="col-lg-2 control-label" for = "datelabel"  id="datelabel" style="line-height: 14px;" >{{trans('package.registred')}}</label>
          <div class="col-lg-10">
            <input type = "text" class = "form-control" id = "date" name="date" placeholder = "" value="{{isset($package) ? $package->created_at : clear(Input::get('tracking'))}}"required="true" readonly="true">
          </div>
          @include('errors.field', ['field' => 'date'])
        </div>
        <!---->
        <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="type" >
          <label class="col-lg-2 control-label" for = "destinalabel"  id="destinalabel" >{{trans('package.destinations')}}</label>
          <div class="col-lg-10">
            <input type = "text" class = "form-control" id = "destino" name="destino" placeholder = "" value="{{isset($package) ? $package->getToUser['code'].' '.$package->getToUser['name'].' '.$package->getToUser['last_name'] : clear(Input::get('destino'))}}"  required="true" readonly="true">
          </div>
          @include('errors.field', ['field' => 'type'])
        </div>
        <!---->
          <div class="form-group row @include('errors.field-class', ['field' => 'id_package'])" id="uploadinvoice">
            <label class="col-lg-2 control-label" for = "date"  id="date" style="line-height: 14px;">{{trans('package.uploadpackage')}}</label>
            <div class="col-lg-10">
              <input type="file" name="fileinvoice" id="fileinvoice" accept=".pdf, image/*" value="{{ Input::get('file') }}" required=true readonly="true" >
          </div>
                @include('sections.errors', ['errors' =>  $errors, 'name' => 'id_package'])
       </div>
        <!---->


        <div class="pull-right">
          <div class = "">
            <button type="button" class="btn btn-primary" onclick="executeupload({{isset($package) ? $package->id : '' }})">{{trans('messages.save')}}</button>
          </div>
        </div>

        <!---->
        <div class="pull-right" style="margin-right: 1%; margin-top: 3%;" id="alertOnProcess">
          <div class="ics-checkpayd" id="ics-checkpayd"></div>
        </div>
      </fieldset>
		</form>
  </div>
</div>
