<!DOCTYPE html>
<html>
    <head>
        <title>{{trans('messages.noUrl')}}</title>
        <link rel="shortcut icon" type="image/png" href="{{asset('/uploads/logo/005.png')}}"/>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        <style>
            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
                color: #B0BEC5;
                font-weight: 100;
                font-family: 'Lato';
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
            }
        </style>
    </head>
    <body>
      <div class="" style="margin: 25%;">
        <div class="container">
          <p>
            <div class="content">
              <a href="{{asset('/')}}">
                <img src="{{asset('uploads/logo/005.png')}}" alt=""/>
              </a>
            </div>
          </p>
          <p>
            <div class="content">
                <div class="title">{{trans('messages.noUrl')}}</div>
            </div>
          </p>
          <p>
            <div class="content">
                <span><b>{{trans('messages.errorCode')}}: 404</b></span>
            </div>
          </p>
          <p>
            <div class="breadcrumb">
              <a href="{{asset('/')}}"><strong>{{trans('menu.dashboard')}}</strong></a> <b>/</b>
              <a href="{{asset('/admin/bookings')}}"><strong>{{trans('menu.bookings')}}</strong></a> <b>/</b>
              <a href="{{asset('/admin/package')}}"><strong>{{trans('menu.wr')}}</strong></a> <b>/</b>
              <a href="{{asset('/admin/pickup')}}"><strong>{{trans('menu.pickup')}}</strong></a> <b>/</b>
              <a href="{{asset('/admin/cargoRelease')}}"><strong>{{trans('menu.cargorelease')}}</strong></a>
            </div>
          </p>
        </div>
      </div>
      <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
      <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    </body>
</html>
