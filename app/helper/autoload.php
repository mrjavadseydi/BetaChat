<?php
require_once __DIR__ ."/key.php";
require_once __DIR__ ."/telegram.php";

function getOption($name)
{
    if (Cache::has('option' . $name)) {
        return Cache::get('option' . $name);
    } else {
        if ($value = \App\Models\Option::where('key', $name)->first()) {
            $value = \App\Models\Option::where('key', $name)->first()->value;
            Cache::put('option' . $name, $value, 360);
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
function doConnects(){
    $activeSearch = \App\Models\Connect::where('status',0)->get();
    foreach ($activeSearch as $search){
        $search = \App\Models\Connect::whereId($search->id)->first();
        if($search->status!=0){
            continue;
        }
        $peer=false;
        if($search->gender=="any"&$search->city=="any"&$search->province=="any"){
            $peer = \App\Models\Connect::where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id]])->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif($search->gender=="male"&$search->city=="any"&$search->province=="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male']])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male']])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male']])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male']])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male']])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male']])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male']])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="female"&$search->city=="any"&$search->province=="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female']])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female']])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female']])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female']])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female']])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female']])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female']])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="female"&$search->city!="any"&$search->province=="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_city',$search->city]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="male"&$search->city!="any"&$search->province=="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_city',$search->city]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="female"&$search->city=="any"&$search->province!="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="male"&$search->city=="any"&$search->province!="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="female"&$search->city!="any"&$search->province!="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','female'],['user_province',$search->province],['user_city',$search->city]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="male"&$search->city!="any"&$search->province!="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_gender','male'],['user_province',$search->province],['user_city',$search->city]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="any"&$search->city!="any"&$search->province!="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province],['user_city',$search->city]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="any"&$search->city=="any"&$search->province!="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_province',$search->province]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }elseif ($search->gender=="any"&$search->city!="any"&$search->province=="any"){
            $peer = \App\Models\Connect::query()->
            Where([['gender','any'],['city','any'],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_city',$search->city]])
                ->orWhere([['gender','any'],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province','any'],['status',0],['chat_id','!=',$search->chat_id],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',"any"],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_city',$search->city]])
                ->orWhere([['gender',$search->user_gender],['city',$search->user_city],['province',$search->user_province],['status',0],['chat_id','!=',$search->chat_id],['user_city',$search->city]])
                ->first();
            if($peer){
                $p1 = \App\Models\Member::where('chat_id',$search->chat_id)->first();
                $p2 =  \App\Models\Member::where('chat_id',$peer->chat_id)->first();
                connectUsersConfig($p1,$p2,$search,$peer);
            }
        }
    }
}
