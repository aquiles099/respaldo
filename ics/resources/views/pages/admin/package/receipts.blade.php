@section('pageTitle', trans('package.receipt'))
@include('sections.translate')
@set('js', ['src/js/invoiceCtrl.js'])
@section('title', trans('package.listreceipt'))
@extends('pages.page')
@section('title-actions')
  <div class="dropdown">
    <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown">
      <span class="text-muted">
        <i class="fa fa-eye" aria-hidden="true"></i>
        <span class="" id="ics_option_load"></span>
        {{trans('invoice.showReceipt')}} |
        <span id="ics_selected_option"></span>
        <span class="caret"></span>
      </span>
    </button>
    <ul class="dropdown-menu" id="">
      {{csrf_field()}}
      <li class="dropdown-header">{{trans('messages.show')}}</li>
      <li class="divider"></li>
      <li><a href="javascript:searchInvoice(1)">{{trans('invoice.all')}} <span class="pull-right"><i class="fa fa-list" aria-hidden="true"></i></span></a></li>
      <li><a href="javascript:searchInvoice(2)">{{trans('invoice.paid')}}  <span class="pull-right"><i class="fa fa-check" aria-hidden="true"></i></span></a></li>
      <li><a href="javascript:searchInvoice(3)">{{trans('invoice.debt')}} <span class="pull-right"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span></a></li>
    </ul>
  </div>
@stop
@section('body')
@include('pages.admin.package.messages')
@include('sections.messages')
<div class="panel panel-default" id = "pnlin">
  <div class="panel-body" id="ics_pnlreceipt"></div>
  <input type="hidden" name="ics_htype" value="" id="ics_htype">
</div>
@stop
