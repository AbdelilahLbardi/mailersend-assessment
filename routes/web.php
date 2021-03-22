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

Route::get('/mails', \App\Http\Controllers\Mails\ListMailsController::class)->name('mails.index');
Route::get('/mails/{mail}', \App\Http\Controllers\Mails\ShowMailController::class)->name('mails.show');
Route::post('/mails', \App\Http\Controllers\Mails\SendMailController::class)->name('mails.create');


Route::view('/{any}', 'welcome')->where('any', '.*');