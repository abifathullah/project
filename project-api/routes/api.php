<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers')->group(function () {
    Route::middleware(['secure.headers', 'throttle:login'])->post('/login', 'AuthController@login');
    Route::middleware('secure.headers')->get('/versions/base', 'VersionController@getVersions');

    Route::middleware(['secure.headers', 'throttle:api', 'auth:sanctum'])->group(function () {
        Route::post('/logout', 'AuthController@logout');
        Route::apiResource('/users', 'UserController');

        Route::controller('ProductCategoryController')->group(function () {
            Route::apiResource('/product-categories', 'ProductCategoryController');
        });

        Route::controller('ProductController')->group(function () {
            Route::apiResource('/products', 'ProductController');
            Route::get('/products-filter', 'filter');
        });
    });
});
