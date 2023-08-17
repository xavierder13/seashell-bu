<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\SpeciesController;
use App\Http\Controllers\HomeController;

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
//     if(!auth()->check()){
//         return view('auth.login');
//     }else{
//         return redirect()->route('admin::home');
//     }
// });

Route::get('/', function () {
    return view('layouts.app');
});



Auth::routes();

Route::group(['as' => 'admin::', 'middleware' => 'auth'], function(){
    Route::prefix('admin')->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::resource('species', SpeciesController::class);
        Route::get('/importfile', [FileUploadController::class, 'ImportExcel']);
    });
});





Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
