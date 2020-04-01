<?php
use App\Models\Admin\Configuration;

$configuration = Configuration::find(1);
$lang = $configuration->language;
//App::setLocale($lang);

 ?>
 @include('sections.translate')
<script type="text/javascript">
$(document).ready( function() {
  $('#type_file').select2().on('select2:select', function(e){
    var el = $(e.currentTarget);
    if (el.attr('id') == 'type_file'){
      var item = eval('(' + el.find('option:selected').attr('value') + ')');

      if (item == 1) {
        $('#po_number').css('display','none');
        $('#label_po').css('display','none');

        $('#invoice_number').css('display','block');
        $('#label_invoice').css('display','block');
      }
      if (item == 2) {
        $('#po_number').css('display','block');
        $('#label_po').css('display','block');

        $('#invoice_number').css('display','none');
        $('#label_invoice').css('display','none');
      }
      if (item == 3) {
        $('#po_number').css('display','block');
        $('#label_po').css('display','block');

        $('#invoice_number').css('display','block');
        $('#label_invoice').css('display','block');
      }
    }
  });
});
</script>
@include('pages.admin.shipment.messages')
<form role="form" action="{{asset($path)}}" onsubmit="createLoad()"method="post" novalidate id="ics_shipmen_form" enctype="multipart/form-data">
  @if(isset($shipment))
    <input type="hidden" name="_method" value="patch">
  @endif
  <!---->
    <fieldset>
      <!--first row selected type-->
      <div class="row">
        <div class="col-md-12">
          <div class="breadcrumb" >
              <span></span>
              <span class="">
                <div class="dropdown" >
                  <a class="dropdown-toggle" type="button" data-toggle="dropdown" id="ics_link_dropdown">
                    <span class="text-muted" data-toggle="tooltip" title="{{trans('shipment.type')}}">
                      <i class="fa fa-eye" aria-hidden="true"></i>
                      <span class="" id="ics_load"></span>
                      {{trans('shipment.type')}}
                      <span id="ics_selected_item"></span>
                      <span class="caret"></span>
                    </span>
                  </a>
                  <ul class="dropdown-menu" id="">
                    <li class="dropdown-header">{{trans('shipment.type')}}</li>
                    <li class="divider"></li>
                    @foreach($transport as $key => $value)
                      @if($value->id!=3)
                        <li class="ics_set_pointer_on_form"><a onclick="icsSetTypeShipment({{$value->id}}, {{isset($edit) && $edit == true ? 'true' : 'false' }}, 0)">{{ucwords(($lang == 'es') ? $value->spanish : $value->english)}}</a></li>
                      @endif
                    @endforeach
                  </ul>
                </div>
              </span>
          </div>
        </div>
      </div>
      <!--define shipment type-->
      <div class="row"  >
        <div class="col-md-12">
        <input type="hidden" id="ics_Hd_Type_Shipment" name="ics_Hd_Type_Shipment" value="1">
          <!--tabs-->
          <ul class="nav nav-tabs nav-justified">
            <li id="ics_inactive_tab0" class="active"><a data-toggle="tab" href="#ics_tab_home">{{trans('shipment.generalInfo')}} <span><i class="fa fa-exchange" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab5" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu5">{{trans('shipment.payment_info')}} <span><i class="fa fa-users" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab1" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu1">{{trans('shipment.entityInfo')}} <span><i class="fa fa-users" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab2" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu2">{{trans('shipment.routesInfo')}} <span><i class="fa fa-random" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab3" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu3">{{trans('transporters.attchments')}} <span><i class="fa fa-cloud-upload" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab4" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu4">{{trans('shipment.cargoInfo')}} <span><i class="fa fa-cubes" aria-hidden="true"></i></span></a></li>
          </ul>
          <div class="tab-content">
            <div id="ics_tab_home"  class="tab-pane fade in active">
            <!--{{trans('shipment.generalInfo')}}-->
              <div class="panel panel-default">
                <div class="panel-heading text-muted">
                  <span><i class="fa fa-exchange" aria-hidden="true"></i></span>
                </div>
                <div class="panel-body">
                  <fieldset id="ics_fielset_load_general_info" class="form">
                    <!--name-->
                    <div class="form-group row @include('errors.field-class', ['field' => 'name_shipment'])">
                      <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.nameShipment')}}</label>
                      <div class="col-lg-8">
                          <input type="text" class="form-control" id="name_shipment" name="name_shipment" value="{{isset($shipment) ? $shipment->name : ''}}" placeholder="{{trans('shipment.nameShipment')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'name_shipment'])
                      </div>
                    </div>
                    <!--containerized-->
                    <div class="form-group row @include('errors.field-class', ['field' => 'containerized'])">
                      <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.containerized')}} (18)</label>
                      <div class="col-lg-8">
                        <div class="@include('errors.field-class', ['field' => 'shipper_select'])">
                          <select style="width:100%;" class="form-control" id="containerized" name="containerized" >
                            <option value="0">{{trans('shipment.uncontainerized')}}</option>
                            @if(isset($containers))
                              @foreach($containers as $key => $container)
                                <option {{((isset($shipment) && ($shipment->containerized == $container->id))) ? 'selected' : ''}} value="{{$container->id}}">{{$container->name}}</option>
                              @endforeach
                            @endif
                          </select>
                          @include('errors.field', ['field' => 'containerized'])
                        </div>
                      </div>
                    </div>
                    <!--NOMBRE DEL CONTAINER-->
                    <!--<div id="container_name" class="form-group row @include('errors.field-class', ['field' => 'container_name'])">
                      <label class="col-lg-3 control-label" id="typeLabel" >{{trans('Nombre del container')}}</label>
                      <div class="col-lg-8">
                          <input type="text" class="form-control" id="container_name" name="container_name" value="{{isset($shipment->container_name) ? $shipment->container_name : ''}}" placeholder="{{trans('Nombre del container')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'container_name'])
                      </div>
                    </div>
                    <!---->
                    <div class="form-group row @include('errors.field-class', ['field' => 'author_shipment'])">
                      <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.authorShipment')}}</label>
                      <div class="col-lg-8">
                          <input type="text" class="form-control" id="author_shipment" name="" value="@if($admin) {{$admin->code}} {{$admin->username}} @endif" placeholder="{{trans('shipment.authorShipment')}}"required="true" readonly ="true" @include('form.readonly')>
                          <input type="hidden" name="author_shipment" value="@if($admin){{$admin->id}}@endif">
                      @include('errors.field', ['field' => 'author_shipment'])
                      </div>
                    </div>
                    <!---->
                    <div class="form-group row @include('errors.field-class', ['field' => 'reservation_shipment'])">
                      <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.reservationShipment')}}(2)</label>
                      <div class="col-lg-8">
                          <input type="text" class="form-control" id="reservation_shipment" name="reservation_shipment" value="{{isset($shipment) ? $shipment->number_reservation : ''}}" placeholder="{{trans('shipment.reservationShipment')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'reservation_shipment'])
                      </div>
                    </div>
                    <!---->
                    <div class="form-group row @include('errors.field-class', ['field' => 'guide_shipment'])">
                      <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.guideShipment')}}(3)</label>
                      <div class="col-lg-8">
                          <input type="text" class="form-control" id="guide_shipment" name="guide_shipment" value="{{isset($shipment) ? $shipment->number_guide : ''}}" placeholder="{{trans('shipment.guideShipment')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'guide_shipment'])
                      </div>
                    </div>
                    <!---->
                    <div class="form-group row @include('errors.field-class', ['field' => 'declarate_shipment'])">
                      <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.declarateShipment')}}</label>
                      <div class="col-lg-8">
                          <input type="text" class="form-control" id="declarate_shipment" name="declarate_shipment" value="{{isset($shipment) ? $shipment->declarate_value : ''}}" placeholder="{{trans('shipment.declarateShipment')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'declarate_shipment'])
                      </div>
                    </div>
                    <!---->
                    <div class="form-group row @include('errors.field-class', ['field' => 'realizationPlace_shipment'])">
                      <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.realizationPlaceShipment')}}</label>
                      <div class="col-lg-8">
                          <input type="text" class="form-control" id="realizationPlace_shipment" name="realizationPlace_shipment" value="{{isset($shipment) ? $shipment->realizate_city_place : ''}}" placeholder="{{trans('shipment.realizationPlaceShipment')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'realizationPlace_shipment'])
                      </div>
                    </div>
                    <!---->
                    <div class="form-group row">
                      <div class="@include('errors.field-class', ['field' => 'realizationDate_shipment'])">
                        <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.realizationDateShipment')}}</label>
                        <div class="col-lg-4">
                            <div class="input-group">
                              <input type="text" class="form-control" id="realizationDate_shipment" name="realizationDate_shipment" value="{{isset($shipment) ? $shipment->realizate_city_date : date('Y-m-d')}}" placeholder="{{trans('shipment.realizationDateShipment')}}"required="true" @include('form.readonly')>
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        @include('errors.field', ['field' => 'realizationDate_shipment'])
                        </div>
                      </div>
                      <div class="@include('errors.field-class', ['field' => 'realizationHour_shipment'])">
                        <div class="col-lg-4">
                            <div class="input-group">
                              <input type="text" class="form-control" id="realizationHour_shipment" name="realizationHour_shipment" value="{{isset($shipment) ? $shipment->realizate_city_hour : date('H:i')}}" placeholder="{{trans('shipment.realizationHourShipment')}}"required="true" @include('form.readonly')>
                              <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                            </div>
                        @include('errors.field', ['field' => 'realizationDate_shipment'])
                        </div>
                      </div>
                    </div>
                    <!--Complementary-->
                    <fieldset id="ics_complentary_info"></fieldset>
                    <!---->
                    <div class="form-group row @include('errors.field-class', ['field' => 'description_shipment'])">
                      <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.instructions')}} (9)</label>
                      <div class="col-lg-8">
                          <textarea class="form-control" id="description_shipment" name="description_shipment" value="" placeholder="{{trans('shipment.instructions')}}"required="true" @include('form.readonly')>{{isset($shipment) ? $shipment->description : ''}}</textarea>
                      @include('errors.field', ['field' => 'description_shipment'])
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
            </div>
            <!--{{trans('shipment.entityInfo')}}-->
            <div id="ics_tab_menu1" class="tab-pane fade" >
              <div class="panel panel-default">
                <div class="panel-heading text-muted">
                  <span><i class="fa fa-users" aria-hidden="true"></i></span>
                </div>
                <div class="panel-body">
                  <!---->
                  <fieldset class="form">
                    <div class="row">
                      <!--shipper-->
                      <div class="col-md-4 ">
                        <div class="breadcrumb">{{trans('shipment.Shipper')}} (1)</div>
                        <div class="@include('errors.field-class', ['field' => 'shipper_select'])">
                          <select style="width:100%;" class="form-control" id="ics_shipper_select" name="shipper_select" >
                            <option value="0">{{trans('shipment.selecteOption')}}</option>
                            @foreach($user as $key => $value)
                              <option {{(isset($shipment) && $shipment->shipper == $value->id) ? 'selected' : ''}} item="{{$value->toJson()}}" value ="{{$value->id}}">{{$value->code}} {{$value->name}} {{$value->last_name}}</option>
                            @endforeach
                          </select>
                          @include('errors.field', ['field' => 'shipper_select'])
                        </div>
                      </div>
                      <!--Entity to Notify-->
                      <div class="col-md-4">
                        <div class="breadcrumb">{{trans('shipment.entityToNotify')}} (8)</div>
                        <div class="@include('errors.field-class', ['field' => 'entityToNotify_select'])">
                          <select style="width:100%;" class="form-control" id="ics_entityToNotify_select" name="entityToNotify_select" >
                              <option value="0">{{trans('shipment.selecteOption')}}</option>
                            @foreach($user as $key => $value)
                              <option {{(isset($shipment) && $shipment->entity_to_notify == $value->id) ? 'selected' : ''}} item="{{$value->toJson()}}"value ="{{$value->id}}">{{$value->code}} {{$value->name}} {{$value->last_name}}</option>
                            @endforeach
                          </select>
                          @include('errors.field', ['field' => 'entityToNotify_select'])
                        </div>
                      </div>
                      <!--Cargo Agent-->
                      <div class="col-md-4">
                        <div class="breadcrumb">{{trans('shipment.cargoAgent')}} (6)</div>
                        <div class="@include('errors.field-class', ['field' => 'cargoAgent_select'])">
                          <select style="width:100%;" class="form-control" id="ics_cargoAgent_select" name="cargoAgent_select" >
                              <option value="0">{{trans('shipment.selecteOption')}}</option>
                            @foreach($user as $key => $value)
                              <option {{(isset($shipment) && $shipment->cargo_agent == $value->id) ? 'selected' : ''}} item="{{$value->toJson()}}"value ="{{$value->id}}">{{$value->code}} {{$value->name}} {{$value->last_name}}</option>
                            @endforeach
                          </select>
                            @include('errors.field', ['field' => 'cargoAgent_select'])
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                          <span><label for="">{{trans('shipment.name')}}</label></span>
                          <input class ="form-control" type="text" id="ics_shipper_name" name="shipper_name" placeholder="{{trans('shipment.name')}}" value="{{isset($shipment) &&  $shipment->getShipper != null ? $shipment->getShipper->name : '' }}">
                        </div>
                        <div class="col-md-4">
                          <span><label for="">{{trans('shipment.name')}}</label></span>
                          <input class ="form-control" type="text" id="ics_entityToNotify_name" name="entityToNotify_name" placeholder="{{trans('shipment.name')}}" value="{{isset($shipment) &&  $shipment->getEntityToNotify != null ? $shipment->getEntityToNotify->name : '' }}">
                        </div>
                        <div class="col-md-4">
                          <span><label for="">{{trans('shipment.name')}}</label></span>
                          <input class ="form-control" type="text" id="ics_cargoAgent_name" name="cargoAgent_name" placeholder="{{trans('shipment.name')}}" value="{{isset($shipment) &&  $shipment->getCargoAgent != null ? $shipment->getCargoAgent->name : '' }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                          <span><label for="">{{trans('shipment.address')}}</label></span>
                          <textarea class="form-control" id="ics_shipper_address" name="shipper_address" placeholder="{{trans('shipment.address')}}">{{isset($shipment) && $shipment->getShipper != null ? $shipment->getShipper->address : '' }}</textarea>
                        </div>
                        <div class="col-md-4">
                          <span><label for="">{{trans('shipment.address')}}</label></span>
                          <textarea class="form-control" id="ics_entityToNotify_address" name="entityToNotify_address" placeholder="{{trans('shipment.address')}}">{{isset($shipment) && $shipment->getEntityToNotify != null ? $shipment->getEntityToNotify->address : '' }}</textarea>
                        </div>
                        <div class="col-md-4">
                          <span><label for="">{{trans('shipment.address')}}</label></span>
                          <textarea class="form-control" id="ics_cargoAgent_address" name="cargoAgent_address" placeholder="{{trans('shipment.address')}}">{{isset($shipment) && $shipment->getCargoAgent != null ? $shipment->getCargoAgent->address : '' }}</textarea>
                        </div>
                    </div>
                  </fieldset>
                  <!---->
                  <fieldset class="form">
                    <div class="row">
                        <div class="col-md-4">
                          <div class="breadcrumb">{{trans('shipment.consigneer')}} (5)
                          </div>
                          <div class="@include('errors.field-class', ['field' => 'consigneer_select'])">
                            <select style="width:100%;" class="form-control" id="ics_consigneer_select" name="consigneer_select" >
                              <option value="0">{{trans('shipment.selecteOption')}}</option>
                              @foreach($user as $key => $value)
                                <option {{(isset($shipment) && $shipment->consigner == $value->id) ? 'selected' : ''}} item="{{$value->toJson()}}"value ="{{$value->id}}">{{$value->code}} {{$value->name}} {{$value->last_name}}</option>
                              @endforeach
                            </select>
                              @include('errors.field', ['field' => 'consigneer_select'])
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="breadcrumb">{{trans('shipment.intermediate')}}
                          </div>
                          <div class="@include('errors.field-class', ['field' => 'consigneer_select'])">
                            <select style="width:100%;" class="form-control" id="ics_intermediate_select" name="intermediate_select" >
                                <option value="0">{{trans('shipment.selecteOption')}}</option>
                              @foreach($user as $key => $value)
                                <option {{(isset($shipment) && $shipment->intermediary == $value->id) ? 'selected' : ''}} item="{{$value->toJson()}}"value ="{{$value->id}}">{{$value->code}} {{$value->name}} {{$value->last_name}}</option>
                              @endforeach
                            </select>
                            @include('errors.field', ['field' => 'intermediate_select'])
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="breadcrumb">{{trans('shipment.destinyAgent')}}</div>
                          <div class="@include('errors.field-class', ['field' => 'destinyAgent_select'])">
                            <select style="width:100%;" class="form-control" id="ics_destinyAgent_select" name="destinyAgent_select" >
                                <option value="0">{{trans('shipment.selecteOption')}}</option>
                              @foreach($user as $key => $value)
                                <option {{(isset($shipment) && $shipment->destiny_agent == $value->id) ? 'selected' : ''}} item="{{$value->toJson()}}"value ="{{$value->id}}">{{$value->code}} {{$value->name}} {{$value->last_name}}</option>
                              @endforeach
                            </select>
                              @include('errors.field', ['field' => 'destinyAgent_select'])
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                          <span><label for="">{{trans('shipment.name')}}</label></span>
                          <input class ="form-control" type="text" id="ics_consigneer_name" name="consigneer_name" placeholder="{{trans('shipment.name')}}"value="{{isset($shipment) && $shipment->getConsigner != null ? $shipment->getConsigner->name : '' }}">
                        </div>
                        <div class="col-md-4">
                          <span><label for="">{{trans('shipment.name')}}</label></span>
                          <input class ="form-control" type="text" id="ics_intermediate_name" name="intermediate_name" placeholder="{{trans('shipment.name')}}"value="{{isset($shipment) && $shipment->getIntermediary != null ? $shipment->getIntermediary->name : '' }}">
                        </div>
                        <div class="col-md-4">
                          <span><label for="">{{trans('shipment.name')}}</label></span>
                          <input class ="form-control" type="text" id="ics_destinyAgent_name" name="destinyAgent_name" placeholder="{{trans('shipment.name')}}"value="{{isset($shipment) && $shipment->getDestinyAgent != null ? $shipment->getDestinyAgent->name : '' }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                          <span><label for="">{{trans('shipment.address')}}</label></span>
                          <textarea class="form-control" id="ics_consigneer_address" name="consigneer_address" placeholder="{{trans('shipment.address')}}">{{isset($shipment) && $shipment->getConsigner != null ? $shipment->getConsigner->address : '' }}</textarea>
                        </div>
                        <div class="col-md-4">
                          <span><label for="">{{trans('shipment.address')}}</label></span>
                          <textarea class="form-control" id="ics_intermediate_address" name="intermediate_address" placeholder="{{trans('shipment.address')}}">{{isset($shipment) && $shipment->getIntermediary != null ? $shipment->getIntermediary->address : '' }}</textarea>
                        </div>
                        <div class="col-md-4">
                          <span><label for="">{{trans('shipment.address')}}</label></span>
                          <textarea class="form-control" id="ics_destinyAgent_address" name="destinyAgent_address" placeholder="{{trans('shipment.address')}}">{{isset($shipment) && $shipment->getDestinyAgent != null ? $shipment->getDestinyAgent->address : '' }}</textarea>
                        </div>
                    </div>
                  </fieldset>
                </div>
              </div>
            </div>
            <div id="ics_tab_menu5"class="tab-pane fade">
              <div class="panel panel-default">
                <!--containerized-->
                <br><br>
                <div class="form-group row @include('errors.field-class', ['field' => 'containerized'])">
                  <div class="col-md-1"></div>
                  <label class="col-lg-2 control-label" id="typeLabel" >{{trans('shipment.currency')}}</label>
                  <div class="col-lg-8">
                    <div class="@include('errors.field-class', ['field' => 'currency'])">
                      <select style="width:100%;" class="form-control" id="currency" name="currency" >
                        <option value="0">{{trans('shipment.selecteOption')}}</option>
                        <option value="172">USD Dolar Americano</option>
                        <option value="48">ECU Moneda Unica Europea (EURO)</option>
                          @foreach($currencys as $key => $currency)
                            <option {{((isset($shipment) && ($shipment->currency == $currency->id))) ? 'selected' : ''}} value="{{$currency->id}}">{{$currency->code.' '.$currency->name}}</option>
                          @endforeach
                      </select>
                      @include('errors.field', ['field' => 'currency'])
                    </div>
                  </div>
                </div>
                <div class="form-group row @include('errors.field-class', ['field' => 'payment'])">
                  <div class="col-md-1"></div>
                  <label class="col-lg-2 control-label" id="typeLabel" >{{trans('shipment.payment_method')}}</label>
                  <div class="col-lg-8">
                    <div class="@include('errors.field-class', ['field' => 'shipper_select'])">
                      <select style="width:100%;" class="form-control" id="payment" name="payment" >
                        <option {{isset($shipment->payment)&&($shipment->payment == 0) ? 'selected':''}} value="0">{{trans('shipment.selecteOption')}}</option>
                        <option {{isset($shipment->payment)&&($shipment->payment == 1) ? 'selected':''}} value="1">{{trans('shimpnet.prepaid')}}</option>
                        <option {{isset($shipment->payment)&&($shipment->payment == 2) ? 'selected':''}} value="2">{{trans('shipmen.collect')}}</option>
                      </select>
                      @include('errors.field', ['field' => 'payment'])
                    </div>
                  </div>
                </div>
                <div class="form-group row @include('errors.field-class', ['field' => 'type_payment'])">
                  <div class="col-md-1"></div>
                  <label class="col-lg-2 control-label" id="typeLabel" >{{trans('shipment.type_payment')}}</label>
                  <div class="col-lg-8">
                    <div class="@include('errors.field-class', ['field' => 'type_payment'])">
                      <select style="width:100%;" class="form-control" id="type_payment" name="type_payment" >
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 0) ? 'selected':''}} value="0">{{trans('shipment.selecteOption')}}</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 1) ? 'selected':''}} value="1">CA - Partial Collect Credit - Partial Prepaid Cash</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 2) ? 'selected':''}} value="2">CB - Partial Collect Credit - Partial Prepaid Credit</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 3) ? 'selected':''}} value="3">CC - All Charges Collect</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 4) ? 'selected':''}} value="4">CE - Partial Collect Credit Card - Partial Prepaid Cash</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 5) ? 'selected':''}} value="5">CG - All Charges Collect by GBL</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 6) ? 'selected':''}} value="6">CH - Partial Collect credit Card - Partial Prepaid Credit</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 7) ? 'selected':''}} value="7">CP - Destination Collect Cash</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 8) ? 'selected':''}} value="8">CX - Destination Collect Credit</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 9) ? 'selected':''}} value="9">CZ - All Charges as Collect by Credit Card</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 10) ? 'selected':''}} value="10">NC - No Charges</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 11) ? 'selected':''}} value="11">NG - No Weight Charge - Other Charges Prepaid by GBL</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 12) ? 'selected':''}} value="12">NP - No Weight Charge - Other Charges Prepaid Cash</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 13) ? 'selected':''}} value="13">NT - No Weight Charge - Other Charges Collect</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 14) ? 'selected':''}} value="14">NX - No Weight Charge - Other Charges Prepaid Credit</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 15) ? 'selected':''}} value="15">NZ - No Wei ht Cha e - Other Cha es Pre aid b Credit card</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 16) ? 'selected':''}} value="16">PC - Partial Prepaid Cash - Partial Collect Cash</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 17) ? 'selected':''}} value="17">PD - Partial Prepaid Credit - Partial Collect Cash</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 18) ? 'selected':''}} value="18">PE - Partial Prepaid Credit Card - Partial Collect Cash</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 19) ? 'selected':''}} value="19">PF - Partial Prepaid Credit Card - Partial Collect Credit Card</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 20) ? 'selected':''}} value="20">PG - All Charges Prepaid by GBL</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 21) ? 'selected':''}} value="21">PH - Partial Prepaid Credit Card - Partial Collect Credit</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 22) ? 'selected':''}} value="22">PP - All Charges Prepaid by Cash</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 23) ? 'selected':''}} value="23">PX - All Charges Prepaid by Credit</option>
                          <option {{isset($shipment->type_payment)&&($shipment->type_payment == 24) ? 'selected':''}} value="24">PZ - Charges Prepaid by Credit Card</option>
                      </select>
                      @include('errors.field', ['field' => 'type_payment'])
                    </div>
                  </div>
                </div>
                <div class="form-group row @include('errors.field-class', ['field' => 'dangerous'])">
                  <div class="col-md-1"></div>
                  <label class="col-lg-2 control-label" id="typeLabel" >{{trans('shipment.dangerous')}}</label>
                  <div class="col-lg-8">
                    <div class="@include('errors.field-class', ['field' => 'dangerous'])">
                      <select style="width:100%;" class="form-control" id="dangerous" name="dangerous" >
                        <option {{isset($shipment->dangerous)&&($shipment->dangerous == 0) ? 'selected':''}} value="0">{{trans('shipment.selecteOption')}}</option>
                        <option {{isset($shipment->dangerous)&&($shipment->dangerous == 1) ? 'selected':''}} value="1">{{trans('shipment.yes')}}</option>
                        <option {{isset($shipment->dangerous)&&($shipment->dangerous == 2) ? 'selected':''}} value="2">{{trans('shipment.no')}}</option>
                      </select>
                      @include('errors.field', ['field' => 'dangerous'])
                    </div>
                  </div>
                </div>

                <div class="form-group row @include('errors.field-class', ['field' => 'insurance'])">
                  <div class="col-md-1"></div>
                  <label class="col-lg-2 control-label" id="typeLabel" >{{trans('shipment.insurance')}}</label>
                  <div class="col-lg-8">
                    <div class="@include('errors.field-class', ['field' => 'insurance'])">
                      <input class="form-control" type="number" name="insurance" max="100" placeholder="{{trans('shipment.insurance')}}" value="{{isset($shipment->insurance)? $shipment->insurance :''}}">
                      @include('errors.field', ['field' => 'insurance'])
                    </div>
                  </div>
                </div>
                <div class="form-group row @include('errors.field-class', ['field' => 'tax'])">
                  <div class="col-md-1"></div>
                  <label class="col-lg-2 control-label" id="typeLabel" >{{trans('shipment.taxxes')}}</label>
                  <div class="col-lg-8">
                    <div class="@include('errors.field-class', ['field' => 'tax'])">
                      <input class="form-control" type="number" name="tax" max="100" placeholder="{{trans('shipment.taxxes')}}" value="{{isset($shipment->tax)? $shipment->tax :''}}">
                      @include('errors.field', ['field' => 'tax'])
                    </div>
                  </div>
                </div>

                <div class="form-group row @include('errors.field-class', ['field' => 'agent_charges'])">
                  <div class="col-md-1"></div>
                  <label class="col-lg-2 control-label" id="typeLabel" >{{trans('shipment.agent_charges')}}</label>
                  <div class="col-lg-8">
                    <div class="@include('errors.field-class', ['field' => 'agent_charges'])">
                      <input class="form-control" type="number" name="agent_charges" placeholder="{{trans('shipment.agent_charges')}}" value="{{isset($shipment->agent_charges)? $shipment->agent_charges :''}}">
                      @include('errors.field', ['field' => 'agent_charges'])
                    </div>
                  </div>
                </div>
                <div class="form-group row @include('errors.field-class', ['field' => 'transport_charges'])">
                  <div class="col-md-1"></div>
                  <label class="col-lg-2 control-label" id="typeLabel" >{{trans('shipment.transport_charges')}}</label>
                  <div class="col-lg-8">
                    <div class="@include('errors.field-class', ['field' => 'transport_charges'])">
                      <input class="form-control" type="number" name="transport_charges" placeholder="{{trans('shipment.transport_charges')}}" value="{{isset($shipment->transport_charges)? $shipment->transport_charges :''}}">
                      @include('errors.field', ['field' => 'transport_charges'])
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--{{trans('shipment.routesInfo')}}-->
            <div id="ics_tab_menu2" class="tab-pane fade" >
              <div class="panel panel-default">
                <div class="panel-heading text-muted">
                  <span><i class="fa fa-random" aria-hidden="true"></i></span>
                </div>
                <div class="panel-body">
                  <fieldset id="ics_fielset_load_routes_info" class="form"></fieldset>
                </div>
              </div>
            </div>

            <div id="ics_tab_menu3" class="tab-pane fade" >
              <div class="panel panel-default">
                <div class="panel-heading text-muted">
                  <span><i class="fa fa-cloud-upload" aria-hidden="true"></i></span>
                </div>
                <div class="panel-body">
                  <div class="col-md-2">
                    <label for="">{{trans('shipment.type_file')}}</label>
                  </div>
                  <div class="@include('errors.field-class', ['field' => 'type_file']) col-md-10">
                    <select style="width:100%;" class="form-control" id="type_file" name="type_file" >
                      <option {{isset($shipment->type_file) &&($shipment->type_file == 0) ? 'selected' : ''}} value="0">{{trans('shipment.selectOption')}}</option>
                      <option {{isset($shipment->type_file) &&($shipment->type_file == 1) ? 'selected' : ''}} value="1">{{trans('shipment.invoice')}}</option>
                      <option {{isset($shipment->type_file) &&($shipment->type_file == 2) ? 'selected' : ''}} value="2">{{trans('shipment.po')}}</option>
                      <option {{isset($shipment->type_file) &&($shipment->type_file == 3) ? 'selected' : ''}} value="3">{{trans('shipment.po_and_inv')}}</option>
                    </select>
                      @include('errors.field', ['field' => 'type_file'])
                  </div>

                  @if(isset($shipment) && (($shipment->type_file == 1)||($shipment->type_file == 3)||($shipment->type_file == 0)))
                      <div id="label_invoice" class="col-md-2">
                        <label for="">{{trans('shipment.invoice_number')}}</label>
                      </div>
                      <div id="invoice_number" class="col-lg-10">
                        <div class="@include('errors.field-class', ['field' => 'invoice_number'])">
                          <input class="form-control" type="number" name="invoice_number"  placeholder="{{trans('shipment.invoice_number')}}" value="{{isset($shipment->invoice_number)? $shipment->invoice_number :''}}">
                          @include('errors.field', ['field' => 'invoice_number'])
                        </div>
                      </div>
                  @endif
                  @if(!isset($shipment))
                      <div id="label_invoice" class="col-md-2">
                        <label for="">{{trans('shipment.invoice_number')}}</label>
                      </div>
                      <div id="invoice_number" class="col-lg-10">
                        <div class="@include('errors.field-class', ['field' => 'invoice_number'])">
                          <input class="form-control" type="number" name="invoice_number"  placeholder="{{trans('shipment.invoice_number')}}" value="{{isset($shipment->invoice_number)? $shipment->invoice_number :''}}">
                          @include('errors.field', ['field' => 'invoice_number'])
                        </div>
                      </div>
                  @endif
                  @if(isset($shipment) && (($shipment->type_file == 2)||($shipment->type_file == 3)||($shipment->type_file == 0)))
                    <div id="label_po" class="col-md-2">
                      <label for="">{{trans('shipment.po_number')}}</label>
                    </div>
                    <div id="po_number" class="col-lg-10">
                      <div class="@include('errors.field-class', ['field' => 'po_number'])">
                        <input class="form-control" type="number" name="po_number"  placeholder="{{trans('shipment.po_number')}}" value="{{isset($shipment->po_number)? $shipment->po_number :''}}">
                        @include('errors.field', ['field' => 'po_number'])
                      </div>
                    </div>
                  @endif
                  @if(!isset($shipment))
                    <div id="label_po" class="col-md-2">
                      <label for="">{{trans('shipment.po_number')}}</label>
                    </div>
                    <div id="po_number" class="col-lg-10">
                      <div class="@include('errors.field-class', ['field' => 'po_number'])">
                        <input class="form-control" type="number" name="po_number"  placeholder="{{trans('shipment.po_number')}}" value="{{isset($shipment->po_number)? $shipment->po_number :''}}">
                        @include('errors.field', ['field' => 'po_number'])
                      </div>
                    </div>
                  @endif

                  <div class="col-md-12" >
                    <input type="file" class="hidden2" id="upload_file" name="upload_file[]" onchange="preview_image();"  multiple="true"/>

                    <div id="image_preview" ></div>
                  </div>
                </div>
              </div>
            </div>
            <!--{{trans('shipment.cargoInfo')}}-->
            <div id="ics_tab_menu4" class="tab-pane fade" >
              <div class="panel panel-default">
                <div class="panel-heading text-muted">
                  <span><i class="fa fa-cubes" aria-hidden="true"></i></span>
                </div>
                <div class="panel-body">
                  <fieldset id="ics_fielset_load_cargo_info" class="form">
                    <!--tabs-->
                    <ul class="nav nav-tabs nav-justified">
                      <li id="ics_inactive_tab0" class="active">
                        <a data-toggle="tab" href="#ics_tab_sub_home" style="text-align: left;">{{trans('shipment.warehouse')}}
                          <span><i class="fa fa-cube" aria-hidden="true"></i></span>
                            <span class="pull-right">
                              <span class="label label-default">{{$warehouse->count()}}</span>
                            </span>
                          </a>
                        </li>
                      <li id="ics_inactive_tab1" class="ics-inactive-tab">
                        <a data-toggle = "tab" href="#ics_tab_sub_menu1" style="text-align: left;">{{trans('shipment.pickup')}}
                          <span><i class="fa fa-truck fa-fw" aria-hidden="true"></i></span>
                          <span class="pull-right">
                            <span class="label label-default">{{$pickup->count()}}</span>
                          </span>
                        </a>
                      </li>
                    </ul>
                    <!--content-->
                    <div class="tab-content">
                        <div id="ics_tab_sub_home"  class="tab-pane fade in active">
                          <div class="panel panel-default">
                            <div class="panel-heading text-muted">
                              <span><i class="fa fa-cube" aria-hidden="true"></i></span>
                            </div>
                            <div class="panel-body">
                              <table class="table table-hover table-striped table-responsive" id="dtble" >
                                <thead>
                                  <tr>
                                    <th>{{trans('shipment.status')}}</th>
                                    <th>{{trans('shipment.name')}}</th>
                                    <th>{{trans('shipment.value')}}</th>
                                    <th>{{trans('shipment.observation')}}</th>
                                    <th>{{trans('shipment.add')}}</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($warehouse as $key => $value)
                                    @if(!isset($shipment))
                                    <!--crear embarque a partir de warehouse recibidos en oficina-->
                                    <tr item="{{$value->toInnerJson()}}">
                                      <td>{{$value->getLastEvent->name}}</td>
                                      <td>{{$value->code}}</td>
                                      <td>{{$value->value}}</td>
                                      <td>{{$value->observation}}</td>
                                      <td>
                                        <input id="check_wr_{{$value->id}}" type="checkbox" name="wr{{$value->id}}" value="wr{{$value->id}}" onclick="addWarehouse({{$value->id}})" @if(isset($shipment_detail)) @foreach($shipment_detail as $key => $detail) @if($detail->warehouse == $value->id ) checked @endif @endforeach @endif/>
                                      </td>
                                    </tr>
                                    @elseif($value->process == $shipment->code || $value->booked == null)
                                      <tr item="{{$value->toInnerJson()}}">
                                        <td>{{$value->getLastEvent->name}}</td>
                                        <td>{{$value->code}}</td>
                                        <td>{{$value->value}}</td>
                                        <td>{{$value->observation}}</td>
                                        <td>
                                          <input id="check_wr_{{$value->id}}" type="checkbox" name="wr{{$value->id}}" value="wr{{$value->id}}" onclick="addWarehouse({{$value->id}})" @if(isset($shipment_detail)) @foreach($shipment_detail as $key => $detail) @if($detail->warehouse == $value->id ) checked @endif @endforeach @endif/>
                                        </td>
                                      </tr>
                                    @endif
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                        <div id="ics_tab_sub_menu1"  class="tab-pane fade in ">
                          <div class="panel panel-default">
                            <div class="panel-heading text-muted">
                              <span><i class="fa fa-truck fa-fw" aria-hidden="true"></i></span>
                            </div>
                            <div class="panel-body">
                              <table class="table table-hover table-striped table-responsive" id="dtble2" >
                                <thead>
                                  <tr>
                                    <th>{{trans('shipment.status')}}</th>
                                    <th>{{trans('shipment.name')}}</th>
                                    <th>{{trans('shipment.value')}}</th>
                                    <th>{{trans('shipment.observation')}}</th>
                                    <th>{{trans('shipment.add')}}</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($pickup as $key => $value)
                                    @if(!isset($shipment))
                                      <tr item="{{$value}}">
                                        <td>{{$value->getLastEvent->description}}</td>
                                        <td>{{$value->code}}</td>
                                        <td>{{$value->value}}</td>
                                        <td>{{$value->observation}}</td>
                                        <td><input id="check_pk_{{$value->id}}" type="checkbox" name="pk{{$value->id}}" value="pk{{$value->id}}" onclick="addPickup({{$value->id}})" @if(isset($shipment_detail)) @foreach($shipment_detail as $key => $detail) @if($detail->pickup == $value->id ) checked @endif @endforeach @endif/></td>
                                      </tr>
                                    @elseif($value->process == $shipment->code || $value->booked == null)
                                      <tr item="{{$value}}">
                                        <td>{{$value->getLastEvent->description}}</td>
                                        <td>{{$value->code}}</td>
                                        <td>{{$value->value}}</td>
                                        <td>{{$value->observation}}</td>
                                        <td><input id="check_pk_{{$value->id}}" type="checkbox" name="pk{{$value->id}}" value="pk{{$value->id}}" onclick="addPickup({{$value->id}})" @if(isset($shipment_detail)) @foreach($shipment_detail as $key => $detail) @if($detail->pickup == $value->id ) checked @endif @endforeach @endif/></td>
                                      </tr>
                                    @endif
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                    </div>
                  </fieldset>
                  <!-- send data -->
                  <div class="pull-right" id="divButton">
                    <button class="btn btn-primary" type="submit" id="submit-all"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{trans(isset($booking) ? 'booking.update' : 'booking.save')}}</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </fieldset>
</form>
