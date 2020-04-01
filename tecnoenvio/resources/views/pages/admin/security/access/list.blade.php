@set('js', ['js/includes/accessCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('access.list'))
@section('title', trans('access.list'))
@extends('pages.page')
@section('title-actions')
<a href="{{asset('admin/security/access/new')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('access.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.security.access.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      <table class="table table-striped table-hover" id="dtble_permission">
        <thead>
          <tr>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($accesss as $row)
            <tr item="{{$row->toInnerJson()}}">
              <td>{{$row->code}}</td>
              <td>{{$row->name}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="accessDelete($(this))" ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                  <li><a href="{{asset("admin/security/access/{$row->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="{{asset("admin/security/access/{$row->id}")}}/read"><i class="fa fa-eye" title="{{trans('messages.details')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
