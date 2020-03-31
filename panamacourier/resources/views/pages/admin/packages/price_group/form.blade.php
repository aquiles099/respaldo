<form role="form" action="{{asset($path)}}" method="post">
  @if(isset($priceGroup))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'spanish'])">
      <label class="col-lg-3 control-label">{{trans('price_group.spanish')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('price_group.spanish')}}" name="spanish" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($priceGroup) ? $priceGroup->spanish : Input::get('spanish')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'spanish'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'english'])">
      <label class="col-lg-3 control-label">{{trans('price_group.english')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('price_group.english')}}" name="english" type="text" maxlength="100" min="5" required="true" value="{{isset($priceGroup) ? $priceGroup->english : Input::get('english')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'english'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'min'])">
      <label class="col-lg-3 control-label">{{trans('price_group.interval')}}</label>
      <div class="col-lg-4">
        <input class="form-control" placeholder="{{trans('price_group.min')}}" name="min" type="number" maxlength="10" min="1" required="true" value="{{isset($priceGroup) ? $priceGroup->min : Input::get('min')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'min'])
      </div>
      <div class="col-lg-5">
        <input class="form-control" placeholder="{{trans('price_group.max')}}" name="max" type="number" maxlength="10" min="5" required="true" value="{{isset($priceGroup) ? $priceGroup->max : Input::get('max')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'max'])
      </div>
    </div>
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons">
        <button type="submit" class="btn btn-info pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($priceGroup)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
