
<script type="text/javascript" src="{!! asset('js/includes/billofladingCtrl.js') !!}"></script>
<form role="form" action="" id="billoflading" method="post">
  <fieldset class="form">
    <!--Primer cuadro, se muestra tracking, origen y destino-->
    <div class="row">
    	<div class="col-md-6">

    		<div class="@include('errors.field-class', ['field' => 'exporter'])"  id="divlarge" >
              <label class=" control-label" id="typeLabel" >{{trans('billoflading.exporter')}}</label>
              <textarea type="text" class="form-control" placeholder="{{trans('billoflading.exporter')}}" id="exporter" name="exporter" type="text" rows="5" min="1" required="true" value="{{isset($billoflading) ? $billoflading->exporter : clear(Input::get('obervation'))}}" @include('form.readonly')> {{isset($billoflading) ? $billoflading->exporter : clear(Input::get('obervation'))}}</textarea>
              @include('errors.field', ['field' => 'exporter'])
            </div>

            <div class="@include('errors.field-class', ['field' => 'consigne'])"  id="divlarge" >
              <label class=" control-label" id="typeLabel" >{{trans('billoflading.consigne')}}</label>
              <textarea type="text" class="form-control" placeholder="{{trans('billoflading.consigne')}}" id="consigne" name="consigne" type="text" rows="5" min="1" required="true" value="{{isset($billoflading) ? $billoflading->consignedto : clear(Input::get('consignedto'))}}" @include('form.readonly')>{{isset($billoflading) ? $billoflading->consignedto : clear(Input::get('consignedto'))}}</textarea>
              @include('errors.field', ['field' => 'consigne'])
            </div>

            <div class="@include('errors.field-class', ['field' => 'notify'])"  id="divlarge" >
              <label class=" control-label" id="typeLabel" >{{trans('billoflading.notify')}}</label>
              <textarea type="text" class="form-control" placeholder="{{trans('billoflading.notify')}}" id="notify" name="notify" type="text" rows="4" min="1" required="true" value="{{isset($billoflading) ? $billoflading->notify : clear(Input::get('notify'))}}" @include('form.readonly')> {{isset($billoflading) ? $billoflading->notify : clear(Input::get('notify'))}}</textarea>
              @include('errors.field', ['field' => 'notify'])
            </div>
            <div class="row">
	            <div class="col-md-6">
					<div class="@include('errors.field-class', ['field' => 'precarri'])"  id="divlarge" >
	              		<label class=" control-label" id="typeLabel" >{{trans('billoflading.precarri')}}</label>
	              		<input type="text" class="form-control" placeholder="{{trans('billoflading.precarri')}}" id="precarri" name="precarri" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->precarri : clear(Input::get('precarri'))}}" @include('form.readonly')>
	              		@include('errors.field', ['field' => 'precarri'])
	            	</div>     

	            	<div class="@include('errors.field-class', ['field' => 'exporting'])"  id="divlarge" >
	              		<label class=" control-label" id="typeLabel" >{{trans('billoflading.exporting')}}</label>
	              		<input type="text" class="form-control" placeholder="{{trans('billoflading.exporting')}}" id="exporting" name="exporting" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->exporting : clear(Input::get('exporting'))}}" @include('form.readonly')>
	              		@include('errors.field', ['field' => 'exporting'])
	            	</div>  

	            	<div class="@include('errors.field-class', ['field' => 'foreing'])"  id="divlarge" >
	              		<label class=" control-label" id="typeLabel" >{{trans('billoflading.foreing')}}</label>
	              		<input type="text" class="form-control" placeholder="{{trans('billoflading.foreing')}}" id="foreing" name="foreing" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->foreing : clear(Input::get('foreing'))}}" @include('form.readonly')>
	              		@include('errors.field', ['field' => 'foreing'])
	            	</div> 


	            </div>

	            <div class="col-md-6">
	            	<div class="@include('errors.field-class', ['field' => 'place'])"  id="divlarge" >
	              		<label class=" control-label" id="typeLabel" >{{trans('billoflading.place')}}</label>
	              		<input type="text" class="form-control" placeholder="{{trans('billoflading.place')}}" id="place" name="place" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->place : clear(Input::get('place'))}}" @include('form.readonly')>
	              		@include('errors.field', ['field' => 'place'])
	            	</div> 

	            	<div class="@include('errors.field-class', ['field' => 'port'])"  id="divlarge" >
	              		<label class=" control-label" id="typeLabel" >{{trans('billoflading.port')}}</label>
	              		<input type="text" class="form-control" placeholder="{{trans('billoflading.port')}}" id="port" name="port" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->port : clear(Input::get('port'))}}" @include('form.readonly')>
	              		@include('errors.field', ['field' => 'port'])
	            	</div> 

	            	<div class="@include('errors.field-class', ['field' => 'placedeli'])"  id="divlarge" >
	              		<label class=" control-label" id="typeLabel" >{{trans('billoflading.placedeli')}}</label>
	              		<input type="text" class="form-control" placeholder="{{trans('billoflading.placedeli')}}" id="placedeli" name="placedeli" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->placedeli : clear(Input::get('placedeli'))}}" @include('form.readonly')>
	              		@include('errors.field', ['field' => 'placedeli'])
	            	</div> 

	            </div>
            </div>
    		
    	</div>

    	<div class="col-md-6">

    		<div class="row">
    			<div class="col-md-6">
    				<div class="@include('errors.field-class', ['field' => 'document'])"  id="divlarge" >
	              		<label class=" control-label" id="typeLabel" >{{trans('billoflading.document')}}</label>
	              		<input type="text" class="form-control" placeholder="{{trans('billoflading.document')}}" id="document" name="document" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->document : clear(Input::get('document'))}}" @include('form.readonly')>
	              		@include('errors.field', ['field' => 'document'])
	            	</div> 
    			</div>

    			<div class="col-md-6">
    				<div class="@include('errors.field-class', ['field' => 'bl'])"  id="divlarge" >
	              		<label class=" control-label" id="typeLabel" >{{trans('billoflading.bl')}}</label>
	              		<input type="text" class="form-control" placeholder="{{trans('billoflading.bl')}}" id="bl" name="bl" type="text"  min="1" required="true" readonly="" value="{{isset($package) ? $package->code : clear(Input::get('bl'))}}" @include('form.readonly')>
	              		@include('errors.field', ['field' => 'bl'])
	            	</div> 	
    			</div>
    		</div>

    		<div class="@include('errors.field-class', ['field' => 'exportre'])"  id="divlarge" >
              <label class=" control-label" id="typeLabel" >{{trans('billoflading.exportre')}}</label>
              <textarea type="text" class="form-control" placeholder="{{trans('billoflading.exportre')}}" id="exportre" name="exportre" type="text" rows="3" min="1" required="true" value="{{isset($billoflading) ? $billoflading->exportreference : clear(Input::get('exportreference'))}}" @include('form.readonly')>{{isset($billoflading) ? $billoflading->exportreference : clear(Input::get('exportreference'))}}</textarea>
              @include('errors.field', ['field' => 'exportreference'])
            </div>

    		<div class="@include('errors.field-class', ['field' => 'forwarding'])"  id="divlarge" >
              <label class=" control-label" id="typeLabel" >{{trans('billoflading.forwarding')}}</label>
              <textarea type="text" class="form-control" placeholder="{{trans('billoflading.forwarding')}}" id="forwarding" name="forwarding" type="text" rows="3" min="1" required="true" value="{{isset($billoflading) ? $billoflading->forwarding : clear(Input::get('forwarding'))}}" @include('form.readonly')> {{isset($billoflading) ? $billoflading->forwarding : clear(Input::get('forwarding'))}}</textarea>
              @include('errors.field', ['field' => 'forwarding'])
            </div>

            <div class="@include('errors.field-class', ['field' => 'point'])"  id="divlarge" >
              <label class=" control-label" id="typeLabel" >{{trans('billoflading.point')}}</label>
              <input  type="text" class="form-control" placeholder="{{trans('billoflading.point')}}" id="point" name="point" type="text" rows="4" min="1" required="true" value="{{isset($billoflading) ? $billoflading->point : clear(Input::get('point'))}}" @include('form.readonly')>
              @include('errors.field', ['field' => 'point'])
            </div>

            <div class="@include('errors.field-class', ['field' => 'purchase'])"  id="divlarge" style="padding-bottom: 10px;">
              <label class=" control-label" id="typeLabel" >{{trans('billoflading.purchase')}}</label>
              <textarea type="text" class="form-control" placeholder="{{trans('billoflading.purchase')}}" id="purchase" name="purchase" type="text" rows="4" min="1" required="true" value="{{isset($billoflading) ? $billoflading->purchaseorder : clear(Input::get('obervation'))}}" @include('form.readonly')> {{isset($billoflading) ? $billoflading->purchaseorder : clear(Input::get('purchase'))}}</textarea>
              @include('errors.field', ['field' => 'purchase'])
            </div>

            <div class="@include('errors.field-class', ['field' => 'loadingpier'])"  id="divlarge" >
              <label class=" control-label" id="typeLabel" >{{trans('billoflading.loadingpier')}}</label>
              <input  type="text" class="form-control" placeholder="{{trans('billoflading.loadingpier')}}" id="loadingpier" name="loadingpier" type="text" rows="4" min="1" required="true" value="{{isset($billoflading) ? $billoflading->loadingpier : clear(Input::get('loadingpier'))}}" @include('form.readonly')>
              @include('errors.field', ['field' => 'loadingpier'])
            </div>

            <div class="row">
    			<div class="col-md-6">
    				<div class="@include('errors.field-class', ['field' => 'typemovie'])"  id="divlarge" >
	              		<label class=" control-label" id="typeLabel" >{{trans('billoflading.typemovie')}}</label>
	              		<input type="text" class="form-control" placeholder="{{trans('billoflading.typemovie')}}" id="typemovie" name="typemovie" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->typemovie : clear(Input::get('obervation'))}}" @include('form.readonly')>
	              		@include('errors.field', ['field' => 'typemovie'])
	            	</div> 
    			</div>

    			<div class="col-md-6">
    				<div class="@include('errors.field-class', ['field' => 'containe'])"  id="divlarge" >
	              		<label class=" control-label" id="typeLabel" >{{trans('billoflading.containe')}}</label>
	              		<input type="text" class="form-control" placeholder="{{trans('billoflading.containe')}}" id="containe" name="containe" type="text"  min="1" required="true" value="{{isset($billoflading) ? $billoflading->containerized : clear(Input::get('containerized'))}}" @include('form.readonly')>
	              		@include('errors.field', ['field' => 'containe'])
	            	</div> 	
    			</div>
    		</div>

    
    	</div>
    </div>
 	
 	<div class="row" style="height:1px; background-color:rgba(158, 158, 158, 0.54);margin-top: 10px;">
    	
    </div>
    <div class="row">
    	<button type="button" class="btn btn-primary" style="float: right;margin-right: 20px;margin-top: 20px;" onclick="resultbill({{$package->id}})"> Generar Reporte</button>    	
    </div>


  </fieldset>
</form>
