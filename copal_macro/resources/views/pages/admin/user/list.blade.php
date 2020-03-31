@set('js', ['js/includes/userCtrl.js'])
@section('pageTitle', trans('user.list'))
@section('title', trans('user.list'))
@extends('pages.page')
@section('toolbar-custom-pre')
<li>
  <a href="{{asset('/')}}" id ="drdusr"><i class="fa fa-home"></i> {{trans('messages.home')}}</a>
</li>
<li>
  <a href="{{asset('/admin/configuration')}}" id ="drdusr"><i class="fa fa-cog"></i> {{strtoupper(trans('menu.adjustments'))}}</a>
</li>
@include('sections.toolbar')
@stop
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/user/new')}}" class="btn btn-primary" title="{{trans('company.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.user.messages')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover table-responsive text-center" id="dtble">
        <thead>
          <tr>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('messages.email')}}</th>
            <th>{{trans('user.created_at')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
            <tr item="{{$user->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:details({{$user->id}})">{{$user->code}}</a></td>
              <td>{{ucwords($user->name)}}</td>
              <td>{{$user->email}}</td>
              <td>{{$user->created_at->format('Y-m-d H:i:s')}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="userDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
