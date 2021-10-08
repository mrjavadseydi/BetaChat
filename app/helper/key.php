<?php

use Telegram\Bot\Keyboard\Keyboard;

if (!function_exists('backButton')) {
    function backButton()
    {
        $btn = Keyboard::button([['بازگشت ↪️']]);
        return Keyboard::make(['keyboard' => $btn, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
    }
}
if (!function_exists('noAction')) {
    function noAction()
    {
        $btn = Keyboard::button([['...']]);
        return Keyboard::make(['keyboard' => $btn, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
    }
}
if (!function_exists('menuButton')) {
    function menuButton()
    {
        $btn = Keyboard::button(
            [
                ['🔱 به یه ناشناس وصلم کن'],
                ['💎پروفایل من💎', "🔍جستوجو پیشرفته"],
                ['❔راهنما❕','🔥کسب درامد','💰سکه💰'],
                ['⚜️قوانین⚜️', '🆘پشتیبانی🆘'],
            ]
        );
        return Keyboard::make(['keyboard' => $btn, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
    }
}
if (!function_exists('onChatButton')) {
    function onChatButton()
    {
        $btn = Keyboard::button(
            [
                ['🔦مشاهده پروفایل🔦'],
                ['❌قطع ارتباط❌'],
            ]

        );
        return Keyboard::make(['keyboard' => $btn, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
    }
}
if (!function_exists('makeMoneyMenu')) {
    function makeMoneyMenu()
    {
        $btn = Keyboard::button(
            [
                ['💳 تسویه','💰موجودی💰'],
                ["💎دریافت لینک اختصاصی💎"],
                ["📜راهنمای کسب درامد"],
                ['بازگشت ↪️']
            ]

        );
        return Keyboard::make(['keyboard' => $btn, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
    }
}
if (!function_exists('joinKey')) {
    function joinKey($link)
    {
        return keyboard::make([
            'inline_keyboard' => [

                [
                    [
                        'text' => "عضویت در کانال ۱",
                        'url' => "https://t.me/BetaChatChannel"
                    ]
                ]
,
                [
                    [
                        'text' => "✅جوین شدم ",
                        'url' => "https://t.me/$link"
                    ]
                ],

            ],
        ]);
    }
}
if (!function_exists('mediaKey')) {
    function mediaKey($id)
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "🔐مشاهده🔐",
                        'callback_data' => "media-$id"
                    ]
                ]
            ],
        ]);
    }
}if (!function_exists('adButton')) {
    function adButton()
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "شروع چت 🙈",
                        'url' => "http://t.me/BetaChatRobot?start=inv_614c160860d5e"
                    ]
                ]
            ],
        ]);
    }
}if (!function_exists('adButton2')) {
    function adButton2()
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "چت با پسر 🤤🙎🏻‍♂️",
                        'url' => "http://t.me/BetaChatRobot?start=inv_614c160860d5e"
                    ],
                    [
                        'text' => "چت با دختر🙋‍♀️💋",
                        'url' => "http://t.me/BetaChatRobot?start=inv_614c160860d5e"
                    ]
                ],
                [
                    [
                        'text' => "چت با همسایه😋❤️",
                        'url' => "http://t.me/BetaChatRobot?start=inv_614c160860d5e"
                    ],
                ]
            ],
        ]);
    }
}
if (!function_exists('genderSelect')) {
    function genderSelect()
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "🙍🏻‍♀️ خانوم",
                        'callback_data' => "profile-gender-female"
                    ], [
                    'text' => "🙎🏻‍♂️آقا",
                    'callback_data' => "profile-gender-male"
                ],

                ]
            ],
        ]);
    }
}
if (!function_exists('changeProfile')) {
    function changeProfile()
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "♻️تغییر نام",
                        'callback_data' => "profile-changeName"
                    ],
                    [
                        'text' => "♻️تغییر عکس پروفایل",
                        'callback_data' => "profile-profile"
                    ]
                ],
                [
                    [
                        'text' => "♻️تغییر جنسیت",
                        'callback_data' => "profile-selectGender"
                    ],
                    [
                        'text' => "♻️تغییر استان و شهرستان",
                        'callback_data' => "profile-place"
                    ]
                ],
                [
                    [
                        'text' => "♻️تغییر سن",
                        'callback_data' => "profile-age"
                    ]
                ]
            ],
        ]);
    }
}
if (!function_exists('connectButton')) {
    function connectButton($male, $female, $gender, $province, $city, $location)
    {
        return keyboard::make([
            'inline_keyboard' => [

                [
                    [
                        'text' => "🔎اتصال",
                        'callback_data' => "initConnect-connect"
                    ]
                ],
                [
                    [
                        'text' => $male,
                        'callback_data' => 'connect-male'
                    ],
                    [
                        'text' => $female,
                        'callback_data' => 'connect-female'
                    ],
                    [
                        'text' => $gender,
                        'callback_data' => 'connect-gender'
                    ]
                ],
                [
                    [
                        'text' => $province,
                        'callback_data' => 'connect-province'
                    ],
                    [
                        'text' => $city,
                        'callback_data' => 'connect-city'
                    ],
                    [
                        'text' => $location,
                        'callback_data' => 'connect-location'
                    ]
                ]

            ],
        ]);
    }
}
if (!function_exists('connectButton2')) {
    function connectButton2()
    {
        return keyboard::make([
            'inline_keyboard' => [

                [
                    [
                        'text' => "⛓جستجو رندوم ",
                        'callback_data' => "FastConnect-connect"
                    ]
                ],
                [
                    [
                        'text' => "🙍🏻‍♀جستجو دختر ",
                        'callback_data' => 'FastConnect-female'
                    ],
                    [
                        'text' => "🙎🏻‍♂️ جستجو پسر",
                        'callback_data' => 'FastConnect-male'
                    ]
                ],
                [
                    [
                        'text' => "📍جستجو اطراف",
                        'callback_data' => 'FastConnect-location'
                    ],

                ]

            ],
        ]);
    }
}
if (!function_exists('disconnectButton')) {
    function disconnectButton()
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "❌قطع ارتباط❌",
                        'callback_data' => "disconnect-true"
                    ],
                    [
                        'text' => "✅ادامه",
                        'callback_data' => "disconnect-delete"
                    ]
                ]
            ],
        ]);
    }
}
if (!function_exists('sendConnectRequest')) {
    function sendConnectRequest($id)
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "✅ارسال درخواست",
                        'callback_data' => "sendConnect-$id"
                    ],
                ], [
                    [
                        'text' => "❌منصرف شدم ",
                        'callback_data' => "disconnect-false"
                    ]
                ]
            ],
        ]);
    }
}
if (!function_exists('profileConnect')) {
    function profileConnect($id)
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "❇️دعوت به چت",
                        'callback_data' => "RequestSendConnect-$id"
                    ],
                    [
                        'text' => "📩ارسال پیام دایرکت",
                        'callback_data' => "sendDirect-$id"
                    ],
                ]
            ],
        ]);
    }
}
if (!function_exists('ConnectRequest')) {
    function ConnectRequest($id)
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "✅وصلم کن",
                        'callback_data' => "customConnect-$id"
                    ],
                ], [
                    [
                        'text' => "❌تمایلی ندارم ",
                        'callback_data' => "disconnect-false"
                    ]
                ]
            ],
        ]);
    }
}
if (!function_exists('girlCoin')) {
    function girlCoin( $chat_id)
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "تایید",
                        'callback_data' => "activate-ok-$chat_id"
                    ],
                    [
                        'text' => "رد",
                        'callback_data' => "activate-nok-$chat_id"
                    ]

                ]
            ],
        ]);
    }
}
if (!function_exists('payUrlButton')) {
    function payUrlButton($url)
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "پرداخت",
                        'url' => $url
                    ]

                ]
            ],
        ]);
    }
}
if (!function_exists('coinButton')) {
    function coinButton()
    {
        return keyboard::make([
            'inline_keyboard' => [
//                [
//                    [
//                        'text' => "💥 ۱۹۹ سکه💰۴۹,۹۰۰ تومان(محدود)",
//                        'callback_data' => "pay-49900-50"
//                    ]
//                ],
//                [
//                    [
//                        'text' => "🥉 ۲۵ سکه💰۱۵ هزار تومان(۲۰٪ تخفیف)",
//                        'callback_data' => "pay-15000-25"
//                    ]
//                ],
                [
                    [
                        'text' => "🥈 ۶۰ سکه💰۳۰ هزار تومان(۲۵٪تخفیف)",
                        'callback_data' => "pay-30000-60"
                    ]
                ],
                [
                    [
                        'text' => "🥇 ۱۲۰ سکه💰۵۵ هزار تومان(۲۷٪تخفیف)",
                        'callback_data' => "pay-55000-120"
                    ]
                ],
                [
                    [
                        'text' => "💎 ۲۵۰ سکه 💰 ۱۰۰ هزار تومان(۳۱٪تخفیف)",
                        'callback_data' => "pay-100000-250"
                    ],
                ],
                [
                    [
                        'text' => "💰 دعوت از دوستان و دریافت سکه رایگان",
                        'callback_data' => "generateLink"
                    ],
                ]
            ],
        ]);
    }
}
if (!function_exists('coinButtonChannel')) {
    function coinButtonChannel()
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "💥 ۱۹۹ سکه💰۴۹,۹۰۰ تومان(محدود)",
                        'callback_data' => "paych-49900-50"
                    ]
                ],
                [
                    [
                        'text' => "🥉 ۲۵ سکه💰۱۵ هزار تومان(۲۰٪ تخفیف)",
                        'callback_data' => "paych-15000-25"
                    ]
                ],
                [
                    [
                        'text' => "🥈 ۶۰ سکه💰۳۰ هزار تومان(۲۵٪تخفیف)",
                        'callback_data' => "paych-30000-60"
                    ]
                ],
                [
                    [
                        'text' => "🥇 ۱۲۰ سکه💰۵۵ هزار تومان(۲۷٪تخفیف)",
                        'callback_data' => "paych-55000-120"
                    ]
                ],
                [
                    [
                        'text' => "💎 ۲۵۰ سکه 💰 ۱۰۰ هزار تومان(۳۱٪تخفیف)",
                        'callback_data' => "paych-100000-250"
                    ],
                ]
            ],
        ]);
    }
}
if (!function_exists('offerCoinButton')) {
    function offerCoinButton()
    {
        return keyboard::make([
            'inline_keyboard' => [

                [
                    [
                        'text' => "💥 ۹۹ سکه💰۳۹,۹۰۰ تومان",
                        'callback_data' => "pay-39900-99"
                    ]
                ]
            ],
        ]);
    }
}
if (!function_exists('acceptDirect')) {
    function acceptDirect($id)
    {
        return keyboard::make([
            'inline_keyboard' => [

                [
                    [
                        'text' => "✅ نمایش بده",
                        'callback_data' => "direct-$id"
                    ]
                ]
            ],
        ]);
    }
}
if (!function_exists('provinceButton')) {
    function provinceButton()
    {
        $provinces = \App\Models\Province::get();
        $main = [];

        for ($i = 0; $i < count($provinces); $i++) {

            $temp[] = [
                'text' => $provinces[$i]['title'],
                'callback_data' => "profile-setProvince-" . $provinces[$i]['id']
            ];
            if ($i % 3 == 0 && $i != 0) {
                $main[] = $temp;
                $temp = [];
            }
        }
        return keyboard::make([
            'inline_keyboard' =>
                $main,
        ]);
    }
}
if (!function_exists('cityButton')) {
    function cityButton($id)
    {
        $provinces = \App\Models\City::where('province_id', $id)->get();
        $main = [];
        for ($i = 0; $i < count($provinces); $i++) {

            $temp[] = [
                'text' => $provinces[$i]['title'],
                'callback_data' => "profile-setCity-" . $provinces[$i]['id']
            ];
            if ($i % 3 == 0 && $i != 0) {
                $main[] = $temp;
                $temp = [];
            }
        }
        return keyboard::make([
            'inline_keyboard' =>
                $main,
        ]);
    }
}
