<div class="panel panel-default">
  <div class="panel-heading">
    {{trans('solicitude.status')}}:
    <strong>{{$solicitude->getStatus->name}}</strong>
    @if($solicitude->status >= App\Helpers\HStatus::FORMRECEIVED)
      <span class="pull-right">
        <strong>
          <a class="icslinkdetails" onclick="icsViewInfoApplicant({{$solicitude->id}},{{$solicitude->client}})">{{trans('solicitude.viewcontactdata')}}</a>
        </strong>
        <i class="fa fa-user fa-fw" aria-hidden="true"></i>
      </span>
    @endif
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-body">
              <!--Codigo-->
              <p>
                <strong>Codigo:</strong> {{$solicitude->code}}
              </p>
              <!--Asunto-->
              <p>
                <strong>Asunto:</strong> {{$solicitude->subject}}
              </p>
              <!--Description-->
              <p>
                <strong>Descripcion:</strong> {{$solicitude->description}}
              </p>
              <!--Fecha de Creacion-->
              <p>
                <strong>Fecha de Creacion:</strong> {{$solicitude->created_at}}
              </p>
              <!--Fecha de Actualizacion-->
              <p>
                <strong>Fecha de Actualizacion:</strong> {{$solicitude->updated_at}}
              </p>
              <!--Admin-->
              <p>
                <strong>Administrador: </strong> {{isset($solicitude->getAdmin) ? $solicitude->getAdmin->code.' '.$solicitude->getAdmin->name  : trans('messages.unknown')}}
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-body">
                <!--Cliente-->
                <p>
                    <strong>Cliente:</strong> {{$solicitude->getClient->name}}
                </p>
                <!--Correo-->
                <p>
                    <strong>Correo:</strong> {{$solicitude->getClient->email}}
                </p>
                <!--Sitio web-->
                <p>
                    <strong>Sitio Web:</strong> {{isset($solicitude->getClient->webpage) ? $solicitude->getClient->webpage : trans('messages.unknown')}}
                </p>
                <!--Telefono-->
                <p>
                    <strong>Teléfono:</strong> {{isset($solicitude->getClient->phone) ? $solicitude->getClient->phone : trans('messages.unknown') }}
                </p>
                <!--Pais-->
                <p>
                    <strong>Pais:</strong> {{isset($solicitude->getClient->getCountry->name) ? $solicitude->getClient->getCountry->name : trans('messages.unknown')}}
                </p>
                <!--Region -->
                <p>
                  <strong>Region:</strong> {{isset($solicitude->getClient->getCountry->name) ? $solicitude->getClient->getCountry->region : trans('messages.unknown')}}
                </p>
            </div>
          </div>
        </div>
      </div>
      @if($solicitude->status < App\Helpers\HStatus::APROVED)
      <div class="col-md-12">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="col-md-9">
                <form class="" id="icsserializeform" method="post">
                  <div class="{{$solicitude->status == App\Helpers\HStatus::PROCESED ? 'col-md-6' : 'col-md-12'}}">
                    <select class="form-control" name="status" id="status">
                      @foreach($status as $key => $value)
                        @if($value->id > $solicitude->status && $value->id < App\Helpers\HStatus::PAYED)
                          <option value="{{$value->id}}">{{$value->name}}</option>
                        @endif
                      @endforeach
                      </select>
                  </div>
                  @if($solicitude->status == App\Helpers\HStatus::PROCESED)
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="sub" name="sub" placeholder="{{trans('messages.sub')}}" value="{{$solicitude->getClient->webpage}}" style="height: 35px">
                  </div>
                  @endif
                  </form>
                </div>
                <div class="col-md-3">
                  <button class="btn btn-primary btn-xs" style="width: 100%" id="sendButton" onclick="icsUpdateSolicitude({{$solicitude->id}})">Guardar</button>
                </div>
            </div>
          </div>
        </div>
      </div>
      @endif
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
                    <td>{{$value->description}} </td>
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
