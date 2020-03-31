<form id="form" role="form" action="{{asset($path)}}" method="post" onkeydown="onKeyDown(event)">
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
    <div class="form-group row @include('errors.field-class', ['field' => 'code'])" id="divCode">
      <label class="col-lg-3 control-label" id="labelCode" >{{trans('consolidated.code')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('consolidated.code')}}" id="code" name="code" type="text" maxlength="100" min="5" required="true" value="{{isset($consolidated) ? $consolidated->code : clear(Input::get('code'))}}" @include('form.readonly',['forceReadonly' => isset($consolidated)])>
          @include('errors.field', ['field' => 'code'])
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
        <input class="form-control" placeholder="{{trans('consolidated.observation')}}" id="observation" name="observation" type="text" maxlength="255" min="5" value="{{isset($consolidated) ? $consolidated->observation : clear(Input::get('observation'))}}" @include('form.readonly')>
          @include('errors.field', ['field' => 'observation'])
      </div>
    </div>

    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'observation'])" id="office">
      <label class="col-lg-3 control-label" id="labelObservation" >{{trans('consolidated.office')}}</label>
       <div class="col-lg-9">
          <select style="width:100%;" class="form-control" id="office" name="office" required="true" @include('form.readonly')>
          <option value="0" cost="0">{{trans('consolidated.notoffice')}}</option>
              @foreach ($offices as $office2)
                <?php $option = $office2->toOption();?>
                @if(isset($consolidated))
                  <option item="{{$office2->toInnerJson()}}" value="    <?= $option['id']?>" <?= $option['id'] == $consolidated->office? 'selected' : ''?>><?= $option['text']?></option>
                  @else
                  <option item="{{$office2->toInnerJson()}}" value="{{$option['id']}}"> {{$option['text']}}</option>
                @endif

              @endforeach
          </select>
          @include('errors.field', ['field' => 'office|'])
        </div>
      </div>

    <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="type" >
        <label class="col-lg-3 control-label" id="typeLabel" >{{trans('consolidated.typeservice')}}</label>
        <div class="col-lg-9">
          <select style="width:100%;" class="form-control" id="typeservice" name="typeservice" required="true" @include('form.readonly')>
          <option value="0" cost="0">{{trans('consolidated.nottransport')}}</option>
              @foreach ($transports as $transport)
                <?php $option = $transport->toOption();?>
                @if(isset($consolidated))
                <option item="{{$transport->toInnerJson()}}" value="<?= $option['id']?>" <?= $option['id'] == $consolidated->transport? 'selected' : ''?>><?= $option['text']?></option>
                @else
                 <option item="{{$transport->toInnerJson()}}" value="{{$option['id']}}"> {{$option['text']}}</option>
                @endif

              @endforeach
          </select>
          @include('errors.field', ['field' => 'typeservice|'])
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
    <!--  -->
    <h3 class="page-header" id="packageTitle" style="display:none;">
      <div class="pull-center">{{trans('consolidated.packageInfo')}}</div>
    </h3>
    <!--  -->
    <h4 class="alert-danger" id="errorTitle" style="display:none;">
      <div class="pull-center">{{trans('consolidated.packageInfo')}}</div>
    </h4>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'tracking'])" id="divTracking" style="display:none;">
      <label class="col-lg-3 control-label" id="labelTracking" >{{trans('consolidated.tracking')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('consolidated.tracking')}}" id="tracking" name="tracking" type="text" maxlength="25" min="10" value="{{isset($consolidated) ? $consolidated->tracking : clear(Input::get('tracking'))}}" @include('form.readonly')>
          @include('errors.field', ['field' => 'tracking'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'observation'])" id="divPackageObservation" style="display:none;">
      <label class="col-lg-3 control-label" id="labelPackageObservation" >{{trans('consolidated.observation')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('consolidated.observation')}}" id="packageObservation" name="packageObservation" type="text" maxlength="255" min="5" @include('form.readonly')>
          @include('errors.field', ['field' => 'observation'])
      </div>
    </div>
    <!-- -->
    <table class="table table-striped" id="tableHeader" style="display:none;">
      <thead>
        <tr>
          <th style="width:10%">{{trans('messages.id')}}</th>
          <th style="width:20%">{{trans('messages.description')}}</th>
          <th style="width:15%">{{trans('messages.tracking')}}</th>
          <th style="width:50%">{{trans('messages.observation')}}</th>
        </tr>
      </thead>
      <tbody id="table">
        @if(isset($packageConsolidated))
        @foreach ($packageConsolidated->all() as $row)
          <tr>
            <td>{{$row->id}}</td>
            <td>{{$consolidated->description}}</td>
            <td>{{$row->getPackage->tracking}}</td>
            <td>{{$row->observation}}</td>
            @if(isset($readonly))
            @if(($readonly === false) && ($consolidated->status === 1))
            <td>
              <ul class="table-actions">
                <li><a onclick="packageConsolidatedDelete({{$row->id}}, event)" ><i class="fa fa-times"  title="{{trans('messages.delete')}}"></i></a></li>
              </ul>
            </td>
            @endif
            @endif
          </tr>
        @endforeach
        @endif
        </tr>
      </tfoot>
    </table>
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
