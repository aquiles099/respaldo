<?php
  /**
  * Se Establecen Patrones [REGEX]
  * 1) Para un ID
  * 2) Para un bug
  * 3) Para una incidencia
  * 4) Para un nombre
  * 5) Para un correo
  */
  $router->pattern('id'        , '[0-9]+'                                                               );
  $router->pattern('bug'       , '[0-9]+'                                                               );
  $router->pattern('incidence' , '[0-9]+'                                                               );
  $router->pattern('client'    , '[a-z0-9]+(?:-[a-z0-9]+)*'                                             );
  $router->pattern('notice'    , '[a-z0-9]+(?:-[a-z0-9]+)*'                                             );
  $router->pattern('email'     , '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$');
  $router->pattern('url'       , '^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \?=.-]*)*\/?$'     );
  /**
  * Rutas Generales
  */
  Route::get('/'                , 'MainController@index'                   );
  Route::get('/contact'         , 'MainController@contact'                 );
  Route::post('/contact'        , 'MainController@contact'                 );
  Route::get('/login'           , 'LoginController@index'                  );
  Route::post('/login'          , 'LoginController@login'                  );
  Route::get('/logout'          , 'LoginController@logout'                 );
  Route::get('/us'              , 'MainController@us'                      );
  Route::get('/demo'            , 'MainController@demo'                    );
  Route::get('/check'           , 'MainController@check'                   );
  Route::get('/terms'           , 'MainController@terms'                   );
  Route::get('/privacy'         , 'MainController@privacy'                 );
  Route::get('/faq'             , 'MainController@faq'                     );
  Route::get('/sub-domain'      , 'MainController@subDomain'               );
  Route::get('/payment/{url}'   , 'MainController@searchClientFromPayment' );
  Route::post('/payment/other'  , 'MainController@otherPayment'            );
  Route::get('/prices'          , 'MainController@prices'                  );
  /**
  * [optimize with 'match']
  */
  Route::match(['get', 'post']   , '/recover-password', 'LoginController@recoverPassword' );
  Route::match(['get', 'post']   , '/solicitude'      , 'MainController@solicitude'       );
  Route::match(['get', 'post']   , '/payment'         , 'MainController@payment'          );
  Route::match(['get', 'post']   ,'/payment/{id}'     , 'MainController@setTypePayment'   );
  Route::match(['get', 'post']   , 'payment/return'   , 'MainController@returnPayment'    );
  Route::match(['get', 'patch']  , '/change-password' , 'MainController@changePassword'   )->middleware('watchSession');
  /**
  *
  */
  Route::get('/news'         , 'MainController@news'      );
  Route::get('/news/{notice}', 'MainController@showNew'   );
  /**
  * Mostrar y recibir formulario de cliente
  */
  Route::get('/check-data/{client}'  , 'MainController@checkData'  );
  Route::patch('/check-data/{client}' , 'MainController@checkData' );
  /**
  *
  */
  Route::group(['prefix' => 'admin/prices', 'middleware' => 'watchSession'], function () {
    Route::get('', 'Admin\PriceController@index');
    Route::match(['get', 'patch'], 'edit' ,'Admin\PriceController@edit');
  });
  /**
  * Administrar Pagos [optimize with 'match' && middleware]
  */
  Route::group(['prefix' => 'admin/payments', 'middleware' => 'watchSession'], function () {
    Route::get(''                , 'Admin\PaymentController@index'            );
    Route::match(['get','patch'] , '{id}'     , 'Admin\PaymentController@edit');
    Route::match(['get','post']  , '{id}/mail', 'Admin\PaymentController@mail');
    Route::delete('{id}'         , 'Admin\PaymentController@delete'           )->middleware('requiredMaster');
    Route::get('{id}/attachment' , 'Admin\PaymentController@attachment'       );
    Route::get('{id}/invoice'    , 'Admin\PaymentController@invoice'          );
  });
  /**
  * Administar Correos [optimize with 'match' && middleware]
  */
  Route::group(['prefix' => 'admin/mails', 'middleware' => 'watchSession'], function () {
    Route::get(''                , 'Admin\EmailController@index'          );
    Route::match(['get','post']  , 'new' , 'Admin\EmailController@create' );
    Route::match(['get','patch'] , '{id}', 'Admin\EmailController@edit'   );
    Route::delete('{id}'         , 'Admin\EmailController@delete'         )->middleware('requiredMaster');
  });
  /**
  * Administrar Seguridad
  */
  Route::group(['prefix' => 'admin/activity', 'middleware' => 'watchSession'], function () {
    Route::get(''             , 'Security\SecurityContoller@index'    );
    Route::get('showLog'      , 'Security\SecurityContoller@showLog'  );
    Route::get('exportLog'    , 'Security\SecurityContoller@exportLog');
  });
  /**
  * Administar Clientes [optimize with 'match' && middleware]
  */
  Route::group(['prefix' => 'admin/clients', 'middleware' => 'watchSession'], function () {
    Route::get(''                , 'Admin\ClientController@index'             );
    Route::match(['get','post']  , 'new', 'Admin\ClientController@create'     );
    Route::match(['get','patch'] , '{id}', 'Admin\ClientController@edit'      );
    Route::get('{id}/view'       , 'Admin\ClientController@view'              );
    Route::delete('{id}'         , 'Admin\ClientController@delete'            )->middleware('requiredMaster');
    Route::match(['get','post']  , '{id}/mail', 'Admin\ClientController@mail' );
  });
  /**
  * Administar Pruebas [optimize with 'match' && middleware]
  */
  Route::group(['prefix' => 'admin/tests', 'middleware' => 'watchSession'], function () {
    Route::get(''                 , 'Admin\TestController@index'            );
    Route::match(['get','patch']  , '{id}', 'Admin\TestController@edit'     );
    Route::match(['get','post']   , '{id}/mail', 'Admin\TestController@mail');
    Route::match(['get','post']   , 'new', 'Admin\TestController@create'    );
    Route::post('{id}'            , 'Admin\TestController@contract'         );
    Route::delete('{id}'          , 'Admin\TestController@delete'           )->middleware('requiredMaster');
    Route::get('ajax/all'         , 'Admin\TestController@ajaxAll'          );
    Route::patch('{id}/review'    , 'Admin\TestController@review'           );
    Route::get('{id}/terms'       , 'Admin\TestController@showTerms'        );
    Route::get('{id}/incidences'  , 'Admin\TestController@incidence'        );
    Route::get('{id}/bugs'        , 'Admin\TestController@bug'              );
    Route::patch('{id}/bugs/{bug}'            , 'Admin\IncidenceController@resolveBug'       );
    Route::patch('{id}/incidences/{incidence}', 'Admin\IncidenceController@resolveIncidence' );
  });
  /**
  * Administar Contactos [optimize with 'match' && middleware]
  */
  Route::group(['prefix' => 'admin/contacts', 'middleware' => 'watchSession'], function () {
    Route::get(''                , 'Admin\ContactController@index'              );
    Route::match(['get','post']  , 'new'      , 'Admin\ContactController@create');
    Route::match(['get','patch'] , '{id}'     , 'Admin\ContactController@edit'  );
    Route::match(['get','post']  , '{id}/mail', 'Admin\ContactController@mail'  );
    Route::delete('{id}'         , 'Admin\ContactController@delete'             )->middleware('requiredMaster');
    Route::get('{id}/mail'       , 'Admin\ContactController@mail'               );
    Route::post('{id}/mail'      , 'Admin\ContactController@mail'               );
  });
  /**
  * Administrar Noticias [optimize with 'match' && middleware]
  */
  Route::group(['prefix' => 'admin/notices', 'middleware' => 'watchSession'], function () {
    Route::get(''                   , 'Admin\NoticeController@index'         );
    Route::match(['get','post']     , 'new' , 'Admin\NoticeController@create');
    Route::match(['get','patch']    , '{id}', 'Admin\NoticeController@edit'  );
    Route::get('{id}/view'          , 'Admin\NoticeController@view'          );
    Route::delete('{id}'            , 'Admin\NoticeController@delete'        )->middleware('requiredMaster');
    Route::get('{id}/check'         , 'Admin\NoticeController@check'         );
    Route::get('{id}/check/reload'  , 'Admin\NoticeController@reload'        );
    Route::get('{id}/aproved'       , 'Admin\NoticeController@aproved'       );
  });
  /**
  * Administrar Solicitudes [optimize with 'match' && middleware]
  */
  Route::group(['prefix' => 'admin/solicitudes', 'middleware' => 'watchSession'], function () {
    Route::get(''               , 'Admin\SolicitudeController@index'              );
    Route::match(['get','post'] , 'new'      , 'Admin\SolicitudeController@create');
    Route::match(['get','patch'], '{id}'     , 'Admin\SolicitudeController@edit'  );
    Route::match(['get','post'] , '{id}/mail', 'Admin\SolicitudeController@mail'  );
    Route::post('{id}'          , 'Admin\SolicitudeController@test'               );
    Route::delete('{id}'        , 'Admin\SolicitudeController@delete'             )->middleware('requiredMaster');
    Route::get('{id}/viewClient', 'Admin\SolicitudeController@viewClient'         );
  });
  /**
  * Administrar Usuarios [optimize with 'match' && middleware]
  */
  Route::group(['prefix' => 'admin/users', 'middleware' => 'watchSession'], function () {
    Route::get(''               , 'Admin\UserController@index'          );
    Route::match(['get', 'post'] , 'new'  , 'Admin\UserController@create');
    Route::match(['get', 'patch'], '{id}' , 'Admin\UserController@edit'  );
    Route::match(['get', 'post'] , '{user}/access' , 'Admin\UserController@access');
    Route::match(['get', 'post'] , '{user}/solicitude' , 'Admin\UserController@solicitude'); /** ## **/
    Route::match(['get', 'post'], '{id}/notifiable' , 'Admin\UserController@notifiable'  )->middleware('requiredMaster');
    Route::get('{id}/view'      , 'Admin\UserController@view'           );
    Route::delete('{id}'        , 'Admin\UserController@delete'         )->middleware('requiredMaster');
  });
  /**
  * Administrar Contratos [optimize with 'match' && middleware]
  */
  Route::group(['prefix' => 'admin/contracts', 'middleware' => 'watchSession'], function () {
    Route::get(''                , 'Admin\ContractController@index'                          );
    Route::get('{id}/payments'   , 'Admin\ContractController@payments'                       );
    Route::match(['get','patch'] , '{id}'           , 'Admin\ContractController@edit'        );
    Route::match(['get','post']  , 'new'            , 'Admin\ContractController@create'      );
    Route::match(['get','post']  , '{id}/mail'      , 'Admin\ContractController@mail'        );
    Route::match(['get','post']  , '{id}/incidences', 'Admin\ContractController@incidence'   );
    Route::get('{id}/view'       , 'Admin\ContractController@view'                           );
    Route::delete('{id}'         , 'Admin\ContractController@delete'                         )->middleware('requiredMaster');
    Route::get('{id}/bugs'       , 'Admin\ContractController@bug'                            );
    Route::get('{id}/contract'   , 'Admin\ContractController@contract'                       );
    Route::patch('{id}/bugs/{bug}'            , 'Admin\IncidenceController@resolveBug'       );
    Route::patch('{id}/incidences/{incidence}', 'Admin\IncidenceController@resolveIncidence' );
  });
  /**
  * Administrar Incidencias [optimize with 'match' && middleware]
  */
  Route::group(['prefix' => 'admin/incidences', 'middleware' => 'watchSession'], function () {
    Route::get(''                , 'Admin\IncidenceController@index'            );
    Route::get('{id}/view'       , 'Admin\IncidenceController@view'             );
    Route::delete('{id}'         , 'Admin\IncidenceController@delete'           )->middleware('requiredMaster');
    Route::match(['get','post']  , '{id}/mail', 'Admin\IncidenceController@mail');
  });
  /**
  * Api para ics-app [protected with cors]
  */
  Route::group(['prefix' => 'api'], function () {
    Route::get('test/client/{url}'    , 'Admin\TestController@apiClient')->middleware('cors');     // Devuelve los datos de una prueba
    Route::post('incidence/new'       , 'Admin\IncidenceController@create')->middleware('cors');   // Reporta una incidencia o bug
    Route::get('contract/client/{url}', 'Admin\ContractController@apiClient')->middleware('cors'); // Devuelve los datos de un contrato
  });
  /**
  *
  */
  Route::group(['prefix' => 'error'], function () {
    Route::get('method-not-found', 'Exception\ExceptionController@methodNotFound');
  });
