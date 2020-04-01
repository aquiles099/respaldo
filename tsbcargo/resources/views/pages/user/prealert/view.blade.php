<?php
    use App\Models\Admin\Configuration;

    $configuration = Configuration::find(1);
    $lang = $configuration->language;
		App::setLocale($lang);
 ?>

<div class="panel panel-default">
	<div class="panel-heading">
	  <span class="text-muted">
        <strong>{{trans('prealert.created_at')}}:</strong> {{strtoupper($prealert->created_at)}}
      </span>
    </div>
	<div class="panel-body">
		<p>
			<strong>{{trans('prealert.code')}}:</strong> {{strtoupper($prealert->code)}}
		</p>
		<hr>
		<p>
			<strong>{{trans('prealert.order_service')}}:</strong> {{strtoupper($prealert->order_service)}}
		</p>
		<hr>
		<p>
			<strong>{{trans('prealert.provider')}}:</strong> {{strtoupper($prealert->provider)}}
		</p>
		<hr>
		<p>
			<strong>{{trans('prealert.courier')}}:</strong> {{strtoupper($prealert->getCourier->name)}}
		</p>
		<hr>
		<p>
			<strong>{{trans('prealert.date_arrived')}}:</strong> {{strtoupper($prealert->date_arrived)}}
		</p>
		<hr>
		<p>
			<strong>{{trans('prealert.value')}}:</strong> {{strtoupper($prealert->value)}}
		</p>
		<hr>
		<p>
			<strong>{{trans('prealert.content')}}:</strong> {{strtoupper($prealert->content)}}
		</p>
		@if((((isset($prealert->large))&&(isset($prealert->height))&& (isset($prealert->width)))))
			<hr>
			<p>
				<strong>{{trans('prealert.dimensions')}}:</strong> {{((isset($prealert->large))&&(isset($prealert->height))&& (isset($prealert->width))&&(($prealert->height!=0) && ($prealert->width!=0) && ($prealert->large!=0))) ? ($prealert->large.'x'.$prealert->height.'x'.$prealert->width).(($prealert->unidad == 1) ? 'in' : 'cm') : 'NO INGRESADO'}}
			</p>
		@endif
		@if(isset($prealert->weight))
			<hr>
			<p>
				<strong>{{trans('package.weight')}}:</strong> {{(($prealert->weight>0) ? $prealert->weight.(($prealert->unidad == 1) ? 'lb' : 'kg') : 'NO INGRESADO')}}
			</p>
		@endif
		@if(isset($prealert->type))
			<hr>
			<p>
				<strong>{{trans('prealert.type_transport')}}:</strong> {{(($prealert->type != 0) ? ((($prealert->type == 1) ? 'Marítimo' : ($prealert->type == 2) ? 'Aéreo' : 'NO SELECCIONÓ')):'NO SELECCIONÓ')}}
			</p>
		@endif
	</div>
</div>
