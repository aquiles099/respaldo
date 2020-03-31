@set('buttonPadding', 20)
@set('toolbar')
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
              @endif
            </span>
            <span class="caret"></span>
          </span>
        </button>
        <ul class="dropdown-menu" id="">
          <li class="dropdown-header">{{trans('messages.show')}}</li>
          <li class="divider"></li>
          <li><a href="javascript:showDateDashboard(1)">{{trans('messages.today')}} <span class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i></span></a></li>
          <li><a href="javascript:showDateDashboard(2)">{{trans('messages.yesterday')}} <span class="pull-right"><i class="fa fa-undo" aria-hidden="true"></i></span></a></li>
          <li><a href="javascript:showDateDashboard(3)">{{trans('messages.month')}} <span class="pull-right"><i class="fa fa-calendar-o" aria-hidden="true"></i></span></a></li>
          <li><a href="javascript:showDateDashboard(4)">{{trans('messages.day')}}   <span class="pull-right"><i class="fa fa-calendar" aria-hidden="true"></i></span></a></li>
          {{--<li><a href="javascript:showDateDashboard(5)">{{trans('messages.all')}}   <span class="pull-right"><i class="fa fa-th-list" aria-hidden="true"></i></span></a></li>--}}
        </ul>
      </div>
    </span>
  </div>
</div>
@stop
@section('body')
<div class="row">
  <div class="col-md-12">
    <ol class="breadcrumb shadow" id="ics-breadcrumb">
      <li><span class="text-muted">{{trans('messages.shortcuts')}}</span></li>
    </ol>
  </div>
</div>
<!---->
<div class="row">
  <div class="col-md-2">
    <div class="panel panel-primary">
      <a href="{{asset('admin/package')}}"class="infoRd">
        <div class="panel-body" id="ics-panel-body">
          <h1 class="text-center"><i class="fa fa-cube" aria-hidden="true"></i></h1>
        </div>
      </a>
      <div class="panel-heading"><h4 class=""><span class="text-center">{{trans('dashboard.warehouse')}}</span></h4></div>
    </div>
  </div>
<!---->
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
      <a href="{{asset('admin/cargoRelease')}}"class="infoRd">
        <div class="panel-body" id="ics-panel-body">
          <h1 class="text-center"><i class="fa fa-th-large" aria-hidden="true"></i></h1>
        </div>
      </a>
      <div class="panel-heading"><h4 class=""><span class="text-center">{{trans('dashboard.release')}}</span></h4></div>
    </div>
  </div>
<!---->
  <div class="col-md-2">
    <div class="panel panel-primary">
      <a href="{{asset('admin/shipments')}}"class="infoRd">
        <div class="panel-body" id="ics-panel-body">
          <h1 class="text-center"><i class="fa fa-external-link fa-fw" aria-hidden="true"></i></h1>
        </div>
      </a>
     <div class="panel-heading"><h4 class=""><span class="text-center">{{trans('dashboard.shipments')}}</span></h4></div>
    </div>
  </div>
<!---->
  <div class="col-md-2">
    <div class="panel panel-primary">
      <a href="{{asset('admin/bookings')}}"class="infoRd">
        <div class="panel-body" id="ics-panel-body">
          <h1 class="text-center"><i class="fa fa-calendar" aria-hidden="true"></i></h1>
        </div>
      </a>
      <div class="panel-heading"><h4 class="text-center"><span class="text-center">{{trans('dashboard.bookings')}}</span></h4></div>
    </div>
  </div>
<!---->
  <div class="col-md-2">
    <div class="panel panel-primary" >
      <a href="{{asset('admin/suppliers')}}" class="infoRd">
        <div class="panel-body" id="ics-panel-body">
          <h1 class="text-center"><i class="fa fa-asterisk" aria-hidden="true"></i></h1>
        </div>
      </a>
      <div class="panel-heading"><h4 class=""><span class="text-center">{{trans('dashboard.suppliers')}}</span></h4></div>
    </div>
  </div>
