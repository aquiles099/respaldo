@set('js', ['js/includes/operatorsCtrl.js'])
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
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover text-center" id="dtble_operator">
        <thead>
          <tr>
            <th>{{trans('operator.code')}}</th>
            <th>{{trans('messages.usuario')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('messages.email')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($operators as  $operator)
            <tr item="{{$operator->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:details({{$operator->id}})">{{$operator->code}}</a></td>
              <td>{{$operator->username}}</td>
              <td>{{ucwords($operator->name)}}</td>
              <td>{{$operator->email}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="operatorDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
