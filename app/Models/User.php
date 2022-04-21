<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements MustVerifyEmail
{
    // use Authenticatable;
    //protected $table = 'admins';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'full_name',
        'email',
        'password',
        'phone',
        'prev_password',
        'address_id'
    ];

    public function addresses()
    {
    	return $this->hasMany('app\Models\Address', 'id', 'address_id');
    }
}
