<?php

namespace App;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
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

    public function fields()
    {
      return $this->hasMany('App\Fields');
    }

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    public function isAdmin()
    {
        return Auth::check() && Auth::user()->role == 'admin';
    }

    public function isOwner($object)
    {
        return Auth::check() && $object->user_id == $this->id;
    }

    public function canUpdate($object)
    {
        return $this->isAdmin() || $this->isOwner($object);   
    }

    public function hasPermission($permission)
    {
        switch ($permission) {
            case 'create-tractor':
            case 'update-tractor':
            case 'delete-tractor':
            case 'create-process':
            case 'update-process':
            case 'delete-process':
                return true;
            default:
                return false;
                break;
        }
    }
}
