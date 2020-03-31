@set('js', ['src/js/vesselCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('vessel.list'))
@section('title', trans('vessel.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/vessels/new')}}" onclick="loadButton(this)" class="btn btn-primary" data-toggle="tooltip" title="{{trans('vessel.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.vessel.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover table-responsive text-center" id="dtble_vessel">
        <thead>
          <tr>
            <th>{{trans('vessel.code')}}</th>
            <th>{{trans('vessel.name')}}</th>
            <th>{{trans('vessel.flag')}}</th>
            <th>{{trans('vessel.country')}}</th>
            <th>{{trans('vessel.city')}}</th>
            <th>{{trans('vessel.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($vessels as $key => $value)
            <tr item="{{$value->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:details({{$value->id}})">{{$value->code}}</a></td>
              <td>{{ucwords($value->name)}}</td>
              <td>{{ucwords($value->flag)}}</td>
              <td>{{ucwords($value->getCountry->name)}}</td>
              <td>{{ucwords($value->getCity->name)}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="icsVesselDelete($(this))"><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
