<div class="panel panel-default col-md-6" id="pnlcli" >
  <span class="text-center"><h4>{{trans('messages.clients')}}</h4></span>
  <hr>
  <div class="panel-body">
    <table class="table table-striped table-hover text-center" id="dtble2">
      <thead>
        <tr>
          <th style="width:10%">{{trans('messages.id')}}</th>
          <th style="width:50%">{{trans('messages.name')}}</th>
          <th style="width:25%">{{trans('messages.code')}}</th>
          <th style="width:15%">{{trans('messages.actions')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach($clients as $client)
          <tr item="">
            <td>{{ucwords($client->id)}}</td>
            <td>{{ucwords($client->name)}}</td>
            <td>{{ucwords($client->code)}}</td>
            <td>
              <ul class="table-actions">
                <li><a href="javascript:editClient({{$client->id}}, false)"><i class="fa fa-eye" title="{{trans('messages.details')}}"></i></a></li>
                <li><a onclick="deleteClient({{$client->id}}, false)" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
              </ul>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
