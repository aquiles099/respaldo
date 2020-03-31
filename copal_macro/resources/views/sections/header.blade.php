<!DOCTYPE html>
<html lang="es">
<head>
    <base href="{{asset('/')}}" target="_self">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('pageTitle', trans('ICS'))</title>
    <!-- Customize favicon-->
  <link rel="shortcut icon" type="image/png" href="{{isset($configuration_header) ? ($configuration_header->logo_ics == '') ? asset('/uploads/logo/005.png') : $configuration_header->logo_ics : asset('/uploads/logo/005.png')}}"/>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">


    <!-- jquery-editable-select -->
    <link href="{{asset('bower_components/jquery-editable-select/dist/jquery-editable-select.min.css')}}" rel="stylesheet">
    <!--Customize fonts-->
      <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <!-- select2 -->
    <link href="{{asset('js/select2/css/select2.css')}}" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="{{asset('bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('dist/css/sb-admin-2.css')}}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <!--Customize style-->
    <link href="{{asset('styles.css')}}" rel="stylesheet" type="text/css">
    <!--Customize pickList-->
    <link href="{{asset('libs/pickList/pickList.css')}}" rel="stylesheet" type="text/css">
    <!--Customize select 2-->
    <link href="{{asset('bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="https://rawgit.com/iamdanfox/anno.js/gh-pages/dist/anno.js" type="text/javascript"></script>
    <script src="https://rawgit.com/litera/jquery-scrollintoview/master/jquery.scrollintoview.js" type="text/javascript"></script>

    <link href="{{asset('bower_components/anno.js/anno.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('libs/jquery-ui.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('libs/jquery.min.js')}}"></script>
    <!--Custom datepicker-->
    <script src="{{asset('libs/bootstrap-datepicker.min.js')}}"></script>
    <!--Custom datatable-->
    <link href="{{asset('libs/dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--Custom datetimepicker-->
    <link href="{{asset('libs/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--Custom dropzone-->
    <link href="{{asset('bower_components/dropzone/dist/min/dropzone.min.css')}}" rel="stylesheet" type="text/css">

    <!--Custom charts-->
    <script src="{{asset('libs/loader.js')}}"></script>
    <!--Custom qr-->
    <script src={{asset('libs/qrcode.js')}}></script>

    <script src={{asset('libs/jspdf.min.js')}}></script>

    <script src="{{asset('libs/moment.min.js')}}"></script>
    <script src="{{asset('libs/bootstrap-datetimepicker.min.js')}}"></script>
    <!--custom timepicker-->
    <script>
    function asset(url) {
      return '{{asset('/')}}' + url;
    }
    </script>
    <script src="{{asset('dist/js/main.js')}}"></script>
    @if(isset($js) && is_array($js))
      @foreach($js as $script)
        <script src="{{asset($script)}}"></script>
      @endforeach
    @endif
</head>

<body>
