@set('js', ['js/includes/courierCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('courier.couriers'))
@section('title', trans('courier.couriers'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/courier/new')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('courier.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.courier.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover" id="dtble_carrier">
        <thead>
          <tr>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($couriers as $row)
            <tr item="{{$row->toInnerJson()}}">
              <td><a class = "infoRd" href = "javascript:details({{$row->id}})">{{$row->code}}</a></td>
              <td style="text-transform:capitalize;">{{$row->name}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="courierDelete($(this))" ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
