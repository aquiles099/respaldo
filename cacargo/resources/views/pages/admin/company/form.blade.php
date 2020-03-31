<form onsubmit="createLoad()" role="form" action="{{asset($path)}}" method="post" id="formCompany">
  @if(isset($company))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('company.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('company.name')}}" name="name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($company) ? $company->name : Input::get('name')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'ruc'])">
      <label class="col-lg-3 control-label">{{trans('company.ruc')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('company.ruc')}}" name="ruc" type="text" maxlength="25" min="5" required="true" value="{{isset($company) ? $company->ruc : Input::get('ruc')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'ruc'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])">
      <label class="col-lg-3 control-label">{{trans('company.direction')}}</label>
      <div class="col-lg-9">
        <textarea class="form-control" placeholder="{{trans('company.direction')}}" name="direction" maxlength="255" min="5" required="true" rows="4" @include('form.readonly')>{{isset($company) ? $company->direction : Input::get('direction')}}</textarea>
        @include('errors.field', ['field' => 'direction'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'phone_01'])">
      <label class="col-lg-3 control-label">{{trans('company.phone_main')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('company.phone_main')}}" name="phone_01" type="text" maxlength="25" min="5" required="true" value="{{isset($company) ? $company->phone_01 : Input::get('phone_01')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'phone_01'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'phone_02'])">
      <label class="col-lg-3 control-label">{{trans('company.phone_alternative')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('company.phone_alternative')}}" name="phone_02" type="text" maxlength="25" min="5" value="{{isset($company) ? $company->phone_02 : Input::get('phone_02')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'phone_02'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'email_01'])">
      <label class="col-lg-3 control-label">{{trans('company.email_main')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('company.email_main')}}" name="email_01" type="email" maxlength="50" min="5" required="true" value="{{isset($company) ? $company->email_01 : Input::get('email_01')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'email_01'])
      </div>
    </div>
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'email_02'])">
      <label class="col-lg-3 control-label">{{trans('company.email_alternative')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('company.email_alternative')}}" name="email_02" type="email" maxlength="50" min="5" value="{{isset($company) ? $company->email_02 : Input::get('email_02')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'email_02'])
      </div>
    </div>
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons" id="divButton">
        <button type="submit" class="btn btn-primarypull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($company)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
