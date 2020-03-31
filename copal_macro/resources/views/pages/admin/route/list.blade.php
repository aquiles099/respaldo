@set('js', ['dist/js/routeCtrl.js'])
@section('pageTitle', trans('route.list'))
@section('title', trans('route.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/routes/new')}}" class="btn btn-primary" data-toggle="tooltip" title="{{trans('route.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.route.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover table-responsive text-center" id="dtble">
        <thead>
          <tr>
            <th>{{trans('route.code')}}</th>
            <th>{{trans('route.name')}}</th>
            <th>{{trans('route.type')}}</th>
            <th>{{trans('route.originCountry')}}</th>
            <th>{{trans('route.originCity')}}</th>
            <th>{{trans('route.destinyCountry')}}</th>
            <th>{{trans('route.destinyCity')}}</th>
            <th>{{trans('route.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($routes as $key => $value)
            <tr item="{{$value->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:details({{$value->id}})">{{$value->code}}</a></td>
              <td>{{ucwords($value->name)}}</td>
              <td>{{ucwords($value->getTransport->spanish)}}</td>
              <td>{{ucwords($value->getOriginCountry->name)}}</td>
              <td>{{ucwords($value->getOriginCity->name)}}</td>
              <td>{{ucwords($value->getDestinyCountry->name)}}</td>
              <td>{{ucwords($value->getDestinyCity->name)}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="routeDelete($(this))"><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
