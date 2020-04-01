<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Reportes de Paquetes</title>
    <link rel="stylesheet" href="{{asset('styles.css')}}" media="screen" title="no title" charset="utf-8">
  </head>
  <body class="pdfBody">
    <!--Se define la cabecera del pdf, contiene logo e informacion de la empresa-->
    <header class = "pdfHeader">
      <table>
        <tr>
          <td>
         
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
        {{trans('messages.package')}}: {{isset($package) ? $package->code : Input::get('code')}}
    </div>
      <!--Datos informativos del paquete-->
    <table >
      <tr>
        <td><b>{{trans('package.tracking')}}:</b></td>
        <td>{{isset($package) ? $package->code : Input::get('code')}}</td>
      </tr>
      <tr>
        <td><b>{{trans('package.from')}}:</b></td>
        <td>{{isset($package) ? (isset($package->to_client) ? $companyclient->name : $package->getCourier['name']) : ''}}</td>
      </tr>
      <tr>
        <td><b>{{trans('package.to')}}:</b></td>
        <td>{{isset($package) ? (isset($package->to_client) ? $package->getToClient['code']."-".$package->getToClient['name'] : $package->getToUser['code']."-".$package->getToUser['name']." ".$package->getToUser['last_name']) : ''}}</td>
      </tr>
      <tr>
        <td><b>{{trans('messages.date')}}:</b></td>
        <td>{{isset($package->created_at) ? $package->created_at:'' }}</td>
      </tr>
    </table>

    <!--Tabla con registros listados-->
    <br>
    <div>

      <p style="font-size:14px"> Paquete con numero de tracking:{{isset($package) ? $package->code : Input::get('code')}}</p>

      <p style="font-size:14px">Valor del Paquete:{{isset($package) ? $package->value : Input::get('value')}}$. </p>

      <p style="font-size:14px">Peso  volumetrico:{{isset($package) ? $package->volumetricweight : Input::get('volumetricweight')}}lbs,

      <p style="font-size:14px">Largo: {{isset($package) ? $package->large : Input::get('large')}}cm </p>
      <p style="font-size:14px">Ancho:{{isset($package) ? $package->width : Input::get('width')}}cm </p>
      <p style="font-size:14px">Altura:{{isset($package) ? $package->height : Input::get('height')}}cm</p> 
      <p style="font-size:14px">Peso:{{isset($package) ? $package->weight : Input::get('weight')}}cm. </p>


    </div>



      <table style="width:100%;padding:0; margin:0">
        <tr>
          <td style="text-align: right;">
            @if(isset($detailreceipt))
                @foreach ($detailreceipt as $row)
                   <p> {{$row->name}}({{$row->value_oring}}%)</p>
                   @endforeach
              @endif
          </td>
          <td style="text-align: right;">
            @if(isset($detailreceipt))
                @foreach ($detailreceipt as $row)
                   <p> +{{$row->value_package}}</p>
                   @endforeach
              @endif
          </td>
         </tr>
         <tr>
          <td style="text-align: right!important;">
            <h4>{{trans('package.subtotal')}}: </h4>
          </td>
          <td style="text-align: right!important;">
            <h4>{{isset($receipt->subtotal) ? $receipt->subtotal:'' }}$</h4>
          </td>
         </tr>

          <tr>
          <td style="text-align: right;">
            <p>{{trans('package.promotion')}}: </p>
          </td>
          <td style="text-align: right;">
            <p style="text-align: right;">-{{isset($promo->value_package) ? $promo->value_package :'0'}}$</p>
          </td>
         </tr>

          <tr style="background-color:#eee">
          <td style="text-align: right;">
            <h3 style="text-align: right;">Total: </h3>
          </td>
          <td style="text-align: right;">
            <h3 style="text-align: right;"" >{{isset($receipt->total) ? $receipt->total:'' }}$</h3>
          </td>
         </tr>


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
