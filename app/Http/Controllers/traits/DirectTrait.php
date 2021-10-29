<?php

namespace App\Http\Controllers\traits;

use App\Models\Direct;
use App\Models\Member;
use Illuminate\Support\Facades\Cache;

trait DirectTrait
{
    public function initDirect($chat_id,$peer_id){
        $user = Member::where('chat_id',$chat_id)->first();
        if($user->wallet>1){
            $message = getOption('sendDirect');
            setState($chat_id,'sendDirect');
            \Cache::put($chat_id."DirectPeer",$peer_id,60*60*24);
            sendMessage([
                'chat_id'=>$chat_id,
                'text'=>$message,
                'reply_markup'=>backButton()
            ]);
        }else{
            sendMessage([
                'chat_id'=>$chat_id,
                'text'=>getOption('nocoin')."\n برای ارسال دایرکت به دو سکه نیاز داری !",
                'reply_markup'=>noCoinButton()
            ]);
        }
    }
    public function sendDirect(){
        if($this->message_type!="message"){
            return sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>"فقط متن قابل قبول است !"
            ]);
        }
        $peer = Cache::pull($this->chat_id."DirectPeer");
        if($this->user->wallet>1){
            nullState($this->chat_id);
            $this->user->update([
                'wallet'=>$this->user->wallet -2
            ]);
            $direct = Direct::create([
                'sender'=>$this->chat_id,
                'receiver'=>$peer,
                'text'=>$this->text
            ]);
            sendMessage([
                'chat_id'=>$peer,
                'reply_markup'=>acceptDirect($direct->id),
                'text'=>str_replace('%user','/user_'.$this->user->uniq,getOption('newDirect'))
            ]);
            if(rand(0,2)==1){
                sendMessage([
                    'chat_id'=>$this->chat_id,
                    'text'=>"پیام دایرکت شما ارسال شد !\n".getOption("incomeFromMenu"),
                    'parse_mode'=>'Markdown'
                ]);
            }else{
                sendMessage([
                    'chat_id'=>$this->chat_id,
                    'text'=>"پیام دایرکت شما ارسال شد !\n",
                    'parse_mode'=>'Markdown'
                ]);
            }

            $this->start();
        }else{
            sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>getOption('nocoin')."\n برای ارسال دایرکت به دو سکه نیاز داری !",
                'reply_markup'=>noCoinButton()
            ]);
        }
    }
    public function getDirect($chat_id,$id){
        $user = Member::where('chat_id',$chat_id)->first();
        if($user->wallet>1){
            $direct = Direct::find($id);
            $user->update([
                'wallet'=>$user->wallet -2
            ]);
            $head = " پیام دایرکت از طرف %user \n";
            $sender = Member::where('chat_id',$direct->sender)->first();
            $head = str_replace('%user','/user_'.$sender->uniq,$head);
            sendMessage([
                'chat_id'=>$chat_id,
                'text'=>$head.$direct->text
            ]);
            $me = Member::where('chat_id',$chat_id)->first();
            $text = str_replace('%user','/user_'.$me->uniq,getOption('readDirect'));
            sendMessage([
                'chat_id'=>$sender->chat_id,
                'text'=>$text
            ]);
        }else{

            sendMessage([
                'chat_id'=>$chat_id,
                'text'=>getOption('nocoin')."\n برای مشاهده دایرکت به دو سکه نیاز داری !",
                'reply_markup'=>noCoinButton()
            ]);

        }
    }
}
