<form role="form" action="" id="showpackage" method="post">
  <fieldset class="form">
    <!--Primer cuadro, se muestra tracking, origen y destino-->
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped">
            <tr>
              <td><b>{{trans('consolidated.code')}}:</b></td>
              <td>{{isset($consolidated) ? $consolidated->code : Input::get('code')}}</td>
            </tr>
            <tr>
              <td><b>{{trans('consolidated.description')}}:</b></td>
              <td>{{isset($consolidated) ? $consolidated->description : Input::get('description')}}</td>
            </tr>
            <tr>
              <td><b>{{trans('consolidated.observation')}}:</b></td>
              <td>{{isset($consolidated) ? $consolidated->observation : Input::get('observation')}}</td>
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
              <td><b>{{trans('consolidated.status')}}:</b></td>
              <td>{{isset($consolidated) ? (($consolidated->status == 1) ? trans('consolidated.open') :  trans('consolidated.close')) : 'status'}}</td>
            </tr>
            <tr>
              <td><b>{{trans('messages.date')}}:</b></td>
              <td>{{isset($consolidated) ? $consolidated->created_at : Input::get('created_at')}}</td>
            </tr>
            <tr>
              <td><b>{{trans('package.status')}}:</b></td>
              <td>{{$consolidated->getLastEvent['description']}}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <!-- listar estados del paquete y cambiar los mismos -->
    @if($consolidated->last_event <= 5)
    <div class="col-md-12" id="packevnt">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="col-md-10">
            <select  class="form-control " id="event" name="event" required="true" @include('form.readonly')>
               @foreach ($event as $row)
                 @if($row->id > $consolidated->last_event)
                  <option value="{{$row->id}}"> {{$row->description}}</option>
                 @endif
               @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-primary" onclick="changestatusconsolidated({{$consolidated->id}})">
               <i class="fa fa-floppy-o" aria-hidden="true"></i>
                 {{trans('messages.save')}}
            </button>
          </div>
        </div>
      </div>
    </div>
    @endif
    <!--Tabla de eventos del paquete actual -->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-center">{{trans('package.list')}}</div>
        </div>
        <div class="panel-body">
          <table class="table table-striped" id="tableHeader">
            <thead>
              <tr>
                <th>{{trans('messages.code')}}</th>
                <th>{{trans('messages.tracking')}}</th>
                <th>{{trans('messages.date')}}</th>
                <th>{{trans('messages.event')}}</th>
              </tr>
            </thead>
            <tbody id="table">
              @if(isset($packageConsolidated))
                @foreach ($packageConsolidated as $row)
                  <tr>
                    <td>{{$row->getPackage->code}}</td>
                    <td>{{$row->getPackage->tracking}}</td>
                    <td>{{$row->created_at}}</td>
                    <td>{{$consolidated->getLastEvent['description']}}</td>
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
