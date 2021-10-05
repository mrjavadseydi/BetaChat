<?php
function getChat($id){
    return \App\Models\ChatLog::where('log_id',$id)->get();
}
function onSenario($chat_id){
    if (Cache::has($chat_id."onChatRobot")){
        return [
            'senario'=>Cache::get($chat_id."onChatRobot"),
            'step'=>Cache::get($chat_id."Senario")
        ];
    }else{
        return false;
    }
}
function getUser($chat_id){
    if(Cache::has('prof'.$chat_id)){
        return Cache::get('prof'.$chat_id);
    }else{
        $user = \App\Models\Member::where('chat_id',$chat_id)->first();
        Cache::put('prof'.$chat_id,$user,60*60);
        return $user;
    }
}
