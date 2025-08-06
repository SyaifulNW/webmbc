<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\dataController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\alumniController;
use App\Http\Controllers\SalesPlanController;



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
Route::get('/admin/database/database', [App\Http\Controllers\dataController::class, 'index'])->name('admin.database.database');
Route::get('/admin/database/create', [App\Http\Controllers\dataController::class, 'create'])->name('admin.database.create');
Route::post('/admin/database/store', [App\Http\Controllers\dataController::class, 'store'])->name('admin.database.store');
Route::get('/admin/database/{id}/edit', [App\Http\Controllers\dataController::class, 'edit'])->name('admin.database.edit');
Route::put('/admin/database/{id}', [App\Http\Controllers\dataController::class, 'update'])->name('admin.database.update');
Route::delete('/admin/database/{id}', [App\Http\Controllers\dataController::class, 'destroy'])->name('delete-database');
Route::get('/admin/database/{id}', [App\Http\Controllers\dataController::class, 'show'])->name('admin.database.show');

// Ongkir Routes
Route::get('/ongkir/provinsi', [OngkirController::class, 'getProvinsi'])->name('ongkir.provinsi');
Route::get('/ongkir/kota', [OngkirController::class, 'getKota'])->name('ongkir.kota');

//Wilayah
Route::get('/wilayah/provinsi', [WilayahController::class, 'getProvinces']);
Route::get('/wilayah/kota/{id}', [WilayahController::class, 'getCities']);

// Alumni Routes
Route::post('/data/pindah-ke-alumni/{id}', [DataController::class, 'pindahKeAlumni'])->name('data.pindahKeAlumni');

Route::get('/admin/alumni/alumni', [App\Http\Controllers\alumniController::class, 'index'])->name('admin.alumni.alumni');
Route::get('/admin/alumni/create', [App\Http\Controllers\alumniController::class, 'create'])->name('admin.alumni.create');
Route::post('/admin/alumni/store', [App\Http\Controllers\alumniController::class, 'store'])->name('admin.alumni.store');
Route::get('/admin/alumni/{id}/edit', [App\Http\Controllers\alumniController::class, 'edit'])->name('admin.alumni.edit');
Route::put('/admin/alumni/{id}', [App\Http\Controllers\alumniController::class, 'update'])->name('admin.alumni.update');
Route::delete('/admin/alumni/{id}', [App\Http\Controllers\alumniController::class, 'destroy'])->name('delete-alumni');
Route::get('/admin/alumni/{id}', [App\Http\Controllers\alumniController::class, 'show'])->name('admin.alumni.show');    

// Sales Plan Routes 
Route::post('/data/{id}/pindah-ke-salesplan', [DataController::class, 'pindahKeSalesPlan'])->name('data.pindahKeSalesPlan');
Route::get('/admin/salesplans', [SalesPlanController::class, 'index'])->name('admin.salesplan.index');
Route::put('/admin/salesplan/{id}', [SalesPlanController::class, 'update'])->name('admin.salesplan.update');

// Export
Route::get('/salesplan/export', [SalesPlanController::class, 'export'])->name('salesplan.export');

// Daily Activities
Route::get('/admin/dailyactivity/index', [App\Http\Controllers\DailyController::class, 'index'])->name('admin.dailyactivity.index');
Route::post('/admin/daily-activity', [App\Http\Controllers\DailyController ::class, 'store'])->name('admin.daily-activity.store');


// Pindah Salesplan dari Alumni
Route::post('/admin/alumni/to-salesplan/{id}', [AlumniController::class, 'toSalesplan'])->name('admin.alumni.toSalesplan');










