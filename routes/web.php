<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController as Login;
use App\Http\Controllers\HomeController as Home;
use App\Http\Controllers\Pertanyaan\PertanyaanController as Pertanyaan;
use App\Http\Controllers\Pertanyaan\ChildController as PertanyaanChild;
use App\Http\Controllers\Media\WhatsappController as WhatsappMedia;
use App\Http\Controllers\Media\PabxController as Pabx;

use App\Http\Controllers\Laporan\LogPanggilanController as LogPanggilan;
use App\Http\Controllers\Laporan\WhatsappController as WhatsappLaporan;

use App\Http\Controllers\Manage\UserController as ManageUser;
use App\Http\Controllers\Manage\TagController as ManageTag;
use App\Http\Controllers\Manage\CustomerController as ManageCustomer;

Auth::routes();
Route::get('/auth/callback', [Login::class, 'auth'])->name('ssoLoginSuccess');

Route::group(['middleware' => ['auth']], function(){
	Route::get('/', [Home::class, 'index'])->name('home');
	Route::prefix('media')->group((function(){
		
		Route::prefix('whatsapp')->group((function(){
			Route::get('/', [WhatsappMedia::class, 'index'])->name('media.whatsapp');
			Route::get('/riwayat', [WhatsappMedia::class, 'riwayat'])->name('media.whatsapp.riwayat');
			Route::get('/trigger', [WhatsappMedia::class, 'trigger'])->name('media.whatsapp.trigger')->withoutMiddleware('auth');
			Route::post('/complete', [WhatsappMedia::class, 'complete'])->name('media.whatsapp.complete');
			Route::post('/store-attachment', [WhatsappMedia::class, 'storeAttachment'])->name('media.whatsapp.store-attachment');
			Route::post('/eskalasi', [WhatsappMedia::class, 'eskalasi'])->name('media.whatsapp.eskalasi');
			Route::post('/set-tag', [WhatsappMedia::class, 'setTag'])->name('media.whatsapp.set-tag');
		}));

		Route::prefix('pabx')->group((function(){
			Route::get('/', [Pabx::class, 'index'])->name('media.pabx');
			Route::post('/submit', [Pabx::class, 'submit'])->name('media.pabx.submit');
		}));

	}));

	Route::prefix('laporan')->group(function(){
		Route::prefix('log-panggilan')->group(function(){
			Route::get('/', [LogPanggilan::class, 'index'])->name('laporan.log-panggilan');
			Route::get('/unduh', [LogPanggilan::class, 'unduh'])->name('laporan.log-panggilan.unduh');
		});
		Route::prefix('whatsapp')->group(function(){
			Route::get('/', [WhatsappLaporan::class, 'index'])->name('laporan.whatsapp');
			Route::get('/chat', [WhatsappLaporan::class, 'chat'])->name('laporan.whatsapp.chat');
		});
	});

	Route::group(['middleware' => ['super.admin']], function(){

		Route::prefix('manage')->group(function(){
			Route::prefix('user')->group(function(){
				Route::get('/', [ManageUser::class, 'index'])->name('manage.user');
				Route::post('/update', [ManageUser::class, 'update'])->name('manage.user.update');
				Route::post('/delete', [ManageUser::class, 'delete'])->name('manage.user.delete');
				Route::get('/load', [ManageUser::class, 'load'])->name('manage.user.load');
			});
			Route::prefix('tag')->group(function(){
				Route::get('/', [ManageTag::class, 'index'])->name('manage.tag');
				Route::post('/update', [ManageTag::class, 'update'])->name('manage.tag.update');
				Route::post('/delete', [ManageTag::class, 'delete'])->name('manage.tag.delete');
				Route::post('/add', [ManageTag::class, 'add'])->name('manage.tag.add');
			});
			Route::prefix('customer')->group(function(){
				Route::get('/', [ManageCustomer::class, 'index'])->name('manage.customer');
				Route::post('/update', [ManageCustomer::class, 'update'])->name('manage.customer.update');
			});
		});

		Route::prefix('pertanyaan')->group(function(){
			Route::get('/', [Pertanyaan::class, 'index'])->name('pertanyaan');
			Route::post('/submit', [Pertanyaan::class, 'submit'])->name('pertanyaan.submit');
			Route::get('/manage', [Pertanyaan::class, 'manage'])->name('pertanyaan.manage');

			Route::prefix('child')->group(function(){
				Route::post('/update', [PertanyaanChild::class, 'update'])->name('pertanyaan.child.update');
				Route::post('/append', [PertanyaanChild::class, 'append'])->name('pertanyaan.child.append');
				Route::post('/delete', [PertanyaanChild::class, 'delete'])->name('pertanyaan.child.delete');
			});
		});
		
	});
});