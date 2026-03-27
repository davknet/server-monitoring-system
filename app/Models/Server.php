<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    //
    protected $table = 'servers' ;

    protected $fillable = [
        'name',
        'url',
        'protocol_id',
        'status_id',
        'description',
        'config',
        'user_id'
    ];


    protected $casts = [
        'config' => 'array',
    ];


  public function protocol()
    {
        return $this->belongsTo(Protocol::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }




}
