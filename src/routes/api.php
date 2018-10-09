<?php

Route::group(['prefix' => 'api/v1', 'middleware' => ['api', 'client']], function () {
    Route::any('ups/rate', 'Syscover\Ups\Controllers\RateController@index')->name('api.ups_rate');
});


