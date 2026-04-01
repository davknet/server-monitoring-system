<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DecisionModel extends Model
{
    protected $table = 'decision';


    protected $fillable = [
        'name',
        'ip_address',
        'server_id',
        'protocol',
        'status',
        'timestamp',
    ];


    protected $casts = [
        'timestamp' => 'datetime',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
    ];


}


