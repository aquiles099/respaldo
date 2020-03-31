@set('js', ['dist/js/cityCtrl.js'])
@section('pageTitle', trans('city.list'))
@section('title', trans('city.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/cities/new')}}" class="btn btn-primary" data-toggle="tooltip" title="{{trans('city.create')}}">
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
            <th>{{trans('state.state')}}</th>
            <th>{{trans('city.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($cities as $key => $value)
            <tr item="{{$value->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:details({{$value->id}})">{{$value->code}}</a></td>
              <td >{{ucwords($value->name)}}</td>
              <td >{{ucwords($value->getCountry->name)}}</td>
              @foreach($states as $key => $val)
                @if($val->id == $value->state)
                  <td >{{ucwords($val->name)}}</td>
                @endif
              @endforeach
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
