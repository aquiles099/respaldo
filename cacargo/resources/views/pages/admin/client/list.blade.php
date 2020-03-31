<div class="panel panel-default col-md-6" id="pnlcli" >
  <span class="text-center"><h4>{{trans('messages.clients')}}</h4></span>
  <hr>
  <div class="panel-body">
    <table class="table table-striped table-hover" id="dtble">
      <thead>
        <tr>
          <th>{{trans('messages.id')}}</th>
          <th>{{trans('messages.name')}}</th>
          <th>{{trans('messages.code')}}</th>
          <th>{{trans('messages.actions')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach($clients as $client)
          <tr item="">
            <td>{{$client->id}}</td>
            <td>{{$client->name}}</td>
            <td>{{$client->code}}</td>
            <td>
              <ul class="table-actions">
                <li><a onclick="deleteClient({{$client->id}}, false)" ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                <li><a href="javascript:editClient({{$client->id}}, false)"><i class="fa fa-eye" title="{{trans('messages.details')}}"></i></a></li>
              </ul>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
