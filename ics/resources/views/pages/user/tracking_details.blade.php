<?php
use App\Helpers\HUserType;
use App\Helpers\HConstants;
/**
*
*/
if(isset($package) && !is_null($package->getLastEvent)) {
  $position = $package->getLastEvent->id;
  //dd($position);
}
else {
//  $position = -1;
}
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
  <div class="panel-heading"><span class="text-muted">{{trans('package.type2')}} | {{isset($package) && $package->getCategory != HConstants::RESPONSE_NULL ? $package->getCategory->label : ''}} </span><span class="pull-right"><span class="text-muted">{{trans('package.tracking2')}} | {{$package->tracking}}</span></span></div>
  <div class="panel-body">
    <div class="panel panel-default">
        <div class="panel-body">
          @if ($events_number == 1)
          <center>
            <ul class="nav nav-wizard">
              @foreach ($status as $key => $value)
              <?php $i = 1; ?>
              <li title="{{$value->description}}" style="width:100%" title={{$value->description}}@if($position == $i) class="active" @endif><a>{{$value->id}}</a></li>
              <?php $i++; ?>
              @endforeach
            </ul>
          </center>
          @endif
          @if ($events_number == 2)
          <center>
            <ul class="nav nav-wizard">
              @foreach ($status as $key => $value)
              <?php $i = 1; ?>
              <li title="{{$value->description}}" style="width:50%" @if($position == $i) class="active" @endif><a>{{$value->name}}</a></li>
              <?php $i++; ?>
              @endforeach
            </ul>
          </center>
          @endif
          @if ($events_number == 3)
          <center>
            <ul class="nav nav-wizard">
              <?php $i = 1; ?>
              @foreach ($status as $key => $value)
              <li title="{{$value->description}}" style="width:33%" @if($position == $i) class="active" @endif><a>{{$value->name}}</a></li>
              <?php $i++; ?>
              @endforeach
            </ul>
          </center>
          @endif
          @if ($events_number == 4)
          <center>
            <ul class="nav nav-wizard">
              <?php $i = 1; ?>
              @foreach ($status as $key => $value)
              <li title="{{$value->description}}" style="width:25%" @if($position == $i) class="active" @endif><a>{{$value->name}}</a></li>
              <?php $i++; ?>
              @endforeach
            </ul>
          </center>
          @endif
          @if ($events_number == 5)
          <center>
            <ul class="nav nav-wizard">
              <?php $i = 1; ?>
              @foreach ($status as $key => $value)
              <li title="{{$value->description}}" style="width:20%" @if($position == $i) class="active" @endif><a>{{$value->name}}</a></li>
              <?php $i++; ?>
              @endforeach
            </ul>
          </center>
          @endif
          @if ($events_number == 6)
          <center>
            <ul class="nav nav-wizard">
              <?php $i = 1; ?>
              @foreach ($status as $key => $value)
                <li title="{{$value->description}}" style="width:16%" @if($position == $i) class="active" @endif><a>{{$value->name}}</a></li>
                <?php $i++; ?>
              @endforeach
            </ul>
          </center>
          @endif
        </div>
    </div>
  <fieldset class="form">
    <div class="text-center text-muted" id ="details">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
              <th>{{trans('package.large')}}: {{$resultpacklarge}} cm</th>
              <th>{{trans('package.width')}}: {{$resultpackwidth}} cm</th>
              <th>{{trans('package.height')}}: {{$resultpackheight}} cm</th>
              <th>{{trans('package.volume')}}: {{$resultpackvol}} ft<sup>3</sup></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </fieldset>
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
