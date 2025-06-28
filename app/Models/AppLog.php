<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppLog extends Model
{
    protected $table = 'app_logs';
    protected $fillable = ['foreign_id', 'changed_by', 'model_type', 'action', 'old_data', 'new_data'];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];
}
