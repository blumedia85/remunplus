<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/', "Mentordeveloper\\Authentication\\Controllers\\AuthController@getClientLogin");
Route::get('/payadmin', "Mentordeveloper\\Authentication\\Controllers\\AuthController@getAdminLogin");
Route::get('/company', "Mentordeveloper\Authentication\Controllers\DashboardController@base");
