<div class="row" @if(is_null(Session::get('key-sesion'))) style="margin-left: -15px; padding-bottom: 10px;" @endif>
  <div class="col-md-12">
    <div class="navbar-wrapper">
      <div class="navbar navbar-inverse navbar-fixed-top" style="background-color: #fff; border-color: #fff; border: 0px solid #fff!important">
        <div class="navbar-inner" style="border-color: #fff;border: 0px solid #fff;">
          <div class="row" style="margin-bottom: 0px;">
            <!--Logo-->
            <div class="col-md-3 icsheader3c">
              <a href="{{asset('/')}}">
                <img src="{{asset('dist/img/logo.png')}}" style="margin-left:5px; height: 100px;" alt="{{trans('messages.ICS')}}">
              </a>
            </div>
            <!--Section triangle-->
            <div class="col-md-2" style="padding-left: 0px;" >
              <div class="triangulo_top_left"></div>
            </div>
            <!--List-->
            <div class="col-md-7">
              <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
              </a>
              @include('sections.navbar')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
