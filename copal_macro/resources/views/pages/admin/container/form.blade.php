<form role="form" action="{{asset($path)}}" method="post">
  @if(isset($container))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('container.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('container.name')}}" name="name" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($container) ? $container->name : clear(Input::get('name'))}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($container)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
