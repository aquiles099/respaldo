<form role="form" action="{{asset($path)}}" method="post" novalidate enctype="multipart/form-data">
  @if(isset($shipment))
    <input type="hidden" name="_method" value="patch">
  @endif
  <!---->
    <fieldset class="form">
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
                      {{trans('transporters.type')}}
                      <span id="ics_selected_item"></span>
                      <span class="caret"></span>
                    </span>
                  </a>
                  <ul class="dropdown-menu" id="">
                    <li class="dropdown-header">{{trans('transporters.type')}}</li>
                    <li class="divider"></li>
                    @foreach($transport as $key => $value)
                    <li class="ics_set_pointer_on_form"><a onclick="icsSetTypeShipment({{$value->id}})">{{$value->spanish}}</a></li>
                    @endforeach
                  </ul>
                </div>
              </span>
          </div>
        </div>
      </div>
      <!--define shipment type-->
      <div class="row">
        <div class="col-md-12">
          <!--tabs-->
          <ul class="nav nav-tabs nav-justified" id="typet">
            <li id="ics_inactive_tab0" class="active"><a data-toggle="tab" href="#ics_tab_home">{{trans('transporters.generalInfo')}} <span><i class="fa fa-exchange" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab1"><a data-toggle="tab" href="#ics_tab_menu1">{{trans('transporters.address')}} <span><i class="fa fa-phone-square" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab2" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu2">{{trans('transporters.attchments')}} <span><i class="fa fa-random" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab3" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu3">{{trans('transporters.paymentterms')}} <span><i class="fa fa-cubes" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab4" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu4">{{trans('transporters.maritimos')}} <span><i class="fa fa-life-ring" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab5" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu5">{{trans('transporters.airline')}} <span><i class="fa fa-plane" aria-hidden="true"></i></span></a></li>
            <li id="ics_inactive_tab6" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu6">{{trans('transporters.ground')}} <span><i class="fa fa-truck" aria-hidden="true"></i></span></a></li>

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
                      <!---->
                     <!-- Nombre del proveedor -->
                <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.name')}}</label>
                  <div class="col-lg-10">
                       <input type="text" class="form-control" id="name" name="name" value="" placeholder="{{trans('transporters.name')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'name'])
                   </div>
                 </div>

                <!-- Identificacion del proveedor -->
                <div class="form-group row @include('errors.field-class', ['field' => 'identification'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.identification')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="identification" name="identification" value="" placeholder="{{trans('transporters.identification')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'identification'])
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <!-- telefono del proveedor -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'phone'])">
                       <label class="col-lg-4 control-label" id="typeLabel" >{{trans('transporters.phone')}}</label>
                       <div class="col-lg-8">
                           <input type="text" class="form-control" id="phone" name="phone" value="" placeholder="{{trans('transporters.phone')}}" @include('form.readonly')>
                       @include('errors.field', ['field' => 'phone'])
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <!-- fax del proveedor -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'fax'])">
                       <label class="col-lg-4 control-label" id="typeLabel" >{{trans('transporters.fax')}}</label>
                       <div class="col-lg-8">
                           <input type="text" class="form-control" id="fax" name="fax" value="" placeholder="{{trans('transporters.fax')}}" @include('form.readonly')>
                       @include('errors.field', ['field' => 'fax'])
                      </div>
                    </div>
                  </div>

                </div>

                <!-- Identificacion del correo -->
                <div class="form-group row @include('errors.field-class', ['field' => 'email'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.email')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="email" name="email" value="" placeholder="{{trans('transporters.email')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'email'])
                  </div>
                </div>

                <!-- Pagina web -->
                <div class="form-group row @include('errors.field-class', ['field' => 'web'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.web')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="web" name="web" value="" placeholder="{{trans('transporters.web')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'web'])
                  </div>
                </div>

                <!-- Numero de Cuenta -->
                <div class="form-group row @include('errors.field-class', ['field' => 'account_number'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.accountnumber')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="account_number" name="account_number" value="" placeholder="{{trans('transporters.accountnumber')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'account_number'])
                  </div>
                </div>

                <!-- Nombre del contacto -->
                <div class="form-group row @include('errors.field-class', ['field' => 'name_contac'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.accountname')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="name_contac" name="name_contac" value="" placeholder="{{trans('transporters.accountname')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'name_contac'])
                  </div>
                </div>

                <!-- Apellido del contacto -->
                <div class="form-group row @include('errors.field-class', ['field' => 'lastname_contac'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.accountlastname')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="lastname_contac" name="lastname_contac" value="" placeholder="{{trans('transporters.accountlastname')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'lastname_contac'])
                  </div>
                </div>

                <!-- Numero de Exportacion -->
                <div class="form-group row @include('errors.field-class', ['field' => 'exportation'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.numberexportation')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="exportation" name="exportation" value="" placeholder="{{trans('transporters.numberexportation')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'exportation'])
                  </div>
                </div>

                <!-- Division -->
                <div class="form-group row @include('errors.field-class', ['field' => 'divition'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.divition')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="divition" name="divition" value="" placeholder="{{trans('transporters.divition')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'divition'])
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
                     <div class="panel-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="breadcrumb">
                            <span>{{trans('transporters.address')}}</span>
                          </div>

                           <!-- Calle -->
                          <div class="form-group row @include('errors.field-class', ['field' => 'address_street'])">
                             <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.street')}}</label>
                             <div class="col-lg-10">
                                 <input type="text" class="form-control" id="address_street" name="address_street" value="" placeholder="{{trans('transporters.street')}}" @include('form.readonly')>
                             @include('errors.field', ['field' => 'address_street'])
                            </div>
                          </div>

                          <!--country-->
                          <div class="form-group row @include('errors.field-class', ['field' => 'country'])">
                            <label class="col-lg-2 control-label">{{trans('vessel.country')}}</label>
                            <div class="col-lg-10">
                              @if(!isset($readonly) || $readonly == false)
                              <select style="width:100%;" class="form-control" id="address_country" name="address_country" required="true" value="{{isset($vessel) ? $route->country : Input::get('country')}}" @include('form.readonly') >
                                <option value="0">{{trans('route.selectOption')}}</option>
                                @foreach($country as $key => $value)
                                  <option {{(isset($vessel)) && ($vessel->country == $value->id) ? 'selected' : Input::get('country') == $value->id ? 'selected' : '' }} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                              </select>
                              @else
                              <input class="form-control" placeholder="" name="" type="text" required="true" value="{{isset($vessel) ? $route->country : Input::get('country')}}" @include('form.readonly')>
                              @endif
                              @include('errors.field', ['field' => 'country'])
                            </div>
                          </div>

                          <!--city-->
                          <div class="form-group row @include('errors.field-class', ['field' => 'city'])">
                            <label class="col-lg-2 control-label">{{trans('vessel.city')}} <span id="ics_load_vessel_city"></span></label>
                            <div class="col-lg-10">
                              <input class="form-control" placeholder="" id="address_city" name="address_city" type="text" required="true" value="{{isset($vessel) ? $route->city : Input::get('city')}}" @include('form.readonly')>
                              @include('errors.field', ['field' => 'city'])
                            </div>
                          </div>

                           <!-- Estado -->
                          <div class="form-group row @include('errors.field-class', ['field' => 'address_state'])">
                             <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.state')}}</label>
                             <div class="col-lg-10">
                                 <input type="text" class="form-control" id="address_state" name="address_state" value="" placeholder="{{trans('transporters.state')}}" @include('form.readonly')>
                             @include('errors.field', ['field' => 'address_state'])
                            </div>
                          </div>

                          <!-- Codigo Postal -->
                          <div class="form-group row @include('errors.field-class', ['field' => 'address_code'])">
                             <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.code')}}</label>
                             <div class="col-lg-10">
                                 <input type="text" class="form-control" id="address_code" name="address_code" value="" placeholder="{{trans('transporters.code')}}" @include('form.readonly')>
                             @include('errors.field', ['field' => 'address_code'])
                            </div>
                          </div>


                           <!-- Puerto -->
                          <div class="form-group row @include('errors.field-class', ['field' => 'address_port'])">
                             <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.port')}}</label>
                             <div class="col-lg-10">
                                 <input type="text" class="form-control" id="address_port" name="address_port" value="" placeholder="{{trans('transporters.port')}}" @include('form.readonly')>
                             @include('errors.field', ['field' => 'address_port'])
                            </div>
                          </div>

                        </div>

                        <div class="col-md-12">
                          <div class="breadcrumb">
                            <span>{{trans('transporters.addressbilling')}}</span>
                          </div>

                           <!-- Calle -->
                          <div class="form-group row @include('errors.field-class', ['field' => 'address_street'])">
                             <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.street')}}</label>
                             <div class="col-lg-10">
                                 <input type="text" class="form-control" id="billing_address_street" name="billing_address_street" value="" placeholder="{{trans('transporters.street')}}" @include('form.readonly')>
                             @include('errors.field', ['field' => 'address_street'])
                            </div>
                          </div>


                          <!--country-->
                          <div class="form-group row @include('errors.field-class', ['field' => 'country'])">
                            <label class="col-lg-2 control-label">{{trans('vessel.country')}}</label>
                            <div class="col-lg-10">
                              @if(!isset($readonly) || $readonly == false)
                              <select style="width:100%;" class="form-control" id="billing_address_country" name="billing_address_country" required="true" value="{{isset($vessel) ? $route->country : Input::get('country')}}" @include('form.readonly') >
                                <option value="0">{{trans('route.selectOption')}}</option>
                                @foreach($country as $key => $value)
                                  <option {{(isset($vessel)) && ($vessel->country == $value->id) ? 'selected' : Input::get('country') == $value->id ? 'selected' : '' }} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                              </select>
                              @else
                              <input class="form-control" placeholder="" id="billing_address_country" name="billing_address_country" type="text" required="true" value="{{isset($vessel) ? $route->country : Input::get('country')}}" @include('form.readonly')>
                              @endif
                              @include('errors.field', ['field' => 'country'])
                            </div>
                          </div>

                          <!--city-->
                          <div class="form-group row @include('errors.field-class', ['field' => 'city'])">
                            <label class="col-lg-2 control-label">{{trans('vessel.city')}} <span id="ics_load_vessel_city2"></span></label>
                            <div class="col-lg-10">
                              @if(!isset($readonly) || $readonly == false)
                              <select style="width:100%;" class="form-control" id="billing_address_city" name="billing_address_city" required="true" value="{{isset($vessel) ? $route->city : Input::get('city')}}" @include('form.readonly') >
                                <option value="0">{{trans('route.selectOption')}}</option>
                                @if(isset($view))
                                  @foreach($country as $key => $value)
                                    <option {{(isset($vessel)) && ($vessel->city == $value->id) ? 'selected' : Input::get('city') == $value->id ? 'selected' : '' }} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->name}}</option>
                                  @endforeach
                                @endif
                              </select>
                              @else
                              <input class="form-control" placeholder="" id="billing_address_city" name="billing_address_city" type="text" required="true" value="{{isset($vessel) ? $route->city : Input::get('city')}}" @include('form.readonly')>
                              @endif
                              @include('errors.field', ['field' => 'city'])
                            </div>
                          </div>

                           <!-- Estado -->
                          <div class="form-group row @include('errors.field-class', ['field' => 'billing_address_state'])">
                             <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.state')}}</label>
                             <div class="col-lg-10">
                                 <input type="text" class="form-control" id="billing_address_state" name="billing_address_state" value="" placeholder="{{trans('transporters.state')}}" @include('form.readonly')>
                             @include('errors.field', ['field' => 'address_state'])
                            </div>
                          </div>

                          <!-- Codigo Postal -->
                          <div class="form-group row @include('errors.field-class', ['field' => 'billing_address_code'])">
                             <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.code')}}</label>
                             <div class="col-lg-10">
                                 <input type="text" class="form-control" id=billing_"address_code" name="billing_address_code" value="" placeholder="{{trans('transporters.code')}}" @include('form.readonly')>
                             @include('errors.field', ['field' => 'address_code'])
                            </div>
                          </div>


                           <!-- Puerto -->
                          <div class="form-group row @include('errors.field-class', ['field' => 'billing_address_port'])">
                             <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.port')}}</label>
                             <div class="col-lg-10">
                                 <input type="text" class="form-control" id="billing_address_port" name="billing_address_port" value="" placeholder="{{trans('transporters.port')}}" @include('form.readonly')>
                             @include('errors.field', ['field' => 'address_port'])
                            </div>
                          </div>


                        </div>
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
                    <fieldset id="ics_fielset_load_routes_info" class="form">
                      <div class="row">
                        <div class="col-md-12" >
                            <input type="file" class="hidden2" id="upload_file" name="upload_file[]" onchange="preview_image();"  multiple="true"/>

                            <div id="image_preview" ></div>
                        </div>
                    </div>


                    </fieldset>
                  </div>
                </div>
              </div>
              <!--{{trans('shipment.cargoInfo')}}-->
            <div id="ics_tab_menu3" class="tab-pane fade" >
              <div class="panel panel-default">
                <div class="panel-heading text-muted">
                  <span><i class="fa fa-cubes" aria-hidden="true"></i></span>
                </div>
                  <div class="panel-body">
                    <div class="form-group row @include('errors.field-class', ['field' => 'note'])" id="type" >
                      <label class="col-lg-1 control-label" id="typeLabel" >{{trans('transporters.note')}}</label>
                      <div class="col-lg-11">
                          <textarea class="form-control" id="note" name="note" value="{{Input::get('note')}}" rows="4" placeholder="{{trans('transporters.note')}}" @include('form.readonly')>{{isset($transporters) ? $transporters->note : Input::get('note')}}</textarea>
                          @include('errors.field', ['field' => 'note'])
                      </div>
                    </div>

                    <div class="breadcrumb">
                          <span>{{trans('transporters.terms')}}</span>
                    </div>

                    <!-- Terminos -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'payments_term_terms'])">
                        <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.terms')}}</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="payments_term_terms" name="payments_term_terms" value="" placeholder="{{trans('transporters.terms')}}" @include('form.readonly')>
                           @include('errors.field', ['field' => 'payments_term_terms'])
                       </div>
                    </div>

                   <!-- Normalmente paga por -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'payments_term_pays'])">
                        <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.paymethod')}}</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="payments_term_pays" name="payments_term_pays" value="" placeholder="{{trans('transporters.paymethod')}}" @include('form.readonly')>
                           @include('errors.field', ['field' => 'payments_term_pays'])
                       </div>
                    </div>

                    <!-- Moneda -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'payments_term_coin'])">
                      <label class="col-lg-2 control-label">{{trans('transporters.coin')}}</label>
                      <div  class="col-lg-10">
                            <select style="width:100%;" class="form-control" id ="payments_term_coin" name="payments_term_coin" placeholder="{{trans('transporters.coin')}}"  value="{{isset($transporters) ? $transporters->payments_term_coin : Input::get('payments_term_coin')}}" @include('form.readonly')>
                               <option value="1">$ Dolar</option>
                               <option value="2">€ Euro</option>
                            </select>
                      </div>
                    </div>

                    <!-- Limite de Credito -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'payments_term_creditlimit'])">
                        <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.limitbill')}}</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="payments_term_creditlimit" name="payments_term_creditlimit" value="" placeholder="0.00" @include('form.readonly')>
                           @include('errors.field', ['field' => 'payments_term_creditlimit'])
                       </div>
                    </div>

                    <!-- Factura Periodicamente -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'payments_term_bill'])">
                        <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.billperio')}}</label>
                        <div class="col-lg-10">
                            <select style="width:100%;" class="form-control" id ="payments_term_bill" name="payments_term_bill" placeholder="{{trans('transporters.coin')}}"  value="{{isset($transporters) ? $transporters->payments_term_bill : Input::get('payments_term_bill')}}" @include('form.readonly')>
                               <option value="0">Seleccione Periodo a Facturar</option>
                               <option value="1">Nunca Aplicar</option>
                               <option value="2">Mensual</option>
                               <option value="3">Trimestral</option>
                               <option value="4">Semestral</option>
                            </select>
                       </div>
                    </div>
                  </div>

              </div>
            </div>

            <div id="ics_tab_menu4" class="tab-pane fade" >
                <div class="panel panel-default">
                  <div class="panel-heading text-muted">
                    <span><i class="fa fa-random" aria-hidden="true"></i></span>
                  </div>
                  <div class="panel-body">
                    <fieldset id="ics_fielset_load_routes_info" class="form">

                      <!-- Numero FMC -->
                        <div class="form-group row @include('errors.field-class', ['field' => 'numberfmc'])">
                            <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.numberfmc')}}</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="numberfmc" name="numberfmc" value="" placeholder="{{trans('transporters.numberfmc')}}" @include('form.readonly')>
                               @include('errors.field', ['field' => 'numberfmc'])
                           </div>
                        </div>

                      <!-- Numero SCAC -->
                      <div class="form-group row @include('errors.field-class', ['field' => 'numberscac'])">
                            <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.numberscac')}}</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="numberscac" name="numberscac" value="" placeholder="{{trans('transporters.numberscac')}}" @include('form.readonly')>
                               @include('errors.field', ['field' => 'numberscac'])
                           </div>
                        </div>


                    </fieldset>
                  </div>

                  <div class="pull-right" style="padding-bottom:5px;padding-top:5px;">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{trans(isset($transporters) ? 'transporters.update' : 'transporters.save')}}</button>
                  </div>
                </div>
              </div>

              <div id="ics_tab_menu5" class="tab-pane fade" >
                <div class="panel panel-default">
                  <div class="panel-heading text-muted">
                    <span><i class="fa fa-random" aria-hidden="true"></i></span>
                  </div>
                  <div class="panel-body">
                    <fieldset id="ics_fielset_load_routes_info" class="form">
                   <!-- Numero de cuenta IATA -->
                        <div class="form-group row @include('errors.field-class', ['field' => 'numberiata'])">
                            <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.numberiata')}}</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="numberiata" name="numberiata" value="" placeholder="{{trans('transporters.numberiata')}}" @include('form.readonly')>
                               @include('errors.field', ['field' => 'numberiata'])
                           </div>
                        </div>

                      <!-- Numero de la aerolinea -->
                      <div class="form-group row @include('errors.field-class', ['field' => 'codeair'])">
                            <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.codeair')}}</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="codeair" name="codeair" value="" placeholder="{{trans('transporters.codeair')}}" @include('form.readonly')>
                               @include('errors.field', ['field' => 'codeair'])
                           </div>
                        </div>


                        <!--NUmero de codigo de la aerolinea-->
                        <div class="form-group row @include('errors.field-class', ['field' => 'numbercodeair'])">
                            <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.numbercodeair')}}</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="numbercodeair" name="numbercodeair" value="" placeholder="{{trans('transporters.numbercodeair')}}" @include('form.readonly')>
                               @include('errors.field', ['field' => 'numbercodeair'])
                           </div>
                        </div>

                      <!-- Numero de Guia aerea -->
                      <div class="form-group row @include('errors.field-class', ['field' => 'guidenumber'])">
                            <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.guidenumber')}}</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="guidenumber" name="guidenumber" value="" placeholder="{{trans('transporters.guidenumber')}}" @include('form.readonly')>
                               @include('errors.field', ['field' => 'guidenumber'])
                           </div>
                        </div>


                    </fieldset>
                  </div>

                  <div class="pull-right" style="padding-bottom:5px;padding-top:5px;">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{trans(isset($transporters) ? 'transporters.update' : 'transporters.save')}}</button>
                  </div>
                </div>
              </div>

              <div id="ics_tab_menu6" class="tab-pane fade" >
                <div class="panel panel-default">
                  <div class="panel-heading text-muted">
                    <span><i class="fa fa-random" aria-hidden="true"></i></span>
                  </div>
                  <div class="panel-body">
                    <fieldset id="ics_fielset_load_routes_info" class="form">
                      <!-- Numero SCAC -->
                      <div class="form-group row @include('errors.field-class', ['field' => 'numberscac'])">
                            <label class="col-lg-2 control-label" id="typeLabel" >{{trans('transporters.numberscac')}}</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="numberscac" name="numberscac" value="" placeholder="{{trans('transporters.numberscac')}}" @include('form.readonly')>
                               @include('errors.field', ['field' => 'numberscac'])
                           </div>
                        </div>
                    </fieldset>
                  </div>

                  <div class="pull-right" style="padding-bottom:5px;padding-top:5px;">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{trans(isset($transporters) ? 'transporters.update' : 'transporters.save')}}</button>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
      <span>
        <input type="hidden" id="transport" name="transport" value="1">
      </span>
    </fieldset>
</form>
