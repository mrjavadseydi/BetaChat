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
////    \Illuminate\Support\Facades\Artisan::call('migrate:fresh');
//$app= \Illuminate\Support\Facades\Cache::get('newReq');
//dd($app);

//    dd($main);
    $provinces = \App\Models\City::where('province_id',10)->get();
    $main = [];
    for($i=0;$i<count($provinces);$i++){

        $temp[] = [
            'text'=>$provinces[$i]['title'],
            'callback_data'=>"profile-setCity-".$provinces[$i]['id']
        ];
        if($i%3==0&&$i!=0){
            $main[] = $temp;
            $temp = [];
        }
    }
    dd($main);
}
);
