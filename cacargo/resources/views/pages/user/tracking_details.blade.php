<?php
use App\Helpers\HUserType;
use App\Helpers\HConstants;

if(isset($package) && !is_null($package->getLastEvent)) {
  $position = $package->getLastEvent->step;
}
else {
  $position = -1;
}

$events = Event::all();
$events_num = Event::query()->where('active','=',1)->count();
?>
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
  <div class="panel-heading"><span class="text-muted">{{trans('package.type2')}} </span><span class="pull-right"><span class="text-muted">{{trans('package.tracking2')}} | {{$package->tracking}}</span></span></div>
  <div class="panel-body">
    <div class="panel panel-default">
        <div class="panel-body">
          <center>
            <ul class="nav nav-wizard">
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
