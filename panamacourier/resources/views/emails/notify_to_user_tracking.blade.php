@include('sections.translate')
<div style="padding: 20px; background-color: #efefef;">
  <div style="background-color: white; padding: 15px;">
    <div>
      <table>
				<tbody>
					<tr>
						<!--logo ics-->
						<td>
							<img style="width:200px;" src="{{is_null($configuration->logo_ics) || $configuration->logo_ics == '' ? asset('uploads/logo/favicon.png') : $configuration->logo_ics}}">
						</td>
						<!-- header de notifcaiones configurado-->
						<td style="text-align: justify; font-size: 11px">
							{!!$configuration->header_mail!!}
						</td>
					</tr>
				</tbody>
			</table>
    </div>
    <hr>
    <div style="text-align: center;font-weight: bold; padding: 2%;color: #353030; text-transform: uppercase;">
      'SALUDOS, LE INFORMAMOS QUE YA PUEDE CONSULTAR EL ESTADO DE SUS PAQUETES Y LOS PRECIOS DE LOS MISMOS EN NUESTRO SISTEMA'
    </div>
    <div style="text-align: left">
      <p>
        Estimado {{ucfirst($name.' '.$last_name)}} sus paquetes han sido procesados y los codigos de tracking para realizar el rastreo son:
      </p>
      <p>
        @foreach($trackings as $key => $tracking)
          <b>Descripción:</b>   {{$tracking['description']}}<br>
          <b>Tracking:</b>      {{$tracking['tracking']}}<br>
          <b>Transportista:</b> {{($tracking['type']>=2) ? 'FEDEX' : 'DHL'}}<br><br>
        @endforeach
      </p>
    </div>
    <p>RECUERDE QUE PUEDE CONSULTAR EL ESTADO DE SUS PAQUETES EN LA PAGINA WEB DEL TRANSPORTISTA SELECCIONADO, UTILIZANDO EL NUMERO DE TRACKING</p>
    <!--terminos y condiciones en el pie del correo-->
		<p>
			<div style="text-align: justify">
				{!!$configuration->footer_mail!!}
			</div>
		</p>
    <p style ="text-align: center;font-weight: bold; background-color: #2A2F3A; padding: 2%; color: white;">
      {!! trans('mail.ics', [
        'company' => $configuration->name_company,
        'url'     => $configuration->web_site_company
      ]) !!}
    </p>
  </div>
</div>
