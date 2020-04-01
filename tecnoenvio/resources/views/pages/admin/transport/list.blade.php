@set('js', ['js/includes/transportCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('transport.list'))
@section('title', trans('transport.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/service/new')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('transport.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.transport.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover" id="dtble_route">
        <thead>
          <tr>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('messages.price')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transports as $row)
            <tr item="{{$row->toInnerJson()}}">
              <td><a class = "infoRd" href = "javascript:details({{$row->id}})">{{$row->code}}</a></td>
              <td style="text-transform:capitalize;">{{$row->spanish}}</td>
              <td>{{$row->price}}$</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="transportDelete($(this))" ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
