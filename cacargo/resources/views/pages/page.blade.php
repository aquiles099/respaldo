@set('buttonPadding', 20)
@set('toolbar')
@section('pageTitle', trans('menu.dashboard'))
@section('title', trans('menu.dashboard'))
@set('pageCSS', 'panel-white')
@extends('pages.blank')
@include('sections.translate')
@section('title-actions')

<a class="btn btn-primary" href="{{asset('/admin/package/prealert')}}" onclick="loadButton(this)"data-toggle="tooltip" data-placement="left" title="{{trans('messages.dateprealerts')}}">
  <i aria-hidden="hidden" class="fa fa-flag"></i>
    {{trans('menu.prealerts')}}
    @if(isset($today_prealerts) && $today_prealerts > 0)
    <span class="badge">
      {{$today_prealerts}}
    </span>
    @endif
</a>
@stop
@section('body')
<div class="breadcrumb text-muted">
{{trans('messages.resume')}}
    <span class="pull-right">
      <div  class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer">
          <span class="text-muted">
            <i class="fa fa-eye" aria-hidden="true"></i>
            <span class="" id="dateload"></span>
            {{trans('messages.viewPackageOf')}} |
            <span id="selected_date">
              @if(isset($today))
                {{(($today == (date('Y-m-d'))) ? trans('messages.today') : $today ) }}
                @else
                  {{trans('messages.all_times')}}
                @endif
            </span>
            <span class="caret"></span>
          </span>
        </a>
        <ul class="dropdown-menu" id="dropdown">
          <li class="dropdown-header">{{trans('messages.show')}}</li>
          <li class="divider"></li>
          <li><a href="javascript:showDateDashboard(1)">{{trans('messages.today')}} <span class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i></span></a></li>
          <li><a href="javascript:showDateDashboard(2)">{{trans('messages.yesterday')}} <span class="pull-right"><i class="fa fa-undo" aria-hidden="true"></i></span></a></li>
          <li><a href="javascript:showDateDashboard(3)">{{trans('messages.month')}} <span class="pull-right"><i class="fa fa-calendar-o" aria-hidden="true"></i></span></a></li>
          <li><a href="javascript:showDateDashboard(4)">{{trans('messages.day')}}   <span class="pull-right"><i class="fa fa-calendar" aria-hidden="true"></i></span></a></li>
          <li><a href="javascript:showDateDashboard(5)">{{ucwords(trans('messages.all'))}}<span class="pull-right"><i class="fa fa-th-list" aria-hidden="true"></i></span></a></li>
        </ul>
      </div>
    </span>
