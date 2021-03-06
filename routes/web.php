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

Route::get('/', function () {
    return view('index');
});

Auth::routes();
Route::get('/test', 'TestController@test')->name('test');
Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('index');
Route::get('/wallet', 'WalletController@wallet')->name('wallet');
Route::get('/fund', 'HomeController@fund')->name('fund');
Route::get('/news', 'HomeController@news')->name('news');
Route::get('/download', 'HomeController@download')->name('download');
Route::get('/complete-registration', 'Auth\RegisterController@completeRegistration');
Route::get('/user/activation/{token}', 'Auth\RegisterController@userActivation');
Route::get('/user/reactivation/{id}', 'Auth\RegisterController@ResendActivation');

Route::get('/2fa','PasswordSecurityController@show2faForm');
Route::post('/generate2faSecret','PasswordSecurityController@generate2faSecret')->name('generate2faSecret');
Route::post('/2fa','PasswordSecurityController@enable2fa')->name('enable2fa');
Route::post('/disable2fa','PasswordSecurityController@disable2fa')->name('disable2fa');

Route::post('/getwalletinfo', 'WalletController@getwalletinfo')->name('getwalletinfo');
Route::post('/getmasternodestatus', 'WalletController@getmasternodestatus')->name('getmasternodestatus');
Route::post('/getaddresses', 'WalletController@getaddresses')->name('getaddresses');
Route::post('/gettransactions', 'WalletController@gettransactions')->name('gettransactions');
Route::post('/contact', 'ContactController@contact')->name('contact');
Route::post('/2faVerify', function () {
    return redirect(URL()->previous());
})->name('2faVerify')->middleware('2fa');
