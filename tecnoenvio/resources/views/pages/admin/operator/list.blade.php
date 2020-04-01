@set('js', ['js/includes/operatorsCtrl.js'])
@set('js', ['js/includes/userCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('operator.list'))
@section('title', trans('operator.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/operator/new')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('operator.creating')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.operator.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      <table class="table table-striped table-hover" id="dtble_operator">
        <thead>
          <tr>
           <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.usuario')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('messages.email')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($operators as $row)
            <tr item="{{$row->toInnerJson()}}">
              <td>{{$row->code}}</td>
              <td>{{$row->username}}</td>
              <td>{{$row->name}}</td>
              <td>{{$row->email}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="operatorDelete($(this))" ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                  <li><a href="{{asset("/admin/operator/{$row->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="{{asset("/admin/operator/{$row->id}")}}/read"><i class="fa fa-eye" title="{{trans('messages.details')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
