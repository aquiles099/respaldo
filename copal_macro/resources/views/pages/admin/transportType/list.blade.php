@set('js', ['dist/js/transportTypeCtrl.js'])
@section('pageTitle', trans('transportType.list'))
@section('title', trans('transportType.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/typeTransports/new')}}" class="btn btn-primary" data-toggle="tooltip" title="{{trans('transportType.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.transportType.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover table-responsive text-center" id="dtble">
        <thead>
          <tr>
            <th>{{trans('transportType.code')}}</th>
            <th>{{trans('transportType.name')}}</th>
            <th>{{trans('transportType.type')}}</th>
            <th>{{trans('transportType.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($transport_types as $key => $value)
            <tr item="{{$value->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:details({{$value->id}})">{{$value->code}}</a></td>
              <td>{{ucwords($value->name)}}</td>
              <td>{{ucwords($value->getTransport->spanish)}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="icstransportTypeDelete($(this))"><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
