@if(isset($user) && !is_null(Session::get('key-sesion')) && (Session::get('key-sesion')['type'] == \App\Helpers\HUserType::NATURAL_PERSON))

@endif
<li id="step4" class="dropdown" >
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="drdusr">
        <i class="fa fa-user fa-fw"></i>
        @if(!is_null(Session::get('key-sesion')) && (Session::get('key-sesion')['type'] == \App\Helpers\HUserType::NATURAL_PERSON))
         {{ strtoupper(Session::get('key-sesion')['data']->name) }} {{ strtoupper(Session::get('key-sesion')['data']->last_name) }} | <i class="fa fa-qrcode" aria-hidden="true"></i> {{ Session::get('key-sesion')['data']->code }}
        @else
         {{ Session::get('key-sesion')['data']->code }} {{ strtoupper(Session::get('key-sesion')['data']->username) }}
        @endif
        &nbsp;<i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-user" >
      <li class="dropdown-header">{{trans('messages.options')}}</li>
      <li class="divider"></li>
      @if(Session::get('key-sesion')['type'] == \App\Helpers\HUserType::NATURAL_PERSON)
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
