@set('js', ['src/js/mail.js'])
@section('title-page', trans('messages.email'))
@section('admin-page-title', trans('messages.email'))
@extends('layouts.main.master')
@section('admin-actions')
@stop
@section('admin-body')
  @include('sections.messages')
  @include('pages.admin.contact.messages')
  <div class="container">
    <div class="row">
      <div class="span12">
        <div class="cform" id="contact-form">
          <form action="{{asset("$path")}}" method="post" onsubmit="icsGeneralLoad('sendButton')">
            <!--Nombre-->
            <div class="row" style="margin-bottom: 0px">
              <div class="col-md-1 ">
                <label for="">{{trans('messages.name')}}</label>
              </div>
              <div class="col-md-8 ">
                <div class="field your-email form-group @include('errors.field-class', ['field' => 'name'])">
                  <input type="text" id="name"  name="name" class="form-control" value="{{isset($contact) ? $contact->name :Input::get('name')}}"  placeholder="{{trans('messages.name')}}" required="true" />
                  @include('errors.field', ['field' => 'name'])
                </div>
              </div>
            </div>
            <!--Email-->
            <div class="row" style="margin-bottom: 0px">
              <div class="col-md-1 ">
                <label for="">{{trans('messages.email')}}</label>
              </div>
              <div class="col-md-8 ">
                <div class="field your-email form-group @include('errors.field-class', ['field' => 'email'])">
                  <input type="text" id="email"  name="email" class="form-control" value="{{isset($contact) ? $contact->email : Input::get('email')}}"  placeholder="{{trans('messages.email')}}" required="true" />
                  @include('errors.field', ['field' => 'email'])
                </div>
              </div>
            </div>
            <!--Asunto-->
            <div class="row" style="margin-bottom: 0px">
              <div class="col-md-1 ">
                <label for="">{{trans('messages.subject')}}</label>
              </div>
              <div class="col-md-8 ">
                <div class="field your-email form-group @include('errors.field-class', ['field' => 'subject'])">
                  <input type="text" id="subject"  name="subject" class="form-control" value="{{isset($contact) ? 'RE:'.$contact->subject : Input::get('subject')}}"  placeholder="{{trans('messages.subject')}}" required="true" />
                  @include('errors.field', ['field' => 'subject'])
                </div>
              </div>
            </div>
            <!--Message-->
            <div class="row" style="margin-bottom: 0px">
              <div class="col-md-1 ">
                <label for="">{{trans('messages.message')}}</label>
              </div>
              <div class="col-md-8 ">
                <div class="field message form-group @include('errors.field-class', ['field' => 'message'])">
                  <textarea type="text" id="mailmessage"  name="message" class="ckeditor"  placeholder="{{trans('messages.message')}}" required="true">{{Input::get('message')}}</textarea>
                  @include('errors.field', ['field' => 'message'])
                </div>
                <div style="text-align: right">
                  <button id="sendButton" type="submit" class="btn btn-primary" name="button">{{trans('messages.send')}}</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@stop
