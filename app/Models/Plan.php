<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'tbl_plans';
    protected $fillable = ['name', 'price', 'highlight', 'duration', 'description', 'image', 'is_active', 'created_by', 'updated_by'];
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
