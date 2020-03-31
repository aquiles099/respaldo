@set('js', ['js/includes/transportersCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('transporters.transporters'))
@section('title', trans('transporters.transporters'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/transporters/new')}}" onclick="loadButton(this)" class="btn btn-primary" data-toggle="tooltip" title="{{trans('transporters.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.transporters.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover text-center" id="dtble">
        <thead>
          <tr>
            <th style="width:20%;">{{trans('messages.code')}}</th>
            <th style="width:20%;">{{trans('messages.name')}}</th>
            <th style="width:20%;">{{trans('transporters.identification')}}</th>
            <th style="width:20%;">{{trans('messages.email')}}</th>
            <th style="width:25%;">{{trans('messages.actions')}}</th>
          </tr>
        </thead>
       <tbody>
          @foreach ($transporters as $value)
            <tr item="{{$value}}">
              <td><a class="infoRd" href="javascript:details({{$value->id}})">{{$value->code}}</a></td>
              <td>{{ucwords($value->name)}}</a></td>
              <td>{{$value->identification}}</td>
              <td>{{$value->email}}</td>
              <td>
                <ul class="table-actions" style="margin-left: 16%;">
                <li><a onclick="transportersDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
