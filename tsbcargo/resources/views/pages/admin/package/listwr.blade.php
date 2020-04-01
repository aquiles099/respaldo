@set('js', ['js/includes/packageCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('package.listwr'))
@section('title', trans('package.listwr'))
@extends('pages.page')
@section('title-actions')
@stop
@section('pre-title')
@stop
@section('body')
  @include('pages.admin.package.messages')
  @include('sections.messages')
  <div class="panel  showpack" id="pnlin">
    <div class="panel-body" >
      <table class="table table-striped table-border table-hover text-center" id="dtble" >
        <thead>
          <tr>
            <th>{{trans('messages.tracking')}}</th>
            <th>{{trans('messages.codesystem')}}</th>
            <th>{{trans('messages.client')}}</th>
            <th>{{trans('messages.invoice')}}</th>
            <th>{{trans('package.registred')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $row)
            <tr item="{{$row->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:detailspackage({{$row->id}}, 'true')">{{$row->tracking}}</a></td>
              <td>WR-{{(isset($row->code) ? $row->code : $row->code)}}</td>
              <td>{{(isset($row->to_user) ? $row->getToUser['code']." ".$row->getToUser['name']." ".$row->getToUser['last_name'] : $row->getToUser['code']." ".$row->getToUser['name']." ".$row->getToUser['last_name'])}}</td>
              <td>@if($row->invoice == 0) <a href="javascript:upload({{$row->id}})"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: orange"></i></a>@else<i class="fa fa-check" aria-hidden="true" style="color: green"></i>@endif</td>
              <td>{{$row->created_at->format('d-M-Y')}}</td>
              <td>
                <ul class="table-actions">
                  <li><a href="{{asset("admin/package/{$row->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="{{asset("admin/package/{$row->id}")}}/print" target="_blank"><i class="fa fa-ticket" title="{{trans('messages.tickets')}}" ></i></a></li>
                  <li><a target="_blank" href="javascript:detailsreceipt({{$row->id}})" ><i class="fa fa-list" title="{{trans('messages.details')}}" ></i></a></li>
                  <li><a target="_blank" href="javascript:icsPrint({{$row->id}})" ><i class="fa fa-print" title="{{trans('print.print')}}" ></i></a></li>
                  <li><a href="{{asset("admin/billingid/{$row->id}")}}" target="_blank"><i class="fa fa-file-pdf-o" title="{{trans('invoice.acrobat')}}"></i></a></li>
                  <li><a onclick="packageDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
