<div class="panel panel-default">
  <div class="panel-heading">
    <i class="fa fa-user fa-fw" ara-hidden="true"></i>
    {{trans('messages.createdby')}}:
    <strong>
      @if(isset($client->getAdmin))
      {{$client->getAdmin->code}} {{strtoupper($client->getAdmin->name)}}
      @endif
    </strong>
  </div>
  <div class="panel-body">
    <div class="col-md-6">
      <!--Nombre-->
      <p>
        <strong>{{trans('messages.name')}}:</strong> {{$client->name}}
      </p>
      <!--ASUNTO-->
      <p>
        <strong>{{trans('messages.dni')}}:</strong> {{$client->dni}}
      </p>
      <!--CORREO-->
      <p>
        <strong>{{trans('messages.country')}}:</strong> {{isset($client->getCountry->name) ? $client->getCountry->name : trans('messages.unknown')}}
      </p>
      <!--MENSAJE-->
      <p>
        <strong>{{trans('messages.region')}}:</strong> {{$client->region}}
      </p>
      <!--FECHA-->
      <p>
        <strong>{{trans('messages.address')}}:</strong> {{$client->address}}
      </p>
      <!--FECHA-->
      <p>
        <strong>{{trans('messages.city')}}:</strong> {{$client->city}}
      </p>
      <!--FECHA-->
      <p>
        <strong>{{trans('messages.postal_code')}}:</strong> {{$client->postal_code}}
      </p>
      <!--FECHA-->
      <p>
        <strong>{{trans('messages.phone')}}:</strong> {{$client->phone}}
      </p>
    </div>
    <div class="col-md-6">
      <!--FECHA-->
      <p>
        <strong>{{trans('messages.email')}}:</strong> {{$client->email}}
      </p>
      <!--FECHA-->
      <p>
        <strong>{{trans('messages.webpage')}}:</strong> {{$client->webpage}}
      </p>
      <!--FECHA-->
      <p>
        <strong>{{trans('messages.sub')}}:</strong> {{$client->sub_domain}}
      </p>
      <!--FECHA-->
      <p>
        <strong>{{trans('messages.name_manager')}}:</strong> {{$client->name_manager}}
      </p>
      <!--FECHA-->
      <p>
        <strong>{{trans('messages.last_name_manager')}}:</strong> {{$client->last_name_manager}}
      </p>
      <!--FECHA-->
      <p>
        <strong>{{trans('messages.phone_manager')}}:</strong> {{$client->phone_manager}}
      </p>
      <!--FECHA-->
      <p>
        <strong>{{trans('messages.email_manager')}}:</strong> {{$client->email_manager}}
      </p>
    </div>
    <div class="col-md-12">
      <div class="panel panel-default">
          <div class="panel-heading">
            <i class="fa fa-list fa-fw" ara-hidden="true"></i>
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
                <tr>
                  <td>Registrado</td>
                  <td>{{$client->created_at}}</td>
                </tr>
              </tbody>
            </table>
          </div>
      </div>
    </div>
  </div>
</div>
