<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatGPTController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/chatgpt', [ChatGPTController::class, 'index'])
    ->name('chatgpt.index');

Route::post('/chatgpt/ask', [ChatGPTController::class, 'ask'])
    ->name('chatgpt.ask');

Route::view('/chat', 'openai.chat');
Route::post('/chat', [ChatGPTController::class, 'chat'])->name('chatgpt.chat');


Route::view('/open/chat', 'openai.openchat');
Route::post('/open/chat', [ChatGPTController::class, 'chat'])->name('chatgpt.api');