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
        if ($this->message_type == "location") {
            $location = $req['message']['location'];
            $latitude = $location['latitude'];
            $longitude = $location['longitude'];
            $response = json_decode(Http::withHeaders([
                'x-api-key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjdjMmNlNmEwYjYyMWQ2MDM1YzEyNWI3OTIyOWUwNjZhMWQ5N2M3ZWJhNTA2OGFkM2I0MDM5NjY3ODQwZjc3ODA2Y2EzN2E2NDE3N2M4YTAzIn0.eyJhdWQiOiIxNTY5NSIsImp0aSI6IjdjMmNlNmEwYjYyMWQ2MDM1YzEyNWI3OTIyOWUwNjZhMWQ5N2M3ZWJhNTA2OGFkM2I0MDM5NjY3ODQwZjc3ODA2Y2EzN2E2NDE3N2M4YTAzIiwiaWF0IjoxNjMzNDU5MDM5LCJuYmYiOjE2MzM0NTkwMzksImV4cCI6MTYzNTk2NDYzOSwic3ViIjoiIiwic2NvcGVzIjpbImJhc2ljIl19.YRI3qVti2Ck2g1NO_Y-Fmuq-cGyVu9aqdjSKBpGw0OEsViFZPtPgXnWXjqcKcDcEoD2lhPGJvcszDXtV3RYWj_HP_fI_ystbijRrf_KYfVlwkia_NBEbAqfJ6C9VVeU2bi7w4jvrvhnVnVotQSdA63MUFKftA56M8yGXCGP5JKV1ixPjHHkrORvNeVy_HZeo3JM9MjAUniBpssnAL5S1A-XvgT5Z7SnTmB2YVRIIjLtKyQg-qL9-KcIRyWqm6r54nVBOdnQ28Swc3W0ebuZM1-goxWxgcR-ELx8gaT_pBrSXRj0G4T84IK-6g1rowOuL4J5raqSkSyv58PqeTlVxFQ'
            ])->get('https://map.ir/reverse', [
                'lat' => $latitude,
                'lon' => $longitude
            ]));
            $province_id = Province::where('title', '=', $response['province'])->id;
            $city_id = City::where('title', '=', $response['county'])->id;
            if ($this->user->province_id == $province_id && $this->user->city_id == $city_id) {
                $this->user->update([
                    'latitude' => $latitude,
                    'longitude' => $longitude
                ]);
                $x1 = floor($latitude);
                $x2 = ceil($latitude);
                $y1 = floor($longitude);
                $y2 = ceil($longitude);
                return [
                    'nearby' => Member::whereBetween('latitude', [$x1, $x2])->whereBetween('longitude', [$y1, $y2])->get(),
                    'fellowCitizen' => Member::where('city_id', '=', $city_id)->get(),
                    'fellowProvincial' => Member::where('province_id', '=', $province_id)->get()
                ];
            } else {
                sendMessage([
                    'chat_id' => $this->chat_id,
                    'text' => "موقعیت مکانی ارسال شده با شهر و استان وارد شده در بخش مشخصات مطابقت ندارد، لطفا موقعیت صحیح خود را ارسال کنید و یا نسبت به اصلاح شهر و استان وارد شده اقدام نمایید"
                ]);
            }

        } else {
            sendMessage([
                'chat_id' => $this->chat_id,
                'text' => "لطفا موقعیت مکانی خود را ارسال کنید"
            ]);
        }
    }
}
