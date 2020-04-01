<form class="" action="{{asset($path)}}" method="post">
  <fieldset role="form">
    <!--name-->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])" id="">
      <div class="col-lg-3">
        <label for="name">{{trans('messages.name')}}</label>
      </div>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('messages.name')}}" id="name" name="name" type="text" maxlength="25" min="10" required="true" value="{{isset($store) ? $store->name : clear(Input::get('name'))}}" >
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!--description-->
    <div class="form-group row @include('errors.field-class', ['field' => 'description'])" id="">
      <div class="col-lg-3">
        <label for="description">{{trans('messages.description')}}</label>
      </div>
      <div class="col-lg-9">
        <textarea class="form-control" placeholder="{{trans('messages.description')}}" id="description" name="description"  required="true">{{isset($store) ? $store->description : clear(Input::get('description'))}}</textarea>
        @include('errors.field', ['field' => 'description'])
      </div>
    </div>
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($office)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
