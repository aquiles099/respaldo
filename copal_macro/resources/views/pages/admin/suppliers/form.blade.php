<form role="form" action="{{asset($path)}}" method="post" onsubmit="createLoad()" enctype="multipart/form-data">
  @if(isset($suppliers))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset>
    <!--tabs-->
    <ul class="nav nav-tabs nav-justified">
      <li id="ics_inactive_tab0" class="active"><a data-toggle="tab" href="#ics_tab_menu0">{{trans('suppliers.general')}} <span><i class="fa fa-exchange" aria-hidden="true"></i></span></a></li>
      <li id="ics_inactive_tab1"><a data-toggle="tab" href="#ics_tab_menu1">{{trans('suppliers.address')}} <span><i class="fa fa-phone-square" aria-hidden="true"></i></span></a></li>
      <li id="ics_inactive_tab2" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu2">{{trans('suppliers.attchments')}} <span><i class="fa fa-cloud-upload" aria-hidden="true"></i></span></a></li>
      <li id="ics_inactive_tab4" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu4">{{trans('suppliers.paymentterms')}} <span><i class="fa fa-tasks" aria-hidden="true"></i></span></a></li>
    </ul>
    <!--tab content-->
    <div class="tab-content">
      <div id="ics_tab_menu0" class="tab-pane fade in active" >
        <!--Cargo Info-->
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-exchange" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <div class="row" style="margin-left: 20px;margin-right: 20px;">
              <div class="col-md-12">
                <div class="breadcrumb">
                  <span>{{trans('suppliers.suppliersinfo')}}</span>
                </div>

                <!-- Nombre del proveedor -->
                <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.name')}}</label>
                  <div class="col-lg-10">
                       <input type="text" class="form-control" id="name" name="name" value="" placeholder="{{trans('suppliers.name')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'name'])
                   </div>
                 </div>

                <!-- Identificacion del proveedor -->
                <div class="form-group row @include('errors.field-class', ['field' => 'identification'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.identification')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="identification" name="identification" value="" placeholder="{{trans('suppliers.identification')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'identification'])
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <!-- telefono del proveedor -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'phone'])">
                       <label class="col-lg-4 control-label" id="typeLabel" >{{trans('suppliers.phone')}}</label>
                       <div class="col-lg-8">
                           <input type="text" class="form-control" id="phone" name="phone" value="" placeholder="{{trans('suppliers.phone')}}" @include('form.readonly')>
                       @include('errors.field', ['field' => 'phone'])
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <!-- fax del proveedor -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'fax'])">
                       <label class="col-lg-4 control-label" id="typeLabel" >{{trans('suppliers.fax')}}</label>
                       <div class="col-lg-8">
                           <input type="text" class="form-control" id="fax" name="fax" value="" placeholder="{{trans('suppliers.fax')}}" @include('form.readonly')>
                       @include('errors.field', ['field' => 'fax'])
                      </div>
                    </div>
                  </div>

                </div>

                <!-- Identificacion del correo -->
                <div class="form-group row @include('errors.field-class', ['field' => 'email'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.email')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="email" name="email" value="" placeholder="{{trans('suppliers.email')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'email'])
                  </div>
                </div>

                <!-- Pagina web -->
                <div class="form-group row @include('errors.field-class', ['field' => 'web'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.web')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="web" name="web" value="" placeholder="{{trans('suppliers.web')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'web'])
                  </div>
                </div>

                <!-- Numero de Cuenta -->
                <div class="form-group row @include('errors.field-class', ['field' => 'account_number'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.accountnumber')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="account_number" name="account_number" value="" placeholder="{{trans('suppliers.accountnumber')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'account_number'])
                  </div>
                </div>

                <!-- Nombre del contacto -->
                <div class="form-group row @include('errors.field-class', ['field' => 'name_contac'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.accountname')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="name_contac" name="name_contac" value="" placeholder="{{trans('suppliers.accountname')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'name_contac'])
                  </div>
                </div>

                <!-- Apellido del contacto -->
                <div class="form-group row @include('errors.field-class', ['field' => 'lastname_contac'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.accountlastname')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="lastname_contac" name="lastname_contac" value="" placeholder="{{trans('suppliers.accountlastname')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'lastname_contac'])
                  </div>
                </div>

                <!-- Numero de Exportacion -->
                <div class="form-group row @include('errors.field-class', ['field' => 'exportation'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.numberexportation')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="exportation" name="exportation" value="" placeholder="{{trans('suppliers.numberexportation')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'exportation'])
                  </div>
                </div>

                <!-- Division -->
                <div class="form-group row @include('errors.field-class', ['field' => 'divition'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.divition')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="divition" name="divition" value="" placeholder="{{trans('suppliers.divition')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'divition'])
                  </div>
                </div>


              </div>

            </div>
          </div>
        </div>
      </div> <!-- second tab -->
      <div id="ics_tab_menu1" class="tab-pane fade">
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-exchange" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <div class="breadcrumb">
                  <span>{{trans('suppliers.address')}}</span>
                </div>

                 <!-- Calle -->
                <div class="form-group row @include('errors.field-class', ['field' => 'address_street'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.street')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="billing_address_street" name="billing_address_street" value="" placeholder="{{trans('suppliers.street')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'address_street'])
                  </div>
                </div>


                <!--country-->
                <div class="form-group row @include('errors.field-class', ['field' => 'country'])">
                  <label class="col-lg-2 control-label">{{trans('vessel.country')}}</label>
                  <div class="col-lg-10">
                    @if(!isset($readonly) || $readonly == false)
                    <select class="form-control" id="ics_vessel_country" name="country" required="true" value="{{isset($vessel) ? $route->country : Input::get('country')}}" @include('form.readonly') >
                      <option value="0">{{trans('route.selectOption')}}</option>
                      @foreach($country as $key => $value)
                        <option {{(isset($vessel)) && ($vessel->country == $value->id) ? 'selected' : Input::get('country') == $value->id ? 'selected' : '' }} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{ucwords($value->name)}}</option>
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
                  <label class="col-lg-2 control-label">{{trans('vessel.city')}} <span id="ics_load_vessel_city2"></span></label>
                  <div class="col-lg-10">
                    @if(!isset($readonly) || $readonly == false)
                    <select class="form-control" id="ics_vessel_city" name="city" required="true" value="{{isset($vessel) ? $route->city : Input::get('city')}}" @include('form.readonly') >
                      <option value="0">{{trans('route.selectOption')}}</option>
                      @if(isset($view))
                        @foreach($country as $key => $value)
                          <option {{(isset($vessel)) && ($vessel->city == $value->id) ? 'selected' : Input::get('city') == $value->id ? 'selected' : '' }} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                      @endif
                    </select>
                    @else
                    <input class="form-control" placeholder="" name="" type="text" required="true" value="{{isset($vessel) ? $route->city : Input::get('city')}}" @include('form.readonly')>
                    @endif
                    @include('errors.field', ['field' => 'city'])
                  </div>
                </div>

                 <!-- Estado -->
                <div class="form-group row @include('errors.field-class', ['field' => 'address_state'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.state')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="billing_address_state" name="billing_address_state" value="" placeholder="{{trans('suppliers.state')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'address_state'])
                  </div>
                </div>

                <!-- Codigo Postal -->
                <div class="form-group row @include('errors.field-class', ['field' => 'address_code'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.code')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="billing_address_code" name="billing_address_code" value="" placeholder="{{trans('suppliers.code')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'address_code'])
                  </div>
                </div>


                 <!-- Puerto -->
                <div class="form-group row @include('errors.field-class', ['field' => 'address_port'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.port')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="billing_address_port" name="billing_address_port" value="" placeholder="{{trans('suppliers.port')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'address_port'])
                  </div>
                </div>

              </div>

              <div class="col-md-12">
                <div class="breadcrumb">
                  <span>{{trans('suppliers.addressbilling')}}</span>
                </div>

                 <!-- Calle -->
                <div class="form-group row @include('errors.field-class', ['field' => 'address_street'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.street')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="address_street" name="address_street" value="" placeholder="{{trans('suppliers.street')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'address_street'])
                  </div>
                </div>


                <!--country-->
                <div class="form-group row @include('errors.field-class', ['field' => 'country'])">
                  <label class="col-lg-2 control-label">{{trans('vessel.country')}}</label>
                  <div class="col-lg-10">
                    @if(!isset($readonly) || $readonly == false)
                    <select class="form-control" id="ics_vessel_country2" name="country" required="true" value="{{isset($vessel) ? $route->country : Input::get('country')}}" @include('form.readonly') >
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
                  <label class="col-lg-2 control-label">{{trans('vessel.city')}} <span id="ics_load_vessel_city2"></span></label>
                  <div class="col-lg-10">
                    @if(!isset($readonly) || $readonly == false)
                    <select class="form-control" id="ics_vessel_city2" name="city" required="true" value="{{isset($vessel) ? $route->city : Input::get('city')}}" @include('form.readonly') >
                      <option value="0">{{trans('route.selectOption')}}</option>
                      @if(isset($view))
                        @foreach($country as $key => $value)
                          <option {{(isset($vessel)) && ($vessel->city == $value->id) ? 'selected' : Input::get('city') == $value->id ? 'selected' : '' }} item="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                      @endif
                    </select>
                    @else
                    <input class="form-control" placeholder="" name="" type="text" required="true" value="{{isset($vessel) ? $route->city : Input::get('city')}}" @include('form.readonly')>
                    @endif
                    @include('errors.field', ['field' => 'city'])
                  </div>
                </div>

                 <!-- Estado -->
                <div class="form-group row @include('errors.field-class', ['field' => 'address_state'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.state')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="address_state" name="address_state" value="" placeholder="{{trans('suppliers.state')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'address_state'])
                  </div>
                </div>

                <!-- Codigo Postal -->
                <div class="form-group row @include('errors.field-class', ['field' => 'address_code'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.code')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="address_code" name="address_code" value="" placeholder="{{trans('suppliers.code')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'address_code'])
                  </div>
                </div>

                 <!-- Puerto -->
                <div class="form-group row @include('errors.field-class', ['field' => 'address_port'])">
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.port')}}</label>
                   <div class="col-lg-10">
                       <input type="text" class="form-control" id="address_port" name="address_port" value="" placeholder="{{trans('suppliers.port')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'address_port'])
                  </div>
                </div>


              </div>
            </div>
          </div>
        </div>
      </div> <!--fisrt tab-->
      <div id="ics_tab_menu2" class="tab-pane fade">
        <!--Aditional Info-->
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
      <div id="ics_tab_menu4" class="tab-pane fade">
        <!--Aditional Info-->
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-tasks" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <div class="form-group row @include('errors.field-class', ['field' => 'note'])" id="type" >
              <label class="col-lg-1 control-label" id="typeLabel" >{{trans('suppliers.note')}}</label>
              <div class="col-lg-11">
                  <textarea class="form-control" id="note" name="note" value="{{Input::get('note')}}" rows="4" placeholder="{{trans('suppliers.note')}}" @include('form.readonly')>{{isset($suppliers) ? $suppliers->note : Input::get('note')}}</textarea>
                  @include('errors.field', ['field' => 'note'])
              </div>
            </div>
            <div class="breadcrumb">
                  <span>{{trans('suppliers.terms')}}</span>
            </div>
            <!-- Terminos -->
            <div class="form-group row @include('errors.field-class', ['field' => 'payments_term_terms'])">
                <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.terms')}}</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="payments_term_terms" name="payments_term_terms" value="" placeholder="{{trans('suppliers.terms')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'payments_term_terms'])
               </div>
            </div>
           <!-- Normalmente paga por -->
            <div class="form-group row @include('errors.field-class', ['field' => 'payments_term_pays'])">
                <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.paymethod')}}</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="payments_term_pays" name="payments_term_pays" value="" placeholder="{{trans('suppliers.paymethod')}}" @include('form.readonly')>
                   @include('errors.field', ['field' => 'payments_term_pays'])
               </div>
            </div>
            <!-- Moneda -->
            <div class="form-group row @include('errors.field-class', ['field' => 'payments_term_coin'])">
              <label class="col-lg-2 control-label">{{trans('suppliers.coin')}}</label>
              <div  class="col-lg-10">
                    <select class="form-control" id ="payments_term_coin" name="payments_term_coin" placeholder="{{trans('suppliers.coin')}}"  value="{{isset($suppliers) ? $suppliers->payments_term_coin : Input::get('payments_term_coin')}}" @include('form.readonly')>
                       <option value="1">$ Dolar</option>
                       <option value="2">€ Euro</option>
                    </select>
              </div>
            </div>
            <!-- Limite de Credito -->
            <div class="form-group row @include('errors.field-class', ['field' => 'payments_term_pays'])">
                <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.limitbill')}}</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="payments_term_pays" name="payments_term_pays" value="" placeholder="0.00" @include('form.readonly')>
                   @include('errors.field', ['field' => 'payments_term_pays'])
               </div>
            </div>
            <!-- Factura Periodicamente -->
            <div class="form-group row @include('errors.field-class', ['field' => 'payments_term_bill'])">
                <label class="col-lg-2 control-label" id="typeLabel" >{{trans('suppliers.billperio')}}</label>
                <div class="col-lg-10">
                    <select class="form-control" id ="payments_term_coin" name="payments_term_coin" placeholder="{{trans('suppliers.coin')}}"  value="{{isset($suppliers) ? $suppliers->payments_term_coin : Input::get('payments_term_coin')}}" @include('form.readonly')>
                       <option value="0">Seleccione Periodo a Facturar</option>
                       <option value="1">Nunca Aplicar</option>
                       <option value="2">Mensual</option>
                       <option value="3">Trimestral</option>
                       <option value="4">Semestral</option>
                    </select>
               </div>
            </div>
          </div>
          <div class="pull-right" id="divButton"style="padding-bottom:5px;padding-top:5px;">
            <button class="btn btn-primary" type="submit" id="submit-all"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{trans(isset($suppliers) ? 'suppliers.update' : 'suppliers.save')}}</button>
          </div>
          </div>
        </div>
      </div>
    </div>
  </fieldset>
</form>
