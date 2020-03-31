<div style="padding: 20px; background-color: #efefef;">
	<div style="background-color: white; padding: 15px;">
		<div>
			<table>
				<tbody>
					<tr>
						<!--logo ics-->
						<td>
							<img style="width:200px;" src="<?php echo e(is_null($configuration->logo_ics) || $configuration->logo_ics == '' ? asset('uploads/logo/favicon.png') : $configuration->logo_ics); ?>">
						</td>
						<!-- header de notifcaiones configurado-->
						<td style="text-align: justify; font-size: 11px">
							<?php echo $configuration->header_mail; ?>

						</td>
					</tr>
				</tbody>
			</table>
    </div>
		<hr>
		<!--cabecera si se reporta un cambio de contraseña-->
		<?php if(isset($change)): ?>
		<div style="text-align: center;font-weight: bold; padding: 2%;color: #353030; text-transform: uppercase;">
			<?php echo trans('messages.changepassSuccessInfo', [
				'code' 		  => $user->code,
				'name' 		  => $user->name,
				'last_name' => $user->last_name
			]); ?>

		</div>
		<?php elseif(isset($recovery)): ?>
			<!--cabecera si se reporta recordar contraseña-->
			<div style="text-align: center;font-weight: bold; padding: 2%;color: #353030; text-transform: uppercase;">
				<?php echo trans('messages.recoverypassSuccessInfo', [
					'company'   => $configuration->name_company,
					'name' 		  => $user->name,
					'last_name' => $user->last_name
				]); ?>

			</div>
			<?php else: ?>
			<!--cabecera si se reporta un registro de usuario correcto-->
			<div style="text-align: center;font-weight: bold; padding: 2%;color: #353030; text-transform: uppercase;">
				<?php echo trans('messages.registerUserSuccessInfo', [
					'code' 		  => $user->code,
					'name' 		  => $user->name,
					'last_name' => $user->last_name,
					'company'   => $configuration->name_company
					]); ?>

			</div>
		<?php endif; ?>
		<!--Correo o nombre de usuario-->
		<p>
			<?php echo trans('messages.mail_userName', ['userName' => $user->email]); ?>

		</p>
		<!--Contraseña de usuario-->
		<p>
			<?php echo trans('messages.mail_password', ['password' => $password]); ?>

		</p>
		<!--terminos y condiciones en el pie del correo-->
		<p>
			<div style="text-align: justify">
				<?php echo $configuration->footer_mail; ?>

			</div>
		</p>
		<!--pie de correo si se reporta un registro de usuario-->
		<?php if(isset($host) && isset($link)): ?>
		<p style ="font-weight: bold; background-color: #2A2F3A; padding: 2%; color: white; text-align: center">
			<?php echo trans('messages.check_link', [
				'host' 		=> $host,
				'link' 		=> $link,
				'company' => $configuration->name_company,
				'url'			=> $configuration->web_site_company
			]); ?>

		</p>
		<?php else: ?>
		<!--pie de correo si se registra un cambio de contraseña-->
			<?php if(isset($change)): ?>
			<p style ="font-weight: bold; background-color: #2A2F3A; padding: 2%; color: white; text-align: center">
				<?php echo trans('messages.changepassSuccess'); ?>

			</p>
		<!--pie de correo si se detecta un cambio de contraseña-->
			<?php else: ?>
			<p style ="font-weight: bold; background-color: #2A2F3A; padding: 2%; color: white; text-align: center">
				<?php echo trans('messages.recoveryPasswordSuccess'); ?>

			</p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>
