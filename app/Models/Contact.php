<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'tbl_contacts'; 
    protected $fillable = [
        'position', 'name', 'phone', 'email', 'open_hours', 'address'
    ];
}
