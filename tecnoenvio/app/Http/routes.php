<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
$router->pattern('email' , '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$');
$router->pattern('id'       , '[0-9]+');
$router->pattern('sw'       , '[0-9]+');
$router->pattern('company'  , '[0-9]+');
$router->pattern('date'     , '[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])');
$router->pattern('month'    , '[0-9]{4}-(0[1-9]|1[012])');

//Rutas para la API
Route::group(['prefix' => '/admin/api'], function () {
  Route::get('operator/{email}'     , 'Admin\OperatorController@changeOperator')->middleware('cors');
});

//Rutas para el manejo de fallas
Route::group(['prefix' => '/admin/incidence'], function () {
    Route::get('new'     , 'Admin\IncidenceController@create');
    Route::post('new'     , 'Admin\IncidenceController@create');
});

// Rutas Generales ///////////////////////////////////////////////////////////////
Route::get('/'                            , 'MainController@index'           );
Route::get('/{sw}/day/{id}'               , 'MainController@dateSelect'      );
Route::get('/{sw}/date/{date}'            , 'MainController@dateSelect'      );
Route::get('/{sw}/month/{month}'          , 'MainController@dateSelect'      );
/**
*
*/
Route::get('/login'                       , 'LoginController@index'          );
Route::get('/login/load'                  , 'LoginController@loadData'       );
Route::get('/login/loadtest'              , 'LoginController@loadTest'       );
Route::post('/operator/statusoperator'    , 'Admin\OperatorController@statusOperator' );
Route::get('/login/terms'                 , 'LoginController@verifyTerms'    );

Route::post('/login'                      , 'LoginController@login'          );
Route::get('/logout'                      , 'LoginController@logout'         );
/**
*
*/
Route::get('/register'                    , 'LoginController@register'       );
Route::post('/register'                   , 'LoginController@doRegister'     );
/**
*
*/
Route::get('/recover-password'            , 'LoginController@recoverPassword');
Route::post('/recover-password'           , 'LoginController@recoverPassword')->middleware('block');
Route::get('/terms'                       , 'LoginController@terms'          );
Route::get('/help'                        , 'LoginController@help'           );
/**
*
*/
Route::get('check/account'                , 'LoginController@check'          );
Route::get('check/account/op'             , 'LoginController@checkOp'        );
/**
*
*/
Route::group(['prefix' => '/account'], function () {
  // paquetes y filtrado
  Route::get(''             , 'AccountController@index'        );
  Route::post(''            , 'AccountController@index'        )->middleware('block');
  // cuenta y detalles de usuario
  Route::get('{id}'         , 'AccountController@details'      );
  Route::get('user'         , 'AccountController@account'      );
  Route::patch('user'       , 'AccountController@account'      )->middleware('block');
  // cambiar contraseña
  Route::get('user/pass'    , 'AccountController@changepass'   );
  Route::patch('user/pass'  , 'AccountController@changepass'   )->middleware('block');
  // subir factura de paquete
  Route::get('upload/{id}'  , 'AccountController@upload'       );
  Route::post('upload/{id}' , 'AccountController@upload'       )->middleware('block');
  // ver y actualzar foto de perfil
  Route::post('user/loadfile'      , 'AccountController@loadFile'     )->middleware('block');
  Route::get('user/avatar'         , 'AccountController@avatar'       );
  Route::get('user/avatar/update'  , 'AccountController@avatarUpdate' );
  // ver direccion de usuario
  Route::get('address'  , 'AccountController@address'       );
  // gestion de prealertas
  Route::get('prealert'       , 'AccountController@prealertList'    );
  Route::post('prealert'      , 'AccountController@prealertList'    );
  Route::get('prealert/{id}'  , 'AccountController@prealertDetails' );
  Route::post('prealert/{id}' , 'AccountController@prealertDetails' );
  Route::patch('prealert/{id}', 'AccountController@prealertDetails' );
  Route::get('prealert/new'   , 'AccountController@prealertCreate'  );
  Route::post('prealert/new'  , 'AccountController@prealertCreate'  );
  Route::get('prealert/{id}/view'  , 'AccountController@prealertView' );
  //gestion de notificaciones
  Route::get('notifications/settings', 'AccountController@settingsNotification');
  Route::post('notifications/settings', 'AccountController@settingsNotification')->middleware('block');
});

