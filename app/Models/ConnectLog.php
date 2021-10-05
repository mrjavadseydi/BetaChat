<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectLog extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function onBot(){
        return ($this->user_1<0||$this->user_2);
    }
}
