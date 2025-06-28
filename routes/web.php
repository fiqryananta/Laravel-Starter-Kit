<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::namespace('App\Http\Controllers\Backend')->group(function () {
    
    Route::group(['prefix' => 'authentication', 'as' => 'authentication.'], function() {
    
        Route::any('/login', 'AuthController@login')->name('login');
        Route::any('/logout', 'AuthController@logout')->name('logout');
        Route::any('/forgot-password/{token?}', 'AuthController@forgot_password')->name('forgot_password');
        Route::any('/change-password/{token?}', 'AuthController@change_password')->name('change_password');
        Route::any('/registration', 'AuthController@registration')->name('registration');
        Route::any('/confirm-email/{token}', 'AuthController@confirm_email')->name('confirm_email');
        Route::any('/verify-email/{token}', 'AuthController@verify_email')->name('verify_email');
        Route::any('/confirm-email-resend/{token}', 'AuthController@confirm_email_resend')->name('confirm_email_resend');

        Route::any('/terms-of-service', 'AuthController@terms_of_service')->name('terms_of_service');
        Route::any('/privacy-policy', 'AuthController@privacy_policy')->name('privacy_policy');

    });
    
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function() {
    
        Route::any('/', 'DashboardController@index')->name('index');

    });
    
    Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
    
        Route::any('/', 'UserController@index')->name('index');
        Route::any('/add', 'UserController@add')->name('add');
        Route::any('/{id}/edit', 'UserController@edit')->name('edit');
        Route::post('/{id}/delete', 'UserController@delete')->name('delete');

    });
    
    Route::group(['prefix' => 'role', 'as' => 'role.'], function() {
    
        Route::any('/', 'RoleController@index')->name('index');
        Route::any('/add', 'RoleController@add')->name('add');
        Route::any('/{id}/edit', 'RoleController@edit')->name('edit');
        Route::post('/{id}/delete', 'RoleController@delete')->name('delete');

    });
    
    Route::group(['prefix' => 'permission', 'as' => 'permission.'], function() {
    
        Route::any('/', 'PermissionController@index')->name('index');
        Route::any('/add', 'PermissionController@add')->name('add');
        Route::any('/{id}/edit', 'PermissionController@edit')->name('edit');
        Route::post('/{id}/delete', 'PermissionController@delete')->name('delete');

    });

});