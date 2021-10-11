<?php

namespace App\Http\Controllers;


use App\Http\Controllers\traits\ConnectToUser;
use App\Http\Controllers\traits\ConnectTrait;
use App\Http\Controllers\traits\DirectTrait;
use App\Http\Controllers\traits\GirlTrait;
use App\Http\Controllers\traits\IncomeTrait;
use App\Http\Controllers\traits\InlineQuery;
use App\Http\Controllers\traits\InviteTrait;
use App\Http\Controllers\traits\OnChatTrait;
use App\Http\Controllers\traits\PaymentTrait;
use App\Http\Controllers\traits\ProfileTrait;
use App\Http\Controllers\traits\SearchTrait;
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
    use ProfileTrait, InlineQuery, TextTrait, ConnectTrait, OnChatTrait, PaymentTrait, ConnectToUser, InviteTrait, IncomeTrait, DirectTrait, SearchTrait, GirlTrait;

    public function init(Request $request)
    {

        $req = $request->toArray();
//        devLog($req);
//        Cache::put('newReq', $req);
//        die();

        $this->message_type = messageType($req);
//        if( $this->message_type == "photo"&&$req['message']['from']['id']=="1389610583"){
//            if(Cache::has('prof')){
//                $prof = Cache::pull('prof');
//                $prof[]=end($req['message']['photo'])['file_id'];
//                Cache::put('prof',$prof);
//            }else{
//                $prof[]=end($req['message']['photo'])['file_id'];
//                Cache::put('prof',$prof);
//            }
////            devLog(Cache::get('prof'));
//            return 0;
//        }
        if ($this->message_type == "callback_query") {
            return $this->initCallBack($req);
        }
        $this->text = $req['message']['text'] ?? "//**";
        $this->chat_id = $req['message']['chat']['id'] ?? "";
        $this->from_id = $req['message']['from']['id'] ?? "";
//        return sendMessage([
//            'chat_id'=>$this->chat_id,
//            'text'=>"ربات به مدت 5 دقیقه در دسترس نخواهد بود !"
//        ])
        if ($this->chat_id == "802384351") {
            return 0;
        }

        if ($req['message']['chat']['type'] == "private") {
            if (isset($req['message']['from']['id']) && (!joinCheck('@BetaChatChannel', $this->chat_id))) {
                if (substr($this->text, 0, 11) == "/start inv_" || substr($this->text, 0, 11) == "/start inc_") {
                    Cache::put('uniqInvite' . $this->chat_id, $this->text);
                    $link = "BetaChatRobot?start=" . substr($this->text, 7);
                    return sendMessage([
                        'chat_id' => $this->chat_id,
                        'text' => "🔱 دوست عزیز برای استفاده از ربات لطفا در کانال های زیر عضو شوید !

💠بعد از عضویت حتما از دکمه عضو شدم استفاده نمایید!",
                        'reply_markup' => joinKey($link)
                    ]);

                } else {
                    return sendMessage([
                        'chat_id' => $this->chat_id,
                        'text' => getOption('channel'),
                        'reply_markup' => joinKey("BetaChatRobot?start=true")
                    ]);
                }

            }
            if (Cache::has('uniqInvite' . $this->chat_id)) {
                $text = Cache::pull('uniqInvite' . $this->chat_id);
                if (substr($text, 0, 11) == "/start inv_") {
                    $this->InviteCheck($text);
                }
                if (substr($text, 0, 11) == "/start inc_") {
                    $this->InviteIncomeCheck($text);
                }
            }

            if (!($user = Member::where('chat_id', $this->chat_id)->first())) {
                $profile = null;
                $user = Member::create([
                    'chat_id' => $this->chat_id,
                    'name' => $req['message']['from']['first_name'],
                    'username' => $req['message']['from']['username'] ?? null,
                    'profile' => $profile,
                    'uniq' => makeUniq(),
                    'wallet' => 2,
                    'gender' => 'null'
                ]);
                return sendMessage([
                    'chat_id' => $this->chat_id,
                    'text' => getOption('start'),
                    'reply_markup' => menuButton()
                ]);
            }
            $this->user = $user;
        } else {
            exit();
        }
        $user->touch();
        if (($this->text == "/start" || $this->text == "بازگشت ↪️" || $this->text == "/start true") && $user->state != "onChat") {
            nullState($this->chat_id);
            Connect::where([['chat_id', $this->chat_id], ['status', 0]])->update([
                'status' => -2
            ]);
            return $this->start();
        } elseif ($this->text == "/start" && $user->state == "onChat") {
            return sendMessage([
                'chat_id' => $this->chat_id,
                'text' => "شما در حال چت هستید برای پایان گفت و گو از دکمه قطع ارتباط استفاده کن! ",
                'reply_markup' => onChatButton()
            ]);
        } elseif (($this->text == "..." || $this->text == "بازگشت ↪️" || $this->text == "/start") && ($user->state == "getoutShaba" || $user->state == "getoutName" || $user->state == "getoutPhone")) {
            return sendMessage([
                'chat_id' => $this->chat_id,
                'text' => "لطفا مقدار خواسته شده را ارسال کنید  ",
                'reply_markup' => onChatButton()
            ]);
        }
        if ($this->chat_id == "1389610583" && strpos($this->text, "/user_") !== false) {
            if ($this->user->state == "onChat")
                return devLog(Member::where('uniq', str_replace('/user_', '', $this->text))->first());
            else
                devLog(Member::where('uniq', str_replace('/user_', '', $this->text))->first());
        }

//        devLog($user->state);
        switch ($user->state) {
            case "ProfileName":
                $this->SetProfileName();
                break;
            case "ProfileAge":
                $this->SetProfileAge();
                break;
            case "ProfilePhoto":
                $this->SetProfilePhoto($req);
                break;
            case "Report":
                $this->setReportMessage();
                break;
            case "getoutShaba":
                $this->getShaba();
                break;
            case "getoutName":
                $this->getNameIncome();
                break;
            case "getoutPhone":
                $this->getPhone();
                break;
            case "sendDirect":
                $this->sendDirect();
                break;
            case "onChat":
                return $this->ManageOnChat($req);
                break;

        }
        switch ($this->text) {
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
            case strpos($this->text, "/user_") !== false:
                $this->getUserProfileViaId();
                break;

            case "🔍جستوجو پیشرفته🔎":
            case "🔍جستوجو پیشرفته":
                $this->initToConnectSearch();
                break;
            case "💎کسب درامد":
            case "🔥کسب درامد":
            case "/income":
                $this->incomeMenu();
                break;
            case "📜راهنمای کسب درامد":
                $this->incomeHelp();
                break;
            case "💰موجودی💰":
                $this->incomeWallet();
                break;
            case "💎دریافت لینک اختصاصی💎":
                $this->IncomeLinkGenerate();
                break;
            case "💳 تسویه":
                $this->incomeCheck();
                break;
            case "/state":

                if ($this->chat_id == "259189869" || $this->chat_id == "1389610583") {
                    $money = Payment::where('status', 1)->sum('price');
                    $member = Member::where('chat_id', '>', 0)->count();
                    sendMessage([
                        'chat_id' => $this->chat_id,
                        'text' => "درامد : $money
                        کاربران $member"
                    ]);
                }
                break;
            case "/button":
                if ($this->chat_id == "259189869" || $this->chat_id == "1389610583") {

                    sendMessage([
                        'chat_id' => $this->chat_id,
                        'text' => "اگه بیکاری بیا چت کنیم !🥲🤤",
                        'reply_markup' => adButton()
                    ]);
                }
                break;
            case "/button2":
                if ($this->chat_id == "259189869" || $this->chat_id == "1389610583") {

                    sendMessage([
                        'chat_id' => $this->chat_id,
                        'text' => "حوصلت سررفته؟؟ سینگلی🤔🙊

انلاینی زووود رل بزن😍😍👇",
                        'reply_markup' => adButton2()
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
