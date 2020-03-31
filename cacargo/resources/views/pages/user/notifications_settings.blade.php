@set('only')
<?php
use App\Helpers\HUserType;
  if(Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
?>
@set('js', ['js/includes/resellerCtrl.js'])
@section('pageTitle', trans('messages.managenotications'))
@section('icon-title')
  <i aria-hidden="true" class="fa fa-bell fa-fw"></i>
@stop
@section('title', trans('messages.managenotications'))
@extends('pages.page')
@include('sections.translate')
@section('title-actions')
@stop
@section('body')
  @include('sections.messages')
  <div class="text-muted">
    <i aria-hidden="true" class="fa fa-eye"></i>
    {{strtoupper(trans('messages.notificationsinfo'))}}
  </div>
  <div class="panel panel-default">
    <div class="panel-heading text-center">
      <span class="text-muted">
        <i aria-hidden="true" class="fa fa-bell fa-fw"></i>
        {{trans('messages.managenotications')}}
      </span>
    </div>
    <div class="panel-body">
      <form class="" onsubmit="createLoad()" action="{{asset('/account/notifications/settings')}}" method="post">
        <fieldset role="form">
          <table class="table table-striped table-hover table-responsive" id="dtble">
            <thead>
              <tr>
                <th style="text-align:center">{{trans('messages.number')}}</th>
                <th style="text-align:center">{{trans('messages.description')}}</th>
                <th style="text-align:center">{{trans('messages.active')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($events as $key => $event)
                @if(($event->active == '1'))
                  <tr>
                    <td>{{$key + 1}}</td>
                    <td>
                      @if($event->id != 2)
                        {{strtoupper($event->name)}}
                        @if($event->id == 1) <span><i class="fa fa-building-o" aria-hidden="true"></i></span> @endif
                        @if($event->id == 3) <span><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span> @endif
                        @if($event->id == 4) <span><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span> @endif
                        @if($event->id == 5) <span><i class="fa fa-check" aria-hidden="true"></i></span> @endif
                        @if($event->id == 6) <span><i class="fa fa-user" aria-hidden="true"></i></span> @endif
                      @else
                        {{strtoupper($event->name)}}
                        @if($event->id == 2) <span><i class="fa fa-cubes" aria-hidden="true"></i></span> @endif
                      @endif
                    </td>
                    <td>
                      <input type="checkbox" name="icsnu{{$event->id}}" value="{{$event->id}}" @foreach($user_notifications as $key => $value)@if($value->event == $event->id) checked @endif @endforeach>
                    </td>
                  </tr>
                @endif
              @endforeach
            </tbody>
          </table>
          <hr>
          <div class="text-muted" id="divButton">
              <button type="submit" class="pull-right btn btn-primary" id="submitBnt">{{trans('messages.send')}}</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
@stop
