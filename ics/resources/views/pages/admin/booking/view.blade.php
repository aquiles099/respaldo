<?php $lang = App::getLocale(); ?>
@include('sections.translate')

<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
      <!--first square-->
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <table class="table table-striped">
              <tr>
                <td><b>{{trans('booking.code')}}:</b></td>
                <td>{{isset($booking) ? $booking->code : ''}}</td>
              </tr>
              <tr>
                <td><b>{{trans('booking.course')}}:</b></td>
                <td>{{isset($booking) ? $booking->course : ''}}</td>
              </tr>
              <tr>
                <td><b>{{trans('booking.type')}}:</b></td>
                <td>{{isset($booking) ? ($lang == 'es')? $booking->getTransport->spanish : $booking->getTransport->english : ''}}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <!--second square-->
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <table class="table table-striped">
              <tr>
                <td><b>{{trans('booking.shipper')}}:</b></td>
                <td>@if(isset($booking->getShipper)) {{$booking->getShipper->code}}-{{$booking->getShipper->name}} {{$booking->getShipper->last_name}}@endif</td>
              </tr>
              <tr>
                <td><b>{{trans('booking.consigneer')}}:</b></td>
                <td>@if(isset($booking->getConsigner)) {{$booking->getConsigner->code}}-{{$booking->getConsigner->name}} {{$booking->getConsigner->last_name}}@endif</td>
              </tr>
              <tr>
                <td><b>{{trans('package.status')}}:</b></td>
                <td>
                  @if($booking->last_event == '1')
                    <span class="label label-default">{{$booking->getLastEvent->name}}</span>
                  @elseif($booking->last_event == '2')
                    <span class="label label-primary">{{$booking->getLastEvent->name}}</span>
                  @elseif($booking->last_event == '3')
                    <span class="label label-info">{{$booking->getLastEvent->name}}</span>
                  @elseif($booking->last_event == '4')
                    <span class="label label-info">{{$booking->getLastEvent->name}}</span>
                  @elseif($booking->last_event == '5')
                    <span class="label label-warning">{{$booking->getLastEvent->name}}</span>
                  @elseif($booking->last_event == '6')
                    <span class="label label-success">{{$booking->getLastEvent->name}}</span>
                  @endif
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!--change status-->
    @if($booking->last_event < $events_num)
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6 " style="padding-right: 0px;padding-left: 0px;">
                <label class="col-lg-3 control-label" style="padding-top: 5px;" id="labelDirection" >{{trans('package.observation')}}:</label>
                <div class="col-lg-9">
                   <input class="form-control" style="height:28px" placeholder="{{trans('package.observation')}}" id="observation" name="observation" type="text" value="" @include('form.readonly')>
                      @include('errors.field', ['field' => 'obervation'])
                </div>
              </div>

              <div class="col-md-4" style="padding-right: 0px;padding-left: 0px;">
                <label class="col-lg-3 control-label" id="labelDirection" style="padding-top: 5px;" >{{trans('package.status')}}:</label>
                <div class="col-lg-9">
                  <select class="form-control" name="icsBookigStatus" id="ics_booking_status">
                    @foreach($event as $key => $value)
                      @if($value->id >= $booking->last_event)
                        <option item ="{{$value->id}}" name="{{$value->name}}" value="{{$value->id}}">{{$value->name}}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-lg-2">
                <button class="btn btn-primary btn-sm" style="width: 100%" type="button" name="button" id="ics_button_change_booking_status" onclick="icsChangeStatusBooking({{$booking->id}})"><span><i class="fa fa-floppy-o" aria-hidden="true"></i></span> {{trans('booking.save')}}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    <!--details-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">{{trans('booking.cargoContain')}} <span class="pull-right"><i class="fa fa-cubes" aria-hidden="true"></i></span></div>
          <div class="panel-body">
            <table class="table text-center table-striped table-responsive table-hover table-bordered">
              <thead>
                <th>{{trans('booking.item')}}</th>
                <th>{{trans('booking.container')}}</th>
                <th>{{trans('booking.dimensions')}}</th>
                <th>{{trans('booking.description')}}</th>
              </thead>
              <tbody>
                @foreach($bookingDetail as $key => $value)
                  <tr item="{{$value->toInnerJson()}}">
                    <td style="padding:4px">{{$key + 1}}</td>
                    <td style="padding:4px">{{isset($value->getContainer->name) ? $value->getContainer->name : ''}}</td>
                    <td style="padding:4px">{{$value->large}}x{{$value->width}}x{{$value->height}}</td>
                    <td style="padding:4px">{{$value->description}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!--events-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">{{trans('booking.eventList')}} <span class="pull-right"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></span></div>
          <div class="panel-body">
            <table class="table text-center table-striped table-responsive table-hover table-bordered" id="tableHeader">
              <thead>
                <tr style="padding: 4px;">
                  <th style="width:20%">{{trans('messages.code')}}</th>
                  <th style="width:20%">{{trans('messages.user')}}</th>
                  <th style="width:20%">{{trans('messages.event')}}</th>
                  <th style="width:30%">{{trans('messages.observation')}}</th>
                </tr>
              </thead>
              <tbody id="table">
                @if(isset($event_list))
                  @foreach ($event_list as $row)
                    <tr style="padding: 4px;">
                      <td style="text-align: center;padding: 4px;" >{{$booking->code}}</td>
                      <td style="text-align: center;padding: 4px;" >{{$row->getUser['name']}}</td>
                      <td style="text-align: center;padding: 4px;" >{{$row->getEvent['name']}}</td>
                      <td style="text-align: center;padding: 4px;">{{$row->observation}}</td>
                    </tr>
                  @endforeach
                @endif
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
