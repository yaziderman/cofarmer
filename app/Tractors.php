<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tractors extends Model
{
    protected $table = 'tractors';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function processes(){
        return $this->hasMany('App\Processes');
    }
}
