<?php

/*
|----------------------------------
| UPS
|----------------------------------
*/
Route::any('api/v1/ups/rate',   'Syscover\Ups\Controllers\RateController@index')->name('upsRate');


