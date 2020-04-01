@set('js', ['js/includes/packageCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('package.packages'))
@section('title', trans('package.packages'))
@extends('pages.page')
@section('title-actions')
@stop
@section('pre-title')
@stop
@section('body')
  @include('pages.admin.package.messages')
  @include('sections.messages')
  <div class="panel panel-default  showpack" id="pnlin">
    <div class="panel-body" >
      <table class="table table-striped table-border table-hover" id="dtble_pack" >
        <thead>
          <tr>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.tracking')}}</th>
            <th>{{trans('messages.client')}}</th>
            <th>{{trans('messages.invoice')}}</th>
            <th>{{trans('package.registred')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $row)
            <tr item="{{$row->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:detailspackage({{$row->id}}, 'true')">{{$row->code}}</a></td>
              <td>{{$row->tracking}}</td>
              <td>{{(isset($row->to_client) ? $row->getToClient['code']." ".$row->getToClient['name'] : $row->getToUser['code']." ".$row->getToUser['name'])}}</td>
              <td>@if($row->invoice == 0)
                <a href="javascript:upload({{$row->id}})">
                  <i class="fa fa-times" aria-hidden="true"></i>
                </a>
                @else
                <i class="fa fa-check" aria-hidden="true"></i>
                @endif</td>
              <td>{{$row->created_at}}</td>
              <td>
                <ul class="table-actions">

                  <li><a onclick="packageDelete($(this))" ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                  @if(isset($row->from_courier))
                    <li><a href="{{asset("admin/packagecurriers/{$row->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  @else
                    <li><a href="{{asset("admin/package/{$row->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  @endif
                  <li><a href="{{asset("admin/package/{$row->id}")}}/print" target="_blank"><i class="fa fa-ticket"    title="{{trans('messages.tickets')}}" ></i></a></li>
                  <li><a target="_blank" href="javascript:detailsreceipt({{$row->id}})" ><i class="fa fa-list"    title="{{trans('messages.details')}}" ></i></a></li>
                  <li><a target="_blank" href="{{asset("admin/package/{$row->id}")}}/invoice" ><i class="fa fa-file-pdf-o"    title="{{trans('messages.invoice')}}" ></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
