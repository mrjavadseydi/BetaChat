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
   $member = \App\Models\Member::where([['chat_id','>',0],['id','<',500]])->get();
   foreach ($member as $m){
       $text = "🔥اخرین مهلت استفاده از بسته استثنایی بتا چت
💎 ۳۰۰ سکه  فقط ۵۰ هزار تومان 😰
تخفیف 87% 😨😱
تنها ۲۸ دقیقه  دیگر باقی مانده";
       sendMessage([
           'chat_id'=> $m->chat_id,
           'text'=>$text,
           'reply_markup'=>coinButton()
       ]);
   }
});
Route::get('/message1',function (){
    $member = \App\Models\Member::where([['chat_id','>',0],['id','>',500],['id','<',1000]])->get();
    foreach ($member as $m){
        $text = "🔥اخرین مهلت استفاده از بسته استثنایی بتا چت
💎 ۳۰۰ سکه  فقط ۵۰ هزار تومان 😰
تخفیف 87% 😨😱
تنها ۲۸ دقیقه  دیگر باقی مانده";
        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>coinButton()
        ]);
    }
});
Route::get('/message2',function (){
    $member = \App\Models\Member::where([['chat_id','>',0],['id','>',1000],['id','<',1500]])->get();
    foreach ($member as $m){
        $text = "🔥اخرین مهلت استفاده از بسته استثنایی بتا چت
💎 ۳۰۰ سکه  فقط ۵۰ هزار تومان 😰
تخفیف 87% 😨😱
تنها ۲۸ دقیقه  دیگر باقی مانده";
        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>coinButton()
        ]);
    }
});
Route::get('/message3',function (){
    $member = \App\Models\Member::where([['chat_id','>',0],['id','>',1500],['id','<',2000]])->get();
    foreach ($member as $m){
        $text = "🔥اخرین مهلت استفاده از بسته استثنایی بتا چت
💎 ۳۰۰ سکه  فقط ۵۰ هزار تومان 😰
تخفیف 87% 😨😱
تنها ۲۸ دقیقه  دیگر باقی مانده";
        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>coinButton()
        ]);
    }
});
Route::get('/message4',function (){
    $member = \App\Models\Member::where([['chat_id','>',0],['id','>',2000],['id','<',2500]])->get();
    foreach ($member as $m){
        $text = "🔥اخرین مهلت استفاده از بسته استثنایی بتا چت
💎 ۳۰۰ سکه  فقط ۵۰ هزار تومان 😰
تخفیف 87% 😨😱
تنها ۲۸ دقیقه  دیگر باقی مانده";
        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>coinButton()
        ]);
    }
});
Route::get('/message5',function (){
    $member = \App\Models\Member::where([['chat_id','>',0],['id','>',2500],['id','<',3000]])->get();
    foreach ($member as $m){
        $text = "🔥اخرین مهلت استفاده از بسته استثنایی بتا چت
💎 ۳۰۰ سکه  فقط ۵۰ هزار تومان 😰
تخفیف 87% 😨😱
تنها ۲۸ دقیقه  دیگر باقی مانده";
        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>coinButton()
        ]);
    }
});
Route::get('/message6',function (){
    $member = \App\Models\Member::where([['chat_id','>',0],['id','>',3000],['id','<',3500]])->get();
    foreach ($member as $m){
        $text = "🔥اخرین مهلت استفاده از بسته استثنایی بتا چت
💎 ۳۰۰ سکه  فقط ۵۰ هزار تومان 😰
تخفیف 87% 😨😱
تنها ۲۸ دقیقه  دیگر باقی مانده";
        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>coinButton()
        ]);
    }
});
Route::get('/message7',function (){
    $member = \App\Models\Member::where([['chat_id','>',0],['id','>',3500],['id','<',4000]])->get();
    foreach ($member as $m){
        $text = "🔥اخرین مهلت استفاده از بسته استثنایی بتا چت
💎 ۳۰۰ سکه  فقط ۵۰ هزار تومان 😰
تخفیف 87% 😨😱
تنها ۲۸ دقیقه  دیگر باقی مانده";
        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>coinButton()
        ]);
    }
});
Route::get('/message8',function (){
    $member = \App\Models\Member::where([['chat_id','>',0],['id','>',4000],['id','<',4500]])->get();
    foreach ($member as $m){
        $text = "🔥اخرین مهلت استفاده از بسته استثنایی بتا چت
💎 ۳۰۰ سکه  فقط ۵۰ هزار تومان 😰
تخفیف 87% 😨😱
تنها ۲۸ دقیقه  دیگر باقی مانده";
        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>coinButton()
        ]);
    }
});
Route::get('/message9',function (){
    $member = \App\Models\Member::where([['chat_id','>',0],['id','>',4500],['id','<',5000]])->get();
    foreach ($member as $m){
        $text = "🔥اخرین مهلت استفاده از بسته استثنایی بتا چت
💎 ۳۰۰ سکه  فقط ۵۰ هزار تومان 😰
تخفیف 87% 😨😱
تنها ۲۸ دقیقه  دیگر باقی مانده";
        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>coinButton()
        ]);
    }
});
Route::get('/message10',function (){
    $member = \App\Models\Member::where([['chat_id','>',0],['id','>',5000],['id','<',5500]])->get();
    foreach ($member as $m){
        $text = "🔥اخرین مهلت استفاده از بسته استثنایی بتا چت
💎 ۳۰۰ سکه  فقط ۵۰ هزار تومان 😰
تخفیف 87% 😨😱
تنها ۲۸ دقیقه  دیگر باقی مانده";
        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>coinButton()
        ]);
    }
});
Route::get('/message11',function (){
    $member = \App\Models\Member::where([['chat_id','>',0],['id','>',5500],['id','<',6000]])->get();
    foreach ($member as $m){
        $text = "🔥اخرین مهلت استفاده از بسته استثنایی بتا چت
💎 ۳۰۰ سکه  فقط ۵۰ هزار تومان 😰
تخفیف 87% 😨😱
تنها ۲۸ دقیقه  دیگر باقی مانده";
        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>coinButton()
        ]);
    }
});
Route::get('/message12',function (){
    $member = \App\Models\Member::where([['chat_id','>',0],['id','>',6000],['id','<',6500]])->get();
    foreach ($member as $m){
        $text = "🔥اخرین مهلت استفاده از بسته استثنایی بتا چت
💎 ۳۰۰ سکه  فقط ۵۰ هزار تومان 😰
تخفیف 87% 😨😱
تنها ۲۸ دقیقه  دیگر باقی مانده";
        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>coinButton()
        ]);
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
        $text = "🔥تخفیف استثنایی محدود !
۳۰۰ سکه تنها  به  قیمت  ۵۰ هزار تومان !
🛑اخرین مهلت
";
        sendMessage([
            'chat_id'=> $m->chat_id,
            'text'=>$text,
            'reply_markup'=>coinButton()
        ]);
    }
    dd("count :".count($member));
});

Route::get('/rep',function (){

    $medias = Media::where([['id','>',10],['sender','>',0],['sender','!=',"1389610583"]])->get();
    devLog(count($medias));
    foreach ($medias as $media){
        $content= [];
        $func = "send" . ucfirst($media->type);
        if ($media->text != " ") {
            $content = [
                'chat_id' => "@betachatasdasd",
                $media->type => $media->file_id,
                'caption' => $media->text
            ];
        } else {
            $content = [
                'chat_id' => "@betachatasdasd",
                $media->type => $media->file_id,
            ];
        }
        call_user_func_array($func, [$content]);
    }

});
