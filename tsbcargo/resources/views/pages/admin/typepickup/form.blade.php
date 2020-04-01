<form role="form" action="{{asset($path)}}" onsubmit="createLoad()" method="post">
  @if(isset($typepickup))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('typepickup.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('typepickup.name')}}" name="name" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($typepickup) ? $typepickup->name : clear(Input::get('name'))}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>

    <!---->
    <div class="form-group row @include('errors.field-class', ['field' => 'description'])">
      <label class="col-lg-3 control-label">{{trans('typepickup.description')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('typepickup.description')}}" name="description" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($typepickup) ? $typepickup->description : clear(Input::get('description'))}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'description'])
      </div>
    </div>
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons" id="divButton">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($tipepickup)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
