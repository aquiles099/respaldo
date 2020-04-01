<form onsubmit="createLoad()" id="form" role="form" action="{{asset($path)}}" method="post" onkeydown="onKeyDown(event)">
  @if(isset($consolidated))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'id'])" id="divId" style="display:none;">
      <label class="col-lg-3 control-label" id="labelId" >{{trans('consolidated.id')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('consolidated.id')}}" id="id" name="id" type="text" maxlength="100" min="5" value="{{isset($consolidated) ? $consolidated->id : clear(Input::get('id'))}}" @include('form.readonly',['forceReadonly' => isset($consolidated)])>
          @include('errors.field', ['field' => 'id'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'description'])" id="divDescription">
      <label class="col-lg-3 control-label" id="labelDescription" >{{trans('consolidated.description')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('consolidated.description')}}" id="description" name="description" type="text" maxlength="100" min="5" required="true" value="{{isset($consolidated) ? $consolidated->description : clear(Input::get('description'))}}" @include('form.readonly',['forceReadonly' => isset($consolidated)])>
          @include('errors.field', ['field' => 'description'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'observation'])" id="divObservation">
      <label class="col-lg-3 control-label" id="labelObservation" >{{trans('consolidated.observation')}}</label>
      <div class="col-lg-9">
        <textarea class="form-control" placeholder="{{trans('consolidated.observation')}}" id="observation" name="observation" type="text" maxlength="255" min="5" @include('form.readonly')>{{isset($consolidated) ? $consolidated->observation : clear(Input::get('observation'))}}</textarea>
          @include('errors.field', ['field' => 'observation'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'status'])" id="divStatus" style="display:none;">
      <label class="col-lg-3 control-label" id="labelStatus" >{{trans('consolidated.status')}}</label>
      <div class="col-lg-9">
      {{trans('consolidated.open')}}  <input type="checkbox" id="status" name="status" onchange="setDisabled();" @if(isset($consolidated)) @if($consolidated->status==1) checked @endif @endif @include('form.readonly')>
        @include('errors.field', ['field' => 'status'])
      </div>
    </div>
    @if(isset($consolidated))
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="text-center">
          <b>{{trans('messages.packages')}}</b>
        </div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-hover" id="dtble">
              <thead>
                <tr>
                  <th>{{trans('messages.code')}}</th>
                  <th>{{trans('messages.tracking')}}</th>
                  <th>{{trans('messages.category')}}</th>
                  <th>{{trans('messages.add')}}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($package as $key => $value)
                  @if(is_null($value->consolidated) || ($value->consolidated == $consolidated->id))
                    <tr>
                      <td>{{$value->code}}</td>
                      <td>{{$value->tracking}}</td>
                      <td>{{$value->getCategory->label}}</td>
                      <td>
                        <input type="checkbox" name="wr{{$value->id}}" value="wr{{$value->id}}" @foreach($packageConsolidated as $key => $package) @if($value->id == $package->package) checked  @endif @endforeach/>
                      </td>
                    </tr>
                   @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    @endif
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons" style="display:block;" id="divButton">
        <button type="submit" class="btn btn-primary pull-right" id="button">
        <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($consolidated)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
