<?php

use App\Models\Member;

require_once __DIR__ . "/key.php";
require_once __DIR__ . "/telegram.php";
require_once __DIR__ . "/logs.php";

function getOption($name)
{
    if (Cache::has('option' . $name)) {
        return Cache::get('option' . $name);
    } else {
        if ($value = \App\Models\Option::where('key', $name)->first()) {
            $value = \App\Models\Option::where('key', $name)->first()->value;
            Cache::put('option' . $name, $value, 160);
            return $value;
        }
        return false;
    }
}

function setOption($name, $value)
{
    if ($conf = \App\Models\Option::where('key', $name)->first()) {
        $conf->update([
            'value' => $value
        ]);
    } else {
        \App\Models\Option::create([
            'key' => $name,
            'value' => $value
        ]);
    }
}

function setState($chat_id, $state)
{
    \App\Models\Member::where('chat_id', $chat_id)->update([
        'state' => $state
    ]);
}

function nullState($chat_id)
{
    \App\Models\Member::where('chat_id', $chat_id)->update([
        'state' => Null
    ]);
}

function getState($chat_id)
{
    return \App\Models\Member::where('chat_id', $chat_id)->first()->state;
}

function doConnects()
{
    $activeSearch = \App\Models\Connect::where('status', 0)->get();
    foreach ($activeSearch as $search) {
        $found = false;
        $search = \App\Models\Connect::whereId($search->id)->first();
        if ($search->status != 0) {
            continue;
        }
        $peer = false;
        if ($search->gender == "any" & $search->city == "any" & $search->province == "any") {
            $peer = \App\Models\Connect::where([['gender', 'any'], ['city', 'any'], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id]])->first();
            if ($peer) {
                $p1 = \App\Models\Member::where('chat_id', $search->chat_id)->first();
                $p2 = \App\Models\Member::where('chat_id', $peer->chat_id)->first();
                connectUsersConfig($p1, $p2, $search, $peer);
                $found = true;
            }
        } elseif ($search->gender == "male" & $search->city == "any" & $search->province == "any") {
            $peer = \App\Models\Connect::query()->
            Where([['gender', 'any'], ['city', 'any'], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male']])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male']])
                ->orWhere([['gender', 'any'], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male']])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male']])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male']])
                ->orWhere([['gender', $search->user_gender], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male']])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male']])
                ->first();
            if ($peer) {
                $p1 = \App\Models\Member::where('chat_id', $search->chat_id)->first();
                $p2 = \App\Models\Member::where('chat_id', $peer->chat_id)->first();
                connectUsersConfig($p1, $p2, $search, $peer);
                $found = true;
            }
        } elseif ($search->gender == "female" & $search->city == "any" & $search->province == "any") {
            $peer = \App\Models\Connect::query()->
            Where([['gender', 'any'], ['city', 'any'], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female']])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female']])
                ->orWhere([['gender', 'any'], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female']])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female']])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female']])
                ->orWhere([['gender', $search->user_gender], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female']])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female']])
                ->first();
            if ($peer) {
                $p1 = \App\Models\Member::where('chat_id', $search->chat_id)->first();
                $p2 = \App\Models\Member::where('chat_id', $peer->chat_id)->first();
                connectUsersConfig($p1, $p2, $search, $peer);
                $found = true;
            }
        } elseif ($search->gender == "female" & $search->city != "any" & $search->province == "any") {
            $peer = \App\Models\Connect::query()->
            Where([['gender', 'any'], ['city', 'any'], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_city', $search->city]])
                ->first();
            if ($peer) {
                $p1 = \App\Models\Member::where('chat_id', $search->chat_id)->first();
                $p2 = \App\Models\Member::where('chat_id', $peer->chat_id)->first();
                connectUsersConfig($p1, $p2, $search, $peer);
                $found = true;
            }
        } elseif ($search->gender == "male" & $search->city != "any" & $search->province == "any") {
            $peer = \App\Models\Connect::query()->
            Where([['gender', 'any'], ['city', 'any'], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_city', $search->city]])
                ->first();
            if ($peer) {
                $p1 = \App\Models\Member::where('chat_id', $search->chat_id)->first();
                $p2 = \App\Models\Member::where('chat_id', $peer->chat_id)->first();
                connectUsersConfig($p1, $p2, $search, $peer);
                $found = true;
            }
        } elseif ($search->gender == "female" & $search->city == "any" & $search->province != "any") {
            $peer = \App\Models\Connect::query()->
            Where([['gender', 'any'], ['city', 'any'], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_province', $search->province]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_province', $search->province]])
                ->orWhere([['gender', 'any'], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_province', $search->province]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_province', $search->province]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_province', $search->province]])
                ->orWhere([['gender', $search->user_gender], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_province', $search->province]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_province', $search->province]])
                ->first();
            if ($peer) {
                $p1 = \App\Models\Member::where('chat_id', $search->chat_id)->first();
                $p2 = \App\Models\Member::where('chat_id', $peer->chat_id)->first();
                connectUsersConfig($p1, $p2, $search, $peer);
                $found = true;
            }
        } elseif ($search->gender == "male" & $search->city == "any" & $search->province != "any") {
            $peer = \App\Models\Connect::query()->
            Where([['gender', 'any'], ['city', 'any'], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_province', $search->province]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_province', $search->province]])
                ->orWhere([['gender', 'any'], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_province', $search->province]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_province', $search->province]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_province', $search->province]])
                ->orWhere([['gender', $search->user_gender], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_province', $search->province]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_province', $search->province]])
                ->first();
            if ($peer) {
                $p1 = \App\Models\Member::where('chat_id', $search->chat_id)->first();
                $p2 = \App\Models\Member::where('chat_id', $peer->chat_id)->first();
                connectUsersConfig($p1, $p2, $search, $peer);
                $found = true;
            }
        } elseif ($search->gender == "female" & $search->city != "any" & $search->province != "any") {
            $peer = \App\Models\Connect::query()->
            Where([['gender', 'any'], ['city', 'any'], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'female'], ['user_province', $search->province], ['user_city', $search->city]])
                ->first();
            if ($peer) {
                $p1 = \App\Models\Member::where('chat_id', $search->chat_id)->first();
                $p2 = \App\Models\Member::where('chat_id', $peer->chat_id)->first();
                connectUsersConfig($p1, $p2, $search, $peer);
                $found = true;
            }
        } elseif ($search->gender == "male" & $search->city != "any" & $search->province != "any") {
            $peer = \App\Models\Connect::query()->
            Where([['gender', 'any'], ['city', 'any'], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_gender', 'male'], ['user_province', $search->province], ['user_city', $search->city]])
                ->first();
            if ($peer) {
                $p1 = \App\Models\Member::where('chat_id', $search->chat_id)->first();
                $p2 = \App\Models\Member::where('chat_id', $peer->chat_id)->first();
                connectUsersConfig($p1, $p2, $search, $peer);
                $found = true;
            }
        } elseif ($search->gender == "any" & $search->city != "any" & $search->province != "any") {
            $peer = \App\Models\Connect::query()->
            Where([['gender', 'any'], ['city', 'any'], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_province', $search->province], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_province', $search->province], ['user_city', $search->city]])
                ->first();
            if ($peer) {
                $p1 = \App\Models\Member::where('chat_id', $search->chat_id)->first();
                $p2 = \App\Models\Member::where('chat_id', $peer->chat_id)->first();
                connectUsersConfig($p1, $p2, $search, $peer);
                $found = true;
            }
        } elseif ($search->gender == "any" & $search->city == "any" & $search->province != "any") {
            $peer = \App\Models\Connect::query()->
            Where([['gender', 'any'], ['city', 'any'], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_province', $search->province]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_province', $search->province]])
                ->orWhere([['gender', 'any'], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_province', $search->province]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_province', $search->province]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_province', $search->province]])
                ->orWhere([['gender', $search->user_gender], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_province', $search->province]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_province', $search->province]])
                ->first();
            if ($peer) {
                $p1 = \App\Models\Member::where('chat_id', $search->chat_id)->first();
                $p2 = \App\Models\Member::where('chat_id', $peer->chat_id)->first();
                connectUsersConfig($p1, $p2, $search, $peer);
                $found = true;
            }
        } elseif ($search->gender == "any" & $search->city != "any" & $search->province == "any") {
            $peer = \App\Models\Connect::query()->
            Where([['gender', 'any'], ['city', 'any'], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_city', $search->city]])
                ->orWhere([['gender', 'any'], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', 'any'], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', "any"], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_city', $search->city]])
                ->orWhere([['gender', $search->user_gender], ['city', $search->user_city], ['province', $search->user_province], ['status', 0], ['chat_id', '!=', $search->chat_id], ['user_city', $search->city]])
                ->first();
            if ($peer) {
                $p1 = \App\Models\Member::where('chat_id', $search->chat_id)->first();
                $p2 = \App\Models\Member::where('chat_id', $peer->chat_id)->first();
                connectUsersConfig($p1, $p2, $search, $peer);
                $found = true;
            }
        }

        if($found==false &&$search->gender == "female"&&\App\Models\Payment::where([['chat_id',$search->chat_id],['status',1]])->count()==0&&\App\Models\Connect::where([['chat_id',$search->chat_id],['connected_to','<',0]])->count()<2){
//        if($found==false &&$search->gender == "female"&&\App\Models\Payment::where([['chat_id',$search->chat_id],['status',1]])->count()==0){

            $name = [
                'فاطمه','ftm','عسل',
                'sima',
                'نرگس',
                'سعیده',
                'fatemeh',
                'پروانه',
                'sahar',
                'رویا',
                'negin',
                'ارزو',
                'دنیا',
                'پرنسس',
                'ستایش',
                'نسترن',
                'elham banoo',
                'asma',
                'نرجس :)',
                'به تو چه؟',
                'mina khanom',
            ];
            $prof = Cache::get('prof');
            $prof[] = 'AgACAgQAAxkBAAICKWFQgg5tBlPzmZkoO4nvJkg_JvDAAAIHtzEbEiKJUh7CC4YwSrA_AQADAgADeQADIQQ';
            $prof[] = 'AgACAgQAAxkBAAICK2FQgk985xvfag_niBATx3JtfJ-2AAIItzEbEiKJUtGrsHF84FR0AQADAgADeQADIQQ';
            $prof[] = 'AgACAgQAAxkBAAICLWFQgm18llOsbkYhtnGw9A4QR5-PAAIJtzEbEiKJUjctcGcYFGYKAQADAgADeAADIQQ';
            $prof[] = 'AgACAgQAAxkBAAICL2FQgpF_IxXC7JdTvYLuvoDYVqk1AAIKtzEbEiKJUvKvykq2u5I4AQADAgADeQADIQQ';
            $prof[] = 'AgACAgQAAxkBAAICMWFQgvv4vZionCD20qrEtbDhX3IOAAILtzEbEiKJUvIv8kj_uKHMAQADAgADeAADIQQ';
            $prof[] = 'AgACAgQAAxkBAAICM2FQgxy-_R0rPhWhkkYM0S5RnIFgAAIMtzEbEiKJUsSNdeegYEmrAQADAgADeQADIQQ';
            $prof[] = 'AgACAgQAAxkBAAICNWFQg0QmHC7y1t7G9Y0IfIbO-jMhAAINtzEbEiKJUmnilGOV7aIeAQADAgADeAADIQQ';
            $p2_id =  -rand(100,999999);
            $user = Member::create([
                'chat_id' =>$p2_id,
                'name'=>$name[rand(0,count($name)-1)],
                'username'=>null,
                'profile'=>$prof[rand(0,count($prof)-1)],
                'uniq'=>makeUniq(),
                'gender'=>"female",
                'age'=>rand(20,23)
            ]);
            try{
                if($search->city != "any" ){
                    $user->update([
                        'city_id'=>$search->city
                    ]);
                }
                if($search->province != "any" ){
                    $user->update([
                        'province_id'=>$search->province
                    ]);
                }
            }catch (Exception $e){

            }


            $p1 = \App\Models\Member::where('chat_id', $search->chat_id)->first();
            connectUsersConfigRobot($p1, $user, $search);
            $found = true;

        }
    }
}

function makeUniq()
{
    $all = 'abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $list = str_split($all);
    $max = 6;
    $res = "";
    for ($i = 0; $i < $max; $i++) {
        $res .= $list[rand(0, count($list) - 1)];
    }
    return $res;
}