</div>
<!--End first List of shortcuts-->
<!-- Second List of shortcuts-->
<div class="row">
  <div class="col-md-2">
    <div class="panel panel-primary">
      <a href="{{asset('admin/routes')}}"class="infoRd" id="ics-link">
      <div class="panel-body" id="ics-panel-body">
        <h1 class="text-center"><i class="fa fa-road" aria-hidden="true"></i></h1>
      </div>
      </a>
      <div class="panel-heading"><h4>{{trans('dashboard.routes')}}</h4></div>
    </div>
  </div>
<!---->
  <div class="col-md-2">
    <div class="panel panel-primary">
      <a href="{{asset('admin/user/new')}}"class="infoRd" id="ics-link">
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
      <a href="{{asset('admin/service')}}"class="infoRd" id="ics-link">
        <div class="panel-body" id="ics-panel-body">
          <h1 class="text-center"><i class="fa fa-random" aria-hidden="true"></i></h1>
        </div>
      </a>
     <div class="panel-heading"><h4>{{trans('dashboard.services')}}</h4></div>
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
<!---->
  <div class="col-md-2">
    <div class="panel panel-primary">
      <a href="{{asset('admin/category')}}"class="infoRd" id="ics-link">
        <div class="panel-body" id="ics-panel-body">
          <h1 class="text-center"><i class="fa fa-table" aria-hidden="true"></i></h1>
        </div>
      </a>
      <div class="panel-heading"><h4>{{trans('dashboard.category')}}</h4></div>
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
  <!--
  /**
  * ALMACEN
  */
  -->
  <div class="panel panel-default">
    <div class="panel-heading" role = "tab" id="heading1">
      <h4 class="panel-title" style="text-align:left">
        <a href="#collapse1" data-toggle = "collapse" data-parent = "#acordeon" class="ics-undecorate">
          <span>
            <i aria-hidden="true" class="fa fa-cube"></i> {{trans('dashboard.warehouse')}}
          </span>
        </a>
        <span class="pull-right"><span class="label label-default">{{isset($packages) ? $packages->count() : ''}}</span></span>
      </h4>
    </div>
    <div id="collapse1" class = "panel-collapse collapse in">
      <div class="panel-body">
        @if(isset($todayPackage) && isset($sendPackages) && isset($transitPackages) && isset($arribedPackage) && isset($noInvoice) && isset($delivered))
          @if($todayPackage == 0 && $sendPackages == 0 && $transitPackages == 0 && $arribedPackage == 0 && $noInvoice == 0 && $delivered == 0)
            <h5 class="text-muted">{{trans('messages.noRegisterPackages')}} <i class="fa fa-exclamation" aria-hidden="true"></i></h5>
          @else
          <!--Paneles-->
          <div class="row">
          <!--Recibidos en oficina-->
          <?php $i =1; ?>
          @if ($events_number == 1)
            <div class="col-md-5">
            </div>
          @endif
          @if ($events_number == 2)
            <div class="col-md-4">
            </div>
          @endif
          @if ($events_number == 3)
            <div class="col-md-3">
            </div>
          @endif
          @if ($events_number == 4)
            <div class="col-md-2">
            </div>
          @endif
          @if ($events_number == 5)
            <div class="col-md-1">
            </div>
          @endif
          @foreach ($status as $key => $events)
              <div class="col-md-2">
                @if(isset($todayPackage))
                        @if ($i == 1)
                          <div class="panel panel-primary ">
                            <div class="panel-heading"><h4 class="">{{$events->name}}</h4></div>
                            <div class="panel-body pack">
                            <span class="label label-default"> {{$todayPackage}} </span>
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
                            <span class="label label-default"> {{$sendPackages}} </span>
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
                            <span class="label label-default"> {{$transitPackages}} </span>
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
                            <span class="label label-default"> {{$arribedPackage}} </span>
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

          <!--Enviados-->
          <!--
          <div class="col-md-2">
            <div class="panel panel-green ">
              <div class="panel-heading"> <h4 class="">{{trans('menu.send')}}</h4></div>
              <div class="panel-body pack">
                @if(isset($sendPackages))
                  <span class="label label-default"> {{$sendPackages}} </span>
                @endif
              </div>
              <div class="panel-footer dash" id="pnlin"><a href="javascript:details(2)">{{trans('messages.details')}}</a></div>
            </div>
          </div>
          <!--En transito--><!--
          <div class="col-md-2">
            <div class="panel panel-yellow ">
              <div class="panel-heading"><h4 class="">{{trans('package.inTransit')}}</h4></div>
              <div class="panel-body pack">
                @if(isset($transitPackages))
                  <span class="label label-default"> {{$transitPackages}} </span>
                @endif
              </div>
              <div class="panel-footer dash" id="pnlin"><a href="javascript:details(3)">{{trans('messages.details')}}</a></div>
            </div>
          </div>
          <!--Destino--><!--
          <div class="col-md-2">
            @if(isset($arribedPackage))
              <div class="panel panel-default " id="pnlnoin">
                <div class="panel-heading"><h4 class="">{{trans('package.destination')}}</h4></div>
                <div class="panel-body pack">
                    <span class="label label-default"> {{$arribedPackage}} </span>
                </div>
                @foreach($pOffice as $office)
                <div class="panel-footer dash" id="pnlin"><a href="javascript:details(4)">{{trans('messages.details')}}</a> <span class="pull-right text-muted">{{$office->code}}</span></div>
                @endforeach
            </div>
            @endif
          </div>
          <!--sin factura--><!--
          <div class="col-md-2">
            @if(isset($noInvoice))
              <div class="panel panel-red ">
                <div class="panel-heading"><h4 style="font-size:17px">{{trans('package.withOutInvoice')}}</h4></div>
                <div class="panel-body pack">
                    <span class="label label-default"> {{$noInvoice}} </span>
                </div>
                <div class="panel-footer dash" id="pnlin"><a href="javascript:details(5)">{{trans('messages.details')}}</a></div>
            </div>
            @endif
          </div>
          <!--entregado--><!--
          <div class="col-md-2">
            @if(isset($delivered))
              <div class="panel panel-default " id="pnldelv" >
                <div class="panel-heading"><h4>{{trans('package.delivered')}}</h4></div>
                <div class="panel-body pack">
                    <span class="label label-default"> {{$delivered}} </span>
                </div>
                <div class="panel-footer dash" id="pnlin"><a href="javascript:details(6)">{{trans('messages.details')}}</a></div>
            </div>
            @endif
          </div>-->
          </div>
          @endif
        @endif
      </div>
    </div>
  </div>
  <!--
  /**
  * RESERVAS
  */
  -->
  <div class="panel panel-default">
    <div class="panel-heading" role = "tab" id="heading2">
      <h4 class="panel-title">
        <a href="#collapse2" data-toggle = "collapse" data-parent = "#acordeon">
          <h4 class="panel-title" style="text-align:left">
            <a href="#collapse2" data-toggle = "collapse" data-parent = "#acordeon">
              <i aria-hidden="true" class="fa fa-calendar"></i> {{trans('dashboard.bookings')}}
            </a>
            <span class="pull-right"><span class="label label-default">{{isset($bookings) ? $bookings->count() : ''}}</span></span>
          </h4>
        </a>
      </h4>
    </div>
    <div id="collapse2" class = "panel-collapse collapse ">
      <div class="panel-body">
        @if(isset($receivedBookings) && isset($sendBookings) && isset($transitBookings) && isset($arribedBooking) && isset($deliveredBookings))
          @if($receivedBookings == 0 && $sendBookings == 0 && $transitBookings == 0 && $arribedBooking == 0 && $deliveredBookings == 0)
            <h5 class="text-muted">{{trans('dashboard.noRegisterBookings')}} <i class="fa fa-exclamation" aria-hidden="true"></i></h5>
          @else
          <!--Paneles-->
          <div class="row">
          <!--Recibidos en oficina-->
          <?php $i =1; ?>
          @if ($events_number == 1)
            <div class="col-md-5">
            </div>
          @endif
          @if ($events_number == 2)
            <div class="col-md-4">
            </div>
          @endif
          @if ($events_number == 3)
            <div class="col-md-3">
            </div>
          @endif
          @if ($events_number == 4)
            <div class="col-md-2">
            </div>
          @endif
          @if ($events_number == 5)
            <div class="col-md-1">
            </div>
          @endif
          @foreach ($status as $key => $events)
              <div class="col-md-2">
                @if(isset($receivedBookings))
                        @if ($i == 1)
                          <div class="panel panel-primary ">
                            <div class="panel-heading"><h4 class="">{{$events->name}}</h4></div>
                            <div class="panel-body pack">
                            <span class="label label-default"> {{$receivedBookings}} </span>
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
                            <span class="label label-default"> {{$sendBookings}} </span>
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
                            <span class="label label-default"> {{$transitBookings}} </span>
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
                            <span class="label label-default"> {{$arribedBooking}} </span>
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
<!--
          <div class="row">
            <!--Recibidos en oficina--><!--
            <div class="col-md-2">
              @if(isset($receivedBookings))
                <div class="panel panel-primary ">
                  <div class="panel-heading"><h4 class="">{{trans('menu.recibed')}}</h4></div>
                  <div class="panel-body pack">
                      <span class="label label-default">{{$receivedBookings}}</span>
                  </div>
                  @foreach($mOffice as $office)
                  <div class="panel-footer dash" id="pnlin"><a href="javascript:details(1)">{{trans('messages.details')}}</a></div>
                  @endforeach
               </div>
             @endif
            </div>
            <!--Enviados--><!--
            <div class="col-md-2">
              <div class="panel panel-green ">
                <div class="panel-heading"> <h4 class="">{{trans('menu.send')}}</h4></div>
                <div class="panel-body pack">
                  @if(isset($sendBookings))
                    <span class="label label-default">{{$sendBookings}}</span>
                  @endif
                </div>
                <div class="panel-footer dash" id="pnlin"><a href="javascript:details(2)">{{trans('messages.details')}}</a></div>
              </div>
            </div>
            <!--En transito--><!--
            <div class="col-md-2">
              <div class="panel panel-yellow ">
                <div class="panel-heading"><h4 class="">{{trans('package.inTransit')}}</h4></div>
                <div class="panel-body pack">
                  @if(isset($transitBookings))
                    <span class="label label-default">{{$transitBookings}}</span>
                  @endif
                </div>
                <div class="panel-footer dash" id="pnlin"><a href="javascript:details(3)">{{trans('messages.details')}}</a></div>
              </div>
            </div>
            <!--Destino--><!--
            <div class="col-md-2">
              @if(isset($arribedBooking))
                <div class="panel panel-default " id="pnlnoin">
                  <div class="panel-heading"><h4 class="">{{trans('package.destination')}}</h4></div>
                  <div class="panel-body pack">
                      <span class="label label-default">{{$arribedBooking}}</span>
                  </div>
                  @foreach($pOffice as $office)
                  <div class="panel-footer dash" id="pnlin"><a href="javascript:details(4)">{{trans('messages.details')}}</a> <span class="pull-right text-muted">{{$office->code}}</span></div>
                  @endforeach
              </div>
              @endif
            </div>
            <!--sin factura--><!--
            <div class="col-md-2">
                <div class="panel panel-red ">
                  <div class="panel-heading"><h4 style="font-size:17px">{{trans('package.withOutInvoice')}}</h4></div>
                  <div class="panel-body pack">
                      <span class="label label-default">N/A</span>
                  </div>
                  <div class="panel-footer dash" id="pnlin"><a href="javascript:details(5)">{{trans('messages.details')}}</a></div>
              </div>
            </div>
            <!--entregado--><!--
            <div class="col-md-2">
              @if(isset($deliveredBookings))
                <div class="panel panel-default " id="pnldelv" >
                  <div class="panel-heading"><h4>{{trans('package.delivered')}}</h4></div>
                  <div class="panel-body pack">
                      <span class="label label-default">{{$deliveredBookings}}</span>
                  </div>
                  <div class="panel-footer dash" id="pnlin"><a href="javascript:details(6)">{{trans('messages.details')}}</a></div>
              </div>
              @endif
            </div>
          </div>-->
          @endif
        @endif
      </div>
    </div>
  </div>
  <!--
  /**
  * RECOGIDAS
  */
  -->
  <div class="panel panel-default">
    <div class="panel-heading" role = "tab" id="heading3">
      <h4 class="panel-title" style="text-align:left">
        <a href="#collapse3" data-toggle = "collapse" data-parent = "#acordeon">
          <i aria-hidden="true" class="fa fa-truck"></i> {{trans('dashboard.pickup')}}
        </a>
        <span class="pull-right"><span class="label label-default">{{isset($pickups) ? $pickups->count() : ''}}</span></span>
      </h4>
    </div>
    <div id="collapse3" class = "panel-collapse collapse ">
      <div class="panel-body">
        @if(isset($receivedPickups) && isset($sendPickups) && isset($transitPickups) && isset($arribedPickups) && isset($noInvoicePickups) && isset($deliveredPickups))
          @if($receivedPickups == 0 && $sendPickups == 0 && $transitPickups == 0 && $arribedPickups == 0 && $noInvoicePickups == 0 && $deliveredPickups == 0)
            <h5 class="text-muted">{{trans('dashboard.noRegisterPickup')}} <i class="fa fa-exclamation" aria-hidden="true"></i></h5>
          @else
          <!--Paneles-->
          <div class="row">
          <!--Recibidos en oficina-->
          <?php $i =1; ?>
          @if ($events_number == 1)
            <div class="col-md-5">
            </div>
          @endif
          @if ($events_number == 2)
            <div class="col-md-4">
            </div>
          @endif
          @if ($events_number == 3)
            <div class="col-md-3">
            </div>
          @endif
          @if ($events_number == 4)
            <div class="col-md-2">
            </div>
          @endif
          @if ($events_number == 5)
            <div class="col-md-1">
            </div>
          @endif
          @foreach ($status as $key => $events)
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
          <!--Paneles--><!--
          <div class="row">
          <!--Recibidos en oficina--><!--
          <div class="col-md-2">
            @if(isset($receivedPickups))
              <div class="panel panel-primary ">
                <div class="panel-heading"><h4 class="">{{trans('menu.recibed')}}</h4></div>
                <div class="panel-body pack">
                    <span class="label label-default"> {{$receivedPickups}} </span>
                </div>
                @foreach($mOffice as $office)
                <div class="panel-footer dash" id="pnlin"><a href="javascript:details(1)">{{trans('messages.details')}}</a></div>
                @endforeach
             </div>
           @endif
          </div>
          <!--Enviados--><!--
          <div class="col-md-2">
            <div class="panel panel-green ">
              <div class="panel-heading"> <h4 class="">{{trans('menu.send')}}</h4></div>
              <div class="panel-body pack">
                @if(isset($sendPickups))
                  <span class="label label-default"> {{$sendPickups}} </span>
                @endif
              </div>
              <div class="panel-footer dash" id="pnlin"><a href="javascript:details(2)">{{trans('messages.details')}}</a></div>
            </div>
          </div>
          <!--En transito--><!--
          <div class="col-md-2">
            <div class="panel panel-yellow ">
              <div class="panel-heading"><h4 class="">{{trans('package.inTransit')}}</h4></div>
              <div class="panel-body pack">
                @if(isset($transitPickups))
                  <span class="label label-default"> {{$transitPickups}} </span>
                @endif
              </div>
              <div class="panel-footer dash" id="pnlin"><a href="javascript:details(3)">{{trans('messages.details')}}</a></div>
            </div>
          </div>
          <!--Destino--><!--
          <div class="col-md-2">
            @if(isset($arribedPickups))
              <div class="panel panel-default " id="pnlnoin">
                <div class="panel-heading"><h4 class="">{{trans('package.destination')}}</h4></div>
                <div class="panel-body pack">
                    <span class="label label-default"> {{$arribedPickups}} </span>
                </div>
                @foreach($pOffice as $office)
                <div class="panel-footer dash" id="pnlin"><a href="javascript:details(4)">{{trans('messages.details')}}</a> <span class="pull-right text-muted">{{$office->code}}</span></div>
                @endforeach
            </div>
            @endif
          </div>
          <!--sin factura--><!--
          <div class="col-md-2">
            @if(isset($noInvoicePickups))
              <div class="panel panel-red ">
                <div class="panel-heading"><h4 style="font-size:17px">{{trans('package.withOutInvoice')}}</h4></div>
                <div class="panel-body pack">
                    <span class="label label-default"> {{$noInvoicePickups}} </span>
                </div>
                <div class="panel-footer dash" id="pnlin"><a href="javascript:details(5)">{{trans('messages.details')}}</a></div>
            </div>
            @endif
          </div>
          <!--entregado--><!--
          <div class="col-md-2">
            @if(isset($deliveredPickups))
              <div class="panel panel-default " id="pnldelv" >
                <div class="panel-heading"><h4>{{trans('package.delivered')}}</h4></div>
                <div class="panel-body pack">
                    <span class="label label-default"> {{$deliveredPickups}} </span>
                </div>
                <div class="panel-footer dash" id="pnlin"><a href="javascript:details(6)">{{trans('messages.details')}}</a></div>
            </div>
            @endif
          </div>
        </div>-->
          @endif
        @endif
      </div>
    </div>
  </div>
  <!--
  /**
  * EMBARQUES
  */
  -->
  <div class="panel panel-default">
    <div class="panel-heading" role = "tab" id="heading4">
      <h4 class="panel-title" style="text-align:left">
        <a href="#collapse4" data-toggle = "collapse" data-parent = "#acordeon">
          <i aria-hidden="true" class="fa fa-external-link"></i> {{trans('dashboard.shipments')}}
        </a>
        <span class="pull-right"><span class="label label-default">{{isset($shipments) ? $shipments->count() : ''}}</span></span>
      </h4>
    </div>
    <div id="collapse4" class = "panel-collapse collapse ">
      <div class="panel-body">
          @if(isset($receivedShipments) && isset($sendShipments) && isset($transitShipments) && isset($arribedShipments)  && isset($deliveredShipments))
            @if($receivedShipments == 0 && $sendShipments == 0 && $transitShipments == 0 && $arribedShipments == 0  && $deliveredShipments == 0)
              <h5 class="text-muted">{{trans('dashboard.noRegisterShipments')}} <i class="fa fa-exclamation" aria-hidden="true"></i></h5>
            @else
            <!--Paneles-->
            <div class="row">
            <!--Recibidos en oficina-->
            <?php $i =1; ?>
            @if ($events_number == 1)
              <div class="col-md-5">
              </div>
            @endif
            @if ($events_number == 2)
              <div class="col-md-4">
              </div>
            @endif
            @if ($events_number == 3)
              <div class="col-md-3">
              </div>
            @endif
            @if ($events_number == 4)
              <div class="col-md-2">
              </div>
            @endif
            @if ($events_number == 5)
              <div class="col-md-1">
              </div>
            @endif
            @foreach ($status as $key => $events)
                <div class="col-md-2">
                  @if(isset($receivedShipments))
                          @if ($i == 1)
                            <div class="panel panel-primary ">
                              <div class="panel-heading"><h4 class="">{{$events->name}}</h4></div>
                              <div class="panel-body pack">
                              <span class="label label-default"> {{$receivedShipments}} </span>
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
                              <span class="label label-default"> {{$sendShipments}} </span>
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
                              <span class="label label-default"> {{$transitShipments}} </span>
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
                              <span class="label label-default"> {{$arribedShipments}} </span>
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
            <!--Paneles--><!--
            <div class="row">
            <!--Recibidos en oficina--><!--
            <div class="col-md-2">
              @if(isset($receivedPickups))
                <div class="panel panel-primary ">
                  <div class="panel-heading"><h4 class="">{{trans('menu.recibed')}}</h4></div>
                  <div class="panel-body pack">
                      <span class="label label-default"> {{$receivedPickups}} </span>
                  </div>
                  @foreach($mOffice as $office)
                  <div class="panel-footer dash" id="pnlin"><a href="javascript:details(1)">{{trans('messages.details')}}</a></div>
                  @endforeach
               </div>
             @endif
            </div>
            <!--Enviados--><!--
            <div class="col-md-2">
              <div class="panel panel-green ">
                <div class="panel-heading"> <h4 class="">{{trans('menu.send')}}</h4></div>
                <div class="panel-body pack">
                  @if(isset($sendPickups))
                    <span class="label label-default"> {{$sendPickups}} </span>
                  @endif
                </div>
                <div class="panel-footer dash" id="pnlin"><a href="javascript:details(2)">{{trans('messages.details')}}</a></div>
              </div>
            </div>
            <!--En transito--><!--
            <div class="col-md-2">
              <div class="panel panel-yellow ">
                <div class="panel-heading"><h4 class="">{{trans('package.inTransit')}}</h4></div>
                <div class="panel-body pack">
                  @if(isset($transitPickups))
                    <span class="label label-default"> {{$transitPickups}} </span>
                  @endif
                </div>
                <div class="panel-footer dash" id="pnlin"><a href="javascript:details(3)">{{trans('messages.details')}}</a></div>
              </div>
            </div>
            <!--Destino--><!--
            <div class="col-md-2">
              @if(isset($arribedPickups))
                <div class="panel panel-default " id="pnlnoin">
                  <div class="panel-heading"><h4 class="">{{trans('package.destination')}}</h4></div>
                  <div class="panel-body pack">
                      <span class="label label-default"> {{$arribedPickups}} </span>
                  </div>
                  @foreach($pOffice as $office)
                  <div class="panel-footer dash" id="pnlin"><a href="javascript:details(4)">{{trans('messages.details')}}</a> <span class="pull-right text-muted">{{$office->code}}</span></div>
                  @endforeach
              </div>
              @endif
            </div>
            <!--sin factura--><!--
            <div class="col-md-2"><!--
                <div class="panel panel-red ">
                  <div class="panel-heading"><h4 style="font-size:16px">{{trans('package.withOutInvoice')}}</h4></div>
                  <div class="panel-body pack">
                      <span class="label label-default"> N/A </span>
                  </div>
                  <div class="panel-footer dash" id="pnlin"><a href="javascript:details(5)">{{trans('messages.details')}}</a></div>
              </div>
            </div>
            <!--entregado--><!--
            <div class="col-md-2"><!--
              @if(isset($deliveredPickups))
                <div class="panel panel-default " id="pnldelv" >
                  <div class="panel-heading"><h4>{{trans('package.delivered')}}</h4></div>
                  <div class="panel-body pack">
                      <span class="label label-default"> {{$deliveredPickups}} </span>
                  </div>
                  <div class="panel-footer dash" id="pnlin"><a href="javascript:details(6)">{{trans('messages.details')}}</a></div>
              </div>
              @endif
            </div>
          </div>-->
            @endif
          @endif
      </div>
    </div>
  </div>
  <!--
  /**
  * LIBERACION
  */
  -->
  <div class="panel panel-default">
    <div class="panel-heading" role = "tab" id="heading5">
      <h4 class="panel-title" style="text-align:left">
        <a href="#collapse5" data-toggle = "collapse" data-parent = "#acordeon">
          <i aria-hidden="true" class="fa fa-th-large"></i> {{trans('dashboard.release')}}
        </a>
        <span class="pull-right"><span class="label label-default">{{isset($releases) ? $releases->count() : ''}}</span></span>
      </h4>
    </div>
    <div id="collapse5" class = "panel-collapse collapse ">
      <div class="panel-body">
          @if(isset($receivedReleases) && isset($sendReleases) && isset($transitReleases) && isset($arribedReleases)  && isset($deliveredReleases))
            @if($receivedReleases == 0 && $sendReleases == 0 && $transitReleases == 0 && $arribedReleases == 0  && $deliveredReleases == 0)
              <h5 class="text-muted">{{trans('dashboard.noRegisterReleases')}} <i class="fa fa-exclamation" aria-hidden="true"></i></h5>
            @else
            <!--Paneles-->
            <div class="row">
            <!--Recibidos en oficina-->
            <?php $i =1; ?>
            @if ($events_number == 1)
              <div class="col-md-5">
              </div>
            @endif
            @if ($events_number == 2)
              <div class="col-md-4">
              </div>
            @endif
            @if ($events_number == 3)
              <div class="col-md-3">
              </div>
            @endif
            @if ($events_number == 4)
              <div class="col-md-2">
              </div>
            @endif
            @if ($events_number == 5)
              <div class="col-md-1">
              </div>
            @endif
            @foreach ($status as $key => $events)
                <div class="col-md-2">
                  @if(isset($receivedReleases))
                          @if ($i == 1)
                            <div class="panel panel-primary ">
                              <div class="panel-heading"><h4 class="">{{$events->name}}</h4></div>
                              <div class="panel-body pack">
                              <span class="label label-default"> {{$receivedReleases}} </span>
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
                              <span class="label label-default"> {{$sendReleases}} </span>
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
                              <span class="label label-default"> {{$transitReleases}} </span>
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
                              <span class="label label-default"> {{$arribedReleases}} </span>
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
            <!--Paneles--><!--
            <div class="row">
            <!--Recibidos en oficina--><!--
            <div class="col-md-2">
              @if(isset($receivedReleases))
                <div class="panel panel-primary ">
                  <div class="panel-heading"><h4 class="">{{trans('menu.recibed')}}</h4></div>
                  <div class="panel-body pack">
                      <span class="label label-default"> {{$receivedReleases}} </span>
                  </div>
                  @foreach($mOffice as $office)
                  <div class="panel-footer dash" id="pnlin"><a href="javascript:details(1)">{{trans('messages.details')}}</a></div>
                  @endforeach
               </div>
             @endif
            </div>
            <!--Enviados--><!--
            <div class="col-md-2">
              <div class="panel panel-green ">
                <div class="panel-heading"> <h4 class="">{{trans('menu.send')}}</h4></div>
                <div class="panel-body pack">
                  @if(isset($sendReleases))
                    <span class="label label-default"> {{$sendReleases}} </span>
                  @endif
                </div>
                <div class="panel-footer dash" id="pnlin"><a href="javascript:details(2)">{{trans('messages.details')}}</a></div>
              </div>
            </div>
            <!--En transito--><!--
            <div class="col-md-2">
              <div class="panel panel-yellow ">
                <div class="panel-heading"><h4 class="">{{trans('package.inTransit')}}</h4></div>
                <div class="panel-body pack">
                  @if(isset($transitReleases))
                    <span class="label label-default"> {{$transitReleases}} </span>
                  @endif
                </div>
                <div class="panel-footer dash" id="pnlin"><a href="javascript:details(3)">{{trans('messages.details')}}</a></div>
              </div>
            </div>
            <!--Destino--><!--
            <div class="col-md-2">
              @if(isset($arribedReleases))
                <div class="panel panel-default " id="pnlnoin">
                  <div class="panel-heading"><h4 class="">{{trans('package.destination')}}</h4></div>
                  <div class="panel-body pack">
                      <span class="label label-default"> {{$arribedReleases}} </span>
                  </div>
                  @foreach($pOffice as $office)
                  <div class="panel-footer dash" id="pnlin"><a href="javascript:details(4)">{{trans('messages.details')}}</a> <span class="pull-right text-muted">{{$office->code}}</span></div>
                  @endforeach
              </div>
              @endif
            </div>
            <!--sin factura--><!--
            <div class="col-md-2">
                <div class="panel panel-red ">
                  <div class="panel-heading"><h4 style="font-size:16px">{{trans('package.withOutInvoice')}}</h4></div>
                  <div class="panel-body pack">
                      <span class="label label-default"> N/A </span>
                  </div>
                  <div class="panel-footer dash" id="pnlin"><a href="javascript:details(5)">{{trans('messages.details')}}</a></div>
              </div>
            </div>
            <!--entregado--><!--
            <div class="col-md-2">
              @if(isset($deliveredReleases))
                <div class="panel panel-default " id="pnldelv" >
                  <div class="panel-heading"><h4>{{trans('package.delivered')}}</h4></div>
                  <div class="panel-body pack">
                      <span class="label label-default"> {{$deliveredReleases}} </span>
                  </div>
                  <div class="panel-footer dash" id="pnlin"><a href="javascript:details(6)">{{trans('messages.details')}}</a></div>
              </div>
              @endif
            </div>
          </div>-->
            @endif
          @endif
      </div>
    </div>
  </div>
</div>
@stop
