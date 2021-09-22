<?php

namespace App\Http\Controllers\traits;

use App\Models\ChatLog;
use App\Models\Connect;
use App\Models\ConnectLog;
use App\Models\Media;
use App\Models\Member;
use Illuminate\Support\Facades\Cache;

trait OnChatTrait
{

    public function ManageOnChat($req)
    {
//        devLog($this->message_type);
        switch ($this->message_type) {
            case "message":
                $this->manageOnChatMessage();
                break;
            case "animation":
                $this->sendAnimationToPeer($req);
                break;
            case "photo":
            case "video":
            case "document":
            case "voice":
                $this->addToMedia($req);
                break;
            default :

                sendMessage([
                    'chat_id'=>$this->chat_id,
                    'text'=>'این نوع محتوا هنوز پشتیبانی نمیشود !',
                    'reply_markup'=>onChatButton()
                ]);
                break;
        }
    }

    public function addToMedia($req){
        $peer = Connect::where([['chat_id', $this->chat_id], ['status', 1]])->first();
        $translate = [
            "photo"=>" عکس ",
            'video'=>" فیلم ",
            'document'=>" فایل ",
            'voice'=>" ویس "
        ];
        $uniq = Cache::get($this->chat_id."onChat");
        if($this->message_type!="photo"){
            $file_id = $req['message'][$this->message_type]['file_id'];
        }else{
            $file_id = end($req['message']['photo'])['file_id'];
        }
        $peerProfile = Member::where('chat_id',$peer->connected_to)->first();
        $media = Media::create([
            'uniq'=> $uniq,
            'text'=>$req['message']['caption'] ?? " ",
            'sender'=>$this->chat_id,
            'receiver'=>$peer->connected_to,
            'file_id'=>$file_id,
            'type'=>$this->message_type
        ]);
        $template = getOption('media');
        $template = str_replace('%name',$peerProfile->name,$template);
        $template = str_replace('%type',$translate[$this->message_type],$template);
        sendMessage([
            'chat_id' => $peer->connected_to,
            'text' => $template,
            'reply_markup' => mediaKey($media->id)
        ]);
        ChatLog::create([
            'log_id'=>ConnectLog::where('uniq',$uniq)->first()->id,
            'sender'=>$this->chat_id,
            'receiver'=>$peer->connected_to,
            'type'=>$this->message_type,
            'caption'=>$req['message']['caption'] ?? " ",
            'file_id'=>$file_id
        ]);

    }
    public function manageOnChatMessage()
    {
        switch ($this->text) {
            case "🔦مشاهده پروفایل🔦":
                $this->getOnChatProfile();
                break;
            case "❌قطع ارتباط❌":
                $this->disconnect();
                break;
            default:
                $this->sendToPeer();
                break;
        }
    }
     public function sendAnimationToPeer($req){
         $peer = Connect::where([['chat_id', $this->chat_id], ['status', 1]])->first();
         $animation = $req['message']['animation']['file_id'];
         sendAnimation([
             'chat_id' => $peer->connected_to,
             'animation' => $animation,
             'reply_markup' => onChatButton()
         ]);
         $uniq = Cache::get($this->chat_id."onChat");
         ChatLog::create([
             'log_id'=>ConnectLog::where('uniq',$uniq)->first()->id,
             'sender'=>$this->chat_id,
             'receiver'=>$peer->connected_to,
             'type'=>'animation',
             'caption'=>" ",
             'file_id'=>$animation
         ]);

     }

    public function DisconnectChat($chat_id)
    {
        $peer1 = Connect::where([['chat_id', $chat_id], ['status', 1]])->first();
        $peer2 = Connect::where([['chat_id', $peer1->connected_to], ['status', 1]])->first();
        sendMessage([
            'chat_id' => $chat_id,
            'text' => "مکالمه خاتمه یافت!",
            'reply_markup' => menuButton()
        ]);
        nullState($chat_id);
        sendMessage([
            'chat_id' => $peer1->connected_to,
            'text' => "مکالمه خاتمه یافت!",
            'reply_markup' => menuButton()
        ]);
        nullState($peer1->connected_to);
        $peer1->update([
            'status' => 2
        ]);
        $peer2->update([
            'status' => 2
        ]);

    }
    public function sendToPeer(){
        $peer = Connect::where([['chat_id', $this->chat_id], ['status', 1]])->first();
        sendMessage([
            'chat_id' => $peer->connected_to,
            'text' => $this->text,
            'reply_markup' => onChatButton()
        ]);
        $uniq = Cache::get($this->chat_id."onChat");
        ChatLog::create([
            'log_id'=>ConnectLog::where('uniq',$uniq)->first()->id,
            'sender'=>$this->chat_id,
            'receiver'=>$peer->connected_to,
            'type'=>'message',
            'caption'=>$this->text,
            'file_id'=>null
        ]);
    }
    public function sendMediaFromData($chat_id,$id){
        $member = Member::where('chat_id',$chat_id)->first();
        if($member->wallet>0){
            $member->update([
                'wallet'=>$member->wallet-1
            ]);
            $media = Media::whereId($id)->first();
            $func = "send".ucfirst($media->type);
            if($media->text!=" ") {
                $content = [
                    'chat_id' => $chat_id,
                    $media->type => $media->file_id,
                    'caption' => $media->text
                ];
            }else{
                $content = [
                    'chat_id' => $chat_id,
                    $media->type => $media->file_id,
                ];
            }
            call_user_func_array($func,[$content]);
        }else{
            sendMessage([
                'chat_id'=>$chat_id,
                'text'=>getOption('nocoin'),
                'reply_markup'=>coinButton()
            ]);
        }
    }
}
