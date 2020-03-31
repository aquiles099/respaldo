<?php
header('Access-Control-Allow-Origin: *');
header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );
/**
*
*/
$router->pattern('id'       , '[0-9]+');
$router->pattern('sw'       , '[0-9]+');
$router->pattern('company'  , '[0-9]+');
$router->pattern('shipment' , '[0-9]+');
$router->pattern('transport', '[0-9]+');
$router->pattern('date'     , '[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])');
$router->pattern('month'    , '[0-9]{4}-(0[1-9]|1[012])');
/**
* Api para pagina web
*/
Route::group(['prefix' => 'api/website'], function () {
  Route::match(['get', 'post'], 'countries', ['as' => 'api.countries', 'uses' => 'ApiController@countryList']);
  Route::match(['get', 'post'], 'prices'   , ['as' => 'api.prices'   , 'uses' => 'ApiController@getPrice'])->middleware('cors');
});
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
  Route::patch('user'       , 'AccountController@account'      );
  // cambiar contraseña
  Route::get('user/pass'    , 'AccountController@changepass'   );
  Route::patch('user/pass'  , 'AccountController@changepass'   );
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
   Route::get('prealert'              , 'AccountController@prealertList'          );
   Route::post('prealert'             , 'AccountController@prealertList'          )->middleware('block');
   Route::get('prealert/{id}'         , 'AccountController@prealertDetails'       );
   Route::post('prealert/{id}'        , 'AccountController@prealertDetails'       )->middleware('block');
   Route::patch('prealert/{id}'       , 'AccountController@prealertDetails'       );
   Route::get('prealert/{id}/details' , 'AccountController@prealertDetailsPackage');
   Route::get('prealert/new'          , 'AccountController@prealertCreate'        );
   Route::post('prealert/new'         , 'AccountController@prealertCreate'        );
   Route::get('prealert/{id}/view'    , 'AccountController@prealertView'          );
  //gestion de notificaciones
  //Route::get('notifications/settings', 'AccountController@settingsNotification');
  //Route::post('notifications/settings', 'AccountController@settingsNotification')->middleware('block');
   /**
   * Paypal Payment
   */
  Route::match(['get', 'post'], 'prealert/{pickup}/payment',        ['as' => 'payment.create', 'uses' => 'AccountController@PaymentWithpaypal']);
  Route::match(['get', 'post'], 'prealert/{pickup}/payment-status', ['as' => 'payment.status', 'uses' => 'AccountController@PaymentStatus']);
});
//Rutas para la API
Route::group(['prefix' => '/admin/api'], function () {
  Route::get('operator/{email}'     , 'Admin\OperatorController@changeOperator')->middleware('cors');
});
//Rutas para el manejo de fallas
Route::group(['prefix' => '/admin/incidence'], function () {
    Route::get('new'     , 'Admin\IncidenceController@create');
    Route::post('new'     , 'Admin\IncidenceController@create');
    Route::get('list'     , 'Admin\IncidenceController@list');
});

