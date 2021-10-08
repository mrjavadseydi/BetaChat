<?php

namespace App\Http\Controllers\traits;

use App\Models\City;
use App\Models\Connect;
use App\Models\Member;
use App\Models\Province;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\FileUpload\InputFile;

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
        $coin = str_replace('%coin',$this->user->wallet,$coin);
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
        $peer_id = Connect::where([['chat_id',$this->chat_id],['status',1]])->first();
        if($peer_id){
            $peer_id= $peer_id->connected_to;
            $user = Member::where('chat_id',$peer_id)->first();
//       Log::alert($peer_id);
//        return 0 ;
            $profile = $user->profile ?? InputFile::create(public_path('noprof.jpg'),'noprof.jpg');
            $gender = $user->gender ?? 'ثبت نشده ';
            $age = $user->age ?? 'ثبت نشده ';
            if($gender == "male"){
                $gender = "🙎🏻‍♂️آقا";
            }elseif($gender == "female"){
                $gender = "🙍🏻‍♀️ خانوم";
            }else{
                $gender = "ثبت نشده";
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

👤پروفایل کاربر: "."/user_".$user->uniq."

🔘نام : ".$user->name."
🔘جنسیت : ".$gender."
🔘سن : ".$age."
🔘استان : ".$province. "
🔘شهر : ".$city. "
";
            sendPhoto([
                'chat_id'=>$this->chat_id,
                'photo'=>$profile,
                'caption'=>$caption,
                'reply_markup'=>onChatButton()
            ]);
            sendMessage([
                'chat_id'=>$peer_id,
                'text'=>"⚠️ پروفایل شما توسط کاربر مقابل چک شد!",
                'reply_markup'=>onChatButton()
            ]);
        }

    }

}
