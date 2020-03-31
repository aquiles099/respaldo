@set('js', ['js/includes/containerCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('container.list'))
@section('title', trans('container.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/containers/new')}}" onclick="loadButton(this)" class="btn btn-primary" data-toggle="tooltip" title="{{trans('container.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.container.messages')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
  <div class="panel-body">
    <table class="table table-striped table-hover table-responsive text-center" id="dtble_container">
      <thead>
        <tr>
          <th>{{trans('container.code')}}</th>
          <th>{{trans('container.name')}}</th>
          <th>{{trans('container.created_at')}}</th>
          <th>{{trans('container.actions')}}</th>
        </tr>
      </thead>
      <tbody class="">
        @if(isset($container))
          @foreach($container as $key => $value)
            <tr item="{{$value}}">
              <td><a class = "infoRd" id="{{$value->id}}" href="javascript:details({{$value->id}})">{{$value->code}}</a></td>
              <td>{{ucwords($value->name)}}</td>
              <td>{{$value->created_at->format('Y-m-d')}}</td>
              <td style="text-align:-webkit-center">
                <ul class="table-actions">
                  <li><a onclick="containerDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>
</div>
@stop
