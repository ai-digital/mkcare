<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RekamController;
use App\Http\Controllers\UserController;
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
	$pasien=null;
    return view('welcome',['pasien' => $pasien]);
});
Route::get('/cari/','App\Http\Controllers\PasienController@cari')->name('cari');

 
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');
Route::get('/pasien/createPDF/{id?}', 'App\Http\Controllers\PasienController@createPDF')->name('createPDF');
Route::get('/pasien/export_excel', 'App\Http\Controllers\PasienController@export_excel')->name('export_excel');
Route::group(['middleware' => 'auth'], function () {

	Route::resource('pasien',PasienController::class);
	Route::resource('rekam', RekamController::class);

	Route::get('rekam_isi', function () {
		return view('pages.rekam_isi');
	})->name('rekam_isi');
	Route::get('/rekam/detail/{id?}', 'App\Http\Controllers\RekamController@show')->name('rekam_show'); 
	Route::get('/showrekam/{id?}', 'App\Http\Controllers\RekamController@showrekam')->name('rekam_detail_pasien'); 
	Route::get('/nomkcare_cari', 'App\Http\Controllers\PasienController@nomkcareSearch')->name('nomkcare_cari');
	
	Route::delete('/rekam/delete/{id}', 'App\Http\Controllers\RekamController@destroy')->name('delete');
	//Route::get('file_import', [PasienController::class, 'index'])->name('file_import');
	Route::post('file_import','App\Http\Controllers\PasienController@fileimport')->name('file_import'); 
	
	Route::resource('user', UserController::class);
	Route::get('wilayah/listkecamatan', array('uses' => 'App\Http\Controllers\WilayahController@listkecamatan'));
	Route::get('wilayah/listkelurahan', array('uses' => 'App\Http\Controllers\WilayahController@listkelurahan'));
	Route::get('wilayah/listkabupaten', array('uses' => 'App\Http\Controllers\WilayahController@listkabupaten'));

	 
});

Route::group(['middleware' => 'auth'], function () {
 	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

