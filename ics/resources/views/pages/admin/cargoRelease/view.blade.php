<div class="panel panel-default">
  <div class="panel-body">
    <fieldset  item ="{{$cargo_release->toInnerJson()}}">
      <div class="row">
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-body">
              <table class="table table-striped">
                <tr>
                  <td><b>{{trans('cargoRelease.code')}}:</b></td>
                  <td>{{isset($cargo_release) ? $cargo_release->code: trans('cargoRelease.notFoundData')}}</td>
                </tr>
                <tr>
                  <td><b>{{trans('cargoRelease.releaseDate')}}:</b></td>
                  <td>{{isset($cargo_release) ? $cargo_release->release_date: trans('cargoRelease.notFound')}}</td>
                </tr>
                <tr>
                  <td><b>{{trans('cargoRelease.releaseTime')}}:</b></td>
                  <td>{{isset($cargo_release) ? $cargo_release->release_time: trans('cargoRelease.notFound')}}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-body">
              <table class="table table-striped">
                <tr>
                  <td><b>{{trans('cargoRelease.status')}}:</b></td>
                  <td>
                    @if($cargo_release->last_event == '1')
                      <span class="label label-default">{{$cargo_release->getLastEvent->name}}</span>
                    @elseif($cargo_release->last_event == '2')
                      <span class="label label-primary">{{$cargo_release->getLastEvent->name}}</span>
                    @elseif($cargo_release->last_event == '3')
                      <span class="label label-info">{{$cargo_release->getLastEvent->name}}</span>
                    @elseif($cargo_release->last_event == '4')
                      <span class="label label-info">{{$cargo_release->getLastEvent->name}}</span>
                    @elseif($cargo_release->last_event == '5')
                      <span class="label label-warning">{{$cargo_release->getLastEvent->name}}</span>

                    @elseif($cargo_release->last_event == '6')
                      <span class="label label-success">{{$cargo_release->getLastEvent->name}}</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>{{trans('cargoRelease.contact_name_user')}}:</b></td>
                  <td>{{isset($cargo_release) ? $cargo_release->contact_name: trans('cargoRelease.notFound')}}</td>
                </tr>
                <tr>
                  <td><b>{{trans('cargoRelease.contact_phone_user')}}:</b></td>
                  <td>{{isset($cargo_release) ? $cargo_release->contact_phone: trans('cargoRelease.notFound')}}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!--change status-->
      @if($cargo_release->last_event < $events_num)
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

              <div  class="col-md-4" style="padding-right: 0px;padding-left: 0px;">
                  <label class="col-lg-3 control-label" id="labelDirection" style="padding-top: 5px;" >{{trans('package.status')}}:</label>
                  <div class="col-lg-9">
                      <select class="form-control" name="icscargoReleaseStatus" id="icscargoReleaseStatus">
                        @if(isset($event))
                          @foreach($event as $key => $value)
                            @if($value->id >= $cargo_release->last_event)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                            @endif
                          @endForeach
                        @endif
                      </select>
                    </div>
                </div>
                <div class="col-lg-2">
                  <button class="btn btn-primary btn-sm" onclick="icsChangeStatusCargoRelease({{$cargo_release->id}})" style="width: 100%" type="button" name="button" id="ics_button_change_cargoRelease_status"><span><i class="fa fa-floppy-o" aria-hidden="true"></i></span> {{trans('booking.save')}}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif
      <!--list of cargo-->
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">{{trans('cargoRelease.cargoContain')}} <span class="pull-right"><i class="fa fa-cubes" aria-hidden="true"></i></span></div>
            <div class="panel-body">
              <table class="table text-center table-striped table-responsive table-hover table-bordered">
                <thead>
                  <th>{{trans('cargoRelease.item')}}</th>
                  <th>{{trans('cargoRelease.type')}}</th>
                  <th>{{trans('cargoRelease.name')}}</th>
                  <th>{{trans('cargoRelease.packages')}}</th>
                </thead>
                <tbody>
                  @foreach($cargo_release_detail as $key => $value)
                    <tr item ="{{$value}}">
                      <td style="padding:4px">{{$key + 1}}</td>
                      <td style="padding:4px">{{($value->warehouse_receipt != null) ? trans('cargoRelease.warehouseReceipt') : trans('cargoRelease.pickupOrder')}}</td>
                      <td style="padding:4px">{{($value->warehouse_receipt != null) ? $value->getWarehouseReceipt->code : $value->getPickupOrder->code}}</td>
                      <td style="padding:4px">{{($value->warehouse_receipt != null) ? $value->getWarehouseReceiptCount($value->warehouse_receipt) : $value->getPickupOrderCount($value->pickup_order) }}</td>
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
            <div class="panel-heading">{{trans('cargoRelease.eventList')}} <span class="pull-right"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></span></div>
            <div class="panel-body">
              <table class="table text-center table-striped table-responsive table-hover table-bordered">
                <thead>
                  <th >{{trans('cargoRelease.item')}}</th>
                  <th >{{trans('cargoRelease.user')}}</th>
                  <th >{{trans('messages.event')}}</th>
                  <th >{{trans('cargoRelease.observation')}}</th>
                </thead>
                <tbody>
                  @foreach($list_event as $key => $value)
                  <tr item="{{$value->toInnerJson()}}">
                    <td style="padding:4px">{{$key + 1}}</td>
                    <td style="padding:4px">{{$value->user}}</td>
                    <td style="padding:4px">{{$value->getEvent->name}}</td>
                    <td style="padding:4px">{{$value->observation}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </fieldset>
  </div>
</div>
