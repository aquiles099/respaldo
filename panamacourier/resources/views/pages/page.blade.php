@set('buttonPadding', 20)
@set('toolbar')
@include('sections.translate')
@section('pageTitle', trans('menu.dashboard'))
@section('title', trans('menu.dashboard'))
@set('pageCSS', 'panel-white')
@extends('pages.blank')
@section('title-actions')
<div class="row">
  <div class="col-md-12">
    <span class="pull-right">
      <div class="dropdown">
        <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown">
          <span class="text-muted" data-toggle="tooltip" title="{{trans('messages.selectedDatePackage')}}">
            <i class="fa fa-eye" aria-hidden="true"></i>
            <span class="" id="dateload"></span>
            {{trans('messages.viewPackageOf')}} |
            <span id="selected_date">
              @if(isset($today))
                {{(($today == (date('Y-m-d'))) ? trans('messages.today') : $today ) }}
              @else
                {{trans('dashboard.all')}}
              @endif
            </span>
            <span class="caret"></span>
          </span>
        </button>
        <ul class="dropdown-menu" id="">
          <li class="dropdown-header">{{trans('messages.show')}}</li>
          <li class="divider"></li>
          <li>
            <a href="javascript:showDateDashboard(1)">
              {{ucwords(trans('messages.today'))}}
              <span class="pull-right">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
              </span>
            </a>
          </li>
          <li>
            <a href="javascript:showDateDashboard(2)">
              {{ucwords(trans('messages.yesterday'))}}
              <span class="pull-right">
                <i class="fa fa-undo" aria-hidden="true"></i>
              </span>
            </a>
          </li>
          <li>
            <a href="javascript:showDateDashboard(3)">
              {{ucwords(trans('messages.month'))}}
              <span class="pull-right">
                <i class="fa fa-calendar-o" aria-hidden="true"></i>
              </span>
            </a>
          </li>
          <li>
            <a href="javascript:showDateDashboard(4)">
              {{ucwords(trans('messages.day'))}}
              <span class="pull-right">
                <i class="fa fa-calendar" aria-hidden="true"></i>
              </span>
            </a>
          </li>
          <li>
            <a href="javascript:showDateDashboard(5)">
              {{ucwords(trans('messages.all'))}}
              <span class="pull-right">
                <i class="fa fa-th-list" aria-hidden="true"></i>
              </span>
            </a>
          </li>
        </ul>
      </div>
    </span>
  </div>
</div>
@stop
@section('body')
  @if (session()->get('errorMessage'))
    <script type="text/javascript">
        swal({
            title: "Estimado {!! Session::get('key-sesion')['data']->name !!}",
            type: "info",
            html: "Usted tiene <a href='{{ asset('admin/pickup') }}'> <i class = 'fa fa-truck fa-fw' aria-hidden='true'></i> ({!! Session::get('errorMessage') !!}) {{trans('dashboard.pickup')}}</a> \
                  pendiente por verificar "
        });
    </script>
    {{Session::forget('errorMessage')}}
  @endif
<div class="row">
  <div class="col-md-12">
    <ol style="margin-top:10px;" class="breadcrumb shadow" id="ics-breadcrumb">
      <li><span class="text-muted">{{trans('messages.shortcuts')}}</span></li>
    </ol>
  </div>
</div>
<!---->
<div class="row">
<!---->
<div class="col-md-1">

</div>
  <div class="col-md-2">
    <div class="panel panel-primary">
      <a href="{{asset('admin/pickup')}}"class="infoRd">
        <div class="panel-body" id="ics-panel-body">
          <h1 class="text-center"><i class="fa fa-truck" aria-hidden="true"></i></h1>
        </div>
      </a>
      <div class="panel-heading"><h4 class="text-center">{{trans('dashboard.pickup')}}</h4></div>
    </div>
  </div>
<!---->
  <div class="col-md-2">
    <div class="panel panel-primary">
      <a href="{{asset('admin/cities')}}"class="infoRd" id="ics-link">
        <div class="panel-body" id="ics-panel-body">
          <h1 class="text-center"><i class="fa fa-map-marker" aria-hidden="true"></i></h1>
        </div>
      </a>
      <div class="panel-heading"><h4>{{trans('dashboard.cities')}}</h4></div>
    </div>
  </div>
<!---->
  <div class="col-md-2">
    <div class="panel panel-primary">
      <a href="{{asset('admin/receipt')}}"class="infoRd">
        <div class="panel-body" id="ics-panel-body">
          <h1 class="text-center"><i class="fa fa-file-text" aria-hidden="true"></i></h1>
        </div>
      </a>
      <div class="panel-heading"><h4>{{trans('dashboard.receipt')}}</h4></div>
    </div>
  </div>
<!---->
  <div class="col-md-2">
    <div class="panel panel-primary">
      <a href="{{asset('admin/configuration')}}"class="infoRd" id="ics-link">
        <div class="panel-body" id="ics-panel-body">
          <h1 class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></h1>
        </div>
      </a>
     <div class="panel-heading"><h4>{{trans('menu.adjustments')}}</h4></div>
    </div>
  </div>
<!---->
  <div class="col-md-2">
    <div class="panel panel-primary">
      <a href="{{asset('admin/billing')}}"class="infoRd" id="ics-link">
        <div class="panel-body" id="ics-panel-body">
          <h1 class="text-center"><i class="fa fa-bar-chart " aria-hidden="true"></i></h1>
        </div>
      </a>
      <div class="panel-heading"><h4>{{trans('dashboard.reports')}}</h4></div>
    </div>
  </div>
