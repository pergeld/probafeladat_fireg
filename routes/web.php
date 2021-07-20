<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplianceController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\PdfController;

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

Route::get('/', [ApplianceController::class, 'index']);
Route::post('/appliances', [ApplianceController::class, 'store']);
Route::get('/appliances/{appliance}/edit', [ApplianceController::class, 'edit']);
Route::delete('/appliances/{appliance}', [ApplianceController::class, 'destroy']);

Route::get('/controls/{control}', [ControlController::class, 'show']);
Route::post('/controls', [ControlController::class, 'store']);
Route::get('/controls/{control}/edit', [ControlController::class, 'edit']);
Route::delete('/controls/{control}', [ControlController::class, 'destroy']);


Route::get('pdf/create', [PdfController::class, 'create']);