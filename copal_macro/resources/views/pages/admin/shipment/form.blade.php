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
                    <li class="ics_set_pointer_on_form"><a onclick="icsSetTypeShipment({{$value->id}}, {{isset($edit) && $edit == true ? 'true' : 'false' }}, 0)">{{$value->spanish}}</a></li>
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
                      <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.reservationShipment')}}</label>
                      <div class="col-lg-8">
                          <input type="text" class="form-control" id="reservation_shipment" name="reservation_shipment" value="{{isset($shipment) ? $shipment->number_reservation : ''}}" placeholder="{{trans('shipment.reservationShipment')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'reservation_shipment'])
                      </div>
                    </div>
                    <!---->
                    <div class="form-group row @include('errors.field-class', ['field' => 'guide_shipment'])">
                      <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.guideShipment')}}</label>
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
                      <label class="col-lg-3 control-label" id="typeLabel" >{{trans('shipment.descriptionShipment')}}</label>
                      <div class="col-lg-8">
                          <textarea class="form-control" id="description_shipment" name="description_shipment" value="" placeholder="{{trans('shipment.descriptionShipment')}}"required="true" @include('form.readonly')>{{isset($shipment) ? $shipment->description : ''}}</textarea>
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
                        <div class="breadcrumb">{{trans('shipment.Shipper')}}</div>
                        <div class="@include('errors.field-class', ['field' => 'shipper_select'])">
                          <select class="form-control" id="ics_shipper_select" name="shipper_select" >
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
                        <div class="breadcrumb">{{trans('shipment.entityToNotify')}}</div>
                        <div class="@include('errors.field-class', ['field' => 'entityToNotify_select'])">
                          <select class="form-control" id="ics_entityToNotify_select" name="entityToNotify_select" >
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
                        <div class="breadcrumb">{{trans('shipment.cargoAgent')}}</div>
                        <div class="@include('errors.field-class', ['field' => 'cargoAgent_select'])">
                          <select class="form-control" id="ics_cargoAgent_select" name="cargoAgent_select" >
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
                          <div class="breadcrumb">{{trans('shipment.consigneer')}}
                          </div>
                          <div class="@include('errors.field-class', ['field' => 'consigneer_select'])">
                            <select class="form-control" id="ics_consigneer_select" name="consigneer_select" >
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
                            <select class="form-control" id="ics_intermediate_select" name="intermediate_select" >
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
                            <select class="form-control" id="ics_destinyAgent_select" name="destinyAgent_select" >
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
                                      <td>{{$value->getLastEvent->description}}</td>
                                      <td>{{$value->code}}</td>
                                      <td>{{$value->value}}</td>
                                      <td>{{$value->observation}}</td>
                                      <td>
                                        <input id="check_wr_{{$value->id}}" type="checkbox" name="wr{{$value->id}}" value="wr{{$value->id}}" onclick="addWarehouse({{$value->id}})" @if(isset($shipment_detail)) @foreach($shipment_detail as $key => $detail) @if($detail->warehouse == $value->id ) checked @endif @endforeach @endif/>
                                      </td>
                                    </tr>
                                    @elseif($value->process == $shipment->code || $value->booked == null)
                                      <tr item="{{$value->toInnerJson()}}">
                                        <td>{{$value->getLastEvent->description}}</td>
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
