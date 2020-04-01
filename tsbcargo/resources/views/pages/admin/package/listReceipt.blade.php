<table class="table table-striped table-border table-hover text-center" id="dtble" >
  <thead>
    <tr>
      <th style="width:10%;text-align: center;">{{trans('package.receipt')}}</th>
      <th style="width:12%;text-align: center;">{{trans('package.type')}}</th>
      <th style="width:15%;text-align: center;">{{trans('package.subtotal')}}</th>
      <th style="width:10%;text-align: center;">{{trans('package.total')}}</th>
      <th style="width:15%;text-align: center;">{{trans('package.paidOut')}}</th>
      <th style="width:10%;text-align: center;">{{trans('package.debt')}}</th>
      <th style="width:15%;text-align: center;">{{trans('package.statusOfPaid')}}</th>
      <th style="width:20%;text-align: center;">{{trans('messages.actions')}}</th>
    </tr>
  </thead>
  <tbody>
    @if(isset($response))
      <!--All-->
      @if($response == 'Todos') {{--Se listan todas las facturas--}}
        @foreach ($receipt as $receipts)
        <tr item="{{$receipts}}">
          <td style="text-align: center;">{{$receipts->code}}</td>
          <td style="text-align: center;"><a @if (isset($receipts->getPackage)) href="javascript:icsShowWarehouseOnReceipt({{$receipts->getPackage->id}})" @else href="javascript:icsShowPickupOnReceipt({{$receipts->getPickup->id}})" @endif class="infoRd">{{isset($receipts->getPackage) ? $receipts->getPackage->code : $receipts->getPickup->code }}</a></td>
          <td style="text-align: center;">{{$receipts->subtotal}}$</td>
          <td style="text-align: center;">{{$receipts->total}}$</td>
          <!--Pagado-->
          <td style="text-align: center;">
            @if(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 0)
              {{ $receipts->total - $receipts->getInvoice->value}}$
              @elseif(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 1) {{--si la factura esta pagada--}}
              <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
              @else
              <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
            @endif
          </td>
          <!--Deuda-->
          <td style="text-align: center;">
            @if(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 0) {{--si la factura no esta pagada--}}
              {{$receipts->getInvoice->value}}$ {{--valor de la factura, disminuye si amortiza--}}
              @elseif(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 1) {{--si la factura esta pagada--}}
                0$  {{--Se muestra '0' si no hay deuda--}}
                @else
                  {{$receipts->total}}$
            @endif
          </td>
          <td style="text-align: center;">
            @if(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 0)
            <a href="javascript:paid({{$receipts->getInvoice->receipt}})" data-toggle="tooltip" title="{{trans('invoice.pay')}}">{{trans('invoice.incomplete')}}</a>
              @elseif(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 1)
                <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                @else
                  <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
            @endif
          </td>
          <td style="">
            <ul class="table-actions text-center"  >
             {{-- <li><a href="admin/billingid/{{$receipts->id}}" target="_blank"><i class="fa fa-list" title="{{trans('invoice.edit')}}"></i></a></li>
              <li><a href="javascript:printExportFile(1)" target="_blank"><i class="fa fa-print" title="{{trans('invoice.print')}}"></i></a></li>--}}
              <li><a @if(isset($receipts->getPackage)) href="admin/invoice/{{(isset($receipts->getPackage)) ? $receipts->getPackage->id : 0}}/warehouse" @else href="admin/invoice/{{isset($receipts->getPickup) ? $receipts->getPickup->id : 0}}/pickup" @endif target="_blank" target="_blank"><i class="fa fa-file-pdf-o" data-toggle="tooltip" title="{{trans('package.receipt')}}"></i></a></li>
              {{--<li><a href="javascript:printExportFile(3)" target="_blank"><i class="fa fa-file-excel-o" title="{{trans('invoice.xls')}}"></i></a></li>--}}
              @if(!isset($receipts->getInvoice->status))
              <li><a href="javascript:innerCheckin({{$receipts->id}})" id="ics_innercheckinicon" data-toggle="tooltip" title="{{trans('invoice.checkIn')}}"><i class="fa fa-files-o" ></i></a></li>
              @else
              <li><a onclick="showPayments({{$receipts->id}})" data-toggle="tooltip" title="{{trans('invoice.showPayments')}}"><i class="fa fa-list-ol" aria-hidden="true"></i></a></li>
              @endif
            </ul>
          </td>
        </tr>
        @endforeach
      @endif
      <!--PaidOut-->
      @if($response == 'Pagados') {{--Se listan las factuaras pagadas--}}
        @foreach ($receipt as $receipts)
          @if(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 1)
            <tr item="{{$receipts}}">
              <td style="text-align: center;">{{$receipts->code}}</td>
              <td style="text-align: center;"><a @if (isset($receipts->getPackage)) href="javascript:icsShowWarehouseOnReceipt({{$receipts->getPackage->id}})" @else href="javascript:icsShowPickupOnReceipt({{$receipts->getPickup->id}})" @endif class="infoRd">{{isset($receipts->getPackage) ? $receipts->getPackage->code : $receipts->getPickup->code }}</a></td>
              <td style="text-align: center;">{{$receipts->subtotal}}$</td>
              <td style="text-align: center;">{{$receipts->total}}$</td>
              <!--Pagado-->
              <td style="text-align: center;">
                @if(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 0)
                  {{ $receipts->total - $receipts->getInvoice->value}}$
                  @elseif(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 1) {{--si la factura esta pagada--}}
                  <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                  @else
                  <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                @endif
              </td>
              <!--Deuda-->
              <td style="text-align: center;">
                @if(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 0) {{--si la factura no esta pagada--}}
                  {{$receipts->getInvoice->value}}$ {{--valor de la factura, disminuye si amortiza--}}
                  @elseif(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 1) {{--si la factura esta pagada--}}
                    0$  {{--Se muestra '0' si no hay deuda--}}
                    @else
                      {{$receipts->total}}$
                @endif
              </td>
              <td style="text-align: center;">
                @if(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 0)
                <a href="javascript:paid({{$receipts->getInvoice->receipt}})" data-toggle="tooltip" title="{{trans('invoice.pay')}}">{{trans('invoice.incomplete')}}</a>
                  @elseif(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 1)
                    <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                    @else
                      <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                @endif
              </td>
              <td style="">
                <ul class="table-actions text-center"  >
              {{--<li><a href="admin/billingid/{{$receipts->id}}" target="_blank"><i class="fa fa-list" title="{{trans('invoice.edit')}}"></i></a></li>
                  <li><a href="javascript:printExportFile(1)" target="_blank"><i class="fa fa-print" title="{{trans('invoice.print')}}"></i></a></li>--}}
                  <li><a @if(isset($receipts->getPackage)) href="admin/invoice/{{(isset($receipts->getPackage)) ? $receipts->getPackage->id : 0}}/warehouse" @else href="admin/invoice/{{isset($receipts->getPickup) ? $receipts->getPickup->id : 0}}/pickup" @endif target="_blank" target="_blank"><i class="fa fa-file-pdf-o" data-toggle="tooltip" title="{{trans('Generar recibo')}}"></i></a></li>
              {{--<li><a href="javascript:printExportFile(3)" target="_blank"><i class="fa fa-file-excel-o" title="{{trans('invoice.xls')}}"></i></a></li>--}}
                  @if(!isset($receipts->getInvoice->status))
                  <li><a href="javascript:innerCheckin({{$receipts->id}})" id="ics_innercheckinicon" data-toggle="tooltip" title="{{trans('invoice.checkIn')}}"><i class="fa fa-files-o" ></i></a></li>
                  @else
                  <li><a onclick="showPayments({{$receipts->id}})" data-toggle="tooltip" title="{{trans('invoice.showPayments')}}"><i class="fa fa-list-ol" aria-hidden="true"></i></a></li>
                  @endif
                </ul>
              </td>
            </tr>
          @endif
        @endforeach
      @endif
      <!--Debt-->
      @if($response == 'Deudas') {{--Se listan las factuaras con deudas--}}
        @foreach ($receipt as $receipts)
          @if((isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 0) || $receipts->invoice == null)
            <tr item="{{$receipts}}">
              <td style="text-align: center;">{{$receipts->code}}</td>
              <td style="text-align: center;"><a @if (isset($receipts->getPackage)) href="javascript:icsShowWarehouseOnReceipt({{$receipts->getPackage->id}})" @else href="javascript:icsShowPickupOnReceipt({{$receipts->getPickup->id}})" @endif class="infoRd">{{isset($receipts->getPackage) ? $receipts->getPackage->code : $receipts->getPickup->code }}</a></td>
              <td style="text-align: center;">{{$receipts->subtotal}}$</td>
              <td style="text-align: center;">{{$receipts->total}}$</td>
              <!--Pagado-->
              <td style="text-align: center;">
                @if(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 0)
                  {{ $receipts->total - $receipts->getInvoice->value}}$
                  @elseif(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 1) {{--si la factura esta pagada--}}
                  <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                  @else
                  <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                @endif
              </td>
              <!--Deuda-->
              <td style="text-align: center;">
                @if(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 0) {{--si la factura no esta pagada--}}
                  {{$receipts->getInvoice->value}}$ {{--valor de la factura, disminuye si amortiza--}}
                  @elseif(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 1) {{--si la factura esta pagada--}}
                    0$  {{--Se muestra '0' si no hay deuda--}}
                    @else
                      {{$receipts->total}}$
                @endif
              </td>
              <td style="text-align: center;">
                @if(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 0)
                <a href="javascript:paid({{$receipts->getInvoice->receipt}})" data-toggle="tooltip" title="{{trans('invoice.pay')}}">{{trans('invoice.incomplete')}}</a>
                  @elseif(isset($receipts->getInvoice->status) && $receipts->getInvoice->status == 1)
                    <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                    @else
                      <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                @endif
              </td>
              <td style="">
                <ul class="table-actions text-center"  >
              {{--<li><a href="admin/billingid/{{$receipts->id}}" target="_blank"><i class="fa fa-list" title="{{trans('invoice.edit')}}"></i></a></li>
                  <li><a href="javascript:printExportFile(1)" target="_blank"><i class="fa fa-print" title="{{trans('invoice.print')}}"></i></a></li>--}}
                  <li><a @if(isset($receipts->getPackage)) href="admin/invoice/{{(isset($receipts->getPackage)) ? $receipts->getPackage->id : 0}}/warehouse" @else href="admin/invoice/{{isset($receipts->getPickup) ? $receipts->getPickup->id : 0}}/pickup" @endif target="_blank" target="_blank"><i class="fa fa-file-pdf-o" data-toggle="tooltip" title="{{trans('Generar recibo')}}"></i></a></li>
              {{--<li><a href="javascript:printExportFile(3)" target="_blank"><i class="fa fa-file-excel-o" title="{{trans('invoice.xls')}}"></i></a></li>--}}
                  @if(!isset($receipts->getInvoice->status))
                  <li><a href="javascript:innerCheckin({{$receipts->id}})" id="ics_innercheckinicon" data-toggle="tooltip" title="{{trans('invoice.checkIn')}}"><i class="fa fa-files-o" ></i></a></li>
                  @else
                  <li><a onclick="showPayments({{$receipts->id}})" data-toggle="tooltip" title="{{trans('invoice.showPayments')}}"><i class="fa fa-list-ol" aria-hidden="true"></i></a></li>
                  @endif
                </ul>
              </td>
            </tr>
          @endif
        @endforeach
      @endif
    @endif
  </tbody>
</table>
