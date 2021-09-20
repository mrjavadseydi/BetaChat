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
use \App\Http\Controllers\TelegramController;
Route::get('/', function () {
    return view('welcome');
});
Route::any('/telegram',[TelegramController::class,'init']);
Route::get('test',function(){
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh');
$app= \Illuminate\Support\Facades\Cache::get('app');
dd($app);
}
);
