<?php $lang = App::getLocale(); ?>
@include('sections.translate')

<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    <form role="form" action="" method="post" id="formSerial">
      @if(isset($promotions))
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
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
        @if(!isset($readonly) || $readonly == false)
        <div class="form-group row @include('errors.field-class', ['field' => 'type'])">
          <label class="col-lg-3 control-label">{{trans('promotion.aplicate')}}</label>
          <div class="col-lg-9">
            <select style="width:100%;" class="form-control" name="type_value" id = "type_value" type="text" required="true" value="{{isset($promotions) ? $promotions->type_value : Input::get('type_value')}}" @include('form.readonly')>
                  <option value="0">{{trans('promotion.percentage')}}</option>
                  <option value="1">{{trans('promotion.fix')}}</option>
            </select>
              @include('errors.field', ['field' => 'value'])
          </div>
        </div>
        @else
        <div class="form-group row ">
          <label class="col-lg-3 control-label">{{trans('promotion.aplicate')}}</label>
          <div class="col-lg-9">
                <input class = "form-control" value ="{{(isset($promotions) && $promotions->type_value == 0) ? trans('promotion.percentage') : trans('promotion.fix') }}" @include('form.readonly')>
                @include('errors.field', ['field' => 'value'])
          </div>
        </div>
        @endif
        <!--Asignar valor a la promocion-->
        <div class="form-group row @include('errors.field-class', ['field' => 'value'])">
          <label class="col-lg-3 control-label">{{trans('promotion.value')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('promotion.value')}}" name="value" id = "value" type="text" maxlength="255" min="1" required="true" value="{{isset($promotions) ? $promotions->value : Input::get('value')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'value'])
          </div>
        </div>
        <!--Asignar a Promocion un Tipo de Cliente-->
        <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="type" style="display:none" >
          <label class="col-lg-3 control-label" id="typeLabel" >{{trans('promotion.clientType')}}</label>
          <div class="col-lg-9">
            <select style="width:100%;" class="form-control" id="user_type" name="user_type" required="true" @include('form.readonly')>
                @foreach ($usersType as $userType)
                  <?php $option = $userType->toOption();?>
                  <option {{(isset($promotions) ? $promotions->user_type : Input::get('user_type')) == $option['id'] ? 'selected' : ''}} item="{{$userType->toInnerJson()}}" value="{{$option['id']}}">{{$option['text']}}</option>
                @endforeach
            </select>
          </div>
        </div>
        <!--Asignar a Promocion un Tipo de Envio-->
        @if(!isset($readonly) || $readonly == false)
        <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="type" >
          <label class="col-lg-3 control-label" id="typeLabel" >{{trans('promotion.typeShipping')}}</label>
          <div class="col-lg-9">
            <select style="width:100%;" class="form-control" id="transport" name="transport" required="true" @include('form.readonly')>
                @foreach ($transports as $transport)
                  <?php $option = $transport->toOption();?>
                  <option {{(isset($promotions) ? $promotions->transport : Input::get('transport')) == $option['id'] ? 'selected' : ''}} item="{{$transport->toInnerJson()}}" value="{{$option['id']}}">{{$option['text']}}</option>
                @endforeach
            </select>
                @include('errors.field', ['field' => 'type'])
          </div>
        </div>
        @else
        <div class="form-group row ">
          <label class="col-lg-3 control-label">{{trans('promotion.aplicate')}}</label>
          <div class="col-lg-9">
                <input class = "form-control" value ="{{isset($promotions) ? ($lang=='es') ? ucwords($promotions->getTransport->spanish) : ucwords($promotions->getTransport->english) : '' }}" @include('form.readonly')>
                @include('errors.field', ['field' => 'type'])
          </div>
        </div>
        @endif
         <!--Asigar Fecha de Inicio a Promocion-->
        <div class="form-group row @include('errors.field-class', ['field' => 'start_date'])">
          <label class="col-lg-3 control-label">{{trans('promotion.startDate')}}</label>
          <div class="col-lg-9">
                <input class = "form-control" id="dtps"  placeholder = "{{trans('promotion.startDate')}}" name = "start_date" required = "true" value="{{isset($promotions) ? $promotions->start_date : Input::get('start_date')}}" @include('form.readonly')>
                @include('errors.field', ['field' => 'start_date'])
          </div>
        </div>
        <!--Asignar Fecha de Finalizacion a Promocion-->
        <div class="form-group row @include('errors.field-class', ['field' => 'end_date'])">
          <label class="col-lg-3 control-label">{{trans('promotion.endDate')}}</label>
          <div class="col-lg-9">
                <input class = "form-control" id="dtpe" placeholder = "{{trans('promotion.endDate')}}" name = "end_date" required = "true" value="{{isset($promotions) ? $promotions->end_date : Input::get('end_date')}}" @include('form.readonly')>
                @include('errors.field', ['field' => 'end_date'])
          </div>
        </div>
        <!--Asignar a Promocion estatus-->
        @if(!isset($readonly) || $readonly == false)
        <div class="form-group row @include('errors.field-class', ['field' => 'status'])" id="status" >
          <label class="col-lg-3 control-label" id="statusLabel" >{{trans('promotion.status')}}</label>
          <div class="col-lg-9">
            <select style="width:100%;" class="form-control" id="status" name="status" required="true" @include('form.readonly')>
              <option value="1">{{trans('promotion.active')}}</option>
              <option value="0">{{trans('promotion.Inactive')}}</option>
            </select>
                @include('errors.field', ['field' => 'status'])
          </div>
        </div>
        @else
        <div class="form-group row ">
          <label class="col-lg-3 control-label">{{trans('promotion.status')}}</label>
          <div class="col-lg-9">
                <input class = "form-control" id="dtpe" placeholder = "{{trans('promotion.endDate')}}" name = "end_date" required = "true" value="{{isset($promotions) ? ($promotions->status == 0) ? 'inactiva' : 'activa' : Input::get('status')}}" @include('form.readonly')>
                @include('errors.field', ['field' => 'status'])
          </div>
        </div>
        @endif
      </fieldset>
    </form>
  </div>
</div>
