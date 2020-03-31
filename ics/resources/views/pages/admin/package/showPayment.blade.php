<div id="wrapper"  style="background-color:white">
  <div id="page-wrapper" class="only">
    <div class="panel-white col-md-6 shadow ics-panel-white" style="height: 530px;">
      <!--header-->
      <div class="row">
        <div class="col-md-12">
          <div class="" style="margin-top: 9px; margin-bottom: 2px;">
            <p>
              <span >
                <img style="width:100px; height:50px" src="{{isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg')}}" alt="logo" />
                <span style="float:right; width: 50%; text-align: right;"><b>{{trans('invoice.date')}}:</b> {{date('Y-m-d H:i:s')}}</span>
                <hr style="margin-top: 0px; margin-bottom:0px">
              </span>
            </p>
            <h4 style="text-align: left">{{trans('invoice.payHistory')}} </h4>
          </div>
        </div>
      </div>
      <!-- List-->
      <div class="row">
        <div class="col-md-12">
          <p><b>{{trans('invoice.package')}}:</b> {{isset($receipt->getPackage) ? $receipt->getPackage->code  : $receipt->getPickup->code }}</p>
          <p><b>{{trans('invoice.userDestiny')}}:</b>
            @if($receipt->getPackage != null)
              {{($receipt->getPackage->getToUser) ? $receipt->getPackage->getToUser->code : ''}}
              {{($receipt->getPackage->getToUser) ? $receipt->getPackage->getToUser->name : ''}}
              {{($receipt->getPackage->getToUser) ? $receipt->getPackage->getToUser->last_name : ''}}
            @else
              {{($receipt->getPickup->getToUser) ? $receipt->getPickup->getToUser->code : ''}}
              {{($receipt->getPickup->getToUser) ? $receipt->getPickup->getToUser->name : ''}}
              {{($receipt->getPickup->getToUser) ? $receipt->getPickup->getToUser->last_name : ''}}
            @endif</p>
          <p><b>{{trans('invoice.receipt')}}:</b> {{isset($receipt) ? $receipt->code :''}}</p>
          <input type="hidden" name="ics_hreceipt" id="ics_hreceipt" value="{{$receipt->id}}">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            @if($invoiceDetail->count() > 0)
              <table style="width: 100%; margin-bottom: 10px; text-align: justify;" border="1">
                <tr style="font-weight: bold;text-align: center;">
                  <td>{{trans('invoice.transaction')}}</td>
                  <td>{{trans('invoice.paidOut')}}</td>
                  <td>{{trans('invoice.type')}}</td>
                  <td>{{trans('invoice.remaining')}}</td>
                  <td>{{trans('invoice.observation')}}</td>
                </tr>
                @foreach($invoiceDetail as $key => $value)
                <tr style="text-align:center; border:1px white;">
                  <td style="width:5px; padding-bottom: 10px; border-right: 1px solid"><a href="javascript:detailPayment({{$value->id}})" style="color: currentColor">{{$key + 1}}</a></td>
                  <td style="width:10px; padding-bottom: 10px; border-right: 1px solid">{{$value->paidOut}}$</td>
                  <td style="width:10px; padding-bottom: 10px; border-right: 1px solid">{{($value->type == 1) ? trans('invoice.bank') : ($value->type == 2) ? trans('invoice.Cash') : trans('invoice.check')}}</td>
                  <td style="width:20px; padding-bottom: 10px; border-right: 1px solid">{{$value->debt}}$</td>
                  <td style="width:10px; padding-bottom: 10px; border-right: 1px solid">{{$value->observation}}</td>
                </tr>
                @endforeach
              </table>
              @else
                <div class="panel panel-red" style="margin-top: 5%">
                  <div class="panel-heading">{{trans('invoice.noPaids')}} <span class="pull-right"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span></div>
                  <div class="panel-body">
                  </div>
                </div>
            @endif
        </div>
      </div>
    </div>
  </div>
</div>
