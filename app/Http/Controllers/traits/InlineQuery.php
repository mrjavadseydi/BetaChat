<?php

namespace App\Http\Controllers\traits;

trait InlineQuery
{
    public function initCallBack($req)
    {
        $data = $req['callback_query']['data'];
        $ex = explode('-', $data);
        switch ($ex[0]) {
            case 'profile':
                deleteMessage([
                    'chat_id' => $req['callback_query']['from']['id'],
                    'message_id' => $req['callback_query']['message']['message_id']
                ]);
                switch ($ex[1]) {
                    case "changeName":
                        $this->ProfileName($req['callback_query']['from']['id']);
                        break;
                    case "profile":
                        $this->ProfilePhoto($req['callback_query']['from']['id']);
                        break;
                    case "selectGender":
                        $this->ProfileGender($req['callback_query']['from']['id']);
                        break;
                    case "gender":
                        $this->SetProfileGender($req['callback_query']['from']['id'], $ex[2]);
                        break;
                    case "age":
                        $this->ProfileAge($req['callback_query']['from']['id']);
                        break;
                    case "place":
                        $this->ProfileProvince($req['callback_query']['from']['id']);
                        break;
                    case "setProvince":
                        $this->SetProfileProvince($req['callback_query']['from']['id'], $ex[2]);
                        break;
                    case "setCity":
                        $this->SetProfileCity($req['callback_query']['from']['id'], $ex[2]);
                        break;
                    case "location":
                        $this->Location($req['callback_query']['from']['id']);
                        break;
                }
                break;
            case "connect":
                $this->SetFilter($req['callback_query']['from']['id'], $ex[1], $req['callback_query']['message']['message_id']);
                break;
            case "initConnect":
                deleteMessage([
                    'chat_id' => $req['callback_query']['from']['id'],
                    'message_id' => $req['callback_query']['message']['message_id']
                ]);
                $this->insertConnect($req['callback_query']['from']['id']);
                break;
            case "FastConnect":
                deleteMessage([
                    'chat_id' => $req['callback_query']['from']['id'],
                    'message_id' => $req['callback_query']['message']['message_id']
                ]);
                $this->insertFastConnect($req['callback_query']['from']['id'], $ex[1]);
                break;
            case "disconnect":
                deleteMessage([
                    'chat_id' => $req['callback_query']['from']['id'],
                    'message_id' => $req['callback_query']['message']['message_id']
                ]);
                if ($ex[1] == "true") {
                    $this->DisconnectChat($req['callback_query']['from']['id']);
                }
                break;
            case "media":
                $this->sendMediaFromData($req['callback_query']['from']['id'], $ex[1]);
                break;
            case "pay":
                if($ex[1]=="49500"){
                    die();
                }
                deleteMessage([
                    'chat_id' => $req['callback_query']['from']['id'],
                    'message_id' => $req['callback_query']['message']['message_id']
                ]);
                $this->initPayment($req['callback_query']['from']['id'], $ex[1], $ex[2]);
                break;
            case "paych":
                if($ex[1]=="49500"){
                    die();
                }
                $this->initPayment($req['callback_query']['from']['id'], $ex[1], $ex[2]);
                break;
            case "RequestSendConnect":
                deleteMessage([
                    'chat_id' => $req['callback_query']['from']['id'],
                    'message_id' => $req['callback_query']['message']['message_id']
                ]);
                $this->confirmRequestToPeer($req['callback_query']['from']['id'], $ex[1]);
                break;
            case "sendConnect":
                deleteMessage([
                    'chat_id' => $req['callback_query']['from']['id'],
                    'message_id' => $req['callback_query']['message']['message_id']
                ]);
                $this->sendRequestToPeer($req['callback_query']['from']['id'], $ex[1]);
                break;
            case "customConnect":
                $this->acceptRequest($req['callback_query']['from']['id'], $ex[1], $req['callback_query']['message']['message_id']);
                break;
            case "generateLink":
                $this->inviteLinkGenerate($req['callback_query']['from']['id']);
                break;
            case "sendDirect":
                deleteMessage([
                    'chat_id' => $req['callback_query']['from']['id'],
                    'message_id' => $req['callback_query']['message']['message_id']
                ]);
                $this->initDirect($req['callback_query']['from']['id'], $ex[1]);
                break;
            case "direct":
                $this->getDirect($req['callback_query']['from']['id'], $ex[1]);
                break;
            case "activate":
                editMessageText([
                    'chat_id' => '-1001640577626',
                    'text' => $req['callback_query']['message']['text'],
                    'message_id' => $req['callback_query']['message']['message_id']
                ]);
                if ($ex[1] == "ok") {
                    $this->giveGirlCoin($ex[2]);
                }else{
                    $this->makeItBoy($ex[2]);
                }
                break;
            case "report":
                deleteMessage([
                    'chat_id' => $req['callback_query']['from']['id'],
                    'message_id' => $req['callback_query']['message']['message_id']
                ]);
                $this->reportUser($req['callback_query']['from']['id'],$ex[1]);
                break;

        }
    }
}
