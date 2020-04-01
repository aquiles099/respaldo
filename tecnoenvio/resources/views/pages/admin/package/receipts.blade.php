@section('pageTitle', trans('package.receipt'))
@set('js', ['js/includes/receiptCtrl.js'])
@include('sections.translate')
@section('title', trans('package.listreceipt'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
@stop
@section('body')
  @include('pages.admin.package.messages')
  @include('sections.messages')
<div class="panel panel-default" id="pnlin" >
  <div class="panel-body">
    <table class="table table-striped table-border table-hover" id="dtble_rep" >
      <thead>
        <tr style="text-align: center">
          <th>{{trans('messages.code')}}</th>
          <th>{{trans('messages.package')}}</th>
          <th>{{trans('package.subtotal')}}</th>
          <th>{{trans('package.total')}}</th>

          <th>{{trans('messages.actions')}}</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($receipt as $receipts)
          <tr style="text-align: center">
            <td><a class="infoRd" href="javascript:detailsreceipt({{$receipts->id}})">{{$receipts->code}}</a></td>
            <td><a class="infoRd" href="javascript:icsDetailsPackage({{$receipts->getPackage->id}}, false)">{{$receipts->getPackage->code}}</a></td>
            <td>{{$receipts->subtotal}}$</td>
            <td>{{$receipts->total}}$</td>

            <td>
              <ul class="table-actions"  >
                <li><a href="{{asset("admin/receipt/{$receipts->id}")}}/invoice" target="_blank"><i class="fa fa-file-pdf-o" title="{{trans('messages.edit')}}"></i></a>
              </ul>
            </td>
          </tr>
          @endforeach
      </tbody>
    </table>
  </div>
</div>
@stop
