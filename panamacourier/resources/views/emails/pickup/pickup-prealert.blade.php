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
    <!---->
    <p>
      <strong>Solicitado Por: </strong> {!!$user->name!!} {!!$user->last_name!!} , {!!$user->email!!}
    </p>
    <!---->
    <p>
      <strong>Direccion Origen </strong> {!!$pickup->country_shipper!!}, {!!$pickup->region_shipper!!}, {!!$pickup->city_shipper!!}, {!!$pickup->address_shipper!!}
    </p>
    <!---->
    <p>
      <strong>Persona Destino: </strong>{!!$pickup->destin_name!!}
    </p>
    <!---->
    <p>
      <strong>Telefono de Contacto: </strong> {!!$pickup->destin_phone!!}
    </p>
		<!---->
    <p>
      <strong>Direccion Destino: </strong> {!! isset($country->name) ? $country->name : 'No Indicado' !!}, {!!$pickup->region_consig!!}, {!!$pickup->city_consig!!}, {!!$pickup->address_consig!!}
    </p>
		<!---->
		<p>
			<strong>Items Agregados: </strong> {!!$details->count()!!}
		</p>
		<!---->
		<p>
			<strong>Codigo de Recolecta: </strong> {!!$pickup->code!!}
		</p>
    <!--terminos y condiciones en el pie del correo-->
    <p>
      <div style="text-align: justify">
        {!!$configuration->footer_mail!!}
      </div>
    </p>
	</div>
</div>