Route::group(['prefix' => '/user/incidence'], function () {
    Route::get('new'     , 'Admin\IncidenceController@usercreate');
    Route::post('new'     , 'Admin\IncidenceController@usercreate');
});

  /**
* Rutas generales
*/
Route::get('/'                  , 'MainController@index'           );
Route::get('/{sw}/day/{id}'     , 'MainController@dateSelect'      );
Route::get('/{sw}/date/{date}'  , 'MainController@dateSelect'      );
Route::get('/{sw}/month/{month}', 'MainController@dateSelect'      );
/**
*
*/
Route::get('/login'             , 'LoginController@index'          );
Route::post('/login'            , 'LoginController@login'          );
Route::get('/login/load'                  , 'LoginController@loadData'       );
Route::get('/login/loadtest'              , 'LoginController@loadTest'       );
Route::post('/operator/statusoperator'    , 'Admin\OperatorController@statusOperator');
Route::get('/login/terms'                 , 'LoginController@verifyTerms'    );
Route::get('/logout'            , 'LoginController@logout'         );
/**
*
*/
Route::get('/register'          , 'LoginController@register'       );
Route::post('/register'         , 'LoginController@doRegister'     )->middleware('block');
/**
*
*/
Route::get('/recover-password'  , 'LoginController@recoverPassword');
Route::post('/recover-password' , 'LoginController@recoverPassword');
Route::get('/terms'             , 'LoginController@terms'          );
Route::get('/help'              , 'LoginController@help'           );
/**
*
*/
Route::get('check/account'      , 'LoginController@check'          );
Route::get('check/account/op'   , 'LoginController@checkOp'        );
/**
*
*/
Route::get('notFound'           , 'ExceptionController@notFound');
/**
* User Count
*/
/*Route::group(['prefix' => '/account/tracking'], function () {
  Route::get(''                    , 'AccountController@index'        );
  Route::get('{id}'                , 'AccountController@details'      );
  Route::get('user/{id}'           , 'AccountController@account'      );
  Route::patch('user/{id}'         , 'AccountController@account'      )->middleware('block');
  Route::get('user/{id}/pass'      , 'AccountController@changepass'   );
  Route::patch('user/{id}/pass'    , 'AccountController@changepass'   )->middleware('block');
  Route::get('prealert/{id}'       , 'AccountController@upload'       );
  Route::post('prealert/{id}'      , 'AccountController@upload'       )->middleware('block');
});*/
/**
* Users
*/
Route::group(['prefix' => '/admin/users'], function(){
  Route::get(''         , 'Admin\UserController@index'      );
  Route::get('{id}/edit', 'Admin\UserController@viewEdit'   );
  Route::get('{id}/read', 'Admin\UserController@view'       );
  Route::patch('{id}'   , 'Admin\UserController@details'    )->middleware('block');
  Route::put('{id}/save', 'Admin\UserController@viewEdit'   )->middleware('block');
});
/**
*
*/
Route::group(['prefix' => '/admin/user'], function () {
  Route::get('xls'             , 'Admin\UserController@loadXls'          );
  Route::post('xls'            , 'Admin\UserController@loadXls'          );
  Route::get('new'             , 'Admin\UserController@create'     );
  Route::post('new'            , 'Admin\UserController@create'     )->middleware('block');
  Route::get('{id}'            , 'Admin\UserController@details'    );
  Route::get('{id}/read'       , 'Admin\UserController@readDetails');
  Route::delete('{id}'         , 'Admin\UserController@delete'     )->middleware('block');
  Route::delete('{id}/delete'  , 'Admin\UserController@deleteAjax' )->middleware('block'); /** Test Path **/
  Route::patch('{id}'          , 'Admin\UserController@details'    );
  Route::get('/view'           , 'Admin\UserController@listAjax'   );
  Route::get('{id}/view'       , 'Admin\UserController@view'       );
  Route::patch('{id}/view'     , 'Admin\UserController@view'       )->middleware('block'); /** Test Path **/
  Route::get('{id}/viewEdit'   , 'Admin\UserController@viewEdit'   ); /** Test Path **/
  Route::get('viewNew'         , 'Admin\UserController@viewNew'    ); /** Test Path **/
  Route::post('viewNew'        , 'Admin\UserController@viewNew'    )->middleware('block'); /** Test Path **/
});
/**
* Operators
*/
Route::group(['prefix' => '/admin/operators'], function(){
  Route::get(''         , 'Admin\OperatorController@index'      );
  Route::get('{id}/edit', 'Admin\OperatorController@details'    );
  Route::get('{id}/read', 'Admin\OperatorController@readDetails');
  Route::patch('{id}'   , 'Admin\OperatorController@details'    )->middleware('block');
  Route::put('{id}/save', 'Admin\OperatorController@details'    )->middleware('block');
  Route::delete('{id}'  , 'Admin\OperatorController@delete'     )->middleware('block');
});
Route::group(['prefix' => '/admin/operator'], function () {
  Route::get('new'      , 'Admin\OperatorController@create'     );
  Route::post('new'     , 'Admin\OperatorController@create'     )->middleware('block');
});
// Administracion de Compañias y sus cliente ////////////////////////////////////
// Route::group(['prefix' => '/admin/company'], function () {
//   Route::get(''         , 'Admin\CompanyController@index'      );
//   Route::get('new'      , 'Admin\CompanyController@create'     );
//   Route::get('{id}/edit', 'Admin\CompanyController@details'    );
//   Route::get('{id}/read', 'Admin\CompanyController@readDetails');
//   Route::post('new'     , 'Admin\CompanyController@create'     )->middleware('block');
//   Route::delete('{id}'  , 'Admin\CompanyController@delete'     )->middleware('block');
//   Route::patch('{id}'   , 'Admin\CompanyController@details'    )->middleware('block');
//   Route::put('{id}/save', 'Admin\CompanyController@edit'       )->middleware('block');
//   /**********Rutas para la administarcion de clientes*********************/
//   Route::get('{company}/clients'              , 'Admin\ClientController@index'         );
//   Route::get('{company}/clients/new'          , 'Admin\ClientController@create'        );
//   Route::get('{company}/clients/{id}/edit'    , 'Admin\ClientController@details'       );
//   Route::get('{company}/clients/{id}/read'    , 'Admin\ClientController@readDetails'   );
//   Route::post('{company}/clients/new'         , 'Admin\ClientController@create'        )->middleware('block');
//   Route::delete('{company}/clients/{id}'      , 'Admin\ClientController@delete'        )->middleware('block');
//   Route::patch('{company}/clients/{id}'       , 'Admin\ClientController@details'       )->middleware('block');
//   Route::put('{company}/clients/{id}/save'    , 'Admin\ClientController@edit'          )->middleware('block');
// });

/**
* Ruta de clientes dado una empresa en json
*/
Route::get('/admin/package/new/{id}/clients/json','Admin\ClientController@readjsonclient');
/**
* Ruta de aeropuerto o puertos dado un tipo se servicio en json
*/
Route::get('/admin/pckagecurriers/new/{id}/transport/  json','Admin\TransportController@readjsondetailstransport');
Route::get('/admin/pckagecurriers/new/{id}/service/json','Admin\ServicesController@readjsonservice');
Route::get('/admin/pckagecurriers/new/prealerts/{id}','Admin\PackageController@servicePrealerts');
Route::get('/admin/pckagecurriers/new/{id}/service/json','Admin\ServicesController@readjsonservice');
Route::get('/admin/pickup/new/{id}/service/json','Admin\ServicesController@readjsonservice');
Route::get('/admin/pickup/new/{id}/service/json','Admin\ServicesController@readjsonservice');
/**
* Ruta de impuestos por categoria
*/
Route::get('/admin/packagecurriers/new/{id}/tax/json','Admin\CategoryController@readtaxcategory');
Route::get('/admin/pickup/new/{id}/tax/json','Admin\CategoryController@readtaxcategory');

