@set('js', ['js/includes/userCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('user.list'))
@section('title', trans('user.list'))
@extends('pages.page')
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
  <div class="panel panel-default">
    <div class="panel-body">
      <table class="table table-striped" id="dtble_users">
        <thead>
          <tr>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('messages.email')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $row)
            <tr item="{{$row->toInnerJson()}}">
              <td>{{$row->code}}</td>
              <td style="text-transform:capitalize;">{{$row->name.' '.$row->last_name}}</td>
              <td>{{$row->email}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="userDelete($(this))" ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                  <li><a href="{{asset("admin/user/{$row->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="{{asset("admin/user/{$row->id}")}}/read"><i class="fa fa-eye" title="{{trans('messages.details')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
