<?php

namespace App\Http\Controllers;

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
    public function init(Request $request){
        $req = $request->toArray();
        devLog($req);
        if (Cache::has($req['update_id'])) {
            die();
        } else {
            Cache::put($req['update_id'], 60, 60);
        }
        $this->message_type = messageType($req);
        if ($this->message_type == "callback_query") {
//            $this->initCallBack($req);
            exit();
        }
        $this->text = $req['message']['text'] ?? "//**";
        $this->chat_id = $req['message']['chat']['id'] ?? "";
        $this->from_id = $req['message']['from']['id'] ?? "";
//        if ($req['message']['chat']['type'] == "private") {
//            if (!($user = Member::where('chat_id', $this->chat_id)->first())) {
//                $user = Member::create([
//                    'chat_id' => $this->chat_id,
//                    'name'=>$req['message']['from']['firstname'],
//                    'username'=>$req['message']['from']['username']??null
//                ]);
//            } else {
//                $user = Member::where('chat_id', $this->chat_id)->first();
//            }
//            $this->user = $user;
//        } else {
//            exit();
//        }

        devLog(Telegram::getUserProfilePhotos(['user_id'=>$this->chat_id]));
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
