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




//Free to browse controllers
Route::get('/', 'HomeController@home');

Route::match(array('GET', 'POST'), "/login", 'Auth\AuthController@login');
Route::match(array('GET', 'POST'),"/contacts/newsletter-signup", 'ContactsController@newsletterSignup');
Route::match(array('GET'),'/'.Lang::get('routes.front.campaigns',[], env('LANGUAGE')).'/{action}/{params?}', 'CampaignsController@index');
Route::match(array('GET', 'POST'),'/'.Lang::get('routes.front.donors',[], env('LANGUAGE')).'/{action}/{params?}', 'DonorsController@index');
Route::match(array('GET', 'POST'),'/'.Lang::get('routes.front.donations',[], env('LANGUAGE')).'/{action}/{params?}', 'DonationsController@index');
Route::match(array('GET', 'POST'),'/'.Lang::get('routes.front.pages',[], env('LANGUAGE')).'/{action}/{params?}', 'PagesController@index');
//Ajax
Route::match(array('GET', 'POST'),'/ajax/{action}/{params?}', 'AjaxController@index');


//Authenticated users of site controllers
Route::group(['middleware' => 'auth'], function () {

});


//Admin controllers
Route::group(['middleware' => 'auth', 'prefix' => '/admin'], function () {
    Route::get('/{params?}', 'Admin\AdminController@home');

    //Overviews
    Route::match(array('GET', 'POST'),'/overview/{action}/{params?}', 'Admin\AdminController@index');

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

    //Donations
    Route::match(array('GET', 'POST'),'/donation/{action}/{params?}', 'Admin\DonationController@index');

    //Donors
    Route::match(array('GET', 'POST'),'/donor/{action}/{params?}', 'Admin\DonorController@index');

    //Administrators
    Route::match(array('GET', 'POST'),'/user/{action}/{params?}', 'Admin\UserController@index');

    //Beneficiaries
    Route::match(array('GET', 'POST'),'/beneficiary/{action}/{params?}', 'Admin\BeneficiaryController@index');

    //Campaigns
    Route::match(array('GET', 'POST'),'/campaign/{action}/{params?}', 'Admin\CampaignController@index');

    //Filemanager
    Route::match(array('GET', 'POST', 'FILES'),'/file/{action}/{params?}', 'Admin\FileController@index');

    //Logs
    Route::match(array('GET', 'POST'),'/log/{action}/{params?}', 'Admin\LogController@index');

    //Settings
    Route::match(array('GET', 'POST'),'/settings/{action}/{params?}', 'Admin\SettingsController@index');


});
Route::auth();

