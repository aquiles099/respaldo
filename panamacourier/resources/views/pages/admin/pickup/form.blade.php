<?php
  use App\Helpers\HUserType;
?>
<script type="text/javascript">
/**
 * [selectUndInt description]
 * @return [type] [description]
 */
function selectUndInt () {
  $('#ics_load').html('Sistema Internacional de Unidades');
  $('#unidad').val('1');
  $('#large_span').html('cm');
  $('#width_span').html('cm');
  $('#height_span').html('cm');
  $('#volumem').html('m<sup>3</sup>');
  $('#volumea').html('Vkg');
  $('#weight_span').html('kg');

  var count = $('#countpack').val();
  for (var i = 0; i <= count; i++) {

    $('#large'+i).val(($('#large'+i).val() / 0.39370).toFixed(2));
    $('#width'+i).val(($('#width'+i).val() / 0.39370).toFixed(2));
    $('#height'+i).val(($('#height'+i).val() / 0.39370).toFixed(2));
    pesovol();
    $('#weight'+i).val(($('#weight'+i).val() / 2.2046).toFixed(2));
  }
}
/**
 * [selectUndImperial description]
 * @return [type] [description]
 */
function selectUndImperial (){
  $('#ics_load').html('Sistema de Medidas Imperial');
  $('#unidad').val('0');
  $('#large_span').html('in');
  $('#width_span').html('in');
  $('#height_span').html('in');
  $('#volumem').html('ft<sup>3</sup>');
  $('#volumea').html('Vlb');
  $('#weight_span').html('lb');

  var count = $('#countpack').val();
  for (var i = 0; i <= count; i++) {

    $('#large'+i).val(($('#large'+i).val() * 0.39370).toFixed(2));
    $('#width'+i).val(($('#width'+i).val() * 0.39370).toFixed(2));
    $('#height'+i).val(($('#height'+i).val() * 0.39370.toFixed(2)));
    pesovol();
    $('#weight'+i).val(($('#weight'+i).val() * 2.2046.toFixed(2)));
  }
}
/**
 * [pesovol description]
 * @return [type] [description]
 */
function pesovol(){
  var count = $('#countpack').val();
  for (step = 1; step <= count; step++) {
   var larg=$("#pick"+step+" "+"#large"+step).val();
   var anch=$("#pick"+step+" "+"#width"+step).val();
   var alto=$("#pick"+step+" "+"#height"+step).val();
   var resultm=(larg*anch*alto)/1728;
   var resulta=(larg*anch*alto)/166;
   if (count ==1) {
     $("#pick"+step+" "+"#volumetricweightm").val((resultm.toFixed(2)).toString());
     $("#pick"+step+" "+"#volumetricweighta").val((resulta.toFixed(2)).toString());
   } else {
     $("#pick"+step+" "+"#volumetricweightm"+step).val((resultm.toFixed(2)).toString());
     $("#pick"+step+" "+"#volumetricweighta"+step).val((resulta.toFixed(2)).toString());
   }
   //console.log('calculando large: '+ larg+' anch:'+ anch+' alto:'+ alto+' mar:'+resultm+' aer:'+resulta+"\n");
  }
}
</script>