// Administracion de usuarios //////////////////////////////////////////////////
Route::get('/admin/users',  'Admin\UserController@index');
Route::group(['prefix' => '/admin/user'], function () {
  Route::get('new'             , 'Admin\UserController@create'     );
  Route::post('new'            , 'Admin\UserController@create'     )->middleware('block');
  Route::get('{id}'            , 'Admin\UserController@details'    );
  Route::get('{id}/read'       , 'Admin\UserController@readDetails');
  Route::delete('{id}'         , 'Admin\UserController@delete'     )->middleware('block');
  Route::delete('{id}/delete'  , 'Admin\UserController@deleteAjax' )->middleware('block'); /** Test Path **/
  Route::patch('{id}'          , 'Admin\UserController@details'    )->middleware('block');
  Route::get('/view'           , 'Admin\UserController@listAjax'   );
  Route::get('{id}/view'       , 'Admin\UserController@view'       );
  Route::patch('{id}/view'     , 'Admin\UserController@view'       )->middleware('block'); /** Test Path **/
  Route::get('{id}/viewEdit'   , 'Admin\UserController@viewEdit'   ); /** Test Path **/
  Route::get('viewNew'         , 'Admin\UserController@viewNew'    ); /** Test Path **/
  Route::post('viewNew'        , 'Admin\UserController@viewNew'    )->middleware('block'); /** Test Path **/
});

// Administracion de operadores/////////////////////////////////////////////////
Route::get('/admin/operators',  'Admin\OperatorController@index');
Route::group(['prefix' => '/admin/operator'], function () {
  Route::get('new'      , 'Admin\OperatorController@create');
  Route::post('new'     , 'Admin\OperatorController@create')->middleware('block');

  Route::get('{id}'     , 'Admin\OperatorController@details'    );
  Route::get('{id}/read', 'Admin\OperatorController@readDetails');
  Route::delete('{id}'  , 'Admin\OperatorController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\OperatorController@details'    )->middleware('block');
});
// Administracion de Compañias y sus cliente ////////////////////////////////////
Route::group(['prefix' => '/admin/company'], function () {
  Route::get(''         , 'Admin\CompanyController@index'      );
  Route::get('new'      , 'Admin\CompanyController@create'     );
  Route::get('{id}/edit', 'Admin\CompanyController@details'    );
  Route::get('{id}/read', 'Admin\CompanyController@readDetails');
  Route::post('new'     , 'Admin\CompanyController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\CompanyController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\CompanyController@details'    )->middleware('block');
  Route::put('{id}/save', 'Admin\CompanyController@edit'       )->middleware('block');
  /**********Rutas para la administarcion de clientes*********************/
  Route::get('{company}/clients'              , 'Admin\ClientController@index'         );
  Route::get('{company}/clients/new'          , 'Admin\ClientController@create'        );
  Route::get('{company}/clients/{id}/edit'    , 'Admin\ClientController@details'       );
  Route::get('{company}/clients/{id}/read'    , 'Admin\ClientController@readDetails'   );
  Route::post('{company}/clients/new'         , 'Admin\ClientController@create'        )->middleware('block');
  Route::delete('{company}/clients/{id}'      , 'Admin\ClientController@delete'        )->middleware('block');
  Route::patch('{company}/clients/{id}'       , 'Admin\ClientController@details'       )->middleware('block');
  Route::put('{company}/clients/{id}/save'    , 'Admin\ClientController@edit'          )->middleware('block');
});

