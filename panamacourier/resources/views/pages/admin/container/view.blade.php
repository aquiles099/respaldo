<script type="text/javascript">
$(document).ready( function() {
});

var messag = {
  imp_medition : "{!!trans('package.imp_medition')!!}",
  int_medition : "{!!trans('package.int_medition')!!}"
};

function selectUndInt (){
  $('#ics_load').html(messag.int_medition);
  $('#unidad').val('1');
  $('#large_span').html('m');
  $('#width_span').html('m');
  $('#height_span').html('m');
  $('#large_door').html('m');
  $('#width_door').html('m');
  $('#cube_capacity').html('m<sup>3</sup>');
  $('#max_weight').html('kg');
  $('#volumem').html('m<sup>3</sup>');
  $('#volumea').html('Vkg');
  $('#weight_span').html('kg');
}

function selectUndImperial (){
  $('#ics_load').html(messages.imp_medition);
  $('#unidad').val('0');
  $('#large_span').html('ft');
  $('#width_span').html('ft');
  $('#height_span').html('ft');
  $('#large_door').html('ft');
  $('#width_door').html('ft');
  $('#cube_capacity').html('ft<sup>3</sup>');
  $('#max_weight').html('lb');
  $('#volumem').html('ft<sup>3</sup>');
  $('#volumea').html('Vlb');
  $('#weight_span').html('lb');
}
</script>
@include('sections.translate')

<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    <form role="form" action="" method="" id="formSerial">
      @if(isset($container))
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
      @endif
      <input type="hidden" id="unidad" name="unidad" value="{{(isset($container) && $container->unidad == 1) ? 1 : 0}}">
      <fieldset class="form">
        <div class="col-md-12">
          <div class="breadcrumb" >
                <div class="dropdown" >
                  <a class="dropdown-toggle" type="button" data-toggle="dropdown" id="ics_link_dropdown">
                    <span class="text-muted" data-toggle="tooltip" title="{{trans('shipment.type')}}">
                      <i class="fa fa-eye" aria-hidden="true"></i>
                      <span class="" id="ics_load">{{(isset($numberparts) && $numberparts->unidad == 1) ? trans('package.int_medition') : trans('package.imp_medition')}}</span>
                      <span id="ics_selected_item"></span>
                      <span class="caret"></span>
                    </span>
                  </a>
                  <ul class="dropdown-menu" id="">
                    <li class="ics_set_pointer_on_form"><a onclick="selectUndImperial()">{{trans('package.imp_medition')}}</a></li>
                    <li class="ics_set_pointer_on_form"><a onclick="selectUndInt()">{{trans('package.int_medition')}}</a></li>
                  </ul>
                </div>
          </div>
        </div>
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('container.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control form_dimension" placeholder="{{trans('container.name')}}" name="name" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($container) ? ucwords($container->name ): clear(Input::get('name'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>
        <!-- LARGE-->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('container.large')}}</label>
          <div class="col-lg-9">
            <input class="form-control form_dimension" placeholder="{{trans('container.large')}}" name="large" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($container) ? $container->large : clear(Input::get('large'))}}" @include('form.readonly')>
            <span id="large_span"> {{(isset($container) && $container->unidad == 1) ? 'cm' : 'in'}}</span>
            @include('errors.field', ['field' => 'large'])
          </div>
        </div>
        <!-- width-->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('container.width')}}</label>
          <div class="col-lg-9">
            <input class="form-control form_dimension" placeholder="{{trans('container.width')}}" name="width" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($container) ? $container->width : clear(Input::get('width'))}}" @include('form.readonly')>
            <span id="width_span"> {{(isset($container) && $container->unidad == 1) ? 'cm' : 'in'}}</span>
            @include('errors.field', ['field' => 'width'])
          </div>
        </div>
        <!-- HEIGHT-->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('container.height')}}</label>
          <div class="col-lg-9">
            <input class="form-control form_dimension" placeholder="{{trans('container.height')}}" name="height" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($container) ? $container->height : clear(Input::get('height'))}}" @include('form.readonly')>
            <span id="height_span"> {{(isset($container) && $container->unidad == 1) ? 'cm' : 'in'}}</span>
            @include('errors.field', ['field' => 'height'])
          </div>
        </div>
        <!-- LARGE DOOR-->
        <div class="form-group row @include('errors.field-class', ['field' => 'large_door'])">
          <label class="col-lg-3 control-label">{{trans('Alto de la puerta')}}</label>
          <div class="col-lg-9">
            <input class="form-control form_dimension" placeholder="{{trans('Alto de la puerta')}}" name="large_door" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($container) ? $container->large_door : clear(Input::get('large_door'))}}" @include('form.readonly')>
            <span id="large_door"> {{(isset($numberparts) && $numberparts->unidad == 1) ? 'm' : 'ft'}}</span>
            @include('errors.field', ['field' => 'large'])
          </div>
        </div>
        <!-- WIDTH DOOR-->
        <div class="form-group row @include('errors.field-class', ['field' => 'width_door'])">
          <label class="col-lg-3 control-label">{{trans('Ancho de la puerta')}}</label>
          <div class="col-lg-9">
            <input class="form-control form_dimension" placeholder="{{trans('Ancho de la puerta')}}" name="widht_door" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($container) ? $container->widht_door : clear(Input::get('widht_door'))}}" @include('form.readonly')>
            <span id="width_door"> {{(isset($numberparts) && $numberparts->unidad == 1) ? 'm' : 'ft'}}</span>
            @include('errors.field', ['field' => 'width'])
          </div>
        </div>
        <!-- CUBE CAPACITY-->
        <div class="form-group row @include('errors.field-class', ['field' => 'cube_capacity'])">
          <label class="col-lg-3 control-label">{{trans('Capacidad cúbica')}}</label>
          <div class="col-lg-9">
            <input class="form-control form_dimension" placeholder="{{trans('Capacidad cúbica')}}" name="cube_capacity" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($container) ? $container->cube_capacity : clear(Input::get('cube_capacity'))}}" @include('form.readonly')>
            <span id="cube_capacity"> {{(isset($numberparts) && $numberparts->unidad == 1) ? 'm3' : 'ft3'}}</span>
            @include('errors.field', ['field' => 'width'])
          </div>
        </div>
        <!-- MAX LOAD WEIGHT-->
        <div class="form-group row @include('errors.field-class', ['field' => 'max_weight'])">
          <label class="col-lg-3 control-label">{{trans('Peso máximo soportado')}}</label>
          <div class="col-lg-9">
            <input class="form-control form_dimension" placeholder="{{trans('Peso máximo soportado')}}" name="max_weight" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($container) ? $container->max_weight : clear(Input::get('max_weight'))}}" @include('form.readonly')>
            <span id="max_weight"> {{(isset($numberparts) && $numberparts->unidad == 1) ? 'kg' : 'lb'}}</span>
            @include('errors.field', ['field' => 'width'])
          </div>
        </div>
        <!-- info-->
        <div class="form-group row @include('errors.field-class', ['field' => 'info'])">
          <label class="col-lg-3 control-label">{{trans('Caracteristicas adicionales')}}</label>
          <div class="col-lg-9">
            <textarea style="height:90px;" class="form-control form_dimension" placeholder="{{trans('Caracteristicas adicionales')}}" name="info" type="text" autofocus maxlength="200" value="{{isset($container) ? $container : clear(Input::get('info'))}}" @include('form.readonly') rows="8" cols="80">{{isset($container) ? $container->info : clear(Input::get('info'))}}</textarea>
            @include('errors.field', ['field' => 'info'])
          </div>
        </div>
    </form>
  </div>
</div>
