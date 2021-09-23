<?php

namespace App\Http\Controllers\traits;

use App\Models\City;
use App\Models\Member;

use App\Models\Province;
trait ConnectToUser
{
    public function getUserProfileViaId(){
        $peer_id = str_replace('/user_',"",$this->text);
        $peer = Member::where('uniq',$peer_id)->first();
        if($peer){
            $profile = $peer->profile ?? "AgACAgUAAxkBAAICeGFIo3AbcOINYurr8OMUXT6iei08AALWrTEbHLZBVnf6WKj7vSpZAQADAgADeQADIAQ";
            $gender = $peer->gender ?? 'ثبت نشده ';

            if($gender == "male"){
                $gender = "🙎🏻‍♂️آقا";
            }elseif($gender == "female"){
                $gender = "🙍🏻‍♀️ خانوم";
            }else{
                $gender = "ثبت نشده";
            }
            $province =  'ثبت نشده ';
            if($peer->province_id!=null){
                $province = Province::whereId($peer->province_id)->first()->title;
            }
            $city =  'ثبت نشده ';
            if($peer->city_id!=null){
                $city = City::whereId($peer->city_id)->first()->title;
            }
            $caption =
                "
💠نام : ".$peer->name."

🚻جنسیت : ".$gender."

🔅استان : ".$province. "

🌐شهر : ".$city. "

🔰نام کاربری ربات : "."/user_".$peer->uniq."
";
            $up = sendPhoto([
                'chat_id'=>$this->chat_id,
                'photo'=>$profile,
                'caption'=>$caption,
                "reply_markup"=>profileConnect($peer->chat_id)
            ]);
        }
    }
    public function confirmRequestToPeer($chat_id,$peer_id){

            sendMessage([
                'chat_id'=>$chat_id,
                'text'=>getOption("confirmConnect"),
                'reply_markup'=>sendConnectRequest($peer_id)
            ]);




    }
    public function sendRequestToPeer($chat_id,$peer){
        $me = Member::where('chat_id',$chat_id)->first();
        if($me->wallet>0){
            sendMessage([
                'chat_id'=>$chat_id,
                'text'=>"🔰درخواست ارسال شد ",
            ]);
            $me->update([
                'wallet'=>$me->wallet-1
            ]);
            $template = str_replace('%name',$me->name,getOption('chatRequest'));
            $template = str_replace('%id',"/user_".$me->uniq,$template);
            sendMessage([
                'chat_id'=>$peer,
                'text'=>$template,
                'reply_markup'=>ConnectRequest($chat_id)
            ]);
        }else{
            sendMessage([
                'chat_id'=>$chat_id,
                'text'=>getOption('nocoin'),
                'reply_markup'=>coinButton()
            ]);
        }

    }
    public function acceptRequest($chat_id,$peer_id){
        $me = Member::where('chat_id',$chat_id)->first();
        $peer = Member::where('chat_id',$peer_id)->first();
        if($me->state!="onChat"||$me->state!="search"||$peer->state!="onChat"||$peer->state!="search"){

        }else{
            sendMessage([
                'chat_id'=>$chat_id,
                'text'=>"شمایا کاربر مقابل در حال چت و یا جستجو کاربر هستند ! امکان اتصال در حال حاضر وجود ندارد",
            ]);
        }

    }
}