<div class="panel panel-default col-md-6" id="pnlcli" >
  <span class="text-center"><h4>{{trans('messages.clients')}}</h4></span>
  <hr>
  <div class="panel-body">
    <table class="table table-striped table-hover" id="dtble">
      <thead>
        <tr>
          <th style="width:10%">{{trans('messages.id')}}</th>
          <th style="width:50%">{{trans('messages.name')}}</th>
          <th style="width:25%">{{trans('messages.code')}}</th>
          <th style="width:15%">{{trans('messages.actions')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr item="">
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->code}}</td>
            <td>
              <ul class="table-actions">
                <li><a onclick="deleteClient({{$user->id}}, true)" ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                <li><a href="javascript:editClient({{$user->id}}, true)"><i class="fa fa-eye" title="{{trans('messages.details')}}"></i></a></li>
              </ul>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
