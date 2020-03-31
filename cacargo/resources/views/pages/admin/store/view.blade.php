<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    <form class="" action="" method="post" id="formSerial">
      <fieldset role="form">
        <!--name-->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])" id="">
          <div class="col-lg-3">
            <label for="name">{{trans('messages.name')}}</label>
          </div>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('messages.name')}}" id="name" name="name" type="text" maxlength="25" min="10" required="true" value="{{isset($store) ? $store->name : clear(Input::get('name'))}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>
        <!--description-->
        <div class="form-group row @include('errors.field-class', ['field' => 'description'])" id="">
          <div class="col-lg-3">
            <label for="description">{{trans('messages.description')}}</label>
          </div>
          <div class="col-lg-9">
            <textarea class="form-control" placeholder="{{trans('messages.description')}}" id="description" name="description"  required="true" @include('form.readonly')>{{isset($store) ? $store->description : clear(Input::get('description'))}}</textarea>
            @include('errors.field', ['field' => 'description'])
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</div>
