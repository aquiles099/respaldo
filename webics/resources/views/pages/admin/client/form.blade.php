<div class="cform" id="contact-form">
  <form action="{{asset("$path")}}" method="post" role="form" class="contactForm">
    @if(isset($client))
      {{method_field('patch')}}
    @endif
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-6">
          <!-- Name -->
          <div class="field your-name form-group @include('errors.field-class', ['field' => 'name'])">
            <label for="name">{{trans('messages.name')}}</label>
            <input type="text" name="name" class="form-control" id="name" value="{{isset($client) ? $client->name : Input::get('name')}}" placeholder="{{trans('messages.name')}}" required="true"/>
            @include('errors.field', ['field' => 'name'])
          </div>
          <!-- Dni -->
          <div class="field your-name form-group @include('errors.field-class', ['field' => 'dni'])">
            <label for="dni">{{trans('messages.dni')}}</label>
            <input type="text" name="dni" class="form-control" id="dni" value="{{isset($client) ? isset($client->dni) ? $client->dni  : Input::get('dni') : Input::get('dni')}}" placeholder="{{trans('messages.dni')}}" required="true"/>
            @include('errors.field', ['field' => 'dni'])
          </div>
          <!-- Country -->
          <div class="field your-name form-group @include('errors.field-class', ['field' => 'country'])" style="margin-bottom: 45px">
            <label for="country">{{trans('messages.country')}}</label>
            <select type="text" name="country" class="form-control icsselect" id="country" value="{{Input::get('country')}}" placeholder="{{trans('messages.country')}}" required="true"/>
              <option value="0">{{trans('messages.country')}} - {{trans('messages.selectoption')}}</option>
              @foreach($countrys as $key => $value)
                <option {{isset($client) && $client->country == $value->id ? 'selected' : '' }} value="{{$value->id}}">{{$value->name}}</option>
              @endforeach
            </select>
            @include('errors.field', ['field' => 'country'])
          </div>
          <!-- Region -->
          <div class="field your-name form-group @include('errors.field-class', ['field' => 'region'])">
            <label for="region">{{trans('messages.region')}}</label>
            <input type="text" name="region" class="form-control" id="region" value="{{isset($client) ? isset($client->region) ? $client->region : Input::get('region') : Input::get('region')}}" placeholder="{{trans('messages.region')}}" required="true"/>
            @include('errors.field', ['field' => 'region'])
          </div>
          <!-- City-->
          <div class="field subject form-group @include('errors.field-class', ['field' => 'city'])">
            <label for="city">{{trans('messages.city')}}</label>
            <input type="text" class="form-control" name="city" id="city" value="{{isset($client) ? isset($client->city) ? $client->city : Input::get('city') : Input::get('city')}}" placeholder="{{trans('messages.city')}}" required="true"/>
            @include('errors.field', ['field' => 'city'])
          </div>
          <!-- Postal Code-->
          <div class="field subject form-group @include('errors.field-class', ['field' => 'postal_code'])">
            <label for="postal_code">{{trans('messages.postal_code')}}</label>
            <input type="text" class="form-control" name="postal_code" id="postal_code" value="{{isset($client) ? isset($client->postal_code) ? $client->postal_code : Input::get('postal_code') : Input::get('postal_code')}}" placeholder="{{trans('messages.postal_code')}}" required="true"/>
            @include('errors.field', ['field' => 'postal_code'])
          </div>
          <!-- Address -->
          <div class="field message form-group @include('errors.field-class', ['field' => 'address'])">
            <label for="address">{{trans('messages.address')}}</label>
            <textarea class="form-control" name="address" id="address" rows="5"  placeholder="{{trans('messages.address')}}" required="true">{{isset($client) ? isset($client->address) ? $client->address : Input::get('address') : Input::get('address')}}</textarea>
            @include('errors.field', ['field' => 'address'])
          </div>
        </div>
        <div class="col-md-6">
          <!-- Phone -->
          <div class="field subject form-group @include('errors.field-class', ['field' => 'phone'])">
            <label for="phone">{{trans('messages.phone')}}</label>
            <input type="text" class="form-control" name="phone" id="phone" value="{{isset($client) ? isset($client->phone) ? $client->phone : Input::get('phone') : Input::get('phone')}}" placeholder="{{trans('messages.phone')}}" />
            @include('errors.field', ['field' => 'phone'])
          </div>
          <!-- Email -->
          <div class="field your-email form-group @include('errors.field-class', ['field' => 'email'])">
            <label for="email">{{trans('messages.email')}}</label>
            <input type="text" class="form-control" name="email" id="email" value="{{isset($client) ? isset($client->email) ? $client->email : Input::get('email') : Input::get('email')}}" placeholder="{{trans('messages.email')}}" required="true" />
            @include('errors.field', ['field' => 'email'])
          </div>
          <!-- Web Page -->
          <div class="field subject form-group @include('errors.field-class', ['field' => 'webpage'])">
            <label for="webpage">{{trans('messages.webpage')}}</label>
            <input type="text" class="form-control" name="webpage" id="webpage" value="{{isset($client) ? isset($client->webpage) ? $client->webpage : Input::get('webpage') : Input::get('webpage')}}" placeholder="{{trans('messages.webpage')}}" required="true"/>
            @include('errors.field', ['field' => 'webpage'])
          </div>
          <!-- Web Page -->
          <div class="field subject form-group @include('errors.field-class', ['field' => 'sub_domain'])">
            <label for="sub_domain">{{trans('messages.sub')}}</label>
            <input type="text" class="form-control" name="sub_domain" id="sub_domain" value="{{isset($client) ? isset($client->sub_domain) ? $client->sub_domain : Input::get('sub_domain') : Input::get('sub_domain')}}" placeholder="{{trans('messages.sub')}}"/>
            @include('errors.field', ['field' => 'sub_domain'])
          </div>
          <!-- Name Manager -->
          <div class="field subject form-group @include('errors.field-class', ['field' => 'name_manager'])">
            <label for="name_manager">{{trans('messages.name_manager')}}</label>
            <input type="text" class="form-control" name="name_manager" id="name_manager" value="{{isset($client) ? isset($client->name_manager) ? $client->name_manager : Input::get('name_manager') : Input::get('name_manager')}}" placeholder="{{trans('messages.name_manager')}}" required="true"/>
            @include('errors.field', ['field' => 'name_manager'])
          </div>
          <!-- Last Name Manager -->
          <div class="field subject form-group @include('errors.field-class', ['field' => 'last_name_manager'])">
            <label for="last_name_manager">{{trans('messages.last_name_manager')}}</label>
            <input type="text" class="form-control" name="last_name_manager" id="last_name_manager" value="{{isset($client) ? isset($client->name_manager) ? $client->name_manager : Input::get('last_name_manager') : Input::get('last_name_manager')}}" placeholder="{{trans('messages.last_name_manager')}}" required="true"/>
            @include('errors.field', ['field' => 'last_name_manager'])
          </div>
          <!-- Phone Manager -->
          <div class="field subject form-group @include('errors.field-class', ['field' => 'phone_manager'])">
            <label for="phone_manager">{{trans('messages.phone_manager')}}</label>
            <input type="text" class="form-control" name="phone_manager" id="phone_manager" value="{{isset($client) ? isset($client->phone_manager) ? $client->phone_manager : Input::get('phone_manager') : Input::get('phone_manager')}}" placeholder="{{trans('messages.phone_manager')}}" required="true"/>
            @include('errors.field', ['field' => 'phone_manager'])
          </div>
          <!-- Email Manager -->
          <div class="field subject form-group @include('errors.field-class', ['field' => 'email_manager'])">
            <label for="email_manager">{{trans('messages.email_manager')}}</label>
            <input type="text" class="form-control" name="email_manager" id="email_manager" value="{{isset($client) ? isset($client->email_manager) ? $client->email_manager : Input::get('email_manager') : Input::get('email_manager')}}" placeholder="{{trans('messages.email_manager')}}" required="true"/>
            @include('errors.field', ['field' => 'email_manager'])
          </div>
          <button id="sendButton" type="submit" class="btn btn-primary pull-right">{{trans('messages.send')}}</button>
        </div>
      </div>
    </div>
  </form>
</div>
