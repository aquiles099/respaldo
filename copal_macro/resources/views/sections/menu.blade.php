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
    /**
    * Se oculta modulo 'orden de recorrida', el listado y la opcion 'crear' estaran disponble desde 'almacen'
    */
    /*['id' => '035', 'parent' =>  null, 'text' => trans('menu.pickup')          , 'icon' => 'fa-truck'         , 'accesss' => HAccess::$ADMINISTRACION_DE_PICKUP_ODERS]          ,
    ['id' => '036', 'parent' => '035', 'text' => trans('menu.new')             , 'icon' => 'fa-plus'          , 'url' => asset('admin/pickup/new')                              , 'accesss' => ''],
    ['id' => '037', 'parent' => '035', 'text' => trans('menu.sended')          , 'icon' => 'fa-list'          , 'url' => asset('admin/pickup')                                  , 'accesss' => ''],*/
    /**
    * Se oculta modulo 'liberacion de carga', el listado y la opcion 'crear' estaran disponble desde 'almacen'
    */
    /*['id' => '041', 'parent' =>  null, 'text' => trans('menu.cargorelease')    , 'icon' => 'fa-th-large'      , 'accesss' => HAccess::$ADMINISTRACION_DE_CARGO_RELEASE]         ,
    ['id' => '042', 'parent' => '041', 'text' => trans('menu.new')             , 'icon' => 'fa-plus'          , 'url' => asset('admin/cargoRelease/1/new')                        , 'accesss' => ''],
    ['id' => '043', 'parent' => '041', 'text' => trans('menu.sended')          , 'icon' => 'fa-list'          , 'url' => asset('admin/cargoRelease')                            , 'accesss' => ''],
    */
    $items =
    [
      ['id' => '100', 'parent' =>  null, 'text' => trans('menu.dashboard')       , 'icon' => 'fa-home'          , 'url' => asset('/')                                             , 'accesss' => HAccess::$ADMINISTRACION_DE_DASBOARD],
      ['id' => '000', 'parent' =>  null, 'text' => trans('menu.wr')              , 'icon' => 'fa-cube'          , 'accesss' => HAccess::$ADMINISTRACION_DE_PAQUETES]              ,
      /*['id' => '002', 'parent' => '000', 'text' => trans('menu.addwr')           , 'icon' => 'fa-plus'          , 'url' => asset('admin/packagecurriers/new')                     , 'accesss' => ''],*/
      /**
      * Almacen
      */
      ['id' => '003', 'parent' => '000', 'text' => trans('menu.sended')          , 'icon' => 'fa-list'          , 'url' => asset('admin/package')                                 , 'accesss' => ''],
      ['id' => '103', 'parent' => '000', 'text' => trans('menu.pickup')          , 'icon' => 'fa-truck'         , 'url' => asset('admin/pickup')                                  , 'accesss' => ''],
      ['id' => '203', 'parent' => '000', 'text' => trans('menu.cargorelease')    , 'icon' => 'fa-th-large'      , 'url' => asset('admin/cargoRelease')                            , 'accesss' => ''],
      ['id' => '126', 'parent' => '000', 'text' => trans('menu.tpickup')         , 'icon' => 'fa-archive'       , 'url' => asset('admin/tpickup')                                 , 'accesss' => ''],
      ['id' => '128', 'parent' => '000', 'text' => trans('menu.numberpart')      , 'icon' => 'fa-archive'       , 'url' => asset('admin/numberparts')                             , 'accesss' => ''],
      ['id' => '299', 'parent' => '000', 'text' => trans('menu.prealerts')       , 'icon' => 'fa-flag'          , 'url' => asset('admin/prealert')    , 'accesss' => ''],
      /**
      * Consolidados
      */
      /*['id' => '005', 'parent' =>  null, 'text' => trans('menu.consolidated')    , 'icon' => 'fa-cubes'         , 'accesss' => HAccess::$ADMINISTRACION_DE_CONSOLIDADOS]          ,
      ['id' => '006', 'parent' => '005', 'text' => trans('menu.add')             , 'icon' => 'fa-plus'          , 'url' => asset('admin/consolidated/new')                        , 'accesss' => ''],
      ['id' => '007', 'parent' => '005', 'text' => trans('menu.list')            , 'icon' => 'fa-list'          , 'url' => asset('admin/consolidated')                            , 'accesss' => ''],*/
      /*['id' => '038', 'parent' =>  null, 'text' => trans('menu.master')          , 'icon' => 'fa-bars'          , 'accesss' => HAccess::$ADMINISTRACION_DE_MASTER]                ,
      ['id' => '039', 'parent' => '038', 'text' => trans('menu.addmaster')       , 'icon' => 'fa-plus'          , 'url' => asset('admin/master/new')                               , 'accesss' => ''],
      ['id' => '040', 'parent' => '038', 'text' => trans('menu.listmaster')      , 'icon' => 'fa-list'          , 'url' => asset('master')                               , 'accesss' => ''],*/
      ['id' => '008', 'parent' =>  null, 'text' => trans('menu.billing')         , 'icon' => 'fa-file-text'     , 'accesss' => HAccess::$ADMINISTRACION_DE_FACTURACION]           ,
      ['id' => '009', 'parent' => '008', 'text' => trans('menu.sended')          , 'icon' => 'fa-list'          , 'url' => asset('admin/receipt')                                 , 'accesss' => ''],
      /*['id' => '011', 'parent' => '008', 'text' => trans('menu.taxes')           , 'icon' => 'fa-money'         , 'url' => asset('admin/tax')                                     , 'accesss' => ''],*/
      ['id' => '012', 'parent' => '008', 'text' => trans('menu.promotions')      , 'icon' => 'fa-star-o'        , 'url' => asset('admin/promotions')                              , 'accesss' => ''],
      ['id' => '023', 'parent' => '008', 'text' => trans('menu.addcharges')      , 'icon' => 'fa-tag'           , 'url' => asset('admin/addcharge')                               , 'accesss' => ''],
      /**
      * Bookings
      */
      ['id' => '013', 'parent' =>  null, 'text' => trans('menu.bookings')        , 'icon' => 'fa-calendar'   , 'accesss' => HAccess::$ADMINISTRACION_DE_BOOKINGS]                 ,
      ['id' => '014', 'parent' => '013', 'text' => trans('menu.new')             , 'icon' => 'fa-plus'          , 'url' => asset('admin/bookings/new')                            , 'accesss' => ''],
      ['id' => '015', 'parent' => '013', 'text' => trans('menu.list')            , 'icon' => 'fa-list'          , 'url' => asset('admin/bookings')                                , 'accesss' => ''],
      /**
      * Shipment
      */
      ['id' => '212', 'parent' =>  null, 'text' => trans('menu.shipments')       , 'icon' => 'fa-external-link' , 'accesss' => HAccess::$ADMINISTRACION_DE_EMBARQUES]             ,
      ['id' => '214', 'parent' => '212', 'text' => trans('menu.new')             , 'icon' => 'fa-plus'          , 'url' => asset('admin/shipments/new')                            , 'accesss' => ''],
      ['id' => '215', 'parent' => '212', 'text' => trans('menu.list')            , 'icon' => 'fa-list'          , 'url' => asset('admin/shipments')                                , 'accesss' => ''],
      /**
      * Proveedores
      */
      ['id' => '035', 'parent' =>  null, 'text' => trans('menu.suppliers')       , 'icon' => 'fa-asterisk' , 'accesss' => HAccess::$ADMINISTRACION_DE_PROVEEDORES]             ,
      ['id' => '036', 'parent' => '035', 'text' => trans('menu.new')             , 'icon' => 'fa-plus'          , 'url' => asset('admin/suppliers/new')                            , 'accesss' => ''],
      ['id' => '037', 'parent' => '035', 'text' => trans('menu.list')            , 'icon' => 'fa-list'          , 'url' => asset('admin/suppliers')                                , 'accesss' => ''],

      /**
      * Transportista transport
      */
      ['id' => '038', 'parent' =>  null, 'text' => trans('menu.transport')       , 'icon' => 'fa-bus' , 'accesss' => HAccess::$ADMINISTRACION_DE_TRANSPORTE]             ,
      ['id' => '040', 'parent' => '038', 'text' => trans('menu.list')            , 'icon' => 'fa-list'          , 'url' => asset('admin/transport')                                , 'accesss' => ''],
      ['id' => '041', 'parent' => '038', 'text' => trans('menu.routes')          , 'icon' => 'fa-road'          , 'url' => asset('admin/routes')                                  , 'accesss' => ''],
      ['id' => '021', 'parent' => '038', 'text' => trans('menu.transporters')    , 'icon' => 'fa-paper-plane-o' , 'url' => asset('admin/transporters')                               , 'accesss' => ''],
      ['id' => '121', 'parent' => '038', 'text' => trans('menu.transportType')   , 'icon' => 'fa-exchange'      , 'url' => asset('admin/typeTransports')                               , 'accesss' => ''],
      /**
      * Membresia
      */
      ['id' => '200', 'parent' =>  null, 'text' => trans('menu.members')         , 'icon' => 'fa-user' , 'accesss' => HAccess::$ADMINISTRACION_DE_MEMBRESIA]             ,
      ['id' => '201', 'parent' => '200', 'text' => trans('menu.companies')       , 'icon' => 'fa-briefcase'     , 'url' => asset('admin/company')                                 , 'accesss' => ''],
      ['id' => '202', 'parent' => '200', 'text' => trans('menu.users')           , 'icon' => 'fa-users'         , 'url' => asset('admin/users')                                   , 'accesss' => ''],
      ['id' => '204', 'parent' => '200', 'text' => trans('menu.operators')       , 'icon' => 'fa-rocket'        , 'url' => asset('admin/operators')                               , 'accesss' => ''],
      /**
      * General
      */
      ['id' => '016', 'parent' =>  null, 'text' => trans('menu.options')         , 'icon' => 'fa-cogs'          , 'accesss' => HAccess::$ADMINISTRACION_DE_GENERAL]               ,
      ['id' => '018', 'parent' => '016', 'text' => trans('menu.countries')       , 'icon' => 'fa-globe'         , 'url' => asset('admin/country')                                 , 'accesss' => ''],
      ['id' => '291', 'parent' => '016', 'text' => trans('menu.state')          , 'icon' => 'fa-flag'    , 'url' => asset('admin/state')                                  , 'accesss' => ''],
      ['id' => '091', 'parent' => '016', 'text' => trans('menu.cities')          , 'icon' => 'fa-map-marker'    , 'url' => asset('admin/cities')                                  , 'accesss' => ''],
      ['id' => '019', 'parent' => '016', 'text' => trans('menu.offices')         , 'icon' => 'fa-building'      , 'url' => asset('admin/office')                                  , 'accesss' => ''],
      /*['id' => '020', 'parent' => '016', 'text' => trans('menu.courier')         , 'icon' => 'fa-paper-plane-o' , 'url' => asset('admin/courier')                                 , 'accesss' => ''],*/
      ['id' => '042', 'parent' => '016', 'text' => trans('menu.vessels')         , 'icon' => 'fa-anchor'        , 'url' => asset('admin/vessels')                                 , 'accesss' => ''],
      ['id' => '022', 'parent' => '016', 'text' => trans('menu.services')        , 'icon' => 'fa-random'        , 'url' => asset('admin/service')                                 , 'accesss' => ''],
      /*['id' => '023', 'parent' => '016', 'text' => trans('menu.addcharges')      , 'icon' => 'fa-tag'           , 'url' => asset('admin/addcharge')                               , 'accesss' => ''],*/
      ['id' => '024', 'parent' => '016', 'text' => trans('menu.category')        , 'icon' => 'fa-table'         , 'url' => asset('admin/category')                                , 'accesss' => ''],
      ['id' => '025', 'parent' => '016', 'text' => trans('menu.adjustments')     , 'icon' => 'fa-cog'           , 'url' => asset('admin/configuration')                           , 'accesss' => ''],
      ['id' => '125', 'parent' => '016', 'text' => trans('menu.containers')      , 'icon' => 'fa-archive'       , 'url' => asset('admin/containers')                              , 'accesss' => ''],
      /**
      * Security
      */
      ['id' => '300', 'parent' =>  null, 'text' => trans('menu.accessibility')        , 'icon' => 'fa-shield'        , 'accesss' => HAccess::$ADMINISTRACION_DE_SEGURIDAD]             ,
      ['id' => '027', 'parent' => '300', 'text' => trans('menu.access')          , 'icon' => 'fa-eye-slash'     , 'url' => asset('/admin/security/access')                        , 'accesss' => ''],
      ['id' => '028', 'parent' => '300', 'text' => trans('menu.roles')           , 'icon' => 'fa-dot-circle-o'  , 'url' => asset('/admin/security/role')                          , 'accesss' => ''],
      ['id' => '029', 'parent' => '300', 'text' => trans('menu.profile')         , 'icon' => 'fa-building'      , 'url' => asset('/admin/security/profile')                       , 'accesss' => ''],
      /**
      * ClientAttention
      */
      ['id' => '032', 'parent' =>  null, 'text' => trans('menu.clientAttention') , 'icon' => 'fa-phone'         , 'url' => asset('admin/clientAttention')                         , 'accesss' => HAccess::$ADMINISTRACION_DE_ATENCION_AL_CLIENTE],
      /**
      * Reports
      */
      ['id' => '034', 'parent' =>  null, 'text' => trans('menu.reports')         , 'icon' => 'fa-bar-chart'     , 'url' => asset('admin/billing')                                 , 'accesss' => HAccess::$ADMINISTRACION_DE_REPORTES],

    ];
  }
  /*
  ['id' => '014', 'parent' => '013', 'text' => trans('menu.packages')        , 'icon' => 'fa-cube'          , 'url' => asset('admin/billingpackage')      , 'accesss' => ''],
  ['id' => '015', 'parent' => '013', 'text' => trans('menu.consolidated')    , 'icon' => 'fa-cubes'         , 'url' => asset('admin/billingconsolidated') , 'accesss' => ''],*/
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
