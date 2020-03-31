@set('js', ['js/includes/courierCtrl.js'])
@section('pageTitle', trans('courier.couriers'))
@section('title', trans('courier.couriers'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/courier/new')}}" class="btn btn-primary" title="{{trans('courier.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.courier.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover text-center" id="dtble">
        <thead>
          <tr>
            <th style="width:30%">{{trans('messages.code')}}</th>
            <th style="width:50%">{{trans('messages.name')}}</th>
            <th style="width:15%">{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($couriers as $courier)
            <tr item="{{$courier->toInnerJson()}}">
              <td>{{$courier->code}}</td>
              <td><a class = "infoRd" href = "javascript:details({{$courier->id}})">{{ucwords($courier->name)}}</a></td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="courierDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
