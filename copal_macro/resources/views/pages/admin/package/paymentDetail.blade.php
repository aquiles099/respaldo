<div id="wrapper"  style="background-color:white">
  <div id="page-wrapper" class="only">
    <div class="panel-white col-md-6 shadow ics-panel-white">
        @if(isset($detail))
        <div class="row">
    			<div class="col-md-12">
    				<div class="" style="margin-top: 9px; margin-bottom: 2px;">
              <p>
                <span >
                  <img style="width:100px; height:50px" src="{{isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg')}}" alt="logo" />
                  <span style="float:right; width: 50%; text-align: right;"><b>{{trans('invoice.observation')}}:</b> {{$detail->observation}}</span>
                  <hr style="margin-top: 0px; margin-bottom:0px">
                </span>
              </p>
    					<h4 style="text-align: left">{{trans('invoice.detailPaid')}} <small style=" float: right;"><span>{{trans('invoice.date')}}: {{date('Y-m-d H:i:s')}}</span></small></h4>
    				</div>
    			</div>
    		</div>
        <!--header-->
        <div class="row">
          <div class="col-md-12">
              <p><b>{{trans('invoice.package')}}:</b> {{isset($receipt->getPackage) ? $receipt->getPackage->code  : $receipt->getPickup->code }}</p>
              <p><b>{{trans('invoice.userDestiny')}}:</b>
                @if($receipt->getPackage != null)
                  {{$receipt->getPackage->getToUser->code}}
                  {{$receipt->getPackage->getToUser->name}}
                  {{$receipt->getPackage->getToUser->last_name}}
                @else
                  {{$receipt->getPickup->getToUser->code}}
                  {{$receipt->getPickup->getToUser->name}}
                  {{$receipt->getPickup->getToUser->last_name}}
                @endif
              </p>
              <p><b>{{trans('invoice.receipt')}}:</b> {{isset($receipt) ? $receipt->code :''}}</p>
            <input type="hidden" name="ics_hreceipt" id="ics_hreceipt" value="{{$receipt->id}}">
        </div>
      </div>
      <!--list-->
      <table style="width: 100%; margin-bottom: 10px; text-align: justify;" border="1">
        <tr style="font-weight: bold;text-align: center;">
          <td>{{trans('invoice.date')}}</td>
          <td>{{trans('invoice.type')}}</td>
          <td>{{trans('invoice.rode')}}</td>
        </tr>
        <tr style="text-align: center;">
          <td style="padding-top:20px;padding-bottom:290px">{{$detail->created_at}}</td>
          <td style="padding-top:20px;padding-bottom:290px">{{($detail->type == 1) ? trans('invoice.bank') : ($value->type == 2) ? trans('invoice.Cash') : trans('invoice.check')}}</td>
          <td style="padding-top:20px;padding-bottom:290px">{{$detail->paidOut}}$</td>
        </tr>
    </table>
    @endif
  </div>
</div>
</div>
