@set('js', ['src/js/user.js'])
@section('title-page', trans('user.notifiable'))
@section('admin-page-title', trans('user.notifiable'))
@extends('layouts.main.master')
@section('admin-actions')
@stop
@section('admin-body')
  <form class="" action="{{asset("admin/users/{$user->id}")}}/notifiable" method="post">
    <fieldset class="form">
      <!--Notificar Solicitudes-->
        <div class="col-md-12">
          @include('sections.messages')
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-bullhorn fa-fw" aria-hidden="true"></i>
              {{trans('user.notifiablefor')}}
                <strong>
                  <a href="{{asset("admin/users/{$user->id}")}}" class="icslinkdetails">{{strtoupper($user->code)}} {{strtoupper($user->name)}}</a>
                </strong>
            </div>
            <div class="panel-body">
              @foreach($status as $key => $value)
                <label for="status_solicitude_{{$value->id}}">
                  <input  type="checkbox" name="notifiable_{{$value->id}}" id="status_solicitude_{{$value->id}}" value="{{$value->id}}" @foreach($notifiable as $key => $notify) @if ($notify->status == $value->id) checked @endif @endforeach >
                  {{$value->name}}
                </label>
              @endforeach
            </div>
          </div>
        </div>
    </fieldset>
    <div class="col-md-12">
      <!-- Action -->
      <button id="sendButton" type="submit" class="btn btn-primary pull-right" name="button">{{trans('messages.send')}}</button>
    </div>
  </form>
@stop
