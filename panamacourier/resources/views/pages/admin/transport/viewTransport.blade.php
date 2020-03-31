@include('sections.translate')

<div class="panel panel-default">
  <div class="panel-body">
    <form role="form" action="" method="" id="formSerial">
      @if(isset($transport))
        <input type="hidden" name="_method" value="patch">
      @endif
      <fieldset class="form">
        <!--Transport Name -->
        <div class="form-group row @include('errors.field-class', ['field' => 'spanish'])">
          <label class="col-lg-3 control-label">{{trans('transport.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('transport.name')}}" name="spanish" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($transport) ? $transport->spanish : clear(Input::get('spanish'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'spanish'])
          </div>
        </div>
        <!--Transport Price
        <div class="form-group row @include('errors.field-class', ['field' => 'price'])">
          <label class="col-lg-3 control-label">{{trans('transport.price')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('transport.price')}}" name="price" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($transport) ? $transport->price : clear(Input::get('price'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'price'])
          </div>
        </div>-->
      </fieldset>
    </form>
  </div>
  <div class="panel-footer" id="pft2">
    <a href="javascript:icsEditTransport({{$transport->id}}, true)">
     <span class="badge" data-toggle="tooltip" title="{{trans('transport.editPort')}}">
       <span class="glyphicon glyphicon-pencil"></span>
     </span>
   </a>
  </div>
</div>
