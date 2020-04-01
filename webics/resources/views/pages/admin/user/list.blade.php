@set('js', ['src/js/user.js'])
@section('title-page', trans('user.users'))
@section('admin-page-title', trans('user.users'))
@extends('layouts.main.master')
@section('admin-actions')
<a href="{{asset('admin/users/new')}}" class="btn btn-primary" title="{{trans('user.new')}}">
  <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
  {{trans('user.new')}}
</a>
@stop
@section('admin-body')
@include('sections.messages')
  @if ($users->count() == 0)
    @include('sections.no-rows')
  @else
    @include('pages.admin.user.messages')
  <table class="table table-striped table-hover table-responsive" name="icstable" id="icstable">
    <thead>
      <tr>
        <th style="text-align: center">{{trans('user.code')}}</th>
        <th style="text-align: center">{{trans('user.name')}}</th>
        <th style="text-align: center">{{trans('user.email')}}</th>
        <th style="text-align: center">{{trans('user.type')}}</th>
        <th style="text-align: center">{{trans('user.created_at')}}</th>
        <th style="text-align: center">{{trans('messages.actions')}}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $key => $value)
        <tr item="{{$value}}">
          <td>
            <a class="icslinkdetails" onclick="icsShowUser({{$value->id}})">{{$value->code}}</a>
          </td>
          <td>{{$value->name}}</td>
          <td>{{$value->email}}</td>
          <td>{{$value->getType->name}} @if ($value->user_type == App\Helpers\HUserType::MASTER) <i class="fa fa-rocket" aria-hidden="true"></i> @endif</td>
          <td>{{$value->created_at}} </td>
          <td>
            <ul class="table-actions">
              <li><a onclick="userDelete($(this))" ><i class="fa fa-times"  title="{{trans('messages.delete')}}"></i></a></li>
              <li><a href="{{asset("admin/users/{$value->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
              @if(Session::get('key-sesion')['type'] == App\Helpers\HUserType::MASTER)
              <li><a href="{{asset("admin/users/{$value->id}")}}/notifiable"><i class="fa fa-bell fa-fw" title="{{trans('messages.edit')}}"></i></a></li>
              <li><a href="{{asset("admin/users/{$value->id}")}}/access"><i class="fa fa-lock fa-fw" title="{{trans('messages.access')}}"></i></a></li>
              <li><a onclick="modalTable({{$value->id}},'solicitude', false)"><i class="fa fa-bullhorn fa-fw" title="{{trans('messages.solicitude')}}"></i></a></li>
              @endif
            </ul>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @endif
@stop
