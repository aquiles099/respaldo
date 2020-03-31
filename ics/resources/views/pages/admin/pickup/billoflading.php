<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="{{asset('styles.css')}}" media="screen" title="no title" charset="utf-8">
  </head>
  <body class="pdfBody">
    <!--Se define la cabecera del pdf, contiene logo e informacion de la empresa-->
    <header class = "pdfHeader">
      <table>
        <tr>
          <td>
            <!--<img src="{{isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg')}}" alt="logo" />-->
            <h1 style="text-transform: uppercase;">ICS</h1>
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
       <h2 style="text-transform: uppercase;">INVOICE INV-{{isset($receipt->invoice)}}</h2>
    </div>

    <table style="width:100%;padding:0; margin:0;border: grey 1px solid; border-collapse: collapse;margin-top:15px">
          <tr style="border: grey 1px solid; background-color:#ddd;">
          <th> <h3 style="padding:0px;text-decoration: underline;text-align: left ">Cobrar a:</h3> </th>
          <th> <h3 style="padding:0px;text-decoration: underline;text-align: right">Informacion del Envio</h3> </th>
          </tr>
          <tr>
          <td style="padding:5px">
              <p style="padding:0px;line-height:14px;font-weight: bold">Nombre: <span style="text-transform: uppercase;font-weight: 300">{{$userdesti->name}} {{$userdesti->last_name}}</span></p>
              <p style="padding:0px;line-height:10px;font-weight: bold">DNI: <span style="font-weight: 300">{{$userdesti->dni}}</span></p>
              <p style="padding:0px;line-height:7px;font-weight: bold">Pais y Region: <span style="font-weight: 300">{{$userdesti->country}}-{{$userdesti->region}}</span></p>
              <p style="padding:0px;line-height:7px;font-weight: bold">Zip y Dirección: <span style="font-weight: 300">{{$userdesti->postal_code}}-{{$userdesti->address}}</span></p>
              <p style="padding:0px;line-height:7px;font-weight: bold">Telfs: <span style="font-weight: 300">{{$userdesti->local_phone}}/{{$userdesti->celular}}</span></p>

          </td>
          
        
        
            <td style="text-align: right!important;">
           
             <p style="padding:0px;line-height:14px;font-weight: bold">Numero de Envio: <span style="ext-transform: uppercase;font-weight: 300">RE-0{{$package->code}}</span></p>
             <p style="padding:0px;line-height:10px;font-weight: bold">Fecha y Hora de Registro: <span style="font-weight: 300">{{$package->created_at}}</span></p>

             <p style="padding:0px;line-height:7px;font-weight: bold">Consignatario: <span style="text-transform: uppercase;font-weight: 300">{{$userconsig->name}} {{$userconsig->last_name}}</span></p>

             <p style="padding:0px;line-height:7px;font-weight: bold">Usuario Origen: <span style="text-transform: uppercase;font-weight: 300">{{$useroring->name}} {{$useroring->last_name}}</span></p>
             <p style="padding:0px;line-height:7px;font-weight: bold">Estatus de pago: <span style="font-weight: 300">{{(isset($invoice) ? (($invoice->status==1)? 'Pagado': 'Por Pagar') : 'Por Pagar')}} </span></p>
      
            </td>
        </tr>

      </table>




    <!--<table style="width:100%;padding:0; margin:0;border: grey 1px solid; border-collapse: collapse;">
        <tr style="border: grey 1px solid;">
          <td style="border: grey 1px solid;padding:5px">
              <h3 style="padding:0px;line-height:5px;text-decoration: underline;padding-bottom:5px">Usuario de Origen</h3>
              <p style="padding:0px;line-height:7px;font-weight: bold">Nombre: <span style="text-transform: uppercase;font-weight: 300">{{$useroring->name}} {{$useroring->last_name}}</span></p>
              <p style="padding:0px;line-height:7px;font-weight: bold">DNI: <span style="font-weight: 300">{{$useroring->dni}}</span></p>
              <p style="padding:0px;line-height:7px;font-weight: bold">Pais y Region: <span style="font-weight: 300">{{$useroring->country}}-{{$useroring->region}}</span></p>
              <p style="padding:0px;line-height:7px;font-weight: bold">Zip y Dirección: <span style="font-weight: 300">{{$useroring->postal_code}}-{{$useroring->address}}</span></p>
              <p style="padding:0px;line-height:7px;font-weight: bold">Telfs: <span style="font-weight: 300">{{$useroring->local_phone}}/{{$useroring->celular}}</span></p>
          </td>

            <td style="border: grey 1px solid;padding:5px">
               <h3 style="padding:0px;line-height:5px;text-decoration: underline;padding-bottom:5px">Usuario Consignado</h3>

              <p style="padding:0px;line-height:7px;font-weight: bold">Nombre: <span style="text-transform: uppercase;font-weight: 300">{{$userconsig->name}} {{$userconsig->last_name}}</span></p>
              <p style="padding:0px;line-height:7px;font-weight: bold">DNI: <span style="font-weight: 300">{{$userconsig->dni}}</span></p>
              <p style="padding:0px;line-height:7px;font-weight: bold">Pais y Region: <span style="font-weight: 300">{{$userconsig->country}}-{{$userconsig->region}}</span></p>
              <p style="padding:0px;line-height:7px;font-weight: bold">Zip y Dirección: <span style="font-weight: 300">{{$userconsig->postal_code}}-{{$userconsig->address}}</span></p>
              <p style="padding:0px;line-height:7px;font-weight: bold">Telfs: <span style="font-weight: 300">{{$userconsig->local_phone}}/{{$userconsig->celular}}</span></p>

            </td>
          
        </tr>

          

      </table>-->

    <table style="width:100%;padding:0; margin:0;border: grey 1px solid; border-collapse: collapse;margin-top:7px;">
      <tr style="border: 1px solid grey; background-color:#ddd;">
        <th style="height:50px">Descripcion</th>
        <th style="">Cantidad</th>
        <th style="">Precio</th>
        <th style="">Subtotal</th>
      </tr>


      @if(isset($service))
        <tr style="height:50px">
          <td style="text-align: left;;height:30px"> {{$service->name_oring}}</td>
          <td style="text-align: center; "> 1</td>
          <td style="text-align: center;"> {{$service->value_package}}$</td>
          <td style="text-align: center;"> {{$service->value_package}}$</td>
        </tr>
      @endif

      @if(isset($addcharge))
      <tr style="">
        <td style="text-align: left;height:30px"> {{$addcharge->name_oring}}</td>
        <td style="text-align: center; "> 1</td>
        <td style="text-align: center;"> {{$addcharge->value_package}}$</td>
        <td style="text-align: center;"> {{$addcharge->value_package}}$</td>
            
      </tr>
      @endif
      @if(isset($insurance))
      <tr style="">
        <td style="text-align: left;height:30px"> {{$insurance->name_oring}}</td>
        <td style="text-align: center; "> 1</td>
        <td style="text-align: center;"> {{$insurance->value_package}}$</td>
        <td style="text-align: center;"> {{$insurance->value_package}}$</td>
      </tr>
      @endif
      @if(isset($transport))
      <tr style="">
        <td style="text-align: left;height:30px"> Tranporte {{$transport->name_oring}}</td>
        <td style="text-align: center; "> 1</td>
        <td style="text-align: center;"> {{$transport->value_package}}$</td>
        <td style="text-align: center;"> {{$transport->value_package}}$</td>
      </tr>
      @endif

      <tr style="">
        <td style="text-align: left;height:200px"> </td>
        <td style="text-align: center; "> </td>
        <td style="text-align: center; "> </td>
        <td style="text-align: center; "> </td>

        
            
      </tr>

       


    </table>


    <table style="width:100%;padding:0; margin:0;border: grey 1px solid; border-collapse: collapse;margin-top:7px;">
      
      <tr style="">
        
        <td style="border: 1px solid #ddd;text-align: right;height:30px">Subtotal </td>
        <td style="border: 1px solid #ddd;text-align: right;"> {{$receipt->subtotal}}$</td>
       </tr>
        
      @foreach ($detailreceipt as $row)
        <tr>
          
          <td style="text-align: right;border: 1px solid #ddd;height:30px">{{$row->name_oring}} </td>
          <td style="text-align: right;border: 1px solid #ddd;"> {{$row->value_package}}$</td>
       </tr>
      @endforeach
      
      <tr style="">
        
        <td style="border: 1px solid #ddd;text-align: right;height:50px"><h2>Total</h2> </td>
        <td style="border: 1px solid #ddd;text-align: right;"><h2> {{$receipt->total}}$</h2></td>
       </tr>
    </table>

   <!-- <table style="width:100%;padding:0; margin:0;border: grey 1px solid; border-collapse: collapse;margin-top:7px">
      <tr style="border: 1px solid grey; background-color:#ddd"">
        <th style="border: 1px solid grey;text-align: left;">Nota:</th>
        
      </tr>
      <tr style="border: 1px solid grey;">
          <td style="border: 1px solid grey;text-align: center;"> {{$package->observation}}</td>
        
        
      </tr>

    </table>-->

 <!--   <table style="width:100%;padding:0; margin:0;border: grey 1px solid; border-collapse: collapse;margin-top:15px">
      <tr style="border: 1px solid grey; background-color:#ddd"">
        <th style="border: 1px solid grey;text-align: left;">Firmado por:</th>
        <th style="border: 1px solid grey;">Piezas</th>
        <th style="border: 1px solid grey;">Peso</th>
        <th style="border: 1px solid grey;">Volumen</th>
        
      </tr>
      <tr style="border: 1px solid grey;">

        @foreach ($detailspackage as $row)
        
          <td style="border: 1px solid grey;text-align: center;height:40px"> ________________________________________</td>
        <td style="border: 1px solid grey;text-align: center;"> {{$row->pieces}}</td>
        <td style="border: 1px solid grey;text-align: center;"> {{$row->weight}}</td>
        <td style="border: 1px solid grey;text-align: center;"> {{$row->volumetricweight 
        }}ft<sup>3</sup></td>
       @endforeach
        
      </tr>

    </table>-->






      <!--Datos informativos del paquete-->
    <!--<table >
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
        <td>{{$package->created_at}}</td>
      </tr>
    </table>

    Tabla con registros listados
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
                   <p> {{$row->name_oring}}({{$row->value_oring}}%)</p>
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
            <h4>{{$receipt->subtotal}}$</h4>
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
            <h3 style="text-align: right;"" >{{$receipt->total}}$</h3>
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
