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
    $activeSearch = \App\Models\Connect::where('status',0)->get();
    foreach ($activeSearch as $search){
        $search = \App\Models\Connect::whereId($search->id)->first();
        if($search->status!=0){
            continue;
        }
        if($search->gender=="any"&$search->city=="any"&$search->province=="any"){
            $peer = \App\Models\Connect::where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id]])->first();
            if($peer){

                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                $p1->update([
                    'wallet'=>$p1->wallet -1,
                ]);
                $p2->update([
                    'wallet'=>$p2->wallet -1,
                ]);
                \App\Models\ConnectLog::create([
                    'uniq'=>uniqid(),
                    'user_1'=>$p1->chat_id,
                    'user_2'=>$p2->chat_id,
                ]);
                $search->update([
                    'status'=>1,
                    'connected_to'=>$peer->chat_id,
                ]);
                $peer->update([
                    'status'=>1,
                    'connected_to'=>$search->chat_id,
                ]);
                sendMessage([
                    'chat_id'=>$peer->chat_id,
                    'text'=>"😃به یکی وصل شدی ! سلام کن",
                    'reply_markup'=>onChatButton()
                ]);
                sendMessage([
                    'chat_id'=>$search->chat_id,
                    'text'=>"😃به یکی وصل شدی ! سلام کن",
                    'reply_markup'=>onChatButton()
                ]);
                setState($peer->chat_id,'onChat');
                setState($search->chat_id,'onChat');
            }
        }
    }
}
);
