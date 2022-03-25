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

$router->get('/test', 'EquipmentController@test');

$router->group(['prefix'=>'api'], function () use ($router){
    $router->get('/equipment', 'EquipmentController@getEquipment');
    $router->post('/equipment', 'EquipmentController@createEquipment');
    $router->get('/equipment/{id}', 'EquipmentController@getEquipmentById');
    //было PUT и DELETE соответственно, но перестало работать при переходе на рабочий компьютер. Не совсем понимаю, в чем проблема
    $router->post('/equipment/edit/', 'EquipmentController@editEquipment');
    $router->post('/equipment/delete/', 'EquipmentController@deleteEquipment');

    $router->get('/equipment/types','EquipmentController@getEquipmentTypes');
    $router->post('/equipment/types', 'EquipmentController@createEquipmentTypes');
});
