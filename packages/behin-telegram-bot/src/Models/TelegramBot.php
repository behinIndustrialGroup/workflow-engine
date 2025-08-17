<?php

namespace Behin\TelegramBot\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramBot extends Model
{
    protected $fillable = ['name', 'token'];

    public function messages()
    {
        return $this->hasMany(TelegramMessage::class);
    }
}
