<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Database Routes
Route::get('/admin/database/database', [App\Http\Controllers\crmController::class, 'index'])->name('admin.database.database');
Route::get('/admin/database/create', [App\Http\Controllers\crmController::class, 'create'])->name('admin.database.create');
Route::post('/admin/database/store', [App\Http\Controllers\crmController::class, 'store'])->name('admin.database.store');
Route::get('/admin/database/{id}/edit', [App\Http\Controllers\crmController::class, 'edit'])->name('admin.database.edit');
Route::put('/admin/database/{id}', [App\Http\Controllers\crmController::class, 'update'])->name('admin.database.update');
Route::delete('/admin/database/{id}', [App\Http\Controllers\crmController::class, 'destroy'])->name('delete-database');
Route::get('/admin/database/{id}', [App\Http\Controllers\crmController::class, 'show'])->name('admin.database.show');


