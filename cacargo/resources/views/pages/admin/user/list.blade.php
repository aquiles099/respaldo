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
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped" id="dtble">
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
              <td><a class="infoRd" href="javascript:details({{$row->id}})">{{$row->code}}</a></td>
              <td style="text-transform:capitalize;"><center>{{$row->name.' '.$row->last_name}}</center></td>
              <td><center>{{$row->email}}</center></td>
              <td>
                <ul class="table-actions">
                  <center>
                    <li  onclick="userDelete($(this))"><a ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                  </center>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
