<?php
  use App\Helpers\HAccess;
  use App\Helpers\HUserType;
  use App\Models\Model\Security\Access;
  use App\Models\Model\Security\Profile;
  use App\Models\Model\Security\Role;

  /**
  * Se muestra el menu resumido si se trata de un revendedor, (cambiar por compañia)
  */
  $accesosresult=array();
  if(Session::get('key-sesion')['type'] == HUserType::RESELLER)
  {
    $items =
    [
      ['id' => '000', 'parent' =>  null, 'text' => trans('menu.admin')  , 'icon' => 'fa-cogs'],
      ['id' => '001', 'parent' => '000', 'text' => trans('menu.clients') , 'icon' => 'fa-users' , 'url' => asset('admin/clients') , 'accesss' => []]
    ];
  }
  /**
  * Se muestra el menu completo si es un administrador
  */
  else if(Session::get('key-sesion')['type'] == HUserType::OPERATOR)
  {
    $idprofile = Session::get('key-sesion')['data']->profile;
    $idrole    = DB::table('profile_role')->where('profile','=',$idprofile)->get();
    $array = json_decode(json_encode($idrole), True);
    foreach($array as $result) {
     $accesos = DB::table('role_access')->where('role','=',$result['role'])->get();
       $array = json_decode(json_encode($accesos), True);
        foreach($array as $result) {
           array_push($accesosresult,$result['access']);
        }
    }

    $items = [
      ['id' => '100', 'parent' =>  null, 'text' => trans('menu.dashboard'), 'icon' => 'fa-home', 'url' => asset('/'), 'accesss' => HAccess::$ADMINISTRACION_DE_DASBOARD],
      ['id' => '000', 'parent' =>  null, 'text' => trans('menu.wr'), 'icon' => 'fa-cube', 'accesss' => HAccess::$ADMINISTRACION_DE_PAQUETES],
      ['id' => '103', 'parent' => '000', 'text' => trans('menu.pickup'), 'icon' => 'fa-truck', 'url' => asset('admin/pickup'), 'accesss' => ''],
      ['id' => '126', 'parent' => '000', 'text' => trans('menu.tpickup'), 'icon' => 'fa-archive', 'url' => asset('admin/tpickup'), 'accesss' => ''],
      ['id' => '008', 'parent' =>  null, 'text' => trans('menu.billing'), 'icon' => 'fa-file-text', 'accesss' => HAccess::$ADMINISTRACION_DE_FACTURACION],
      ['id' => '009', 'parent' => '008', 'text' => trans('menu.sended'), 'icon' => 'fa-list', 'url' => asset('admin/receipt'), 'accesss' => ''],
      ['id' => '023', 'parent' => '008', 'text' => trans('menu.addcharges'), 'icon' => 'fa-tag', 'url' => asset('admin/addcharge'), 'accesss' => ''],
      ['id' => '035', 'parent' =>  null, 'text' => trans('menu.suppliers'), 'icon' => 'fa-asterisk', 'accesss' => HAccess::$ADMINISTRACION_DE_PROVEEDORES],
      ['id' => '036', 'parent' => '035', 'text' => trans('menu.new'), 'icon' => 'fa-plus', 'url' => asset('admin/suppliers/new'), 'accesss' => ''],
      ['id' => '037', 'parent' => '035', 'text' => trans('menu.list'), 'icon' => 'fa-list', 'url' => asset('admin/suppliers'), 'accesss' => ''],
      ['id' => '038', 'parent' =>  null, 'text' => trans('menu.transport'), 'icon' => 'fa-bus', 'accesss' => HAccess::$ADMINISTRACION_DE_TRANSPORTE],
      ['id' => '021', 'parent' => '038', 'text' => trans('menu.transporters'), 'icon' => 'fa-paper-plane-o' , 'url' => asset('admin/transporters'), 'accesss' => ''],
      ['id' => '200', 'parent' =>  null, 'text' => trans('menu.members'), 'icon' => 'fa-user', 'accesss' => HAccess::$ADMINISTRACION_DE_MEMBRESIA],
      ['id' => '202', 'parent' => '200', 'text' => trans('menu.users'), 'icon' => 'fa-users', 'url' => asset('admin/users'), 'accesss' => ''],
      ['id' => '204', 'parent' => '200', 'text' => trans('menu.operators'), 'icon' => 'fa-rocket', 'url' => asset('admin/operators'), 'accesss' => ''],
      ['id' => '016', 'parent' =>  null, 'text' => trans('menu.options'), 'icon' => 'fa-cogs', 'accesss' => HAccess::$ADMINISTRACION_DE_GENERAL],
      ['id' => '018', 'parent' => '016', 'text' => trans('menu.countries'), 'icon' => 'fa-globe', 'url' => asset('admin/country'), 'accesss' => ''],
      ['id' => '291', 'parent' => '016', 'text' => trans('menu.state'), 'icon' => 'fa-flag', 'url' => asset('admin/state'), 'accesss' => ''],
      ['id' => '091', 'parent' => '016', 'text' => trans('menu.cities'), 'icon' => 'fa-map-marker'    , 'url' => asset('admin/cities'), 'accesss' => ''],
      ['id' => '025', 'parent' => '016', 'text' => trans('menu.adjustments'), 'icon' => 'fa-cog', 'url' => asset('admin/configuration'), 'accesss' => ''],
      ['id' => '300', 'parent' =>  null, 'text' => trans('menu.accessibility'), 'icon' => 'fa-shield', 'accesss' => HAccess::$ADMINISTRACION_DE_SEGURIDAD],
      ['id' => '027', 'parent' => '300', 'text' => trans('menu.access'), 'icon' => 'fa-eye-slash', 'url' => asset('/admin/security/access'), 'accesss' => ''],
      ['id' => '028', 'parent' => '300', 'text' => trans('menu.roles'), 'icon' => 'fa-dot-circle-o', 'url' => asset('/admin/security/role'), 'accesss' => ''],
      ['id' => '029', 'parent' => '300', 'text' => trans('menu.profile'), 'icon' => 'fa-building', 'url' => asset('/admin/security/profile'), 'accesss' => ''],
      ['id' => '034', 'parent' =>  null, 'text' => trans('menu.reports'), 'icon' => 'fa-bar-chart', 'url' => asset('admin/billing'), 'accesss' => HAccess::$ADMINISTRACION_DE_REPORTES],
    ];
  }else {
    return view('pages.user.send_message', []);
  }
