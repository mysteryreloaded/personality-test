<?php

use App\Http\Controllers\MainController;
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

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/question/create', [MainController::class, 'create'])->name('create');
Route::post('/store', [MainController::class, 'questionStore'])->name('question.store');
Route::post('/destroy', [MainController::class, 'destroy'])->name('destroy');

Route::post('/question/{id}/store', [MainController::class, 'answerStore'])->name('answer.store');
Route::post('/finish', [MainController::class, 'finish'])->name('finish');
