<?php $lang = App::getLocale(); ?>
<div class="row">
	<div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped">
            <tr>
              <td><b>{{trans('package.tracking')}}:</b></td>
              <td>{{isset($package) ? $package->code : Input::get('code')}}</td>
            </tr>
            <tr>
              <td><b>{{trans('package.from')}}:</b></td>
              <td>{{isset($package) ? (isset($package->to_client) ? ucwords($company->name) : ucwords($package->getCourier['name'])) : ''}}</td>
            </tr>
            <tr>
              <td><b>{{trans('package.to')}}:</b></td>
              <td>{{isset($package) ? (isset($package->to_client) ?  $package->getToClient['code']."-".$package->getToClient['name'] : $package->getToUser['code']."-".$package->getToUser['name']." ".$package->getToUser['last_name']) : ''}}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <!--Segundo cuadro, se muestra tipo, categoria y estado -->
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped">
            <tr>
              <td><b>{{trans('package.type')}}:</b></td>
              <td>{{isset($package) ? ($lang == 'es') ? ucwords($package->getType['spanish']) : ucwords($package->getType['english']) : Input::get('type')}}</td>
            </tr>
            <tr>
              <td><b>{{trans('package.category')}}:</b></td>
              <td>{{isset($package) ? ucfirst($package->getCategory['label']) : Input::get('category')}}</td>
            </tr>
            <tr>
              <td><b>{{trans('package.status')}}:</b></td>
              <td>{{isset($package) ? ucfirst($package->getLastEvent['description']) : Input::get('last_event')}}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>

</div>

<div class="row">
	<div class="col-md-6">
	 	<div class="panel panel-default" style="margin-bottom: 0px;">
	 	 	<div class="panel-heading">
	          	<h3 class="text-center" id="clientTitle" style="display:block;text-decoration: underline;">
	          		{{trans('package.receipt_description')}}
	          	</h3>
        	</div>
	    	<div class="panel-body" style="padding: 2px;background-color:#eee">
	       	<div class="col-md-12" style="padding: 20px;" >
	       		<p>{{trans('package.serviceOrder')}}:<strong>{{isset($package) ? $package->code : Input::get('code')}}</strong></p>
            <p>{{trans('package.value')}}: <strong>{{isset($package) ? $package->value : Input::get('value')}} $.</strong> </p>
            <p>{{trans('package.volumetricweight')}}:<strong>{{isset($volumen) ? $volumen : Input::get('volumetricweight')}} {{$package->type == 1 ? ((isset($package) && ($package->unidad == 1))? 'cm3' : 'ft3') : ((isset($package) && ($package->unidad == 1))? 'Vkg' : 'Vlb')}} </strong></p>
            <p>{{trans('package.large')}}: <strong>{{isset($large) ? $large : Input::get('large')}} {{(isset($package) && ($package->unidad == 1))? 'cm' : 'in'}}</strong></p>
	       		<p>{{trans('package.width')}}: <strong>{{isset($width) ? $width : Input::get('width')}} {{(isset($package) && ($package->unidad == 1))? 'cm' : 'in'}}</strong></p>
            <p>{{trans('package.height')}}: <strong>{{isset($height) ? $height : Input::get('height')}} {{(isset($package) && ($package->unidad == 1))? 'cm' : 'in'}}</strong></p>
            <p>{{trans('package.weight')}}: <strong>{{isset($weight) ? $weight : Input::get('weight')}} {{(isset($package) && ($package->unidad == 1))? 'kg' : 'lb'}}.</strong> </p>
	       	</div>
	 		</div>
	 	</div>
 	</div>


	<div class="col-md-6">
      <div class="panel panel-default" style="margin-bottom: 0px;">
      <div class="panel-heading">
              <h3 class="text-center" id="clientTitle" style="display:block;text-decoration: underline;">
                {{trans('package.receipt_detail')}}
              </h3>
          </div>
    <div class="panel-body" style="padding: 2px;background-color:#eee">
		<div class="col-md-8" style="text-align: right;border-right: 1px solid grey;   border-left: 1px solid #eee;">
			@if(isset($detailsreceipt))
                @foreach ($detailsreceipt as $row)
                   <p> {{$row->name}}({{$row->value_oring}}%)</p>
                   @endforeach
              @endif
		</div>
		<div class="col-md-4" style="border-right: 1px solid #eee;">
			@if(isset($detailsreceipt))
                @foreach ($detailsreceipt as $row)
                   <p> +{{$row->value_package}}</p>
                   @endforeach
              @endif
		</div>

     <div class="col-md-8" style="text-align: right;border-right: 1px solid grey;   border-left: 1px solid #eee;">
      <p style="font-weight: bold;">Subtotal:</p>
    </div>
    <div class="col-md-4" style="border-right: 1px solid #eee;">
      <p style="font-weight: bold;">{{$receipt->subtotal}}$</p>
    </div>

    <div class="col-md-8" style="text-align: right;border-right: 1px solid grey;   border-left: 1px solid #eee;">
      <p>{{trans('package.promotion')}}:</p>
    </div>
    <div class="col-md-4" style="border-right: 1px solid #eee;">
      <p>-{{isset($promo->value_package) ? $promo->value_package :'0'}}$</p>
    </div>

    <div class="col-md-12">
    <div class="panel panel-default">

        <div class="panel-body" style="padding: 4px;background-color:#f5f5f5">
            <div class="col-md-8" ><h4 style="text-align: right;font-weight: 900;">Total</h4></div>
            <div class="col-md-4">
              @if(isset($receipt))
                <h4 style="text-align: left;font-weight: 900;">{{$receipt->total}}$</h4>
          @endif
            </div>
      </div>
    </div>
  </div>
	</div>
  </div>




</div>
