<?php

namespace App\Http\Controllers;


use App\Http\Controllers\traits\InlineQuery;
use App\Http\Controllers\traits\ProfileTrait;
use App\Models\Member;
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
    use ProfileTrait,InlineQuery;
    public function init(Request $request){
        $req = $request->toArray();
        devLog($req);
        Cache::put('newReq',$req);
//        if (Cache::has($req['update_id'])) {
//            die();
//        } else {
//            Cache::put($req['update_id'], 60, 60);
//        }
        $this->message_type = messageType($req);
        if ($this->message_type == "callback_query") {
//            devLog($req);
            $this->initCallBack($req);
            exit();
        }
        $this->text = $req['message']['text'] ?? "//**";
        $this->chat_id = $req['message']['chat']['id'] ?? "";
        $this->from_id = $req['message']['from']['id'] ?? "";
        if ($req['message']['chat']['type'] == "private") {
            if (!($user = Member::where('chat_id', $this->chat_id)->first())) {
                $profile = Telegram::getUserProfilePhotos(['user_id'=>$this->chat_id]);
                if($profile->total_count>0){
                    $profile = end($profile->photos[0])['file_id'];
                }else{
                    $profile = null;
                }
                $user = Member::create([
                    'chat_id' => $this->chat_id,
                    'name'=>$req['message']['from']['first_name'],
                    'username'=>$req['message']['from']['username']??null,
                    'profile'=>$profile,
                    'uniq'=>uniqid(),
                    'gender'=>null
                ]);
            } else {
                $user = Member::where('chat_id', $this->chat_id)->first();
            }
            $this->user = $user;
        } else {
            exit();
        }

        if ($this->text=="/start"||$this->text=="بازگشت ↪️"&&$user->state!="onChat"){
            nullState($this->chat_id);
            return $this->start();
        }
//        devLog($user->state);
        switch ($user->state){
            case "ProfileName":
                $this->SetProfileName();
                break;
            case "ProfilePhoto":
                $this->SetProfilePhoto($req);
                break;
        }
        switch ($this->text){
            case "💎پروفایل من💎":
                $this->sendProfile();
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
