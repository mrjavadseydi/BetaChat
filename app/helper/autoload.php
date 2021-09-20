<?php
require_once __DIR__ ."/key.php";
require_once __DIR__ ."/telegram.php";

function getOption($name)
{
    if (Cache::has('option' . $name)) {
        return Cache::get('option' . $name);
    } else {
        if ($value = \App\Models\Option::where('key', $name)->first()) {
            $value = \App\Models\Option::where('key', $name)->first()->value;
            Cache::put('option' . $name, $value, 360);
            return $value;
        }
        return false;
    }
}
function setOption($name, $value)
{
    if ($conf = \App\Models\Option::where('key', $name)->first()) {
        $conf->update([
            'value' => $value
        ]);
    } else {
        \App\Models\Option::create([
            'key' => $name,
            'value' => $value
        ]);
    }
}

function setState($chat_id, $state)
{
    \App\Models\Member::where('chat_id', $chat_id)->update([
        'state' => $state
    ]);
}

function nullState($chat_id)
{
    \App\Models\Member::where('chat_id', $chat_id)->update([
        'state' => Null
    ]);
}

function getState($chat_id)
{
    return \App\Models\Member::where('chat_id', $chat_id)->first()->state;
}
