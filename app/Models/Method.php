<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    //
    protected $table = 'methods' ;

    protected $fillable = [
        'name',
        'slug'
    ];

    protected $casts = [
        'name' => 'string',
        'slug' => 'string'
    ];

}
