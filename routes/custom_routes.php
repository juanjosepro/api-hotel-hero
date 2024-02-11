<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// https://api-domain/commands/php-artisan-clear
Route::group(['prefix' => 'commands'], function () {
    Route::get('php-artisan-clear', function() {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');

        return "Cleared!";
    });

    Route::get('php-artisan-storage-link', function() {
        // Artisan::call("storage:link");
        // or
        if (file_exists(public_path('storage'))) {
            return 'The "public/storage" directory  already exists';
        }

        app('files')->link(
            storage_path('app/public'), public_path('storage')
        );

        return 'The "public/storage" directory has been linked';
    });

    Route::get('/php-artisan-migrate', function () {
        Artisan::call('migrate');
    });

    Route::get('/php-artisan-migrate-seed', function () {
        Artisan::call('migrate', ['--seed' => true]);
    });

});
