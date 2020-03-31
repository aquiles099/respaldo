@include('sections.translate')

<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
      <!--first panel-->
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <b>
              <div class="text-center">{{trans('transport.details')}}</div>
            </b>
          </div>
          <div class="panel-body">
            <form role="form" id="formSerial" style="margin-bottom: 208px">
              <fieldset class="form">
                <!--Service Name -->
                <div class="form-group row @include('errors.field-class', ['field' => 'spanish'])">
                  <label class="col-lg-3 control-label">{{trans('transport.name')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('transport.name')}}" name="spanish" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($transport) ? ucwords($transport->spanish) : clear(Input::get('spanish'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'spanish'])
                  </div>
                </div>
                <!--Service Price
                <div class="form-group row @include('errors.field-class', ['field' => 'price'])">
                  <label class="col-lg-3 control-label">{{trans('transport.price')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('transport.price')}}" name="price" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($transport) ? $transport->price : clear(Input::get('price'))}}" @include('form.readonly')>
                    @include('errors.field', ['field' => 'price'])
                  </div>
                </div>
                -->
              </fieldset>
            </form>
          </div>
          <div class="panel-footer" id="pft2">
            <a href="javascript:icsEditTransport({{$transport->id}}, false)">
              <span class="badge" data-toggle="tooltip" title="{{trans('transport.editPort')}}">
                <span class="glyphicon glyphicon-pencil"></span>
              </span>
            </a>
            <a href="javascript:icsLoadPortForm({{$transport->id}})">
              <span class="badge" data-toggle="tooltip"
                @if($transport->id == 1)
                  title="{{trans('transport.newPort')}}"
                @elseif($transport->id == 2)
                  title="{{trans('transport.newAirport')}}"
                @else
                  title="{{trans('transport.newPickupPoint')}}"
                @endif>
                <span class="glyphicon glyphicon-plus"></span>
              </span>
            </a>
          </div>
        </div>
      </div>
      <!--second panel-->
      <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <div class="text-center">
                <b>
                  @if($transport->id == 1)
                    {{trans('transport.ports')}}
                  @elseif($transport->id == 2)
                    {{trans('transport.airports')}}
                  @else
                    {{trans('transport.pickupPoints')}}
                  @endif
                </b>
              </div>
            </div>
            <div class="panel-body" style="min-height: 378px">
              <table class="table table-striped table-hover table-responsive" id="dtble2">
                <thead>
                  <th>{{trans('transport.code')}}</th>
                  <th>{{trans('transport.namePort')}}</th>
                  <th>{{trans('transport.created_at')}}</th>
                  <th>{{trans('transport.actions')}}</th>
                </thead>
                <tbody>
                  @foreach($ports as $key => $value)
                    <tr item="{{$value}}">
                      <td>{{$value->code}}</td>
                      <td>{{$value->name}}</td>
                      <td>{{$value->created_at->format('Y-m-d')}}</td>
                      <td>
                        <ul class="table-actions">
                          <li><a href="javascript:icsViewPort({{$value->id}}, true)"><i class="fa fa-eye" title="{{trans('messages.details')}}"></i></a></li>
                          <li><a onclick="icsPortDelete({{$value->id}},{{$value->transport}})"><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                        </ul>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
      </div>
      </div>
    </div>
  </div>
</div>
