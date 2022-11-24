<?php

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $with = ['seksi'];

    public $timestamps = true;
    
    protected $fillable = [
        'username', 'nip_baru', 'nip_lama', 'nama', 'jabatan', 'golongan_terakhir', 'status_kendaraan', 'seksi_id', 'is_kasi_plt',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


     // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function seksi()
    {
        return $this->hasOne('App\Model\Seksi', 'id', 'seksi_id');
    }

    public function alokasiDL()
    {
        return $this->hasMany('App\Model\Tahapan_Alokasi_DL', 'nip_lama', 'nip_lama');
    }

    public function DL()
    {
        return $this->hasMany('App\Model\DL', 'nip_lama', 'nip_lama');
    }
}
