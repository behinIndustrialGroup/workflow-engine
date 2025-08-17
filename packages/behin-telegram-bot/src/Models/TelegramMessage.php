<?php

namespace Behin\TelegramBot\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramMessage extends Model
{
    protected $fillable = [
        'telegram_bot_id',
        'user_id',
        'message',
        'response',
        'responded_at'
    ];

    protected $dates = ['responded_at'];

    public function bot()
    {
        return $this->belongsTo(TelegramBot::class, 'telegram_bot_id');
    }
}
