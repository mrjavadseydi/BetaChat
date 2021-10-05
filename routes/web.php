<?php

use App\Models\Media;
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
//    Artisan::call('migrate');
//    dd(Cache::get('prof'));
//    Auth::loginUsingId(1);
    $data =  Telegram::getChat([
        'user_id'=>1389610583,
        'chat_id'=>-1001309074190
    ]);
    dd($data);
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
        sendMessage([
            'chat_id'=>1389610583,
            'text'=>"amount : $order->price , status :success , chat_id : $order->chat_id"
        ]);
        sendMessage([
            'chat_id'=>259189869,
            'text'=>"amount : $order->price , status :success , chat_id : $order->chat_id"
        ]);
        return  "تراکنش موفق ! کد پیگیری شما !".$response->referenceId()."<br> مقدار $order->count سکه به حساب شما افزوده شد !";

    }else{
        return "این تراکنش پیدا نشد !";
    }

})->name('pay');

Route::get('/message',function (){
   $member = \App\Models\Member::where([['chat_id','>',0]])->get();

   foreach ($member as $m){
       $text = "
❌ آفر شانسی امشب
🔥 ۱۹۹ سکه به مبلغ ۴۹،۹۰۰ تومان 😱
این آفر ویژه شما میباشد و تنها به مدت ۳ ساعت میتوانید از آن استفاده کنید 😳
از هر ۵۰ نفر یک نفر این آفر رو دریافت میکنه ،‌خوش شانس امشب تویی😉";

       \App\Jobs\SendMessageJob::dispatch($m->chat_id,$text,offerCoinButton(),null);
   }
});

Route::get('/mm',function (){
//    dd(Cache::get('last'));
    if(Cache::has('last')){
        $last =Cache::get('last');
    }else{
        $last = 5927;
    }
    $member = \App\Models\Member::where([['chat_id','>',0],['id','>',$last]])->get();
    $lastID = \App\Models\Member::orderBy('id','desc')->first();
    Cache::put('last',$lastID->id);
    foreach ($member as $m){
        $text = "💥بسته ویژه کاربران جدید 😨
🔥۱۹۹ سکه  فقط ۴۹،۹۰۰  تومان 😱
😳مدت محدود !
حتی در هنگام چت هم میتوانید سکه خریداری کنید!😰";
        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>offerCoinButton()
        ]);
    }
    dd("count :".count($member));
});

Route::get('/rep',function (){

    Artisan::call('queue:work');
});
