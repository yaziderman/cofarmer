<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Processes extends Model
{

    protected $table = 'processes';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'field_id', 'tractor_id', 'planned_date','area', 'approved'
    ];

    public function tractor(){
        return $this->belongsTo('App\Tractors','tractor_id');
    }

    public function field(){
        return $this->belongsTo('App\Fields', 'field_id');
    }

    public function isApproved(){
        return ($this->attributes['approved'] == 1);
    }

    public function approve(){
        $this->attributes['approved'] = 1;
        return $this->save();   
    }
}