Route::get('/admin/prealert', 'Admin\PackageController@prealertList');
Route::get('/admin/prealert/{id}'  , 'AccountController@prealertDetails' );
Route::post('/admin/prealert/{id}'  , 'AccountController@prealertDetails' )->middleware('block');
Route::patch('/admin/prealert/{id}'  , 'AccountController@prealertDetails' )->middleware('block');

////////////////////////////////////////////////////////////////////////////////
// Datos maestros //////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
// Administracion de paises ////////////////////////////////////////////////////
Route::get('/admin/country/list'     ,    'Admin\CountryController@getList' );

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
/**
* Oficinas-Almacenes
*/
// Route::group(['prefix' => '/admin/office'], function () {
//   Route::get(''         , 'Admin\OfficeController@index'      );
//   Route::get('new'      , 'Admin\OfficeController@create'     );
//   Route::get('{id}/edit', 'Admin\OfficeController@details'    );
//   Route::get('{id}/read', 'Admin\OfficeController@readDetails');
//   Route::post('new'     , 'Admin\OfficeController@create'     )->middleware('block');
//   Route::delete('{id}'  , 'Admin\OfficeController@delete'     )->middleware('block');
//   Route::patch('{id}'   , 'Admin\OfficeController@details'    )->middleware('block');
//   Route::put('{id}/save', 'Admin\OfficeController@edit'       )->middleware('block');
// });
/**
* Services
*/
// Route::group(['prefix' => '/admin/service'], function () {
//   Route::get(''         , 'Admin\ServicesController@index'      );
//   Route::get('new'      , 'Admin\ServicesController@create'     );
//   Route::get('{id}/edit', 'Admin\ServicesController@details'    );
//   Route::get('{id}/read', 'Admin\ServicesController@readDetails');
//   Route::post('new'     , 'Admin\ServicesController@create'     )->middleware('block');
//   Route::delete('{id}'  , 'Admin\ServicesController@delete'     )->middleware('block');
//   Route::patch('{id}'   , 'Admin\ServicesController@details'    )->middleware('block');
//   Route::put('{id}/save', 'Admin\ServicesController@details'    )->middleware('block');
// });
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

/**
* Categories
*/
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
// Route::group(['prefix' => '/admin/consolidated/showconsolidated/'], function () {
//   Route::get('{id}'     , 'Admin\ShowConsolidatedController@create'      );
//   Route::post('{id}'     , 'Admin\ShowConsolidatedController@create'     )->middleware('block');
// });
// Administracion de paquetes para mostrar /////////////////////////////////////
// Route::group(['prefix' => '/admin/package/showpackage'], function () {
//   Route::get('{id}'     , 'Admin\ShowPackageController@create'      );
//   Route::post('{id}'     , 'Admin\ShowPackageController@create'     )->middleware('block');
// });
/**
* Impuestos
*/
Route::group(['prefix' => '/admin/tax'], function () {
  Route::get(''         , 'Admin\TaxController@index'      );
  Route::get('new'      , 'Admin\TaxController@create'     );
  Route::get('{id}/edit', 'Admin\TaxController@details'    );
  Route::get('{id}/read', 'Admin\TaxController@readDetails');
  Route::post('new'     , 'Admin\TaxController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\TaxController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\TaxController@details'    )->middleware('block');
  Route::put('{id}/save', 'Admin\TaxController@details'    )->middleware('block');
});
/**
* Administracion de paquetes por ics
*/
// Route::group(['prefix' => '/admin/package'], function () {
//   Route::get(''                , 'Admin\PackageController@index'               );
//   Route::get('new'             , 'Admin\PackageController@create'              );
//   Route::get('{id}'            , 'Admin\PackageController@editpackagecurriers' );
//   Route::patch('{id}'           , 'Admin\PackageController@editpackagecurriers' )->middleware('block');
//   Route::get('{id}/read'       , 'Admin\PackageController@readDetails'         );
//   Route::get('{id}/print'      , 'Admin\PackageController@printer'             );
//   Route::get('{id}/receipt'    , 'Admin\PackageController@detailsreceipt'      );
//   Route::post('new'            , 'Admin\PackageController@create'              )->middleware('block');
//   Route::delete('{id}'         , 'Admin\PackageController@delete'              )->middleware('block');
//   Route::get('{id}/dash'       , 'Admin\PackageController@dashboarDetails'     );
//   Route::get('{id}/upload'     , 'Admin\PackageController@uploadile'           );
//   Route::post('{id}/upload'    , 'Admin\PackageController@uploadile'           )->middleware('block');
//   Route::get('/wr/{id}/upload' , 'Admin\PackageController@uploadile'           );
//   Route::post('wr/{id}/upload' , 'Admin\PackageController@uploadile'           )->middleware('block');
//   Route::get('/wr'             , 'Admin\PackageController@indexwr'             );
//   Route::get('newbill/{id}'    , 'Admin\BillOfLadingController@createwr'       );
//   Route::post('newbill/{id}'   , 'Admin\BillOfLadingController@createwr'       )->middleware('block');
//   Route::get('pdfbill/{id}'    , 'Admin\BillOfLadingController@pdfbillwr'      );
//   Route::get('airwaybill/{id}'    , 'Admin\ReceiptController@airwayBillHouse'      );
//   Route::get('{id}/items'      , 'Admin\PackageController@items'               );
//
// });

