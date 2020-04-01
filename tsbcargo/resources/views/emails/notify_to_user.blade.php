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
      @if ($event == 1)
        {{trans('mail.received', [
          'office'  => $package_office,
          'company' => $configuration->name_company
        ])}}:
      @else
        {{trans('mail.status' , [
          'event' => $current_event,
          'company' => $configuration->name_company
          ])}}
      @endif
    </div>
    <div style="text-align: left">
      <p>
        {!! strtoupper(trans('mail.name', ['name' => $name])) !!}
      </p>
      <p>
        {!! strtoupper(trans('mail.last_name', ['last_name' => $last_name])) !!}
      </p>
      <p>
        {!! strtoupper(trans('mail.user_code', ['user_code' => $user_code])) !!}
      </p>
      <p>
        {!! strtoupper(trans('mail.package_code', ['package_code' => $package_code])) !!}
      </p>
      <p>
        {!! strtoupper(trans('mail.package_tracking', ['package_tracking' => $package_tracking])) !!}
      </p>
      <p>
        {!! strtoupper(trans('mail.package_type', ['package_type' => $package_type])) !!}
      </p>
      <p>
        {!! strtoupper(trans('mail.package_weight', ['package_weight' => $package_weight])) !!}
      </p>
      <p>
        {!! strtoupper(trans('mail.package_value', ['package_value' => $package_value])) !!}
      </p>
      <p>
        {!! strtoupper(trans('mail.package_destiny', [
          'package_destiny_country' => $package_destiny_country,
          'package_destiny_region'  => $package_destiny_region,
          'package_destiny_city'    => $package_destiny_city
          ])) !!}
      </p>
      @if($package_invoice == null || package_invoice == '')
        <p style="background-color: #e68080; padding: 4px">
          {!! strtoupper(trans('mail.package_noinvoice')) !!}
        </p>
      @endif
    </div>
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
