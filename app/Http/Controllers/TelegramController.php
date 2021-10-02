<?php

namespace App\Http\Controllers;


use App\Http\Controllers\traits\ConnectToUser;
use App\Http\Controllers\traits\ConnectTrait;
use App\Http\Controllers\traits\InlineQuery;
use App\Http\Controllers\traits\InviteTrait;
use App\Http\Controllers\traits\OnChatTrait;
use App\Http\Controllers\traits\PaymentTrait;
use App\Http\Controllers\traits\ProfileTrait;
use App\Http\Controllers\traits\TextTrait;
use App\Models\Connect;
use App\Models\Member;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public $message_type;
    public $text;
    public $chat_id;
    public $from_id;
    public $user = null;
    use ProfileTrait,InlineQuery,TextTrait,ConnectTrait,OnChatTrait,PaymentTrait,ConnectToUser,InviteTrait;
    public function init(Request $request){

        $req = $request->toArray();
//        devLog($req);
        Cache::put('newReq',$req);
//        die();

        $this->message_type = messageType($req);
//        if( $this->message_type == "photo"&&$req['message']['from']['id']=="1389610583"){
//            if(Cache::has('mediaReq')){
//                $prof = Cache::pull('mediaReq');
//                $prof[]=end($req['message']['photo'])['file_id'];
//                Cache::put('mediaReq',$prof);
//            }else{
//                $prof[]=end($req['message']['photo'])['file_id'];
//                Cache::put('mediaReq',$prof);
//            }
//            devLog(Cache::get('mediaReq'));
//            return 0;
//        }
        if ($this->message_type == "callback_query") {
            return $this->initCallBack($req);
        }
        $this->text = $req['message']['text'] ?? "//**";
        $this->chat_id = $req['message']['chat']['id'] ?? "";
        $this->from_id = $req['message']['from']['id'] ?? "";
        if($this->chat_id == "802384351"){
            return 0;
        }
        if ($req['message']['chat']['type'] == "private") {
            if (isset($req['message']['from']['id'])&&(!joinCheck('-1001309074190',$this->chat_id)||!joinCheck('-1001311643100',$this->chat_id)||!joinCheck('-1001439072006',$this->chat_id))){
                if( substr($this->text,0,11)=="/start inv_"){
                    $link = "BetaChatRobot?start=".substr($this->text,7);
                    return sendMessage([
                        'chat_id'=>$this->chat_id,
                        'text'=>"🔱 دوست عزیز برای استفاده از ربات لطفا در کانال های زیر عضو شوید !

💠بعد از عضویت حتما از دکمه عضو شدم استفاده نمایید!",
                        'reply_markup'=>joinKey($link)
                    ]);

                }else{
                    return sendMessage([
                        'chat_id'=>$this->chat_id,
                        'text'=>getOption('channel'),
                        'reply_markup'=>joinKey("BetaChatRobot")
                    ]);
                }

            }
            if( substr($this->text,0,11)=="/start inv_") {
                $this->InviteCheck();
            }
            if (!($user = Member::where('chat_id', $this->chat_id)->first())) {
                try{
                    $profile = Telegram::getUserProfilePhotos(['user_id'=>$this->chat_id]);
                    if($profile->total_count>0){
                        $profile = end($profile->photos[0])['file_id'];
                    }else{
                        $profile = null;
                    }
                }catch (\Exception $e){
                    $profile = null;
                }

                $user = Member::create([
                    'chat_id' => $this->chat_id,
                    'name'=>$req['message']['from']['first_name'],
                    'username'=>$req['message']['from']['username']??null,
                    'profile'=>$profile,
                    'uniq'=>makeUniq(),
                    'wallet'=>2,
                    'gender'=>'null'
                ]);
                return sendMessage([
                    'chat_id'=>$this->chat_id,
                    'text'=>getOption('start'),
                    'reply_markup'=>menuButton()
                ]);
            } else {
                $user = Member::where('chat_id', $this->chat_id)->first();

            }
            $this->user = $user;
        } else {
            exit();
        }
        $user->touch();
        if (($this->text=="/start"||$this->text=="بازگشت ↪️")&&$user->state!="onChat"){
            nullState($this->chat_id);
            Connect::where([['chat_id',$this->chat_id],['status',0]])->update([
                'status'=>-2
            ]);
            return $this->start();
        }elseif($this->text=="/start"&&$user->state=="onChat"){
            return sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>"شما در حال چت هستید برای پایان گفت و گو از دکمه قطع ارتباط استفاده کن! ",
                'reply_markup'=>onChatButton()
            ]);
        }
//        devLog($user->state);
        switch ($user->state){
            case "ProfileName":
                $this->SetProfileName();
                break;
            case "ProfileAge":
                $this->SetProfileAge();
                break;
            case "ProfilePhoto":
                $this->SetProfilePhoto($req);
                break;
            case "onChat":
                return  $this->ManageOnChat($req);
                break;

        }
        switch ($this->text){
            case "💎پروفایل من💎":
                $this->sendProfile();
                break;
            case "⚜️قوانین⚜️":
                $this->getRole();
                break;
            case "🆘پشتیبانی🆘":
                $this->getSupport();
                break;
            case "❔راهنما❕":
                $this->getHelp();
                break;
            case "💰سکه💰":
                $this->getCoin();
                break;
            case "🔱 به یه ناشناس وصلم کن":
                $this->initToConnect();
                break;
            case strpos($this->text,"/user_")!==false:
                $this->getUserProfileViaId();
                break;

            case "🔍جستوجو پیشرفته🔎":
            case "🔍جستوجو پیشرفته":
                $this->initToConnectSearch();
                break;
            case "/state":

                if($this->chat_id == "259189869" ||$this->chat_id == "1389610583" ){
                    $money = Payment::where('status',1)->sum('price');
                    $member = Member::where('chat_id','>',0)->count();
                    sendMessage([
                        'chat_id'=>$this->chat_id,
                        'text'=>"درامد : $money
                        کاربران $member"
                    ]);
                }
                break;
            case "/button":
                if($this->chat_id == "259189869" ||$this->chat_id == "1389610583" ){

                    sendMessage([
                        'chat_id'=>$this->chat_id,
                        'text'=>"اگه بیکاری بیا چت کنیم !🥲🤤",
                        'reply_markup'=>adButton()
                    ]);
                }
                break;
                case "/button2":
                if($this->chat_id == "259189869" ||$this->chat_id == "1389610583" ){

                    sendMessage([
                        'chat_id'=>$this->chat_id,
                        'text'=>"حوصلت سررفته؟؟ سینگلی🤔🙊

انلاینی زووود رل بزن😍😍👇",
                        'reply_markup'=>adButton2()
                    ]);
                }
                break;
            default :
                break;
        }


    }
    public function start()
    {
        sendMessage([
            'chat_id' => $this->chat_id,
            'text' => "به منو اصلی خوش آمدید",
            'reply_markup' => menuButton()
        ]);
    }
}