// Administracion de paquestes por curriers /////////////////////////////////////////////////
// Route::group(['prefix' => '/admin/pckagecurriers'], function () {
//   Route::get(''              , 'Admin\PackageController@index'            );
//   Route::get('new'           , 'Admin\PackageController@createcurriers'   );
//   Route::get('new/courier'   , 'Admin\PackageController@currier');
//   Route::get('{id}'          , 'Admin\PackageController@details'          );
//   Route::get('{id}/read'     , 'Admin\PackageController@readDetails'      );
//   Route::get('{id}/print'    , 'Admin\PackageController@printer'          );
//   Route::post('new'          , 'Admin\PackageController@createcurriers'   )->middleware('block');
//   Route::delete('{id}'       , 'Admin\PackageController@delete'           )->middleware('block');
//   Route::patch('{id}'        , 'Admin\PackageController@details'          )->middleware('block');
//   Route::get('new/service'   , 'Admin\CourierController@serviceOrder');
//});
/**
* Promotions
*/
// Route::group(['prefix' => '/admin/promotions'], function () {
//   Route::get(''         , 'Admin\PromotionController@index'      );
//   Route::get('new'      , 'Admin\PromotionController@create'     );
//   Route::get('{id}/edit', 'Admin\PromotionController@details'    );
//   Route::get('{id}/read', 'Admin\PromotionController@readDetails');
//   Route::post('new'     , 'Admin\PromotionController@create'     )->middleware('block');
//   Route::delete('{id}'  , 'Admin\PromotionController@delete'     )->middleware('block');
//   Route::patch('{id}'   , 'Admin\PromotionController@details'    )->middleware('block');
//   Route::put('{id}/save', 'Admin\PromotionController@details'    )->middleware('block');
// });
/**
* Consolidated
*/
// Route::group(['prefix' => '/admin/consolidated'], function () {
//   Route::get(''                    , 'Admin\ConsolidatedController@index'        );
//   Route::get('new'                 , 'Admin\ConsolidatedController@create'       );
//   Route::get('{id}'                , 'Admin\ConsolidatedController@details'      );
//   Route::get('{id}/read'           , 'Admin\ConsolidatedController@readDetails'  );
//   Route::post('new'                , 'Admin\ConsolidatedController@create'       )->middleware('block');
//   Route::patch('addpackage/{id}'   , 'Admin\ConsolidatedController@addPackage'   )->middleware('block');
//   Route::patch('deletepackage/{id}', 'Admin\ConsolidatedController@deletePackage')->middleware('block');
//   Route::delete('{id}'             , 'Admin\ConsolidatedController@delete'       )->middleware('block');
//   Route::patch('{id}'              , 'Admin\ConsolidatedController@details'      )->middleware('block');
// });
/**
* Couriers
*/
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
* Administracion de transporte
*/
Route::group(['prefix' => '/admin/transport'], function () {
    Route::get(''                    , 'Admin\TransportController@index'       );
    Route::get('new'                 , 'Admin\TransportController@create'      );
    Route::get('get'                 , 'Admin\TransportController@getPorts'    );
    Route::get('{id}/edit'           , 'Admin\TransportController@edit'        );
    Route::post('{id}/edit'          , 'Admin\TransportController@edit'        )->middleware('block');
    Route::get('{id}/editPortRead'   , 'Admin\TransportController@editPortRead');
    Route::get('{id}/editPort'       , 'Admin\TransportController@editPort'    );
    Route::put('{id}/editPort'       , 'Admin\TransportController@editPort'    );
    Route::get('{id}/read'           , 'Admin\TransportController@readDetails' );
    Route::get('{id}/viewTransport'  , 'Admin\TransportController@viewTransport');
    Route::put('{id}/viewTransport' , 'Admin\TransportController@viewTransport')->middleware('block');
    Route::post('new'                , 'Admin\TransportController@create'      )->middleware('block');
    Route::delete('{id}'             , 'Admin\TransportController@delete'      )->middleware('block');
    Route::delete('{id}/deletePort'  , 'Admin\TransportController@deletePort'  )->middleware('block');
    Route::patch('{id}'              , 'Admin\TransportController@details'     )->middleware('block');
    Route::put('{id}/save'           , 'Admin\TransportController@edit'        )->middleware('block');
});
/**
* Service Details
*/
Route::group(['prefix' => '/admin/transport/details'], function () {
  Route::get('new/{id}'    , 'Admin\DetailsTransportController@create'     );
  Route::post('new/{id}'   , 'Admin\DetailsTransportController@create'     )->middleware('block');
});
/**
* Receipt
*/
Route::group(['prefix' => '/admin/receipt'], function () {
    Route::get(''                     , 'Admin\ReceiptController@index'          );
    Route::get('{id}'                 , 'Admin\ReceiptController@search'         );
    Route::post('{id}'                , 'Admin\ReceiptController@search'         )->middleware('block');
    Route::get('{id}/checkIn'         , 'Admin\ReceiptController@checkIn'        );
    Route::post('{id}/checkIn'        , 'Admin\ReceiptController@checkIn'        )->middleware('block');
    Route::get('{id}/innerChekin'     , 'Admin\ReceiptController@innerChekin'    );
    Route::get('{id}/showPayment'     , 'Admin\ReceiptController@showPayment'    );
    Route::get('{id}/paymentDetail'   , 'Admin\ReceiptController@paymentDetail'  );
    Route::post('{id}/paymentDetail'  , 'Admin\ReceiptController@paymentDetail'  )->middleware('block');
    Route::get('{id}/masterbill'      , 'Admin\ReceiptController@masterbill'     );
    Route::get('{id}/loadguide'       , 'Admin\ReceiptController@loadingguide'   );
    Route::get('{id}/cargomanifest'   , 'Admin\ReceiptController@cargomanifest'  );
    Route::get('{id}/showWarehouse'   , 'Admin\ReceiptController@showWarehouse'  );
    Route::get('{id}/showPickup'      , 'Admin\ReceiptController@showPickup'     );
});
/**
* Receipt Details
*/
Route::group(['prefix' => '/admin/detailsreceipt'], function () {
    Route::get(''         , 'Admin\DetailsReceiptController@index'      );
    Route::get('new'      , 'Admin\DetailsReceiptController@create'     );
    Route::get('{id}'     , 'Admin\DetailsReceiptController@details'    );
    Route::get('{id}/read', 'Admin\DetailsReceiptController@readDetails');
    Route::post('new'     , 'Admin\DetailsReceiptController@create'     )->middleware('block');
    Route::delete('{id}'  , 'Admin\DetailsReceiptController@delete'     )->middleware('block');
    Route::patch('{id}'   , 'Admin\DetailsReceiptController@details'    )->middleware('block');
    Route::get('{id}/view', 'Admin\DetailsReceiptController@view'       )->middleware('block');
});
/**
* ClientAttention
*/
// Route::group(['prefix' => '/admin/clientAttention'],function () {
//   Route::get(''          , 'Admin\ClientAttentionController@index'           );
//   Route::get('packages'  , 'Admin\ClientAttentionController@searchPackages'  );
//   Route::get('users'     , 'Admin\ClientAttentionController@searchUsers'     );
//   Route::get('promotions', 'Admin\ClientAttentionController@searchPromotions');
//   Route::get('taxes'     , 'Admin\ClientAttentionController@searchTaxes'     );
//   Route::get('services'  , 'Admin\ClientAttentionController@searchServices'  );
//   Route::get('categories', 'Admin\ClientAttentionController@searchCategories');
//   Route::get('companies' , 'Admin\ClientAttentionController@searchCompanies' );
// });
/**
* Configuration
*/
Route::group(['prefix' => 'admin/configuration'],function () {
  Route::get('hour'        , 'Admin\ConfigurationController@serverTime' );
  Route::get('items'       , 'Admin\ConfigurationController@items' );
  Route::get(''            , 'Admin\ConfigurationController@index' );
  Route::post('{id}'       , 'Admin\ConfigurationController@upload')->middleware('block');
  Route::patch('{id}'      , 'Admin\ConfigurationController@upload')->middleware('block');
  Route::patch(''          , 'Admin\ConfigurationController@index' )->middleware('block');
  Route::get('rates/format', ['as' => 'config.rates.format', 'uses' => 'Admin\ConfigurationController@ratesFormat']);
});
/**
* Reports
*/
Route::group(['prefix' => 'admin/billing'], function () {
  Route::get(''     ,  'Admin\BillingController@index'     );
  Route::post(''    ,  'Admin\BillingController@searchData')->middleware('block');
  Route::get('logo' ,  'Admin\BillingController@returnLogo');
});
/**
* Bookings
*/
// Route::group(['prefix' => 'admin/bookings'], function () {
//   Route::get(''           , 'Admin\BookingController@index'                   );
//   Route::get('new'        , 'Admin\BookingController@create'                  );
//   Route::post('new'       , 'Admin\BookingController@create'                  )->middleware('block');
//   Route::get('{id}'       , 'Admin\BookingController@details'                 );
//   Route::get('new/type'   , 'Admin\BookingController@type'                    );
//   Route::get('{id}/view'  , 'Admin\BookingController@view'                    );
//   Route::get('receipt/{id}', 'Admin\ReceiptController@bookingReceipt'         );
//   Route::post('{id}/view' , 'Admin\BookingController@view'                    )->middleware('block');
//   Route::delete('{id}'    , 'Admin\BookingController@delete'                  )->middleware('block');
//   Route::patch('{id}'     , 'Admin\BookingController@details'                 )->middleware('block');
//   Route::get('{id}/items' , 'Admin\BookingController@items'                   );
//   Route::post('attachment', 'Admin\BookingController@uploadFile'              )->middleware('block');
// });
/**
* Containers
*/
// Route::group(['prefix' => 'admin/containers'], function () {
//   Route::get(''         , 'Admin\ContainerController@index'          );
//   Route::get('new'      , 'Admin\ContainerController@create'         );
//   Route::get('{id}/edit', 'Admin\ContainerController@details'        );
//   Route::get('{id}/read', 'Admin\ContainerController@readDetails'    );
//   Route::post('new'     , 'Admin\ContainerController@create'         )->middleware('block');
//   Route::delete('{id}'  , 'Admin\ContainerController@delete'         );
//   Route::patch('{id}'   , 'Admin\ContainerController@details'        );
//   Route::put('{id}/save', 'Admin\ContainerController@details'        );
// });
/**
* Cargo Release
*/
// Route::group(['prefix' => 'admin/cargoRelease'], function () {
//   Route::get(''                 , 'Admin\CargoReleaseController@index'          );
//   Route::get('new'              , 'Admin\CargoReleaseController@create'         );
//   Route::get('{id}'             , 'Admin\CargoReleaseController@details'        );
//   Route::get('{id}/read'        , 'Admin\CargoReleaseController@readDetails'    );
//   Route::post('new'             , 'Admin\CargoReleaseController@create'         )->middleware('block');
//   Route::delete('{id}'          , 'Admin\CargoReleaseController@delete'         )->middleware('block');
//   Route::patch('{id}'           , 'Admin\CargoReleaseController@details'        )->middleware('block');
//   Route::get('{id}/release'     , 'Admin\CargoReleaseController@release'        );
//   Route::get('{id}/contact'     , 'Admin\CargoReleaseController@returnContact'  );
//   Route::get('{id}/view'        , 'Admin\CargoReleaseController@view'           );
//   Route::post('{id}/view'       , 'Admin\CargoReleaseController@view'           )->middleware('block');
//   Route::post('attachment'      , 'Admin\CargoReleaseController@uploadFile'     )->middleware('block');
// });
/**
* Pickup
*/
Route::group(['prefix' => 'admin/tpickup'], function () {
  Route::get(''          , 'Admin\TypePickupController@index'          );
  Route::get('new'       , 'Admin\TypePickupController@create'         );
  Route::get('{id}'      , 'Admin\TypePickupController@details'        );
  Route::get('{id}/read' , 'Admin\TypePickupController@readDetails'    );
  Route::post('new'      , 'Admin\TypePickupController@create'         )->middleware('block');
  Route::delete('{id}'   , 'Admin\TypePickupController@delete'         )->middleware('block');
  Route::patch('{id}'    , 'Admin\TypePickupController@details'        )->middleware('block');
  Route::put('{id}/save' , 'Admin\TypePickupController@details'        )->middleware('block');
  Route::get('{id}/edit' , 'Admin\TypePickupController@details'        );
});
/**
* Numbers Parts
*/
Route::group(['prefix' => 'admin/numberparts'], function () {
  Route::get(''         , 'Admin\NumberPartsController@index'          );
  Route::get('new'      , 'Admin\NumberPartsController@create'         );
  Route::get('{id}/read', 'Admin\NumberPartsController@readDetails'    );
  Route::post('new'     , 'Admin\NumberPartsController@create'         )->middleware('block');
  Route::delete('{id}'  , 'Admin\NumberPartsController@delete'         )->middleware('block');
  Route::patch('{id}'   , 'Admin\NumberPartsController@details'        )->middleware('block');
  Route::put('{id}/save', 'Admin\NumberPartsController@details'        )->middleware('block');
  Route::get('{id}/edit', 'Admin\NumberPartsController@details'        );

});
/**
* Pickup Orders
*/
Route::group(['prefix' => 'admin/pickup'], function () {
  Route::post('price'           , 'Admin\PickupController@getPrice'       )->middleware('cors');
  Route::get(''                 , 'Admin\PickupController@index'          );
  Route::get('new'              , 'Admin\PickupController@create'         );
  Route::get('{id}'             , 'Admin\PickupController@details'        );
  Route::get('{id}/read'        , 'Admin\PickupController@readDetails'    );
  Route::post('new'             , 'Admin\PickupController@create'         )->middleware('block');
  Route::delete('{id}'          , 'Admin\PickupController@delete'         )->middleware('block');
  Route::patch('{id}'           , 'Admin\PickupController@details'        )->middleware('block');
  Route::get('new/type'         , 'Admin\PickupController@type'           );
  Route::get('new/numberparts'  , 'Admin\PickupController@numberparts'    );
  Route::get('{id}/type'        , 'Admin\PickupController@type'           );
  Route::get('{id}/numberparts' , 'Admin\PickupController@numberparts'    );
  Route::get('showpickup/{id}'  , 'Admin\PickupController@showpickup'     );
  Route::post('showpickup/{id}' , 'Admin\PickupController@showpickup'     )->middleware('block');
  Route::post('{id}/addwr'      , 'Admin\PickupController@addwr'          )->middleware('block');
  Route::get('{id}/items'       , 'Admin\PickupController@items'          );
});
/**
* Shipment
*/
Route::group(['prefix' => '/admin/l/shipments'], function () {
  Route::get('iata/{id}'                           , 'Admin\ShipmentController@iata'       );
  Route::get(''                                    , 'Admin\ShipmentController@index'       );
  Route::get('{id}/read'                           , 'Admin\ShipmentController@view'        );
  Route::post('{id}/read'                          , 'Admin\ShipmentController@view'        )->middleware('block')->middleware('block');
});
Route::group(['prefix' => '/admin/shipments'], function () {
  Route::get('new'                                 , 'Admin\ShipmentController@create'      );
  Route::post('new'                                , 'Admin\ShipmentController@create'      )->middleware('block')->middleware('block');
  Route::get('{id}'                                , 'Admin\ShipmentController@details'     );
  Route::get('new/{id}/type/shipment/{shipment}'   , 'Admin\ShipmentController@type'        );
  Route::get('{id}/loadGeneral/shipment/{shipment}', 'Admin\ShipmentController@loadGeneral' );
  Route::get('{id}/loadRoutes/shipment/{shipment}' , 'Admin\ShipmentController@loadRoutes'  );
  Route::delete('{id}'                             , 'Admin\ShipmentController@delete'      )->middleware('block')->middleware('block');
  Route::patch('{id}'                              , 'Admin\ShipmentController@details'     )->middleware('block')->middleware('block');
  Route::post('attachment'                         , 'Admin\ShipmentController@uploadFile'  )->middleware('block')->middleware('block');
  Route::get('{id}/masterbill'                     , 'Admin\ReceiptController@masterbill'   );
  Route::get('{id}/loadguide'                      , 'Admin\ReceiptController@loadingguide' );
  Route::get('{id}/cargomanifest'                  , 'Admin\ReceiptController@cargomanifest');
});
/**
* Routes
*/
Route::group(['prefix' => '/admin/routes'], function () {
  Route::get(''                , 'Admin\RoutesController@index'      );
  Route::get('new'             , 'Admin\RoutesController@create'     );
  Route::post('new'            , 'Admin\RoutesController@create'     )->middleware('block');
  Route::get('{id}/read'       , 'Admin\RoutesController@readDetails');
  Route::get('{id}/edit'       , 'Admin\RoutesController@details'    );
  Route::delete('{id}'         , 'Admin\RoutesController@delete'     )->middleware('block');
  Route::patch('{id}'          , 'Admin\RoutesController@details'    )->middleware('block');
  Route::put('{id}/save'       , 'Admin\RoutesController@details'    )->middleware('block');
  Route::get('new/{id}/city'   , 'Admin\RoutesController@city'       );
});
/**
* Vessels
*/
// Route::group(['prefix' => '/admin/vessels'], function () {
//   Route::get(''                , 'Admin\VesselController@index'      );
//   Route::get('new'             , 'Admin\VesselController@create'     );
//   Route::post('new'            , 'Admin\VesselController@create'     )->middleware('block')->middleware('block');
//   Route::get('{id}/read'       , 'Admin\VesselController@readDetails');
//   Route::delete('{id}'         , 'Admin\VesselController@delete'     )->middleware('block')->middleware('block');
//   Route::get('{id}/edit'       , 'Admin\VesselController@details'    );
//   Route::put('{id}/save'       , 'Admin\VesselController@details'    )->middleware('block')->middleware('block');
//   Route::get('new/{id}/city'   , 'Admin\VesselController@city'       );
// });
/**
* City
*/
Route::group(['prefix' => '/admin/cities'], function () {
  Route::get(''                 , 'Admin\CityController@index'          );
  Route::get('new'              , 'Admin\CityController@create'         );
  Route::post('new'             , 'Admin\CityController@create'         )->middleware('block');
  Route::get('{id}/read'        , 'Admin\CityController@readDetails'    );
  Route::delete('{id}'          , 'Admin\CityController@delete'         )->middleware('block');
  Route::get('{id}/edit'        , 'Admin\CityController@details'        );
  Route::put('{id}/save'        , 'Admin\CityController@details'        )->middleware('block');
  Route::delete('{id}'          , 'Admin\CityController@delete'         )->middleware('block');
  Route::get('new/{id}/state'   , 'Admin\StateController@state'          );
});

