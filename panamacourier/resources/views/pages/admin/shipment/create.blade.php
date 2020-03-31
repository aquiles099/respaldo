@set('js', ['src/js/shipmentCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('shipment.shipmentCreate'))
@section('title', trans('shipment.shipmentCreate'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a  href="{{asset('admin/l/shipments')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" data-toggle="tooltip" title="{{trans('shipment.List')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('shipment.List')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.shipment.messages')
  @include('sections.messages')
  <script type="text/javascript">
    $(document).ready(function(){
      icsSetTypeShipment(1, false, 0);
    });
  </script>
  <div class="panel panel-default" >
    <div class="panel-body">
      <!--form-->
      @include('pages.admin.shipment.form', ['path' => '/admin/shipments/new'])
    </div>
  </div>
@stop
@section('onready')
  initSelect2();
@stop
