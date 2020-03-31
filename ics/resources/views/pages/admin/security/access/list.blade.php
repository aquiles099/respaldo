@set('js', ['js/includes/accessCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('access.list'))
@section('title', trans('access.list'))
@extends('pages.page')
@section('title-actions')
<a href="{{asset('admin/security/access/new')}}"  onclick="javascript:loadButton(this)" class="btn btn-primary" title="{{trans('access.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.security.access.messages')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover text-center" id="dtble_permission">
        <thead>
          <tr>
            <th>{{trans('access.code')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('access.created_at')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($accesss as $access)
            <tr item="{{$access->toInnerJson()}}">
              <td>{{$access->code}}</td>
              <td>{{ucwords($access->name)}}</td>
              <td>{{$access->created_at->format('Y-m-d')}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="accessDelete($(this))"><i class="fa fa-trash-o" title="{{trans('messages.delete')}}"></i></a></li>
                  <li><a href="{{asset("admin/security/access/{$access->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="{{asset("admin/security/access/{$access->id}")}}/read"><i class="fa fa-eye" title="{{trans('messages.details')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
