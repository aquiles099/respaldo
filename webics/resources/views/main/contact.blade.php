@section('title-page', trans('messages.solicitude'))
@section('keywords', trans('messages.contactkeywords'))
@section('meta-facebook')
  <meta property="og:title" content="{{trans('messages.slogan')}}">
  <meta property="og:description" content="{{trans('messages.slogan')}} - {{trans('messages.solicitude')}}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{asset('/solicitude')}}">
  <meta property="og:image" content="{{asset('dist/img/favicon.png')}}">
  <meta property="og:image:width" content="250">
  <meta property="og:image:height" content="250">
  <meta property="og:site_name" content="{{trans('messages.ICS')}}">
@stop
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
  <div class="container">
  	<div class="blankdivider30"></div>
      @include('sections.messages')
  	<h4>{{trans('messages.solicitude')}}</h4>
  	<div class="row">
  		<div class="span12">
  			<div class="cform" id="contact-form">
          <div id="errormessage"></div>
            <form action="{{asset('/solicitude')}}" method="post" role="form" class="contactForm" onsubmit="icsGeneralLoad('sendButton')">
              <div class="row flyRight animated fadeInRightBig">
                <div class="span6">
                  <!-- Name -->
                  <div class="field your-name form-group @include('errors.field-class', ['field' => 'name'])">
                    <input type="text" name="name" class="form-control" id="name" value="{{Input::get('name')}}" placeholder="{{trans('messages.name')}}" required="true"/>
                    @include('errors.field', ['field' => 'name'])
                  </div>
                  <!-- Email -->
                  <div class="field your-email form-group @include('errors.field-class', ['field' => 'email'])">
                    <input type="text" class="form-control" name="email" id="email" value="{{Input::get('email')}}" placeholder="{{trans('messages.email')}}" required="true"/>
                    @include('errors.field', ['field' => 'email'])
                  </div>
                  <!-- Subject-->
                  <div class="field subject form-group @include('errors.field-class', ['field' => 'subject'])">
                    <input type="text" class="form-control" name="subject" id="subject" value="{{Input::get('subject')}}" placeholder="{{trans('messages.subject')}}" required="true"/>
                    @include('errors.field', ['field' => 'subject'])
                  </div>
                </div>
                <div class="span6">
                  <!-- Profile-->
                  <div class="field subject form-group @include('errors.field-class', ['field' => 'profile'])" style="margin-bottom: 45px">
                    <select class="form-control" name="profile" >
                      <option value="0">{{trans('messages.profile')}} - {{trans('messages.selectoption')}}</option>
                      @foreach($profiles as $key => $value)
                      <option value="{{$value['id']}}">{{$value['text']}}</option>
                      @endforeach
                    </select>
                    @include('errors.field', ['field' => 'profile'])
                  </div>
                  <!-- Description -->
                  <div class="field message form-group @include('errors.field-class', ['field' => 'description'])">
                    <textarea class="form-control" name="description" id="description" rows="5"  placeholder="{{trans('messages.message')}}" required="true" style="height: 165px">{{Input::get('description')}}</textarea>
                    @include('errors.field', ['field' => 'description'])
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
