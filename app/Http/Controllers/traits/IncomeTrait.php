<?php

namespace App\Http\Controllers\traits;

use App\Models\Invite;
use App\Models\Member;
use App\Models\PayOut;
use Illuminate\Support\Facades\Cache;

trait IncomeTrait
{
    public function incomeMenu(){
        sendMessage([
            'chat_id'=>$this->chat_id,
            'text'=>getOption('makeMoney'),
            'reply_markup'=>makeMoneyMenu()
        ]);
    }
    public function incomeWallet(){
        $text = str_replace('%money',$this->user->money,getOption('inventory'));
        sendMessage([
            'chat_id'=>$this->chat_id,
            'text'=>$text,
            'reply_markup'=>makeMoneyMenu()
        ]);
    }
    public function IncomeLinkGenerate(){
        $text = str_replace('%link',"http://t.me/BetaChatRobot?start=inc_".$this->user->uniq,getOption('incomeLink'));
        sendMessage([
            'chat_id'=>$this->chat_id,
            'text'=>$text,
            'reply_markup'=>makeMoneyMenu()
        ]);
    }
    public function incomeHelp(){
        sendMessage([
            'chat_id'=>$this->chat_id,
            'text'=>getOption('incomeHelp'),
            'reply_markup'=>makeMoneyMenu()
        ]);
    }

    public function incomeCheck(){
        sendMessage([
            'chat_id'=>$this->chat_id,
            'text'=>"در حال بررسی دعوت های شما لطفا صبرکنید ",
            'reply_markup'=>backButton()
        ]);
        setState($this->chat_id,'checkIncome');
        if ($this->user->money>=30000){
            $invites = Invite::where([['from_id',$this->chat_id],['type',2]])->get();
            $in = 0;
            $chat_ids = "";
            $hasNotJoin = false;
            foreach ($invites as $invite) {
                if(!joinCheck('@BetaChatChannel',$invite->chat_id)){
                    $chat_ids .= " $invite->chat_id ,";
                    $hasNotJoin = true;
                }else{
                    $in+=500;
                }
            }
            if($hasNotJoin){
                sendMessage([
                    'chat_id'=>$this->chat_id,
                    'text'=>" کاربران با چت ایدی $chat_ids  در کانال ما جوین نیستند  (@BetaChatChannel)
این کاربر برای شما محاسبه نخواهد شد !
                         ",
                    'reply_markup'=>backButton()
                ]);
            }
            if ($in>=30000){
                sendMessage([
                    'chat_id'=>$this->chat_id,
                    'text'=>str_replace('%income',number_format($in),getOption('successIncome')),
                    'reply_markup'=>noAction()
                ]);
                $out = PayOut::create([
                    'chat_id'=>$this->chat_id,
                    'amount'=>$in,
                ]);
                \Cache::put('payOut'.$this->chat_id,$out->id);
                Invite::where([['from_id',$this->chat_id],['type',2]])->update([
                    'type'=>3
                ]);
                sendMessage([
                    'chat_id'=>$this->chat_id,
                    'text'=>getOption('shaba'),
                    'reply_markup'=>noAction()
                ]);
                $this->user->update([
                    'money'=>0
                ]);
                setState($this->chat_id,'getoutShaba');

            }else{
                sendMessage([
                    'chat_id'=>$this->chat_id,
                    'text'=>"دعوت های شما محاسبه شد ! مجموعا : $in  تومان  و این مبلغ کمتر از حد واریز میباشد ! ",
                    'reply_markup'=>makeMoneyMenu()
                ]);
                nullState($this->chat_id);
            }
        }else{
            sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>"شما موجودی کافی ندارید !",
                'reply_markup'=>makeMoneyMenu()
            ]);
            nullState($this->chat_id);
        }
    }
    public function getShaba(){
        $id = \Cache::get('payOut'.$this->chat_id);
        PayOut::whereId($id)->update([
            'shaba'=>$this->text
        ]);
        sendMessage([
            'chat_id'=>$this->chat_id,
            'text'=>getOption('getNameIncome'),
            'reply_markup'=>noAction()
        ]);
        setState($this->chat_id,'getoutName');
    }
    public function getNameIncome(){
        $id = \Cache::get('payOut'.$this->chat_id);
        PayOut::whereId($id)->update([
            'name'=>$this->text
        ]);
        sendMessage([
            'chat_id'=>$this->chat_id,
            'text'=>getOption('getPhone'),
            'reply_markup'=>noAction()
        ]);
        setState($this->chat_id,'getoutPhone');
    }
    public function getPhone(){
        $id = \Cache::pull('payOut'.$this->chat_id);
        PayOut::whereId($id)->update([
            'phone'=>$this->text
        ]);
        $pay = PayOut::whereId($id)->first();
        sendMessage([
            'chat_id'=>$this->chat_id,
            'text'=>getOption('incomeDone'),
            'reply_markup'=>backButton()
        ]);
        $username = $this->user->username ??"none";
        sendMessage([
            'chat_id'=>"@daramad_bardasht",
            'text'=>"
name : $pay->name,
shaba : $pay->shaba,
phone : $pay->phone,
amount : $pay->amount,
chat id : $pay->chat_id
username : $username

            "
        ]);
        nullState($this->chat_id);

        $this->start();
    }
    public function InviteIncomeCheck($text)
    {
        $user = Member::where('chat_id', $this->chat_id)->first();

        if (!$user) {
            $uniq = substr($text, 11);

            if (!Cache::has($this->chat_id . $uniq)) {
                Cache::put($this->chat_id . $uniq, "1", 60);
                $in = Member::where('uniq', $uniq)->first();
                if ($in) {
                    Invite::create([
                        'chat_id'=>$this->chat_id,
                        'from_id'=>$in->chat_id,
                        'uniq'=>$text,
                        'type'=>2
                    ]);
                    $in->update([
                        'money' => $in->money + 500
                    ]);
                    sendMessage([
                        'chat_id' => $in->chat_id,
                        'text' => "💰 مبلغ ۵۰۰ تومان به حساب شما افزوده شد "
                    ]);
                }
            }
        }
    }

}
