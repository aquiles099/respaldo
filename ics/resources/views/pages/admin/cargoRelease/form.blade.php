<form role="form" action="{{asset($path)}}" onsubmit="createLoad()" method="post" novalidate   id="ics_cargo_release_form" enctype="multipart/form-data">
  @if(isset($cargoRelease))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset>
    <!--tabs-->
    <ul class="nav nav-tabs nav-justified">
      <li id="ics_inactive_tab0" class="active"><a data-toggle = "tab" href="#ics_tab_menu0">{{trans('cargoRelease.releaseInfo')}} <span><i class="fa fa-user" aria-hidden="true"></i></span></a></li>
      <li id="ics_inactive_tab1" class="ics-inactive-tab"><a data-toggle="tab" href="#ics_tab_menu1">{{trans('cargoRelease.chargeInformation')}} <span><i class="fa fa-cubes" aria-hidden="true"></i></span></a></li>
      <li id="ics_inactive_tab2" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu2">{{trans('transporters.attchments')}} <span><i class="fa fa-cloud-upload" aria-hidden="true"></i></span></a></li>
      <li id="ics_inactive_tab3" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu3">{{trans('cargoRelease.aditionalInformation')}} <span><i class="fa fa-plus-square-o" aria-hidden="true"></i></span></a></li>
    </ul>
    <!--tab content-->
    <div class="tab-content">
      <div id="ics_tab_menu0" class="tab-pane fade in active">
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-user" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <!--Divider-->
                <div class="breadcrumb">
                  <span>{{trans('cargoRelease.dateInfo')}}</span>
                </div>
                <fieldset class="form">
                  <!--departure range-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'from'])" id="type" >
                    <label class="col-lg-2 control-label" id="typeLabel" >{{trans('cargoRelease.date')}}</label>
                    <div class="col-lg-4 @include('errors.field-class', ['field' => 'release_date'])">
                      <div class="input-group">
                        <input type="text" class="form-control" id="release_date" name="release_date" value="{{isset($cargoRelease) ? $cargoRelease->release_date : Input::get('release_date')}}" required="true" placeholder ="{{trans('cargoRelease.date')}}" @include('form.readonly')>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                      @include('errors.field', ['field' => 'release_date'])
                    </div>
                    <label class="col-lg-2 control-label" id="typeLabel" >{{trans('cargoRelease.hour')}}</label>
                    <div class="col-lg-4 @include('errors.field-class', ['field' => 'release_time'])">
                      <div class="input-group">
                        <input type="text" class="form-control" id="release_time" name="release_time" value="{{isset($cargoRelease) ? $cargoRelease->release_time : Input::get('release_time')}}" required="true" placeholder ="{{trans('cargoRelease.hour')}}" @include('form.readonly')>
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                      </div>
                       @include('errors.field', ['field' => 'release_time'])
                    </div>
                  </div>
                </fieldset>
              </div>
              <!---->

              <div class="col-md-12">
                <div class="breadcrumb">
                    <span>{{trans('package.userconsigner')}}</span>
                </div>

                <div class="form-group row @include('errors.field-class', ['field' => 'finalOriginUser'])" id="destination" style="display:block;"}}>
                  <label class="col-lg-3 control-label">{{trans('package.user')}}</label>
                  <div class="col-lg-9">
                  <select class="form-control" id="finalConsigUser" name="finalConsigUser"  @include('form.readonly') >
                  <option value="">{{trans('package.chooseUser')}}</option>
                  <option value="adduc">{{trans('package.adduser')}}</option>
                    @foreach ($users as $user)
                      <?php $option = $user->toOption();?>
                      <label class="col-lg-3 control-label" id="labelUser" value="{{$option['id']}}"></label>
                      <option {{(isset($package) ? $package->consigner_user : Input::get('finalConsigUser')) == $option['id'] ? 'selected' : ''}} item="{{$user}}" value="{{$option['id']}}">{!! $option['text']!!}</option>
                    @endforeach
                  </select>
                 </div>
                </div>

                <div class="form-group row @include('errors.field-class', ['field' => 'name'])" id="clientName" >
                  <label class="col-lg-3 control-label" id="labelName" >{{trans('package.clientName')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" readonly="true" placeholder="{{trans('package.clientName')}}" id="cons_name" name="cons_name" type="text" maxlength="25" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['name'] : clear(Input::get('name'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'name'])
                  </div>
                </div>

                <!---->
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
                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'phone'])" id="clientPhone" >
                  <label class="col-lg-3 control-label" id="labelPhone" >{{trans('package.clientPhone')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" readonly="true" placeholder="{{trans('package.clientPhone')}}" id="cons_phone" name="cons_phone" type="text" maxlength="25" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['local_phone']: clear(Input::get('phone'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'phone'])
                  </div>
                </div>

                <!---->
                <div class="form-group row @include('errors.field-class', ['field' => 'phone'])" id="clientPhone" >
                  <label class="col-lg-3 control-label" id="labelPhone" >{{trans('package.cell')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" readonly="true" placeholder="{{trans('package.cell')}}" id="cons_cell" name="cons_cell" type="text" maxlength="25" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['celular']: clear(Input::get('phone'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'phone'])
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
                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                  <label class="col-lg-3 control-label" id="labelDirection" style="line-height: 14px;" >{{trans('package.zip')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" readonly="true" placeholder="{{trans('package.clientDirection')}}" id="cons_zipcode" name="cons_zipcode" type="text" maxlength="250" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['postal_code'] : clear(Input::get('cons_zipcode'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'direction'])
                  </div>
                </div>

                <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientCountry">
                  <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.country')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" readonly="true" placeholder="{{trans('package.country')}}" id="cons_country" name="cons_country" type="text" maxlength="250" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['country'] : clear(Input::get('cons_country'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'direction'])
                  </div>
                </div>

                   <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientSelectCountry">
                  <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.country')}}</label>
                  <div class="col-lg-9">
                    <select class="form-control"  readonly="true" name="clientSelectCountry" placeholder="{{trans('messages.country')}}" required="true" value="{{Input::get('country')}}" id="clientSelectCountry" >
                      @if(isset($countrys))
                        <option value="0">{{trans('route.selectOption')}}</option>
                        @foreach($countrys as $country)
                          <option {{(Input::get('country')) == $country ? 'selected' : '' }} value="{{$country->name}}" >{{$country->name}}</option>
                        @endforeach
                      @endif
                    </select>
                      @include('errors.field', ['field' => 'direction'])
                  </div>
                </div>
                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
                  <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.region')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" readonly="true" placeholder="{{trans('package.region')}}" id="cons_region" name="cons_region" type="text" maxlength="250" min="5"  value="{{isset($package->consigner_user) ? $package->getToConsigneUser['region'] : clear(Input::get('cons_region'))}}" @include('form.readonly')>
                      @include('errors.field', ['field' => 'direction'])
                  </div>
                </div>

                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" >
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
                                    @if(!isset($cargoRelease))
                                    <tr item = "{{$value}}">
                                      <td>{{$value->getLastEvent->description}}</td>
                                      <td>{{$value->code}}</td>
                                      <td>{{$value->value}}</td>
                                      <td>{{$value->observation}}</td>
                                      <td><input type="checkbox" name="wr{{$value->id}}" value="wr{{$value->id}}" @if(isset($cargo_release_detail)) @foreach($cargo_release_detail as $key => $detail) @if($detail->warehouse_receipt == $value->id ) checked @endif @endforeach @endif/></td>
                                    </tr>
                                    @elseif($value->process == $cargoRelease->code || $value->booked == null)
                                    <tr item = "{{$value}}">
                                      <td>{{$value->getLastEvent->description}}</td>
                                      <td>{{$value->code}}</td>
                                      <td>{{$value->value}}</td>
                                      <td>{{$value->observation}}</td>
                                      <td><input type="checkbox" name="wr{{$value->id}}" value="wr{{$value->id}}" @if(isset($cargo_release_detail)) @foreach($cargo_release_detail as $key => $detail) @if($detail->warehouse_receipt == $value->id ) checked @endif @endforeach @endif/></td>
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
                                    @if(!isset($cargoRelease))
                                    <tr item = "{{$value}}">
                                      <td>{{$value->getLastEvent->description}}</td>
                                      <td>{{$value->code}}</td>
                                      <td>{{$value->value}}</td>
                                      <td>{{$value->observation}}</td>
                                      <td><input type="checkbox" name="pk{{$value->id}}" value="pk{{$value->id}}" @if(isset($cargo_release_detail)) @foreach($cargo_release_detail as $key => $detail) @if($detail->pickup_order == $value->id ) checked @endif @endforeach @endif/></td>
                                    </tr>
                                    @elseif($value->process == $cargoRelease->code || $value->booked == null)
                                    <tr item = "{{$value}}">
                                      <td>{{$value->getLastEvent->description}}</td>
                                      <td>{{$value->code}}</td>
                                      <td>{{$value->value}}</td>
                                      <td>{{$value->observation}}</td>
                                      <td><input type="checkbox" name="pk{{$value->id}}" value="pk{{$value->id}}" @if(isset($cargo_release_detail)) @foreach($cargo_release_detail as $key => $detail) @if($detail->pickup_order == $value->id ) checked @endif @endforeach @endif/></td>
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
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="ics_tab_menu2" class="tab-pane fade" >
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
      </div><!-- second tab -->
      <div id="ics_tab_menu3" class="tab-pane fade">
        <!--Aditional Info-->
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-plus-square-o" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <!--adiional info-->
            <div class="form-group row @include('errors.field-class', ['field' => 'aditionalInformation'])" id="type" >
              <label class="col-lg-3 control-label" id="typeLabel" >{{trans('cargoRelease.aditionalInformation')}}</label>
              <div class="col-lg-9">
                  <textarea class="form-control" id="aditionalInformation" name="aditional_information" value="{{Input::get('aditional_information')}}" placeholder="{{trans('cargoRelease.aditionalInformation')}}"required="true" @include('form.readonly')>{{isset($cargoRelease) ? $cargoRelease->aditional_information : Input::get('aditional_information')}}</textarea>
                  @include('errors.field', ['field' => 'aditionalInformation'])
              </div>
            </div>
            <!-- send data -->
            <div class="pull-right" id="divButton">
              <button class="btn btn-primary" type="submit" id="submit-all"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{trans(isset($cargoRelease) ? 'cargoRelease.update' : 'cargoRelease.save')}}</button>
            </div>
          </div>
        </div>
      </div> <!--last tab --> <!--Last tab-->
    </div>
  </fieldset>
</form>
