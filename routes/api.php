<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'Api\AuthController@login');
    Route::post('logout', 'Api\AuthController@logout');
    Route::post('refresh', 'Api\AuthController@refresh');
    Route::post('me', 'Api\AuthController@me');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'kegiatan'

], function ($router) {

    Route::post('get', 'Api\Kegiatan_Controller@show');
    Route::post('create', 'Api\Kegiatan_Controller@create');
    Route::post('update', 'Api\Kegiatan_Controller@update');
    Route::post('delete', 'Api\Kegiatan_Controller@delete');

    //tahapan
    Route::post('{$idKegiatan}/get', 'Api\Kegiatan_Controller@tahapan_show');
    Route::post('{$idKegiatan}/create', 'Api\Kegiatan_Controller@tahapan_create');
    Route::post('{$idKegiatan}/update', 'Api\Kegiatan_Controller@tahapan_update');
    Route::post('{$idKegiatan}/delete', 'Api\Kegiatan_Controller@tahapan_delete');

    //alokasi
    Route::post('{$idKegiatan}/alokasi/{$idKegiatanTahapan}/get', 'Api\Kegiatan_Controller@tahapan_alokasi_show');
    Route::post('{$idKegiatan}/alokasi/{$idKegiatanTahapan}/create', 'Api\Kegiatan_Controller@tahapan_alokasi_create');
    Route::post('{$idKegiatan}/alokasi/{$idKegiatanTahapan}/update', 'Api\Kegiatan_Controller@tahapan_alokasi_update');
    Route::post('{$idKegiatan}/alokasi/{$idKegiatanTahapan}/delete', 'Api\Kegiatan_Controller@tahapan_alokasi_delete');
    Route::post('{$idKegiatan}/alokasi/{$idKegiatanTahapan}/start', 'Api\Kegiatan_Controller@tahapan_alokasi_start');
    Route::post('{$idKegiatan}/alokasi/{$idKegiatanTahapan}/stop', 'Api\Kegiatan_Controller@tahapan_alokasi_stop');

    //Capaian
    Route::post('{$idKegiatan}/capaian/get', 'Api\Kegiatan_Controller@tahapan_alokasi_show');
    Route::post('{$idKegiatan}/capaian/create', 'Api\Kegiatan_Controller@tahapan_alokasi_create');
    Route::post('{$idKegiatan}/capaian/update', 'Api\Kegiatan_Controller@tahapan_alokasi_update');

     

});


Route::group([

    'middleware' => 'api',
    'prefix' => 'dl'

], function ($router) {

    Route::post('get', 'Api\DL_Controller@show');
    Route::post('update_alokasi', 'Api\DL_Controller@update');
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'capaian'

], function ($router) {
    //umum
    Route::post('getBeranda', 'Api\Capaian_Controller@getBeranda');
    //perorangan
    Route::post('get', 'Api\Capaian_Controller@get');
    Route::post('update', 'Api\Capaian_Controller@update');

     //Seksi
     Route::post('getSeksi', 'Api\Capaian_Controller@getSeksi');
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'ckp'

], function ($router) {

    Route::post('ckp_t/get', 'Api\CKP_Controller@target_get');
    Route::post('ckp_t/create', 'Api\CKP_Controller@target_create');
    Route::post('ckp_t/add', 'Api\CKP_Controller@target_add');
    Route::post('ckp_t/update', 'Api\CKP_Controller@target_update');
    Route::post('ckp_t/submit', 'Api\CKP_Controller@target_submit');

    Route::post('ckp_r/get', 'Api\CKP_Controller@real_get');
    Route::post('ckp_r/create', 'Api\CKP_Controller@real_create');
    Route::post('ckp_t/add', 'Api\CKP_Controller@real_add');
    Route::post('ckp_r/update', 'Api\CKP_Controller@real_update');
    Route::post('ckp_r/submit', 'Api\CKP_Controller@real_submit');

});
