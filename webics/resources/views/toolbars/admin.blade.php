<li>
  <a href="{{asset('admin/mails/new')}}"><i class="fa fa-envelope fa-fw"></i> {{trans('messages.email')}}</a>
</li>
<!-- Admin Item -->
<li class="dropdown" >
  <a class="dropdown-toggle" data-toggle="dropdown" href="#" id ="drdusr"><i class="fa fa-user"></i>
      @if(!is_null(Session::get('key-sesion')))
        {{ strtoupper(Session::get('key-sesion')['data']->name) }}
      @endif
    <i class="fa fa-caret-down"></i>
  </a>
  <ul class="dropdown-menu dropdown-user" id="icsadmindropdown">
    <!---->
    <li>
      <a href="{{asset('/logout')}}">
        <i class="fa fa-sign-out" aria-hidden="true"></i> {{trans('messages.logout')}}
      </a>
    </li>
    <!---->
    <li>
      <a href="{{asset('/change-password')}}">
        <i class="fa fa-lock fa-fw" aria-hidden="true"></i> {{trans('messages.changepass')}}
      </a>
    </li>
  </ul>
</li>
