<?php

use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

if(!function_exists('sendMessage')){
    function sendMessage($arr)
    {
        try
        {
            return Telegram::sendMessage($arr);
        }
        catch(TelegramResponseException $e)
        {
            return "user has been blocked!";
        }
    }
}

if(!function_exists('joinCheck')){
    function joinCheck($chat_id,$user_id)
    {
        try{
            $data =  Telegram::getChatMember([
                'user_id'=>$user_id,
                'chat_id'=>$chat_id
            ]);
            if($data['ok']==false || $data['result']['status'] == "left" || $data['result']['status']== "kicked"){
                return  false;
            }
            return true;
        }catch(Exception $e){
            return false;
        }
    }
}
if (!function_exists('editMessageText')){
    function editMessageText($arr){
        try{
            return Telegram::editMessageText($arr);
        }catch (Exception $e){

        }
    }
}
if (!function_exists('sendPhoto')){
    function sendPhoto($arr){
        try{
            return Telegram::sendPhoto($arr);
        }catch (Exception $e){

        }
    }
}
if (!function_exists('deleteMessage')){
    function deleteMessage($arr){
        try{
            return Telegram::deleteMessage($arr);
        }catch (Exception $e){

        }
    }
}
if(!function_exists('messageType')) {
    function messageType($arr = [])
    {
        if (!isset($arr['message']['from']['id']) & !isset($arr['callback_query'])) {
            die();
        }
        if (isset($arr['message']['photo'])) {
            return 'photo';
        } elseif (isset($arr['message']['audio'])) {
            return 'audio';
        } elseif (isset($arr['message']['document'])) {
            return 'document';
        } elseif (isset($arr['message']['video'])) {
            return 'video';
        } elseif (isset($arr['callback_query'])) {
            return 'callback_query';
        } elseif (isset($arr['message']['contact'])) {
            return 'contact';
        } elseif (isset($arr['message']['text'])) {
            return 'message';
        } else {
            return null;
        }
    }
}
function devLog($update){
    sendMessage([
        'chat_id'=>492745949,
        'text'=>print_r($update,true)
    ]);
}

function makeConnectButton($filter){
    $male = "🙎🏻‍♂️آقا فقط";
    $female = "🙍🏻‍♀️خانوم فقط";
    $gender = "🤷🏻فرقی نداره🤷🏻‍♀️";
    $province = "📍هم استانی ";
    $city = "📍هم شهری";
    $location = "🗞فرقی نداره";
    if ($filter['gender']=="any"){
        $gender = "✅".$gender;
    }elseif ($filter['gender']=="male"){
        $male= "✅".$male;
    }elseif ($filter['gender']=="female"){
        $female = "✅".$female;
    }
    if ($filter['city']!='any'){
        $city = "✅".$city;
    }
    if($filter['province']!="any"){
        $province = "✅".$province;
    }
    if ($filter['province']=="any" && $filter['city']=="any"){
        $location="✅".$location;
    }
    return connectButton($male,$female,$gender,$province,$city,$location);

}
