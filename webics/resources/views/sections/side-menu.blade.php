<?php
  use App\Models\Admin\UserAccess;
  $accesses = UserAccess::byUser(Session::get('key-sesion')['data']->id)->get();
 ?>
 <div class="navbar-default sidebar" role="navigation" style="min-height: 883px">
   <div class="sidebar-nav navbar-collapse">
     <ul class="nav" id="side-menu">
       @foreach  ($accesses as $key => $value)
        <li>
          <a href="{{$value->getItem->path}}">
            <i class="{{$value->getItem->icon}}" aria-hidden="true"></i>
            {{$value->getItem->description}}
          </a>
        </li>
       @endforeach
     </ul>
   </div>
 </div>