<div class="panel panel-default">
  <div class="panel-body">
    <form role="form" action="{{ asset( $path )}}" method="post" onsubmit="createLoad()" novalidate enctype="multipart/form-data">
      @if ( isset($pickup) )
        <input type="hidden" name="_method" value="patch">
      @endif
      <input type="hidden" id="unidad" name="unidad" value=" {{(isset($numberparts->unidad) && $numberparts->unidad == 1) ? 1 : 0}} ">
        <fieldset class="form">
          <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#ics_tab_home">{{trans('pickup.entities')}} <span><i class="fa fa-user" aria-hidden="true"></i></span></a></li>
            <li><a data-toggle = "tab" href="#ics_tab_menu1">{{trans('booking.chargeInformation')}} <span><i class="fa fa-cubes" aria-hidden="true"></i></span></a></li>
            <li><a data-toggle = "tab" href="#ics_tab_menu2">{{trans('pickup.general_info')}} <span><i class="fa fa-exchange" aria-hidden="true"></i></span></a></li>
            <li><a data-toggle = "tab" href="#ics_tab_menu3">{{trans('transporters.attchments')}} <span><i class="fa fa-cloud-upload" aria-hidden="true"></i></span></a></li>
          </ul>
          <div class="tab-content" style="height:560px">
            <!-- Tab 1 -->
            <div id="ics_tab_home" class="tab-pane fade in active">
              <div class="panel panel-default" >
                <!---->
                <div class="panel-heading text-muted">
                  <span><i class="fa fa-user" aria-hidden="true"></i></span>
                </div>
                <!---->
                <div class="row" style="padding: 0 20px 0px 20px;">
                  <div class="col-md-6">
                    <div class="breadcrumbpack">
                      <span>{{trans('pickup.userconsigner')}}</span>
                    </div>
                    <!---->
                    <div class="form-group row @include('errors.field-class', ['field' => 'finalOriginUser'])" id="destination" style="display:block;"}}>
                      <label class="col-lg-3 control-label">{{trans('pickup.userconsigner')}}</label>
                      <div class="col-lg-9">
                        <select style="width:100%;" class="form-control" id="exporter" name="exporter"  @include('form.readonly') >
                          <option value="0" item="0">{{trans('pickup.chooseUser')}}</option>
                          @foreach ($users as $user)
                            @if($user->id != 0)
                              <option {{(isset($pickup) ? $pickup->consigner_user : Input::get('exporter')) == $user->id ? 'selected' : ''}} item="{{$user}}" value="{{$user->id}}">{{ucwords($user->name.' '.$user->last_name)}}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <!--  -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.country')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" placeholder="{{trans('package.country')}}" id="cons_country" name="cons_country" type="text" maxlength="250" min="5" readonly="true" value="{{isset($pickup->country_shipper) ? $pickup->country_shipper : clear(Input::get('cons_country'))}}" @include('form.readonly')>
                        @include('errors.field', ['field' => 'direction'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.region')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" placeholder="{{trans('package.region')}}" id="cons_region" name="cons_region" type="text" maxlength="250" min="5" readonly="true" value="{{isset($pickup->region_shipper) ? $pickup->region_shipper : clear(Input::get('cons_region'))}}" @include('form.readonly')>
                        @include('errors.field', ['field' => 'direction'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.city')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" readonly="true" placeholder="{{trans('package.city')}}" id="cons_city" name="cons_city" type="text" maxlength="250" min="5"  value="{{isset($pickup->city_shipper) ? $pickup->city_shipper : clear(Input::get('city'))}}" @include('form.readonly')>
                        @include('errors.field', ['field' => 'direction'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.clientDirection')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" placeholder="{{trans('package.clientDirection')}}" id="cons_direction" name="cons_direction" type="text" maxlength="250" min="5" readonly="true" value="{{isset($pickup->address_shipper) ? $pickup->address_shipper : clear(Input::get('direction'))}}" @include('form.readonly')>
                        @include('errors.field', ['field' => 'direction'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'phone'])" id="clientPhone" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.phone')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" placeholder="{{trans('package.phone')}}" id="cons_phone" name="cons_phone" type="text" maxlength="250" min="5" readonly="true" value="{{isset($pickup) ? $pickup->shipper_phone : clear(Input::get('phone'))}}" @include('form.readonly')>
                        @include('errors.field', ['field' => 'direction'])
                      </div>
                    </div>
                    <!---->
                    <div class="form-group row @include('errors.field-class', ['field' => 'another'])" id="anotherDirection" >
                      <label class="col-lg-3 control-label" id="labelanotherDirection" >{{trans('pickup.ubication')}}</label>
                      <div class="col-lg-9">
                        <select style="width:100%;" id="exporter_dir"class="form-comtrol form_dimension" name="">
                          <option {{(isset($pickup)&&($pickup->location_shipper == 0))? 'selected' : ''}} value="0">{{trans('pickup.registered_address')}}</option>
                          <option {{(isset($pickup)&&($pickup->location_shipper == 1))? 'selected' : ''}} value="1">{{trans('pickup.another_address')}}</option>
                        </select>
                        @include('errors.field', ['field' => 'anotherdirection'])
                      </div>
                    </div>
                  </div>
                  <!-- CONSIGNATARIO-->
                  <div class="col-md-6">
                    <div class="breadcrumbpack">
                      <span>{{ trans('package.destinationInfo') }}</span>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'consigner'])" id="destination" style="display:block;"}}>
                      <label class="col-lg-3 control-label">{{trans('package.destination')}}</label>
                      <div class="col-lg-9" id="destin_select">
                        <select style="width:100%;" class="form-control" id="consigner" name="consigner" >
                        <option value="">{{trans('package.chooseClient')}}</option>
                          @foreach ($users as $user)
                            @if($user->id != 0)
                              <option {{(isset($pickup) ? $pickup->to_user : Input::get('consigner')) == $user->id ? 'selected' : ''}} item="{{$user}}" value="{{$user->id}}">{{ucwords($user->name.' '.$user->last_name)}}</option>
                            @endif
                          @endforeach
                          <option value="0" {{(isset($pickup))&&($pickup->to_user == 0) ? 'selected' : ''}}>{{trans('messages.other')}}</option>
                        </select>
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'name']) {{ isset($pickup) && ($pickup->to_user != '0') ? 'hidden' : ''}}" id="clientName" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('messages.name')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" placeholder="{{trans('messages.name')}}" id="destin_name" name="destin_name" type="text" maxlength="250" min="5" value="{{isset($pickup->destin_name) ? ($pickup->to_user == 0) ? ($pickup->destin_name) : isset($usercons->name) : clear(Input::get('destin_name'))}}" @include('form.readonly')>
                        @include('errors.field', ['field' => 'destin_country'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.country')}}</label>
                      <div class="col-lg-9">
                        <select class="form-control" id="destin_country" name="destin_country">
                          <option value="">{{trans('pickup.selectOption')}}</option>
                          @foreach ($countries as $country)
                            <option @if ( isset( $cookie ) && ( $cookie ) ) {{ ($cookie['country'] == $country->id) ? 'selected' : '' }} value="{{ $cookie['country'] }}"  @else {{ ((isset($pickup->country_consig)) && ($pickup->country_consig == ($country->id))) ? 'selected' : '' }} value="{{ $country->id }}"  @endif>{{ isset($country) ? ucfirst($country->name) : '' }}</option>
                          @endforeach
                        </select>
                        @include('errors.field', ['field' => 'destin_country'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.region')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" placeholder="{{trans('package.region')}}" id="destin_region" name="destin_region" type="text" maxlength="250" min="5" readonly="true" value="{{isset($pickup) ? $pickup->region_consig : clear(Input::get('destin_region'))}}" @include('form.readonly')>
                        @include('errors.field', ['field' => 'destin_region'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.city')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" readonly="true" placeholder="{{trans('package.city')}}" id="destin_city" name="destin_city" type="text" maxlength="250" min="5"  value="{{isset($pickup) ? $pickup->city_consig : clear(Input::get('city'))}}" @include('form.readonly')>
                        @include('errors.field', ['field' => 'destin_city'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.clientDirection')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" placeholder="{{trans('package.clientDirection')}}" id="destin_direction" name="destin_direction" type="text" maxlength="250" min="5" readonly="true" value="{{isset($pickup) ? $pickup->address_consig : clear(Input::get('destin_direction'))}}" @include('form.readonly')>
                        @include('errors.field', ['field' => 'destin_direction'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'phone'])" id="clientPhone" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.phone')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" placeholder="{{trans('package.phone')}}" id="destin_phone" name="destin_phone" type="text" maxlength="250" min="5" readonly="true" value="{{isset($pickup->destin_phone) ? $pickup->destin_phone : clear(Input::get('destin_phone'))}}" @include('form.readonly')>
                        @include('errors.field', ['field' => 'direction'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'another'])" id="anotherDirection" >
                      <label class="col-lg-3 control-label" id="labelanotherDirection" >{{trans('pickup.deliver_ubication')}}</label>
                      <div class="col-lg-9">
                        <select style="width:100%;" id="consigner_dir" class="form-comtrol form_dimension" name="">
                          <option {{ (isset($pickup)&&($pickup->location_consig == 0))? 'selected' : ''}} value="0"> {{ trans('pickup.registered_address') }}</option>
                          <option {{ (isset($pickup)&&($pickup->location_consig == 1))? 'selected' : ''}} value="1"> {{ trans('pickup.another_address') }}</option>
                        </select>
                        @include('errors.field', ['field' => 'anotherdirection'])
                      </div>
                    </div>
                  </div>
                </div>
                <!---->
                <div class="row" style="padding: 0 20px 0px 20px;">
                  <!-- PROVIDER-->
                  <div class="col-md-6">
                    <div class="breadcrumbpack">
                      <span>{{ trans('pickup.supplier') }}</span>
                    </div>
                    <!---->
                    <div class="form-group row @include('errors.field-class', ['field' => 'supplier'])" id="destination" style="display:block;"}}>
                      <label class="col-lg-3 control-label">{{trans('pickup.supplier')}}</label>
                      <div class="col-lg-9">
                      <select style="width:100%;" class="form-control" id="supplier" name="supplier"  @include('form.readonly') >
                        <option value="0">{{trans('pickup.chooseSupplier')}}</option>
                          @foreach ($suppliers as $supplier)
                          <option {{(isset($pickup) && isset($supplier) && ($supplier->id ==  $pickup->provider))? 'selected' :  ''}} item="{{$supplier->id}}" value="{{$supplier->id}}">{{$supplier->name}}</option>
                        @endforeach
                      </select>
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('pickup.invoice_number')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" placeholder="{{trans('pickup.invoice_number')}}" id="inv_number" name="inv_number" type="text" maxlength="50" min="1"  value="{{isset($pickup) ? $pickup->invoice : clear(Input::get('invoice'))}}")>
                        @include('errors.field', ['field' => 'inv_number'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('pickup.po')}}</label>
                      <div class="col-lg-9">
                      <input class="form-control" placeholder="{{trans('pickup.po')}}" id="purchase_order" name="purchase_order" type="text" maxlength="250" min="5" value="{{isset($pickup) ? $pickup->po_number : clear(Input::get('po_number'))}}">
                      @include('errors.field', ['field' => 'purchase_order'])
                      </div>
                    </div>
                  </div>
                  <!-- TRANSPORTER-->
                  <div class="col-md-6">
                    <div class="breadcrumbpack">
                      <span>{{trans('pickup.transporter')}}</span>
                    </div>
                    <div class="form-group row @include('errors.field-class', ['field' => 'finalDestinationUser'])" id="destination" style="display:block;"}}>
                      <label class="col-lg-3 control-label">{{trans('pickup.transporter')}}</label>
                      <div class="col-lg-9">
                        <select style="width:100%;" class="form-control" id="transporter" name="transporter"  @include('form.readonly') >
                          <option value="0">{{trans('pickup.chooseTransporter')}}</option>
                            @foreach ($transporters as $transporter)
                              @if($transporter->transport == 3)
                              <option {{((isset($transporter)&&(isset($pickup))&&($transporter->id == $pickup->transporter)) ? 'selected' : '')}} item="{{$transporter}}" value="{{$transporter->id}}">{{$transporter->name}}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <!---->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('N° PRO')}}</label>
                      <div class="col-lg-9">
                        <?php
                        if ( isset($pickup) ) {
                          foreach ($transporters as $key => $transporter) {
                            if ($transporter->id == $pickup->transporter) {
                              $trans = ($transporter);
                            }
                          }
                        }
                        ?>
                        <input class="form-control" placeholder="{{trans('N° PRO')}}" id="transporter_pro" name="transporter_pro" type="text" maxlength="250" min="5" readonly="true" value="{{isset($trans) ? $trans->numberscac : clear(Input::get('transporter_pro'))}}" @include('form.readonly')>
                        @include('errors.field', ['field' => 'transporter_pro'])
                      </div>
                    </div>
                    <!---->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('N° Tracking')}}</label>
                      <div class="col-lg-9">
                      <input class="form-control" placeholder="{{trans('N° Tracking')}}" id="tracking_transporter" name="tracking_transporter" type="text" maxlength="250" min="5"  value="{{isset($pickup) ? $pickup->trans_tracking : clear(Input::get('trans_tracking'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'tracking_transporter'])
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Tab 2 -->
            <div id="ics_tab_menu1" class="tab-pane fade">
              <div class="form-group row @include('errors.field-class', ['field' => 'courier'])" id="courier" style="display:none" >
                <label class="col-lg-3 control-label" id="courierLabel" >{{trans('package.couriers')}}</label>
                <div class="col-lg-9">
                <select style="width:100%;" class="form-control" id="courierSelect" name="courierSelect" @include('form.readonly')>
                  @foreach ($couriers as $courier)
                    <option {{(isset($package->from_courier) ? $package->from_courier : Input::get('from_courier')) == $courier->id ? 'selected' : ''}} value="{{$courier->id}}">{{$courier->name}}</option>
                  @endforeach
                </select>
                </div>
              </div>
              <div class="panel panel-default" >
              <div class="panel-heading text-muted">
                <span><i class="fa fa-cubes" aria-hidden="true"></i></span>
                <span class="pull-right">
                  <span class="text-muted">
                    <a role="button" onclick="addpackage()" class="btn btn-primary btn-xs">{{trans('pickup.addpackage')}} <i class="fa fa-plus" aria-hidden="true"></i> </a>
                  </span>
                </span>
              </div>
              <br>
              <div class="col-md-12">
                <div class="dropdown" >
                  <a class="dropdown-toggle" type="button" data-toggle="dropdown" id="ics_link_dropdown">
                  <span class="text-muted" data-toggle="tooltip" title="{{trans('shipment.type')}}">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    <span class="" id="ics_load">{{(isset($numberparts->unidad) && $numberparts->unidad == 1) ? trans('package.int_medition') : trans('package.imp_medition')}}</span>
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
              <!--<div class="row" style="padding: 15px;">
              <button type="button" class="btn btn-primary" style="float: left;margin-left: 15px;" onclick="addpackage()"><i class="fa fa-plus-square" aria-hidden="true"></i> Agregar Paquetes</button>
              </div>-->
              <div class="row" style="padding: 30px 30px 0 30px;">
                <ul class="nav nav-tabs" id="listpack">
                  <li class="paq active"><a data-toggle="tab" href="#pick1"><i class="fa fa-circle-o-notch" aria-hidden="true"></i> PKO 1</a></li>
                </ul>
                <!---->
                <div class="tab-content" id="contentpack">
                  <div id="pick1" class="tab-pane fade in active" style="padding:20px">
                    <div class="row" id="divTracking" style="">
                      <!---->
                      <div class="col-md-8">
                        <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'description'])"  id="divlarge" >
                          <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.description')}}</label>
                          <div class="col-lg-10">
                            <input type="text" class="form-control" placeholder="{{trans('package.description')}}" id="description1" name="description1" type="float" min="1" required="true" value="{{isset($detailspack) ? $detailspack->description : clear(Input::get('description'))}}"
                            @include('form.readonly')>
                            @include('errors.field', ['field' => 'description'])
                          </div>
                        </div>
                        @if(Session::get('key-sesion')['type'] == HUserType::OPERATOR)
                        <div class="dimensmedidas  @include('errors.field-class', ['field' => 'typepickup'])"  id="divlarge" >
                          <div class="row" style="margin-right: 0px;margin-left: 0px;">
                            <div class="col-md-2">
                              <label class="control-label" id="typeLabel" style="line-height: 16px;">{{trans('pickup.typepickup')}}</label >
                            </div>
                            <!---->
                            <div class="col-md-10">
                              <select style="width:100%;"class="form-control" id="typepickup1" name="typepickup1" required="true"  @include('form.readonly')>
                              <option value="">{{trans('pickup.chosetypepk')}}</option>
                              @foreach ($typepickup as $transport)
                              <option {{((isset($pickup->details_type)) && ($transport->id == $pickup->details_type)) ? 'selected' : ''}} item="{{$transport }}" value="{{$transport->id}}"> {{strtoupper($transport->name)}}</option>
                              @endforeach
                              </select>
                              @include('errors.field', ['field' => 'typepickup'])
                            </div>
                          </div>
                        </div>
                        <!---->
                        <div class="hidden dimensmedidas  @include('errors.field-class', ['field' => 'numberparts'])"  id="divlarge" >
                          <div class="row" style="margin-right: 0px;margin-left: 0px;">
                            <div class="col-md-2">
                              <label class="control-label" id="typeLabel" style="line-height: 13px;">{{trans('pickup.numberparts')}}</label >
                            </div>
                            <div class="col-md-10">
                            <select style="width:100%;" class="form-control" id="numberparts1" name="numberparts1" onchange="valselect('1')" required="true"  @include('form.readonly')>
                              <option value="">{{trans('pickup.chosenotnumber')}}</option>
                                @foreach($numberparts as $key => $value)
                              <option item ="{{$value}}" value="{{$value->id}}">{{$value->name}}</option>
                              @endforeach
                            </select>
                            @include('errors.field', ['field' => 'numberparts'])
                            </div>
                          </div>
                        </div>
                        @endif
                        <!---->
                        <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'pieces'])"  id="divlarge" >
                          <label class="col-lg-2 control-label" id="typeLabel" >{{trans('pickup.pieces')}}</label>
                            <div class="col-lg-10">
                              <input type="number" class="form-control" placeholder="{{trans('package.pieces')}}" id="pieces1" name="pieces1" maxlength="10" min="1" required="true" value="{{isset($detailspack) ? $detailspack->large : clear(Input::get('pieces'))}}" @include('form.readonly')>
                            @include('errors.field', ['field' => 'pieces'])
                          </div>
                        </div>
                        <!---->
                        <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'value'])"  id="divlarge" >
                          <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.value')}}</label>
                          <div class="col-lg-10">
                          <input type="number" class="form-control" placeholder="{{trans('package.value')}} ($)" id="valued1" name="valued1"  maxlength="10" min="1" onkeyup="resultvalue()" required="true" value="{{isset($detailspack) ? $detailspack->value : clear(Input::get('value'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'value'])
                          </div>
                        </div>
                        @if(Session::get('key-sesion')['type'] == HUserType::OPERATOR)
                        <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'invoiced'])"  id="divlarge" >
                          <label class="col-lg-2 control-label" id="typeLabel" >{{trans('pickup.invoice_number')}}</label>
                          <div class="col-lg-10">
                            <input type="text" class="form-control" placeholder="{{trans('pickup.invoice_number')}}" id="invoiced1" name="invoiced1" maxlength="10" min="1" required="true" value="{{isset($detailspack) ? $detailspack->value : clear(Input::get('value'))}}" @include('form.readonly')>
                            @include('errors.field', ['field' => 'invoiced'])
                          </div>
                        </div>
                        <!---->
                        <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'tracking'])"  id="divlarge" >
                          <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.tracking')}}</label>
                          <div class="col-lg-10">
                            <input type="text" class="form-control" placeholder="{{trans('package.tracking')}}" id="tracking1" name="tracking1" maxlength="10" min="1" required="true" value="{{isset($detailspack) ? $detailspack->value : clear(Input::get('value'))}}" @include('form.readonly')>
                            @include('errors.field', ['field' => 'invoiced'])
                          </div>
                        </div>
                        @endif
                      </div>
                      <!---->
                      <div class="col-md-4">
                        <!---->
                        <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'large'])"  id="divlarge" >
                          <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.large')}}</label>
                          <div class="col-lg-9">
                            <input type="number" class="form-control form_dimension" placeholder="{{trans('package.large')}}" id="large1" name="large1" onkeyup="pesovol()" type="float" maxlength="10" min="1" required="true"  @if (!isset($cookie)) value="{{isset($detailspack) ? $detailspack->large : clear(Input::get('large'))}}" @else value="{{$cookie['long']}}" @endif @include('form.readonly')>
                            <span id="large_span"> {{(isset($numberparts->unidad) && $numberparts->unidad == 1) ? 'cm' : 'in'}}</span>
                            @include('errors.field', ['field' => 'large'])
                          </div>
                        </div>
                        <!---->
                        <div class="dimensmedidas  @include('errors.field-class', ['field' => 'width'])" onkeyup="pesovol()" id="divwidth">
                          <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.width')}}</label>
                          <div class="col-lg-9">
                            <input type="number" class="form-control form_dimension" placeholder="{{trans('package.width')}}" id="width1" name="width1" type="float" maxlength="10" min="1" required="true" @if(!isset($cookie)) value="{{isset($detailspack) ? $detailspack->width : clear(Input::get('width'))}}" @else value="{{$cookie['width']}}" @endif @include('form.readonly')>
                            <span id="width_span"> {{(isset($numberparts->unidad) && $numberparts->unidad == 1) ? 'cm' : 'in'}}</span>
                            @include('errors.field', ['field' => 'width'])
                          </div>
                        </div>
                        <!---->
                        <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                          <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.height')}}</label>
                          <div class="col-lg-9">
                            <input type="number" class="form-control form_dimension" placeholder="{{trans('package.height')}}" id="height1" onkeyup="pesovol()" name="height1" type="float" maxlength="10" min="1" required="true" @if(!isset($cookie))  value="{{isset($detailspack) ? $detailspack->height : clear(Input::get('height'))}}"  @else value="{{$cookie['heigh']}}" @endif @include('form.readonly')>
                            <span id="height_span"> {{(isset($numberparts->unidad) && $numberparts->unidad == 1) ? 'cm' : 'in'}}</span>
                            @include('errors.field', ['field' => 'height'])
                          </div>
                        </div>
                        <!---->
                        <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                          <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.volumem')}}</label>
                          <div class="col-lg-9">
                            <input type="number" class="form-control form_dimension" placeholder="{{trans('package.volumem')}}" id="volumetricweightm" onkeyup="pesovol()" name="volumetricweightm1" type="float" readonly="" maxlength="10" min="1" required="true" value="{{isset($pickup) ? $pickup->volumetricweightm : clear(Input::get('volumetricweightm1'))}}" @include('form.readonly')>
                            <span id="volumem">{{(isset($numberparts->unidad) && $numberparts->unidad == 1) ? 'm3' : 'ft3'}}</span>
                            @include('errors.field', ['field' => 'volumetricweight'])
                          </div>
                        </div>
                       <!---->
                        <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                          <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.volumea')}}</label>
                          <div class="col-lg-9">
                            <input type="number" class="form-control form_dimension" placeholder="{{trans('package.volumea')}}" id="volumetricweighta" onkeyup="pesovol()" name="volumetricweighta1" type="float" readonly="" maxlength="10" min="1" required="true" value="{{isset($pickup) ? $pickup->volumetricweighta : clear(Input::get('volumetricweighta1'))}}" @include('form.readonly')>
                            <span id="volumea">{{(isset($numberparts->unidad) && $numberparts->unidad == 1) ? 'Vkg' : 'Vlb'}}</span>
                            @include('errors.field', ['field' => 'volumetricweight'])
                          </div>
                        </div>
                        <!---->
                        <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'weight1'])" id="divheight">
                          <label class="col-lg-3 control-label " id="typeLabel" >{{trans('package.weight')}}</label>
                          <div class="col-lg-9">
                            <input type="number" class="form-control form_dimension" placeholder="{{trans('package.weight')}}" id="weight1" onkeyup="pesovol()" name="weight1" type="float" maxlength="10" min="1" required="true" @if(!isset($cookie)) value="{{isset($detailspack) ? $detailspack->weight : clear(Input::get('weight'))}}" @else value="{{$cookie['heigh']}}" @endif @include('form.readonly')>
                            <span id="weight_span">{{(isset($numberparts->unidad) && $numberparts->unidad == 1) ? 'kg' : 'lb'}}</span>
                            @include('errors.field', ['field' => 'weight'])
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
            </div>
            <!-- Tab 3 -->
            <div id="ics_tab_menu2" class="tab-pane fade">
              <div class="panel panel-default" >
                <div class="panel-heading text-muted">
                  <span><i class="fa fa-exchange" aria-hidden="true"></i></span>
                </div>
                <div class="row" style="padding: 25px;">
                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                  @if(Session::get('key-sesion')['type'] == HUserType::OPERATOR)
                  <div class="col-lg-1">
                  </div>
                  <label class="col-lg-2 control-label" id="labelDirection" >{{trans('pickup.collect_number')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control form_dimension" style="width: 88.3%;" placeholder="{{trans('pickup.collect_number')}}" id="pickup_number" name="pickup_number" type="text" maxlength="250" min="5"  value="{{isset($pickup) ? $pickup->pickup_number : clear(Input::get('pickup_number'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'pickup_number'])
                  </div>
                  <br><br>
                  <div class="col-lg-1"></div>
                  <label class="col-lg-2 control-label" id="labelDirection" >{{trans('pickup.addcharge')}}</label>
                  <div class="col-lg-8">
                  <select style="width:100%;" class="form-control form_dimension" id="addcharge" name="addcharge">
                    <option value="0">{{trans('pickup.selectOption')}}</option>
                      @foreach($addcharges as $key => $addcharge)
                      <option {{((isset($pickup))&&($addcharge->id == $pickup->addcharge) ? 'selected' : '' )}} value="{{$addcharge->id}}">{{$addcharge->name}}</option>
                    @endforeach
                  </select>
                  @include('errors.field', ['field' => 'addcharge'])
                  </div>
                  <div class="panel-heading text-muted">
                  <span><br></span>
                  </div>
                  @endif
                  <!--PickUp date and hour-->
                  <div class="form-group form_dimension row @include('errors.field-class', ['field' => 'pickup_date'])" id="type" >
                    <div class="col-lg-1"></div>
                    <label class="col-lg-2 control-label" id="typeLabel" >{{trans('pickup.pickup_date')}}</label>
                    <div class="col-lg-4 @include('errors.field-class', ['field' => 'pickup_date'])">
                      <div class="input-group">
                        <?php $p_date = isset($pickup->pickup_date) ? explode(" ", $pickup->pickup_date): null; ?>
                        <input type="text" class="form-control" id="pickup_date" name="pickup_date" value="{{isset($p_date[0]) ? $p_date[0] : date('Y-m-d')}}" required="true" placeholder ="{{trans('shipment.since')}}" @include('form.readonly')>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                      @include('errors.field', ['field' => 'since_departure_maritime'])
                    </div>
                    <div class="col-lg-4 @include('errors.field-class', ['field' => 'pickup_hour'])">
                      <div class="input-group">
                        <input type="text" class="form-control" id="pickup_hour" name="pickup_hour" value="{{isset($p_date[1]) ? $p_date[1] : date('H:i')}}" required="true" placeholder ="{{trans('shipment.hour')}}" @include('form.readonly')>
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                      </div>
                      @include('errors.field', ['field' => 'pickup_hour'])
                    </div>
                  </div>
                  <!--Deliver date and hour-->
                  <div class="form-group form_dimension row @include('errors.field-class', ['field' => 'deliver_date'])" id="type" >
                    <div class="col-lg-1"></div>
                    <label class="col-lg-2 control-label" id="typeLabel" >{{trans('pickup.deliver_date')}}</label>
                    <div class="col-lg-4 @include('errors.field-class', ['field' => 'deliver_date'])">
                      <?php $d_date = isset($pickup->deliver_date) ? explode(" ",$pickup->deliver_date):null; ?>
                      <div class="input-group">
                        <input type="text" class="form-control" id="deliver_date" name="deliver_date" value="{{isset($d_date[0]) ? $d_date[0] : date('Y-m-d')}}" required="true" placeholder ="{{trans('shipment.since')}}" @include('form.readonly')>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                      @include('errors.field', ['field' => 'deliver_date'])
                    </div>
                    <div class="col-lg-4 @include('errors.field-class', ['field' => 'deliver_hour'])">
                      <div class="input-group">
                        <input type="text" class="form-control" id="deliver_hour" name="deliver_hour" value="{{isset($d_date[1]) ? $d_date[1] : date('H:i')}}" required="true" placeholder ="{{trans('shipment.hour')}}" @include('form.readonly')>
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                      </div>
                      @include('errors.field', ['field' => 'deliver_hour'])
                    </div>
                  </div>
                  <br>
                  <div class="col-lg-1"></div>
                  <label class="col-lg-2 control-label" id="labelDirection" >{{ trans('pickup.notes') }}</label>
                  <div class="col-lg-8">
                    <textarea id="notes" type="text" placeholder="{{trans('pickup.notes')}}" class="form-control" name="notes" value="{{isset($pickup->notes) ? $pickup->notes : ''}}">{{isset($pickup->notes) ? $pickup->notes : ''}}</textarea>
                    @include('errors.field', ['field' => 'addcharge'])
                  </div>
                </div>
                </div>
              </div>
            </div>
            <!-- Tab 4-->
            <div id="ics_tab_menu3" class="tab-pane fade" >
              <div class="panel panel-default">
                <div class="panel-heading text-muted">
                  <span><i class="fa fa-cloud-upload" aria-hidden="true"></i></span>
                </div>
                <div class="panel-body">
                  <div class="col-md-12" >
                    <input type="file" class="hidden2" id="upload_file" name="upload_file[]" onchange="preview_image();"  multiple="true"/>
                    <div id="image_preview" >
                      @if(isset($attachments))
                        @foreach($attachments as $attachment)
                        <div class='preview' id='prev'>
                          <div class='divimg'>
                          <a target="blank" href="{{isset($attachment) ? $attachment->path : ''}}">
                            <img width="100" height="200" class='thumbnailp' src="{{isset($attachment) ? $attachment->path : ''}}">
                          </a>
                          </div>
                        </div>
                        @endforeach
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              @if(!isset($readonly) || !$readonly)
              <div class="col-lg-12 buttons"  id="divButton">
                <button type="submit" class="btn btn-primary pull-right" id="icsBtnPayment">
                  <i class="fa fa-floppy-o" aria-hidden="true"></i>
                  {{ trans(isset($package)?'messages.update' : 'messages.save') }}
                </button>
              </div>
              @endif
            </div>
            <!---->
            <input type ="hidden" name="countpack" id="countpack" value="1">
            <input type ="hidden" name="start_at" id="start_at" value="{{ $start_at }}">
          </div>
        </fieldset>
    </form>
  </div>
</div>