/**
*Ruta de clientes dado una empresa en json
*/

////////////////////////////////////////////////////////////////////////////////
//Route::get('/admin/package/new/{id}/clients/json','Admin\ClientController@readjsonclient');
//Route::get('/admin/package/{id}/clients/json','Admin\ClientController@readjsonclient');
// Datos maestros //////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
// Administracion de paises ////////////////////////////////////////////////////
Route::group(['prefix' => '/admin/country'], function () {
  Route::get(''         , 'Admin\CountryController@index'      );
  Route::get('new'      , 'Admin\CountryController@create'     );
  Route::get('{id}/edit', 'Admin\CountryController@details'    );
  Route::get('{id}/read', 'Admin\CountryController@readDetails');
  Route::post('new'     , 'Admin\CountryController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\CountryController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\CountryController@details'    )->middleware('block');
  Route::put('{id}/save', 'Admin\CountryController@edit'       )->middleware('block');
});
// Administracion de oficinas / almacenes //////////////////////////////////////
Route::group(['prefix' => '/admin/office'], function () {
  Route::get(''         , 'Admin\OfficeController@index'      );
  Route::get('new'      , 'Admin\OfficeController@create'     );
  Route::get('{id}/edit', 'Admin\OfficeController@details'    );
  Route::get('{id}/read', 'Admin\OfficeController@readDetails');
  Route::post('new'     , 'Admin\OfficeController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\OfficeController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\OfficeController@details'    )->middleware('block');
  Route::put('{id}/save', 'Admin\OfficeController@edit'       )->middleware('block');
});
// Administracion de categorias de paquetes/////////////////////////////////////
Route::group(['prefix' => '/admin/category'], function () {
  Route::get(''             , 'Admin\CategoryController@index'      );
  Route::get('new'          , 'Admin\CategoryController@create'     );
  Route::get('{id}/edit'    , 'Admin\CategoryController@details'    );
  Route::get('{id}/read'    , 'Admin\CategoryController@readDetails');
  Route::post('new'         , 'Admin\CategoryController@create'     )->middleware('block');
  Route::delete('{id}'      , 'Admin\CategoryController@delete'     )->middleware('block');
  Route::patch('{id}'       , 'Admin\CategoryController@details'    )->middleware('block');
  Route::put('{id}/save'    , 'Admin\CategoryController@edit'       )->middleware('block');
});
// Administracion de consolidados para mostrar /////////////////////////////////////
Route::group(['prefix' => '/admin/consolidated/showconsolidated/'], function () {
  Route::get('{id}'     , 'Admin\ShowConsolidatedController@create'      );
  Route::post('{id}'     , 'Admin\ShowConsolidatedController@create'     )->middleware('block');
});
// Administracion de paquetes para mostrar /////////////////////////////////////
Route::group(['prefix' => '/admin/package/showpackage'], function () {
  Route::get('{id}'     , 'Admin\ShowPackageController@create'      );
  Route::post('{id}'     , 'Admin\ShowPackageController@create'     )->middleware('block');
});
// Administracion de impuestos /////////////////////////////////////////////////
Route::group(['prefix' => '/admin/tax'], function () {
  Route::get(''         , 'Admin\TaxController@index'      );
  Route::get('new'      , 'Admin\TaxController@create'     );
  Route::get('{id}'     , 'Admin\TaxController@details'    );
  Route::get('{id}/read', 'Admin\TaxController@readDetails');
  Route::post('new'     , 'Admin\TaxController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\TaxController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\TaxController@details'    )->middleware('block');
  Route::get('{id}/view', 'Admin\TaxController@view');
});
// Administracion de paquestes por ICS       ///////////////////////////////////////////////
Route::group(['prefix' => '/admin/package'], function () {
  Route::get(''            , 'Admin\PackageController@index'                );
  Route::get('new'         , 'Admin\PackageController@create'               );
  Route::get('{id}'        , 'Admin\PackageController@details'              );
  Route::get('{id}/read'   , 'Admin\PackageController@readDetails'          );
  Route::get('{id}/upload'     , 'Admin\PackageController@uploadile'           );
  Route::post('{id}/upload'    , 'Admin\PackageController@uploadile'           )->middleware('block');
  Route::get('{id}/print'  , 'Admin\PackageController@printer'              );
  Route::get('{id}/receipt', 'Admin\PackageController@detailsreceipt'       );
  Route::post('new'        , 'Admin\PackageController@create'               )->middleware('block');
  Route::delete('{id}'     , 'Admin\PackageController@delete'               )->middleware('block');
  Route::patch('{id}'      , 'Admin\PackageController@details'              )->middleware('block');
  Route::get('{id}/dash'   , 'Admin\PackageController@dashboarDetails'      );
  Route::get('new/{id}/clients/json','Admin\ClientController@readjsonclient');
  Route::get('new/{id}/typeservice/json','Admin\TransportTypeController@readjsonservice');
  Route::get('{id}/invoice', 'Admin\ReceiptController@invoicepackage'       );
  // gestion de prealertas
  Route::get('prealert'        , 'Admin\PackageController@prealertList'     );
  Route::get('prealert/{id}'   , 'AccountController@prealertDetails');
  Route::patch('prealert/{id}' , 'AccountController@prealertDetails')->middleware('block');
  Route::delete('prealert/{id}', 'Admin\PackageController@prealertDelete'   )->middleware('block');


});
// Administracion de paquestes por curriers /////////////////////////////////////////////////
Route::group(['prefix' => '/admin/packagecurriers'], function () {
  Route::get(''          , 'Admin\PackageController@index'            );
  Route::get('new'       , 'Admin\PackageController@createcurriers'   );
  Route::get('{id}'      , 'Admin\PackageController@detailscurriers'  );
  Route::get('{id}/read' , 'Admin\PackageController@readDetails'      );
  Route::get('{id}/print', 'Admin\PackageController@printer'          );
  Route::post('new'      , 'Admin\PackageController@createcurriers'   )->middleware('block');
  Route::delete('{id}'   , 'Admin\PackageController@delete'           )->middleware('block');
  Route::patch('{id}'    , 'Admin\PackageController@detailscurriers'  )->middleware('block');
  Route::get('new/verify', 'Admin\PackageController@verify'           );
  Route::get('new/{id}/typeservice/json','Admin\TransportTypeController@readjsonservice');
});
// Administacion de Promociones
Route::group(['prefix' => '/admin/promotions'], function () {
  Route::get(''         , 'Admin\PromotionController@index'      );
  Route::get('new'      , 'Admin\PromotionController@create'     );
  Route::get('{id}'     , 'Admin\PromotionController@details'    );
  Route::get('{id}/read', 'Admin\PromotionController@readDetails');
  Route::post('new'     , 'Admin\PromotionController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\PromotionController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\PromotionController@details'    )->middleware('block');
  Route::get('{id}/view', 'Admin\PromotionController@view'       );
});
// Administracion de consolidados /////////////////////////////////////////////////
Route::group(['prefix' => '/admin/consolidated'], function () {
  Route::get(''                    , 'Admin\ConsolidatedController@index'        );
  Route::get('new'                 , 'Admin\ConsolidatedController@create'       );
  Route::get('{id}'                , 'Admin\ConsolidatedController@details'      );
  Route::get('{id}/read'           , 'Admin\ConsolidatedController@readDetails'  );
  Route::post('new'                , 'Admin\ConsolidatedController@create'       )->middleware('block');
  Route::patch('addpackage/{id}'   , 'Admin\ConsolidatedController@addPackage'   )->middleware('block');
  Route::patch('deletepackage/{id}', 'Admin\ConsolidatedController@deletePackage')->middleware('block');
  Route::delete('{id}'             , 'Admin\ConsolidatedController@delete'       )->middleware('block');
  Route::patch('{id}'              , 'Admin\ConsolidatedController@details'      )->middleware('block');
});

