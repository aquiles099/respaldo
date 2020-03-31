
<script type="text/javascript" src="{!! asset('js/includes/showpackageCtrl.js') !!}"></script>
<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
      <!--Primer cuadro, se muestra tracking, origen y destino-->
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <table class="table table-striped">
              <tr>
                <td><b>{{trans('package.code')}}:</b></td>
                <td>{{isset($package) ? $package->code : Input::get('code')}}</td>
              </tr>
              <tr>
                <td><b>{{trans('package.from')}}:</b></td>
                <td>{{isset($package) ? (isset($package->to_client) ? $companyclient->name : $package->getCourier['name']) : ''}}</td>
              </tr>
              <tr>
                <td><b>{{trans('package.to')}}:</b></td>
                <td>{{isset($package) ? (isset($package->to_client) ? $package->getToClient['code']."-".$package->getToClient['name'] : $package->getToUser['code']."-".$package->getToUser['name']." ".$package->getToUser['last_name']) : ''}}</td>
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
                <td>{{isset($package->type) ? $package->getType->spanish : Input::get('category')}}</td>
              </tr>
              <tr>
                <td><b>{{trans('package.category')}}:</b></td>
                <td>{{isset($package) ? $package->getCategory['label'] : Input::get('category')}}</td>
              </tr>
              <tr>
                <td><b>{{trans('package.status')}}:</b></td>
                <td>
                  @if($package->last_event == '1')
                    <span class="label label-default">{{$package->getLastEvent->name}}</span>
                  @elseif($package->last_event == '2')
                    <span class="label label-primary">{{$package->getLastEvent->name}}</span>
                  @elseif($package->last_event == '3')
                    <span class="label label-info">{{$package->getLastEvent->name}}</span>
                  @elseif($package->last_event == '4')
                    <span class="label label-info">{{$package->getLastEvent->name}}</span>
                  @elseif($package->last_event == '5')
                    <span class="label label-warning">{{$package->getLastEvent->name}}</span>

                  @elseif($package->last_event == '6')
                    <span class="label label-success">{{$package->getLastEvent->name}}</span>
                  @endif
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    @if(!isset($noInvoice) || $noInvoice != true)
      <!-- listar estados del paquete y cambiar los mismos -->
      @if($package->last_event <= $events_num+1)
        <div class="row">
          <div class="col-md-12" id="packevnt">
            <div class="panel panel-default">
              <div class="panel-body">

                <div class="col-md-6 " style="padding-right: 0px;padding-left: 0px;">
                  <label class="col-lg-3 control-label" style="padding-top: 5px;" id="labelDirection" >{{trans('package.observation')}}:</label>
                  <div class="col-lg-9">
                     <input class="form-control" style="height:28px" placeholder="{{trans('package.observation')}}" id="observation" name="observation" type="text" value="" @include('form.readonly')>
                              @include('errors.field', ['field' => 'obervation'])
                  </div>
                </div>
                <div class="col-md-4" style="padding-right: 0px;padding-left: 0px;">
                  <label class="col-lg-3 control-label" id="labelDirection" style="padding-top: 5px;" >{{trans('package.status')}}:</label>
                  <div class="col-lg-9">
                    <select  class="form-control " id="event" name="event" required="true" @include('form.readonly')>
                         @foreach ($event as $row)
                            @if($row->id > $package->last_event)
                                <option value={{$row->id}}> {{$row->name}}</option>
                            @endif
                         @endforeach
                      </select>
                  </div>
                </div>
                <div class="col-md-2" id="button">
                  <button type="button" class="btn btn-primary" onclick="this.disabled = true;changestatuspackage({{$package->id}})">
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
        </div>
      @endif
    @endif
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">{{trans('cargoRelease.cargoContain')}} <span class="pull-right"><i class="fa fa-cubes" aria-hidden="true"></i></span></div>
          <div class="panel-body">
           <table class="table text-center table-striped table-responsive table-hover table-bordered" id="tableHeader">
            <thead>
              <tr style="padding: 4px;">
                <th style="width:20%;padding: 4px;">Piezas</th>
                <th style="width:20%;padding: 4px;">Dimensiones</th>
                <th style="width:20%;padding: 4px;">Descrpción</th>
                <th style="width:20%;padding: 4px;">Peso</th>
                <th style="width:20%;padding: 4px;">Volumen</th>
              </tr>
            </thead>
            <tbody id="table">
              @foreach ($detailspack as $row)
              <tr style="padding: 4px;">
                <td style="text-align: center;padding: 4px;"> {{$row->pieces}}</td>
                <td style="text-align: center;padding: 4px;"> {{$row->large}}x{{$row->width}}x{{$row->height}}</td>
                <td style="text-align: center;padding: 4px;"> {{$row->name}}</td>
                <td style="text-align: center;padding: 4px;"> {{$row->weight}}lb</td>
                @if($package->type == 1)
                  <td style="text-align: center;padding: 4px;"> {{$row->volumetricweightm}}ft<sup>3</sup></td>
                @endif
                @if($package->type == 2)
                  <td style="text-align: center;padding: 4px;"> {{$row->volumetricweighta}}Vlb</td>
                @endif
              </tr>
               @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
          <!--Tabla de eventos del paquete actual -->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">{{trans('cargoRelease.eventList')}}
            <span class="pull-right"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></span>
          @foreach($invoice as $file)
            <span class="pull-right" id="packinvo">
              <a href="{{$file->path}}" download="{{trans('messages.invoice')}}" style="margin-right: 10px">
                <small>{{trans('messages.inv')}} <i class="fa fa-download" aria-hidden="true"></i></small>
             </a>
           </span>
         @endforeach
      </div>
        <div class="panel-body">
          <table class="table text-center table-striped table-responsive table-hover table-bordered" id="tableHeader">
            <thead>
              <tr style="padding: 4px;">
                <th style="width:20%">{{trans('messages.code')}}</th>
                <th style="width:20%">{{trans('messages.user')}}</th>
                <th style="width:20%">{{trans('messages.event')}}</th>
                <th style="width:30%">{{trans('messages.observation')}}</th>
              </tr>
            </thead>
            <tbody id="table">
              @if(isset($packageLog))
                @foreach ($packageLog as $row)
                  <tr style="padding: 4px;">
                    <td style="text-align: center;padding: 4px;" >WR-{{substr($package->code,6,8)}}</td>
                    <td style="text-align: center;padding: 4px;" >{{$row->getUser['name']}}</td>
                    <td style="text-align: center;padding: 4px;" >{{$row->getEvent['name']}}</td>
                    <td style="text-align: center;padding: 4px;">{{$row->observation}}</td>
                  </tr>
                @endforeach
              @endif
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>
