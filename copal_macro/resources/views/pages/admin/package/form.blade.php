<form role="form" action="{{asset($path)}}" method="post" onsubmit="createLoad()" novalidate enctype="multipart/form-data">
  @if(isset($package))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">

    <!-- Select de empresas -->
    <div class="form-group row @include('errors.field-class', ['field' => 'company'])" id="company" style="display:block;"}}>
      <label class="col-lg-3 control-label" id="companyLabel" >{{trans('package.company')}}</label>
      <div class="col-lg-9">
      <select class="form-control" id="companySelect" name="companySelect"  @include('form.readonly') >
        <option value="0">{{trans('package.chooseCompany')}}</option>
        @foreach ($company as $companys)
          <?php $option = $companys->toOption();?>
          <option item="{{$companys->toInnerJson()}}" value="{{$option['id']}}">{{$option['text']}}</option>
        @endforeach
      </select>
      </div>
    </div>
    <!--Select de clientes -->
    <div class="form-group row @include('errors.field-class', ['field' => 'client'])" id="client" style="display:none;"}}>
      <label class="col-lg-3 control-label" id="clientLabel" >{{trans('package.clients')}} <span id="clientload" class="text-muted small"></span></label>
      <div class="col-lg-9">
      <select class="form-control" id="clientSelect" name="clientSelect"  @include('form.readonly') >
        <option value="0">{{trans('package.chooseClient')}}</option>
      </select>
      </div>
    </div>
    <!--  -->
    <div class="col-md-6"  id="divcli" style="display:none;">

      <h3 class="page-header" id="clientTitle" style="display:none;">
        <div class="pull-center">{{trans('package.clientInfo')}}</div>
      </h3>
      <!-- -->

      <div class="form-group row @include('errors.field-class', ['field' => 'name'])" id="clientName" style="display:none;">
        <label class="col-lg-3 control-label" id="labelName" >{{trans('package.clientName')}}</label>
        <div class="col-lg-9">
          <input class="form-control" placeholder="{{trans('package.clientName')}}" id="name" name="name" type="text" maxlength="25" min="5" required="true" value="{{isset($package) ? $package->getClient['name'] : clear(Input::get('name'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
        </div>
      </div>
      <!-- -->
      <div class="form-group row @include('errors.field-class', ['field' => 'phone'])" id="clientPhone" style="display:none;">
        <label class="col-lg-3 control-label" id="labelPhone" >{{trans('package.clientPhone')}}</label>
        <div class="col-lg-9">
          <input class="form-control" placeholder="{{trans('package.clientPhone')}}" id="phone" name="phone" type="text" maxlength="25" min="5" required="true" value="{{isset($package) ? $package->getClient['phone'] : clear(Input::get('phone'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'phone'])
        </div>
      </div>
      <!-- -->
      <div class="form-group row @include('errors.field-class', ['field' => 'email'])" id="clientEmail" style="display:none;">
        <label class="col-lg-3 control-label" id="labelEmail" >{{trans('package.clientEmail')}}</label>
        <div class="col-lg-9">
          <input class="form-control" placeholder="{{trans('package.clientEmail')}}" id="email" name="email" type="text" maxlength="50" min="5" required="true" value="{{isset($package) ? $package->getClient['email'] : clear(Input::get('email'))}}"@include('form.readonly')>
            @include('errors.field', ['field' => 'email'])
        </div>
      </div>
      <!-- -->
      <div class="form-group row @include('errors.field-class', ['field' => 'identifier'])" id="clientIdentifier" style="display:none;">
        <label class="col-lg-3 control-label" id="labelIdentifier" >{{trans('package.clientIdentifier')}}</label>
        <div class="col-lg-9">
          <input class="form-control" placeholder="{{trans('package.clientIdentifier')}}" id="identifier" name="identifier" type="text" maxlength="25" min="5" required="true" value="{{isset($package) ? $package->getClient['identifier'] : clear(Input::get('identifier'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'identifier'])
        </div>
      </div>
      <!-- -->
      <div class="form-group row @include('errors.field-class', ['field' => 'direction'])" id="clientDirection" style="display:none;">
        <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.clientDirection')}}</label>
        <div class="col-lg-9">
          <input class="form-control" placeholder="{{trans('package.clientDirection')}}" id="direction" name="direction" type="text" maxlength="250" min="5" required="true" value="{{isset($package) ? $package->getClient['direction'] : clear(Input::get('direction'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'direction'])
        </div>
      </div>

        <div class="form-group row @include('errors.field-class', ['field' => 'observation'])" id="divObservation" style="display:none;">
        <label class="col-lg-3 control-label" id="labelObservation" >{{trans('package.observation')}}</label>
        <div class="col-lg-9">
          <input class="form-control" placeholder="{{trans('package.observation')}}" id="observation" name="observation" type="text" maxlength="250" min="5" value="{{isset($package) ? $package->observation : clear(Input::get('observation'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'observation'])
        </div>
      </div>

    </div>





     <div class="col-md-12">
      <h3 class="page-header" id="packageTitle" style="display:none;">
        <div class="pull-center">{{trans('package.packageInfo')}}</div>
      </h3>
      <div class="col-md-12">
      <!-- -->
          <div class="row" id="divTracking">
          <div class="col-md-4 row @include('errors.field-class', ['field' => 'tracking'])" id="divTracking" style="display:none;">

              <div class="row"> <h4> {{trans('package.tracking')}}</h4> </div>
              <input class="form-control" placeholder="{{trans('package.tracking')}}" id="tracking" name="tracking" type="text" maxlength="25" min="10" required="true" value="{{isset($package) ? $package->tracking : clear(Input::get('tracking'))}}" @include('form.readonly',['forceReadonly' => isset($package)])>
                @include('errors.field', ['field' => 'tracking'])

          </div>
          </div>
          <!-- -->

          <div class="col-md-6" id="divdimens" style="display:none;padding-right: 22px;padding-left: 0px;">
          <div class="row"><h4> {{trans('package.dimens')}}</h4></div>

            <div class="col-md-4 dimensmedidas @include('errors.field-class', ['field' => 'large'])"  id="divlarge" >

                <input type="number" class="form-control" placeholder="{{trans('package.large')}}" id="large" name="large" onkeyup="pesovol()" type="float" maxlength="10" min="1" required="true" value="{{isset($package) ? $package->large : clear(Input::get('large'))}}" @include('form.readonly')>
                  @include('errors.field', ['field' => 'large'])

            </div>

            <div class="col-md-4 dimensmedidas @include('errors.field-class', ['field' => 'width'])" onkeyup="pesovol()" id="divwidth">


                <input type="number" class="form-control" placeholder="{{trans('package.width')}}" id="width" name="width" type="float" maxlength="10" min="1" required="true" value="{{isset($package) ? $package->width : clear(Input::get('width'))}}" @include('form.readonly')>
                  @include('errors.field', ['field' => 'width'])

            </div>
            <!-- -->
            <div class="col-md-4 dimensmedidas @include('errors.field-class', ['field' => 'height'])" id="divheight">


                <input type="number" class="form-control" placeholder="{{trans('package.height')}}" id="height" onkeyup="pesovol()" name="height" type="float" maxlength="10" min="1" required="true" value="{{isset($package) ? $package->height : clear(Input::get('height'))}}" @include('form.readonly')>
                  @include('errors.field', ['field' => 'height'])

            </div>
            <!-- -->

          </div>

          <div class="col-md-3 dimensmedidas @include('errors.field-class', ['field' => 'weight'])" id="divweight" style="display:none;">
              <div class="row"><h4> {{trans('package.weight')}}</h4></div>
                 <input type="number" class="form-control" placeholder="{{trans('package.weight')}}" id="weight"  name="weight" type="float" maxlength="10" min="1" required="true" value="{{isset($package) ? $package->weight : clear(Input::get('weight'))}}" @include('form.readonly')>
                  @include('errors.field', ['field' => 'weight'])

            </div>

            <div class="col-md-3 dimensmedidas @include('errors.field-class', ['field' => 'value'])" id="divvalue" style="display:none;padding-right: 22px;padding-left: 0px;">

            <div class="row"><h4> {{trans('package.value')}}</h4></div>
              <input type="number" class="form-control" placeholder="{{trans('package.value')}}" id="value" name="value" onkeyup="taxcalculation()" type="float" maxlength="10" min="1" required="true" value="{{isset($package) ? $package->value : clear(Input::get('value'))}}" @include('form.readonly')>
                @include('errors.field', ['field' => 'value'])

          </div>


          <!-- -->


        </div>
      <!-- -->

  <div class="col-md-6" id="divdimens" style="display:none;">
      <div class="form-group row @include('errors.field-class', ['field' => 'type'])" id="type" >
        <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.type')}}</label>
        <div class="col-lg-9">
          <select class="form-control" id="type" name="type" required="true" @include('form.readonly')>
          <option value="0" cost="0">{{trans('package.nottype')}}</option>
              @foreach ($transports as $transport)
                <?php $option = $transport->toOption();?>
                <option {{(isset($package) ? $package->type : Input::get('type')) == $option['id'] ? 'selected' : ''}} item="{{$transport->toInnerJson()}}" value="{{$option['id']}}" cost="{{$option['price']}}">{{$option['text']}} {{$option['price']}}($)</option>
              @endforeach
          </select>
          @include('errors.field', ['field' => 'type|'])
        </div>
      </div>
      <!-- -->
      <div class="form-group row @include('errors.field-class', ['field' => 'category'])" id="categoryDiv" style="display:none;">
        <label class="col-lg-3 control-label" id="categoryLabel" >{{trans('package.category')}}</label>
        <div class="col-lg-9">
          <select class="form-control" id="category" name="category" required="true" @include('form.readonly')>
              @foreach ($category as $cat)
                <?php $option = $cat->toOption();?>
                <option {{(isset($package) ? $package->category : Input::get('category')) == $option['id'] ? 'selected' : ''}} item="{{$cat->toInnerJson()}}"  porcent="{{$option['percent']}}" value="{{$option['id']}}" cost="{{$option['percent']}}">{{$option['text']}} {{$option['percent']}}(%)</option>
              @endforeach
          </select>
        </div>
      </div>
      <!-- -->
      <div class="form-group row @include('errors.field-class', ['field' => 'invoice'])" id="invoice" style="display:none;">
        <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.invoice')}}</label>
        <div class="col-lg-9">
          <select class="form-control" id="invoice" name="invoice" required="true" @include('form.readonly')>
              {{--se comenta el codigo php para que se inicalice el select como 'sin factura'--}}
              <option {{--(isset($package) ? $package->invoice : 0) == 0 ? 'selected' : ''--}} value=0>{{trans('package.withOutInvoice')}}</option>
              <option {{--(isset($package) ? $package->invoice : 1) == 1 ? 'selected' : ''--}} value=1>{{trans('package.withInvoice')}}</option>
          </select>
        </div>
      </div>


       <div class="form-group row @include('errors.field-class', ['field' => 'id_package'])" id="uploadinvoice" style="padding-left: 30%;display:none">

          <input type="file" name="fileinvoice" id="fileinvoice" accept=".pdf, image/*" value="{{ Input::get('file') }}" required=true >
                @include('sections.errors', ['errors' =>  $errors, 'name' => 'id_package'])
       </div>

      <!-- -->
      <div class="form-group row @include('errors.field-class', ['field' => 'consolidate'])" id="consolidate" style="display:block;">
        <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.consolidated')}}</label>
        <div class="col-lg-9">
         <select class="form-control" id="consolidated" name="consolidated" required="true" @include('form.readonly')>
         <option value="0">{{trans('package.notconsolidated')}}</option>
              @foreach ($consolidated as $consol)
                <?php $option = $consol->toOption();?>
                <option {{(isset($package) ? $package->type : Input::get('type')) == $option['id'] ? 'selected' : ''}} item="{{$transport->toInnerJson()}}" value="{{$option['id']}}">{{$option['text']}}</option>
              @endforeach
          </select>
          <span style="color:grey;">(En caso que Aplique)</span>
        </div>
      </div>

      <!---->

      <div class="form-group row @include('errors.field-class', ['field' => 'consolidate'])" id="consolidate" style="display:block;">
        <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.promotion')}}</label>
        <div class="col-lg-9">
         <select class="form-control" id="promotion" name="promotion" required="true" @include('form.readonly')>
         <option value="0">{{trans('package.notpromotion')}}</option>
              @foreach ($promotions as $promotion)
                <?php $option = $promotion->toOption();?>
                <option {{(isset($package) ? $package->type : Input::get('type')) == $option['id'] ? 'selected' : ''}} item="{{$transport->toInnerJson()}}" value="{{$option['id']}}" reduction="{{$option['reduction']}}">{{$option['text']}}</option>
              @endforeach
          </select>
          <span style="color:grey;">(En caso que Aplique)</span>
        </div>
      </div>
    </div>

    <div class="col-md-6" >
      <div class="form-group row @include('errors.field-class', ['field' => 'volumetricweight'])" id="type" style="display:none;">
        <label class="col-lg-3 control-label" id="typeLabel" style="line-height: 18px!important;" >{{trans('package.volumetricweight')}}</label>
        <div class="col-lg-9">
               <input class="form-control"  placeholder="{{trans('package.volumetricweight')}}" id="volumetricweight" name="volumetricweight" type="float" maxlength="10" min="1" readonly required="true" value="{{isset($package) ? $package->value : clear(Input::get('value'))}}" @include('form.readonly')>
                @include('errors.field', ['field' => 'value'])
        </div>
      </div>
      <!-- -->
      <div class="form-group row @include('errors.field-class', ['field' => 'tax'])" id="taxdiv" style="display:none;">

        @foreach ($tax as $taxs)
                <?php $option = $taxs->toOption();?>
                <label class="col-lg-3 control-label" id="invoiceLabel" >{{$option['text']}}</label>
                <div class="col-lg-9">
                  <input class="form-control"  placeholder="{{$option['text']}}" attr-mivalue="{{$option['tax']}}" id="{{'tax'.$option['id']}}" name="{{'tax'.$option['id']}}" readonly  type="float" maxlength="10" min="1" required="true" value="" @include('form.readonly')>
                @include('errors.field', ['field' => 'value'])
                </div>
        @endforeach

      </div>
      <!-- -->
      <div class="form-group row @include('errors.field-class', ['field' => 'invoice'])" id="invoice" style="display:none;">
        <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.subtotal')}}</label>
        <div class="col-lg-9">
           <input class="form-control"  placeholder="{{trans('package.subtotal')}}" id="subtotal" name="subtotal" type="float" maxlength="10" min="1" required="true" readonly value="{{isset($package) ? $package->value : clear(Input::get('value'))}}" @include('form.readonly')>
                @include('errors.field', ['field' => 'value'])
        </div>
      </div>

       <!--Promotion-->
      <div class="form-group row @include('errors.field-class', ['field' => 'invoice'])" id="divalpromotion"  >
        <label class="col-lg-3 control-label" id="invoiceLabel" style="line-height: 14px;" >{{trans('package.promotionselect')}}</label>
        <div class="col-lg-9">
           <input class="form-control"  placeholder="{{trans('package.notpromotionna')}}" id="promotionval" name="promotionval" type="float" maxlength="10" min="1" required="true" readonly value="{{isset($package) ? $package->value : clear(Input::get('value'))}}" @include('form.readonly')>
                @include('errors.field', ['field' => 'value'])
        </div>
      </div>

      <!--Total-->
      <div class="form-group row @include('errors.field-class', ['field' => 'invoice'])" id="invoice" >
        <label class="col-lg-3 control-label" id="invoiceLabel" >{{trans('package.total')}}</label>
        <div class="col-lg-9">
           <input class="form-control"  placeholder="{{trans('package.total')}}" id="total" name="total" type="float" maxlength="10" min="1" required="true" readonly value="{{isset($package) ? $package->value : clear(Input::get('value'))}}" @include('form.readonly')>
                @include('errors.field', ['field' => 'value'])
        </div>
      </div>


    </div>




    </div>
    <!--  -->

    <!-- -->
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons" style="display:none;" id="divButton">
        <button type="submit" class="btn btn-primary pull-right">
        <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($package)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
