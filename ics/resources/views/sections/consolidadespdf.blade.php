<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Reportes de Consolidades</title>
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
        {{trans('consolidated.consolidated')}}
    </div>
      <!--Datos informativos del paquete-->

    <!--Tabla con registros listados-->
    <br>
    <table class = "pdfTable">
      <thead>
        <tr>
          <th >{{trans('messages.id')}}</th>
          <th >{{trans('consolidated.code')}}</th>
          <th >{{trans('messages.tracking')}}</th>
          <th >{{trans('messages.description')}}</th>
          <th >{{trans('consolidated.status')}}</th>
          <th >{{trans('messages.date')}}</th>
        </tr>
      </thead>
      <tbody>
        @if(isset($consolidated))
          @foreach ($consolidated as $row)
            <tr>
              <td>{{$row->id}}</td>
              <td>{{$row->code}}</td>
              <td>{{$row->description}}</td>
              <td>{{$row->obervation}}</td>
              <td>{{$row->status}}</td>
              <td>{{$row->created_at}}</td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
      <!--Se define el pie de pagina-->
    <div class="pdfFooter">
      <p>
        {{isset($configuration) ? ($configuration->footerReceipt == '') ? trans('configuration.nofooter') : $configuration->footerReceipt : trans('configuration.noheader') }}
      </p>
    </div>
  </body>
</html>
