@set('js', ['src/js/user.js'])
@section('title-page', trans('user.accees'))
@section('admin-page-title', trans('user.access'))
@extends('layouts.main.master')
@section('admin-actions')
@stop
@section('admin-body')
  <form class="" action="{{asset("admin/users/{$user->id}")}}/access" method="post">
    <fieldset class="form">
      <!--Accessos-->
        <div class="col-md-12">
          @include('sections.messages')
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-lock fa-fw"></i>
              <span>
                {{trans('user.foraccess')}}
                <strong>{{$user->code}} {{strtoupper($user->name)}}</strong>
              </span>
            </div>
            <div class="panel-body">
              @foreach ($items as $key => $item)
                <label for="{{$item->id}}">
                  <input id="{{$item->id}}" type="checkbox" name="{{$item->id}}" value="{{$item->id}}" @foreach ($accesses as $key => $value) @if ($value->item == $item->id) checked @endif @endforeach>
                  {{$item->description}}
                </label>
              @endforeach
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <!-- Action -->
          <button id="sendButton" type="submit" class="btn btn-primary pull-right" name="button">{{trans('messages.send')}}</button>
        </div>
    </fieldset>
  </form>
@stop