$tree = [];
  foreach ($items as &$item)
  {
    $tree[$item['id']]['node'] = $item;
    if(isset($item['parent']) && !is_null($item['parent']))
    {
      if(!isset($tree[$item['parent']])) {
        $tree[$item['parent']]  = [];
      }
      $tree[$item['parent']]['children'][] = &$tree[$item['id']];
    }
  }
  $tree = array_filter($tree, function($node) {
    return !isset($node['node']['parent']) || is_null($node['node']['parent']);
  });
  function filterItems($tree) {
    return $tree;
  }

  function existaccess($value,$acces) {
    if(in_array($acces, $value)){
        return true;
    }else{
        return false;
    }
  }
?>
<div class="navbar-default sidebar" role="navigation">
  <div id="menu" class="sidebar-nav navbar-collapse">
    <ul class="nav" id="side-menu">
      <?php $i=4; ?>
      @foreach(filterItems($tree) as $key => $item)
       @if(existaccess($accesosresult,$item['node']['accesss']))
        @if(!isset($item['node']['url']))
          @if(isset($item['children']) && count($item['children']) > 0)
            <li id="{{'step'.$i}}">
              <a id="item" href="#" class=""><i class="fa {{$item['node']['icon']}} fa-fw"></i> {{$item['node']['text']}} <span class="fa arrow"></span></a>
              <ul class="nav nav-second-level">
                @foreach($item['children'] as $subitem)
                    <li><a id="subitem" href="{{$subitem['node']['url']}}"><i class="fa {{$subitem['node']['icon']}} fa-fw"></i> {{$subitem['node']['text']}}</a></li>
                @endforeach
              </ul>
            </li>
          @endif
        @else
          <li><a id="{{'step'.$i}}" href="{{$item['node']['url']}}"><i class="fa {{$item['node']['icon']}} fa-fw"></i> {{$item['node']['text']}}</a></li>
        @endif
      @endif
      <?php $i++; ?>
      @endforeach
    </ul>
  </div>
</div>
