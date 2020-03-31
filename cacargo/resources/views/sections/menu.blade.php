<?php
  use App\Helpers\HAccess;
  use App\Helpers\HUserType;
  use App\Models\Model\Security\Access;
  use App\Models\Model\Security\Profile;
  use App\Models\Model\Security\Role;


  use App\Models\Admin\Configuration;

  $configuration = Configuration::find(1);
  $lang = $configuration->language;
  App::setLocale($lang);  /**
  * Se muestra el menu resumido si se trata de un revendedor, (cambiar por compañia)
  */
  $accesosresult=array();
  if(Session::get('key-sesion')['type'] == HUserType::RESELLER)
  {
    $items = [
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

    $items =
    [
      ['id' => '031', 'parent' =>  null, 'text' => trans('menu.dashboard') , 'icon' => 'fa-home'         , 'url' => asset('admin/dashboard')     , 'accesss' => HAccess::$ADMINISTRACION_DE_DASBOARD],
      /**
      * Paquetes
      */
      ['id' => '000', 'parent' =>  null, 'text' => trans('menu.packages')        , 'icon' => 'fa-cube','accesss' => HAccess::$ADMINISTRACION_DE_PAQUETES]         ,
      //['id' => '001', 'parent' => '000', 'text' => trans('menu.paquetespersonas'), 'icon' => 'fa-briefcase'     , 'url' => asset('admin/package/new')         , 'accesss' => HAccess::$ADMINISTRACION_DE_PAQUETES],
      ['id' => '002', 'parent' => '000', 'text' => trans('menu.paquetescurrier') , 'icon' => 'fa-plus'          , 'url' => asset('admin/packagecurriers/new') , 'accesss' => HAccess::$ADMINISTRACION_DE_PAQUETES],
      ['id' => '003', 'parent' => '000', 'text' => trans('menu.sended')          , 'icon' => 'fa-list'          , 'url' => asset('admin/packagelist')             , 'accesss' => ''],
      ['id' => '203', 'parent' => '000', 'text' => trans('menu.prealerts')       , 'icon' => 'fa-flag'          , 'url' => asset('admin/package/prealert')    , 'accesss' => ''],
      /**
      * Consolidados
      */
      //['id' => '005', 'parent' =>  null, 'text' => trans('menu.consolidated')    , 'icon' => 'fa-cubes','accesss' => HAccess::$ADMINISTRACION_DE_CONSOLIDADOS]        ,
      //['id' => '006', 'parent' => '005', 'text' => trans('menu.add')             , 'icon' => 'fa-plus'          , 'url' => asset('admin/consolidated/new')    , 'accesss' => ''],
      //['id' => '007', 'parent' => '005', 'text' => trans('menu.list')            , 'icon' => 'fa-list'          , 'url' => asset('admin/consolidated')        , 'accesss' => ''],
      /**
      * Facturacion
      */
      //['id' => '008', 'parent' =>  null, 'text' => trans('menu.billing')         , 'icon' => 'fa-file-text','accesss' => HAccess::$ADMINISTRACION_DE_FACTURACION]    ,
      //['id' => '009', 'parent' => '008', 'text' => trans('menu.sended')          , 'icon' => 'fa-list'          , 'url' => asset('admin/receipt/read')        , 'accesss' => ''],
      /*['id' => '011', 'parent' => '008', 'text' => trans('menu.taxes')           , 'icon' => 'fa-money'         , 'url' => asset('admin/tax')                 , 'accesss' => ''],*/
      //['id' => '012', 'parent' => '008', 'text' => trans('menu.promotions')      , 'icon' => 'fa-star-o'        , 'url' => asset('admin/promotions')          , 'accesss' => ''],
      //['id' => '0125', 'parent' => '008', 'text' => trans('menu.addcharges')      , 'icon' => 'fa-tag'           , 'url' => asset('admin/addcharge')                               , 'accesss' => ''],
      /**
      * Reportes
      */
      ['id' => '013', 'parent' =>  null, 'text' => trans('menu.reports')         , 'icon' => 'fa-bar-chart','accesss' => HAccess::$ADMINISTRACION_DE_REPORTES]    ,
      ['id' => '014', 'parent' => '013', 'text' => trans('menu.packages')        , 'icon' => 'fa-cube'          , 'url' => asset('admin/billingpackage')      , 'accesss' => ''],
      //['id' => '015', 'parent' => '013', 'text' => trans('menu.consolidated')    , 'icon' => 'fa-cubes'         , 'url' => asset('admin/billingconsolidated') , 'accesss' => ''],
      /**
      * General
      */
      ['id' => '016', 'parent' =>  null, 'text' => trans('menu.options')         , 'icon' => 'fa-cogs','accesss' => HAccess::$ADMINISTRACION_DE_GENERAL]         ,
      //['id' => '017', 'parent' => '016', 'text' => trans('menu.companies')       , 'icon' => 'fa-briefcase'     , 'url' => asset('admin/company')             , 'accesss' => ''],
      ['id' => '018', 'parent' => '016', 'text' => trans('menu.countries')       , 'icon' => 'fa-globe'         , 'url' => asset('admin/country')             , 'accesss' => ''],
      //['id' => '019', 'parent' => '016', 'text' => trans('menu.offices')         , 'icon' => 'fa-building'      , 'url' => asset('admin/office')              , 'accesss' =>''],
      ['id' => '020', 'parent' => '016', 'text' => trans('menu.courier')         , 'icon' => 'fa-paper-plane-o' , 'url' => asset('admin/courier')             , 'accesss'  => ''],
      ['id' => '021', 'parent' => '016', 'text' => trans('menu.services')        , 'icon' => 'fa-random'        , 'url' => asset('admin/service')             , 'accesss'  => ''],
      //['id' => '022', 'parent' => '016', 'text' => trans('menu.category')        , 'icon' => 'fa-table'         , 'url' => asset('admin/category')            , 'accesss' => ''],
      //['id' => '124', 'parent' => '016', 'text' => trans('menu.store')           , 'icon' => 'fa-shopping-cart'     , 'url' => asset('admin/store')               , 'accesss' => ''],
      ['id' => '023', 'parent' => '016', 'text' => trans('menu.adjustments')     , 'icon' => 'fa-cog'           , 'url' => asset('admin/configuration')       , 'accesss' => ''],
      ['id' => '121', 'parent' => '016', 'text' => trans('menu.transportType')   , 'icon' => 'fa-exchange'      , 'url' => asset('admin/typeTransports')                               , 'accesss' => ''],
      /**
      * Seguridad
      */
      ['id' => '024', 'parent' =>  null, 'text' => trans('menu.users') , 'icon' => 'fa-users'         , 'url' => asset('admin/users')    , 'accesss' => HAccess::$ADMINISTRACION_DE_DASBOARD],

    //['id' => '024', 'parent' =>  null, 'text' => trans('menu.security')        , 'icon' => 'fa-shield', 'accesss' => HAccess::$ADMINISTRACION_DE_SEGURIDAD]       ,
      //['id' => '025', 'parent' => '024', 'text' => trans('menu.access')          , 'icon' => 'fa-eye-slash'     , 'url' => asset('/admin/security/access')    , 'accesss' => ''],
      //['id' => '026', 'parent' => '024', 'text' => trans('menu.roles')           , 'icon' => 'fa-dot-circle-o'  , 'url' => asset('/admin/security/role')      , 'accesss' => ''],
      //['id' => '027', 'parent' => '024', 'text' => trans('menu.profile')         , 'icon' => 'fa-building'      , 'url' => asset('/admin/security/profile')   , 'accesss' => ''],
      //['id' => '028', 'parent' => '024', 'text' => trans('menu.users')           , 'icon' => 'fa-users'         , 'url' => asset('admin/users')               , 'accesss' => ''],
      //['id' => '029', 'parent' => '024', 'text' => trans('menu.operators')       , 'icon' => 'fa-rocket'        , 'url' => asset('admin/operators')           , 'accesss' => ''],
      //['id' => '030', 'parent' =>  null, 'text' => trans('menu.clientAttention') , 'icon' => 'fa-phone'         , 'url' => asset('admin/clientAttention')     , 'accesss' => HAccess::$ADMINISTRACION_DE_ATENCION_AL_CLIENTE]
    ];
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
                    <li><a id="subitem" href="{{$subitem['node']['url']}}"@if($subitem['node']['id'] == '14' || $subitem['node']['id'] == '15') target="_blank" @endif><i class="fa {{$subitem['node']['icon']}} fa-fw"></i> {{$subitem['node']['text']}}</a></li>
                @endforeach
              </ul>
            </li>
          @endif
        @else
          <li id="{{'step'.$i}}"><a href="{{$item['node']['url']}}"><i class="fa {{$item['node']['icon']}} fa-fw"></i> {{$item['node']['text']}}</a></li>
        @endif
      @endif
      <?php $i++; ?>
      @endforeach
    </ul>
  </div>
</div>
