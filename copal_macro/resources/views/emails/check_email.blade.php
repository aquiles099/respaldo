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
		<!--cabecera si se reporta un cambio de contraseña-->
		@if(isset($change))
		<div style="text-align: center;font-weight: bold; padding: 2%;color: #353030; text-transform: uppercase;">
			{!! trans('messages.changepassSuccessInfo', [
				'code' 		  => $user->code,
				'name' 		  => $user->name,
				'last_name' => $user->last_name
			]) !!}
		</div>
		@elseif (isset($recovery))
			<!--cabecera si se reporta recordar contraseña-->
			<div style="text-align: center;font-weight: bold; padding: 2%;color: #353030; text-transform: uppercase;">
				{!! trans('messages.recoverypassSuccessInfo', [
					'company'   => $configuration->name_company,
					'name' 		  => $user->name,
					'last_name' => $user->last_name
				]) !!}
			</div>
			@else
			<!--cabecera si se reporta un registro de usuario correcto-->
			<div style="text-align: center;font-weight: bold; padding: 2%;color: #353030; text-transform: uppercase;">
				{!! trans('messages.registerUserSuccessInfo', [
					'code' 		  => $user->code,
					'name' 		  => $user->name,
					'last_name' => $user->last_name,
					'company'   => $configuration->name_company
					])
				!!}
			</div>
		@endif
		<!--Correo o nombre de usuario-->
		<p>
			{!! trans('messages.mail_userName', ['userName' => $user->email]) !!}
		</p>
		<!--Contraseña de usuario-->
		<p>
			{!! trans('messages.mail_password', ['password' => $password]) !!}
		</p>
		<!--terminos y condiciones en el pie del correo-->
		<p>
			<div style="text-align: justify">
				{!!$configuration->footer_mail!!}
			</div>
		</p>
		<!--pie de correo si se reporta un registro de usuario-->
		@if(isset($host) && isset($link))
		<p style ="font-weight: bold; background-color: #2A2F3A; padding: 2%; color: white; text-align: center">
			{!! trans('messages.check_link', [
				'host' 		=> $host,
				'link' 		=> $link,
				'company' => $configuration->name_company,
				'url'			=> $configuration->web_site_company
			]) !!}
		</p>
		@else
		<!--pie de correo si se registra un cambio de contraseña-->
			@if(isset($change))
			<p style ="font-weight: bold; background-color: #2A2F3A; padding: 2%; color: white; text-align: center">
				{!! trans('messages.changepassSuccess') !!}
			</p>
		<!--pie de correo si se detecta un cambio de contraseña-->
			@else
			<p style ="font-weight: bold; background-color: #2A2F3A; padding: 2%; color: white; text-align: center">
				{!! trans('messages.recoveryPasswordSuccess') !!}
			</p>
			@endif
		@endif
	</div>
</div>
