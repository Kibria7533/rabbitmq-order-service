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
use Illuminate\Support\Facades\Route;

Route::get('/start-queue', function () {
    \Illuminate\Support\Facades\Artisan::call('queue:work',['--queue'=>'order.q']);
});
$router->get('/', function () {
    return 'Hello World from order service';
});
$router->get('/orders', ["as" => "orders", "uses" => "OrderController@getOrder"]);
$router->post('/store', ["as" => "orders.store", "uses" => "OrderController@store"]);
$router->delete('/delete/{id}', ["as" => "orders.delete", "uses" => "OrderController@delete"]);
