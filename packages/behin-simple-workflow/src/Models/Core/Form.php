<?php

namespace Behin\SimpleWorkflow\Models\Core;

use Behin\SimpleWorkflow\Controllers\Core\TaskController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Form extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $incrementing = false;
    protected $keyType = 'string';
    public $table = 'wf_forms';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'name',
        'executive_file',
        'content'
    ];

}
