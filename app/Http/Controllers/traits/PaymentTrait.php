<?php

namespace App\Http\Controllers\traits;

use App\Models\Payment;

trait PaymentTrait
{
    public function initPayment($chat_id,$amount,$coin){
        $response = zarinpal()
            ->amount($amount) // مبلغ تراکنش
            ->request()
            ->description("خرید سکه ") // توضیحات تراکنش
            ->callbackUrl("https://betaChat.javad-online.ir/payment")
            ->mobile('09123456789')
            ->send();

        if (!$response->success()) {
            devLog($response->error());
            return sendMessage([
                'chat_id'=>$chat_id,
                'text'=>$response->error()->message(),
            ]);
        }else{
            $orderId = time();
            Payment::create([
                'chat_id'=>$chat_id,
                'price'=>$amount,
                'count'=>$coin,
                'token'=>$response->authority(),
                'order_id'=>$orderId,
                'status'=>0
            ]);
            $price = number_format($amount);
            sendMessage([
                'chat_id'=>$chat_id,
                'text'=>"🔰 جهت پرداخت مبلغ  $price   روی دکمه زیر کلیک کنید ! پس از پرداخت سکه به حساب شما افزوده میشود!"."\n ".$response->url(),
                'reply_markup'=>payUrlButton($response->url())
            ]);
        }

    }
}
