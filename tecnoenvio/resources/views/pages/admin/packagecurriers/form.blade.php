@include('sections.translate')

<form  id="formulario" role="form" method="post" novalidate method="post">
  <fieldset>
    @if(isset($package))
      <input type="hidden" name="_method" value="patch">
    @endif
    <div class="breadcrumb">
      <i aria-hidden="true" class="fa fa-paper-plane-o"></i>
      {{trans('package.courier')}}
    </div>
    <div class="id_100 form-group row @include('errors.field-class', ['field' => 'courierSelect'])">
      <div class="col-md-12">
        <select class="form-control" id="courierSelect" name="courierSelect" @include('form.readonly')>
          @foreach ($couriers as $courier)
            <option {{(isset($package->from_courier) ? $package->from_courier : Input::get('from_courier')) == $courier->id ? 'selected' : ''}} value="{{$courier->id}}">{{$courier->name}}</option>
          @endforeach
        </select>
        @include('errors.field', ['field' => 'courierSelect'])
      </div>
    </div>
    <!--tabs-->
    <ul class="nav nav-tabs nav-justified">
      <li  class="active"><a data-toggle = "tab" href="#ics_tab_menu0">{{trans('package.packageinfo')}} <span><i class="fa fa-cube" aria-hidden="true"></i></span></a></li>
      <li><a data-toggle="tab" href="#ics_tab_menu1">{{trans('package.destinyinfo')}} <span><i class="fa fa-user" aria-hidden="true"></i></span></a></li>
      <li><a data-toggle="tab" href="#ics_tab_menu2">{{trans('package.paymentinfo')}} <span><i class="fa fa-usd" aria-hidden="true"></i></span></a></li>
    </ul>
    <!--content-->
    <div class="tab-content">
      <!--tab 0-->
      <div id="ics_tab_menu0" class="tab-pane fade in active">
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-cube" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <!--tracking-->
            <div class="form-group row @include('errors.field-class', ['field' => 'tracking'])" id="divTracking"  >
              <div class="col-lg-3">
                <label for="tracking">{{trans('package.tracking')}}</label>
              </div>
              <div class="col-lg-9">
                <input class="form-control form_dimension" placeholder="{{trans('package.tracking')}}" id="tracking" name="tracking" type="text" maxlength="25" min="10" required="true" value="{{isset($package) ? $package->tracking : clear(Input::get('tracking'))}}" @include('form.readonly',['forceReadonly' => isset($package)])>
                @include('errors.field', ['field' => 'tracking'])
              </div>
            </div>
            <!--service order-->
            <div class="form-group row @include('errors.field-class', ['field' => 'service_order'])" id=""  >
              <div class="col-lg-3">
                <label for="service_order">{{trans('package.service_order')}}</label>
                <span id="ics_service_order" class="pull-right"></span>
              </div>
              <div class="col-lg-9">
                <div class="input-group" style="width:94%!important" >
                  <input class="form-control form_dimension" placeholder="{{trans('package.service_order')}}" id="service_order" name="service_order" type="text" maxlength="25" min="10" required="true" value="{{isset($package) ? $package->order_service : clear(Input::get('service_order'))}}" @include('form.readonly',['forceReadonly' => isset($package)])>
                  <span class = "input-group-addon">
                    <a href="javascript:icsSearchPrealert()" class="text-muted" data-toggle="tooltip" title="{{trans('package.queryprealert')}}">
                        <i aria-hidden="true" class="fa fa-search"></i>
                    </a>
                  </span>
                </div>
                @include('errors.field', ['field' => 'service_order'])
              </div>
            </div>
            <!--large-->
            <div class="form-group row @include('errors.field-class', ['field' => 'large'])"  id="divlarge">
              <div class="col-lg-3">
                <label for="large">{{trans('package.large')}}</label>
              </div>
              <div class="col-lg-9">
                <input type="number" class="form-control form_dimension" placeholder="{{trans('package.large')}}" id="large" name="large" onkeyup="pesovol()" type="float" style="display: inline;" maxlength="10" min="1" required="true" value="{{isset($package) ? $package->large : clear(Input::get('large'))}}" @include('form.readonly')>
                 <span>in</span>
                  @include('errors.field', ['field' => 'large'])
              </div>
            </div>
            <!--width-->
            <div class="form-group row @include('errors.field-class', ['field' => 'width'])" onkeyup="pesovol()" id="divwidth">
              <div class="col-lg-3">
                <label for="width">{{trans('package.width')}}</label>
              </div>
              <div class="col-lg-9">
                <input type="number" class="form-control form_dimension" placeholder="{{trans('package.width')}}" id="width" name="width" type="float" maxlength="10" min="1" style="display: inline;" required="true" value="{{isset($package) ? $package->width : clear(Input::get('width'))}}" @include('form.readonly')>
                 <span>in</span>
                  @include('errors.field', ['field' => 'width'])
              </div>
            </div>
            <!--height-->
            <div class="form-group row @include('errors.field-class', ['field' => 'height'])" onkeyup="pesovol()" id="divheight">
              <div class="col-lg-3">
                <label for="height">{{trans('package.height')}}</label>
              </div>
              <div class="col-lg-9">
                <input type="number" class="form-control form_dimension" placeholder="{{trans('package.height')}}" id="height" onkeyup="pesovol()" name="height"  type="float" maxlength="10" min="1" required="true" value="{{isset($package) ? $package->height : clear(Input::get('height'))}}" @include('form.readonly')>
                 <span>in</span>
                  @include('errors.field', ['field' => 'height'])
              </div>
            </div>
            <!--weight-->
            <div class="form-group row @include('errors.field-class', ['field' => 'weight'])" onkeyup="pesovol()" id="divweight">
              <div class="col-lg-3">
                <label for="weight">{{trans('package.weight')}}</label>
              </div>
              <div class="col-lg-9">
                <input type="number" class="form-control form_dimension" placeholder="{{trans('package.weight')}}" id="weight" onkeyup="pesovol()" name="weight" type="float" maxlength="10" min="1" required="true" value="{{isset($package) ? $package->weight : clear(Input::get('weight'))}}" @include('form.readonly')>
                 <span>lb</span>
                  @include('errors.field', ['field' => 'weight'])
              </div>
            </div>
            <!--value-->
            <div class="form-group row @include('errors.field-class', ['field' => 'value'])" onkeyup="pesovol()" id="divvalue">
              <div class="col-lg-3">
                <label for="value">{{trans('package.value')}}</label>
              </div>
              <div class="col-lg-9">
                <input type="number" class="form-control form_dimension" placeholder="{{trans('package.value')}}" id="value" name="value" type="float" maxlength="10" min="1" required="true" value="{{isset($package) ? $package->value : clear(Input::get('value'))}}" @include('form.readonly')>
                <span>$</span>
                @include('errors.field', ['field' => 'value'])
              </div>
            </div>

            <div class="form-group row @include('errors.field-class', ['field' => 'volumetricweight'])" id="divtype" >
                <label class="col-lg-3 control-label" id="typeLabel" style="line-height: 18px!important;" >{{trans('package.volumem')}}</label>
                <div class="col-lg-9">
                       <input class="form-control form_dimension"  placeholder="{{trans('package.volumem')}}" id="volumetricweightm" name="volumetricweightm" type="float" maxlength="10" min="1" readonly required="true" value="{{isset($package) ? $package->volumetricweightm : clear(Input::get('volumetricweightm'))}}" @include('form.readonly')>
                        <span>ft<sup>3</sup></span>
                          @include('errors.field', ['field' => 'volumetricweightm'])
                </div>
            </div>

            <div class="form-group row @include('errors.field-class', ['field' => 'volumetricweight'])" id="divtype" >
                <label class="col-lg-3 control-label" id="typeLabel" style="line-height: 18px!important;" >{{trans('package.volumea')}}</label>
                <div class="col-lg-9">
                       <input class="form-control form_dimension"  placeholder="{{trans('package.volumea')}}" id="volumetricweighta" name="volumetricweighta" type="float" maxlength="10" min="1" readonly required="true" value="{{isset($package) ? $package->volumetricweighta : clear(Input::get('volumetricweighta'))}}" @include('form.readonly')>
                       <span>Vlb</span>
                          @include('errors.field', ['field' => 'volumetricweighta'])
                </div>
            </div>


          </div>
        </div>
      </div>
      <!--tab 1-->
      <div id="ics_tab_menu1" class="tab-pane fade">
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-user" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <!--user select-->
            <div class="form-group row @include('errors.field-class', ['field' => 'finalDestinationUser'])" id="destination" style="display:block;"}}>
              <label class="col-lg-3 control-label">{{trans('package.destination')}}</label>
              <div class="col-lg-9">
              <select class="form-control" id="finalDestinationUser" name="finalDestinationUser"  @include('form.readonly') >
              <option value="">{{trans('package.chooseClient')}}</option>
                @foreach ($users as $user)
                  <?php $option = $user->toOption();?>
                  <option {{(isset($package) ? $package->to_user : Input::get('to_user')) == $option['id'] ? 'selected' : ''}} item="{{$user->toInnerJson()}}" value="{{$option['id']}}">{!! $option['text']!!}</option>
                @endforeach
              </select>
             </div>
            </div>
            <!--user name-->
            <div class="form-group row @include('errors.field-class', ['field' => 'name'])" id="clientName" >
             <label class="col-lg-3 control-label" id="labelName" >{{trans('package.clientName')}}</label>
             <div class="col-lg-9">
               <input class="form-control" placeholder="{{trans('package.clientName')}}" id="name" name="name" type="text" maxlength="25" min="5" required="true" value="{{isset($package->getToUser) ? $package->getToUser->name : clear(Input::get('name'))}}" @include('form.readonly')>
                 @include('errors.field', ['field' => 'name'])
             </div>
           </div>
            <!--user phone-->
            <div class="form-group row @include('errors.field-class', ['field' => 'phone'])" id="clientPhone" >
              <label class="col-lg-3 control-label" id="labelPhone" >{{trans('package.clientPhone')}}</label>
              <div class="col-lg-9">
                <input class="form-control" placeholder="{{trans('package.clientPhone')}}" id="phone" name="phone" type="text" maxlength="25" min="5" required="true" value="{{isset($package->getToUser) ? $package->getToUser->local_phone : clear(Input::get('phone'))}}" @include('form.readonly')>
                  @include('errors.field', ['field' => 'phone'])
              </div>
            </div>
            <!--user email -->
            <div class="form-group row @include('errors.field-class', ['field' => 'email'])" id="clientEmail" >
              <label class="col-lg-3 control-label" id="labelEmail" >{{trans('package.clientEmail')}}</label>
              <div class="col-lg-9">
                <input class="form-control" placeholder="{{trans('package.clientEmail')}}" id="email" name="email" type="text" maxlength="50" min="5" required="true" value="{{isset($package->getToUser) ? $package->getToUser->email : clear(Input::get('email'))}}"@include('form.readonly')>
                  @include('errors.field', ['field' => 'email'])
              </div>
            </div>
            <!--user dni -->
            <div class="form-group row @include('errors.field-class', ['field' => 'identifier'])" id="clientIdentifier" >
              <label class="col-lg-3 control-label" id="labelIdentifier" >{{trans('package.clientIdentifier')}}</label>
              <div class="col-lg-9">
                <input class="form-control" placeholder="{{trans('package.clientIdentifier')}}" id="identifier" name="identifier" type="text" maxlength="25" min="5" required="true" value="{{isset($package->getToUser) ? $package->getToUser->dni : clear(Input::get('identifier'))}}" @include('form.readonly')>
                  @include('errors.field', ['field' => 'identifier'])
              </div>
            </div>

            <!--user Address -->
            <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="divDirection" >
              <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.address')}}</label>
              <div class="col-lg-9">
                <textarea class="form-control" placeholder="{{trans('package.address')}}" id="direction" name="direction" type="text" maxlength="250" min="5" @include('form.readonly') value = "{{isset($package->getToUser) ? $package->getToUser['address'] : clear(Input::get('address'))}}">{{isset($package->getToUser) ? $package->getToUser->country.', '.$package->getToUser->region.', '.$package->getToUser->city.', '.$package->getToUser->address: clear(Input::get('address'))}}</textarea>
                  @include('errors.field', ['field' => 'observation'])
              </div>
            </div>
            <!--user observation -->
            <div class="form-group row @include('errors.field-class', ['field' => 'observation'])" id="divObservation" >
              <label class="col-lg-3 control-label" id="labelObservation" >{{trans('package.observation')}}</label>
              <div class="col-lg-9">
                <textarea class="form-control" placeholder="{{trans('package.observation')}}" id="observation" name="observation" type="text" maxlength="250" min="5" @include('form.readonly')>{{isset($package) ? $receipt->observation : clear(Input::get('observation'))}}</textarea>
                  @include('errors.field', ['field' => 'observation'])
              </div>
            </div>

          </div>
        </div>
      </div>
      <!--tab 2-->
      <div id="ics_tab_menu2" class="tab-pane fade">
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-usd" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <div class="row">
              <!--type-->
              <div class="col-md-6">
                <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="idtype" >
                  <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.service')}}</label>
                  <div class="col-lg-9">
                    <select class="form-control" id="type" name="type" required="true" @include('form.readonly')>
                    <option value="" cost="0">{{trans('package.nottype')}}</option>
                        @foreach ($transports as $transport)
                          <?php $option = $transport->toOption();?>
                          <option {{(isset($package) ? $package->type : Input::get('type')) == $option['id'] ? 'selected' : ''}} item="{{$transport->toInnerJson()}}" value="{{$option['id']}}" cost="{{$option['price']}}">{{$option['text']}} </option>
                        @endforeach
                    </select>
                    @include('errors.field', ['field' => 'type|'])
                  </div>
                </div>

                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="idtype" >
                  <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.type')}}</label>
                  <div class="col-lg-9">
                    <select class="form-control" id="typeservice" name="typeservice" required="true" @include('form.readonly')>
                    <option value="">{{trans('package.notservice')}}</option>
                    @if($tytransport!='')
                        @foreach ($tytransport as $transport)
                          <?php $option = $transport->toOption();?>
                          <option {{(isset($package) ? $package->dettype : Input::get('type')) == $option['id'] ? 'selected' : ''}} item="{{$transport}}" cost="{{$option['price']}}" value="{{$option['id']}}">{{$option['text']}} {{$option['price']}}($)</option>
                        @endforeach
                    @endif
                    </select>
                    @include('errors.field', ['field' => 'type|'])
                  </div>
                </div>

              <div class="form-group row @include('errors.field-class', ['field' => 'taxval'])" style="display:block;">
                <label class="col-lg-3 control-label" id="servicelabel" >{{trans('package.taxx')}}</label>
                <div class="col-lg-9">
                  <input class="form-control" placeholder="{{trans('package.taxx')}}" id="taxval" onkeyup="calctax()" name="taxval" type="text" maxlength="5"  value="{{isset($tax->value) ? $tax->value : ''}}">
                  @include('errors.field', ['field' => 'taxval'])

                </div>
              </div>

               <div class="form-group row @include('errors.field-class', ['field' => 'insurance'])" style="display:block;">
                <label class="col-lg-3 control-label" id="servicelabel" >{{trans('package.insurance')}}</label>
                <div class="col-lg-9">
                  <input class="form-control" placeholder="{{trans('package.insurance')}}" id="insurance" onkeyup="calcinsurance()" name="insurance" type="text" maxlength="5"   value="{{isset($insurance) ? $insurance->value_oring : clear(Input::get('insurance'))}}">
                  @include('errors.field', ['field' => 'tracking'])
                @include('errors.field', ['field' => 'insurance'])
                </div>
              </div>

              <div class="form-group row @include('errors.field-class', ['field' => 'addcharge'])" >
                  <label class="col-lg-3 control-label" id="officeLabel" style="line-height: 15px;" >{{trans('package.addcharge')}}</label>
                  <div class="col-lg-9">
                    <select class="form-control" id="addcharge" name="addcharge"  @include('form.readonly')>
                     <option value="">{{trans('package.chorgeaddcharge')}}</option>
                     @foreach ($addcharge as $addcharges)
                      <option {{isset($idaddcharge) && $idaddcharge->id_complemento==$addcharges->id ? 'selected':''}} item="{{$addcharges}}" cost="{{$addcharges->value}}"  value="{{$addcharges->id}}" >{{$addcharges->name}}-{{$addcharges->value}}$</option>
                     @endforeach
                    </select>
                    @include('errors.field', ['field' => 'office'])
                  </div>
                </div>


              <div class="form-group row @include('errors.field-class', ['field' => 'office'])" id="officeDiv" >
                  <label class="col-lg-3 control-label" id="officeLabel" >{{trans('package.office')}}</label>
                  <div class="col-lg-9">
                    <select class="form-control" id="office" name="office"  @include('form.readonly')>
                     <option value="">{{trans('package.chooseOffice')}}</option>
                     @foreach ($office as $offi)
                        <?php $option = $offi->toOption();?>
                        <option {{(isset($package) ? $package->office : Input::get('office')) == $option['id'] ?  'selected' : ''}} item="{{$offi->toInnerJson()}}"  value="{{$option['id']}}" >{{$option['text']}}</option>
                     @endforeach
                    </select>
                    @include('errors.field', ['field' => 'office'])
                  </div>
                </div>
                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'category'])" id="categoryDiv" >
                  <label class="col-lg-3 control-label" id="categoryLabel" >{{trans('package.category')}}</label>
                  <div class="col-lg-9">
                    <select class="form-control" id="category" name="category" required="true" @include('form.readonly')>
                        @foreach ($category as $cat)
                          <?php $option = $cat->toOption();?>
                          <option {{(isset($package) ? $package->category : Input::get('category')) == $option['id'] ? 'selected' : ''}} item="{{$cat->toInnerJson()}}"  porcent="{{$option['percent']}}" value="{{$option['id']}}" cost="{{$option['percent']}}">{{$option['text']}} </option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'invoice'])" id="invoice" >
                  <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.invoice')}}</label>
                  <div class="col-lg-9">
                    <select class="form-control" id="invoice" name="invoice" required="true" @include('form.readonly')>
                      {{--se comenta el codigo php para que se inicalice el select como 'sin factura'--}}
                        <option {{--(isset($package) ? $package->invoice : 0) == 0 ? 'selected' : ''--}} value=0>{{trans('package.withOutInvoice')}}</option>
                        <option {{--(isset($package) ? $package->invoice : 1) == 1 ? 'selected' : ''--}} value=1>{{trans('package.withInvoice')}}</option>
                    </select>
                    </div>
                </div>
                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'id_package'])" id="uploadinvoice" style="padding-left: 30%;display:none">
                    <input type="file" name="file" id="file" accept=".pdf, image/*" autofocus value="{{ Input::get('file') }}" >
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'id_package'])
                </div>
                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'consolidate'])" id="consolidate" style="display:block;">
                  <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.consolidated')}}</label>
                  <div class="col-lg-9">
                   <select class="form-control" id="consolidated" name="consolidated" required="true" @include('form.readonly')>
                   <option value="">{{trans('package.notconsolidated')}}</option>
                        @foreach ($consolidated as $consol)
                          <?php $option = $consol->toOption();?>
                          <option {{(isset($package->consolidated) ? $package->consolidated : Input::get('type')) == $option['id'] ? 'selected' : ''}} item="{{$transport->toInnerJson()}}" value="{{$option['id']}}">{{$option['text']}}</option>
                        @endforeach
                    </select>
                    <span class="text-muted">{{trans('messages.optional')}}</span>
                  </div>
                </div>
                <!---->
                <div class="form-group row @include('errors.field-class', ['field' => 'consolidate'])" id="consolidate" style="display:block;">
                  <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.promotion')}}</label>
                  <div class="col-lg-9">
                   <select class="form-control" id="promotion" name="promotion" required="true" @include('form.readonly')>
                   <option value="">{{trans('package.notpromotion')}}</option>
                        @foreach ($promotions as $promo)
                          <?php $option = $promo->toOption();?>
                          <option {{(isset($promotion->id_complemento) ? $promotion->id_complemento : Input::get('type')) == $option['id'] ? 'selected' : ''}}  item="{{$promo}}" value="{{$option['id']}}" reduction="{{$option['reduction']}}">{{$option['text']}}</option>
                        @endforeach
                    </select>
                    <span class="text-muted">{{trans('messages.optional')}}</span>
                  </div>
                </div>
              </div>
              <!-- isset($package) && $package->type == 1 ? $package->volumetricweightm.' ft3' : isset($package) && $package->type == 2 ? $package->volumetricweighta.' Vlb' :''-->
              <div class="col-md-6">
                <!-- -->
                <div class="form-group row @include('errors.field-class', ['field' => 'tax'])" id="taxdiv" >
                    <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.volume')}}</label>
                    <div class="col-lg-9">
                      <input class="form-control"  placeholder="{{trans('package.volume')}}" id="volre" name="volre" readonly  type="float" maxlength="10" min="1" required="true" value="@if(isset($package) && $package->type == 1) {{$package->volumetricweightm}}.ft3 @elseif (isset($package) && $package->type == 2) {{$package->volumetricweighta}}Vlb @endif" @include('form.readonly')>
                      @include('errors.field', ['field' => 'value'])
                    </div>

                </div>

                <!--Costo total por el servicio -->
                <div class="form-group row @include('errors.field-class', ['field' => 'costservice'])" id="divsubtotal" >
                  <label class="col-lg-3 control-label" id="invoiceLabel" style="line-height: 15px;" >{{trans('package.costservice')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control"  placeholder="{{trans('package.costservice')}}" id="costservice" name="costservice" type="float" maxlength="10" min="1" required="true" readonly value="{{isset($idtytransport) ? $idtytransport->price : clear(Input::get('value'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'subtotal'])
                  </div>
                </div>


                <!--Valor de Cargos Adicionales -->

                <div class="form-group row @include('errors.field-class', ['field' => 'costadd'])" id="divsubtotal" >
                  <label class="col-lg-3 control-label" id="invoiceLabel" style="line-height: 15px;">{{trans('package.costadd')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control"  placeholder="{{trans('package.costadd')}}" id="costadd" name="costadd" type="float" maxlength="10" min="1" required="true" readonly value="{{isset($idaddcharge) ? $idaddcharge->value_package : clear(Input::get('value'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'subtotal'])
                  </div>
                </div>

                <!--Valor del Seguro -->

                <div class="form-group row @include('errors.field-class', ['field' => 'costinsu'])" id="divsubtotal" >
                  <label class="col-lg-3 control-label" id="invoiceLabel" style="line-height: 15px;">{{trans('package.insurance')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control"  placeholder="{{trans('package.costinsurence')}}" id="costinsu" name="costinsu" type="float" maxlength="10" min="1" required="true" readonly  value="{{isset($insurance) ? $insurance->value_package : clear(Input::get('insurance'))}}"@include('form.readonly')>
                    @include('errors.field', ['field' => 'subtotal'])
                  </div>
                </div>



                <!--subtotal -->
                <div class="form-group row @include('errors.field-class', ['field' => 'subtotal'])" id="divsubtotal" >
                  <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.subtotal')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control"  placeholder="{{trans('package.subtotal')}}" id="subtotal" name="subtotal" type="float" maxlength="10" min="1" required="true" readonly value="{{isset($receipt) ? $receipt->subtotal : clear(Input::get('value'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'subtotal'])
                  </div>
                </div>

                <div class="form-group row @include('errors.field-class', ['field' => 'tax'])" id="taxdiv" >

                    <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.tax')}}</label>
                    <div class="col-lg-9">
                      <input class="form-control"  placeholder="{{trans('package.tax')}}" id="taxre" name="taxre" readonly  type="float" maxlength="10" min="1" required="true"  value="{{isset($tax->valuep) ? $tax->valuep : ''}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'value'])
                    </div>

                </div>

                <!--promotion-->
                <div class="form-group row @include('errors.field-class', ['field' => 'promotionval'])" id="divalpromotion"  >
                  <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.promotionselect')}}</label>
                  <div class="col-lg-9">
                     <input class="form-control"  placeholder="{{trans('package.notpromotionna')}}" id="promotionval" name="promotionval" type="float" maxlength="10" min="1" required="true" readonly value="{{isset($promotion->value_package) ? $promotion->value_package : clear(Input::get('value'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'promotionval'])
                  </div>
                </div>
                <!--total-->
                <div class="form-group row @include('errors.field-class', ['field' => 'total'])" id="divtotal" >
                  <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.total')}}</label>
                  <div class="col-lg-9">
                     <input class="form-control"  placeholder="{{trans('package.total')}}" id="total" name="total" type="float" maxlength="10" min="1" required="true" readonly value="{{isset($receipt) ? $receipt->total : clear(Input::get('total'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'total'])
                  </div>
                </div>
                <input type ="hidden" name="start_at" id="start_at" value="{{$start_at}}">
              </div>
              </div>
              @if(!isset($readonly) || !$readonly)
              <div class="col-lg-12 buttons"  id="divButton">
                <span id="ics_user_notify" class="text-muted"></span>
                <button onclick="icsNotifyUserSubmit()"  id="loginButton" type="submit" class="btn btn-primary pull-right">
                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                  {{trans(isset($package)?'messages.update' : 'messages.save')}}
                </button>
              </div>
            @endif
            </div>
          </div>

        </div>
      </div>
    </div>
  </fieldset>
</form>
