@include('sections.header')
<?php
use App\Models\Admin\Configuration;
use App\Helpers\HUserType;
    /**
    * Se asigna logo al sistema
    */
    $logo = Configuration::all()->last();
    $configuration = Configuration::find(1);

    if ($configuration->time_zone == null) {
      $configuration->time_zone = 'America/Caracas (UTC-04:30)';
      $configuration->save();
    }
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);

      $lang = isset($configuration->language) ? $configuration->language : 'en';
      App::setLocale($lang);
      $usr = Session::get('key-sesion')['type'];
    /**
    *
    */
?>
<script type="text/javascript">
    var messages = {
      language : "{!!$lang!!}"
    };

    // setInterval( function (){
    //   var url      = asset('admin/configuration') +'/hour';
    //   $('a#step4').removeClass('active');
    //     $.ajax({
    //         url: url,
    //         type: 'GET',
    //         dataType: 'json',
    //         beforeSend: function ()
    //         {
    //
    //         },
    //         success: function (json)
    //         {
    //           if (json.message == 'true') {
    //               $('#timezone').html('{{trans("configuration.system_hour")}}'+json.time);
    //           }else {
    //             $('#timezone').html('');
    //           }
    //         }
    //       });
    // }, 1000 );
</script>
<!--
<div class="only" id="loaderPage">
  <center>
    <h1 style="margin-top: 25%; margin-bottom: 50%; color: #1c558c;">
      <i class="fa fa-circle-o-notch fa-spin"></i> Espere...
    </h1>
  </center>
</div>-->
<div id="wrapper" style="background-color:white; height:93%;">
  <nav id="navbar" class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{asset('/')}}">
        <img class = "headerlogo" src="{{isset($logo) ? ($logo->logo_ics == '') ? asset('/dist/images/logo.png') : $logo->logo_ics : asset('/dist/images/logo.png')}}"/>
      </a>
    </div>
    <div id="timezone" class="" value="" style="margin-top:2px;color:gray;padding-left:79%;height:0px;">
    </div>
    @if((!isset($user) || isset($toolbar)))
      <ul class="nav navbar-top-links navbar-right">
        @section('toolbar-custom-pre')
          @if(!is_null(Session::get('key-sesion')))
          <!---->
          <li id="step1">
            <a href="{{asset('/')}}" id ="drdusr"><i class="fa fa-home"></i> {{trans('messages.home')}}</a>
          </li>
            @if(!isset($user))
            @if(Session::get('key-sesion')['data']->user_type !=  HUserType::NATURAL_PERSON)
              <!---->
              <li id="step2">
                <a href="{{asset('/admin/configuration')}}" id ="drdusr"><i class="fa fa-cog"></i> {{strtoupper(trans('menu.adjustments'))}}</a>
              </li>
            @endif
            <!---->
              @include('sections.toolbar')
              <!-- <li style="cursor: pointer;"id="tuto">
                <i class="fa fa-info-circle"></i> Tutorial
              </li> -->
            @else
              @include('sections.toolbar.user')
            @endif
          @endif
        @show
        @yield('toolbar-custom-post')
      </ul>
    @endif
    @if(!isset($menu) && !isset($only))
      @include('sections.menu')
    @endif
  </nav>
  <div id="page-wrapper" class="{{isset($only) ? 'only' : ''}}">
    <div class="container-fluid {{isset($pageCSS) ? $pageCSS : ''}}">
      @yield('pre-title')
      @if(!isset($noTitle))
        <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header" style="text-align: right; color:#23527c">
                @yield('icon-title')
                @yield('title', 'Document Title') <!--<span id="rowLoad" style="font-size: 25px"><small><i class='fa fa-spin fa-spinner'></i> Cargando....</small></span>-->
                <div class="pull-left">@yield('title-actions')</div>
              </h1>
          </div>
        </div>
      @endif
      <div class="row" >
        <div class="col-lg-12">
          @section('body')
              Document body...
          @show
        </div>
      </div>
    </div>
  </div>
</div>
@include('sections.footer')