// Administracion de couriers/////////////////////////////////////////////////
Route::group(['prefix' => '/admin/courier'], function () {
  Route::get(''         , 'Admin\CourierController@index'      );
  Route::get('new'      , 'Admin\CourierController@create'     );
  Route::get('{id}/edit', 'Admin\CourierController@details'    );
  Route::get('{id}/read', 'Admin\CourierController@readDetails');
  Route::post('new'     , 'Admin\CourierController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\CourierController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\CourierController@details'    )->middleware('block');
  Route::put('{id}/save', 'Admin\CourierController@edit'       )->middleware('block');
});
/**
* Tiendas
*/
Route::group(['prefix' => '/admin/store'], function () {
  Route::get(''         , 'Admin\StoreController@index'      );
  Route::get('new'      , 'Admin\StoreController@create'     );
  Route::get('{id}/edit', 'Admin\StoreController@details'    );
  Route::get('{id}/read', 'Admin\StoreController@readDetails');
  Route::post('new'     , 'Admin\StoreController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\StoreController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\StoreController@details'    )->middleware('block');
  Route::put('{id}/save', 'Admin\StoreController@details'       )->middleware('block');
});
// Administracion de servicios/////////////////////////////////////////////////
Route::group(['prefix' => '/admin/service'], function () {
    Route::get(''         , 'Admin\TransportController@index'      );
    Route::get('new'      , 'Admin\TransportController@create'     );
    Route::get('{id}/edit', 'Admin\TransportController@details'    );
    Route::get('{id}/read', 'Admin\TransportController@readDetails');
    Route::post('new'     , 'Admin\TransportController@create'     )->middleware('block');
    Route::delete('{id}'  , 'Admin\TransportController@delete'     )->middleware('block');
    Route::patch('{id}'   , 'Admin\TransportController@details'    )->middleware('block');
    Route::put('{id}/save', 'Admin\TransportController@edit'       )->middleware('block');
});

