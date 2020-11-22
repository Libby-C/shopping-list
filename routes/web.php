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

$router->get('/', function () use ($router) {
    return "Hello";
});
$router->get('user/{id}/lists', 'ShoppingListController@get');
$router->post('user/{user_id}/lists/{list_id}', 'ShoppingListController@addToList');
$router->delete('user/{user_id}/lists/{list_id}', 'ShoppingListController@removeFromList');
