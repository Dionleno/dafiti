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

$router->group(['prefix' => 'v2'], function () use ($router) {
    $router->get('beers','BeersController@index');//Get Beers
    $router->get('beers/filter','BeersController@filter');//Parameters
    $router->get('beer/{id}','BeersController@singlebeer');//Single Beer
    $router->get('beers/random','BeersController@random');//Random
    $router->get('beers/page/{page}/{totalPage}','BeersController@paginate');//Pagination
});
