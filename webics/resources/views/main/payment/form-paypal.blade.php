<div class="panel panel-default">
  <div class="panel-heading">
    <span>
      <i class="fa fa-money fa-fw" aria-hidden="true"></i>
    </span>
    <span>Otras formas de pago</span>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <span>
                <i class="fa fa-paypal" aria-hidden="true"></i>
              </span>
              <span>Paypal</span>
            </div>
            <div class="panel-body">
              <form action="{{env('ICS_PAYPAL_ACTION')}}" method="post" target="_blank">
              <input type="hidden" name="cmd" value="_s-xclick">
              <input type="hidden" name="charset" value="utf-8">
              <input type="hidden" name="hosted_button_id" value="32LES9YNGVSDY">
              <input type="hidden" name="return" value="{{asset("payment/return?p=$client->remember_token")}}">
              <input type="hidden" name="item_name" value="{{$solicitude->profile == 1 ? trans('messages.micro') : $solicitude->profile == 2 ? : trans('messages.macro')}}">
              <table>
              <tr>
                <td>
                  <input type="hidden" name="on0" value="{{$solicitude->profile == 1 ? trans('messages.micro') : $solicitude->profile == 2 ? : trans('messages.macro')}}">
                  Seleccione una Opción
                </td>
              </tr>
              <tr>
                <td>
                  <select class="form-control" name="os0">
                     <option value="1 año">1 año $100.00 USD</option>
                     <option value="2 años">2 años $180.00 USD</option>
                     <option value="3 años">3 años $270.00 USD</option>
                   </select>
                 </td>
               </tr>
              </table>
                <input type="hidden" name="currency_code" value="USD">
                <input type="image" src="{{env('ICS_PAYPAL_IMG_BUTTON')}}" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="{{env('ICS_PAYPAL_IMG')}}" width="1" height="1">
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-4">

        </div>
        <div class="col-md-4">
				<img src="{{asset('dist/img/favicon.png')}}" style="height: 195px; float: right;" alt = "{{trans('messages.ICS')}} - {{trans('messages.payment')}}" >
        </div>
      </div>
    </div>
  </div>
  <div class="panel-footer">
    <span class="icstitle">
      Ha solicitado un pago para ICS en su version
        <strong>
          <!--App Micro-->
          @if ($solicitude->profile == '1')
            {{trans('messages.micro')}}
          @endif
          <!--App Macro-->
          @if ($solicitude->profile == '2')
            {{trans('messages.macro')}}
          @endif
        </strong>
    </span>
  </div>
</div>
