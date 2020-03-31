<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Reporte de Paquete</title>
    <link rel="stylesheet" href="{{asset('styles.css')}}" media="screen" title="no title" charset="utf-8">
  </head>
  <body class="pdfBody">
    <!--Se define la cabecera del pdf, contiene logo e informacion de la empresa-->
    <header class = "pdfHeader">
      <table>
        <tr>
          <td>
            <img src="{{asset('/dist/images/logoazul.jpg')}}" alt="logo" />
          </td>
          <td>
            <p>
              "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
              ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
              laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
              voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
              non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
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
        <td>{{isset($package) ? (isset($package->from_client) ? $package->getClient['name'] : $package->getCourier['name']) : ''}}</td>
      </tr>
      <tr>
        <td><b>{{trans('package.package')}}:</b></td>
        <td>{{isset($package) ? (isset($package->to_client) ? $package->getToClient['name'] : $package->getToUser['name']) : ''}}</td>
      </tr>
      <tr>
        <td><b>{{trans('messages.date')}}:</b></td>
        <td>{{isset($date)? $date :''}}</td>
      </tr>
    </table>
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
        @if(isset($packageLog))
          @foreach ($packageLog as $row)
            <tr>
              <td>{{$row->id}}</td>
              <td>{{$package->code}}</td>
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
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
         aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
         dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
         deserunt mollit anim id est laborum."
      </p>
    </div>
  </body>
</html>
