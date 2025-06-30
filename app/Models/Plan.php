<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'tbl_plans';
    protected $fillable = ['name', 'price', 'highlight', 'meal_types', 'delivery_days', 'description', 'image', 'is_active', 'created_by', 'updated_by'];

    protected $casts = [
        'meal_types' => 'array',
        'delivery_days' => 'array',
    ];
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