</div>
<div class="row">
  @if(isset($events_num))
    @if($events_num == 5)
      <div class="col-md-1">

      </div>
    @endif
    @if($events_num == 4)
      <div class="col-md-2">

      </div>
    @endif
    @if($events_num == 3)
      <div class="col-md-3">

      </div>
    @endif
    @if($events_num == 2)
      <div class="col-md-4">

      </div>
    @endif
    @if($events_num == 1)
      <div class="col-md-5">

      </div>
    @endif
  @endif
  @if((isset($events))&&($events[0]->active ==1))
  <div class="col-md-2">
    @if(isset($todayPackage))
      <div class="panel panel-primary">
        <div class="panel-heading"><h4 class="">{{isset($events[0]) ?$events[0]->name : trans('menu.recibed')}}</h4></div>
        <div class="panel-body pack">
            <span class="label label-default"> {{$todayPackage}} </span>
        </div>
        @foreach($mOffice as $office)
        <div class="panel-footer dash" id="pnlin"><a href="javascript:details(1)">{{trans('messages.details')}}</a><span class="pull-right text-muted">{{$office->code}}</span></div>
        @endforeach
     </div>
   @endif
  </div>
  @endif
  {{--Paquetes enviados en la fecha seleccionada--}}
  @if((isset($events))&&($events[1]->active ==1))
  <div class="col-md-2">
    <div class="panel panel-green">
      <div class="panel-heading"> <h4 class="">{{isset($events[1]) ?$events[1]->name : trans('menu.send')}}</h4></div>
      <div class="panel-body pack">
        @if(isset($sendPackages))
          <span class="label label-default"> {{$sendPackages}} </span>
        @endif
      </div>
      <div class="panel-footer dash" id="pnlin"><a href="javascript:details(2)">{{trans('messages.details')}}</a></div>
    </div>
  </div>
  @endif
  {{--Paquetes en transito en la fecha seleccionada--}}
  @if((isset($events))&&($events[2]->active ==1))
  <div class="col-md-2">
    <div class="panel panel-yellow">
      <div class="panel-heading"><h4 class="">{{isset($events[2]) ?$events[2]->name : trans('package.inTransit')}}</h4></div>
      <div class="panel-body pack">
        @if(isset($transitPackages))
          <span class="label label-default"> {{$transitPackages}} </span>
        @endif
      </div>
      <div class="panel-footer dash" id="pnlin"><a href="javascript:details(3)">{{trans('messages.details')}}</a></div>
    </div>
  </div>
  @endif
  {{--Paquetes en destino en la fecha seleccionada--}}
  @if((isset($events))&&($events[3]->active ==1))
  <div class="col-md-2">
    @if(isset($arribedPackage))
      <div class="panel panel-default" id="pnlnoin">
        <div class="panel-heading"><h4 class="">{{isset($events[3]) ?$events[3]->name : trans('package.destination')}}</h4></div>
        <div class="panel-body pack">
            <span class="label label-default"> {{$arribedPackage}} </span>
        </div>
        @foreach($pOffice as $office)
        <div class="panel-footer dash" id="pnlin"><a href="javascript:details(4)">{{trans('messages.details')}}</a> <span class="pull-right text-muted">{{$office->code}}</span></div>
        @endforeach
    </div>
    @endif
  </div>
  @endif
  {{--Paquetes sin factura en la fecha seleccionada--}}
  @if((isset($events))&&($events[4]->active ==1))
  <div class="col-md-2">
    @if(isset($noInvoice))
      <div class="panel panel-red">
        <div class="panel-heading"><h4>{{isset($events[4]) ?$events[4]->name : trans('package.withOutInvoice')}}</h4></div>
        <div class="panel-body pack">
            <span class="label label-default"> {{$noInvoice}} </span>
        </div>
        <div class="panel-footer dash" id="pnlin"><a href="javascript:details(5)">{{trans('messages.details')}}</a></div>
    </div>
    @endif
  </div>
  @endif
  {{--Paquetes entregados en la fecha seleccionada--}}
  @if((isset($events))&&($events[5]->active ==1))
  <div class="col-md-2">
    @if(isset($delivered))
      <div class="panel panel-default" id="pnldelv" >
        <div class="panel-heading"><h4>{{isset($events[5]) ?$events[5]->name : trans('package.delivered')}}</h4></div>
        <div class="panel-body pack">
            <span class="label label-default"> {{$delivered}} </span>
        </div>
        <div class="panel-footer dash" id="pnlin"><a href="javascript:details(6)">{{trans('messages.details')}}</a></div>
    </div>
    @endif
  </div>
  @endif
</div><!--
<div class="breadcrumb text-muted">
{{trans('messages.visualizations')}}
</div>
<!--
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    @if(isset($todayPackage) && isset($sendPackages) && isset($transitPackages) && isset($arribedPackage) && isset($noInvoice) && isset($delivered))
      @if($todayPackage == 0 && $sendPackages == 0 && $transitPackages == 0 && $arribedPackage == 0 && $noInvoice == 0 && $delivered == 0)
      <div class="panel panel-heading text-center">
        <span class="text-muted">{{trans('messages.noRegisterPackages')}} <i class="fa fa-exclamation" aria-hidden="true"></i></span>
      </div>
      <div class="panel-body">
      </div>
      @else
      <div class="panel-body">
        <script>chartNums({{$todayPackage}}, {{$sendPackages}}, {{$transitPackages}}, {{$arribedPackage}} , {{$noInvoice}}, {{$delivered}})</script>
        <div id="barchart_values" class="mainchart"></div>
      </div>
      @endif
    @endif
    </div>
  </div>
