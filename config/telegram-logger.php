<?php

return [
    // Telegram logger bot token
    'token' => "1799815865:AAE1963zra2pye2nmSkBbT8subbpkFPquDg",

    // Telegram chat id
    'chat_id' => "1389610583",

    // Blade Template to use formatting logs
    'template' => env('TELEGRAM_LOGGER_TEMPLATE', 'laravel-telegram-logging::standard')
];
