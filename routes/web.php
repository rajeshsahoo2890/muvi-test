<?php
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
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
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/video-play/{id?}', [HomeController::class, 'videoPlay'])->name('videoplay');
Route::get('/get-video/{id?}', [HomeController::class, 'getVideo'])->name('getVideo');
/*Route::get('get-video/{video}', 'HomeController@getVideo')->name('getVideo'); */

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'loginPost'])->name('login.post');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('video', [VideoController::class, 'index'])->name('video');
        Route::get('video/add/{id?}', [VideoController::class, 'add'])->name('video.add');
        Route::post('video', [VideoController::class, 'post'])->name('video.post');
    });

    Route::prefix('ajax')->name('admin.ajax.')->group(function () {
        Route::post('video-status/{id}', [VideoController::class, 'status'])->name('video.status');
        Route::post('video-delete/{id}', [VideoController::class, 'delete'])->name('video.delete');
    });

    Route::prefix('dtable')->name('admin.dtable.')->group(function () {
        Route::get('video', [VideoController::class, 'datatable'])->name('video');
    });
});

