@set('js', ['src/js/stateCtrl.js'])
@section('pageTitle', trans('state.list'))
@section('title', trans('state.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/state/new')}}" class="btn btn-primary" data-toggle="tooltip" title="{{trans('city.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.city.messages')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover table-responsive text-center" id="dtble">
        <thead>
          <tr>
            <th>{{trans('city.code')}}</th>
            <th>{{trans('city.name')}}</th>
            <th>{{trans('city.country')}}</th>
            <th>{{trans('city.description')}}</th>
            <th>{{trans('city.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($cities as $key => $value)
            <tr item="{{$value}}">
              <td><a class="infoRd" href="javascript:details({{$value->id}})">{{$value->code}}</a></td>
              <td>{{ucwords($value->name)}}</td>
              <td>{{ucwords($value->getCountry->name)}}</td>
              <td>{{ucwords($value->description)}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="icsCityDelete($(this))"><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
