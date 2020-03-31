<form role="form" action="{{asset($path)}}" method="post" novalidate  onsubmit="select(this); return true">
  @if(isset($cargoRelease))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset>
    <!--tabs-->
    <ul class="nav nav-tabs nav-justified">
      <li id="ics_inactive_tab0" class="active"><a data-toggle="tab" href="#ics_tab_menu0">{{trans('booking.chargeInformation')}} <span><i class="fa fa-cubes" aria-hidden="true"></i></span></a></li>
      <li id="ics_inactive_tab1" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu1">{{trans('cargoRelease.releaseInfo')}} <span><i class="fa fa-user" aria-hidden="true"></i></span></a></li>
      <li id="ics_inactive_tab2" class="ics-inactive-tab"><a data-toggle = "tab" href="#ics_tab_menu2">{{trans('booking.aditionalInformation')}} <span><i class="fa fa-plus-square-o" aria-hidden="true"></i></span></a></li>
    </ul>
    <!--tab content-->
    <div class="tab-content">
      <div id="ics_tab_menu0" class="tab-pane fade in active" >
        <!--Cargo Info-->
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-cubes" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <!--divider-->
                <div class="breadcrumb" >
                    <span></span>
                    <span class="">
                      <div class="dropdown" >
                        <a class="dropdown-toggle" type="button" data-toggle="dropdown" id="ics_link_dropdown">
                          <span class="text-muted" data-toggle="tooltip" title="{{trans('cargoRelease.filterBy')}}">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                            <span class="" id="ics_load"></span>
                            {{trans('cargoRelease.filterBy')}} | {{($type == 1) ? trans('cargoRelease.warehouseReceipt') : trans('cargoRelease.pickupOrder')}}
                            <span id="selected_item">
                            </span>
                            <span class="caret"></span>
                          </span>
                        </a>
                        <ul class="dropdown-menu" id="">
                          <li class="dropdown-header">{{trans('messages.show')}}</li>
                          <li class="divider"></li>
                          <li><a href="{{asset('admin/cargoRelease/1/new')}}">{{trans('cargoRelease.wr')}} <span class="pull-right"><i class="fa fa-cube" aria-hidden="true"></i></span></a></li>
                          <li><a href="{{asset('admin/cargoRelease/2/new')}}">{{trans('cargoRelease.pk')}} <span class="pull-right"><i class="fa fa-th-large fa-fw" aria-hidden="true"></i></span></a></li>
                        </ul>
                      </div>
                    </span>
                </div>
              </div>
              <div class="col-md-12">
                @include('sections.list.pick', [
                  'label'    => trans('cargoRelease.cargo'),
                  'name'     => 'cargo',
                  'data'     => $cargo,
                  'selected' => isset($cargo) ? getIds($cargo) : Input::get('cargo')
                ])
                <!---->

              </div>
            </div>
          </div>
        </div>
      </div> <!-- second tab -->
      <div id="ics_tab_menu1" class="tab-pane fade">
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
                        <input type="text" class="form-control" id="release_date" name="release_date" value="{{isset($cargoRelease) ? $cargoRelease->rrelease_date : Input::get('release_date')}}" required="true" placeholder ="{{trans('cargoRelease.date')}}" @include('form.readonly')>
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
                <!--Divider-->
                <div class="breadcrumb">
                  <span>{{trans('cargoRelease.contactInfo')}}</span>
                </div>
                <!--Shipper Information-->
                <fieldset class="form">
                  <!--name-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'contact_user'])" >
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('cargoRelease.contact_user')}}</label>
                    <div class="col-lg-9">
                      <select style="width:100%;" class="form-control" id="contact_user" name="contact_user" required="true" @include('form.readonly')>
                        @if(isset($users))
                          <option value="0">{{trans('booking.selectUser')}}</option>
                          @foreach($users as $key => $user)
                            <option {{isset($booking) ? ($booking->shipper == $user->id) ? 'selected' : '' : '' }} name ="{{$user->name}} {{$user->last_name}}" item="{{$user->toInnerJson()}}" value="{{$user->id}}">{{$user->code}} {{$user->email}}</option>
                          @endforeach
                        @endif
                      </select>
                        @include('errors.field', ['field' => 'contact_user'])
                    </div>
                  </div>
                  <!--name-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'contact_name'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('cargoRelease.contact_name')}}</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" id="contact_name" name="contact_name" value="{{isset($booking) ? $booking : Input::get('contact_name')}}" placeholder="{{trans('cargoRelease.contact_name')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'contact_name'])
                    </div>
                  </div>
                  <!--phone-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'contact_phone'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('cargoRelease.contact_phone')}}</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="{{isset($booking) ? $booking->getShipper->celular : Input::get('contact_phone')}}" placeholder="{{trans('cargoRelease.contact_phone')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'contact_phone'])
                    </div>
                  </div>
                  <!--country-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'contact_country'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('cargoRelease.contact_country')}}</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" id="contact_country" name="contact_country" value="{{isset($booking) ? $booking->getShipper->country : Input::get('contact_country')}}" placeholder="{{trans('cargoRelease.contact_region')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'contact_country'])
                    </div>
                  </div>
                  <!--region-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'contact_region'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('cargoRelease.contact_region')}}</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" id="contact_region" name="contact_region" value="{{isset($booking) ? $booking->getShipper->region : Input::get('contact_region')}}" placeholder="{{trans('cargoRelease.contact_region')}}"required="true" @include('form.readonly')>
                    @include('errors.field', ['field' => 'contact_region'])
                    </div>
                  </div>
                  <!--city-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'contact_city'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('cargoRelease.contact_city')}}</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" id="contact_city" name="contact_city" value="{{isset($booking) ? $booking->getShipper->city : Input::get('contact_city')}}" placeholder="{{trans('cargoRelease.contact_city')}}"required="true" @include('form.readonly')>
                    @include('errors.field', ['field' => 'contact_city'])
                    </div>
                  </div>
                  <!--address-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'contact_address'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('cargoRelease.contact_address')}}</label>
                    <div class="col-lg-9">
                        <textarea class="form-control" id="contact_address" name="contact_address" placeholder="{{trans('cargoRelease.contact_address')}}"required="true" @include('form.readonly')>{{isset($cargoRelease) ? $cargoRelease->getShipper->address : Input::get('contact_address')}}</textarea>
                    @include('errors.field', ['field' => 'contact_address'])
                    </div>
                  </div>
                  <!--postal code-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'contact_postal_code'])">
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('cargoRelease.contact_postal_code')}}</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" id="contact_postal_code" name="contact_postal_code" value="{{isset($booking) ? $booking->getShipper->postal_code : Input::get('contact_postal_code')}}" placeholder="{{trans('cargoRelease.contact_postal_code')}}"required="true" @include('form.readonly')>
                      @include('errors.field', ['field' => 'contact_postal_code'])
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>
          </div>
        </div>
      </div> <!--fisrt tab-->
      <div id="ics_tab_menu2" class="tab-pane fade">
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
                  <textarea class="form-control" id="aditionalInformation" name="aditionalInformation" value="{{Input::get('aditionalInformation')}}" placeholder="{{trans('booking.aditionalInformation')}}"required="true" @include('form.readonly')>{{isset($booking) ? $booking->aditionalInformation : Input::get('aditionalInformation')}}</textarea>
                  @include('errors.field', ['field' => 'aditionalInformation'])
              </div>
            </div>
            <!-- send data -->
            <div class="pull-right">
              <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{trans(isset($booking) ? 'booking.update' : 'booking.save')}}</button>
            </div>
          </div>
        </div>
      </div> <!--last tab --> <!--Last tab-->
    </div>
  </fieldset>
</form>
