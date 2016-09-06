<?php

Route::group(['middleware' => ['web', 'pulsar']], function() {

    /*
    |--------------------------------------------------------------------------
    | SPAS
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.name') . '/spas/spas/{lang}/{offset?}',                                    ['as' => 'spa',                    'uses' => 'Syscover\Spas\Controllers\SpaController@index',                      'resource' => 'spas-spa',        'action' => 'access']);
    Route::any(config('pulsar.name') . '/spas/spas/json/data/{lang}',                                    ['as' => 'jsonDataSpa',            'uses' => 'Syscover\Spas\Controllers\SpaController@jsonData',                   'resource' => 'spas-spa',        'action' => 'access']);
    Route::get(config('pulsar.name') . '/spas/spas/create/{lang}/{offset}/{tab}/{id?}',                  ['as' => 'createSpa',              'uses' => 'Syscover\Spas\Controllers\SpaController@createRecord',               'resource' => 'spas-spa',        'action' => 'create']);
    Route::post(config('pulsar.name') . '/spas/spas/store/{lang}/{offset}/{tab}/{id?}',                  ['as' => 'storeSpa',               'uses' => 'Syscover\Spas\Controllers\SpaController@storeRecord',                'resource' => 'spas-spa',        'action' => 'create']);
    Route::get(config('pulsar.name') . '/spas/spas/{id}/edit/{lang}/{offset}/{tab}',                     ['as' => 'editSpa',                'uses' => 'Syscover\Spas\Controllers\SpaController@editRecord',                 'resource' => 'spas-spa',        'action' => 'access']);
    Route::put(config('pulsar.name') . '/spas/spas/update/{lang}/{id}/{offset}/{tab}',                   ['as' => 'updateSpa',              'uses' => 'Syscover\Spas\Controllers\SpaController@updateRecord',               'resource' => 'spas-spa',        'action' => 'edit']);
    Route::get(config('pulsar.name') . '/spas/spas/delete/{lang}/{id}/{offset}',                         ['as' => 'deleteSpa',              'uses' => 'Syscover\Spas\Controllers\SpaController@deleteRecord',               'resource' => 'spas-spa',        'action' => 'delete']);
    Route::get(config('pulsar.name') . '/spas/spas/delete/translation/{lang}/{id}/{offset}',             ['as' => 'deleteTranslationSpa',   'uses' => 'Syscover\Spas\Controllers\SpaController@deleteTranslationRecord',    'resource' => 'spas-spa',        'action' => 'delete']);
    Route::delete(config('pulsar.name') . '/spas/spas/delete/select/records/{lang}',                     ['as' => 'deleteSelectSpa',        'uses' => 'Syscover\Spas\Controllers\SpaController@deleteRecordsSelect',        'resource' => 'spas-spa',        'action' => 'delete']);
    Route::post(config('pulsar.name') . '/spas/spas/check/hotel/slug',                                   ['as' => 'apiCheckSlugSpa',        'uses' => 'Syscover\Spas\Controllers\SpaController@apiCheckSlug',               'resource' => 'spas-spa',        'action' => 'access']);
});