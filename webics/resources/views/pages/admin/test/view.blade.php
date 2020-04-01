<div class="panel panel-default">
  <div class="panel-heading">
    {{trans('solicitude.status')}}:
    <strong>
      {{isset($test->getStatus) ? $test->getStatus['name'] : trans('messages.unknown')}}
    </strong>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-body">
            <!---->
              <p>
                <strong>Codigo:</strong> {{$test->code}}
              </p>
            <!---->
              <p>
                <strong>Solicitud:</strong> {{$test->getSolicitude->code}}
              </p>
            <!---->
              <p>
                <strong>Fecha de Solicitud:</strong> {{$test->getSolicitude->created_at}}
              </p>
            <!---->
              <p>
                <strong>Fecha de Creacion Prueba:</strong> {{$test->created_at}}
              </p>
            <!---->
              <p>
                <strong>Fecha de Fin de Prueba:</strong> {{$test->cutoff_date}}
              </p>
            <!---->
              <p>
                <strong>Operadores:</strong> {{$test->operators}}
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-body">
              <!---->
                <p>
                    <strong>Cliente:</strong> {{$test->getClient->name}}
                </p>
              <!---->
                <p>
                    <strong>Correo:</strong> {{$test->getClient->email}}
                </p>
              <!---->
                <p>
                    <strong>Sitio Web:</strong> {{$test->getClient->webpage}}
                </p>
              <!---->
                <p>
                    <strong>Sub-Dominio:</strong> {{$test->getClient->sub_domain}}
                </p>
              <!---->
                <p>
                    <strong>Pais:</strong> {{isset($test->getClient->getCountry->name) ? $test->getClient->getCountry->name : ''}}
                </p>
              <!---->
                <p>
                  <strong>Clientes:</strong> {{$test->clients}}
                </p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="col-md-10">
                <form class="" id="icsserializeform" method="post">
                  <div class="col-md-6">
                    <select class="form-control" name="status">
                      @foreach($status as $key => $value)
                        @if($value->id < 6)
                         <option value="{{$value->id}}">{{$value->name}}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6">
                    <input class="form-control" type="text" name="description" placeholder="{{trans('messages.observation')}}" value="" style="height: 35px;" >
                  </div>
                </form>
              </div>
              <div class="col-md-2">
                <button type="button" class="btn btn-primary" id="sendButton" name="button" onclick="icsChangeStatusTest({{$test->id}})">{{trans('messages.send')}}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Logs-->
      <div class="col-md-12">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <table class="table table-striped table-hover table-bordered table-responsive">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>{{trans('messages.status')}}</th>
                    <th>{{trans('messages.description')}}</th>
                    <th>{{trans('messages.date')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($logs as $key => $value)
                   <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$value->getStatus->name}}</td>
                    <td>{{$value->description}}</td>
                    <td>{{$value->created_at}}</td>
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
