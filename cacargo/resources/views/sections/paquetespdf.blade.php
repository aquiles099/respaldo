<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Reportes de Paquetes</title>
    <!-- Customize favicon-->
    <link rel="shortcut icon" type="image/png" href="{{asset('/uploads/logo/005.png')}}"/>
    <link rel="stylesheet" href="{{asset('styles.css')}}" media="screen" title="no title" charset="utf-8">
  </head>
  @include('sections.translate')

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
                {{isset($configuration) ? ($configuration->header_receipt == '') ? trans('configuration.noheader') : $configuration->header_receipt : trans('configuration.noheader') }}
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
    <table class="pdfTable">
      <thead>
        <tr>
          <th >{{trans('messages.id')}}</th>
          <th >{{trans('messages.package')}}</th>
          <th >{{trans('messages.user')}}</th>
          <th >{{trans('messages.event')}}</th>
          <th >{{trans('messages.service_order')}}</th>
          <th >{{trans('messages.dimensions')}}</th>
          <th >{{trans('messages.date')}}</th>
          <th >{{trans('messages.tracking')}}</th>
        </tr>
      </thead>
      <tbody>
        @if(isset($package))
          @foreach ($package as $row)
            <tr>
              <td>{{$row->id}}</td>
              <td>{{$row->code}}</td>
              <td>{{isset($row->getToUser->code) ? $row->getToUser->code : ''}} {{isset($row->getToUser->name) ? $row->getToUser->name : ''}}</td>
              <td>{{isset($row->getLastEvent->description) ? $row->getLastEvent->description : ''}}</td>
              <td>{{isset($row->order_service) ? $row->order_service : ''}}</td>
              <td>{{$row->width}}x{{$row->height}}x{{$row->large}}</td>
              <td>{{$row->start_at}}</td>
              <td>{{$row->tracking}}</td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
      <!--Se define el pie de pagina-->
    <div class="pdfFooter">
      <p>
          {{isset($configuration) ? ($configuration->footer_receipt == '') ? trans('configuration.nofooter') : $configuration->footer_receipt : trans('configuration.nofooter') }}
      </p>
    </div>
  </body>
</html>
