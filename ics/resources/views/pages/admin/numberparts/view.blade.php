<script type="text/javascript">
$(document).ready( function() {
});

function selectUndInt (){
  $('#ics_load').html('Sistema Internacional de Unidades');
  $('#unidad').val('1');
  $('#large_span').html('cm');
  $('#width_span').html('cm');
  $('#height_span').html('cm');
  $('#volumem').html('m<sup>3</sup>');
  $('#volumea').html('Vkg');
  $('#weight_span').html('kg');
}

function selectUndImperial (){
  $('#ics_load').html('Sistema de Medidas Imperial');
  $('#unidad').val('0');
  $('#large_span').html('in');
  $('#width_span').html('in');
  $('#height_span').html('in');
  $('#volumem').html('ft<sup>3</sup>');
  $('#volumea').html('Vlb');
  $('#weight_span').html('lb');
}
</script>
@include('sections.translate')
<div class="panel panel-default" id="pnlft">
<form class="form" action="" method="post" id="formSerial">
  @if(isset($numberparts))
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
  @endif
  <div class="panel-body">
    <input type="hidden" id="unidad" name="unidad" value="{{(isset($numberparts) && $numberparts->unidad == 1) ? 1 : 0}}">
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
                  <li class="ics_set_pointer_on_form"><a onclick="selectUndImperial()">{{trans('package.package.imp_medition')}}</a></li>
                  <li class="ics_set_pointer_on_form"><a onclick="selectUndInt()">{{trans('package.int_medition')}}</a></li>
                </ul>
              </div>
        </div>
      </div>
    <div class="row">
      <div class="col-md-8">
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.name')}}" name="name" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->name : clear(Input::get('name'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>

        <!---->
        <div class="form-group row @include('errors.field-class', ['field' => 'description'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.description')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.description')}}" name="description" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->description : clear(Input::get('description'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'description'])
          </div>
        </div>

        <!---->
        <div class="form-group row @include('errors.field-class', ['field' => 'customer'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.customer')}}</label>
          <div class="col-lg-9">
          <select style="width: 100%;" class="form-control" name="customer">
            <option value="0">{{trans('pickup.selectOption')}}</option>
            @foreach($clients as $key => $client)
              <option {{isset($numberparts)&&($numberparts->customer == $client->id) ? 'selected' : ''}} value="{{$client->id}}">{{ucwords($client->name.' '.$client->last_name)}}</option>
            @endforeach
          </select>
          @include('errors.field', ['field' => 'customer'])
          </div>
        </div>

        <div class="form-group row @include('errors.field-class', ['field' => 'manufacturer'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.manufacturer')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.manufacturer')}}" name="manufacturer" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->manufacturer : clear(Input::get('manufacturer'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'manufacturer'])
          </div>
        </div>

        <div class="form-group row @include('errors.field-class', ['field' => 'model'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.model')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.model')}}" name="model" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->model : clear(Input::get('model'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'manufacturer'])
          </div>
        </div>

        <div class="form-group row @include('errors.field-class', ['field' => 'package'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.package')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.package')}}" name="package" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->package : clear(Input::get('package'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'package'])
          </div>
        </div>

        <div class="form-group row @include('errors.field-class', ['field' => 'pieces'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.pieces')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.pieces')}}" name="pieces" type="number" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->pieces : clear(Input::get('pieces'))}}" @include('form.readonly')>
              @include('errors.field', ['field' => 'pieces'])
          </div>
        </div>

        <div class="form-group row @include('errors.field-class', ['field' => 'sku'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.sku')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.sku')}}" name="sku" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->sku : clear(Input::get('sku'))}}" @include('form.readonly')>
                @include('errors.field', ['field' => 'sku'])
          </div>
        </div>

        <div class="form-group row @include('errors.field-class', ['field' => 'note'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.note')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.note')}}" name="note" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->note : clear(Input::get('note'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'note'])
          </div>
        </div>



      </div>

      <div class="col-md-4">
        <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'large'])"  id="divlarge" >
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.large')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.large')}}" id="large" name="large" onkeyup="pesovol()" type="float" maxlength="10" min="1" required="true" value="{{isset($numberparts) ? $numberparts->large : clear(Input::get('large'))}}" @include('form.readonly')>
                  <span id="large_span"> {{(isset($numberparts) && $numberparts->unidad == 1) ? 'cm' : 'in'}}</span>
                  @include('errors.field', ['field' => 'large'])
                </div>
              </div>

              <div class="dimensmedidas  @include('errors.field-class', ['field' => 'width'])" onkeyup="pesovol()" id="divwidth">
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.width')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.width')}}" id="width" name="width" type="float" maxlength="10" min="1" required="true" value="{{isset($numberparts) ? $numberparts->width : clear(Input::get('width'))}}" @include('form.readonly')>
                  <span id="width_span"> {{(isset($numberparts) && $numberparts->unidad == 1) ? 'cm' : 'in'}}</span>
                  @include('errors.field', ['field' => 'width'])
               </div>
              </div>

              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.height')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.height')}}" id="height" onkeyup="pesovol()" name="height" type="float" maxlength="10" min="1" required="true" value="{{isset($numberparts) ? $numberparts->height : clear(Input::get('height'))}}"
                  @include('form.readonly')>
                  <span id="height_span"> {{(isset($numberparts) && $numberparts->unidad == 1) ? 'cm' : 'in'}}</span>
                  @include('errors.field', ['field' => 'height'])
                </div>
              </div>

              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.volumem')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.volumem')}}" id="volumetricweightm" onkeyup="pesovol()" name="volumetricweightm" type="float" readonly="" maxlength="10" min="1" required="true" value="{{isset($numberparts) ? $numberparts->volumetricweightm : clear(Input::get('volumetricweightm'))}}" @include('form.readonly')>
                  <span id="volumem">{{(isset($numberparts) && $numberparts->unidad == 1) ? 'm3' : 'ft3'}}</span>
                  @include('errors.field', ['field' => 'volumetricweight'])
                </div>
              </div>


              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.volumea')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.volumea')}}" id="volumetricweighta" onkeyup="pesovol()" name="volumetricweighta" type="float" readonly="" maxlength="10" min="1" required="true" value="{{isset($numberparts) ? $numberparts->volumetricweighta : clear(Input::get('volumetricweighta'))}}" @include('form.readonly')>
                  <span style="font-size: 11px;" id="volumea">{{(isset($numberparts) && $numberparts->unidad == 1) ? 'Vkg' : 'Vlb'}}</span>
                  @include('errors.field', ['field' => 'volumetricweight'])
                </div>
              </div>

              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                <label class="col-lg-3 control-label " id="typeLabel" >{{trans('package.weight')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.weight')}}" id="weight" onkeyup="pesovol()" name="weight" type="float" maxlength="10" min="1" required="true" value="{{isset($numberparts) ? $numberparts->weight : clear(Input::get('weight'))}}" @include('form.readonly')>
                  <span id="weight_span">{{(isset($numberparts) && $numberparts->unidad == 1) ? 'kg' : 'lb'}}</span>
                  @include('errors.field', ['field' => 'weight'])
                </div>
              </div>

      </div>
    </div>




  </fieldset>
  </div>
