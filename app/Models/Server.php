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

    public function requestTests()
    {
        return $this->hasMany(RequestTestModel::class);
    }



    public function setPasswordAttribute($value)
    {

        $value = trim($value);
         // Only encrypt if not null and not empty string
        if ($value !== null && $value !== '') {
            // Prevent double encryption: check if value is already encrypted
            try {
                Crypt::decryptString($value);
                // If decryption succeeds, assume already encrypted → use as-is
                $this->attributes['password'] = $value;
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                // Not encrypted yet → encrypt it
                $this->attributes['password'] = Crypt::encryptString($value);
            }
        } else {
            $this->attributes['password'] = null;
        }
    }


     public function getDecryptedPassword(): ?string
    {
        return $this->attributes['password']
            ? Crypt::decryptString($this->attributes['password'])
            : null;
    }




}