/**
*
*/
Route::group(['prefix' => '/admin/typeTransports'], function () {
  Route::get(''                 , 'Admin\TransportTypeController@index'          );
  Route::get('new'              , 'Admin\TransportTypeController@create'         );
  Route::post('new'             , 'Admin\TransportTypeController@create'         )->middleware('block');
  Route::get('{id}/read'        , 'Admin\TransportTypeController@readDetails'    );
  Route::delete('{id}'          , 'Admin\TransportTypeController@delete'         )->middleware('block');
  Route::get('{id}/edit'        , 'Admin\TransportTypeController@details'        );
  Route::put('{id}/save'        , 'Admin\TransportTypeController@details'        )->middleware('block');
  Route::delete('{id}'          , 'Admin\TransportTypeController@delete'         )->middleware('block');
});

/**
* Aditional Charges
*/
Route::group(['prefix' => '/admin/addcharge'], function () {
  Route::get(''         , 'Admin\AddChargesController@index'      );
  Route::get('new'      , 'Admin\AddChargesController@create'     );
  Route::get('{id}'     , 'Admin\AddChargesController@details'    );
  Route::get('{id}/read', 'Admin\AddChargesController@readDetails');
  Route::post('new'     , 'Admin\AddChargesController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\AddChargesController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\AddChargesController@details'    )->middleware('block');
  Route::put('{id}/save', 'Admin\AddChargesController@edit'       )->middleware('block');
});


// Administracion de detalle de servicio/////////////////////////////////////////
Route::group(['prefix' => '/admin/service/details'], function () {
  Route::get('new'        , 'Admin\DetailsTransportController@create'     );

});


