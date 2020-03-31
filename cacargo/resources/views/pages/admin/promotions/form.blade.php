<form onsubmit="createLoad()" role="form" action="{{asset($path)}}" method="post">
  @if(isset($promotions))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!--Nombre de la promocion-->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('promotion.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('promotion.name')}}" name="name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($promotions) ? $promotions->name : Input::get('name')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!--Asignar Valor en Porcentaje o Fijo a la Promocion-->
    <div class="form-group row @include('errors.field-class', ['field' => 'type'])">
      <label class="col-lg-3 control-label">{{trans('promotion.aplicate')}}</label>
      <div class="col-lg-9">
      <select class="form-control" name="type_value" id = "type_value" type="text" required="true" value="{{isset($promotions) ? $promotions->type_value : Input::get('type_value')}}" @include('form.readonly')>
            <option value="0">{{trans('promotion.percentage')}}</option>
            <option value="1">{{trans('promotion.fix')}}</option>
      </select>
      </div>
    </div>
    <!--Asignar valor a la promocion-->
    <div class="form-group row @include('errors.field-class', ['field' => 'value'])">
      <label class="col-lg-3 control-label">{{trans('promotion.value')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('promotion.value')}}" name="value" id = "value" type="text" maxlength="255" min="1" required="true" value="{{isset($promotions) ? $promotions->value : Input::get('value')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'value'])
      </div>
    </div>
    <!--Asignar a Promocion un Tipo de Cliente-->
    <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="type" >
      <label class="col-lg-3 control-label" id="typeLabel" >{{trans('promotion.clientType')}}</label>
      <div class="col-lg-9">
        <select class="form-control" id="user_type" name="user_type" required="true" @include('form.readonly')>
            @foreach ($usersType as $userType)
              <?php $option = $userType->toOption();?>
              <option {{(isset($promotions) ? $promotions->user_type : Input::get('user_type')) == $option['id'] ? 'selected' : ''}} item="{{$userType->toInnerJson()}}" value="{{$option['id']}}">{{$option['text']}}</option>
            @endforeach
        </select>
      </div>
    </div>
    <!--Asignar a Promocion un Tipo de Envio-->
    <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="type" >
      <label class="col-lg-3 control-label" id="typeLabel" >{{trans('promotion.typeShipping')}}</label>
      <div class="col-lg-9">
        <select class="form-control" id="transport" name="transport" required="true" @include('form.readonly')>
            @foreach ($transports as $transport)
              <?php $option = $transport->toOption();?>
              <option {{(isset($promotions) ? $promotions->transport : Input::get('transport')) == $option['id'] ? 'selected' : ''}} item="{{$transport->toInnerJson()}}" value="{{$option['id']}}">{{$option['text']}}</option>
            @endforeach
        </select>
      </div>
    </div>
     <!--Asigar Fecha de Inicio a Promocion-->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('promotion.startDate')}}</label>
      <div class="col-lg-9">
            <input class = "form-control" id="dtps"  placeholder = "{{trans('promotion.startDate')}}" name = "start_date" required = "true" value="{{isset($promotions) ? $promotions->start_date : Input::get('start_date')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'value'])
      </div>
    </div>
    <!--Asignar Fecha de Finalizacion a Promocion-->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('promotion.endDate')}}</label>
      <div class="col-lg-9">
            <input class = "form-control" id="dtpe" placeholder = "{{trans('promotion.endDate')}}" name = "end_date" required = "true" value="{{isset($promotions) ? $promotions->end_date : Input::get('end_date')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'value'])
      </div>
    </div>
    <!--Asignar a Promocion estatus-->
    @if(!isset($readonly) || $readonly == false)
    <div class="form-group row @include('errors.field-class', ['field' => 'status'])" id="status" >
      <label class="col-lg-3 control-label" id="statusLabel" >{{trans('promotion.status')}}</label>
      <div class="col-lg-9">
        <select class="form-control" id="status" name="status" required="true" @include('form.readonly')>
          <option {{isset($promotions) && ($promotions->status == '1') ? 'selected' : '' }} value="1">{{trans('promotion.active')}}</option>
          <option {{isset($promotions) && ($promotions->status == '0') ? 'selected' : '' }} value="0">{{trans('promotion.Inactive')}}</option>
        </select>
      </div>
    </div>
    @else
    <div class="form-group row ">
      <label class="col-lg-3 control-label">{{trans('promotion.status')}}</label>
      <div class="col-lg-9">
            <input class = "form-control" id="dtpe" placeholder = "{{trans('promotion.endDate')}}" name = "end_date" required = "true" value="{{isset($promotions) ? ($promotions->status == 0) ? 'inactiva' : 'activa' : Input::get('status')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'value'])
      </div>
    </div>
    @endif

    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons" id="divButton">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($office)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
