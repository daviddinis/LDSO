<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
    ];


    public function cars()
    {
        return $this->hasMany('App\Car');
    }
    public function driver()
    {
        return $this->hasMany('App\Driver');
    }
    public function users()
    {
        return $this->hasMany('App\Users');
    }
}
