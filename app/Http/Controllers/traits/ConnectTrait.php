<?php

namespace App\Http\Controllers\traits;

use App\Models\Connect;
use App\Models\Member;
use App\Models\User;
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

    public function SetFilter( $chat_id,$newFilter,$msg_id)
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
            if ($filter['province'] =="any") {
                $filter['province'] = $user->province_id ?? "true";
            }else{
                $filter['province'] = "any";
            }
        }
        if ($newFilter == "city") {
            if ($filter['city']=="any"){
                $filter['city'] = $user->city_id ?? "true";

            }else{
                $filter['city'] ="any";
            }
        }
        if ($newFilter == "location") {
            $filter['city'] ="any";
            $filter['province'] = "any";
        }
        Cache::put($chat_id . "-connect", $filter);

        $connect = getOption('connect');
        editMessageText([
            'chat_id' => $chat_id,
            'text' => $connect,
            'message_id'=>$msg_id,
            'reply_markup' => makeConnectButton($filter)
        ]);

    }
    public function insertConnect($chat_id){
        if(!Cache::has($chat_id . "-connect")){
            $filter = [
                "gender" => "any",
                "city" => "any",
                "province" => "any"
            ];
        }else{
            $filter = Cache::pull($chat_id . "-connect");
        }
        $init=1;
        if ($filter['gender']!="any"){
            $init++;
        }
        if($filter['city']!='any'){
            $init++;
        }
        if($filter['province']!="any"){
            $init++;
        }
        if(Member::where('chat_id',$chat_id)->first()->wallet>=$init){
            $me = Member::where('chat_id',$chat_id)->first();
            Connect::create([
                'chat_id'=>$chat_id,
                'status'=>0,
                'gender'=>$filter['gender'],
                'province'=>$filter['province'],
                'city'=>$filter['city'],
                'connected_to'=>"0",
                'user_gender'=>$me->gender,
                'user_city'=>$me->city_id,
                'user_province'=>$me->province_id,
                'cost'=>$init
            ]);
            sendMessage([
                'chat_id'=>$chat_id,
                'text'=>getOption('search'),
                'reply_markup'=>backButton()
            ]);
            setState($chat_id,"search");
        }else{
            sendMessage([
                'chat_id'=>$chat_id,
                'text'=>getOption('nocoin'),
                'reply_markup'=>coinButton()
            ]);
        }
        doConnects();
    }
}
