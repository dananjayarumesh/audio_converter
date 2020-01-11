<?php

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
// Auth::routes();

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
Route::post('register', 'Auth\RegisterController@register');

Route::get('/', 'HomeController@index')->name('home');
Route::post('upload-convert', 'HomeController@submitConvert');
Route::post('webhook/cloudconvert', '\CloudConvert\Laravel\CloudConvertWebhooksController');
Route::get('get-upload-status/{tag}', 'HomeController@getConvertLogStatus');
Route::get('get-convert-history', 'HomeController@getConvertHistory');
Route::get('download/{tag}', 'HomeController@downloadConverted');

Route::get('/vue/{vue_capture?}', function () {
 return view('vue.index');
})->where('vue_capture', '[\/\w\.-]*');

Route::get('/symlink', function () {
	Artisan::call('storage:link');
});