</div>-->
<!--
<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
        @if(isset($mar) && isset($air))
          @if($mar == 0 && $air == 0)
            <div class="panel panel-heading text-center">
              <span class="text-muted">{{trans('messages.noRegisterPackages')}} <i class="fa fa-exclamation" aria-hidden="true"></i></span>
            </div>
            <div class="panel-body">
            </div>
          @else
            <div class="panel-body">
              <script>chartType({{$mar}},{{$air}})</script>
              <div id="donutchart" class="chart"></div>
            </div>
          @endif
        @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      @if(isset($invoicePackages) && isset($noInvoicePackages))
        @if($invoicePackages == 0 && $noInvoicePackages == 0)
        <div class="panel panel-heading text-center">
          <span class="text-muted">{{trans('messages.noRegisterPackages')}} <i class="fa fa-exclamation" aria-hidden="true"></i></span>
        </div>
        <div class="panel-body">
        </div>
        @else
        <div class="panel-body">
          <script>mainChart({{$invoicePackages}},{{$noInvoicePackages}})</script>
          <div id="mainchart" class="chart"></div>
        </div>
        @endif
      @endif
    </div>
  </div>
</div>-->
<!--
<div class="breadcrumb text-muted">
{{trans('messages.shortcuts')}}
</div>

<div class="row">
  <div class="col-md-2">
    <div class="panel panel-primary">
      <div class="panel-body">
        <h1 class="text-center"><a href="{{asset('admin/package')}}"class="infoRd"><i class="fa fa-cube" aria-hidden="true"></i></a></h1>
      </div>
      <div class="panel-heading"><h4 class=""><span class="text-center">{{trans('menu.packages')}}</span></h4></div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="panel panel-primary">
      <div class="panel-body">
        <h1 class="text-center"><a href="{{asset('admin/receipt/read')}}"class="infoRd"><i class="fa fa-file-text fa-fw" aria-hidden="true"></i></a></h1>
      </div>
      <div class="panel-heading"><h4 class="text-center">{{trans('menu.billing')}}</h4></div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="panel panel-primary">
      <div class="panel-body">
        <h1 class="text-center"><a href="{{asset('admin/company')}}"class="infoRd"><i class="fa fa-briefcase" aria-hidden="true"></i></a></h1>
      </div>
      <div class="panel-heading"><h4 class=""><span class="text-center">{{trans('menu.companies')}}</span></h4></div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="panel panel-primary">
      <div class="panel-body">
        <h1 class="text-center"><a href="{{asset('admin/service')}}"class="infoRd"><i class="fa fa-random" aria-hidden="true"></i></a></h1>
      </div>
     <div class="panel-heading"><h4 class=""><span class="text-center">{{trans('menu.services')}}</span></h4></div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="panel panel-primary">
      <div class="panel-body">
        <h1 class="text-center"><a href="{{asset('admin/category')}}"class="infoRd"><i class="fa fa-table" aria-hidden="true"></i></a></h1>
      </div>
      <div class="panel-heading"><h4 class=""><span class="text-center">{{trans('menu.category')}}</span></h4></div>
    </div>
  </div>

  <div class="col-md-2">
    <div class="panel panel-primary">
      <div class="panel-body">
        <h1 class="text-center"><a href="{{asset('admin/courier')}}"class="infoRd"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a></h1>
      </div>
      <div class="panel-heading"><h4 class=""><span class="text-center">{{trans('menu.courier')}}</span></h4></div>
    </div>
  </div>
</div>-->
@stop
