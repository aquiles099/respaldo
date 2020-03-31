<form role="form" action="{{asset($path)}}" method="post">
  @if(isset($client))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!--Nombre del cliente -->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('client.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('client.name')}}" name="name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($client) ? $client->name : Input::get('name')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!--Identificador del cliente -->
    <div class="form-group row @include('errors.field-class', ['field' => 'identifier'])">
      <label class="col-lg-3 control-label">{{trans('client.identifier')}}  <span class = "badge" data-toggle="tooltip" data-placement="top" title="{{trans('messages.indentToolTipText')}}"> ? </span></label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('client.identifier')}}" name="identifier" type="text" maxlength="25" min="5" value="{{isset($client) ? $client->identifier : Input::get('identifier')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'identifier'])
      </div>
    </div>
    <!--Direccion del cliente -->
    <div class="form-group row @include('errors.field-class', ['field' => 'direction'])">
      <label class="col-lg-3 control-label">{{trans('client.direction')}}</label>
      <div class="col-lg-9">
        <textarea class="form-control" placeholder="{{trans('client.direction')}}" name="direction" maxlength="255" min="5" required="true" rows="4" @include('form.readonly')>{{isset($client) ? $client->direction : Input::get('direction')}}</textarea>
        @include('errors.field', ['field' => 'direction'])
      </div>
    </div>
    <!--Telefono del cliente -->
    <div class="form-group row @include('errors.field-class', ['field' => 'phone'])">
      <label class="col-lg-3 control-label">{{trans('client.phone')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('client.phone')}}" name="phone" type="text" maxlength="25" min="5" required="true" value="{{isset($client) ? $client->phone : Input::get('phone')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'phone'])
      </div>
    </div>
    <!--Email del cliente -->
    <div class="form-group row @include('errors.field-class', ['field' => 'email'])">
      <label class="col-lg-3 control-label">{{trans('client.email')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('client.email')}}" name="email" type="email" maxlength="50" min="5" required="true" value="{{isset($client) ? $client->email : Input::get('email')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'email'])
      </div>
    </div>
    <!--Nombre de la compañia asociada-->
    <div class="form-group row ">
      <label class="col-lg-3 control-label">{{trans('client.company')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('client.company')}}" name="name_company" type="text" autofocus maxlength="100" min="5" required="true" value="{{$company->name}}" readonly>
      </div>
    </div>
    <!--Hidden ID -->
    <div class="form-group row @include('errors.field-class', ['field' => 'company'])" style="display:none">
      <label class="col-lg-3 control-label">{{trans('client.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('client.company')}}" name="company" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($company) ? $company->id : Input::get('company')}}" readonly>
        @include('errors.field', ['field' => 'company'])
      </div>
    </div>
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($client)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
