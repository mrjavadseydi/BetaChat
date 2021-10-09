<?php

use App\Models\Direct;
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
        'chat_id'=>1389610583
    ]);
    $text = "";
    foreach ($data as$key=> $d){
        if($key!="photo")
            $text.="$key : $d \n";
    }
    devLog($text);
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
   $members = \App\Models\Member::where([['chat_id','>',0],['wallet',"<",10]])->get();
//   $fakes  = \App\Models\Member::where('chat_id','<',0)->get();
//   $max = count($fakes)-1;
//    \App\Jobs\SendMessageJob::dispatch(1389610583,str_replace('%user','/user_',getOption('newDirect')),acceptDirect(5),null);

//    foreach ($members as $member){
//       $direct = Direct::create([
//           'sender'=>$fakes[rand(0,$max)]->chat_id,
//           'receiver'=>$member->chat_id,
//           'text'=>"سلام ، بیکارم
//🙄حوصله داری بیا چت کنیم"
//       ]);
//       \App\Jobs\SendMessageJob::dispatch($member->chat_id,str_replace('%user','/user_'.$member->uniq,getOption('newDirect')),acceptDirect($direct->id),null);
//   }
   //sendMessage([
//    'chat_id'=>1389610583,
//    'text'=>"Asdas",
//    'reply_markup'=>offerCoinButton()
//]);
    $text = "
🛑فرصت نهایی🛑
🔥 تخفیف ویژه حلول ماه مبارک ربیع الاول
💎 ۱۲۰ سکه به قیمت ۴۹،۵۰۰
یه اقا پیدا نمیشه ؟😬،خانوما منتظرن🥰";
   foreach ($members as $m){
       \App\Jobs\SendMessageJob::dispatch($m->chat_id,$text,coinButton(),"markdown");
   }
});

Route::get('/mm',function (){

    if(Cache::has('last')){
        $last =Cache::get('last');
    }else{
        $last = 8938;
    }
    $member = \App\Models\Member::where([['chat_id','>',0],['id','>',$last]])->get();
    $lastID = \App\Models\Member::orderBy('id','desc')->first();
    Cache::put('last',$lastID->id);
    foreach ($member as $m){
        $text = "
🛑اخرین تمدید🛑
🔥 تخفیف ویژه حلول ماه مبارک ربیع الاول
💎 ۱۲۰ سکه به قیمت ۴۹،۵۰۰
هرچه سریعتر نسبت به خرید اقدام کنید😬،خانوما منتظرن🥰

";

        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>offerCoinButton()
        ]);
    }
    dd("count :".count($member));
});

Route::get('/rep',function (){
$text = "🔥 تخفیف ویژه ۱۲ نفر اول
💎 ۱۲۰ سکه به قیمت ۴۹،۵۰۰
این تخفیف تنها برای ۱۲ نفر اول فعال خواهد بود 😇
🙂هرچه سریعتر نسبت به خرید اقدام کنید";
sendMessage([
    'chat_id'=>"@BetaChatChannel",
    'text'=>$text,
    'reply_markup'=>coinButtonChannel()
]);
//    Artisan::call('queue:work');
});


Route::get('login',[\App\Http\Controllers\AuthController::class,'index'])->name('login');
Route::post('login',[\App\Http\Controllers\AuthController::class,'login']);
Route::middleware('auth')->group(function (){
    Route::get('/panel',[App\Http\Controllers\Panel\PanelController::class,'index'])->name('panel');
    Route::resource('chat',\App\Http\Controllers\Panel\ChatController::class);
});

Route::any('logout',function (){
    Auth::logout();
})->name('logout');
