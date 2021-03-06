@include('sections.translate')
<div class="panel panel-default" id="pnlft">
  <div class="panel-body">

    @if(isset($transport))
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    @endif

  @if($transport->id=='1')
    <div style="text-align: right;padding-bottom: 2%;">
      <button class="btn btn-primary" onclick="adddetailstransport()">{{trans('transport.boat')}}</button>
    </div>
  @else
    <div style="text-align: right;padding-bottom: 2%;">
      <button class="btn btn-primary" onclick="adddetailstransport()">{{trans('transport.airport')}}</button>
    </div>
  @endif
    <form role="form" action="" method="" id="formSerial">
      <fieldset class="form">
        <!--Service Name -->
        <div class="form-group row @include('errors.field-class', ['field' => 'spanish'])">
          <label class="col-lg-3 control-label">{{trans('transport.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('transport.name')}}" name="spanish" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($transport) ? $transport->spanish : clear(Input::get('spanish'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'spanish'])
          </div>
        </div>
        <!--Service Price -->
        <div class="form-group row @include('errors.field-class', ['field' => 'price'])">
          <label class="col-lg-3 control-label">{{trans('transport.price')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('transport.price')}}" name="price" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($transport) ? $transport->price : clear(Input::get('price'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'price'])
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</div>
