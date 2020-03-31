<div class="panel panel-default" id="pnlft">
<form class="form" action="" method="post" id="formSerial">
  @if(isset($numberparts))
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
  @endif
  <div class="panel-body">
   <fieldset class="form">

    <div class="row">
      <div class="col-md-8">
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.name')}}" name="name" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->name : clear(Input::get('name'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>

        <!---->
        <div class="form-group row @include('errors.field-class', ['field' => 'description'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.description')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.description')}}" name="description" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->description : clear(Input::get('description'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'description'])
          </div>
        </div>

        <!---->
        <div class="form-group row @include('errors.field-class', ['field' => 'customer'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.customer')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.customer')}}" name="customer" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->customer : clear(Input::get('customer'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'customer'])
          </div>
        </div>

        <div class="form-group row @include('errors.field-class', ['field' => 'manufacturer'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.manufacturer')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.manufacturer')}}" name="manufacturer" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->manufacturer : clear(Input::get('manufacturer'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'manufacturer'])
          </div>
        </div>

        <div class="form-group row @include('errors.field-class', ['field' => 'model'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.model')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.model')}}" name="model" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->model : clear(Input::get('model'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'manufacturer'])
          </div>
        </div>

        <div class="form-group row @include('errors.field-class', ['field' => 'package'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.package')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.package')}}" name="package" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->package : clear(Input::get('package'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'package'])
          </div>
        </div>

        <div class="form-group row @include('errors.field-class', ['field' => 'pieces'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.pieces')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.pieces')}}" name="pieces" type="number" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->pieces : clear(Input::get('pieces'))}}" @include('form.readonly')>
              @include('errors.field', ['field' => 'pieces'])
          </div>
        </div>

        <div class="form-group row @include('errors.field-class', ['field' => 'sku'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.sku')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.sku')}}" name="sku" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->sku : clear(Input::get('sku'))}}" @include('form.readonly')>
                @include('errors.field', ['field' => 'sku'])
          </div>
        </div>

        <div class="form-group row @include('errors.field-class', ['field' => 'note'])">
          <label class="col-lg-3 control-label">{{trans('numberparts.note')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('numberparts.note')}}" name="note" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($numberparts) ? $numberparts->note : clear(Input::get('note'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'note'])
          </div>
        </div>



      </div>

      <div class="col-md-4">
        <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'large'])"  id="divlarge" >
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.large')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.large')}}" id="large" name="large" onkeyup="pesovol()" type="float" maxlength="10" min="1" required="true" value="{{isset($numberparts) ? $numberparts->large : clear(Input::get('large'))}}" @include('form.readonly')>
                  <span>in</span>
                  @include('errors.field', ['field' => 'large'])
                </div>  
              </div>

              <div class="dimensmedidas  @include('errors.field-class', ['field' => 'width'])" onkeyup="pesovol()" id="divwidth">
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.width')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.width')}}" id="width" name="width" type="float" maxlength="10" min="1" required="true" value="{{isset($numberparts) ? $numberparts->width : clear(Input::get('width'))}}" @include('form.readonly')>
                  <span>in</span>
                  @include('errors.field', ['field' => 'width'])
               </div>
              </div>
        
              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.height')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.height')}}" id="height" onkeyup="pesovol()" name="height" type="float" maxlength="10" min="1" required="true" value="{{isset($numberparts) ? $numberparts->height : clear(Input::get('height'))}}" 
                  @include('form.readonly')>
                  <span>in</span>
                  @include('errors.field', ['field' => 'height'])
                </div>
              </div>

              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.volumem')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.volumem')}}" id="volumetricweightm" onkeyup="pesovol()" name="volumetricweightm" type="float" readonly="" maxlength="10" min="1" required="true" value="{{isset($numberparts) ? $numberparts->volumetricweightm : clear(Input::get('volumetricweightm'))}}" @include('form.readonly')>
                  <span>ft<sup>3</sup></span>
                  @include('errors.field', ['field' => 'volumetricweight'])
                </div>
              </div>


              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                <label class="col-lg-3 control-label" id="typeLabel" >{{trans('package.volumea')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.volumea')}}" id="volumetricweighta" onkeyup="pesovol()" name="volumetricweighta" type="float" readonly="" maxlength="10" min="1" required="true" value="{{isset($numberparts) ? $numberparts->volumetricweighta : clear(Input::get('volumetricweighta'))}}" @include('form.readonly')>
                  <span>Vlb</span>
                  @include('errors.field', ['field' => 'volumetricweight'])
                </div>
              </div>

              <div class=" dimensmedidas  @include('errors.field-class', ['field' => 'height'])" id="divheight">
                <label class="col-lg-3 control-label " id="typeLabel" >{{trans('package.weight')}}</label>
                <div class="col-lg-9">
                  <input type="number" class="form-control form_dimension" placeholder="{{trans('package.weight')}}" id="weight" onkeyup="pesovol()" name="weight" type="float" maxlength="10" min="1" required="true" value="{{isset($numberparts) ? $numberparts->weight : clear(Input::get('weight'))}}" @include('form.readonly')>
                  <span>lb</span>
                  @include('errors.field', ['field' => 'weight'])
                </div>
              </div>

      </div>
    </div>
    

   
  
  </fieldset>
  </div>