</div>
<!--End second List of shortcuts-->
<!---->
<div class="row">
  <div class="col-md-12">
    <ol class="breadcrumb shadow" id="ics-breadcrumb">
      <li><span class="text-muted">{{trans('dashboard.viewings')}} </span></li>
    </ol>
  </div>
</div>
<div class="panel-group" id="acordeon" role = "tab-list">

  <div class="panel panel-default">
    <div class="panel-heading" role = "tab" id="heading3">
      <h4 class="panel-title" style="text-align:left">
        <a href="#collapse3" data-toggle = "collapse" data-parent = "#acordeon">
          <i aria-hidden="true" class="fa fa-truck"></i> {{trans('dashboard.pickup')}}
        </a>
        <span class="pull-right"><span class="label label-default">{{isset($pickups) ? $pickups->count() : ''}}</span></span>
      </h4>
    </div>
    <div id="collapse3" class = "">
      <div class="panel-body">
        @if(isset($receivedPickups) && isset($sendPickups) && isset($transitPickups) && isset($arribedPickups) && isset($noInvoicePickups) && isset($deliveredPickups))
          @if($receivedPickups == 0 && $sendPickups == 0 && $transitPickups == 0 && $arribedPickups == 0 && $noInvoicePickups == 0 && $deliveredPickups == 0)
            <h5 class="text-muted">{{trans('dashboard.noRegisterPickup')}} <i class="fa fa-exclamation" aria-hidden="true"></i></h5>
          @else
          <!--Paneles-->
          <div class="row">
          <!--Recibidos en oficina-->
          <?php $i =1; ?>
          @if ($pickupStatus_number == 1)
            <div class="col-md-5">
            </div>
          @endif
          @if ($pickupStatus_number == 2)
            <div class="col-md-4">
            </div>
          @endif
          @if ($pickupStatus_number == 3)
            <div class="col-md-3">
            </div>
          @endif
          @if ($pickupStatus_number == 4)
            <div class="col-md-2">
            </div>
          @endif
          @if ($pickupStatus_number == 5)
            <div class="col-md-1">
            </div>
          @endif
          @foreach ($pickupStatus as $key => $events)
              <div class="col-md-2">
                @if(isset($receivedPickups))
                        @if ($i == 1)
                          <div class="panel panel-primary ">
                            <div class="panel-heading"><h4 class="">{{$events->name}}</h4></div>
                            <div class="panel-body pack">
                            <span class="label label-default"> {{$receivedPickups}} </span>
                            </div>
                            @foreach($mOffice as $office)
                              <div class="panel-footer dash" id="pnlin"><a href="javascript:details({{$i}})">{{trans('messages.details')}}</a></div>
                            @endforeach
                          </div>
                        @endif
                        @if ($i == 2)
                          <div class="panel panel-green ">
                            <div class="panel-heading"><h4 class="">{{$events->name}}</h4></div>
                            <div class="panel-body pack">
                            <span class="label label-default"> {{$sendPickups}} </span>
                            </div>
                            @foreach($mOffice as $office)
                              <div class="panel-footer dash" id="pnlin"><a href="javascript:details({{$i}})">{{trans('messages.details')}}</a></div>
                            @endforeach
                          </div>
                        @endif
                        @if ($i == 3)
                          <div class="panel panel-yellow ">
                            <div class="panel-heading"><h4 class="">{{$events->name}}</h4></div>
                            <div class="panel-body pack">
                            <span class="label label-default"> {{$transitPickups}} </span>
                            </div>
                            @foreach($mOffice as $office)
                              <div class="panel-footer dash" id="pnlin"><a href="javascript:details({{$i}})">{{trans('messages.details')}}</a></div>
                            @endforeach
                          </div>
                        @endif
                        @if ($i == 4)
                          <div class="panel panel-primary ">
                            <div class="panel-heading"><h4 class="">{{$events->name}}</h4></div>
                            <div class="panel-body pack">
                            <span class="label label-default"> {{$arribedPickups}} </span>
                            </div>
                            @foreach($mOffice as $office)
                              <div class="panel-footer dash" id="pnlin"><a href="javascript:details({{$i}})">{{trans('messages.details')}}</a></div>
                            @endforeach
                          </div>
                        @endif
                        @if ($i == 5)
                          <div class="panel panel-red ">
                            <div class="panel-heading"><h4 class="">{{$events->name}}</h4></div>
                            <div class="panel-body pack">
                            <span class="label label-default"> {{$delivered}} </span>
                            </div>
                            @foreach($mOffice as $office)
                              <div class="panel-footer dash" id="pnlin"><a href="javascript:details({{$i}})">{{trans('messages.details')}}</a></div>
                            @endforeach
                          </div>
                        @endif
                        @if ($i == 6)
                          <div class="panel panel-primary ">
                            <div class="panel-heading"><h4 class="">{{$events->name}}</h4></div>
                            <div class="panel-body pack">
                            <span class="label label-default"> {{$laststatus}} </span>
                            </div>
                            @foreach($mOffice as $office)
                              <div class="panel-footer dash" id="pnlin"><a href="javascript:details({{$i}})">{{trans('messages.details')}}</a></div>
                            @endforeach
                          </div>
                        @endif
               @endif
             </div>
             <?php $i++;?>
          @endforeach
          @endif
        @endif
      </div>
    </div>
  </div>
@stop
