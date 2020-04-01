<form class="form" role="form" action="{{asset($path)}}" method="post" enctype="multipart/form-data" files="true" data-toggle="validator">
  <fieldset>
    @if(isset($prealert))
      <input type="hidden" name="_method" value="patch">
    @endif
    <input type="hidden" id="unidad" name="unidad" value="{{(isset($package) && $package->unidad == 1) ? 1 : 0}}">
    <div class="col-md-12">
      <div class="breadcrumb" >
            <div class="dropdown" >
              <a class="dropdown-toggle" type="button" data-toggle="dropdown" id="ics_link_dropdown">
                <span class="text-muted" data-toggle="tooltip" title="{{trans('shipment.type')}}">
                  <i class="fa fa-eye" aria-hidden="true"></i>
                  <span class="" id="ics_load">{{(isset($package) && $package->unidad == 1) ? 'Sistema Internacional de Unidades' : 'Sistema de Medidas Imperial'}}</span>
                  <span id="ics_selected_item"></span>
                  <span class="caret"></span>
                </span>
              </a>
              <ul class="dropdown-menu" id="">
                <li class="ics_set_pointer_on_form"><a onclick="selectUndImperial()">{{'Sistema de Medidas Imperial'}}</a></li>
                <li class="ics_set_pointer_on_form"><a onclick="selectUndInt()">{{'Sistema Internacional de Unidades'}}</a></li>
              </ul>
            </div>
      </div>
    </div>
    <!--courier select-->
    <div class="form-group row @include('errors.field-class', ['field' => 'courier'])">
      <div class="col-lg-2">
        <label for="courierSelect">{{trans('messages.carrier')}}</label>
      </div>
      <div class="col-lg-4">
        <select class="form-control" id="courierSelect" name="courier" style="width: 100% !important" autofocus="true">
          @foreach ($couriers as $key => $courier)
            <option {{isset($prealert) && $prealert->courier == $courier->id ? 'selected' : '' }} value="{{$courier->id}}">{{strtoupper($courier->name)}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'courier'])
      </div>
      <label class="col-lg-2 control-label" id="typeLabel" >{{trans('Tipo de servicio')}}</label>
      <div class="col-lg-4">
        <select class="form-control form_dimension" id="type" name="type">
          <option value="0">Seleccione</option>
          @foreach($types as $key => $type)
            <option {{((isset($type)) && (isset($prealert)) && ($type->id == $prealert->type)) ? 'selected' : ''}} value="{{$type->id}}">{{ucwords($type->spanish)}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'type'])
      </div>
    </div>
    <!--provider-->
    <div class="form-group row @include('errors.field-class', ['field' => 'provider'])">
      <div class="col-lg-2">
        <label for="courierSelect">{{trans('prealert.provider')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('prealert.infoprovider')}}"></i></label>
      </div>
      <div class="col-lg-4">
        <input class="form-control" placeholder="{{trans('prealert.provider')}}" id="provider" name="provider" type="text" required="true" value="{{isset($prealert) ? $prealert->provider : clear(Input::get('provider'))}}" >
        @include('errors.field', ['field' => 'provider'])
      </div>
      <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.large')}}</label>
      <div class="col-lg-4">
        <input type="number" class="form-control form_dimension" placeholder="{{trans('package.large')}}" id="large" name="large" onkeyup="pesovol()" type="float" maxlength="10" min="1"  value="{{isset($prealert) ? $prealert->large : clear(Input::get('large'))}}" @include('form.readonly')>
        <span id="large_span" >{{(isset($prealert) && $prealert->unidad == 1) ? 'cm' : 'in'}}</span>
        @include('errors.field', ['field' => 'large'])
      </div>
    </div>
    <!--service order-->
    <div class="form-group row @include('errors.field-class', ['field' => 'order_service'])" id="">
      <div class="col-lg-2">
        <label for="service_order">{{trans('messages.service_order')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('prealert.infoorder')}}"></i></label>
      </div>
      <div class="col-lg-4">
        <input class="form-control" placeholder="{{trans('messages.service_order')}}" id="service_order" name="order_service" type="text" required="true" value="{{isset($prealert) ? $prealert->order_service : clear(Input::get('order_service'))}}" >
        @include('errors.field', ['field' => 'order_service'])
      </div>
      <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.width')}}</label>
      <div class="col-lg-4">
        <input type="number" class="form-control form_dimension" placeholder="{{trans('package.width')}}" id="width" name="width" type="float" maxlength="10" min="1"  value="{{isset($prealert) ? $prealert->width : clear(Input::get('width'))}}" @include('form.readonly')>
        <span id="width_span">{{(isset($prealert) && $prealert->unidad == 1) ? 'cm' : 'in'}}</span>
        @include('errors.field', ['field' => 'width'])
     </div>
    </div>
    <!--value-->
    <div class="form-group row @include('errors.field-class', ['field' => 'value'])" id="">
      <div class="col-lg-2">
        <label for="value">{{trans('messages.value')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{trans('prealert.infovalue')}}"></i></label>
      </div>
      <div class="col-lg-4">
        <input class="form-control" placeholder="{{trans('messages.value')}} $" id="value" name="value" type="text"  required="true" value="{{isset($prealert) ? $prealert->value : clear(Input::get('value'))}}" >
        @include('errors.field', ['field' => 'value'])
      </div>
      <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.height')}}</label>
      <div class="col-lg-4">
        <input type="number" class="form-control form_dimension" placeholder="{{trans('package.height')}}" id="height1" onkeyup="pesovol()" name="height1" type="float" maxlength="10" min="1"  value="{{isset($prealert) ? $prealert->height : clear(Input::get('height'))}}"
        @include('form.readonly')>
        <span id="height">{{(isset($prealert) && $prealert->unidad == 1) ? 'cm' : 'in'}}</span>
        @include('errors.field', ['field' => 'height'])
      </div>
    </div>
    <!--content-->
    <div class="form-group row @include('errors.field-class', ['field' => 'content'])" id="">
      <div class="col-lg-2">
        <label for="value">{{trans('messages.content')}}</label>
      </div>
      <div class="col-lg-4">
        <input class="form-control" placeholder="{{trans('messages.content')}}" id="content" name="content" type="text"  required="true" value="{{isset($prealert) ? $prealert->content : clear(Input::get('content'))}}" >
        @include('errors.field', ['field' => 'content'])
      </div>
      <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.volumem')}}</label>
      <div class="col-lg-4">
        <input type="number" class="form-control form_dimension" placeholder="{{trans('package.volumem')}}" id="volumetricweightm1" name="volumetricweightm1" type="float" readonly="" maxlength="10" min="1"  value="{{isset($prealert) ? $prealert->volumetricweightm1 : ''}}" @include('form.readonly')>
        <span id="volumem">{{(isset($prealert) && $prealert->unidad == 1) ? 'm3' : 'ft3'}}</span>
        @include('errors.field', ['field' => 'volumetricweight'])
      </div>
    </div>
    <!--arrivedate-->
    <div class="form-group row @include('errors.field-class', ['field' => 'date_arrived'])" id="">
      <div class="col-lg-2">
        <label for="value">{{trans('messages.arrivedate')}}</label>
      </div>
      <div class="col-lg-4">
          <div class="input-group">
            <input class="form-control" placeholder="{{trans('messages.arrivedate')}}" id="arrivedate" name="date_arrived" type="text"  required="true" value="{{isset($prealert) ? $prealert->date_arrived : clear(Input::get('date_arrived'))}}" >
            <span class = "input-group-addon">
              <i aria-hidden="true" class="fa fa-calendar"></i>
            </span>
          </div>
            @include('errors.field', ['field' => 'date_arrived'])
      </div>
      <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.volumea')}}</label>
      <div class="col-lg-4">
        <input type="number" class="form-control form_dimension" placeholder="{{trans('package.volumea')}}" id="volumetricweighta1" name="volumetricweighta1" type="float" readonly="" maxlength="10" min="1"  value="{{isset($prealert) ? $prealert->volumetricweighta1 : ''}}" @include('form.readonly')>
        <span id="volumea">{{(isset($prealert) && $prealert->unidad == 1) ? 'Vkg' : 'Vlb'}}</span>
        @include('errors.field', ['field' => 'volumetricweight'])
      </div>
    </div>
    <!--{{--Archivo a Subir--}}-->
    <div class="form-group row @include('errors.field-class', ['field' => 'file'])">
      <div class="col-lg-2">
        <label for="upload-photo" id="label">{{trans('messages.selectfile')}}</label>
      </div>
      <div class="{{isset($removable) && $removable == true ? 'col-lg-4' : 'col-lg-4' }}">
        <input style="padding-left: 0px" type="file" class="hidden2"  name="file" id="upload_file" accept=".pdf, image/*" onchange="preview_image()"  multiple="false">
        @include('sections.errors', ['errors' =>  $errors, 'name' => 'file'])
      </div>
      <label class="col-lg-2 control-label " id="typeLabel" >{{trans('package.weight')}}</label>
      <div class="col-lg-4">
        <input type="number" class="form-control form_dimension" placeholder="{{trans('package.weight')}}" id="weight1" onkeyup="pesovol()" name="weight1" type="float" maxlength="10" min="1"  value="{{isset($prealert) ? $prealert->weight : clear(Input::get('weight'))}}" @include('form.readonly')>
        <span id="weight">{{(isset($prealert) && $prealert->unidad == 1) ? 'kg' : 'lb'}}</span>
        @include('errors.field', ['field' => 'weight'])
      </div>
      @if(isset($prealert))
        <div class="{{isset($removable) && $removable == true ? 'col-lg-3' : 'col-lg-4' }}">
            <div class="breadcrumb">
              <i aria-hidden="true" class="fa fa-file-o"></i>
              <strong>{{trans('prealert.associatedfile')}}: </strong>
              <span class="text-muted">{{isset($prealert->getFile) ? $prealert->getFile->name : trans('prealert.notFile') }}</span>
            </div>
        </div>
      @endif
    </div>
    <!--{{--Archivo a Subir--}}-->
    <div>
      <div class="col-lg-3">
      </div>
      <div class="co-lg-9">
        <div id="image_preview" ></div>
      </div>
    </div>
    <!---->
    @if(isset($prealert))
    <div class="pull-left text-muted">
      <i aria-hidden="true" class="fa fa-eye"></i>
      {{strtoupper(trans('prealert.notificationsprealert'))}}
    </div>
    @endif
    <!---->
    <div class="form-group">
      <span class="pull-left">
        <div id="divload"></div>
      </span>
      <span class="pull-right">
        <button  type="submit" class="btn btn-primary">{{trans('messages.send')}} </button>
      </span>
    </div>
  </fieldset>
</form>
