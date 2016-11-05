<?php

$pattern = '[a-z0-9\_\=]+';

Route::group([
    'prefix'    => 'admin',
    'namespace' => 'Terranet\Administrator',
    'middleware'=> ['web'],
], function () use ($pattern) {
    /*
    |-------------------------------------------------------
    | Authentication
    |-------------------------------------------------------
    */
    Route::get('login', [
        'as'   => 'scaffold.login',
        'uses' => 'AuthController@getLogin',
    ]);
    Route::post('login', 'AuthController@postLogin');
    Route::get('logout', [
        'as'   => 'scaffold.logout',
        'uses' => 'AuthController@getLogout',
    ]);

    /*
    |-------------------------------------------------------
    | Main Scaffolding routes
    |-------------------------------------------------------
    */
    Route::group([], function () use ($pattern) {
        /*
        |-------------------------------------------------------
        | Custom routes
        |-------------------------------------------------------
        |
        | Controllers that shouldn't be handled by Scaffolding controller
        | goes here.
        |
        */
        // Edit Item


        /*
        |-------------------------------------------------------
        | Scaffolding routes
        |-------------------------------------------------------
        */
        // Dashboard
        Route::get('/', [
            'as'   => 'scaffold.dashboard',
            'uses' => 'DashboardController@index',
        ]);

        // Index
        Route::get('{module}', [
            'as'   => 'scaffold.index',
            'uses' => 'Controller@index',
        ])->where('module', $pattern);

        // Create new Item
        Route::get('{module}/create', [
            'as'   => 'scaffold.create',
            'uses' => 'Controller@create',
        ])->where('module', $pattern);

        // Save new item
        Route::post('{module}/create', 'Controller@store')->where('module', $pattern);

        // View Item
        Route::get('{module}/{id}', [
            'as'   => 'scaffold.view',
            'uses' => 'Controller@view',
        ])->where('module', $pattern);

        // Edit Item
        Route::get('{module}/{id?}/edit', [
            'as'   => 'scaffold.edit',
            'uses' => 'Controller@edit',
        ])->where('module', $pattern);

        // Save Item
        Route::post('{module}/{id?}/edit', [
            'as'   => 'scaffold.update',
            'uses' => 'Controller@update',
        ])->where('module', $pattern);

        // Delete Item
        Route::get('{module}/{id}/delete', [
            'as'   => 'scaffold.delete',
            'uses' => 'Controller@delete',
        ])->where('module', $pattern);

        // Delete attachment
        Route::get('{module}/{id}/delete/attachment/{attachment}', [
            'as'   => 'scaffold.delete_attachment',
            'uses' => 'Controller@deleteAttachment',
        ])->where('module', $pattern);

        // Custom method
        Route::get('{module}/{id}/{action}', [
            'as'   => 'scaffold.action',
            'uses' => 'Controller@action',
        ])->where('module', $pattern);

        // Custom method
        Route::get('{module}/{id}/do/{action}', [
            'as'   => 'scaffold.action',
            'uses' => 'Controller@customAction',
        ])->where('module', $pattern);

        // Custom batch method
        Route::post('{module}/batch-action', [
            'as'   => 'scaffold.batch',
            'uses' => 'BatchController@batch',
        ])->where('module', $pattern);

        // Export collection url
        Route::get('{module}.{format}', [
            'as'   => 'scaffold.export',
            'uses' => 'BatchController@export',
        ])->where('module', $pattern);
    });
});
