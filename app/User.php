<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','uuid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setUuidAttribute($value = null) 
    {
        if(!$value) {
            try {
                $this->attributes['uuid'] = Uuid::uuid4()->toString(); // i.e. 25769c6c-d34d-4bfe-ba98-e0ee856f3e7a
            } catch (UnsatisfiedDependencyException $e) {
                // Some dependency was not met. Either the method cannot be called on a
                // 32-bit system, or it can, but it relies on Moontoast\Math to be present.
                report($e);
                return false;
            }
        }
    }

    /**
    * A user has many students.
    */
    public function students()
    {
        return $this->hasMany(\App\Student::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
