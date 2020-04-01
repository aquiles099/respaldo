<form onsubmit="createLoad()" role="form" action="{{asset($path)}}" method="post">
  @if(isset($category))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'label'])">
      <label class="col-lg-3 control-label">{{trans('category.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('category.name')}}" name="label" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($category) ? $category->label : Input::get('label')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'label'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'percentage'])">
      <label class="col-lg-3 control-label">{{trans('category.percentage')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('category.percentage')}}" name="percentage" type="float" autofocus min="1" required="true" value="{{isset($category) ? $category->percentage : Input::get('percentage')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'percentage'])
      </div>
    </div>
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons" id="divButton">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($percentage)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