/**
* State
*/
Route::group(['prefix' => '/admin/state'], function () {
  Route::get(''                 , 'Admin\StateController@index'          );
  Route::get('new'              , 'Admin\StateController@create'         );
  Route::post('new'             , 'Admin\StateController@create'         )->middleware('block');
  Route::get('{id}/read'        , 'Admin\StateController@readDetails'    );
  Route::delete('{id}'          , 'Admin\StateController@delete'         )->middleware('block');
  Route::get('{id}/edit'        , 'Admin\StateController@details'        );
  Route::put('{id}/save'        , 'Admin\StateController@details'        )->middleware('block');
  Route::delete('{id}'          , 'Admin\StateController@delete'         )->middleware('block');
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
* suppliers
*/
Route::group(['prefix' => '/admin/suppliers'], function () {
  Route::get(''                 , 'Admin\SuppliersController@index'          );
  Route::get('attachment'                 , 'Admin\SuppliersController@getAttachment'          );
  Route::get('new'              , 'Admin\SuppliersController@create'         );
  Route::post('new'             , 'Admin\SuppliersController@create'         )->middleware('block');
  Route::get('new/{id}/type'    , 'Admin\SuppliersController@type'           );
  Route::get('{id}/loadGeneral' , 'Admin\SuppliersController@loadGeneral'    );
  Route::get('{id}/loadRoutes'  , 'Admin\SuppliersController@loadRoutes'     );
  Route::get('{id}/loadCargo'   , 'Admin\SuppliersController@loadCargo'      );
  Route::delete('{id}'          , 'Admin\SuppliersController@delete'         )->middleware('block');
  Route::get('{id}/read'       , 'Admin\SuppliersController@readDetails'  );
  Route::get('{id}/edit'       , 'Admin\SuppliersController@details'      );
  Route::patch('{id}'          , 'Admin\SuppliersController@details'      )->middleware('block');
  Route::put('{id}/save'       , 'Admin\SuppliersController@details'      )->middleware('block');
});

/**
* transporters
*/

Route::group(['prefix' => '/admin/transporters'], function () {
  Route::get(''                 , 'Admin\TransportersController@index'     );
  Route::get('new'              , 'Admin\TransportersController@create'    );
  Route::post('new'             , 'Admin\TransportersController@create'    )->middleware('block');
  Route::delete('{id}'          , 'Admin\TransportersController@delete'    )->middleware('block');
  Route::get('new/{id}/type/{transport}'    , 'Admin\ShipmentController@type'          );
  Route::get('{id}/loadGeneral/{transport}' , 'Admin\ShipmentController@loadGeneral'   );
  Route::get('{id}/loadRoutes/{transport}'  , 'Admin\ShipmentController@loadRoutes'    );
  Route::get('{id}/loadCargo/{transport}'   , 'Admin\ShipmentController@loadCargo'     );
  Route::get('{id}/read'       , 'Admin\TransportersController@readDetails');
  Route::get('{id}/edit'       , 'Admin\TransportersController@details'    );
  Route::patch('{id}'          , 'Admin\TransportersController@details'    )->middleware('block');
  Route::put('{id}/save'       , 'Admin\TransportersController@details'    )->middleware('block');
});
/**
* Administracion de billoflading
*/
// Route::group(['prefix' => '/admin/pickup'], function () {
//   Route::get('newbill/{id}'     , 'Admin\BillOfLadingController@create'      );
//   Route::post('newbill/{id}'    , 'Admin\BillOfLadingController@create'      )->middleware('block');
//   Route::get('receiptbill/{id}' , 'Admin\BillOfLadingController@receiptbill' );
//   Route::get('pdfbill/{id}'     , 'Admin\BillOfLadingController@pdfbill');
// });
/**
* Administracion de Master Bill Of Lading
*/
// Route::group(['prefix' => '/admin/master'], function () {
//   Route::get(''          , 'Admin\MasterController@index'       );
//   Route::get('new'       , 'Admin\MasterController@create'      );
//   Route::get('data/{id}' , 'Admin\MasterController@getdata'     );
// });
/*****************************Security***********************************/
/**
* Access
*/
Route::group(['prefix' => '/admin/security/access'], function () {
  Route::get(''         , 'Admin\Security\AccessController@index'      );
  Route::get('new'      , 'Admin\Security\AccessController@create'     );
  Route::get('{id}/'    , 'Admin\Security\AccessController@details'    );
  Route::get('{id}/read', 'Admin\Security\AccessController@readDetails');
  Route::post('new'     , 'Admin\Security\AccessController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\Security\AccessController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\Security\AccessController@details'    )->middleware('block');
  Route::put('{id}/save', 'Admin\Security\AccessController@details'    )->middleware('block');
});
/**
* Role
*/
Route::group(['prefix' => '/admin/security/role'], function () {
  Route::get(''         , 'Admin\Security\RoleController@index'      );
  Route::get('new'      , 'Admin\Security\RoleController@create'     );
  Route::get('{id}/',     'Admin\Security\RoleController@details'    );
  Route::get('{id}/read', 'Admin\Security\RoleController@readDetails');
  Route::post('new'     , 'Admin\Security\RoleController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\Security\RoleController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\Security\RoleController@details'    )->middleware('block');
  Route::put('{id}/save', 'Admin\Security\RoleController@details'    )->middleware('block');
});
/**
* Profile
*/
Route::group(['prefix' => '/admin/security/profile'], function () {
  Route::get(''         , 'Admin\Security\ProfileController@index'      );
  Route::get('new'      , 'Admin\Security\ProfileController@create'     );
  Route::get('{id}'     , 'Admin\Security\ProfileController@details'    );
  Route::get('{id}/read', 'Admin\Security\ProfileController@readDetails');
  Route::post('new'     , 'Admin\Security\ProfileController@create'     )->middleware('block');
  Route::delete('{id}'  , 'Admin\Security\ProfileController@delete'     )->middleware('block');
  Route::patch('{id}'   , 'Admin\Security\ProfileController@details'    )->middleware('block');
});
/**
* Group
*/
Route::get('/admin/price_groups', 'Admin\Packages\PriceGroupsController@index');
Route::group(['prefix' => '/admin/price_group'], function () {
  Route::get('new'      , 'Admin\Packages\PriceGroupsController@create');
  Route::post('new'     , 'Admin\Packages\PriceGroupsController@create'     );
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
Route::get('admin/billing/{id}'          , 'Admin\ReceiptController@readreceipt'            );
Route::get('admin/shipments/airwaybill/{id}'          , 'Admin\ReceiptController@airwayBill'            );
Route::get('admin/billingpackage'        , 'Admin\ReceiptController@readreceiptpackage'     );
Route::get('admin/billingconsolidated'   , 'Admin\ReceiptController@readreceiptconsolidated');
Route::get('admin/billingid/{id}'        , 'Admin\ReceiptController@readreceiptpackageid'   );
Route::get('admin/billpickup/{id}'       , 'Admin\ReceiptController@readpickupbill'         );
//Route::get('admin/invoice/{id}/warehouse', 'Admin\ReceiptController@readinvoicepackageid'   );
Route::get('admin/invoice/{id}/warehouse', 'Admin\ReceiptController@invoicepackage'         );
Route::get('admin/invoice/{id}/cargoRelease', 'Admin\ReceiptController@cargoReleasePackage'         );
Route::get('admin/invoice/{id}/pickup'   , 'Admin\ReceiptController@readInvoicePickup'      );
Route::get('admin/receiptpickup/{id}'    , 'Admin\ReceiptController@receiptpickupid'        );
