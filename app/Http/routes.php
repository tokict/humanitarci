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

Route::group(['middleware' => 'guest'], function () {
Route::get('/', 'HomeController@index');
Route::get("/login", 'Auth\AuthController@login');
Route::post("/login", 'Auth\AuthController@login');

//Free to browse controllers
Route::match(array('GET', 'POST'),"/contacts/newsletter-signup", 'ContactsController@newsletterSignup');
Route::match(array('GET', 'POST'),'/'.Lang::get('routes.front.campaigns',[], env('LANGUAGE')).'/{action}/{params?}', 'CampaignsController@index');
});

//Authenticated users of site controllers
Route::group(['middleware' => 'auth'], function () {

    Route::get('user/profile', function () {
        // Uses Auth Middleware
    });
});


//Admin controllers
Route::group(['middleware' => 'auth', 'prefix' => '/admin'], function () {
    Route::get('/', 'Admin\AdminController@index');

    //Ajax
    Route::match(array('GET', 'POST'),'/ajax/{action}/{params?}', 'Admin\AjaxController@index');

    //Persons
    Route::match(array('GET', 'POST'),'/person/{action}/{params?}', 'Admin\PersonController@index');

    //Legal entities
    Route::match(array('GET', 'POST'),'/legal-entity/{action}/{params?}', 'Admin\LegalEntityController@index');

    //Banks
    Route::match(array('GET', 'POST'),'/bank/{action}/{params?}', 'Admin\BankController@index');

    //Organizations
    Route::match(array('GET', 'POST'),'/organization/{action}/{params?}', 'Admin\OrganizationController@index');

    //Administrators
    Route::match(array('GET', 'POST'),'/user/{action}/{params?}', 'Admin\UserController@index');

    //Beneficiaries
    Route::match(array('GET', 'POST'),'/beneficiary/{action}/{params?}', 'Admin\BeneficiaryController@index');

    //Campaigns
    Route::match(array('GET', 'POST'),'/campaign/{action}/{params?}', 'Admin\CampaignController@index');

    //Filemanager
    Route::match(array('GET', 'POST', 'FILES'),'/file/{action}/{params?}', 'Admin\FileController@index');


});
Route::auth();

