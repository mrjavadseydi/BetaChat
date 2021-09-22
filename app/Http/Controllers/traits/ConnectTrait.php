<?php

namespace App\Http\Controllers\traits;

use App\Models\Member;
use Illuminate\Support\Facades\Cache;

trait ConnectTrait
{
    public function initToConnect()
    {
        $filter = [
            "gender" => "any",
            "city" => "any",
            "province" => "any"
        ];
        Cache::put($this->chat_id . "-connect", $filter);
        $connect = getOption('connect');
        sendMessage([
            'chat_id' => $this->chat_id,
            'text' => $connect,
            'reply_markup' => makeConnectButton($filter)
        ]);
    }

    public function SetFilter( $chat_id,$newFilter)
    {
        if(!Cache::has($chat_id . "-connect")){
            $filter = [
                "gender" => "any",
                "city" => "any",
                "province" => "any"
            ];
            Cache::put($this->chat_id . "-connect", $filter);
        }else{
            $filter = Cache::get($chat_id . "-connect");
        }
        $user = Member::where('chat_id', $chat_id)->first();
        if ($newFilter == "male") {
            $filter['gender'] = "male";
        }
        if ($newFilter == "female") {
            $filter['gender'] = "female";
        }
        if ($newFilter == "gender") {
            $filter['gender'] = "any";
        }
        if ($newFilter == "province") {
            $filter['province'] = $user->province_id ?? "true";
        }
        if ($newFilter == "city") {
            $filter['city'] = $user->city_id ?? "true";
        }
        Cache::put($chat_id . "-connect", $filter);

        $connect = getOption('connect');
        sendMessage([
            'chat_id' => $chat_id,
            'text' => $connect,
            'reply_markup' => makeConnectButton($filter)
        ]);
    }

}
