<?php
use App\Models\Admin\User;
$user = User::find(Session::get('key-sesion')['data']->id);
 ?>
@if(isset($user) && !is_null(Session::get('key-sesion')) && (Session::get('key-sesion')['type'] == \App\Helpers\HUserType::NATURAL_PERSON))
<!--paquetes-->
  <li >
    <a href="{{asset('/account')}}" id="drdusr">
      <i class="fa fa-cubes"></i>
      {{strtoupper(trans('messages.packages'))}}
        @if((isset($packages) && $packages->count() > 0) || (isset($filter) && isset($packages) && $packages->count() > 0))
            <sup style="background-color:#ed9028;" class="badge">{{isset($packages_user)&&(($user->view==1)) ? $packages_user->count() : ($user->view!=1) ? $packages->count() : ''}}</sup>
            @if($user->view!=1)
              <?php
                  if ($user->view!=1) {
                    $user->view =1;
                    $user->save();
                  }
               ?>
            @endif
        @endif
    </a>
  </li>

  {{--
    <!--map direccion-->
     <li>
       <a href="{{asset('/account/address')}}" id ="drdusr"><i class="fa fa-map-marker" aria-hidden="true"></i> {{strtoupper(trans('messages.icsadress'))}}</a>
     </li>
    --}}
  <!--prealerta-->
  <li>
    <a href="{{asset('/account/prealert')}}" id ="drdusr"><i class="fa fa-flag"></i> {{strtoupper(trans('messages.prealert'))}}</a>
  </li>
  <!--notificaciones-->
  <li class="dropdown" >
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id ="drdusr"><i class="fa fa-bell"></i>
      {{strtoupper(trans('messages.notifications'))}}
      <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-user" >
      <li class="dropdown-header">{{trans('messages.options')}}</li>
      <li class="divider"></li>
      <li>
        <a href="{{asset('/account/notifications/settings')}}">
          <i class="fa fa-cog fa-fw" aria-hidden="true"></i> {{trans('messages.manage')}}
        </a>
      </li>
    </ul>
  </li>
@endif
<li  id="step4" class="dropdown" >
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="drdusr">
        <i class="fa fa-user fa-fw"></i>
        @if(!is_null(Session::get('key-sesion')) && (Session::get('key-sesion')['type'] == \App\Helpers\HUserType::NATURAL_PERSON))
         {{ strtoupper(Session::get('key-sesion')['data']->name) }} {{ strtoupper(Session::get('key-sesion')['data']->last_name) }} | <i class="fa fa-qrcode" aria-hidden="true"></i> {{ Session::get('key-sesion')['data']->code }}
        @else
        {{ Session::get('key-sesion')['data']->code }} {{ Session::get('key-sesion')['data']->username }}
        @endif
        &nbsp;<i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
      <li class="dropdown-header">{{trans('messages.options')}}</li>
      <li class="divider"></li>
      @if(isset($user) && !is_null(Session::get('key-sesion')) && (Session::get('key-sesion')['type'] == \App\Helpers\HUserType::NATURAL_PERSON))
      <!---->
        <li>
          <a href="{{asset('/account/user')}}">
            <i class="fa fa-user fa-fw" aria-hidden="true"></i> {{trans('messages.myAccount')}}
          </a>
        </li>
      <!---->
        <li>
          <a href="{{asset('/account/user/pass')}}">
            <i class="fa fa-lock" style="text-align:left" aria-hidden="true"></i> {{trans('messages.changepassword')}}
          </a>
        </li>
      @endif
      <li><a href="{{asset('/logout')}}"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i> {{trans('messages.logout')}}</a></li>
    </ul>
</li>
