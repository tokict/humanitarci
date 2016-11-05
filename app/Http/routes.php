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

Route::get('/', function () {
    return view('welcome');
});
Route::get("/login", 'Auth\AuthController@login');
Route::post("/login", 'Auth\AuthController@login');

//Free to browse controllers
Route::get("/contacts/newsletter-signup", 'ContactsController@newsletterSignup');


//Authenticated users of site controllers
Route::group(['middleware' => 'auth'], function () {

    Route::get('user/profile', function () {
        // Uses Auth Middleware
    });
});


//Admin controllers
Route::group(['middleware' => 'auth', 'prefix' => '/admin'], function () {
    Route::get('/', 'AdminController@index');


});
Route::auth();

Route::get('/home', 'HomeController@index');