// Administracion de Recibos/////////////////////////////////////////////////
Route::group(['prefix' => '/admin/receipt'], function () {
    Route::get(''         , 'Admin\ReceiptController@index'      );
    Route::get('new'      , 'Admin\ReceiptController@create'     );
    Route::get('{id}'     , 'Admin\ReceiptController@details'    );
    Route::get('read'     , 'Admin\ReceiptController@read'       );
    Route::get('{id}/read', 'Admin\ReceiptController@readDetails');
    Route::post('new'     , 'Admin\ReceiptController@create'     )->middleware('block');
    Route::delete('{id}'  , 'Admin\ReceiptController@delete'     )->middleware('block');
    Route::patch('{id}'   , 'Admin\ReceiptController@details'    )->middleware('block');
    Route::get('{id}/view', 'Admin\ReceiptController@view'       );
    Route::get('{id}/invoice', 'Admin\ReceiptController@invoicepackage'       );
});

// Administracion detalle de Recibos/////////////////////////////////////////////////
Route::group(['prefix' => '/admin/detailsreceipt'], function () {
    Route::get(''         , 'Admin\DetailsReceiptController@index'      );
    Route::get('new'      , 'Admin\DetailsReceiptController@create'     );
    Route::get('{id}'     , 'Admin\DetailsReceiptController@details'    );
    Route::get('{id}/read', 'Admin\DetailsReceiptController@readDetails');
    Route::post('new'     , 'Admin\DetailsReceiptController@create'     )->middleware('block');
    Route::delete('{id}'  , 'Admin\DetailsReceiptController@delete'     )->middleware('block');
    Route::patch('{id}'   , 'Admin\DetailsReceiptController@details'    )->middleware('block');
    Route::get('{id}/view', 'Admin\DetailsReceiptController@view'       );
});

// Rutas para Atencion al cliente
Route::group(['prefix' => '/admin/clientAttention'],function () {
  Route::get(''          , 'Admin\ClientAttentionController@index'           );
  Route::get('packages'  , 'Admin\ClientAttentionController@searchPackages'  );
  Route::get('users'     , 'Admin\ClientAttentionController@searchUsers'     );
  Route::get('promotions', 'Admin\ClientAttentionController@searchPromotions');
  Route::get('taxes'     , 'Admin\ClientAttentionController@searchTaxes'     );
  Route::get('services'  , 'Admin\ClientAttentionController@searchServices'  );
  Route::get('categories', 'Admin\ClientAttentionController@searchCategories');
  Route::get('companies' , 'Admin\ClientAttentionController@searchCompanies');
});

//Rutas para ajustes
Route::group(['prefix' => 'admin/configuration'],function () {
  Route::get('hour'      , 'Admin\ConfigurationController@serverTime' );
  Route::get('items'      , 'Admin\ConfigurationController@items' );
  Route::get(''    , 'Admin\ConfigurationController@index' );
  Route::patch(''  , 'Admin\ConfigurationController@index')->middleware('block');
});

