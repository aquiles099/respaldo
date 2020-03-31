<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>{{isset($invoice) ?  $invoice->code : ''}}</title>
    <link rel="stylesheet" href="{{asset('styles.css')}}" media="screen" title="no title" charset="utf-8">
  </head>
  <body class="pdfBody">
    <!--Se define la cabecera del pdf, contiene logo e informacion de la empresa-->
    <header class = "pdfHeader">
      <table>
        <tr>
          <td>
            <img src="{{isset($configuration) ? ($configuration->logo_ics == '') ? asset('/uploads/logo/005.png') : $configuration->logo_ics : asset('/uploads/logo/005.png')}}" alt="logo" style="width: 90px;"/>
          </td>
           <td>
            <p>
              {{isset($configuration) ? ($configuration->headerReceipt == '') ? trans('configuration.noheader') : $configuration->headerReceipt : trans('configuration.noheader') }}
            </p>
          </td>
        </tr>
      </table>
      </div>
      <hr>
    </header>
     <div class="pdfInfo">
       <h2 style="text-transform: uppercase;">{{trans('invoice.invoice')}}: {{isset($invoice) ?  $invoice->code : ''}}{{$package->code}}</h2>
    </div>
    <table style="width:100%;padding:0; margin:0;border: grey 1px solid; border-collapse: collapse;margin-top:10px">
          <tr style="border: grey 1px solid; background-color:#ddd;">
          <th  style="padding-left:15px"> <h4 style="padding:0px;text-decoration: underline;text-align: left ">Cobrar a:</h4> </th>
          <th  style="padding-right:15px"> <h4 style="padding:0px;text-decoration: underline;text-align: right">Informacion del Envio</h4> </th>
          </tr>
          <tr>
          <td style="padding-left:10px,padding-right:10px">
              <p style="padding:0px;line-height:14px;font-weight: bold">Nombre: <span style="text-transform: uppercase;font-weight: 300">@if(isset($userdesti)){{$userdesti->name}} {{$userdesti->last_name}} @endif</span></p>
              <p style="padding:0px;line-height:10px;font-weight: bold">DNI: <span style="font-weight: 300">@if(isset($userdesti)) {{$userdesti->dni}} @endif</span></p>
              <p style="padding:0px;line-height:7px;font-weight: bold">Pais y Region: <span style="font-weight: 300">@if(isset($userdesti)) {{$userdesti->country}}-{{$userdesti->region}} @endif</span></p>
              <p style="padding:0px;line-height:7px;font-weight: bold">Zip y Dirección: <span style="font-weight: 300">@if(isset($userdesti)) {{$userdesti->postal_code}}-{{$userdesti->address}} @endif</span></p>
              <p style="padding:0px;line-height:7px;font-weight: bold">Telfs: <span style="font-weight: 300">@if(isset($userdesti)) {{$userdesti->local_phone}}/{{$userdesti->celular}} @endif</span></p>
          </td>
            <td style="text-align: right!important;padding-left:10px,padding-right:10px">
             <p style="padding:0px;line-height:14px;font-weight: bold">Numero de Envio: <span style="ext-transform: uppercase;font-weight: 300">{{$package->code}}</span></p>
             <p style="padding:0px;line-height:10px;font-weight: bold">Fecha y Hora de Registro: <span style="font-weight: 300">{{$package->created_at}}</span></p>
             <p style="padding:0px;line-height:7px;font-weight: bold">Consignatario: <span style="text-transform: uppercase;font-weight: 300">@if(isset($useroring)){{$userconsig->name}} {{$userconsig->last_name}} @endif</span></p>
             <p style="padding:0px;line-height:7px;font-weight: bold">Usuario Origen: <span style="text-transform: uppercase;font-weight: 300">@if(isset($useroring)) {{$useroring->name}} {{$useroring->last_name}} @endif</span></p>
             <p style="padding:0px;line-height:7px;font-weight: bold">Estatus de pago: <span style="font-weight: 300">{{(isset($invoice) ? (($invoice->status==1)? 'Pagado': 'Por Pagar') : 'Por Pagar')}} </span></p>
            </td>
        </tr>
      </table>
    <table style="width:100%;padding:0px; margin:0;border: grey 1px solid; border-collapse: collapse;margin-top:3px;">
      <tr style="border: 1px solid grey; background-color:#ddd;border: grey 1px solid;">
        <th style="height:40px">Descripcion</th>
        <th style="">Cantidad</th>
        <th style="">Precio</th>
        <th style="">Subtotal</th>
      </tr>
      @if(isset($service))
        <tr style="height:50px;padding:10px;border: grey 1px solid;">
          <td style="text-align: center;height:30px"> {{$service->name_oring}}</td>
          <td style="text-align: center; "> 1</td>
          <td style="text-align: center;"> {{$service->value_package}}$</td>
          <td style="text-align: center;"> {{$service->value_package}}$</td>
        </tr>
      @endif
      @if(isset($addcharge))
      <tr style="border: grey 1px solid;">
        <td style="text-align: center;height:30px"> {{$addcharge->name_oring}}</td>
        <td style="text-align: center; "> 1</td>
        <td style="text-align: center;"> {{$addcharge->value_package}}$</td>
        <td style="text-align: center;"> {{$addcharge->value_package}}$</td>
      </tr>
      @endif
      @if(isset($insurance))
      <tr style="border: grey 1px solid;">
        <td style="text-align: center;height:30px"> {{$insurance->name_oring}}</td>
        <td style="text-align: center; "> 1</td>
        <td style="text-align: center;"> {{$insurance->value_package}}$</td>
        <td style="text-align: center;"> {{$insurance->value_package}}$</td>
      </tr>
      @endif
      @if(isset($transport))
      <tr style="border: grey 1px solid;">
        <td style="text-align: center;height:30px"> Tranporte {{$transport->name_oring}}</td>
        <td style="text-align: center; "> 1</td>
        <td style="text-align: center;"> {{$transport->value_package}}$</td>
        <td style="text-align: center;"> {{$transport->value_package}}$</td>
      </tr>
      @endif
      <tr style="border: grey 1px solid;">
        <td style="text-align: center;height:170px"> </td>
        <td style="text-align: center; "> </td>
        <td style="text-align: center; "> </td>
        <td style="text-align: center; "> </td>
      </tr>
    </table>
    <table style="width:100%;padding:0; margin:0;border: grey 1px solid; border-collapse: collapse;margin-top:7px;">
      <tr style="">
        <td style="border: 1px solid #ddd;text-align: center;height:20px">Subtotal </td>
        <td style="border: 1px solid #ddd;text-align: center;"> {{$receipt->subtotal}}$</td>
       </tr>
      @foreach ($detailreceipt as $row)
        <tr>
          <td style="text-align: center;border: 1px solid #ddd;height:20px">{{$row->name_oring}} </td>
          <td style="text-align: center;border: 1px solid #ddd;"> {{$row->value_package}}$</td>
       </tr>
      @endforeach
      <tr style="">
        <td style="border: 1px solid #ddd;text-align: right;height:40px"><h3>Total</h3> </td>
        <td style="border: 1px solid #ddd;text-align: right;"><h3> {{$receipt->total}}$</h3></td>
       </tr>
    </table>
      <!--Se define el pie de pagina-->
    <div class="pdfFooter">
      <p>
          {{isset($configuration) ? ($configuration->footerReceipt == '') ? trans('configuration.nofooter') : $configuration->footerReceipt : trans('configuration.noheader') }}
      </p>
    </div>
  </body>
</html>
