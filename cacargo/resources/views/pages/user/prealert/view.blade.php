@include('sections.translate')
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
		<hr>
		<p>
			<strong>{{trans('prealert.associatedfile')}}: </strong>	{{isset($prealert->getFile) ? $prealert->getFile->name : trans('prealert.notFile') }}
		</p>
	</div>
</div>
