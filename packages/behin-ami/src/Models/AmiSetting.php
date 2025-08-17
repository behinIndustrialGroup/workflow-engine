<?php

namespace Behin\Ami\Models;

use Illuminate\Database\Eloquent\Model;

class AmiSetting extends Model
{
    protected $fillable = [
        'host', 'port', 'username', 'password',
    ];
}
