<?php
namespace App\Http\Controllers\traits;

use App\Models\City;
use App\Models\Member;
use App\Models\Province;
use Telegram\Bot\FileUpload\InputFile;

trait ProfileTrait
{
    public function sendProfile(){
        $profile = $this->user->profile ?? InputFile::create(public_path('noprof.jpg'),'noprof.jpg');
        $gender = $this->user->gender ?? 'ثبت نشده ';
        $age = $this->user->age ?? 'ثبت نشده ';

        if($gender == "male"){
            $gender = "🙎🏻‍♂️آقا";
        }elseif($gender == "female"){
            $gender = "🙍🏻‍♀️ خانوم";
        }else{
            $gender = "ثبت نشده";
        }
        $province =  'ثبت نشده ';
        if($this->user->province_id!=null){
            $province = Province::whereId($this->user->province_id)->first()->title;
        }
        $city =  'ثبت نشده ';
        if($this->user->city_id!=null){
            $city = City::whereId($this->user->city_id)->first()->title;
        }
        $caption =
"👤پروفایل کاربر: "."/user_".$this->user->uniq."

🔘نام : ".$this->user->name."
🔘جنسیت : ".$gender."
🔘سن : ".$age."
🔘استان : ".$province. "
🔘شهر : ".$city. "
 🔘موجودی :".$this->user->wallet ." سکه ". "
";
        $up = sendPhoto([
            'chat_id'=>$this->chat_id,
            'photo'=>$profile,
            'caption'=>$caption,
            'reply_markup'=>changeProfile()
        ]);
    }
    public  function ProfileName($chat_id){
        setState($chat_id,'ProfileName');
        sendMessage([
            'chat_id'=>$chat_id,
            'text'=>'نام جدید خود را وارد کنید',
            'reply_markup'=>backButton()
        ]);
    }
    public  function SetProfileName(){
        if($this->message_type=="message"){
            nullState($this->chat_id);
            sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>'نام شما تغییر کرد',
                'reply_markup'=>menuButton()
            ]);
            Member::where('chat_id',$this->chat_id)->update([
                'name'=>$this->text
            ]);
        }else{
            sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>'متوجه نشدم لطفا نام خود را وارد کنید',
                'reply_markup'=>backButton()
            ]);
        }
    }
    public  function ProfileAge($chat_id){
        setState($chat_id,'ProfileAge');
        sendMessage([
            'chat_id'=>$chat_id,
            'text'=>'لطفا سن خود را با اعداد لاتین وارد کنید',
            'reply_markup'=>backButton()
        ]);
    }
    public  function SetProfileAge(){
        if($this->message_type=="message"&&is_numeric($this->text)){
            nullState($this->chat_id);
            sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>'سن شما تغییر کرد',
                'reply_markup'=>menuButton()
            ]);
            Member::where('chat_id',$this->chat_id)->update([
                'age'=>intval($this->text)
            ]);
        }else{
            sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>'متوجه نشدم لطفا سن خود را با اعداد لاتین وارد کنید',
                'reply_markup'=>backButton()
            ]);
        }
    }
    public  function Location($chat_id){
        setState($chat_id,'setLocation');
        sendMessage([
            'chat_id'=>$chat_id,
            'text'=>' لطفا لوکیشن خود را با استفاده از دکمه های زیر ارسال کنید',
            'reply_markup'=>sendLocation()
        ]);
    }
    public  function setLocation($req){
        if($this->message_type=="location"){
            nullState($this->chat_id);
            sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>'لوکیشن شما تغییر کرد',
                'reply_markup'=>menuButton()
            ]);
            $lat = $req['message']['location']['latitude'];
            $lon = $req['message']['location']['longitude'];
            Member::where('chat_id',$this->chat_id)->update([
                'latitude'=>$lat,
                'longitude'=>$lon
            ]);
        }else{
            sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>'متوجه نشدم لطفا لوکیشن خود را با استفاده از دکمه های زیر ارسال کنید',
                'reply_markup'=>sendLocation()
            ]);
        }
    }
    public  function ProfilePhoto($chat_id){
        setState($chat_id,'ProfilePhoto');
        sendMessage([
            'chat_id'=>$chat_id,
            'text'=>'عکس جدید را ارسال کنید',
            'reply_markup'=>backButton()
        ]);
    }
    public  function SetProfilePhoto($req){
        if($this->message_type=="photo"){
            $photo = end($req['message']['photo'])['file_id'];
            nullState($this->chat_id);

            sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>'عکس شما تغییر کرد',
                'reply_markup'=>menuButton()
            ]);
            Member::where('chat_id',$this->chat_id)->update([
                'profile'=>$photo
            ]);
        }else{
            sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>'متوجه نشدم لطفا عکس جدید را ارسال کنید',
                'reply_markup'=>backButton()
            ]);
        }
    }
    public  function ProfileGender($chat_id){
        sendMessage([
            'chat_id'=>$chat_id,
            'text'=>'لطفا جنسیت خود را با استفاده از دکمه های زیر انتخاب کنید',
            'reply_markup'=>genderSelect()
        ]);
    }
    public function SetProfileGender($chat_id,$gender){
        Member::where('chat_id',$chat_id)->update([
            'gender'=>$gender
        ]);
        if($gender=="female"){
            $this->sendToChannel($chat_id);
        }
        sendMessage([
            'chat_id'=>$chat_id,
            'text'=>'جنسیت شما با موفقیت تغییر کرد ',
            'reply_markup'=>menuButton()
        ]);
        nullState($chat_id);
    }
    public  function ProfileProvince($chat_id){
        sendMessage([
            'chat_id'=>$chat_id,
            'text'=>'استان خود را از طریق  دکمه های زیر انتخاب کنید',
            'reply_markup'=>provinceButton()
        ]);
    }
    public function SetProfileProvince($chat_id,$id){
        Member::where('chat_id',$chat_id)->update([
            'province_id'=>$id
        ]);
        sendMessage([
            'chat_id'=>$chat_id,
            'text'=>'لطفا شهر خود را انتخاب کنید ',
            'reply_markup'=>cityButton($id)
        ]);
    }
    public function SetProfileCity($chat_id,$id){
        Member::where('chat_id',$chat_id)->update([
            'city_id'=>$id
        ]);
        sendMessage([
            'chat_id'=>$chat_id,
            'text'=>'استان و شهرستان ثبت شد  ',
            'reply_markup'=>menuButton()
        ]);
        nullState($chat_id);
    }
}
