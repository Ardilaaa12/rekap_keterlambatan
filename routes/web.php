<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RayonController;
use App\Http\Controllers\RombelController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['IsGuest'])->group(function(){
    Route::get('/', function () {
        return view('login');
    })->name('login');
});

Route::post('/login-auth', [UserController::class, 'loginAuth'])->name('login.auth');

Route::middleware('IsLogin')->group(function() {
    
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    
    Route::middleware('IsAdmin')->group(function() {
        Route::get('/dashboard', function () {
            return view('index');
        })->name('info');

        Route::prefix('user')->name('user.')->group(function() {
            Route::get('/data', [UserController::class, 'index'])->name('index');
            Route::get('/search', [UserController::class, 'cari'])->name('cari');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/id/{id}', [UserController::class, 'edit'])->name('edit');
            Route::patch('/update/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
        });

        Route::prefix('rayon')->name('rayon.')->group(function() {
            Route::get('/data', [RayonController::class, 'index'])->name('index');
            Route::get('/search', [RayonController::class, 'cari'])->name('cari');
            Route::get('/create', [RayonController::class, 'create'])->name('create');
            Route::post('/store', [RayonController::class, 'store'])->name('store');
            Route::get('/id/{id}', [RayonController::class, 'edit'])->name('edit');
            Route::patch('/update/{id}', [RayonController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [RayonController::class, 'destroy'])->name('delete');
    
        });
    
        Route::prefix('rombel')->name('rombel.')->group(function() {
            Route::get('/data', [RombelController::class, 'index'])->name('index');
            Route::get('/search', [RombelController::class, 'cari'])->name('cari');
            Route::get('/create', [RombelController::class, 'create'])->name('create');
            Route::post('/store', [RombelController::class, 'store'])->name('store');
            Route::get('/id/{id}', [RombelController::class, 'edit'])->name('edit');
            Route::patch('/update/{id}', [RombelController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [RombelController::class, 'destroy'])->name('delete');
        });
    
        Route::prefix('student')->name('student.')->group(function() {
            Route::get('/data', [StudentController::class, 'index'])->name('index');
            Route::get('/create', [StudentController::class, 'create'])->name('create');
            Route::get('/search', [StudentController::class, 'cari'])->name('cari');
            Route::post('/store', [StudentController::class, 'store'])->name('store');
            Route::get('/id/{id}', [StudentController::class, 'edit'])->name('edit');
            Route::patch('/update/{id}', [StudentController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [StudentController::class, 'destroy'])->name('delete');
    
        });
    
        Route::prefix('late')->name('late.')->group(function () {
            Route::get('/data', [LateController::class, 'index'])->name('index');
            Route::get('/file', [LateController::class, 'file'])->name('file');
            Route::get('/detail/{id}', [LateController::class, 'detail'])->name('detail');
            Route::get('/search', [LateController::class, 'cari'])->name('cari');
            Route::get('/create', [LateController::class, 'create'])->name('create');
            Route::post('/store', [LateController::class, 'store'])->name('store');
            Route::get('/id/{id}', [LateController::class, 'edit'])->name('edit');
            Route::patch('/update/{id}', [LateController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [LateController::class, 'destroy'])->name('delete');
            Route::get('/print/{id}', [LateController::class, 'print'])->name('print');
            Route::get('/download/{id}', [LateController::class, 'downloadPDF'])->name('download-pdf');
            Route::get('/export-excel', [LateController::class, 'exportExcel'])->name('export-excel'); 
    
        });
    });

    Route::middleware('IsPs')->group(function() {
        Route::get('/index', [UserController::class, 'dashboard'])->name('dashboard');

        Route::prefix('student')->name('student.')->group(function() {
            Route::get('/file', [StudentController::class, 'data'])->name('data');
            Route::get('/cari', [StudentController::class, 'search'])->name('search');
        });

        Route::prefix('late')->name('late.')->group(function () {
            Route::get('/index', [LateController::class, 'data'])->name('data');
            Route::get('/excel-export', [LateController::class, 'excelExport'])->name('excel-export'); 
            Route::get('/berkas', [LateController::class, 'berkas'])->name('berkas');
            Route::get('/{id}', [LateController::class, 'show'])->name('show');
            Route::get('/cetak/{id}', [LateController::class, 'cetak'])->name('cetak');
            Route::get('/unduh/{id}', [LateController::class, 'unduhPDF'])->name('unduh-pdf');
        });
    });
    

});