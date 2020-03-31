<form role="form" action="{{asset($path)}}" method="post">
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
    <!--Transport Price -->
    <div class="form-group row @include('errors.field-class', ['field' => 'price'])">
      <label class="col-lg-3 control-label">{{trans('transport.price')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('transport.price')}}" name="price" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($transport) ? $transport->price : clear(Input::get('price'))}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'price'])
      </div>
    </div>
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($transport)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
