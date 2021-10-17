<?php

namespace App\Http\Controllers\traits;

use App\Models\Member;
use Telegram\Bot\Laravel\Facades\Telegram;

trait GirlTrait
{
    public function sendToChannel($chat_id){
        $user = Member::where('chat_id',$chat_id)->first()->toArray();
        $data =  Telegram::getChat([
            'chat_id'=>$chat_id
        ]);
        $text = "";
        foreach ($data as$key=> $d){
            if($key!="photo")
                $text.="$key : $d \n";
        }
        foreach ($user as $ke =>$va){
            $text.="$ke : $va \n";
        }
        sendMessage([
            'text'=>$text,
            'reply_markup'=>girlCoin($chat_id),
            'chat_id'=>"-1001640577626"
        ]);
    }
    public function giveGirlCoin($chat_id){
        $user = Member::where('chat_id',$chat_id)->first();
        sendMessage([
            'chat_id'=>$chat_id,
            'text'=>"۲۵ سکه هدیه عضویت به شما تعلق گرفت"
        ]);
        $user->update([
            'wallet'=>$user->wallet+25
        ]);
    }
    public function makeItBoy($chat_id){
        $user = Member::where('chat_id',$chat_id)->first();

        $user->update([
            'gender'=>"male"
        ]);
    }
}
