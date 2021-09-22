<?php

namespace App\Http\Controllers\traits;

use App\Models\City;
use App\Models\Connect;
use App\Models\Member;
use App\Models\Province;

trait TextTrait
{

    public function getRole(){
        $role = getOption('role');
        sendMessage([
            'chat_id'=>$this->chat_id,
            'text'=>$role,
            'reply_markup'=>menuButton()
        ]);
    }
    public function getSupport(){
        $support = getOption('support');
        sendMessage([
            'chat_id'=>$this->chat_id,
            'text'=>$support,
            'reply_markup'=>menuButton()
        ]);
    }
    public function getHelp(){
        $help = getOption('help');
        sendMessage([
            'chat_id'=>$this->chat_id,
            'text'=>$help,
            'reply_markup'=>menuButton()
        ]);
    }

    public function getCoin(){
        $coin = getOption('coin');
        sendMessage([
            'chat_id'=>$this->chat_id,
            'text'=>$coin,
            'reply_markup'=>coinButton()
        ]);
    }
    public function disconnect(){
        sendMessage([
            'chat_id'=>$this->chat_id,
            'text'=>"از قطع ارتباط اطمینان داری؟",
            'reply_markup'=>disconnectButton()
        ]);
    }
    public function getOnChatProfile(){
        $peer_id = Connect::where([['chat_id',$this->chat_id],['status',1]])->first()->connected_to;
        $user = Member::where('chat_id',$peer_id)->first();
        $profile = $user->profile ?? "AgACAgUAAxkBAAICeGFIo3AbcOINYurr8OMUXT6iei08AALWrTEbHLZBVnf6WKj7vSpZAQADAgADeQADIAQ";
        $gender = $user->gender ?? 'ثبت نشده ';

        if($gender == "male"){
            $gender = "🙎🏻‍♂️آقا";
        }elseif($gender == "female"){
            $gender = "🙍🏻‍♀️ خانوم";
        }
        $province =  'ثبت نشده ';
        if($user->province_id!=null){
            $province = Province::whereId($user->province_id)->first()->title;
        }
        $city =  'ثبت نشده ';
        if($user->city_id!=null){
            $city = City::whereId($user->city_id)->first()->title;
        }
        $caption =
            "
💠نام : ".$user->name."

🚻جنسیت : ".$gender."

🔅استان : ".$province. "

🌐شهر : ".$city. "

🔰نام کاربری ربات : "."/user_".$user->uniq."
";
        sendPhoto([
            'chat_id'=>$this->chat_id,
            'photo'=>$profile,
            'caption'=>$caption,
            'reply_markup'=>onChatButton()
        ]);
        sendMessage([
            'chat_id'=>$peer_id,
            'text'=>"کاربر  مقابل پروفایل شمارو  چک کرد!",
            'reply_markup'=>onChatButton()
        ]);
    }

}
