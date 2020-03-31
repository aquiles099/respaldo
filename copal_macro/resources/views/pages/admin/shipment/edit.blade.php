@set('js', ['src/js/shipmentCtrl.js'])
@section('pageTitle', trans('shipment.edit'))
@section('title', trans((!$readonly) ? 'shipment.edit' : 'shipment.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$shipment->toInnerJson()}}">
    <a href="{{asset('admin/shipments')}}" onclick="javascript:loadButton(this)" class="btn btn-default" title="{{trans('shipment.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="icsShipmentDelete($(this), false)" class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.shipment.messages')
  @include('sections.messages')
    <script type="text/javascript">
    $(document).ready(function(){
      icsSetTypeShipment({{$shipment->transport}}, true, {{$shipment->id}});
    });
  </script>
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.shipment.form', [
        'path' => "/admin/shipments/{$shipment->id}",'edit' => "true"
        ])
    </div>
  </div>
@stop
