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
    <!----->
    <div class="">
      <h3>Estimado: {!!$user->name!!} {!!$user->last_name!!}</h3>
    </div>
    <!---->
    <div class="">
        Hemos recibido su pago perteneciente a la orden de recolecta <strong>{!!$pickup->code!!}</strong> , en breve procederemos a completar el proceso.
    </div>
    <!---->
    <p>
      <div style="text-align: justify">
        {!!$configuration->footer_mail!!}
      </div>
    </p>
	</div>
</div>
