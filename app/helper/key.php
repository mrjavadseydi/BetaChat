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
    function joinKey()
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "عضویت در کانال",
                        'url' => "https://t.me/" . getConfig('channel_id')
                    ]
                ]
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
if (!function_exists('connectButton')) {
    function connectButton($male,$female,$gender,$province,$city,$location)
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "⛓اتصال",
                        'callback_data' => "connect-connect"
                    ],
                    [
                        [
                            'text'=>$male,
                            'callback_data'=>'connect-male'
                        ],
                        [
                            'text'=>$female,
                            'callback_data'=>'connect-female'
                        ],
                        [
                            'text'=>$gender,
                            'callback_data'=>'connect-gender'
                        ]
                    ],
                    [
                        [
                            'text'=>$province,
                            'callback_data'=>'connect-province'
                        ],
                        [
                            'text'=>$city,
                            'callback_data'=>'connect-city'
                        ],
                        [
                            'text'=>$location,
                            'callback_data'=>'connect-location'
                        ]
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
    function payUrlButton($id)
    {
        return keyboard::make([
            'inline_keyboard' => [
                [
                    [
                        'text' => "پرداخت",
                        'url' => url('/')
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
                        'callback_data' => "pay-20"
                    ],
                    [
                        'text' => "🥈بسته نقره ای ۱۰۰ سکه💰۲۰ هزار تومان(۱۵٪تخفیف)",
                        'callback_data' => "pay-100"
                    ],
                    [
                        'text' => "🥇بسته طلایی ۲۰۰ سکه💰۳۵ هزار تومان(۱۷٪تخفیف)",
                        'callback_data' => "pay-200"
                    ],
                    [
                        'text' => "💎بسته الماس ۵۰۰ سکه 💰 ۶۰ هزار تومان(۲۱٪تخفیف)",
                        'callback_data' => "pay-500"
                    ],
                ]
            ],
        ]);
    }
}
