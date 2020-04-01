@include('sections.translate')
<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    <form role="form" action="" method="post" id="formSerial">
      @if(isset($office))
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
      @endif
      <fieldset class="form">
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('office.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('office.name')}}" name="name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($office) ? $office->name : Input::get('name')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'direction'])">
          <label class="col-lg-3 control-label">{{trans('office.direction')}}</label>
          <div class="col-lg-9">
            <textarea class="form-control" placeholder="{{trans('office.direction')}}" name="direction" maxlength="255" min="5" required="true" rows="4" @include('form.readonly')>{{isset($office) ? $office->direction : Input::get('direction')}}</textarea>
            @include('errors.field', ['field' => 'direction'])
          </div>
        </div>
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'phone'])">
          <label class="col-lg-3 control-label">{{trans('office.phone')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('office.phone')}}" name="phone" type="text" maxlength="25" min="5" required="true" value="{{isset($office) ? $office->phone : Input::get('direction')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'phone'])
          </div>
        </div>

        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'country'])">
          <label class="col-lg-3 control-label">{{trans('office.country')}}</label>
          <div class="col-lg-9">
            @if(!isset($readonly) || $readonly == false)
              <select style="width:100%;" class="form-control"  name="country" required="true" value="{{isset($office) ? $office->country : Input::get('country')}}" @include('form.readonly')>
                @foreach ($countries as $country)
                  <option {{isset($office) && $office->getCountry->id == $country->id ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                @endforeach
              </select>
            @else
            <input class="form-control" type="text" name="name" value="{{isset($office) ? $office->getCountry->name : Input::get('country')}}" name="country" required="true" placeholder="{{trans('office.country')}}" @include('form.readonly')>
            @endif
          </div>
          @include('errors.field', ['field' => 'country'])
        </div>
      </fieldset>
    </form>
  </div>
</div>
