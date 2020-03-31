@set('js', ['js/includes/roleCtrl.js'])
@section('pageTitle', trans('role.list'))
@section('title', trans('role.list'))
@extends('pages.page')
@section('title-actions')
<a href="{{asset('admin/security/role/new')}}" class="btn btn-primary" title="{{trans('role.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.security.role.messages')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover text-center" id="dtble">
        <thead>
          <tr>
            <th>{{trans('role.code')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('role.created_at')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($roles as $role)
            <tr item="{{$role->toInnerJson()}}">
              <td>{{$role->code}}</td>
              <td>{{$role->name}}</td>
              <td>{{$role->created_at->format('Y-m-d')}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="roleDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                  <li><a href="{{asset("admin/security/role/{$role->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="{{asset("admin/security/role/{$role->id}")}}/read"><i class="fa fa-eye"    title="{{trans('messages.details')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
