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
            <img src="{{isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg')}}" alt="logo" />
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
        {{trans('package.packages')}}
    </div>
      <!--Datos informativos del paquete-->

    <!--Tabla con registros listados-->
    <br>
    <table class = "pdfTable">
      <thead>
        <tr>
          <th >{{trans('messages.id')}}</th>
          <th >{{trans('messages.package')}}</th>
          <th >{{trans('messages.user')}}</th>
          <th >{{trans('messages.event')}}</th>
          <th >{{trans('messages.previousEvent')}}</th>
          <th >{{trans('messages.observation')}}</th>
          <th >{{trans('messages.date')}}</th>
        </tr>
      </thead>
      <tbody>
        @if(isset($package))
          @foreach ($package as $row)
            <tr>
              <td>{{$row->id}}</td>
              <td>{{$row->code}}</td>
              <td>{{$row->getUser['name']}}</td>
              <td>{{$row->getEvent['description']}}</td>
              <td>{{$row->getPreviousEvent['description']}}</td>
              <td>{{$row->observation}}</td>
              <td>{{$row->created_at}}</td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
      <!--Se define el pie de pagina-->
    <div class="pdfFooter">
      <p>
          {{isset($configuration) ? ($configuration->footerReceipt == '') ? trans('configuration.nofooter') : $configuration->footerReceipt : trans('configuration.nofooter') }}
      </p>
    </div>
  </body>
</html>
