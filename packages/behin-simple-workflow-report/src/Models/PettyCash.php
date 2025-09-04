<?php

namespace Behin\SimpleWorkflowReport\Models;

use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    protected $fillable = ['title', 'amount', 'paid_at', 'from_account'];

    protected $casts = [
        'paid_at' => 'date',
    ];
}

