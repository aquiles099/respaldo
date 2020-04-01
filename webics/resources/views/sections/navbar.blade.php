<nav class="pull-right nav-collapse" >
  <ul id="menu-main" class="nav">
    <li>
      <a title="{{trans('menu.home')}}" href="{{asset('/')}}">
        @if(!is_null(Session::get('key-sesion')))
          <i class="fa fa-home fa-fw"></i>
        @endif
        {{trans('menu.home')}}
      </a>
    </li>
    @if(is_null(Session::get('key-sesion')))
      @include('toolbars.web')
    @else
      @include('toolbars.admin')
    @endif
  </ul>
</nav>
