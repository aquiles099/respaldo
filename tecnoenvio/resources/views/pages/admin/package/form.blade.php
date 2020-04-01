@include('sections.translate')

<form onsubmit="icsNotifyUserSubmit()" role="form" action="{{asset($path)}}" method="post" novalidate enctype="multipart/form-data">
  <fieldset role="form">
    @if(isset($package))
      <input type="hidden" name="_method" value="patch">
    @endif
    <!--tabs-->
    <ul class="nav nav-tabs nav-justified">
      <li  class="active"><a data-toggle = "tab" href="#ics_tab_menu0">{{trans('package.packageinfo')}} <span><i class="fa fa-cube" aria-hidden="true"></i></span></a></li>
      <li><a data-toggle="tab" href="#ics_tab_menu1">{{trans('package.destinyinfo')}} <span><i class="fa fa-user" aria-hidden="true"></i></span></a></li>
      <li><a data-toggle="tab" href="#ics_tab_menu2">{{trans('package.paymentinfo')}} <span><i class="fa fa-usd" aria-hidden="true"></i></span></a></li>
    </ul>
    <!---->
    <input type ="hidden" name="start_at" id="start_at" value="{{$start_at}}">
    <!--content-->
    <div class="tab-content">
      <!---->
      <div id="ics_tab_menu0" class="tab-pane fade in active">
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-cube" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <!---->
            <div class="form-group row @include('errors.field-class', ['field' => 'large'])"  id="divlarge">
              <label class="col-lg-3 control-label" for="large">{{trans('package.large')}}</label>
              <div class="col-lg-9">
                <input type="number" class="form-control form_dimension" placeholder="{{trans('package.large')}} (inches)" id="large" name="large" onkeyup="pesovol()" type="float"  maxlength="10" min="1" required="true" value="{{isset($package) ? $package->large : clear(Input::get('large'))}}" @include('form.readonly')>
                <span>in</span>
              @include('errors.field', ['field' => 'large'])
              </div>
            </div>
            <!---->
            <div class="form-group row  @include('errors.field-class', ['field' => 'width'])" onkeyup="pesovol()" id="divwidth">
              <label class="col-lg-3 control-label" for="width">{{trans('package.width')}}</label>
              <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.width')}} (inches)" id="width" name="width" type="float" maxlength="10"  min="1" required="true" value="{{isset($package) ? $package->width : clear(Input::get('width'))}}" @include('form.readonly')>
                  <span>in</span>
              @include('errors.field', ['field' => 'width'])
              </div>
            </div>
            <!-- -->
            <div class="form-group row  @include('errors.field-class', ['field' => 'height'])" id="divheight" >
              <label class="col-lg-3 control-label" for="height">{{trans('package.width')}}</label>
              <div class="col-lg-9">
                <input type="number" class="form-control form_dimension" placeholder="{{trans('package.height')}} (inches)" id="height" onkeyup="pesovol()" name="height" type="float"  maxlength="10" min="1" required="true" value="{{isset($package) ? $package->height : clear(Input::get('height'))}}" @include('form.readonly')>
                <span>in</span>
                @include('errors.field', ['field' => 'height'])
              </div>
            </div>
            <!-- -->
            <div class="form-group row @include('errors.field-class', ['field' => 'weight'])" id="divweight" >
                <label class="col-lg-3 control-label" for="weight">{{trans('package.weight')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.weight')}}" id="weight"  name="weight" type="float" maxlength="10" min="1"   required="true" value="{{isset($package) ? $package->weight : clear(Input::get('weight'))}}" @include('form.readonly')>
                  <span>in</span>
                  @include('errors.field', ['field' => 'weight'])
                </div>
            </div>
            <!-- -->
            <div class="form-group row  @include('errors.field-class', ['field' => 'value'])" id="divvalue">
              <label class="col-lg-3 control-label" for="value">{{trans('package.value')}}</label>
              <div class="col-lg-9">
                <input type="number" class="form-control form_dimension" placeholder="{{trans('package.value')}}" id="value" name="value" style="display: inline;" type="float" maxlength="10" min="1" onkeyup="calcinsurance()" required="true" value="{{isset($package) ? $package->value : clear(Input::get('value'))}}" @include('form.readonly')>
                <span>$</span>
                  @include('errors.field', ['field' => 'value'])
              </div>
           </div>

           <div class="form-group row @include('errors.field-class', ['field' => 'volumetricweight'])" id="divtype" >
                <label class="col-lg-3 control-label" id="typeLabel" style="line-height: 18px!important;" >{{trans('package.volumem')}}</label>
                <div class="col-lg-9">
                       <input class="form-control form_dimension"  placeholder="{{trans('package.volumem')}}" id="volumetricweightm" name="volumetricweightm" type="float" maxlength="10" min="1" readonly required="true" value="{{isset($package) ? $package->volumetricweightm : clear(Input::get('value'))}}" @include('form.readonly')>
                        <span>ft<sup>3</sup></span>
                          @include('errors.field', ['field' => 'volumetricweightm'])
                </div>
            </div>

            <div class="form-group row @include('errors.field-class', ['field' => 'volumetricweight'])" id="divtype" >
                <label class="col-lg-3 control-label" id="typeLabel" style="line-height: 18px!important;" >{{trans('package.volumea')}}</label>
                <div class="col-lg-9">
                       <input class="form-control form_dimension"  placeholder="{{trans('package.volumea')}}" id="volumetricweighta" name="volumetricweighta" type="float" maxlength="10" min="1" readonly required="true" value="{{isset($package) ? $package->volumetricweighta : clear(Input::get('value'))}}" @include('form.readonly')>
                       <span>Vlb</span>
                          @include('errors.field', ['field' => 'volumetricweighta'])
                </div>
            </div>
          </div>
        </div>
      </div>
      <!---->
      <div id="ics_tab_menu1" class="tab-pane fade">
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-user" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
            <!-- Select de empresas -->
            <div class="form-group row @include('errors.field-class', ['field' => 'company'])" id="company">
              <label class="col-lg-3 control-label" id="companyLabel" >{{trans('package.company')}}</label>
              <div class="col-lg-9">
              <select class="form-control" id="companySelect" name="companySelect"  @include('form.readonly')>
                <option value="">{{trans('package.chooseCompany')}}</option>
                @foreach ($company as $companys)
                  <?php $option = $companys->toOption();?>
                    <option {{(isset($package->getToClient['company']) ? $package->getToClient['company'] : Input::get('company')) == $option['id'] ? 'selected' : ''}}  item="{{$companys->toInnerJson()}}" value="{{$option['id']}}">{{$option['text']}}</option>
                @endforeach
              </select>
              </div>
            </div>
            <!--Select de clientes -->
            <div class="form-group row @include('errors.field-class', ['field' => 'client'])" id="client">
              <label class="col-lg-3 control-label" id="clientLabel" >{{trans('package.clients')}} <span id="clientload" class="text-muted small"></span></label>
              <div class="col-lg-9">
                <select class="form-control" id="clientSelect" name="clientSelect"  @include('form.readonly') >
                 <option value="">{{trans('package.chooseClient')}}</option>
                  @if(isset($package->getToClient))
                    <option value="{{$package->to_client}}">{{$package->getToClient['code']." ".$package->getToClient['name']." ".$package->getToClient['email']}}</option>
                  @else
                    <option value="0">{{trans('package.chooseClient')}}</option>
                  @endif
                </select>
              </div>
            </div>
            <div class="" id="divcli">
              <!-- -->
              <div class="form-group row @include('errors.field-class', ['field' => 'name'])" id="clientName">
                <label class="col-lg-3 control-label" id="labelName" >{{trans('package.clientName')}}</label>
                <div class="col-lg-9">
                  <input class="form-control" placeholder="{{trans('package.clientName')}}" id="name" name="name" type="text" maxlength="25" min="5" required="true" value="{{isset($package) ? $package->getToClient['name'] : clear(Input::get('name'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'name'])
                </div>
              </div>
              <!-- -->
              <div class="form-group row @include('errors.field-class', ['field' => 'phone'])" id="clientPhone">
                <label class="col-lg-3 control-label" id="labelPhone" >{{trans('package.clientPhone')}}</label>
                <div class="col-lg-9">
                  <input class="form-control" placeholder="{{trans('package.clientPhone')}}" id="phone" name="phone" type="text" maxlength="25" min="5" required="true" value="{{isset($package) ? $package->getToClient['phone'] : clear(Input::get('phone'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'phone'])
                </div>
              </div>
              <!-- -->
              <div class="form-group row @include('errors.field-class', ['field' => 'email'])" id="clientEmail">
                <label class="col-lg-3 control-label" id="labelEmail" >{{trans('package.clientEmail')}}</label>
                <div class="col-lg-9">
                  <input class="form-control" placeholder="{{trans('package.clientEmail')}}" id="email" name="email" type="text" maxlength="50" min="5" required="true" value="{{isset($package) ? $package->getToClient['email'] : clear(Input::get('email'))}}"@include('form.readonly')>
                    @include('errors.field', ['field' => 'email'])
                </div>
              </div>
              <!-- -->
              <div class="form-group row @include('errors.field-class', ['field' => 'identifier'])" id="clientIdentifier">
                <label class="col-lg-3 control-label" id="labelIdentifier" >{{trans('package.clientIdentifier')}}</label>
                <div class="col-lg-9">
                  <input class="form-control" placeholder="{{trans('package.clientIdentifier')}}" id="identifier" name="identifier" type="text" maxlength="25" min="5" required="true" value="{{isset($package) ? $package->getToClient['identifier'] : clear(Input::get('identifier'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'identifier'])
                </div>
              </div>
              <!-- -->
              <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection">
                <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.clientDirection')}}</label>
                <div class="col-lg-9">
                  <input class="form-control" placeholder="{{trans('package.clientDirection')}}" id="direction" name="direction" type="text" maxlength="250" min="5" required="true" value="{{isset($package) ? $package->getToClient['direction'] : clear(Input::get('direction'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'direction'])
                </div>
              </div>
              <!-- -->
              <div class="form-group row @include('errors.field-class', ['field' => 'observation'])" id="divObservation">
                <label class="col-lg-3 control-label" id="labelObservation" >{{trans('package.observation')}}</label>
                <div class="col-lg-9">
                  <input class="form-control" placeholder="{{trans('package.observation')}}" id="observation" name="observation" type="text" maxlength="250" min="5" value="{{isset($package) ? $package->observation : clear(Input::get('observation'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'observation'])
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!---->
      <div id="ics_tab_menu2" class="tab-pane fade">
        <div class="panel panel-default">
          <div class="panel-heading text-muted">
            <span><i class="fa fa-usd" aria-hidden="true"></i></span>
          </div>
          <div class="panel-body">
              <div class="row">
                <!---->
                <div class="col-lg-6">
                  <!---->
                  <div class="form-group row @include('errors.field-class', ['field' => 'type'])"  >
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

                  <!--Tipo de Transporte -->
                  <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="idtype" >
                    <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.type')}}</label>
                    <div class="col-lg-9">
                      <select class="form-control" id="typeservice" name="typeservice" required="true" @include('form.readonly')>
                      <option value="">{{trans('package.notservice')}}</option>
                      @if($tytransport!='')
                          @foreach ($tytransport as $transport)
                            <?php $option = $transport->toOption();?>
                            <option {{(isset($package) ? $package->type : Input::get('type')) == $option['id'] ? 'selected' : ''}} item="{{$transport}}" cost="{{$option['price']}}" value="{{$option['id']}}">{{$option['text']}} {{$option['price']}}($)</option>
                          @endforeach
                      @endif
                      </select>
                      @include('errors.field', ['field' => 'type|'])
                    </div>
                  </div>
                  <!---->

                  <div class="form-group row @include('errors.field-class', ['field' => 'insurance'])" style="display:block;">
                    <label class="col-lg-3 control-label" id="servicelabel" >{{trans('package.taxx')}}</label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="{{trans('package.taxx')}}" id="taxval" onkeyup="calctax()" name="taxval" type="text" maxlength="5"   value="{{isset($insurance) ? $insurance->value_oring : clear(Input::get('insurance'))}}">
                      @include('errors.field', ['field' => 'tracking'])
                    @include('errors.field', ['field' => 'insurance'])
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



                          <option item="{{$addcharges}}" cost="{{$addcharges->value}}"  value="{{$addcharges->id}}" >{{$addcharges->name}}-{{$addcharges->value}}$</option>
                       @endforeach
                      </select>
                      @include('errors.field', ['field' => 'office'])
                    </div>
                  </div>
                  <!---->

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
                  <div class="form-group row @include('errors.field-class', ['field' => 'category'])" id="categoryDiv">
                    <label class="col-lg-3 control-label" id="categoryLabel" >{{trans('package.category')}}</label>
                    <div class="col-lg-9">
                      <select class="form-control" id="category" name="category" required="true" @include('form.readonly')>
                          @foreach ($category as $cat)
                            <?php $option = $cat->toOption();?>
                            <option {{(isset($package) ? $package->category : Input::get('category')) == $option['id'] ? 'selected' : ''}} item="{{$cat->toInnerJson()}}"  porcent="{{$option['percent']}}" value="{{$option['id']}}" cost="{{$option['percent']}}">{{$option['text']}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                  <!-- -->
                  <div class="form-group row @include('errors.field-class', ['field' => 'invoice'])" id="invoice">
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
                     <input type="file" name="fileinvoice" id="fileinvoice" accept=".pdf, image/*" value="{{ Input::get('file') }}" required=true >
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
                            <option {{(isset($package) ? $package->type : Input::get('type')) == $option['id'] ? 'selected' : ''}} item="{{$transport->toInnerJson()}}" value="{{$option['id']}}">{{$option['text']}}</option>
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
                            <option {{(isset($promotion) ? $promotion->id_complemento : Input::get('type')) == $option['id'] ? 'selected' : ''}}  item="{{$promo}}" value="{{$option['id']}}" reduction="{{$option['reduction']}}">{{$option['text']}}</option>
                          @endforeach
                      </select>
                      <span class="text-muted">{{trans('messages.optional')}}</span>
                    </div>
                  </div>
                </div>
                <!--isset($package) && $package->type == 1 ? $package->volumetricweightm.' ft3' : isset($package) && $package->type == 2 ? $package->volumetricweighta.' Vlb' :''-->
                <div class="col-lg-6">
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
                  <label class="col-lg-3 control-label" id="invoiceLabel" style="line-height: 15px;">{{trans('package.costinsurence')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control"  placeholder="{{trans('package.costinsurence')}}" id="costinsu" name="costinsu" type="float" maxlength="10" min="1" required="true" readonly  value="{{isset($insurance) ? $insurance->value_package : clear(Input::get('insurance'))}}"@include('form.readonly')>
                    @include('errors.field', ['field' => 'subtotal'])
                  </div>
                </div>
                <!-- -->
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
                     <input class="form-control"  placeholder="{{trans('package.notpromotionna')}}" id="promotionval" name="promotionval" type="float" maxlength="10" min="1" required="true" readonly value="{{isset($promotion) ? $promotion->value_package : clear(Input::get('value'))}}" @include('form.readonly')>
                          @include('errors.field', ['field' => 'promotionval'])
                  </div>
                </div>
                  <!---->
                  <div class="form-group row @include('errors.field-class', ['field' => 'invoice'])" id="invoice" >
                    <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.total')}}</label>
                    <div class="col-lg-9">
                       <input class="form-control"  placeholder="{{trans('package.total')}}" id="total" name="total" type="float" maxlength="10" min="1" required="true" readonly value="{{isset($package) ? $package->value : clear(Input::get('value'))}}" @include('form.readonly')>
                        @include('errors.field', ['field' => 'value'])
                    </div>
                  </div>
                </div>
                </div>
              </div>
          </div>
          <!-- Change this to a button or input when using this as a form -->
        @if(!isset($readonly) || !$readonly)
          <div class="col-lg-12 buttons" style="display:none;" id="divButton">
            <button type="submit" class="btn btn-primary pull-right">
            <i class="fa fa-floppy-o" aria-hidden="true"></i>
              {{trans(isset($package)?'messages.update' : 'messages.save')}}
            </button>
          </div>
        @endif
        </div>
      </div>
    </div>
  </fieldset>
</form>
