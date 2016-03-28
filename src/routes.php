<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can any all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['middleware' => ['web', 'pulsar']], function() {

    /*
    |--------------------------------------------------------------------------
    | SPAS
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/hotels/spas/{lang}/{offset?}',                                    ['as'=>'spa',                    'uses'=>'Syscover\Spas\Controllers\SpaController@index',                      'resource' => 'spas-spa',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/hotels/spas/json/data/{lang}',                                    ['as'=>'jsonDataSpa',            'uses'=>'Syscover\Spas\Controllers\SpaController@jsonData',                   'resource' => 'spas-spa',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/hotels/spas/create/{lang}/{offset}/{tab}/{id?}',                  ['as'=>'createSpa',              'uses'=>'Syscover\Spas\Controllers\SpaController@createRecord',               'resource' => 'spas-spa',        'action' => 'create']);
    Route::post(config('pulsar.appName') . '/hotels/spas/store/{lang}/{offset}/{tab}/{id?}',                  ['as'=>'storeSpa',               'uses'=>'Syscover\Spas\Controllers\SpaController@storeRecord',                'resource' => 'spas-spa',        'action' => 'create']);
    Route::get(config('pulsar.appName') . '/hotels/spas/{id}/edit/{lang}/{offset}/{tab}',                     ['as'=>'editSpa',                'uses'=>'Syscover\Spas\Controllers\SpaController@editRecord',                 'resource' => 'spas-spa',        'action' => 'access']);
    Route::put(config('pulsar.appName') . '/hotels/spas/update/{lang}/{id}/{offset}/{tab}',                   ['as'=>'updateSpa',              'uses'=>'Syscover\Spas\Controllers\SpaController@updateRecord',               'resource' => 'spas-spa',        'action' => 'edit']);
    Route::get(config('pulsar.appName') . '/hotels/spas/delete/{lang}/{id}/{offset}',                         ['as'=>'deleteSpa',              'uses'=>'Syscover\Spas\Controllers\SpaController@deleteRecord',               'resource' => 'spas-spa',        'action' => 'delete']);
    Route::get(config('pulsar.appName') . '/hotels/spas/delete/translation/{lang}/{id}/{offset}',             ['as'=>'deleteTranslationSpa',   'uses'=>'Syscover\Spas\Controllers\SpaController@deleteTranslationRecord',    'resource' => 'spas-spa',        'action' => 'delete']);
    Route::delete(config('pulsar.appName') . '/hotels/spas/delete/select/records/{lang}',                     ['as'=>'deleteSelectSpa',        'uses'=>'Syscover\Spas\Controllers\SpaController@deleteRecordsSelect',        'resource' => 'spas-spa',        'action' => 'delete']);
    Route::post(config('pulsar.appName') . '/hotels/spas/check/hotel/slug',                                   ['as'=>'apiCheckSlugSpa',        'uses'=>'Syscover\Spas\Controllers\SpaController@apiCheckSlug',               'resource' => 'spas-spa',        'action' => 'access']);
});