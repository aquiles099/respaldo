<?php
use App\Helpers\HUserType;
use App\Helpers\HConstants;
if(isset($package) && !is_null($package->getLastEvent)) {
  $position = $package->getLastEvent->step;
}
else {
  $position = -1;
}
?>
@include('sections.translate')
@section('title-actions')
@stop
@set('noTitle')
@set('only')
<?php
  if (Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
?>
<div class="panel panel-default">
  <div class="panel-heading"><span class="text-muted">{{trans('package.type2')}} | {{$package->getCategory->label}} </span><span class="pull-right"><span class="text-muted">{{trans('package.tracking2')}} | {{$package->tracking}}</span></span></div>
  <div class="panel-body">
    <div class="panel panel-default">
        <div class="panel-body">
          <center>
            <ul class="nav nav-wizard">
              <li style="width:20%" @if($position == HConstants::EVENT_RECEIVED) class="active" @endif><a>{{trans('package.received')}}</a></li>
              <li style="width:20%" @if($position == HConstants::EVENT_PROCESED) class="active" @endif><a>{{trans('package.processed')}}</a></li>
              <li style="width:20%" @if($position == HConstants::EVENT_TRANSIT) class="active" @endif><a>{{trans('package.inTransit')}}</a></li>
              <li style="width:20%" @if($position == HConstants::EVENT_ARRIVED) class="active" @endif><a>{{trans('package.available')}}</a></li>
              <li style="width:20%" @if($position == HConstants::EVENT_AVAILABLE) class="active" @endif><a>{{trans('package.delivered')}}</a></li>
            </ul>
          </center>
        </div>
    </div>
    <div class="text-center text-muted" id ="details">
      <table class="table table-striped table-hover table-responsive">
        <thead>
          <tr>
              <th>{{trans('package.large')}}: {{$package->large}} {{trans('messages.in')}}</th>
              <th>{{trans('package.width')}}: {{$package->width}} {{trans('messages.in')}}</th>
              <th>{{trans('package.height')}}: {{$package->height}} {{trans('messages.in')}} </th>
              <th>{{trans('package.volume')}}: {{$package->volumetricweightm}} ft3</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
     <table class="table table-striped table-hover table-responsive" id="dtble2">
       <thead>
         <tr>
             <th style="text-align: center">{{trans('messages.date')}}</th>
             <th style="text-align: center">{{trans('messages.description')}}</th>
             <th style="text-align: center">{{trans('messages.observation')}}</th>
         </tr>
       </thead>
       <tbody>
         @if(isset($logs))
          @foreach($logs as $row)
            <tr>
              <td>{{$row->created_at}}</td>
              <td>{{$row->getEvent->description}}</td>
              <td>@if(!empty($row->observation))({{$row->observation}})@endif</td>
            </tr>
           @endforeach
         @endif
       </tbody>
     </table>
  </div>
 <div class="panel-footer text-center text-muted">
   {{trans('package.status')}}: {{$package->getLastEvent->description}}
   @if($position == HConstants::EVENT_RECEIVED) <span><i class="fa fa-building-o" aria-hidden="true"></i></span> @endif
   @if($position == HConstants::EVENT_PROCESED) <span><i class="fa fa-cubes" aria-hidden="true"></i></span> @endif
   @if($position == HConstants::EVENT_TRANSIT) <span><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span> @endif
   @if($position == HConstants::EVENT_ARRIVED) <span><i class="fa fa-check" aria-hidden="true"></i></span> @endif
   @if($position == HConstants::EVENT_AVAILABLE) <span><i class="fa fa-handshake-o" aria-hidden="true"></i></span> @endif
 </div>
</div>
