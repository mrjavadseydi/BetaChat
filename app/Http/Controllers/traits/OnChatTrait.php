<?php

namespace App\Http\Controllers\traits;

use App\Models\ChatLog;
use App\Models\Connect;
use App\Models\ConnectLog;
use App\Models\Media;
use App\Models\Member;
use App\Models\Report;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Exception;

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
            case "sticker":
                $this->sendStickerToPeer($req);
                break;
            case "photo":
            case "video":
            case "document":
            case "voice":

                $this->addToMedia($req);
                break;
            default :

                sendMessage([
                    'chat_id' => $this->chat_id,
                    'text' => 'این نوع محتوا هنوز پشتیبانی نمیشود !',
                    'reply_markup' => onChatButton()
                ]);
                break;
        }
    }

    public function addToMedia($req)
    {
        $uniq = Cache::get($this->chat_id . "onChat");
        hasId($this->chat_id,$req['message']['caption'] ?? " ");

        if (Cache::has($this->chat_id . 'onChatRobot')) {
            $this->ChatToBot();
        }
        $peer = Connect::where([['chat_id', $this->chat_id], ['status', 1]])->first();

        $translate = [
            "photo" => " عکس ",
            'video' => " فیلم ",
            'document' => " فایل ",
            'voice' => " ویس "
        ];
        if ($this->message_type != "photo") {
            $file_id = $req['message'][$this->message_type]['file_id'];
        } else {
            $file_id = end($req['message']['photo'])['file_id'];
        }
        $peerProfile = Member::where('chat_id', $this->chat_id)->first();
        if($peer){
            $media = Media::create([
                'uniq' => $uniq,
                'text' => $req['message']['caption'] ?? " ",
                'sender' => $this->chat_id,
                'receiver' => $peer->connected_to,
                'file_id' => $file_id,
                'type' => $this->message_type
            ]);
            $template = getOption('media');
            $template = str_replace('%name', $peerProfile->name, $template);
            $template = str_replace('%type', $translate[$this->message_type], $template);
            sendMessage([
                'chat_id' => $peer->connected_to,
                'text' => $template,
                'reply_markup' => mediaKey($media->id)
            ]);

            ChatLog::create([
                'log_id' => ConnectLog::where('uniq', $uniq)->first()->id,
                'sender' => $this->chat_id,
                'receiver' => $peer->connected_to,
                'type' => $this->message_type,
                'caption' => $req['message']['caption'] ?? " ",
                'file_id' => $file_id
            ]);
        }



    }

    public function manageOnChatMessage()
    {
        switch ($this->text) {
            case "🔦مشاهده پروفایل🔦":
                $this->getOnChatProfile();
                break;
            case "❌قطع ارتباط❌":
            case "❌قطع ارتباط":
                $this->disconnect();
                break;
            default:
                $this->sendToPeer();
                break;
        }
    }

    public function sendAnimationToPeer($req)
    {
        $peer = Connect::where([['chat_id', $this->chat_id], ['status', 1]])->first();
        $animation = $req['message']['animation']['file_id'];
        if (Cache::has($this->chat_id . 'onChatRobot')) {
            sleep(rand(1, 8));
            $this->ChatToBot();
        } else {

            sendAnimation([
                'chat_id' => $peer->connected_to,
                'animation' => $animation,
                'reply_markup' => onChatButton()
            ]);

        }
        $uniq = Cache::get($this->chat_id . "onChat");
        ChatLog::create([
            'log_id' => ConnectLog::where('uniq', $uniq)->first()->id,
            'sender' => $this->chat_id,
            'receiver' => $peer->connected_to,
            'type' => 'animation',
            'caption' => " ",
            'file_id' => $animation
        ]);
    }

    public function sendStickerToPeer($req)
    {
        $peer = Connect::where([['chat_id', $this->chat_id], ['status', 1]])->first();
        $sticker = $req['message']['sticker']['file_id'];

        if (Cache::has($this->chat_id . 'onChatRobot')) {
            $this->ChatToBot();
        } else {
            sendSticker([
                'chat_id' => $peer->connected_to,
                'sticker' => $sticker,
                'reply_markup' => onChatButton()
            ]);

        }
        $uniq = Cache::get($this->chat_id . "onChat");
        ChatLog::create([
            'log_id' => ConnectLog::where('uniq', $uniq)->first()->id,
            'sender' => $this->chat_id,
            'receiver' => $peer->connected_to,
            'type' => 'sticker',
            'caption' => " ",
            'file_id' => $sticker
        ]);
    }

    public function DisconnectChat($chat_id)
    {
        $peer1 = Connect::where([['chat_id', $chat_id], ['status', 1]])->first();
        $peer2 = false;
        $p2 = false;
        if ($peer1) {
            $p2 = Member::where('chat_id', $peer1->connected_to)->first();
            $p1 = Member::where('chat_id', $peer1->chat_id)->first();

            $peer2 = Connect::where([['chat_id', $peer1->connected_to], ['status', 1]])->first();

            if ($peer2 && $p1) {
                sendMessage([
                    'chat_id' => $peer1->connected_to,
                    'text' => "مکالمه با /user_$p1->uniq خاتمه یافت!",
                    'reply_markup' => menuButton()
                ]);
            } else {
                sendMessage([
                    'chat_id' => $peer1->connected_to,
                    'text' => "مکالمه خاتمه یافت!",
                    'reply_markup' => menuButton()
                ]);
            }
            $peer1->update([
                'status' => 2
            ]);
            nullState($peer1->connected_to);
            Connect::where([['chat_id', $peer1->connected_to], ['status', 1]])->update([
                'status' => 2

            ]);
        }
        if ($p2) {
            sendMessage([
                'chat_id' => $chat_id,
                'text' => "مکالمه با /user_$p2->uniq خاتمه یافت!",
                'reply_markup' => menuButton()
            ]);
        } else {
            sendMessage([
                'chat_id' => $chat_id,
                'text' => "مکالمه خاتمه یافت!",
                'reply_markup' => menuButton()
            ]);
        }

        nullState($chat_id);
        if ($peer2) {
            $peer2->update([
                'status' => 2
            ]);
        }
        Connect::where([['chat_id', $chat_id], ['status', 1]])->update([
            'status' => 2
        ]);
        if (Cache::has($chat_id . 'onChatRobot')) {
            Cache::pull($chat_id . 'onChatRobot');
            Cache::pull($chat_id . 'Senario');
        }
    }

    public function ChatToBot()
    {
        if ($this->message_type == "message" && strlen($this->text) < 1) {
            return 0;
        }
        if ($this->message_type == "message" && ($this->text == "na" || $this->text == "نه" || $this->text == "نمیخوام" || $this->text == "نخیر")) {
            return 0;
        }
        sleep(rand(5, 8));

        if ($this->message_type == "message" && is_numeric($this->text)) {
            $idk =
                [
                    'چی میگی ؟',
                    "???",
                    "ها؟",
                    "wtf?",
                    'این چیه؟'
                ];
            sendMessage([
                'chat_id' => $this->chat_id,
                'text' => $idk[rand(0, count($idk) - 1)],
                'reply_markup' => onChatButton()
            ]);
            return 0;
        }
        $peer = Connect::where([['chat_id', $this->chat_id], ['status', 1]])->first();
        $uniq = Cache::get($this->chat_id . "onChat");

        $senario = Cache::get($this->chat_id . 'onChatRobot');
        $step = Cache::get($this->chat_id . 'Senario');
        if ($step == 0 && ($this->text == "na" || $this->text == "نه" || $this->text == "نمیخوام" || $this->text == "نخیر")) {
            $idk =
                [
                    'چی میگی ؟',
                    "???",
                    "ها؟",
                    "wtf?",
                    'این چیه؟'
                ];
            sendMessage([
                'chat_id' => $this->chat_id,
                'text' => $idk[rand(0, count($idk) - 1)],
                'reply_markup' => onChatButton()
            ]);
            return 0;
        }
        if ($senario[$step] == "randPhoto") {

            $file_id = Cache::get('mediaReq');
            $file_id = $file_id[rand(0, count($file_id) - 1)];
            $media = Media::create([
                'uniq' => $uniq,
                'text' => " ",
                'sender' => $peer->connected_to,
                'receiver' => $this->chat_id,
                'file_id' => $file_id,
                'type' => "photo"
            ]);
            $peerProfile = Member::where('chat_id', $peer->connected_to)->first();
            $template = getOption('media');
            $template = str_replace('%name', $peerProfile->name, $template);
            $template = str_replace('%type', "عکس", $template);
            if (rand(0, 2) == 1) {
                sendMessage([
                    'chat_id' => $this->chat_id,
                    'text' => "⚠️ پروفایل شما توسط کاربر مقابل چک شد!",
                    'reply_markup' => onChatButton()
                ]);
                sleep(4);
            }

            sendMessage([
                'chat_id' => $this->chat_id,
                'text' => $template,
                'reply_markup' => mediaKey($media->id)
            ]);
        } elseif ($senario[$step] == "end") {
            $peer1 = Connect::where([['chat_id', $this->chat_id], ['status', 1]])->first();
            sendMessage([
                'chat_id' => $this->chat_id,
                'text' => "مکالمه خاتمه یافت!",
                'reply_markup' => menuButton()
            ]);
            nullState($this->chat_id);
            $peer1->update([
                'status' => 2
            ]);
            Cache::pull($this->chat_id . 'onChatRobot');
            Cache::pull($this->chat_id . 'Senario');

        } elseif ($senario[$step] == "sleep20") {
            sleep(20);
            $peer1 = Connect::where([['chat_id', $this->chat_id], ['status', 1]])->first();
            sendMessage([
                'chat_id' => $this->chat_id,
                'text' => "مکالمه خاتمه یافت!",
                'reply_markup' => menuButton()
            ]);
            nullState($this->chat_id);
            $peer1->update([
                'status' => 2
            ]);
            Cache::pull($this->chat_id . 'onChatRobot');
            Cache::pull($this->chat_id . 'Senario');

        } elseif ($senario[$step] == "talk") {
            $step++;
            while ($senario[$step] != "endTalk") {
                sendMessage([
                    'chat_id' => $this->chat_id,
                    'text' => $senario[$step],
                    'reply_markup' => onChatButton()
                ]);
                sleep(1);
                $step++;

            }


        } elseif ($senario[$step] == "prof") {
            $step++;
            sendMessage([
                'chat_id' => $this->chat_id,
                'text' => "⚠️ پروفایل شما توسط کاربر مقابل چک شد!",
                'reply_markup' => onChatButton()
            ]);
            sleep(1);
            sendMessage([
                'chat_id' => $this->chat_id,
                'text' => $senario[$step],
                'reply_markup' => onChatButton()
            ]);
        } else {
            sendMessage([
                'chat_id' => $this->chat_id,
                'text' => $senario[$step],
                'reply_markup' => onChatButton()
            ]);

        }
        if (Cache::has($this->chat_id . "Senario")) {
            $step = $step + 1;
            Cache::put($this->chat_id . "Senario", $step);
        }


    }

    public function sendToPeer()
    {
        $peer = Connect::where([['chat_id', $this->chat_id], ['status', 1]])->first();
        $uniq = Cache::get($this->chat_id . "onChat");
        hasId($this->chat_id,$this->text);
        if (Cache::has($this->chat_id . 'onChatRobot')) {

            $this->ChatToBot();
        } else if ($peer) {
            sendMessage([
                'chat_id' => $peer->connected_to,
                'text' => $this->text,
                'reply_markup' => onChatButton()
            ]);


        } else {
            try {
                sendMessage([
                    'chat_id' => $this->chat_id,
                    'text' => "خطایی داشتیم ! اتصال شما را ناچارا قطع میکنیم ",
                ]);
                return $this->DisconnectChat($this->chat_id);
            } catch (\Exception $e) {

            }

        }
        if ($log = ConnectLog::where('uniq', $uniq)->first()) {
            ChatLog::create([
                'log_id' => $log->id,
                'sender' => $this->chat_id,
                'receiver' => $peer->connected_to,
                'type' => 'message',
                'caption' => $this->text,
                'file_id' => null
            ]);
        }


    }

    public function reportUser($chat_id,$peer_id)
    {
        setState($chat_id, 'Report');
        sendMessage([
            'chat_id' => $chat_id,
            'text' => 'لطفا برای ما بنویسید چه مشکلی پیش آمده است؟',
            'reply_markup' => backButton()
        ]);
        Cache::put('report'.$chat_id,$peer_id,360);
    }

    public function setReportMessage()
    {
        if ($this->message_type == "message"&&Cache::has('report'.$this->chat_id)) {
            nullState($this->chat_id);
            sendMessage([
                'chat_id' => $this->chat_id,
                'text' => 'کاربر گزارش شد!',
                'reply_markup' => menuButton()
            ]);
            $reported = Cache::pull('report'.$this->chat_id);
            Report::create([
                'reporting_user' => $this->chat_id,
                'report_message' => $this->text,
                'reported_user' => $reported
            ]);
            sendMessage([
                'chat_id'=>"-1001702636590",
                'text'=>
                "
reporting_user :$this->chat_id
text : $this->text
reported : $reported
"
            ]);
        } else {
            sendMessage([
                'chat_id' => $this->chat_id,
                'text' => 'متوجه نشدم لطفا مشکل را در قالب پیام متنی ارسال کنید',
                'reply_markup' => backButton()
            ]);
        }
    }

    public function sendMediaFromData($chat_id, $id)
    {
        $member = Member::where('chat_id', $chat_id)->first();
        if ($member->wallet > 2) {
            $member->update([
                'wallet' => $member->wallet - 3
            ]);
            $media = Media::whereId($id)->first();
            $func = "send" . ucfirst($media->type);
            if ($media->text != " ") {
                $content = [
                    'chat_id' => $chat_id,
                    $media->type => $media->file_id,
                    'caption' => $media->text
                ];
            } else {
                $content = [
                    'chat_id' => $chat_id,
                    $media->type => $media->file_id,
                ];
            }
            call_user_func_array($func, [$content]);
        } else {
            sendMessage([
                'chat_id' => $chat_id,
                'text' => getOption('nocoin'),
                'reply_markup' => noCoinButton()
            ]);
        }
    }
}
