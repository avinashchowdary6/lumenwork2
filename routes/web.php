<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
  $router->get('users',  ['uses' => 'UserController@showAllUsers']);

  $router->get('users/{id}', ['uses' => 'UserController@showOneUser']);

  $router->post('users', ['uses' => 'UserController@create']);

  $router->delete('users/{id}', ['uses' => 'UserController@delete']);

  $router->put('users/{id}', ['uses' => 'UserController@update']);
});

Route::group([

  'prefix' => 'api'

], function ($router) {
  Route::post('login', 'AuthController@login');
  Route::post('logout', 'AuthController@logout');
  Route::post('refresh', 'AuthController@refresh');
  Route::post('user-profile', 'AuthController@me');

}); 



$router->group(['middleware' => ['auth', 'verified']], function () use ($router) {
  $router->get('/user', 'AuthController@user');
  $router->post('/email/request-verification', ['as' => 'email.request.verification', 'uses' => 'AuthController@emailRequestVerification']);
  $router->post('/deactivate', 'AuthController@deactivate');
});
$router->post('/reactivate', 'AuthController@reactivate');
$router->post('/password/reset-request', 'RequestPasswordController@sendResetLinkEmail');
$router->post('/password/reset', [ 'as' => 'password.reset', 'uses' => 'ResetPasswordController@reset' ]);
$router->post('/email/verify', ['as' => 'email.verify', 'uses' => 'AuthController@emailVerify']);