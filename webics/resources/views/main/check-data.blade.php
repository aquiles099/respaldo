@section('title-page', trans('messages.check-data'))
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
  <div class="container">
  	<div class="blankdivider30"></div>
      @include('sections.messages')
  	<h4>{{trans('messages.check-data')}}</h4>
  	<div class="row">
  		<div class="span12">
  			<div class="cform" id="contact-form">
          <div id="errormessage"></div>
            <form action="{{asset("/check-data/{$client->slug}")}}" method="post" role="form" class="contactForm" onsubmit="icsGeneralLoad('sendButton')">
              @if(isset($client))
                <input type="hidden" name="_method" value="patch">
              @endif
              <div class="row">
                <div class="span6">
                  <!-- Name -->
                  <div class="field your-name form-group @include('errors.field-class', ['field' => 'name'])">
                    <input type="text" name="name" class="form-control" id="name" value="{{isset($client) ? $client->name :Input::get('name')}}" placeholder="{{trans('messages.name')}}" required="true" readonly="true"/>
                    @include('errors.field', ['field' => 'name'])
                  </div>
                  <!-- Dni -->
                  <div class="field your-name form-group @include('errors.field-class', ['field' => 'dni'])">
                    <input type="text" name="dni" class="form-control" id="dni" value="{{Input::get('dni')}}" placeholder="{{trans('messages.dni')}}" required="true"/>
                    @include('errors.field', ['field' => 'dni'])
                  </div>
                  <!-- Country -->
                  <div class="field your-name form-group @include('errors.field-class', ['field' => 'country'])" style="margin-bottom: 45px">
                    <select type="text" name="country" class="form-control icsselect" id="country" value="{{Input::get('country')}}" placeholder="{{trans('messages.country')}}" required="true"/>
                      <option value="0">{{trans('messages.country')}} - {{trans('messages.selectoption')}}</option>
                      @foreach($countrys as $key => $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                      @endforeach
                    </select>
                    @include('errors.field', ['field' => 'country'])
                  </div>
                  <!-- Region -->
                  <div class="field your-name form-group @include('errors.field-class', ['field' => 'region'])">
                    <input type="text" name="region" class="form-control" id="region" value="{{Input::get('region')}}" placeholder="{{trans('messages.region')}}" required="true"/>
                    @include('errors.field', ['field' => 'region'])
                  </div>
                  <!-- City-->
                  <div class="field subject form-group @include('errors.field-class', ['field' => 'city'])">
                    <input type="text" class="form-control" name="city" id="city" value="{{Input::get('city')}}" placeholder="{{trans('messages.city')}}" required="true"/>
                    @include('errors.field', ['field' => 'city'])
                  </div>
                  <!-- Postal Code-->
                  <div class="field subject form-group @include('errors.field-class', ['field' => 'postal_code'])">
                    <input type="text" class="form-control" name="postal_code" id="postal_code" value="{{Input::get('postal_code')}}" placeholder="{{trans('messages.postal_code')}}" required="true"/>
                    @include('errors.field', ['field' => 'postal_code'])
                  </div>
                  <!-- Address -->
                  <div class="field message form-group @include('errors.field-class', ['field' => 'address'])">
                    <textarea class="form-control" name="address" id="address" rows="5"  placeholder="{{trans('messages.address')}}" required="true">{{Input::get('address')}}</textarea>
                    @include('errors.field', ['field' => 'address'])
                  </div>
                </div>
                <div class="span6">
                  <!-- Phone -->
                  <div class="field subject form-group @include('errors.field-class', ['field' => 'phone'])">
                    <input type="text" class="form-control" name="phone" id="phone" value="{{Input::get('phone')}}" placeholder="{{trans('messages.phone')}}" required="true"/>
                    @include('errors.field', ['field' => 'phone'])
                  </div>
                  <!-- Email -->
                  <div class="field your-email form-group @include('errors.field-class', ['field' => 'email'])">
                    <input type="text" class="form-control" name="email" id="email" value="{{isset($client) ? $client->email : Input::get('email')}}" placeholder="{{trans('messages.email')}}" required="true" readonly="true"/>
                    @include('errors.field', ['field' => 'email'])
                  </div>
                  <!-- Web Page -->
                  <div class="field subject form-group @include('errors.field-class', ['field' => 'webpage'])">
                    <input type="text" class="form-control" name="webpage" id="webpage" value="{{Input::get('webpage')}}" placeholder="{{trans('messages.webpage')}}" required="true"/>
                    @include('errors.field', ['field' => 'webpage'])
                  </div>
                  <!-- Name Manager -->
                  <div class="field subject form-group @include('errors.field-class', ['field' => 'name_manager'])">
                    <input type="text" class="form-control" name="name_manager" id="name_manager" value="{{Input::get('name_manager')}}" placeholder="{{trans('messages.name_manager')}}" required="true"/>
                    @include('errors.field', ['field' => 'name_manager'])
                  </div>
                  <!-- Last Name Manager -->
                  <div class="field subject form-group @include('errors.field-class', ['field' => 'last_name_manager'])">
                    <input type="text" class="form-control" name="last_name_manager" id="last_name_manager" value="{{Input::get('last_name_manager')}}" placeholder="{{trans('messages.last_name_manager')}}" required="true"/>
                    @include('errors.field', ['field' => 'last_name_manager'])
                  </div>
                  <!-- Phone Manager -->
                  <div class="field subject form-group @include('errors.field-class', ['field' => 'phone_manager'])">
                    <input type="text" class="form-control" name="phone_manager" id="phone_manager" value="{{Input::get('phone_manager')}}" placeholder="{{trans('messages.phone_manager')}}" required="true"/>
                    @include('errors.field', ['field' => 'phone_manager'])
                  </div>
                  <!-- Email Manager -->
                  <div class="field subject form-group @include('errors.field-class', ['field' => 'email_manager'])">
                    <input type="text" class="form-control" name="email_manager" id="email_manager" value="{{Input::get('email_manager')}}" placeholder="{{trans('messages.email_manager')}}" required="true"/>
                    @include('errors.field', ['field' => 'email_manager'])
                  </div>
                  <button id="sendButton" type="submit" class="btn btn-theme pull-right">{{trans('messages.send')}}</button>
                </div>
              </div>
            </form>
  			</div>
  		</div>
  	</div>
  </div>
</section>
@stop
