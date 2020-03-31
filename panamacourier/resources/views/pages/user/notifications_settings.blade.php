@set('only')
<?php
use App\Helpers\HUserType;
  if(Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
?>
@set('js', ['js/includes/resellerCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('messages.managenotications'))
@section('icon-title')
  <i aria-hidden="true" class="fa fa-bell fa-fw"></i>
@stop
@section('title', trans('messages.managenotications'))
@extends('pages.page')
@section('title-actions')
@stop
@section('body')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-heading text-center">
      <span class="text-muted">
        <i aria-hidden="true" class="fa fa-bell fa-fw"></i>
        {{trans('messages.managenotications')}}
      </span>
    </div>
    <div class="panel-body">
      <form class="" action="{{asset('/account/notifications/settings')}}" method="post">
        <fieldset role="form">
          <table class="table table-striped table-hover table-responsive" id="dtble_notifications">
            <thead>
              <tr>
                <th style="text-align:center">{{trans('messages.number')}}</th>
                <th style="text-align:center">{{trans('messages.description')}}</th>
                <th style="text-align:center">{{trans('messages.active')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($events as $key => $event)
                  <tr>
                    <td style="text-align:center">{{$key + 1}}</td>
                    <td style="text-align:center">
                        {{strtoupper($event->name)}}
                        @if($event->id == 1) <span><i  aria-hidden="true"></i></span> @endif
                        @if($event->id == 3) <span><i  aria-hidden="true"></i></span> @endif
                        @if($event->id == 5) <span><i  aria-hidden="true"></i></span> @endif
                        @if($event->id == 6) <span><i  aria-hidden="true"></i></span> @endif
                        @if($event->id == 2) <span><i  aria-hidden="true"></i></span> @endif
                    </td>
                    <td style="text-align:center">
                      <input type="checkbox" name="icsnu{{$event->id}}" value="{{$event->id}}" @foreach($user_notifications as $key => $value)@if($value->event == $event->id) checked @endif @endforeach>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
          <hr>
          <div class="text-muted">
            <i aria-hidden="true" class="fa fa-eye"></i>
            {{strtoupper(trans('messages.notificationsinfo'))}}
              <button type="submit" class="pull-right btn btn-primary" id="submitBnt">{{trans('messages.send')}}</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
@stop
