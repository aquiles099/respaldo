<?php
use App\Models\Admin\Company;
use App\Models\Admin\Transporters;
 ?>
<script type="text/javascript">
$(document).ready( function() {
  initSelect2();
  setInitials();

  //ordenarSelect('finalConsigUser');
});
/*ORDENAR LOS CONSIGNATARIOS
function ordenarSelect(id_componente)
  {
    var selectToSort = jQuery('#' + id_componente);
    var optionActual = selectToSort.val();
    selectToSort.html(selectToSort.children('option').sort(function (a, b) {
      return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
    })).val(optionActual);
  }*/
</script>
@include('pages.admin.packagecurriers.messages')
<div class="panel panel-default">
    <div class="panel-body">

<form role="form" action="{{asset($path)}}" method="post" onsubmit="createPackage()" novalidate enctype="multipart/form-data">
  @if(isset($package))
    <input type="hidden" name="_method" value="patch">
  @endif
  <input type="hidden" id="unidad" name="unidad" value="{{(isset($package) && $package->unidad == 1) ? 1 : 0}}">
  <fieldset class="form" style="height:678px;">

   <ul class="nav nav-tabs nav-justified">
      <li class="active"><a data-toggle="tab" href="#ics_tab_home">{{trans('package.clientInfo')}} <span><i class="fa fa-user" aria-hidden="true"></i></span></a></li>
      <li><a data-toggle = "tab" href="#ics_tab_menu1">{{trans('booking.chargeInformation')}} <span><i class="fa fa-cubes" aria-hidden="true"></i></span></a></li>

      <li><a data-toggle = "tab" href="#ics_tab_menu2">{{trans('package.packageservice')}} <span><i class="fa fa-exchange" aria-hidden="true"></i></span></a></li>

      <li><a data-toggle = "tab" href="#ics_tab_menu3">{{trans('transporters.attchments')}} <span><i class="fa fa-cloud-upload" aria-hidden="true"></i></span></a></li>

      <li><a data-toggle = "tab" href="#ics_tab_menu4">{{trans('package.packagepayment')}} <span><i class="fa fa-credit-card" aria-hidden="true"></i></span></a></li>
      <!--<li><a data-toggle = "tab" href="#ics_tab_menu4">{{trans('package.attachment')}} <span><i class="fa fa-cubes" aria-hidden="true"></i></span></a></li>
      <li><a data-toggle = "tab" href="#ics_tab_menu5">{{trans('package.transport')}} <span><i class="fa fa-truck" aria-hidden="true"></i></span></a></li>-->
    </ul>

    <div class="tab-content" style="height:560px">
      <div id="ics_tab_home" class="tab-pane fade in active">
        <div class="panel panel-default" >
           <div class="panel-heading text-muted">
            <span><i class="fa fa-user" aria-hidden="true"></i></span>
            <span class="pull-right">
              <span class="text-muted">
                <!--<a role="button" onclick="alert('in process...')" class="btn btn-primary btn-xs">{{trans('package.next')}} <i class="fa fa-chevron-right" aria-hidden="true"></i></a>-->
              </span>
            </span>
           </div>

              <div class="row" style="padding: 0 20px 0px 20px;">
              <div class="col-md-6">
                <div class="breadcrumbpack">
                    <span>{{trans('package.userconsigner')}}</span>
                </div>
                <input type="hidden" id="shipper_is" name="shipper_is" value="{{isset($package->shipper_is) ? $package->shipper_is : 0}}">
                <div class="form-group row @include('errors.field-class', ['field' => 'finalOriginUser'])" id="destination" style="display:block;"}}>
                  <label class="col-lg-3 control-label">{{trans('package.user')}}</label>
                  <div class="col-lg-9">
                  <select style="width:100%;" class="form-control" id="finalConsigUser" name="finalConsigUser"  @include('form.readonly') >
                  <option value="">{{trans('package.chooseUser')}}</option>
                  <option value="adduc">{{trans('package.adduser')}}</option>
                  @if(isset($shippers['people']))
                    @foreach($shippers['people'] as $user)
                      <?php $option = $user->toOption();?>
                      <option {{isset($package)&&(($package->shipper_is <= 1)||($package->shipper_is==null))&&($package->consigner_user == $user->id) ? 'selected' : ''}} item="{{$user->toInnerJson()}}" value="{{$option['id']}}">{{$user->code.' '.ucwords($user->name).' '.ucwords($user->last_name)}}</option>
                    @endforeach
                  @endif
                  @if(isset($shippers['transporters']))
                    @foreach($shippers['transporters'] as $transporter)
                      <option {{isset($package)&&($package->shipper_is == 3)&&($package->transporter == $transporter->id) ? 'selected' : ''}} value="{{$transporter->id}}" item="{{$transporter}}">{{$transporter->code.' '.strtoupper($transporter->name)}}</option>
                    @endforeach
                  @endif
                  @if(isset($shippers['company']))
                    @foreach($shippers['company'] as $company)
                      <option {{isset($package)&&($package->shipper_is == 2)&&($package->company == $company->id) ? 'selected' : ''}} value="{{$company->id}}" item="{{$company}}">{{$company->code.' '.strtoupper($company->name)}}</option>
                    @endforeach
                  @endif
                  </select>
                 </div>
                </div>

                <div class="form-group row @include('errors.field-class', ['field' => 'name'])" id="clientName" >
                  <label class="col-lg-3 control-label" id="labelName" >{{trans('package.clientName')}}</label>
                  <div class="col-lg-9">
                    @if(!isset($package)||($package->shipper_is==1)||($package->shipper_is==null))
                    <input class="form-control" readonly="true" placeholder="{{trans('package.clientName')}}" id="cons_name" name="cons_name" type="text" maxlength="25" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['name'] : clear(Input::get('name'))}}" @include('form.readonly')>
                    @endif
                    @if(isset($package)&&($package->shipper_is==3))
                      <?php $trans = Transporters::find($package->transporter); ?>
                      <input class="form-control" readonly="true" placeholder="{{trans('package.clientName')}}" id="cons_name" name="cons_name" type="text" maxlength="25" min="5"  value="{{isset($trans) ? $trans->name : clear(Input::get('name'))}}" @include('form.readonly')>
                    @endif
                    @if(isset($package)&&($package->shipper_is==2))
                      <?php $compa = Company::find($package->company); ?>
                      <input class="form-control" readonly="true" placeholder="{{trans('package.clientName')}}" id="cons_name" name="cons_name" type="text" maxlength="25" min="5"  value="{{isset($compa) ? $compa->name : clear(Input::get('name'))}}" @include('form.readonly')>
                    @endif
                      @include('errors.field', ['field' => 'name'])
                  </div>
                </div>

                @if(!isset($package)||($package->shipper_is < 2 ))
                    <!---->
                    <div class="form-group row @include('errors.field-class', ['field' => 'name'])" id="clientLastName" >
                      <label class="col-lg-3 control-label" id="labelName" >{{trans('package.clientLastName')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" readonly="true" placeholder="{{trans('package.clientLastName')}}" id="cons_lastname" name="cons_lastname" type="text" maxlength="25" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['last_name'] : clear(Input::get('name'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'name'])
                      </div>
                    </div>
                @endif

                    <!-- -->
                    <div id="dni_con" class="form-group row @include('errors.field-class', ['field' => 'dni'])">
                      <label class="col-lg-3 control-label">{{trans('messages.dni')}} </label>
                      <div class="col-lg-9">
                        @if(!isset($package)||($package->shipper_is==1)||($package->shipper_is==null))
                          <input class="form-control" placeholder="{{trans('messages.dni')}}" name="cons_dni" id="cons_dni" type="text"  maxlength="100" min="5" readonly="true" required="true" value="{{isset($package->consigner_user) ? $package->getToConsigneUser['dni'] : Input::get('dni')}}" @include('form.readonly')>
                        @endif
                        @if(isset($package)&&($package->shipper_is==3))
                          <?php $trans = Transporters::find($package->transporter); ?>
                          <input class="form-control" placeholder="{{trans('messages.dni')}}" name="cons_dni" id="cons_dni" type="text"  maxlength="100" min="5" readonly="true" required="true" value="{{isset($trans) ? $trans->identification : Input::get('dni')}}" @include('form.readonly')>
                        @endif
                        @if(isset($package)&&($package->shipper_is==2))
                          <?php $compa = Company::find($package->company); ?>
                          <input class="form-control" placeholder="{{trans('messages.dni')}}" name="cons_dni" id="cons_dni" type="text"  maxlength="100" min="5" readonly="true" required="true" value="{{isset($compa) ? $compa->ruc : Input::get('dni')}}" @include('form.readonly')>
                        @endif
                        @include('errors.field', ['field' => 'dni'])
                      </div>
                    </div>

                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'phone'])" id="clientPhone" >
                      <label class="col-lg-3 control-label" id="labelPhone" >{{trans('package.clientPhone')}}</label>
                      <div class="col-lg-9">
                        @if(!isset($package)||($package->shipper_is==1)||($package->shipper_is==null))
                          <input class="form-control" readonly="true" placeholder="{{trans('package.clientPhone')}}" id="cons_phone" name="cons_phone" type="text" maxlength="25" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['local_phone']: clear(Input::get('phone'))}}" @include('form.readonly')>
                        @endif
                        @if(isset($package)&&($package->shipper_is==3))
                          <?php $trans = Transporters::find($package->transporter); ?>
                          <input class="form-control" readonly="true" placeholder="{{trans('package.clientPhone')}}" id="cons_phone" name="cons_phone" type="text" maxlength="25" min="5"  value="{{isset($trans) ? $trans->phone: clear(Input::get('phone'))}}" @include('form.readonly')>
                        @endif
                        @if(isset($package)&&($package->shipper_is==2))
                          <?php $compa = Company::find($package->company); ?>
                          <input class="form-control" readonly="true" placeholder="{{trans('package.clientPhone')}}" id="cons_phone" name="cons_phone" type="text" maxlength="25" min="5"  value="{{isset($compa) ? $compa->phone_01: clear(Input::get('phone'))}}" @include('form.readonly')>
                        @endif
                          @include('errors.field', ['field' => 'phone'])
                      </div>
                    </div>

                    <!---->
                    <div class="form-group row @include('errors.field-class', ['field' => 'phone'])" id="clientPhone" >
                      <label class="col-lg-3 control-label" id="labelPhone" >{{trans('package.cell')}}</label>
                      <div class="col-lg-9">
                        @if(!isset($package)||($package->shipper_is==1)||($package->shipper_is==null))
                          <input class="form-control" readonly="true" placeholder="{{trans('package.cell')}}" id="cons_cell" name="cons_cell" type="text" maxlength="25" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['celular']: clear(Input::get('phone'))}}" @include('form.readonly')>
                        @endif
                        @if(isset($package)&&($package->shipper_is==3))
                          <?php $trans = Transporters::find($package->transporter); ?>
                          <input class="form-control" readonly="true" placeholder="{{trans('package.cell')}}" id="cons_cell" name="cons_cell" type="text" maxlength="25" min="5"  value="{{isset($trans) ? $trans->fax: clear(Input::get('phone'))}}" @include('form.readonly')>
                        @endif
                        @if(isset($package)&&($package->shipper_is==2))
                          <?php $compa = Company::find($package->company); ?>
                          <input class="form-control" readonly="true" placeholder="{{trans('package.cell')}}" id="cons_cell" name="cons_cell" type="text" maxlength="25" min="5"  value="{{isset($compa) ? $compa->phone_02: clear(Input::get('phone'))}}" @include('form.readonly')>
                        @endif
                          @include('errors.field', ['field' => 'phone'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'email'])" id="clientEmail" >
                      <label class="col-lg-3 control-label" id="labelEmail" >{{trans('package.clientEmail')}}</label>
                      <div class="col-lg-9">
                        @if(!isset($package)||($package->shipper_is==1)||($package->shipper_is==null))
                          <input class="form-control" readonly="true" placeholder="{{trans('package.clientEmail')}}" id="cons_email" name="cons_email" type="text" maxlength="50" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['email'] : clear(Input::get('email'))}}"@include('form.readonly')>
                        @endif
                        @if(isset($package)&&($package->shipper_is==3))
                          <?php $trans = Transporters::find($package->transporter); ?>
                          <input class="form-control" readonly="true" placeholder="{{trans('package.clientEmail')}}" id="cons_email" name="cons_email" type="text" maxlength="50" min="5"  value="{{isset($trans) ? $trans->email : clear(Input::get('email'))}}"@include('form.readonly')>
                        @endif
                        @if(isset($package)&&($package->shipper_is==2))
                          <?php $compa = Company::find($package->company); ?>
                          <input class="form-control" readonly="true" placeholder="{{trans('package.clientEmail')}}" id="cons_email" name="cons_email" type="text" maxlength="50" min="5"  value="{{isset($compa) ? $compa->email_01 : clear(Input::get('email'))}}"@include('form.readonly')>
                        @endif
                          @include('errors.field', ['field' => 'email'])
                      </div>
                    </div>

              @if(!isset($package)||($package->shipper_is==1)||($package->shipper_is==null))
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientZip" >
                      <label class="col-lg-3 control-label" id="labelDirection" style="line-height: 14px;" >{{trans('package.zip')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" readonly="true" placeholder="{{trans('Zip code')}}" id="cons_zipcode" name="cons_zipcode" type="text" maxlength="250" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['postal_code'] : clear(Input::get('cons_zipcode'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'direction'])
                      </div>
                    </div>

                       <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientCountry" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.country')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" readonly="true" placeholder="{{trans('package.country')}}" id="cons_country" name="cons_country" type="text" maxlength="250" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['country'] : clear(Input::get('cons_country'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'direction'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientRegion" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.region')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" readonly="true" placeholder="{{trans('package.region')}}" id="cons_region" name="cons_region" type="text" maxlength="250" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['region'] : clear(Input::get('cons_region'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'direction'])
                      </div>
                    </div>

                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientCity" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.city')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" readonly="true" placeholder="{{trans('package.city')}}" id="cons_city" name="cons_city" type="text" maxlength="250" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['city'] : clear(Input::get('cons_region'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'direction'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.clientDirection')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control"  readonly="true" placeholder="{{trans('package.clientDirection')}}" id="cons_direction" name="cons_direction" type="text" maxlength="250" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['address'] : clear(Input::get('direction'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'direction'])
                      </div>
                    </div>
                @endif
              </div>


              <div class="col-md-6">
                <div class="breadcrumbpack">
                    <span>{{trans('package.destinationInfo')}}</span>
                </div>
                <!--<div class="form-group row @include('errors.field-class', ['field' => 'finalDestinationUser'])" id="destination" style="display:block;"}}>
                  <label class="col-lg-3 control-label">{{trans('package.destination')}}</label>
                  <div class="col-lg-9">
                  <select style="width:100%;" class="form-control" id="finalDestinationUser" name="finalDestinationUser"  @include('form.readonly') >
                  <option value="">{{trans('package.chooseClient')}}</option>
                  <option value="addud">{{trans('package.adduser')}}</option>
                    @foreach ($users as $user)
                      <?php //$option = $user->toOption();?>
                      <option {{(isset($package->to_user) ? $package->to_user : Input::get('finalDestinationUser')) == $option['id'] ? 'selected' : ''}} item="{{$user->toInnerJson()}}" value="{{$option['id']}}">{{$user->code.' '.ucwords($user->name).' '.ucwords($user->last_name)}}</option>
                    @endforeach
                  </select>
                 </div>
               </div>-->

                 <input type="hidden" id="consig_is" name="consig_is" value="{{isset($package->consig_is) ? $package->consig_is : 0}}">
                 <div class="form-group row @include('errors.field-class', ['field' => 'finalDestinationUser'])" id="destination" style="display:block;"}}>
                   <label class="col-lg-3 control-label">{{trans('package.destination')}}</label>
                   <div class="col-lg-9">
                     <select style="width:100%;" class="form-control" id="finalDestinationUser" name="finalDestinationUser"  @include('form.readonly') >
                       <option value="">{{trans('package.chooseClient')}}</option>
                       <option value="addud" item='0'>{{trans('package.adduser')}}</option>
                   @if(isset($shippers['people']))
                     @foreach($shippers['people'] as $user)
                       <?php $option = $user->toOption();?>
                       <option {{isset($package)&&(($package->consig_is <= 1)||($package->consig_is==null))&&($package->to_user == $user->id) ? 'selected' : ''}} item="{{$user->toInnerJson()}}" value="{{$option['id']}}">{{$user->code.' '.ucwords($user->name).' '.ucwords($user->last_name)}}</option>
                     @endforeach
                   @endif
                   @if(isset($shippers['transporters']))
                     @foreach($shippers['transporters'] as $transporter)
                       <option {{isset($package)&&($package->consig_is == 3)&&($package->transporter_cons == $transporter->id) ? 'selected' : ''}} value="{{$transporter->id}}" item="{{$transporter}}">{{$transporter->code.' '.strtoupper($transporter->name)}}</option>
                     @endforeach
                   @endif
                   @if(isset($shippers['company']))
                     @foreach($shippers['company'] as $company)
                       <option {{isset($package)&&($package->consig_is == 2)&&($package->company_cons == $company->id) ? 'selected' : ''}} value="{{$company->id}}" item="{{$company}}">{{$company->code.' '.strtoupper($company->name)}}</option>
                     @endforeach
                   @endif
                   </select>
                  </div>
                 </div>

                <div class="form-group row @include('errors.field-class', ['field' => 'name'])" id="consigName" >
                  <label class="col-lg-3 control-label" id="labelName" >{{trans('package.clientName')}}</label>
                  <div class="col-lg-9">
                    @if(!isset($package)||($package->consig_is==1)||($package->shipper_is==null))
                    <input class="form-control" readonly="true" placeholder="{{trans('package.clientName')}}" id="destin_name" name="destin_name" type="text" maxlength="25" min="5"  value="{{isset($package->to_user) ? $package->getToUser['name'] : clear(Input::get('name'))}}" @include('form.readonly')>
                    @endif
                    @if(isset($package)&&($package->consig_is==3))
                      <?php $trans = Transporters::find($package->transporter_cons); ?>
                      <input class="form-control" readonly="true" placeholder="{{trans('package.clientName')}}" id="destin_name" name="destin_name" type="text" maxlength="25" min="5"  value="{{isset($trans) ? $trans->name : clear(Input::get('name'))}}" @include('form.readonly')>
                    @endif
                    @if(isset($package)&&($package->consig_is==2))
                      <?php $compa = Company::find($package->company_cons); ?>
                      <input class="form-control" readonly="true" placeholder="{{trans('package.clientName')}}" id="destin_name" name="destin_name" type="text" maxlength="25" min="5"  value="{{isset($compa) ? $compa->name : clear(Input::get('name'))}}" @include('form.readonly')>
                    @endif
                      @include('errors.field', ['field' => 'name'])
                  </div>
                </div>
                @if(!isset($package)||($package->consig_is < 2 ))
                   <!---->
                  <div class="form-group row @include('errors.field-class', ['field' => 'name'])" id="consigLastName" >
                    <label class="col-lg-3 control-label" id="labelName" >{{trans('package.clientLastName')}}</label>
                    <div class="col-lg-9">
                      <input class="form-control" readonly="true" placeholder="{{trans('package.clientLastName')}}" id="destin_lastname" name="destin_lastname" type="text" maxlength="25" min="5"  value="{{isset($package->to_user) ? $package->getToUser['last_name'] : clear(Input::get('name'))}}" @include('form.readonly')>
                        @include('errors.field', ['field' => 'name'])
                    </div>
                  </div>
                @else
                    <!---->
                   <div style="display:none;" class="form-group row @include('errors.field-class', ['field' => 'name'])" id="consigLastName" >
                     <label class="col-lg-3 control-label" id="labelName" >{{trans('package.clientLastName')}}</label>
                     <div class="col-lg-9">
                       <input class="form-control" readonly="true" placeholder="{{trans('package.clientLastName')}}" id="destin_lastname" name="destin_lastname" type="text" maxlength="25" min="5"  value="{{isset($package->to_user) ? $package->getToUser['last_name'] : clear(Input::get('name'))}}" @include('form.readonly')>
                         @include('errors.field', ['field' => 'name'])
                     </div>
                   </div>
                @endif
                 <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'dni'])">
                  <label class="col-lg-3 control-label">{{trans('messages.dni')}} </label>
                  <div class="col-lg-9">
                    @if(!isset($package)||($package->consig_is==1)||($package->shipper_is==null))
                      <input class="form-control" placeholder="{{trans('messages.dni')}}" name="destin_dni" id="destin_dni" type="text" readonly="true" maxlength="100" min="5" required="true" value="{{isset($package->to_user) ? $package->getToUser['dni'] : Input::get('dni')}}" @include('form.readonly')>
                    @endif
                    @if(isset($package)&&($package->consig_is==3))
                      <?php $trans = Transporters::find($package->transporter_cons); ?>
                      <input class="form-control" placeholder="{{trans('messages.dni')}}" name="destin_dni" id="destin_dni" type="text"  maxlength="100" min="5" readonly="true" required="true" value="{{isset($trans) ? $trans->identification : Input::get('dni')}}" @include('form.readonly')>
                    @endif
                    @if(isset($package)&&($package->consig_is==2))
                      <?php $compa = Company::find($package->company_cons); ?>
                      <input class="form-control" placeholder="{{trans('messages.dni')}}" name="destin_dni" id="destin_dni" type="text"  maxlength="100" min="5" readonly="true" required="true" value="{{isset($compa) ? $compa->ruc : Input::get('dni')}}" @include('form.readonly')>
                    @endif
                    @include('errors.field', ['field' => 'dni'])
                  </div>
                </div>
                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'phone'])" id="consigPhone" >
                  <label class="col-lg-3 control-label" id="labelPhone" >{{trans('package.clientPhone')}}</label>
                  <div class="col-lg-9">
                    @if(!isset($package)||($package->consig_is==1)||($package->shipper_is==null))
                      <input class="form-control" placeholder="{{trans('package.clientPhone')}}" id="destin_phone" name="destin_phone" type="text" readonly="true" maxlength="25" min="5"  value="{{isset($package->to_user) ? $package->getToUser['local_phone'] : clear(Input::get('phone'))}}" @include('form.readonly')>
                    @endif
                    @if(isset($package)&&($package->consig_is==3))
                      <?php $trans = Transporters::find($package->transporter_cons); ?>
                      <input class="form-control" readonly="true" placeholder="{{trans('package.clientPhone')}}" id="destin_phone" name="destin_phone" type="text" maxlength="25" min="5"  value="{{isset($trans) ? $trans->phone: clear(Input::get('phone'))}}" @include('form.readonly')>
                    @endif
                    @if(isset($package)&&($package->consig_is==2))
                      <?php $compa = Company::find($package->company_cons); ?>
                      <input class="form-control" readonly="true" placeholder="{{trans('package.clientPhone')}}" id="destin_phone" name="destin_phone" type="text" maxlength="25" min="5"  value="{{isset($compa) ? $compa->phone_01: clear(Input::get('phone'))}}" @include('form.readonly')>
                    @endif
                      @include('errors.field', ['field' => 'phone'])
                  </div>
                </div>

                <!---->
                <div class="form-group row @include('errors.field-class', ['field' => 'phone'])" id="consigPhone" >
                  <label class="col-lg-3 control-label" id="labelPhone" >{{trans('package.cell')}}</label>
                  <div class="col-lg-9">
                    @if(!isset($package)||($package->consig_is==1)||($package->shipper_is==null))
                      <input class="form-control" readonly="true"_cons placeholder="{{trans('package.cell')}}" id="destin_cell" name="destin_cell" type="text" maxlength="25" min="5"  value="{{isset($package->to_user) ? $package->getToUser['celular']: clear(Input::get('phone'))}}" @include('form.readonly')>
                    @endif
                    @if(isset($package)&&($package->consig_is==3))
                      <?php $trans = Transporters::find($package->transporter_cons); ?>
                      <input class="form-control" readonly="true" placeholder="{{trans('package.cell')}}" id="destin_cell" name="destin_cell" type="text" maxlength="25" min="5"  value="{{isset($trans) ? $trans->fax: clear(Input::get('phone'))}}" @include('form.readonly')>
                    @endif
                    @if(isset($package)&&($package->consig_is==2))
                      <?php $compa = Company::find($package->company_cons); ?>
                      <input class="form-control" readonly="true" placeholder="{{trans('package.cell')}}" id="destin_cell" name="destin_cell" type="text" maxlength="25" min="5"  value="{{isset($compa) ? $compa->phone_02: clear(Input::get('phone'))}}" @include('form.readonly')>
                    @endif
                      @include('errors.field', ['field' => 'phone'])
                  </div>
                </div>
                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'email'])" id="consigEmail" >
                  <label class="col-lg-3 control-label" id="labelEmail" >{{trans('package.notify_mail')}}</label>
                  <div id="email_consigner" class="col-lg-9">
                    <!-- @if(!isset($package->consig_is)||($package->consig_is==1)||($package->shipper_is==null))
                      <input class="form-control" readonly="true" placeholder="{{trans('package.clientEmail')}}" id="destin_email" name="destin_email" type="text" maxlength="50" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['email'] : clear(Input::get('email'))}}"@include('form.readonly')>
                    @endif
                    @if(isset($package)&&($package->consig_is==3))
                      <?php $trans = Transporters::find($package->transporter_cons); ?>
                      <input class="form-control" readonly="true" placeholder="{{trans('package.clientEmail')}}" id="destin_email" name="destin_email" type="text" maxlength="50" min="5"  value="{{isset($trans) ? $trans->email : clear(Input::get('email'))}}"@include('form.readonly')>
                    @endif
                    @if(isset($package)&&($package->consig_is==2))
                      <?php $compa = Company::find($package->company_cons); ?>
                      <input class="form-control" readonly="true" placeholder="{{trans('package.clientEmail')}}" id="destin_email" name="destin_email" type="text" maxlength="50" min="5"  value="{{isset($compa) ? $compa->email_01 : clear(Input::get('email'))}}"@include('form.readonly')>
                    @endif -->
                    <select class="form-control" id="destin_email" name="destin_email">
                      <option value="">Email a notificar</option>
                      @if(isset($package->to_user))
                          @if(isset($package->getToUser['alt_email'])&&($package->getToUser['alt_email']!='')&&($package->getToUser['alt_email']!=null))
                            <option value="1">{{$package->getToUser['alt_email']}}</option>
                          @endif
                          @if(isset($package->getToUser['email'])&&($package->getToUser['email']!='')&&($package->getToUser['email']!=null))
                            <option value="2">{{$package->getToUser['email']}}</option>
                          @endif
                            <option selected value='3'>No notificar</option>
                      @endif
                    </select>
                      @include('errors.field', ['field' => 'destin_email'])
                  </div>
                </div>
                <!-- -->
                @if(!isset($package)||($package->consig_is==1)||($package->consig_is==null))
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="consig_zip" >
                      <label class="col-lg-3 control-label" id="labelDirection" style="line-height: 14px;" >{{trans('package.zip')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" placeholder="{{trans('package.zip')}}" id="destin_zipcode" name="destin_zipcode" type="text" readonly="true" maxlength="250" min="5"  value="{{isset($package->to_user) ? $package->getToUser['postal_code'] : clear(Input::get('destin_zipcode'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'destin_zipcode'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="consig_country" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.country')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" placeholder="{{trans('package.country')}}" id="destin_country" name="destin_country" type="text" readonly="true" maxlength="250" min="5"  value="{{isset($package->to_user) ? $package->getToUser['country'] : clear(Input::get('destin_country'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'destin_country'])
                      </div>
                    </div>
                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="consig_region" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.region')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" readonly="true" placeholder="{{trans('package.region')}}" id="destin_region" name="destin_region" type="text" maxlength="250" min="5"  value="{{isset($package->to_user) ? $package->getToUser['region'] : clear(Input::get('destin_region'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'destin_region'])
                      </div>
                    </div>

                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="consig_city" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.city')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" readonly="true" placeholder="{{trans('package.city')}}" id="destin_city" name="destin_city" type="text" maxlength="250" min="5"  value="{{isset($package->to_user) ? $package->getToUser['city'] : clear(Input::get('destin_city'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'destin_city'])
                      </div>
                    </div>

                    <!-- -->
                    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="consig_direction" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.clientDirection')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" readonly="true" placeholder="{{trans('package.clientDirection')}}" id="destin_direction" name="destin_direction" type="text" maxlength="250" min="5"  value="{{isset($package->to_user) ? $package->getToUser['address'] : clear(Input::get('destin_direction'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'destin_direction'])
                      </div>
                    </div>
                @else
                    <div style="display:none;" class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="consig_zip" >
                      <label class="col-lg-3 control-label" id="labelDirection" style="line-height: 14px;" >{{trans('package.zip')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" placeholder="{{trans('package.zip')}}" id="destin_zipcode" name="destin_zipcode" type="text" readonly="true" maxlength="250" min="5"  value="{{isset($package->to_user) ? $package->getToUser['postal_code'] : clear(Input::get('destin_zipcode'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'destin_zipcode'])
                      </div>
                    </div>
                    <!-- -->
                    <div style="display:none;" class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="consig_country" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.country')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" placeholder="{{trans('package.country')}}" id="destin_country" name="destin_country" type="text" readonly="true" maxlength="250" min="5"  value="{{isset($package->to_user) ? $package->getToUser['country'] : clear(Input::get('destin_country'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'destin_country'])
                      </div>
                    </div>
                    <!-- -->
                    <div style="display:none;" class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="consig_region" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.region')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" readonly="true" placeholder="{{trans('package.region')}}" id="destin_region" name="destin_region" type="text" maxlength="250" min="5"  value="{{isset($package->to_user) ? $package->getToUser['region'] : clear(Input::get('destin_region'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'destin_region'])
                      </div>
                    </div>

                    <!-- -->
                    <div style="display:none;" class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="consig_city" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.city')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" readonly="true" placeholder="{{trans('package.city')}}" id="destin_city" name="destin_city" type="text" maxlength="250" min="5"  value="{{isset($package->to_user) ? $package->getToUser['city'] : clear(Input::get('destin_city'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'destin_city'])
                      </div>
                    </div>

                    <!-- -->
                    <div style="display:none;" class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="consig_direction" >
                      <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.clientDirection')}}</label>
                      <div class="col-lg-9">
                        <input class="form-control" readonly="true" placeholder="{{trans('package.clientDirection')}}" id="destin_direction" name="destin_direction" type="text" maxlength="250" min="5"  value="{{isset($package->to_user) ? $package->getToUser['address'] : clear(Input::get('destin_direction'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'destin_direction'])
                      </div>
                    </div>
                @endif
              </div>

      </div>
    </div>

      </div>
      <div id="ics_tab_menu1" class="tab-pane fade">

      <!--<div class="form-group row @include('errors.field-class', ['field' => 'courier'])" id="courier" style="display:yes" >
        <label class="col-lg-3 control-label" id="courierLabel" >{{trans('package.couriers')}}</label>
        <div class="col-lg-9">
        <select style="width:100%;" class="form-control" id="courier" name="courier" @include('form.readonly')>
          @foreach ($couriers as $courier)
            <option {{(isset($package->from_courier) ? $package->from_courier : Input::get('from_courier')) == $courier->id ? 'selected' : ''}} value="{{$courier->id}}">{{$courier->name}}</option>
          @endforeach
        </select>
        </div>
      </div>
-->
      <div class="panel panel-default" >

           <div class="panel-heading text-muted">
            <span><i class="fa fa-cubes" aria-hidden="true"></i></span>
            <span class="pull-right">
              <span class="text-muted">
                <a role="button" onclick="addpackage()" class="btn btn-primary btn-xs">{{trans('package.addpackage')}} <i class="fa fa-plus" aria-hidden="true"></i> </a>
              </span>
            </span>
           </div>
             <div class="col-md-12">
               <div class="breadcrumb" >
                     <div class="dropdown" >
                       <a class="dropdown-toggle" type="button" data-toggle="dropdown" id="ics_link_dropdown">
                         <span class="text-muted" data-toggle="tooltip" title="{{trans('shipment.type')}}">
                           <i class="fa fa-eye" aria-hidden="true"></i>
                           <span class="" id="ics_load">{{(isset($package) && $package->unidad == 1) ? trans('package.int_medition') : trans('package.imp_medition')}}</span>
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

      <!--  <div class="row" style="padding: 15px;">
           <button type="button" class="btn btn-primary" style="float: left;margin-left: 15px;" onclick="addpackage()"><i class="fa fa-plus-square" aria-hidden="true"></i> Agregar Paquetes</button>
        </div>-->

        <div class="row" style="padding: 25px 30px 0 30px">
          <ul class="nav nav-tabs" id="listpack">
            <li class="paq active" id="lipaquete1" ><a data-toggle="tab" href="#paquete1"><i class="fa fa-circle-o-notch" aria-hidden="true"></i> PK 1</a></li>
          </ul>


        <div class="tab-content" id="contentpack">
        <div id="paquete1" class="tab-pane fade in active" style="padding:20px">
           <div class="row" id="divTracking" style="">
            <div class="col-md-8">
              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'description'])"  id="divlarge" >
                <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.description')}}</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" placeholder="{{trans('package.description')}}" id="description1" name="description1" type="float" min="1"  value="{{isset($detailspack[0]) ? $detailspack[0]->description : clear(Input::get('description'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'description'])
                </div>
              </div>

              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'pieces'])"  id="divlarge" >
                <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.pieces')}}</label>
                <div class="col-lg-10">
                  <input type="number" class="form-control" placeholder="{{trans('package.pieces')}}" id="pieces1" name="pieces1" type="int" maxlength="10" min="1"  value="{{isset($detailspack[0]) ? $detailspack[0]->pieces : clear(Input::get('pieces'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'pieces'])
                </div>
              </div>

              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'value'])"  id="divlarge" >
                <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.value')}}</label>
                <div class="col-lg-10">
                  <input type="number" class="form-control" placeholder="{{trans('package.value')}} ($)" id="valued1" name="valued1" type="int" maxlength="10" min="1" onkeyup="resultvalue()"  value="{{isset($detailspack[0]) ? $detailspack[0]->value : clear(Input::get('value'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'value'])
                </div>
              </div>

              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'serviceOrder'])"  id="divlarge" >
                  <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.prelert')}}</label>
                  <div id="contSelect" style="padding-bottom:5px;" class="col-lg-10">
                        <select onclick="javascript:AddPrealerts(1)" class="form-control" style="width:100%;" name="serviceOrder1" id="serviceOrder1">
                          <option value="">{{trans('package.chooseSelect')}}</option>
                        </select>
                      @include('errors.field', ['field' => 'serviceOrder1'])
                 </div>
               </div>

               <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'currier'])"  id="divlarge" >
                   <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.currier')}}</label>
                   <div class="col-lg-10">
                     <select style="width:100%;" class="form-control" id="currier1" name="currier1" @include('form.readonly')>
                        <option value="1">{{trans('package.notcurrier')}}</option>
                       @foreach ($couriers as $courier)
                         <option {{(isset($package->courier) ? mb_strtoupper($package->courier) : Input::get('courier')) == $courier->id ? 'selected' : ''}} value="{{mb_strtoupper($courier->id)}}">{{mb_strtoupper($courier->name)}}</option>
                       @endforeach
                     </select>
                       @include('errors.field', ['field' => 'currier'])
                  </div>
                </div>
            </div>

            <div class="col-md-4">
              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'large'])"  id="divlarge" >
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.large')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.large')}}" id="large1" name="large1" onkeyup="pesovol()" type="float" maxlength="10" min="1"  value="{{isset($detailspack[0]) ? $detailspack[0]->large : clear(Input::get('large'))}}" @include('form.readonly')>
                  <span id="large" >{{(isset($package) && $package->unidad == 1) ? 'cm' : 'in'}}</span>
                  @include('errors.field', ['field' => 'large'])
                </div>
              </div>

              <div class="dimensmedidas  @include('errors.field-class', ['field' => 'width'])" onkeyup="pesovol()" id="divwidth">
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.width')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.width')}}" id="width1" name="width1" type="float" maxlength="10" min="1"  value="{{isset($detailspack[0]) ? $detailspack[0]->width : clear(Input::get('width'))}}" @include('form.readonly')>
                  <span id="width">{{(isset($package) && $package->unidad == 1) ? 'cm' : 'in'}}</span>
                  @include('errors.field', ['field' => 'width'])
               </div>
              </div>

              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.height')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.height')}}" id="height1" onkeyup="pesovol()" name="height1" type="float" maxlength="10" min="1"  value="{{isset($detailspack[0]) ? $detailspack[0]->height : clear(Input::get('height'))}}"
                  @include('form.readonly')>
                  <span id="height">{{(isset($package) && $package->unidad == 1) ? 'cm' : 'in'}}</span>
                  @include('errors.field', ['field' => 'height'])
                </div>
              </div>

              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.volumem')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.volumem')}}" id="volumetricweightm1" name="volumetricweightm1" type="float" readonly="" maxlength="10" min="1"  value="{{isset($detailspack[0]) ? $detailspack[0]->volumetricweightm : ''}}" @include('form.readonly')>
                  <span id="volumem">{{(isset($package) && $package->unidad == 1) ? 'm3' : 'ft3'}}</span>
                  @include('errors.field', ['field' => 'volumetricweight'])
                </div>
              </div>


              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.volumea')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.volumea')}}" id="volumetricweighta1" name="volumetricweighta1" type="float" readonly="" maxlength="10" min="1"  value="{{isset($detailspack[0]) ? $detailspack[0]->volumetricweighta : ''}}" @include('form.readonly')>
                  <span id="volumea">{{(isset($package) && $package->unidad == 1) ? 'Vkg' : 'Vlb'}}</span>
                  @include('errors.field', ['field' => 'volumetricweight'])
                </div>
              </div>

              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                <label class="col-lg-3 control-label " id="typeLabel" >{{trans('package.weight')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.weight')}}" id="weight1" onkeyup="pesovol()" name="weight1" type="float" maxlength="10" min="1"  value="{{isset($detailspack[0]) ? $detailspack[0]->weight : clear(Input::get('weight'))}}" @include('form.readonly')>
                  <span id="weight">{{(isset($package) && $package->unidad == 1) ? 'kg' : 'lb'}}</span>
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

      <div id="ics_tab_menu2" class="tab-pane fade">

         <div class="panel panel-default" >
           <div class="panel-heading text-muted">
            <span><i class="fa fa-exchange" aria-hidden="true"></i></span>
            <span class="pull-right">
              <span class="text-muted">
               <!-- <a role="button" onclick="alert('in process...')" class="btn btn-primary btn-xs">{{trans('package.next')}} <i class="fa fa-chevron-right" aria-hidden="true"></i></a>-->
              </span>
            </span>
           </div>
          <div class="row" style="padding: 25px;">
            <div class="col-md-6" id="divdimens" >
              <div class="form-group row @include('errors.field-class', ['field' => 'tracking'])" >
                  <label class="col-lg-3 control-label" id="trackingLabel" >{{trans('package.tracking')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('package.tracking')}}" id="tracking" name="tracking" type="text" maxlength="25" value="{{isset($package->tracking) ? $package->tracking : clear(Input::get('tracking'))}}" @include('form.readonly',['forceReadonly' => isset($package)])>
                      @include('errors.field', ['field' => 'tracking'])
                 </div>
               </div>

              <div class="form-group row @include('errors.field-class', ['field' => 'tracking'])"  >
                <label class="col-lg-3 control-label" id="valueLabel" >{{trans('package.value')}}</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" placeholder="{{trans('package.value')}} ($)" id="value" name="value" onkeyup="taxcalculation()" type="float" readonly="true" min="1"  value="{{isset($package->value) ? number_format($package->value) : clear(Input::get('value'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'value'])
                </div>
              </div>



              <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="divdettype" >
                <label class="col-lg-3 control-label" id="typeLabel" style="    line-height: 15px;">{{trans('package.airportandport')}}</label>
                <div class="col-lg-9">
                  <select style="width:100%;" class="form-control" id="dettype" name="dettype"  @include('form.readonly')>
                    <option value="" cost="0">{{trans('package.airportandport')}}</option>
                  </select>
                  @include('errors.field', ['field' => 'type|'])
                </div>
              </div>

              <div class="form-group row @include('errors.field-class', ['field' => 'id_package'])" id="uploadinvoice" style="padding-left: 30%;display:none">
                  <input type="file" name="file" id="file" accept=".pdf, image/*" autofocus value="{{ Input::get('file') }}" >
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'id_package'])
              </div>
            </div>

            <div class="col-md-6" >

              <div class="form-group row @include('errors.field-class', ['field' => 'office'])" id="officeDiv" >
                <label class="col-lg-3 control-label" id="officeLabel" >{{trans('package.office')}}</label>
                <div class="col-lg-9">
                  <select style="width:100%;" class="form-control" id="office" name="office"  @include('form.readonly')>
                   <option value="">{{trans('package.chooseOffice')}}</option>
                   @foreach ($office as $offi)
                      <?php $option = $offi->toOption();?>
                      <option {{(isset($package->category) ? $package->category : Input::get('office')) == $option['id'] ?  'selected' : ''}} item="{{$offi->toInnerJson()}}"  value="{{$option['id']}}" >{{$option['text']}}</option>
                   @endforeach
                  </select>
                  @include('errors.field', ['field' => 'office'])
                </div>
              </div>

              <div class="form-group row @include('errors.field-class', ['field' => 'invoice'])" id="invoice" >
              <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.invoice')}}</label>
              <div class="col-lg-9">
                <select style="width:100%;" class="form-control" id="invoice" name="invoice"  @include('form.readonly')>
                  {{--se comenta el codigo php para que se inicalice el select como 'sin factura'--}}
                  <option {{--(isset($package) ? $package->invoice : 0) == 0 ? 'selected' : ''--}} value=0>{{trans('package.withOutInvoice')}}</option>
                  <option {{--(isset($package) ? $package->invoice : 1) == 1 ? 'selected' : ''--}} value=1>{{trans('package.withInvoice')}}</option>
                </select>
              </div>
              </div>

              <div class="form-group row @include('errors.field-class', ['field' => 'consolidate'])" id="consolidate" style="display:block;">
               <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.shipment')}}</label>
               <div class="col-lg-9">
                  <select style="width:100%;" class="form-control" id="shipment" name="shipment"  @include('form.readonly')>
                     <option value="">{{trans('package.notshipment')}}</option>
                     @if(isset($shipment))
                       @foreach ($shipment as $consol)
                        <option item="{{$consol}}" value="{{$consol->id}}"> {{$consol->name }}-{{$consol->description}}</option>
                        @endforeach
                      @endif
                  </select>
                  <span style="color:grey;">(En caso que Aplique)</span>
               </div>
              </div>
              <!--ADUANA-->
              <div class="form-group row @include('errors.field-class', ['field' => 'aduana'])">
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.customs')}}</label>
                <div class="col-lg-9">
                    <select style="width:100%;" class="form-control" id="aduana" name="aduana" >
                      @if((isset($package->aduana)) && ($package->aduana == 0))
                        <option value="0" selected>{{trans('package.unrequired')}}</option>
                      @else
                        <option value="0">{{trans('package.unrequired')}}</option>
                      @endif
                      @if((isset($package->aduana)) && ($package->aduana == 1))
                        <option value="1" selected>{{trans('package.require')}}</option>
                      @else
                        <option value="1">{{trans('package.require')}}</option>
                      @endif
                    </select>
                    @include('errors.field', ['field' => 'aduana'])
                </div>
              </div>
              <!--NOMBRE DE ADUANA-->
              <div id="aduana_name" style="display:none;" class="form-group row @include('errors.field-class', ['field' => 'aduana_name'])">
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('Descripcion')}}</label>
                <div class="col-lg-9">
                    <input maxlength="20" type="text" style="width:100%;"class="form-control" id="aduana_name" name="aduana_name" value="{{isset($package->description_aduana) ? $package->description_aduana : ''}}" placeholder="{{trans('Nombre y desripcion de aduana')}}"required="true" @include('form.readonly')>
                @include('errors.field', ['field' => 'aduana_name'])
                </div>
              </div>
            </div>


            <div class="col-md-12">
            <div class="@include('errors.field-class', ['field' => 'obervation'])"  id="divlarge" >
              <label class="col-lg-2 control-label" id="typeLabel" >{{trans('package.observation')}}</label>
              <div class="col-lg-10">
                <textarea type="text" class="form-control" placeholder="{{trans('package.observation')}}" id="observation" name="observation" type="text" rows="4" min="1"  value="{{isset($package->obervation) ? $package->obervation : clear(Input::get('obervation'))}}" @include('form.readonly')></textarea>
                    @include('errors.field', ['field' => 'obervation'])
              </div>
            </div>
            </div>
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

      <div id="ics_tab_menu4" class="tab-pane fade">

        <div class="panel panel-default" >
           <div class="panel-heading text-muted">
              <span><i class="fa fa-credit-card" aria-hidden="true"></i></span>
              <span class="pull-right"></span>
           </div>
        <div class="row" style="padding: 25px;">
          <div class="col-md-6">
            <div class="form-group row @include('errors.field-class', ['field' => 'type'])"  >
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.service')}}</label>
                <div class="col-lg-9">
                  <select style="width:100%;" class="form-control" id="type" name="type"  @include('form.readonly')>
                    <option value="" cost="0">{{trans('package.nottype')}}</option>
                    @foreach ($transports as $transport)
                      <?php $option = isset($transport) ? $transport->toOption(): null;?>
                      <option {{(isset($package->type) ? $package->type : Input::get('type')) == $option['id'] ? 'selected' : ''}} item="{{isset($transport) ? $transport->toInnerJson() : null}}" value="{{$option['id']}}" cost="{{$option['price']}}">{{ucwords($option['text'])}} </option>
                    @endforeach
                  </select>
                  @include('errors.field', ['field' => 'type|'])
                </div>
            </div>

             <!-- -->
            <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="idtype" >
              <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.route')}}</label>
              <div class="col-lg-9">
                <select style="width:100%;" class="form-control" id="typeservice" name="typeservice" required="true" @include('form.readonly')>
                <option value="">{{trans('package.chooseSelect')}}</option>
                  @if($routes != '')
                    @foreach ($routes as $service)
                      <option {{(isset($package->details_type) ? $package->details_type : Input::get('type')) == $service->id ? 'selected' : ''}} item="{{$service}}" cost="{{$service->price}}" value="{{$service->id}}">{{ucwords($service->name)}} {{$service->price}}($)</option>
                    @endforeach
                  @endif
                </select>
                @include('errors.field', ['field' => 'type|'])
              </div>
            </div>
            <!---->

            <div class="form-group row @include('errors.field-class', ['field' => 'insurance'])" id="consolidate" style="display:block;">
              <label class="col-lg-3 control-label" id="servicelabel" style="line-height: 16px;" >{{trans('package.insurance')}}</label>
              <div class="col-lg-9">
                <input class="form-control" placeholder="{{trans('package.insurance')}}" id="insurance" onkeyup="calcinsurance()" name="insurance" type="text" maxlength="5"   value="{{isset($insurance) ? $insurance->value_oring : clear(Input::get('insurance'))}}">
                  @include('errors.field', ['field' => 'tracking'])
               @include('errors.field', ['field' => 'insurance'])
              </div>
            </div>

            <div class="form-group row @include('errors.field-class', ['field' => 'taxval'])" style="display:block;">
                <label class="col-lg-3 control-label" id="servicelabel" >{{trans('package.taxx')}}</label>
                <div class="col-lg-9">
                  <input class="form-control" placeholder="{{trans('package.taxx')}}" id="taxval" onkeyup="calctax()" name="taxval" type="text" maxlength="5"  value="{{isset($taxxes->value_oring) ? $taxxes->value_oring : '' }}">
                  @include('errors.field', ['field' => 'taxval'])
                </div>
            </div>

            <div class="form-group row @include('errors.field-class', ['field' => 'category'])" id="categoryDiv" >
              <label class="col-lg-3 control-label" id="categoryLabel" >{{trans('package.category')}}</label>
              <div class="col-lg-9">
                <select style="width:100%;" class="form-control" id="category" name="category"  @include('form.readonly')>
                  <option value="" cost="0" porcent="0">{{trans('package.chooseCategory')}}</option>
                  @if(isset($category))
                    @foreach ($category as $cat)
                      <?php $option = $cat->toOption();?>
                      <option {{(isset($package->category) ? $package->category : Input::get('category')) == $option['id'] ? 'selected' : ''}} item="{{$cat->toInnerJson()}}"  porcent="{{$option['percent']}}" value="{{$option['id']}}" cost="{{$option['percent']}}">{{ucfirst($option['text'])}} {{$option['percent']}}(%)</option>
                    @endforeach
                  @endif
                </select>
                @include('errors.field', ['field' => 'category'])
              </div>
            </div>

            <div class="form-group row @include('errors.field-class', ['field' => 'addcharge'])" id="consolidate" style="display:block;">
              <label class="col-lg-3 control-label" id="service" style="line-height: 16px;" >{{trans('package.addcharge')}}</label>
              <div class="col-lg-9">
                <select style="width:100%;" class="form-control" id="addcharge" name="addcharge"  @include('form.readonly')>
                <option value="" cost="0">{{trans('package.notaddcharge')}}</option>
                @if(isset($addcharges))
                  @foreach ($addcharges as $addcharge)
                    <option {{(isset($detailspack[0]->addcharge) ? $detailspack[0]->addcharge : Input::get('addcharge')) == $addcharge->id ? 'selected' : ''}} cost="{{$addcharge->value}}" value="{{$addcharge->name}}">{{$addcharge->name.' '.$addcharge->value}}($)</option>
                  @endforeach
                @endif
                </select>
                 @include('errors.field', ['field' => 'addcharge'])
               <span style="color:grey;">(En caso que Aplique)</span>
              </div>
            </div>


            <div class="form-group row @include('errors.field-class', ['field' => 'promotion'])" id="promotion" style="display:block;">
              <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.promotion')}}</label>
              <div class="col-lg-9">
               <select style="width:100%;" class="form-control" id="promotion" name="promotion"  @include('form.readonly')>
               <option value="" reduction="0">{{trans('package.notpromotion')}}</option>
                  @if(isset($promotions))
                    @foreach ($promotions as $promotion)
                      <?php $option = $promotion->toOption();?>
                      <option {{(isset($idaddpromotion) ? $idaddpromotion->id_complemento : Input::get('type')) == $option['id'] ? 'selected' : ''}} item="" value="{{$option['id']}}" reduction="{{$option['reduction']}}">{{$option['text']}}</option>
                    @endforeach
                  @endif
                </select>
                <span style="color:grey;">(En caso que Aplique)</span>
              </div>
            </div>

          </div>

          <div class="col-md-6">
          <div class="form-group row @include('errors.field-class', ['field' => 'tax'])" id="taxdiv" >
              <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.volume')}}</label>
              <div class="col-lg-9">
                <?php
                  $totalvolm = 0;
                  $totalvola = 0;
                  if (isset($detailspack)) {
                    foreach ($detailspack as $key => $pack) {
                      $totalvolm += $pack->volumetricweightm;
                      $totalvola += $pack->volumetricweighta;
                    }
                  }
                 ?>
                @if((isset($package))&&($package->type == 1))
                  <input class="form-control"  placeholder="{{trans('package.volume')}}" id="volre" name="volre" readonly  type="float" maxlength="10" min="1" required="true" value= "{{isset($detailspack) ? number_format($totalvolm,2,',','.') : 'no'}} ft3"
                  @include('form.readonly')>
                @endif
                @if((isset($package))&&($package->type == 2))
                  <input class="form-control"  placeholder="{{trans('package.volume')}}" id="volre" name="volre" readonly  type="float" maxlength="10" min="1" required="true" value= "{{isset($detailspack) ? number_format($totalvola,2,',','.') : 'no'}} Vlb"
                  @include('form.readonly')>
                @endif
                @if(!(isset($package)))
                  <input class="form-control"  placeholder="{{trans('package.volume')}}" id="volre" name="volre" readonly  type="float" maxlength="10" min="1" required="true" value= ""
                  @include('form.readonly')>
                @endif
                @include('errors.field', ['field' => 'value'])
              </div>

          </div>

         <!--Costo total por el servicio -->
          <div class="form-group row @include('errors.field-class', ['field' => 'costservice'])" id="divsubtotal" >
            <label class="col-lg-3 control-label" id="invoiceLabel" style="line-height: 15px;" >{{trans('package.costservice')}}</label>
            <div class="col-lg-9">
              <input class="form-control"  placeholder="{{trans('package.costservice')}}" id="costservice" name="costservice" type="float" maxlength="10" min="1" required="true" readonly value="{{isset($idtytransport) ? $idtytransport->value_oring : clear(Input::get('value'))}} $" @include('form.readonly')>
              @include('errors.field', ['field' => 'subtotal'])
            </div>
          </div>

          <!--Costo total del seguro -->
          <div class="form-group row @include('errors.field-class', ['field' => 'insurance'])" id="consolidate" style="display:block;">
              <label class="col-lg-3 control-label" id="servicelabel" style="line-height: 16px;" >{{trans('package.toinsurance')}}</label>
              <div class="col-lg-9">
                <input class="form-control" placeholder="{{trans('package.toinsurance')}}" id="toinsurance" name="toinsurance" type="text"   value="{{isset($insurance) ? $insurance->value_package : ''}} $" readonly>
                    @include('errors.field', ['field' => 'tracking'])
                 @include('errors.field', ['field' => 'insurance'])
              </div>
            </div>

            <!--Costo total de cargos adicionales -->

            <div class="form-group row @include('errors.field-class', ['field' => 'costadd'])" id="divsubtotal" >
              <label class="col-lg-3 control-label" id="invoiceLabel" style="line-height: 15px;">{{trans('package.costadd')}}</label>
              <div class="col-lg-9">
                <input class="form-control"  placeholder="{{trans('package.costadd')}}" id="costadd" name="costadd" type="float" maxlength="10" min="1" required="true" readonly value="{{isset($idaddcharge) ? $idaddcharge->value_oring : clear(Input::get('value'))}} $" @include('form.readonly')>
                @include('errors.field', ['field' => 'subtotal'])
              </div>
            </div>

            <!--Costo de subtotal -->
            <div class="form-group row @include('errors.field-class', ['field' => 'invoice'])" id="invoice" >
              <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.subtotal')}}</label>
              <div class="col-lg-9">
                 <input class="form-control"  placeholder="{{trans('package.subtotal')}}" id="subtotal" name="subtotal" type="float" maxlength="10" min="1"  readonly value="{{isset($package->value) ? $package->value : clear(Input::get('value'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'value'])
              </div>
            </div>

            <!--Costo de Impuestos -->

            <div class="form-group row @include('errors.field-class', ['field' => 'tax'])" id="taxdiv" >
                <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.tax')}}</label>
                <div class="col-lg-9">
                  <input class="form-control"  placeholder="{{trans('package.tax')}}" id="taxre" name="taxre" readonly  type="float" maxlength="10" min="1" required="true"  value="{{isset($insurance) ? $taxxes->value_package : ''}} $" @include('form.readonly')>
                  @include('errors.field', ['field' => 'value'])
                </div>
            </div>


            <div class="form-group row @include('errors.field-class', ['field' => 'promotionval'])" id="divalpromotion">
              <label class="col-lg-3 control-label" id="invoiceLabel" style="line-height: 14px;" >{{trans('package.promotionselect')}}</label>
               <div class="col-lg-9">
               <input class="form-control"  placeholder="{{trans('package.notpromotionna')}}" id="promotionval" name="promotionval" type="float" maxlength="10" min="1"  readonly value="{{isset($package->value) ? $package->value : clear(Input::get('value'))}}" @include('form.readonly')>
                        @include('errors.field', ['field' => 'value'])
               </div>
            </div>


            <div class="form-group row @include('errors.field-class', ['field' => 'invoice'])" id="invoice" >
              <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.total')}}</label>
              <div class="col-lg-9">
                 <input class="form-control"  placeholder="{{trans('package.total')}}" id="total" name="total" type="float" maxlength="10" min="1"  readonly value="{{isset($package->value) ? $package->value : clear(Input::get('value'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'value'])
              </div>
            </div>

          </div>
          </div>
          @if(!isset($readonly) || !$readonly)
            <div class="col-lg-12 buttons"  id="divButton">
              <button type="submit" class="btn btn-primary pull-right">
              <i class="fa fa-floppy-o" aria-hidden="true"></i>
                {{trans(isset($package)?'messages.update' : 'messages.save')}}
              </button>
            </div>
          @endif
        </div>
      </div>

      <div id="ics_tab_menu4" class="tab-pane fade">
      </div>

      <div id="ics_tab_menu5" class="tab-pane fade">
      </div>



    <input type ="hidden" name="countpack" id="countpack" value="1">
    <input type ="hidden" name="aux" id="aux" value="1">

    <input type ="hidden" name="start_at" id="start_at" value="{{(isset($start_at))?$start_at:null}}">


    </div>
     </div>
    </div>
    <!--  -->

    <!-- -->
    <!-- Change this to a button or input when using this as a form -->

  </fieldset>
</form>
