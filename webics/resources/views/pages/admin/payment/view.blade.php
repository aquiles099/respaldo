<div class="panel panel-default">
  <div class="panel-heading">
    <i class="fa fa-money fa-fw" aria-hidden="true"></i>
    {{trans('messages.paymentdetails')}}
    <span class="pull-right">
      <a href="{{asset("admin/payments/{$payment->id}")}}/attachment">
        <i class="fa fa-file" aria-hidden=""></i>
        {{trans('messages.attachment')}}
      </a>
    </span>
  </div>
  <div class="panel-body">
    <!---->
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-money fa-fw" aria-hidden="true"></i>
              {{trans('messages.pay')}}
            </div>
            <div class="">
              <div class="panel-body">
                <!--Code-->
                <p>
                  <strong>{{trans('payment.code')}}:</strong> {{$payment->code}}
                </p>
                <!--Monto-->
                <p>
                  <strong>{{trans('payment.amount')}}:</strong> {{$payment->amount}} {{env('CURRENCY')}}
                </p>
                <!--Años de contrato-->
                <p>
                  <strong>{{trans('payment.years')}}:</strong> {{$payment->years}}
                </p>
                <!--Tipo de Software [MICRO-MACRO]-->
                <p>
                  <strong>{{trans('payment.type')}}:</strong> {{$payment->type}}
                </p>
                <!--Banco-->
                <p>
                  <strong>{{trans('payment.bank')}}:</strong> {{$payment->bank}}
                </p>
                <!--N° Transaccion-->
                <p>
                  <strong>{{trans('payment.transaction')}}:</strong> {{$payment->transaction}}
                </p>
                <!--N° Transaccion-->
                <p>
                  <strong>{{trans('payment.concept')}}:</strong> {{$payment->concept}}
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-user fa-fw" aria-hidden="true"></i>
              {{trans('messages.client')}}
            </div>
            <div class="">
              <div class="panel-body">
                <!--Codigo-->
                <p>
                  <strong>{{trans('client.code')}}:</strong> {{$client->code}}
                </p>
                <!--Nombre-->
                <p>
                  <strong>{{trans('client.name')}}:</strong> {{$client->name}}
                </p>
                <!--Correo-->
                <p>
                  <strong>{{trans('client.email')}}:</strong> {{$client->email}}
                </p>
                <!--Subdominio-->
                <p>
                  <strong>{{trans('messages.sub')}}:</strong> {{$client->sub_domain ? $client->sub_domain : trans('messages.unknown')}}
                </p>
                <!--Pais-->
                <p>
                  <strong>{{trans('client.country')}}:</strong> {{$client->country ? strtoupper($client->getCountry->name) : trans('messages.unknown')}}
                </p>
                <!--Prueba-->
                <p>
                  <strong>{{trans('contract.test')}}:</strong> {{isset($test->code) ? $test->code : trans('messages.unknown')}}
                </p>
                <!--Contrato-->
                <p>
                  <strong>{{trans('contract.contract')}}:</strong> {{isset($contract->code) ? $contract->code : trans('messages.unknown')}}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Form status-->
    @if($payment->status == App\Helpers\HPayment::HOLD )
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body" style="padding-bottom: 0px">
              <form name="icsForm" class="" id="icsFormSerialize">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-4">
                      <select class="form-control" name="status" required="true">
                        @foreach($status as $key => $value)
                          @if($value['id'] > $payment->status)
                            <option value="{{$value['id']}}">{{$value['text']}}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="description" id="description" value="" placeholder="{{trans('messages.description')}}" style="margin-bottom: 0px; height: 35px" required="true">
                    </div>
                    <div class="col-md-4">
                      <button class="btn btn-primary" type="button" name="sendButton" id="sendButton" onclick="icsChangeStatusPayment({{$payment->id}})" style="width: 100%">{{trans('messages.send')}}</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    <!--Action Log-->
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <table class="table table-hover table-striped table-responsive table-bordered">
                <thead>
                  <tr>
                    <th>{{trans('payment.status')}}</th>
                    <th>{{trans('payment.user')}}</th>
                    <th>{{trans('payment.date')}}</th>
                    <th>{{trans('payment.observation')}}</th>
                  </tr>
                </thead>
                <tbody>
                   @foreach($log as $key => $value)
                    <tr item="{{$value->toJson()}}">
                      <td>
                        @if($value->status == App\Helpers\HPayment::HOLD) {{trans('payment.hold')}} @endif
                        @if($value->status == App\Helpers\HPayment::DENIED) {{trans('payment.denied')}} @endif
                        @if($value->status == App\Helpers\HPayment::APROVED) {{trans('payment.aproved')}} @endif
                      </td>
                      <td>{{isset($value->getUser) ? $value->getUser->email  : trans('messages.unknown')}}</td>
                      <td>{{$value->created_at}}</td>
                      <td>{{$value->description}}</td>
                    </tr>
                   @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
