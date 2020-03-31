<?php
  use App\Models\Admin\Package;
  use App\Models\Admin\Pickup;
 ?>
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
                <td><b>{{trans('shipment.code')}}:</b></td>
                <td>{{isset($shipment) ? $shipment->code : ''}}</td>
              </tr>
              <tr>
                <td><b>{{trans('shipment.operator')}}:</b></td>
                <td>{{isset($shipment) ? $shipment->getOperator->code : ''}} {{isset($shipment) ? $shipment->getOperator->code : ''}}</td>
              </tr>
              <tr>
                <td><b>{{trans('shipment.type')}}:</b></td>
                <td>{{isset($shipment) ? $shipment->getTransport->spanish : ''}}</td>
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
                <td><b>{{trans('shipment.shipper')}}:</b></td>
                <td>@if(isset($shipment) && $shipment->getShipper != null) {{$shipment->getShipper->code}} {{$shipment->getShipper->name}}@endif</td>
              </tr>
              <tr>
                <td><b>{{trans('shipment.consigneer')}}:</b></td>
                <td>@if(isset($shipment) && $shipment->getConsigner != null) {{$shipment->getConsigner->code}} {{$shipment->getConsigner->name}}@endif</td>
              </tr>
              <tr>
                <td><b>{{trans('package.status')}}:</b></td>
                <td>
                  @if($shipment->last_event == '1')
                    <span class="label label-default">{{$shipment->getLastEvent->name}}</span>
                  @elseif($shipment->last_event == '2')
                    <span class="label label-primary">{{$shipment->getLastEvent->name}}</span>
                  @elseif($shipment->last_event == '3')
                    <span class="label label-info">{{$shipment->getLastEvent->name}}</span>
                  @elseif($shipment->last_event == '4')
                    <span class="label label-info">{{$shipment->getLastEvent->name}}</span>
                  @elseif($shipment->last_event == '5')
                    <span class="label label-warning">{{$shipment->getLastEvent->name}}</span>

                  @elseif($shipment->last_event == '6')
                    <span class="label label-success">{{$shipment->getLastEvent->name}}</span>
                  @endif
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!--change status-->
    @if($shipment->last_event <= 5)
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
                  <select style="width:100%;" class="form-control" name="icsBookigStatus" id="ics_shipment_status">
                    @foreach($event as $key => $value)
                        @if($value->id > $shipment->last_event)
                          <option item ="{{$value->id}}" name="{{$value->name}}" value="{{$value->id}}">{{$value->name}}</option>
                        @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-lg-2">
                <button class="btn btn-primary btn-sm" style="width: 100%" type="button" name="button" id="ics_button_change_shipment_status" onclick="icsChangeStatusShipment({{$shipment->id}})"><span><i class="fa fa-floppy-o" aria-hidden="true"></i></span> {{trans('shipment.save')}}</button>
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
          <div class="panel-heading">{{trans('shipment.cargoContain')}} <span class="pull-right"><i class="fa fa-cubes" aria-hidden="true"></i></span></div>
          <div class="panel-body">
            <table class="table text-center table-striped table-responsive table-hover table-bordered">
              <thead>
                <th>{{trans('shipment.item')}}</th>
                <th>{{trans('shipment.package')}}</th>
                <th>{{trans('shipment.type')}}</th>
                <th>{{trans('shipment.volume')}}</th>
                <th>{{trans('shipment.weight')}}</th>
              </thead>
              <tbody>
                @foreach($shipmentDetail as $key => $value)
                  <tr item="{{$value->toInnerJson()}}">
                    <td style="padding:4px">{{$key + 1}}</td>
                    <td style="padding:4px">{{isset($value->warehouse) ? (Package::find($value->warehouse)->code) : (isset($value->pickup) ? (Pickup::find($value->pickup)->code) : '')}}</td>
                    <td style="padding:4px">@if($value->warehouse != null) {{trans('shipment.warehouse')}} @else {{trans('shipment.pickup')}}  @endif</td>
                    <td style="padding:4px">{{$value->volume}} {{isset($value->warehouse) ? ((Package::find($value->warehouse)->type == 1) ? ((Package::find($value->warehouse)->unidad == 1) ? 'm3' : 'ft3' ) : ((Package::find($value->warehouse)->unidad == 1) ? 'Vkg' : 'Vlb' ) ) : (isset($value->pickup) ? ((Pickup::find($value->pickup)->type == 1) ? ((Pickup::find($value->pickup)->unidad == 1) ? 'm3' : 'ft3') : ((Pickup::find($value->pickup)->unidad == 1) ? 'Vkg' : 'Vlb') ) : '')}}</td>
                    <td style="padding:4px">{{$value->weight}} {{isset($value->warehouse) ? ((Package::find($value->warehouse)->type == 1) ? ((Package::find($value->warehouse)->unidad == 1) ? 'kg' : 'lb' ) : ((Package::find($value->warehouse)->unidad == 1) ? 'kg' : 'lb' ) ) : (isset($value->pickup) ? ((Pickup::find($value->pickup)->type == 1) ? ((Pickup::find($value->pickup)->unidad == 1) ? 'kg' : 'lb') : ((Pickup::find($value->pickup)->unidad == 1) ? 'kg' : 'lb') ) : '')}}</td>
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
          <div class="panel-heading">{{trans('shipment.eventList')}} <span class="pull-right"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></span></div>
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
                      <td style="text-align: center;padding: 4px;" >{{$shipment->code}}</td>
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
