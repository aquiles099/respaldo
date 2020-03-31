<?php
if(isset($package) && !is_null($package->getLastEvent)) {
  $position = $package->getLastEvent->step;
}
else {
  $position = -1;
}
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
@section('pageTitle', trans('menu.packages'))
@section('title', trans('menu.packages'))
@section('icon-title')
  <i aria-hidden="true" class="fa fa-cubes"></i>
@stop
@section('title-actions')
<a href="{{isset($filter) ? asset('account/') : '#section' }}" class="btn btn-primary" @if(!isset($filter)) data-toggle="collapse" @endif>
  <span><i class="{{isset($filter) ? 'fa fa-list' : 'fa fa-filter' }}"></i></span>
  {{isset($filter) ? trans('messages.list') : trans('messages.filter')}}
</a>
@stop
@extends('pages.page')
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
              <th style="text-align: center">{{trans('Progreso')}}</th>
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
                  @if($package->getLastEvent->step == HConstants::EVENT_RECEIVED) {{trans('package.received')}} <i class="fa fa-building-o" aria-hidden="true"></i> @endif
                  @if($package->getLastEvent->step == HConstants::EVENT_PROCESED) {{trans('package.processed')}} <i class="fa fa-cubes" aria-hidden="true"></i>@endif
                  @if($package->getLastEvent->step == HConstants::EVENT_TRANSIT) {{trans('package.inTransit')}} <i class="fa fa-paper-plane-o" aria-hidden="true"></i> @endif
                  @if($package->getLastEvent->step == HConstants::EVENT_TRANSIT) {{trans('package.available')}} <i class="fa fa-check" aria-hidden="true"></i>@endif
                  @if($package->getLastEvent->step == HConstants::EVENT_AVAILABLE) {{trans('package.delivered')}} <i class="fa fa-user" aria-hidden="true"></i>@endif
                </td>
                <td style="background-color:white; vertical-align:middle">
                  <ul class="nav nav-wizard" style="padding-left: 6%">
                      @if ($events_number == 1)
                          <?php $i = 1; ?>
                        @foreach ($status as $key => $value)
                          <li title={{$value->description}} style="width:100%" @if($package->getLastEvent->id == $i) class="active" @endif><a>{{$value->name}}</a></li>
                          <?php $i++; ?>
                        @endforeach
                      @endif
                      @if ($events_number == 2)
                        <?php $i = 1; ?>
                        @foreach ($status as $key => $value)
                          <li title={{$value->description}} style="width:50%" @if($package->getLastEvent->id == $i) class="" @endif><a>{{$value->name}}</a></li>
                          <?php $i++; ?>
                        @endforeach
                      @endif
                      @if ($events_number == 3)
                            <?php $i = 1; ?>
                          @foreach ($status as $key => $value)
                            <li title={{$value->description}} style="width:33%" @if($package->getLastEvent->id == $i) class="active" @endif><a>{{$value->name}}</a></li>
                            <?php $i++; ?>
                          @endforeach
                      @endif
                      @if ($events_number == 4)
                        <?php $i = 1; ?>
                        @foreach ($status as $key => $value)
                        <li title={{$value->description}} style="width:25%" @if($package->getLastEvent->id == $i) class="active" @endif><a>{{$value->name}}</a></li>
                        <?php $i++; ?>
                        @endforeach
                      @endif
                      @if ($events_number == 5)
                        <?php $i = 1; ?>
                        @foreach ($status as $key => $value)
                        <li title={{$value->description}} style="width:20%" @if($package->getLastEvent->id == $i) class="active" @endif><a>{{$value->name}}</a></li>
                        <?php $i++; ?>
                        @endforeach
                      @endif
                      @if ($events_number == 6)
                      <?php $i = 1; ?>
                        @foreach ($status as $key => $value)
                        <li title="{{$value->description}}" style="width:16%" @if($package->getLastEvent->id == $i) class="active" @endif><a>{{$value->name}}</a></li>
                        <?php $i++; ?>
                        @endforeach
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
