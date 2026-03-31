<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestTestModel extends Model
{
    //

    protected $table = 'server_request_test';

    protected $fillable = [
        'server_id',
        'server_name',
        'server_ip',
        'response_time',
        'status',
        'message',
    ];


    protected $casts = [
        'status' => 'string',
        'response_time' => 'float',
        'message' => 'string',
    ];


 public function server()
{
    return $this->belongsTo(Server::class);
}

}
