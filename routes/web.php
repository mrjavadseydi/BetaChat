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

    for($i=0;$i<40;$i++){
        sleep(1);
        doConnects();

    }
}
);
Route::get('/cache',function (){
    dd(Cache::get('prof'));
});
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

