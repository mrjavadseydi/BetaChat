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


        $connect = getOption('connect');
        if(rand(0,6)==4){
            sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>getOption("incomeFromMenu"),
                'parse_mode'=>'Markdown'
            ]);
        }

        sendMessage([
            'chat_id' => $this->chat_id,
            'text' => $connect,
            'reply_markup' => connectButton2()
        ]);
        if ($this->user->gender=="null"){
            sendMessage([
                'chat_id'=>$this->chat_id ,
                'text'=>'لطفا قبل از شروع چت جنسیت خود را با استفاده از دکمه های زیر انتخاب کنید',
                'reply_markup'=>genderSelect()
            ]);
        }elseif ($this->user->province_id==null&&rand(0,5)==4){
            sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>'لطفا قبل از شروع چت استان خود را از طریق  دکمه های زیر انتخاب کنید',
                'reply_markup'=>provinceButton()
            ]);
        }
    }
    public function initToConnectSearch()
    {
        $filter = [
            "gender" => "any",
            "city" => "any",
            "province" => "any"
        ];
        Cache::put($this->chat_id . "-connect", $filter);
        $connect = getOption('CustomSearch');
        if(rand(0,6)==4){
            sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>getOption("incomeFromMenu"),
                'parse_mode'=>'Markdown'
            ]);
        }
        sendMessage([
            'chat_id' => $this->chat_id,
            'text' => $connect,
            'reply_markup' => makeConnectButton($filter)
        ]);
    }

    public function SetFilter($chat_id, $newFilter, $msg_id)
    {
        if (!Cache::has($chat_id . "-connect")) {
            $filter = [
                "gender" => "any",
                "city" => "any",
                "province" => "any"
            ];
            Cache::put($this->chat_id . "-connect", $filter);
        } else {
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
            if ($filter['province'] == "any") {
                $filter['province'] = $user->province_id ?? "true";
            } else {
                $filter['province'] = "any";
            }
        }
        if ($newFilter == "city") {
            if ($filter['city'] == "any") {
                $filter['city'] = $user->city_id ?? "true";

            } else {
                $filter['city'] = "any";
            }
        }
        if ($newFilter == "location") {
            $filter['city'] = "any";
            $filter['province'] = "any";
        }
        Cache::put($chat_id . "-connect", $filter);

        $connect = getOption('connect');
        editMessageText([
            'chat_id' => $chat_id,
            'text' => $connect,
            'message_id' => $msg_id,
            'reply_markup' => makeConnectButton($filter)
        ]);

    }

    public function insertConnect($chat_id)
    {
        if (!Cache::has($chat_id . "-connect")) {
            $filter = [
                "gender" => "any",
                "city" => "any",
                "province" => "any"
            ];
        } else {
            $filter = Cache::pull($chat_id . "-connect");
        }
        $init = 1;
        if ($filter['gender'] != "any") {
            $init++;
        }
        if ($filter['city'] != 'any') {
            $init++;
        }
        if ($filter['province'] != "any") {
            $init++;
        }
        if (Member::where('chat_id', $chat_id)->first()->wallet >= $init) {
            $me = Member::where('chat_id', $chat_id)->first();
            Connect::create([
                'chat_id' => $chat_id,
                'status' => 0,
                'gender' => $filter['gender'],
                'province' => $filter['province'],
                'city' => $filter['city'],
                'connected_to' => "0",
                'user_gender' => $me->gender,
                'user_city' => $me->city_id,
                'user_province' => $me->province_id,
                'cost' => $init
            ]);
            sendMessage([
                'chat_id' => $chat_id,
                'text' => getOption('search'),
                'reply_markup' => backButton()
            ]);
            setState($chat_id, "search");
        } else {
            sendMessage([
                'chat_id' => $chat_id,
                'text' => getOption('nocoin'),
                'reply_markup' => noCoinButton()
            ]);
        }
        doConnects();
    }

    public function insertFastConnect($chat_id, $type)
    {

        $init = 0;
        if ($type == "connect") {
            $init = 0;
        }
        if ($type == "female") {
            $init= 2;
        }
        if ($type == "male") {
            $init= 2;
        }

        if ($type == "location") {
            $init= 2;
        }

        if (Member::where('chat_id', $chat_id)->first()->wallet >= $init) {
            $me = Member::where('chat_id', $chat_id)->first();
            if($type=="connect"){
                Connect::create([
                    'chat_id' => $chat_id,
                    'status' => 0,
                    'gender' => "any",
                    'province' => "any",
                    'city' => "any",
                    'connected_to' => "0",
                    'user_gender' => $me->gender,
                    'user_city' => $me->city_id,
                    'user_province' => $me->province_id,
                    'cost' => $init
                ]);
            }elseif ($type == "female"){
                Connect::create([
                    'chat_id' => $chat_id,
                    'status' => 0,
                    'gender' => "female",
                    'province' => "any",
                    'city' => "any",
                    'connected_to' => "0",
                    'user_gender' => $me->gender,
                    'user_city' => $me->city_id,
                    'user_province' => $me->province_id,
                    'cost' => $init
                ]);
            }elseif ($type == "male"){
                Connect::create([
                    'chat_id' => $chat_id,
                    'status' => 0,
                    'gender' => "male",
                    'province' => "any",
                    'city' => "any",
                    'connected_to' => "0",
                    'user_gender' => $me->gender,
                    'user_city' => $me->city_id,
                    'user_province' => $me->province_id,
                    'cost' => $init
                ]);
            }elseif ($type == "location"){
                Connect::create([
                    'chat_id' => $chat_id,
                    'status' => 0,
                    'gender' => "any",
                    'province' => $me->province_id??"any",
                    'city' => $me->city_id??"any",
                    'connected_to' => "0",
                    'user_gender' => $me->gender,
                    'user_city' => $me->city_id,
                    'user_province' => $me->province_id,
                    'cost' => $init
                ]);
            }
            sendMessage([
                'chat_id' => $chat_id,
                'text' => getOption('search'),
                'reply_markup' => backButton()
            ]);
            setState($chat_id, "search");
        } else {
            sendMessage([
                'chat_id' => $chat_id,
                'text' => getOption('nocoin'),
                'reply_markup' => noCoinButton()
            ]);
        }
        doConnects();
    }

}
