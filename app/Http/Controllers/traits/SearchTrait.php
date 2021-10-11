<?php

namespace App\Http\Controllers\traits;

use App\Models\City;
use App\Models\Member;
use App\Models\Province;
use Illuminate\Support\Facades\Http;

trait SearchTrait
{
    public function initSearch($req)
    {
        if ($this->user->city_id == null) {
            sendMessage([
                'chat_id' => $this->chat_id,
                'text' => 'استان خود را از طریق  دکمه های زیر انتخاب کنید',
                'reply_markup' => provinceButton()
            ]);
        } elseif ($this->user->latitude == NULL) {
            sendMessage([
                'chat_id' => $this->chat_id,
                'text' => getOption('sendLocation'),
                'reply_markup' => sendLocation()
            ]);
            setState($this->chat_id, 'sendLocation');
        } else {
            return $this->prepareSearch($this->user->latitude, $this->user->longitude);
        }
    }

    public function applyLocation($req)
    {
        if ($this->message_type == "location") {
            $lat = $req['message']['location']['latitude'];
            $lon = $req['message']['location']['longitude'];
            sendMessage([
                'chat_id'=>$this->chat_id,
                'text'=>"💎 ۲ سکه هدیه ارسال لوکیشن به شما تعلق گرفت"
            ]);
            $this->user->update([
                'wallet'=>$this->user->wallet +2
            ]);
            return $this->prepareSearch($lat,$lon);
        }else{
            sendMessage([
                'chat_id' => $this->chat_id,
                'text' => getOption('sendLocation'),
                'reply_markup' => sendLocation()
            ]);
        }
    }

    public function locationSearch($latitude, $longitude)
    {

        $response = json_decode(Http::withHeaders([
            'x-api-key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjdjMmNlNmEwYjYyMWQ2MDM1YzEyNWI3OTIyOWUwNjZhMWQ5N2M3ZWJhNTA2OGFkM2I0MDM5NjY3ODQwZjc3ODA2Y2EzN2E2NDE3N2M4YTAzIn0.eyJhdWQiOiIxNTY5NSIsImp0aSI6IjdjMmNlNmEwYjYyMWQ2MDM1YzEyNWI3OTIyOWUwNjZhMWQ5N2M3ZWJhNTA2OGFkM2I0MDM5NjY3ODQwZjc3ODA2Y2EzN2E2NDE3N2M4YTAzIiwiaWF0IjoxNjMzNDU5MDM5LCJuYmYiOjE2MzM0NTkwMzksImV4cCI6MTYzNTk2NDYzOSwic3ViIjoiIiwic2NvcGVzIjpbImJhc2ljIl19.YRI3qVti2Ck2g1NO_Y-Fmuq-cGyVu9aqdjSKBpGw0OEsViFZPtPgXnWXjqcKcDcEoD2lhPGJvcszDXtV3RYWj_HP_fI_ystbijRrf_KYfVlwkia_NBEbAqfJ6C9VVeU2bi7w4jvrvhnVnVotQSdA63MUFKftA56M8yGXCGP5JKV1ixPjHHkrORvNeVy_HZeo3JM9MjAUniBpssnAL5S1A-XvgT5Z7SnTmB2YVRIIjLtKyQg-qL9-KcIRyWqm6r54nVBOdnQ28Swc3W0ebuZM1-goxWxgcR-ELx8gaT_pBrSXRj0G4T84IK-6g1rowOuL4J5raqSkSyv58PqeTlVxFQ'
        ])->get('https://map.ir/reverse', [
            'lat' => $latitude,
            'lon' => $longitude
        ]),true);
        $province_id = Province::where('title', $response['province'])->first()->id;
        $city_id = City::where('title', $response['county'])->first()->id;

        $this->user->update([
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);
        $x1 = floor($latitude);
        $x2 = ceil($latitude);
        $y1 = floor($longitude);
        $y2 = ceil($longitude);

        return [
            'nearby' => Member::query()->whereBetween('latitude', [$x1, $x2])->whereBetween('longitude', [$y1, $y2])->where('chat_id','!=',$this->chat_id)->inRandomOrder()->limit(4)->get(),
            'fellowCitizen' => Member::query()->where('city_id', $city_id)->where('chat_id','!=',$this->chat_id)->inRandomOrder()->limit(4)->get(),
            'fellowProvincial' => Member::query()->where('province_id',  $province_id)->where('chat_id','!=',$this->chat_id)->inRandomOrder()->limit(4)->get()
        ];
    }

    public function prepareSearch($lat, $long)
    {
        $members = $this->locationSearch($lat, $long);
        $text = "📍کاربران نزدیک بر اساس لوکیشن \n";
        foreach ($members['nearby'] as $nearby) {
            $name = $nearby->name;
            $age = $nearby->age ?? "🔢ثبت نشده ";
            $uniq = "/user_" . $nearby->uniq;
            if($nearby->gender =="male"){
                $gender = "🙎🏻‍♂️آقا";
            }elseif($nearby->gender =="female"){
                $gender =  '🙍🏻‍♀️خانوم';
            }else{
                $gender ='🤷‍♂️ثبت نشده🤷🏻‍♀️';
            }
            $gender = $gender[$nearby->gender];
            $text .= "نام : $name \n جنسیت : $gender \n سن : $age \n آیدی ربات : $uniq \n ➰〰️➰〰️➰〰 \n️";
        }
        $text .= "📍کاربران هم استانی شما \n";
        foreach ($members['fellowProvincial'] as $nearby) {
            $name = $nearby->name;
            $age = $nearby->age ?? "🔢ثبت نشده ";
            $uniq = "/user_" . $nearby->uniq;
            if($nearby->gender =="male"){
                $gender = "🙎🏻‍♂️آقا";
            }elseif($nearby->gender =="female"){
                $gender =  '🙍🏻‍♀️خانوم';
            }else{
                $gender ='🤷‍♂️ثبت نشده🤷🏻‍♀️';
            }
            $text .= "نام : $name \n جنسیت : $gender \n سن : $age \n آیدی ربات : $uniq \n ➰〰️➰〰️➰〰 \n️";
        }
        $text .= "📍کاربران هم شهری شما \n";
        foreach ($members['fellowCitizen'] as $nearby) {
            $name = $nearby->name;
            $age = $nearby->age ?? "🔢ثبت نشده ";
            $uniq = "/user_" . $nearby->uniq;
            if($nearby->gender =="male"){
                $gender = "🙎🏻‍♂️آقا";
            }elseif($nearby->gender =="female"){
                $gender =  '🙍🏻‍♀️خانوم';
            }else{
                $gender ='🤷‍♂️ثبت نشده🤷🏻‍♀️';
            }
            $text .= "نام : $name \n جنسیت : $gender \n سن : $age \n آیدی ربات : $uniq \n ➰〰️➰〰️➰〰 \n️";
        }
        $text .= "برای پیدا کردن کاربران بیشتر میتوانید مجددا جستجو کنید !";
        $text .="\n برای تغییر لوکیشن از منو پروفایل من اقدام کنید ";

        nullState($this->chat_id);
        sendMessage([
            'chat_id' => $this->chat_id,
            'text' => $text,
            'reply_markup' => menuButton()
        ]);

    }
}
