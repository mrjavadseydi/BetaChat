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
        $peer=false;
        if($search->gender=="any"&$search->city=="any"&$search->province=="any"){
            $peer = \App\Models\Connect::where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id]])->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif($search->gender=="male"&$search->city=="any"&$search->province=="any"){
            $peer = \App\Models\Connect::query()->
                Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male']])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male']])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male']])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male']])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male']])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male']])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male']])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="female"&$search->city=="any"&$search->province=="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female']])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female']])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female']])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female']])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female']])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female']])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female']])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="female"&$search->city!="any"&$search->province=="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_city',$search->city]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="male"&$search->city!="any"&$search->province=="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_city',$search->city]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="female"&$search->city=="any"&$search->province!="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="male"&$search->city=="any"&$search->province!="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="female"&$search->city!="any"&$search->province!="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province],['user_city',$search->city]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="male"&$search->city!="any"&$search->province!="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province],['user_city',$search->city]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="any"&$search->city!="any"&$search->province!="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province],['user_city',$search->city]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="any"&$search->city=="any"&$search->province!="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="any"&$search->city!="any"&$search->province=="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_city',$search->city]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }
    }
}
);
Route::get('payment',function (\Illuminate\Http\Request $request){
    $authority = $request->Authority;
    $status = $request->Status;
    $order = \App\Models\Payment::where([['token',$authority],['status',0]])->first();
    if($order){
        $response = zarinpal()
            ->amount($order->price)
            ->verification()
            ->authority($authority)
            ->send();

        if (!$response->success()) {
            echo "خطا ! ".$response->error()->message();
            echo "</br> در صورت نیاز از طریق پشتیبانی میتوانید پیگیری کنید!";
            echo "</br> کد پیگیری $order->order_id";
            return  "</br>عملیات نا موفق!";
        }
        $user = \App\Models\Member::where('chat_id',$order->chat_id)->first();
        sendMessage([
            'chat_id'=>$order->chat_id,
            'text'=> "تراکنش موفق ! کد پیگیری شما !".$response->referenceId()."\n مقدار $order->count سکه به حساب شما افزوده شد !"
        ]);
        $user->update([
            'wallet'=>$user->wallet+$order->count
        ]);
        $order->update([
            'status'=>1,
            'order_id'=>$response->referenceId()
        ]);
        return  "تراکنش موفق ! کد پیگیری شما !".$response->referenceId()."<br> مقدار $order->count سکه به حساب شما افزوده شد !";

    }else{
        return "این تراکنش پیدا نشد !";
    }

})->name('pay');

