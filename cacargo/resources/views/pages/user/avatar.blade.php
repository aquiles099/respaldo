<div class="panel panel-default">
  <div class="panel-body">
    <div class="jumbotron">
      <center>
        <a href="javascript:icsUpdatePicProfile(false)" data-toggle="tooltip" title="{{trans('messages.changeavatar')}}">
          <img class="img-responsive img-rounded" src="{{asset('/dist/images/user.jpg')}}" alt=""  />
        </a>
      </center>
    </div>
  </div>
  <div class="panel-footer">
    <div class="text-muted">
      <i aria-hidden="true" class="fa fa-user"></i>
      @if(isset($user))
        {{strtoupper($user->name)}} {{strtoupper($user->last_name)}}
        <strong>({{$user->code}})</strong>
      @endif
    </div>
  </div>
</div>
