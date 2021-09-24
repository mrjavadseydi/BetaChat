<?php

use Telegram\Bot\Keyboard\Keyboard;

if (!function_exists('backButton')) {
    function backButton()
    {
        $btn = Keyboard::button([['بازگشت ↪️']]);
        return Keyboard::make(['keyboard' => $btn, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
    }
}
if (!function_exists('menuButton')) {
    function menuButton()
    {
        $btn = Keyboard::button(
            [
                ['🔱 به یه ناشناس وصلم کن'],
                ['💎پروفایل من💎', '💰سکه💰'],
                ['❔راهنما❕', '🆘پشتیبانی🆘'],
                ['⚜️قوانین⚜️'],
            ]
        );
        return Keyboard::make(['keyboard' => $btn, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
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
        return Keyboard::make(['keyboard' => $btn, 'resize_keyboard' => true, 'one_time_keyboard' => true]);
    }
}
if (!function_exists('joinKey')) {
    function joinKey($link)
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "عضویت در کانال",
                        'url' => "https://t.me/" . getOption('channel_id')
                    ]
                ],
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
                        'text' => "تغییر نام",
                        'callback_data' => "profile-changeName"
                    ],
                    [
                        'text' => "تغییر عکس پروفایل",
                        'callback_data' => "profile-profile"
                    ]
                ],
                [
                    [
                        'text' => "تغییر جنسیت",
                        'callback_data' => "profile-selectGender"
                    ],
                    [
                        'text' => "تغییر استان و شهرستان",
                        'callback_data' => "profile-place"
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
                        'text' => "⛓اتصال",
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
                        'text' => "✉️دعوت به چت",
                        'callback_data' => "RequestSendConnect-$id"
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
if (!function_exists('activateUser')) {
    function activateUser($id, $chat_id)
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "تایید",
                        'callback_data' => "activate-$id-$chat_id"
                    ],
                    [
                        'text' => "رد",
                        'callback_data' => "deactive-$id-$chat_id"
                    ],
                    [
                        'text' => "بلاک",
                        'callback_data' => "block-$id-$chat_id"
                    ],

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
                [
                    [
                        'text' => "🥉بسته برنزی ۴۰ سکه💰۱۰ هزار تومان(۱۰٪ تخفیف)",
                        'callback_data' => "pay-10000-40"
                    ]
                ],
                [
                    [
                        'text' => "🥈بسته نقره ای ۱۰۰ سکه💰۲۰ هزار تومان(۱۵٪تخفیف)",
                        'callback_data' => "pay-20000-100"
                    ]
                ],
                [
                    [
                        'text' => "🥇بسته طلایی ۲۰۰ سکه💰۳۵ هزار تومان(۱۷٪تخفیف)",
                        'callback_data' => "pay-35000-500"
                    ]
                ],
                [
                    [
                        'text' => "💎بسته الماس ۵۰۰ سکه 💰 ۶۰ هزار تومان(۲۱٪تخفیف)",
                        'callback_data' => "pay-60000-500"
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
