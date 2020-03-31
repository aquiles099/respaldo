<form role="form" action="{{asset($path)}}" method="post">
  <fieldset class="form">
    <!--Primer cuadro, se muestra tracking, origen y destino-->
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped">
            <tr>
              <td><b>{{trans('package.tracking')}}:</b></td>
              <td>{{isset($package) ? $package->code : Input::get('code')}}</td>
            </tr>
            <tr>
              <td><b>{{trans('package.from')}}:</b></td>
              <td>{{isset($package) ? (isset($package->from_client) ? $package->getClient['name'] : $package->getCourier['name']) : ''}}</td>
            </tr>
            <tr>
              <td><b>{{trans('package.to')}}:</b></td>
              <td>{{isset($package) ? (isset($package->to_client) ? $package->getToClient['name'] : $package->getToUser['name']) : ''}}</td>
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
              <td>{{isset($package) ? $package->getType['spanish'] : Input::get('type')}}</td>
            </tr>
            <tr>
              <td><b>{{trans('package.category')}}:</b></td>
              <td>{{isset($package) ? $package->getCategory['label'] : Input::get('category')}}</td>
            </tr>
            <tr>
              <td><b>{{trans('package.status')}}:</b></td>
              <td>{{isset($package) ? $package->getLastEvent['name'] : Input::get('last_event')}}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <!-- listar estados del paquete y cambiar los mismos -->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="col-md-10">
            <select  class="form-control " id="event" name="event" required="true" @include('form.readonly')>
                 @foreach ($event as $row)
                   <option value={{$row->description}}> {{$row->description}}</option>
                 @endforeach
              </select>
          </div>
          <div class="col-md-2">
            <button  type="submit" class="btn btn-info">
              <i class="fa fa-floppy-o" aria-hidden="true"></i> {{trans('messages.save')}}
            </button>
          </div>
        </div>
      </div>
    </div>
    <!--Tabla de eventos del paquete actual -->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="text-center" id="clientTitle" style="display:block;">
              <div class="pull-center">{{trans('messages.events')}}</div>
          </h3>
        </div>
        <div class="panel-body">
          <table class="table table-striped" id="tableHeader">
            <thead>
              <tr>
                <th style="width:5%">{{trans('messages.id')}}</th>
                <th style="width:10%">{{trans('messages.package')}}</th>
                <th style="width:20%">{{trans('messages.user')}}</th>
                <th style="width:20%">{{trans('messages.event')}}</th>
                <th style="width:20%">{{trans('messages.previousEvent')}}</th>
                <th style="width:50%">{{trans('messages.observation')}}</th>
                <th style="width:20%">{{trans('messages.date')}}</th>
              </tr>
            </thead>
            <tbody id="table">
              @if(isset($packageLog))
                @foreach ($packageLog as $row)
                  <tr>
                    <td>{{$row->id}}</td>
                    <td>{{$package->code}}</td>
                    <td>{{ucwords($row->getUser['name']9}}</td>
                    <td>{{ucwords($row->getEvent['name'])}}</td>
                    <td>{{ucwords($row->getPreviousEvent['name'])}}</td>
                    <td>{{ucfirst($row->observation)}}</td>
                    <td>{{$row->created_at}}</td>
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
</form>
