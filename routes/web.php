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
Artisan::call('view:clear');
Route::group(
    [
        'middleware' => 'guest'
    ], function () {
    Route::get('/auth', function () {
        return view('guest.auth');
    })->name('auth');
    Route::get('/register', function () {
        return view('guest.register');
    })->name('register');
    Route::post('/register', [\App\Http\Controllers\UserController::class, 'register'])->name('register_post');
    Route::get('/restore', function () {
        return view('guest.restore');
    })->name('restore');
    Route::post('/restore', [\App\Http\Controllers\UserController::class, 'restore'])->name('restore_post');
    Route::post('/auth', [\App\Http\Controllers\UserController::class, 'login'])->name('auth_post');
});


Route::group(
    ['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return redirect()->route('documents.index');
    });
    Route::get('/logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('logout');

    Route::get('/rates', [\App\Http\Controllers\TariffsController::class, 'index'])->name('tariffs');
    Route::get('/rates/confirm/', [\App\Http\Controllers\TariffsController::class, 'confirm'])->name('tariffs_confirm');
    Route::post('/rates/{tariff}', [\App\Http\Controllers\TariffsController::class, 'post'])->name('tariffs_post');
    Route::get('/rates/list', [\App\Http\Controllers\TariffsController::class, 'list'])->name('tariffs_list');

    Route::get('/profile', function () {
        SEOMeta::setTitle('Профиль');
        return view('users.profile');
    })->name('profile');
    Route::post('/profile', [\App\Http\Controllers\UserController::class, 'changeEmail'])->name('profile_post');
    Route::get('/profile/{code}', [\App\Http\Controllers\UserController::class, 'activeEmail'])->name('active_email');

    Route::resource('documents', \App\Http\Controllers\DocumentController::class);
    Route::get('/documents/download/{document}',
        [\App\Http\Controllers\DocumentController::class, 'download'])->name('documents.download');
    Route::resource('documents.pages', \App\Http\Controllers\PagesController::class);

    Route::get('/documents/{document}/pages/{page}/block',
        [\App\Http\Controllers\BlocksController::class, 'userBlock'])->name('block_pages');
    Route::post('/documents/{document}/pages/{page}/block/variant/{variant}',
        [\App\Http\Controllers\BlocksController::class, 'getVariantHtml'])->name('block_pages_variant');
    Route::post('/documents/{document}/pages/{page}/block',
        [\App\Http\Controllers\BlocksController::class, 'savePage'])->name('block_pages_save');

    Route::post('/uploadImage', [\App\Http\Controllers\CkeditorController::class, 'upload'])->name('upload_image');

    Route::group([
        'middleware' => 'admin'
    ], function () {
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'users'])->name('users');
        Route::resource('blocks', \App\Http\Controllers\BlocksController::class)->except(['show']);
        Route::resource('blocks.types', \App\Http\Controllers\VariantBlockController::class)->except(['show']);
        Route::get('/rates/list/{tariff}',
            [\App\Http\Controllers\TariffsController::class, 'detail'])->name('tariffs_detail');
        Route::post('/rates/list/{tariff}',
            [\App\Http\Controllers\TariffsController::class, 'update'])->name('tariffs_detail_update');
    });
});


