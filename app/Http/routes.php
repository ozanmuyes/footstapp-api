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

/**
 * @var \Dingo\Api\Routing\Router $api
 */
$api = app('Dingo\Api\Routing\Router');

$api->version("v1", function () use ($api) {
  $api->post('token-auth', '\FootStapp\Http\Controllers\v1\AuthenticateController@authenticate');
  $api->post('token-refresh', '\FootStapp\Http\Controllers\v1\AuthenticateController@refresh');

//  $api->group(["prefix" => "users"], function () use ($api) {
  $api->group(["prefix" => "users", "middleware" => "api.auth"], function () use ($api) {
    $api->get('/', '\FootStapp\Http\Controllers\v1\UsersController@index');
  });

  $api->group(["prefix" => "user-groups"], function () use ($api) {
//  $api->group(["prefix" => "user-groups", "middleware" => "api.auth"], function () use ($api) {
    $api->get('/', '\FootStapp\Http\Controllers\v1\UserGroupsController@index');
    $api->get('{id}', '\FootStapp\Http\Controllers\v1\UserGroupsController@show');
  });

  $api->group(["prefix" => "permissions"], function () use ($api) {
//  $api->group(["prefix" => "permissions", "middleware" => "api.auth"], function () use ($api) {
    $api->get('/', '\FootStapp\Http\Controllers\v1\PermissionsController@index');
    $api->get('{id}', '\FootStapp\Http\Controllers\v1\PermissionsController@show');
  });
});

Route::get('/', function () {
  return view('welcome');
});
