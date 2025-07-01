<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'tbl_subscriptions';
    protected $fillable = [
        'user_id', 'name', 'phone', 'plan',
        'meal_types', 'delivery_days', 'allergies', 'total_price', 'status', 'pause_start', 'pause_end'
    ];

    protected $casts = [
        'meal_types' => 'array',
        'delivery_days' => 'array',
    ];
}
