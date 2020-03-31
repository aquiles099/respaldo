@set('js', ['dist/js/transportCtrl.js'])
@section('pageTitle', trans('transport.list'))
@section('title', trans('transport.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/transport/new')}}" class="btn btn-primary" data-toggle="tooltip" title="{{trans('transport.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.transport.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover text-center" id="dtble">
        <thead>
          <tr>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('messages.price')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transports as $transport)
            <tr item="{{$transport->toInnerJson()}}">
              <td><a class = "infoRd" href = "javascript:detailstransport({{$transport->id}},'true')">{{$transport->code}}</a></td>
              <td>{{ucwords($transport->spanish)}}</td>
              <td>{{$transport->price}}$</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="transportDelete($(this))" ><i class="fa fa-trash-o" title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
