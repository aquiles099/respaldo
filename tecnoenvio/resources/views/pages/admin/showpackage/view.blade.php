@include('sections.translate')

  <fieldset class="form">
    <!--Primer cuadro, se muestra tracking, origen y destino-->
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped">
            <tr>
              <td><b>{{trans('messages.code')}}:</b></td>
              <td>{{isset($package) ? $package->code : Input::get('code')}}</td>
            </tr>
            <tr>
              <td><b>{{trans('package.from')}}:</b></td>
              <td>{{isset($package) ? (isset($package->to_client) ? $companyclient->name : $package->getCourier['name']) : ''}}</td>
            </tr>
            <tr>
              <td><b>{{trans('package.to')}}:</b></td>
              @if(isset($package) && $package->to_client != null)
                <td>{{$package->getToClient->getCompany->name}} {{$package->getToClient->code}} {{$package->getToClient->name}} {{$package->getToClient->email}} </td>
              @else
                <td>@if($package->to_user != null) {{$package->getToUser->code}} {{$package->getToUser->name}} {{$package->getToUser->email}} @endif</td>
              @endif
            </tr>
            <tr>
              <td><b>{{trans('messages.destiny')}}:</b></td>
              <td>{{isset($package->getOficce) ? strtoupper($package->getOficce->direction) : '' }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <!--Segundo cuadro, se muestra tipo, categoria y estado -->
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped">
            <tr>
              <td><b>{{trans('package.type')}}:</b></td>
              <td>{{isset($package) ? $package->getType['spanish']: ''}}</td>
            </tr>
            <tr>
              <td><b>{{trans('package.category')}}:</b></td>
              <td>{{isset($package) ? $package->getCategory->label : ''}}</td>
            </tr>
            <tr>
              <td><b>{{trans('package.status')}}:</b></td>
              <td>{{isset($package) ? $package->getLastEvent->description : ''}}</td>
            </tr>
            <tr>
              <td><b>{{trans('messages.order_service')}}:</b></td>
              <td>{{isset($package) ? $package->order_service : ''}}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <!-- listar estados del paquete y cambiar los mismos -->
    @if($package->last_event <= 5)
    <div class="col-md-12" id="packevnt">
      <div class="panel panel-default">
         <div class="panel-body">
            <div class="col-md-6 " style="padding-right: 0px;padding-left: 0px;">
              <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.observation')}}:</label>
              <div class="col-lg-9">
                 <input class="form-control" style="height:28px" placeholder="{{trans('package.observation')}}" id="observation" name="observation" type="text" value="" @include('form.readonly')>
                          @include('errors.field', ['field' => 'obervation'])
              </div>
            </div>
            <div class="col-md-4" style="padding-right: 0px;padding-left: 0px;">
              <label class="col-lg-3 control-label" id="labelDirection" >{{trans('package.status')}}:</label>
              <div class="col-lg-9">
                <select  class="form-control " id="event" name="event" required="true" @include('form.readonly')>
                     @foreach ($event as $row)
                        @if(($row->id > $package->last_event)&&($row->active != 0))
                          <option value={{$row->id}}> {{$row->name}}</option>
                       @endif
                     @endforeach
                  </select>
              </div>
            </div>
            <div class="col-md-2" id="button">
              <button  type="button" class="btn btn-primary" onclick="changestatuspackage({{$package->id}})">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> {{trans('messages.save')}}
              </button>
            </div>
          </div>
      </div>
    </div>
    <div class="progress" id="cl"  style="display:none; margin-left:100px; width:80%;">
      <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:50%">
        <span class="sr-only"></span>
      </div>
    </div>
    @endif
    <!--Tabla de eventos del paquete actual -->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="pull-center">{{trans('messages.events')}}
            @foreach($invoice as $file)
              <span class="pull-right" id="packinvo">
                <a href="{{$file->path}}" download="{{trans('messages.invoice')}}">
                  <small>{{trans('messages.invoice')}} <i class="fa fa-download" aria-hidden="true"></i></small>
               </a>
             </span>
           @endforeach
        </div>
        </div>
        <div class="panel-body">
          <table class="table table-striped" id="dtble2">
            <thead>
              <tr style="text-align:center">
                <th>{{trans('messages.package')}}</th>
                <th>{{trans('messages.user')}}</th>
                <th>{{trans('messages.event')}}</th>
                <th>{{trans('messages.observation')}}</th>
              </tr>
            </thead>
            <tbody id="table">
              @if(isset($packageLog))
                @foreach ($packageLog as $row)
                  <tr style="text-align: center">
                    <td>{{$package->code}}</td>
                    <td>{{$row->getUser['name']}}</td>
                    <td>{{$row->getEvent['description']}}</td>
                    <td>{{$row->observation}}</td>
                  </tr>
                @endforeach
              @endif
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </fieldset>
