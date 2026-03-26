<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    protected $fillable = [
        'name',
        'protocol',
        'description',
        'type',
        'version',
        'is_active',
        'config',
        'user_id',
    ];


    protected $casts = [
        'is_active' => 'boolean',
        'config' => 'array',
    ];



}
