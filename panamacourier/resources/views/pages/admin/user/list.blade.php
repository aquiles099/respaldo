@set('js', ['js/includes/userCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('user.list'))
@section('title', trans('user.list'))
@extends('pages.page')
@section('toolbar-custom-pre')
<!---->
<li id="step1">
  <a href="{{asset('/')}}" id ="drdusr">
    <i class="fa fa-home"></i>
    {{trans('messages.home')}}
  </a>
</li>
<!---->
<li id="step2">
  <a href="{{asset('/admin/configuration')}}" id ="drdusr">
    <i class="fa fa-cog"></i>
    {{strtoupper(trans('menu.adjustments'))}}
  </a>
</li>
<!---->
<li id="">
  <a href="{{substr (asset('http://www.internationalcargosystem.com/payment/'.asset('/')), 0, strlen(asset('http://www.internationalcargosystem.com/payment/'.asset('/'))) - 1)}}" target="_blank" id ="drdusr">
    <i class="fa fa-credit-card"></i>
    {{strtoupper(trans('messages.pay'))}}
  </a>
</li>
<!---->
<li id="step3" class="dropdown" >
  <a class="dropdown-toggle" data-toggle="dropdown" href="#" id ="drdusr"><i class="fa fa-support"></i>
    {{strtoupper(trans('menu.help'))}}
    <i class="fa fa-caret-down"></i>
  </a>
  <ul class="dropdown-menu dropdown-user" style="right: -47px;">
    <li>
      <a href="{{asset('/admin/incidence/new')}}">
         <i class="fa fa-bullhorn"></i> {{trans('menu.incidence')}}
      </a>
    </li>
    <li style="cursor: pointer;" onclick="javascript:acercaDe()">
        <div class="" style="margin-left:20px;">
          <i class="fa fa-info-circle"></i>{{trans('menu.about')}}
        </div>
    </li>
  </ul>
</li>
<!---->
  @include('sections.toolbar')
<!---->
<li style="cursor: pointer;"id="tuto">
  <i class="fa fa-info-circle"></i> Tutorial
</li>
@stop
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/user/new')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('company.create')}}">
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
              <td>
                <a class="infoRd" href="javascript:details({{$user->id}})">
                  {{isset($user->code) ? $user->code : trans('messages.unknown')}}
                </a>
              </td>
              <td>{{isset($user->name) ? ucwords($user->name) : trans('messages.unknown')}}</td>
              <td>{{isset($user->email) ? $user->email : trans('messages.unknown')}}</td>
              <td>{{isset($user->created_at) ? $user->created_at : trans('messages.unknown')}}</td>
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
