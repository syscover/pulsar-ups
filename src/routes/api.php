<?php

/*
|----------------------------------
| UPS
|----------------------------------
*/
Route::post('api/v1/ups/rate',   'Syscover\Ups\Controllers\RateController@index')->name('upsRate');


