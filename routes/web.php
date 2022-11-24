<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/login', 'Web\Auth@showLoginForm')->name('login');
Route::post('/login', 'Web\Auth@login');
Route::get('/logout', 'Web\Auth@logout')->name('logout');


Route::get('/home', 'Web\Web_Controller@webshow');
Route::get('/seksi', 'Web\Web_Controller@webshow');
Route::get('/individu', 'Web\Web_Controller@webshow');

Route::post('/home', 'Web\Capaian_Controller@getBeranda');
Route::post('/seksi', 'Web\Capaian_Controller@getSeksi');
Route::post('/individu', 'Web\Capaian_Controller@getOnlyYou');

Route::post('/getListUser', 'Web\Web_Controller@getListUser');
Route::post('/getListMitra', 'Web\Web_Controller@getListMitra');
Route::post('/getListReferensi', 'Web\Web_Controller@getListReferensi');


Route::get('/ckp', 'Web\Web_Controller@webshow');
Route::get('/dl', 'Web\Web_Controller@webshow');

// Route::get('/refresh', 'Web\Capaian_Controller@refresh_all_capaian');
// Route::get('uuid', function () {
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
//     echo (string) Uuid::generate();
//     echo "<br>";
// });



Route::group([

    'middleware' => 'web',
    'prefix' => 'kegiatan'

], function ($router) {

    Route::post('get', 'Web\Kegiatan_Controller@list_kegiatan');
    Route::get('create', 'Web\Web_Controller@webshow');
    Route::post('create', 'Web\Kegiatan_Controller@createKegiatan');
    Route::post('{idKegiatan}/update', 'Web\Kegiatan_Controller@updateKegiatan');
    Route::post('{idKegiatan}/delete', 'Web\Kegiatan_Controller@deleteKegiatan');
    Route::get('{idKegiatan}', 'Web\Web_Controller@webshow');
    Route::post('{idKegiatan}', 'Web\Kegiatan_Controller@Kegiatan_show');

    //excel
    // Route::post('{idKegiatan}/downloadTemplate', 'Web\Kegiatan_Controller@downloadTemplate');
    // Route::post('{idKegiatan}/uploadTemplate', 'Web\Kegiatan_Controller@uploadTemplate');

    Route::post('{idKegiatan}/addNewPJ', 'Web\Kegiatan_Controller@addNewPJ');
    Route::post('{idKegiatan}/deleteNewPJ', 'Web\Kegiatan_Controller@deleteNewPJ');

    //tahapan
    Route::get('{idKegiatan}/tahapan/{idKegiatanTahapan}/show', 'Web\Web_Controller@webshow');
    Route::get('{idKegiatan}/tahapan/{idKegiatanTahapan}/capaian/show', 'Web\Web_Controller@webshow');
    Route::post('{idKegiatan}/tahapan/{idKegiatanTahapan}/show', 'Web\Kegiatan_Controller@tahapanKegiatan_show');

    Route::post('{idKegiatan}/tahapan/create', 'Web\Kegiatan_Controller@tahapanKegiatan_create');
    Route::post('{idKegiatan}/tahapan/{idKegiatanTahapan}/update', 'Web\Kegiatan_Controller@tahapanKegiatan_update');
    Route::post('{idKegiatan}/tahapan/{idKegiatanTahapan}/delete', 'Web\Kegiatan_Controller@tahapanKegiatan_delete');
    Route::post('{idKegiatan}/tahapan/{idKegiatanTahapan}/start', 'Web\Kegiatan_Controller@tahapanKegiatan_start');
    Route::post('{idKegiatan}/tahapan/{idKegiatanTahapan}/stop', 'Web\Kegiatan_Controller@tahapanKegiatan_stop');

    //alokasi
    Route::post('{idKegiatan}/tahapan/{idKegiatanTahapan}/alokasi', 'Web\Kegiatan_Controller@tahapanKegiatan_alokasi');
});

Route::group([

    'middleware' => 'web',
    'prefix' => 'capaian'

], function ($router) {
    //umum
    Route::get('get', 'Web\Web_Controller@webshow');
    Route::post('get', 'Web\Capaian_Controller@getIndividu');
    //perorangan
    Route::post('/seksi/{idCapaianSeksi}/update', 'Web\Capaian_Controller@updateCapaianSeksi');
    Route::post('/individu/{idCapaianIndividu}/update', 'Web\Capaian_Controller@updateCapaianIndividu');
});


Route::group([

    'middleware' => 'web',
    'prefix' => 'ckp'

], function ($router) {

    Route::get('show', 'Web\Web_Controller@webshow');
    Route::get('create', 'Web\Web_Controller@webshow');

    Route::get('print/target/{month}/{year}', 'Web\CKP_Controller@print_t');
    Route::get('print/realisasi/{month}/{year}', 'Web\CKP_Controller@print_r');

    Route::post('show/{month}/{year}', 'Web\CKP_Controller@showCKP');

    Route::post('ckp_t/{month}/{year}/create/get', 'Web\CKP_Controller@target_get');
    Route::post('ckp_t/{month}/{year}/create/submit', 'Web\CKP_Controller@target_submit');

    Route::post('ckp_r/{month}/{year}/add', 'Web\CKP_Controller@real_add');
    Route::post('ckp_r/{month}/{year}/update/{idCKPItem}', 'Web\CKP_Controller@real_update');
    Route::post('ckp_r/{month}/{year}/delete/{idCKPItem}', 'Web\CKP_Controller@real_delete');
    Route::post('ckp_r/{month}/{year}/submit', 'Web\CKP_Controller@real_submit');
});



Route::group([

    'middleware' => 'web',
    'prefix' => 'dl'

], function ($router) {
    Route::get('get', 'Web\Web_Controller@webshow');

    Route::post('get/{month}/{year}', 'Web\DL_Controller@showDL');
    Route::post('get/{month}/{year}/{nip_lama}', 'Web\DL_Controller@showDL');
    Route::post('update_dl/{idAlokasiKegiatanTahapan}', 'Web\DL_Controller@updateDL');
    //action 1: create 2:update 3:delete
});

