<form role="form" action="{{asset($path)}}" onsubmit="createLoad()" method="post" id="ics_cargo_booking_form" novalidate enctype="multipart/form-data" >
  @if(isset($booking))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset>
    <!--tabs-->
    <ul class="nav nav-tabs nav-justified">
      <li id="ics_inactive_tab0" class="active"><a data-toggle="tab" href="#ics_tab_home">{{trans('booking.generalInformation')}} <span><i class="fa fa-exchange" aria-hidden="true"></i></span></a></li>
      <li id="ics_inactive_tab1" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu1">{{trans('booking.chargeInformation')}} <span><i class="fa fa-cubes" aria-hidden="true"></i></span></a></li>
      <li id="ics_inactive_tab2" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu2">{{trans('booking.contactInformation')}} <span><i class="fa fa-user" aria-hidden="true"></i></span></a></li>
      <li id="ics_inactive_tab3" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu3">{{trans('transporters.attchments')}} <span><i class="fa fa-cloud-upload" aria-hidden="true"></i></span></a></li>
      <li id="ics_inactive_tab4" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu4">{{trans('booking.aditionalInformation')}} <span><i class="fa fa-plus-square-o" aria-hidden="true"></i></span></a></li>
    </ul>
    <input type="hidden" name="countbooking" id="countbooking" value="1">
    <!--body tabs-->
    <div class="tab-content">
      <div id="ics_tab_home"  class="tab-pane fade in active">
        <!--General Info-->
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-exchange" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <!--transport and course-->
            <div class="form-group row @include('errors.field-class', ['field' => 'transport'])" id="type" >
              <label class="col-lg-2 control-label" id="typeLabel" >{{trans('booking.typeTransport')}}</label>
              <div class="col-lg-4">
                <select class="form-control" id="transport" name="transport" required="true" @include('form.readonly')>
                  @if(isset($transports))
                    @foreach($transports as $key => $transport)
                      <option {{isset($booking) ? ($booking->transport == $transport->id) ? 'selected' : '' : '' }} name ="{{$transport->spanish}}" value="{{$transport->id}}">{{$transport->spanish}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
              <label class="col-lg-2 control-label" id="typeLabel" >{{trans('booking.course')}}</label>
              <div class="col-lg-4">
                <select class="form-control" id="course" name="course" required="true" @include('form.readonly')>
                  @if(isset($bookingCourse))
                    @foreach($bookingCourse as $key => $course)
                      <option {{isset($booking) ? ($booking->course == $course['text']) ? 'selected' : '' : '' }} name ="{{$course['text']}}" value="{{$course['text']}}">{{$course['text']}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            <!--from & to-->
            <div class="form-group row @include('errors.field-class', ['field' => 'from'])" id="type" >
              <label class="col-lg-2 control-label" id="typeLabel" >{{trans('booking.from')}}</label>
              <div class="col-lg-4">
                <select class="form-control" id="transport" name="from_country" required="true" @include('form.readonly')>
                  @if(isset($countrys))
                    @foreach($countrys as $key => $country)
                      <option {{isset($booking) ? ($booking->from_country == $country->id) ? 'selected' : '' : '' }} name ="{{$country->code}}{{$country->name}}" value="{{$country->id}}">{{$country->code}} {{$country->name}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
              <label class="col-lg-2 control-label" id="typeLabel" >{{trans('booking.to')}}</label>
              <div class="col-lg-4">
                <select class="form-control" id="course" name="to_country" required="true" @include('form.readonly')>
                  @if(isset($countrys))
                    @foreach($countrys as $key => $country)
                      <option {{isset($booking) ? ($booking->to_country == $country->id) ? 'selected' : '' : '' }} name ="{{$country->code}}{{$country->name}}" value="{{$country->id}}">{{$country->code}} {{$country->name}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            <!--divider-->
            <div class="breadcrumb">
              <span>{{trans('booking.departureDateRange')}}</span>
            </div>
            <!--departure range-->
            <div class="form-group row @include('errors.field-class', ['field' => 'from'])" id="type" >
              <label class="col-lg-2 control-label" id="typeLabel" >{{trans('booking.since')}}</label>
              <div class="col-lg-4 @include('errors.field-class', ['field' => 'departureSince'])">
                <div class="input-group">
                  <input type="text" class="form-control" id="departureSince" name="since_departure_date" value="{{isset($booking) ? $booking->since_departure_date : Input::get('departureSince')}}" required="true" placeholder ="{{trans('booking.since')}}" @include('form.readonly')>
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                @include('errors.field', ['field' => 'departureSince'])
              </div>
              <label class="col-lg-2 control-label" id="typeLabel" >{{trans('booking.until')}}</label>
              <div class="col-lg-4 @include('errors.field-class', ['field' => 'departureUntil'])">
                <div class="input-group">
                  <input type="text" class="form-control" id="departureUntil" name="until_departure_date" value="{{isset($booking) ? $booking->until_departure_date : Input::get('departureUntil')}}" required="true" placeholder ="{{trans('booking.until')}}" @include('form.readonly')>
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                 @include('errors.field', ['field' => 'departureUntil'])
              </div>
            </div>
            <!--divider-->
            <div class="breadcrumb">
              <span>{{trans('booking.arrivedDateRange')}}</span>
            </div>
            <!--departure range-->
            <div class="form-group row @include('errors.field-class', ['field' => 'from'])" id="type" >
              <label class="col-lg-2 control-label" id="typeLabel" >{{trans('booking.since')}}</label>
              <div class="col-lg-4 @include('errors.field-class', ['field' => 'arrivedSince'])">
                <div class="input-group">
                  <input type="text" class="form-control" id="arrivedSince" name="since_arrived_date" value="{{isset($booking) ? $booking->since_arrived_date : Input::get('arrivedSince')}}" required="true" placeholder ="{{trans('booking.since')}}" @include('form.readonly')>
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                    @include('errors.field', ['field' => 'arrivedSince'])
              </div>
              <label class="col-lg-2 control-label" id="typeLabel" >{{trans('booking.until')}}</label>
              <div class="col-lg-4 @include('errors.field-class', ['field' => 'arrivedUntil'])">
                <div class="input-group">
                  <input type="text" class="form-control" id="arrivedUntil" name="until_arrived_date" value="{{isset($booking) ? $booking->until_arrived_date : Input::get('arrivedUntil')}}" required="true" placeholder ="{{trans('booking.until')}}" @include('form.readonly')>
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                  @include('errors.field', ['field' => 'arrivedUntil'])
              </div>
            </div>
          </div>
        </div>
      </div> <!--fisrt tab-->
      <div id="ics_tab_menu1" class="tab-pane fade" >
        <!--Cargo Info-->
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-cubes" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <!--divider-->
                <div class="breadcrumb">
                  <span>{{trans('booking.descriptionOfGoods')}}</span>
                </div>
                <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'declarateGoods'])"  id="divlarge" >
                  <textarea class="form-control" id="declarateGoods" name="declarate_goods" placeholder="{{trans('booking.descriptionOfGoods')}}">{{isset($booking) ? $booking->declarate_goods : Input::get('declarateGoods')}}</textarea>
                  @include('errors.field', ['field' => 'declarateGoods'])
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <!--divider-->
                <div class="breadcrumb">
                  <div class="" style="text-align:right">
                    <span style="float:left">{{($edit == true) ? trans('booking.editCargo') : trans('booking.addCargo')}}</span>
                    <span><button type="button" class="btn btn-primary btn-xs" name="button" onclick="icsAddCargoOnBooking({{$edit}})">{{trans('booking.addPackage')}} <i aria-hidden="true" class="fa fa-plus"></i></button></span>
                  </div>
                </div>
                <!-- Cargo List-->
                <fieldset>
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <div class="row" style="padding: 0px 30px 0 30px;">
                        <!-- Add Button -->
                        <ul class="nav nav-tabs" id="ics_booking_list">
                          <li class="paq active" id='ics_li_cargo1'><a data-toggle="tab" href="#ics_bk_1"><i class="fa fa-circle-o-notch" aria-hidden="true"></i> {{trans('booking.Bk')}}1</a></li>
                        </ul>
                        <!-- Booking Create-->
                        <div class="tab-content" id="ics_content_booking">
                          <div id="ics_bk_1" class="tab-pane fade in active" style="padding:20px">
                            <div class="row" id="ics_cargo_content">
                             <div class="col-md-8">
                               <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'description1'])"  id="divlarge" >
                                 <label class="col-lg-2 control-label" id="typeLabel" >{{trans('booking.description')}}</label>
                                 <div class="col-lg-10">
                                   <input type="text" class="form-control" placeholder="{{trans('package.description')}}" id="description1" name="description1" type="float" min="1" required="true" value="@if(!isset($booking)){{clear(Input::get('description1'))}}@endif" @include('form.readonly')>
                                       @include('errors.field', ['field' => 'description1'])
                                 </div>
                               </div>

                               <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'pieces1'])"  id="divlarge" >
                                 <label class="col-lg-2 control-label" id="typeLabel" >{{trans('booking.pieces')}}</label>
                                 <div class="col-lg-10">
                                   <input type="number" class="form-control" placeholder="{{trans('package.pieces')}}" id="pieces1" name="pieces1" type="int" maxlength="10" min="1" required="true" value="@if(!isset($booking)){{clear(Input::get('pieces1'))}}@endif" @include('form.readonly')>
                                       @include('errors.field', ['field' => 'pieces1'])
                                 </div>
                               </div>

                               <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'type1'])"  id="divlarge" >
                                 <label class="col-lg-2 control-label" id="typeLabel" >{{trans('booking.type')}}</label>
                                 <div class="col-lg-10">
                                   <select class="form-control" id="type1" name="type1" required="true" @include('form.readonly')>
                                     @foreach($container as $key => $value)
                                      <option item ="{{$value->toInnerJson()}}" value="{{$value->id}}">{{$value->name}}</option>
                                     @endforeach
                                    </select>
                                       @include('errors.field', ['field' => 'type1'])
                                 </div>
                               </div>
                             </div>
                             <!-- Booking Dimensions-->
                             <div class="col-md-4">
                               <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'large1'])"  id="divlarge" >
                                 <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.large')}}</label>
                                 <div class="col-lg-9">
                                   <input type="number" class="form-control form_dimension" placeholder="{{trans('package.large')}}" id="large1" name="large1" onkeyup="icsGetPesoVol()" type="float" maxlength="10" min="1" required="true" value="@if(!isset($booking)){{clear(Input::get('large1'))}}@endif" @include('form.readonly')>
                                   <span>in</span>
                                   @include('errors.field', ['field' => 'large1'])
                                 </div>
                               </div>

                               <div class="dimensmedidas  @include('errors.field-class', ['field' => 'width1'])" onkeyup="icsGetPesoVol()" id="divwidth">
                                 <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.width')}}</label>
                                 <div class="col-lg-9">
                                   <input type="number" class="form-control form_dimension" placeholder="{{trans('package.width')}}" id="width1" name="width1" type="float" maxlength="10" min="1" required="true" value="@if(!isset($booking)){{clear(Input::get('width1'))}}@endif" @include('form.readonly')>
                                   <span>in</span>
                                   @include('errors.field', ['field' => 'width1'])
                                </div>
                               </div>

                               <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height1'])" id="divheight">
                                 <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.height')}}</label>
                                 <div class="col-lg-9">
                                   <input type="number" class="form-control form_dimension" placeholder="{{trans('package.height')}}" id="height1" onkeyup="icsGetPesoVol()" name="height1" type="float" maxlength="10" min="1" required="true" value="@if(!isset($booking)){{clear(Input::get('height1'))}}@endif"
                                   @include('form.readonly')>
                                   <span>in</span>
                                   @include('errors.field', ['field' => 'height1'])
                                 </div>
                               </div>

                               <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'volumetricweightm1'])" id="divheight">
                                 <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.volumem')}}</label>
                                 <div class="col-lg-9">
                                   <input type="number" class="form-control form_dimension" placeholder="{{trans('package.volumem')}}" id="volumetricweightm1" onkeyup="icsGetPesoVol()" name="volumetricweightm1" type="float" readonly="" maxlength="10" min="1" required="true" value="@if(!isset($booking)){{clear(Input::get('volumetricweightm1'))}}@endif" @include('form.readonly')>
                                   <span>ft<sup>3</sup></span>
                                   @include('errors.field', ['field' => 'volumetricweightm1'])
                                 </div>
                               </div>


                               <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'volumetricweighta1'])" id="divheight">
                                 <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.volumea')}}</label>
                                 <div class="col-lg-9">
                                   <input type="number" class="form-control form_dimension" placeholder="{{trans('package.volumea')}}" id="volumetricweighta1" onkeyup="icsGetPesoVol()" name="volumetricweighta1" type="float" readonly="" maxlength="10" min="1" required="true" value="@if(!isset($booking)){{clear(Input::get('volumetricweighta1'))}}@endif" @include('form.readonly')>
                                   <span>Vlb</span>
                                    @include('errors.field', ['field' => 'volumetricweighta1'])
                                 </div>
                               </div>

                               <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'weight1'])" id="divheight">
                                 <label class="col-lg-3 control-label " id="typeLabel" >{{trans('package.weight')}}</label>
                                 <div class="col-lg-9">
                                   <input type="number" class="form-control form_dimension" placeholder="{{trans('package.weight')}}" id="weight1" onkeyup="icsGetPesoVol()" name="weight1" type="float" maxlength="10" min="1" required="true" value="@if(!isset($booking)){{clear(Input::get('weight1'))}}@endif" @include('form.readonly')>
                                   <span>lb</span>
                                  @include('errors.field', ['field' => 'weight1'])
                                 </div>
                               </div>
                             </div>
                           </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- second tab -->
      <div id="ics_tab_menu2" class="tab-pane fade">
        <!--Contact Info-->
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-user" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <!--Divider-->
                <div class="breadcrumb">
                  <span>{{trans('booking.shipperInformation')}}</span>
                </div>
                <!--Shipper Information-->
                <fieldset class="form">
                  <!--user-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'shipperName'])" >
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.name')}}</label>
                    <div class="col-lg-9">
                      <select class="form-control" id="shipperName" name="shipperName" required="true" @include('form.readonly')>
                        @if(isset($users))
                          <option value="">{{trans('booking.selectUser')}}</option>
                          <option value="adduc">{{trans('package.adduser')}}</option>
                          @foreach($users as $key => $user)
                            <option {{isset($booking) && $booking->shipper =! null ? ($booking->shipper == $user->id) ? 'selected' : '' : '' }} name ="{{$user->name}} {{$user->last_name}}" item="{{$user->toInnerJson()}}" value="{{$user->id}}">{{$user->code}} {{$user->name}} {{$user->last_name}}</option>
                          @endforeach
                        @endif
                      </select>
                        @include('errors.field', ['field' => 'shipperName'])
                    </div>
                  </div>
                  <!--name-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'name'])" id="clientName" >
                  <label class="col-lg-3 control-label" id="labelName" >{{trans('booking.name')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" readonly="true" placeholder="{{trans('package.clientName')}}" id="cons_name" name="cons_name" type="text" maxlength="25" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['name'] : clear(Input::get('name'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'name'])
                  </div>
                </div>
                 <!--last name-->
                <div class="form-group row @include('errors.field-class', ['field' => 'name'])" id="clientName" >
                  <label class="col-lg-3 control-label" id="labelName" >{{trans('package.clientLastName')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" readonly="true" placeholder="{{trans('package.clientLastName')}}" id="cons_lastname" name="cons_lastname" type="text" maxlength="25" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['last_name'] : clear(Input::get('name'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'name'])
                  </div>
                </div>
                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'dni'])">
                  <label class="col-lg-3 control-label">{{trans('messages.dni')}} </label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('messages.dni')}}" name="cons_dni" id="cons_dni" type="text"  maxlength="100" min="5" readonly="true" required="true" value="{{isset($package->consigner_user) ? $package->getToConsigneUser['dni'] : Input::get('dni')}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'dni'])
                  </div>
                </div>
                <!--cell_phone-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'localPhone'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.phone')}}</label>
                    <div class="col-lg-9">
                        <input type="text" readonly="true" class="form-control" id="cons_phone" name="cons_phone" value="{{isset($booking->getShipper) ? $booking->getShipper->celular : Input::get('shipperPhone')}}" placeholder="{{trans('booking.phone')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'shipperPhone'])
                    </div>
                  </div>
                  <!--cell_phone-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'shipperPhone'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.cell')}}</label>
                    <div class="col-lg-9">
                        <input type="text" readonly="true" class="form-control" id="cons_cell" name="cons_cell" value="{{isset($booking->getShipper) ? $booking->getShipper->celular : Input::get('shipperPhone')}}" placeholder="{{trans('package.cell')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'shipperPhone'])
                    </div>
                  </div>
                   <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'email'])" id="clientEmail" >
                  <label class="col-lg-3 control-label" id="labelEmail" >{{trans('package.clientEmail')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" readonly="true" placeholder="{{trans('package.clientEmail')}}" id="cons_email" name="cons_email" type="text" maxlength="50" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['email'] : clear(Input::get('email'))}}"@include('form.readonly')>
                      @include('errors.field', ['field' => 'email'])
                  </div>
                </div>
                  <!--country-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'shipperCountry'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.country')}}</label>
                    <div class="col-lg-9">
                        <input type="text" readonly="true" class="form-control" id="cons_country" name="cons_country" value="{{isset($booking->getShipper) ? $booking->getShipper->country : Input::get('shipperCountry')}}" placeholder="{{trans('booking.country')}}"equired="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'shipperCountry'])
                    </div>
                  </div>
                  <!--region-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'shipperRegion'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.region')}}</label>
                    <div class="col-lg-9">
                        <input type="text" readonly="true" class="form-control" id="cons_region" name="cons_region" value="{{isset($booking->getShipper) ? $booking->getShipper->region : Input::get('shipperRegion')}}" placeholder="{{trans('booking.region')}}"required="true" @include('form.readonly')>
                    @include('errors.field', ['field' => 'shipperRegion'])
                    </div>
                  </div>
                  <!--city-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'shipperCity'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.city')}}</label>
                    <div class="col-lg-9">
                        <input type="text" readonly="true" class="form-control" id="cons_city" name="cons_city" value="{{isset($booking->getShipper) ? $booking->getShipper->city : Input::get('shipperCity')}}" placeholder="{{trans('booking.city')}}"required="true" @include('form.readonly')>
                    @include('errors.field', ['field' => 'shipperCity'])
                    </div>
                  </div>
                  <!--address-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'shipperAdress'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.address')}}</label>
                    <div class="col-lg-9">
                        <textarea readonly="true" class="form-control" id="cons_direction" name="cons_direction" value="{{isset($booking->getShipper) ? $booking->getShipper->address : Input::get('shipperAdress')}}" placeholder="{{trans('booking.address')}}"required="true" @include('form.readonly')>{{isset($booking->getShipper) ? $booking->getShipper->address : Input::get('shipperAdress')}}</textarea>
                    @include('errors.field', ['field' => 'shipperAdress'])
                    </div>
                  </div>
                  <!--postal code-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'shipperPostalCode'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.postalCode')}}</label>
                    <div class="col-lg-9">
                        <input type="text" readonly="true" class="form-control" id="cons_zipcode" name="cons_zipcode" value="{{isset($booking->getShipper) ? $booking->getShipper->postal_code : Input::get('shipperPostalCode')}}" placeholder="{{trans('booking.postalCode')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'shipperPostalCode'])
                    </div>
                  </div>
                </fieldset>
              </div>
              <div class="col-md-6">
                <!--Divider-->
                <div class="breadcrumb">
                  <span>{{trans('booking.consigneeInformation')}}</span>
                </div>
                <!--Shipper Information-->
                <fieldset class="form">
                  <!--user-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'shipperName'])" >
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.name')}}</label>
                    <div class="col-lg-9">
                      <select class="form-control" id="consName" name="consName" required="true" @include('form.readonly')>
                        @if(isset($users))
                          <option value="">{{trans('booking.selectUser')}}</option>
                          <option value="addud">{{trans('package.adduser')}}</option>
                          @foreach($users as $key => $user)
                            <option {{isset($booking) && $booking->shipper =! null ? ($booking->shipper == $user->id) ? 'selected' : '' : '' }} name ="{{$user->name}} {{$user->last_name}}" item="{{$user->toInnerJson()}}" value="{{$user->id}}">{{$user->code}} {{$user->name}} {{$user->last_name}}</option>
                          @endforeach
                        @endif
                      </select>
                        @include('errors.field', ['field' => 'shipperName'])
                    </div>
                  </div>
                  <!--name-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'name'])" id="clientName" >
                  <label class="col-lg-3 control-label" id="labelName" >{{trans('booking.name')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" readonly="true" placeholder="{{trans('package.clientName')}}" id="destin_name" name="destin_name" type="text" maxlength="25" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['name'] : clear(Input::get('name'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'name'])
                  </div>
                </div>
                 <!--last name-->
                <div class="form-group row @include('errors.field-class', ['field' => 'name'])" id="clientName" >
                  <label class="col-lg-3 control-label" id="labelName" >{{trans('package.clientLastName')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" readonly="true" placeholder="{{trans('package.clientLastName')}}" id="destin_lastname" name="destin_lastname" type="text" maxlength="25" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['last_name'] : clear(Input::get('name'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'name'])
                  </div>
                </div>
                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'dni'])">
                  <label class="col-lg-3 control-label">{{trans('messages.dni')}} </label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('messages.dni')}}" name="destin_dni" id="destin_dni" type="text"  maxlength="100" min="5" readonly="true" required="true" value="{{isset($package->consigner_user) ? $package->getToConsigneUser['dni'] : Input::get('dni')}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'dni'])
                  </div>
                </div>
                <!--cell_phone-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'localPhone'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.phone')}}</label>
                    <div class="col-lg-9">
                        <input type="text" readonly="true" class="form-control" id="destin_phonedestin" name="destin_phone" value="{{isset($booking->getShipper) ? $booking->getShipper->celular : Input::get('shipperPhone')}}" placeholder="{{trans('booking.phone')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'shipperPhone'])
                    </div>
                  </div>
                  <!--cell_phone-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'shipperPhone'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.cell')}}</label>
                    <div class="col-lg-9">
                        <input type="text" readonly="true" class="form-control" id="destin_cell" name="destin_cell" value="{{isset($booking->getShipper) ? $booking->getShipper->celular : Input::get('shipperPhone')}}" placeholder="{{trans('package.cell')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'shipperPhone'])
                    </div>
                  </div>
                   <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'email'])" id="clientEmail" >
                  <label class="col-lg-3 control-label" id="labelEmail" >{{trans('package.clientEmail')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" readonly="true" placeholder="{{trans('package.clientEmail')}}" id="destin_email" name="destin_email" type="text" maxlength="50" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['email'] : clear(Input::get('email'))}}"@include('form.readonly')>
                      @include('errors.field', ['field' => 'email'])
                  </div>
                </div>
                  <!--country-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'shipperCountry'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.country')}}</label>
                    <div class="col-lg-9">
                        <input type="text" readonly="true" class="form-control" id="destin_country" name="destin_country" value="{{isset($booking->getShipper) ? $booking->getShipper->country : Input::get('shipperCountry')}}" placeholder="{{trans('booking.country')}}"equired="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'shipperCountry'])
                    </div>
                  </div>
                  <!--region-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'shipperRegion'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.region')}}</label>
                    <div class="col-lg-9">
                        <input type="text" readonly="true" class="form-control" id="destin_region" name="destin_region" value="{{isset($booking->getShipper) ? $booking->getShipper->region : Input::get('shipperRegion')}}" placeholder="{{trans('booking.region')}}"required="true" @include('form.readonly')>
                    @include('errors.field', ['field' => 'shipperRegion'])
                    </div>
                  </div>
                  <!--city-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'shipperCity'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.city')}}</label>
                    <div class="col-lg-9">
                        <input type="text" readonly="true" class="form-control" id="destin_city" name="destin_city" value="{{isset($booking->getShipper) ? $booking->getShipper->city : Input::get('shipperCity')}}" placeholder="{{trans('booking.city')}}"required="true" @include('form.readonly')>
                    @include('errors.field', ['field' => 'shipperCity'])
                    </div>
                  </div>
                  <!--address-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'shipperAdress'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.address')}}</label>
                    <div class="col-lg-9">
                        <textarea readonly="true" class="form-control" id="destin_direction" name="destin_direction" value="{{isset($booking->getShipper) ? $booking->getShipper->address : Input::get('shipperAdress')}}" placeholder="{{trans('booking.address')}}"required="true" @include('form.readonly')>{{isset($booking->getShipper) ? $booking->getShipper->address : Input::get('shipperAdress')}}</textarea>
                    @include('errors.field', ['field' => 'shipperAdress'])
                    </div>
                  </div>
                  <!--postal code-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'shipperPostalCode'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.postalCode')}}</label>
                    <div class="col-lg-9">
                        <input type="text" readonly="true" class="form-control" id="destin_zipcode" name="destin_zipcode" value="{{isset($booking->getShipper) ? $booking->getShipper->postal_code : Input::get('shipperPostalCode')}}" placeholder="{{trans('booking.postalCode')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'shipperPostalCode'])
                    </div>
                  </div>
                </fieldset>
              </div>





            </div>
          </div>
        </div>
      </div> <!-- third tab -->

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

      <div id="ics_tab_menu4" class="tab-pane fade">
        <!--Aditional Info-->
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-plus-square-o" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <!--adiional info-->
            <div class="form-group row @include('errors.field-class', ['field' => 'aditionalInformation'])" id="type" >
              <label class="col-lg-3 control-label" id="typeLabel" >{{trans('booking.aditionalInformation')}}</label>
              <div class="col-lg-9">
                  <textarea class="form-control" id="aditionalInformation" name="aditional_information" value="{{Input::get('aditionalInformation')}}" placeholder="{{trans('booking.aditionalInformation')}}"required="true" @include('form.readonly')>{{isset($booking) ? $booking->aditional_information : Input::get('aditionalInformation')}}</textarea>
                  @include('errors.field', ['field' => 'aditionalInformation'])
              </div>
            </div>
            <!-- send data -->
            <div class="pull-right" id="divButton">
              <button class="btn btn-primary" type="submit" id="submit-all"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{trans(isset($booking) ? 'booking.update' : 'booking.save')}}</button>
            </div>
          </div>
        </div>
      </div> <!--last tab --> <!--Last tab-->
    </div>
  </fieldset>
</form>
