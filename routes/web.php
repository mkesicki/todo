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

$router->group(['prefix' => 'api/v1/'], function ($app) {
    
    $app->get('login/','UsersController@login');
    $app->post('register/','UsersController@register');


    $app->post('list/','ListsController@create');
    $app->get('list/{id}/', 'ListsController@getById');
    $app->get('list/', 'ListsController@get');
    $app->put('list/{id}/', 'ListsController@update');
    $app->delete('list/{id}/', 'ListsController@delete');
    $app->get('list/{id}/tasks', 'ListsController@getTasks');
    $app->get('list/filter/{filter}', 'ListsController@getFilteredList');

    
    $app->post('task/','TasksController@create');
    $app->get('task/filter/{filter}', 'TasksController@getFiltered');
    $app->get('task/{id}/', 'TasksController@getById');
    $app->put('task/{id}/', 'TasksController@update');
    $app->delete('task/{id}/', 'TasksController@delete');
    

    $app->post('category/','CategoriesController@create');
    $app->get('category/', 'CategoriesController@get');
    $app->get('category/{id}/', 'CategoriesController@getById');
    $app->put('category/{id}/', 'CategoriesController@update');
    $app->delete('category/{id}/', 'CategoriesController@delete');

});

?>
