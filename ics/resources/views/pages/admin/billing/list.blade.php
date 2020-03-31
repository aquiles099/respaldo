@set('js', ['js/includes/billingCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('billing.list'))
@section('title', trans('billing.list'))
@extends('pages.page')
<?php use App\Models\Admin\Receipt;
$lang = App::getLocale(); ?>
@section('title-actions')
  @if(isset($typeReport))
    <div class="dropdown">
      <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown">
        <span class="text-muted">
          <i class="fa fa-eye" aria-hidden="true"></i>
          <span class="" id="ics_option_load"></span>
          {{trans('billing.exportAs')}}
          <span id="ics_selected_option"></span>
          <span class="caret"></span>
        </span>
      </button>
      <ul class="dropdown-menu" id="">
        <li class="dropdown-header">{{trans('billing.export')}}</li>
        <li class="divider"></li>
        <li><a style="cursor: pointer" onclick="javascript:exportFile(1)">{{trans('billing.printer')}} <span class="pull-right"><i class="fa fa-print" aria-hidden="true"></i></span></a></li>
        <li><a style="cursor: pointer" onclick="javascript:exportFile(2)">{{trans('billing.pdf')}}  <span class="pull-right"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span></a></li>
        <li><a style="cursor: pointer" onclick="javascript:exportFile(3)">{{trans('billing.xls')}} <span class="pull-right"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span></a></li>
      </ul>
    </div>
  @endif
@stop
@section('body')
@include('sections.messages')
<div class="panel panel-default showpack" id = "pnlin">
    <div class="panel-body" >
      @include('pages.admin.billing.form')
        <div class="table-responsive">
          <?php
          $tag='';
            if (isset($typeReport)) {
              if($typeReport == 1){
                $tag = 'dtble_billing_invoice';
              }
              if($typeReport == 2){
                $tag = 'dtble_billing_invoice_pay';
              }
              if($typeReport == 3){
                $tag = 'dtble_billing_debt';
              }
              if($typeReport == 4){
                $tag = 'dtble_billing_received';
              }
              if($typeReport == 5){
                $tag = 'dtble_billing_in_transit';
              }
              if($typeReport == 6){
                $tag = 'dtble_billing_in_route';
              }
            }

          ?>
          <table class="table table-striped table-hover " id="{{$tag}}">
            @if(isset($typeReport) && ($typeReport == 1 || $typeReport == 2 || $typeReport == 3))
            <thead>
              <th style="width:10%;text-align: center;">{{trans('package.receipt')}}</th>
              <th style="width:12%;text-align: center;">{{trans('package.type')}}</th>
              <th style="width:15%;text-align: center;">{{trans('package.subtotal')}}</th>
              <th style="width:10%;text-align: center;">{{trans('package.total')}}</th>
              <th style="width:10%;text-align: center;">{{trans('package.debt')}}</th>
              <th style="width:15%;text-align: center;">{{trans('package.paidOut')}}</th>
              <th style="width:15%;text-align: center;">{{trans('package.statusOfPaid')}}</th>
            </thead>
            <tbody>
              @foreach($data as $value)
                @if(isset($typeReport) &&($typeReport == 1))
                  <!--Todas las facturas-->
                  <tr style="text-align: center">
                    <td>{{$value->code}}</td>
                    <td>@if($value->getPackage != null)
                            <a class="infoRd" href="javascript:detailspackage({{$value->id-1}}, 'true')">{{$value->getPackage->code}}</a>
                        @else
                            <a class="infoRd" href="javascript:detailspickup({{$value->id}}, 'true')">{{$value->getPickup->code}}</a>
                        @endif
                    </td>
                    <td>{{$value->subtotal}}$</td>
                    <td>{{$value->total}}$</td>
                    <!--Deuda-->
                    <td>
                      @if(isset($value->getInvoice->status) && $value->getInvoice->status == 0) {{--si la factura no esta pagada--}}
                        {{$value->getInvoice->value}}$ {{--valor de la factura, disminuye si amortiza--}}
                        @elseif(isset($value->getInvoice->status) && $value->getInvoice->status == 1) {{--si la factura esta pagada--}}
                          0$  {{--Se muestra '0' si no hay deuda--}}
                          @else
                            {{$value->total}}$
                      @endif
                    </td>
                    <!--Pagado-->
                    <td>
                      @if(isset($value->getInvoice->status) && $value->getInvoice->status == 0)
                        {{ $value->total - $value->getInvoice->value}}$
                        @elseif(isset($value->getInvoice->status) && $value->getInvoice->status == 1) {{--si la factura esta pagada--}}
                        {{trans('billing.yes')}}
                        @else
                        {{trans('invoice.noDefined')}}
                      @endif
                    </td>
                    <!---->
                    <td>
                      @if(isset($value->getInvoice->status) && $value->getInvoice->status == 0)
                        {{trans('invoice.incomplete')}}
                        @elseif(isset($value->getInvoice->status) && $value->getInvoice->status == 1)
                          {{trans('billing.complete')}}
                          @else
                        {{trans('invoice.noDefined')}}
                      @endif
                    </td>
                  </tr>
                @endif
                @if(isset($typeReport) &&($typeReport == 2))
                  <!--Facturas Pagadas-->
                  @if(isset($value->getInvoice->status) && $value->getInvoice->status == 1)
                  <tr style="text-align: center">
                    <td>{{$value->code}}</td>
                    <td>@if($value->getPackage->tracking != null) {{$value->getPackage->code}} @else {{$value->getPickup->code}} @endif</td>
                    <td>{{$value->subtotal}}$</td>
                    <td>{{$value->total}}$</td>
                    <!--Deuda-->
                    <td>
                      @if(isset($value->getInvoice->status) && $value->getInvoice->status == 0) {{--si la factura no esta pagada--}}
                        {{$value->getInvoice->value}}$ {{--valor de la factura, disminuye si amortiza--}}
                        @elseif(isset($value->getInvoice->status) && $value->getInvoice->status == 1) {{--si la factura esta pagada--}}
                          0$  {{--Se muestra '0' si no hay deuda--}}
                          @else
                            {{$value->total}}$
                      @endif
                    </td>
                    <!--Pagado-->
                    <td>
                      @if(isset($value->getInvoice->status) && $value->getInvoice->status == 0)
                        {{ $value->total - $value->getInvoice->value}}$
                        @elseif(isset($value->getInvoice->status) && $value->getInvoice->status == 1) {{--si la factura esta pagada--}}
                        {{trans('billing.yes')}}
                        @else
                        {{trans('invoice.noDefined')}}
                      @endif
                    </td>
                    <!---->
                    <td>
                      @if(isset($value->getInvoice->status) && $value->getInvoice->status == 0)
                        {{trans('invoice.incomplete')}}
                        @elseif(isset($value->getInvoice->status) && $value->getInvoice->status == 1)
                          {{trans('billing.complete')}}
                          @else
                        {{trans('invoice.noDefined')}}
                      @endif
                    </td>
                  </tr>
                  @endif
                @endif
                @if(isset($typeReport) &&($typeReport == 3))
                  <!--Facturas con Deudas-->
                  @if((isset($value->getInvoice->status) && $value->getInvoice->status == 0) || $value->invoice == null)
                  <tr style="text-align: center">
                    <td>{{$value->code}}</td>
                    <td>@if($value->getPackage != null) {{$value->getPackage->code}} @else {{$value->getPickup->code}} @endif</td>
                    <td>{{$value->subtotal}}$</td>
                    <td>{{$value->total}}$</td>
                    <!--Deuda-->
                    <td>
                      @if(isset($value->getInvoice->status) && $value->getInvoice->status == 0) {{--si la factura no esta pagada--}}
                        {{$value->getInvoice->value}}$ {{--valor de la factura, disminuye si amortiza--}}
                        @elseif(isset($value->getInvoice->status) && $value->getInvoice->status == 1) {{--si la factura esta pagada--}}
                          0$  {{--Se muestra '0' si no hay deuda--}}
                          @else
                            {{$value->total}}$
                      @endif
                    </td>
                    <!--Pagado-->
                    <td>
                      @if(isset($value->getInvoice->status) && $value->getInvoice->status == 0)
                        {{ $value->total - $value->getInvoice->value}}$
                        @elseif(isset($value->getInvoice->status) && $value->getInvoice->status == 1) {{--si la factura esta pagada--}}
                        {{trans('billing.yes')}}
                        @else
                        {{trans('invoice.noDefined')}}
                      @endif
                    </td>
                    <!---->
                    <td>
                      @if(isset($value->getInvoice->status) && $value->getInvoice->status == 0)
                        {{trans('invoice.incomplete')}}
                        @elseif(isset($value->getInvoice->status) && $value->getInvoice->status == 1)
                          {{trans('billing.complete')}}
                          @else
                        {{trans('invoice.noDefined')}}
                      @endif
                    </td>
                  </tr>
                  @endif
                @endif
              @endforeach
            </tbody>
            @endif
            <!--Envios-->
            @if(isset($typeReport) && ($typeReport == 4 || $typeReport == 5 || $typeReport == 6))
            <thead>
              <th style="width:10%;text-align: center;">{{trans('package.receipt')}}</th>
              <th style="width:12%;text-align: center;">{{trans('package.type')}}</th>
              <th style="width:15%;text-align: center;">{{trans('package.subtotal')}}</th>
              <th style="width:10%;text-align: center;">{{trans('package.total')}}</th>
              <th style="width:10%;text-align: center;">{{trans('package.debt')}}</th>
              <th style="width:15%;text-align: center;">{{trans('package.paidOut')}}</th>
              <th style="width:15%;text-align: center;">{{trans('package.statusOfPaid')}}</th>
            </thead>
            <tbody>
              @if(isset($typeReport) && $typeReport == 4)
                <!--Envios Recibidos-->
                @foreach($data as $value)
                  @if($value->getPackage->last_event == 1)
                  <tr style="text-align: center">
                    <td>{{$value->getPackage->id}}</td>
                    <td>{{ $value != null && $value->getPackage != null ? $value->getPackage->created_at->format('Y-m-d') : ''}}</td>
                    <td>{{ $value != null && $value->getPackage != null ? $value->getPackage->code : ''}}</td>
                    <td>@if(isset($value->getPackage->to_client)&&($value->getPackage->to_client == null)){{isset($value->getPackage->getToUser->code) ? $value->getPackage->getToUser->code : ''}} {{isset($value->getPackage->getToUser->name) ? $value->getPackage->getToUser->name : ''}} @else {{$value->getPackage->to_client}} @endif</td>
                    <td>{{$value->pieces}}</td>
                    <td>{{isset($value->getPackage->getCourier->name) ? $value->getPackage->getCourier->name : ''}}</td>
                    <td>{{isset($value->getPackage->getToUser->code) ? $value->getPackage->getToUser->code : ''}} {{isset($value->getPackage->getToUser->name) ? $value->getPackage->getToUser->name : ''}}</td>
                    <td>{{isset($value->getPackage->getType) ? ($lang == 'es') ? ($lang == 'es') ? ucwords($transport->spanish) : ucwords($transport->english) : ucwords($transport->english) : ''}}</td>
                    <td>{{$value->weight}}</td>
                    <td>{{$value->large}}x{{$value->width}}x{{$value->height}}</td>
                  </tr>
                  @endif
                @endforeach
              @endif
              @if(isset($typeReport) && $typeReport == 5)
                <!--Envios en Transito-->
                @foreach($data as $value)
                  @if($value->getPackage->last_event == 3)
                  <tr style="text-align: center">
                    <td>{{$value->getPackage->id}}</td>
                    <td>{{ $value != null && $value->getPackage != null ? $value->getPackage->created_at->format('Y-m-d') : ''}}</td>
                    <td>{{ $value != null && $value->getPackage != null ? $value->getPackage->code : ''}}</td>
                    <td>{{(isset($value->getPackage->to_client)&&($value->getPackage->to_client == null)) ? isset($value->getPackage->getToUser->code) ? $value->getPackage->getToUser->code : '' : isset($value->getPackage->to_client) ? $value->getPackage->to_client : ''}}</td>
                    <td>{{$value->pieces}}</td>
                    <td>{{$value->getPackage->getCourier->name}}</td>
                    <td>{{isset($value->getPackage->getToUser->code) ? $value->getPackage->getToUser->code : ''}}</td>
                    <td>{{($lang=='es')?$value->getPackage->getType->spanish:$value->getPackage->getType->english}}</td>
                    <td>{{$value->weight}}</td>
                    <td>{{$value->large}}x{{$value->width}}x{{$value->height}}</td>
                  </tr>
                  @endif
                @endforeach
              @endif

              @if(isset($typeReport) && ($typeReport == 6))
              @foreach($data as $value)
              <tr style="text-align: center">
                <td>{{$value->getPackage->id}}</td>
                <td>@if($value->getPackage != null)
                        <a class="infoRd" href="javascript:detailspackage({{$value->getPackage->id}}, 'true')">{{$value->getPackage->code}}</a>
                    @else
                        <a class="infoRd" href="javascript:detailspickup({{$value->getPickup->id}}, 'true')">{{$value->getPickup->code}}</a>
                    @endif
                </td>
                <?php
                  $factura = Receipt::query()->where('package','=',$value->getPackage->id)->first();

                 ?>
                <td>{{$factura->subtotal}}$</td>
                <td>{{$factura->total}}$</td>
                <!--Deuda-->
                <td>
                  @if(isset($value->getInvoice->status) && $value->getInvoice->status == 0) {{--si la factura no esta pagada--}}
                    {{$value->getInvoice->value}}$ {{--valor de la factura, disminuye si amortiza--}}
                    @elseif(isset($value->getInvoice->status) && $value->getInvoice->status == 1) {{--si la factura esta pagada--}}
                      0$  {{--Se muestra '0' si no hay deuda--}}
                      @else
                        {{$factura->total}}$
                  @endif
                </td>
                <!--Pagado-->
                <td>
                  @if(isset($value->getInvoice->status) && $value->getInvoice->status == 0)
                    {{ $factura->total - $value->value}}$
                    @elseif(isset($value->getInvoice->status) && $value->getInvoice->status == 1) {{--si la factura esta pagada--}}
                    {{trans('billing.yes')}}
                    @else
                    {{trans('invoice.noDefined')}}
                  @endif
                </td>
                <!---->
                <td>
                  @if(isset($value->getInvoice->status) && $value->getInvoice->status == 0)
                    {{trans('invoice.incomplete')}}
                    @elseif(isset($value->getInvoice->status) && $value->getInvoice->status == 1)
                      {{trans('billing.complete')}}
                      @else
                    {{trans('invoice.noDefined')}}
                  @endif
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>
            @endif
          </table>
        </div>
        @if(isset($typeReport))
        <input type="hidden" name="{{$nameReport}}" id="ics_hidden_option" value="{{$typeReport}}">
        @endif
    </div>
</div>
@stop
