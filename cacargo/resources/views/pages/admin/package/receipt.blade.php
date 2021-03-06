@include('sections.translate')
<div class="row">
	<div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped">
            <tr>
              <td><b>{{trans('package.code')}}:</b></td>
              <td>{{isset($package) ? $package->code : Input::get('code')}}</td>
            </tr>
            <tr>
              <tr>
              <td><b>{{trans('package.tracking')}}:</b></td>
              <td>{{isset($package->tracking) ? $package->tracking : Input::get('code')}}</td>
            </tr>
            <tr>
              <td><b>{{trans('package.from')}}:</b></td>
              <td>{{isset($package) ? (isset($package->to_client) ? $company->name : $package->getCourier['name']) : ''}}</td>
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
              <td>{{isset($package) ? $package->getType['spanish'] : Input::get('type')}}</td>
            </tr>
            <!-- <tr>
              <td><b>{{trans('package.category')}}:</b></td>
              <td>{{isset($package) ? $package->getCategory['label'] : Input::get('category')}}</td>
            </tr> -->
            <tr>
              <td><b>{{trans('package.status')}}:</b></td>
              <td>{{isset($package) ? $package->getLastEvent['description'] : Input::get('last_event')}}</td>
            </tr>
             <tr>
              <td><b>{{trans('package.receipt')}}:</b></td>
              <td>{{isset($receipt) ? $receipt->code : Input::get('last_event')}}</td>
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
	          		{{trans('messages.description_pack')}}
	          	</h3>
        	</div>
	    	<div class="panel-body" style="padding: 2px;background-color:#eee">
	       		<div class="col-md-12" style="padding: 20px;" >
	       			<p>{{trans('messages.tracking')}}:<strong>{{isset($package) ? $package->code : Input::get('code')}}</strong></p>
              <p>{{trans('messages.value')}}: <strong>{{isset($package) ? $package->value : Input::get('value')}} $.</strong> </p>
              <p>{{trans('package.volumetricweight')}}:<strong>

                @if(isset($package->type) && ($package->type==1))
                   {{ $package->volumetricweightm.' ft3'}}
                @elseif(isset($package->type) && ($package->type==2))
                    {{$package->volumetricweighta."vlb"}}
                @endif


               </strong></p>
              <p>{{trans('messages.large')}}: <strong>{{isset($package) ? $package->large : Input::get('large')}} in</strong></p>
	       			<p >{{trans('messages.width')}}: <strong>{{isset($package) ? $package->width : Input::get('width')}} in</strong></p>
              <p>{{trans('messages.height')}}: <strong>{{isset($package) ? $package->height : Input::get('height')}} in</strong></p>
              <p>{{trans('messages.weight')}}: <strong>{{isset($package) ? $package->weight : Input::get('weight')}} lb.</strong> </p>


	       		</div>

	 		</div>
	 	</div>
 	</div>


	<div class="col-md-6">
      <div class="panel panel-default" style="margin-bottom: 0px;">
      <div class="panel-heading">
              <h3 class="text-center" id="clientTitle" style="display:block;text-decoration: underline;">
                {{trans('messages.receipt_detail')}}
              </h3>
          </div>
    <div class="panel-body" style="padding: 2px;background-color:#eee">

    <div class="col-md-8" style="text-align: right;border-right: 1px solid grey;   border-left: 1px solid #eee;">
      <p>{{trans('package.service')}}:</p>
    </div>
    <div class="col-md-4" style="border-right: 1px solid #eee;">
      <p>{{isset($detailtype->value_package) ? $detailtype->value_package :'0'}}$</p>
    </div>

    <div class="col-md-8" style="text-align: right;border-right: 1px solid grey;   border-left: 1px solid #eee;">
      <p>{{trans('package.insurance')}}:</p>
    </div>
    <div class="col-md-4" style="border-right: 1px solid #eee;">
      <p>{{isset($insurance->value_package) ? $insurance->value_package :'0'}}$</p>
    </div>

     <div class="col-md-8" style="text-align: right;border-right: 1px solid grey;   border-left: 1px solid #eee;">
      <p>{{trans('package.addcharge')}}:</p>
    </div>
    <div class="col-md-4" style="border-right: 1px solid #eee;">
      <p>-{{isset($addcharge->value_package) ? $addcharge->value_package :'0'}}$</p>
    </div>


     <div class="col-md-8" style="text-align: right;border-right: 1px solid grey;   border-left: 1px solid #eee;">
      <p style="font-weight: bold;">Subtotal:</p>
    </div>
    <div class="col-md-4" style="border-right: 1px solid #eee;">
      <p style="font-weight: bold;">{{$receipt->subtotal}}$</p>
    </div>

    <div class="col-md-8" style="text-align: right;border-right: 1px solid grey;   border-left: 1px solid #eee;">
      @if(isset($detailsreceipt))
                @foreach ($detailsreceipt as $row)
                   <p> Tax ({{$row->value_oring}}%)</p>
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
