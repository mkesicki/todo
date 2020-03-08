<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Users extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
    // use AuthenticableTrait;

    // use Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     **/
    protected $fillable = [
        "email", 
        "firstname", 
        "lastname", 
        "email", 
        "birthdate", 
        "phone", 
        "password", 
        "gender",
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    
    public function lists()
    {
        return $this->hasMany('App\Lists','user_id');
    }
}
