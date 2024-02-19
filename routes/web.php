<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PertanyaanController as Pertanyaan;
use App\Http\Controllers\Media\WhatsappController as Whatsapp;

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

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
// Route::get('/showSSOLoginForm', 'App\Http\Controllers\Auth\LoginController@LoginForm')->name('ssoLogin');
Route::get('/auth/callback','App\Http\Controllers\Auth\LoginController@auth')->name('ssoLoginSuccess');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::get('/application', 'App\Http\Controllers\ApplicationController@index')->name('application');
Route::get('/application/facebook/{page?}', 'App\Http\Controllers\ApplicationController@facebook')->name('application.facebook');
Route::get('/application/instagram/{page?}', 'App\Http\Controllers\ApplicationController@instagram')->name('application.instagram');
Route::get('/application/whatsapp/{page?}', 'App\Http\Controllers\ApplicationController@wa')->name('application.whatsapp');
Route::get('/application/call-center/{page?}', 'App\Http\Controllers\ApplicationController@callcenter')->name('application.callcenter');
Route::get('/application/webchat/{page?}', 'App\Http\Controllers\ApplicationController@webchat')->name('application.webchat');
Route::get('/application/email/{page?}', 'App\Http\Controllers\ApplicationController@email')->name('application.email');

Route::get('/customer-monitoring', 'App\Http\Controllers\CustomerMonitoringController@index')->name('customer-monitoring');

Route::get('/report', 'App\Http\Controllers\ReportController@index')->name('report');

Route::get('/setting', 'App\Http\Controllers\SettingController@index')->name('setting');

Route::get('/setting/account-management', 'App\Http\Controllers\UserController@index')->name('setting.accountmanagement');
Route::get('/setting/account-management/add', 'App\Http\Controllers\UserController@add')->name('setting.accountmanagement.add');
Route::post('/setting/account-management/add', 'App\Http\Controllers\UserController@add')->name('setting.accountmanagement.add-p');
Route::get('/setting/account-management/edit/{id}', 'App\Http\Controllers\UserController@edit')->name('setting.accountmanagement.edit');
Route::post('/setting/account-management/edit/{id}', 'App\Http\Controllers\UserController@edit')->name('setting.accountmanagement.edit-p');
Route::get('/setting/account-management/delete/{id}', 'App\Http\Controllers\UserController@delete')->name('setting.accountmanagement.delete');

Route::get('/setting/agent-management', 'App\Http\Controllers\DepartmentApiController@index')->name('setting.agentmanagement');
Route::get('/setting/agent-management/add', 'App\Http\Controllers\DepartmentApiController@add')->name('setting.agentmanagement.add');
Route::post('/setting/agent-management/add', 'App\Http\Controllers\DepartmentApiController@add')->name('setting.agentmanagement.add-p');
Route::get('/setting/agent-management/edit/{id}', 'App\Http\Controllers\DepartmentApiController@edit')->name('setting.agentmanagement.edit');
Route::post('/setting/agent-management/edit/{id}', 'App\Http\Controllers\DepartmentApiController@edit')->name('setting.agentmanagement.edit-p');
Route::get('/setting/agent-management/delete/{id}', 'App\Http\Controllers\DepartmentApiController@delete')->name('setting.agentmanagement.delete');

Route::get('/tag/json', 'App\Http\Controllers\MessageTagController@tag')->name('tag');
Route::get('/tag', 'App\Http\Controllers\MessageTagController@index')->name('tag.index');
Route::get('/tag/add', 'App\Http\Controllers\MessageTagController@add')->name('tag.add');
Route::post('/tag/add', 'App\Http\Controllers\MessageTagController@add')->name('tag.add-p');
Route::get('/tag/edit/{id}', 'App\Http\Controllers\MessageTagController@edit')->name('tag.edit');
Route::post('/tag/edit/{id}', 'App\Http\Controllers\MessageTagController@edit')->name('tag.edit-p');
Route::get('/tag/delete/{id}', 'App\Http\Controllers\MessageTagController@delete')->name('tag.delete');
Route::get('/tag/get-tag', 'App\Http\Controllers\MessageTagController@getTag')->name('tag.get-tag');
Route::post('/tag/assign-tag', 'App\Http\Controllers\MessageTagController@assignTag')->name('tag.assign-tag');
// Route::post('/tag/removeTag', 'App\Http\Controllers\MessageTagController@removeTag')->name('tag.removeTag');

Route::get('/help', 'App\Http\Controllers\HelpController@index')->name('help');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	/*Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');*/
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});


Route::get('/api/sync', 'App\Http\Controllers\SyncController@index')->name('api.sync');
Route::get('/api/dashboard', 'App\Http\Controllers\DashboardApiController@index')->name('api.dashboard');
Route::get('/api/socialBlade', 'App\Http\Controllers\SocialBladeApiController@index')->name('api.sb');
Route::get('/api/application/email', 'App\Http\Controllers\EmailApiController@index')->name('api.email');
Route::get('/api/application/facebook', 'App\Http\Controllers\FacebookApiController@index')->name('api.fb');
Route::get('/api/application/instagram', 'App\Http\Controllers\InstagramApiController@index')->name('api.ig');
Route::get('/api/application/webchat', 'App\Http\Controllers\WebChatApiController@index')->name('api.web');
Route::get('/api/application/whatsapp', 'App\Http\Controllers\WhatsappApiController@index')->name('api.wa');
Route::get('/api/application/callcenter', 'App\Http\Controllers\CallCenterApiController@index')->name('api.cc');
Route::post('/api/application/callcenter', 'App\Http\Controllers\CallCenterApiController@update')->name('api.cc.update');
Route::get('/api/message', 'App\Http\Controllers\MessageApiController@index')->name('api.message.index');
Route::post('/api/message', 'App\Http\Controllers\MessageApiController@sendMessage')->name('api.message.send');
Route::post('/api/message/resolved', 'App\Http\Controllers\MessageApiController@markRoomAsResolved')->name('api.message.markRoomAsResolved');
Route::get('/api/message/roomhistory', 'App\Http\Controllers\MessageApiController@getRoomHistory')->name('api.message.getRoomHistory');
Route::post('/api/message/agent', 'App\Http\Controllers\MessageApiController@assignAgentToRoom')->name('api.message.agent');
// Route::get('/api/message/removeagent', 'App\Http\Controllers\MessageApiController@removeAgentFromRoom')->name('api.message.removeagent');
Route::get('/api/customerMonitoring', 'App\Http\Controllers\CustomerMonitoringApiController@index')->name('api.cm');
Route::get('/api/report', 'App\Http\Controllers\ReportApiController@index')->name('api.report');
Route::get('/api/eskalasi', 'App\Http\Controllers\MessageApiController@eskalasi')->name('api.eskalasi');

// -- //

Route::prefix('pertanyaan')->group(function(){
	Route::get('/', [Pertanyaan::class, 'index'])->name('pertanyaan');
});

Route::prefix('media')->group((function(){
	Route::prefix('whatsapp')->group((function(){
		Route::get('/', [Whatsapp::class, 'index'])->name('media.whatsapp');
		Route::get('/riwayat', [Whatsapp::class, 'riwayat'])->name('media.whatsapp.riwayat');
	}));
}));