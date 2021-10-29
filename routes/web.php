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
dd();
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
    return "fuck you!";
   $members = \App\Models\Member::where([['chat_id','>',0]])->get();
   $fakes  = \App\Models\Member::where('chat_id','<',0)->get();
   $max = count($fakes)-1;
//    \App\Jobs\SendMessageJob::dispatch(1389610583,str_replace('%user','/user_',getOption('newDirect')),acceptDirect(5),null);

    foreach ($members as $member){
        $tempFake =$fakes[rand(0,$max)];
       $direct = Direct::create([
           'sender'=>$tempFake->chat_id,
           'receiver'=>$member->chat_id,
           'text'=>"سلام ، بیکارم
🙄حوصله داری بیا چت کنیم"
       ]);
       \App\Jobs\SendMessageJob::dispatch($member->chat_id,str_replace('%user','/user_'.$tempFake->uniq,getOption('newDirect')),acceptDirect($direct->id),null);
   }
   //sendMessage([
//    'chat_id'=>1389610583,
//    'text'=>"Asdas",
//    'reply_markup'=>offerCoinButton()
//]);
//    $text = "
//💠 %name عزیز
//توی ۳ ساعت گذشته ‍‍۶۵۲ *پسر* و ۵۱۲ *دختر* داخل ربات گفتگو کردند ‼️😨
//*توهم میتونی یکی از این افراد باشی ❕*
//🔥 برای شروع میتونی بسته ویژه امشب رو خریداری کنی، * ۲۹۹ سکه به مبلغ ۵۱ هزار تومان*`(۸۸٪ تخفیف😱)`
//*این بسته محدوده ⚠️*
//";
//   foreach ($members as $m){
//       \App\Jobs\SendMessageJob::dispatch($m->chat_id,str_replace('%name',$m->name,$text),coinButton(),"markdown");
//   }
});

Route::get('/mm',function (){
dd();
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
    $text = "
🛑* ۵ هزار تومن اعتبار رایگان برای همه !*
*بتا چت بروزرسانی شد !*
🔱پنج هزار تومان اعتبار رایگان به همه کاربران اضافه شد !
⚠️هزینه مشاهده مدیا *کاهش *یافت !
⚜️پیدا کردن کاربران اطراف با گزینه  ‍‍`📍اطرافیان من`  !
💎سکه رایگان با استفاده از  قابلیت جدید ‍‍`📍اطرافیان من`  !
😱کاهش سقف برداشت اعتبار به ۱۵ هزار تومان
❌امکان گزارش کاربران متخلف !
💎تخفیف استثنایی ابه مناسبت بروز رسانی ربات 💎

🤩 * ۱۵۵* سکه به قیمت`۴۹،۵۰۰` ‍ تومان🥳
😁   /start  را ارسال کنید و از امکانات جدید استفاده کنید
";
sendMessage([
    'chat_id'=>"@BetaChatChannel",
    'text'=>$text,
    'reply_markup'=>coinButtonChannel(),
    'parse_mode'=>'markdown'
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
