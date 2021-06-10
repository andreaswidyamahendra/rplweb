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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'HomeController@log');

Auth::routes();

Route::get('redirect/{driver}', 'Auth\LoginController@redirectToProvider')->name('login.provider');
Route::get('{driver}/callback', 'Auth\LoginController@handleProviderCallback')->name('login.callback');

Route::get('/home', 'HomeController@index')->name('home');

//MHS - JADWAL UJIAN
Route::get('/mahasiswa/jadwalUjian', 'MahasiswaController@jadwal_ujian');

//MHS - SURAT KETERANGAN
Route::get('/mahasiswa/SuratKeterangan', 'MahasiswaController@SuratKeterangan');
Route::post('/mahasiswa/ajukanSuratKet', 'MahasiswaController@AjukanSurat');

//MHS - PENGAJUAN KP
Route::get('/mahasiswa/Kp', 'MahasiswaController@Kp');
Route::post('/mahasiswa/ajukanKp', 'MahasiswaController@AjukanKp');

Route::get('/mahasiswa/PraKp', 'MahasiswaController@PraKp');
Route::post('/mahasiswa/ajukanPraKp', 'MahasiswaController@AjukanPraKP');


Route::get('/homeDosen', 'HomeController@index_dosen')->name('homeDosen');

Route::get('/dosen/BimbinganKp', 'DosenController@BimbinganKp');

Route::get('/dosen/{idKp}/{nim}/setUjian', 'DosenController@setUjian');

Route::get('/dosen/UjianKp', 'DosenController@UjianKp');


Route::get('/homeKoor', 'HomeController@index_koor')->name('homeKoor');

Route::get('/koor/BimbinganKp', 'KoorController@BimbinganKp');

Route::get('/koor/{idKp}/{nim}/SetUjian', 'KoorController@ajuinUjian');

Route::get('/koor/UjianKp', 'KoorController@UjianKp');

Route::get('/koor/RegisKp', 'KoorController@RegisKp');
Route::post('/koor/setKp', 'KoorController@setKp');
Route::get('/koor/openkp/{nim}', 'KoorController@openkp');

Route::get('/koor/RegisPraKp', 'KoorController@RegisPraKp');
Route::post('/koor/setPraKp', 'KoorController@setPraKp');
Route::get('/koor/openprakp/{nim}', 'KoorController@openprakp');

Route::get('/koor/SuratKet', 'KoorController@SuratKet');
Route::post('/koor/setSurat', 'KoorController@setSurat');
Route::get('/koor/opensurat/{nim}', 'KoorController@opensurat');

Route::get('/koor/setUjiank', 'KoorController@SetUjianK');
Route::post('/koor/setUjian', 'KoorController@SetUjian');

Route::get('/koor/BatasKp', 'KoorController@BatasKp');
Route::post('/koor/setBatas', 'KoorController@setBatas');
