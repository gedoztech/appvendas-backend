<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

//Managers
$router->group(['prefix' => 'managers'], function () use ($router) {
    $router->get('/', 'ManagerController@index');
    $router->get('/{id}', 'ManagerController@show');
});

//Sellers
$router->group(['prefix' => 'sellers'], function () use ($router) {
    $router->get('/', 'SellerController@index');
    $router->get('/{id}', 'SellerController@show');
    $router->post('/create', 'SellerController@store');
    $router->put('/{id}', 'SellerController@update');
    $router->delete('/{id}', 'SellerController@destroy');
});

//Sales
$router->group(['prefix' => 'sales'], function () use ($router) {
    $router->get('/', 'SaleController@index');
    $router->get('/{id}', 'SaleController@show');
    $router->post('/create', 'SaleController@store');
    $router->put('/{id}', 'SaleController@update');
    $router->delete('/{id}', 'SaleController@destroy');
});