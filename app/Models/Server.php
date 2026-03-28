<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Server extends Model
{
    //
    protected $table = 'servers' ;

    protected $fillable = [
        'name',
        'url',
        'protocol_id',
        'method',
        'ip_address',
        'port',
        'username',
        'password',
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



    public function setPasswordAttribute($value)
    {
        // This automatically encrypts whenever you save/update the password
        $this->attributes['password'] = $value
            ? Crypt::encryptString($value)
            : null;
    }


     public function getDecryptedPassword(): ?string
    {
        return $this->attributes['password']
            ? Crypt::decryptString($this->attributes['password'])
            : null;
    }


    

}
