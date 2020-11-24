<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'expiration_date', 'value', 'file', 'obs', 'car_id',
    ];

    public function car() {
        return $this->belongsTo('App\Car');
    }



}
