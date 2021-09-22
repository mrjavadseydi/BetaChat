<?php

namespace App\Http\Controllers\traits;

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

}
