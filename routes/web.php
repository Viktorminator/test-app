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

use Illuminate\Support\Facades\DB;

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->post('register', 'UserController@createUser');
        $router->post('sign-in', 'UserController@authenticate');
        $router->post('recover-password', 'UserController@recoverPassword');
        $router->patch('recover-password', 'UserController@recoverPassword');
    });
});

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => 'api'], function () use ($router) {
        $router->group(['prefix' => 'user'], function () use ($router) {
            $router->get('companies', 'CompanyController@getCompanies');
            $router->post('companies', 'CompanyController@createCompany');
        });
    });
});

$router->get('/test', function () use ($router) {
    try {
        DB::connection()->getPdo();
        print_r("Connection is ok <br>");
    } catch (\Exception $e) {
        die("Could not connect to the database.  Please check your configuration. error:" . $e );
    }

    return $router->app->version();
});
