<?php

namespace App\Http\Controllers\traits;

use App\Models\Invite;
use App\Models\Member;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\FileUpload\InputFile;

trait InviteTrait
{
    public function InviteCheck()
    {
        $user = Member::where('chat_id', $this->chat_id)->first();

        if (!$user) {
            $uniq = substr($this->text, 11);
            if (!Cache::has($this->chat_id . $uniq)) {
                Cache::put($this->chat_id . $uniq, "1", 60);
                $in = Member::where('uniq', $uniq)->first();
                if ($in) {
                    Invite::create([
                        'chat_id'=>$this->chat_id,
                        'from_id'=>$in->chat_id,
                        'uniq'=>$this->text
                    ]);
                    $in->update([
                        'wallet' => $in->wallet + intval(getOption('inviteCoin'))
                    ]);
                    sendMessage([
                        'chat_id' => $in->chat_id,
                        'text' => getOption('invite')
                    ]);
                }
            }
        }
    }

    public function inviteLinkGenerate($chat_id)
    {
        $me = Member::where('chat_id', $chat_id)->first();
        $link = "t.me/BetaChatRobot?start=inv_" . $me->uniq;
        $text = str_replace('%link', $link, getOption('inviteLink'));
        sendMessage([
            'chat_id' => $chat_id,
            'text' => $text
        ]);
        $photo = InputFile::create(public_path("banner.jpg"),'banner.jpg');
        sendPhoto([
            'chat_id'=>$chat_id,
            'caption'=>str_replace('%link', $link, getOption('banner')),
            'photo'=>$photo
        ]);
    }
}
