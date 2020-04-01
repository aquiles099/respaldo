<div class="panel panel-default">
  <div class="panel-heading">
    <i class="fa fa-handshake-o fa-fw" aria-hidden="true"></i>
    {{trans('contract.contractdata')}}
  </div>
  <div class="panel-body">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-user fa-fw" aria-hidden="true"></i>
          {{trans('contract.clientdata')}}
        </div>
        <div class="panel-body">
          <!---->
          <p>
            <strong>{{trans('messages.name')}}:</strong>
            {{$client->name}}
          </p>
          <!---->
          <p>
            <strong>{{trans('messages.email')}}:</strong>
            {{$client->email}}
          </p>
          <!---->
          <p>
            <strong>{{trans('messages.country')}}:</strong>
            {{isset($client->getCountry->name) ? $client->getCountry->name : trans('messages.unknown')}}
          </p>
          <!---->
          <p>
            <strong>{{trans('messages.region')}}:</strong>
            {{isset($client->region) ? $client->region : trans('messages.unknown')}}
          </p>
          <!---->
          <p>
            <strong>{{trans('messages.phone')}}:</strong>
            {{isset($client->phone) ? $client->phone : trans('messages.unknown')}}
          </p>
          <!---->
          <p>
            <strong>{{trans('messages.webpage')}}:</strong>
            {{isset($client->webpage) ? $client->webpage : trans('messages.unknown')}}
          </p>
          <!---->
          <p>
            <strong>{{trans('messages.sub')}}:</strong>
            {{isset($client->subdomain) ? $client->subdomain : trans('messages.unknown')}}
          </p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-handshake-o fa-fw" aria-hidden="true"></i>
          {{trans('contract.contractdata')}}
        </div>
        <div class="panel-body">
          <!---->
          <p>
            <strong>{{trans('contract.register')}}:</strong>
            {{$contract->register_date}}
          </p>
          <!---->
          <p>
            <strong>{{trans('contract.cutoff_date')}}:</strong>
            {{$contract->cut_off_date}}
          </p>
          <!---->
          <p>
            <strong>{{trans('contract.profile')}}:</strong>
            @if ($contract->getSolicitude->profile == '1')
              {{trans('messages.micro')}}
            @elseif ($contract->getSolicitude->profile == '2')
              {{trans('messages.macro')}}
              @else
              {{trans('messages.unknown')}}
            @endif
          </p>
          <!---->
          <p>
            <strong>{{trans('contract.created_at')}}:</strong>
            {{$contract->created_at}}
          </p>
          <!---->
          <p>
            <strong>{{trans('contract.status')}}:</strong>
            {{$contract->getStatus->name}}
          </p>
          <!--Operadores Actuales-->
          <p>
            <strong>{{trans('contract.operators')}}:</strong>
            {{is_null($test->operators) ? trans('messages.unknown') : $test->operators}}
          </p>
          <!--Clientes Actuales-->
          <p>
            <strong>{{trans('contract.clients')}}:</strong>
            {{is_null($test->clients) ? trans('messages.unknown') : $test->operators }}
          </p>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-list fa-fw" aria-hidden="true"></i>
          {{trans('messages.history')}}
        </div>
        <div class="panel-body">
          <table class="table table-striped table-hover table-bordered table-responsive">
            <thead>
              <tr>
                <th>{{trans('messages.description')}}</th>
                <th>{{trans('messages.date')}}</th>
              </tr>
            </thead>
            <tbody>
              <!--Solictud de Prueba-->
              <tr>
                <td>Solicitud de Prueba</td>
                <td>{{$solicitude->created_at}}</td>
              </tr>
              <!--Registrado-->
              <tr>
                <td>Registrado en Sistema</td>
                <td>{{$client->created_at}}</td>
              </tr>
              <!--Prueba-->
              <tr>
                <td>Activacion de Prueba</td>
                <td>{{$test->created_at}}</td>
              </tr>
              <!--Contrato-->
              <tr>
                <td>Creacion de Contrato</td>
                <td>{{$contract->created_at}}</td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
  </div>
</div>
