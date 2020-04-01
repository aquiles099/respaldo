<div class="panel panel-default">
  <div class="panel-heading">{{trans('user.name')}}: <strong>{{$user->name}}</strong></div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        @if($user->user_type == App\Helpers\HUserType::SELLER || $user->user_type == App\Helpers\HUserType::MASTER)
          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-body">
                <h1>
                  <i class="fa fa-bullhorn fa-fw"></i>
                  {{trans('menu.solicitudes')}}
                  <span class="pull-right">{{$solicitudes->count()}}</span>
                </h1>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-body">
                <h1>
                  <i class="fa fa-user fa-fw"></i>
                  {{trans('menu.clients')}}
                  <span class="pull-right">{{$clients->count()}}</span>
                </h1>
              </div>
            </div>
          </div>
        @elseif($user->user_type == App\Helpers\HUserType::WRITTER)
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <h1>
                <i class="fa fa-file-text-o fa-fw"></i>
                {{trans('menu.news')}}
                <span class="pull-right">{{$notices->count()}}</span>
              </h1>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">{{trans('messages.logaction')}}</div>
            <div class="panel-body">
              <table class="table table-bordered table-hover table-responsive table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{trans('messages.date')}}</th>
                  <th>{{trans('messages.description')}}</th>
                </tr>
              </thead>
                <tbody>
                  @foreach($logs as $key => $value)
                  <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$value->created_at}}</td>
                    <td>{{$value->description}}</td>
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
