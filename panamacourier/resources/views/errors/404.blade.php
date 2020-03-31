@set('only')
<?php
use App\Helpers\HUserType;
  if (Session::get('key-sesion')['type'] == HUserType::OPERATOR) {
    unset($only);
  }
?>
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
          <div class="content">
            <a href="{{asset('/')}}">
              <img src="{{isset($logo) ? ($logo->logo_ics == '') ? asset('/dist/images/logo.jpg') : $logo->logo_ics : asset('/dist/images/logo.jpg')}}" alt=""/>
            </a>
          </div>
          <div class="content">
              <div class="title">{{trans('messages.noUrl')}}</div>
          </div>
          <div class="content">
              <span><b>{{trans('messages.errorCode')}}: 404</b></span>
          </div>
          @if(Session::get('key-sesion')['type'] == HUserType::NATURAL_PERSON)
          <div class="breadcrumb">
            <a href="{{asset('/account/prealert')}}">
              <strong>{{trans('menu.pickup')}}</strong>
            </a>
            <b>/</b>
            <a href="{{asset('/account/user')}}">
              <strong>{{trans('messages.myAccount')}}</strong>
            </a> <b>/</b>
            <a href="{{asset('/account/user/pass')}}">
              <strong>{{trans('messages.changepassword')}}</strong>
            </a> <b>/</b>
            <a href="{{asset('/logout')}}">
              <strong>{{trans('messages.logout')}}</strong>
            </a>
          </div>
          @else
          <div class="breadcrumb">
            <a href="{{asset('/admin/pickup')}}">
              <strong>
                {{trans('menu.pickup')}}
              </strong>
            </a>
            <b>/</b>
            <a href="{{asset('/admin/cities')}}">
              <strong>
                {{trans('menu.cities')}}
              </strong>
            </a>
            <b>/</b>
            <a href="{{asset('/admin/receipt')}}">
              <strong>
                {{trans('menu.billing')}}
              </strong>
            </a>
            <b>/</b>
            <a href="{{asset('/admin/country')}}">
              <strong>
                {{trans('menu.reports')}}
              </strong>
            </a>
          </div>
          @endif
        </div>
      </div>
      <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
      <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    </body>
</html>
