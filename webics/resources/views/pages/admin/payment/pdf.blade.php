<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>{{$client->webpage.'-invoice-'.$payment->code.'.pdf'}}</title>
    <!-- Customize favicon-->
    <link rel="shortcut icon" type="image/png" href="{{asset('dist/img/favicon.png')}}"/>
  </head>
  <style>
    body {
      font-family: Arial, Helvetica, Verdana;
    }
    table {
      width: 100%
      border-collapse: collapse;
    }
    .column-right {
      text-align: right;
      font-size: 20px
    }
    table,td {
  	border: 1px solid black;
  }
  </style>
  <body>
    <div class="container">
      <div class="">
        <table>
          <tr>
            <td>
              <!--Logo-->
              <p>
                <img src="{{asset('dist/img/logo.png')}}" alt="{{trans('messages.ICS')}} {{trans('messages.slogan')}}" style="width: 200px"/>
              </p>
            </td>
            <td class="column-right">
              <p>
                Payment Receipt {{$payment->code}}
              </p>
              <p>
                <table  border="1">
                  <tr><td>Art&iacute;culo</td><td>Cantidad</td></tr>
                  <tr><td>Zapatillas</td><td>1.500</td></tr>
                  <tr><td>Gorras</td><td>12.200</td></tr>
                  <tr><td>Pantalones</td><td>3.800</td></tr>
                  <tr><td>Camisetas</td><td>7.100</td></tr>
                </table>
              </p>
            </td>
          </tr>
        </table>
      </div>
      <!--Datos de Solicitud-->
      <div class="">
        <p>
          <strong>Datos de solicitud</strong>
        </p>
        <p>
          {{$solicitude}}
        </p>
      </div>
      <!--Datos de contrato-->
      <div class="">
        <p>
          <strong>Datos de Contrato</strong>
        </p>
        <p>
          {{isset($contract) ? $contract : trans('messages.unknown')}}
        </p>
      </div>
      <!--Datos de Cliente-->
      <div class="">
        <p>
          <strong>Datos de Cliente</strong>
        </p>
        <p>
          {{$client}}
        </p>
      </div>
      <!--Datos de Pago-->
      <div class="">
        <p>
          <strong>Datos de Pago</strong>
        </p>
        <p>
          {{$payment}}
        </p>
      </div>
    </div>
  </body>
</html>
