<?php
use App\Models\Admin\Event;
use App\Models\Admin\User;

$user = User::find(Session::get('key-sesion')['data']->id);

if(isset($package) && !is_null($package->getLastEvent)) {
  $position = $package->getLastEvent->step;
}
else {
  $position = -1;
}
$events_num = Event::query()->where('active','=',1)->count();


?>
@set('only')
<?php
use App\Helpers\HUserType;
use App\Helpers\HConstants;
use Carbon\Carbon;
/**
*
*/
  if(Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
  $today = Carbon::now()->format('Y-m-d');
  /**
  *
  */
?>
@set('js', ['js/includes/resellerCtrl.js'])
@section('pageTitle', trans('menu.casillero'))
@section('title', trans('menu.casillero'))
@section('icon-title')
  <i aria-hidden="true" class="fa fa-cubes"></i>
@stop
@section('title-actions')
<a href="{{isset($filter) ? asset('account/') : '#section' }}" class="btn btn-primary" @if(!isset($filter)) data-toggle="collapse" @endif>
  <span><i class="{{isset($filter) ? 'fa fa-list' : 'fa fa-filter' }}"></i></span>
  {{isset($filter) ? trans('messages.list') : trans('Historial')}}
</a>
@stop
@extends('pages.page')
@include('sections.translate')
@section('body')
@if((Session::get('with')) == "successMessage")
<script type="text/javascript">
$(document).ready(function() {
  $('#pnlin').html('<i class="fa fa-spin fa-spinner"></i> Cargando...');
    setTimeout(function () {
      window.location.href = "asset('/')";
      {{Session::set('with','')}}
  },2000);
});
</script>
@endif
  @include('sections.messages')
    @include('pages.user.filter',[
      'path' => 'account'
    ])
  <div class="panel panel-default usrtrck" id = "pnlin">
    @if($packages->count() == 0)
    <div class="panel-heading text-center">
      <span class="text-muted">
          {{trans('messages.noMomentPackages')}}
        <i class="fa fa-exclamation" aria-hidden="true"></i>
      </span>
    </div>
    <div class="panel-body">
    @else
    <div class="panel-heading text-center">
      <span class="text-muted">
        <i class="fa fa-cubes" aria-hidden="true"></i>
        {{trans('messages.packages')}}
      </span>
    </div>
    <div class="panel-body">
      <table class="table table-responsive" id="dtble">
        <thead>
          <tr>
              <th style="text-align: center">{{trans('messages.code')}}</th>
              <th style="text-align: center">{{trans('messages.tracking')}}</th>
              <th style="text-align: center">{{trans('messages.date')}}</th>
              <th style="text-align: center">{{trans('package.status')}}</th>
              <th style="text-align: center">{{trans('messages.progress')}}</th>
              <th style="text-align: center">{{trans('messages.invoice')}}</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($packages as $package)
            <tr>
              <td style="vertical-align:middle">{{$package->code}}</td>
              <td style="vertical-align:middle"><a class="infoRd" href="javascript:details({{$package->id}})">{{$package->tracking}}</a></td>
              <td style="vertical-align:middle">{{$package->created_at}}</td>
              <td style="vertical-align:middle">
                @if($package->getLastEvent->step == 0) {{$events[0]->name}} @endif
                @if($package->getLastEvent->step == 1) {{$events[1]->name}} @endif
                @if($package->getLastEvent->step == 2) {{$events[2]->name}} @endif
                @if($package->getLastEvent->step == 3) {{$events[3]->name}} @endif
                @if($package->getLastEvent->step == 4) {{$events[4]->name}} @endif
                @if($package->getLastEvent->step == 5) {{$events[5]->name}} @endif
              </td >
              <td style="background-color:white; vertical-align:middle">
                <ul class="nav nav-wizard" style="padding-left: 6%">
                  @if($events_num == 1)
                      @if($events[0]->active==1)<li style="width:100%;" @if($package->getLastEvent->step == 0) class="active" @endif><a>{{$events[0]->name}}</a></li>@endif
                      @if($events[1]->active==1)<li style="width:100%;" @if($package->getLastEvent->step == 1) class="active" @endif><a>{{$events[1]->name}}</a></li>@endif
                      @if($events[2]->active==1)<li style="width:100%;" @if($package->getLastEvent->step == 2) class="active" @endif><a>{{$events[2]->name}}</a></li>@endif
                      @if($events[3]->active==1)<li style="width:100%;" @if($package->getLastEvent->step == 3) class="active" @endif><a>{{$events[3]->name}}</a></li>@endif
                      @if($events[4]->active==1)<li style="width:100%;" @if($package->getLastEvent->step == 4) class="active" @endif><a>{{$events[4]->name}}</a></li>@endif
                      @if($events[5]->active==1)<li style="width:100%;" @if($package->getLastEvent->step == 5) class="active" @endif><a>{{$events[5]->name}}</a></li>@endif
                  @endif

                  @if($events_num == 2)
                      @if($events[0]->active==1)<li style="width:50%;" @if($package->getLastEvent->step == 0) class="active" @endif><a>{{$events[0]->name}}</a></li>@endif
                      @if($events[1]->active==1)<li style="width:50%;" @if($package->getLastEvent->step == 1) class="active" @endif><a>{{$events[1]->name}}</a></li>@endif
                      @if($events[2]->active==1)<li style="width:50%;" @if($package->getLastEvent->step == 2) class="active" @endif><a>{{$events[2]->name}}</a></li>@endif
                      @if($events[3]->active==1)<li style="width:50%;" @if($package->getLastEvent->step == 3) class="active" @endif><a>{{$events[3]->name}}</a></li>@endif
                      @if($events[4]->active==1)<li style="width:50%;" @if($package->getLastEvent->step == 4) class="active" @endif><a>{{$events[4]->name}}</a></li>@endif
                      @if($events[5]->active==1)<li style="width:50%;" @if($package->getLastEvent->step == 5) class="active" @endif><a>{{$events[5]->name}}</a></li>@endif
                  @endif

                  @if($events_num == 3)
                      @if($events[0]->active==1)<li style="width:33%;" @if($package->getLastEvent->step == 0) class="active" @endif><a>{{$events[0]->name}}</a></li>@endif
                      @if($events[1]->active==1)<li style="width:33%;" @if($package->getLastEvent->step == 1) class="active" @endif><a>{{$events[1]->name}}</a></li>@endif
                      @if($events[2]->active==1)<li style="width:33%;" @if($package->getLastEvent->step == 2) class="active" @endif><a>{{$events[2]->name}}</a></li>@endif
                      @if($events[3]->active==1)<li style="width:33%;" @if($package->getLastEvent->step == 3) class="active" @endif><a>{{$events[3]->name}}</a></li>@endif
                      @if($events[4]->active==1)<li style="width:33%;" @if($package->getLastEvent->step == 4) class="active" @endif><a>{{$events[4]->name}}</a></li>@endif
                      @if($events[5]->active==1)<li style="width:33%;" @if($package->getLastEvent->step == 5) class="active" @endif><a>{{$events[5]->name}}</a></li>@endif
                  @endif

                  @if($events_num == 4)
                      @if($events[0]->active==1)<li style="width:25%;" @if($package->getLastEvent->step == 0) class="active" @endif><a>{{$events[0]->name}}</a></li>@endif
                      @if($events[1]->active==1)<li style="width:25%;" @if($package->getLastEvent->step == 1) class="active" @endif><a>{{$events[1]->name}}</a></li>@endif
                      @if($events[2]->active==1)<li style="width:25%;" @if($package->getLastEvent->step == 2) class="active" @endif><a>{{$events[2]->name}}</a></li>@endif
                      @if($events[3]->active==1)<li style="width:25%;" @if($package->getLastEvent->step == 3) class="active" @endif><a>{{$events[3]->name}}</a></li>@endif
                      @if($events[4]->active==1)<li style="width:25%;" @if($package->getLastEvent->step == 4) class="active" @endif><a>{{$events[4]->name}}</a></li>@endif
                      @if($events[5]->active==1)<li style="width:25%;" @if($package->getLastEvent->step == 5) class="active" @endif><a>{{$events[5]->name}}</a></li>@endif
                  @endif

                  @if($events_num == 5)
                      @if($events[0]->active==1)<li style="width:20%;" @if($package->getLastEvent->step == 0) class="active" @endif><a>{{$events[0]->name}}</a></li>@endif
                      @if($events[1]->active==1)<li style="width:20%;" @if($package->getLastEvent->step == 1) class="active" @endif><a>{{$events[1]->name}}</a></li>@endif
                      @if($events[2]->active==1)<li style="width:20%;" @if($package->getLastEvent->step == 2) class="active" @endif><a>{{$events[2]->name}}</a></li>@endif
                      @if($events[3]->active==1)<li style="width:20%;" @if($package->getLastEvent->step == 3) class="active" @endif><a>{{$events[3]->name}}</a></li>@endif
                      @if($events[4]->active==1)<li style="width:20%;" @if($package->getLastEvent->step == 4) class="active" @endif><a>{{$events[4]->name}}</a></li>@endif
                      @if($events[5]->active==1)<li style="width:20%;" @if($package->getLastEvent->step == 5) class="active" @endif><a>{{$events[5]->name}}</a></li>@endif
                  @endif

                  @if($events_num == 6)
                      @if($events[0]->active==1)<li style="width:16%;" @if($package->getLastEvent->step == 0) class="active" @endif><a>{{$events[0]->name}}</a></li>@endif
                      @if($events[1]->active==1)<li style="width:16%;" @if($package->getLastEvent->step == 1) class="active" @endif><a>{{$events[1]->name}}</a></li>@endif
                      @if($events[2]->active==1)<li style="width:16%;" @if($package->getLastEvent->step == 2) class="active" @endif><a>{{$events[2]->name}}</a></li>@endif
                      @if($events[3]->active==1)<li style="width:16%;" @if($package->getLastEvent->step == 3) class="active" @endif><a>{{$events[3]->name}}</a></li>@endif
                      @if($events[4]->active==1)<li style="width:16%;" @if($package->getLastEvent->step == 4) class="active" @endif><a>{{$events[4]->name}}</a></li>@endif
                      @if($events[5]->active==1)<li style="width:16%;" @if($package->getLastEvent->step == 5) class="active" @endif><a>{{$events[5]->name}}</a></li>@endif
                  @endif
                </ul>
              </td>
              <td style="vertical-align:middle">
              @if($package->invoice == false)
                @if($package->last_event < HConstants::EVENT_DELIVERED)
                  <a href="{{asset("account/upload/{$package->id}")}}" title="{{trans('messages.uploadFile')}}">
                    <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                  {{trans('messages.load')}}
                  </a>
                @endif
              @else
                  <i class="fa fa-check" aria-hidden="true">
              @endif
              </td>
            </tr>
        @endforeach
        </tbody>
      </table>
      @endif
    </div>
  </div>
@stop
