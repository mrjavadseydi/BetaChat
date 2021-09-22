<?php

namespace App\Http\Controllers\traits;

use App\Models\Connect;

trait OnChatTrait
{

    public function ManageOnChat($req)
    {
        switch ($this->message_type) {
            case "message":
                $this->manageOnChatMessage();
                break;

        }
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
        }
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
}
