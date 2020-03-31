@set('js', ['js/includes/numberpartsCtrl.js'])
@section('pageTitle', trans('numberparts.list'))
@section('title', trans('numberparts.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/numberparts/new')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" data-toggle="tooltip" title="{{trans('numberparts.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.numberparts.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
  <div class="panel-body">
    <table class="table table-striped table-hover table-responsive text-center" id="dtble">
      <thead>
        <tr>
          <th>{{trans('numberparts.code')}}</th>
          <th>{{trans('numberparts.description')}}</th>
          <th>{{trans('numberparts.model')}}</th>
          <th>{{trans('numberparts.customer')}}</th>
          <th>{{trans('numberparts.manufacturer')}}</th>
          <th>{{trans('numberparts.pieces')}}</th>
          <th>{{trans('numberparts.actions')}}</th>
        </tr>
      </thead>
      <tbody class="">
        @if(isset($numberparts))
          @foreach($numberparts as $key => $value)
            <tr item="{{$value}}">
              <td><a class="infoRd" href="javascript:details({{$value->id}})">{{$value->code}}</a></td>
              <td>{{ucwords($value->description)}}</td>
              <td>{{ucwords($value->model)}}</td>
              <td>{{ucwords($value->customer)}}</td>
              <td>{{ucwords($value->manufacturer)}}</td>
              <td>{{ucwords($value->pieces)}}</td>
              <td style="text-align:-webkit-center">
                <ul class="table-actions">
                  <!--<li><a href="{{asset("/admin/numberparts/{$value->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="{{asset("/admin/numberparts/{$value->id}")}}/read"><i class="fa fa-eye" title="{{trans('messages.details')}}"></i></a></li>-->
                  <li><a onclick="numberpartDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
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
