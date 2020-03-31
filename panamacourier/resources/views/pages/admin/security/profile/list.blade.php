@set('js', ['js/includes/profileCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('profile.list'))
@section('title', trans('profile.list'))
@extends('pages.page')
@section('title-actions')
<a href="{{asset('admin/security/profile/new')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" title="{{trans('profile.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.security.profile.messages')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover text-center" id="dtble">
        <thead>
          <tr>
            <th>{{trans('profile.code')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('profile.created_at')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($profiles as $profile)
            <tr item="{{$profile->toInnerJson()}}">
              <td>{{$profile->code}}</td>
              <td>{{ucwords($profile->name)}}</td>
              <td>{{$profile->created_at->format('Y-m-d')}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="profileDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                  <li><a href="{{asset("admin/security/profile/{$profile->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="{{asset("admin/security/profile/{$profile->id}")}}/read"><i class="fa fa-eye"    title="{{trans('messages.details')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
