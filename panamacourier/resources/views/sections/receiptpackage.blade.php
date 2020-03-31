<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>{{strtoupper(trans('messages.warehousereceipt'))}} - {{$package->code}}</title>
    <link rel="stylesheet" href="{{asset('styles.css')}}" media="screen" title="no title" charset="utf-8">
    <!-- Customize favicon-->
    <link rel="shortcut icon" type="image/png" href="{{isset($configuration_header) ? ($configuration_header->logo_ics == '') ? asset('/uploads/logo/005.png') : $configuration_header->logo_ics : asset('/uploads/logo/005.png')}}"/>
  </head>
  <body class="pdfBody">
    <!--Se define la cabecera del pdf, contiene logo e informacion de la empresa-->
    <header class = "pdfHeader">
      <table>
        <tr>
          <td>
            <img src="{{isset($configuration) ? ($configuration->logo_ics == '') ? asset('/uploads/logo/005.png') : $configuration->logo_ics : asset('/uploads/logo/005.png')}}" alt="logo" style="width: 90px;"/>
          </td>
          <td style="text-align: justify; font-size: 11px; padding: 5px">
            {{isset($configuration) ? $configuration->header_label : '' }}
          </td>
        </tr>
      </table>
      </div>
    </header>
    <!--nombe de recibo-->
     <div style="background-color: #21517a; color: white; margin-top: 0px; text-align: center; font-size: 20px; font-weight: bold; border: 2px solid rgb(102, 102, 102);">
       <div style="margin-top: 5px; margin-bottom: 5px">
           <span >{{strtoupper(trans('messages.warehousereceipt'))}} - {{$package->code}}</span>
       </div>
     </div>
     <!--Informacion del Envio-->
    <table style="width:100%;padding:0; margin:0">
      <tr>
        <td style="text-align: right!important;">
         <p style="padding:0px;line-height:14px;font-weight: bold">Numero de Envio: <span style="text-transform: uppercase;font-weight: 300">{{$package->code}}</span></p>
         <p style="padding:0px;line-height:14px;font-weight: bold">Tipo de Envio: <span style="text-transform: uppercase;font-weight: 300">{{$package->getCategory != '' ? strtoupper($package->getCategory->label) : trans('messages.unknown')}}</span></p>
         <p style="padding:0px;line-height:14px;font-weight: bold">Tipo de Transporte: <span style="text-transform: uppercase;font-weight: 300">{{$package->getType != '' ? strtoupper($package->getType->spanish) : trans('messages.unknown')}}</span></p>
         <p style="padding:0px;line-height:10px;font-weight: bold">Fecha y Hora de Registro: <span style="font-weight: 300">{{$package->created_at}}</span></p>
         <p style="padding:0px;line-height:10px;font-weight: bold">Estatus: <span style="font-weight: 300">{{strtoupper($package->getLastEvent['description'])}}</span></p>
         <p style="padding:0px;line-height:10px;font-weight: bold">Oficina de Recepcion: <span style="font-weight: 300">{{$package->getOffice['name'] != '' ? strtoupper($package->getOffice['name']) : trans('messages.unknown')}}</span></p>
        </td>
      </tr>
    </table>
    <!--Informacion de Carga-->
    <table style="width: 100%; border: 2px solid rgb(102, 102, 102); border-collapse: collapse;">
      <tr>
        <td style="background-color: #21517a; color: white; margin-top: 0px; text-align: center; font-size: 20px; font-weight: bold; border: 2px solid rgb(102, 102, 102);  width:50%">
        {{trans('messages.userconsigne')}}
        </td>
        <td style="background-color: #21517a; color: white; margin-top: 0px; text-align: center; font-size: 20px; font-weight: bold; border: 2px solid rgb(102, 102, 102); width:50%">
        {{trans('messages.userdestiny')}}
        </td>
      </tr>
      <!--Informacion de Usuario-->
      <tr>
        <!--Usuario Consignado-->
        <td style=" margin-top: 0px; text-align: right; border: 2px solid rgb(102, 102, 102);  width:50%">
          <p style="padding:0px;line-height:7px;font-weight: bold">Nombre: <span style="text-transform: uppercase;font-weight: 300">{{isset($userconsig) ? $userconsig->name." ".$userconsig->last_name:''}}</span></p>
          <p style="padding:0px;line-height:7px;font-weight: bold">DNI: <span style="font-weight: 300">{{isset($userconsig) ? $userconsig->dni:''}}</span></p>
          <p style="padding:0px;line-height:7px;font-weight: bold">Pais y Region: <span style="font-weight: 300">{{isset($userconsig) ? $userconsig->country."-".$userconsig->region:''}}</span></p>
          <p style="padding:0px;line-height:7px;font-weight: bold">Zip y Dirección: <span style="font-weight: 300">{{isset($userconsig) ? $userconsig->postal_code."-".$userconsig->address:''}}</span></p>
          <p style="padding:0px;line-height:7px;font-weight: bold">Telfs: <span style="font-weight: 300">{{isset($userconsig) ? $userconsig->local_phone."/".$userconsig->celular:''}}</span></p>
        </td>
        <!--Usuario Destino-->
        <td style=" margin-top: 0px; text-align: right; border: 2px solid rgb(102, 102, 102); width:50%">
          <p style="padding:0px;line-height:7px;font-weight: bold">Nombre: <span style="text-transform: uppercase;font-weight: 300">{{isset($userdesti) ? $userdesti->name." ".$userdesti->last_name:''}}</span></p>
          <p style="padding:0px;line-height:7px;font-weight: bold">DNI: <span style="font-weight: 300">{{isset($userdesti) ? $userdesti->dni: ''}}</span></p>
          <p style="padding:0px;line-height:7px;font-weight: bold">Pais y Region: <span style="font-weight: 300">{{isset($userdesti) ? $userdesti->country."-".$userdesti->region:''}}</span></p>
          <p style="padding:0px;line-height:7px;font-weight: bold">Zip y Dirección: <span style="font-weight: 300">{{isset($userdesti) ? $userdesti->postal_code."-".$userdesti->address:''}}</span></p>
          <p style="padding:0px;line-height:7px;font-weight: bold">Telfs: <span style="font-weight: 300">{{isset($userdesti) ? $userdesti->local_phone."/".$userdesti->celular:''}}</span></p>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="background-color: #21517a; color: white; margin-top: 0px; text-align: center; font-size: 20px; font-weight: bold; border: 2px solid rgb(102, 102, 102);">
        {{trans('messages.aplicatecharges')}}
        </td>
      </tr>
      <tr>
        <td colspan="2" style="margin-top: 0px; text-align: right; border: 2px solid rgb(102, 102, 102);">
          <div style="width: 100%">
            <table style="width: 100%">
              <tbody>
                <tr style="font-weight: bold; text-align: right">
                  <td>{{trans('messages.type')}}</td>
                  <td>{{trans('messages.value')}}</td>
                </tr>
                @foreach($aplicate_charges as $key => $value)
                <tr style="text-align: right">
                  <!--Tipo de Atributo-->
                  <td>
                    @if($value->type_attribute == "I")
                    {{trans('messages.tax')}}
                    @endif
                    @if($value->type_attribute == "S")
                    {{trans('messages.secure')}}
                    @endif
                    @if($value->type_attribute == "T")
                    {{trans('messages.transport')}}
                    @endif
                    @if($value->type_attribute == "A")
                    {{trans('messages.aditionalcarge')}}
                    @endif
                    @if($value->type_attribute == "P")
                    {{trans('messages.promotion')}}
                    @endif
                  </td>
                  <!--Costo del Cargo-->
                  <td>
                  {{$value->type_attribute == "P" ? '-' : '+' }}    {{$value->value_oring}} $
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </td>
      </tr>
    </table>
    <table style="width: 100%; border: 2px solid rgb(102, 102, 102); border-collapse: collapse;">
      <tr style="background-color: #21517a; color: white;">
        <th style="border: 1px solid grey;">Cantidad</th>
        <th style="border: 1px solid grey;">Dimensiones</th>
        <th style="border: 1px solid grey;">Descripción</th>
        <th style="border: 1px solid grey;">Peso</th>
        <th style="border: 1px solid grey;">Volumen</th>
      </tr>
      @foreach ($detailspackage as $row)
      <tr style="border: 1px solid grey;">
        <td style="border: 1px solid grey;text-align: center;"> {{$row->pieces}}</td>
        <td style="border: 1px solid grey;text-align: center;"> {{$row->large}}x{{$row->width}}x{{$row->height}}</td>
        <td style="border: 1px solid grey;text-align: center;"> {{$row->description}}</td>
        <td style="border: 1px solid grey;text-align: center;"> {{$row->weight}} lb</td>
        <td style="border: 1px solid grey;text-align: center;">
          @if($row->getPackage->type == \App\Helpers\HConstants::TRANSPORT_MARITHIME)
            {{$row->volumetricweightm}}
            ft<sup> 3</sup>
          @elseif($row->getPackage->type == \App\Helpers\HConstants::TRANSPORT_AERIAL)
            {{$row->volumetricweighta}}
            vlb
          @else
            {{trans('messages.unknown')}}
          @endif
        </td>
      </tr>
       @endforeach
    </table>
    <!---->
    <table style="width: 100%; border: 2px solid rgb(102, 102, 102); border-collapse: collapse;">
      <tr style="background-color: #21517a; color: white;">
        <th style="border: 1px solid grey;text-align: left;">Nota:</th>
      </tr>
      <tr style="border: 1px solid grey;">
         <td style="border: 1px solid grey;text-align: justify; padding: 5px">Nota:
          <p>
            {{$package->observation}}
          </p>
        </td>
      </tr>
    </table>
    <!---->
    <table style="width: 100%; border: 2px solid rgb(102, 102, 102); border-collapse: collapse;">
      <tr style="background-color: #21517a; color: white;">
        <th style="border: 1px solid grey;text-align: left;">Firmado por:</th>
        <th style="border: 1px solid grey;">Piezas</th>
        <th style="border: 1px solid grey;">Peso</th>
        <th style="border: 1px solid grey;">Volumen</th>
      </tr>
      <tr style="border: 1px solid grey;">
        <td style="border: 1px solid grey;text-align: center;height:40px"> ________________________________________</td>
        <td style="border: 1px solid grey;text-align: center;"> {{$resultpackpieces}}</td>
        <td style="border: 1px solid grey;text-align: center;"> {{$resultpackweight}} lb</td>
        <td style="border: 1px solid grey;text-align: center;">
          @if($row->getPackage->type == \App\Helpers\HConstants::TRANSPORT_MARITHIME)
            {{$row->volumetricweightm}}
            ft<sup> 3</sup>
          @elseif($row->getPackage->type == \App\Helpers\HConstants::TRANSPORT_AERIAL)
            {{$row->volumetricweighta}}
            vlb
          @else
            {{trans('messages.unknown')}}
          @endif
        </td>
      </tr>
    </table>
    <!--Se define el pie de pagina-->
    <div class="pdfFooter">
      <p>
        {{isset($configuration) ? ($configuration->footer_receipt == '') ? trans('configuration.nofooter') : $configuration->footer_receipt : trans('configuration.nofooter') }}
      </p>
    </div>
  </body>
</html>