////////////////////////////////////////////////////////////////////////////////
// Seguridad ///////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
// Administracion de accesos ///////////////////////////////////////////////////
Route::group(['prefix' => '/admin/security/access'], function () {
  Route::get(''         , 'Admin\Security\AccessController@index'      );
  Route::get('new'      , 'Admin\Security\AccessController@create'     );
  Route::get('{id}'     , 'Admin\Security\AccessController@details'    );
  Route::get('{id}/read', 'Admin\Security\AccessController@readDetails');
  Route::post('new'     , 'Admin\Security\AccessController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\Security\AccessController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\Security\AccessController@details'    )->middleware('block');
});
// Administracion de roles /////////////////////////////////////////////////////
Route::group(['prefix' => '/admin/security/role'], function () {
  Route::get(''         , 'Admin\Security\RoleController@index'      );
  Route::get('new'      , 'Admin\Security\RoleController@create'     );
  Route::get('{id}'     , 'Admin\Security\RoleController@details'    );
  Route::get('{id}/read', 'Admin\Security\RoleController@readDetails');
  Route::post('new'     , 'Admin\Security\RoleController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\Security\RoleController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\Security\RoleController@details'    )->middleware('block');
});
// Administracion de perfiles //////////////////////////////////////////////////
Route::group(['prefix' => '/admin/security/profile'], function () {
  Route::get(''         , 'Admin\Security\ProfileController@index'      );
  Route::get('new'      , 'Admin\Security\ProfileController@create'     );
  Route::get('{id}'     , 'Admin\Security\ProfileController@details'    );
  Route::get('{id}/read', 'Admin\Security\ProfileController@readDetails');
  Route::post('new'     , 'Admin\Security\ProfileController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\Security\ProfileController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\Security\ProfileController@details'    )->middleware('block');
});
// Administracion de grupos ////////////////////////////////////////////////////
Route::get('/admin/price_groups', 'Admin\Packages\PriceGroupsController@index');
Route::group(['prefix' => '/admin/price_group'], function () {
  Route::get('new'      , 'Admin\Packages\PriceGroupsController@create');
  Route::post('new'     , 'Admin\Packages\PriceGroupsController@create'     )->middleware('block');
/*  Route::get('{id}'     , 'Admin\Security\RoleController@details'    );
  Route::get('{id}/read', 'Admin\Security\RoleController@readDetails');
  Route::delete('{id}'  , 'Admin\Security\RoleController@delete'     );
  Route::patch('{id}'   , 'Admin\Security\RoleController@details'    );
*/
});
////////////////////////////////////////////////////////////////////////////////
// Direccion que solo se habilitran en el modo de desarrollo ///////////////////
////////////////////////////////////////////////////////////////////////////////
// Todas las Rutas de la aplicacion ////////////////////////////////////////////
Route::get('routes'          , 'Development\\RoutesController@index');
Route::get('access/file'     , 'Development\\AccessController@generateFile');
Route::get('role/file'       , 'Development\\RoleController@generateFile');
Route::get('profile/file'    , 'Development\\ProfileController@generateFile');
Route::get('user_type/file'  , 'Development\\UserTypeController@generateFile');

/**
* Prueba para generar pdf
*/

Route::get('admin/billing/{id}'       , 'Admin\ReceiptController@readreceipt'            );
Route::get('admin/billingpackage'     , 'Admin\ReceiptController@readreceiptpackage'     );
Route::get('admin/billingconsolidated', 'Admin\ReceiptController@readreceiptconsolidated');
Route::get('admin/billingid/{id}'     , 'Admin\ReceiptController@readreceiptpackageid'   );
/*Route::get('admin/billing/{id}',function($id){
  $package = App\Models\Admin\Package::find($id);
  $packageLog = App\Models\Admin\Log::ByPackage($package->id)->get();
  $event = App\Models\Admin\Event::all();
  $vars = [
    'package'    => $package,
    'packageLog' => $packageLog,
    'date'       => date('Y-m-d')
  ];
  $pdf = PDF::loadView('sections/pdf',$vars);
  $pdf->setPaper('A4', 'auto');
  return $pdf->stream('invoice.pdf');
});*/



Route::get('admin/receipt',function(){
  $id = 4;
  $package = App\Models\Admin\Package::find($id);
  $packageLog = App\Models\Admin\Log::ByPackage($package->id)->get();
  $event = App\Models\Admin\Event::all();
  $vars = [
    'package'    => $package,
    'packageLog' => $packageLog,
    'date'       => date('Y-m-d')
  ];
  $pdf = PDF::loadView('sections/pdf',$vars);
  $pdf->setPaper('A4', 'auto');
  return $pdf->stream('invoice.pdf');
});

Route::get('/fpdf', function () {

    Fpdf::AddPage();

    Fpdf::SetFont('Arial','B',16);
    Fpdf::Cell(40,10,'Hello World!');
    Fpdf::Output();
    exit;

});
