<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     description="Field model",
 *     type="object",
 *     title="Field model"
 * )
 */
class Fields extends Model
{
    protected $table = 'fields';
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'user_id', 'crops_type','area'
    ];

    public function processes(){
        return $this->hasMany('App\Processes');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
