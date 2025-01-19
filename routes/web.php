<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\LogController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FileUploadController::class, 'showForm'])->name('upload.form');
Route::post('/upload', [FileUploadController::class, 'handleUpload'])->name('upload.handle');

Route::get('/logs', [LogController::class, 'showLogs']);
